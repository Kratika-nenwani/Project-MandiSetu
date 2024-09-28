@extends('index_main')
@section('csscontent')
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 20px auto;
        }

        /* Header Styles */
        .invoice-container header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 20px;
            border-bottom: 2px solid #4caf50;
        }

        .invoice-from,
        .invoice-to {
            flex: 1;
            margin: 0 10px;
        }

        .invoice-from h2,
        .invoice-to h2 {
            color: #4caf50;
            margin-bottom: 10px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .invoice-details {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details h2 {
            color: #4caf50;
            font-size: 18px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
        }

        .invoice-table th {
            background-color: #4caf50;
            color: white;
        }

        .invoice-table tbody tr:nth-child(even) {
            background-color: #f1f8e9;
        }

        .invoice-table tfoot tr td {
            font-size: 14px;
        }

        .invoice-total {
            font-size: 18px;
            font-weight: bold;
            padding: 10px 0;
            border-top: 2px solid #ddd;
            margin-bottom: 20px;
            text-align: right;
        }

        /* Button Styles */
        .btn-print {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
        }

        .btn-print:hover {
            background-color: #388e3c;
        }

        /* Footer Styles */
        .invoice-container footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #4caf50;
        }

        .payment-info,
        .contact-us {
            margin-bottom: 20px;
        }

        .payment-info h2,
        .contact-us h2 {
            color: #4caf50;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .contact-us p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Order Invoice</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Order Invoice</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="card-body">
                                <div class="invoice-container">
                                    <header>
                                        <div class="invoice-from">
                                            <h2>Invoice From:</h2>
                                            <p>SuperAdmin</p>
                                            <p>Your Company Name</p>
                                            <p>info@yourcompany.com</p>
                                            <p>Company Address</p>
                                        </div>
                                        <div class="invoice-to">
                                            <h2>Invoice To:</h2>
                                            <p>{{ $order->name }}</p>
                                            <p>{{ $order->email }}</p>
                                            <p>{{ $order->address }}, {{ $order->city }}, {{ $order->state }}</p>
                                            <p>{{ $order->zipcode }}, {{ $order->country }}</p>
                                        </div>
                                    </header>
                                    <main>
                                        <div class="invoice-details">
                                            <p>Invoice No: #{{ $order->id }}</p>
                                            <p>Invoice Date: {{ $order->created_at->format('d M, Y') }}</p>
                                        </div>
                                        <table class="invoice-table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $products = json_decode($order->product_details, true);
                                                    $serialNumber = 1;
                                                    $total = 0; // Initialize total
                                                @endphp

                                                @if (is_array($products) && !empty($products))
                                                    @foreach ($products as $product)
                                                        @php
                                                            $productTotal = ($product['price'] ?? 0) * ($product['quantity'] ?? 0);
                                                            $total += $productTotal;
                                                            $quality = DB::table('products')
                                                                ->where('id', $product['id'])
                                                                ->value('quality');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $serialNumber++ }}</td>
                                                            <td>{{ $product['name'] ?? 'No Description Available' }}({{ $quality ?? 'N/A' }})</td>
                                                            <td>{{ $product['quantity'] ?? 0 }} </td>
                                                            <td>{{ '₹' . number_format($product['price'] ?? 0, 2) }}</td>
                                                            <td>{{ '₹' . number_format($productTotal, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No products found.</td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">Sub-Total:</td>
                                                    <td>₹{{ number_format($total, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">TAX 2%:</td>
                                                    <td>₹{{ number_format($total * 0.02, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Grand Total:</td>
                                                    <td>₹{{ number_format($total * 1.02, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="invoice-total">
                                            <strong>Total:</strong> ₹{{ number_format($total * 1.02, 2) }}
                                        </div>
                                        <button class="btn-print" onclick="window.print()">Print Invoice</button>
                                    </main>
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
    <!-- Your JS content here -->
@endsection
