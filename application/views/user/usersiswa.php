<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">siswa</a></li>
            </ol>
        </div>
        <?php if ($this->session->flashdata('flash')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible alert-alt fade show my-4 mx-5">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
                <strong><?= $this->session->flashdata('flash')['alert'] ?>!</strong> <?= $this->session->flashdata('flash')['message']; ?>.
            </div>
        <?php endif; ?>

        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Log siswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nis Siswa</th>
                                        <th>Email</th>
                                        <th>Nama Siswa</th>

                                        <th>is_active</th>
                                        <th>kode_unik</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usersiswa as $user) : ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td><span class="badge light badge-primary"><?php echo $user->nis_siswa; ?></span></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td><?php echo $user->nama_siswa; ?></td>
                                            <td><?php echo $user->is_active; ?></td>
                                            <td><?php echo $user->kode_unik; ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="" data-toggle="modal" data-target="#ubah<?= $user->id; ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                    <a href="<?php echo base_url('User/deletelogsiswa/' . base64_encode($user->id)); ?>" onclick="return confirm('Anda yakin ingin menghapus Nama <?= $user->nama_siswa; ?>')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php foreach ($usersiswa as $siswa) : ?>
    <div class="modal fade" id="ubah<?= $siswa->id; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $titleedit; ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo base_url('User/editlogsiswa'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control input-default " placeholder="input-default" value="<?php echo $siswa->id; ?>" readonly>
                        </div>
                        <div cl ass="form-group">
                            <label>Nis Siswa</label>
                            <input type="text" name="nis" class="form-control" placeholder="input-menu" value="<?php echo $siswa->nis_siswa; ?>" required>
                            <?= form_error('nis', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control input-rounded" placeholder="input-icon" value="<?php echo $siswa->email; ?>">
                            <?= form_error('email', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>Status</label>
                            <select name="is_active" id="is_active" class="form-control" required>
                                <option value="1" <?= $siswa->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $siswa->is_active == 0 ? 'selected' : '' ?>>Tidak aktif</option>
                            </select>
                            <?= form_error('icon', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>