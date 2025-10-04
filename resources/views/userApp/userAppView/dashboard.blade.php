@php
    $userId = session('app_user_id');
    $userName = session('app_user_name');
    $userPhone = session('app_user_phone');
    $userPic = session('app_user_photo');
    $userWallet = session('app_user_wallet');

    // dd($userPic);
    // exit;
    /*

@if ($userPic)
<img src="{{ url(asset($userPic)) }}" alt="image" class="imaged w32">
@endif
*/
    // dd(session()->all());

    // $introducerId = session('app_user_introducer_id');

    // dd($introducerId);
    // exit;

@endphp

@extends('userApp.layouts.userAppLayout')
@section('title', 'Suraksha Finance')

@section('content')



    <style>
        .card-block {
            height: 16rem;
        }
    </style>

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            {{-- <img src="{{ url('userApp/assets/img/logo.png') }}" alt="logo" class="logo"> --}}


            <img style="border-radius: 10px;margin: 8px 0 0 15px;" width="60"
                src="{{ url('userApp/assets/goldoffLogo.webp') }}" alt="">
        </div>
        <div class="right">

            {{-- @if ($userName) --}}
            <div>
                <center>
                    {{-- <h3>Welcome, </h3> --}}
                    <strong>{{ $userName }}</strong>
                    {{-- @endif --}}
                    <br>
                    {{-- @if ($userPhone) --}}
                    <div>{{ $userPhone }}</div>
                    {{-- @endif --}}
                </center>
            </div>
            {{-- <a href="{{ route('userAppSettings.userApp'); }}" class="headerButton"> --}}

            {{-- </a> --}}


        </div>
    </div>
    <!-- * App Header -->






    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">



                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">Total Balance</span>
                        {{-- @if ($userWallet)
                    <h1 class="total" id="totalWallet">₹ {{ $userWallet ?? '0.00' }}</h1>

                    @endif --}}
                        <h1 class="total" id="totalWallet">₹ {{ number_format($userWallet ?? 0, 2) }}</h1>

                    </div>
                    <div class="right">
                        @if ($userPic)
                            &nbsp;&nbsp;&nbsp; <img src="{{ url(asset($userPic)) }}" alt="image"
                                style="max-width: 50px; border-radius: 50% ;">
                        @endif
                        <br>
                        <span style="cursor: pointer;" onclick="location.reload();" class="badge badge-success"> Refresh
                            Wallet</span>
                    </div>
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    {{-- <div class="item">
                        <a href="{{ route('addBalance.userApp') }}">
                            <div class="icon-wrapper ">
                                <ion-icon name="add-outline"></ion-icon>
                            </div>
                            <strong>Add Balance</strong>
                        </a>
                    </div> --}}
                    <div class="item">
                        <a href="{{ route('myPackagesList.userApp') }}">
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="bar-chart-outline"></ion-icon>
                            </div>
                            <strong>My Packages</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="{{ route('downlines.userApp') }}">
                            <div class="icon-wrapper bg-secondary">
                                <ion-icon name="git-pull-request-outline"></ion-icon>
                            </div>
                            <strong>My Down Line</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#withdrawActionSheet">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            </div>
                            <strong>Withdraw</strong>
                        </a>
                    </div>

                    <div class="item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#walletTransfer">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="swap-vertical-outline"></ion-icon>
                            </div>
                            <strong>Wallet Transfer</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="{{ route('allTransactions.userApp') }}">
                            <div class="icon-wrapper bg-warning">
                                <ion-icon name="swap-vertical"></ion-icon>
                            </div>
                            <strong>All Transactions</strong>
                        </a>
                    </div>

                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <!-- Wallet Card -->


        <!-- DialogIconedSuccess -->
        <div class="modal fade dialogbox" id="DialogIconedSuccess" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-success">
                        <ion-icon name="checkmark-circle"></ion-icon>
                    </div>
                    <div class="modal-header">

                        <h5 class="modal-title"> Success</h5>

                    </div>
                    <div class="modal-body">
                        @if (session('success'))
                            {{ session('success') }}
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-bs-dismiss="modal">CLOSE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * DialogIconedSuccess -->


        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById('DialogIconedSuccess'));
                    myModal.show();
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                alert("{{ session('error') }}");
            </script>
        @endif


        <!-- Withdraw Action Sheet -->
        <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Withdraw Money Request</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">


                            @if ($errors->any())
                                <div class="alert alert-danger mb-1">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <form action="{{ route('withdrawMoney.userApp') }}" method="POST"
                                enctype="multipart/form-data" onsubmit="return confirm('Are you sure ?');">
                                @csrf

                                <input type="hidden" name="userId" value="{{ $userId }}">
                                <input type="hidden" name="userName" value="{{ $userName }}">
                                <input type="hidden" name="userPhone" value="{{ $userPhone }}">


                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addonb1">₹</span>
                                        <input min="0" max="{{ $userWallet ?? '0.00' }}" id="withdraw_req"
                                            name="withdraw_req" type="number" class="form-control"
                                            placeholder="Enter an amount" value="{{ old('withdraw_req') }}">
                                    </div>
                                </div>

                                <div class=" form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Withdraw</button>
                                </div>
                                {{-- data-bs-dismiss="modal" --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Withdraw Action Sheet -->


        <!-- Wallet Fund Transfer -->
        <div class="modal fade action-sheet" id="walletTransfer" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wallet Fund Transfer</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">


                            @if ($errors->any())
                                <div class="alert alert-danger mb-1">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <form class="introducer-section" action="{{ route('wallet.transfer.process') }}" method="POST"
                                enctype="multipart/form-data" onsubmit="return confirm('Are you sure ?');">
                                @csrf

                                <input type="hidden" name="userId" value="{{ $userId }}">
                                <input type="hidden" name="userName" value="{{ $userName }}">
                                <input type="hidden" name="userPhone" value="{{ $userPhone }}">


                                <div class="form-group basic">
                                    <label class="label">User Phone No</label>
                                    <div class="input-group mb-2">

                                        <input min="0" type="number" name="to_phone"
                                            class="form-control introducer_id mr-2" placeholder="Enter phone"
                                            value="{{ old('to_phone') }}">
                                        <button type="button" class="btn btn-primary introduceIDBtn">Search</button>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Verify User Name</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control introducer_name" name="to_introducer_name" readonly>
                                    </div>
                                </div>



                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addonb1">₹</span>
                                        <input min="0" max="{{ $userWallet ?? '0.00' }}" id="withdraw_req"
                                            name="withdraw_req" type="number" class="form-control"
                                            placeholder="Enter an amount" value="{{ old('withdraw_req') }}">
                                    </div>
                                </div>

                                <div class=" form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Transfer</button>
                                </div>
                                {{-- data-bs-dismiss="modal" --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *Wallet Fund Transfer -->


     <!-- Stats -->
     <div class="section">
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Invested Amount</div>
                    <div class="value text-success">₹ 552.95</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Total PIN  </div>
                   
                    <a href=""><div class="value text-primary ">₹ 86.45</div></a>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Wallet Balance</div>
                    <div class="value">₹ 53.25</div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-box">
                    <div class="title">Withdraw Balance</div>
                    <div class="value text-secondary">₹ 120.99</div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Stats -->








        {{-- <h1 class="text-center pt-2">All Super Packages </h1> --}}

        <style>
            .card-bg-images {
                background-image: url('{{ url('userApp/assets/goldBg.webp') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                border-radius: 12px;
                /* optional */
                padding: 20px;
                /* adjust if needed */
                color: #000;
                /* optional if you want white text */

            }

            .bottom,
            .card-number,
            .balance,
            .card-main,
            .title,
            .label,
            .card-expiry,
            .card-ccv {
                font-weight: 700 !important;
                color: #000 !important;
            }
        </style>







        <style>
            /* Base Button Style */
            .btn-gold-animated {
                position: relative;
                display: inline-block;
                padding: 12px 50px;
                border: none;
                border-radius: 12px;
                background-image: url('{{ url('userApp/assets/goldBuy.webp') }}');
                background-size: cover;
                background-position: center;
                color: #000;
                font-weight: bold;
                overflow: hidden;
                z-index: 1;
                transition: transform 0.2s ease, box-shadow 0.3s ease-in-out;
                text-transform: uppercase;
            }

            /* Glowing Shadow Effect */
            .btn-gold-animated {
                box-shadow: 0 0 8px rgba(255, 193, 7, 0.6), 0 0 20px rgba(255, 193, 7, 0.4);
            }

            /* Button Hover Effect (Neon Glow on Hover) */
            .btn-gold-animated:hover {
                transform: scale(1.02);
                box-shadow: 0 0 15px rgba(255, 215, 0, 1), 0 0 25px rgba(255, 215, 0, 0.8);
                /* Stronger glow on hover */
            }

            /* Inner text stays above the animated border */
            .btn-gold-animated .btn-text {
                position: relative;
                z-index: 2;
                animation: pulseText 2s ease-in-out infinite;
                /* Pulsing text animation */
            }

            /* Pulsing Text Effect */
            @keyframes pulseText {
                0% {
                    text-shadow: 0 0 6px rgba(255, 193, 7, 0.5);
                    transform: scale(1);
                }

                50% {
                    text-shadow: 0 0 12px rgba(255, 193, 7, 1);
                    transform: scale(1.1);
                }

                100% {
                    text-shadow: 0 0 6px rgba(255, 193, 7, 0.5);
                    transform: scale(1);
                }
            }

            /* Animated border using pseudo-elements */
            .btn-gold-animated::before,
            .btn-gold-animated::after {
                content: '';
                position: absolute;
                border-radius: 30px;
                inset: 0;
                padding: 2px;
                /* border thickness */
                background: linear-gradient(135deg, cyan, white, cyan);
                -webkit-mask:
                    linear-gradient(#fff 0 0) content-box,
                    linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                animation: rotate-border 3s linear infinite;
                z-index: 1;
            }

            /* Optional overlay on hover */
            .btn-gold-animated::after {
                animation-delay: 1.5s;
                opacity: 0.4;
            }

            /* Animation keyframes */
            @keyframes rotate-border {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>



        <style>
            .totalAmountAnimated {
                position: relative;
                display: inline-block;
                padding: 4px 12px;
                font-weight: bold;
                font-size: 1.2rem;
                color: #000;
                /* Keeps the text readable */
                background: linear-gradient(90deg, #ffe082, #ffe082, #fff8e1);
                background-size: 200% 100%;
                border-radius: 8px;
                animation:
                    blinkEffect 1.5s steps(2, start) infinite,
                    pulseGlow 2.5s ease-in-out infinite,
                    shimmerBg 3s linear infinite;

                /* Outer glow (shadow) */
                box-shadow:
                    0 0 10px rgba(255, 193, 7, 0.6),
                    0 0 20px rgba(255, 193, 7, 0.5),
                    0 0 30px rgba(255, 193, 7, 0.4);
            }

            /* Blinking effect (opacity toggle) */
            @keyframes blinkEffect {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.9;
                }
            }

            /* Glowing text shadow */
            @keyframes pulseGlow {
                0% {
                    text-shadow: 0 0 6px rgba(255, 193, 7, 0.5);
                }

                50% {
                    text-shadow: 0 0 15px rgba(255, 193, 7, 1);
                }

                100% {
                    text-shadow: 0 0 6px rgba(255, 193, 7, 0.5);
                }
            }

            /* Background shimmer animation */
            @keyframes shimmerBg {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }
        </style>

        <style>
            .card-bg-golden {
                position: relative;
                padding: 24px;
                border-radius: 16px;
                color: #000;
                /* Black or dark text for contrast */
                background: linear-gradient(135deg, #d9ff00, #ffd54f, #fff8e1);
                background-size: 400% 400%;
                animation: shimmerGold 6s ease-in-out infinite, blinkGold 2s steps(2, start) infinite;

                /* Outer glowing box shadow */
                box-shadow:
                    0 0 10px rgba(255, 215, 0, 0.4),
                    0 0 20px rgba(255, 215, 0, 0.3),
                    0 0 40px rgba(255, 215, 0, 0.2);
            }

            /* Text glow inside the card */
            /* .card-bg-golden h1,
            .card-bg-golden .title,
            .card-bg-golden .label,
            .card-bg-golden span,
            .card-bg-golden p {
                text-shadow: 0 0 6px rgba(255, 215, 0, 0.6);
            } */

            /* Shimmer animation for background */
            @keyframes shimmerGold {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            /* Subtle blinking */
            @keyframes blinkGold {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.95;
                }
            }
        </style>




        <!-- Stats -->
        <div class="section  " style="display: none;">

            <div class="row mt-3 ">


                @foreach ($appPackages as $index => $appPackage)
                    <!-- card block -->
                    <div class="card-block card-bg-images mb-3">
                        <div class="card-main">
                            <div class="card-button ">

                                {{-- <form action="{{ route('package.buy') }}" method="POST"
                                   onsubmit="return validatePackagePurchase({{ $appPackage->id }}, {{ $hasBoughtPackage1 ? 'true' : 'false' }});">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $appPackage->id }}">
                                    <button type="submit" class="btn btn-lg btn-gold-animated ">
                                        Gold Buy
                                    </button>
                                </form> --}}
                                <form action="{{ route('package.buy') }}" method="POST"
                                    onsubmit="return validatePackagePurchase(
                                            {{ $appPackage->id }},
                                            {{ $hasBoughtPackage1 ? 'true' : 'false' }},
                                            '{{ addslashes($appPackage->package_name) }}',
                                            {{ $appPackage->package_amount }}
                                        );">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $appPackage->id }}">
                                    <button type="submit" class="btn btn-lg btn-gold-animated">Gold Buy</button>
                                </form>


                            </div>


                            <div class="balance">
                                <span class="label">Package Name</span>
                                <h1 class="title">{{ $appPackage->package_name }}</h1>
                            </div>

                            <div class="in">
                                <div class="card-number">
                                    <span class="label">Package Amount</span>
                                    ₹ {{ $appPackage->package_amount }}
                                    <br>
                                    <span class="label">Get Total Amount</span>
                                    <span class="totalAmountAnimated"> ₹ {{ $appPackage->package_total_amount }}</span>
                                </div>

                                <div class="bottom">
                                    <div class="card-expiry">
                                        <span class="label">Package %</span>
                                        {{ $appPackage->package_payout_per }}%
                                    </div>
                                    <div class="card-ccv">
                                        <span class="label">Time Duration</span>
                                        {{ $appPackage->package_time_duration }} min
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- * card block -->
                @endforeach

            </div>

            <script>
                function validatePackagePurchase(packageId, hasBoughtPackage1, packageName, packageAmount) {

                    if (packageId == 1 && hasBoughtPackage1) {
                        alert("❌ You have already bought " + packageName + ". It can only be purchased once.");
                        return false;
                    }

                    if (packageId != 1 && !hasBoughtPackage1) {
                        alert("⚠️ Please buy Package 1 first before purchasing " + packageName + ".");
                        return false;
                    }

                    return confirm(
                        "Are you sure you want to buy " +
                        packageName +
                        " for ₹" + packageAmount.toFixed(2) + "?"
                    );
                }
            </script>




        </div>
        <!-- * Stats -->





    </div>
    <!-- * App Capsule -->




    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">



                            @if ($userPic)
                                <img src="{{ asset($userPic) }}" alt="image" class="imaged  w36">
                            @endif
                        </div>
                        <div class="in">
                            @if ($userName)
                                {{-- <h3>Welcome, </h3> --}}
                                <strong>{{ $userName }}</strong>
                            @endif

                            @if ($userPhone)
                                <div class="text-muted">{{ $userPhone }}</div>
                            @endif

                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    <div class="sidebar-balance">
                        <div class="listview-title">Balance</div>
                        <div class="in">
                            {{-- @if ($userWallet)
                       <h1 class="total" id="totalWallet">₹ {{ $userWallet ?? '0.00' }}</h1>

                        @endif --}}

                            <h1 class="total" id="totalWallet" style="color: #fff">₹
                                {{ number_format($userWallet ?? 0, 2) }}</h1>



                        </div>
                    </div>
                    <!-- * balance -->

                    {{-- <!-- action group -->
                <div class="action-group">
                    <a href="index.html.htm" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="add-outline"></ion-icon>
                            </div>
                            Deposit
                        </div>
                    </a>
                    <a href="index.html.htm" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            </div>
                            Withdraw
                        </div>
                    </a>
                    <a href="index.html.htm" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="arrow-forward-outline"></ion-icon>
                            </div>
                            Send
                        </div>
                    </a>
                    <a href="app-cards.html.htm" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                            My Cards
                        </div>
                    </a>
                </div>
                <!-- * action group --> --}}

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
                    <ul class="listview image-listview text inset no-line">


                        <li>
                            <div class="item">
                                <div class="in">
                                    <div>
                                        Dark Mode
                                    </div>
                                    <div class="form-check form-switch  ms-2">
                                        <input class="form-check-input dark-mode-switch" type="checkbox"
                                            id="darkmodeSwitch">
                                        <label class="form-check-label" for="darkmodeSwitch"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="{{ route('downlines.userApp') }}" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="git-pull-request-outline"></ion-icon>
                                </div>

                                <div class="in">
                                    Down Lines
                                </div>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Update Password
                                  
                                </div>
                            </a>
                        </li> --}}

                        <li>
                            <a href="#" class="item" data-bs-toggle="modal"
                                data-bs-target="#updatePasswordModal">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="in">Update Details</div>
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('logoutUserApp.userApp') }}" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>

                                <div class="in">
                                    Log out
                                </div>
                            </a>
                        </li>

                    </ul>
                    <!-- * menu -->



                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->









    <!-- Update Password and Bank Details Modal -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Password & Bank Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="updatePasswordForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Password Fields -->
                        <div class="form-group mb-2">
                            <label for="new_password">New Password</label>
                            <input type="text" class="form-control" id="new_password" name="new_password">
                        </div>

                        <div class="form-group mb-2">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="text" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <!-- Bank Details -->
                        <div class="form-group mb-2">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank_name">
                        </div>

                        <div class="form-group mb-2">
                            <label>IFSC Code</label>
                            <input type="text" class="form-control" name="ifsc_code">
                        </div>

                        <div class="form-group mb-2">
                            <label>Bank Account Number</label>
                            <input type="text" class="form-control" name="bank_account_no">
                        </div>

                        <div class="form-group mb-2">
                            <label>UPI ID</label>
                            <input type="text" class="form-control" name="upi_id">
                        </div>

                        <div class="form-group mb-2">
                            <label>UPI QR Code (Image)</label>
                            <input type="file" class="form-control" name="upi_qr_code" accept="image/*">
                        </div>

                        <div class="form-group mb-2">
                            <label>User Profile Pic (Optional)</label>
                            <input type="file" class="form-control" name="user_pic_img" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>

                    <div id="passwordUpdateMsg" class="mt-3 text-center"></div>
                </div>

            </div>
        </div>
    </div>







    <script>
        document.getElementById('updatePasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const messageBox = document.getElementById('passwordUpdateMsg');
            messageBox.innerHTML = '⏳ Updating...';

            fetch('{{ route('user.password.update') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        messageBox.innerHTML = `<span class="text-success">✅ ${data.message}</span>`;
                        if (data.redirect) {
                            localStorage.setItem('success_flash', data.password_message);
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 800);
                        }
                    } else {
                        messageBox.innerHTML = `<span class="text-danger">❌ ${data.message}</span>`;
                    }
                })
                .catch(() => {
                    messageBox.innerHTML = `<span class="text-danger">Something went wrong.</span>`;
                });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.introduceIDBtn').click(function() {
                var section = $(this).closest('.introducer-section');
                var id = section.find('.introducer_id').val();

                if (id) {
                    $.get('/get-introducer/' + id, function(data) {
                        if (data && data.name) {
                            section.find('.introducer_id_hidden').val(data.introducer_id_hidden);
                            section.find('.introducer_name').val(data.name);
                            section.find('.wallet_bal').val(data
                            .wallet_bal); // optional if you add input
                            section.find('.introducer_address').val(data.address); // optional

                          
                        } else {
                            alert('Introducer not found');
                        }
                    }).fail(function() {
                        alert('Something went wrong');
                    });
                } else {
                    alert('Please enter Introducer ID');
                }
            });
        });
    </script>


@endsection
