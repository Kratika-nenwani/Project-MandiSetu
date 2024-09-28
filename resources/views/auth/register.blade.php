<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Mandisetu | Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/libs/twitter-bootstrap-wizard/prettify.css">
    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        body {
            /* background: url('assets/images/mandisetu.jpg') no-repeat center center fixed; */
            background-size: cover;
        }

        .center-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Adjust height if needed */
        }

        .is-invalid {
            border-color: red;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875rem;
        }

        .card {
            width: 100%;
            max-width: 800px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* Add border with transparency */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            /* Make the card background transparent */
            padding: 20px;
        }

        .login-danger {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">


        <div class="col-lg-12 center-card">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Register Form</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div id="basic-pills-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav">
                            <li class="nav-item">
                                <a href="#personal-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Personal Details">
                                        <i class="bx bx-user"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#business-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Business Details">
                                        <i class="bx bx-briefcase"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#account-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Account Details">
                                        <i class="bx bx-credit-card"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#terms-conditions" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Terms and Conditions">
                                        <i class="bx bx-file"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane" id="personal-details">
                                <form id="myForm" action="{{ route('save') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="text-center mb-4">
                                        <h5>Personal Details</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name-input" class="form-label">Name <span
                                                        class="login-danger">*</span></label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name') }}" id="name"
                                                    placeholder="Enter your name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email-input" class="form-label">Email <span
                                                        class="login-danger">*</span></label>
                                                <input type="email" class="form-control" name="email"
                                                    id="email" placeholder="Enter your email"
                                                    value="{{ old('email') }}" required>
                                                <div id="email-error" class="invalid-feedback" style="display:none;">
                                                    Please enter a valid email address.
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone-input" class="form-label">Phone <span
                                                        class="login-danger">*</span></label>
                                                <input type="phone" class="form-control" name="phone"
                                                    id="phone" placeholder="Enter your phone"
                                                    value="{{ old('phone') }}" required>
                                                <div id="phone-error" class="invalid-feedback" style="display:none;">
                                                    Please enter a valid phone number.
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone-input" class="form-label">Phone <span
                                                        class="login-danger">*</span></label>
                                                <input type="text" class="form-control" name="phone"
                                                    id="phone" placeholder="Enter your phone number" required>
                                                <div id="phone-error" class="invalid-feedback"
                                                    style="display: none;"></div>
                                            </div>
                                        </div> --}}



                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="password-input" class="form-label">Password <span
                                                        class="login-danger">*</span></label>
                                                <input type="password" class="form-control" name="password"
                                                    id="password-input" placeholder="Enter Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="role-input" class="form-label">Register as <span
                                                        class="login-danger">*</span></label>
                                                <select id="role-input" name="role" class="form-control" required>
                                                    <option value="">Select Role</option>
                                                    <option value="Wholesaler"
                                                        {{ old('role') == 'Wholesaler' ? 'selected' : '' }}>Wholesaler
                                                    </option>
                                                    <option value="MandiVyapari"
                                                        {{ old('role') == 'MandiVyapari' ? 'selected' : '' }}>
                                                        MandiVyapari</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="document-input" class="form-label">Select Verification
                                                    Document <span class="login-danger">*</span></label>
                                                <select id="document-input" name="document" class="form-control"
                                                    required>
                                                    <option value="">Select Document</option>
                                                    <option value="gumasta"
                                                        {{ old('document') == 'gumasta' ? 'selected' : '' }}>Gumasta
                                                    </option>
                                                    <option value="gst"
                                                        {{ old('document') == 'gst' ? 'selected' : '' }}>GST
                                                        Registration</option>
                                                    <option value="mandi_license"
                                                        {{ old('document') == 'mandi_license' ? 'selected' : '' }}>
                                                        Mandi License</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" id="gumasta-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gumasta-number" class="form-label">Gumasta Number<span
                                                        class="login-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('gumasta_no') }}" name="gumasta_no"
                                                    id="gumasta_no" placeholder="Enter Gumasta Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gumasta-image" class="form-label">Gumasta Image<span
                                                        class="login-danger">*</span></label>
                                                <input type="file" class="form-control" name="gumasta"
                                                    id="gumasta-image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="gst-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gst-registration" class="form-label">GST Image <span
                                                        class="login-danger">*</span></label>
                                                <input type="file" class="form-control" name="gst_registration"
                                                    id="gst_image" placeholder="Enter GST Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gst-number" class="form-label">GST Number <span
                                                        class="login-danger">*</span> </label>
                                                <input type="text" class="form-control"
                                                    name="gst_no"value="{{ old('gst_no') }}" id="gst-number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="mandi-license-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="mandi-license-number" class="form-label">Mandi License
                                                    Number<span class="login-danger">*</span></label>
                                                <input type="text" class="form-control" name="mandi_license_no"
                                                    value="{{ old('mandi_license_no') }}" id="mandi-license-number"
                                                    placeholder="Enter Mandi License Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="mandi-license-image" class="form-label">Mandi License
                                                    Image<span class="login-danger">*</span></label>
                                                <input type="file" class="form-control" name="mandi_license"
                                                    id="mandi-license-image">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="next" id="next1"><a class="btn btn-primary">Next <i
                                                    class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                            </div>
                            <div class="tab-pane" id="business-details">
                                <div class="text-center mb-4">
                                    <h5>Business Details</h5>
                                    <p class="card-title-desc">Fill all information below</p>
                                </div>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="business-name-input" class="form-label">Business
                                                Name<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="business_name"
                                                value="{{ old('business_name') }}" id="business_name"
                                                placeholder="Enter Business Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="office-phn-input" class="form-label">Office Phone<span
                                                    class="login-danger">*</span></label>
                                            <input type="phone" class="form-control" name="office-phn-input"
                                                value="{{ old('office-phn-input') }}" id="office-phn-input"
                                                placeholder="Enter your phone">
                                            <div id="office-phn-error" class="invalid-feedback"
                                                style="display:none;">
                                                Please enter a valid phone number.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="office-address-input" class="form-label">Office
                                                Address<span class="login-danger">*</span></label>
                                            <textarea id="office-address-input" name="office_address" value="{{ old('office_address') }}" class="form-control"
                                                rows="2" placeholder="Enter Office Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pan-input" class="form-label">PAN<span
                                                    class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="pan-input"
                                                value="{{ old('pan-input') }}" id="pan-input"
                                                placeholder="Enter your PAN">
                                            <div id="pan-error" class="invalid-feedback" style="display:none;">
                                                Please enter a valid PAN number.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="aadhar-input" class="form-label">Aadhar<span
                                                    class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="aadhar-input"
                                                value="{{ old('aadhar-input') }}" id="aadhar-input"
                                                placeholder="Enter your Aadhar">
                                            <div id="aadhar-error" class="invalid-feedback" style="display:none;">
                                                Please enter a valid aadhar number.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pan-card-input" class="form-label">PAN Card<span
                                                    class="login-danger">*</span></label>
                                            <input type="file" class="form-control" name="pan_card"
                                                id="pan-card-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="aadhar-card-input" class="form-label">Aadhar Card<span
                                                    class="login-danger">*</span></label>
                                            <input type="file" class="form-control" name="aadhar_card"
                                                id="aadhar-card-input">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="shop-image-input" class="form-label">Shop Image<span
                                                    class="login-danger">*</span></label>
                                            <input type="file" class="form-control" name="image"
                                                id="image">
                                        </div>
                                    </div>
                                </div>

                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                    <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                                class="bx bx-chevron-left me-1"></i>
                                            Previous</a></li>
                                    <li class="next" id="next2"><a class="btn btn-primary">Next <i
                                                class="bx bx-chevron-right ms-1"></i></a></li>
                                </ul>
                            </div>
                            <div class="tab-pane" id="account-details">
                                <div class="text-center mb-4">
                                    <h5>Account Details</h5>
                                    <p class="card-title-desc">Fill all information below</p>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="account-no-input" class="form-label">Account No <span
                                                    class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="account_no"
                                                value="{{ old('account_no') }}" id="account-no-input"
                                                placeholder="Enter Account No">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="ifsc-code-input" class="form-label">IFSC Code<span
                                                    class="login-danger">*</span></label>
                                            <input type="text" class="form-control" name="ifsc-code-input"
                                                value="{{ old('ifsc-code-input') }}" id="ifsc-code-input"
                                                placeholder="Enter your ifsc code">
                                            <div id="ifsc-code-error" class="invalid-feedback" style="display:none;">
                                                Please enter a valid ifsc code.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="statement-input" class="form-label">6 Month of Bank
                                                Statement <span class="login-danger">*</span></label>
                                            <input type="file" class="form-control" name="statement"
                                                value="{{ old('statement') }}" id="statement-input">
                                        </div>
                                    </div>

                                </div>


                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                    <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                                class="bx bx-chevron-left me-1"></i>
                                            Previous</a></li>
                                    <li class="next" id="next3"><a class="btn btn-primary">Next <i
                                                class="bx bx-chevron-right ms-1"></i></a></li>
                                </ul>

                            </div>
                            <div class="tab-pane" id="terms-conditions">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Terms and Conditions</h5>

                                        <p class="card-title-desc">Please read and agree to the terms and
                                            conditions
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-control"
                                            style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px; background-color: #f8f9fa;">
                                            <p>
                                                Mandisetu is an innovative platform designed to streamline the
                                                agricultural supply chain by connecting farmers, traders, and buyers
                                                efficiently. The app provides a comprehensive solution for managing
                                                agricultural transactions, market information, and trade
                                                facilitation.
                                            </p>

                                            <p>
                                                By using Mandisetu, you agree to abide by the following terms and
                                                conditions. If you do not agree, please refrain from using the app.
                                            </p>

                                            <ul>
                                                <li><strong>Acceptance of Terms:</strong> By using Mandisetu, you
                                                    agree
                                                    to abide by these terms and conditions. If you do not agree,
                                                    please
                                                    refrain from using the app.</li>
                                                <li><strong>User Responsibilities:</strong> Users are responsible
                                                    for
                                                    maintaining the confidentiality of their account information and
                                                    for
                                                    all activities conducted under their account. You agree to use
                                                    Mandisetu only for lawful purposes and in accordance with all
                                                    applicable laws and regulations.</li>
                                                <li><strong>Privacy Policy:</strong> Your privacy is important to
                                                    us.
                                                    Mandisetu collects and uses personal information in accordance
                                                    with
                                                    our Privacy Policy. By using the app, you consent to our data
                                                    collection and usage practices.</li>
                                                <li><strong>Limitation of Liability:</strong> Mandisetu is not
                                                    liable
                                                    for any direct, indirect, incidental, or consequential damages
                                                    arising from the use of the app. We make no warranties regarding
                                                    the
                                                    accuracy or reliability of the app’s content.</li>

                                            </ul>

                                        </div>


                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="termsCheck">
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the terms and conditions<span class="login-danger">*</span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="aggrement" id="aggrement" value="0">
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);"
                                                class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i>
                                                Previous </a></li>

                                    </ul>


                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="assets/js/plugins.js"></script>
        <script src="assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="assets/libs/twitter-bootstrap-wizard/prettify.js"></script>
        <script src="assets/js/pages/form-wizard.init.js"></script>
        <script>
            $(document).ready(function() {
                $('#document-input').change(function() {
                    var selectedDocument = $(this).val();

                    // Hide all fields
                    $('#gumasta-fields, #gst-fields, #mandi-license-fields').hide();

                    // Remove 'required' attribute from all fields
                    $('#gumasta-fields input, #gst-fields input, #mandi-license-fields input').removeAttr(
                        'required');

                    // Show and set 'required' attribute based on selected document
                    if (selectedDocument == 'gumasta') {
                        $('#gumasta-fields').show();
                        $('#gumasta-fields input').attr('required', 'required');
                    } else if (selectedDocument == 'gst') {
                        $('#gst-fields').show();
                        $('#gst-fields input').attr('required', 'required');
                    } else if (selectedDocument == 'mandi_license') {
                        $('#mandi-license-fields').show();
                        $('#mandi-license-fields input').attr('required', 'required');
                    }
                });
            });
        </script>
        <script>
            document.getElementById('termsCheck').addEventListener('change', function() {
                document.getElementById('aggrement').value = this.checked ? '1' : '0';
            });
        </script>

        <script>
            var count = false;
            document.querySelector('#next1').addEventListener('click', function(event) {
                count = false;
                const nextButton = this.querySelector('a');
                if (!validateEmail() || !validatePhone()) {
                    event.preventDefault();
                    alert('Please fill out all fields properly.');
                } else {

                    const specificRequiredSelectors = [
                        '#name', // Replace with your specific field selectors
                        '#email',
                        '#phone',
                        '#password',
                        '#document-input',
                        '#role-input'
                    ];

                    // Get all required fields and specific required fields
                    let allRequiredFields = document.querySelectorAll('input[required], select[required]');
                    let specificRequiredFields = document.querySelectorAll(specificRequiredSelectors.join(', '));
                    let allFields = new Set([...allRequiredFields, ...specificRequiredFields]);

                    let allFilled = true;

                    // Loop through each required field and check if it's filled
                    allFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            allFilled = false;
                            field.classList.add('is-invalid'); // Add invalid class to highlight the field
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    // If not all specific and required fields are filled, prevent the default action
                    if (!allFilled) {
                        event.preventDefault(); // Prevent any action
                        alert('Please fill out all required fields before proceeding.');
                    } else {
                        // Proceed to the next step: Add the href attribute
                        console.log('All specified and required fields are filled. Proceeding...');
                        nextButton.setAttribute('href', 'javascript:void(0);');
                        count = true; // Set the href to "javascript:void(0);"
                        // Trigger the click again with the href set
                        nextButton.click();
                    }
                }
            });
            document.querySelector('#next2').addEventListener('click', function(event) {
                // Get the 'Next' button element
                count = false;
                const nextButton = this.querySelector('a');
                if (!validateOfficePhone() || !validatePAN() || !validateAadhar()) {
                    event.preventDefault();
                    alert('Please fill out all fields properly.');
                } else {
                    // Define the selectors for specific required fields
                    const specificRequiredSelectors = [
                        '#image', // Replace with your specific field selectors
                        '#business_name', // Replace with your specific field selectors
                        '#aadhar-card-input',
                        '#pan-card-input',
                        '#aadhar-input',
                        '#pan-input',
                        '#office-address-input',
                        '#office-phn-input'
                    ];

                    // Get all required fields and specific required fields
                    let allRequiredFields = document.querySelectorAll('input[required], select[required]');
                    let specificRequiredFields = document.querySelectorAll(specificRequiredSelectors.join(', '));
                    let allFields = new Set([...allRequiredFields, ...specificRequiredFields]);

                    let allFilled = true;

                    // Loop through each required field and check if it's filled
                    allFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            allFilled = false;
                            field.classList.add('is-invalid'); // Add invalid class to highlight the field
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    // If not all specific and required fields are filled, prevent the default action
                    if (!allFilled) {
                        event.preventDefault(); // Prevent any action
                        alert('Please fill out all required fields before proceeding.');
                    } else {
                        // Proceed to the next step: Add the href attribute
                        console.log('All specified and required fields are filled. Proceeding...');
                        nextButton.setAttribute('href', 'javascript:void(0);');
                        count = true; // Set the href to "javascript:void(0);"
                        // Trigger the click again with the href set
                        nextButton.click();
                    }
                }
            });
            document.querySelector('#next3').addEventListener('click', function(event) {
                // Get the 'Next' button element
                count = false;
                const nextButton = this.querySelector('a');
                if (!validateIFSC()) {
                    event.preventDefault();
                    alert('Please fill out all fields properly.');
                } else {
                    // Define the selectors for specific required fields
                    const specificRequiredSelectors = [
                        '#account-no-input', // Replace with your specific field selectors
                        '#ifsc-code-input', // Replace with your specific field selectors
                        '#statement-input'
                    ];

                    // Get all required fields and specific required fields
                    let allRequiredFields = document.querySelectorAll('input[required], select[required]');
                    let specificRequiredFields = document.querySelectorAll(specificRequiredSelectors.join(', '));
                    let allFields = new Set([...allRequiredFields, ...specificRequiredFields]);

                    let allFilled = true;

                    // Loop through each required field and check if it's filled
                    allFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            allFilled = false;
                            field.classList.add('is-invalid'); // Add invalid class to highlight the field
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    // If not all specific and required fields are filled, prevent the default action
                    if (!allFilled) {
                        event.preventDefault(); // Prevent any action
                        alert('Please fill out all required fields before proceeding.');
                    } else {
                        // Proceed to the next step: Add the href attribute
                        console.log('All specified and required fields are filled. Proceeding...');
                        nextButton.setAttribute('href', 'javascript:void(0);');
                        count = true; // Set the href to "javascript:void(0);"
                        // Trigger the click again with the href set
                        nextButton.click();
                    }
                }
            });
        </script>
        <script>
            document.querySelector('#email').addEventListener('input', validateEmail);
            document.querySelector('#phone').addEventListener('input', validatePhone);
            document.querySelector('#office-phn-input').addEventListener('input', validateOfficePhone);
            document.querySelector('#aadhar-input').addEventListener('input', validateAadhar);
            document.querySelector('#pan-input').addEventListener('input', validatePAN);
            document.querySelector('#ifsc-code-input').addEventListener('input', validateIFSC);

            function validatePhone() {
                const phoneInput = document.querySelector('#phone');
                const phoneError = document.querySelector('#phone-error');

                // Regular expression for validating phone number format
                const phonePattern = /^[0-9]{10}$/;

                if (!phoneInput.value.trim()) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Phone number is required.';
                    phoneError.style.display = 'block';
                    return false;

                } else if (!phonePattern.test(phoneInput.value.trim())) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Please enter a valid 10-digit phone number.';
                    phoneError.style.display = 'block';
                    return false;
                } else {
                    phoneInput.classList.remove('is-invalid');
                    phoneError.style.display = 'none';
                    return true;
                }
            }


            function validateEmail() {
                const emailInput = document.querySelector('#email');
                const emailError = document.querySelector('#email-error');

                // Regular expression for validating email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailInput.value.trim()) {
                    emailInput.classList.add('is-invalid');
                    emailError.textContent = 'Email is required.';
                    emailError.style.display = 'block';
                    return false;
                } else if (!emailPattern.test(emailInput.value.trim())) {
                    emailInput.classList.add('is-invalid');
                    emailError.textContent = 'Please enter a valid email address.';
                    emailError.style.display = 'block';
                    return false;
                } else {
                    emailInput.classList.remove('is-invalid');
                    emailError.style.display = 'none';
                    return true;
                }
            }



            function validateOfficePhone() {
                const phoneInput = document.querySelector('#office-phn-input');
                const phoneError = document.querySelector('#office-phn-error');

                // Regular expression for validating phone number format
                const phonePattern = /^[0-9]{10}$/;

                if (!phoneInput.value.trim()) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Phone number is required.';
                    phoneError.style.display = 'block';
                    return false;

                } else if (!phonePattern.test(phoneInput.value.trim())) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Please enter a valid 10-digit phone number.';
                    phoneError.style.display = 'block';
                    return false;
                } else {
                    phoneInput.classList.remove('is-invalid');
                    phoneError.style.display = 'none';
                    return true;
                }
            }


            function validateAadhar() {
                const phoneInput = document.querySelector('#aadhar-input');
                const phoneError = document.querySelector('#aadhar-error');

                // Regular expression for validating phone number format
                const phonePattern = /^[0-9]{12}$/;

                if (!phoneInput.value.trim()) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Aadhar number is required.';
                    phoneError.style.display = 'block';
                    return false;

                } else if (!phonePattern.test(phoneInput.value.trim())) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Please enter a valid Aadhar number.';
                    phoneError.style.display = 'block';
                    return false;
                } else {
                    phoneInput.classList.remove('is-invalid');
                    phoneError.style.display = 'none';
                    return true;
                }
            }


            function validatePAN() {
                const phoneInput = document.querySelector('#pan-input');
                const phoneError = document.querySelector('#pan-error');

                // Regular expression for validating phone number format
                const phonePattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

                if (!phoneInput.value.trim()) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'PAN number is required.';
                    phoneError.style.display = 'block';
                    return false;

                } else if (!phonePattern.test(phoneInput.value.trim())) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Please enter a valid PAN number.';
                    phoneError.style.display = 'block';
                    return false;
                } else {
                    phoneInput.classList.remove('is-invalid');
                    phoneError.style.display = 'none';
                    return true;
                }
            }


            function validateIFSC() {
                const phoneInput = document.querySelector('#ifsc-code-input');
                const phoneError = document.querySelector('#ifsc-code-error');

                // Regular expression for validating phone number format
                const phonePattern = /^[A-Z]{4}0[A-Z0-9]{6}$/;

                if (!phoneInput.value.trim()) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'IFSC number is required.';
                    phoneError.style.display = 'block';
                    return false;

                } else if (!phonePattern.test(phoneInput.value.trim())) {
                    phoneInput.classList.add('is-invalid');
                    phoneError.textContent = 'Please enter a valid IFSC number.';
                    phoneError.style.display = 'block';
                    return false;
                } else {
                    phoneInput.classList.remove('is-invalid');
                    phoneError.style.display = 'none';
                    return true;
                }
            }
        </script>

        <script>
            document.getElementById('myForm').addEventListener('submit', function(event) {
                var checkbox = document.getElementById('termsCheck');
                if (!checkbox.checked) {
                    event.preventDefault(); // Prevent form submission
                    alert('Please accept the terms & conditions.');
                }
            });
        </script>








</body>

</html>
