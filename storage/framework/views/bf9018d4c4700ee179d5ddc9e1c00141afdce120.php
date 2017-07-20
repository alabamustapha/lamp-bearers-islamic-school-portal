<?php $__env->startSection('title',  $student->name); ?>

<?php $__env->startSection('result-heading'); ?>

<?php $__env->startSection('result-heading'); ?>
<img src="<?php echo e(asset('img/banner.jpg')); ?>" class="m-b-xs" alt="profile" width="100%">
  <div class="row m-b-xs m-t-xs">
                <div class="col-xs-12">

                    <div class="col-xs-5">
                        <table class="table small m-b-xs result-table">
                            <tbody>
                            <tr>
                                <td>
                                    Name: <strong> <?php echo e($student->name); ?> </strong>
                                </td>
                                <td>
                                    Reg Number: <strong> <?php echo e($student->admin_number); ?> </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Class: <strong> <?php echo e($results->first()->classroom->level->name . ' ' . $results->first()->classroom->name); ?> </strong>
                                </td>
                                <td>
                                    House: <strong> <?php echo e($student->house->name); ?> </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    No in class: <strong> <?php echo e($results->first()->classroom_students_count()); ?> </strong>
                                </td>
                                
                                
                                    
                                
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-2">

                        <div class="profile-image">
                            <img src="<?php echo e(has_image($student) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png')); ?>" class="img-rounded m-b-md" alt="profile">
                        </div>

                    </div>
                    <div class="col-xs-5">

                                        <table class="table small m-b-xs result-table">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    Academic year: <strong> <?php echo e($results->first()->session->name); ?> </strong>
                                                </td>
                                                <td>
                                                  <strong>Term</strong> <?php echo e(ucfirst($results->first()->term)); ?>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    No. of days School opened: <strong> <?php echo e("108"); ?> </strong>
                                                </td>
                                                <td>
                                                    No. of days present: <strong> <?php echo e(""); ?> </strong>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    % of days present: <strong> <?php echo e(""); ?> </strong>
                                                </td>

                                                <td>
                                                    House: <strong> <?php echo e($student->house->name); ?> </strong>
                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                    </div>

                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('result-body'); ?>
        <table class="table table-bordered small result-table" id="subject-scores">
            <thead>
            <tr>
                <th>Subjects</th>
                <th class="text-center">1st Term</th>
                <th class="text-center">2nd Term</th>
                
                
                <th class="text-center">CA Total</th>
                <th class="text-center">Exam/60</th>
                <th class="text-center">Grand Total</th>
                <th class="text-center">Session Avg</th>
                <th class="text-center">Class Highest</th>
                <th class="text-center">Class Average</th>
                <th class="text-center">Position</th>
                <th class="text-center">Grade</th>
                <th class="text-center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <tr>
                <td><?php echo e($result->subject->name); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->first_term_total(), 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->second_term_total(), 2, '0', 0)); ?></td>
                
                
                <td class="text-center"><?php echo e(str_pad($result->first_ca + $result->second_ca, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->exam, 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->total(), 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(round(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3, 1)); ?></td>
                <td class="text-center"><?php echo e(str_pad($result->class_highest_mark(), 2, '0', 0)); ?></td>
                <td class="text-center"><?php echo e(round($result->class_average(), 1)); ?></td>
                <td class="text-center"><?php echo e($result->position()); ?></td>
                <td class="text-center"><?php echo e(grade(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3)); ?></td>
                
                <td class="text-center"><?php echo e(remark(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
             <tr>
                <td></td>
                <td>Total Mark</td>
                <td>
                <?php echo e($student->third_term_results($results->first()->session->id)->sum('first_ca') +
                    $student->third_term_results($results->first()->session->id)->sum('second_ca') +
                    $student->third_term_results($results->first()->session->id)->sum('exam')); ?>

                </td>
                <td></td>
                <td></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
             
                
                
                
                        
                        
                   
                
                
                
                
                
                
                
                
            
            </tbody>
        </table>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('result-footer'); ?>


<div class="row">
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Handwriting</td>
                        <td><?php echo e(isset($psychomotor->handwriting) ? $psychomotor->handwriting : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Drawing &amp; Painting</td>
                        <td><?php echo e(isset($psychomotor->drawing_painting) ? $psychomotor->drawing_painting : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Games &amp; Sports</td>
                        <td><?php echo e(isset($psychomotor->games_sports) ? $psychomotor->games_sports : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Computer Appreciation</td>
                        <td><?php echo e(isset($psychomotor->computer_appreciation) ? $psychomotor->computer_appreciation : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Recitation Skills</td>
                        <td><?php echo e(isset($psychomotor->recitation_skills) ? $psychomotor->recitation_skills : ''); ?></td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Character &amp; Development</th>
                    <th>Rating</th>
                </thead>

                <tbody>
                    <tr>
                        <td>Punctuality</td>
                        <td><?php echo e(isset($psychomotor->punctuality) ? $psychomotor->punctuality : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Neatness</td>
                        <td><?php echo e(isset($psychomotor->neatness) ? $psychomotor->neatness : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Politeness</td>
                        <td><?php echo e(isset($psychomotor->politeness) ? $psychomotor->politeness : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Cooperation with others</td>
                        <td><?php echo e(isset($psychomotor->cooperation) ? $psychomotor->cooperation : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Leadership</td>
                        <td><?php echo e(isset($psychomotor->leadership) ? $psychomotor->leadership : ''); ?></td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Emotional Stability</td>
                        <td><?php echo e(isset($psychomotor->emotional_stability) ? $psychomotor->emotional_stability : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Health</td>
                        <td><?php echo e(isset($psychomotor->health) ? $psychomotor->health : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Attentiveness</td>
                        <td><?php echo e(isset($psychomotor->attentiveness) ? $psychomotor->attentiveness : ''); ?></td>
                    </tr>
                    <tr>
                        <td>Attitude to work</td>
                        <td><?php echo e(isset($psychomotor->attitude_to_work) ? $psychomotor->attitude_to_work : ''); ?></td>
                    </tr>

                </tbody>
            </table>
    </div>
        <div class="col-xs-3">

            <canvas id="barChart" heigth="150px"></canvas>

        </div>

</div>
<table class="table table-bordered small result-table">
    <tr>
        <td>RATING SCALES</td>
        <td>70-100 Excellent ( A )</td>
        <td>60-69 Very Good ( B )</td>
        <td>50-59 Good ( C )</td>
        <td>45-49 Fair ( D )</td>
        <td>40-44 Poor ( E )</td>
        <td>00-39 Fail ( F )</td>
    </tr>
</table>


<table class="table small result-table">
            <tr>
                <td colspan="2">Class Teacher's Comment: <strong><em class="text-right"><?php echo e(isset($comment->body) ? $comment->body : ''); ?></em></strong></td>
                
                
            </tr>
            <tr>
                <td>Date: <strong><em> <?php echo e(date('m - d - Y')); ?> </em></strong></td>
                <td>Signature</td>
                

            </tr>

            <tr>
                <td colspan="2">Head Teacher's Comment: <strong><em><?php echo e(head_teacher_remark(round($student->term_percentage($results))) . ". "); ?> <?php echo e($student->status == "promoting" ? "Promoted to " . $student->classroom->level->name . " ". $student->classroom->name : " " . $student->status == "repeating" ? "Repeated to " . $student->classroom->level->name . " ". $student->classroom->name : " "); ?></em></strong></td>
                
            </tr>
            <tr>
                <td>Date</td>
                <td>Signature</td>
                
            </tr>
            <tr>
                <td>Next Term Begin: <strong><em>11th, September 2017</em></strong></td>
                <td>Next Term Fee: <?php echo e('N' . number_format($student->next_term_charges('third'))); ?></td>
            </tr>
        </table>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>