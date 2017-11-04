<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Auth;
class User extends Authenticatable
{
    use SoftDeletes;
    use Billable;

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
    

    use Notifiable;

    //protected $dates = ['deleted_at'];
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'active_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function user_children(){
        return $this->hasOne('App\ChildrenInfo');
    }

    public function user_subscription()
    {
        return $this->hasMany('App\Subscription');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role');
    }
    
//    public function sendPasswordResetNotification($token)
//    {
//        $this->notify(new ResetPasswordNotification($token));
//    }
}
