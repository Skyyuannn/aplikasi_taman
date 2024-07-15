<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5 class="m-0 font-weight-bold text-danger">Data Tanaman</h5>
        <div class="section-header-button">
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="create()" data-toggle="modal" data-target="#addFLower">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <button type="button" class="btn btn-danger btn-sm" title="Filter" onclick="openFilterModal()">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-data-tanaman">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Kuantitas</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addFLower" tabindex="-1" aria-labelledby="addFLowerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFLowerLabel">Tambah Data Tanaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('main/flowers/create') ?>" method="POST" id="add-flower-form">
                    <input type="hidden" id="id" name="id">
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label>Nama Tanaman :</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Kuantitas :</label>
                            <input type="number" class="form-control" id="qty" name="qty">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tipe Tanaman :</label>
                        <select class="form-control" name="type" id="type">
                            <option value="" selected disabled>-- Pilih Tipe --</option>
                            <?php foreach ($flowerType as $val) { ?>
                                <option value="<?= $val['id'] ?>"><?= $val['type'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-7">
                            <label>Gambar :</label>
                            <input type="file" class="form-control-file" id="image" accept="image/png, image/gif, image/jpeg, image/jpg" name="image">
                            <small class="text-danger" id="imageInfo"></small>
                        </div>
                        <div class="col-md-5">
                            <img src="" alt="" id="gambar" class="img-thumbnail" style="width:100px;height: 100px;object-fit: cover;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal :</label>
                        <input type="date" class="form-control" name="created_date" id="created_date">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSubmit">Insert</button>
            </div>
            </form>
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
            <form id="filter-form">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            },
            columns: [{
                    data: 'id'
                }, // Kolom 0: ID
                {
                    data: 'name'
                }, // Kolom 1: Nama
                {
                    data: 'type'
                }, // Kolom 2: Tipe
                {
                    data: 'qty'
                }, // Kolom 3: Kuantitas
                {
                    data: 'image'
                }, // Kolom 4: Gambar
                {
                    data: 'created_date'
                }, // Kolom 5: Tanggal
                {
                    data: 'action'
                }, // Kolom 6: Aksi
            ]
        });

        $('#filter-form').submit(function(e) {
            e.preventDefault();
            dataTanaman.ajax.reload();
            $('#filterModal').modal('hide');
        });

        $('#add-flower-form').submit(function(e) {
            e.preventDefault();
            $('.btnSubmit').attr('disabled', 'disabled');
            let formData = new FormData($(this)[0]);
            let url = $('#id').val() ? '<?= base_url('main/flowers/update/') ?>' + $('#id').val() : '<?= base_url('main/flowers/create') ?>';
            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.btnSubmit').removeAttr('disabled');
                    if (response.status === 'success') {
                        successAlert(response.msg)
                            .then(() => {
                                $('#table-data-tanaman').DataTable().ajax.reload();
                                $('#addFLower').modal('hide');
                                clearField();
                            });
                    } else {
                        let errorMessage = response.error;
                        errorAlert(errorMessage, true);
                    }
                },
                error: function(err) {
                    $('.btnSubmit').removeAttr('disabled');
                    errorAlert('Terjadi kesalahan', true);
                }
            });
        });

    });

    function create() {
        clearField();
        $('#addFLowerLabel').html("Insert Tanaman");
        $('#gambar').hide();
        $('#imageInfo').html('');
        $('#addFLower').modal('show');
    }

    function edit(id) {
        $('#gambar').show();
        $.ajax({
            type: "get",
            url: "<?= site_url('main/flowers/edit/') ?>" + id,
            dataType: "json",
            success: function(res) {
                $('#addFLowerLabel').html("Update Tanaman");
                $('#id').val(res.data.id);
                $('#name').val(res.data.name);
                $('#qty').val(res.data.qty);
                $('#type').val(res.data.type_id);
                $('#created_date').val(res.data.created_date);
                if (res.data.image) {
                    $('#image').val('');
                    $('#gambar').attr('src', '<?= base_url() ?>/uploads/flowers/' + res.data.image);
                    $('#imageInfo').html('');
                } else {
                    $('#imageInfo').html('Gambar tidak tersedia');
                }
                $('#addFLower').modal('show');
            }
        });
    }

    function hapus(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: "<?= site_url('main/flowers/delete/') ?>" + id,
                type: 'POST',
                data: {
                    _token: '<?= csrf_token() ?>'
                },
                success: function(response) {
                    successAlert(response.msg)
                        .then(() => {
                            $('#table-data-tanaman').DataTable().ajax.reload();
                        });
                },
                error: function(err) {
                    errorAlert('Terjadi kesalahan', true);
                }
            });
        }
    }

    function openFilterModal() {
        $('#filterModal').modal('show');
    }

    function clearField() {
        $('#addFLower form')[0].reset();
        $('#id').val('');
        $('#gambar').hide();
        $('#imageInfo').html('');
    }
</script>
<?= $this->endSection() ?>