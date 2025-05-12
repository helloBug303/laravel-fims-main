<!-- Edit Sale Form -->
<form method="POST" action="<?php echo e(route('sales.update', $sale->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo e($sale->product->name); ?>" readonly>
    </div>
    
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo e(old('quantity', $sale->qty)); ?>" required>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="text" name="price" class="form-control" value="<?php echo e($sale->product->sale_price); ?>" readonly>
    </div>

    <div class="form-group">
        <label for="total">Total</label>
        <input type="text" name="total" id="total" class="form-control" value="<?php echo e(old('total', $sale->price)); ?>" readonly>
    </div>

    <div class="form-group">
        <label for="date">Sale Date</label>
        <input type="date" name="date" class="form-control" value="<?php echo e(old('date', $sale->date)); ?>" required>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-info">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
</form>

<!-- JavaScript to update total dynamically -->
<script>
    var price = <?php echo e($sale->product->sale_price); ?>;
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
<?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/sales/edit.blade.php ENDPATH**/ ?>