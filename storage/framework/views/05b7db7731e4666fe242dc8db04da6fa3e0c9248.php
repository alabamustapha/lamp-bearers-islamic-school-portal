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


<div class="row m-t-sm">
    <div class="col-lg-6">

       <table class="table table-bordered table-stripped">
        <thead>
            <th>Session</th>
            <th>First Term</th>
            <th>Second Term</th>
            <th>Third Term</th>
            <th>Analytics</th>
        </thead>
        <tbody>
            <?php $__currentLoopData = $academic_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session_name => $session_results): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr>
                    <td><?php echo e($session_name); ?></td>
                    <td><?php echo e($student->term_percentage($session_results['first_term'])); ?></td>
                    <td><?php echo e($student->term_percentage($session_results['second_term'])); ?></td>
                    <td><?php echo e($student->term_percentage($session_results['third_term'])); ?></td>
                    <td>View Analytics</td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </tbody>
        </table>
    </div>
    <div class="col-lg-6">

    </div>
</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>