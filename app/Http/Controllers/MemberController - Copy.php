<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;




class MemberController extends Controller
{
   




public function getIntroducer($id)
{
    // 1️⃣ Prevent user from entering their own phone or ID
    $currentUserPhone = Session::get('app_user_phone');

    if ($id == $currentUserPhone) {
        return response()->json(['error' => 'You cannot use your own number as introducer']);
    }

    $introducer = DB::table('app_users')
        ->where('id', $id)
        ->orWhere('phone_number', $id)
        ->first();

    if (!$introducer) {
        return response()->json(['error' => 'Introducer not found']);
    }

    return response()->json([
        'introducer_id_hidden' => $introducer->id,
        'name'     => $introducer->app_u_name,
        'phone'    => $introducer->phone_number,
        'select_plan_name'  => $introducer->select_plan_name,
        'select_plan_id'  => $introducer->select_plan_id,
        'address'  => $introducer->app_u_address,
        'wallet_bal'  => $introducer->user_wallet,
        'position' => null // no position field exists in this table
    ]);
}




  // Show Add Form
    public function adminCreate()
    {
        $last = Member::orderBy('id', 'desc')->first();
        $nextId = str_pad(($last ? $last->id + 1 : 1), 7, '0', STR_PAD_LEFT); // e.g. 0000007

    if (request()->routeIs('addAdmin.adminCreate')) {
        return view('admin.logicApp.addAdmin', [
            'nextId' => $nextId,
            'company' => null,
            'isEdit' => false,
        ]);
    }
        return view('admin.member_join', compact('nextId', 'memberJoinDropDpwn'));
    }



       // Store New Company
    public function adminStore(Request $request)
    {
        $request->validate([
            'member_id' => 'required|unique:members,member_id',
            'CompanyName' => 'required',
            'phone' => 'required|unique:members,phone',
            'qrCodeUpload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('qrCodeUpload')) {
            $file = $request->file('qrCodeUpload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/qr_company'), $filename);
            $filePath = 'uploads/qr_company/' . $filename;
        }

        $joinDate = Carbon::now();

        Member::create([
            'member_id' => $request->member_id,
            'name' => $request->CompanyName,
            'phone' => $request->phone,
            'password' => Hash::make('abc11'),
            'email' => $request->email,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'cin_no' => $request->cin_no,
            'BankName' => $request->BankName,
            'BankACNo' => $request->BankACNo,
            'BankIFSC' => $request->BankIFSC,
            'upiId' => $request->upiId,
            'qrCodeUpload' => $filePath,
            'join_date' => $joinDate,
            'expiry_date' => '2025-07-18',
            // 'status' => Active= 1, Deactive =2, Pending = 3	,
            'status' => 2,
        ]);

     if (request()->routeIs('addAdmin.adminStore')) {
            return back()->with('success', 'Registration successful!');
        }

        return back()->with('success', 'Company added Successful.');
    }

    // Show Edit Form
    public function adminEdit($id)
    {
        $company = Member::findOrFail($id);
        return view('admin.logicApp.addAdmin', [
            'company' => $company,
            'nextId' => $company->member_id,
            'isEdit' => true,
        ]);
    }

    // Update Existing Company

public function adminUpdate(Request $request, $id)
{
    $company = Member::findOrFail($id);

    $request->validate([
        'CompanyName' => 'required',
        'phone' => 'required|unique:members,phone,' . $id,
        'qrCodeUpload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'password' => 'nullable|string|min:4', // Optional password update
        'company_status' => 'required|in:1,2,3',
    ]);

    // Handle QR file
    $filePath = $company->qrCodeUpload;
    if ($request->hasFile('qrCodeUpload')) {
        $file = $request->file('qrCodeUpload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/qr_company'), $filename);
        $filePath = 'uploads/qr_company/' . $filename;
    }

    // Prepare update data
    $updateData = [
        'name' => $request->CompanyName,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'pincode' => $request->pincode,
        'state' => $request->state,
        'cin_no' => $request->cin_no,
        'BankName' => $request->BankName,
        'BankACNo' => $request->BankACNo,
        'BankIFSC' => $request->BankIFSC,
        'upiId' => $request->upiId,
        'qrCodeUpload' => $filePath,
        'status' => $request->company_status,
    ];

    // If password is filled, update it
    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    $company->update($updateData);

    return back()->with('success', 'Company updated successfully!');
}


