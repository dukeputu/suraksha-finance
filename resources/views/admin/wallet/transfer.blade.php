@extends('layouts.app')
@section('title', 'Income List')

@section('content')



    <div class="container">
        <h3>Wallet to Wallet Transfer</h3>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif





        <form method="POST" action="{{ route('wallet.transfer.process') }}">
            @csrf
            <p class="from-top-header">Transfer Left to Right</p>
            <div class="row">
                <!-- FROM Section -->
                <div class="col-md-6 introducer-section mb-4">
                
            
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Enter From Introducer Phone</label>
                            <div class="form-inline">
                                <input min="0" type="number" name="from_phone" class="form-control introducer_id mr-2" placeholder="Enter phone" value="{{ old('from_phone') }}">
                                <button type="button" class="btn btn-primary introduceIDBtn">Search</button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>From User Name<sup>*</sup></label>
                            <input type="text" class="form-control introducer_name" name="from_introducer_name" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>From User Wallet BAL<sup>*</sup></label>
                            <input type="text" class="form-control wallet_bal" name="from_wallet_bal" readonly>
                        </div>
                    </div>
                </div>
            
                <!-- TO Section -->
                <div class="col-md-6 introducer-section mb-4">
                    
            
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Enter To Introducer Phone</label>
                            <div class="form-inline">
                                <input min="0" type="number" name="to_phone" class="form-control introducer_id mr-2" placeholder="Enter phone" value="{{ old('to_phone') }}">
                                <button type="button" class="btn btn-primary introduceIDBtn">Search</button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>To User Name<sup>*</sup></label>
                            <input type="text" class="form-control introducer_name" name="to_introducer_name" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>To User Wallet BAL<sup>*</sup></label>
                            <input type="text" class="form-control wallet_bal" name="to_wallet_bal" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            




            <div class="form-group">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Transfer</button>
        </form>
    </div>
@endsection





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




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
    
 $(document).ready(function() {
    $('.introduceIDBtn').click(function() {
        var section = $(this).closest('.introducer-section');
        var id = section.find('.introducer_id').val();

        if (id) {
            $.get('/get-introducer/' + id, function(data) {
                if (data && data.name) {
                    section.find('.introducer_id_hidden').val(data.introducer_id_hidden);
                    section.find('.introducer_name').val(data.name);
                    section.find('.wallet_bal').val(data.wallet_bal); // optional if you add input
                    section.find('.introducer_address').val(data.address); // optional

                    // Uncomment if using position radio buttons in each section
                    /*
                    if (data.position === 'Left') {
                        section.find('.position_left').prop('checked', true);
                    } else if (data.position === 'Right') {
                        section.find('.position_right').prop('checked', true);
                    }
                    */
                } else {
                    alert('Introducer not found');
                }
            }).fail(function() {
                alert('Something went wrong');
            });
        } else {
            alert('Please enter Introducer ID');
        }
    });
});

</script>
