<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $account_types = Category::find(1)->subCategories;
        return view('user.accounts', compact('account_types'));
    }

    public function accounts()
    {
        $accounts = Product::getAllProducts(1);
        return response()->json(['accounts' => $accounts]);
    }

    public function tools()
    {
        $tools = Product::getAllProducts(2);
        return response()->json(['tools' => $tools]);
    }

    public function tutorials()
    {
        $tutorials = Product::getAllProducts(3);
        return response()->json(['tutorials' => $tutorials]);
    }

    public function premiumRDP()
    {
        $premium_rdp = Product::getAllProducts(4);
        return response()->json(['premium_rdp' => $premium_rdp]);
    }

    public function getProductBySubCategory($id)
    {
        $products = Product::getAllProductBySubCateory($id);
        return response()->json(['products' => $products]);
    }
}
