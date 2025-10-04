@extends('layouts.app')
@section('title', 'Income List')

@section('content')



<div class="container">
    <h3>🔔 Membership Renewal Notice (Expiring in 30–60 Days)</h3>

    @if($expiringSoon->isEmpty())
    <div class="alert alert-success">No upcoming renewals found.</div>
@else
    <table id="fileTable1" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>SL No</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Plan</th>
                <th>Status</th>
                <th>Join Date</th>
                <th>Expiry Date</th>
                <th>Renew</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($expiringSoon as $user)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ str_pad($user->id, 7, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $user->app_u_name }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->select_plan_name }}</td>
                    <td>
                        @if ($user->status == 1)
                            <span class="badge badge-success">Active</span>
                        @elseif ($user->status == 2)
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Expired</span>
                        @endif
                    </td>
                    <td>
                        @if($user->join_date)
                            {{ \Carbon\Carbon::parse($user->join_date)->format('d-m-Y') }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($user->expiry_date)
                            {{ \Carbon\Carbon::parse($user->expiry_date)->format('d-m-Y') }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/renew-member/' . $user->id) }}" class="btn btn-sm btn-primary">Renew</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif



</div>
@endsection
