<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php if(!empty($page_title)): ?>
            <?php echo e(remove_junk($page_title)); ?>

        <?php elseif(!empty($user)): ?>
            <?php echo e(ucfirst($user->name)); ?>

        <?php else: ?>
            Inventory Management System
        <?php endif; ?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <?php if(auth()->check()): ?>
        <?php $user = auth()->user(); ?>
        <header id="header">
            <div class="logo pull-left">
                <img src="<?php echo e(asset('lib/images/whitelogo.png')); ?>" alt="Francheska's IMS Logo" />
            </div>
            <div class="header-content">
            <div class="header-date pull-left">
    <strong><?php echo e(now()->timezone('Asia/Manila')->format('F j, Y, g:i a')); ?></strong></div>
                <div class="pull-right clearfix">
                    <ul class="info-menu list-inline list-unstyled">
                        <li class="profile">
                            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                          <img src="<?php echo e($user->image ? asset('lib/images/' . $user->image) : asset('lib/images/whitelogo.png')); ?>" alt="user-image" class="img-circle img-inline" style="width: 40px; height: 40px;">

                                <span><?php echo e(ucfirst($user->name)); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="last">
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="glyphicon glyphicon-off"></i> Logout
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="sidebar">
            <?php if($user->user_level === 1): ?>
                <!-- admin menu -->
                <?php echo $__env->make('admin.admin_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif($user->user_level === 2): ?>
                <!-- Special user -->
                <?php echo $__env->make('special_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif($user->user_level === 3): ?>
                <!-- User menu -->
                <?php echo $__env->make('user_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="page">
        <div class="container-fluid">
            <!-- Content goes here -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
<?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/layouts/header.blade.php ENDPATH**/ ?>