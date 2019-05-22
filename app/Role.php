<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'role_id'
    ];

    // protected $appends = ['role_name'];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function supervisors()
    {
        return $this->hasMany('App\Supervisor');
    }

    public function admins()
    {
        return $this->hasMany('App\Admin');
    }

    public function getRoleNameAttribute($value)
    {
        $name = $this->attributes['role_name'] = ucfirst($value);
        return $name;
    }
}
