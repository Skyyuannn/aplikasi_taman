<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('main/dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-0">
            <img src="<?= base_url('Logo_Poltek-transformed.png') ?>" alt="Logo Taman Elektronika" width="60" height="60" style="margin-right: 5px;">
        </div>
        <div class="sidebar-brand-text mx-3" style="line-height: 30px;">Taman Elektronika</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('main/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tanaman" aria-expanded="true" aria-controls="tanaman">
            <i class="fas fa-fw fa-archive"></i>
            <span>Tanaman</span>
        </a>
        <div id="tanaman" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= base_url('main/flowers/data-tanaman') ?>">Data Tanaman</a>
                <a class="collapse-item" href="<?= base_url('main/flowers/data-tanaman-filter') ?>">Filter Tanaman</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#masterData" aria-expanded="true" aria-controls="masterData">
            <i class="fas fa-fw fa-database"></i>
            <span>Tipe Tanaman</span>
        </a>
        <div id="masterData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= base_url('main/master-data/flowers-type/tipe-tanaman') ?>">Tipe</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->