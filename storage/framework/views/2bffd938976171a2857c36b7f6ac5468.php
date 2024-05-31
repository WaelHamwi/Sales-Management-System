<?php $__env->startSection('title'); ?>
<?php echo e(__('s.orders')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- Check if there is an error message -->
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(__(session('error'))); ?>

    </div>
<?php endif; ?>
  <div class="page-header">
    <h3 class="page-title"> <?php echo e(__('s.orders')); ?> </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li  class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
        <li class="breadcrumb-item"><?php echo e(__('s.orders')); ?></li>

      </ol>
    </nav>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href=<?php echo e(route('orders.create')); ?> type="button" class="add-button btn btn-primary "><?php echo e(__('s.add_order')); ?></a>
          </p>
          <table id="table"   data-toggle="table"  data-pagination="true" data-search="true" data-url="<?php echo e(route('orders.json')); ?>" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th  data-sortable="true" data-field="date" ><?php echo e(__('s.order_date')); ?></th>
              <th  data-sortable="true" data-field="price" ><?php echo e(__('s.order_price')); ?></th>
              <th  data-sortable="true" data-field="currency_symbol" ><?php echo e(__('s.currency')); ?></th>
              <th data-sortable="true" data-field="branch_name"><?php echo e(__('s.branch_name')); ?></th>
              <th  data-sortable="true" data-field="status" ><?php echo e(__('s.order_status')); ?></th>
              <th data-formatter="actionFormatter"><?php echo e(__('s.action')); ?></th>
          </tr>
      </thead>

  </table>
  <!-- Modal -->
        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel"><?php echo e(__('s.order_details')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div id="orderDetails"></div>
                <table id="table" class="table-order-details" data-toggle="table"   class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th data-sortable="true" data-field="product_name"><?php echo e(__('s.product_name')); ?></th>
              <th data-sortable="true" data-field="quantity"><?php echo e(__('s.quantity')); ?></th>
              <th data-sortable="true" data-field="subtotal"><?php echo e(__('s.subtotal')); ?></th>
              <th  data-sortable="true" data-field="currency_symbol" ><?php echo e(__('s.currency')); ?></th>
          </tr>
      </thead>
  </table>

              </div>
            </div>
          </div>
        </div>
  <!-- Modal -->
        </div>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var translations1= {'Are you sure you want to delete this order?': '<?php echo e(__("s.Are you sure you want to delete this order?")); ?>'}
    var translations = {
        'Confirmation': '<?php echo e(__("s.Confirmation")); ?>',
        'Are you sure you want to delete this order?': '<?php echo e(__("s.Are you sure you want to delete this order?")); ?>',
        'Yes': '<?php echo e(__("s.Yes")); ?>',
        'No': '<?php echo e(__("s.No")); ?>',
        'deleting order done:': '<?php echo e(__("s.deleting_order_done:")); ?>',
        'Deletion canceled': '<?php echo e(__("s.Deletion canceled")); ?>',
        'ID':'<?php echo e(__("s.ID")); ?>',
        'product_name':'<?php echo e(__("s.product_name")); ?>',
        'product_id':'<?php echo e(__("s.product_id")); ?>',
        'subtotal':'<?php echo e(__("s.subtotal")); ?>',
        'product_price':'<?php echo e(__("s.product_price")); ?>',
        'total_price':'<?php echo e(__("s.total_price")); ?>',
        'payment_method':'<?php echo e(__("s.payment_method")); ?>',
        'order_date':'<?php echo e(__("s.order_date")); ?>',
    };

//************the delete function is in the notify-init.js***************//
   function actionFormatter(value, row, index) {
       var editUrl = '<?php echo e(route('orders.edit', ['id' => ':id'])); ?>';
       var deleteUrl = '<?php echo e(route('orders.destroy', ['id' => ':id'])); ?>';
       editUrl = editUrl.replace(':id', row.id);
       deleteUrl = deleteUrl.replace(':id', row.id);

       return [
           '<a href="' + editUrl + '" class="text-primary mr-3">',
           '<i class="fas fa-edit"></i>',
           '</a>',
             '<a href="javascript:void(0)" class="delete-button" data-order-id="' + row.id + '" onclick="destroy(\'order\', ' + row.id + ')">' +
               '<i class="fas fa-trash-alt text-danger"></i>' +
           '</a>',
           '<a id="view-order-' + row.id + '" class="text-primary mr-3 view-order-btn">',
           '<i class="fas fa-eye"></i>',
           '</a>'
       ].join('');
   }


   // Define translations




</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>