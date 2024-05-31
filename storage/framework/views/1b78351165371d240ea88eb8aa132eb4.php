<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/')); ?>">
            <span class="menu-title "><?php echo e(__('s.dashboard')); ?></span>
            <i class="mdi mdi-home menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/companies')); ?>">
            <span class="menu-title"><?php echo e(__('s.companies')); ?></span>
            <i class="mdi mdi-domain menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/branches')); ?>">
            <span class="menu-title"><?php echo e(__('s.branches')); ?></span>
            <i class="mdi mdi-store menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/categories')); ?>">
            <span class="menu-title"><?php echo e(__('s.categories')); ?></span>
            <i class="mdi fa-list-alt menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/products')); ?>">
            <span class="menu-title"><?php echo e(__('s.products')); ?></span>
            <i class="mdi fa-shopping-basket menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/stocks')); ?>">
            <span class="menu-title"><?php echo e(__('s.stocks')); ?></span>
            <i class="mdi fa-warehouse menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(url('/orders')); ?>">
            <span class="menu-title"><?php echo e(__('s.orders')); ?></span>
            <i class="mdi fa-shopping-cart menu-icon"></i>
        </a>
    </li>



    <div class="btn-group" role="group" aria-label="Language Switcher">

  <a href="?lang=<?php echo e(__('s.opposite_language_code')); ?>" class="btn btn-primary col-2 ">
    <?php echo e(__('s.opposite_language')); ?>

  </a>
  </div>
  </ul>
</nav>
<!-- partial -->
<?php /**PATH C:\xampp\htdocs\semiramis\resources\views/layouts/main-sidebar.blade.php ENDPATH**/ ?>