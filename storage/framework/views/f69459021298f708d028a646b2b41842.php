<?php $__env->startSection('title'); ?>
<?php echo e(__('s.add_branch')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
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
    <div class="page-header">
      <h3 class="page-title"> <?php echo e(__('s.branches')); ?> </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo e(url('/branches')); ?>"><?php echo e(__('s.branches')); ?></a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > <?php echo e(__('s.create_branch')); ?></a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
                <form action="<?php echo e(route('branches.store')); ?>" id="formDropzone" class="forms-sample imageValidation" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
      <?php echo csrf_field(); ?>
      <div class="form-group">
      <input type="hidden" name="branch_id" id="branch_id_hidden" value="">
          <label for="exampleInputName1"><?php echo e(__('s.branch_name')); ?> <span>*</span></label>
          <input type="text" value="" autofocus name="branch_name" class="form-control" id="exampleInputName1" placeholder="<?php echo e(__('s.first_name_placeholder')); ?>">
      </div>
      <div class="form-group">
          <label for="company_id"><?php echo e(__('Select Company')); ?></label>
          <select name="company_id" class="form-control" id="company_id">
              <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
      </div>
      <!--dropzone form start-->
      <div class="form-group dropzone" id="myDropzone" data-upload-route="<?php echo e(route('branches.upload')); ?>">
          <label class="form-label text-muted opacity-75 fw-medium" for="formImage"><?php echo e(__('s.file_upload')); ?></label>
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
                              <path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
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
      <button id="formSubmitBranch" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
      <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light"><?php echo e(__('s.cancel')); ?></a>
  </form>

                <!-- Form  ends -->
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

    var branchTranslations = {
            fillBranchName: '<?php echo e(__("s.fill_branch_name")); ?>',
            branchNameMax: '<?php echo e(__("s.branch_name_max", ["max" => 35])); ?>',
            branchNameEnglishLetter: '<?php echo e(__("s.branch_name_english_letter")); ?>',
            imageRequired: '<?php echo e(__("s.image_required")); ?>',
            nonUniqueBranchName:'<?php echo e(__("s.fill_unique_branch_name")); ?>',
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/branches/create.blade.php ENDPATH**/ ?>