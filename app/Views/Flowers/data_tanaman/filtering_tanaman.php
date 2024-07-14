<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Tanaman</h1>
</div> -->
<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5 class="m-0 font-weight-bold text-primary">Filter Tanaman</h5>
        <div>
            <!-- <button type="button" class="btn btn-sm btn-primary btn-pill mx-2" title="Filter" style="float: right" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-plus"></i> Tambah
            </button> -->
            <button type="button" class="btn btn-sm btn-info btn-pill" title="Filter" style="float: right" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-data-tanaman" style="width: 100%;">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Kuantitas</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <!-- <th>Aksi</th> -->
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalTitle">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('main/flowers/load-data') ?>" method="post" autocomplete="off">
    <div class="modal-body">
        <div class="form-group">
            <label for="category">Tipe Tanaman</label>
            <?= selectFlowerType('category') ?>
        </div>
     <div class="form-group">
            <label for="filter_year">Tahun</label>
            <input type="number" class="form-control" id="filter_year" name="filter_year" placeholder="Masukkan tahun">
        </div>
     </div>
    <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-save-modal">Simpan</button>
             </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
    let dataTanaman = $('#table-data-tanaman').DataTable({
        info: false,
        lengthChange: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('main/flowers/load-data') ?>',
            type: 'POST',
            data: function(d) {
                d._token = '<?= csrf_token() ?>'; // Tambahkan token CSRF
                d.category = $('#filterModal #category').val();
                d.filter_year = $('#filterModal #filter_year').val();
            },
            dataType: 'json',
            error: function(xhr, error, thrown) {
                console.log('Kesalahan Ajax:', error);
                console.log('Kesalahan yang dilempar:', thrown);
            }
        },
            columnDefs: [{
                targets: [0],
                orderable: false
            }],
            language: {
                emptyTable: 'Data tidak ditemukan!',
                searchPlaceholder: "Cari...",
            },columns: [
                { data: 'id' },      // Kolom 0: ID
                { data: 'name' },    // Kolom 1: Nama
                { data: 'type' },    // Kolom 2: Tipe
                { data: 'qty' },// Kolom 3: Kuantitas
                { data: 'image' },   // Kolom 4: Gambar
                { data: 'created_date' },  // Kolom 5: Tanggal
            ]
        })

        $('#filterModal').on('show.bs.modal', function() {
            $('#filterModal .btn-save-modal').click(function(e) {
                e.preventDefault();

                dataTanaman.ajax.reload()
                $('#filterModal').modal('hide')
            })
        })

    });



    function deleteData(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('main/flowers/delete/') ?>' + id,
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.deleteButton').removeAttr('disabled')
                        if (response.status === 'success') {
                            successAlert(response.msg)
                                .then(() => {
                                    $('#table-data-tanaman').DataTable().ajax.reload();
                                })
                        } else {
                            let errorMessage = response.error
                            errorAlert(errorMessage, true)
                        }
                    },
                    error: function(err) {
                        $('.deleteButton').removeAttr('disabled')
                    }
                })
            }
        });
    }
</script>
<?= $this->endSection() ?>