<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $tool_types = Category::find(2)->subCategories;
        $title = "All Tools";
        return view('admin.tools')->with(['tool_types'=>$tool_types, 'title'=>$title]);
    }

    public function products()
    {
        $products = DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                    ->where('categories.id', '=', 2)
                    ->orderBy('products.id', 'DESC')
                    ->get();
        return response()->json(['products' => $products]);
    }

    public function getProductBySubCategory($id)
    {
        $products = DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                    ->where('sub_categories.id', '=', $id)
                    ->orderBy('products.id', 'DESC')
                    ->get();
        return response()->json(['products' => $products]);
    }

    public function viewProduct($id)
    {
        $product = DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS product_type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->where('products.id', '=', $id)
                    ->first();
        return response()->json(['product' => $product]);
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        Product::create($request->all());
        return response()->json(['success' => 'Product Added Successfully!']);
    }

    public function editProduct($id)
    {
        $sub_categoires = SubCategory::where('category_id', 2)->get();
        $product = Product::where('id', $id)->first();
        return response()->json(['subCategories' => $sub_categoires, 'product'=>$product]);
    }

    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'description' => 'required',
            'price'     =>  'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->sub_category_id = $request->sub_category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->in_stock = $request->in_stock;
        $product->country = $request->country;
        $product->save();

        return response()->json(['success' => "Product updated successfully!"]);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['success' => "Product deleted successfully!"]);
    }
}
