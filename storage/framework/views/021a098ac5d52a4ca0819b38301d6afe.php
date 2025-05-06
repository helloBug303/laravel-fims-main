<div id="addModalContent">
    <form method="POST" action="<?php echo e(route('products.store')); ?>" id="addProductForm">
        <?php echo csrf_field(); ?>

        <div class="modal-header">
            <h4 class="modal-title">Add New Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Product Title</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>

            <div class="form-group">
                <label for="categorie_id">Category</label>
                <select class="form-control" id="categorie_id" name="categorie_id" required>
                    <option value="">Select Product Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="media_id">Product Photo</label>
                <select class="form-control" id="media_id" name="media_id" required>
                    <option value="">Select Product Photo</option>
                    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($photo->id); ?>"><?php echo e($photo->file_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required>
            </div>

            <div class="form-group">
                <label for="buy_price">Buying Price</label>
                <input type="number" step="0.01" class="form-control" id="buy_price" name="buy_price" placeholder="Buying Price" required>
            </div>

            <div class="form-group">
                <label for="sale_price">Selling Price</label>
                <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" placeholder="Selling Price" required>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Add Product</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
<?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/products/create.blade.php ENDPATH**/ ?>