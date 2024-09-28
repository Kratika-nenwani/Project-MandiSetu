@extends('index_main')

@section('csscontent')
<link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

<!-- color picker css -->
<link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/classic.min.css" /> <!-- 'classic' theme -->
<link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/monolith.min.css" /> <!-- 'monolith' theme -->
<link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/nano.min.css" /> <!-- 'nano' theme -->

<!-- datepicker css -->
<link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">

<!-- preloader css -->
<link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
{{-- <style>
    /* CSS to style the buttons as small circles with space around them */
    #quantity-type-buttons .btn {
        border-radius: 50%;
        width: 55px;
        height: 45px;
        padding: 0;
        font-size: 14px;
        margin: 0 5px;
    }

    #quantity-type-buttons .btn.active {
        background-color: #007bff;
        color: #fff;
    }

    .center-card {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
       
    }

    .card {
        width: 100%;
        max-width: 800px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 20px;
    }

</style> --}}

<style>
    /* CSS to style the buttons as small circles with space around them */
    #quantity-type-buttons .btn {
        border-radius: 50%;
        width: 40px; /* Reduced width for small size */
        height: 40px; /* Reduced height for small size */
        padding: 0;
        font-size: 12px; /* Smaller font size */
        margin: 0 3px; /* Reduced margin for small size */
    }

    #quantity-type-buttons .btn.active {
        background-color: #007bff;
        color: #fff;
    }

    .center-card {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        width: 100%;
        max-width: 800px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 20px;
    }

    @media (max-width: 576px) {
        .card {
            padding: 15px;
        }

        #quantity-type-buttons .btn {
            width: 35px; /* Further reduced width for small screens */
            height: 35px; /* Further reduced height for small screens */
            font-size: 10px; /* Smaller font size for small screens */
            margin: 0 2px; /* Smaller margin for small screens */
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
                        <h4 class="mb-sm-0 font-size-18">Create Quality</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                <li class="breadcrumb-item active">Create Quality</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

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


            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Quality</h4>
                            <p class="card-title-desc">Fill in the details to create a new Quality.</p>
                        </div>
                        <div class="card-body p-4">
                            <!-- Create Commodity Form -->
                            <form id="create-commodity-form" class="form-group" action="{{ route('storeproduct') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">




                                <div class="mb-3">
                                    <label for="commodity-sell" class="form-label">Commodity Name</label>

                                    <select class=" form-control" id="commodity-sell" name="commodity_id" onchange="fetchVariantsSell(this.value)" required>
                                        <option value="">Select Commodity</option>
                                        @foreach($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                        @endforeach
                                    </select>

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
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <div id="quantity-type-buttons" class="btn-group mb-2" role="group" aria-label="Quantity Type">
                                        <button type="button" class="btn btn-secondary" style="background-color: #2ab57d; border-color: #2ab57d; color: #ffffff;" id="kg-btn">Kg</button>
                                        <button type="button" class="btn btn-secondary" style="background-color: #2ab57d; border-color: #2ab57d; color: #ffffff;" id="mt-btn">MT</button>
                                        <button type="button" class="btn btn-secondary" style="background-color: #2ab57d; border-color: #2ab57d; color: #ffffff;" id="quantal-btn">Quantal</button>
                                        <button type="button" class="btn btn-secondary" style="background-color: #2ab57d; border-color: #2ab57d; color: #ffffff;" id="ton-btn">Ton</button>
                                    </div>
                                    <input class="form-control" type="number" id="quantity" name="quantity" placeholder="Enter quantity" disabled required>
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input class="form-control" id="state" name="state" placeholder="Enter State Name" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input class="form-control" id="district" name="district" placeholder="Enter District Name" rows="3" required>
                                </div>

                                <div class="mb-3">
                                    <label for="commodity-image" class="form-label">Images</label>
                                    <div id="image-container">
                                        <input class="form-control" type="file" id="commodity-image" name="images[]" multiple="multiple" required>
                                    </div>
                                    <br>

                                    {{-- <button type="button" class="btn btn-secondary" id="add-image-btn" style="background-color: #2ab57d; border-color: #2ab57d; color: #ffffff;">
                                        Add Image
                                    </button> --}}

                                </div>


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
<script src="assets/js/pages/form-advanced.init.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const quantityButtons = document.querySelectorAll('#quantity-type-buttons .btn');

        // Quantity Type Buttons
        quantityButtons.forEach(button => {
            button.addEventListener('click', function() {
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



        document.getElementById('add-image-btn').addEventListener('click', function() {
            const imageContainer = document.getElementById('image-container');
            const newImageInput = document.createElement('input');
            newImageInput.classList.add('form-control', 'mt-2');
            newImageInput.type = 'file';
            newImageInput.name = 'images[]';
            imageContainer.appendChild(newImageInput);
        });
    });

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
{{-- <script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="assets/libs/pace-js/pace.min.js"></script>

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- color picker js -->
<script src="assets/libs/%40simonwep/pickr/pickr.min.js"></script>
<script src="assets/libs/%40simonwep/pickr/pickr.es5.min.js"></script>

<!-- datepicker js -->
<script src="assets/libs/flatpickr/flatpickr.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/form-advanced.init.js"></script>

<script src="assets/js/app.js"></script> --}}

<script>
    document.getElementById('commodity-search').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let selectElement = document.getElementById('commodity-sell');
        let options = selectElement.querySelectorAll('option');

        options.forEach(option => {
            let text = option.textContent.toLowerCase();
            option.style.display = text.includes(searchValue) ? 'block' : 'none';
        });

        // Optionally, reset the selected value if no matching option
        if (searchValue === '') {
            selectElement.value = '';
        }
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commoditySelect = new Choices('#commodity-sell', {
            placeholderValue: 'Search commodities...'
            , searchPlaceholderValue: 'Type to search...'
        , });
    });

</script>


@endsection
