<?php $__env->startSection('title'); ?>
    <?php echo e(__('s.edit_profile')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title1'); ?>
    <?php echo e(__('s.edit_profile')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title2'); ?>
    <?php echo e(__('s.profile_overview')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('errors1')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('errors1')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
                <form action="<?php echo e(route('profile.update')); ?>" id="formDropzone" class="forms-sample" method="POST"
                    enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="exampleInputName1"><?php echo e(__('s.first_name')); ?> <span>*</span></label>
                        <input type="text" value="<?php echo e(auth()->user()->first_name); ?>" autofocus name="first_name"
                            class="form-control" id="exampleInputName1" placeholder="<?php echo e(__('s.first_name_placeholder')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1"><?php echo e(__('s.last_name')); ?> <span>*</span></label>
                        <input type="text" value="<?php echo e(auth()->user()->last_name); ?>" name="last_name" class="form-control"
                            id="exampleInputName2" placeholder="<?php echo e(__('s.last_name_placeholder')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3"><?php echo e(__('s.email_address')); ?> </label>
                        <input type="email" value="<?php echo e(auth()->user()->email); ?>" name="email" class="form-control"
                            id="exampleInputEmail3" placeholder="<?php echo e(__('s.email_placeholder')); ?>" disabled>
                    </div>
                    <label for="showFormCheckbox"> <?php echo e(__('s.change_password')); ?> </label>
                    <input type="checkbox" id="showFormCheckbox"><br><br>
                    <div class="form-group form-group-password">
                        <label for="exampleInputPassword4"><?php echo e(__('s.old_password')); ?> </label>
                        <input name="old_password" value="" type="password" class="form-control" id="InputPassword1"
                            placeholder="<?php echo e(__('s.old_password_placeholder')); ?>">
                    </div>
                    <div class="form-group form-group-password">
                        <label for="exampleInputPassword4"><?php echo e(__('s.new_password')); ?> </label>
                        <input name="new_password" value="" type="password" class="form-control" id="InputPassword2"
                            placeholder="<?php echo e(__('s.new_password_placeholder')); ?>">
                    </div>
                    <div class="form-group form-group-password">
                        <label for="exampleInputPassword4"><?php echo e(__('s.confirm_password')); ?> </label>
                        <input name="confirmation_password" value="" type="password" class="form-control"
                            id="InputPassword3" placeholder="<?php echo e(__('s.confirm_password_placeholder')); ?>">
                    </div>
                    <div class="form-group">
                        <?php if($user->image): ?>
                            <img src="<?php echo e(asset('uploads/' . auth()->user()->image)); ?>" id="userImage" class="userImage"
                                alt="User Image">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/placeholder.png')); ?>" class="userImage" alt="">
                        <?php endif; ?>
                    </div>
                    <!--dropzone form start-->
                    <div class="form-group dropzone" id="myDropzone" data-upload-route="<?php echo e(route('profile.upload')); ?>">
                        <label class="form-label text-muted opacity-75 fw-medium"
                            for="formImage"><?php echo e(__('s.file_upload')); ?></label>
                        <div class="dropzone-drag-area form-control" id="previews">
                            <div class="dz-message text-muted opacity-50" data-dz-message>
                                <span><?php echo e(__('s.drag_file_here')); ?></span>
                            </div>
                            <div class="d-none" id="dzPreviewContainer">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-photo">
                                        <img id="imageInput" class="dz-thumbnail" data-dz-thumbnail>
                                    </div>
                                    <button class="dz-delete border-0 p-0 " type="button" data-dz-remove>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times">
                                            <path fill="#FFFFFF"
                                                d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div class="dz-upload-container">
                                        <div class="dz-upload-progress"></div>
                                        <div class="progress-text"></div>
                                        <i class="fas fa-check checkmark-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="imageInput2" name="image">
                        </div>
                    </div>
                    <!--dropzone form end-->
                    <button id="formSubmitProfile" type="submit"
                        class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light"><?php echo e(__('s.cancel')); ?></a>
                </form>
                <!-- Form  ends -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        var currentLocale = "<?php echo e(App::currentLocale()); ?>";
        var globalPosition = currentLocale === 'ar' ? 'bottom left' : 'bottom right';
        // *******************User's input validation using notify.js**************************
        $(document).ready(function() {
            $('#formSubmitProfile').click(function(e) {
                $('#loader').addClass('activate');
                var fields = [
                    'exampleInputName1',
                    'exampleInputName2',
                    'InputPassword1',
                    'InputPassword2',
                    'InputPassword3'
                ];

                // Reset validation state by removing 'is-invalid' class
                fields.forEach(function(fieldId) {
                    document.getElementById(fieldId).classList.remove('is-invalid');
                });

                var preventSubmit = false;
                var showFormCheckbox = document.getElementById('showFormCheckbox').checked;
                var newPassword = document.getElementById('InputPassword2').value.trim();
                var confirmPassword = document.getElementById('InputPassword3').value.trim();
                var oldPassword = document.getElementById('InputPassword1').value.trim();

                if (oldPassword !== '') {
                    // Make an AJAX request to validate the old password
                    $.ajax({
                        url: "<?php echo e(route('profile.validate-password')); ?>",
                        type: 'POST',
                        data: {
                            old_password: oldPassword,
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            // Handle success response if needed
                            console.log(response);
                            $('#loader').removeClass('activate');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response if needed
                            console.error(error);
                            $('#loader').removeClass('activate');
                            // Display an error message to the user indicating that the old password is incorrect
                            document.getElementById('InputPassword1').classList.add(
                                'is-invalid');
                            $.notify('<?php echo e(__('s.password_failed')); ?>', {
                                globalPosition: globalPosition
                            });
                        }
                    });
                }

                for (var i = 0; i < fields.length; i++) {
                    var fieldValue = document.getElementById(fields[i]).value.trim();
                    var message = "";

                    switch (fields[i]) {
                        case 'exampleInputName1':
                        case 'exampleInputName2':
                            if (fieldValue.length === 0) {
                                message = (fields[i] === 'exampleInputName1') ?
                                    "<?php echo e(__('s.fill_first_name')); ?>" : "<?php echo e(__('s.fill_last_name')); ?>";
                            } else if (!/[a-zA-Z]/.test(fieldValue)) {
                                message = (fields[i] === 'exampleInputName1') ?
                                    "<?php echo e(__('s.first_name.string')); ?>" : "<?php echo e(__('s.last_name.string')); ?>";
                            } else if (fieldValue.length > 35) {
                                message = (fields[i] === 'exampleInputName1') ?
                                    "<?php echo e(__('s.first_name.max', ['max' => 35])); ?>" :
                                    "<?php echo e(__('s.last_name.max', ['max' => 35])); ?>";
                            }
                            break;
                        case 'InputPassword1':
                            if (showFormCheckbox) {
                                if (fieldValue.length === 0) {
                                    message = "<?php echo e(__('s.fill_old_password')); ?>";
                                } else if (fieldValue.length < 8) {
                                    message = "<?php echo e(__('s.old_password.min')); ?>";
                                }
                            }
                            break;
                        case 'InputPassword2':
                            if (showFormCheckbox) {
                                if (fieldValue.length === 0) {
                                    message = "<?php echo e(__('s.fill_new_password')); ?>";
                                } else if (fieldValue.length < 8) {
                                    message = "<?php echo e(__('s.new_password.min')); ?>";
                                } else if (fieldValue === oldPassword) {
                                    message = "<?php echo e(__('s.new_password.different')); ?>";
                                }
                            }
                            break;
                        case 'InputPassword3':
                            if (showFormCheckbox) {
                                if (fieldValue.length === 0) {
                                    message = "<?php echo e(__('s.fill_confirm_password')); ?>";
                                } else if (fieldValue !== newPassword) {
                                    message = "<?php echo e(__('s.confirmation_password.same')); ?>";
                                }
                            }
                            break;
                        default:
                            break;
                    }

                    if (message !== "") {
                        preventSubmit = true;
                        document.getElementById(fields[i]).classList.add('is-invalid');
                        document.getElementById(fields[i]).focus(); // Focus on the field
                        $.notify(message, {
                            globalPosition: globalPosition
                        });
                        // Break the loop if we found a validation message
                        break;
                    }
                }

                // Prevent form submission only if there are validation messages to display
                if (preventSubmit) {
                    e.preventDefault();
                    $('#loader').removeClass('activate');
                }

                fields.forEach(function(fieldId) {
                    document.getElementById(fieldId).addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                    });
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/profile/index.blade.php ENDPATH**/ ?>