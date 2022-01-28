<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "All User Account";
        return view('admin.user-accounts', compact('title'));
    }

    public function getUserAccounts()
    {
        $userAccounts = User::all();
        return response()->json(['user-accounts' => $userAccounts]);
    }

    public function createUserAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:15'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        User::create($request->all());

        return response()->json(['success' => 'User Account Created!']);
    }

    public function editUserAccount($user_id)
    {
        $userAccount = User::find($user_id);
        return response()->json(['userAccount' => $userAccount]);
    }

    public function updateUserAccount(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,'.$user_id,
            'email'     => 'required|email|unique:users,email,'.$user_id
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::find($user_id);
        if($request->password !== null){
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->wallet = $request->wallet;
            $user->active = $request->active;
        }
        else{
            $user->email = $request->email;
            $user->username = $request->username;
            $user->wallet = $request->wallet;
            $user->active = $request->active;
        }
        $user->save();
        return response()->json(['success' => 'User account updated!']);
    }

    public function deleteUserAccount($user_id){
        $admin = User::find($user_id);
        $admin->delete();
        return response()->json(['success' => "User Account Deleted!"]);
    }
}
