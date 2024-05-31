<?php $__env->startSection('title'); ?>
    <?php echo e(__('s.create_stock')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- Include any additional CSS files here -->
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
        <h3 class="page-title"> <?php echo e(__('s.stocks')); ?> </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(url('/stocks')); ?>"><?php echo e(__('s.stocks')); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><a > <?php echo e(__('s.create_stock')); ?></a></li>
            </ol>
        </nav>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Form starts -->
                <form action="<?php echo e(route('stocks.store')); ?>" id="stock_form" class="forms-sample" method="POST" enctype="multipart/form-data" style="border:none; background:#FFFFFF; padding:0px;">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="product_id"><?php echo e(__('s.select_product')); ?></label>
                        <select name="product_id[]" class="form-control multiple-select" id="product_id" multiple>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div id="quantity_fields"></div>

                    <div class="form-group">
                        <label for="branch_id"><?php echo e(__('s.select_branch')); ?></label>
                        <select name="branch_id" class="form-control" id="branch_id">
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button id="formSubmitStock" type="submit" class="btn btn-gradient-primary me-2"><?php echo e(__('s.submit')); ?></button>
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
            fillQuantityNumber: '<?php echo e(__("s.fill_quantity_number")); ?>',
            invalidQuantityFormat: '<?php echo e(__("s.invalid_quantity_format")); ?>',
            selectProduct: '<?php echo e(__("s.select_product_please")); ?>',
            duplicateProduct: '<?php echo e(__("s.duplicate_product_found")); ?>',
            no_branches:'<?php echo e(__("s.no_branches")); ?>',
        };
      


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/stocks/create.blade.php ENDPATH**/ ?>