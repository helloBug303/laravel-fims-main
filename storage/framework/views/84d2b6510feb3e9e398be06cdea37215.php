

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <div style="text-align: left; margin-bottom: 50px; margin-top: 40px;">
            <h2>Out of Stock Products</h2>
        </div>

        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto; overflow-y: auto;">
            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Out of Stock Products</span>
                </strong>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-default btn-sm pull-right">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back to All Products
                </a>
            </div>

            <div class="panel-body" style="padding: 30px;">
                <?php echo $__env->make('partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="table-danger">
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center">
                                        <?php if($product->media && $product->media->file_name): ?>
                                            <img src="<?php echo e(asset('lib/products/' . $product->media->file_name)); ?>" alt="Product Photo"
                                                style="height: 80px; width: auto;">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="<?php echo e(asset('uploads/products/default.png')); ?>"
                                                alt="No Image Available" style="height: 80px; width: auto;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($product->name); ?></td>
                                    <td class="text-center"><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                    <td class="text-center">
                                        <?php echo e($product->quantity); ?>

                                        <?php if($product->quantity == 0): ?>
                                            <span class="badge" style="background-color: #6c757d; color: white;">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center"><?php echo e($product->buy_price); ?></td>
                                    <td class="text-center"><?php echo e($product->sale_price); ?></td>
                                    <td class="text-center"><?php echo e($product->date->toFormattedDateString()); ?></td>
                                    <td class="text-center">
                                        <?php echo e($product->expiry_date ? $product->expiry_date->toFormattedDateString() : 'N/A'); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center">No out of stock products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
            <div class="modal-dialog" role="document">
                <form method="POST" id="deleteForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
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

        <!-- Delete Product Script -->
        <script>
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var productId = button.data('id');
                var action = "<?php echo e(route('products.destroy', ':id')); ?>";
                action = action.replace(':id', productId);
                $('#deleteForm').attr('action', action);
            });
        </script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/products/outofstock.blade.php ENDPATH**/ ?>