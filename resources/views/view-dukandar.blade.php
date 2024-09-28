

@extends('index_main')

@section('csscontent')
<!-- Add your custom CSS here -->
<link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">View Shopkeepers</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">DataTables</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Shopkeeper List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-editable table-nowrap align-middle table-edits yajra_datatable">
                                    <thead>
                                        <th>ID</th>
                                        <th>Mandivyapari_id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Shop Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <!--<th>Mandi License</th>-->
                                        <!--<th>Gumasta </th>-->
                                        <!--<th>GST Registration </th>-->
                                        <!--<th>Mandi License no</th>-->
                                        <!--<th>Gumasta no</th>-->
                                        <!--<th>GST no</th>  -->
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <!--<th>Aadhar Card </th>-->
                                        <!--<th>PAN Card </th>-->
                                        <!--<th>Account No</th>-->
                                        <!--<th>IFSC Code</th>-->
                                        <!--<th>Statement</th>-->
                                        <!--<th>Office Phone</th>-->
                                        <!--<th>Image</th>-->
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be populated by DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection

@section('jscontent')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>

<script type="text/javascript">
    $(function() {
        var table = $('.yajra_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('view-dukandar') }}",
            columns: [
               { data: 'id', name: 'id' },
                { data: 'mandivyapari_id', name: 'mandivyapari_id' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'shop_name', name: 'shop_name' },
                { data: 'address', name: 'address' },
                { data: 'email', name: 'email' },
                // { data: 'mandi_license', name: 'mandi_license' },
                // { data: 'gumasta', name: 'gumasta' },
                // { data: 'gst_registration', name: 'gst_registration' },
                // { data: 'mandi_license_no', name: 'mandi_license_no' },
                // { data: 'gumasta_no', name: 'gumasta_no' },
                // { data: 'gst_no', name: 'gst_no' },
                { data: 'aadhar', name: 'aadhar' },
                { data: 'pan', name: 'pan' },
                // { data: 'aadhar_card', name: 'aadhar_card' },
                // { data: 'pan_card', name: 'pan_card' },
                // { data: 'account_no', name: 'account_no' },
                // { data: 'ifsc_code', name: 'ifsc_code' },
                // { data: 'statement', name: 'statement' },
                // { data: 'office_phn', name: 'office_phn' },
                // { data: 'image', name: 'image' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Edit button handler
               // Edit button handler
               $(document).on('click', '.edit', function() {
            var row = $(this).closest('tr');
            var cells = row.find('td').not(':last');
            var id = row.find('td:first').text().trim();
            $(this).data('id', id);

            cells.each(function() {
                var cell = $(this);
                var content = cell.text().trim();
                if (cell.find('img').length) {
                    return; // Skip cells with images
                }
                cell.html('<input type="text" class="form-control" value="' + content + '">');
            });

            $(this).removeClass('btn-primary edit').addClass('btn btn-outline-secondary save').html('<i class="fas fa-save"></i>');
        });

        // Save button handler
        $(document).on('click', '.save', function() {
            var row = $(this).closest('tr');
            var cells = row.find('td').not(':last');
            var id = $(this).data('id');
            var data = {};

            cells.each(function(index) {
                var cell = $(this);
                var input = cell.find('input');
                if (input.length) {
                    data[index] = input.val();
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('update-dukandar', ':id') }}".replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    mandivyapari_id: data[1],
                    name: data[2],
                    phone: data[3],
                    shop_name: data[4],
                    address: data[5],
                    email: data[6],
                    mandi_license_no: data[7],
                    gumasta_no: data[8],
                    gst_no: data[9],
                    aadhar_card: data[10],
                    pan_card: data[11],
                    account_no: data[12],
                    ifsc_code: data[13],
                    office_phn: data[14],
                    mandi_license: data[15],
                    gumasta: data[16],
                    gst_registration: data[17],
                    aadhar: data[18],
                    pan: data[19],
                    statement: data[20],
                    image: data[21],
                },
                success: function(response) {
                    swal.fire({
                        title: 'Updated!',
                        text: 'The shopkeeper details have been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    table.ajax.reload();
                },
                error: function(xhr) {
                    swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the shopkeeper details.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Double-click row to edit
        $(document).on('dblclick', 'table.yajra_datatable tbody tr', function() {
            var row = $(this);
            var cells = row.find('td').not(':last');
            var id = row.find('td:first').text().trim();

            row.find('.edit').trigger('click');
        });

        // Delete button handler
        $(document).on('click', '.delete', function() {
            var row_id = $(this).attr('id');
            var table_row = $(this).closest('tr');
            var url = "{{ route('delete-dukandar', ':id') }}".replace(':id', row_id);

            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: row_id,
                        },
                        success: function(data) {
                            swal.fire({
                                title: 'Deleted!',
                                text: 'The shopkeeper record has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                table_row.remove();
                            });
                        }
                    });
                }
            });
        });
    });
</script>


@endsection

