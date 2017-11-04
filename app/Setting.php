<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Setting extends Model
{

    protected $table = 'settings';
    //status 1 means active and 0 means in active
    protected $fillable = [
        'title',
        'group',
        'key',
        'key_options',
        'value',
        'status',
        'created_by',
        'updated_by'
    ];

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function activeSetting($id){
        $setting = $this->withTrashed()->find($id);
        $setting->status = 1;
        $setting->deleted_at = NULL;
        $setting->save();
    }

    public function inactiveSetting($id){
        $setting = $this->withTrashed()->find($id);
        $setting->status = 0;
        $setting->save();
        //soft delete
        $setting->delete();
    }
}
