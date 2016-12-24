<?php $__env->startSection('title', 'Upcoming Payments'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">
<div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Students yet to pay</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e($students->count()); ?></h1>
                        
                        
                    </div>
                </div>
            </div>

           <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Upcoming revenue</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e('N' . number_format($total_amount)); ?></h1>
                        
                        
                    </div>
                </div>
            </div>

             <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Paid revenue</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e($session ?  'N' . number_format(expected_term_payment($session->id, $term) - $total_amount) : 'N/A'); ?></h1>
                        
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Upcoming Percentage</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center"><?php echo e($session ? $total_amount * 100 / expected_term_payment($session->id, $term) . '%': 'N/A'); ?></h1>
                        
                        
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