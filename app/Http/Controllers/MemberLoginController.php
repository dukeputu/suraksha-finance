<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class MemberLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


 public function login(Request $request)
{
    $request->validate([
        'member_id' => 'required',
        'password' => 'required',
    ]);

    $input = $request->member_id;

    // 🔍 Try to find user by either member_id or phone
    $member = Member::where('member_id', $input)
                    ->orWhere('phone', $input)
                    ->first();

    if ($member && Hash::check($request->password, $member->password)) {
        Session::put('member_id', $member->member_id);
        Session::put('member_name', $member->name); // optional
        return redirect('/dashboard');
    }

    return back()->with('error', 'Invalid credentials');
}

    public function logout()
    {
        Session::forget('member_id');
        return redirect('/login')->with('error', 'Logged out successfully');
    }
}
