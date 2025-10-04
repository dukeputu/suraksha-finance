@extends('layouts.app')
@section('title', 'Income List')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="row">
   
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $plan->select_plan }} Plan Income View</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
             <table id="fileTable1" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Down Member</th>
                            <th>Your Level</th>
                            <th>Amount</th>
                            <th>Plan Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($transactions as $tx)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $tx->downline_name }} MUM/{{ $tx->member_id }}</td>
                                <td>{{ $tx->level }}</td>
                                <td>₹{{ number_format($tx->amount, 2) }}</td>
                                <td>{{ $plan->select_plan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Total Income:</strong></td>
                            <td colspan="2"><strong>₹{{ number_format($totalIncome, 2) }}</strong></td>
                        </tr>
                    </tfoot>
            </table>

                </div>
            </div>
        </div>

    </div>
</section>
</div>




@endsection



{{-- @section('content')
<div class="content">
    <h1>{{ $plan->select_plan }} Plan</h1>
    <p><strong>Plan ID:</strong> {{ $plan->select_plan_id }}</p>
    <p><strong>Amount:</strong> ₹{{ $plan->plan_amount }}</p>
    <p><strong>Payout:</strong> ₹{{ $plan->plan_payout }}</p>
    <p><strong>Level:</strong> {{ $plan->plan_level }}</p>
</div>
@endsection 

SELECT * FROM `mlm_transactions` WHERE `beneficiary_id` = '0000033';

--}}

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