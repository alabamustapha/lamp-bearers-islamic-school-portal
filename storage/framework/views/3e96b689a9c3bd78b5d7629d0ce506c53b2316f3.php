<?php $__env->startSection('title', 'Add students'); ?>

<?php $__env->startSection('styles'); ?>
     <link href="<?php echo e(asset('css/plugins/datapicker/datepicker3.css')); ?>" rel="stylesheet">
     <link href="<?php echo e(asset('css/plugins/jasny/jasny-bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-heading'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Create Student record</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('admin')); ?>">Home</a>
                </li>
                <li class="active">
                    <a href="#">Add Student record</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
                <a title="Add new guradian info" href="<?php echo e(url('admin/guardians/create')); ?>" target="_blank" class="btn btn-primary m-t-md">
                    Add Guardian Details
                </a>
        </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-title">
                    <h5>Fill the form below to create a new student record</h5>
                </div>

                <div class="ibox-content">
                    <!-- staff registration form -->
                    <form method="POST" class="form" enctype="multipart/form-data" action="<?php echo e(url('admin/students')); ?>">
                             <?php echo e(csrf_field()); ?>


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
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Surname *</label>
                                                 <input placeholder="surname" class="form-control input-lg" type="text" name="surname" value="<?php echo e(old('surname')); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">First name *</label>
                                                <input placeholder="first name" class="form-control input-lg" type="text" name="first_name" value="<?php echo e(old('first_name')); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Middle name </label>
                                                <input placeholder="middle name" class="form-control input-lg" type="text" name="middle_name" value="<?php echo e(old('middle_name')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Sex *</label>
                                                <select class="form-control input-lg" name="sex" required="" value="<?php echo e(old('sex')); ?>">
                                                    <option></option>
                                                    <option value="Male" <?php echo e(old('sex') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="Female" <?php echo e(old('sex') == 'Female' ? 'selected' : ''); ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="font-normal control-label">DOB *</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="dob" class="form-control input-lg" name="dob" value="<?php echo e(old('dob')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Nationality *</label>
                                                <select class="form-control input-lg" name="country_id" id="country_id" required="">
                                                    <option></option>
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                        <option value="<?php echo e((int)$country->id); ?>" <?php echo e(old('country_id') == $country->id ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">State of Origin *</label>
                                                <select class="form-control input-lg" name="state_id" id="state" required="">
                                                    <option value="">--select--</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">LGA *</label>
                                                <select class="form-control input-lg" name="lga_id" id="lga" required="">
                                                    <option value="">--select--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-8">
                                            <img id="image_upload_preview" data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxkZWZzLz48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9IjcwIiBzdHlsZT0iZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQ7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MTQweDE0MDwvdGV4dD48L2c+PC9zdmc+" style="width: 100px; height: 100px;" data-src="holder.js/100x100" class="img-rounded" alt="100x100">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class=" col-md-offset-2 col-md-6">
                                            <div class="fileinput fileinput-new form-group m-t-sm m-b-xs" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">select photo</span><span class="fileinput-exists">Change</span><input type="file" name="image" class="form-control input-lg" id="inputFile" value="<?php echo e(old('image')); ?>"></span>
                                                <span class="fileinput-filename"></span>
                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <div class="input-group">
                                           <span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="tel" placeholder="phone" class="form-control input-lg" name="phone"  value="<?php echo e(old('phone')); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-at"></i></span><input type="email" placeholder="email" name="email" class="form-control input-lg" value="<?php echo e(old('email')); ?>">
                                          </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Address *</label>
                                        <div class="input-group">
                                           <span class="input-group-addon"><i class="fa fa-home"></i></span><input type="text" placeholder="address" class="form-control input-lg" name="address" required value="<?php echo e(old('address')); ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                           <div class="row">
                               <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="font-normal control-label">Admission number *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span><input type="text" class="form-control input-lg" name="admin_number" required="" value="<?php echo e(isset($admin_number) ? $admin_number : old('admin_number')); ?>">
                                            </div>
                                        </div>
                                    </div>

                                   <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Class *</label>
                                           <select class="form-control input-lg" name="classroom_id" required="">
                                           <option>--select--</option>
                                           <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                               <option value="<?php echo e($classroom->id); ?>" <?php echo e(old('classroom_id') == $classroom->id ? 'selected' : ''); ?>><?php echo e($classroom->level->name . ' ' . $classroom->name); ?></option>
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
                                               <option value="<?php echo e($house->id); ?>" <?php echo e(old('house_id') == $house->id ? 'selected' : ''); ?>><?php echo e($house->name); ?></option>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                           </select>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                    <div class="col-lg-2">
                                       <div class="form-group">
                                           <label class="control-label">Guardian phone</label>
                                           <input type="text" id="guardian_phone" class="form-control input-lg" name="guardian_phone" value="<?php echo e(old('guardian_phone')); ?>">
                                       </div>
                                   </div>
                                    <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Guardian </label>
                                           <select class="form-control input-lg" name="guardian_id" readonly="readonly">

                                           </select>
                                       </div>
                                   </div>
                                   <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-normal control-label">Date admitted *</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="date_admitted" class="form-control input-lg" name="date_admitted" value="<?php echo e(old('date_admitted')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-normal control-label">Religion </label>
                                        <select class="form-control input-lg" name="religion" required="required">
                                            <option value="">--select---</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                               </div>
                           <div class="row">
                               <div class="col-lg-12">
                                   <div class="form-group">
                                       <label class="control-label">Comment</label>
                                       <textarea class="form-control" name="comment" placeholder="note about students"><?php echo e(old('comment')); ?></textarea>
                                   </div>
                               </div>
                           </div>

                            <div class="hr-line-dashed"></div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit">Create record</button>
                                    </div>
                                </div>
                            </div>

                    </form>
                    <!-- end students registration form -->
                </div>

            </div>
         </div>
    </div>

</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
<!-- Data picker -->
<script src="<?php echo e(asset('js/plugins/datapicker/bootstrap-datepicker.js')); ?>"></script>

<script>
    $(document).ready(function(){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    guardian_phone = $('#guardian_phone');


                    guardian_phone.keyup(function(){

                       var phone = $(this).val();

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

                       var $country = $('#country_id');

                       var $country_id = $country.val();

                       if($country_id !== ""){
                        $.ajax({
                             type: "POST",
                             url: window.location.protocol + "//" + window.location.host + "/get_list_of_states/" + $country_id,
                             success: function(data){
                                var $state = $('#state');
                                $state.empty();
                                $('<option value="">--select-state--</option>').appendTo('#state');
                                for(var i = 0; i < data.length; i++){
                                  $('<option value="' + data[i].id + '">' + data[i].name + '</option>').appendTo('#state');
                                }
                             }
                           });
                       }

                       $country.change(function(){
                       //$('#country').val([]);
                       var $country_id = $(this).val();

                       $.ajax({
                             type: "POST",
                             url: window.location.protocol + "//" + window.location.host + "/get_list_of_states/" + $country_id,
                             success: function(data){
                                var $state = $('#state');
                                $state.empty();
                                $('<option value="">--select-state--</option>').appendTo('#state');
                                for(var i = 0; i < data.length; i++){
                                  $('<option value="' + data[i].id + '">' + data[i].name + '</option>').appendTo('#state');
                                }
                             }
                           });
                      });

                      var $state = $('#state');

                         $state.change(function(){
                         //$('#country').val([]);
                         var $state_id = $(this).val();

                         $.ajax({
                               type: "POST",
                               url: window.location.protocol + "//" + window.location.host + "/get_list_of_lgas/" + $state_id,
                               success: function(data){
                                  var $lga = $('#lga');
                                  $lga.empty();
                                  $('<option value="">--select-lga--</option>').appendTo('#lga');
                                  for(var i = 0; i < data.length; i++){
                                    $('<option value="' + data[i].id + '">' + data[i].name + '</option>').appendTo('#lga');
                                  }
                               }
                             });
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