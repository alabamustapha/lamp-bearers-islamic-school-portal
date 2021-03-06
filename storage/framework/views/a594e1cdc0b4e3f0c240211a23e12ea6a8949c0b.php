<?php $__env->startSection('title', 'Students'); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/plugins/dataTables/datatables.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Current Active School Students</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('admin')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="#">All students currently in school</a>
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
                    <h5>Searchable list of students</h5>
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
                                        <table class="table table-striped table-bordered table-hover students-dataTables" >
                                        <thead>
                                        <tr>
                                            <th>Admin Number</th>
                                            <th>Name</th>
                                            <th>Sex</th>
                                            <th>Class</th>
                                            <th>House</th>
                                            <th>Parent</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                        <tr class="">
                                            <td>
                                                <?php echo e($student->admin_number); ?>

                                            </td>
                                            <td>
                                                <a class="link-info" href="<?php echo e(url('admin/students/' . $student->id)); ?>" target="_blank" title="<?php echo e("View" . ' ' . $student->name . ' details'); ?>"><?php echo e($student->name); ?></a>
                                            </td>
                                            <td>
                                                <?php echo e($student->sex); ?>

                                            </td>
                                            <td>
                                                <?php if(isset($student->classroom) && !is_null($student->classroom)): ?>
                                                <a class="link-info" href="<?php echo e(url('admin/classrooms/' . $student->classroom->id)); ?>" target="_blank" title="<?php echo e("View" . ' ' . $student->classroom->name . ' classroom'); ?>"><?php echo e($student->classroom->name); ?></a>
                                                <?php else: ?>
                                                <?php echo e($student->status); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="link-info" href="<?php echo e(url('admin/houses/' . $student->house->id)); ?>" target="_blank" title="<?php echo e("View" . ' ' . $student->house->name . ' sport house details'); ?>"><?php echo e($student->house->name); ?></a>
                                            </td>
                                            <td>
                                                <?php if($student->guardian): ?>
                                                    <a class="link-info" href="<?php echo e(url('admin/guardians/' . $student->guardian->id)); ?>" target="_blank" title="<?php echo e("View" . ' ' . $student->name . ' guardian details'); ?>"><?php echo e(isset($student->guardian->name) ? $student->guardian->name : 'N/A'); ?></a>
                                                <?php endif; ?>
                                            </td>
                                            
                                                
                                                      
                                                      
                                                
                                            

                                        </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <tr>
                                                <th>Admin Number</th>
                                                <th>Name</th>
                                                <th>Sex</th>
                                                <th>Class</th>
                                                <th>House</th>
                                                <th>Parent</th>
                                                
                                            </tr>
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


<?php $__env->startSection('scripts'); ?>
<script src=" <?php echo e(asset('js/plugins/dataTables/datatables.min.js')); ?>"></script>

<script>
 $(document).ready(function(){


            $('.students-dataTables').DataTable({

                pageLength: 25,
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

})


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>