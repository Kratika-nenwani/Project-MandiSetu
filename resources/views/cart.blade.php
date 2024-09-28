@extends('index_main')

@section('csscontent')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Overall Page Styling */
    .main-content.cart-page {
        background-color: #f9f9f9;
        padding: 20px;
    }

    .page-title-box {
        border-bottom: 1px solid #e1e1e1;
        padding-bottom: 15px;
    }

    .page-title-box h4 {
        color: #333;
    }

    .breadcrumb-item a {
        color: #007bff;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    /* Card Styling */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    /* Table Styling */
    .cart-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .cart-table thead th {
        background-color: #e8f5e9;
        color: #388e3c;
        font-weight: bold;
    }

    .cart-table tbody tr {
        background-color: #fff;
        border-bottom: 1px solid #ddd;
    }

    .cart-table tbody tr:nth-child(even) {
        background-color: #f1f8e9;
    }

    .cart-table img {
        max-width: 100px;
        border-radius: 4px;
    }

    .cart-table input[type="number"] {
        width: 60px;
        text-align: center;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .cart-table td,
    .cart-table th {
        padding: 12px;
        text-align: center;
    }

    .btn-remove {
        background-color: #e57373;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-remove:hover {
        background-color: #c62828;
    }

    .btn-checkout {
        background-color: #4caf50;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-checkout:hover {
        background-color: #388e3c;
    }

    .cart-total {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

   /* Cart Summary */
.cart-summary {
    margin-top: 20px;
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    float: right;
    width: 320px; 
    position: relative; 
}

.cart-summary h3 {
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    border-bottom: 2px solid #e8f5e9;
    padding-bottom: 10px;
}

.cart-summary h6 {
    font-size: 16px;
    color: #333;
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.cart-summary h6 span {
    font-weight: bold;
    color: #388e3c;
}

.cart-summary .btn-checkout {
    display: block;
    width: 100%;
    background-color: #4caf50;
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    text-align: center;
    transition: background-color 0.3s;
    margin-top: 20px;
}

.cart-summary .btn-checkout:hover {
    background-color: #388e3c;
}

.cart-summary::before {
    content: "";
    position: absolute;
    top: -15px;
    right: 10px;
    width: 0;
    height: 0;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-bottom: 15px solid #fff;
}


 /* Empty Cart Message Styling */
 .empty-cart-message {
        text-align: center;
        padding: 50px;
        color: #888;
        font-size: 24px;
        font-weight: bold;
    }

    .empty-cart-message a {
        color: #388e3c;
        text-decoration: none;
        font-size: 18px;
    }

    .empty-cart-message a:hover {
        text-decoration: underline;
    }


</style>
@endsection

@section('content')

<div class="main-content cart-page">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Cart</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                @if (count($cart) > 0)
                                <table class="table table-bordered dt-responsive nowrap w-100 cart-table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $item)
                                        @php
                                            // Fetch the product based on item ID
                                            $product = App\Models\Product::find($item['id']);
                                            
                                            // Check if the image field is already an array
                                            $images = is_array($product->image) ? $product->image : json_decode($product->image, true);
                                        @endphp
                                        <tr>
                                            <td>
                                                @if (is_array($images) && !empty($images))
                                                    <img src="{{ asset('ProductImages/' . $images[0]) }}" class="blur-up lazyload" alt="" style="width: 100px;">
                                                @else
                                                    <img src="{{ asset('default-image-path.jpg') }}" class="blur-up lazyload" alt="No Image" style="width: 100px;">
                                                @endif
                                            </td>
                                            <td>{{ $product->commodity->name }}</td>
                                            <td>₹ {{ $item['price'] }}</td>
                                            <td>
                                                {{ $item['quantity'] }}{{ $item['unit'] }} &nbsp;&nbsp;&nbsp;
                                            </td>
                                            <td>₹ {{ $item['price'] * $item['quantity'] }}</td>
                                            <td>
                                                <a data-product-id="{{ $item['id'] }}" class="remove-from-cart-btn table cart-page__table__remove">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>

                                <!-- Cart Summary -->
                                <div class="cart-summary">
                                    <h3>Cart Totals</h3>
                                    <h6>SubTotal<span>₹{{ number_format($totalCost, 2) }}</span></h6>
                                    <h6>Shipping cost <span>₹{{ number_format($shippingCost, 2) }}</span></h6>
                                    <h6>Total <span>₹{{ number_format($totalCost + $shippingCost, 2) }}</span></h6>
                                    <br>
                                    <a href="{{ route('checkout') }}" class="btn-checkout float-end">Proceed to Checkout</a>
                                </div>
                                <br>

                                <!-- Checkout Button -->

                            
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Display a message if the cart is empty -->
                    <div class="empty-cart-message">
                        <p>Your cart is currently empty.</p>
                        <a href="{{ route('buy') }}">Continue Shopping</a>
                    </div>
                    @endif
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

@endsection

@section('jscontent')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(".minus-to-cart-btn").on("click", function() {
        var productId = $(this).data("product-id");
        console.log("Product ID:", productId); // Debug: Log the product ID

        $.ajax({
            url: "/cart/minus/" + productId
            , type: "GET", // Assuming your minuscart route uses the GET method
            dataType: "json"
            , success: function(response) {
                console.log("AJAX response:", response); // Debug: Log the AJAX response
                if (response.success) {
                    // Show success message or notification
                    window.location.reload();
                } else {
                    // Handle error message if there's an issue
                    alert("Error removing product: " + response.message);
                }
            }
            , error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown); // Debug: Log the AJAX error details
                console.log("Response Text:", jqXHR.responseText); // Debug: Log the full response text
            }
        });
    });


    $(".add-to-cart-btn").on("click", function() {
        var productId = $(this).data("product-id");

        // Debug: Log the product ID
        console.log("Adding product to cart with ID:", productId);

        $.ajax({
            url: "/cart/add/" + productId, // Replace with your actual route
            type: "GET"
            , dataType: "json"
            , success: function(response) {
                // Debug: Log the server response
                console.log("Server response:", response);

                if (response.success) {
                    // Show success message or notification
                    if (response.alert) {
                        alert("Product added to cart!");
                    }
                    window.location.reload();
                } else {
                    // Handle error message if there's an issue
                    alert("Error adding product: " + response.message);
                }
            }
            , error: function(jqXHR, textStatus, errorThrown) {
                // Handle server errors
                console.error("AJAX error:", textStatus, errorThrown);
                console.error("Response text:", jqXHR.responseText);
            }
        });
    });


    $(".remove-from-cart-btn").on("click", function() {
        var productId = $(this).data("product-id");
        var currentElement = $(this);
        $.ajax({
            url: "/cart/remove/" + productId
            , type: "GET"
            , dataType: "json"
            , success: function(response) {
                if (response.success) {
                    window.location.reload();
                    if (response.alert) {
                        alert("Product delete to cart!");
                    }
                } else {
                    alert("Error delete product: " + response.message);
                }
            }
            , error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    });

</script>

@endsection
