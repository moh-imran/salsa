<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;
class QualifyUpperSecData extends Model
{
    use SoftDeletes;
    use AuditLogTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'qualify_upper_sec_datas';
    protected $fillable = [
        'school_code',
        'share_qualify_vocational_program',
        'share_qualify_arts_aestetichs_program',
        'share_qualify_econ_philos_socialsc_program',
        'share_qualify_natural_science_tech_program',
        'share_not_qualified',
        'created_by',
        'updated_by'
    ];
    public function school()
    {
        return $this->belongsTo(\App\School::class, 'school_code', 'code');
    }
}
