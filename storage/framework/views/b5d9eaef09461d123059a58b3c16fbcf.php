<?php $__env->startSection('title'); ?>
<?php echo e(__('s.companies')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(__(session('success'))); ?>

    </div>
<?php endif; ?>

<!-- Check if there is an error message -->
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(__(session('error'))); ?>

    </div>
<?php endif; ?>
  <div class="page-header">
    <h3 class="page-title"> <?php echo e(__('s.companies')); ?> </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('s.companies')); ?></li>
      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href=<?php echo e(route('companies.create')); ?> type="button" class="add-button btn btn-primary "><?php echo e(__('s.add_company')); ?></a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="<?php echo e(route('companies.json')); ?>" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="name" ><?php echo e(__('s.company_name')); ?></th>
              <th  data-sortable="true" data-field="currency" ><?php echo e(__('s.company_currency')); ?></th>
              <th data-sortable="true" data-field="image" data-formatter="imageFormatter"><?php echo e(__('s.company_image')); ?></th>
              <th data-formatter="actionFormatter"><?php echo e(__('s.action')); ?></th>
          </tr>
      </thead>
      <tbody>

</tbody>
  </table>





        </div>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var translations = {
        'Confirmation': '<?php echo e(__("s.Confirmation")); ?>',
        'Are you sure you want to delete this company?': '<?php echo e(__("s.Are you sure you want to delete this company?")); ?>',
        'Yes': '<?php echo e(__("s.Yes")); ?>',
        'No': '<?php echo e(__("s.No")); ?>',
        'deleting company done:': '<?php echo e(__("s.deleting company done:")); ?>',
        'Deletion canceled': '<?php echo e(__("s.Deletion canceled")); ?>'
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '<?php echo e(route('companies.edit', ['id' => ':id'])); ?>';
       var deleteUrl = '<?php echo e(route('companies.destroy', ['id' => ':id'])); ?>';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-company-id="' + row.id + '" onclick="destroy(\'company\', ' + row.id + ')">' +
                          '<i class="fas fa-trash-alt text-danger"></i>' +
                      '</a>'
       ].join('');
   }
   function imageFormatter(value, row) {
       if (!value) {
           var imageUrl = "<?php echo e(asset('images/placeholder.png')); ?>";
       } else {
           var imageUrl = "<?php echo e(asset('uploads/')); ?>" + '/' + value;
       }
       return '<img src="' + imageUrl + '" width="100" alt="Company Image">';
   }


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/companies/index.blade.php ENDPATH**/ ?>