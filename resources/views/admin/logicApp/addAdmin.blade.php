@extends('layouts.app')
@section('title', 'Company')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                @if (session('success'))
                <div class="flash-message flash-success">
                    {{ session('success') }}
                    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
                @endif

                @if (session('error') ||$errors->any())
                <div class="flash-message flash-error">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach

                        <li>{{ session('error') }}</li>
                    </ul>
                    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
                @endif


                <form role="form" method="POST"
                    action="{{ $isEdit ? route('addAdmin.adminUpdate', $company->id) : route('addAdmin.adminStore') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="box-body">
                        <p class="from-top-header">Company Information</p>
                        <div class="row">

                            {{-- Member ID hidden --}}
                            <input type="hidden" name="member_id" value="{{ $nextId }}">

                            <div class="form-group col-md-4">
                                <label>Company Name<sup>*</sup></label>
                                <input type="text" name="CompanyName" class="form-control"
                                    value="{{ old('CompanyName', $company->name ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Phone No<sup>*</sup></label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $company->phone ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $company->email ?? '') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Full Address<sup>*</sup></label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $company->address ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>State<sup>*</sup></label>
                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $company->state ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Pin Code<sup>*</sup></label>
                                <input type="text" name="pincode" class="form-control"
                                    value="{{ old('pincode', $company->pincode ?? '') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>CIN No<sup>*</sup></label>
                                <input type="text" name="cin_no" class="form-control"
                                    value="{{ old('cin_no', $company->cin_no ?? '') }}" required>
                            </div>

                            @if(isset($company))
                            <div class="form-group col-md-4">
                                <label>Password <small>(Default password is- abc11 If need change then do )</small></label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status<sup>*</sup></label>
                                <select name="company_status" class="form-control" required>
                                    <option disabled="" selected="">Company List</option>
                                    <option value="1" {{ $company->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $company->status == 2 ? 'selected' : '' }}>Deactive</option>
                                    <option value="3" {{ $company->status == 3 ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        @endif


                        </div>

                        <p class="from-top-header">Bank Information</p>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label>Bank Name<sup>*</sup></label>
                                <input type="text" name="BankName" class="form-control"
                                    value="{{ old('BankName', $company->BankName ?? '') }}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bank AC No.<sup>*</sup></label>
                                <input type="text" name="BankACNo" class="form-control"
                                    value="{{ old('BankACNo', $company->BankACNo ?? '') }}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bank IFSC<sup>*</sup></label>
                                <input type="text" name="BankIFSC" class="form-control"
                                    value="{{ old('BankIFSC', $company->BankIFSC ?? '') }}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>UPI ID<sup>*</sup></label>
                                <input type="text" name="upiId" class="form-control"
                                    value="{{ old('upiId', $company->upiId ?? '') }}" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>UPI QR Code<sup>*</sup></label>
                                @if($isEdit && !empty($company->qrCodeUpload))
                                <div>
                                    <a target="_blank" href="{{ url($company->qrCodeUpload) }}">
                                         <img src="{{ asset($company->qrCodeUpload) }}" alt="" width="100" required>
                                        </a>
                                   <span> <small> 👈 Click to Big View </small></span>
                                </div>
                                @endif
                                <input type="file" name="qrCodeUpload" class="form-control">
                            </div>




                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>








            </div><!-- /.box -->



        </div>

    </div>
</section><!-- /.content -->







</div><!-- /.content-wrapper -->




@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if ($errors -> any())
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
    $(document).ready(function () {
        $('#introduceIDBtn').click(function () {
            // $('#introducer_id').focusout(function () {
            var id = $('#introducer_id').val();

            if (id) {
                $.get('/get-introducer/' + id, function (data) {
                    if (data && data.name) {
                        $('#introducer_id_hidden').val(data.introducer_id_hidden);
                        $('#introducer_name').val(data.name);
                        $('#introducer_phone').val(data.phone);
                        $('#introducer_address').val(data.address);

                        // Set Position radio button
                        if (data.position === 'Left') {
                            $('#position_left').prop('checked', true);
                        } else if (data.position === 'Right') {
                            $('#position_right').prop('checked', true);
                        }
                    } else {
                        alert('Introducer not found');
                    }
                }).fail(function () {
                    alert('Something went wrong');
                });
            } else {
                // alert('Please enter Introducer ID');
            }
        });
    });
</script>