<?php $__env->startSection('title', $classroom->name); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($classroom->name); ?> Students</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('teacher')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('admin/classrooms/' . $classroom->id)); ?>"><?php echo e($classroom->name); ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                                Update classroom
                            </button>
                             <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">


                                            <form method="POST" class="form" enctype="multipart/form-data" action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/upload_classroom_comments_excel')); ?>">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                                 <h4 class="modal-title"><?php echo e($classroom->level->name . ' ' . $classroom->name); ?></h4>
                                                 <h3 class="modal-title">Comments and Psychomotor</h3>

                                            </div>

                                            <div class="modal-body">



                                                <?php echo e(csrf_field()); ?>

                                                 <input type="hidden" name="classroom_id" value="<?php echo e($classroom->id); ?>">
                                                 <input type="hidden" name="teacher_id" value="<?php echo e($teacher->id); ?>">
                                                 <input type="hidden" name="term" value="<?php echo e($session ? $session->term() : null); ?>">
                                                 <input type="hidden" name="session_id" value="<?php echo e($session ? $session->id : 0); ?>">


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
                                                            <label class="control-label" for="comments_psychomotor">Select file</label>
                                                            <input type="file" name="comments_physchomotor" id="comments_psychomotor" class="form-control" required>
                                                        </div>
                                                     </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="control-label">File Type </label>
                                                                <select class="form-control" name="type" required>
                                                                    <option></option>
                                                                    <option value="comments"  <?php echo e(old('type') == 'comments' ? 'selected' : ''); ?>>Comments</option>
                                                                    <option value="psychomotors" <?php echo e(old('type') == 'psychomotor' ? 'selected' : ''); ?>>Psychomotors</option>
                                                                    <option value="attendance" <?php echo e(old('type') == 'attendance' ? 'selected' : ''); ?>>Attendance</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Upload classroom</button>
                                            </div>

                                     </form>
                                     </div>
                                </div>
                            </div>
        </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="wrapper wrapper-content">
<?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $students->count() > 0): ?>
<div class="row m-b-md">
    <div class="col-lg-6">
          <?php if($classroom->level->rank == $highest_level): ?>

                <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/graduate')); ?>" method="post" id="graduate">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PUT')); ?>

                     <div class="input-group m-b"><span class="input-group-btn">

                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Add all students to graduate list</button></span>

                      </div>

                </form>

          <?php else: ?>

              <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/promote')); ?>" method="post" id="promote">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PUT')); ?>

                     <div class="input-group m-b"><span class="input-group-btn">
                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Promote all to</button></span>

                          <select class="form-control" name="promoted_to_classroom_id">
                             <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promoted_to_classroom): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                 <?php if($classroom->level->rank < $promoted_to_classroom->level->rank): ?>
                                     <option value="<?php echo e($promoted_to_classroom->id); ?>"><?php echo e($promoted_to_classroom->name); ?></option>
                                 <?php endif; ?>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                          </select>
                      </div>

                </form>

          <?php endif; ?>
        </div>

    <div class="col-lg-6">
        <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/repeat')); ?>" method="post" id="repeat">
        <?php echo e(csrf_field()); ?>

        <?php echo e(method_field('PUT')); ?>

                <div class="input-group m-b"><span class="input-group-btn">
                     <button  type="submit" class="btn btn-warning btn-block" id="repeat-all">Repeat to</button></span>
                     <input type="hidden" name="repeated_to_classroom_id" value="<?php echo e($classroom->id); ?>">
                 </div>
        </form>
    </div>
</div>


