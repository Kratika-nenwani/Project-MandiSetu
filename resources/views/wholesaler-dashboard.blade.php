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
                            <h4 class="mb-sm-0 font-size-18">Wholesaler Dashboard</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Wholesaler Dashboard</li>
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
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Inventory</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="3500">0</span> Kgs
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div id="mini-chart1" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span class="badge bg-success-subtle text-success">+500 Kgs</span>
                                    <span class="ms-1 text-muted font-size-13">Since last month</span>
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
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Orders</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="75">0</span> Orders
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div id="mini-chart2" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span class="badge bg-danger-subtle text-danger">-5 Orders</span>
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
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Pending Payments</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="12000">0</span> INR
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div id="mini-chart3" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span class="badge bg-warning-subtle text-warning">+1500 INR</span>
                                    <span class="ms-1 text-muted font-size-13">Since last month</span>
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
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Recent Sales</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="2000">0</span> INR
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div id="mini-chart4" data-colors='["#2ab57d"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span class="badge bg-success-subtle text-success">+300 INR</span>
                                    <span class="ms-1 text-muted font-size-13">Since last week</span>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row-->

                <div class="row">


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Line Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="line-chart" data-colors='["#2ab57d", "#ccc"]' class="e-charts"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">

                                            <h4 class="card-title mb-0 me-2">
                                                Weekly Average Price
                                            </h4>
                                            <div class="dropdown me-2">
                                                <select id="commodityDropdown" class="form-select form-select-sm"
                                                    aria-label="Select Commodity">
                                                    @foreach ($commodity as $commodity)
                                                        <option value="{{ $commodity->name }}">{{ $commodity->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div id="mix-line-bar" data-colors='["#2ab57d", "#5156be", "#fd625e"]'
                                        class="e-charts"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>

                    </div>
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
                                        <div id="wallet-balance" data-colors='["#777aca", "#2ab57d", "#a8aada"]'
                                            class="apex-charts"></div>
                                    </div>
                                    <div class="col-sm align-self-center">
                                        <div class="mt-4 mt-sm-0">
                                            <div>
                                                <p class="mb-2"><i
                                                        class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i>
                                                    Fruits</p>
                                                <h6>1500 Kgs = <span class="text-muted font-size-14 fw-normal">₹
                                                        3000.00</span></h6>
                                            </div>

                                            <div class="mt-4 pt-2">
                                                <p class="mb-2"><i
                                                        class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                                    Nuts</p>
                                                <h6>800 Kgs = <span class="text-muted font-size-14 fw-normal">₹
                                                        1600.00</span></h6>
                                            </div>

                                            <div class="mt-4 pt-2">
                                                <p class="mb-2"><i
                                                        class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i>
                                                    Vegetables</p>
                                                <h6>1200 Kgs = <span class="text-muted font-size-14 fw-normal">₹
                                                        2400.00</span></h6>
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
                                        <h5 class="card-title mb-4">Top Selling Products</h5>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity Sold</th>
                                                        <th>Total Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Apples</td>
                                                        <td>3000 Kgs</td>
                                                        <td>₹ 6000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Almonds</td>
                                                        <td>1500 Kgs</td>
                                                        <td>₹ 3000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tomatoes</td>
                                                        <td>2500 Kgs</td>
                                                        <td>₹ 5000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cinnamon</td>
                                                        <td>1200 Kgs</td>
                                                        <td>₹ 2400.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Recent Orders</h5>
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Order #1234
                                                <span class="badge bg-success rounded-pill">₹ 450.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Order #1235
                                                <span class="badge bg-warning rounded-pill">₹ 600.00</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Order #1236
                                                <span class="badge bg-danger rounded-pill">₹ 750.00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>



                    <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div> <!-- page-content -->
    </div> <!-- main-content -->
@endsection
@section('jscontent')
    <script src="assets/libs/echarts/echarts.min.js"></script>
    <!-- echarts init -->
    <script src="assets/js/pages/echarts.init.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const dropdown = document.getElementById('commodityDropdown');
    
            // Initial chart update
            updateChartData(dropdown.value);
    
            // Add event listener for change event
            dropdown.addEventListener('change', (event) => {
                updateChartData(event.target.value);
            });
        });
    
       function updateChartData(selectedCommodity) {
    const params = {
        commodity: selectedCommodity
    };
    const queryString = new URLSearchParams(params).toString();

    fetch(`https://stagging.jookwang.me/api/get-stats?${queryString}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // Convert the array to the expected object format
            const statistics = data.data.reduce((acc, entry) => {
                acc[entry.date] = {
                    min: entry.min,
                    max: entry.max,
                    modal: entry.modal
                };
                return acc;
            }, {});

            console.log(statistics);

            if (Object.keys(statistics).length === 0) {
                const option = {
                    title: {
                        text: 'No Data Available',
                        left: 'center',
                        top: 'center',
                        textStyle: {
                            fontSize: 18,
                            fontWeight: 'normal',
                            color: '#888'
                        }
                    },
                    xAxis: {
                        data: []
                    },
                    yAxis: {
                        min: 0,
                        max: 1
                    },
                    series: []
                };

                myChart.setOption(option, true);
                console.log("No data available for the selected commodity.");
            } else {
                const dates = Object.keys(statistics);
                const minPrices = dates.map(date => statistics[date].min || 0);
                const maxPrices = dates.map(date => statistics[date].max || 0);
                const modalPrices = dates.map(date => statistics[date].modal || 0);

                const option = {
                    grid: {
                        zlevel: 0,
                        x: 90,
                        x2: 80,
                        y: 30,
                        y2: 30,
                        borderWidth: 0,
                        backgroundColor: 'rgba(0,0,0,0)',
                        borderColor: 'rgba(0,0,0,0)'
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'cross',
                            crossStyle: {
                                color: '#999'
                            }
                        }
                    },
                    toolbox: {
                        orient: 'center',
                        left: 0,
                        top: 20,
                        feature: {
                            dataView: {
                                readOnly: false,
                                title: 'Data View'
                            },
                            magicType: {
                                type: ['line', 'bar'],
                                title: {
                                    line: 'For line chart',
                                    bar: 'For bar chart'
                                }
                            },
                            restore: {
                                title: 'Restore'
                            },
                            saveAsImage: {
                                title: 'Download Image'
                            }
                        }
                    },
                    color: mixlinebarColors,
                    legend: {
                        data: ['Min Price', 'Max Price', 'Modal Price'],
                        textStyle: {
                            color: '#858d98'
                        }
                    },
                    xAxis: [{
                        type: 'category',
                        data: dates,
                        axisPointer: {
                            type: 'shadow'
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#858d98'
                            }
                        }
                    }],
                    yAxis: [{
                        type: 'value',
                        min: 0,
                        max: 30000,
                        interval: 5000,
                        axisLine: {
                            lineStyle: {
                                color: '#858d98'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(133, 141, 152, 0.1)'
                            }
                        },
                        axisLabel: {
                            formatter: '{value} Rs'
                        }
                    },
                    {
                        type: 'value',
                        min: 0,
                        max: 50000,
                        interval: 50000,
                        axisLine: {
                            lineStyle: {
                                color: '#858d98'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(133, 141, 152, 0.1)'
                            }
                        },
                        axisLabel: {
                            formatter: '{value} Rs'
                        }
                    }],
                    series: [{
                            name: 'Min Price',
                            type: 'bar',
                            data: minPrices
                        },
                        {
                            name: 'Max Price',
                            type: 'bar',
                            data: maxPrices
                        },
                        {
                            name: 'Modal Price',
                            type: 'line',
                            yAxisIndex: 1,
                            data: modalPrices
                        }
                    ]
                };

                myChart.setOption(option, true);
                console.log("Chart data updated successfully");
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

    </script>
    
@endsection
