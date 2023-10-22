<div class="content-body">
    <div class="col-xl-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Siswa <?= $siswa['nama_siswa']; ?></h4>
            </div>

            <div class="card">
                <div class=" card-body">
                    <div class="widget-content nopadding">
                        <form action="<?= base_url() ?>siswa/editsiswa" method="post" class="form-horizontal">
                            <div class="form-group col-md-12">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">
                                <label class="control-label">Name Lengkap:</label>
                                <div class="controls">
                                    <input type="text" class="form-control" value="<?= $siswa['nama_siswa']; ?>" name="nama" required />
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Nomor Induk Siswa</label>
                                <div class="controls">
                                    <input type="text" class="form-control" minlength="10" maxlength="10" value="<?= $siswa['nis']; ?>" name="nis" required />
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Jenis Kelamin</label>
                                <div class="form-group mb-0">
                                    <label class="radio-inline mr-3"><input type="radio" name="jeniskelamin" value="L" <?= $siswa['jenis_kelamin'] == 'L' ? 'checked' : ''; ?>> Laki Laki</label>
                                    <label class="rAQadio-inline mr-3"><input type="radio" name="jeniskelamin" value="P" <?= $siswa['jenis_kelamin'] == 'P' ? 'checked' : ''; ?>> Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Tanggal Lahir (mm-dd)</label>
                                <div class="controls">
                                    <input type="date" value="<?= $siswa['tgl_lahir'] ?>" name="tgl_lahir" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Kelas :</label>
                                <div class="controls">
                                    <select name="kelas" id="kelas" class="form-control" required>
                                        <option value="0" selected disabled>Pilih kelas..</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option <?= $siswa['id_kelas'] == $k['id_kelas'] ? 'selected' : '' ?> value="<?= $k['id_kelas']; ?>"><?= $k['kelas']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="normal" class="control-label">Nomor Telepon :</label>
                                <div class="controls">
                                    <input type="text" id="mask-phoneExt" name="nomor_hp" value="<?= $siswa['no_telepon']; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-md-12 n">
                                <label class="control-label">Alamat</label>
                                <div class="controls">
                                    <textarea class="form-control" minlength="10" name="alamat" required><?= $siswa['alamat']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="editsiswa" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>s