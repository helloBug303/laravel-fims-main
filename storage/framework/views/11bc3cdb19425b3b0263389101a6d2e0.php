<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <div style="text-align: left; margin-bottom: 50px; margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Products</h2>

            <!-- Search & Filter Section -->
            <div class="row mb-4">
                <!-- Search Section -->
                <div class="col-md-6">
                    <form action="<?php echo e(route('products.index')); ?>" method="GET" class="form-inline d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <input type="text" name="search" class="form-control" placeholder="Search Products"
                                value="<?php echo e(request('search')); ?>" style="padding: 5px 10px; width: 100%;">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary ml-2" style="padding: 5px 10px;">
                            Clear
                        </a>
                    </form>
                </div>

                <!-- Filter Section -->
                <div class="col-md-6 text-right">
                    <form action="<?php echo e(route('products.index')); ?>" method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <select name="status" class="form-control" style="width: 150px;">
                                <option value="">All Stock</option>
                                <option value="low" <?php echo e(request('status') == 'low' ? 'selected' : ''); ?>>Low Stock Items</option>
                                <option value="near_expiry" <?php echo e(request('status') == 'near_expiry' ? 'selected' : ''); ?>>Near Expiry Items</option>
                                <option value="out_of_stock" <?php echo e(request('status') == 'out_of_stock' ? 'selected' : ''); ?>>Out of Stock Items</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Products</span>
                </strong>
                <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addProductModal" id="addProductBtn">
               Add Product
               </button>
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
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr <?php if($product->quantity <= 5): ?> class="table-danger" 
                                    <?php elseif($product->expiry_date && $product->expiry_date->diffInDays(now()) <= 7): ?> class="table-warning" 
                                    <?php endif; ?>>
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

                                        <?php if($product->quantity == 0): ?>
                                      <span class="badge" style="background-color: #6c757d; color: white;">Out of Stock</span>
                                      <?php elseif($product->quantity <= 5): ?>
                                     <span class="badge" style="background-color: #dc3545; color: white;">Low</span>
                                     <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($product->buy_price); ?></td>
                                    <td class="text-center"><?php echo e($product->sale_price); ?></td>
                                    <td class="text-center"><?php echo e($product->date->toFormattedDateString()); ?></td>
                                    <td class="text-center">
                                        <?php echo e($product->expiry_date ? $product->expiry_date->toFormattedDateString() : 'N/A'); ?>

                                        <?php
                                            $daysUntilExpiry = now()->diffInDays($product->expiry_date, false);
                                        ?>
                                        <?php if($product->expiry_date && $daysUntilExpiry < 0): ?>
                                            <br>
                                            <span class="badge" style="background-color:  #dc3545; color: white;">Expired</span>
                                        <?php elseif($product->expiry_date && $daysUntilExpiry >= 0 && $daysUntilExpiry <= 7): ?>
                                            <br>
                                            <span class="badge" style="background-color: orange; color: white;">Expiring soon</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-info open-edit-modal" data-id="<?php echo e($product->id); ?>" title="Edit">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </button>
                                            <button class="btn btn-xs btn-danger" title="Delete" data-toggle="modal"
                                                    data-target="#deleteModal" data-id="<?php echo e($product->id); ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <?php if(request('status') == 'near_expiry'): ?>
                                            No near expiry items found.
                                        <?php else: ?>
                                            No products found.
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="addProductModalBody">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#addProductBtn', function () {
            $.ajax({
                url: "<?php echo e(route('products.create')); ?>",
                type: "GET",
                success: function (response) {
                    $('#addProductModalBody').html(response);
                },
                error: function () {
                    $('#addProductModalBody').html('<div class="alert alert-danger">Unable to load form.</div>');
                }
            });
        });
    </script>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">Confirm Delete</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
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

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="editModalBody">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $(document).on('click', '.open-edit-modal', function() {
            const productId = $(this).data('id');
            const url = '/products/' + productId + '/edit';

            $.get(url, function(response) {
                $('#editModalBody').html(response);
                $('#editModal').modal('show');
            }).fail(function() {
                alert('Failed to load edit form.');
            });
        });

        // Clear modal content on close
        $('#editModal').on('hidden.bs.modal', function () {
            $('#editModalBody').html('');
        });
    });
    </script>

    <!-- Delete Product Script -->
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            var actionUrl = '/products/' + productId;

            $('#deleteForm').attr('action', actionUrl);
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/products/index.blade.php ENDPATH**/ ?>