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
                            <th>Down Member</th>
                            <th>Your Level</th>
                            <th>Amount</th>
                            <th>Plan Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tr>
                                <td>1</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                         <tr>
                                <td>1</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                         <tr>
                                <td>1</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>aaaa</td>
                                <td>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-primary"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>


                      
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