<?php endif; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students in <?php echo e($classroom->name); ?></h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                        <?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed')): ?>
                                        <th>Overall (%)</th>
                                        <th>Promote</th>
                                        <th>Repeat</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <tr class="gradeA">
                                        <td><?php echo e($student->admin_number); ?></td>
                                        <td><a class="" href="<?php echo e(url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id )); ?>" title="<?php echo e('View ' . $student->name . ' profile'); ?>"><?php echo e($student->name); ?></a></td>
                                        <td><?php echo e($student->sex); ?></td>
                                        <td><?php echo e($student->house->name); ?></td>
                                        <td><?php echo e(isset($student->guardian->name) ? $student->guardian->name : 'N/A'); ?></td>

                                        <?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed')): ?>
                                        <td></td>
                                        <td>
                                            <?php if($classroom->level->rank == $highest_level): ?>

                                                <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id  . '/students/'. $student->id .  '/graduate')); ?>" method="post" id="graduate">
                                                <?php echo e(csrf_field()); ?>

                                                <?php echo e(method_field('PUT')); ?>

                                                     <div class="input-group m-b"><span class="input-group-btn">

                                                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Add to graduate list</button></span>

                                                      </div>

                                                </form>

                                          <?php else: ?>
                                            <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/students/'. $student->id .  '/promote')); ?>" method="post" id="repeat">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('PUT')); ?>

                                                    <div class="input-group m-b"><span class="input-group-btn">
                                                         <button  type="submit" class="btn btn-primary btn-block" id="repeat-all">Promote to</button></span>
                                                         <select class="form-control" name="promoted_to_classroom_id">
                                                          <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promoted_to_classroom): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                              <?php if($classroom->level->rank < $promoted_to_classroom->level->rank): ?>
                                                                  <option value="<?php echo e($promoted_to_classroom->id); ?>"><?php echo e($promoted_to_classroom->name); ?></option>
                                                              <?php endif; ?>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                         </select>
                                                     </div>
                                            </form>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                             <form action="<?php echo e(url('teacher/classrooms/' . $classroom->id . '/students/'. $student->id .  '/repeat')); ?>" method="post" id="repeat">
                                                <?php echo e(csrf_field()); ?>

                                                <?php echo e(method_field('PUT')); ?>

                                                        <div class="input-group m-b"><span class="input-group-btn">
                                                             <button  type="submit" class="btn btn-warning btn-block" id="repeat-all">Repeat class</button></span>
                                                             <input type="hidden" name="repeated_to_classroom_id" value="<?php echo e($classroom->id); ?>">
                                                         </div>
                                                </form>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                        <?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed')): ?>
                                        <th>Overall (%)</th>
                                        <th>Promote</th>
                                        <th>Repeat</th>
                                        <?php endif; ?>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>

<?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $promoted_students->count() > 0 && $classroom->level->rank != 7): ?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be promoted to <?php echo e($classroom->name); ?></h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $promoted_students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <tr class="gradeA">
                                        <td><?php echo e($student->admin_number); ?></td>
                                        <td><a class="" href="<?php echo e(url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id )); ?>" title="<?php echo e('View ' . $student->name . ' profile'); ?>"><?php echo e($student->name); ?></a></td>
                                        <td><?php echo e($student->sex); ?></td>
                                        <td><?php echo e($student->house->name); ?></td>
                                        <td><?php echo e($student->guardian->name); ?></td>

                                    </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>


<?php endif; ?>


<?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $promoting_students->count() > 0): ?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be promoted</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $promoting_students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <tr class="gradeA">
                                        <td><?php echo e($student->admin_number); ?></td>
                                        <td><a class="" href="<?php echo e(url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id )); ?>" title="<?php echo e('View ' . $student->name . ' profile'); ?>"><?php echo e($student->name); ?></a></td>
                                        <td><?php echo e($student->sex); ?></td>
                                        <td><?php echo e(isset($student->house->name) ? $student->house->name : 'N/A'); ?></td>
                                        <td><?php echo e(isset($student->guardian->name) ? $student->guardian->name : 'N/A'); ?></td>

                                    </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>


<?php endif; ?>

<?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $repeating_students->count() > 0): ?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be repeated</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $repeating_students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <tr class="gradeA">
                                        <td><?php echo e($student->admin_number); ?></td>
                                        <td><a class="" href="<?php echo e(url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id )); ?>" title="<?php echo e('View ' . $student->name . ' profile'); ?>"><?php echo e($student->name); ?></a></td>
                                        <td><?php echo e($student->sex); ?></td>
                                        <td><?php echo e(isset($student->house->name) ? $student->house->name : 'N/A'); ?></td>
                                        <td><?php echo e(isset($student->guardian->name) ? $student->guardian->name : 'N/A'); ?></td>

                                    </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
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

            $('.dataTables-example').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

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

            /* Init DataTables */
            var oTable = $('#editable').DataTable();
            });


         </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>