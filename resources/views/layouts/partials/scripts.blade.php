<!-- jQuery 2.1.3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>    

    <script src="{{ asset('admin/dist/js/app.min.js')}}" type="text/javascript"></script>

        <!-- DATA TABES SCRIPT -->
       <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<!-- DataTables Buttons + Export -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Required for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Required for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<!-- CSS for buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">


  </body>
</html>

<script type="text/javascript">
$(document).ready(function() {
    $('#fileTable1').DataTable({
        "pageLength": 50,
        "lengthMenu": [5, 10, 20, 50,100],
        "scrollX": true,            // Enables horizontal scrolling
        "responsive": false         // Disables responsive layout
    });
});
</script>
