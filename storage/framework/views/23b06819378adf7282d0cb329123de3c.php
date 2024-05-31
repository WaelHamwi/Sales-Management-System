<?php $__env->startSection('title'); ?>
<?php echo e(__('s.edit_order')); ?>

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
    <h3 class="page-title"><?php echo e(__('s.orders')); ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('s.dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/orders')); ?>"><?php echo e(__('s.orders')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a><?php echo e(__('s.edit_order')); ?></a></li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- Form starts -->
            <form action="<?php echo e(route('orders.update', $order->id)); ?>" id="formDropzone" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> 

                <div class="form-group">
                    <label for="exampleInputName1"><?php echo e(__('s.order_date')); ?> <span>*</span></label>
                    <input type="date" value="<?php echo e($order->order_date); ?>" name="order_date" class="form-control" id="order_date" placeholder="<?php echo e(__('s.order_date_placeholder')); ?>">
                </div>

                <div class="form-group">
                    <label for="company_id"><?php echo e(__('s.select_company')); ?></label>
                    <select name="company" class="form-control" id="company_id">
                        <option disabled value=""><?php echo e(__('s.select_company')); ?></option>
                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($company->id); ?>" <?php echo e($companyId == $company->id ? 'selected' : ''); ?>><?php echo e($company->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>


                <div id="branch_select_wrapper" class="form-group">
                    <label for="branch_id"><?php echo e(__('s.select_branch')); ?></label>
                    <select name="branch_id" class="form-control" id="branch_id">
                        <option disabled selected value=""><?php echo e(__('s.select_branch')); ?></option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" <?php echo e($order->branch_id == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group" id="status">
                    <label for="status"><?php echo e(__('s.order_status')); ?></label>
                    <select name="status" id="orderStatus" class="form-control" >
                        <option value="success" <?php echo e($order->status === 'success' ? 'selected' : ''); ?>>success</option>
                        <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>cancelled</option>
                    </select>
                </div>
                <div><p id='noStatus'></p></div>

                <div id="product_container">
                    <div class="form-group" id="hidden-select-product">
                        <label for="product_id"><?php echo e(__('s.select_product')); ?></label>
                        <select name="product_id[]" class="form-control" id="product_id" multiple>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" <?php echo e(in_array($product->id, $selectedProductIds) ? 'selected' : ''); ?>>
                                <?php echo e($product->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row selector-container">
                    <div id="product_price">
                        <?php $__currentLoopData = $productPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $productPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label for="productPrice_<?php echo e($productId); ?>"><?php echo e(__('s.product_price_for')); ?> <?php echo e($products->find($productId)->name); ?></label>
                            <input type="number" name="product_price[]" value="<?php echo e($productPrice); ?>" class="form-control product_price_input" id="product_price_<?php echo e($productId); ?>" data-product-id="<?php echo e($productId); ?>" min="1">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div id="quantity_fields">
                        <?php $__currentLoopData = $productQuantities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $productQuantity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label for="quantity_<?php echo e($productId); ?>"><?php echo e(__('s.quantity_for')); ?> <?php echo e($products->find($productId)->name); ?></label>
                            <input type="number" name="stock_quantity[]" value="<?php echo e($productQuantity); ?>" class="form-control quantity_input" id="quantity_<?php echo e($productId); ?>" data-product-id="<?php echo e($productId); ?>" min="1">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div id="product_total_price">
                        <?php $__currentLoopData = $productTotalPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $productTotalPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label for="productTotalPriceField_<?php echo e($productId); ?>"><?php echo e(__('s.product_total_price_for')); ?> <?php echo e($products->find($productId)->name); ?></label>
                            <input type="text" name="total_price[]" value="<?php echo e($productTotalPrice); ?>" class="form-control product_total_price" id="product_total_price_<?php echo e($productId); ?>" disabled>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="form-group">
                        <label for="productTotalOfTotalPriceField"><?php echo e(__('s.product_total_of_total_price_for')); ?></label>
                        <div id="product_total_of_total_selected_price">
                            <input type="hidden" name="total_of_total_price" id="total_of_total_price_value" value="<?php echo e($orderPrice); ?>">
                            <input type="text" value="<?php echo e($orderPrice); ?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group row selector-container">
                    <div id="product_price"></div>
                    <div id="quantity_fields"></div>
                    <div id="product_total_price"></div>
                    <div id="product_total_of_total_price">
                    </div>
                </div>

                <button id="formSubmitOrders" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light"><?php echo e(__('s.cancel')); ?></a>
            </form>
            <!-- Form ends -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<script>
    var translations = {
        quantity_for: '<?php echo e(__("s.quantity_for")); ?>',
        product_price_for: '<?php echo e(__("s.product_price_for")); ?>',
        product_total_price_for: '<?php echo e(__("s.product_total_price_for")); ?>',
        product_total_of_total_price_for: '<?php echo e(__("s.product_total_of_total_price_for")); ?>',
        fillorderDate: '<?php echo e(__("s.fill_order_date")); ?>',
        length_order_price: '<?php echo e(__("s.length_order_price")); ?>',
        length_order_branch: '<?php echo e(__("s.length_order_branch")); ?>',
        fillCompany: '<?php echo e(__("s.fill_company")); ?>',
        fillBranch: '<?php echo e(__("s.fill_branch_name")); ?>',
        selectProduct: '<?php echo e(__("s.select_product_please")); ?>',
        fillQuantity: '<?php echo e(__("s.fill_quantity_number")); ?>',
        invalidQuantityFormat: '<?php echo e(__("s.invalid_quantity_format")); ?>',
        invalidProductPrice: '<?php echo e(__("s.invalid_product_price")); ?>',
        subtotalExceededLimit: '<?php echo e(__("s.subtotal_length_exceeded")); ?>',
        select_branch: '<?php echo e(__("s.select_branch")); ?>',
        no_products: '<?php echo e(__("s.no_products")); ?>',
        no_branches: '<?php echo e(__("s.no_branches")); ?>',
        productNotEnoughStock: '<?php echo e(__("s.product_not_enough_stock")); ?>',
        final_total_price_for: '<?php echo e(__("s.final_total_price_for")); ?>',
        statusNotChangeable:'<?php echo e(__("s.status_not_changeable")); ?>',
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/orders/edit.blade.php ENDPATH**/ ?>