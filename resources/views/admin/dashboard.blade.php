@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">
            @if(session('msg'))
                <div class="alert alert-info">
                    {{ session('msg') }}
                </div>
            @endif
        </div>
    </div>
    <div class="main-content">
        <div
            style="text-align: left; margin-bottom: 50px;  margin-top: 30px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Dashboard</h2>
        </div>

        <div
            style="display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 20px; justify-content: center; margin-bottom: 20px;">
            <!-- Expired Items -->
            <a href="{{ route('products.expired') }}" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-secondary1">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top">{{ $expiredCount ?? 0 }}</h2> <!-- Use $expiredCount directly -->
                        <p class="text-muted">Expired Items</p>
                    </div>
                </div>
            </a>


            <!-- Near Expiry Items -->
            <a href="{{ route('products.near_expiry') }}" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-red">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top">{{ $nearlyExpiredCount ?? 0 }}</h2>
                        <p class="text-muted">Near Expiry Items</p>
                    </div>
                </div>
            </a>

            <!-- Low Stock -->
            <a href="{{ route('products.lowstock') }}" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left" style="background-color: #dc3545; color: white;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top">{{ isset($lowStockProducts) ? $lowStockProducts->count() : 0 }}</h2>
                        <!-- Display the number of low stock products -->
                        <p class="text-muted">Low Stock Items</p>
                    </div>
                </div>
            </a>

            <!-- Products -->
            <a href="{{ route('products.index') }}" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-blue2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top">{{ $c_product['total'] ?? 0}}</h2>
                        <p class="text-muted">Products</p>
                    </div>
                </div>
            </a>

            <!-- Sales -->
            <a href="{{ route('sales.index') }}" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-green">
                        <i class="fa-solid fa-peso-sign"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top">{{ $c_sale['total'] ?? 0}}</h2>
                        <p class="text-muted">Sales</p>
                    </div>
                </div>
            </a>
        </div>


        <!-- Table Panels -->
        <div class="container-fluid">
            <div class="row">

                <!-- Highest Selling Products -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-primary h-100 d-flex flex-column">
                        <div class="panel-heading bg-primary text-white text-center py-2">
                            <strong>Highest Selling Products</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Qty</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products_sold as $product_sold)
                                        <tr>
                                            <td>{{ $product_sold->name }}</td>
                                            <td>{{ $product_sold->totalQty }}</td>
                                            <td>₱{{ number_format($product_sold->totalSold, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No highest selling products</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Latest Sales -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-success h-100 d-flex flex-column">
                        <div class="panel-heading bg-success text-white text-center py-2">
                            <strong>Latest Sales</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_sales as $recent_sale)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td><a
                                                    href="{{ route('sales.edit', $recent_sale->id) }}">{{ $recent_sale->product->name }}</a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($recent_sale->date)->format('Y-m-d') }}</td>
                                            <td>₱{{ $recent_sale->price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent sales</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Recently Added Products -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-warning h-100 d-flex flex-column">
                        <div class="panel-heading bg-warning text-dark text-center py-2">
                            <strong>Recently Added Products</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px;  overflow-y: auto;">
                            <div class="list-group">
                                @forelse($recent_products as $recent_product)
                                    <a class="list-group-item d-flex align-items-center"
                                        href="{{ route('products.edit', $recent_product->id) }}" style="overflow: visible;">
                                        <span
                                            class="badge bg-warning text-dark me-2 flex-shrink-0">₱{{ $recent_product->sale_price }}</span>

                                        <img src="{{ isset($recent_product->media) ? asset('uploads/products/' . $recent_product->media->file_name) : asset('uploads/products/no_image.png') }}"
                                            class="img-thumbnail me-2 flex-shrink-0" width="40" height="40" alt="">

                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <strong class="d-block text-truncate">{{ $recent_product->name }}</strong>
                                        </div>
                                        <small
                                            class="text-muted d-block text-truncate">{{ $recent_product->category->name ?? 'N/A' }}</small>
                                    </a>
                                @empty
                                    <p class="text-muted">No recent products available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Low Stock Items -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-danger h-100 d-flex flex-column">
                        <div class="panel-heading bg-danger text-white text-center py-2">
                            <strong>Low Stock Items</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <ul class="list-group">
                                @if($lowStockProducts->isNotEmpty())
                                    @foreach ($lowStockProducts as $product)
                                        @if($product->quantity > 0) <!-- Ensure it doesn't display products with 0 quantity -->
                                            <li class="list-group-item d-flex justify-content-start align-items-center">
                                                <span class="badge badge-danger badge-pill me-3">{{ $product->quantity }}</span>
                                                <div>
                                                    <strong>{{ $product->name }}</strong><br>
                                                    <small class="text-muted">{{ $product->category->name ?? 'N/A' }}</small>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                <li class="list-group-item text-center text-muted">No low stock items</li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>

@endsection