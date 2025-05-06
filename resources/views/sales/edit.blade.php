<!-- Edit Sale Form -->
<form method="POST" action="{{ route('sales.update', $sale->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="{{ $sale->product->name }}" readonly>
    </div>
    
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $sale->qty) }}" required>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="text" name="price" class="form-control" value="{{ $sale->product->sale_price }}" readonly>
    </div>

    <div class="form-group">
        <label for="total">Total</label>
        <input type="text" name="total" id="total" class="form-control" value="{{ old('total', $sale->price) }}" readonly>
    </div>

    <div class="form-group">
        <label for="date">Sale Date</label>
        <input type="date" name="date" class="form-control" value="{{ old('date', $sale->date) }}" required>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-info">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
</form>

<!-- JavaScript to update total dynamically -->
<script>
    var price = {{ $sale->product->sale_price }};
    var quantityInput = document.getElementById('quantity');
    var totalInput = document.getElementById('total');

    function updateTotal() {
        var quantity = parseInt(quantityInput.value) || 0;
        var total = quantity * price;
        totalInput.value = total.toFixed(2);
    }

    quantityInput.addEventListener('input', updateTotal);
    updateTotal();
</script>
