<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['user_status'];

    public function getUserStatusAttribute($value)
    {
        if($this->status == 0){
            return 'Disabled';
        }else{
            return 'Enabled';
        }
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function sale()
    {
        return $this->hasMany('App\Sale');
    }
}
