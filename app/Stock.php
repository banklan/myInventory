<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'size', 'pks_received', 'units_perpack', 'colour', 'price_perunit', 'total_units', 'total_cost', 'sn',
        'mfg', 'exp'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
