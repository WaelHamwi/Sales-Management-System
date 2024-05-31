<?php $__env->startSection('title'); ?>
<?php echo e(__('s.branches')); ?>

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
    <h3 class="page-title"> <?php echo e(__('s.branches')); ?> </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('s.branches')); ?></li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href=<?php echo e(route('branches.create')); ?> type="button" class="add-button btn btn-primary "><?php echo e(__('s.add_branch')); ?></a>

          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="<?php echo e(route('branches.json')); ?>" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="name" ><?php echo e(__('s.branch_name')); ?></th>
              <th data-sortable="true" data-field="company_name"><?php echo e(__('s.company_name')); ?></th>
              <th data-sortable="true" data-field="image" data-formatter="imageFormatter"><?php echo e(__('s.branch_image')); ?></th>
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
    var translations1= {'Are you sure you want to delete this branch?': '<?php echo e(__("s.Are you sure you want to delete this branch?")); ?>'}
    var translations = {
        'Confirmation': '<?php echo e(__("s.Confirmation")); ?>',
        'Are you sure you want to delete this branch?': '<?php echo e(__("s.Are you sure you want to delete this branch?")); ?>',
        'Yes': '<?php echo e(__("s.Yes")); ?>',
        'No': '<?php echo e(__("s.No")); ?>',
        'deleting branch done:': '<?php echo e(__("s.deleting branch done:")); ?>',
        'Deletion canceled': '<?php echo e(__("s.Deletion canceled")); ?>'
    };


   function actionFormatter(value, row, index) {
       var editUrl = '<?php echo e(route('branches.edit', ['id' => ':id'])); ?>';
       var deleteUrl = '<?php echo e(route('branches.destroy', ['id' => ':id'])); ?>';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-branch-id="' + row.id + '" onclick="destroy(\'branch\', ' + row.id + ')">' +
     '<i class="fas fa-trash-alt text-danger"></i>' +
 '</a>'

       ].join('');
   }
   function imageFormatter(value, row) {
       if (!value) {
           // If value is empty or null, use the default placeholder image
           var imageUrl = "<?php echo e(asset('images/placeholder.png')); ?>";
       } else {
           var imageUrl = "<?php echo e(asset('uploads/')); ?>" + '/' + value;
       }
       return '<img src="' + imageUrl + '" width="100" alt="branch Image">';
   }

   // Define translations




</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/branches/index.blade.php ENDPATH**/ ?>