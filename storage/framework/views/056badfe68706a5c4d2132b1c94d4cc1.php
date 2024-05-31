<?php $__env->startSection('title'); ?>
<?php echo e(__('s.products')); ?>

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
    <h3 class="page-title"> <?php echo e(__('s.products')); ?> </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
            <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('s.products')); ?></li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href="<?php echo e(route('products.create')); ?>" type="button" class="add-button btn btn-primary"><?php echo e(__('s.add_product')); ?></a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="<?php echo e(route('products.json')); ?>" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="name" ><?php echo e(__('s.product_name')); ?></th>
              <th  data-sortable="true" data-field="price" ><?php echo e(__('s.product_price')); ?></th>
              <th data-sortable="true" data-field="currency_symbol"><?php echo e(__('s.currency')); ?></th>
              <th  data-sortable="true" data-field="sku" ><?php echo e(__('s.SKU')); ?></th>
              <th  data-sortable="true" data-field="barcode" ><?php echo e(__('s.Barcode')); ?></th>
              <th data-sortable="true" data-field="company_name"><?php echo e(__('s.company_name')); ?></th>
              <th data-sortable="true" data-field="category_name"><?php echo e(__('s.category_name')); ?></th>
              <th data-sortable="true" data-field="image" data-formatter="imageFormatter"><?php echo e(__('s.product_image')); ?></th>
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
    var translations1= {'Are you sure you want to delete this product?': '<?php echo e(__("s.Are you sure you want to delete this product?")); ?>'}
    var translations = {
        'Confirmation': '<?php echo e(__("s.Confirmation")); ?>',
        'Are you sure you want to delete this product?': '<?php echo e(__("s.Are you sure you want to delete this product?")); ?>',
        'Yes': '<?php echo e(__("s.Yes")); ?>',
        'No': '<?php echo e(__("s.No")); ?>',
        'deleting product done:': '<?php echo e(__("s.deleting product done:")); ?>',
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '<?php echo e(route('products.edit', ['id' => ':id'])); ?>';
       var deleteUrl = '<?php echo e(route('products.destroy', ['id' => ':id'])); ?>';

       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
           '<a href="javascript:void(0)" class="delete-button" data-product-id="' + row.id + '" onclick="destroy(\'product\', ' + row.id + ')">' +
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
       return '<img src="' + imageUrl + '" width="100" alt="product Image">';
   }

   // Define translations




</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/products/index.blade.php ENDPATH**/ ?>