public function storePlanMaster(Request $request)
{
    $request->validate([
        'select_plan_id' => 'required|integer|exists:plan_name_master,id',
        'plan_amount'    => 'required|numeric',
        'plan_payout'    => 'required|string|max:255',
    ]);

    // Get plan name from plan_name_master
    $plan = \DB::table('plan_name_master')->where('id', $request->select_plan_id)->first();

    // Get how many levels already exist for this plan
    $existingCount = \DB::table('plan_master')
                        ->where('select_plan_id', $request->select_plan_id)
                        ->count();

    // Auto increment the next level number
    $nextLevelNumber = $existingCount + 1;
    $nextLevel = 'L' . $nextLevelNumber;

    // Insert into DB
    \DB::table('plan_master')->insert([
        'select_plan_id' => $request->select_plan_id,
        'select_plan'    => $plan->plan_names,
        'plan_amount'    => $request->plan_amount,
        'plan_payout'    => $request->plan_payout,
        'plan_level'     => $nextLevel,
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return back()->with('success', 'Plan added with level ' . $nextLevel);
}


public function showPlanMaster()
{
    $plans  = DB::table('plan_master')->get();
    $planNames= DB::table('plan_name_master')->get();

    return view('admin.plan_master', compact('plans', 'planNames'));
}

// Handle delete plan
public function deletePlan($id)
{
    DB::table('plan_master')->where('id', $id)->delete();
    return back()->with('success', 'Plan deleted successfully!');
}


// ******************************************

public function viewAdminsList()
{
    // $getCompany  = DB::table('members')->get();
   
    $getCompany = Member::where('member_id', '!=', '0000001')->get();


    // $compantList= DB::table('plan_name_master')->get();

    // return view('admin.plan_master', compact('plans', 'planNames'));
    
    return view('admin.logicApp.viewAdminsList', compact('getCompany'));

}
// ********************************

public function packageMasterGet()
{    
   // Fetch all packages from the database
    $packages = \DB::table('package_master')->get();
    // Pass the packages data to the view 
    return view('admin.logicApp.packageMaster', compact('packages'));
}



 public function packageMasterStore(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_amount' => 'required|numeric',
            'package_payout_per' => 'required|numeric',
            'package_total_amount' => 'required|numeric',
            'package_time_duration' => 'required|numeric',
        ]);

        // Insert data into package_master table
        DB::table('package_master')->insert([
            'package_name' => $request->package_name,
            'package_amount' => $request->package_amount,
            'package_payout_per' => $request->package_payout_per,
            'package_total_amount' => $request->package_total_amount,
            'package_time_duration' => $request->package_time_duration,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // return redirect()->route('packageMaster.list')->with('success', 'Package created successfully!');
        return back()->with('success', 'Package created successfully!');
    }




// **************************************************











// This is pure Laravel + DataTables JS, no third-party Laravel packages, fully customizable.

public function allMembersList()
{
return view('admin.allViewTables.allMembersList');
}

/**
     * Reusable dynamic datatable method for any table.
     */



    public function dynamicDataTable(Request $request)
    {
        $table = $request->get('table');
        $columns = $request->get('columns'); // required
        $searchable = $request->get('searchable', []);
        $orderable = $request->get('orderable', []);

        if (!$table || !$columns || !is_array($columns)) {
            return response()->json(['error' => 'Missing or invalid table or columns'], 400);
        }

        // Base query
        $query = DB::table($table);
        $totalData = $query->count();

        // Searching
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search, $searchable) {
                foreach ($searchable as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        $totalFiltered = $query->count();

        // Ordering
        $orderCol = $request->input('order.0.column', 0);
        $orderBy = $columns[$orderCol] ?? $columns[0];
        $dir = $request->input('order.0.dir', 'asc');

        $query->orderBy($orderBy, $dir)
              ->offset($request->input('start'))
              ->limit($request->input('length'));

        $data = [];
        $i = $request->input('start') + 1;

        foreach ($query->get() as $row) {
            $temp = [];
            $temp['DT_RowIndex'] = $i++;
            foreach ($columns as $col) {
                $temp[$col] = $row->$col ?? '';
            }
            $data[] = $temp;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,
        ]);
    }


// end This is pure Laravel + DataTables JS, no third-party Laravel packages, fully customizable.






// ****************************************


// ***********************************

    
public function showPlanPage($slug)
{
    // Get plan details
    $plan = DB::table('plan_master')
        ->whereRaw('LOWER(select_plan) = ?', [strtolower($slug)])
        ->first();

    if (!$plan) {
        abort(404, 'Plan not found');
    }

    // Get current logged-in member ID from session
    $beneficiaryId = session('member_id');

    // Get income transactions for the member under the plan
    $transactions = DB::table('mlm_transactions as t')
        ->join('members as m', 't.member_id', '=', 'm.member_id')
        ->select(
            't.member_id',
            'm.name as downline_name',
            't.level',
            't.amount',
            't.plan_id'
        )
        ->where('t.beneficiary_id', $beneficiaryId)
        ->where('t.plan_id', $plan->select_plan_id)
        ->get();

    // Total income
    $totalIncome = $transactions->sum('amount');

    return view('admin.allViewTables.plans_view_menu', [
        'plan' => $plan,
        'transactions' => $transactions,
        'totalIncome' => $totalIncome,
    ]);
}

// *************************************


// *************************************************









// User App All Cntoler Start *************************


public function registerUserApp(Request $request)
{
    // Validate input (optional, but recommended)
    $request->validate([
        'user_name'             => 'required|string|max:255',
        'phone_number'     => 'required|string|max:20|unique:app_users,phone_number',
        // 'password'         => 'required|string|max:255',
        'address'          => 'nullable|string',
        'profile_picture'      => 'nullable|file|mimes:jpeg,png,jpg,|max:20048',
        'upi_qr_code'      => 'required|nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
    ]);

    
        // Step 2: Find Introducer
    $introducer = DB::table('app_users')
        ->where('phone_number', $request->introducer_number)
        ->first();



     $uploadFile = function ($request, $inputName, $folder, $prefix = '') {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = $request->phone_number . '_' . $prefix . '_' . $file->getClientOriginalName();
                $file->move(public_path("uploads/$folder"), $filename);
                return "uploads/$folder/" . $filename;
            }
            return null;
        };

        $profilePicPath = $uploadFile($request, 'profile_picture', 'qr_user', 'profile');
        $qrCodePath     = $uploadFile($request, 'upi_qr_code', 'qr_user', 'qr');

    // Insert into DB

    DB::table('app_users')->insert([
        'app_u_name'              => $request->user_name,
        'phone_number'      => $request->phone_number,
        // 'select_plan_name'      => $request->select_plan_name,
        // 'select_plan_id'      => $request->select_plan_id,
        'user_wallet'      => 0,
        'introducer_id'     => $introducer->id ?? '1',
        'introducer_phone'     => $introducer->phone_number ?? '0001112223',
        'introducer_name'   => $introducer->app_u_name ?? 'Company',
        'user_email'      => $request->user_email,
        // 'password'          => Hash::make($request->password ?? '000111'),
        'password'          => Hash::make('0011'),
        'app_u_address'           => $request->user_address,
        'pin_code'          => $request->pin_code,
        'bank_name'         => $request->bank_name,
        'ifsc_code'         => $request->ifsc_code,
        'bank_account_no'   => $request->bank_account_no,
        'upi_id'            => $request->upi_id,
        'upi_qr_code'       => $profilePicPath,
        'user_pic_img'       => $qrCodePath,
        'status'            => 1,
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    // return back()->with('success', 'Plan added with level' . $nextLevel);

   return redirect()->route('userLogin.app')->with('success', '<h3 style="color:#fff;"> Registered Successfully.<br> Login User Name = ' . $request->phone_number . '<br>Login Password Is = 0011</h3>');


}


public function appUsersAdminPanelList()
{    
    $appUsers = \DB::table('app_users')->get();

    $userBalanceRequest = \DB::table('user_balance_request')
        ->leftJoin('app_users', 'user_balance_request.app_user_id', '=', 'app_users.id')
            ->select(
                'user_balance_request.*',
                'app_users.user_wallet',
                'app_users.bank_name',
                'app_users.ifsc_code',
                'app_users.bank_account_no',
                'app_users.upi_id',
                'app_users.upi_qr_code'
            )
            ->orderBy('user_balance_request.id', 'desc')
            ->get();


    $withdrawalRequest = \DB::table('user_withdraw_request')
                ->leftJoin('app_users', 'user_withdraw_request.app_user_id', '=', 'app_users.id')
                ->select(
                    'user_withdraw_request.*',
                    'app_users.user_wallet',
                    'app_users.bank_name',
                    'app_users.ifsc_code',
                    'app_users.bank_account_no',
                    'app_users.upi_id',
                    'app_users.upi_qr_code'
                )
                ->get();




    if (request()->routeIs('addBalanceRequest.list')) {
        return view('admin.logicApp.addBalanceRequest', compact('userBalanceRequest'));
    }

    if (request()->routeIs('withdrawalRequest.list')) {
        return view('admin.logicApp.withdrawalRequest', compact('withdrawalRequest'));
    }
    
    return view('admin.logicApp.appUsers', compact('appUsers'));
    
}



public function userAppDashboard()
{    

    // $appPackages = \DB::table('package_master')->get();

        $actived = 1;
        $membersBankDetails = DB::table('members')
            ->where('status', $actived)
            ->orderBy('id', 'asc')
            ->get();
        // Default message
        $warningMessage = null;
        // Check if there are more than 1 active members
        if ($membersBankDetails->count() > 1) {
            $warningMessage = "More than 1 company is active. Please contact the company.";
        }



        $introducerId = session('app_user_introducer_id');

        if ($introducerId === '99999999') {
            // Super introducer — show all plans
            $memberJoinDropDpwn = DB::table('plan_master')
                ->select('select_plan_id', 'select_plan', 'plan_amount')
                ->groupBy('select_plan_id', 'select_plan', 'plan_amount')
                ->get();
               
        } else {
            // Get introducer's select_plan_id
            $introducerPlanId = DB::table('app_users')
                ->where('id', $introducerId) // use introducer's ID as user ID
                ->value('select_plan_id');
               
            if ($introducerPlanId) {
                // Get introducer's plan rank
                $planRank = DB::table('plan_name_master')
                    ->where('id', $introducerPlanId)
                    ->value('plan_rank');
                   
        
                if ($planRank) {
                    // Get all plan IDs that are <= introducer's rank
                    $planIds = DB::table('plan_name_master')
                        ->where('plan_rank', '<=', $planRank)
                        ->pluck('id');

                       
        
                    // Get matching plans
                    $memberJoinDropDpwn = DB::table('plan_master')
                        ->select('select_plan_id', 'select_plan', 'plan_amount')
                        ->whereIn('select_plan_id', $planIds)
                        ->groupBy('select_plan_id', 'select_plan', 'plan_amount')
                        ->get();
                        // dd($memberJoinDropDpwn);
                        // exit;
                } else {
                    // If rank not found, return empty
                    $memberJoinDropDpwn = collect();
                }
            } else {
                // If introducer has no plan ID, return empty
                $memberJoinDropDpwn = collect();
            }
        }
        
        
    


        if (request()->routeIs('addBalance.userApp')) {
            return view('userApp.userAppView.addBalance', compact('membersBankDetails', 'warningMessage', 'memberJoinDropDpwn'));
        }
        

    // return view('userApp.userAppView.dashboard', compact('appPackages'));
    
}






public function userAddBalance(Request $request)
{
    $request->validate([
        'add_balance_amount' => 'required|numeric|min:1',
        'select_plan_id'     => 'required|integer|exists:plan_master,select_plan_id',
        'payment_screenShot' => 'nullable|file|mimes:jpeg,png,jpg|max:20048',
        'userId'             => 'required|integer|exists:app_users,id',
        'userName'           => 'required|string|max:255',
        'userPhone'          => 'required|string|max:20',
    ]);
    
    


    $uploadFile = function ($request, $inputName, $folder) {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $filename = Str::slug($request->userPhone) . '_' . now()->format('YmdHis') .'_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/$folder"), $filename);
            return "uploads/$folder/" . $filename;
        }
        return null;
    };

    $paymentScreenShot = $uploadFile($request, 'payment_screenShot', 'userPaymentScreenShot');

    // Insert into user_balance_request table
    DB::table('user_balance_request')->insert([
        'app_user_id'     => $request->userId,
        'app_user_name'   => $request->userName,
        'user_phone'      => $request->userPhone,
        'req_bal_amount'  => $request->add_balance_amount,
        'selected_plan_id'  => $request->select_plan_id,
        'pay_screenshot'  => $paymentScreenShot,
        'status'          => 2, // Pending
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

    // Get current wallet (before change)
    $walletBefore = DB::table('app_users')->where('id', $request->userId)->value('user_wallet') ?? 0;

    // Insert into user_transactions table
    DB::table('user_transactions')->insert([
        'app_user_id'     => $request->userId,
        'type_id'         => 1, // 1 = Add Balance
        'amount'          => $request->add_balance_amount,
        'wallet_before'   => $walletBefore,
        'wallet_after'    => $walletBefore, // Balance not yet added
        'status'          => 'Pending',
        'requested_at'    => now(),
        'screenshot'      => $paymentScreenShot,
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);

    // return redirect()->route('dashboard.app')->with('success', 'Rs.' . $request->add_balance_amount . ' balance request submitted successfully. Please wait for approval.');
    return redirect()->route('addBalance.userApp')->with('success', 'Rs.' . $request->add_balance_amount . ' balance request submitted successfully. Please wait for approval.');
}






    /*    return redirect()->route('userLogin.app')->with('success', '<h3 style="color:#fff;"> Registered Successfully.<br> Login User Name = ' . $request->phone_number . '<br>Login Password Is = 000111</h3>'); */




public function withdrawMoneyUserApp(Request $request)
{
    $request->validate([
        'withdraw_req' => 'required|numeric|min:1',
        'userId'       => 'required|integer',
        'userName'     => 'required|string|max:100',
        'userPhone'    => 'required|string|max:15',
    ]);

    $userId = $request->userId;
    $withdrawAmount = floatval($request->withdraw_req);

    // Fetch user
    $user = DB::table('app_users')->where('id', $userId)->first();
    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    $currentWallet = floatval($user->user_wallet);

    if ($currentWallet < $withdrawAmount) {
        return back()->with('error', 'Insufficient balance for withdrawal.');
    }

    $paymentScreenshot = 0; // Default

    DB::beginTransaction();
    try {
        // 1. Deduct wallet
        $newWallet = $currentWallet - $withdrawAmount;
        DB::table('app_users')->where('id', $userId)->update([
            'user_wallet' => $newWallet
        ]);

        // 2. Insert into withdraw request table
        DB::table('user_withdraw_request')->insert([
            'app_user_id'     => $userId,
            'app_user_name'   => $request->userName,
            'user_phone'      => $request->userPhone,
            'req_bal_amount'  => $withdrawAmount,
            'pay_screenshot'  => $paymentScreenshot,
            'status'          => 2, // Pending
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // 3. Log user transaction (type_id 4 = Withdrawal)
        DB::table('user_transactions')->insert([
            'app_user_id'   => $userId,
            'type_id'       => 4,
            'amount'        => $withdrawAmount,
            'wallet_before' => $currentWallet,
            'wallet_after'  => $newWallet,
            'status'        => 'Pending',
            'requested_at'  => now(),
            'done_at'       => null,
            'screenshot'    => $paymentScreenshot,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        DB::commit();

        // Update wallet in session
        Session::put('app_user_wallet', $newWallet);

        return back()->with('success', '₹' . number_format($withdrawAmount, 2) . ' withdrawal request submitted successfully. Please wait for approval.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong. Try again.');
    }
}



/* public function withdrawalScrenshortUpload(Request $request, $id)
{
    $request->validate([
        'payment_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480', // 20 MB max
    ]);

    $withdrawal = DB::table('user_withdraw_request')->where('id', $id)->first();

    if (!$withdrawal) {
        return back()->with('error', 'Withdrawal request not found.');
    }

    $filePath = $withdrawal->pay_screenshot;

    if ($request->hasFile('payment_screenshot')) {
        $file = $request->file('payment_screenshot');
        $filename = 'withdraw_' . now()->format('Ymd_His') . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/withdrawalDone'), $filename);
        $filePath = 'uploads/withdrawalDone/' . $filename;
    }

    DB::beginTransaction();
    try {
        // 1. Update withdrawal request table
        DB::table('user_withdraw_request')->where('id', $id)->update([
            'pay_screenshot' => $filePath,
            'status'         => 1, // Done
            'updated_at'     => now(),
        ]);

        // 2. Update corresponding transaction in user_transactions
        DB::table('user_transactions')
            ->where('app_user_id', $withdrawal->app_user_id)
            ->where('type_id', 4) // Withdrawal
            ->whereNull('done_at') // Pending only
            ->orderByDesc('id')
            ->limit(1)
            ->update([
                'screenshot' => $filePath,
                'status'     => 'Done',
                'done_at'    => now(),
                'updated_at' => now(),
            ]);

        DB::commit();
        return back()->with('success', 'Screenshot uploaded and withdrawal marked as completed.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong while updating. Please try again.');
    }
}
 */

 public function withdrawalScrenshortUpload(Request $request, $id)
{
    $request->validate([
        'online_cash' => 'required|in:1,2', // 1 = online, 2 = cash
        'payment_screenshot' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:20480', // 20 MB max
    ]);

    $withdrawal = DB::table('user_withdraw_request')->where('id', $id)->first();

    if (!$withdrawal) {
        return back()->with('error', 'Withdrawal request not found.');
    }

    $filePath = $withdrawal->pay_screenshot;

    if ($request->hasFile('payment_screenshot')) {
        $file = $request->file('payment_screenshot');
        $filename = 'withdraw_' . now()->format('Ymd_His') . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/withdrawalDone'), $filename);
        $filePath = 'uploads/withdrawalDone/' . $filename;
    }

    DB::beginTransaction();
    try {
        // 1. Update withdrawal request table
        DB::table('user_withdraw_request')->where('id', $id)->update([
            'pay_screenshot' => $filePath,
            'online_cash'    => $request->online_cash, // ✅ store payment method
            'status'         => 1, // Done
            'updated_at'     => now(),
        ]);

        // 2. Update corresponding transaction in user_transactions
        DB::table('user_transactions')
            ->where('app_user_id', $withdrawal->app_user_id)
            ->where('type_id', 4) // Withdrawal
            ->whereNull('done_at') // Pending only
            ->orderByDesc('id')
            ->limit(1)
            ->update([
                'screenshot' => $filePath,
                'status'     => 'Done',
                'done_at'    => now(),
                'updated_at' => now(),
            ]);

        DB::commit();
        return back()->with('success', 'Screenshot uploaded and withdrawal marked as completed.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong while updating. Please try again.');
    }
}










// ************************************************************
/* public function addBalanceTrafer(Request $request, $id)
{
    $request->validate([
        'userBlaAdd' => 'required|numeric',
    ]);

    // Get withdrawal request
    $balanceRequest = DB::table('user_balance_request')->where('id', $id)->first();

    if (!$balanceRequest) {
        return back()->with('error', 'Balance request not found.');
    }

    // Fetch user
    $user = DB::table('app_users')->where('id', $balanceRequest->app_user_id)->first();

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    $requestedAmount = (float)$request->userBlaAdd;
    $walletBefore = (float)$user->user_wallet;
    $walletAfter = $walletBefore + $requestedAmount;

    DB::beginTransaction();

    try {
        // 1. Update request status to "Done"
        DB::table('user_balance_request')->where('id', $id)->update([
            'status' => 1,
            'updated_at' => now(),
        ]);

        // 2. Update user's wallet
        DB::table('app_users')->where('id', $user->id)->update([
            'user_wallet' => $walletAfter,
        ]);

        // 3. Update the existing transaction
        DB::table('user_transactions')
            ->where('app_user_id', $user->id)
            ->where('type_id', 1) // Add Balance
            ->where('status', 'Pending')
            ->where('amount', $requestedAmount)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->update([
                'wallet_after' => $walletAfter,
                'status'       => 'Done',
                'done_at'      => now(),
                'updated_at'   => now(),
            ]);

        DB::commit();

        return back()->with('success', 'Balance transferred and transaction updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'An error occurred while updating balance.');
    }
} */


/* public function addBalanceTrafer(Request $request, $id)
{
    $request->validate([
        'userBlaAdd' => 'required|numeric',
    ]);

    // Get withdrawal request
    $balanceRequest = DB::table('user_balance_request')->where('id', $id)->first();

    if (!$balanceRequest) {
        return back()->with('error', 'Balance request not found.');
    }

    // Fetch user
    $user = DB::table('app_users')->where('id', $balanceRequest->app_user_id)->first();

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    // Get plan name from plan_master (based on selected_plan_id from balanceRequest)
    $planName = DB::table('plan_master')
        ->where('select_plan_id', $balanceRequest->selected_plan_id)
        ->value('select_plan');

    $requestedAmount = (float)$request->userBlaAdd;
    $walletBefore = (float)$user->user_wallet;
    $walletAfter = $walletBefore + $requestedAmount;

    DB::beginTransaction();

    try {
        // 1. Update request status to "Done"
        DB::table('user_balance_request')->where('id', $id)->update([
            'status' => 1,
            'updated_at' => now(),
        ]);

        // 2. Update user's wallet and plan details
        DB::table('app_users')->where('id', $user->id)->update([
            'user_wallet'       => $walletAfter,
            'select_plan_id'    => $balanceRequest->selected_plan_id,
            'select_plan_name'  => $planName ?? '',
        ]);

        // 3. Update the existing transaction
        DB::table('user_transactions')
            ->where('app_user_id', $user->id)
            ->where('type_id', 1) // Add Balance
            ->where('status', 'Pending')
            ->where('amount', $requestedAmount)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->update([
                'wallet_after' => $walletAfter,
                'status'       => 'Done',
                'done_at'      => now(),
                'updated_at'   => now(),
            ]);

        DB::commit();

        return back()->with('success', 'Balance transferred, plan updated, and transaction completed successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'An error occurred while updating balance.');
    }
}
 */


 public function addBalanceTrafer(Request $request, $id)
{
    $request->validate([
        'userBlaAdd' => 'required|numeric',
    ]);

    // 1. Get balance request
    $balanceRequest = DB::table('user_balance_request')->where('id', $id)->first();
    if (!$balanceRequest) {
        return back()->with('error', 'Balance request not found.');
    }

    // 2. Get user
    $user = DB::table('app_users')->where('id', $balanceRequest->app_user_id)->first();
    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    // 3. Get plan details
    $planValid = DB::table('plan_name_master')
        ->where('id', $balanceRequest->selected_plan_id)
        ->value('plan_valid') ?? 365;

    $planName = DB::table('plan_master')
        ->where('select_plan_id', $balanceRequest->selected_plan_id)
        ->value('select_plan') ?? '';

    $joinDate = Carbon::now();
    $expiryDate = $joinDate->copy()->addDays($planValid);

    $requestedAmount = (float)$request->userBlaAdd;
    $walletBefore = (float)$user->user_wallet;
    $walletAfter = $walletBefore + $requestedAmount;

    DB::beginTransaction();
    try {
        /** ----------------
         * Step 1: Update Request Status
         * ---------------- */
        DB::table('user_balance_request')->where('id', $id)->update([
            'status' => 1,
            'updated_at' => now(),
        ]);

        /** ----------------
         * Step 2: Update User Wallet + Plan + Dates
         * ---------------- */
        DB::table('app_users')->where('id', $user->id)->update([
            'user_wallet'      => $walletAfter,
            'select_plan_id'   => $balanceRequest->selected_plan_id,
            'select_plan_name' => $planName,
            'join_date'        => $joinDate->toDateString(),
            'expiry_date'      => $expiryDate->toDateString(),
        ]);

        /** ----------------
         * Step 3: MLM Plan Commission Distribution
         * ---------------- */
        $planId = $balanceRequest->selected_plan_id;
        $payouts = DB::table('plan_master')
            ->where('select_plan_id', $planId)
            ->orderBy('id', 'asc')
            ->get();

        $uplineId = $user->introducer_id;
        $levelIndex = 0;
        foreach ($payouts as $payout) {
            if (!$uplineId || $levelIndex >= 40) break;

            $upline = DB::table('app_users')->where('id', $uplineId)->first();
            if (!$upline) break;

            // Insert MLM Transaction
            DB::table('mlm_transactions')->insert([
                'app_user_id'     => $user->id,
                'introducer_id'=> $uplineId,
                'level'         => $payout->plan_level,
                'amount'        => $payout->plan_payout,
                'plan_id'       => $planId,
                'created_at'    => now()
            ]);

            // Update upline wallet
            DB::table('app_users')
                ->where('id', $uplineId)
                ->increment('user_wallet', $payout->plan_payout);

            $uplineId = $upline->introducer_id;
            $levelIndex++;
        }

        /** ----------------
         * Step 4: Update Transaction Table
         * ---------------- */
        DB::table('user_transactions')
            ->where('app_user_id', $user->id)
            ->where('type_id', 1) // Add Balance
            ->where('status', 'Pending')
            ->where('amount', $requestedAmount)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->update([
                'wallet_after' => $walletAfter,
                'status'       => 'Done',
                'done_at'      => now(),
                'updated_at'   => now(),
            ]);

        /** ----------------
         * Step 5: Update Company Total Deposits
         * ---------------- */
        // $this->updateCompanyTotalDeposits();
            // After MLM transactions are inserted , All member wallets updated
        // $this->updateAllUserWallets();
        // $this->updateCompanyTotalDeposits();


        DB::commit();
        return back()->with('success', 'Balance transferred, MLM payouts processed, and plan updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error while updating balance: ' . $e->getMessage());
    }
}


public function updateAllUserWalletsManually()
{
    $this->updateAllUserWallets();
    return redirect()->back()->with('success', 'All user wallets updated successfully.');
}

public function updateAllUserWallets()
{
    // 1️⃣ Get total income per beneficiary (introducer)
    $wallets = DB::table('mlm_transactions')
        ->select('introducer_id', DB::raw('SUM(amount) as total'))
        ->groupBy('introducer_id')
        ->pluck('total', 'introducer_id'); // ['3' => 560, ...]

    // 2️⃣ Update each app_user's wallet
    foreach ($wallets as $userId => $amount) {
        DB::table('app_users')
            ->where('id', $userId) // ✅ Matches your "app_users.id"
            ->update(['user_wallet' => $amount]);
    }

    // 3️⃣ Set 0 for users who have no transactions
    DB::table('app_users')
        ->whereNotIn('id', $wallets->keys())
        ->update(['user_wallet' => 0]);
}

public function updateCompanyTotalDeposits()
{
    // Assuming company account is app_user_id = 1
    $companyId = 1; 

    $total = DB::table('app_users')
        ->select('select_plan_id', 'select_plan_name', DB::raw('COUNT(*) as user_count'))
        ->groupBy('select_plan_id', 'select_plan_name')
        ->get()
        ->map(function ($plan) {
            $amount = DB::table('plan_master')
                ->where('select_plan_id', $plan->select_plan_id)
                ->orderBy('id', 'asc')
                ->value('plan_amount') ?? 0;

            return $amount * $plan->user_count;
        })->sum();

    DB::table('app_users')
        ->where('id', $companyId)
        ->update(['total_deposit_earned' => $total]);

    return redirect()->back()->with('success', 'Company total plan deposits updated!');
}



// *************************************************************
/* public function checkMemberStatusAndNotify() 
{
    $today = Carbon::now();
    $pendingStart = $today->copy()->addDays(30);

    Member::where('expiry_date', '<=', $pendingStart)
          ->where('expiry_date', '>=', $today)
          ->where('status', 1)
          ->update(['status' => 2]);
}

public function autoDeactivateExpiredMembers() 
{
    $today = Carbon::now();
    Member::where('expiry_date', '<', $today)->update(['status' => 0]);
}

public function notifyExpiringMembers() 
{
    $start = Carbon::now();
    $end = $start->copy()->addDays(60);

    $expiringSoon = Member::whereBetween('expiry_date', [$start, $end])
                          ->whereIn('status', [1, 2])
                          ->get();

    return view('admin.renewals.notify', compact('expiringSoon'));
}

public function renewMember($member_id) 
{
    $member = Member::where('member_id', $member_id)->first();
    if ($member) {
        $validity = DB::table('plan_name_master')
            ->where('id', $member->select_plan_id)
            ->value('plan_valid') ?? 365;

        $fromDate = Carbon::now()->greaterThan($member->expiry_date)
                    ? Carbon::now() : Carbon::parse($member->expiry_date);

        $member->expiry_date = $fromDate->addDays($validity);
        $member->status = 1;
        $member->save();

        return back()->with('success', 'Member renewed successfully.');
    }
    return back()->with('error', 'Member not found.');
}

public function checkMemberExpiries()
    {
        $today = Carbon::now();
        $notifyBefore = $today->copy()->addDays(60); // Next 60 days

        $expiringSoon = Member::whereBetween('expiry_date', [$today, $notifyBefore])
                            ->where('status', 1)
                            ->orderBy('expiry_date', 'asc')
                            ->get();

        return view('admin.renewals.notify', compact('expiringSoon'));
    }
 */



    
    // 1. Check and update member status
    public function checkMemberStatusAndNotify()
    {
        $today = Carbon::now()->toDateString();
        $pendingStart = Carbon::now()->addDays(30)->toDateString();

        // Status 2 = Pending Renewal (expires within 30 days)
        DB::table('app_users')
            ->where('expiry_date', '<=', $pendingStart)
            ->where('expiry_date', '>=', $today)
            ->where('status', 1)
            ->update(['status' => 2]);

        return "Member statuses updated successfully.";
    }

    // 2. Auto deactivate expired members
    public function autoDeactivateExpiredMembers()
    {
        $today = Carbon::now()->toDateString();

        DB::table('app_users')
            ->where('expiry_date', '<', $today)
            ->update(['status' => 0]);

        return "Expired members deactivated.";
    }

    // 3. Notify members expiring in next 60 days
    public function notifyExpiringMembers()
    {
        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->addDays(60)->toDateString();

        $expiringSoon = DB::table('app_users')
            ->whereBetween('expiry_date', [$start, $end])
            ->whereIn('status', [1, 2])
            ->orderBy('expiry_date', 'asc')
            ->get();

        return view('admin.renewals.notify', compact('expiringSoon'));
    }

    // 4. Renew member
    public function renewMember($member_id)
    {
        $member = DB::table('app_users')->where('id', $member_id)->first();

        if ($member) {
            $validity = DB::table('plan_name_master')
                ->where('id', $member->select_plan_id)
                ->value('plan_valid') ?? 365;

            $fromDate = Carbon::now()->greaterThan(Carbon::parse($member->expiry_date))
                        ? Carbon::now()
                        : Carbon::parse($member->expiry_date);

            $newExpiry = $fromDate->addDays($validity)->toDateString();

            DB::table('app_users')
                ->where('id', $member->id)
                ->update([
                    'expiry_date' => $newExpiry,
                    'status' => 1
                ]);

            return back()->with('success', 'Member renewed successfully.');
        }
        return back()->with('error', 'Member not found.');
    }

    // 5. Renewal reminder (view members expiring soon)
    public function checkMemberExpiries()
    {
        $today = Carbon::now()->toDateString();
        $notifyBefore = Carbon::now()->addDays(60)->toDateString();

        $expiringSoon = DB::table('app_users')
            ->whereBetween('expiry_date', [$today, $notifyBefore])
            ->where('status', 1)
            ->orderBy('expiry_date', 'asc')
            ->get();

        return view('admin.renewals.notify', compact('expiringSoon'));
    }







// **************************************************************

public function showWalletTransferForm() 
{
        return view('admin.wallet.transfer');
}



/* 
 public function processWalletTransfer(Request $request)
{
    $request->validate([
        'from_phone' => 'required|exists:app_users,phone_number',
        'to_phone'   => 'required|exists:app_users,phone_number|different:from_phone',
        'amount'     => 'required|numeric|min:1',
    ]);

    $amount = $request->amount;

    DB::beginTransaction();
    try {
        // Lock both users for safe balance changes
        $from = DB::table('app_users')->where('phone_number', $request->from_phone)->lockForUpdate()->first();
        $to   = DB::table('app_users')->where('phone_number', $request->to_phone)->lockForUpdate()->first();

        if (!$from || !$to || $from->user_wallet < $amount) {
            DB::rollBack();
            return back()->with('error', 'Insufficient balance or invalid user.');
        }

        // Store before balances
        $fromBefore = $from->user_wallet;
        $toBefore   = $to->user_wallet;

        // Update balances
        DB::table('app_users')->where('id', $from->id)->update([
            'user_wallet' => $fromBefore - $amount
        ]);

        DB::table('app_users')->where('id', $to->id)->update([
            'user_wallet' => $toBefore + $amount
        ]);

        // Save transfer log
        DB::table('wallet_transfers')->insert([
            'from_user_id'        => $from->id,
            'from_user_last_bal'  => $fromBefore,
            'to_user_id'          => $to->id,
            'to_user_last_bal'    => $toBefore,
            'amount'              => $amount,
            'from_balance_change' => "-{$amount}",
            'from_balance_after'  => $fromBefore - $amount,
            'to_balance_change'   => "+{$amount}",
            'to_balance_after'    => $toBefore + $amount,
            'created_at'          => now(),
        ]);

        DB::commit();
        return back()->with('success', 'Transfer completed successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Transfer failed. ' . $e->getMessage());
    }
}
 */

 public function processWalletTransfer(Request $request)
{
    $isAdmin = (session('member_id') === '0000001'); // your admin check

    if ($isAdmin) {
        // Admin can transfer from any account
        $request->validate([
            'from_phone' => 'required|exists:app_users,phone_number',
            'to_phone'   => 'required|exists:app_users,phone_number|different:from_phone',
            'amount'     => 'required|numeric|min:1',
        ]);

        $fromPhone = $request->from_phone;
    } else {
        // Normal user: from_phone is always current user
        $request->validate([
            'to_phone' => 'required|exists:app_users,phone_number|different:to_phone',
            'amount'   => 'required|numeric|min:1',
        ]);

        $fromPhone = session('app_user_phone');
    }

    $amount = $request->amount;

    DB::beginTransaction();
    try {
        // Lock both accounts for safe balance change
        $from = DB::table('app_users')->where('phone_number', $fromPhone)->lockForUpdate()->first();
        $to   = DB::table('app_users')->where('phone_number', $request->to_phone)->lockForUpdate()->first();

        if (!$from || !$to || $from->user_wallet < $amount) {
            DB::rollBack();
            return back()->with('error', 'Insufficient balance or invalid user.');
        }

        // Store before balances
        $fromBefore = $from->user_wallet;
        $toBefore   = $to->user_wallet;

        // Update balances
        DB::table('app_users')->where('id', $from->id)->update([
            'user_wallet' => $fromBefore - $amount
        ]);

        DB::table('app_users')->where('id', $to->id)->update([
            'user_wallet' => $toBefore + $amount
        ]);

        // Save transfer log
        DB::table('wallet_transfers')->insert([
            'from_user_id'        => $from->id,
            'from_user_last_bal'  => $fromBefore,
            'to_user_id'          => $to->id,
            'to_user_last_bal'    => $toBefore,
            'amount'              => $amount,
            'from_balance_change' => "-{$amount}",
            'from_balance_after'  => $fromBefore - $amount,
            'to_balance_change'   => "+{$amount}",
            'to_balance_after'    => $toBefore + $amount,
            'created_at'          => now(),
        ]);

        DB::commit();
        return back()->with('success', 'Transfer completed successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Transfer failed. ' . $e->getMessage());
    }
}







public function walletTransferHistory()
{
    $memberId = session('member_id'); // Logged-in member ID

    $query = DB::table('wallet_transfers')
        ->leftJoin('app_users as from_user', 'wallet_transfers.from_user_id', '=', 'from_user.id')
        ->leftJoin('app_users as to_user', 'wallet_transfers.to_user_id', '=', 'to_user.id')
        ->select(
            'wallet_transfers.*',
            'from_user.phone_number as from_phone',
            'to_user.phone_number as to_phone'
        )
        ->orderBy('wallet_transfers.created_at', 'desc');

    // If not admin, filter by own transactions
    if ($memberId !== '0000001') {
        $query->where(function ($q) use ($memberId) {
            $q->where('wallet_transfers.from_user_id', $memberId)
              ->orWhere('wallet_transfers.to_user_id', $memberId);
        });
    }

    $history = $query->get();

    return view('admin.wallet.history', compact('history', 'memberId'));
}



 
 


// *************************************************************

public function buyPackage(Request $request)
{
    $userId = Session::get('app_user_id');
    $introducer_id = Session::get('introducer_id');
    $introducer_phone = Session::get('introducer_phone');

    if (!$userId) {
        return redirect()->route('userLogin.app')->with('error', 'You must be logged in to buy a package.');
    }

    $packageId = $request->package_id;

    // Fetch user & package
    $user = DB::table('app_users')->where('id', $userId)->first();
    $package = DB::table('package_master')->where('id', $packageId)->first();

    if (!$user || !$package) {
        return back()->with('error', 'User or Package not found.');
    }

    $walletBefore = (float)$user->user_wallet;
    $packageAmount = (float)$package->package_amount;

    if ($walletBefore < $packageAmount) {
        return back()->with('error', 'Insufficient wallet balance.');
    }

    $walletAfter = $walletBefore - $packageAmount;

    // Start DB transaction to ensure consistency
    DB::beginTransaction();

    try {
        // 1. Deduct user wallet
        DB::table('app_users')->where('id', $userId)->update([
            'user_wallet' => $walletAfter,
            'updated_at' => now()
        ]);

        // 2. Insert package purchase
        DB::table('user_package_purchases')->insert([
            'app_user_id' => $userId,
            'package_id'  => $packageId,
            'introducer_id'  => $introducer_id,
            'introducer_phone'  => $introducer_phone,
            'amount_paid' => $packageAmount,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // 3. Insert into user_transactions
        DB::table('user_transactions')->insert([
            'app_user_id'   => $userId,
            'type_id'       => 2, // 2 = Package Buy
            'amount'        => $packageAmount,
            'wallet_before' => $walletBefore,
            'wallet_after'  => $walletAfter,
            'status'        => 'Done',
            'requested_at'  => now(),
            'done_at'       => now(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // 4. Update wallet in session
        Session::put('app_user_wallet', $walletAfter);

        DB::commit();

        return back()->with('success', 'Package purchased successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong while purchasing the package.');
    }
}





public function showPackageBuyingRequests()
{
    $requests = DB::table('user_package_purchases as upp')
        ->leftJoin('app_users as au', 'upp.app_user_id', '=', 'au.id')
        ->leftJoin('package_master as pm', 'upp.package_id', '=', 'pm.id')
        ->select(
            'upp.id',
            'au.app_u_name as user_name',
            'au.phone_number',
            'upp.amount_paid',
            'pm.package_name',
            'upp.created_at'
        )
        ->orderBy('upp.created_at', 'desc')
        ->get();

    return view('admin.logicApp.packageBuyingRequest', compact('requests'));
}



// ******************************************************
public function userAppDashboardUpdate()
{
    $appPackages = DB::table('package_master')->get();
    $userId = session('app_user_id');

    $purchases = DB::table('user_package_purchases')
        ->join('package_master', 'user_package_purchases.package_id', '=', 'package_master.id')
        ->where('user_package_purchases.app_user_id', $userId)
        ->where('user_package_purchases.is_credited', 0)
        ->select(
            'user_package_purchases.id as purchase_id',
            'user_package_purchases.created_at',
            'package_master.package_total_amount',
            'package_master.package_time_duration'
        )
        ->get();

    foreach ($purchases as $purchase) {
        $matureTime = \Carbon\Carbon::parse($purchase->created_at)
            ->addMinutes(intval($purchase->package_time_duration));

        if (now()->greaterThanOrEqualTo($matureTime)) {
            $currentWallet = DB::table('app_users')->where('id', $userId)->value('user_wallet');
            $amountToCredit = floatval($purchase->package_total_amount);
            $newWallet = floatval($currentWallet) + $amountToCredit;

            // Begin transaction
            DB::beginTransaction();

            try {
                // 1. Update user wallet
                DB::table('app_users')
                    ->where('id', $userId)
                    ->update(['user_wallet' => $newWallet]);

                // 2. Mark package as credited
                DB::table('user_package_purchases')
                    ->where('id', $purchase->purchase_id)
                    ->update([
                        'is_credited' => 1,
                        'updated_at' => now()
                    ]);

                // 3. Log transaction
                DB::table('user_transactions')->insert([
                    'app_user_id'   => $userId,
                    'type_id'       => 3, // 3 = Maturity
                    'amount'        => $amountToCredit,
                    'wallet_before' => $currentWallet,
                    'wallet_after'  => $newWallet,
                    'status'        => 'Done',
                    'requested_at'  => $matureTime,
                    'done_at'       => now(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Optionally log the error
            }
        }
    }

    $hasBoughtPackage1 = DB::table('user_package_purchases')
                        ->where('app_user_id', $userId)
                        ->where('package_id', 1)
                        ->exists();



    // Refresh wallet in session
    $userWallet = DB::table('app_users')->where('id', $userId)->value('user_wallet');
    Session::put('app_user_wallet', $userWallet);

    return view('userApp.userAppView.dashboard', compact('userWallet', 'appPackages','hasBoughtPackage1'));
}
// ************************************************************



public function allTransactionsUserApp(Request $request)
{
    // $userId = auth()->user()->id; // or $request->user()->id if using auth guard
    $userId = session('app_user_id');

    $transactions = DB::table('user_transactions as ut')
        ->join('transaction_types as tt', 'ut.type_id', '=', 'tt.id')
        ->select(
            'ut.*',
            'tt.name as type'
        )
        ->where('ut.app_user_id', $userId)
        ->orderByDesc('ut.id')
        ->get();

    return view('userApp.userAppView.allTransactions', compact('transactions'));
}






public function myPackagesList()
{
    $userId = session('app_user_id');

    $transactions = DB::table('user_transactions')
        ->where('app_user_id', $userId)
        ->whereIn('type_id', [2, 3]) // Buy or Maturity
        ->orderByDesc('id')
        ->get();

    $packageData = DB::table('user_package_purchases as upp')
        ->join('package_master as pm', 'upp.package_id', '=', 'pm.id')
        ->where('upp.app_user_id', $userId)
        ->select(
            'upp.id as purchase_id',
            'upp.amount_paid',
            'upp.created_at as purchase_created_at',
            'upp.is_credited',
            'pm.package_name',
            'pm.package_amount',
            'pm.package_total_amount',
            'pm.package_time_duration',
            'pm.package_payout_per'
        )
        ->get();

    $combined = $transactions->map(function ($txn) use ($packageData) {
        $match = null;

        if ($txn->type_id == 2) { // Buy
            $match = $packageData->first(function ($pkg) use ($txn) {
                return (float)$pkg->amount_paid === (float)$txn->amount &&
                    \Carbon\Carbon::parse($pkg->purchase_created_at)->format('Y-m-d H:i') ===
                    \Carbon\Carbon::parse($txn->requested_at)->format('Y-m-d H:i');
            });
        }

        if ($txn->type_id == 3) { // Maturity
            $match = $packageData->first(function ($pkg) use ($txn) {
                return $pkg->is_credited == 1 &&
                    (float)$pkg->package_total_amount === (float)$txn->amount;
            });
        }

        return (object)[
            'type_id'           => $txn->type_id,
            'type_name'         => $txn->type_id == 2 ? 'Package Buy' : 'Maturity',
            'status'            => $txn->status,
            'amount'            => $txn->amount,
            'wallet_before'     => $txn->wallet_before,
            'wallet_after'      => $txn->wallet_after,
            'requested_at'      => $txn->requested_at,
            'done_at'           => $txn->done_at,
            'package_name'      => $match->package_name ?? 'N/A',
            'package_amount'    => $match->package_amount ?? null,
            'package_total_amount' => $match->package_total_amount ?? null,
            'package_time_duration' => $match->package_time_duration ?? null,
            'package_payout_per' => $match->package_payout_per ?? null,
            'is_credited'       => $match->is_credited ?? null,
        ];
    });

    return view('userApp.userAppView.myPackagesList', [
        'appPackages' => $combined
    ]);
}


/* public function downlinesTree()
{
    
    return view('userApp.userAppView.downlinesTree'); 
} */


public function downlinesTree()
{
    $currentPhone = session('app_user_phone'); // Get logged-in user's phone
    $members = DB::table('app_users')->get();

    $rootUser = $members->where('phone_number', $currentPhone)->first(); // Find root user

    $treeHtml = '';

    if ($rootUser) {
        $treeHtml .= '<ul>';
        $treeHtml .= '<li>';
        $treeHtml .= '<div class="node toggle open" style="background:#d1ffd1;border:2px solid green;">';
        $treeHtml .= '👑 ' . $rootUser->app_u_name . ' [' . $rootUser->phone_number . ']</div>';

        $treeHtml .= $this->buildTreeHtml($members, $rootUser->id); // Pass root user ID
        $treeHtml .= '</li>';
        $treeHtml .= '</ul>';
    }

    return view('userApp.userAppView.downlinesTree', compact('treeHtml'));
}







private function buildTreeHtml($members, $parentId = null)
{
    $html = '';
    $children = $members->where('introducer_id', $parentId);

    if ($children->count()) {
        $html .= '<ul class="children">';
        foreach ($children as $member) {
            $hasChild = $members->where('introducer_id', $member->id)->count() > 0;

            $html .= '<li>';
            $html .= '<div class="node toggle ' . ($hasChild ? 'open' : '') . '" style="border: 1px solid #ccc;">';
            $html .= ($hasChild ? '➖' : '👤') . ' ';
            $html .= htmlspecialchars($member->app_u_name) . ' ';

            // ✅ Here is the fixed part with correct PHP string syntax
            $html .= '<span 
                class="text-primary openIncomeModal" 
                data-user-name="' . htmlspecialchars($member->app_u_name) . '" 
                data-user-phone="' . htmlspecialchars($member->phone_number) . '" 
                data-user-id="' . $member->id . '" 
                style="cursor:pointer;" 
                data-bs-toggle="modal" 
                data-bs-target="#ModalBasic">
                [' . htmlspecialchars($member->phone_number) . ']
            </span>';

            $html .= '</div>';

            // 🔁 Recursive call for children
            $html .= $this->buildTreeHtml($members, $member->id);

            $html .= '</li>';
        }
        $html .= '</ul>';
    }

    return $html;
}








public function getDownlineIncome($id)
{
    $allUserIds = $this->getAllDownlineUserIds($id);

    $downlines = DB::table('app_users as au')
        ->leftJoin('user_package_purchases as upp', 'au.id', '=', 'upp.app_user_id')
        ->whereIn('au.id', $allUserIds)
        ->select('au.app_u_name as name', 'au.phone_number as phone', 'upp.amount_paid as amount')
        ->get();

    return response()->json([
        'downlines' => $downlines
    ]);
}

private function getAllDownlineUserIds($parentId)
{
    $ids = [];
    $directs = DB::table('app_users')->where('introducer_id', $parentId)->pluck('id');

    foreach ($directs as $id) {
        $ids[] = $id;
        $ids = array_merge($ids, $this->getAllDownlineUserIds($id));
    }

    return $ids;
}








    public function updatePassword(Request $request)
{
    $userId = session('app_user_id');

    if (!$userId) {
        return response()->json(['success' => false, 'message' => 'User not authenticated.']);
    }

    // Validate file types
    $request->validate([
        'upi_qr_code' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'user_pic_img' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Check password match
    if ($request->new_password !== $request->confirm_password) {
        return response()->json(['success' => false, 'message' => 'Passwords do not match.']);
    }

    // Upload helper
    $uploadFile = function ($field, $folder, $prefix = '') use ($request) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $filename = 'USER_' . $prefix . '_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/$folder"), $filename);
            return "uploads/$folder/" . $filename;
        }
        return null;
    };

    // Upload files if present
    $qrPath = $uploadFile('upi_qr_code', 'qr_user', 'qr');
    $picPath = $uploadFile('user_pic_img', 'user_pics', 'pic');

    // Prepare update data
    $updateData = [
        'password' => Hash::make($request->new_password),
        'bank_name' => $request->bank_name,
        'ifsc_code' => $request->ifsc_code,
        'bank_account_no' => $request->bank_account_no,
        'upi_id' => $request->upi_id,
        'updated_at' => now(),
    ];

    if ($qrPath) $updateData['upi_qr_code'] = $qrPath;
    if ($picPath) $updateData['user_pic_img'] = $picPath;

    // Update user
    DB::table('app_users')->where('id', $userId)->update($updateData);

    return response()->json([
        'success' => true,
        'message' => 'Password & bank details updated successfully.',
        'redirect' => true,
        'redirect_url' => route('userLogin.app'),
        'password_message' => '<h3 style="color:#fff;">Your new password is: <strong>' . $request->new_password . '</strong><br>Save it carefully.</h3>'
    ]);
}






public function adminLoginAsUser($userId)
{
    $user = DB::table('app_users')->where('id', $userId)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Flush previous session
    // Session::flush();
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

    // Set new session values
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

    return redirect()->route('addBalance.userApp')->with('success', '🔑 You are now logged in as: ' . $user->app_u_name);
}





// User App All Cntoler End *************************


// delete **************************************************

/*
Your Controller Method (already good)
 // ✅ Only allow specific tables
    $allowedTables = ['members', 'plans', 'companies'];
✅ 2. Define Route in web.php

Route::get('/delete/{table}/{id}', [MemberController::class, 'deleteFromTable'])->name('generic.delete');

✅ 3. Use in Blade (Dynamic Delete Button)

<a href="{{ route('generic.delete', ['table' => 'members', 'id' => $company->id]) }}"
   onclick="return confirm('Are you sure you want to delete {{ $company->name }}?')"
   class="btn btn-danger">
    <i class="fa fa-trash"></i>
</a>

*/


public function deleteFromTable(Request $request, $table, $id)
{
    // ✅ Only allow specific tables
    $allowedTables = ['members', 'package_master'];

    if (!in_array($table, $allowedTables)) {
        abort(403, 'Unauthorized table access.');
    }

    DB::table($table)->where('id', $id)->delete();

    // return back()->with('success', ucfirst($table) . ' deleted successfully!');
    return back()->with('success',  ' Deleted successfully!');
}

// delete **************************************************


}