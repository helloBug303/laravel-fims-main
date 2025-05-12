<?php $__env->startSection('content'); ?>

    <div class="container mt-4">
        <div
            style="text-align: left; margin-bottom: 50px; margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Nearly Expiry Items</h2>
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
                                <th class="text-center" style="width: 200px;">Expiration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $daysLeft = now()->diffInDays($product->expiry_date);
                                ?>
                                <tr class="table-warning">
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
                                    <td class="text-center"><?php echo e($product->quantity); ?></td>
                                    <td class="text-center">
                                        <?php echo e(\Carbon\Carbon::parse($product->expiry_date)->toFormattedDateString()); ?><br>
                                        <aspan class="badge" style="background-color: orange; margin-top: 5px;">
                                            <?php echo e((int) $daysLeft); ?> days left
                                        </aspan>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No nearly expired products available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/products/near_expiry.blade.php ENDPATH**/ ?>