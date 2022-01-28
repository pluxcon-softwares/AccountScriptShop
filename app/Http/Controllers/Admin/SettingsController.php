<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function uploadSiteLogo(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'sitelogo' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ],['sitelogo.max' => 'Image site should be 2MB maximum']);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

        if($request->hasFile('sitelogo'))
        {
            $filename = $request->file('sitelogo')->getClientOriginalName();

            $current_image = Setting::where('user_id', 1)
                                        ->orWhere('user_id', Auth::guard('admin')->user()->id)
                                        ->first();

            if(Storage::exists('public/site_logo/'.$current_image->site_logo))
            {
                Storage::delete('public/site_logo/'.$current_image->site_logo);
            }

            $image = Image::make($request->file('sitelogo'));
            $image->resize(50, 50);

            $image->save(storage_path('app/public/site_logo/'.$filename));

            $setting = Setting::where('user_id', 1)
                        ->orWhere('user_id', Auth::guard('admin')->user()->id)
                        ->first();
            $setting->site_logo = $filename;
            $setting->user_id = Auth::guard('admin')->user()->id;
            $setting->save();

            return response()->json(['success' => 'Site logo uploaded successfully!']);
        }
        else{
            return response()->json(['error' => 'Choose a image to upload']);
        }
    }

    public function changeSitename(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'sitename'  => 'required'
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

        $setting = Setting::where('user_id', 1)
                            ->orWhere('user_id', Auth::guard('admin')->user()->id)
                            ->first();
        $setting->site_name = $request->sitename;
        $setting->save();
        return response()->json(['success' => 'Sitename has been updated!']);
    }

    public function changeSiteBackgroundImage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'sitebackground'    => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

        if($request->hasFile('sitebackground'))
        {
            $filename = $request->file('sitebackground')->getClientOriginalName();
            $current_image = Setting::find(1)->first();
            if(Storage::exists('public/bg_image/'.$current_image->page_background))
            {
                Storage::delete('public/bg_image/'.$current_image->page_background);
            }
            $image = Image::make($request->file('sitebackground'))->resize(1920, 1080);
            $image->save(storage_path('app/public/bg_image/'.$filename));

            $current_image->page_background = $filename;
            $current_image->save();
            return response()->json(['success' => 'Site page background updated Successfully!']);
        }
    }
}