@extends('index_main')

@section('csscontent')
    <!-- Include DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        /* Additional styles for table alignment */
        .table td, .table th {
            text-align: left;
        }
        .product-name {
            font-weight: bold;
            max-width: 250px; /* Adjust as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .quantity {
            text-align: right; /* Right-align quantities */
        }
        .table thead th {
            background-color: #f8f9fa;
            text-align: center;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .btn-view-invoice {
            font-size: 12px;
            padding: 4px 8px;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">MyOrders</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="#">Requests</a></li>
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
                                <h4 class="card-title">Order List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-editable table-nowrap align-middle yajra_datatable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Products Name</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Action</th> <!-- New column for buttons -->
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
    <!-- Include necessary JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.yajra_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myorders') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'product_details',
                        name: 'product_details',
                        className: 'product-name' // Apply custom CSS class
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        className: 'quantity' // Apply custom CSS class
                    },
                    { data: 'status', name: 'status' },
                    {
                        data: 'id', // Assuming 'id' is used to identify the order
                        name: 'action',
                        render: function(data, type, row) {
                            // Adjust the URL as needed for viewing invoices
                            return '<a href="/invoice/' + data + '" class="btn btn-primary btn-view-invoice">View Invoice</a>';
                        },
                        orderable: false, // Make this column non-orderable
                        searchable: false // Make this column non-searchable
                    }
                ],
                // Optional DataTable configuration options
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });
        });
    </script>
@endsection
