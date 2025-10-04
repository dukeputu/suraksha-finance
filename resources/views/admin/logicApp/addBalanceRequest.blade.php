@extends('layouts.app')
@section('title', 'Balance Request')

@section('content')

@if(session('debugLog'))
    <div class="card mt-3">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Commission Debug Log</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach(session('debugLog') as $log)
                    <li class="list-group-item">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        {{ $log }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


    <!-- Main content -->
    <section class="content">
        <div class="row">

            @if (session('success'))
            <div class="flash-message flash-success">
                {{ session('success') }}
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
            @endif

            @if (session('error'))

            <div style="background: red;"> 
                {{ session('error') }}
            </div>
            
            @endif

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
                                    <th>User Phone No</th>
                                    {{-- <th>Last Wallet Balance</th> --}}
                                    <th>Balance Request</th>
                                    <th>Payment Photo</th>
                                    <th>Status</th>
                                    <th>Req. At</th>
                                    <th>Done At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userBalanceRequest as $index => $BalanceRequest)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $BalanceRequest->app_user_name }}</td>
                                        <td>{{ $BalanceRequest->user_phone }}</td>
                                        {{-- <td>{{ $BalanceRequest->user_wallet }}</td> --}}
                                        <td>{{ $BalanceRequest->req_bal_amount }}</td>
                                        {{-- <td>
                                            
                                            
                                            <a href="{{ $BalanceRequest->pay_screenshot }}" target="_blank">View
                                                Screenshot</a>
                                        </td> --}}

                                         <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#bankDetailsModal{{ $index }}">
                                                Click To View
                                            </button>

                                        </td>

                                        <td>
                                            @if ($BalanceRequest->status == 1)
                                                <span class="badge btn-success">Approved</span>
                                            @elseif($BalanceRequest->status == 2)
                                                <span class="badge bg-navy">Pending</span>
                                            @else
                                                <span class="badge btn-secondary">Unknown</span>
                                            @endif
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($BalanceRequest->created_at)->format('d-m-Y , h:i A') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($BalanceRequest->updated_at)->format('d-m-Y , h:i A') }}
                                        </td>

                                        <td>
                                            @if ($BalanceRequest->status == 1)
                                                <button class="btn btn-primary btn-sm" disabled>
                                                    <i class="fa fa-check"></i> Approved
                                                </button>
                                            @else
                                                <form action="{{ route('addBalanceTrafer.list', $BalanceRequest->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to send ₹{{ $BalanceRequest->req_bal_amount }} to {{ $BalanceRequest->app_user_name }}?');">
                                                    @csrf
                                                    <input type="hidden" name="userBlaAdd"
                                                        value="{{ $BalanceRequest->req_bal_amount }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>

                                    </tr>

                                        <!-- Modal -->
                                    <div class="modal fade" id="bankDetailsModal{{ $index }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalLabel{{ $index }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                        <b>{{ $BalanceRequest->app_user_name }}</b> - Add Balance Screenshot <br>
                                                        Phone No: {{ $BalanceRequest->user_phone }}
                                                    </h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"><span>&times;</span></button>
                                                </div>

                                                <div class="modal-body">
                                                    {{-- <p><strong>Introducer Name:</strong> {{ $BalanceRequest->introducer_name ?? 'N/A' }}</p>
                                                    <p><strong>Introducer Phone:</strong> {{ $BalanceRequest->introducer_phone ?? 'N/A' }}</p>
                                                    <p><strong>User Address:</strong> {{ $BalanceRequest->app_u_address ?? 'N/A' }}</p>
                                                    <p><strong>User Email ID:</strong> {{ $BalanceRequest->user_email ?? 'N/A' }}</p>
                                                    <p><strong>Bank Name:</strong> {{ $BalanceRequest->bank_name ?? 'N/A' }}</p>
                                                    <p><strong>IFSC Code:</strong> {{ $BalanceRequest->ifsc_code ?? 'N/A' }}</p>
                                                    <p><strong>AC Holder Name:</strong> {{ $BalanceRequest->app_u_name ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Bank AC No.:</strong>
                                                        {{ $BalanceRequest->bank_account_no ?? 'N/A' }}</p>
                                                    
                                                    <p><strong>UPI QR Code:</strong></p> --}}
                                                        <p><strong>Balance Request:</strong> {{ $BalanceRequest->req_bal_amount ?? 'N/A' }}</p>
                                                    @if ($BalanceRequest->pay_screenshot)
                                                        <center>
                                                            <img src="{{ asset($BalanceRequest->pay_screenshot) }}" width="200"
                                                                alt="UPI QR Code">
                                                        </center>
                                                    @else
                                                        <p>N/A</p>
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

@endsection






