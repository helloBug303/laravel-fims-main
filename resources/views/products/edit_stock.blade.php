@extends('layouts.app')

@section('content')
<div class="container">
    <div class="center-form-wrapper">
        @include('partials.messages') {{-- Display messages --}}

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Edit Stock Quantity</strong>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('products.update_stock', $product->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Display Product Name -->
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $product->name }}" disabled>
                    </div>

                    <!-- Display Product Category -->
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="category" value="{{ $product->category->name ?? 'N/A' }}" disabled>
                    </div>

                    <!-- Edit Stock Quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update Stock</button>
                        <a href="{{ route('products.lowstock') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
