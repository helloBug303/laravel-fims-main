<!-- resources/views/products/expired.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
    <div style="text-align: left; margin-bottom: 50px; margin-top: 40px;">
        <h2>Expired Products</h2>
    </div>
      
        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto; overflow-y: auto;">
            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Expired Products</span>
                </strong>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm pull-right">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back to All Products
                </a>
            </div>

            <div class="panel-body" style="padding: 30px;">
                @include('partials.messages')

                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 100px;">Photo</th>
                                <th>Product Name</th>
                                <th class="text-center" style="width: 100px;">Categories</th>
                                <th class="text-center" style="width: 100px;">In-Stock</th>
                                <th class="text-center" style="width: 100px;">Buying Price</th>
                                <th class="text-center" style="width: 100px;">Selling Price</th>
                                <th class="text-center" style="width: 150px;">Product Added</th>
                                <th class="text-center" style="width: 150px;">Expiration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr class="{{ $product->expiry_date && $product->expiry_date < now() ? 'table-danger' : '' }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if($product->media && $product->media->file_name)
                                        <img src="{{ asset('lib/products/' . $product->media->file_name) }}" alt="Product Photo" style="height: 80px; width: auto;">
                                    @else
                                        <img class="img-avatar img-circle" src="{{ asset('uploads/products/default.png') }}" alt="No Image Available" style="height: 80px; width: auto;">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $product->quantity }}</td>
                                <td class="text-center">{{ $product->buy_price }}</td>
                                <td class="text-center">{{ $product->sale_price }}</td>
                                <td class="text-center">{{ $product->date->toFormattedDateString() }}</td>
                                <td class="text-center">
                                    {{ $product->expiry_date ? $product->expiry_date->toFormattedDateString() : 'N/A' }}
                                    <br>
                                    @if($product->expiry_date && $product->expiry_date < now())
                                        <span class="badge" style="background-color: red; color: white;">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">Confirm Delete</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
