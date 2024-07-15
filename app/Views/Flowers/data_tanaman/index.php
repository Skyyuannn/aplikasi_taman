<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Tanaman</h1>
</div> -->

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5 class="m-0 font-weight-bold text-primary">Data Tanaman</h5>
        <div class="section-header-button">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="create()" data-toggle="modal" data-target="#addFLower"><i class="fas fa-plus"></i> Tambah</a>
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
                    <th>Tanggal</th> <!-- Tambahkan kolom tanggal -->
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
                    <input type="hidden" id="id">
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
            </div>
            <div class="form-group">
    <label>Tanggal :</label>
    <input type="date" class="form-control" name="created_date" id="created_date">
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary .btnSubmit">Insert</button>
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
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipe Tanaman</label>
                    <select class="form-control" name="type">
                        <option value="">Pilih Semua</option>
                        <?php foreach ($flowerType as $val) { ?>
                            <option value="<?= $val['id'] ?>"><?= $val['type'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save-modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#table-data-tanaman').DataTable({
            ajax: "<?php echo site_url('main/flowers/fetch-data'); ?>",
            responsive: true,
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'created_date',
                    name: 'created_date'
                },
                {
                    data: 'action',
                    name: 'action'
                },
                
            ],
            columnDefs: [{
                targets: [0],
                orderable: false
            }, {
                className: "td-text-center editable-cost",
                targets: 2
            }, ],
            language: {
                emptyTable: 'Data tidak ditemukan!',
                searchPlaceholder: "Cari...",
            }


        })
        $('#add-flower-form').submit(function(e) {
            e.preventDefault();
            if (method != 'edit') {
                submitRequest($('#add-flower-form'), '#table-data-tanaman')
                clearField()
                $('#addFLower').modal('hide')
            } else {
                let id = $('#id').val()
                $.ajax({
                    url: '<?= base_url('main/flowers/update/') ?>' + id,
                    type: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.btnSubmit').removeAttr('disabled')
                        if (response.status === 'success') {
                            successAlert(response.msg)
                                .then(() => {
                                    console.log(response);
                                    $('#table-data-tanaman').DataTable().ajax.reload();
                                    $('#addFLower').modal('hide')
                                })
                        } else {
                            let errorMessage = response.error
                            errorAlert(errorMessage, true)
                        }
                    },
                    error: function(err) {
                        $('.btnSubmit').removeAttr('disabled')
                    }
                })
            }
        })

    });

    function create() {
        method = "create"
        clearField()
        $('#addFLowerLabel').html("Insert Tanaman");
        $('#gambar').hide();
        $('#imageInfo').html('')
    }

    function edit(id) {
        method = "edit";
        $('#gambar').show();
        $.ajax({
            type: "get",
            url: "<?php echo site_url('main/flowers/edit/'); ?>" + id,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                clearField();
                method = "edit";
                $('#id').val(id)
                $('#addFLowerLabel').html("Edit Tanaman");
                $('#addFLower').modal('show');
                $('#name').val(res.data.name);
                $('#qty').val(res.data.qty);
                $('#type').val(res.data.type);
                $('#gambar').attr('src', '<?= base_url() ?>/uploads/' + (res.data.image != null ? `${res.data.image}` : 'no-image.jpg'));
                $('#imageInfo').html('* Kosongkan jika tidak merubah gambar')
            }
        });
    }

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

    function clearField() {
        $('#name').val('')
        $('#qty').val('')
        $('#image').val('')
    }
</script>
<?= $this->endSection() ?>