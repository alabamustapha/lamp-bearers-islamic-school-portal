<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">
<div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Total Active Students</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e($total_students); ?></h1>
                        <div class="pull-left font-bold text-success"><?php echo e($total_male_students); ?> <i class="fa fa-male"></i></div>
                        <div class="pull-right font-bold text-success"><?php echo e($total_female_students); ?> <i class="fa fa-female"></i></div>
                    </div>
                </div>
            </div>

           <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Total Active Teachers</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e($total_teachers); ?></h1>
                        <div class="pull-left font-bold text-success"><?php echo e($total_male_teachers); ?> <i class="fa fa-male"></i></div>
                        <div class="pull-right font-bold text-success"><?php echo e($total_female_teachers); ?> <i class="fa fa-female"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
               <div class="ibox float-e-margins">
                   <div class="ibox-title">
                      <h5 class="pull-left">Total Graduated Students</h5>
                   </div>
                   <div class="ibox-content">
                       <h1 class="text-center"><?php echo e(isset($total_graduated_students) ? $total_graduated_students : 0); ?></h1>
                       <div class="pull-left font-bold text-success"><?php echo e(isset($total_graduated_male_students) ? $total_graduated_male_students : 0); ?> <i class="fa fa-male"></i></div>
                       <div class="pull-right font-bold text-success"><?php echo e(isset($total_graduated_female_students) ? $total_graduated_female_students : 0); ?> <i class="fa fa-female"></i></div>
                   </div>
               </div>
           </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right"><?php if(isset($session) && !is_null($session)): ?> <?php echo e($session->term()); ?><?php else: ?><?php echo e('No session'); ?> <?php endif; ?></span>
                        <h5>Expected Payment</h5>
                    </div>
                    <div class="ibox-content">

                        <h1 class="text-center"><?php if(isset($session) && !is_null($session->term())): ?> <?php echo e('N' . number_format(expected_term_payment($session, $session->term()))); ?><?php else: ?><?php echo e('No session'); ?> <?php endif; ?></h1>
                        
                        
                    </div>
                </div>
            </div>
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