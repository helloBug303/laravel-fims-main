<div id="editModalContent">
    <form method="POST" action="<?php echo e(route('products.update', $product->id)); ?>" id="editProductForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="modal-header">
            <h4 class="modal-title">Edit Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>
        </div>

        <div class="modal-body">
            <!-- Replicating the form inside the modal like the original panel -->
            <div class="form-group">
                <label for="name">Product Title</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo e($product->name); ?>" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required
                    value="<?php echo e($product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : ''); ?>">
            </div>

            <div class="form-group">
                <label for="categorie_id">Category</label>
                <select class="form-control" id="categorie_id" name="categorie_id" required>
                    <option value="">Select a category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e($product->categorie_id == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="media_id">Photo</label>
                <select class="form-control" id="media_id" name="media_id" required>
                    <option value="">No image</option>
                    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($photo->id); ?>" <?php echo e($product->media_id == $photo->id ? 'selected' : ''); ?>>
                            <?php echo e($photo->file_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Stock Qty</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="<?php echo e($product->quantity); ?>" required>
            </div>

            <div class="form-group">
                <label for="buy_price">Buying Price</label>
                <input type="number" step="0.01" class="form-control" id="buy_price" name="buy_price"
                    value="<?php echo e($product->buy_price); ?>" required>
            </div>

            <div class="form-group">
                <label for="sale_price">Selling Price</label>
                <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price"
                    value="<?php echo e($product->sale_price); ?>" required>
            </div>
        </div>

        <!-- Footer with buttons -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Update Product</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
<?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/products/edit.blade.php ENDPATH**/ ?>