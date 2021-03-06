<?php $__env->startSection('title', $classroom->level->name . ' '  . $classroom->name); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/plugins/dataTables/datatables.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($classroom->name); ?> - <?php echo e($subject->subject->name); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('teacher')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/subjects/' . $subject->id)); ?>"><?php echo e($subject->subject->name); ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
                <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                    Upload Result
                </button>
                 <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">


                                <form method="POST" class="form" enctype="multipart/form-data" action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/subjects/' . $subject->subject->id . '/update_students_term_results_excel')); ?>">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                     <h4 class="modal-title"><?php echo e($classroom->level->name . ' ' . $classroom->name . ' - ' . $subject->subject->short_name); ?></h4>

                                </div>

                                <div class="modal-body">



                                    <?php echo e(csrf_field()); ?>

                                     <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                     <input type="hidden" name="subject_id" value="<?php echo e($subject->subject->id); ?>">
                                     <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                     <input type="hidden" name="session_id" value="<?php echo e($session->id); ?>">

                                  <?php if(count($errors) > 0): ?>
                                     <!-- Form Error List -->
                                     <div class="alert alert-danger">
                                         <strong>Whoops! Something went wrong!</strong>
                                         <ul>
                                             <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                 <li><?php echo e($error); ?></li>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                         </ul>
                                     </div>
                                 <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label" for="upload_students_term_results_excel">Select file</label>
                                                <input type="file" name="students_term_results" id="upload_students_term_results_excel" class="form-control" required>
                                            </div>
                                         </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Term </label>
                                                    <select class="form-control" name="term" required>
                                                        <option></option>
                                                        <option value="first"  <?php echo e(old('term') == 'first' ? 'selected' : ''); ?>>First</option>
                                                        <option value="second" <?php echo e(old('term') == 'second' ? 'selected' : ''); ?>>Second</option>
                                                        <option value="third"  <?php echo e(old('term') == 'third' ? 'selected' : ''); ?>>Third</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload result</button>
                                </div>

                         </form>
                         </div>
                    </div>
                </div>
        </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

 <div class="wrapper wrapper-content animated fadeInRight ecommerce">

     <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Update students First term result</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none">
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                            <thead>
                                <tr>
                                    <th>Admin Number</th>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Class Highest</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr class="gradeX">
                                    <td><?php echo e($student->admin_number); ?></td>
                                    <td><a href="#" title="Alaba profile" target="_blank"><?php echo e($student->name); ?></a></td>
                                    <td><?php echo e($student->sex); ?></td>

                                    <?php $score = $student->student_subject_session_term_result($subject->subject->id, $session->id, 'first') ?>

                                      <form method="POST" action="<?php echo e(url('teacher/classrooms/'. $classroom->id .'/subjects/' . $subject->id . '/students/' .$student->id. '/results/create')); ?>">

                                          <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                          <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                          <input type="hidden" name="subject_id" value="<?php echo e($subject->subject->id); ?>">
                                          <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                          <input type="hidden" name="session_id" value="<?php echo e($session->id); ?>">
                                          <input type="hidden" name="term" value="first">

                                          <td style="width: 13%;">

                                              <div class="input-group">
                                                  <input type="number" name="first_ca" class="form-control first_ca" value="<?php echo e(!is_null($score) ? $score->first_ca : ''); ?>" max="20" min="0">
                                                  
                                              </div>
                                          </td>
                                          <td style="width: 13%;">

                                              <div class="input-group">
                                                  <input type="number" name="second_ca" class="form-control second_ca" value="<?php echo e(!is_null($score) ? $score->second_ca : ''); ?>" max="20" min="0">
                                                  
                                              </div>
                                          </td>
                                          <td style="width: 13%;">
                                              <div class="input-group">
                                                  <input type="number" name="exam" class="form-control exam" value="<?php echo e(!is_null($score) ? $score->exam : ''); ?>" max="60" min="0">
                                              </div>
                                          </td>
                                      </form>
                                      <td class="total-score">
                                           <?php echo e(!is_null($score) ? $score->total() : ''); ?>

                                      </td>
                                      <td class="class-highest">
                                          <?php echo e(!is_null($score) ? $score->class_highest_mark() : ''); ?>

                                        </td>
                                      <td class="score-grade">
                                        <?php echo e(!is_null($score) ? $score->grade() : ''); ?>

                                      </td>
                                      <td class="score-position">
                                        <?php echo e(!is_null($score) ? $score->position() : ''); ?>

                                      </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Admin Number</th>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Class Highest</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if(isset($session) && !is_null($session) && $session->term() == 'first'): ?>
     <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Update students <?php echo e($session->term()); ?> term result</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none">
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                            <thead>
                                <tr>
                                    <th>Admin Number</th>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Class Highest</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr class="gradeX">
                                    <td><?php echo e($student->admin_number); ?></td>
                                    <td><a href="#" title="Alaba profile" target="_blank"><?php echo e($student->name); ?></a></td>
                                    <td><?php echo e($student->sex); ?></td>

                                    <?php $score = $student->student_subject_session_term_result($subject->subject->id, $session->id, 'first') ?>

                                      <form method="POST" action="<?php echo e(url('teacher/classrooms/'. $classroom->id .'/subjects/' . $subject->id . '/students/' .$student->id. '/results/create')); ?>">

                                          <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                          <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                          <input type="hidden" name="subject_id" value="<?php echo e($subject->subject->id); ?>">
                                          <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                          <input type="hidden" name="session_id" value="<?php echo e($session->id); ?>">
                                          <input type="hidden" name="term" value="<?php echo e($session->term()); ?>">

                                          <td style="width: 13%;">

                                              <div class="input-group">
                                                  <input type="number" name="first_ca" class="form-control first_ca" value="<?php echo e(!is_null($score) ? $score->first_ca : ''); ?>" max="20" min="0">
                                                  
                                              </div>
                                          </td>
                                          <td style="width: 13%;">

                                              <div class="input-group">
                                                  <input type="number" name="second_ca" class="form-control second_ca" value="<?php echo e(!is_null($score) ? $score->second_ca : ''); ?>" max="20" min="0">
                                                  
                                              </div>
                                          </td>
                                          <td style="width: 13%;">
                                              <div class="input-group">
                                                  <input type="number" name="exam" class="form-control exam" value="<?php echo e(!is_null($score) ? $score->exam : ''); ?>" max="60" min="0">
                                              </div>
                                          </td>
                                      </form>
                                      <td class="total-score">
                                           <?php echo e(!is_null($score) ? $score->total() : ''); ?>

                                      </td>
                                      <td class="class-highest">
                                          <?php echo e(!is_null($score) ? $score->class_highest_mark() : ''); ?>

                                        </td>
                                      <td class="score-grade">
                                        <?php echo e(!is_null($score) ? $score->grade() : ''); ?>

                                      </td>
                                      <td class="score-position">
                                        <?php echo e(!is_null($score) ? $score->position() : ''); ?>

                                      </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Admin Number</th>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Class Highest</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif(isset($session) && !is_null($session) && $session->term() == 'second'): ?>
          <div class="row">
             <div class="col-lg-12">
                 <div class="ibox float-e-margins">
                     <div class="ibox-title">
                         <h5>Update students <?php echo e($session->term()); ?> term result</h5>
                         <div class="ibox-tools">
                             <a class="collapse-link">
                                 <i class="fa fa-chevron-up"></i>
                             </a>
                             <a class="close-link">
                                 <i class="fa fa-times"></i>
                             </a>
                         </div>
                     </div>
                     <div class="ibox-content" style="display: none">
                         <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                                 <thead>
                                     <tr>
                                         <th>Admin Number</th>
                                         <th>Name</th>
                                         <th>Sex</th>
                                         <th>CA1</th>
                                         <th>CA2</th>
                                         <th>Exam</th>
                                         <th>Total</th>
                                         
                                         <th>Grade</th>
                                         <th>Position</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                     <tr class="gradeX">
                                         <td><?php echo e($student->admin_number); ?></td>
                                         <td><a href="#" title="Alaba profile" target="_blank"><?php echo e($student->name); ?></a></td>
                                         <td><?php echo e($student->sex); ?></td>

                                         <?php $score = $student->student_subject_session_term_result($subject->subject->id, $session->id, 'second') ?>

                                           <form method="POST" action="<?php echo e(url('teacher/classrooms/'. $classroom->id .'/subjects/' . $subject->id . '/students/' .$student->id. '/results/create')); ?>">
                                               <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                               <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                               <input type="hidden" name="subject_id" value="<?php echo e($subject->subject->id); ?>">
                                               <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                               <input type="hidden" name="session_id" value="<?php echo e($session->id); ?>">
                                               <input type="hidden" name="term" value="<?php echo e($session->term()); ?>">

                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="first_ca" class="form-control first_ca" value="<?php echo e(!is_null($score) ? $score->first_ca : ''); ?>" max="20" min="0">
                                                       
                                                   </div>
                                               </td>
                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="second_ca" class="form-control second_ca" value="<?php echo e(!is_null($score) ? $score->second_ca : ''); ?>" max="20" min="0">
                                                       
                                                   </div>
                                               </td>
                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="exam" class="form-control exam" value="<?php echo e(!is_null($score) ? $score->exam : ''); ?>" max="60" min="0">
                                                       
                                                   </div>
                                               </td>
                                           </form>
                                           <td class="total-score">
                                                <?php echo e(!is_null($score) ? $score->total() : ''); ?>

                                           </td>
                                           
                                             
                                           
                                           <td class="score-grade">
                                             <?php echo e(!is_null($score) ? $score->grade() : ''); ?>

                                           </td>
                                           <td class="score-position">
                                             <?php echo e(!is_null($score) ? $score->position() : ''); ?>

                                           </td>
                                     </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                     </tbody>
                                     <tfoot>
                                     <tr>
                                         <th>Admin Number</th>
                                         <th>Name</th>
                                         <th>Sex</th>
                                         <th>CA1</th>
                                         <th>CA2</th>
                                         <th>Exam</th>
                                         <th>Total</th>
                                         
                                         <th>Grade</th>
                                         <th>Position</th>
                                     </tr>
                                     </tfoot>
                                 </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <?php elseif(isset($session) && !is_null($session) && $session->term() == 'third'): ?>
                   <div class="row">
                      <div class="col-lg-12">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <h5>Update students <?php echo e($session->term()); ?> term result</h5>
                                  <div class="ibox-tools">
                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content" style="display: none">
                                  <div class="table-responsive">
                                          <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                                          <thead>
                                              <tr>
                                                  <th>Admin Number</th>
                                                  <th>Name</th>
                                                  <th>Sex</th>
                                                  <th>CA1</th>
                                                  <th>CA2</th>
                                                  <th>Exam</th>
                                                  <th>Total</th>
                                                  <th>Grade</th>
                                                  <th>Position</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                              <tr class="gradeX">
                                                  <td><?php echo e($student->admin_number); ?></td>
                                                  <td><a href="#" title="Alaba profile" target="_blank"><?php echo e($student->name); ?></a></td>
                                                  <td><?php echo e($student->sex); ?></td>

                                                  <?php $score = $student->student_subject_session_term_result($subject->subject->id, $session->id, 'third') ?>

                                                    <form method="POST" action="<?php echo e(url('teacher/classrooms/'. $classroom->id .'/subjects/' . $subject->id . '/students/' .$student->id. '/results/create')); ?>">
                                                        <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                                        <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                                        <input type="hidden" name="subject_id" value="<?php echo e($subject->subject->id); ?>">
                                                        <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                                        <input type="hidden" name="session_id" value="<?php echo e($session->id); ?>">
                                                        <input type="hidden" name="term" value="<?php echo e($session->term()); ?>">

                                                        <td style="width: 13%;">
                                                            <div class="input-group">
                                                                <input type="number" name="first_ca" class="form-control first_ca" value="<?php echo e(!is_null($score) ? $score->first_ca : ''); ?>" max="20" min="0">
                                                                
                                                            </div>
                                                        </td>
                                                        <td style="width: 13%;">
                                                            <div class="input-group">
                                                                <input type="number" name="second_ca" class="form-control second_ca" value="<?php echo e(!is_null($score) ? $score->second_ca : ''); ?>" max="20" min="0">
                                                                
                                                            </div>
                                                        </td>
                                                        <td style="width: 13%;">
                                                            <div class="input-group">
                                                                <input type="number" name="exam" class="form-control exam" value="<?php echo e(!is_null($score) ? $score->exam : ''); ?>" max="60" min="0">
                                                                
                                                            </div>
                                                        </td>
                                                    </form>
                                                    <td class="total-score">
                                                         <?php echo e(!is_null($score) ? $score->total() : ''); ?>

                                                    </td>
                                                    <td class="score-grade">
                                                      <?php echo e(!is_null($score) ? $score->grade() : ''); ?>

                                                    </td>
                                                    <td class="score-position">
                                                      <?php echo e(!is_null($score) ? $score->position() : ''); ?>

                                                    </td>
                                              </tr>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                              </tbody>
                                              <tfoot>
                                              <tr>
                                                  <th>Admin Number</th>
                                                  <th>Name</th>
                                                  <th>Sex</th>
                                                  <th>CA1</th>
                                                  <th>CA2</th>
                                                  <th>Exam</th>
                                                  <th>Total</th>
                                                  <th>Grade</th>
                                                  <th>Position</th>
                                              </tr>
                                              </tfoot>
                                          </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
