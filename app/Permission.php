<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Permission extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->created_by = (Auth::user())? Auth::user()->id:'1';
            $model->updated_by = (Auth::user())? Auth::user()->id:'1';
        });

        static::updating(function($model)
        {
            $model->updated_by = (Auth::user())? Auth::user()->id:'1';
        });
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_permission');
    }
}
