
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
    <h3 class="page-title"> <?php echo e(__('s.inventory_details')); ?> </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/')); ?>"> <?php echo e(__('s.dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/stocks')); ?>"><?php echo e(__('s.stocks')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a> <?php echo e(__('s.inventory_details')); ?></a></li>
        </ol>
    </nav>
</div>

<div class="form-group row selector-container">
    <div class="form-group dashboard-input">
        <select name="company" id="company_id" class="form-control dashboard-input input-lg dynamic filter btn-gradient-primary  select-arrow" data-dependent="state">
            <option value=""><?php echo e(__('s.all_companies')); ?></option>
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="arrow-down"></div>
    </div>
    <div class="form-group dashboard-input">
        <select name="branch" id="branch_id" class="form-control  dashboard-input input-lg dynamic filter btn-gradient-primary" data-dependent="state">
            <option selected disabled value=""><?php echo e(__('s.select_branch')); ?></option>
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="arrow-down"></div>
    </div>
    <div class="dropdown-menu">
        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="dropdown-item btn-gradient-primary" href="#" id="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div role="separator" class="dropdown-divider"></div>
        <a class="dropdown-item btn-gradient-primary" href="#">Separated link</a>
    </div>
</div>


<div class="card-container">

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var translations = {
        'go_to_product': '<?php echo e(__("s.go_to_product")); ?>',
        'select_branch': '<?php echo e(__("s.select_branch")); ?>',
        'no_branches':'<?php echo e(__("s.no_branches")); ?>',
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/dashboard/inventoryDetails.blade.php ENDPATH**/ ?>