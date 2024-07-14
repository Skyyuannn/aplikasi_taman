<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Taman Elektronika - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->

    <link href="<?= base_url() ?>/template/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/template/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- <link href="<?= base_url() ?>template/vendor/datatables/responsive.bootstrap4.min.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>/template/vendor/sweet-alert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?= $this->include('layout/sidebar') ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session('name') ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url() ?>/template/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('main/profile/setting') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin Ingin Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Logout Dibawah Jika Kamu Ingin Keluar.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('main/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>template/vendor/datatables/responsive.bootstrap4.min.js"></script> -->
    <!-- <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"> -->
    <script src="<?= base_url() ?>template/vendor/sweet-alert2/dist/sweetalert2.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/template/js/sb-admin-2.min.js"></script>
    <script src="<?= base_url() ?>/template/js/custom.js"></script>

    <script>
        let csrfToken = '<?php echo csrf_hash() ?>'

        function successAlert(text, isHtml = false) {
            let options = {
                title: 'Success!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            }

            if (isHtml) {
                options.html = text
            } else {
                options.text = text
            }

            return Swal.fire(options)
        }

        function errorAlert(text, isHtml = false) {
            let options = {
                title: 'Error!',
                icon: 'error',
                confirmButtonText: 'Ok'
            }
            if (isHtml) {
                options.html = text
            } else {
                options.text = text
            }
            return Swal.fire(options)
        }

        function submitRequest(element, tableId = null) {
            $('.btnSubmit').attr('disabled', true)
            $.ajax({
                url: element.attr('action'),
                type: element.attr('method'),
                data: new FormData(element[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.btnSubmit').removeAttr('disabled')
                    if (response.status === 'success') {
                        successAlert(response.msg)
                            .then(() => {
                                console.log(element);
                                $(tableId).DataTable().ajax.reload();
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
    </script>

    <?= $this->renderSection('script') ?>

</body>

</html>