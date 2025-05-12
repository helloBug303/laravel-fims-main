<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('lib/images/invenLogo22.png')); ?>">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>


<body class="login-page-body">
    <div class="login-container">
        <div class="login-header">
        <img src="<?php echo e(asset('lib/images/invenLogo22.png')); ?>" alt="Francheska's IMS Logo" />
            <p>Please log in to continue</p>
        </div>

        <?php if($errors->any()): ?>
            <ul class="error-msg">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><strong>Error:</strong> <?php echo e($error); ?> </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo e(old('username')); ?>" placeholder="Enter your username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
<?php /**PATH E:\xampp\htdocs\laravel-fims-main\resources\views/auth/login.blade.php ENDPATH**/ ?>