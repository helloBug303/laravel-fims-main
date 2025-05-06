

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="center-form-wrapper">
        <!-- Display Session Messages -->
        <?php if(session('msg')): ?>
            <div class="alert alert-success"><?php echo e(session('msg')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Category Edit Panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Edit <?php echo e($category->name); ?> Category
                </strong>
            </div>
            <div class="panel-body">
                <form method="POST" action="<?php echo e(route('categories.update', $category->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="categorie_name">Category Name</label>
                        <input type="text" name="categorie_name" id="categorie_name" class="form-control" value="<?php echo e(old('categorie_name', $category->name)); ?>" required>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Update</button>
                        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/categories/edit.blade.php ENDPATH**/ ?>