
<?php $__env->startSection('title'); ?>
<?php echo e(__('s.dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title1'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title2'); ?>
overview
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('fail')): ?>
<div class="alert alert-danger" role="alert">
    <?php echo e(session('fail')); ?>

</div>
<?php endif; ?>
<div class="page-header">
    <h3 class="page-title"> <?php echo e(__('s.product')); ?> </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/stocks')); ?>"><?php echo e(__('s.stocks')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> <?php echo e(__('s.product_details')); ?></a></li>
        </ol>
    </nav>
</div>



<div class="product-container">
    <div class="product-image">
        <img src="<?php echo e(asset('uploads/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>">
    </div>
    <div class="product-details">
        <h1 class="product-name" id="productName"><?php echo e($product->name); ?></h1>
        <p class="product-price" id="productPrice"><span>Price:</span> <?php echo e($product->price); ?></p>
        <p class="product-sku" id="productSku"><span>SKU:</span> <?php echo e($product->sku); ?></p>
        <p class="product-barcode" id="productBarcode"><span>Barcode:</span> <?php echo e($product->barcode); ?></p>
        <p class="product-category" id="productCategory"><span>Category:</span> <?php echo e($product->category->name); ?></p>
        <p class="product-company" id="productCompany"><span>Company:</span><?php echo e($product->company->name); ?></p>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/dashboard/productShow.blade.php ENDPATH**/ ?>