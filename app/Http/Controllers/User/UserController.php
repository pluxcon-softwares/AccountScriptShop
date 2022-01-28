<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $title = 'User Profile';
        $user = User::find(Auth::user()->id);
        return view('user.profile')->with(['title' => $title, 'user' => $user]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:15|confirmed'
        ]);

        $user = User::find(Auth::user()->id);
        if(!Hash::check($request->old_password, $user->password))
        {
            return back()->with('error', 'Current password do not match, try again');
        }
        $user->password = $request->new_password;
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully, you can logout and login with new password');
    }
}
