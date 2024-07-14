<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<div class="card mb-3">
    <h1 class="h3 p-2 mb-0 text-gray-800"><strong>Tipe Tanaman</strong></h1>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Tipe Tanaman</h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('main/master-data/flowers-type/create') ?>" method="POST" id="add-flower-type">
            <div class="form-row">
                <div class="form-group col-md-9">
                    <!-- <label>Nama Tanaman :</label> -->
                    <input type="text" class="form-control" id="type" name="type" placeholder="Masukan Jenis Tanaman" required>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary .btnSubmit">Insert</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow my-3">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tipe Tanaman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table-tipe-tanaman">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editTypeFlower" tabindex="-1" aria-labelledby="editTypeFlowerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTypeFlowerLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="update-flower-type">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label>Tipe Tanaman :</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <!-- <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Kuantitas :</label>
                            <input type="number" class="form-control" id="qty" name="qty">
                        </div>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary .btnSubmit">Save</button>
            </div>
            </form>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#table-tipe-tanaman').DataTable({
            ajax: "<?php echo site_url('main/master-data/flowers-type/fetch-data'); ?>",
            responsive: true,
            lengthChange: false,
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            columnDefs: [{
                targets: [0],
                orderable: true
            }, {
                className: "td-text-center",
                targets: 2
            }],
            language: {
                emptyTable: 'Data tidak ditemukan!',
                searchPlaceholder: "Cari...",
            }
        })

        $('#add-flower-type').submit(function(e) {
            e.preventDefault();
            submitRequest($('#add-flower-type'), '#table-tipe-tanaman')
            clearField()
        })

        $('#update-flower-type').submit(function(e) {
            let id = $('#id').val()
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('main/master-data/flowers-type/update/') ?>' + id,
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
                                $('#table-tipe-tanaman').DataTable().ajax.reload();
                                $('#editTypeFlower').modal('hide')
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
        })
    });

    function edit(id) {
        method = "edit";
        $.ajax({
            type: "get",
            url: "<?php echo site_url('main/master-data/flowers-type/edit/'); ?>" + id,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                clearField();
                method = "edit";
                $('#id').val(id)
                $('#editTypeFlowerLabel').html("Edit Jenis Tanaman");
                $('#editTypeFlower').modal('show');
                $('#name').val(res.data.type);
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
                    url: '<?= base_url('main/master-data/flowers-type/delete/') ?>' + id,
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
                                    $('#table-tipe-tanaman').DataTable().ajax.reload();
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
        $('#type').val('')
        // $('#qty').val('')
        // $('#image').val('')
    }
</script>
<?= $this->endSection() ?>