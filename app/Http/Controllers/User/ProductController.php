<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function productsByCategory($category_id)
    {
        $data['title'] = 'Product';
        $data['products'] = Product::with('subCategory')
                                    ->where('category_id', $category_id)
                                    ->get();

        $data['subcategories'] = SubCategory::where('category_id', $category_id)->get();
        //return $data['products'];
        return view('user.products', compact('data'));
    }

    public function productsBySubCategory($id)
    {
        $products = Product::with(['subCategory'])->where('sub_category_id', $id)->get();
        return response()->json(['data' => $products]);
    }
}
