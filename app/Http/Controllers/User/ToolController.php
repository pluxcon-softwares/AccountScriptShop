<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ToolController extends Controller
{
    public function index()
    {
        $title = 'All Tools';
        $tools = Category::find(2)->subCategories;
        return view('user.tools')->with(['title' => $title, 'tools' => $tools]);
    }

    public function getAllTools()
    {
        $tools = Product::getAllProducts(2);
        return response()->json(['tools' => $tools]);
    }

    public function getProductBySubCategory($id)
    {
        $tools = Product::getAllProductBySubCateory($id);
        return response()->json(['tools' => $tools]);
    }
}
