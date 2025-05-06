

<?php $__env->startSection('content'); ?>

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
            <?php echo $__env->make('partials.messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 

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
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr <?php if($product->quantity <= 5): ?> class="table-danger" <?php endif; ?>>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td class="text-center">
                                        <?php if($product->media && $product->media->file_name): ?>
                                            <img src="<?php echo e(asset('lib/products/' . $product->media->file_name)); ?>" alt="Product Photo" style="height: 80px; width: auto;">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="<?php echo e(asset('uploads/products/default.png')); ?>" alt="No Image Available" style="height: 80px; width: auto;">
                                        <?php endif; ?>
                                    </td>
                            <td><?php echo e($product->name); ?></td>
                            <td class="text-center"><?php echo e($product->category->name ?? 'N/A'); ?></td>

                            
                            <td class="text-center">
                                <?php echo e($product->quantity); ?>

                                <?php if($product->quantity <= 5): ?>
                                    <span class="badge badge-danger" style="background-color: red;">Low</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!-- Edit Button -->
                                    <a href="<?php echo e(route('products.edit_stock', $product->id)); ?>" class="btn btn-xs btn-info" title="Edit Stock"><i class="glyphicon glyphicon-plus"></i> </a>
                                    <!-- Delete Button -->
                                    <button class="btn btn-xs btn-danger" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo e($product->id); ?>">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
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

<?php $__env->startPush('scripts'); ?>
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var productId = button.data('id')
        var action = "<?php echo e(url('products')); ?>/" + productId;
        $('#deleteForm').attr('action', action);
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/products/lowstock.blade.php ENDPATH**/ ?>