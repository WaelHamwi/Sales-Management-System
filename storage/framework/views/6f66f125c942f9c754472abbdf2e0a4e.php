<?php $__env->startSection('title'); ?>
<?php echo e(__('s.edit_category')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

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
      <h3 class="page-title"> <?php echo e(__('s.categories')); ?> </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo e(url('/categories')); ?>"><?php echo e(__('s.categories')); ?></a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > <?php echo e(__('s.edit_category')); ?></a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
              <form action="<?php echo e(route('categories.update', ['id' => $category->id])); ?>" class="forms-sample" method="POST"   enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label for="exampleInputName1"><?php echo e(__('s.category_name')); ?> <span>*</span></label>
                        <input type="text" value="<?php echo e($category->name); ?>" autofocus name="category_name"
                        class="form-control" id="exampleInputName1"
                        placeholder="<?php echo e(__('s.category_name_placeholder')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="company_id"><?php echo e(__('s.select_company')); ?></label>
                        <select name="company_id" class="form-control" id="company_id">
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!--dropzone form start-->
                    <div class="form-group dropzone" id="myDropzone" data-upload-route="<?php echo e(route('categories.upload')); ?>">
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
                                        <i class="fas fa-check checkmark-icon" ></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="imageInput2" name="image">
                        </div>
                    </div>
                    <!--dropzone form end-->
                    <div class="form-group">
            <?php if($category->image): ?>
            <img src="<?php echo e(asset('uploads/' . $category->image)); ?>" id="categoryImage" class="categoryImage" alt="category Image">
            <?php else: ?>
            <img src="<?php echo e(asset('uploads/defaultcategoryImage.jpeg')); ?>"  class="userImage"  alt="">
          <?php endif; ?>
        </div>
                    <button id="formSubmitCategory" type="submit"
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


    var translations = {
           fillCategoryName: '<?php echo e(__("s.fill_category_name")); ?>',
           categoryNameMax: '<?php echo e(__("s.category_name_max", ["max" => 35])); ?>',
           imageRequired: '<?php echo e(__("s.image_required")); ?>'
       };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>