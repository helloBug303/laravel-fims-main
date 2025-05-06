@extends('layouts.app')

@section('content')

<div class="container mt-4">
<div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Low Stock Items</h2>
    </div>
    <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
        <div class="panel-heading" style="padding: 20px;">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Items</span>
            </strong>
        </div>

        <div class="panel-body" style="padding: 30px;">
            @include('partials.messages') {{-- Flash messages --}}

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="width: 100px;">Photo</th>
                            <th>Product Name</th>
                            <th class="text-center" style="width: 100px;">Category</th>
                            <th class="text-center" style="width: 100px;">In-Stock</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr @if($product->quantity <= 5) class="table-danger" @endif>
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

                            {{-- Stock Quantity with Low Stock Warning --}}
                            <td class="text-center">
                                {{ $product->quantity }}
                                @if ($product->quantity <= 5)
                                    <span class="badge badge-danger" style="background-color: red;">Low</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!-- Edit Button -->
                                    <a href="{{ route('products.edit_stock', $product->id) }}" class="btn btn-xs btn-info" title="Edit Stock"><i class="glyphicon glyphicon-plus"></i> </a>
                                    <!-- Delete Button -->
                                    <button class="btn btn-xs btn-danger" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="{{ $product->id }}">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <span>&times;</span>
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

@push('scripts')
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var productId = button.data('id')
        var action = "{{ url('products') }}/" + productId;
        $('#deleteForm').attr('action', action);
    });
</script>
@endpush

@endsection
