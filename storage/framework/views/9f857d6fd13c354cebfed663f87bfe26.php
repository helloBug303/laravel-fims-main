<?php $__env->startSection('content'); ?>

    <div class="container mt-4">

        <div
            style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
            <h2>Sales</h2>

            <!-- Search & Filter Section -->
            <div class="row mb-4">
                <!-- Search by Product Name -->
                <div class="col-md-6">
                    <form action="<?php echo e(route('sales.index')); ?>" method="GET" class="form-inline d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <input type="text" name="search" class="form-control" placeholder="Search by Product Name"
                                value="<?php echo e(request('search')); ?>" style="padding: 5px 10px; width: 100%;">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                        <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-secondary ml-2"
                            style="padding: 5px 10px;">Clear</a>
                    </form>
                </div>

                <!-- Filter by Date -->
                <div class="col-md-6 text-right">
                    <form action="<?php echo e(route('sales.index')); ?>" method="GET" class="form-inline d-flex justify-content-end">
                        <label class="mr-2">Filter by Date:</label>
                        <input type="date" name="date" class="form-control mr-2" value="<?php echo e(request('date')); ?>">
                        <button type="submit" class="btn btn-success">Filter</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="panel panel-default" style="width: 100%; max-width: 1200px; margin: 0 auto;">

            <div class="panel-heading" style="padding: 20px;">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Sales</span>
                </strong>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                    data-target="#addSaleModal">
                    Add Sale
                </button>

            </div>

            <div class="panel-body" style="padding: 30px;">
                <?php if(session('msg')): ?>
                    <div class="alert alert-success"><?php echo e(session('msg')); ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 40%;">Product Name</th>
                                <th class="text-center" style="width: 15%;">Quantity</th>
                                <th class="text-center" style="width: 15%;">Total ₱</th>
                                <th class="text-center" style="width: 15%;">Date</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($sale->product->name); ?></td>
                                    <td class="text-center"><?php echo e($sale->quantity); ?></td>
                                    <td class="text-center"><?php echo e($sale->price); ?></td>
                                    <td class="text-center"><?php echo e($sale->date->format('Y-m-d')); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('sales.edit', $sale->id)); ?>"
                                                class="btn btn-xs btn-warning edit-sale-btn" data-id="<?php echo e($sale->id); ?>"
                                                data-toggle="tooltip" title="Edit">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>

                                            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal"
                                                data-target="#confirmDeleteModal<?php echo e($sale->id); ?>" title="Delete">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="confirmDeleteModal<?php echo e($sale->id); ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmDeleteLabel<?php echo e($sale->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="confirmDeleteLabel<?php echo e($sale->id); ?>">Confirm Deletion
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this sale? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="<?php echo e(route('sales.destroy', $sale->id)); ?>" method="POST"
                                                    style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No sales found for this search or date filter.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Sale Modal -->
    <div class="modal fade" id="addSaleModal" tabindex="-1" role="dialog" aria-labelledby="addSaleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Sale</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>

                <form method="POST" action="<?php echo e(route('sales.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <!-- Session Messages -->
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger text-center"><?php echo e(session('error')); ?></div>
                        <?php endif; ?>

                        <!-- Product Selection -->
                        <div class="form-group">
                            <label for="main_product_id">Product</label>
                            <select name="main_product_id" id="main_product_id" class="form-control" required>
                                <option value="">Select a product</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($product->quantity > 0 && (!$product->expiry_date || $product->expiry_date >= now())): ?> <!-- Ensure only non-expired products are shown -->
                                        <option value="<?php echo e($product->id); ?>" 
                                            <?php if(old('main_product_id') == $product->id || ($selectedProduct && $selectedProduct->id == $product->id)): ?> selected <?php endif; ?>
                                            data-price="<?php echo e($product->sale_price); ?>" 
                                            data-name="<?php echo e($product->name); ?>"
                                            data-quantity="<?php echo e($product->quantity); ?>">
                                            <?php echo e($product->name); ?> (Stock: <?php echo e($product->quantity); ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['main_product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <input type="hidden" name="product_id" id="product_id_hidden">

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="product_name">Item</label>
                            <input type="text" id="product_name" class="form-control" readonly>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" readonly>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Quantity -->
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required >
                            <small id="quantity-warning" class="text-danger d-none"></small>
                            <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>



                        <!-- Total -->
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" name="total" id="total" class="form-control" readonly>
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add Sale</button>
                        <button type="reset" class="btn btn-warning" style="background-color: #6c757d; color: white; border: none;">Reset</button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Script block to handle dynamic price/total -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainProductDropdown = document.getElementById('main_product_id');
            const productIdHidden = document.getElementById('product_id_hidden');
            const productNameField = document.getElementById('product_name');
            const priceInput = document.getElementById('price');
            const quantityInput = document.getElementById('quantity');
            const totalInput = document.getElementById('total');
            const warningMessage = document.getElementById('quantity-warning');
            const submitBtn = document.querySelector('#addSaleModal form button[type="submit"]');

            function updateProductFields() {
                const selectedOption = mainProductDropdown.options[mainProductDropdown.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    productIdHidden.value = selectedOption.value;
                    productNameField.value = selectedOption.dataset.name || selectedOption.text;
                    priceInput.value = selectedOption.dataset.price || '';
                    calculateTotal();
                } else {
                    productIdHidden.value = '';
                    productNameField.value = '';
                    priceInput.value = '';
                    totalInput.value = '';
                }
            }

            function calculateTotal() {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value);
                const selectedOption = mainProductDropdown.options[mainProductDropdown.selectedIndex];
                const maxStock = parseInt(selectedOption.dataset.quantity) || 0;

                if (!isNaN(quantity) && quantity > 0 && quantity > maxStock) {
                    warningMessage.classList.remove('d-none');
                    warningMessage.textContent = 'Insufficient stock available';
                    submitBtn.disabled = true;
                } else {
                    warningMessage.classList.add('d-none');
                    warningMessage.textContent = '';
                    submitBtn.disabled = false;
                }

                totalInput.value = (!isNaN(quantity) ? (price * quantity).toFixed(2) : '');
            }



            // Listen for changes in the product selection and quantity input
            mainProductDropdown.addEventListener('change', updateProductFields);
            quantityInput.addEventListener('input', calculateTotal);

            // Initial population of product fields when the page loads
            if (mainProductDropdown.value) updateProductFields();
        });


        const addSaleForm = document.querySelector('#addSaleModal form');
        const submitBtn = addSaleForm.querySelector('button[type="submit"]');

        function validateQuantity() {
            const quantity = parseInt(quantityInput.value) || 0;
            const maxStock = parseInt(mainProductDropdown.options[mainProductDropdown.selectedIndex].dataset.quantity) || 0;
            const warning = document.getElementById('quantity-warning');

            if (quantity > maxStock) {
                warning.classList.remove('d-none');
                submitBtn.disabled = true;
            } else {
                warning.classList.add('d-none');
                submitBtn.disabled = false;
            }

            totalInput.value = (price * quantity).toFixed(2);
        }

        quantityInput.addEventListener('input', validateQuantity);
        mainProductDropdown.addEventListener('change', updateProductFields);

    </script>

    <!-- Edit Sale Modal -->
    <div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editSaleModalLabel">Edit Sale</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body" id="editSaleModalBody">
                    <!-- The edit form will be loaded here automatically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Script to disable expired products -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productDropdown = document.getElementById('main_product_id');
            const options = productDropdown.querySelectorAll('option');

            options.forEach(function (option) {
                const productExpiryDate = option.dataset.expiryDate; // Get expiry date from data attribute
                if (productExpiryDate && new Date(productExpiryDate) < new Date()) {
                    option.disabled = true; // Disable expired products
                }
            });
        });
    </script>



    <!-- AJAX Script -->
    <script>
        $(document).on('click', '.edit-sale-btn', function (e) {
            e.preventDefault();
            let saleId = $(this).data('id');
            let url = '/sales/' + saleId + '/edit';  // URL to fetch the form

            $('#editSaleModal').modal('show');  // Show the modal

            $.get(url, function (data) {
                // Populate the modal body with the form
                $('#editSaleModalBody').html(data);
            });
        });
    </script>



    <!-- Ensure jQuery and Bootstrap JS are loaded -->
    <?php $__env->startPush('scripts'); ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/sales/index.blade.php ENDPATH**/ ?>