<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($guardian->title . ' ' . $guardian->name); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('guardian')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('guardian/payments')); ?>">Payments</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Current Active Wards(<?php echo e($guardian->students()->whereIn('status',  ['active', 'promoting', 'promoted', 'repeating', 'repeated', 'graduating'] )->count()); ?>)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover .teacher-classroom-dataTables" >
                        <thead>
                        <tr>
                            <th>Ward's name</th>
                            <th>Admin number</th>
                            <th>Sex</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Term</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $__currentLoopData = $current_term_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                        <tr class="gradeA">
                            <td><?php echo e($payment['student']->name); ?></td>
                            <td><?php echo e($payment['student']->admin_number); ?></td>
                            <td><?php echo e($payment['student']->sex); ?></td>
                            <td><?php echo e(isset($payment['student']->classroom->name) ? $payment['student']->classroom->name : ""); ?></td>
                            <td><?php echo e($payment['term']); ?></td>
                            <td><?php echo e($payment['amount']); ?></td>
                            <td>
                                <form action="<?php echo e(url('guardian/payments/current_school_fees')); ?>" method="post">
                                    <input type='hidden' name="amount" value="<?php echo e($payment['amount'] * 100); ?>">
                                    <input type='hidden' name="email"  value="<?php echo e($payment['email']); ?>">
                                    <input type='hidden' name="callback_url"  value="<?php echo e(url('guardian/payments/current_school_fee/callback')); ?>">
                                    <input type="hidden" name="metadata" value="<?php echo e($payment['metadata']); ?>">
                                    <input type="hidden" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>">
                                    <input type="hidden" name="key" value="<?php echo e(config('paystack.secretKey')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <button type="submit" class="btn btn-primary"><i class="fa fa-credit-card"></i> Pay now</button>
                                </form>
                            </td>

                        </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Ward's name</th>
                            <th>Admin number</th>
                            <th>Sex</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Term</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        </table>
                            </div>
                </div>
            </div>
        </div>
    </div>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>