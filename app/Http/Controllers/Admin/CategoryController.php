<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title ="Sub Categories";
        $categories = Category::all();
        return view('admin.subcategories')->with(['title' => $title, 'categories' => $categories]);
    }

    public function categories()
    {
        $categories = Category::all();
        $title = "Main Categories";
        return view('admin.categories')->with(['title' => $title, 'categories' => $categories]);
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        Category::create($request->all());

        return response()->json(['success' => 'Category has been created']);
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return response()->json(['category' => $category]);
    }

    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' =>  'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->save();

        return response()->json(['success' => 'Category updated!']);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['success' => 'Category has been deleted!']);
    }

    public function subCategories()
    {
        $sub_categories = SubCategory::all();
        return response()->json(['data' => $sub_categories]);
    }

    public function subCategoriesByID($id)
    {
        $subcategoies = SubCategory::where('category_id', $id)->get();
        return response()->json(['data' => $subcategoies]);
    }

    //===================== SUB CATEGORY FUNCTIONS SECTION ====================================

    public function addSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addCategory'   =>  'required',
            'addSubCategory' =>  'required',
            'addFile'       =>  'image|mimes:png,jpg,jpeg,gif|max:2048'
        ],['addFile.max' => 'File size cannot be more than 2MB']);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }
        $filename = null;
        if($request->hasFile('addFile'))
        {
            $filename = $request->file('addFile')->getClientOriginalName();
            $image = Image::make($request->file('addFile'))->resize(80, 80);
            $image->save(storage_path("app/public/category_images/$filename"));
        }

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->addCategory;
        $subCategory->sub_category_name = $request->addSubCategory;
        if($filename != null){ $subCategory->image = $filename; }
        $subCategory->save();

        return response()->json(['success' => 'Sub-Category created successfully!']);
    }

    public function editSubCategory($id)
    {
        $subCategory = SubCategory::find($id);
        $categories = Category::all();
        return response()->json(['subCategory' => $subCategory, 'categories' => $categories]);
    }

    public function updateSubCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'editCategory'   =>  'required',
            'editSubCategory' =>  'required',
            'editFile'  => 'image|mimes:png,jpg,jpeg,gif|max:2048'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $filename = null;

        if($request->hasFile('editFile'))
        {
            $filename = $request->file('editFile')->getClientOriginalName();
            
            $currentFilename = SubCategory::find($id);

            if(Storage::exists("public/category_images/".$currentFilename->image))
            {
                Storage::delete("public/category_images/".$currentFilename->image);
            }
            $img = Image::make($request->file('editFile'))->resize(80, 80);
            $img->save(storage_path("app/public/category_images/".$filename)); 
        }

        $subCategory = SubCategory::find($id);
        $subCategory->category_id = $request->editCategory;
        if($filename !== null) { $subCategory->image = $filename; }
        $subCategory->sub_category_name = $request->editSubCategory;
        $subCategory->save();

        return response()->json(['success' => 'Sub Category updated!']);
    }

    public function deleteSubCategory($id)
    {
        $subCategory = SubCategory::find($id);
        $subCategory->delete();
        return response()->json(['success' => 'Sub Category deleted!']);
    }
}
