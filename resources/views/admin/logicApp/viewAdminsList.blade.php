@extends('layouts.app')
@section('title', 'Company')

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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($getCompany as $company)
                            <tr>
                                
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->phone  }}</td>
                                <td title="{{ $company->address }}">{{ \Str::limit($company->address, 20) }}</td>
                                <td>
                                     @if($company->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($company->status == 2)
                                        <span class="badge bg-danger">Deactive</span>
                                    @elseif($company->status == 3)
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif

                                </td>
                                <td>
                                   <a href="{{ route('addAdmin.adminEdit', $company->id) }}" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>



                               {{-- *********** Get method --}}
                                {{-- <a href="{{ route('generic.delete', ['table' => 'members', 'id' => $company->id]) }}"
                                onclick="return confirm('Are you sure want to delete {{ $company->name }}?')"
                                class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a> --}}

                                {{-- *********** Post method--}}
                                <form action="{{ route('generic.delete', ['table' => 'members', 'id' => $company->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure want to delete {{ $company->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                               {{-- *********** --}}
                                </td>


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