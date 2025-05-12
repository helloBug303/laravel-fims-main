<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="center-form-wrapper">
        <?php echo $__env->make('partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Edit Stock Quantity</strong>
            </div>
            <div class="panel-body">
                <form method="POST" action="<?php echo e(route('products.update_stock', $product->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Display Product Name -->
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" value="<?php echo e($product->name); ?>" disabled>
                    </div>

                    <!-- Display Product Category -->
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="category" value="<?php echo e($product->category->name ?? 'N/A'); ?>" disabled>
                    </div>

                    <!-- Edit Stock Quantity -->
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo e($product->quantity); ?>" required>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Update Stock</button>
                        <a href="<?php echo e(route('products.lowstock')); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/products/edit_stock.blade.php ENDPATH**/ ?>