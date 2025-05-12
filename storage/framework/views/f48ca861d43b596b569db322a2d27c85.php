<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="custom-col-md-12">
    <div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Sales Report</h2>
    </div>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
    </div>
    
</div>

<div class="row">
    
    <div class="report-custom-col-md-12">
        
        <div class="panel">
            
            <div class="panel-heading">
                <h4>Generate Sales Report</h4>
            </div>
            <div class="panel-body">
                <form method="POST" action="<?php echo e(route('sales.report.byDates')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="date-range">Date Range</label>
                        <div class="input-group">
                            <input type="date" name="start-date" class="form-control" required>
                            <span class="input-group-addon"> > </span>
                            <input type="date" name="end-date" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/sales/report.blade.php ENDPATH**/ ?>