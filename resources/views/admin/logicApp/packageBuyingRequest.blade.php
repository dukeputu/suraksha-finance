@extends('layouts.app')
@section('title', 'Income List')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="row">
   
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Plan Income View</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
<table id="fileTable1" class="display responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <th>SL No</th>
            <th>User Name</th>
            <th>Phone</th>
            <th>Amount Paid</th>
            <th>Plan Name</th>
            <th>Purchased At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $index => $req)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $req->user_name }}</td>
            <td>{{ $req->phone_number }}</td>
            <td>₹{{ number_format($req->amount_paid, 2) }}</td>
            <td>{{ $req->package_name }}</td>
            <td>{{ \Carbon\Carbon::parse($req->created_at)->format('d M Y h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>



                </div>
            </div>
        </div>

    </div>
</section>
</div>




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