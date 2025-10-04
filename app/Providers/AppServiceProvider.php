<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Member;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        
         /* View::composer('*', function ($view) {
           $plans_master_menu  = DB::table('plan_master')
            ->select('select_plan_id', 'select_plan')
            ->groupBy('select_plan_id', 'select_plan')
            ->get();
        $view->with('plans_master_menu', $plans_master_menu);
            }); */

        // ***************************

     // **********************
            /*

        View::composer('*', function ($view) {
            $memberId = session('member_id');
            $walletBalanceSideBar = 0;
            $totalPlanDeposits = null;
            $planRankForMenu = DB::table('plan_name_master')->get();
               $planNameFromDB = Member::where('member_id', $memberId)->value('select_plan_name') ?? 'NA';

            if ($memberId) {

                $walletBalanceSideBar = Member::where('member_id', $memberId)->value('member_wallet') ?? 0;
             
                if ($memberId === '0000001') {
                    // 🏦 Use stored value
                    $totalPlanDeposits = Member::where('member_id', '0000001')->value('total_deposit_earned') ?? 0;
                }
            }

            $view->with('walletBalanceSideBar', $walletBalanceSideBar)
                ->with('totalPlanDeposits', $totalPlanDeposits)
                ->with('planNameFromDB', $planNameFromDB)
                ->with('planRankForMenu', $planRankForMenu);
        });
            */
 







        
    }
}
