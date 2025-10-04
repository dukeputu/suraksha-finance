@php
    use Illuminate\Support\Facades\DB;

    $balanceRequest = DB::table('user_balance_request')
        ->where('app_user_id', session('app_user_id'))
        ->orderByDesc('id')
        ->first();
@endphp

@if ($balanceRequest && $balanceRequest->status == 2)
    <center>
        <h2 style="margin-top: 30px;">⏳ Your request is under review. Please wait for approval.</h2>
    </center>
    @php exit; @endphp
@elseif ($balanceRequest && $balanceRequest->status == 1)
    @php
        header('Location: ' . route('dashboard.app'));
        exit();
    @endphp
@endif


{{-- Dashboard content goes here if no pending request --}}


@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')




    <!-- App Header -->
    <div class="appHeader">







        <div class="left">
            {{-- <a href="{{route('dashboard.app')}}" class="headerButton ">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a> --}}
        </div>
        <div class="pageTitle">
            Buy A Plan


        </div>

    </div>
    <!-- * App Header -->

    <br>
    <br>



    <h1 class="text-center pt-2"> Buy A Plan</h1>

    <div class="section mt-2">

        <div class="card">
            <div class="card-body">

                @php
                    $userId = session('app_user_id');
                    $userName = session('app_user_name');
                    $userPhone = session('app_user_phone');
                @endphp

                @if (session('success'))
                    <div class="alert alert-primary mb-1">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-1">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('userAddBalance.userApp') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="userId" value="{{ $userId }}">
                    <input type="hidden" name="userName" value="{{ $userName }}">
                    <input type="hidden" name="userPhone" value="{{ $userPhone }}">

                    <div class="card">
                        <div class="card-body">
                           

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label>Select Plan*</label>
                                    <select name="select_plan_id" class="form-control" required>
                                        <option disabled selected>Select Plan</option>
                                        @foreach ($memberJoinDropDpwn as $plan)
                                            <option value="{{ $plan->select_plan_id }}"
                                                data-amount="{{ $plan->plan_amount }}">
                                                {{ $plan->select_plan }} ₹{{ $plan->plan_amount }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="add_balance_amount" id="add_balance_amount" value="">
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const select = document.querySelector('[name="select_plan_id"]');
                                    const hiddenInput = document.getElementById('add_balance_amount');

                                    select.addEventListener('change', function() {
                                        const selectedOption = select.options[select.selectedIndex];
                                        hiddenInput.value = selectedOption.getAttribute('data-amount');
                                    });
                                });
                            </script>


                            <h3 class="text-center pt-2">Upload Payment ScreenShot</h3>

                            <div class="custom-file-upload" id="fileUpload1">
                                <input type="file" id="fileuploadInput" accept=".png, .jpg, .jpeg"
                                    name="payment_screenShot">
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                            <i>Upload Payment ScreenShot</i>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <br><br><br>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Submit</button>
                    </div>
                    <br><br><br><br>
                </form>

            </div>
        </div>

    </div>


    <div class="section mt-5 mb-4">

        <div class="card">
            <div class="card-body">
                <h4>Company Payment Details</h4>

                @if ($warningMessage)
                    <div class="alert alert-danger mb-1">
                        {{ $warningMessage }}
                    </div>
                @endif



                @foreach ($membersBankDetails as $bankDetails)
                    <div>
                        @if (!empty($bankDetails->BankName))
                            <strong>Bank Name : {{ $bankDetails->BankName }}</strong><br>
                        @endif

                        @if (!empty($bankDetails->BankIFSC))
                            <strong>Bank IFSC Code: {{ $bankDetails->BankIFSC }}</strong><br>
                        @endif

                        @if (!empty($bankDetails->name))
                            <strong>AC Holder Name : {{ $bankDetails->name }}</strong><br>
                        @endif

                        @if (!empty($bankDetails->BankACNo))
                            <strong>Bank AC. No : {{ $bankDetails->BankACNo }}</strong><br>
                        @endif

                        @if (!empty($bankDetails->upiId))
                            <strong>UPI Id : {{ $bankDetails->upiId }}</strong><br>
                        @endif

                        @if (!empty($bankDetails->qrCodeUpload))
                            <strong>UPI QR Code 👇</strong><br><br>
                            <center class="mb-1">
                                <img src="{{ url(asset($bankDetails->qrCodeUpload)) }}" class="imaged w200">
                            </center>
                        @endif
                    </div>
                @endforeach


            </div>
        </div>


    </div>


@endsection
