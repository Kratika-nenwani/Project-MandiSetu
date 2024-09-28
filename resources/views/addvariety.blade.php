@extends('index_main')

@section('csscontent')
<style>
    .main-content {
        padding: 20px;
    }

    .page-title-box {
        margin-bottom: 20px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    .card-title-desc {
        font-size: 14px;
        color: #6c757d;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #2ab57d;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .page-title-box {
            text-align: center;
        }

        .breadcrumb {
            justify-content: center;
        }

        .card-title {
            font-size: 20px;
        }

        .card-title-desc {
            font-size: 13px;
        }

        .btn-primary {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            padding: 10px;
        }

        .page-title-box {
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 18px;
        }

        .form-label {
            font-size: 14px;
        }
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
                        <h4 class="mb-sm-0 font-size-18 text-center text-sm-start">Variety</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Add Variety</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

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

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Variety</h4>
                            <p class="card-title-desc">Fill in the details to Add Variety.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('storevariety') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-lg-8">
                                        <label for="commodity_id" class="form-label">Commodity</label>
                                        <select class="form-control" id="commodity_id" name="commodity_id" required>
                                            <!-- Populate with commodities from database -->
                                            @foreach($commodities as $commodity)
                                                <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-8">
                                        <label for="name" class="form-label">Variety Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Variety</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End row -->
        </div>
        <!-- Container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection

@section('jscontent')
<!-- Add any additional JS here -->
@endsection