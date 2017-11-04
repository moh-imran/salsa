<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
use DB;
use Auth;

class SchoolSalsaValue extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'school_salsa_values';
    protected $fillable = [
        'school_code',
        'bg_parents_avg_level_of_education',
        'bg_share_of_newly_immigrated',
        'bg_share_of_born_abroad',
        'bg_share_of_foreign_background',
        'bg_share_of_boys',
        'ga_actual_value_f',
        'ga_model_calc_value_b',
        'ga_residual_value_f-b',
        'amp_actual_value_f',
        'amp_model_calc_value_b',
        'amp_residual_value_f-b',
        'avg_deviation_value_in_primary_sub',
        'community_code',
        'created_by',
        'updated_by'
    ];


    public function school()
    {
        return $this->belongsTo(\App\School::class, 'school_code', 'code');
    }

    /**
     * Update Deviation Values
     * Update school vise primary subject average deviation values in school salsa values table
     */
    public static function updateSalsaSchoolsSubCommunities()
    {
        DB::select(DB::raw("ALTER TABLE `school_salsa_values` DISABLE KEYS"));

        DB::select(
            DB::raw("UPDATE `school_salsa_values` s
                    join
                    (select ss.community_code, c.title, ss.school_code, c.parent_code from `subcummunity_schools` ss
                    join `communities` c on ss.community_code = c.code) as t
                    on s.school_code = t.school_code
                    set s.community_code = t.community_code"
            )
        );

        DB::select(DB::raw("ALTER TABLE `school_salsa_values` ENABLE KEYS"));
    }
}
