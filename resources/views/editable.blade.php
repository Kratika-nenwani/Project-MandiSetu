<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Mandisetu |  Admin Dashboard </title>
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
            background: url('assets/images/mandisetu.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .center-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Adjust height if needed */
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
    </style>
</head>

<body>
    <div id="layout-wrapper">

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

        <div class="col-lg-12 center-card">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Register Form</h4>
                </div>
                <div class="card-body">
                    <div id="basic-pills-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav">
                            <li class="nav-item">
                                <a href="#personal-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Personal Details">
                                        <i class="bx bx-user"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#business-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Business Details">
                                        <i class="bx bx-briefcase"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#account-details" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Account Details">
                                        <i class="bx bx-credit-card"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#terms-conditions" class="nav-link" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Terms and Conditions">
                                        <i class="bx bx-file"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane" id="personal-details">
                                <div class="text-center mb-4">
                                    <h5>Personal Details</h5>
                                    <p class="card-title-desc">Fill all information below</p>
                                </div>
                                <form action="{{ route('save') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name-input" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email-input" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phone-input" class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="password-input" class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" id="password-input" placeholder="Enter Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="role-input" class="form-label">Register as</label>
                                                <select id="role-input"  name="role" class="form-control">
                                                    <option value="">Select Role</option>
                                                    <option value="Wholesaler">Wholesaler</option>
                                                    <option value="MandiVyapari">MandiVyapari</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="document-input" class="form-label">Select Verification Document</label>
                                                <select id="document-input" class="form-control">
                                                    <option value="">Select Document</option>
                                                    <option value="gumasta">Gumasta</option>
                                                    <option value="gst">GST Registration</option>
                                                    <option value="mandi_license">Mandi License</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="gumasta-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gumasta-number" class="form-label">Gumasta Number</label>
                                                <input type="text" class="form-control" name="gumasta_no" id="gumasta_no" placeholder="Enter Gumasta Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gumasta-image" class="form-label">Gumasta Image</label>
                                                <input type="file" class="form-control" name="gumasta" id="gumasta-image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="gst-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gst-registration" class="form-label">GST Image </label>
                                                <input type="file" class="form-control" name="gst_registration" id="gst_image" placeholder="Enter GST Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="gst-number" class="form-label">GST Number </label>
                                                <input type="text" class="form-control" name="gst_no" id="gst-number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="mandi-license-fields" style="display:none;">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="mandi-license-number" class="form-label">Mandi License Number</label>
                                                <input type="text" class="form-control" name="mandi_license_no" id="mandi-license-number" placeholder="Enter Mandi License Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="mandi-license-image" class="form-label">Mandi License Image</label>
                                                <input type="file" class="form-control" name="mandi_license" id="mandi-license-image">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Next <i class="bx bx-chevron-right ms-1"></i></a></li>
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
                                                <label for="business-name-input" class="form-label">Business Name</label>
                                                <input type="text" class="form-control" name="business_name	" id="business_name" placeholder="Enter Business Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="office-phn-input" class="form-label">Office Phone</label>
                                                <input type="text" class="form-control" name="office_phn" id="office-phn-input" placeholder="Enter Office Phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="office-address-input" class="form-label">Office Address</label>
                                                <textarea id="office-address-input" name="office_address" class="form-control" rows="2" placeholder="Enter Office Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="pan-input" class="form-label">PAN</label>
                                                <input type="text" class="form-control" name="pan" id="pan-input" placeholder="Enter your PAN number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="aadhar-input" class="form-label">Aadhar</label>
                                                <input type="text" class="form-control" name="aadhar" id="aadhar-input" placeholder="Enter your Aadhar number">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="pan-card-input" class="form-label">PAN Card</label>
                                                <input type="file" class="form-control" name="pan_card" id="pan-card-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="aadhar-card-input" class="form-label">Aadhar Card</label>
                                                <input type="file" class="form-control" name="aadhar_card" id="aadhar-card-input">
                                            </div>
                                        </div>
                                         
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="shop-image-input" class="form-label">Shop Image</label>
                                                <input type="file" class="form-control" name="image" id="image">
                                            </div>
                                        </div>
                                    </div>
                                
                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                    <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                    <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Next <i class="bx bx-chevron-right ms-1"></i></a></li>
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
                                                <label for="account-no-input" class="form-label">Account No</label>
                                                <input type="text" class="form-control" name="account_no" id="account-no-input" placeholder="Enter Account No">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="ifsc-code-input" class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" name="ifsc_code" id="ifsc-code-input" placeholder="Enter IFSC Code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="statement-input" class="form-label">6 Month of Bank Statement</label>
                                                <input type="file" class="form-control" name="statement" id="statement-input">
                                            </div>
                                        </div>
                                       
                                    </div>
                                  
                              
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                        <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Next <i class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                                
                            </div>
                            <div class="tab-pane" id="terms-conditions">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Terms and Conditions</h5>
                                        <p class="card-title-desc">Please read and agree to the terms and conditions</p>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-control" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px; background-color: #f8f9fa;">
                                            <p>
                                                The share market, also known as the stock market, is a platform where shares of publicly-held companies are issued, bought, and sold. It is a crucial component of a free-market economy, enabling companies to raise capital by selling shares to investors. Investors, in turn, can gain ownership in the company and potentially earn profits through dividends and capital gains.
                                            </p>     
                                            
                                            <p>
                                                Investing in the share market requires careful analysis and understanding of market trends, company performance, and economic indicators. While it offers opportunities for wealth creation, it also involves risks, and investors should consider their risk tolerance and investment goals.
                                            </p>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the terms and conditions
                                        </label>
                                    </div>
                                    <input type="hidden" name="aggrement" id="aggrement" value="0">
                                    {{-- <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i> Previous </a></li>
                                        <li class="finish"><button type="submit" class="btn btn-primary">Finish</button></li>
                                    </ul> --}}
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                            </div>
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
            $(document).ready(function () {
                $('#document-input').change(function () {
                    var selectedDocument = $(this).val();
                    $('#gumasta-fields, #gst-fields, #mandi-license-fields').hide();
                    if (selectedDocument == 'gumasta') {
                        $('#gumasta-fields').show();
                    } else if (selectedDocument == 'gst') {
                        $('#gst-fields').show();
                    } else if (selectedDocument == 'mandi_license') {
                        $('#mandi-license-fields').show();
                    }
                });
            });
        </script>
       <script>
        document.getElementById('termsCheck').addEventListener('change', function () {
            document.getElementById('aggrement').value = this.checked ? '1' : '0';
        });
    </script>
</body>

</html>



