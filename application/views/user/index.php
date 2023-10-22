<div class="content-body">
    <!-- row -->




    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data User</a></li>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th>Status Akun</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($users as $u) : ?>
                                        <tr>
                                            <td><img class="rounded-circle" width="50" src="<?= base_url() ?>assets/images/user/<?= $u['image'] ?>" alt=""></td>
                                            <td><?= $u['name']; ?></td>
                                            <td><?= $u['email']; ?></td>
                                            <td>
                                                <?php
                                                $role = $u['role_id'];
                                                $level = $this->db->query("SELECT role FROM tabel_user_role WHERE id = '$role' ")->result_array();

                                                ?>
                                                <div class="badge badge-secondary"><?= $level[0]['role'] ?></div>
                                            </td>

                                            <td><?= $u['is_active'] == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="<?= base_url(); ?>user/edit" method="POST">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                        <input type="hidden" name="id_user" value="<?= $u['id'] ?>">
                                                        <button type="submit" class="btn btn-primary shadow btn-xs sharp mr-1" name="editsiswa"><i class="fa fa-pencil"></i></button>
                                                    </form>
                                                    <form action="<?= base_url() ?>user/delete" method="POST">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                        <input type="hidden" name="id_user" value="<?= $u['id'] ?>">
                                                        <button class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                                    </form>

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