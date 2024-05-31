<?php $__env->startSection('title'); ?>
<?php echo e(__('s.dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title1'); ?>
<?php echo e(__('s.dashboard')); ?>

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
    <div class="form-group dashboard-input input-lg dynamic filter">
        <div id="reportrange">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="<?php echo e(asset('assets/images/dashboard/circle.svg')); ?>" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3"> <?php echo e(__('s.sales')); ?> <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                </h4>
                <?php echo e(__('s.sum_of_sales')); ?>

                <h2 class="mb-5 countOfPriceSales"></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="<?php echo e(asset('assets/images/dashboard/circle.svg')); ?>" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3"> <?php echo e(__('s.orders')); ?> <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                </h4>
                <?php echo e(__('s.sum_of_orders')); ?>

                <h2 class="mb-5 countOfSuccessSales"></h2>

            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="<?php echo e(asset('assets/images/dashboard/circle.svg')); ?>" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3"><?php echo e(__('s.inventory_details')); ?> <i class="mdi mdi-information mdi-24px float-right"></i>
                </h4>
                <?php echo e(__('s.number_of_products_in_the_stock')); ?>

                <h2 class="mb-5 numOfProducts"></h2>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var translations = {
        'select_branch': '<?php echo e(__("s.select_branch")); ?>',
        'no_branches':'<?php echo e(__("s.no_branches")); ?>',
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>