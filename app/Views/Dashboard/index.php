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

<?php
// Mengelompokkan data berdasarkan tahun
$flowersByYear = [];
foreach ($flowers as $flower) {
    $year = date('Y', strtotime($flower['created_date']));
    if (!isset($flowersByYear[$year])) {
        $flowersByYear[$year] = [];
    }
    $flowersByYear[$year][] = $flower;
}

// Mengurutkan data berdasarkan tahun dari yang terlama ke terbaru
ksort($flowersByYear);

// Menyiapkan data untuk Chart.js
$years = array_keys($flowersByYear);
$quantities = array_map(function($flowers) {
    return array_reduce($flowers, function($carry, $flower) {
        return $carry + $flower['qty'];
    }, 0);
}, $flowersByYear);

?>


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
                                Total Jenis Tanaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($flowersType) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-envira fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>
<!-- Grafik Tanaman Berdasarkan Tahun -->
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Grafik Tanaman Berdasarkan Tahun</div>
                        <canvas id="flowersChart"></canvas>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// var_dump($years);die;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('flowersChart').getContext('2d');
    var flowersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($years) ?>,
            datasets: [{
                label: 'Jumlah Tanaman',
                data: <?= json_encode($quantities) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Flowers By Year -->
<div class="row">
    <?php foreach ($flowersByYear as $year => $flowers): ?>
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tanaman Tahun <?= $year ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($flowers) ?> Tanaman</div>
                            <ul>
                                <?php foreach ($flowers as $flower): ?>
                                    <li><?= $flower['name'] ?> (<?= $flower['qty'] ?>)</li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>