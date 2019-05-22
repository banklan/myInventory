<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'role_id', 'status'
    ];

    protected $guard = 'admin';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['role', 'admin_status'];

    

    public function getNameAttribute($value)
    {
        $this->attributes['full_name'] = ucfirst($value);
    }

    public function getRoleAttribute($value)
    {
        return 'Admin';
    }

    public function getAdminStatusAttribute($value)
    {
        if($this->status == 0){
            return "Disabled";
        }else{
            return "Enabled";
        }
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
