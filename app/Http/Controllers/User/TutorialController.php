<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class TutorialController extends Controller
{
    public function index()
    {
        $title = 'All Tutorials';
        $tutorials = Category::find(3)->subCategories;
        return view('user.tutorials')->with(['title' => $title, 'tutorials' => $tutorials]);
    }

    public function getAllTutorials()
    {
        $tutorials = Product::getAllProducts(3);
        return response()->json(['tutorials' => $tutorials]);
    }

    public function getProductBySubCategory($id)
    {
        $tutorials = Product::getAllProductBySubCateory($id);
        return response()->json(['tutorials' => $tutorials]);
    }
}
