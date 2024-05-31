<?php $__env->startSection('title'); ?>
<?php echo e(__('s.add_product')); ?>

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
      <h3 class="page-title"> <?php echo e(__('s.products')); ?> </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo e(url('/products')); ?>"><?php echo e(__('s.products')); ?></a></li>
          <li  class="breadcrumb-item active" aria-current="page"><a > <?php echo e(__('s.create_product')); ?></a></li>
        </ol>
      </nav>
    </div>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form  starts -->
                <form action="<?php echo e(route('products.store')); ?>" id="formDropzone" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
      <?php echo csrf_field(); ?>
      <div class="form-group">
          <label for="exampleInputName1"><?php echo e(__('s.product_name')); ?> <span>*</span></label>
          <input type="text" value="" autofocus name="product_name" class="form-control" id="exampleInputName1" placeholder="<?php echo e(__('s.product_name_placeholder')); ?>">
      </div>
      <div class="form-group">
          <label for="company_id"><?php echo e(__('s.select_company')); ?></label>
          <select name="company_id" class="form-control" id="company_id">
              <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
      </div>
      <div class="form-group">
          <label for="category_id"><?php echo e(__('s.select_category')); ?></label>
          <select name="category_id" class="form-control" id="category_id">
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
      </div>
      <div class="form-group">
          <label for="exampleInputName1"><?php echo e(__('s.product_price')); ?> <span>*</span></label>
          <input type="text" value="" autofocus name="product_price" class="form-control" id="productPrice" placeholder="<?php echo e(__('s.product_price_placeholder')); ?>">
      </div>
      <div class="form-group">
          <label for="exampleInputName1"><?php echo e(__('s.SKU')); ?> </label>
          <input type="text" value="" autofocus name="product_sku" class="form-control" id="productSKU" placeholder="<?php echo e(__('s.product_sku_placeholder')); ?>">
      </div>
      <div class="form-group">
          <label for="exampleInputName1"><?php echo e(__('s.Barcode')); ?> </label>
          <input type="text" value="" autofocus name="product_barcode" class="form-control" id="productBarcode" placeholder="<?php echo e(__('s.product_barcode_placeholder')); ?>">
      </div>
      <!--dropzone form start-->
      <div class="form-group dropzone" id="myDropzone" data-upload-route="<?php echo e(route('products.upload')); ?>">
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
      <button id="formSubmitProduct" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
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
         length_product_name: '<?php echo e(__("s.length_product_name")); ?>',
         length_product_price: '<?php echo e(__("s.length_product_price")); ?>',
         length_product_barcode: '<?php echo e(__("s.length_product_barcode")); ?>',
         length_product_SKU: '<?php echo e(__("s.length_product_SKU")); ?>',
         image_required: '<?php echo e(__("s.image_required")); ?>',
         invalid_product_price:'<?php echo e(__("s.invalid_product_price")); ?>',
     };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/products/create.blade.php ENDPATH**/ ?>