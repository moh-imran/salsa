<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
use DB;
class Community extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //protected $table = 'communities';
    protected $fillable = [
        'code',
        'title',
        'parent_code',
        'lat',
        'long',
        'created_by',
        'updated_by',
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($community) { // called BEFORE delete()
            $community->schools()->delete();
        });
    }

    public function schools(){
        return $this->hasMany('App\School', 'community_code', 'code');
    }

    public static function warning(){
        $communities =  Community::all();
//      stop to fire events like update
        School::flushEventListeners();
        $schools = '';
        foreach ($communities as $community) {
            $lat = School::where('community_code', $community->code)->avg('lat');
            $lng = School::where('community_code', $community->code)->avg('long');
            if ($lat != '' && $lng != '') {
                $distance = " (((acos(sin((" . $lat . "*pi()/180)) *
                    sin((`lat`*pi()/180))+cos((" . $lat . "*pi()/180)) *
                    cos((`lat`*pi()/180)) *
                    cos(((" . $lng . "- `long`)*pi()/180))))*180/pi())*60*1.1515) as distance";

                School::where('community_code', $community->code)
                    ->whereNotExists(function ($q) use ($community, $lat, $lng) {
                        $q->where('lat', '<=', ($lat + 2))
                            ->where('lat', '>=', ($lat - 2))
                            ->where('long', '<=', ($lng + 2))
                            ->where('long', '>=', ($lng - 2));
                    })->withTrashed()
                    ->update(['warning' => 1]);

                $schools[] = School::select('*', DB::raw($distance))
                    ->where('community_code', $community->code)
                    ->whereNotExists(function ($q) use ($community, $lat, $lng) {
                        $q->where('lat', '<=', ($lat + 2))
                            ->where('lat', '>=', ($lat - 2))
                            ->where('long', '<=', ($lng + 2))
                            ->where('long', '>=', ($lng - 2));
                    })
                    ->get();
            }
        }
        return $schools;
    }

    public static function updateCommunityLatLng()
    {
        $communities =  Community::whereNull('lat')->whereNull('long')->whereNotNull('title')->get();
//      stop to fire events like update
        Community::flushEventListeners();
        foreach ($communities as $community){
            if(!empty($community->title)){
                $address = places($community->title);
                Community::find($community->id)->update([
                    'lat' => $address['lat'],
                    'long' => $address['lng']
                ]);
            }
        }
    }

    public static function getNearByCommunity($lat, $lng, $offset= 0){
        $distance = " (((acos(sin((".$lat."*pi()/180)) *
                    sin((`lat`*pi()/180))+cos((".$lat."*pi()/180)) *
                    cos((`lat`*pi()/180)) *
                    cos(((".$lng."- `long`)*pi()/180))))*180/pi())*60*1.1515) as distance";
        $community = Community::select('id', 'code', 'title', DB::raw($distance))
            ->whereNotNull('lat')
            ->whereNotNull('long')
            ->orderBy('distance')
            ->offset($offset)
            ->take(1)
            ->get()->toArray();
        if(!empty($community)) {
            return $community[0];
        }

    }
}
