
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
                        <h4 class="mb-sm-0 font-size-18">Update Product</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Update Product</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Quality</h4>
                            <p class="card-title-desc">Fill in the details to update a quality.</p>
                        </div>
                        <div class="card-body p-4">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="mb-3">
                                    <label for="commodity_id" class="form-label">Commodity</label>
                                    <select class="form-control" id="commodity_id" name="commodity_id" required>
                                        <!-- Populate with commodities from database -->
                                        @foreach($commodities as $commodity)
                                            <option value="{{ $commodity->id }}" {{ $product->commodity_id == $commodity->id ? 'selected' : '' }}>{{ $commodity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>        

                                <div class="mb-3">
                                    <label for="variety_id" class="form-label">Variety</label>
                                    <select class="form-control" id="variety_id" name="variety_id" required>
                                        <!-- Populate with varieties from database -->
                                        @foreach($varieties as $variety)
                                            <option value="{{ $variety->id }}" {{ $product->variety_id == $variety->id ? 'selected' : '' }}>{{ $variety->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quality" class="form-label">Quality</label>
                                    <input type="text" class="form-control" id="quality" name="quality" value="{{ $product->quality }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input type="text" class="form-control" id="rate" name="rate" value="{{ $product->rate }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $product->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
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

