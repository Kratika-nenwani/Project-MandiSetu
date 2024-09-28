@extends('index_main')

@section('csscontent')
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
                        <h4 class="mb-sm-0 font-size-18">Variety</h4>

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
                            <h4 class="card-title">Variety List</h4>
                            {{-- <a href="{{ route('addvariety') }}" class="btn btn-primary">
                               Add Variety
                            </a> --}}
                        </div>
                        <div class="card-body">
                         <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-editable table-nowrap align-middle table-edits yajra_datatable">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Commodity Id</th>
                                    <th>Name</th>
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
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/libs/table-edits/build/table-edits.min.js"></script>
<script src="assets/js/pages/table-editable.int.js"></script>
<script type="text/javascript">
    $(function() {
      var id = $('#cat_id').val();
        var table = $('.yajra_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('viewvariety') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'commodity_id',
                    name: 'commodity_id'
                },
              
                {
                    data: 'name',
                    name: 'name'
                },

               
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // function makeRowEditable(row) {
        //     var cells = row.find('td').not(':last');
        //     cells.each(function() {
        //         var cell = $(this);
        //         var content = cell.text().trim();
        //         cell.html('<input type="text" class="form-control" value="' + content + '">');
        //     });
        //     row.find('.edit').removeClass('btn-primary edit').addClass('btn btn-outline-secondary save').html('<i class="fas fa-save"></i>');
        // }

        // $(document).on('click', '.edit', function() {
        //     var row = $(this).closest('tr');
        //     makeRowEditable(row);
        // });

        // $(document).on('dblclick', '.yajra_datatable tbody tr', function() {
        //     makeRowEditable($(this));
        // });

        // $(document).on('click', '.save', function() {
        //     var row = $(this).closest('tr');
        //     var cells = row.find('td').not(':last');
        //     var id = $(this).data('id');
        //     var data = {};

        //     cells.each(function(index) {
        //         var cell = $(this);
        //         var input = cell.find('input');
        //         data[cell.index()] = input.val();
        //         cell.text(input.val());
        //     });

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('varietyup', ':id') }}".replace(':id', id),
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             id: id,
        //             commodity_id: data[1],
        //             name: data[2]
        //         },
        //         success: function(response) {
        //             swal.fire({
        //                 title: 'Updated!',
        //                 text: 'Your variety has been updated.',
        //                 icon: 'success',
        //                 confirmButtonText: 'OK'
        //             });
        //             table.ajax.reload();
        //         },
        //         error: function(xhr) {
        //             swal.fire({
        //                 title: 'Error!',
        //                 text: 'There was an error updating the variety.',
        //                 icon: 'error',
        //                 confirmButtonText: 'OK'
        //             });
        //         }
        //     });

        //     $(this).removeClass('btn-success save').addClass('btn-primary edit').text('Edit');
        // });

        $(function() {
        var commodities = @json($commodities); // Ensure you pass commodities data from the backend

        function makeRowEditable(row) {
    var cells = row.find('td').not(':last'); // Exclude the last column (actions)
    cells.each(function(index) {
        var cell = $(this);
        var content = cell.text().trim();

        if (index === 0) {
            // Index 0 is for the id field, skip making it editable
            return;
        }

        if (index === 1) { // Index 1 for commodity_id
            var select = $('<select class="form-control"></select>');
            // Populate select with commodities
            commodities.forEach(function(commodity) {
                select.append('<option value="' + commodity.id + '"' + (commodity.name === content ? ' selected' : '') + '>' + commodity.name + '</option>');
            });
            cell.html(select);
        } else {
            cell.html('<input type="text" class="form-control" value="' + content + '">');
        }
    });

    row.find('.edit').removeClass('btn-primary edit').addClass('btn btn-outline-secondary save').html('<i class="fas fa-save"></i>');
}


        $(document).on('dblclick', '.yajra_datatable tbody tr', function() {
            makeRowEditable($(this));
        });

        $(document).on('click', '.edit', function() {
            var row = $(this).closest('tr');
            makeRowEditable(row);
        });

        $(document).on('click', '.save', function() {
            var row = $(this).closest('tr');
            var cells = row.find('td').not(':last');
            var id = $(this).data('id');
            var data = {};

            cells.each(function(index) {
                var cell = $(this);
                var input = cell.find('input, select'); // Include select element
                data[index] = input.val();
                cell.text(input.val());
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('varietyup', ':id') }}".replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    commodity_id: data[1], // Adjusted index for select
                    name: data[2]
                },
                success: function(response) {
                    swal.fire({
                        title: 'Updated!',
                        text: 'Your variety has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    table.ajax.reload();
                },
                error: function(xhr) {
                    swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the variety.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $(this).removeClass('btn-success save').addClass('btn-primary edit').text('Edit');
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '.delete', function() {
        var row_id = $(this).attr('id');
        var table_row = $(this).closest('tr');
        var url = "{{ route('delete-variety') }}";
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
        })
    });
</script>



@endsection