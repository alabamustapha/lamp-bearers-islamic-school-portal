<?php $__env->startSection('title',  $student->name); ?>


<?php $__env->startSection('result-heading'); ?>
<img src="<?php echo e(asset('img/banner.jpg')); ?>" class="m-b-xs" alt="profile" width="100%">
  <div class="row m-b-xs m-t-xs">
                <div class="col-md-12">

                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                           
                                
                                    
                                
                            
                            <td>
                                Name: <strong> <?php echo e($student->name); ?> </strong>
                            </td>
                            <td>
                                Reg Number: <strong> <?php echo e($student->admin_number); ?> </strong>
                            </td>
                            <td>
                                Class: <strong> <?php echo e($results->first()->classroom->name); ?> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Academic year: <strong> <?php echo e($results->first()->session->name); ?> </strong>
                            </td>
                            <td>
                                Position: <strong> <?php echo e($student->first_term_position($results->first()->session_id)); ?> </strong>
                            </td>
                            <td>
                              <strong>Term</strong> <?php echo e(ucfirst($results->first()->term)); ?>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('result-body'); ?>
        <table class="table table-bordered small result-table">
            <thead>
            <tr>
                <th>Subjects</th>
                <th class="text-center">CA1/20</th>
                <th class="text-center">CA2/20</th>
                <th class="text-center">CA Total</th>
                <th class="text-center">Exam/60</th>
                <th class="text-center">Grand Total</th>
                <th class="text-center">Grade</th>
                
                <th class="text-center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <tr>
                <td><?php echo e($result->subject->name); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->first_ca, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->second_ca, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->first_ca + $result->second_ca, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->exam, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->total(), 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e($result->grade()); ?></td>
                
                <td class="text-center"><?php echo e($result->remark()); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <tr>
                <td></td>
                <td>Total Mark</td>
                <td><?php echo e($student->first_term_results($results->first()->session_id)->sum('first_ca') +
                    $student->first_term_results($results->first()->session_id)->sum('second_ca') +
                    $student->first_term_results($results->first()->session_id)->sum('exam')); ?>

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Average</td>
                <td><?php echo e(round($student->term_percentage($results), 2)); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Percentage</td>
                <td><?php echo e(round($student->term_percentage($results), 0) . '%'); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('result-footer'); ?>
<table class="table table-bordered small">
    <tr>
        <td>RATING SCALES</td>
        <td>70-100 Excellent</td>
        <td>60-69 Very Good</td>
        <td>50-59 Good</td>
        <td>45-49 Fair</td>
        <td>40-44 Poor</td>
        <td>00-39 Fail</td>
    </tr>
</table>


<table class="table small">
            <tr>
                <td>Grade</td>
                <td><?php echo e(grade(round($student->term_percentage($results), 0))); ?></td>
            </tr>
            <tr>
                <td>No. of Student in Class</td>
                <td><?php echo e($results->first()->classroom_students_count()); ?></td>
            </tr>
            <tr>
                <td>Next Term Begin</td>
                <td></td>
            </tr>
            <tr>
                <td>Teacher's Comment</td>
                <td height="20"><?php echo e(class_teacher_remark(round($student->term_percentage($results)))); ?></td>
            </tr>
            <tr>
                <td>Head Teacher's Sign</td>
                <td><img src="<?php echo e(asset('img/sign.png')); ?>" width="80px" height="35px"></td>
            </tr>
        </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>