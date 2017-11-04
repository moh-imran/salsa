<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ImportErrors extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'import_errors';
    protected $fillable = [
        'table_name',
        'missing_table_name',
        'community_code',
        'community_title',
        'school_code',
        'school_title',
        'status',
        'created_by',
        'updated_by'
    ];

}
