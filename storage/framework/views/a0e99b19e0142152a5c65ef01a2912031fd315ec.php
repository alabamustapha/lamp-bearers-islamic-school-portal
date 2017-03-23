<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title'); ?> | Result</title>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/schoolite.css')); ?>" rel="stylesheet">


</head>

<body class="white-bg result-page">
      <div class="wrapper wrapper-content">

           <?php echo $__env->yieldContent('result-heading'); ?>

           <?php echo $__env->yieldContent('result-body'); ?>

           <?php echo $__env->yieldContent('result-footer'); ?>
      </div>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo e(asset('js/inspinia.js')); ?>"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
