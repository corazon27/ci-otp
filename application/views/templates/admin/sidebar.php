<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">TEST</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $title == 'Dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <li class="nav-item <?= $title == 'Product' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/product'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>CRUD AJAX + Pagination</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-md-none mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

</ul>
<!-- End of Sidebar -->