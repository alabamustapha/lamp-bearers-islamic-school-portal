<?php $__env->startSection('title', 'Profile settings'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content">
     <div class="row">
         <div class="col-md-8 col-md-offset-2">
             <div class="panel panel-default">
                 <div class="panel-heading">Update password</div>
                 <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('admin/profile/reset_password')); ?>">
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

                         <div class="form-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">

                             <label for="name" class="col-md-4 control-label">Username</label>

                             <div class="col-md-6">
                                 <input id="name" type="email" class="form-control" name="username" value="<?php echo e(Auth::user()->username); ?>" required>

                                 <?php if($errors->has('username')): ?>
                                     <span class="help-block">
                                         <strong><?php echo e($errors->first('username')); ?></strong>
                                     </span>
                                 <?php endif; ?>
                             </div>
                         </div>


                         <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                             <label for="password" class="col-md-4 control-label">New password</label>

                             <div class="col-md-6">
                                 <input id="password" type="password" class="form-control" name="password" required>

                                 <?php if($errors->has('password')): ?>
                                     <span class="help-block">
                                         <strong><?php echo e($errors->first('password')); ?></strong>
                                     </span>
                                 <?php endif; ?>
                             </div>
                         </div>

                         <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                             <label for="password-confirm" class="col-md-4 control-label">Confirm new password</label>

                             <div class="col-md-6">
                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                 <?php if($errors->has('password_confirmation')): ?>
                                     <span class="help-block">
                                         <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                     </span>
                                 <?php endif; ?>
                             </div>
                         </div>

                         <div class="form-group">
                             <div class="col-md-6 col-md-offset-4">
                                 <button type="submit" class="btn btn-primary">
                                     Update security
                                 </button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>