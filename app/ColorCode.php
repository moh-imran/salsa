<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ColorCode extends Model
{
    protected $table = 'color_codes';
    protected $fillable = [
        'key',
        'label',
        'much_higher_when_greater_than',
        'above_when_greater_than',
        //'average_when_greater_than',
        'below_when_less_than',
        'much_below_when_less_than',
        'status',
        'created_by',
        'updated_by',
    ];
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //
}
