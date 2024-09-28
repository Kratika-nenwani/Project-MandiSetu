@extends('index_main')

@section('csscontent')
<style>
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #f2f2f2;
    }
    .profile-card {
        width: 90%;
        max-width: 700px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: left;
        margin-bottom: 30px;
    }
    .profile-card h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }
    .profile-card p {
        margin: 10px 0;
        color: #555;
        font-size: 16px;
    }
    .profile-card strong {
        color: #333;
    }
    .product-list {
        width: 90%;
        max-width: 800px;
        margin-top: 20px;
    }
    .product-item {
        display: flex;
        align-items: flex-start;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }
    .product-item:hover {
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }
    .product-images {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 20px;
    }
    .product-images img {
        width: 150px; /* Set a fixed size for images */
        height: 150px;
        border-radius: 4px;
        margin-bottom: 10px;
        object-fit: cover;
    }
    .product-details {
        flex: 1;
    }
    .product-details h4 {
        margin-bottom: 15px;
        color: #333;
        font-size: 20px;
    }
    .product-details p {
        margin: 8px 0;
        color: #666;
        font-size: 14px;
    }
    .no-data {
        text-align: center;
        font-size: 18px;
        color: #999;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="profile-container">
            <div class="profile-card">
                <h2>User Profile</h2>
                <p><strong>Name:</strong> {{$user->name}}</p>
                <p><strong>Email:</strong> {{$user->email}}</p>
                <p><strong>Phone:</strong> {{$user->phone}}</p>
                <p><strong>Role:</strong> {{$user->role}}</p>
            </div>

            @if($user->role == "Wholesaler")
                <div class="product-list">
                    <h3>Products Added by {{$user->name}}</h3>
                    @forelse($products as $product)
                    <div class="product-item">
                        <div class="product-images">
                            @if($product->image)
                                @php
                                    $images = json_decode($product->image, true);
                                @endphp
                                @foreach($images as $image)
                                    <img src="{{ asset('ProductImages/' . $image) }}" alt="Product Image">
                                @endforeach
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                        <div class="product-details">
                            @php
                                $commodity = \App\Models\Commodity::find($product->commodity_id);
                                $variety = \App\Models\Variety::find($product->variety_id);
                            @endphp
                            <h4>Commodity: {{ $commodity ? $commodity->name : 'N/A' }}</h4>
                            <p><strong>Variety:</strong> {{ $variety ? $variety->name : 'N/A' }}</p>
                            <p><strong>Quality:</strong> {{$product->quality}}</p>
                            <p><strong>Rate:</strong> {{$product->rate}}</p>
                        </div>
                    </div>
                    @empty
                        <p class="no-data">No products added yet.</p>
                    @endforelse
                </div>
            @else
                <div class="product-list">
                    <h3>Sale Done by {{$user->name}}</h3>
@forelse($dukandars as $dukandar)
    <div class="card mb-4">
        <div class="card-body">
            @php
                $product = \App\Models\Product::find($dukandar->product_id);
                $basicDukandar = \App\Models\Dukandar::find($dukandar->dukandar_id);
            @endphp

            <h4 class="card-title text-center">Sale Summary</h4>
            <hr>

            <div class="row">
                <!-- Left Column: Dukandar Details -->
                <div class="col-md-6">
                    <h5 class="text-muted">Dukandar Information</h5>
                    @if($basicDukandar)
                        <p><strong>Name:</strong> {{ $basicDukandar->name }}</p>
                        <p><strong>Shop Name:</strong> {{ $basicDukandar->shop_name }}</p>
                        <p><strong>Phone:</strong> {{ $basicDukandar->phone }}</p>
                        <p><strong>Email:</strong> {{ $basicDukandar->email }}</p>
                    @endif
                </div>

                <!-- Right Column: Product and Sale Details -->
                <div class="col-md-6">
                    @if($product)
                        <h5 class="text-muted">Product Information</h5>
                        <p><strong>Product ID:</strong> {{ $dukandar->product_id }}</p>
                        <p><strong>Quality:</strong> {{ $product->quality }}</p>
                        <p><strong>Commodity:</strong> {{ $product->commodity_id ? \App\Models\Commodity::find($product->commodity_id)->name : 'N/A' }}</p>
                        <p><strong>Variety:</strong> {{ $product->variety_id ? \App\Models\Variety::find($product->variety_id)->name : 'N/A' }}</p>
                    @endif

                    <h5 class="text-muted mt-3">Sale Details</h5>
                    <p><strong>Quantity Sold:</strong> {{ $dukandar->quantity }} {{ $dukandar->unit }}</p>
                    <p><strong>Price per Unit:</strong> ₹{{ $dukandar->price_per_unit }}</p>
                    <p><strong>Total Sale:</strong> ₹{{ $dukandar->total }}</p>
                </div>
            </div>

            <hr>
            <p class="text-center mb-0"><strong>{{ $basicDukandar->name }}</strong> purchased <strong>{{ $dukandar->quantity }} {{ $dukandar->unit }}</strong> of <strong>{{ $product->commodity_id ? \App\Models\Commodity::find($product->commodity_id)->name : 'N/A' }} - {{ $product->variety_id ? \App\Models\Variety::find($product->variety_id)->name : 'N/A' }} - {{ $product->quality }}</strong> at ₹{{ $dukandar->price_per_unit }} per unit.</p>
        </div>
    </div>
@empty
    <p class="no-data">No sales found.</p>
@endforelse



                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('jscontent')
<!-- Any additional JavaScript can be added here -->
@endsection
