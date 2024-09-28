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
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Quality</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Add </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                       
                            {{-- <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="mb-3">
                                    <label for="commodity_id" class="form-label">Commodity</label>
                                    <select class="form-control" id="commodity_id" name="commodity_id" required>
                                        <!-- Populate with commodities from database -->
                                        @foreach($commodities as $commodity)
                                            <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>        

                                <div class="mb-3">
                                    <label for="variety_id" class="form-label">Variety</label>
                                    <select class="form-control" id="variety_id" name="variety_id" required>
                                        <!-- Populate with varieties from database -->
                                        @foreach($varieties as $variety)
                                            <option value="{{ $variety->id }}">{{ $variety->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="quality" class="form-label">Quality</label>
                                    <input type="text" class="form-control" id="quality" name="quality" required>
                                </div>

                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input type="text" class="form-control" id="rate" name="rate"  required>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" required>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </form> --}}

                            <form id="create-commodity-form" class="form-group" action="{{ route('storeproduct') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                               
                                   
                                {{-- <div class="mb-3">
                                    <label for="commodity-sell" class="form-label">Commodity Name</label>
                                    <div class="input-group">
                                        <input type="text" id="commodity-search" class="form-control mb-2" placeholder="Search commodities...">
                                        <select class="form-select" id="commodity-sell" name="commodity_id" onchange="fetchVariantsSell(this.value)" required>
                                            <option value="">Select Commodity</option>
                                            @foreach($commodities as $commodity)
                                                <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-secondary" id="add-commodity-name-btn">Add</button>
                                    </div>
                                </div> --}}
                                
                                   
                               
                                
                                <div class="mb-3">
                                    <label for="commodity-name" class="form-label">Commodity Name</label>
                                    <div class="input-group">
                                        <select class="form-select" id="commodity-sell" name="commodity_id" onchange="fetchVariantsSell(this.value)" required>
                                            <option value="">Select Commodity</option>
                                            @foreach($commodities as $commodity)
                                                <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                            @endforeach
                                        </select>
                                      
                                    </div>
                                </div>
                                
                                <div class="mb-3" id="new-commodity-name-div" style="display: none;">
                                    <label for="new-commodity-name" class="form-label">New Commodity Name</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="new-commodity-name" name="new_commodity_name" placeholder="Enter new commodity name">
                                    </div>
                                    <label for="new-variety-name" class="form-label mt-2">New Variety Name</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="new-variety-name" name="new_variety_name" placeholder="Enter new variety name">
                                        <button type="button" class="btn btn-primary" id="save-commodity-name-btn">Save</button>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="variant-sell" class="form-label">Variant</label>
                                    <select class="form-select" id="variant-sell" name="variety_id">
                                        <option value="">Select Variant</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="quality" class="form-label">Quality</label>
                                    <input class="form-control" type="text" id="quality" name="quality" placeholder="Enter quality" required>
                                </div>
    
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input class="form-control" type="text" id="rate" name="rate" placeholder="Enter rate" required>
                                </div>
    
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input class="form-control" type="text" id="unit" name="unit" placeholder="Enter rate" required>
                                </div>
    
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input class="form-control" type="text" id="quantity" name="quantity" placeholder="Enter rate" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="commodity-image" class="form-label">Images</label>
                                    <div id="image-container">
                                        <input class="form-control" type="file" id="commodity-image" name="images[]" required>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-secondary" id="add-image-btn">Add Image</button>
                                </div>
                                
                                
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantity');
    const quantityButtons = document.querySelectorAll('#quantity-type-buttons .btn');

    // Quantity Type Buttons
    quantityButtons.forEach(button => {
        button.addEventListener('click', function () {
            quantityButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            quantityInput.disabled = false;
            switch (this.id) {
                case 'kg-btn':
                    quantityInput.placeholder = "Enter quantity in Kg";
                    break;
                case 'mt-btn':
                    quantityInput.placeholder = "Enter quantity in MT";
                    break;
                case 'quantal-btn':
                    quantityInput.placeholder = "Enter quantity in Quantal";
                    break;
                case 'ton-btn':
                    quantityInput.placeholder = "Enter quantity in Ton";
                    break;
            }
        });
    });

    const addCommodityNameBtn = document.getElementById('add-commodity-name-btn');
    const newCommodityNameDiv = document.getElementById('new-commodity-name-div');
    const saveCommodityNameBtn = document.getElementById('save-commodity-name-btn');
    const newCommodityNameInput = document.getElementById('new-commodity-name');
    const newVarietyNameInput = document.getElementById('new-variety-name');
    const commodityNameSelect = document.getElementById('commodity-name');
    const commodityTypeSelect = document.getElementById('commodity-type');
    const imageContainer = document.getElementById('image-container');
    const addImageBtn = document.getElementById('add-image-btn');

    // Add Commodity Event Handler
    addCommodityNameBtn.addEventListener('click', function () {
        newCommodityNameDiv.style.display = 'block';
        console.log('Add Commodity button clicked');
    });

    // Save Commodity Event Handler
    saveCommodityNameBtn.addEventListener('click', function () {
        const newCommodityName = newCommodityNameInput.value.trim();
        const newVarietyName = newVarietyNameInput.value.trim();

        console.log('New Commodity Name:', newCommodityName);
        console.log('New Variety Name:', newVarietyName);

        if (newCommodityName && newVarietyName) {
            $.ajax({
                url: '{{ route("savecommodity") }}', // Your route for saving commodity and variety
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    name: newCommodityName, // Match with the server-side expected field name
                    variety_name: newVarietyName // Match with the server-side expected field name
                },
                success: function (response) {
                    console.log('Response:', response);
                    alert('Successfully saved commodity and variants');
                    window.location.reload(); // Reload the window after success
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Failed to save commodity and variety. Please try again.');
                }
            });
        } else {
            alert('Please enter both commodity name and variety name.');
        }
    });

    addImageBtn.addEventListener('click', function () {
        const newImageInput = document.createElement('input');
        newImageInput.type = 'file';
        newImageInput.name = 'images[]';
        newImageInput.classList.add('form-control', 'mt-2');
        imageContainer.appendChild(newImageInput);
    });
});

function fetchVariants(commodityId) {
    if (commodityId) {
        $.ajax({
            url: `/fetch-variants/${commodityId}`,
            method: 'GET',
            success: function (data) {
                console.log('Fetched variants:', data); // Debugging output

                const variantSelect = $('#variant');
                variantSelect.empty(); // Clear existing options
                variantSelect.append('<option value="">Select Variant</option>'); // Add default option

                data.variants.forEach(function (variant) {
                    variantSelect.append($('<option>', {
                        value: variant.id,
                        text: variant.name
                    }));
                });
            },
            error: function (xhr, status, error) {
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
            success: function (data) {
                console.log('Fetched variants (sell):', data); // Debugging output

                const variantSelect = $('#variant-sell');
                variantSelect.empty(); // Clear existing options
                variantSelect.append('<option value="">Select Variant</option>'); // Add default option

                data.variants.forEach(function (variant) {
                    variantSelect.append($('<option>', {
                        value: variant.id,
                        text: variant.name
                    }));
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching variants (sell):', status, error); // Debugging output
            }
        });
    }
}

</script>
<!-- Add any additional JS here -->
@endsection
