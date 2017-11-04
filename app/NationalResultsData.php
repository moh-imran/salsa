<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\custom\Traits\AuditLogTrait;
class NationalResultsData extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'national_results_datas';
    protected $fillable = [
        'school_code',
        'subject_id',
        'students_participated',
        'merit_points',
        'share_ae',
        'share_participated',
        'created_by',
        'updated_by'
    ];
    public function school()
    {
        return $this->belongsTo(\App\School::class, 'school_code', 'code');
    }
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    /**
     * Update Deviation Values
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public static function updateShareParticipated()
    {
        DB::select(
            DB::raw("UPDATE `national_results_datas` n
            INNER JOIN `grade9_datas` p on n.school_code = p.school_code AND n.subject_id = p.subject_id
            SET n.share_participated =  FORMAT((n.students_participated/NULLIF(p.students_enrolled, 0)) * 100, 2)")
        );

        /*DB::select(
            DB::raw("UPDATE `national_results_datas` n
                INNER JOIN `school_pupil_teacher_stats` p on n.school_code = p.school_code
                SET n.share_participated = (n.students_participated/NULLIF(p.students_grade9, 0))"));*/
    }
}
