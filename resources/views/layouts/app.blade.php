
    @include('layouts.partials.head')



    {{-- Top Navbar --}}
    @include('layouts.partials.header')

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main Content --}}
    <div class="content-wrapper"> 

         <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            {{-- @yield('dashboard', ' ')  --}}
            @yield('title', 'MLM')
            <small>Preview</small>
          </h1>
         
        </section>

                @yield('content')
           
    </div>

    {{-- Footer --}}
@include('layouts.partials.footer')



{{-- Scripts --}}
@include('layouts.partials.scripts')
</body>
</html>
