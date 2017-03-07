  <div class="row m-b-lg m-t-lg">
                <div class="col-md-5">

                    <div class="profile-image">
                        <img src="<?php echo e(has_image($guardian) ? asset('storage/' . $guardian->image) : asset('storage/images/' . strtolower($guardian->sex) . '.png')); ?>" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h3 class="no-margins">
                                    <?php echo e($guardian->name); ?>

                                </h3>
                                <h4><a href="mailto: <?php echo e(isset($guardian->email) ? $guardian->email : '#'); ?>"><?php echo e(isset($guardian->email) ? $guardian->email : 'no email'); ?></a></h4>
                                <h5><?php echo e($guardian->guardian_id); ?></h5>
                                <h4>Wards: <?php echo e($guardian->students->count()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                Sex <strong> <?php echo e($guardian->sex); ?> </strong>
                            </td>
                            <td>
                                Phone <strong><?php echo e($guardian->phone); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>State of origin</strong> <?php echo e($guardian->state->name); ?>, <?php echo e($guardian->lga->name); ?>

                            </td>
                            <td>
                                <strong>Occupation</strong> <?php echo e($guardian->occupation); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Address</strong> <?php echo e($guardian->address); ?>

                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>