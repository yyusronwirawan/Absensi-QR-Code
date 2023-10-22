<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-theme16.css">
</head>

<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="<?= base_url('assets/') ?>images/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="<?= base_url('assets/') ?>images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Pengaktifan akun</h3>
                        <p>Hai <?= $datasiswa['nama_siswa'] ?>, Silahkan buat email dan password untuk akun anda.</p>
                        <form>
                            <input class="form-control nis" type="hidden" name="nis" value="<?= $datasiswa['nis'] ?>" placeholder="E-mail Address" required>
                            <input class="form-control email" type="text" name="email" placeholder="E-mail Address" required>
                            <div class="infoemail"></div>
                            <input class="form-control password" type="password" name="password" placeholder="Password baru" required>
                            <a class="infopassword"></a>
                            <input class="form-control password2" type="password" name="password2" placeholder="Konfirmasi Password baru" required>
                            <div class="infopassword2"></div>
                            <div class="form-button full-width">
                                <button id="submit" name="password2" type="submit" class="ibtn btn-forget">Konfirmasi Password</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password link sent</h3>
                        <p>Please check your inbox iofrm@iofrmtemplate.io</p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span> <a href="#">We can help</a>.
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/popper.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/main.js"></script>
</body>

</html>

<script>
    function validateEmail(email) {
        let res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        return res.test(email);
    }
    $('#submit').click(function(e) {
        e.preventDefault();
        let email = $('.email').val();
        let password = $('.password').val();
        let password2 = $('.password2').val();
        let nis = $('.nis').val();
        if (validateEmail(email) == false) {
            $('.infoemail').html('<small class="error-message">Email tidak valid</small>');
        } else if (password.length < 6) {
            $('.infoemail').html('')
            $('.infopassword').html('<small class="error-message">Minimal 6 karakter</small>');
        } else if (password != password2) {
            $('.infopassword').html('')
            $('.infopassword2').html('<small class="error-message">Konfirmasi password tidak sesuai</small>');
        } else {
            $(this).html('Memproses Data....');
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>ajax/linked_success",
                data: {
                    nis: nis,
                    email: email,
                    password: password
                },
                dataType: 'json',
                process: function() {},
                success: function(data) {
                    window.location.href = data
                },
                error: function() {
                    $('.modal-body').html('Kesalahan system')
                }
            });
        }
    })
</script>