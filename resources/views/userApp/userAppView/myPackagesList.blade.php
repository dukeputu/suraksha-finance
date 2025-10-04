@php
$userId = session('app_user_id');
$userName = session('app_user_name');
$userPhone = session('app_user_phone');
$userPic = session('app_user_photo');
$userWallet = session('app_user_wallet');

// dd($userPic);
// exit;
/*

@if($userPic)
<img src="{{ url(asset($userPic))}}" alt="image" class="imaged w32">
@endif
*/
@endphp

@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')

<style>
    .card-block {
        height: 16rem;
    }
</style>

<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="{{route('dashboard.app')}}" class="headerButton ">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        Packages List


    </div>

</div>
<!-- * App Header -->
<br>





<!-- App Capsule -->
<div id="appCapsule">


    <h1 class="text-center pt-2">My Super Packages </h1>

    <!-- Stats -->
    <div class="section  ">

        <div class="row mt-3 ">

{{-- 
 @foreach($appPackages as $appPackage)
            <div class="card shadow-sm mb-3 border-{{ $appPackage->type_id == 2 ? 'primary' : 'success' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">{{ $appPackage->package_name ?? 'Package' }}</h5>
                        <span class="badge bg-{{ $appPackage->type_id == 2 ? 'primary' : 'success' }}">
                            {{ $appPackage->type_name }}
                        </span>

                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Status: {{ $appPackage->status }}</small><br>
                            
                            @if($appPackage->done_at)
                            <small>Done: {{ \Carbon\Carbon::parse($appPackage->done_at)->format('d M Y h:i A')
                                }}</small><br>
                            @endif

                            <small>Requested: {{ \Carbon\Carbon::parse($appPackage->requested_at)->format('d M Y h:i A')
                                }}</small><br>
                        </div>
                        <div>
                            <div class="col">
                                <div class="text-muted">Amount</div>
                                <strong class="{{ $appPackage->type_id == 2 ? 'text-danger' : 'text-success' }}">
                                    {{ $appPackage->type_id == 2 ? 'Dr' : 'Cr' }} ₹{{ number_format($appPackage->amount,
                                    2) }}
                                </strong>
                            </div>
                        </div>
                    </div>


                    <hr class="my-2">

                    <div class="row text-center">
                        <div class="col">
                            <div class="text-muted">Wallet Before</div>
                            <strong class="text-danger">₹{{ number_format($appPackage->wallet_before, 2) }}</strong>
                        </div>

                        <div class="col">
                            <div class="text-muted">Wallet After</div>
                            <strong class="text-success">₹{{ number_format($appPackage->wallet_after, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
 @endforeach --}}


 @foreach($appPackages as $pkg)
    <div class="card mb-3 shadow-sm border-left-{{ $pkg->type_id == 2 ? 'primary' : 'success' }}">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">
                    <span class="badge badge-{{ $pkg->type_id == 2 ? 'primary' : 'success' }}">
                        {{ $pkg->type_name }}
                    </span>
                </h5>
                <h5 class="mb-0 {{ $pkg->type_id == 3 ? 'text-success' : 'text-danger' }}">
                    ₹{{ number_format($pkg->amount, 2) }}
                    <span class="text-muted small">{{ $pkg->type_id == 2 ? 'Dr' : 'Cr' }}</span>
                </h5>
            </div>
<div class="d-flex justify-content-between align-items-center mt-2">
@if($pkg->type_id == 2)
            <div class="">
                <strong class="d-block">📦 Package Details:</strong>
                <small><strong>Name:</strong> {{ $pkg->package_name }}</small><br>
                <small><strong>Package Amount:</strong> ₹{{ number_format($pkg->package_amount, 2) }}</small><br>
                <small><strong>Get Total Amount:</strong> ₹{{ number_format($pkg->package_total_amount, 2) }}</small><br>
                <small><strong>Package %:</strong> {{ $pkg->package_payout_per }}%</small><br>
                <small><strong>Time Duration:</strong> {{ $pkg->package_time_duration }} min</small>
            </div>
            @endif


     <p class="">
        
                <strong>Status:</strong>
                <span class="badge badge-{{ $pkg->status == 'Done' ? 'success' : 'warning' }}">
                    {{ $pkg->status }}
                </span>
               
                <br>
                <strong>Wallet Before:</strong> ₹{{ number_format($pkg->wallet_before, 2) }}<br>
                <strong>Wallet After:</strong> ₹{{ number_format($pkg->wallet_after, 2) }}<br>
                <strong>Requested:</strong> {{ \Carbon\Carbon::parse($pkg->requested_at)->format('d-m-Y h:i A') }}<br>
                @if($pkg->done_at)
                    <strong>Done At:</strong> {{ \Carbon\Carbon::parse($pkg->done_at)->format('d-m-Y h:i A') }}
                @endif
            </p>

</div>
       
        </div>
    </div>
@endforeach





        </div>




    </div>
    <!-- * Stats -->





</div>
<!-- * App Capsule -->












@endsection