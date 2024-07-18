<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Taman Elektronika - Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/template/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: #ffffff;
        }

        .card {
            border-radius: 1rem;
        }

        .btn-primary {
            background-color: #ff4b2b;
            border-color: #ff4b2b;
        }

        .btn-primary:hover {
            background-color: #ff416c;
            border-color: #ff416c;
        }
    </style>
</head>

<body class="bg-gradient-danger">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <img src="<?= base_url('Logo_Poltek-transformed.png') ?>" alt="Logo Taman Elektronika" width="80" height="80" class="mb-4">
                                <h1 class="h4 text-gray-900 mb-4"><strong>Website TamanKu</strong></h1>
                                <p class="mb-4">Aplikasi Taman Elektronika karya anak bangsa.</p>
                            </div>
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="alert-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <b>Error!</b>
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <form action="<?= base_url('auth/login-process') ?>" method="post" class="user">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" value="1" id="showPassword">
                                    <label class="form-check-label" for="showPassword">Show Password</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small text-black" href="<?= base_url('register') ?>">Create an Account!</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>/template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/template/js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            var passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>

</body>

</html>