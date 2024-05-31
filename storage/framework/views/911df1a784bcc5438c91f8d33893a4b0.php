<!DOCTYPE html>
<html lang="<?php echo e(App::currentLocale() ?? 'en'); ?>">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
  <?php echo $__env->make('layouts.main-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="container-fluid page-body-wrapper">
    <?php echo $__env->make('layouts.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <?php if (! (Request::is('companies')||('companies/create'))): ?>
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <?php if(Request::is('/')): ?>
              <i class="mdi mdi-home"></i>
              <?php elseif(Request::is('profile/edit')): ?>
              <i class="mdi mdi-account"></i>
              <?php endif; ?>
              <?php endif; ?>
            </span> <?php echo $__env->yieldContent('title1'); ?>
          </h3>

        </div>

        <?php echo $__env->yieldContent('content'); ?>
      </div>
      <!-- content-wrapper ends -->
      <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <div id="loader" class="loader-overlay">
  </div>

  <div id="spinner"></div>

  <script type="text/javascript">
    var dropzoneTranslations = {
      'default_message': "<?php echo e(__('s.default_message')); ?>",
      'fallback_message': "<?php echo e(__('s.fallback_message')); ?>",
      'invalid_file_type': "<?php echo e(__('s.invalid_file_type')); ?>",
      'file_too_big': "<?php echo e(__('s.file_too_big', ['fileSize' => ':filesize', 'maxFilesize' => ':maxFilesize'])); ?>",
      'response_error': "<?php echo e(__('s.response_error', ['statusCode' => ':statusCode'])); ?>",
      'cancel_upload': "<?php echo e(__('s.cancel_upload')); ?>",
      'cancel_upload_confirmation': "<?php echo e(__('s.cancel_upload_confirmation')); ?>",
      'remove_file': "<?php echo e(__('s.remove_file')); ?>",
      'max_files_exceeded': "<?php echo e(__('s.max_files_exceeded', ['maxFiles' => ':maxFiles'])); ?>"
    };
    var currentLocale = "<?php echo e(App::currentLocale()); ?>";
    var globalPosition = currentLocale === 'ar' ? 'bottom left' : 'bottom right';
  </script>
  <!-- container-scroller -->
  <?php echo $__env->make('layouts.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/layouts/master.blade.php ENDPATH**/ ?>