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

           

           






          <form role="form" method="POST" action="{{ url('/member-join') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <p class="from-top-header">Member Information</p>
                        <div class="row">

                            <!-- Introducer Section -->
                            <div class="form-group col-md-4">
                                <label> Enter Introduce ID or Phone</label>
                                <div style="display: flex;">
                                    <input type="number"  id="introducer_id"
                                        class="form-control">
                                    <input type="hidden" name="introducer_id_hidden" id="introducer_id_hidden">
                                    <button type="button" id="introduceIDBtn"
                                        class="btn btn-primary">Search</button>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Introducer Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="introducer_name" id="introducer_name"
                                    readonly>

                            </div>

                            <div class="form-group col-md-4">
                                <label>Introducer Phone No</label>
                                <input type="text" class="form-control" name="introducer_phone" id="introducer_phone"
                                    readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Introducer Full Address</label>
                                <input type="text" class="form-control" name="introducer_address"
                                    id="introducer_address" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="radio">
                                    <label><input type="radio" id="position_left" name="position" value="Left" checked>
                                        Position Left</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" id="position_right" name="position" value="Right">
                                        Position Right</label>
                                </div>
                            </div>
                        </div>


                        <p class="from-top-header">Plan Information</p>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Select Plan*</label>
                                <select name="select_plan_id" class="form-control" required>
                                    <option disabled selected>Select Plan</option>
                                    @foreach($memberJoinDropDpwn as $plan)
                                    <option value="{{ $plan->select_plan_id }}" data-name="{{ $plan->select_plan }}">
                                        {{ $plan->select_plan }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="select_plan_name" id="select_plan_name" value="">
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const select = document.querySelector('[name="select_plan_id"]');
                                    const hiddenInput = document.getElementById('select_plan_name');

                                    select.addEventListener('change', function () {
                                        const selected = select.options[select.selectedIndex];
                                        hiddenInput.value = selected.getAttribute('data-name');
                                    });
                                });
                            </script>
                        </div>

                        <!-- Member Section -->
                        <p class="from-top-header">Member Information</p>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Member ID<sup>*</sup></label>
                                <input type="text" class="form-control" value="MUM/{{ $nextId }}" readonly>

                                <!-- Hidden field to store real value -->
                                <input type="hidden" name="member_id" value="{{ $nextId }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Phone No<sup>*</sup></label>
                                <input type="number" class="form-control" name="phone" value="{{ old('phone') }}"
                                    required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Full Address<sup>*</sup></label>
                                <input type="text" class="form-control" name="address" 
                                    value="{{ old('address') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Pin Code<sup>*</sup></label>
                                <input type="number" class="form-control" name="pincode" 
                                    value="{{ old('pincode') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>State<sup>*</sup></label>
                                <input type="text" class="form-control" name="state" 
                                    value="{{ old('state') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>District<sup>*</sup></label>
                                <input type="text" class="form-control" name="district" 
                                    value="{{ old('district') }}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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