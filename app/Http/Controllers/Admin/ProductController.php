<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data['categories'] = Category::all();
        $data['title'] = 'Products';
        return view('admin.products', compact('data'));
    }

    public function allProducts()
    {
        $products = Product::with(['category', 'subCategory'])->get();
        return response()->json(['data' => $products]);
    }

    public function storeProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'addCategory'       =>  'required|numeric',
            'addSubCategory'    =>  'required|numeric',
            'addName'           =>  'required',
            'addPrice'          =>  'required|numeric',
            'addCountry'        =>  'nullable',
            'addDescription'    =>  'required'
        ], [
            'addPrice.required' =>  'Product price cannot be empty',
            'addPrice.numeric'  =>  'Product price format is invalid, enter ex:(5, 5.00)',
            'addCategory.numeric'       =>  'Main category cannot be empty',
            'addSubCategory.numeric'       =>  'Main category cannot be empty',  
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

        $product = new Product;
        $product->name = $request->addName;
        $product->price = $request->addPrice;
        $product->country = $request->addCountry;
        $product->description = $request->addDescription;
        $product->category_id = $request->addCategory;
        $product->sub_category_id = $request->addSubCategory;
        $product->save();

        return response()->json(['success' => 'New product has been added successfully!']);
    }

    public function editUpdateProduct(Request $request, $id = null)
    {
        if($request->isMethod('post'))
        {
            $validate = Validator::make($request->all(), [
                'editCategory'       =>  'required|numeric',
                'editSubCategory'    =>  'required|numeric',
                'editName'           =>  'required',
                'editPrice'          =>  'required|numeric',
                'editCountry'        =>  'nullable',
                'editDescription'    =>  'required'
            ], [
                'editPrice.required' =>  'Product price cannot be empty',
                'editPrice.numeric'  =>  'Product price format is invalid, enter ex:(5, 5.00)',
                'editCategory.numeric'       =>  'Main category cannot be empty',
                'editSubCategory.numeric'       =>  'Main category cannot be empty',  
            ]);
    
            if($validate->fails())
            {
                return response()->json(['errors' => $validate->errors()]);
            }
    
            $product = Product::find($request->product_id);
            $product->name = $request->editName;
            $product->price = $request->editPrice;
            $product->country = $request->editCountry;
            $product->description = $request->editDescription;
            $product->category_id = $request->editCategory;
            $product->sub_category_id = $request->editSubCategory;
            $product->save();
    
            return response()->json(['success' => 'New product has been added successfully!']);
        }

        if($request->isMethod('get'))
        {
            $product = Product::find($id);
            return response()->json($product);
        }
    }

    public function deleteProduct(Request $request)
    {
        $id = (int) $request->product_id;
        Product::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully!']);
    }

    public function viewProduct($id)
    {
        $product = Product::with(['category', 'subCategory'])->where('id', $id)->first();
        return response()->json($product);
    }

    /*public function fetchProductBySubCategory($id)
    {
        $products = DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->where('sub_categories.id', '=', $id)
                    ->get();

        return response()->json(['products' => $products]);
    }

    public function viewProduct($id)
    {
        $product = DB::table('products')
                    ->select('products.*', 'sub_categories.sub_category_name AS type')
                    ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                    ->where('products.id', '=', $id)
                    ->first();
        return response()->json(['product' => $product]);
    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_category_id'   =>  'required',
            'name'  =>  'required',
            'description'   =>  'required',
            'price' =>  'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $product = new Product();
        $product->sub_category_id = $request->sub_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->in_stock = $request->in_stock;
        $product->country = $request->country;
        $product->save();

        return response()->json(['success'  =>  'Product created successfully!']);
    }

    public function editProduct($product_id)
    {
        $product = Product::find($product_id);
        return response()->json(['product' => $product]);
    }

    public function updateProduct(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'sub_category_id'   =>  'required',
            'name'  =>  'required',
            'description'   =>  'required',
            'price' =>  'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $product = Product::find($product_id);
        $product->sub_category_id = $request->sub_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->in_stock = $request->in_stock;
        $product->country = $request->country;
        $product->save();

        return response()->json(['success'  =>  'Product updated successfully!']);
    }

    public function deleteProduct($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();
        return response()->json(['success' => 'Product deleted succesufully!']);
    }*/
}
