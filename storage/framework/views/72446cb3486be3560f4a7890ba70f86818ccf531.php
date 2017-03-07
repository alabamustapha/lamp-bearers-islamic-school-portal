<?php $__env->startSection('title', $guardian->name); ?>

<?php $__env->startSection('styles'); ?>
     <link href="<?php echo e(asset('css/plugins/datapicker/datepicker3.css')); ?>" rel="stylesheet">
     <link href="<?php echo e(asset('css/plugins/jasny/jasny-bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($guardian->name . ' ' . $guardian->guardian_id); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('admin')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('admin/guardians/')); ?>">Guardians</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('#')); ?>"><?php echo e($guardian->name); ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                Edit info
            </button>

        </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layouts.partials.guardian.profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


 <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><?php echo e($guardian->name); ?> -  Active Wards</h5>
                                    </div>
                                    <div class="ibox-content">


                                            <table class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Reg. Number</th>
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>classroom</th>
                                                        <th>level</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                            <?php $__currentLoopData = $guardian->students->whereIn('status', ['active', 'promoting', 'repeating', 'promoted', 'repeated']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($student->admin_number); ?></td>
                                                        <td><?php echo e($student->name); ?></td>
                                                        <td><?php echo e($student->sex); ?></td>
                                                        <td><?php echo e(isset($student->classroom->name) ? $student->classroom->name : ""); ?></td>
                                                        <td><?php echo e(isset($student->classroom->level->name) ? $student->classroom->level->name : ""); ?></td>
                                                        <td><?php echo e($student->status); ?></td>
                                                    </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                </tbody>
                                            </table>

                                    </div>
                                </div>
                            </div>
                        </div>

            <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><?php echo e($guardian->name); ?> -  Graduated Wards</h5>
                                    </div>
                                    <div class="ibox-content">


                                            <table class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Reg. Number</th>
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                            <?php $__currentLoopData = $guardian->students->where('status', 'graduated'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($student->admin_number); ?></td>
                                                        <td><?php echo e($student->name); ?></td>
                                                        <td><?php echo e($student->sex); ?></td>
                                                        <td><?php echo e($student->status); ?></td>
                                                    </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                                </tbody>
                                            </table>

                                    </div>
                                </div>
                            </div>
                        </div>

</div>



<?php $__env->stopSection(); ?>





<?php $__env->startSection('scripts'); ?>
    <!-- ChartJS-->
    <script src="<?php echo e(asset('js/plugins/chartJs/Chart.min.js')); ?>"></script>
    <script>

        $(function () {

           function readURL(input) {
               if (input.files && input.files[0]) {
                   var reader = new FileReader();

                   reader.onload = function (e) {
                       $('#image_upload_preview').attr('src', e.target.result);
                   }

                   reader.readAsDataURL(input.files[0]);
               }
           }

           $("#inputFile").change(function () {
               readURL(this);
           });



        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>