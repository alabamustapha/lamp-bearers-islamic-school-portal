<?php $__env->startSection('title', $student->name); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($student->name); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('guardian')); ?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo e(url('guardian/wards')); ?>">Wards</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('guardian/wards/' . $student->id)); ?>"><?php echo e($student->name); ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">


<?php echo $__env->make('layouts.partials.student.profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



    
    
    
        
            
                
                
                
                    
                
                
            
        
      
    
    

    
    
    
        
            
                
                
                
                    
                
                
            
        
      
    
    

    
    
    
        
            
                
                
                
                    
                
                
            
        
      
    
    



</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>