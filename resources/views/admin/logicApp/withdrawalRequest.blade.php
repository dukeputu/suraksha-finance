@extends('layouts.app')
@section('title', 'Withdrawal Request')

@section('content')


    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"> Plan Income View</h3>
                    </div>
                    <div class="box-body">
                        <table id="fileTable1" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>User Name</th>
                                    <th>User Phone No</th>
                                    <th>User Wallet Balance</th>
                                    <th>Balance Request</th>
                                    <th>Payment Method</th> <!-- New column -->
                                    <th>User Bank Details</th>
                                    <th>Status</th>
                                    <th>User Requested At</th>
                                    <th>Payment Done At</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($withdrawalRequest as $index => $BalanceRequest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $BalanceRequest->app_user_name }}</td>
                                        <td>{{ $BalanceRequest->user_phone }}</td>
                                        <td>{{ $BalanceRequest->user_wallet }}</td>
                                        <td>{{ $BalanceRequest->req_bal_amount }}</td>

                                        <!-- New payment method display -->
                                        <td>
                                            @if ($BalanceRequest->online_cash == 1)
                                                <span class="label label-success">Online</span>
                                            @elseif($BalanceRequest->online_cash == 2)
                                                <span class="label label-warning">Cash</span>
                                            @else
                                                <span class="label label-default">Not Set</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#bankDetailsModal{{ $index }}">
                                                Click To View
                                            </button>
                                        </td>




                                        <td>
                                            @if ($BalanceRequest->status == 1)
                                                <span class="label label-success">Approved</span>
                                            @elseif($BalanceRequest->status == 2)
                                                <span class="label label-warning">Pending</span>
                                            @else
                                                <span class="label label-default">Unknown</span>
                                            @endif
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($BalanceRequest->created_at)->format('d-m-Y , h:i A') }}
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($BalanceRequest->updated_at)->format('d-m-Y , h:i A') }}
                                        </td>

                                        {{-- <td>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></a>
                                </td> --}}
                                    </tr>


                                    <!-- Modal -->
                                    <div class="modal fade" id="bankDetailsModal{{ $index }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalLabel{{ $index }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"><span>&times;</span></button>
                                                    <h4 class="modal-title">
                                                        <b> {{ $BalanceRequest->app_user_name }}</b> Payment
                                                        Details Pay ₹ {{ $BalanceRequest->req_bal_amount }}
                                                        <br>
                                                        Phone No:- {{ $BalanceRequest->user_phone }}
                                                    </h4>
                                                </div>

                                                <div class="modal-body">
                                                    <p><strong>Bank Name:</strong>
                                                        {{ $BalanceRequest->bank_name ?? 'N/A' }}</p>
                                                    <p><strong>IFSC Code:</strong>
                                                        {{ $BalanceRequest->ifsc_code ?? 'N/A' }}</p>
                                                    <p><strong>AC Holder Name:</strong>
                                                        {{ $BalanceRequest->app_user_name ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Bank AC No.:</strong>
                                                        {{ $BalanceRequest->bank_account_no ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>UPI ID:</strong> {{ $BalanceRequest->upi_id ?? 'N/A' }}</p>
                                                    <p><strong>UPI QR Code:</strong></p>

                                                    @if ($BalanceRequest->upi_qr_code)
                                                        <center>
                                                            <img src="{{ asset($BalanceRequest->upi_qr_code) }}"
                                                                width="200" alt="UPI QR Code">
                                                        </center>
                                                    @else
                                                        <p>N/A</p>
                                                    @endif

                                                    <hr>

                                                    @if ($BalanceRequest->pay_screenshot !== '0')
                                                        <p><strong>Company Payment Screenshot:</strong></p>
                                                        <center>
                                                            <img src="{{ asset($BalanceRequest->pay_screenshot) }}"
                                                                width="200" alt="Payment Screenshot">
                                                        </center>
                                                    @else
                                                        {{-- <form
                                                action="{{ route('withdrawalScrenshortUpload.list', ['id' => $BalanceRequest->id]) }}"
                                                method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure')">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="payment_screenshot">Upload Company Payment
                                                        Screenshot</label>
                                                    <input required accept=".png, .jpg, .jpeg" type="file"
                                                        name="payment_screenshot" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-success btn-sm">Upload
                                                    Screenshot</button>
                                            </form> --}}

                                                        <form
                                                            action="{{ route('withdrawalScrenshortUpload.list', ['id' => $BalanceRequest->id]) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            onsubmit="return confirm('Are you sure')">
                                                            @csrf

                                                            <div class="form-group">
                                                                <label>Payment Method</label><br>
                                                                <label>
                                                                    <input type="radio" name="online_cash" value="1"
                                                                        required> Online
                                                                </label>
                                                                &nbsp;&nbsp;
                                                                <label>
                                                                    <input type="radio" name="online_cash" value="2">
                                                                    Cash
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="payment_screenshot">Upload Company Payment
                                                                    Screenshot</label>
                                                                <input required accept=".png, .jpg, .jpeg" type="file"
                                                                    name="payment_screenshot" class="form-control">
                                                            </div>

                                                            <button type="submit" class="btn btn-success btn-sm">Upload
                                                                Screenshot</button>
                                                        </form>
                                                    @endif
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
