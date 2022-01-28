<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['sub_category_name', 'image', 'category_id'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
