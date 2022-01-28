<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'sub_category_id', 'order_by', 'name', 'description', 'price'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }
}
