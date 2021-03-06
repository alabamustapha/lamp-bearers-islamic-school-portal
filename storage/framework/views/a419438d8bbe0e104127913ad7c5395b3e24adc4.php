
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>School | Login</title>

    <link href="css/app.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <img src="<?php echo e(asset('img/logo.png')); ?>" class="img-circle circle-border m-b-md" alt="logo" width="200px">

            </div>
            <h3>Welcome to Lamp Bearers Islamic School's Portal</h3>
            <p>Login in. To continue.</p>
            <?php if(count($errors) > 0): ?>
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <strong>Whoops! Something went wrong!</strong>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form class="m-t" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo e(csrf_field()); ?>

                <div class="form-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                    <input id="username" type="text" class="form-control" name="username" placeholder="user id" value="<?php echo e(old('username')); ?>" required autofocus>

                    <?php if($errors->has('username')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('username')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">

                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo e(url('#')); ?>">Contact the admin</a>
            </form>
            <p class="m-t">Created by <small> <a href="http://redehub.com.ng">redehubng</a> &copy; <?php echo e('2015 - ' . date('Y')); ?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/app.js"></script>

</body>

</html>