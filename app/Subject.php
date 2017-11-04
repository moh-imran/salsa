<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Subject extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->created_by = (Auth::user())? Auth::user()->id: '1';
            $model->updated_by = (Auth::user())? Auth::user()->id: '1';
        });

        static::updating(function($model)
        {
            $model->updated_by = (Auth::user())? Auth::user()->id: '1';
        });
    }
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'subjects';
    protected $fillable = [
        'title',
        'status',
        'use_for_deviation',
        'is_primary',
        'created_by',
        'updated_by'
    ];
    public function grade9Data()
    {
        return $this->hasOne('App\Grade9Data');
    }
    public function nationalResultsData()
    {
        return $this->hasOne('App\NationalResultsData');
    }
}
