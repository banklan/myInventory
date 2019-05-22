<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name'];

    protected $with = ['category', 'stocks'];
    protected $appends = ['cos_price', 'sellin_price'];
    

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setCostPriceAttribute($value)
    {
        $this->attributes['cost_price'] = $value * 100;
    }

    public function setSellingPriceAttribute($value)
    {
        $this->attributes['selling_price'] = $value * 100;
    }

    public function getCosPriceAttribute($value)
    {
        $cost = number_format($this->cost_price/100, 2, '.', ',');
        return $cost;
    }

    public function getSellinPriceAttribute($value)
    {
        $price = number_format($this->selling_price/100, 2, '.', ',');
        return $price;
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
}
