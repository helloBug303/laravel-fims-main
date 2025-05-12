<?php $__env->startSection('content'); ?>

<div class="row">
    
    <div class="custom-col-md-12">
    <div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Sales Report</h2>
    </div>
        <h4>Sales Report from <?php echo e(\Carbon\Carbon::parse($startDate)->format('Y-m-d')); ?> to <?php echo e(\Carbon\Carbon::parse($endDate)->format('Y-m-d')); ?></h4>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Total Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $grandTotal = 0;
                    $totalProfit = 0;
                ?>
                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Calculate the total for this item
                        $itemTotal = $sale->quantity * ($sale->product->sale_price ?? 0);
                        // Calculate profit for this item
                        $itemProfit = $sale->quantity * (($sale->product->sale_price ?? 0) - ($sale->product->buy_price ?? 0));
                        
                        // Add to running totals
                        $grandTotal += $itemTotal;
                        $totalProfit += $itemProfit;
                    ?>
                    <tr>
                        <td><?php echo e(\Carbon\Carbon::parse($sale->date)->format('Y-m-d')); ?></td>
                        <td><?php echo e(ucfirst($sale->product->name)); ?></td>
                        <td><?php echo e(number_format($sale->product->buy_price ?? 0, 2)); ?></td>
                        <td><?php echo e(number_format($sale->product->sale_price ?? 0, 2)); ?></td>
                        <td><?php echo e($sale->quantity); ?></td>
                        <td><?php echo e(number_format($itemTotal, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr class="text-right">
                    <td colspan="5"><strong>Grand Total</strong></td>
                    <td>₱<?php echo e(number_format($grandTotal, 2)); ?></td>
                </tr>
                <tr class="text-right">
                    <td colspan="5"><strong>Profit</strong></td>
                    <td>₱<?php echo e(number_format($totalProfit, 2)); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/sales/report_result.blade.php ENDPATH**/ ?>