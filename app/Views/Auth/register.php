<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/template/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/template/vendor/sweet-alert2/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="<?= base_url('auth/register-process') ?>" method="post" id="register-form" class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Fullname" autocomplete="off">
                                    <div class="invalid-feedback errName"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" autocomplete="off">
                                    <div class="invalid-feedback errUsername"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="firstPassword" name="password" placeholder="Password">
                                        <div class="invalid-feedback errPassword"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                                        <div class="invalid-feedback not-match"></div>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" value="1" id="showPassword">
                                        <label class="form-check-label" for="showPassword">Show Password</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block doRegister">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('login') ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/sweet-alert2/dist/sweetalert2.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>/template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/template/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#register-form').submit(function(e) {
                let name = $('#name').val()
                let username = $('#username').val()
                let password = $('#firstPassword').val()
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    // processData: false,
                    // contentType: false,
                    beforeSend: function() {
                        $('.doRegister').attr('disable', 'disabled')
                        $('.doRegister').html("<i class='fa fa-spin fa-spinner'></i>")
                    },
                    complete: function() {
                        $('.doRegister').removeAttr('disable')
                        $('.doRegister').html("Register Account")
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log(response);
                            Swal.fire({
                                icon: "success",
                                title: response.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            clearField()
                            $('.errName').html('')
                            $('#name').removeClass('is-invalid')
                            $('.errUsername').html('')
                            $('#username').removeClass('is-invalid')
                            $('.errPassword').html('')
                            $('#firstPassword').removeClass('is-invalid')
                            $('#confirmPassword').removeClass('is-valid');
                        } else {
                            error = response.msg
                            if (error.name) {
                                $('.errName').html(error.name)
                                $('#name').addClass('is-invalid')

                            } else {
                                $('.errName').html('')
                                $('#name').removeClass('is-invalid')
                            }
                            if (error.username) {
                                $('.errUsername').html(error.username)
                                $('#username').addClass('is-invalid')
                            } else {
                                $('.errUsername').html('')
                                $('#username').removeClass('is-invalid')
                            }
                            if (error.password) {
                                $('.errPassword').html(error.password)
                                $('#firstPassword').addClass('is-invalid')
                            } else {
                                $('.errPassword').html('')
                                $('#firstPassword').removeClass('is-invalid')
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })

                return false
            })
        })

        function clearField() {
            $('#name').val('')
            $('#username').val('')
            $('#firstPassword').val('')
            $('#confirmPassword').val('')
        }
        $('#showPassword').on('change', function() {
            if ($('#confirmPassword').attr('type') == "password" && $('#firstPassword').attr('type') == "password") {
                $('#confirmPassword').attr('type', 'text');
                $('#firstPassword').attr('type', 'text');
                $('#toggle-eye').removeClass('fa-eye-slash')
                $('#toggle-eye').addClass('fa-eye')
            } else {
                $('#confirmPassword').attr('type', 'password');
                $('#firstPassword').attr('type', 'password');
                $('#toggle-eye').removeClass('fa-eye')
                $('#toggle-eye').addClass('fa-eye-slash')
            }
        })
        $('#firstPassword, #confirmPassword').on('keyup change', function() {
            if ($('#confirmPassword').val() != '' && $('#firstPassword') != '') {
                if ($('#firstPassword').val() == $('#confirmPassword').val()) {
                    $('#confirmPassword').addClass('is-valid');
                    $('#confirmPassword').removeClass('is-invalid');
                    $('.doRegister').prop('disabled', false)
                } else {
                    $('#confirmPassword').addClass('is-invalid');
                    $('.not-match').html('Password not match')
                    $('#confirmPassword').removeClass('is-valid');
                    $('.doRegister').prop('disabled', true)
                }
            } else {
                $('#confirmPassword').removeClass('is-valid');
                $('#confirmPassword').removeClass('is-invalid');
                $('.doRegister').prop('disabled', true)
            }
        });
    </script>

</body>

</html>