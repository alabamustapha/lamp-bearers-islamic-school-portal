<?php $__env->startSection('title', $student->name); ?>

<?php $__env->startSection('styles'); ?>
     <link href="<?php echo e(asset('css/plugins/datapicker/datepicker3.css')); ?>" rel="stylesheet">
     <link href="<?php echo e(asset('css/plugins/jasny/jasny-bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo e($student->name . ' ' . $student->admin_number); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('admin')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('admin/students/')); ?>">Students</a>
                </li>
                <li class="active">
                    <a href="<?php echo e(url('#')); ?>"><?php echo e($student->name); ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                Edit info
            </button>
             <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated bounceInRight">

                            <form method="POST" class="form" enctype="multipart/form-data" action="<?php echo e(url('admin/students/' . $student->id)); ?>">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                 <img id="image_upload_preview" data-holder-rendered="true" src="<?php echo e(has_image($student) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png')); ?>"  class="img-circle circle-border m-b-md" alt="student passport" width="100px">


                                 <h4 class="modal-title"><?php echo e($student->name); ?></h4>


                                <div class="fileinput fileinput-new form-group m-t-sm m-b-xs" data-provides="fileinput">
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select a new passport</span><span class="fileinput-exists">Change</span><input type="file" name="image" id="inputFile"></span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                </div>


                            </div>

                            <div class="modal-body">



                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('PUT')); ?>


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
                                        <div class="col-lg-6 col-md-6">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Surname *</label>

                                                 <input placeholder="surname" class="form-control input-lg" type="text" name="surname" value="<?php echo e(trim(explode(' ', $student->name)[0])); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">First name *</label>
                                                <input placeholder="first name" class="form-control input-lg" type="text" name="first_name" value="<?php echo e(trim(explode(' ', $student->name)[1])); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Middle name *</label>
                                                <input placeholder="middle name" class="form-control input-lg" type="text" name="middle_name" value="<?php echo e(isset(explode(' ', $student->name)[2]) ? trim(explode(' ', $student->name)[2]) : null); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Sex *</label>
                                                <select class="form-control input-lg" name="sex" required="">
                                                    <option></option>
                                                    <option value="Male" <?php echo e($student->sex == 'Male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="Female" <?php echo e($student->sex == 'Female' ? 'selected' : ''); ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="font-normal control-label">DOB *</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="dob" class="form-control input-lg" name="dob" value="<?php echo e($student->dob->format('m/d/Y')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Phone</label>
                                                <div class="input-group">
                                                   <span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="tel" placeholder="phone" class="form-control input-lg" name="phone"  value="<?php echo e($student->phone); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                           <div class="row">
                               <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-at"></i></span><input type="email" placeholder="email" name="email" class="form-control input-lg" value="<?php echo e($student->email); ?>">
                                          </div>
                                    </div>
                                </div>
                                   <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Class *</label>
                                           <select class="form-control input-lg" name="classroom_id" required="">
                                           <option>--select--</option>
                                           <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                               <option value="<?php echo e($classroom->id); ?>" <?php echo e($student->classroom_id == $classroom->id ? 'selected' : ''); ?>><?php echo e($classroom->name); ?></option>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                           </select>
                                       </div>
                                   </div>

                                   <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Sport house *</label>
                                           <select class="form-control input-lg" name="house_id" required="">
                                               <option>--select--</option>
                                               <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                               <option value="<?php echo e($house->id); ?>" <?php echo e($student->house_id == $house->id ? 'selected' : ''); ?>><?php echo e($house->name); ?></option>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                           </select>
                                       </div>
                                   </div>

                               </div>
                               <div class="row">
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                          <label class="control-label">Guardian phone</label>
                                          <input type="text" id="guardian_phone" class="form-control input-lg" name="guardian_phone" value="<?php echo e(isset($student->guardian->phone) ? $student->guardian->phone : old('guardian_phone')); ?>">
                                      </div>
                                  </div>
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                          <label class="control-label">Guardian </label>
                                          <select class="form-control input-lg" name="guardian_id" readonly="readonly">
                                                <?php if($student->guardian != null): ?>
                                                    <option value="<?php echo e($student->guardian->id); ?>"><?php echo e($student->guardian->name); ?></option>
                                                <?php endif; ?>
                                          </select>
                                      </div>
                                  </div>
                               </div>
                               <div class="row">
                                <div class="col-lg-6">
                                   <div class="form-group">
                                       <label class="control-label">Address *</label>
                                       <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-home"></i></span><input type="text" placeholder="address" class="form-control input-lg" name="address" required value="<?php echo e($student->address); ?>">
                                       </div>
                                   </div>
                               </div>
                                <div class="col-lg-6">
                                       <div class="form-group">
                                           <label class="control-label">Status *</label>
                                           <select class="form-control input-lg" name="status">
                                               <option value="">--select-</option>
                                               <option value="active" <?php echo e($student->status == 'active' ? 'selected' : ''); ?>>Active</option>
                                               <option value="active" <?php echo e($student->status == 'left' ? 'selected' : ''); ?>>Left</option>
                                               <option value="active" <?php echo e($student->status == 'graduated' ? 'selected' : ''); ?>>Graduated</option>
                                               <option value="active" <?php echo e($student->status == 'dismissed' ? 'selected' : ''); ?>>Dismissed</option>
                                               <option value="active" <?php echo e($student->status == 'deactivated' ? 'selected' : ''); ?>>Deactivated</option>
                                           </select>
                                       </div>
                                   </div>

                               </div>
                           <div class="row">
                               <div class="col-lg-12">
                                   <div class="form-group">
                                       <label class="control-label">Comment</label>
                                       <textarea class="form-control" name="comment" placeholder="note about students"><?php echo e($student->comment); ?></textarea>
                                   </div>
                               </div>
                           </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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

<?php if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed')): ?>

    
            
            
                 
                      

                      
                         
                             
                                 
                             
                         
                      
                  

            
        

    
        
        
                
                     
                     
                     
                         
                             
                         
                     
                     
                 
        
    

<?php endif; ?>

</div>



<?php echo $__env->make('layouts.partials.student.profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


 <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Academic history</h5>
                        </div>
                        <div class="ibox-content">


                                <table class="table" >
                                        <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Level</th>
                                           <th>action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <tr>
                                            <td><?php echo e($student->session_classroom($session->id)->name); ?></td>
                                            <td><?php echo e($student->session_classroom($session->id)->level->name); ?></td>
                                            <td class="text-left">

                                                <div class="btn-group">
                                                    
                                                    <a class="btn btn-primary" type="button" href="<?php echo e(url('admin/students/'. $student->id .'/results/session/'.$session->id.'/view')); ?>">View</a>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                    </tbody>
                                </table>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>School Fees Payment history</h5>
                        </div>
                        <div class="ibox-content">


                                <table class="table" >
                                        <thead>
                                        <tr>
                                            <th>Session</th>
                                            <th>Class</th>
                                            <th>First term</th>
                                            <th>Second term</th>
                                            <th>Third term</th>
                                           <th>action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class_session): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <tr>
                                            <td><?php echo e($class_session->name); ?></td>
                                            <td><?php echo e($student->session_classroom($class_session->id)->name); ?></td>
                                            <td><?php echo e(isset($session) && $class_session->id == $session->id ? $student->classroom->first_term_charges : 0); ?></td>
                                            <td><?php echo e(isset($session) && $class_session->id == $session->id ? $student->classroom->second_term_charges : 0); ?></td>
                                            <td><?php echo e(isset($session) && $class_session->id == $session->id ? $student->classroom->third_term_charges : 0); ?></td>
                                            <td class="text-left">
                                                <div class="btn-group">
                                                    
                                                    <a class="btn btn-primary" type="button" href="<?php echo e(url('admin/students/'. $student->id .'/results/session/'.$session->id.'/view')); ?>">View</a>
                                                    
                                                </div>
                                            </td>
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
    <script src="<?php echo e(asset('js/plugins/datapicker/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/chartJs/Chart.min.js')); ?>"></script>
    <script>


        $(document).ready(function(){

                           $.ajaxSetup({
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               }
                           });

                                    guardian_phone = $('#guardian_phone');

                                    guardian_phone.focusout(function(){

                                       var phone = $(this).val();

                                       if(phone.length == 0){
                                           $('#guardian_phone').parent().removeClass('has-success');
                                           $('#guardian_phone').parent().removeClass('has-error');
                                           $("select[name='guardian_id']").children().remove();
                                       }

                                       $.ajax({
                                             type: "POST",
                                             data: {"phone":phone},
                                             url: window.location.protocol + "//" + window.location.host + "/get_guardian_id/" + phone,
                                             success: function(data){

                                                if(parseInt(data) == 0){

                                                    $('#guardian_phone').parent().removeClass('has-success');
                                                    $('#guardian_phone').parent().addClass('has-error');
                                                    $("select[name='guardian_id']").children().remove();

                                                }else{
                                                    $('#guardian_phone').parent().removeClass('has-error');
                                                    $('#guardian_phone').parent().addClass('has-success');
                                                    $("select[name='guardian_id']").children().remove();
                                                    $("select[name='guardian_id']").append("<option value='" + data.id + "' selected='selected'>" + data.name + "</option>");
                                                }

                                             }
                                           });

                                    });

                                    guardian_phone.keyup(function(){

                                       var phone = $(this).val();

                                       if(phone.length == 0){
                                           $('#guardian_phone').parent().removeClass('has-success');
                                           $('#guardian_phone').parent().removeClass('has-error');
                                           $("select[name='guardian_id']").children().remove();
                                       }

                                       $.ajax({
                                             type: "POST",
                                             data: {"phone":phone},
                                             url: window.location.protocol + "//" + window.location.host + "/get_guardian_id/" + phone,
                                             success: function(data){

                                                if(parseInt(data) == 0){

                                                    $('#guardian_phone').parent().removeClass('has-success');
                                                    $('#guardian_phone').parent().addClass('has-error');
                                                    $("select[name='guardian_id']").children().remove();

                                                }else{
                                                    $('#guardian_phone').parent().removeClass('has-error');
                                                    $('#guardian_phone').parent().addClass('has-success');
                                                    $("select[name='guardian_id']").children().remove();
                                                    $("select[name='guardian_id']").append("<option value='" + data.id + "' selected='selected'>" + data.name + "</option>");
                                                }

                                             }
                                           });

                                    });

                $('#dob').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

                $('#date_admitted').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

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