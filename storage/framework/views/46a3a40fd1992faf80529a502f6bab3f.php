<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">
            <?php if(session('msg')): ?>
                <div class="alert alert-info">
                    <?php echo e(session('msg')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="main-content">
        <div
            style="text-align: left; margin-bottom: 50px;  margin-top: 30px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Dashboard</h2>
        </div>

        <div
            style="display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 20px; justify-content: center; margin-bottom: 20px;">
            <!-- Expired Items -->
            <a href="<?php echo e(route('products.expired')); ?>" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-secondary1">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top"><?php echo e($expiredCount ?? 0); ?></h2> <!-- Use $expiredCount directly -->
                        <p class="text-muted">Expired Items</p>
                    </div>
                </div>
            </a>


            <!-- Near Expiry Items -->
            <a href="<?php echo e(route('products.near_expiry')); ?>" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-red">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top"><?php echo e($nearlyExpiredCount ?? 0); ?></h2>
                        <p class="text-muted">Near Expiry Items</p>
                    </div>
                </div>
            </a>

            <!-- Low Stock -->
            <a href="<?php echo e(route('products.lowstock')); ?>" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left" style="background-color: #dc3545; color: white;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top"><?php echo e(isset($lowStockProducts) ? $lowStockProducts->count() : 0); ?></h2>
                        <!-- Display the number of low stock products -->
                        <p class="text-muted">Low Stock Items</p>
                    </div>
                </div>
            </a>

            <!-- Products -->
            <a href="<?php echo e(route('products.index')); ?>" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-blue2">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top"><?php echo e($c_product['total'] ?? 0); ?></h2>
                        <p class="text-muted">Products</p>
                    </div>
                </div>
            </a>

            <!-- Sales -->
            <a href="<?php echo e(route('sales.index')); ?>" style="color:black; min-width: 300px;">
                <div class="panel panel-box clearfix custom-panel">
                    <div class="panel-icon pull-left bg-green">
                        <i class="fa-solid fa-peso-sign"></i>
                    </div>
                    <div class="panel-value pull-right">
                        <h2 class="margin-top"><?php echo e($c_sale['total'] ?? 0); ?></h2>
                        <p class="text-muted">Sales</p>
                    </div>
                </div>
            </a>
        </div>


        <!-- Table Panels -->
        <div class="container-fluid">
            <div class="row">

                <!-- Highest Selling Products -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-primary h-100 d-flex flex-column">
                        <div class="panel-heading bg-primary text-white text-center py-2">
                            <strong>Highest Selling Products</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Qty</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $products_sold; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sold): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($product_sold->name); ?></td>
                                            <td><?php echo e($product_sold->totalQty); ?></td>
                                            <td>₱<?php echo e(number_format($product_sold->totalSold, 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No highest selling products</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Latest Sales -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-success h-100 d-flex flex-column">
                        <div class="panel-heading bg-success text-white text-center py-2">
                            <strong>Latest Sales</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $recent_sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                            <td><a
                                                    href="<?php echo e(route('sales.edit', $recent_sale->id)); ?>"><?php echo e($recent_sale->product->name); ?></a>
                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($recent_sale->date)->format('Y-m-d')); ?></td>
                                            <td>₱<?php echo e($recent_sale->price); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent sales</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Recently Added Products -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-warning h-100 d-flex flex-column">
                        <div class="panel-heading bg-warning text-dark text-center py-2">
                            <strong>Recently Added Products</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px;  overflow-y: auto;">
                            <div class="list-group">
                                <?php $__empty_1 = true; $__currentLoopData = $recent_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a class="list-group-item d-flex align-items-center"
                                        href="<?php echo e(route('products.edit', $recent_product->id)); ?>" style="overflow: visible;">
                                        <span
                                            class="badge bg-warning text-dark me-2 flex-shrink-0">₱<?php echo e($recent_product->sale_price); ?></span>

                                        <img src="<?php echo e(isset($recent_product->media) ? asset('uploads/products/' . $recent_product->media->file_name) : asset('uploads/products/no_image.png')); ?>"
                                            class="img-thumbnail me-2 flex-shrink-0" width="40" height="40" alt="">

                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <strong class="d-block text-truncate"><?php echo e($recent_product->name); ?></strong>
                                        </div>
                                        <small
                                            class="text-muted d-block text-truncate"><?php echo e($recent_product->category->name ?? 'N/A'); ?></small>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-muted">No recent products available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Low Stock Items -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="panel panel-danger h-100 d-flex flex-column">
                        <div class="panel-heading bg-danger text-white text-center py-2">
                            <strong>Low Stock Items</strong>
                        </div>
                        <div class="panel-body overflow-auto" style="height: 500px; overflow-y: auto;">
                            <ul class="list-group">
                                <?php if($lowStockProducts->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($product->quantity > 0): ?> <!-- Ensure it doesn't display products with 0 quantity -->
                                            <li class="list-group-item d-flex justify-content-start align-items-center">
                                                <span class="badge badge-danger badge-pill me-3"><?php echo e($product->quantity); ?></span>
                                                <div>
                                                    <strong><?php echo e($product->name); ?></strong><br>
                                                    <small class="text-muted"><?php echo e($product->category->name ?? 'N/A'); ?></small>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <li class="list-group-item text-center text-muted">No low stock items</li>
                                <?php endif; ?>
                            </ul>

                        </div>
                    </div>
                </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>