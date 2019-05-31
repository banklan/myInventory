<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyBatch extends Model
{
    protected $fillable = ['user_id', 'role_id', 'batch', 'open'];
}
