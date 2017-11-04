<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
class Grade9Data extends Model
{
    use SoftDeletes;
    use AuditLogTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'grade9_datas';
    protected $fillable = [
        'school_code',
        'subject_id',
        'students_enrolled',
        'merit_points',
        'share_ae',
        'deviation_value',
        'created_by',
        'updated_by'
    ];

    public function school()
    {
        return $this->belongsTo(\App\School::class, 'school_code', 'code');
    }
    public function subject()
    {
        return $this->belongsTo(\App\Subject::class, 'subject_id');
    }
    /**
     * Get the triangle for the school's subject.
     */
    public function subject_triangle()
    {
        return $this->hasOne('App\SubjectTriangles', 'grade9_data_id', 'id');
    }
    
    public  function show_deviation_triangle()
    {
        return $this->hasOne('App\SubjectTriangles', 'grade9_data_id', 'id');
    }
    
    public function show_participiation_triangle()
    {
        return $this->hasOne('App\SubjectTriangles', 'grade9_data_id', 'id');
    }

    /**
     * Update Deviation Values
     * Update subject vise deviation values in grade9 data table and
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public function updateDeviationValues()
    {
        $this->updateGrade9DeviationValues();
        $this->updateSalsaDeviationValues();
    }

    /**
     * Update Deviation Values
     * Update subject vise deviation values in grade9 data table and
     */
    public static function updateGrade9DeviationValues()
    {
        DB::select(
            DB::raw("UPDATE grade9_datas g
                join `national_results_datas` n on g.school_code = n.school_code and g.subject_id = n.subject_id
                join `subjects` s on g.subject_id = s.id and s.use_for_deviation = '1'
				SET g.deviation_value = (NULLIF(g.merit_points,0)) - (NULLIF(n.merit_points,0))"));
    }

    /**
     * Update Deviation Values
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public static function updateSalsaDeviationValues()
    {
        DB::select(
            DB::raw("UPDATE school_salsa_values ss
                join (select avg(NULLIF(g.deviation_value,0)) as deviation, g.school_code
                from `grade9_datas` g
                join `subjects` s on g.subject_id = s.id
                where s.is_primary = '1' AND g.school_status != '0'
                group by g.school_code) as t
                on ss.school_code = t.school_code
                SET ss.avg_deviation_value_in_primary_sub = t.deviation"));
    }
}
