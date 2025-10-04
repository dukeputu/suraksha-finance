@extends('layouts.app')
@section('title', 'Plan Master')

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

                <form role="form" method="POST" action="{{ url('/plan-master') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <p class="from-top-header">Plan Master</p>
                        <div class="row">
                            <!-- select Plan -->
                            <div class="form-group col-sm-12">
                                <label>Select Plan*</label>
                                <select class="form-control" name="select_plan_id" required>
                                    <option disabled selected>Select Plan</option>
                                    @foreach($planNames as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->plan_names }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Plan Amount<sup>*</sup></label>
                                <input type="number" class="form-control" name="plan_amount"
                                    value="{{ old('plan_amount') }}" required>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Plan PayOut<sup>*</sup></label>
                                <input type="number" class="form-control" name="plan_payout"
                                    value="{{ old('plan_payout') }}" required>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>




            </div><!-- /.box -->
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Plan View </h3>
                    <input class="form-check-input" type="checkbox" role="switch" id="deleteSwitch">
                    
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="fileTable1" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Plan Name</th>
                                <th>Plan Amount</th>
                                <th>Payout</th>
                                <th>Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($plans as $plan)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $plan->select_plan }}</td>
                                <td>{{ $plan->plan_amount }}</td>
                                <td>{{ $plan->plan_payout }}</td>
                                <td>{{ $plan->plan_level }}</td>
                                <td style="display: none;" class="plan-btn">
                                    <a  href="{{ route('plan.delete', $plan->id) }}" class="btn btn-danger btn-sm " id="plan-btn-{{ $plan->id }}"
                                        onclick="return confirm('Are you sure to delete this {{ $plan->select_plan }} plan?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
<script>
deleteSwitch.onchange = () => 
  document.querySelectorAll('.plan-btn').forEach(btn => 
    btn.style.display = deleteSwitch.checked ? 'block' : 'none'
  );
</script>

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