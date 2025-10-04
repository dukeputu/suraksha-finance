<!-- Left side column. contains the logo and sidebar -->
<style>
    .sidebar .label {
        font-size: 11px;
        margin-left: 10px;
    }
</style>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            {{-- <div class="pull-left image">
        <img src="{{ asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
      </div> --}}
            <div class="pull-left info">

                <a class=" logoutUser" href="{{ url('/logout') }}"
                    style=" background: tomato; padding: 4px 11px; border-radius: 10px; ">Logout</a>

                <a class=" logoutUser" href="{{ route('userLogin.app') }}"
                    style=" background: blue; padding: 4px 11px; border-radius: 10px; " target="_blank">User</a>


            </div>
            {{-- <div class="pull-left info">
        <p>{{ session('member_name') ?? 'Guest' }} <br>
          ID: MUM/{{ session('member_id') ?? '-' }}
          <br>
          Plan: <strong>{{ $planNameFromDB ?? 'NA' }} </strong>
        </p>
        <p><strong>Wallet:</strong> ₹{{ $walletBalanceSideBar ?? 0 }}</p>

        @if (session('member_id') === '0000001')
        <p><strong>Plan Deposits:</strong> ₹{{ $totalPlanDeposits ?? 0 }}</p>
        @endif


        <br>
        <a class=" logoutUser" href="{{ url('/logout') }}"
          style=" background: tomato; padding: 4px 11px; border-radius: 10px; ">Logout</a>

        <a class=" logoutUser" href="{{ route('userLogin.app') }}"
          style=" background: blue; padding: 4px 11px; border-radius: 10px; " target="_blank">User</a>


      </div> --}}
        </div>


        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- <li class="active treeview"> -->
            <li class=" treeview">
                <a href="{{ url('/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li>

            <li class="treeview">

                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i> <span>Admin List</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li>
                        <a href="{{ route('addAdmin.adminCreate') }}">
                            <i class="fa fa-circle-o"></i> Add Admin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('viewAdmins.list') }}">
                            <i class="fa fa-circle-o"></i> View Admins List
                        </a>
                    </li>

                </ul>
            </li>


            {{-- <li class=" treeview">
                <a href="{{ route('packageMaster.list') }}">
                    <i class="fa fa-file"></i> <span>Package Master</span>
                </a>

            </li> --}}


            <li class=" treeview">
                <a href="{{ url('plan-master') }}">
                    <i class="fa fa-tasks"></i> <span>Plan Master</span>
                </a>

            </li>


            <li class=" treeview">
                <a href="{{ route('appUsers.listAdminPanel') }}">
                    <i class="fa fa-file"></i> <span>App Users</span>



                </a>

            </li>



            <li class=" treeview">
                <a href="{{ route('addBalanceRequest.list') }}">
                    <i class="fa fa-file"></i> <span>Add Balance Request</span>

                    @php
                        $renewCount = \DB::table('user_balance_request')->where('status', 2)->count();

                        $withdrawalCount = \DB::table('user_withdraw_request')->where('status', 2)->count();
                    @endphp
                    @if ($renewCount > 0)
                        <small class="label pull-right bg-yellow">{{ $renewCount }}</small>
                    @endif

                </a>

            </li>


            <li class=" treeview">
                <a href="{{ route('packageBuyingRequest.list') }}">
                    <i class="fa fa-file"></i> <span>Package Buying </span>
                </a>

            </li>


            <li class=" treeview">
                <a href="{{ route('withdrawalRequest.list') }}">
                    <i class="fa fa-file"></i> <span>Withdrawal Request</span>
                    @if ($withdrawalCount > 0)
                        <small class="label pull-right bg-yellow">{{ $withdrawalCount }}</small>
                    @endif

                </a>

            </li>

            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-exchange"></i> <span>Wallet Transfer</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/wallet-transfer') }}"><i class="fa fa-circle-o"></i> Transfer Wallet</a></li>
                    <li><a href="{{ url('/wallet-transfer-history') }}"><i class="fa fa-circle-o"></i> Transfer
                            History</a></li>
                </ul>
            </li>




            <li class="treeview">
                <a href="{{ url('renewal-reminder') }}">
                    <i class="fa fa-bell"></i> 
                    <span>Renewal Reminder</span>
                    @php
                        use Carbon\Carbon;
                        $renewCount = \DB::table('app_users')
                            ->whereBetween('expiry_date', [
                                Carbon::now(),
                                Carbon::now()->addDays(60)
                            ])
                            ->where('status', 1)
                            ->count();
                    @endphp
                    @if($renewCount > 0)
                        <small class="label pull-right bg-yellow">{{ $renewCount }}</small>
                    @endif
                </a>
            </li>
            



            <br>
            <br>
            <br>





        </ul>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const path = location.pathname;
            document.querySelectorAll('.sidebar-menu li a').forEach(a => {
                if (a.pathname === path) a.parentElement.classList.add('active');
            });
        });
    </script>


    <!-- /.sidebar -->
</aside>
