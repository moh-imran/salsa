<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;

class Triangles extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'triangles';
    protected $fillable = [
        'key',
        'status',
        'participation_warning_value',
        'merit_points_warning_value',
        'subject_id',
        'created_by',
        'updated_by'
    ];

    public function subject()
    {
        return $this->hasOne( \App\Subject::class );
    }

    public static function updateTriangles()
    {
        Triangles::updateSubjectTriangles();
        Triangles::updateSchoolTriangles();
    }

    /**
     * Update school level triangles count
     * @return mixed
     */
    public static function updateSchoolTriangles()
    {
        $triangles = "false";
        $user_id = (Auth::user())? Auth::user()->id: '1';

        try {
            $triangles = DB::select(
                DB::raw("INSERT INTO school_triangles (school_code, triangle_count, created_by, updated_by)
                        (
                          select tmp2.school_code, (
                                SUM(tmp2.triangle_count_in_primary_subs)
                                ) as triangle_count_in_primary_subs,
                                 '". $user_id ."' as created_by,
                                 '". $user_id ."' as updated_by
                            from
                            (
                            select tmp.school_code, (
                                CASE
                                   WHEN tmp.participation_diff < tmp.merit_diff then tmp.merit_diff
                                   ELSE tmp.participation_diff
                                END
                                ) as triangle_count_in_primary_subs,
                                tmp.participation_diff , tmp.merit_diff , tmp.subject_id
                              from
                              (
                                select n.id,n.school_code,n.subject_id,n.share_participated as sharep,t.participation_warning_value as participation_val,n.merit_points as n_merit_points,g.merit_points,t.merit_points_warning_value as merit_val,
                                    CASE
                                        WHEN n.share_participated < t.participation_warning_value then 1
                                        ELSE 0
                                    END as participation_diff,
                                    CASE
                                        WHEN ABS(n.merit_points - g.merit_points) > t.merit_points_warning_value then 1
                                        ELSE 0
                                    END as merit_diff
                                from `national_results_datas` n
                                JOIN `subjects` s on n.subject_id = s.id and s.is_primary = '1'
                                JOIN triangles t on n.subject_id = t.subject_id
                                join grade9_datas g on n.school_code = g.school_code and n.subject_id = g.subject_id
                                WHERE CASE
                                        WHEN n.share_participated < t.participation_warning_value then 1
                                        ELSE 0
                                    END > 0 OR
                                CASE
                                        WHEN ABS(n.merit_points - g.merit_points) > t.merit_points_warning_value then 1
                                        ELSE 0
                                END > 0
                              ) as tmp
                              group by tmp.school_code, tmp.subject_id
                              ) as tmp2
                              group by tmp2.school_code
                        )
                        ON DUPLICATE KEY UPDATE school_code = VALUES(school_code), triangle_count = VALUES(triangle_count)")
            );

        }
        catch(\Exception $e)
        {
//            return $e->getMessage();
            return response()->json(['error' => 'Unexpected error occur, please try again.']);
        }
        return $triangles;
    }

    /**
     * Update subject level triangles
     * @return mixed
     */
    public static function updateSubjectTriangles()
    {
        $triangles = 'false';
        $user_id = (Auth::user())? Auth::user()->id: '1';
        DB::beginTransaction();
        try {

            DB::select(DB::raw("TRUNCATE `subject_triangles`"));

            $triangles = DB::select(
                DB::raw("INSERT INTO subject_triangles (school_code, subject_id, show_participiation_triangle, show_deviation_triangle, grade9_data_id, created_by, updated_by)
                    (
                        select tmp.school_code, tmp.subject_id, tmp.participation_diff, tmp.merit_diff, tmp.grade_id, '". $user_id ."' as created_by, '". $user_id ."' as updated_by
                        from
                        (
                            select n.id, g.id as grade_id, n.school_code,n.subject_id,n.share_participated as sharep,
                             t.participation_warning_value as participation_val,n.merit_points as n_merit_points,g.merit_points,
                             t.merit_points_warning_value as merit_val,
                                CASE
                                    WHEN n.share_participated < t.participation_warning_value then 1
                                    ELSE 0
                                END as participation_diff,
                                CASE
                                    WHEN ABS(n.merit_points - g.merit_points) > t.merit_points_warning_value then 1
                                    ELSE 0
                                END as merit_diff
                            from `national_results_datas` n
                            JOIN `subjects` s on n.subject_id = s.id
                            JOIN triangles t on n.subject_id = t.subject_id
                            join grade9_datas g on n.school_code = g.school_code and n.subject_id = g.subject_id
                            WHERE CASE
                                    WHEN n.share_participated < t.participation_warning_value then 1
                                    ELSE 0
                                END > 0 OR
                                CASE
                                    WHEN ABS(n.merit_points - g.merit_points) > t.merit_points_warning_value then 1
                                    ELSE 0
                                END > 0
                        ) as tmp
                    )")
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            //return $e->getMessage();
            return response()->json(['error' => 'Unexpected error occur, please try again.']);
        }
        DB::commit();

        return $triangles;
    }
}
