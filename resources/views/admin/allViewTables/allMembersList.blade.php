@extends('layouts.app')
@section('title', 'Income List')

@section('content')


<!-- Main content -->
<section class="content">
    <div class="row">
   
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">All Member List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">


             <table id="allMembersList" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Member Name</th>
                            <th>Member Id</th>
                            <th>Member Phone No</th>
                            <th>Member Plan Name</th>
                            <th>Member Wallet Balance</th>
                            <th>Introducer Name</th>
                            <th>Introducer Phone</th>
                            <th>Member Reg. Date</th>
                            
                        </tr>
                    </thead>
                   {{-- // This is pure Laravel + DataTables JS, no third-party Laravel packages, fully customizable. function dynamicDataTable
                   /**
                        * Reusable dynamic datatable method for any table.
                        */
                   --}}

                   
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



{{-- // This is pure Laravel + DataTables JS, no third-party Laravel packages, fully customizable. --}}
{{-- /**
     * Reusable dynamic datatable method for any table.
     */ --}}

<script>


        $(document).ready(function () {
            $('#allMembersList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dynamicDataTable.ajax') }}",
                    type: 'POST',
                    data: {
                        table: 'members',
                        columns: ['member_id','member_id ', 'name', 'phone', 'select_plan_name', 'member_wallet', 'introducer_name', 'introducer_phone', 'created_at'],
                        searchable: ['name', 'member_id', 'phone','select_plan_name','member_wallet', 'introducer_name', 'introducer_phone'],
                        orderable: ['created_at']
                        
                            },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'member_id', name: 'member_id' },
                    { data: 'phone', name: 'phone' },
                    { data: 'select_plan_name', name: 'select_plan_name' },
                    { data: 'member_wallet', name: 'member_wallet' },
                    { data: 'introducer_name', name: 'introducer_name' },
                    { data: 'introducer_phone', name: 'introducer_phone' },
                    { data: 'created_at', name: 'created_at' }
                    ],

                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 500],
                responsive: true,

                // ✅ Add export buttons here
                dom: 'lBfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5',
                    'print'
                ]
            });
        });

  


</script>




