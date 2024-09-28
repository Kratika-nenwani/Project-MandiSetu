@extends('index_main')

@section('csscontent')
<!-- Add any additional CSS here -->
<style>
    .main-content {
        padding: 20px;
    }

    .page-title-box {
        margin-bottom: 20px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #2ab57d;
        border-color: #2ab57d;
        border-radius: 5px;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #2ab57d;
        border-color: #2ab57d;
    }

    .card-title {
        font-size: 24px;
        font-weight: 700;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #2ab57d;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create Commodity</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Create Commodity</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Commodity</h4>
                            <p class="card-title-desc">Fill in the details to update Commodity.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('commodityup', ['id' => $commodity->id]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $commodity->name }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Commodity</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection

@section('jscontent')
<!-- Add any additional JS here -->
@endsection
