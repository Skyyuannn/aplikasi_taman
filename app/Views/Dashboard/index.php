<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Tombol Panduan -->
<div class="col-xl-3 col-md-6 mb-4">
    <a href="<?= base_url('panduan\BUKU_PANDUAN_WEBSITE_TAMAN_ELEKTRONIKA.pdf') ?>" download="BUKU_PANDUAN_WEBSITE_TAMAN_ELEKTRONIKA.pdf" class="btn btn-primary">
        <i class="fas fa-file-pdf"></i> Panduan
    </a>
</div>


<!-- Content Row -->
<div class="row text-center">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="flowers\data-tanaman-filter" style="text-decoration: none; color: inherit;">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tanaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalFlowers['qty'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-leaf fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="master-data/flowers-type/tipe-tanaman" style="text-decoration: none; color: inherit;">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Tipe Tanaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($flowersType) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-envira fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>
<?= $this->endSection() ?>