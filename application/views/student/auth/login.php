<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/iofrm-theme4.css">
</head>

<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="<?= base_url() ?>assets/images/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="<?= base_url() ?>assets/images/graphic1.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="tulisanlogin">Hallo, Silahkan login</h3>
                        <p class="tulisankecil">Silahkan login sebagai siswa</p>
                        <div class="kotakalert">
                            <?php if ($this->session->flashdata('flash')) : ?>
                                <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible fade show" role="alert">
                                    <strong><?= $this->session->flashdata('flash')['alert'] ?> </strong> <?= $this->session->flashdata('flash')['message'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>.
                        </div>
                        <div class="gifloading"></div>
                        <div class="kotaklogin">

                            <div class="page-links">
                                <a href="login4.html" class="active">Login</a>
                            </div>
                            <form>
                                <input class="form-control nomorinduk" type="number" name="username" placeholder="Nomor Induk" required>
                                <span class="infonis"></span>
                                <input class="form-control password" type="password" name="password" placeholder="Password" required>
                                <span class="infopassword"></span>
                                <div class="form-button">
                                    <button id="submit" type="submit" class="ibtn buttonlogin">Login</button>
                                    <!-- <a href="forget4.html">Lupa password?</a> -->
                                    <a href="<?= base_url('student/auth/linked_account') ?>">NIS belum terkait akun?</a>
                                    <a href="<?= base_url('student/auth/verif_email') ?>">Aktivasi email ?</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/main.js"></script>
</body>

</html>
<script>
    $('.buttonlogin').click(function(e) {
        e.preventDefault();
        let nis = $('.nomorinduk').val();
        let password = $('.password').val();
        if (nis.length < 10) {
            $('.infonis').html('<small class="error-message">Nis harus 10 digit</small>');
        } else {
            $('.kotaklogin').hide();
            $('.tulisankecil').hide();
            $('.tulisanlogin').html('Memproses Login...')
            $('.gifloading').html('<img src="<?= base_url() ?>assets/img/loading.gif">');
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>ajax/login_proccess",
                data: {
                    nis: nis,
                    password: password
                },
                dataType: 'json',
                process: function() {},
                success: function(data) {
                    if (data.status == false) {
                        $('.kotaklogin').show();
                        $('.tulisankecil').show();
                        $('.tulisanlogin').html('Silahkan Login')
                        $('.gifloading').html('');
                        $('.kotakalert').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Gagal!</strong>${data.data}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>`);
                    } else if (data.status == true) {
                        window.location.href = data.data;
                    }
                },
                error: function() {
                    $('.kotaklogin').show();
                    $('.tulisankecil').show();
                    $('.tulisanlogin').html('Silahkan Login')
                    $('.gifloading').html('');
                    $('.kotakalert').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Gagal!</strong> Kesalahan system!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>`);
                }
            });
        }
    })
</script>