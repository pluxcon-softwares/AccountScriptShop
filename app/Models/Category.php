<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    
    public function subCategories()
    {
        return $this->hasMany('App\Models\SubCategory');
    }
}
