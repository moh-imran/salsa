<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\custom\Traits\AuditLogTrait;

class SubjectTriangles extends Model
{
    use SoftDeletes;
    use AuditLogTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'subject_triangles';
    protected $fillable = [
        'school_code',
        'subject_id',
        'show_triangle',
        'created_by',
        'updated_by'
    ];

}
