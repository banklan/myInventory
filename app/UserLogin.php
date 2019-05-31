<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = ['user_id', 'role_id', 'last_login', 'batch_open', 'ip'];
}
