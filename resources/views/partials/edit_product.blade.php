<form method="POST" action="{{ route('products.update', $product->id) }}">
    @csrf
    @method('PUT')
    <!-- Add your form fields here -->
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control">
    </div>
    <!-- Add more fields as needed -->
    <button type="submit" class="btn btn-success">Update</button>
</form>
