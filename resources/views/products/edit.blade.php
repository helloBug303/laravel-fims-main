<div id="editModalContent">
    <form method="POST" action="{{ route('products.update', $product->id) }}" id="editProductForm">
        @csrf
        @method('PUT')

        <div class="modal-header">
            <h4 class="modal-title">Edit Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>
        </div>

        <div class="modal-body">
            <!-- Replicating the form inside the modal like the original panel -->
            <div class="form-group">
                <label for="name">Product Title</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required
                    value="{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : '' }}">
            </div>

            <div class="form-group">
                <label for="categorie_id">Category</label>
                <select class="form-control" id="categorie_id" name="categorie_id" required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->categorie_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="media_id">Photo</label>
                <select class="form-control" id="media_id" name="media_id" required>
                    <option value="">No image</option>
                    @foreach ($photos as $photo)
                        <option value="{{ $photo->id }}" {{ $product->media_id == $photo->id ? 'selected' : '' }}>
                            {{ $photo->file_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Stock Qty</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="{{ $product->quantity }}" required>
            </div>

            <div class="form-group">
                <label for="buy_price">Buying Price</label>
                <input type="number" step="0.01" class="form-control" id="buy_price" name="buy_price"
                    value="{{ $product->buy_price }}" required>
            </div>

            <div class="form-group">
                <label for="sale_price">Selling Price</label>
                <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price"
                    value="{{ $product->sale_price }}" required>
            </div>
        </div>

        <!-- Footer with buttons -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Update Product</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
