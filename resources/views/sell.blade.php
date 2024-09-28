@extends('index_main')

@section('csscontent')
<!-- Add any additional CSS here -->
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-8">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Sell Quality</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Sell Quality</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body p-4">
                          

                            <!-- Form Container -->
                            <div >
                                <!-- Default View (hidden) -->
                                <div id="default-view" class="form-group">
                                    <p>Select an action to display the form fields.</p>
                                </div>

                                <!-- Buy Form -->
                             

                                <!-- Sell Form -->
                                {{-- <form id="sell-form" class="form-group " method="POST" action="/sell">
                                    @csrf
                                    <!-- CSRF Token for security -->
                                    <div class="mb-3">
                                        <label for="commodity-sell" class="form-label">Commodity</label>
                                        <select class="form-select" id="commodity-sell" name="commodity" onchange="fetchVariantsSell(this.value)">
                                            <option value="">Select Commodity</option>
                                            @foreach($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="variant-sell" class="form-label">Variant</label>
                                        <select class="form-select" id="variant-sell" name="variant">
                                            <option value="">Select Variant</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity-sell" class="form-label">Quantity</label>
                                        <input class="form-control" type="number" id="quantity-sell" name="quantity" placeholder="Enter quantity">
                                    </div>
                                  
                                    <div class="mb-3">
                                        <label for="buy-price" class="form-label">Price</label>
                                        <input class="form-control" type="text" id="buy-price" name="rat" placeholder="Enter buy price">
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label for="commodity-image-sell" class="form-label">Commodity Image</label>
                                        <input class="form-control" type="file" id="commodity-image-sell" name="image">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form> --}}

                                <form class="form-group" action="{{ route("store-sale") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="mandivyapari_id" value="{{ Auth::id() }}">
                                    <!-- Mandivyapari ID -->
                                   
    
                                    <!-- Dukandar ID -->
                                    <div class="mb-3">
                                        <label for="dukandar_id">Shopkeeper ID</label>
                                       
                                            <select class=" form-control" name="dukandar_id"  required>
                                                <option value="">Select Shops</option>
                                                @foreach($dukans as $dukandar)
                                                    <option value="{{ $dukandar->id }}">{{ $dukandar->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
    
                                    <!-- Product ID -->
                                    <div class="mb-3">
                                        <label for="product_id">Product ID</label>
                                       
                                            <select class=" form-control" name="product_id"  required>
                                                <option value="">Select Products</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->commodity_id }}">{{ $product->commodity->name  }}</option>
                                                @endforeach
                                            </select>
                                    </div>
    
                                    <!-- Quantity -->
                                    <div class="mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" required>
                                    </div>
    
                                    <!-- Unit -->
                                    <div class="mb-3">
                                        <label for="unit">Unit</label>
                                        <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter unit" required>
                                    </div>
    
                                    <!-- Price Per Unit -->
                                    <div class="mb-3">
                                        <label for="price_per_unit">Price Per Unit</label>
                                        <input type="text" name="price_per_unit" id="price_per_unit" class="form-control" placeholder="Enter price"
                                            required>
                                    </div>
    
                                    <!-- Total -->
                                    <div class="mb-3">
                                        <label for="total">Total</label>
                                        <input type="text" name="total" id="total" class="form-control" required placeholder="enter total amount">
                                    </div>
    
                                    <!-- Submit Button -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>


                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showForm(action) {
        $('#default-view').addClass('d-none');
        $('#buy-form').addClass('d-none');
        $('#sell-form').addClass('d-none');

        if (action === 'buy') {
            $('#buy-form').removeClass('d-none');
        } else if (action === 'sell') {
            $('#sell-form').removeClass('d-none');
        }
    }

    function fetchVariants(commodityId) {
        if (commodityId) {
            $.ajax({
                url: `/fetch-variants/${commodityId}`
                , method: 'GET'
                , success: function(data) {
                    console.log('Fetched variants:', data); // Debugging output

                    const variantSelect = $('#variant');
                    variantSelect.empty(); // Clear existing options
                    variantSelect.append('<option value="">Select Variant</option>'); // Add default option

                    data.variants.forEach(function(variant) {
                        variantSelect.append($('<option>', {
                            value: variant.id
                            , text: variant.name
                        }));
                    });
                }
                , error: function(xhr, status, error) {
                    console.error('Error fetching variants:', status, error); // Debugging output
                }
            });
        }
    }

    function fetchVariantsSell(commodityId) {
        if (commodityId) {
            $.ajax({
                url: `/fetch-variants/${commodityId}`
                , method: 'GET'
                , success: function(data) {
                    console.log('Fetched variants (sell):', data); // Debugging output

                    const variantSelect = $('#variant-sell');
                    variantSelect.empty(); // Clear existing options
                    variantSelect.append('<option value="">Select Variant</option>'); // Add default option

                    data.variants.forEach(function(variant) {
                        variantSelect.append($('<option>', {
                            value: variant.id
                            , text: variant.name
                        }));
                    });
                }
                , error: function(xhr, status, error) {
                    console.error('Error fetching variants (sell):', status, error); // Debugging output
                }
            });
        }
    }

</script>

@endsection


{{-- @extends('index_main')

@section('csscontent')
<!-- Add any additional CSS here -->
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-8">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Buy/Sell</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Buy/Sell</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <h4 class="card-title">I Want to*</h4>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" onclick="showForm('buy')">Buy</button>
                                <button type="button" class="btn btn-secondary" onclick="showForm('sell')">Sell</button>
                            </div>

                            <!-- Search Form -->
                            <div class="mb-3">
                                <label for="search-commodity" class="form-label">Search Commodities</label>
                                <input class="form-control" type="text" id="search-commodity" placeholder="Search for commodities">
                                <button type="button" class="btn btn-info mt-2" onclick="searchCommodities()">Search</button>
                            </div>

                            <!-- Container for search results (commodity buttons) -->
                            <div id="commodity-buttons" class="d-none"></div>

                            <!-- Form Container -->
                            <div id="form-container">
                                <!-- Default View (hidden) -->
                                <div id="default-view" class="form-group">
                                    <p>Select an action to display the form fields.</p>
                                </div>

                                <!-- Buy Form -->
                                <form id="buy-form" class="form-group d-none" method="POST" action="/buy">
                                    @csrf
                                    <!-- CSRF Token for security -->
                                    <div class="mb-3">
                                        <label for="commodity" class="form-label">Commodity</label>
                                        <select class="form-select" id="commodity" name="commodity_id" onchange="fetchVariants(this.value)">
                                            <option value="">Select Commodity</option>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="variant" class="form-label">Variant</label>
                                        <select class="form-select" id="variant" name="variant_id">
                                            <option value="">Select Variant</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input class="form-control" type="number" id="quantity" name="quantity" placeholder="Enter quantity">
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Unit</label>
                                        <select class="form-select" id="unit" name="unit">
                                            <option>Kg</option>
                                            <option>MT</option>
                                            <option>Quantal</option>
                                            <option>Ton</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selling-price" class="form-label">Selling Price</label>
                                        <input class="form-control" type="text" id="selling-price" name="selling_price" placeholder="Enter selling price">
                                    </div>
                                    <div class="mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <select class="form-select" id="state" name="state">
                                            <!-- Populate with states from database -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="district" class="form-label">District</label>
                                        <select class="form-select" id="district" name="district">
                                            <!-- Populate with districts from database -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="commodity-image" class="form-label">Commodity Image</label>
                                        <input class="form-control" type="file" id="commodity-image" name="commodity_image">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Submit Buy Form</button>
                                    </div>
                                </form>

                                <!-- Sell Form -->
                                <form id="sell-form" class="form-group d-none" method="POST" action="/sell">
                                    @csrf
                                    <!-- CSRF Token for security -->
                                    <div class="mb-3">
                                        <label for="commodity-sell" class="form-label">Commodity</label>
                                        <select class="form-select" id="commodity-sell" name="commodity_id" onchange="fetchVariantsSell(this.value)">
                                            <option value="">Select Commodity</option>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="variant-sell" class="form-label">Variant</label>
                                        <select class="form-select" id="variant-sell" name="variant_id">
                                            <option value="">Select Variant</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity-sell" class="form-label">Quantity</label>
                                        <input class="form-control" type="number" id="quantity-sell" name="quantity" placeholder="Enter quantity">
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit-sell" class="form-label">Unit</label>
                                        <select class="form-select" id="unit-sell" name="unit">
                                            <option>Kg</option>
                                            <option>MT</option>
                                            <option>Quantal</option>
                                            <option>Ton</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="buy-price" class="form-label">Buy Price</label>
                                        <input class="form-control" type="text" id="buy-price" name="buy_price" placeholder="Enter buy price">
                                    </div>
                                    <div class="mb-3">
                                        <label for="state-sell" class="form-label">State</label>
                                        <select class="form-select" id="state-sell" name="state">
                                            <!-- Populate with states from database -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="district-sell" class="form-label">District</label>
                                        <select class="form-select" id="district-sell" name="district">
                                            <!-- Populate with districts from database -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="commodity-image-sell" class="form-label">Commodity Image</label>
                                        <input class="form-control" type="file" id="commodity-image-sell" name="commodity_image">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Submit Sell Form</button>
                                    </div>
                                </form>
                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showForm(action) {
        $('#default-view').addClass('d-none');
        $('#buy-form').addClass('d-none');
        $('#sell-form').addClass('d-none');

        if (action === 'buy') {
            $('#buy-form').removeClass('d-none');
        } else if (action === 'sell') {
            $('#sell-form').removeClass('d-none');
        }
    }

    function searchCommodities() {
        const searchTerm = $('#search-commodity').val();

        if (searchTerm) {
            $.ajax({
                url: `/search-commodities/${searchTerm}`,
                method: 'GET',
                success: function(data) {
                    console.log('Search results:', data); // Debugging output

                    const buttonsContainer = $('#commodity-buttons');
                    buttonsContainer.empty(); // Clear previous search results
                    buttonsContainer.addClass('d-none'); // Hide the container initially

                    const commoditySelect = $('#commodity, #commodity-sell');
                    commoditySelect.empty(); // Clear existing options

                    if (data.commodities.length) {
                        data.commodities.forEach(function(commodity) {
                            const button = $('<button>', {
                                class: 'btn btn-info me-2 mb-2',
                                text: commodity.name,
                                click: function() {
                                    $('#commodity').val(commodity.id);
                                    $('#commodity-sell').val(commodity.id);
                                    fetchVariants(commodity.id);
                                    fetchVariantsSell(commodity.id);
                                }
                            });
                            buttonsContainer.append(button);

                            // Add options to the dropdown
                            const option = $('<option>', {
                                value: commodity.id,
                                text: commodity.name
                            });
                            commoditySelect.append(option);
                        });

                        // Show the buttons container
                        buttonsContainer.removeClass('d-none');
                    } else {
                        buttonsContainer.append('<p>No commodities found.</p>');
                        buttonsContainer.removeClass('d-none');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error searching commodities:', status, error); // Debugging output
                }
            });
        }
    }

    function fetchVariants(commodityId) {
        if (commodityId) {
            $.ajax({
                url: `/fetch-variants/${commodityId}`,
                method: 'GET',
                success: function(data) {
                    const variantSelect = $('#variant');
                    variantSelect.empty(); // Clear existing options

                    if (data.variants.length) {
                        data.variants.forEach(function(variant) {
                            const option = $('<option>', {
                                value: variant.id,
                                text: variant.name
                            });
                            variantSelect.append(option);
                        });
                    } else {
                        variantSelect.append('<option>No variants available.</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching variants:', status, error); // Debugging output
                }
            });
        }
    }

    function fetchVariantsSell(commodityId) {
        if (commodityId) {
            $.ajax({
                url: `/fetch-variants/${commodityId}`,
                method: 'GET',
                success: function(data) {
                    const variantSelect = $('#variant-sell');
                    variantSelect.empty(); // Clear existing options

                    if (data.variants.length) {
                        data.variants.forEach(function(variant) {
                            const option = $('<option>', {
                                value: variant.id,
                                text: variant.name
                            });
                            variantSelect.append(option);
                        });
                    } else {
                        variantSelect.append('<option>No variants available.</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching variants:', status, error); // Debugging output
                }
            });
        }
    }
</script>
@endsection --}}


