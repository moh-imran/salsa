<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
use App\CommunitySalsaValue;
use DB;
use Auth;
use App\Triangles;

class School extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //protected $table = 'schools';
    protected $fillable = [
        'code',
        'title',
        'created_by',
        'updated_by',
        'status',
        'is_public',
        'community_code',
        'community_title',
        'lat',
        'long',
        'street_address',
        'post_number',
        'post_area'
    ];

    public function community()
    {
        return $this->belongsTo('App\Community', 'community_code', 'code');
    }

    public function grade9Data()
    {
        return $this->hasMany('App\Grade9Data', 'school_code', 'code');
    }
    public function nationalResultsData()
    {
        return $this->hasMany('App\NationalResultsData', 'school_code', 'code');
    }
    public function qualifyUpperSecData()
    {
        return $this->hasOne('App\QualifyUpperSecData', 'school_code', 'code');
    }
    public function schoolSalsaValue()
    {
        return $this->hasOne('App\SchoolSalsaValue', 'school_code', 'code');
    }
    public function schoolPupilTeacherStat()
    {
        return $this->hasOne('App\SchoolPupilTeacherStat', 'school_code', 'code');
    }
    public function schoolTriangle()
    {
        return $this->hasOne('App\SchoolTriangles', 'school_code', 'code');
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($school) { // called BEFORE delete()
            $school->grade9Data()->delete();
            $school->nationalResultsData()->delete();
            $school->qualifyUpperSecData()->delete();
            $school->schoolSalsaValue()->delete();
            $school->schoolPupilTeacherStat()->delete();
        });

    }

    /**
     * @return mixed
     */
    public static function disableMissingSchools() {
        $ids = DB::table('grade9_datas')->groupBy('school_code')->select('school_code');
        $schools = School::whereNotIn('code', $ids)->get();
        foreach($schools as $school) {
            School::disableSchoolDependencies($school->id);
        }
        //Update community salsa values against community schools
        CommunitySalsaValue::updateCommunitySalsaValues();
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
        return "true";
    }

    /**
     * @param $id
     */
    public function enableSchoolDependencies($id) {
        $school = School::withTrashed()->find($id);
        $school->grade9Data()->withTrashed()->where('school_status', 0)->update(['school_status'=> 1, 'deleted_at'=> NULL]);
        $school->nationalResultsData()->withTrashed()->where('school_status', 0)->update(['school_status'=> 1, 'deleted_at'=> NULL]);
        $school->qualifyUpperSecData()->withTrashed()->where('school_status', 0)->update(['school_status'=> 1, 'deleted_at'=> NULL]);
        $school->schoolSalsaValue()->withTrashed()->where('school_status', 0)->update(['school_status'=> 1, 'deleted_at'=> NULL]);
        $school->schoolPupilTeacherStat()->withTrashed()->where('school_status', 0)->update(['school_status'=> 1, 'deleted_at'=> NULL]);
        $school->status = 1;
        $school->deleted_at = NULL;
        $school->save();
    }

    public function activeSchool($id){
        School::enableSchoolDependencies($id);
        //Update community salsa values against community schools
        CommunitySalsaValue::updateCommunitySalsaValues();
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
    }

    /**
     * @param $id
     */
    public static function disableSchoolDependencies($id) {
        $school = School::find($id);
        $school->grade9Data()->update(['school_status'=> 0]);
        $school->nationalResultsData()->update(['school_status'=> 0]);
        $school->qualifyUpperSecData()->update(['school_status'=> 0]);
        $school->schoolSalsaValue()->update(['school_status'=> 0]);
        $school->schoolPupilTeacherStat()->update(['school_status'=> 0]);
        $school->status = 0;
        $school->save();
        $school->delete();
    }

    public function inactiveSchool($id){
        School::disableSchoolDependencies($id);
        //Update community salsa values against community schools
        CommunitySalsaValue::updateCommunitySalsaValues();
        //Calculate school level and subject level warning triangles
        Triangles::updateTriangles();
    }


    public static function updateLatLng()
    {
//        $schools =  School::withTrashed()->whereNull('lat')->whereNull('long')->whereNotNull('street_address')->get();
        $schools =  School::withTrashed()->where('warning', 1)->get();

//      stop to fire events like update
        School::flushEventListeners();
        foreach ($schools as $school){
            if(!empty($school->street_address)){
//                $address = places($school->title .' '.$school->street_address .' '.$school->post_number .' '.$school->community_title .' sweden');
//                $address = places($school->street_address .' '.$school->post_number .' '.$school->community_title .' sweden');

                $address = places($school->title .', '.$school->street_address .', '.$school->post_number .', '.$school->post_area .', '.$school->community_title .' sweden');

                //Grindstuskolan,   Mogårdsvägen 10-12,     14343,          VÅRBY,              Huddinge
                //School Name,      Postal Address,         Zip code,       Post Area,          Community Title
                //NAMN,             BESÖKSADRESS,           BESÖKSPOSTNR,   BESÖKSPOSTORT,      KOMMUNNAMN

                School::where('id', $school->id)->withTrashed()->update([
                    'lat' =>  $address['lat'],
                    'long' =>  $address['lng']
                ]);
            }
        }
    }

    /**
     * Update Deviation Values
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public static function updateSchoolsSubCommunities()
    {
        DB::select(
            DB::raw("UPDATE `schools` s
                    join
                    (select ss.community_code, c.title, ss.school_code, c.parent_code from `subcummunity_schools` ss
                    join `communities` c on ss.community_code = c.code) as t
                    on s.code = t.school_code
                    set s.community_code = t.community_code, s.community_title = t.title"
            )
        );
    }

    public static function getNearBySchool($lat, $lng){
        $distance = " (((acos(sin((".$lat."*pi()/180)) *
                    sin((`lat`*pi()/180))+cos((".$lat."*pi()/180)) *
                    cos((`lat`*pi()/180)) *
                    cos(((".$lng."- `long`)*pi()/180))))*180/pi())*60*1.1515) as distance";
        $school = DB::table('schools')
            ->select('id', 'community_code', 'community_title', DB::raw($distance))
            ->where('status', 1)
            ->whereNotNull('lat')
            ->whereNotNull('long')
            ->orderBy('distance')
            ->take(1)
            ->get()->toArray();
            if(!empty($school)) {
                return $school[0];
            }

    }

}
