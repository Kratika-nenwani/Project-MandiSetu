


@extends('index_main')

@section('csscontent')

@endsection

@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">News</h4>

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
                            <h4 class="card-title">News List</h4>
                             <a data-bs-toggle="modal" href="#add_blog" class="btn btn-info float-end">+ Add News</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-editable table-nowrap align-middle table-edits yajra_datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <!--<th>Description</th>-->
                                            <th>Link</th>
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
    <div style="width:100%;" class="modal fade twm-sign-up" id="add_blog" aria-hidden="true"
                aria-labelledby="sign_up_popupLabel2" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h2 class="modal-title" id="sign_up_popupLabel2">Add News</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="twm-tabs-style-2">
                                <form id="f"  action="{{ Route('upload-news') }}"  enctype="multipart/form-data" method="POST">
                                    @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="title"><b>Title</b></label>
                                                    <input type="text" class="form-control" name="title" id="title" style="color: black;" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="image"><b>Image</b></label>
                                                    <input type="file" class="form-control" name="image" id="image" style="color: black;" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="date"><b>Date</b></label>
                                                    <input type="date" class="form-control" name="date" id="date" style="color: black;" >
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="description"><b>Description</b></label>
                                                    <textarea class="form-control" name="description" id="description" rows="4" style="color: black;" required></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="link"><b>Link</b></label>
                                                    <input type="text" class="form-control" name="link" id="link" style="color: black;" >
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12" style="text-align: center;">
                                            <button id="submit" type="submit" class="btn btn-info"><i
                                                    class="mdi mdi-upload btn-icon-prepend"></i> Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

@section('jscontent')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/libs/table-edits/build/table-edits.min.js"></script>
<script src="assets/js/pages/table-editable.int.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

<script type="text/javascript">
    $(function() {
        var table = $('.yajra_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('view-news') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },{
                    data: 'date',
                    name: 'date'
                },
                // {
                //     data: 'description',
                //     name: 'description'
                // },
                {
                    data: 'link',
                    name: 'link'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

//         $(document).on('click', '.edit', function() {
//     var row = $(this).closest('tr');
//     var cells = row.find('td').not(':last');
//     var id = row.find('td:first').text().trim();
//     $(this).data('id', id);

//     cells.each(function(index) {
//         var cell = $(this);
//         var content = cell.text().trim();

//         if (index === 0) {
//             // Skip making the id cell editable
//             return;
//         }

//         cell.html('<input type="text" class="form-control" value="' + content + '">');
//     });

//     $(this).removeClass('btn-primary edit').addClass('btn btn-outline-secondary save').html('<i class="fas fa-save"></i>');
// });


//         $(document).on('click', '.save', function() {
//             var row = $(this).closest('tr');
//             var cells = row.find('td').not(':last');
//             var id = $(this).data('id');
//             var data = {};

//             cells.each(function() {
//                 var cell = $(this);
//                 var input = cell.find('input');
//                 data[cell.index()] = input.val();
//             });

//             $.ajax({
//                 type: 'POST',
//                 url: "{{ route('commodityup', ':id') }}".replace(':id', id),
//                 data: {
//                     _token: '{{ csrf_token() }}',
//                     id: id,
//                     name: data[1]
//                 },
//                 success: function(response) {
//                     swal.fire({
//                         title: 'Updated!',
//                         text: 'Your commodity has been updated.',
//                         icon: 'success',
//                         confirmButtonText: 'OK'
//                     });
//                     table.ajax.reload();
//                 },
//                 error: function(xhr) {
//                     swal.fire({
//                         title: 'Error!',
//                         text: 'There was an error updating the commodity.',
//                         icon: 'error',
//                         confirmButtonText: 'OK'
//                     });
//                 }
//             });
//         });

//         $(document).on('dblclick', 'table.yajra_datatable tbody tr', function() {
//             var row = $(this);
//             var cells = row.find('td').not(':last');
//             var id = row.find('td:first').text().trim();

//             // Ensure the save button has the correct ID
//             row.find('.edit').data('id', id).removeClass('btn-primary edit').addClass('btn btn-outline-secondary save').html('<i class="fas fa-save"></i>');

//             cells.each(function() {
//                 var cell = $(this);
//                 var content = cell.text().trim();
//                 cell.html('<input type="text" class="form-control" value="' + content + '">');
//             });
//         });

        $(document).on('click', '.delete', function() {
            var row_id = $(this).attr('id');
            var table_row = $(this).closest('tr');
            var url = "{{ route('delete-news') }}";

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
                                text: 'Your commodity has been deleted.',
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

