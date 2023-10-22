<div class="content-body">
    <div class="col-xl-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit User <?= $user['name']; ?></h4>
            </div>

            <div class="card">
                <div class=" card-body">
                    <div class="widget-content nopadding">
                        <form action="<?= base_url() ?>user/edituser" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <?php echo form_open_multipart('User/edituser'); ?>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <input type="hidden" name="id_user" value="<?= $user['id']; ?>">
                                <label class="control-label">Nama Lengkap:</label>
                                <div class="controls">
                                    <input type="text" class="form-control" value="<?= $user['name']; ?>" name="nama" required />
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="email" class="form-control" value="<?= $user['email']; ?>" name="email" required />
                                </div>
                            </div>
                            <input type="hidden" name="fotodefault" id="" value="<?= $user['image'] ?>">
                            <div class="form-group col-md-12">
                                <label class="control-label">Foto</label>
                                <div class="controls">
                                    <img src="<?= base_url() ?>assets/images/user/<?= $user['image'] ?>" width="150" height="150">
                                    <input type="file" name="foto" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Level</label>
                                <div class="controls">
                                    <?php
                                    $role = $this->db->query("SELECT * FROM tabel_user_role ")->result_array();
                                    ?>
                                    <select name="role" id="is_active" class="form-control" required>
                                        <?php foreach ($role as $r) : ?>
                                            <option value="<?= $r['id'] ?>" <?= $user['role_id'] == $r['id'] ? 'selected' : '' ?>><?= $r['role'] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">status</label>
                                <div class="controls">
                                    <select name="is_active" id="is_active" class="form-control" required>
                                        <option value="1" <?= $user['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $user['is_active'] == 0 ? 'selected' : '' ?>>Tidak aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="editsiswa" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                            <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>s