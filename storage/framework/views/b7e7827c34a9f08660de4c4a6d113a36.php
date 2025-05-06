<?php $__env->startSection('content'); ?>

<div class="container mt-4">
<div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400; ">
        <h2>Media</h2>
    </div>
    <div class="panel panel-default" style="max-width: 1500px; margin: 0 auto; overflow-y: auto;">
        <div class="panel-heading clearfix" style="padding: 20px;">
            <strong>
                <span class="glyphicon glyphicon-camera"></span>
                <span>All Photos</span>
            </strong>

            <div class="pull-right">
                <form class="form-inline" action="<?php echo e(route('media.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <input type="file" name="file_upload" multiple class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-upload"></span> Upload
                    </button>
                </form>
            </div>
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
                            <th class="text-center" style="width: 20%;">Photo</th>
                            <th class="text-center" style="width: 30%;">Photo Name</th>
                            <th class="text-center" style="width: 30%;">Photo Type</th>
                            <th class="text-center" style="width: 70px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $media_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media_file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td class="text-center">
                            <img src="<?php echo e(asset('lib/products/' . $media_file->file_name)); ?>" style="height: 80px; width: auto;">
                            </td>
                            <td class="text-center"><?php echo e($media_file->file_name); ?></td>
                            <td class="text-center"><?php echo e($media_file->file_type); ?></td>
                            <td class="text-center">
                                <form action="<?php echo e(route('media.destroy', $media_file->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No media files available.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel-fims-main\resources\views/media/index.blade.php ENDPATH**/ ?>