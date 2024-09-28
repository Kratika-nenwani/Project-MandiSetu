@extends('index_main')
@section('csscontent')
    <style>
        body {
            background-color: #f9f9f9;
        }

        .main-content {
            padding: 10px;
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

        .login-danger {
            color: #FF0000;
        }

        /* Custom Media Queries */
        @media (max-width: 768px) {
            .main-content {
                padding: 5px;
            }

            .card {
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .card-title {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Create Shopkeepers</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                    <li class="breadcrumb-item active">Create Shopkeepers</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
              


                <!-- End page title -->

                <div class="row">
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create Shopkeepers</h4>
                                <p class="card-title-desc">Fill in the details to create a new Shopkeeper.</p>
                            </div>
                            <div class="card-body p-4">
                                <!-- Create Shopkeeper Form -->
                                <form class="form-group" action="{{ route('store-dukandar') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">Name<span class="login-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Enter your name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone<span class="login-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shop_name">Shop Name<span class="login-danger">*</span></label>
                                        <input type="text" name="shop_name" id="shop_name" class="form-control"
                                            value="{{ old('shop_name') }}" placeholder="Enter your shop name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address">Address<span class="login-danger">*</span></label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ old('address') }}"placeholder="Enter your address" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email<span class="login-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email') }}" placeholder="Enter your email address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mandi_license_no">Mandi License No</label>
                                        <input type="text" class="form-control" id="mandi_license_no"
                                        value="{{ old('mandi_license_no') }}" name="mandi_license_no" placeholder="Enter your Mandi license number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gumasta_no">Gumasta No</label>
                                        <input type="text" class="form-control" id="gumasta_no" name="gumasta_no"
                                        value="{{ old('gumasta_no') }}"  placeholder="Enter your Gumasta number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gst_no">GST No</label>
                                        <input type="text" class="form-control" id="gst_no" name="gst_no"
                                        value="{{ old('gst_no') }}"  placeholder="Enter your GST number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="aadhar">Aadhar</label>
                                        <input type="text" class="form-control" id="aadhar" name="aadhar"
                                        value="{{ old('aadhar') }}"  placeholder="Enter your Aadhar number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pan">PAN</label>
                                        <input type="text" class="form-control" id="pan" name="pan"
                                        value="{{ old('pan') }}"   placeholder="Enter your PAN number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gumasta">Gumasta</label>
                                        <input type="file" class="form-control" id="gumasta" name="gumasta">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gst_registration">GST Registration</label>
                                        <input type="file" class="form-control" id="gst_registration"
                                            name="gst_registration">
                                    </div>
                                    <div class="mb-3">
                                        <label for="aadhar_card">Aadhar Card</label>
                                        <input type="file" class="form-control" id="aadhar_card" name="aadhar_card">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pan_card">PAN Card</label>
                                        <input type="file" class="form-control" id="pan_card" name="pan_card">
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_no">Account No</label>
                                        <input type="text" class="form-control" id="account_no" name="account_no"
                                        value="{{ old('account_no') }}"   placeholder="Enter your account number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                        value="{{ old('ifsc_code') }}"    placeholder="Enter your IFSC code">
                                    </div>
                                    <div class="mb-3">
                                        <label for="statement">Statement</label>
                                        <input type="file" class="form-control" id="statement" name="statement">
                                    </div>
                                    <div class="mb-3">
                                        <label for="office_phn">Office Phone</label>
                                        <input type="text" class="form-control" id="office_phn" name="office_phn"
                                        value="{{ old('office_phn') }}"    placeholder="Enter your office phone number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <div class="mb-3 text-center">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

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


@endsection
