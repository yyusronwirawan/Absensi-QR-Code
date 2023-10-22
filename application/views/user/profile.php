<div class="content-body">
    <!-- row -->
    <?php


    ?>
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                <!-- <li class="breadcrumb-item active"><a href="javascript:void(0)">Data User</a></li> -->
            </ol>
        </div>
        <?php if ($this->session->flashdata('flash')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible alert-alt fade show my-4 mx-5">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
                <strong><?= $this->session->flashdata('flash')['alert'] ?>!</strong> <?= $this->session->flashdata('flash')['message']; ?>.
            </div>
        <?php endif; ?>


        <div class="row">

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">

                        <div class="profile-blog mb-5">
                            <h5 class="text-primary d-inline">Profil</h5>
                            <img src="<?= base_url() . 'assets/images/user/' . $dataakun['image'] ?>" alt="" class="img-fluid mt-4 mb-4 w-100">
                            <h4>Nama : <?= $dataakun['name'] ?></h4>
                            <h4>Email : <?= $dataakun['email'] ?></h4>
                            <?php
                            $role = $dataakun['role_id'];
                            $level = $this->db->query("SELECT * FROM tabel_user_role WHERE id = '$role' ")->result_array()[0]['role'];
                            ?>
                            <h4>Level : <span class="badge badge-secondary"><?= $level ?></span></h4>
                            <h4>Akun dibuat : <?= namaHariBulanIndonesia($dataakun['date_create']) ?></h4>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#profilelengkap" data-toggle="tab" class="nav-link active show">Ubah Password</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div id="profilelengkap" class="tab-pane fade active show">
                                        <div class="my-post-content pt-3">
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="card">
                                                    <?= $this->session->flashdata('message'); ?>
                                                    <div class="card-header">
                                                        <h4 class="card-title">Ubah Password</h4>
                                                    </div>
                                                    <div class="card-body">

                                                        <form method="POST" action="<?= base_url('User/ubahpassword'); ?>">
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="">
                                                            <div class="form-group">
                                                                <label for="current_password">Password saat ini</label>
                                                                <input type="password" name="current_password" class="form-control" id="current_password">
                                                                <?= form_error('current_password', '<small class="text-danger pl-2">', '</small>');  ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_password1">Password baru</label>
                                                                <input type="password" name="new_password1" class="form-control" name="new_password1" id="new_password1">
                                                                <?= form_error('new_password1', '<small class="text-danger pl-2">', '</small>');  ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_password2">Konfirmasi Password</label>
                                                                <input type="password" name="new_password2" class="form-control" name="new_password2" id="new_password2">
                                                                <?= form_error('new_password2', '<small class="text-danger pl-2">', '</small>');  ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn-sm btn btn-primary">Ubah Password</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    // lihat kata sandi
    $('.seepw').on('change', function() {
        if (this.checked) {
            $('.pw1').attr('type', 'text');
            $('.pw2').attr('type', 'text');
        } else {
            $('.pw1').attr('type', 'password');
            $('.pw2').attr('type', 'passwordss');

        }
    });


    // funtion untuk alert
    function showalert(alert, strong, message) {
        $('.untukalert').html(` <div class="alert alert-${alert} alert-dismissible alert-alt fade show my-4 mx-5">
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
            </button>
            <strong>${strong}</strong>${message}
        </div>`)
    }
    // ganti password 
    $('.changepass').click(function(e) {
        e.preventDefault();
        let oldpw = $('.pwold').val();
        let newpw = $('.pw1').val();
        let confirmpw = $('.pw2').val();

        if (oldpw.length == 0 || newpw.length == 0 || confirmpw.length == 0) {
            showalert('danger', 'Gagal!', ' Harap isi semua Form')
        } else if (newpw.length < 6) {
            showalert('danger', 'Gagal! ', ' Kata sand minimal 6 karakter');
        } else if (newpw != confirmpw) {
            showalert('danger', 'Gagal! ', 'Kata sandi tidak sesuai');
        } else {

            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>ajax/change_password_siswa",
                dataType: 'json',
                data: {
                    oldpw: oldpw,
                    newpw: newpw,
                    confirmpw: confirmpw,
                },
                // dataType: 'json',
                success: function(data) {

                    $('.formeuy').show();
                    if (data.status == false) {
                        showalert('danger', 'Gagal !', data.message);
                    } else if (data.status == true) {
                        showalert('success', 'Berhasil !', data.message);

                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }

    })
</script>