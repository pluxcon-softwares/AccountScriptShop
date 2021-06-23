<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function allCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function subCategoryByCategoryID($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json($subCategories);
    }

    public function getProductsByCategoryID($id)
    {
        $products = Product::with(['category', 'subCategory'])->where('category_id', $id)->get();
        return response()->json(['data'=> $products]);
    }
}
