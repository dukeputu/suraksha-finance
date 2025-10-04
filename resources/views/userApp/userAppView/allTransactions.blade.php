@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')



     <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="{{route('dashboard.app')}}" class="headerButton ">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Transactions
        </div>
        
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Transactions -->
        <div class="section mt-2">
        











<div class="transactions">
    @forelse($transactions as $txn)
        @php
            $isDebit = in_array($txn->type, ['Withdrawal', 'Package Buy']);
            $bgClass = match($txn->status) {
                'Done' => 'bg-success text-white',
                'Pending' => 'bg-warning text-dark',
                'Failed' => 'bg-danger text-white',
                default => 'bg-light text-dark'
            };

            $icon = match($txn->type) {
                'Withdrawal' => '💸',
                'Maturity' => '💰',
                'Package Buy' => '📦',
                'Add Balance' => '➕',
                default => '🔄'
            };

            $statusBadge = match($txn->status) {
                'Done' => 'badge-success',
                'Pending' => 'badge-warning',
                'Failed' => 'badge-danger',
                default => 'badge-secondary'
            };
        @endphp

        <div class="card mb-3 {{ $bgClass }} rounded shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                
                <!-- Left: Type and Time -->
                <div class="text-start" style="min-width: 40%;">
                    <h6 class="mb-1">{{ $icon }} {{ $txn->type }}</h6>
                    <div class="small">
                        <span class="badge {{ $statusBadge }}">{{ $txn->status }}</span><br>
                        <strong>Req:</strong> {{ \Carbon\Carbon::parse($txn->requested_at)->format('d-m-Y h:i A') }}<br>
                        @if($txn->done_at)
                            <strong>Done:</strong> {{ \Carbon\Carbon::parse($txn->done_at)->format('d-m-Y h:i A') }}<br>
                        @endif
                    </div>
                </div>

                <!-- Center: Wallet Info -->
                <div class="text-center small" style="min-width: 25%;">
                    <div><strong>Wallet</strong></div>
                    <div>Before: ₹{{ number_format($txn->wallet_before, 2) }}</div>
                    <div>After: ₹{{ number_format($txn->wallet_after, 2) }}</div>
                </div>

                <!-- Right: Amount -->
                <div class="text-end" style="min-width: 25%;">
                    <div class="h5 {{ $isDebit ? 'text-white' : 'text-white' }}">
                        ₹{{ number_format($txn->amount, 2) }}
                        <small class="text-uppercase">({{ $isDebit ? 'Dr' : 'Cr' }})</small>
                    </div>

                    @if($txn->type === 'Withdrawal' && $txn->screenshot && $txn->screenshot !== '0')
                        <div class="mt-1">
                            <img style="cursor: pointer;" src="{{ asset($txn->screenshot) }}" alt="Screenshot" width="40" height="40" class="rounded border"
                                 onclick="showScreenshot(this.src)" data-bs-toggle="modal" data-bs-target="#ModalBasic">
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">No transactions found.</div>
    @endforelse
</div>













        <!-- Modal Basic -->
        <div class="modal fade modalbox" id="ModalBasic" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment Screenshot</h5>
                        <a href="#" data-bs-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <img style="max-width: 300px" id="modal-img" src="">
                    </div>
                </div>
            </div>
        </div>
        <!-- * Modal Basic -->

<script>
function showScreenshot(src) {
    document.getElementById('modal-img').src = src;
}
</script>


        </div>
        <!-- * Transactions -->






    </div>
    <!-- * App Capsule -->






@endsection
