
@extends('index_main')

@section('csscontent')

    <style>
        /* Overall Page Styling */
        .main-content {
            background-color: #f4f7f6;
            padding: 20px;
        }

        .page-title-box {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .page-title-box h4 {
            color: #333;
            font-weight: bold;
        }

        .breadcrumb-item a {
            color: #4caf50;
        }

        .breadcrumb-item.active {
            color: #9e9e9e;
        }

        /* Card Styling */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            background-color: #e8f5e9;
            border-bottom: 1px solid #d0e1d4;
            color: #4caf50;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            color: #333;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-primary {
            background-color: #4caf50;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #388e3c;
        }

        /* Order Summary Styling */
        .order-summary {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: sticky;
            top: 20px;
        }

        .order-summary h4 {
            color: #4caf50;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            margin-right: 15px;
        }

        .order-item-info {
            flex: 1;
        }

        .order-item-name {
            font-weight: bold;
        }

        .order-item-details {
            color: #777;
        }

        .order-item-price {
            color: #333;
            font-weight: bold;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #e0e0e0;
        }

        .order-total span {
            font-weight: bold;
        }

        .order-total:last-child {
            border-bottom: 1px solid #e0e0e0;
            font-size: 18px;
            color: #333;
        }


        .btn-checkout {
    background-color: #4caf50; /* Light Green Color */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.btn-checkout:hover {
    background-color: #388e3c; /* Slightly Darker Green */
}

.float-end {
    float: right;
    margin: 10px 0;
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
                        <h4 class="mb-sm-0 font-size-18">Checkout</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Checkout</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Checkout</h4>
                            <p class="card-title-desc">Fill in the details</p>
                        </div>
                        <div class="card-body p-4">
                            <form id="create-commodity-form" class="form-group" action="{{ route('savecheckout') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Enter Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="text" id="email" name="email" placeholder="Enter Email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required
                                           pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                                    <div id="phone-error" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Shipping Address</label>
                                    <input class="form-control" id="address" name="address" placeholder="Enter Shipping Address" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input class="form-control" id="city" name="city" placeholder="Enter city" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input class="form-control" id="state" name="state" placeholder="Enter state" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input class="form-control" id="country" name="country" placeholder="Enter country" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="zipcode" class="form-label">ZipCode</label>
                                    <input class="form-control" id="zipcode" name="zipcode" placeholder="Enter zipcode" rows="3" required>
                                </div>
                                
                                <div class="mb-3">
                                    <input id="test-button" type="submit" class="btn btn-primary"></input>
                                </div>
                           
                        </div>
                    </div>
                </div>
                <!-- end col -->

            
                <div class="col-md-4">
                    <div class="order-summary">
                        <h4>Order Summary</h4>
                        @php
                            $subtotal = 0;
                        @endphp
                
                        @foreach ($product as $item)
                            @php
                                // Fetch the product based on item ID
                                $product = App\Models\Product::find($item['id']);
                                $images = $product->image;
                                // $images = json_decode($product->image);
                                $itemSubtotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemSubtotal;
                            @endphp
                            <div class="order-item">
                                <img src="{{ asset('ProductImages/' . $images[0]) }}" alt="Item Image" style="width: 50px; height: 50px;">
                                <div class="order-item-info">
                                    <div class="order-item-name">{{ $product->name }} x {{ $item['quantity'] }}</div>
                                    <div class="order-item-details">{{ $product->commodity->name }}</div>
                                </div>
                                <div class="order-item-price">₹{{ number_format($itemSubtotal, 2) }}</div>
                            </div>
                
                            <input type="hidden" name="product_details[]" value="{{ $product->commodity->name }}">
                            <input type="hidden" name="product_details[]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="product_details[]" value="{{ number_format($itemSubtotal, 2) }}">
                        @endforeach
                
                        <div class="order-total">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="order-total">
                            <span>Shipping</span>
                            <span>₹{{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="order-total">
                            <span>Total</span>
                            <span>₹{{ number_format($subtotal + $shipping, 2) }}</span>
                        </div>
                        
                       
                    </div>
                      {{-- <a href="{{ route('checkout') }}" class="btn-checkout float-end">View Order Details</a> --}}
                 
                </div>
              

            </form>
                <!-- end col -->
                
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

@endsection

@section('jscontent')
<script src="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/alertify.min.js"></script>
    <script>
        document.getElementById("test-button").addEventListener("click", function() {
            alertify.alert("Test Alert", function() {
                alertify.success("Checkout Successfully");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    alertify.error('{{ $error }}');
                @endforeach
            @endif
            @if (session('success'))
                alertify.success('{{ session('success') }}');
            @endif
        });
    </script>
    <script>
        document.getElementById('phone').addEventListener('input', function() {
            var phoneInput = this.value;
            var errorElement = document.getElementById('phone-error');
            
            // Regular expression to check for 10-digit phone number
            var phonePattern = /^[0-9]{10}$/;
    
            if (!phonePattern.test(phoneInput)) {
                errorElement.textContent = 'Please enter a valid 10-digit phone number.';
            } else {
                errorElement.textContent = '';
            }
        });
    </script>
    <!-- You can add any custom JavaScript here -->
@endsection

