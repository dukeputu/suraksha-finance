<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;




class UserAppLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('userApp.userAppView.userLogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('app_users')
            ->where('phone_number', $request->phone_number)
            ->first();

            // dd((array) $user); // ✅ Put it right here

        if ($user && Hash::check($request->password, $user->password)) {
            Session::put('app_user_id', $user->id);
            Session::put('app_user_name', $user->app_u_name ?? '');
            Session::put('app_user_phone', $user->phone_number ?? '');
            Session::put('app_user_email', $user->user_email ?? '');
            Session::put('app_user_photo', $user->user_pic_img ?? '');
            Session::put('app_user_wallet', $user->user_wallet ?? '0.00');
            Session::put('app_user_plan_id', $user->select_plan_id ?? '');
            Session::put('app_user_plan_name', $user->select_plan_name ?? '');
            Session::put('app_user_address', $user->app_u_address ?? '');
            Session::put('app_user_pin', $user->pin_code ?? '');
            Session::put('app_user_bank_name', $user->bank_name ?? '');
            Session::put('app_user_ifsc', $user->ifsc_code ?? '');
            Session::put('app_user_account', $user->bank_account_no ?? '');
            Session::put('app_user_upi_id', $user->upi_id ?? '');
            Session::put('app_user_upi_qr', $user->upi_qr_code ?? '');
            Session::put('app_user_introducer_id', $user->introducer_id ?? '');
            Session::put('app_user_introducer_name', $user->introducer_name ?? '');
            Session::put('app_user_introducer_phone', $user->introducer_phone ?? '');


            return redirect()->route('addBalance.userApp')->with('success', 'Login successful.');
            // return redirect()->route('dashboard.app')->with('success', 'Login successful.');
        }
 
        return back()->with('error', 'Invalid credentials.');
    }

  /*   public function logout()
    {
        Session::forget('app_user_id');
        Session::forget('app_user_name');
        Session::forget('app_user_phone');
        Session::forget('app_user_photo');
        Session::forget('app_user_photo');
        Session::forget('app_user_wallet');
        Session::forget('introducer_id');
        Session::forget('introducer_phone');
        Session::forget('introducer_name');
        return redirect()->route('userLogin.app')->with('error', 'Logged out successfully.');
    } */


    public function logout()
{
    Session::forget([
        'app_user_id',
        'app_user_name',
        'app_user_phone',
        'app_user_email',
        'app_user_photo',
        'app_user_wallet',
        'app_user_plan_id',
        'app_user_plan_name',
        'app_user_address',
        'app_user_pin',
        'app_user_bank_name',
        'app_user_ifsc',
        'app_user_account',
        'app_user_upi_id',
        'app_user_upi_qr',
        'app_user_introducer_id',
        'app_user_introducer_name',
        'app_user_introducer_phone',
    ]);

    // Flush previous session
    // Session::flush();
    return redirect()->route('userLogin.app')->with('error', 'Logged out successfully.');
}

}
