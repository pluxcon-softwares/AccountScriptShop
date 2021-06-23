<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'country', 'price', 'category_id', 'sub_category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public static function getAllProducts($main_category)
    {
        $data =   DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                    ->where('categories.id', '=', $main_category)
                    ->where('products.in_stock', '=', 1)
                    ->orderBy('products.id', 'DESC')
                    ->get();
        return $data;
    }

    public static function getAllProductBySubCateory($sub_category_id)
    {
        $data = DB::table('products')
                ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                ->where('sub_categories.id', '=', $sub_category_id)
                ->where('products.in_stock', '=', 1)
                ->orderBy('products.id', 'DESC')
                ->get();

        return $data;
    }

    public static function viewProductById($id)
    {
        $data = DB::table('products')
                ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                ->where('products.id', '=', $id)
                ->first();

        return $data;
    }
}
