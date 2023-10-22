<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Menu</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Management</a></li>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Menu</h4>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn-sm btn btn-primary" data-toggle="modal" data-target="#tambah"> <i class="flaticon-381-add-2"></i> Tambah</button>

                        <div class="table-responsive">

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th class="width80">ID</th>
                                        <th>Menu</th>
                                        <th>ICON</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Menu as $namamenu) : ?>
                                        <tr>
                                            <td><?php echo $namamenu->id; ?></td>
                                            <td><span class="badge light badge-success"><?php echo $namamenu->menu; ?></span></td>
                                            <td><?php echo $namamenu->icon; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <circle fill="#000000" cx="5" cy="12" r="2" />
                                                                <circle fill="#000000" cx="12" cy="12" r="2" />
                                                                <circle fill="#000000" cx="19" cy="12" r="2" />
                                                            </g>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?php echo base_url('menu/hapus/' . base64_encode($namamenu->id)); ?>">Delete</a>
                                                        <button class="dropdown-item" data-toggle="modal" data-target="#ubah<?= $namamenu->id; ?>">Edit</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                </tbody>
                            <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---Modal Edit-->

<?php foreach ($Menu as $namamenu) : ?>
    <div class="modal fade" id="ubah<?= $namamenu->id; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $titleedit; ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo base_url('menu/edit'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" name="id" class="form-control input-default " placeholder="input-default" value="<?php echo $namamenu->id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Menu</label>
                            <input type="text" name="menu" class="form-control" placeholder="input-menu" value="<?php echo $namamenu->menu; ?>" required>
                            <?= form_error('menu', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>Icon</label>
                            <input type="text" name="icon" class="form-control input-rounded" placeholder="input-icon" value="<?php echo $namamenu->icon; ?>" required>
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

<!---Modal Tambah-->
<div class="modal fade" id="tambah">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titletambah; ?></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('menu/tambah'); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" name="menu" class="form-control" placeholder="input-menu" required>
                        <?= form_error('menu', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class=" form-group">
                        <label>Icon</label>
                        <input type="text" name="icon" class="form-control input-rounded" placeholder="input-icon" required>
                        <?= form_error('icon', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>