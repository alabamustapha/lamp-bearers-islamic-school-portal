<?php $__env->startSection('title', 'Upcoming Payments'); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/plugins/dataTables/datatables.min.css')); ?>" rel="stylesheet">
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

<div class="row ">
    <div class="col-lg-12">

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Students with upcoming term payments</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover students-dataTables">
                    <thead>
                        <tr>
                            <th>Admin. Number</th>
                            <th>Name</th>
                            <th>Classroom</th>
                            <th>Amount</th>
                            <th>Guardian name</th>
                            <th>Guardian Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   <tbody>


                       <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                       <tr>
                           <td><?php echo e($student->admin_number); ?></td>
                           <td><?php echo e($student->name); ?></td>
                           <td><?php echo e($student->classroom->name); ?></td>
                           <?php if($term == 'first'): ?>
                           <td><?php echo e(number_format($student->classroom->first_term_charges)); ?></td>
                           <?php elseif($term == 'second'): ?>
                           <td><?php echo e(number_format($student->classroom->second_term_charges)); ?></td>
                           <?php elseif($term == 'third'): ?>
                           <td><?php echo e(number_format($student->classroom->third_term_charges)); ?></td>
                           <?php endif; ?>
                           <td><?php echo e($student->guardian->name); ?></td>
                           <td><?php echo e($student->guardian->phone); ?></td>
                           <td><button>Pay</button></td>
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
                    {extend: 'excel', title: 'Debtors'},
                    {extend: 'pdf', title: 'Debtors'},

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