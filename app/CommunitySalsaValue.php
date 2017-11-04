<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;
use App\Community;
use App\School;
use App\SchoolSalsaValue;
class CommunitySalsaValue extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function($model)
        {
            $model->updated_by = (Auth::user())? Auth::user()->id: '1';
        });
    }

    protected $dates = ['deleted_at'];

    protected $table = 'community_salsa_values';
    protected $fillable = [
        'community_code',
        'community_title',
        'ga_actual_value_avg_three_yrs',
        'ga_model_calc_value_avg_three_yrs',
        'ga_residual_value_avg_three_yrs',
        'amp_actual_value_avg_three_yrs',
        'amp_model_calc_value_avg_three_yrs',
        'amp_residual_value_avg_three_yrs',
        'public_ga_actual_value_avg_three_yrs',
        'public_ga_model_calc_value_avg_three_yrs',
        'public_ga_residual_value_avg_three_yrs',
        'public_amp_actual_value_avg_three_yrs',
        'public_amp_model_calc_value_avg_three_yrs',
        'public_amp_residual_value_avg_three_yrs',
        'created_by',
        'updated_by'
    ];

    public function community()
    {
        return $this->belongsTo(\App\Community::class, 'community_code', 'code');
    }

    /**
     * Update Deviation Values
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public static function updateCommunitySalsaValues()
    {
        DB::select(DB::raw("ALTER TABLE `community_salsa_values` DISABLE KEYS"));

        //update community salsa (private) average values
        DB::select(
            DB::raw("
                UPDATE `community_salsa_values` n
                        join (select c.code as community_code, c.title as community_title
                        , avg(NULLIF(ss.`ga_actual_value_f`,0)) as ga, avg(NULLIF(ss.`ga_model_calc_value_b`,0)) as gm,
                        avg(NULLIF(ss.`ga_residual_value_f-b`,0)) as gr, avg(NULLIF(ss.`amp_actual_value_f`,0)) as aa,
                        avg(NULLIF(ss.`amp_model_calc_value_b`,0)) as am, avg(NULLIF(ss.`amp_residual_value_f-b`,0)) as ar
                        from `school_salsa_values` ss
                        join `schools` s on ss.school_code = s.code
                        join `communities` c on s.community_code = c.code
                        where s.is_public in ('Kommunal','Landsting') AND s.status != '0'
                        group by c.code) as t
                        on n.community_code = t.community_code
                        SET n.ga_actual_value_avg_three_yrs = t.ga, n.ga_model_calc_value_avg_three_yrs = t.gm,
                        n.ga_residual_value_avg_three_yrs = t.gr, n.amp_actual_value_avg_three_yrs = t.aa,
                        n.amp_model_calc_value_avg_three_yrs = t.am, n.amp_residual_value_avg_three_yrs = t.ar;

                        "));

        //update patent community salsa (private) average values
        DB::select(
            DB::raw("UPDATE `community_salsa_values` n
                        join (select SUBSTRING(ss.community_code, 1,4) as community_code, c.title as community_title
                            , avg(NULLIF(ss.`ga_actual_value_f`,0)) as ga, avg(NULLIF(ss.`ga_model_calc_value_b`,0)) as gm,
                            avg(NULLIF(ss.`ga_residual_value_f-b`,0)) as gr, avg(NULLIF(ss.`amp_actual_value_f`,0)) as aa,
                            avg(NULLIF(ss.`amp_model_calc_value_b`,0)) as am, avg(NULLIF(ss.`amp_residual_value_f-b`,0)) as ar
                            from `school_salsa_values` ss
                            join `schools` s on ss.school_code = s.code
                            join `communities` c on s.community_code = c.code
                            where s.is_public in ('Kommunal','Landsting') AND s.status != '0'
                            AND SUBSTRING(ss.community_code, 1,4) in (
                              select c.parent_code from `communities` c where c.parent_code is not null group by c.parent_code
                            )
                            group by SUBSTRING(ss.community_code, 1,4)) as t
                        on n.community_code = t.community_code
                        SET n.ga_actual_value_avg_three_yrs = t.ga, n.ga_model_calc_value_avg_three_yrs = t.gm,
                        n.ga_residual_value_avg_three_yrs = t.gr, n.amp_actual_value_avg_three_yrs = t.aa,
                        n.amp_model_calc_value_avg_three_yrs = t.am, n.amp_residual_value_avg_three_yrs = t.ar"));

        //update community salsa (public) average values
        DB::select(
            DB::raw("UPDATE `community_salsa_values` n
                        join (select c.code as community_code, c.title as community_title
                        , avg(NULLIF(ss.`ga_actual_value_f`,0)) as ga, avg(NULLIF(ss.`ga_model_calc_value_b`,0)) as gm,
                        avg(NULLIF(ss.`ga_residual_value_f-b`,0)) as gr, avg(NULLIF(ss.`amp_actual_value_f`,0)) as aa,
                        avg(NULLIF(ss.`amp_model_calc_value_b`,0)) as am, avg(NULLIF(ss.`amp_residual_value_f-b`,0)) as ar
                        from `school_salsa_values` ss
                        join `schools` s on ss.school_code = s.code
                        join `communities` c on s.community_code = c.code
                        where s.is_public in ('Enskild') AND s.status != '0'
                        group by c.code) as t
                        on n.community_code = t.community_code
                        SET n.public_ga_actual_value_avg_three_yrs = t.ga, n.public_ga_model_calc_value_avg_three_yrs = t.gm,
                        n.public_ga_residual_value_avg_three_yrs = t.gr, n.public_amp_actual_value_avg_three_yrs = t.aa,
                        n.public_amp_model_calc_value_avg_three_yrs = t.am, n.public_amp_residual_value_avg_three_yrs = t.ar"));

        //update patent community salsa (public) average values
        DB::select(
            DB::raw("UPDATE `community_salsa_values` n
                        join (select SUBSTRING(ss.community_code, 1,4) as community_code, c.title as community_title
                            , avg(NULLIF(ss.`ga_actual_value_f`,0)) as ga, avg(NULLIF(ss.`ga_model_calc_value_b`,0)) as gm,
                            avg(NULLIF(ss.`ga_residual_value_f-b`,0)) as gr, avg(NULLIF(ss.`amp_actual_value_f`,0)) as aa,
                            avg(NULLIF(ss.`amp_model_calc_value_b`,0)) as am, avg(NULLIF(ss.`amp_residual_value_f-b`,0)) as ar
                            from `school_salsa_values` ss
                            join `schools` s on ss.school_code = s.code
                            join `communities` c on s.community_code = c.code
                            where s.is_public in ('Enskild') AND s.status != '0'
                            AND SUBSTRING(ss.community_code, 1,4) in (
                              select c.parent_code from `communities` c where c.parent_code is not null group by c.parent_code
                            )
                            group by SUBSTRING(ss.community_code, 1,4)) as t
                        on n.community_code = t.community_code
                        SET n.public_ga_actual_value_avg_three_yrs = t.ga, n.public_ga_model_calc_value_avg_three_yrs = t.gm,
                        n.public_ga_residual_value_avg_three_yrs = t.gr, n.public_amp_actual_value_avg_three_yrs = t.aa,
                        n.public_amp_model_calc_value_avg_three_yrs = t.am, n.public_amp_residual_value_avg_three_yrs = t.ar"));

        //Update min residual values to show on the home page slider
        DB::select(
            DB::raw(
                "UPDATE `community_salsa_values` c
            INNER JOIN
            (select ssv.school_code, T.community_code , T.MinVal from
                         school_salsa_values as ssv
                        INNER JOIN
                        (Select ssv.community_code, Min(ssv.`amp_residual_value_f-b`) as MinVal
                        from school_salsa_values ssv
                        inner join schools s on ssv.school_code = s.code
                        where  ssv.school_status != '0'
                        Group by ssv.community_code
                        order by ssv.community_code
                        ) As T
                        on ssv.community_code = T.community_code
                        AND ssv.`amp_residual_value_f-b` = T.MinVal
                        AND  ssv.school_status != '0'
                        order by T.community_code) as T2
            on c.community_code = T2.community_code
            SET c.min_school_code = T2.school_code, c.min_amp_residual_value = T2.MinVal"
            )
        );

        //Update min/max schools residual values to show on the home page slider for parent communities
        DB::select(
            DB::raw(
                "UPDATE `community_salsa_values` c
            INNER JOIN
            (select ssv.school_code, T.community_code , T.MinVal from
                         school_salsa_values as ssv
                        INNER JOIN
                        (Select SUBSTRING(ssv.community_code, 1,4) as community_code, Min(ssv.`amp_residual_value_f-b`) as MinVal
                            from school_salsa_values ssv
                            inner join schools s on ssv.school_code = s.code
                            where  ssv.school_status != '0'
                             AND SUBSTRING(ssv.community_code, 1,4) in (
                              select c.parent_code from `communities` c where c.parent_code is not null group by c.parent_code
                            )
                             group by SUBSTRING(ssv.community_code, 1,4)
                            order by SUBSTRING(ssv.community_code, 1,4)
                        ) As T
                        on SUBSTRING(ssv.community_code, 1,4) = T.community_code
                        AND ssv.`amp_residual_value_f-b` = T.MinVal
                        AND  ssv.school_status != '0'
                        order by T.community_code) as T2
            on c.community_code = T2.community_code
            SET c.min_school_code = T2.school_code, c.min_amp_residual_value = T2.MinVal"
            )
        );

        //Update max schools residual values to show on the home page slider
        DB::select(
            DB::raw(
                "UPDATE `community_salsa_values` c
            INNER JOIN
            (
                SELECT ssv.school_code, T.community_code , T.MaxVal
                FROM school_salsa_values as ssv
                INNER JOIN
                (Select ssv.community_code, Max(ssv.`amp_residual_value_f-b`) as MaxVal
                from school_salsa_values ssv
                inner join schools s on ssv.school_code = s.code
                where  ssv.school_status != '0'
                Group by ssv.community_code
                order by ssv.community_code
                ) As T
                Where
                 ssv.community_code = T.community_code
                        AND  ssv.school_status != '0'
                AND ssv.`amp_residual_value_f-b` = T.MaxVal
                order by T.community_code) as T2
            on c.community_code = T2.community_code
            SET c.max_school_code = T2.school_code, c.max_amp_residual_value = T2.MaxVal"
            )
        );

        //Update max schools residual values to show on the home page slider for parent communities
        DB::select(
            DB::raw(
                "UPDATE `community_salsa_values` c
            INNER JOIN
            (
                SELECT ssv.school_code, T.community_code , T.MaxVal
                FROM school_salsa_values as ssv
                INNER JOIN
                (
                    Select SUBSTRING(ssv.community_code, 1,4) as community_code, Max(ssv.`amp_residual_value_f-b`) as MaxVal
                    from school_salsa_values ssv
                    inner join schools s on ssv.school_code = s.code
                    where  ssv.school_status != '0'
                     AND SUBSTRING(ssv.community_code, 1,4) in (
                        select c.parent_code from `communities` c where c.parent_code is not null group by c.parent_code
                     )
                    Group by SUBSTRING(ssv.community_code, 1,4)
                    order by SUBSTRING(ssv.community_code, 1,4)
                ) As T
                Where
                 SUBSTRING(ssv.community_code, 1,4) = T.community_code
                        AND  ssv.school_status != '0'
                AND ssv.`amp_residual_value_f-b` = T.MaxVal
                order by T.community_code
            ) as T2
            on c.community_code = T2.community_code
            SET c.max_school_code = T2.school_code, c.max_amp_residual_value = T2.MaxVal"
            )
        );

        //update community salsa (private) average values
        DB::select(DB::raw("ALTER TABLE `community_salsa_values` ENABLE KEYS"));

    }



}