@extends('index_main')

@section('csscontent')
    <!-- Add your custom CSS here -->
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">View Sales</h4>

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
                            <h4 class="card-title">Sales List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-editable table-nowrap align-middle table-edits yajra_datatable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mandivyapari ID</th>
                                            <th>Dukandar ID</th>
                                            <th>Product ID</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Price Per Unit</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
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
            ajax: "{{ route('view-sales') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'mandivyapari_id', name: 'mandivyapari_id' },
                { data: 'dukandar_id', name: 'dukandar_id' },
                { data: 'stock_id', name: 'stock_id' },
                { data: 'quantity', name: 'quantity' },
                { data: 'unit', name: 'unit' },
                { data: 'price_per_unit', name: 'price_per_unit' },
                { data: 'total', name: 'total' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Delete button handler
        $(document).on('click', '.delete', function() {
            var row_id = $(this).data('id');
            var table_row = $(this).closest('tr');
            var url = "{{ route('delete-sale', ':id') }}".replace(':id', row_id);

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
                                text: 'The sales record has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.row(table_row).remove().draw(false);
                            });
                        }
                    });
                }
            });
        });

        // Edit button handler
        $(document).on('click', '.edit', function() {
            var row = $(this).closest('tr');
            var cells = row.find('td').not(':last');
            var id = row.find('td:first').text().trim();
            $(this).data('id', id);

            cells.each(function(index) {
                var cell = $(this);
                var content = cell.text().trim();
                cell.data('name', index);
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

            cells.each(function() {
                var cell = $(this);
                var input = cell.find('input');
                data[cell.data('name')] = input.val();
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('updatesales', ':id') }}".replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}',
                    mandivyapari_id: data[1],
                    dukandar_id: data[2],
                    product_id: data[3],
                    quantity: data[4],
                    unit: data[5],
                    price_per_unit: data[6],
                    total: data[7]
                },
                success: function(response) {
                    swal.fire({
                        title: 'Updated!',
                        text: 'Your sales record has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    table.ajax.reload();
                },
                error: function(xhr) {
                    swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the sales record.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Double-click row to edit
        $(document).on('dblclick', 'table.yajra_datatable tbody tr', function() {
            var row = $(this);
            row.find('.edit').trigger('click');
        });
    });
</script>
@endsection
