@extends('index_main')

@section('csscontent')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/css/themes/default.min.css" />

<link href="assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
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

    /* Product Card Styling */
    .product-card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 20px;
    }

    .product-info {
        margin-bottom: 15px;
    }

    .card-title {
        color: #4caf50;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        color: #555;
        margin-bottom: 5px;
    }

    .btn-primary {
        background-color: #4caf50;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #388e3c;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Styling */
    @media (max-width: 767.98px) {
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 20px;
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
                        <h4 class="mb-sm-0 font-size-18">Products</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
         

           <div class="row">
    @foreach ($products as $product)
    <div class="col-md-4">
        <div class="card product-card">
            <?php
                $images = $product->image;
            ?>

            <img class="card-img-top img-fluid" src="{{ asset('ProductImages/' . $images[0]) }}" alt="{{ $product->name }}">
            
            <div class="card-body">
                <div class="product-info">
                    <h4 class="card-title">{{ $product->commodity->name }}</h4>
                    <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
                    <p class="card-text"><strong>Selling Price:</strong> ₹{{ $product->rate }}&nbsp;{{ $product->unit }}</p>
                </div>
                <div class="form-group">
                    <label for="quantity-{{ $product->id }}">Quantity</label>
                    <input type="number" class="form-control quantity-input" id="quantity-{{ $product->id }}" min="1" value="1">
                </div>
                <div class="form-group">
                    <label for="unit-{{ $product->id }}">Unit</label>
                    <select class="form-control unit-select" id="unit-{{ $product->id }}">
                        <option value="kg">kg</option>
                        <option value="t">tonne</option>
                        <option value="mt">metric ton</option>
                        <option value="q">quintal</option>
                    </select>
                </div>
                <br>
               <button 
                 data-product-id="{{ $product->id }}" 
                 class="btn btn-primary waves-effect waves-light add-to-cart-btn add-to-purchase-request-btn">
                 Add 
              </button>
            </div>
        </div>
    </div>
    @endforeach
</div>





            <!-- end row -->

        </div>
    </div></div>
    @endsection

    @section('jscontent')

   <script src="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/alertify.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/libs/alertifyjs/build/alertify.min.js"></script>
    <script src="assets/js/pages/notification.init.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/alertify.min.js"></script>
   
    <script>
        $(".minus-to-cart-btn").on("click", function() {
            var productId = $(this).data("product-id");
            console.log("Product ID:", productId);
    
            $.ajax({
                url: "/cart/minus/" + productId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("AJAX response:", response);
                    if (response.success) {
                        alertify.alert("Product quantity decreased!", function() {
                            alertify.success("Ok");
                            // Reload the page after the alert is closed
                            window.location.reload();
                        });
                    } else {
                        alertify.error("Error removing product: " + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);
                    console.log("Response Text:", jqXHR.responseText);
                }
            });
        });
    
       $(".add-to-cart-btn").on("click", function() {
    var productId = $(this).data("product-id");
    var quantity = $("#quantity-" + productId).val();
    var unit = $("#unit-" + productId).val();

    console.log("Product ID:", productId);
    console.log("Quantity:", quantity);
    console.log("Unit:", unit);

    // Ensure all required data is captured
    if (!quantity || !unit) {
        console.error("Missing quantity or unit. Please check your input fields.");
        alertify.error("Please select both quantity and unit.");
        return; // Exit if data is missing
    }

    $.ajax({
        url: "/cart/add/" + productId,
        type: "GET",
        data: {
            quantity: quantity,
            unit: unit,
            _token: "{{ csrf_token() }}"
        },
        dataType: "json",
        beforeSend: function() {
            console.log("Sending AJAX request with the following data:");
            console.log("URL:", "/cart/add/" + productId);
            console.log("Data being sent:", { quantity: quantity, unit: unit });
        },
        success: function(response) {
            console.log("AJAX request was successful.");
            console.log("Server response:", response);

            if (response.success) {
                alertify.alert("Product added to cart!", function() {
                    alertify.success("Ok");
                    // Reload the page after the alert is closed
                    window.location.reload();
                });
            } else {
                console.warn("Server returned an error:", response.message);
                alertify.error("Error adding product: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed.");
            console.error("Status:", textStatus);
            console.error("Error Thrown:", errorThrown);
            console.error("Response Text:", jqXHR.responseText);

            // Optional: Show the user a more detailed error message
            alertify.error("An unexpected error occurred while adding the product to the cart.");
        }
    });
});

    
    
    $(".remove-from-cart-btn").on("click", function() {
            var productId = $(this).data("product-id");
            $.ajax({
                url: "/cart/remove/" + productId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        alertify.alert("Product removed from cart!", function() {
                            alertify.success("Ok");
                            // Reload the page after the alert is closed
                            window.location.reload();
                        });
                    } else {
                        alertify.error("Error removing product: " + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);
                }
            });
        });
        $(document).ready(function() {
    // Function to handle the button click event
    $(".add-to-purchase-request-btn").on("click", function() {
        // Retrieve product ID from button
        var productId = $(this).data("product-id");

        // Retrieve values from input fields
        var quantity = $("#quantity-" + productId).val();
        var unit = $("#unit-" + productId).val();

        // Log values to verify
        console.log("Adding product to purchase request with ID:", productId);
        console.log("Quantity:", quantity);
        console.log("Unit:", unit);

        // Call function to store product in purchase request table
        addProductToPurchaseRequest(productId, quantity, unit);
    });
});

function addProductToPurchaseRequest(productId, quantity, unit) {
    // Assume you have a way to get the logged-in user's ID
    var userId = "{{ Auth::id() }}"; // Get user ID from Laravel

    console.log("Attempting to store product in purchase request table with ID:", productId);
    console.log("Quantity:", quantity);
    console.log("Unit:", unit);
    console.log("User ID:", userId);

    $.ajax({
        url: "/purchase-request/add",
        type: "POST",
        data: {
            product_id: productId,
            quantity: quantity,
            unit: unit,
            user_id: userId, // Include user ID
            _token: "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(response) {
            console.log("AJAX success response:", response);

            if (response.success) {
                alertify.alert("Product added to cart and purchase request!", function() {
                    alertify.success("Ok");
                    // Optionally reload the page or update the UI
                    window.location.reload();
                });
            } else {
                console.error("Error message from server:", response.message);
                alertify.error("Error adding product to purchase request: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error (purchase request):", textStatus, errorThrown);
            console.error("Response text:", jqXHR.responseText);
            console.error("Response status:", jqXHR.status);
            console.error("Response headers:", jqXHR.getAllResponseHeaders());
        }
    });
}

</script> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

@endsection
