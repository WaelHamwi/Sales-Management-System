<?php $__env->startSection('title'); ?>
<?php echo e(__('s.edit_stock')); ?>

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
    <h3 class="page-title"> <?php echo e(__('s.stocks')); ?> </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/stocks')); ?>"><?php echo e(__('s.stocks')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> <?php echo e(__('s.edit_stock')); ?></a></li>
        </ol>
    </nav>
</div>
<div class="col-12 grid-margin stretch-card edit-stock-page">
    <div class="card">
        <div class="card-body">
            <!-- Default Edit Form starts -->
            <form id="default-edit-form" action="<?php echo e(route('stocks.update', ['id' => $stock->id])); ?>" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="quantity"><?php echo e(__('s.quantity')); ?></label>
                    <input type="text" name="stock_quantity" class="form-control" id="quantity" value="<?php echo e($stock->quantity); ?>">
                </div>

                <button id="formSubmitStockEdit" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light"><?php echo e(__('s.cancel')); ?></a>
            </form>
            <!-- Default Edit Form ends -->

            <!-- Button to reveal advanced edit form -->
            <a id="toggleFormButton" class="btn btn-gradient-primary me-2 mt-3 reveal-advanced" onclick="toggleAdvancedForm()"><?php echo e(__('s.edit_more_details')); ?></a>

            <!-- more detials Edit Form starts (initially hidden) -->
            <form method="POST" id="stock_form" action="<?php echo e(route('stocks.updateAll', ['id' => $stock->id])); ?>" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px; display:none;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="product_id"><?php echo e(__('s.select_product')); ?></label>
                    <select name="product_id" class="form-control single-select" id="product_id">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($product->id); ?>" <?php echo e($stock->product_id == $product->id ? 'selected' : ''); ?>><?php echo e($product->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="branch_id"><?php echo e(__('s.select_branch')); ?></label>
                    <select name="branch_id" class="form-control" id="branch_id">
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>" <?php echo e($stock->branch_id == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group" id="quantity_fields">
                <input type="text" name="stock_quantity" class="form-control" id="quantity" value="<?php echo e($stock->quantity); ?>">
                </div>

                <button id="formSubmitStock" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light"><?php echo e(__('s.cancel')); ?></a>
            </form>
            <!-- more details Edit Form ends -->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var translations = {
        quantity_for: '<?php echo e(__("s.quantity_for")); ?>',
        fillQuantityNumber: '<?php echo e(__("s.fill_quantity_number")); ?>',
        invalidQuantityFormat: '<?php echo e(__("s.invalid_quantity_format")); ?>',
        selectProduct: '<?php echo e(__("s.select_product_please")); ?>',
        duplicateProduct: '<?php echo e(__("s.duplicate_product_found")); ?>',
        no_branches: '<?php echo e(__("s.no_branches")); ?>',
        editLessDetails: '<?php echo e(__("s.edit_less_details")); ?>',
        editMoreDetails: '<?php echo e(__("s.edit_more_details")); ?>'
        
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/stocks/edit.blade.php ENDPATH**/ ?>