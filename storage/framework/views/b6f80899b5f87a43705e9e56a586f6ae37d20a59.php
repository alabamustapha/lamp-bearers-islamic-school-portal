<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> </title>


        <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

        <?php echo $__env->yieldContent('styles'); ?>
        <link href="<?php echo e(asset('css/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet">

        <link href="<?php echo e(asset('css/animate.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">


</head>
<body>

  <!-- Wrapper-->
    <div id="wrapper">




        <!-- Navigation -->
        <?php echo $__env->make('layouts.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            <?php echo $__env->make('layouts.topnavbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- breadcrumbs -->
            <?php echo $__env->yieldContent('page-heading'); ?>

            <!-- Main view  -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->


    <!-- Mainly scripts -->
    <script src="<?php echo e(asset('js/jquery-2.1.1.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/metisMenu/jquery.metisMenu.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/slimscroll/jquery.slimscroll.min.js')); ?>"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo e(asset('js/inspinia.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/pace/pace.min.js')); ?>"></script>

    <!-- jQuery UI -->
    <script src="<?php echo e(asset('js/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/plugins/toastr/toastr.min.js')); ?>"></script>

    <!-- offline js -->
    <script src="<?php echo e(asset('js/offline-js.js')); ?>"></script>


    <script>


        Offline.options = {
          game: true
        };
        var offline_check = function(){
          Offline.check();
          if (Offline.state === 'up'){
                if($(".toast-error").length > 0){
                    toastr.success('connected');
                }
          }else{
                toastr.error('no connection');
          }

        };
        setInterval(offline_check, 5000);

        <?php if(session('message')): ?>

                toastr.options = {
                          "closeButton": true,
                          "debug": false,
                          "progressBar": true,
                          "preventDuplicates": false,
                          "positionClass": "toast-top-right",
                          "onclick": null,
                          "showDuration": "400",
                          "hideDuration": "1000",
                          "timeOut": "7000",
                          "extendedTimeOut": "1000",
                          "showEasing": "swing",
                          "hideEasing": "linear",
                          "showMethod": "fadeIn",
                          "hideMethod": "fadeOut"
                        };

                        toastr.success('<?php echo e(session('message')); ?>');


        <?php endif; ?>
    </script>
<?php echo $__env->yieldContent('scripts'); ?>


</body>
</html>
