@extends('layouts.app')
@section('title', 'Package Master')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">

                @if (session('success'))
                <div class="flash-message flash-success">
                    {{ session('success') }}
                    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
                @endif

                @if ($errors->any())
                <div class="flash-message flash-error">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
                @endif

                <form role="form" method="POST" action="{{ route('packageMaster.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <p class="from-top-header">Package Master</p>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Package Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="package_name"
                                    value="{{ old('package_name') }}" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Package Amount<sup>*</sup></label>
                                <input min="1" type="number" class="form-control packageAmount" name="package_amount"
                                    value="{{ old('package_amount') }}" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Package %<sup>*</sup></label>
                                <input min="1" type="number" class="form-control packagePer" name="package_payout_per"
                                    value="{{ old('package_payout_per') }}" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Total Amount<sup>*</sup></label>
                                <input min="1" readonly type="number" class="form-control totalAmount"
                                    name="package_total_amount" value="{{ old('package_total_amount') }}" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Time Duration in Min <sup>1 Day = 24 x 60 = 1440 min </sup> <sup>*</sup></label>
                                <input min="1" type="number" class="form-control" name="package_time_duration"
                                    value="{{ old('package_time_duration') }}" required>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>



                <script>
                    document.addEventListener("input", () => {
                        const packageAmount = parseFloat(document.querySelector(".packageAmount")?.value) || 0;
                        const packagePer = parseFloat(document.querySelector(".packagePer")?.value) || 0;
                        //   document.querySelector(".totalAmount").value = (packageAmount * packagePer / 100).toFixed(2);
                        document.querySelector(".totalAmount").value = Math.round(packageAmount * packagePer / 100 + packageAmount  || '');
                    });
                </script>


            </div><!-- /.box -->
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Package View</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="fileTable1" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Package Name</th>
                                <th>Package Amount</th>
                                <th>Package %</th>
                                <th>Total Amount</th>
                                <th>Time Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($packages as $index => $package)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $package->package_name }}</td>
                                <td>{{ $package->package_amount }}</td>
                                <td>{{ $package->package_payout_per }} %</td>
                                <td>{{ $package->package_amount }} + {{ $package->package_payout_per }} % = {{ $package->package_total_amount }}</td>
                                <td>{{ $package->package_time_duration }} min</td>
                                <td>

                        <form action="{{ route('generic.delete', ['table' => 'package_master', 'id' => $package->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure want to delete {{ $package->package_name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div>
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