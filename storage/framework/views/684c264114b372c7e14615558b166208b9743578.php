<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
       <?php if(Auth::user()): ?>
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="<?php echo e(asset( 'storage/' . Auth::user()->profile_image())); ?>" width="70px" height="70px"></span>

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold"><?php echo e(Auth::user()->username); ?></strong>
                            </span> <span class="text-muted text-xs block"><?php echo e(Auth::user()->roles()->first()->name); ?><b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="<?php echo e(url('/logout')); ?>">Logout</a></li>
                        <li><a href="<?php echo e(url('admin/profile')); ?>">Settings</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    rh+
                </div>
            </li>
            <?php if(Auth::user()->isAdmin()): ?>

                <li class="<?php echo e(isActiveRoute('admin_dashboard')); ?>">
                    <a href="<?php echo e(url('/admin')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('admin_students') or isActiveRoute('admin_guardians') or isActiveRoute('admin_teachers')); ?>">
                    <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Active Records</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="<?php echo e(isActiveRoute('admin_students')); ?>">
                            <a href="<?php echo e(url('/admin/students')); ?>"><i class="fa fa-users"></i>Students</a>
                        </li>
                        <li><a href="<?php echo e(url('/admin/teachers')); ?>"><i class="fa fa-users"></i>Staff</a></li>
                        <li><a href="<?php echo e(url('/admin/guardians')); ?>"><i class="fa fa-users"></i>Guardian</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-pencil-square-o"></i> <span class="nav-label">Registration</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo e(url('/admin/students/create')); ?>"><i class="fa fa-users"></i>Students</a></li>
                        <li><a href="<?php echo e(url('/admin/teachers/create')); ?>"><i class="fa fa-users"></i>Staff</a></li>
                        <li><a href="<?php echo e(url('/admin/guardians/create')); ?>"><i class="fa fa-users"></i>Guardian</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">Management</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo e(url('/admin/classrooms')); ?>"><i class="fa fa-th"></i>Classes</a></li>
                        <li><a href="<?php echo e(url('/admin/levels')); ?>"><i class="fa fa-level-up"></i>Levels</a></li>
                        <li><a href="<?php echo e(url('/admin/subjects')); ?>"><i class="fa fa-pencil"></i>Subjects</a></li>
                        <li><a href="<?php echo e(url('/admin/houses')); ?>"><i class="fa fa-futbol-o"></i>Sport Houses</a></li>
                        <li><a href="<?php echo e(url('admin/sessions')); ?>"><i class="fa fa-plus"></i>Sessions</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-file"></i> <span class="nav-label">Scores sheet</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <?php if( isset($session) && !is_null($session) ): ?>

                            <a href="<?php echo e(url('/admin/results?session_id=' . $session->id )); ?>">
                                <i class="fa fa-file"></i>Current Session
                            </a>

                            <?php else: ?>

                            <a href="<?php echo e(url('/admin/results?session_id=N/A')); ?>" aria-disabled>
                                <i class="fa fa-file"></i>Current Session
                            </a>
                            <?php endif; ?>

                        </li>
                        <li><a href="<?php echo e(url('/admin/results?session_id=All')); ?>"><i class="fa fa-files-o"></i>All Sessions</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo e(url('#')); ?>" disabled="disabled"><i class="fa fa-user"></i> <span class="nav-label">User Account</span></a>
                </li>

                 <li class="<?php echo e(isActiveRoute('admin_payment')); ?>">
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Finances</span><span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?php echo e(url('admin/payments/upcoming')); ?>"><i class="fa fa-money"></i> <span class="nav-label">Upcoming payments</span></a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('admin/payments/debts')); ?>"><i class="fa fa-money"></i> <span class="nav-label">Debts</span></a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('admin/payments/history')); ?>"><i class="fa fa-money"></i> <span class="nav-label">Payments History</span></a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo e(isActiveRoute('admin_notifications')); ?>">
                    <a href="<?php echo e(url('admin/notifications')); ?>"><i class="fa fa-bell"></i> <span class="nav-label">Notifications</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('admin_events')); ?>">
                    <a href="<?php echo e(url('admin/events')); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">Events &amp; calendar</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('admin_store')); ?>">
                    <a href="<?php echo e(url('admin/store')); ?>"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Shop</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('admin_enquiries')); ?>">
                    <a href="<?php echo e(url('admin/enquiries')); ?>"><i class="fa fa-wechat"></i> <span class="nav-label">Enquires &amp; Complaints</span></a>
                </li>


                <li>
                    <a href="#"><i class="fa fa-cloud"></i> <span class="nav-label">Backup</span></a>
                </li>
            <?php endif; ?>

            <?php if(Auth::user()->isTeacher()): ?>
                <li class="<?php echo e(isActiveRoute('teacher_dashboard')); ?>">
                    <a href="<?php echo e(url('/teacher')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>

                <li class="<?php echo e(isActiveRoute('teacher_levels')); ?>">
                    <a href="#"><i class="fa fa-level-up"></i> <span class="nav-label">Levels</span></a>
                </li>

                <li class="<?php echo e(isActiveRoute('teacher_classrooms')); ?>">
                    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Classrooms</span></a>
                    <ul class="nav nav-second-level collapse">
                         <?php if($teacher->classrooms->count() == 0): ?>
                          <li>
                             <a href="#"><span class="nav-label">No class yet</span></a>
                          </li>
                         <?php else: ?>
                         <?php $__currentLoopData = $teacher->classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                             <li>
                                <a href="<?php echo e(url('teacher/classrooms/' . $classroom->id)); ?>" target="_blank">
                                    <i class="fa fa-expand"></i> <?php echo e($classroom->name); ?>

                                </a>
                             </li>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                         <?php endif; ?>

                    </ul>
                </li>

                <li class="<?php echo e(isActiveRoute('teacher_subjects')); ?>">
                    <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Subjects</span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if($teacher->classroom_subjects->count() == 0): ?>
                          <li>
                             <a href="#"><span class="nav-label">No subject yet</span></a>
                          </li>
                         <?php else: ?>
                         <?php $__currentLoopData = $teacher->classroom_subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                             <li>
                                <a href="<?php echo e(url('teacher/classrooms/' . $subject->classroom_id . '/subjects/' . $subject->subject_id)); ?>" target="_blank">
                                    <i class="fa fa-file"></i> <?php echo e($subject->classroom->name . ' ' . $subject->subject->short_name); ?>

                                </a>
                             </li>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                         <?php endif; ?>
                    </ul>
                </li>

                <li class="<?php echo e(isActiveRoute('faq')); ?>">
                    <a href="#"><i class="fa fa-comment"></i> <span class="nav-label">FAQ</span></a>
                </li>
            <?php endif; ?>

            <?php if(Auth::user()->isStudent()): ?>

                <li class="<?php echo e(isActiveRoute('student_dashboard')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_academic_history')); ?>">
                    <a href="<?php echo e(url('/student/academic_history')); ?>"><i class="fa fa-book"></i> <span class="nav-label">Academic History</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_payment_history')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-money"></i> <span class="nav-label">Payment History</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_timetable')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-table"></i> <span class="nav-label">Timetable</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_notifications')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-bell"></i> <span class="nav-label">Notifications</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_events')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">Events &amp; calendar</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('student_events')); ?>">
                    <a href="<?php echo e(url('/student')); ?>"><i class="fa fa-wechat"></i> <span class="nav-label">Student Notice Board</span></a>
                </li>

            <?php endif; ?>

            <?php if(Auth::user()->isGuardian()): ?>

                <li class="<?php echo e(isActiveRoute('student_dashboard')); ?>">
                    <a href="<?php echo e(url('/guardian')); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_wards')); ?>">
                    <a href="<?php echo e(url('/guardian/wards')); ?>"><i class="fa fa-group"></i> <span class="nav-label">Wards</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_payment')); ?>">
                    <a href="<?php echo e(url('guardian/payments')); ?>"><i class="fa fa-money"></i> <span class="nav-label">Payments</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_notifications')); ?>">
                    <a href="<?php echo e(url('guardian/notifications')); ?>"><i class="fa fa-bell"></i> <span class="nav-label">Notifications</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_events')); ?>">
                    <a href="<?php echo e(url('guardian/events')); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">Events &amp; calendar</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_store')); ?>">
                    <a href="<?php echo e(url('guardian/store')); ?>"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Shop</span></a>
                </li>
                <li class="<?php echo e(isActiveRoute('guardian_enquiries')); ?>">
                    <a href="<?php echo e(url('guardian/enquiries')); ?>"><i class="fa fa-wechat"></i> <span class="nav-label">Enquires &amp; Complaints</span></a>
                </li>

            <?php endif; ?>



        </ul>
       <?php endif; ?>
    </div>
</nav>
