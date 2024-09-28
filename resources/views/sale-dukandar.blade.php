@extends('index_main')

@section('csscontent')
<style>
    body {
        background-color: #f9f9f9;
    }

    .main-content {
        padding: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #e6f7e6;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-title {
        color: #28a745;
    }

    .breadcrumb-item a {
        color: #28a745;
    }

    .form-group label {
        font-weight: bold;
        color: #28a745;
    }

    .form-control {
        border: 1px solid #28a745;
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-primary:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .main-content {
            padding: 10px;
        }

        .page-title-box {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title-box h4 {
            font-size: 16px;
        }

        .page-title-right {
            margin-top: 10px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-body {
            padding: 15px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-control {
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb-item {
            font-size: 12px;
        }

        .card-header h4 {
            font-size: 18px;
        }

        .form-group label {
            font-size: 13px;
        }

        .form-control {
            font-size: 13px;
        }

        .btn-primary {
            font-size: 14px;
            padding: 10px;
        }
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
                        <h4 class="mb-sm-0 font-size-18">Sale Products</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                <li class="breadcrumb-item active">Sale Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
        
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sale Products</h4>
                            <p class="card-title-desc">Fill in the details to Sale Product for a Shopkeeper.</p>
                        </div>
                        <div class="card-body p-4">
                            <!-- Create Sale Form -->
                            <form class="form-group" action="{{ route('store-sale') }}" method="POST">
                                @csrf
                                <input type="hidden" name="mandivyapari_id" value="{{ Auth::id() }}">
                            
                                <!-- Dukandar ID -->
                                <div class="mb-3">
                                    <label for="dukandar_id">Shopkeeper ID</label>
                                    <select class="form-control" name="dukandar_id" required>
                                        <option value="">Select Shops</option>
                                        @foreach($dukans as $dukandar)
                                            <option value="{{ $dukandar->id }}">{{ $dukandar->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Product ID -->
                                <div class="mb-3">
                                    <label for="product_id">Product ID</label>
                                    <select class="form-control" name="product_id" required>
                                        <option value="">Select Products</option>
                                       @foreach($products as $product)
                                            <?php
                                                // Fetch the product details from the database where the product id matches
                                                if($product->mandivyapari_id == auth()->user()->id) {
                                                    $p = DB::table('products')
                                                        ->where('id', $product->product_id)
                                                        ->first();
                                                        $c = DB::table('commodities')
                                                        ->where('id', $p->commodity_id)
                                                        ->first();
                                                        $v = DB::table('varieties')
                                                        ->where('id', $p->variety_id)
                                                        ->first();
                                            ?>
                                                <option value="{{ $product->id }}">{{ $product->id }} - [{{$c->name}}]-[{{$v->name}}]-[{{ $p->quality }}] </option>
                                            <?php
                                                }
                                            ?>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                                </div>
                            
                                <!-- Unit -->
                                <div class="mb-3">
                                    <label for="unit">Unit</label>
                                    <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter unit (e.g., kg, liter)" required>
                                </div>
                            
                                <!-- Price Per Unit -->
                                <div class="mb-3">
                                    <label for="price_per_unit">Price Per Unit</label>
                                    <input type="text" name="price_per_unit" id="price_per_unit" class="form-control" placeholder="Enter price per unit" required>
                                </div>
                            
                                <!-- Total -->
                                <div class="mb-3">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" id="total" class="form-control" placeholder="Enter total amount" required>
                                </div>
                            
                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@endsection

@section('jscontent')

@endsection