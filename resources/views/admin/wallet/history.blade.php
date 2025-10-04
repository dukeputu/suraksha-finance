@extends('layouts.app')
@section('title', 'Income List')

@section('content')


<div class="container">
    <h3>Wallet Transfer History</h3>
    
    <table id="fileTable1" class="display responsive nowrap" style="width:100%">
        <thead >
            <tr>
                <th>Date & Time</th>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Amount</th>
                <th>Balance Change</th>
                <th>Balance After</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $row)
                @php
                    $isDebit = $row->from_user_id == $memberId;
                @endphp
                <tr>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        @if($isDebit)
                            <span class="text-danger">Debit</span>
                        @else
                            <span class="text-success">Credit</span>
                        @endif
                    </td>
                    <td>{{ $row->from_phone }}</td>
                    <td>{{ $row->to_phone }}</td>
                    <td>{{ number_format($row->amount, 2) }}</td>
                    <td>
                        @if($isDebit)
                            <span class="text-danger">{{ $row->from_balance_change }}</span>
                        @else
                            <span class="text-success">{{ $row->to_balance_change }}</span>
                        @endif
                    </td>
                    <td>
                        @if($isDebit)
                            {{ number_format($row->from_balance_after, 2) }}
                        @else
                            {{ number_format($row->to_balance_after, 2) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


</div>
@endsection

