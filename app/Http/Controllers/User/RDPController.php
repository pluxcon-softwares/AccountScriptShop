<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class RDPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'All RDPs';
        $rdps = Category::find(4)->subCategories;
        return view('user.rdp')->with(['title' => $title, 'rdps' => $rdps]);
    }

    public function getAllRDPs()
    {
        $rdps = Product::getAllProducts(4);
        return response()->json(['rdps' => $rdps]);
    }

    public function getProductBySubCategory($id)
    {
        $rdps = Product::getAllProductBySubCateory($id);
        return response()->json(['rdps' => $rdps]);
    }
}
