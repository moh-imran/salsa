<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
class SchoolPupilTeacherStat extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //protected $table = 'school_pupil_teacher_stats';
    protected $fillable = [
        'school_code',
        'created_by',
        'updated_by',
        'students_grade1',
        'students_grade2',
        'students_grade3',
        'students_grade4',
        'students_grade5',
        'students_grade6',
        'students_grade7',
        'students_grade8',
        'students_grade9',
        'teachers_count',
        'students_per_teacher',
        'percent_teacher_pedagogical_degree'
    ];
    public function school()
    {
        return $this->belongsTo('App\School', 'school_code', 'code');
    }
}
