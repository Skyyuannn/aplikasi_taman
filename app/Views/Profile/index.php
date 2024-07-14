<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Tanaman</h1>
</div> -->
<div class="row">
    <div class="col-xl-6 col-md-8 col-sm-12 mx-auto">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Profile</h5>
            </div>
            <div class="card-body">
                <div class="">
                    <form action="" method="post" id="profile-update-form">
                        <input type="hidden" id="id" value="<?= $user['id'] ?>">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <label class="float-right text-primary"><a onclick="ChangePassword()" class="toggle">Change Password ?</a></label>
                            <input type="text" class="form-control" id="username" placeholder="" value="<?= $user['username'] ?>" disabled>
                        </div>
                        <div class="form-change-password">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="">
                                <small class="text-danger">* Kosongkan jika tidak ingin mengganti password</small>
                            </div>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" value="1" id="show-pw">
                                <label class="form-check-label" for="show-pw">Show Password</label>
                            </div>
                        </div>
                        <div class="form-input">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= $user['name'] ?>">
                            </div>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary btnUpdate">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        method = "profile";
        $('.form-change-password').hide()

        $('#profile-update-form').submit(function(e) {
            let id = $('#id').val()
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('main/profile/update/') ?>' + id,
                type: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btnUpdate').html('<i class="fas fa-spinner fa-pulse"></i>')
                },
                complete: function() {
                    $('.btnUpdate').html('Update')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        successAlert(response.msg)
                            .then(() => {
                                console.log(response);
                                $('#password').val('')
                            })
                    } else {
                        let errorMessage = response.error
                        errorAlert(errorMessage, true)
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    })

    function ChangePassword() {
        if ($('.toggle').html() != 'Back') {
            method = "password";
            $('.form-change-password').show()
            $('.form-input').hide()
            $('.toggle').html('Back')
            $('#confirmPassword').removeClass('is-invalid');
        } else {
            method = "profile";
            $('.form-change-password').hide()
            $('#password').val('')
            $('.form-input').show()
            $('.toggle').html('Change Password ?')
            $('#form-password').trigger('reset')
        }
    }

    $('#show-pw').on('change', function() {
        if ($('#password').attr('type') == "password") {
            $('#confirmPassword').attr('type', 'text');
            $('#password').attr('type', 'text');
        } else {
            $('#confirmPassword').attr('type', 'password');
            $('#password').attr('type', 'password');
        }
    })


    // $('#password, #confirmPassword').on('keyup', function() {
    //     if ($('#confirmPassword').val() != '' && $('#password') != '') {
    //         if ($('#password').val() == $('#confirmPassword').val()) {
    //             $('#confirmPassword').addClass('is-valid');
    //             $('#confirmPassword').removeClass('is-invalid');
    //         } else {
    //             $('#confirmPassword').addClass('is-invalid');
    //             $('.not-match').html('Password not match')
    //             $('#confirmPassword').removeClass('is-valid');
    //         }
    //     } else {
    //         $('#confirmPassword').removeClass('is-valid');
    //         $('#confirmPassword').removeClass('is-invalid');
    //     }
    // });
</script>
<?= $this->endSection() ?>