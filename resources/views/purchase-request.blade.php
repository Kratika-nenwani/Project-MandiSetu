@extends('index_main')

@section('csscontent')
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Purchase Requests List</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Requests</a></li>
                                <li class="breadcrumb-item active">DataTables</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Purchase Requests</h4>
                            <div>
                                <button type="button" class="btn btn-info btn-clear">Show All</button>
                                <button type="button" class="btn btn-success">Approved</button>
                                <button type="button" class="btn btn-warning">Not Approved</button>
                                <button type="button" class="btn btn-danger">Rejected</button>
                                <button type="button" class="btn btn-secondary">Cancelled</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-editable table-nowrap align-middle table-edits yajra_datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
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
<script src="assets/libs/table-edits/build/table-edits.min.js"></script>
<script src="assets/js/pages/table-editable.int.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('.yajra_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('purchase-request') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' }, // Customer Name
                { data: 'email', name: 'email' }, // Customer email
                { data: 'product_details', name: 'product_details' }, // Product Names
                { data: 'quantity', name: 'quantity' }, // Quantities
                { data: 'status', name: 'status' }, // Status
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                }
            ]
        });

        // Function to apply the search filter
        function applyStatusFilter(status) {
            table.column(5).search(status, true, false).draw(); // Status is in the 6th column (index 5)
        }

        // Button click event listeners
        $('.btn-success').on('click', function() {
            applyStatusFilter('^Approved$'); // Exact match for "Approved"
        });

        $('.btn-warning').on('click', function() {
            applyStatusFilter('^Notapproved$'); // Exact match for "Not Approved"
        });

        $('.btn-danger').on('click', function() {
            applyStatusFilter('^Rejected$'); // Exact match for "Rejected"
        });

        $('.btn-secondary').on('click', function() {
            applyStatusFilter('^Cancel$'); // Exact match for "Cancelled"
        });

        // Show all entries
        $('.btn-clear').on('click', function() {
            table.column(5).search('').draw(); // Clear the status filter
        });

        $(document).on('click', '.change, .reject', function() {
            var requestId = $(this).data('id');
            var newStatus = $(this).data('status');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to change the status to ' + newStatus + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("request-status") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: requestId,
                            status: newStatus
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Updated!',
                                text: 'Status has been updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.ajax.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Failed!',
                                'Failed to update the status.',
                                'error'
                            );
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var row_id = $(this).attr('id');
            var table_row = $(this).closest('tr');
            var url = "{{ route('delete-request') }}";

            Swal.fire({
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
                        url: url.replace(':id', row_id),
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: row_id,
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your request has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.ajax.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete the request.',
                                'error'
                            );
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
        });
    });
</script>


@endsection
