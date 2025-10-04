@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')

    <style>
        .from-top-header {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            background: #6236FF;
            color: #fff;
            display: block;
            border-radius: 20px;
        }

        .appBottomMenu {
            display: none;
        }

        .form-group.basic .form-control,
        .form-group.basic .custom-select {
            padding: 0 15px 0 15px;
            border-radius: 10px;
            background: #f1f1f1;

        }
    </style>

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="{{ url()->previous() }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="{{ route('userLogin.app') }}" class="headerButton">
                Login
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 text-center">
            <h1>Register now</h1>
            <h4>Create an account</h4>
        </div>
        <div class="section mb-5 p-2">
            @if (session('success'))
                <div class="flash-message flash-success">
                    {{ session('success') }}
                    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            @endif

            @if (session('error') || $errors->any())
               

                <div class="alert alert-outline-danger mb-1" role="alert">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
            @endif



            <form action="{{ route('registerUserApp.userApp') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <p class="from-top-header">Member Information</p>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="user_name">Name</label>
                                <input required type="text" class="form-control" id="user_name" name="user_name"
                                    value="{{ old('user_name') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="phone_number">Phone Number <sup>(Phone Number Is User
                                        Name)</sup></label>
                                <input required type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>



                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="user_email">Email</label>
                                <input type="text" class="form-control" id="user_email" name="user_email"
                                    value="{{ old('user_email') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>



                        <div class="custom-file-upload" id="fileUpload1">
                            <input type="file" id="profile_picture" accept=".png, .jpg, .jpeg" name="profile_picture">
                            <label for="profile_picture">
                                <span>
                                    <strong>
                                        <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                        <i>Profile Picture</i>
                                    </strong>
                                </span>
                            </label>
                        </div>



                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="address">Address</label>
                                <input required type="text" class="form-control" id="user_address" name="user_address"
                                    value="{{ old('user_address') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="pin_code">Pin Code</label>
                                <input required type="text" class="form-control" id="pin_code" name="pin_code"
                                    value="{{ old('pin_code') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <p class="from-top-header">Bank Information</p>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name"
                                    value="{{ old('bank_name') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="fice_code">IFSC Code</label>
                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                    value="{{ old('ifsc_code') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="bank_account_no">Bank Account No</label>
                                <input type="text" class="form-control" id="bank_account_no" name="bank_account_no"
                                    value="{{ old('bank_account_no') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="upi_id">UPI Id</label>
                                <input type="text" class="form-control" id="upi_id" name="upi_id"
                                    value="{{ old('upi_id') }}">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>


                        <div class="custom-file-upload" id="fileUpload2">
                            <input type="file" id="upi_qr_code" accept=".png, .jpg, .jpeg" name="upi_qr_code">
                            <label for="upi_qr_code">
                                <span>
                                    <strong>
                                        <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                        <i>UPI QR Code</i>
                                    </strong>
                                </span>
                            </label>
                        </div>
                        <br>
                        <p class="from-top-header">Introducer Information</p>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="label" for="introducer_number">Introducer ID <sup>(Phone
                                                        Number Is
                                                        Introducer ID)</sup></label>
                                                <input type="number" class="form-control" id="introducer_id"
                                                    name="introducer_number" value="{{ old('introducer_number') }}">

                                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                            </div>
                                            <div class="col-6">

                                                <button type="button" id="introduceIDBtn" class="btn btn-primary">Search
                                                    Name</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4 my-3">
                                        <label class="label" for="introducer_name">Introducer Name </label>
                                        <input type="text" class="form-control" name="introducer_name"
                                            id="introducer_name" readonly style=" background: #b3ff00; " value="">
                                    </div>
                                    <div class="col-md-4 my-3">
                                        <label class="label" for="select_plan_name">Introducer Position </label>
                                        <input type="text" class="form-control" name="select_plan_name"
                                            id="select_plan_name" readonly style=" background: #b3ff00; " value="">

                                        <input type="hidden" class="form-control" name="select_plan_id"
                                            id="select_plan_id" readonly style=" background: #b3ff00; " value="">
                                    </div>
                                </div>
                            </div>
                        </div>





                        {{-- <div class="custom-control custom-checkbox mt-2 mb-1">
                        <div class="form-check">
                            <input required type="checkbox" class="form-check-input" id="customCheckb1">
                            <label class="form-check-label" for="customCheckb1">
                                I agree <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and
                                    conditions</a>
                            </label>
                        </div>
                    </div> --}}
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Register</button>
                </div>
            </form>



        </div>

    </div>
    <!-- * App Capsule -->


    <!-- Terms Modal -->
    <div class="modal fade modalbox" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms and Conditions</h5>
                    <a href="#" data-bs-dismiss="modal">Close</a>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, urna eget finibus
                        fermentum, velit metus maximus erat, nec sodales elit justo vitae sapien. Sed fermentum
                        varius erat, et dictum lorem. Cras pulvinar vestibulum purus sed hendrerit. Praesent et
                        auctor dolor. Ut sed ultrices justo. Fusce tortor erat, scelerisque sit amet diam rhoncus,
                        cursus dictum lorem. Ut vitae arcu egestas, congue nulla at, gravida purus.
                    </p>
                    <p>
                        Donec in justo urna. Fusce pretium quam sed viverra blandit. Vivamus a facilisis lectus.
                        Nunc non aliquet nulla. Aenean arcu metus, dictum tincidunt lacinia quis, efficitur vitae
                        dui. Integer id nisi sit amet leo rutrum placerat in ac tortor. Duis sed fermentum mi, ut
                        vulputate ligula.
                    </p>
                    <p>
                        Vivamus eget sodales elit, cursus scelerisque leo. Suspendisse lorem leo, sollicitudin
                        egestas interdum sit amet, sollicitudin tristique ex. Class aptent taciti sociosqu ad litora
                        torquent per conubia nostra, per inceptos himenaeos. Phasellus id ultricies eros. Praesent
                        vulputate interdum dapibus. Duis varius faucibus metus, eget sagittis purus consectetur in.
                        Praesent fringilla tristique sapien, et maximus tellus dapibus a. Quisque nec magna dapibus
                        sapien iaculis consectetur. Fusce in vehicula arcu. Aliquam erat volutpat. Class aptent
                        taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- * Terms Modal -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if ($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif
    </script>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => {
                el.style.transition = "opacity 0.5s";
                el.style.opacity = 0;
                setTimeout(() => el.style.display = 'none', 500);
            });
        }, 4000);
    </script>



    <script>
        $(document).ready(function() {
            $('#introduceIDBtn').click(function() {
                // $('#introducer_id').focusout(function() {
                var id = $('#introducer_id').val();

                if (id) {
                    $.get('/get-introducer/' + id, function(data) {
                        if (data && data.name) {
                            $('#introducer_id_hidden').val(data.introducer_id_hidden);
                            $('#introducer_name').val(data.name);
                            $('#select_plan_name').val(data.select_plan_name);
                            $('#select_plan_id').val(data.select_plan_id);

                            // Set Position radio button
                            if (data.position === 'Left') {
                                $('#position_left').prop('checked', true);
                            } else if (data.position === 'Right') {
                                $('#position_right').prop('checked', true);
                            }
                        } else {
                            alert('Introducer not found');
                        }
                    }).fail(function() {
                        alert('Something went wrong');
                    });
                } else {
                    // alert('Please enter Introducer ID');
                }
            });
        });
    </script>


@endsection
