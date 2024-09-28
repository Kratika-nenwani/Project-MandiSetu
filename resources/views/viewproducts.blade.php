@extends('index_main')

@section('csscontent')
@endsection

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Quality</h4>

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
                                <h4 class="card-title">Quality List</h4>

                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table
                                        class="table table-editable table-nowrap align-middle table-edits yajra_datatable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>CommodityId</th>
                                                <th>VarietyId</th>
                                                <th>Quality</th>
                                                <th>Rate</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Image</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>

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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.yajra_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('viewproducts') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'commodity_id',
                        name: 'commodity_id'
                    },
                    {
                        data: 'variety_id',
                        name: 'variety_id'
                    },
                    {
                        data: 'quality',
                        name: 'quality'
                    },
                    {
                        data: 'rate',
                        name: 'rate'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'image',
                        name: 'image',
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });




            $(function() {
                var commodities =
                    @json($commodities); // Ensure you pass commodities data from the backend
                var varieties =
                    @json($varieties); // Ensure you pass varieties data from the backend

                // Populate commodity select options
                function populateCommodityOptions(select, selectedId) {
                    select.empty();
                    commodities.forEach(function(commodity) {
                        select.append('<option value="' + commodity.id + '"' + (commodity.id ===
                                selectedId ? ' selected' : '') + '>' + commodity.name +
                            '</option>');
                    });
                }

                // Populate variety select options based on selected commodity
                function populateVarietyOptions(select, commodityId, selectedId) {
                    select.empty();
                    varieties.filter(function(variety) {
                        return variety.commodity_id === commodityId;
                    }).forEach(function(variety) {
                        select.append('<option value="' + variety.id + '"' + (variety.id ===
                                selectedId ? ' selected' : '') + '>' + variety.name +
                            '</option>');
                    });
                }

                $(function() {
                    var commodities =
                        @json($commodities); // Ensure you pass commodities data from the backend
                    var varieties =
                        @json($varieties); // Ensure you pass varieties data from the backend

                    // Populate commodity select options
                    function populateCommodityOptions(select, selectedId) {
                        select.empty();
                        commodities.forEach(function(commodity) {
                            select.append('<option value="' + commodity.id + '"' + (
                                    commodity.id == selectedId ? ' selected' : '') +
                                '>' + commodity.name + '</option>');
                        });
                    }

                    // Populate variety select options based on selected commodity
                    function populateVarietyOptions(select, commodityId, selectedId) {
                        select.empty();
                        varieties.filter(function(variety) {
                            return variety.commodity_id == commodityId;
                        }).forEach(function(variety) {
                            select.append('<option value="' + variety.id + '"' + (variety
                                    .id == selectedId ? ' selected' : '') + '>' +
                                variety.name + '</option>');
                        });
                    }

                    function makeRowEditable(row) {
                        var cells = row.find('td').not(':last'); // Exclude the action column
                        var id = row.find('td:first').text()
                            .trim(); // Ensure the ID is correctly captured

                        cells.each(function(index) {
                            var cell = $(this);
                            var content = cell.text().trim();
                             if (index === 0) {
                             return;
                            }

                            if (index ===
                                1) { // Column for commodity_id (2nd column, index 1)
                                var select = $('<select class="form-control"></select>');
                                populateCommodityOptions(select, content);
                                cell.html(select);

                                // Trigger variety dropdown update when commodity changes
                                select.on('change', function() {
                                    var selectedCommodityId = $(this).val();
                                    var varietyCell = row.find(
                                        'td:eq(2)'
                                        ); // Column for variety_id (3rd column, index 2)
                                    var varietySelect = varietyCell.find('select');
                                    populateVarietyOptions(varietySelect,
                                        selectedCommodityId, null
                                    ); // Clear selected ID
                                });

                                // Initialize variety dropdown based on the current commodity
                                var initialCommodityId = select.val();
                                var varietyCell = row.find(
                                    'td:eq(2)'
                                    ); // Column for variety_id (3rd column, index 2)
                                var varietySelect = varietyCell.find('select');
                                populateVarietyOptions(varietySelect, initialCommodityId,
                                    content);

                            } else if (index ===
                                2) { // Column for variety_id (3rd column, index 2)
                                var select = $('<select class="form-control"></select>');
                                populateVarietyOptions(select, row.find('td:eq(1) select')
                                    .val(), content);
                                cell.html(select);
                            } else if (index === 7) { // Image field (8th column)
                                cell.html(
                                    '<input type="file" class="form-control" multiple="multiple">'
                                    );
                            } else {
                                cell.html(
                                    '<input type="text" class="form-control" value="' +
                                    content + '">');
                            }
                        });

                        var actionCell = row.find('td:last');
                        var editButton = actionCell.find('.edit');
                        editButton.removeClass('btn-primary edit').addClass(
                            'btn btn-outline-secondary save').html(
                            '<i class="fas fa-save"></i>');
                    }

                    // Handle click on edit button
                    $(document).on('click', '.edit', function() {
                        var row = $(this).closest('tr');
                        makeRowEditable(row);
                    });

                    // Handle double-click on table row
                    $(document).on('dblclick', '.yajra_datatable tbody tr', function() {
                        makeRowEditable($(this));
                    });

                    // Handle click on save button
                    $(document).on('click', '.save', function() {
                        var row = $(this).closest('tr');
                        var cells = row.find('td').not(
                        ':last'); // Exclude the action column
                        var id = $(this).data('id'); // Retrieve ID from data attribute
                        var data = new FormData();
                        var fieldNames = ['id', 'commodity_id', 'variety_id', 'quality',
                            'rate', 'quantity', 'state', 'district', 'description'
                        ]; // Ensure field names match table columns

                        cells.each(function(index) {
    var cell = $(this);
    var input = cell.find('input, select');
    
    if (input.attr('type') === 'file') {
        var files = input[0].files;
        if (files.length > 0) {
            // Loop through each selected file and append to FormData
            for (var i = 0; i < files.length; i++) {
                data.append('images[]', files[i]);
            }
        } else {
            // If no file is selected, append an empty array
            data.append('images[]', []);
        }
    } else {
        data.append(fieldNames[index], input.val());
    }
});

data.append('id', id);
data.append('user_id', "{{ auth()->user()->id }}"); // Add user_id to the data
data.append('_token', '{{ csrf_token() }}');

// Debug: Log form data
for (var pair of data.entries()) {
    console.log(pair[0] + ', ' + pair[1]);
}
console.log("working");

$.ajax({
    type: 'POST',
    url: "{{ route('productupdate', ':id') }}".replace(':id', id),
    data: data,
    processData: false,
    contentType: false,
    success: function(response) {
        swal.fire({
            title: 'Updated!',
            text: 'Your product has been updated.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            table.ajax.reload(); // Reload the table to see the changes
        });
    },
    error: function(xhr) {
        console.error('Error:', xhr.responseText); // Debug: Show the error response
        swal.fire({
            title: 'Error!',
            text: 'There was an error updating the product.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});

                    });

                });



                // Delete button handler
                $(document).on('click', '.delete', function() {
                    var row_id = $(this).attr('id');
                    var table_row = $(this).closest('tr');
                    var url = "{{ route('delete-product') }}";
                    swal.fire({
                        title: "Are you Sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'get',
                                url: url.replace(':id', row_id),
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: row_id,
                                },
                                success: function(data) {
                                    swal.fire({
                                        title: 'Deleted!',
                                        text: 'Your product has been deleted.',
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
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
@endsection
