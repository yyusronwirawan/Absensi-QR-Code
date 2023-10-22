<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login ! User</title>
    <!-- Favicon icon -->
    <link rel="icon" type="<?= base_url('assets/'); ?>image/png" sizes="16x16" href="<?= base_url('assets/'); ?>./images/favicon.png">
    <link href="<?= base_url('assets/'); ?>./css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <?= $this->session->flashdata('message'); ?>
                                    <h4 class="text-center mb-4 text-white">Login staff</h4>
                                    <form class="user" method="POST" action=" <?php echo base_url('Auth/index'); ?>">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="text" name="email" class="form-control" value=" <?= set_value('email'); ?>" required>
                                            <?= form_error('email', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input type="Password" name="password1" class="form-control" required>
                                            <?= form_error('password1', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <a class="text-white" href="#">Forgot Password?</a>
                                                <a class="text-white" href="<?= base_url('auth/verif_email'); ?>">Verifikasi Email</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p class="text-white">Tidak Punya Akun ? Daftar <a class="text-white" href="<?= base_url('Auth/Regisration'); ?>">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url('assets/'); ?>./vendor/global/global.min.js"></script>
    <script src="<?= base_url('assets/'); ?>./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url('assets/'); ?>./js/custom.min.js"></script>
    <script src="<?= base_url('assets/'); ?>./js/deznav-init.js"></script>

</body>

</html>