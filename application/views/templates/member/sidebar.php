<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex text-white align-items-center bg-primary justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Pengadaan Barang</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/dashboard'); ?>">
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

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user/dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
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
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->