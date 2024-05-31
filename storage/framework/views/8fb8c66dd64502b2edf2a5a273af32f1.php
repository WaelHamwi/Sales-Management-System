<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="<?php echo e(url('/')); ?>">
      <img src="<?php echo e(asset('assets/images/logo.svg')); ?>" alt="logo" />
    </a>
    <a class="navbar-brand brand-logo-mini" href="<?php echo e(url('/')); ?>">
      <img src="<?php echo e(asset('assets/images/logo-mini.svg')); ?>" alt="logo" />
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <!-- New Links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/"><?php echo e(__('s.sales_statistics')); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/stocks/details"><?php echo e(__('s.inventory_details')); ?></a>
      </li>
    </ul>
    <!-- End New Links -->

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <?php if($user->image): ?>
            <img src="<?php echo e(asset('uploads/' . $user->image)); ?>" alt="">
            <?php else: ?>
            <img src="<?php echo e(asset('images/placeholder.png')); ?>" alt="">
            <?php endif; ?>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"> <?php echo e($user->first_name); ?></p>
          </div>
        </a>

        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a href="<?php echo e(url('profile/edit')); ?>" class="dropdown-item" id="editProfileLink">
            <i class="mdi mdi-account me-2"></i> <?php echo e(__('s.edit_profile')); ?>

          </a>
          <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="dropdown-item">
              <i class="mdi mdi-power me-2"></i> <?php echo e(__('s.logout')); ?>

            </button>
          </form>
        </div>
      </li>
    </ul>



    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<!-- partial --><?php /**PATH C:\xampp\htdocs\semiramis\resources\views/layouts/main-header.blade.php ENDPATH**/ ?>