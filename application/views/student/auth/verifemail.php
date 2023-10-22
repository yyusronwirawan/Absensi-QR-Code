<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/iofrm-theme19.css">
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
                        <h3>Verifikasi Email</h3>
                        <p>Untuk verifikasi email, Silahkan masukan NIS anda disini.</p>
                        <form>
                            <input class="form-control nis" type="number" name="nis" placeholder="Nomor Induk" required>
                            <div class="info"></div>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Verifikasi Email</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Link verifikasi dikirim</h3>
                        <p>Kami sudah mengirimkan link verifikasi email ke <span class="emailnya"></span> , silahkan cek inbox / spam email anda untuk melanjutkan verifikasi</p>
                        <div class="info-holder">
                            <span>Tidak menerima email?</span> <a href="#">Hubungi kami</a>.
                        </div>
                    </div>
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
    $('#submit').click(function(e) {
        e.preventDefault();
        let nis = $('.nis').val();
        if (nis.length != 10) {
            $('.info').html('<small class="error-message ">Nomor induk harus 10 digit</small>');
        } else {
            $(this).html('Memproses..');
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>ajax/verif_email_siswa",
                data: {
                    nis: nis,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == false) {
                        $('.info').html(`<small class="error-message ">${data.message}</small>`)
                        $('#submit').html('Verifikasi email');
                    } else {
                        $('.emailnya').html(data.message)
                        $('.info').remove();
                        $('.form-items', '.form-content').addClass('hide-it');
                        $('.form-sent', '.form-content').addClass('show-it');

                    }
                },
                error: function() {
                    $('.info').html('Kesalahan system')
                }
            });
        }
    })
</script>