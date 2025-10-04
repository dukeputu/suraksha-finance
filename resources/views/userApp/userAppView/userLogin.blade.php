@extends('userApp.layouts.userAppLayout')
@section('title', 'Dashboard')

@section('content')
<style>
.appBottomMenu {
    display: none;
}
</style>


    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
      
        <div class="pageTitle"></div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 text-center">
            <h1>Log in</h1>
           
        </div>
        <div class="section mb-5 p-2">

            {{-- @if (session('success'))

                 <div class="alert alert-primary mb-1" role="alert">
                        {!! session('success') !!}
                        <br>
                        Save It Carefully
                    </div>
                @endif --}}



                @if (session('success'))
    <div class="alert alert-primary mb-1" role="alert">
        {!! session('success') !!}
        <br>
                        Save It Carefully
    </div>
@endif

{{-- Check localStorage for JS-injected success message --}}
<script>
    const savedMessage = localStorage.getItem('success_flash');
    if (savedMessage) {
        document.write(`<div class="alert alert-primary mb-1" role="alert">${savedMessage}</div>`);
        localStorage.removeItem('success_flash');
    }
</script>


            @if (session('error'))

                 <div class="alert alert-danger mb-1" role="alert">
                        {!! session('error') !!}
                    </div>
                @endif




        <form method="POST" action="{{ route('loginUserApp.userApp') }}">
            @csrf
            <div class="card">
                <div class="card-body pb-1">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="phone_number">User Name <sup>Phone No</sup></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="User Name" value="{{ old('phone_number') }}" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Your password" autocomplete="off" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-links mt-2">
                <div>
                    <a href="{{ route('userRegister.app') }}">Register Now</a>
                </div>
                {{-- <div><a href="app-forgot-password.html.htm" class="text-muted">Forgot Password?</a></div> --}}
            </div>

            <div class="form-button-group transparent">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
            </div>
        </form>






        </div>

    </div>
    <!-- * App Capsule -->


@endsection