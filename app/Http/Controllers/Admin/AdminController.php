<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "All Admin Account";
        return view('admin.admin-accounts', compact('title'));
    }

    public function getAdminAccounts()
    {
        $adminAccounts = Admin::where('access', 2)->get();
        return response()->json(['admin_accounts' => $adminAccounts]);
    }

    public function createAdminAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|max:15'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        Admin::create($request->all());

        return response()->json(['success' => 'Admin Account Created!']);
    }

    public function editAdminAccount($admin_id)
    {
        $adminAccount = Admin::find($admin_id);
        return response()->json(['admin_account' => $adminAccount]);
    }

    public function updateAdminAccount(Request $request, $admin_id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admins,username,'.$admin_id,
            'email'     => 'required|email|unique:admins,email,'.$admin_id
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = Admin::find($admin_id);
        if($request->password !== null)
        {
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $request->password;
        }
        else{
            $user->email = $request->email;
            $user->username = $request->username;
        }

        $user->save();
        return response()->json(['success' => 'Admin account updated!']);
    }

    public function deleteAdminAccount($admin_id){
        $admin = Admin::find($admin_id);
        $admin->delete();
        return response()->json(['success' => "Admin Account Deleted!"]);
    }
}
