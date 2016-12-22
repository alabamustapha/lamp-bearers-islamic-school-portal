<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="lock-word animated fadeInDown">
    <span class="first-word">LOCKED</span><span>SCREEN</span>
</div>
    <div class="middle-box text-center lockscreen animated fadeInDown">
        <div>
            <div class="m-b-md">
            
            </div>
            <p>Your are in lock screen.You need to enter a valid licence key to continue.</p>
            <form class="m-t" role="form" action="<?php echo e(url('add_licence')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <input type="text" name="licence_key" class="form-control" min="16" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width">Validate Licence</button>
            </form>
        </div>
    </div>

                 
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>




<script>




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

        toastr.success('<?php echo e('Welcome back admin'); ?>');
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>