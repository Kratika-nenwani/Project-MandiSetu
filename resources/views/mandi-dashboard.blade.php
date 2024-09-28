

@extends('index_main')

@section('csscontent')
<style>
    #add-image-btn {
        background-color: #2ab57d;
        border-color: #2ab57d;
        color: #ffffff;
    }

    #add-image-btn:hover {
        background-color: #229f66;
        border-color: #229f66;
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
                        <h4 class="mb-sm-0 font-size-18">Mandi Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Mandi Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Fruits</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="1500">0</span> Kgs
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart1" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+300 Kgs</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Nuts</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="800">0</span> Kgs
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart2" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">-50 Kgs</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Vegetables</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="1200">0</span> Kgs
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart3" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+150 Kgs</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Spices</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="500">0</span> Kgs
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart4" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+75 Kgs</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->    
            </div><!-- end row-->

            

            <div class="row">
                <div class="col-xl-5">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                      

                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <h5 class="card-title me-2">Wallet Balance</h5>
                                <div class="ms-auto">
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            ALL
                                        </button>
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            Fruits
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            Nuts
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            Vegetables
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            Spices
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div id="wallet-balance" data-colors='["#777aca", "#2ab57d", "#a8aada"]' class="apex-charts"></div>
                                </div>
                                <div class="col-sm align-self-center">
                                    <div class="mt-4 mt-sm-0">
                                        <div>
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Fruits</p>
                                            <h6>1500 Kgs = <span class="text-muted font-size-14 fw-normal">₹ 3000.00</span></h6>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Nuts</p>
                                            <h6>800 Kgs = <span class="text-muted font-size-14 fw-normal">₹ 1600.00</span></h6>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Vegetables</p>
                                            <h6>1200 Kgs = <span class="text-muted font-size-14 fw-normal">₹ 2400.00</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->


                
                <div class="col-xl-7">
                    <div class="row">
                        <div class="col-xl-8">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Top Selling Commodities</h5>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Commodity</th>
                                                    <th>Quantity Sold</th>
                                                    <th>Total Sales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Apples</td>
                                                    <td>300 Kgs</td>
                                                    <td>₹ 1500.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Almonds</td>
                                                    <td>200 Kgs</td>
                                                    <td>₹ 2000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Tomatoes</td>
                                                    <td>250 Kgs</td>
                                                    <td>₹ 500.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Black Pepper</td>
                                                    <td>100 Kgs</td>
                                                    <td>₹ 400.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>

                        <div class="col-xl-4">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Recent Transactions</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Apple Sale
                                            <span class="badge bg-success rounded-pill">₹ 500.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Almonds Purchase
                                            <span class="badge bg-primary rounded-pill">₹ 800.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tomato Sale
                                            <span class="badge bg-success rounded-pill">₹ 250.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Pepper Purchase
                                            <span class="badge bg-primary rounded-pill">₹ 200.00</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div><!-- end row -->

        </div><!-- container-fluid -->
    </div><!-- page-content -->
</div><!-- main-content -->
@endsection