<?php endif; ?>

 </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<script src=" <?php echo e(asset('js/plugins/dataTables/datatables.min.js')); ?>"></script>
        <script>
                 $(document).ready(function(){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('input.first_ca').change(function(){
                        if($(this).val() > 20){
                            $(this).addClass('text-danger');
                        }else{
                            if($(this).hasClass('text-danger')) {
                                $(this).removeClass('text-danger')
                                }
                        }
                    });

                    $('input.second_ca').change(function(){
                        if($(this).val() > 20){
                            $(this).addClass('text-danger');
                        }else{
                             if($(this).hasClass('text-danger')) {
                                 $(this).removeClass('text-danger')
                                 }
                         }
                    });


                    $('input.exam').change(function(){
                        if($(this).val() > 60){
                            $(this).addClass('text-danger');
                        }else{
                             if($(this).hasClass('text-danger')) {
                                 $(this).removeClass('text-danger')
                                 }
                         }
                    });

                    var $student_score = $('input.first_ca, input.second_ca, input.exam');


                    $student_score.change(function(){

                     //  alert($(this).val());
                      $update_score = $(this);
                      $form = $(this).closest('tr').children('form');
                      $form_url = $form.attr('action');

                       $.ajax({
                             type: "POST",
                             url: $form_url,
                             data: $form.serialize(),
                             beforeSend: function(){
                                    //alert('before');
                             },
                             success: function(data){

                                    $update_score.closest('tr').children('.total-score').text(data.total);
                                    $update_score.closest('tr').children('.score-grade').text(data.grade);
                                    $update_score.closest('tr').children('.score-position').text(data.position);

                                }
                       });

                    });


        $('.subjects-score-dataTables').DataTable({

                pageLength: 50,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'students'},
                    {extend: 'pdf', title: 'students'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');

                    }
                    }
                ]

            });

                  });

         </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>