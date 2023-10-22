<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Menu</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Sub Management</a></li>
            </ol>
        </div>
        <!-- row -->
        <?php if ($this->session->flashdata('flash')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible alert-alt fade show my-4 mx-5">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
                <strong><?= $this->session->flashdata('flash')['alert'] ?>!</strong> <?= $this->session->flashdata('flash')['message']; ?>.
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sub Menu Management</h4>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn-sm btn btn-primary " data-toggle="modal" data-target="#tambah"> <i class="flaticon-381-add-2"> </i> Tambah</button>
                        <div class="table-responsive">

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th class="width80">ID</th>
                                        <th>Menu</th>
                                        <th>Title</th>
                                        <th>Url</th>
                                        <th>is_active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Submenu as $namasubmenu) : ?>
                                        <tr>
                                            <td><?php echo $namasubmenu['id']; ?></td>
                                            <td><span class="badge light badge-success"><?php echo $namasubmenu['menu']; ?></span></td>
                                            <td><?php echo $namasubmenu['title']; ?></td>
                                            <td><span class="badge light badge-primary"><?php echo $namasubmenu['url']; ?></span></td>
                                            <td><?php echo $namasubmenu['is_active']; ?></td>
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
                                                        <a class="dropdown-item" href="<?php echo base_url('menu/hapussubmenu/' . base64_encode($namasubmenu['id'])); ?>">Delete</a>
                                                        <button class="dropdown-item" data-toggle="modal" data-target="#ubah<?= $namasubmenu['id']; ?>">Edit</button>
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
                <form method="POST" action="<?php echo base_url('menu/tambahsub'); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value=""></option>
                            <?php foreach ($Menu as $m) :  ?>
                                <option value="<?= $m->id; ?>"><?= $m->menu; ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                    <div class=" form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control input-rounded" placeholder="input-title" required>
                        <?= form_error('title', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class=" form-group">
                        <label>Url</label>
                        <input type="text" name="url" class="form-control input-rounded" placeholder="input-url" required>
                        <?= form_error('url', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class=" form-group">
                        <label>Aktif</label>
                        <select name="is_active" id="" class="form-control" required>
                            <option value="" selected disabled>Pilih status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak aktif</option>
                        </select>
                        <?= form_error('is_active', '<small class="text-danger pl-2">', '</small>'); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!---Modal Edit-->

<?php foreach ($Submenu as $namasubmenu) : ?>
    <div class="modal fade" id="ubah<?= $namasubmenu['id']; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $titleedit; ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo base_url('menu/editsub'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>" id="">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" name="id" class="form-control input-default " placeholder="input-default" value="<?php echo $namasubmenu['id']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control" required>

                                <?php foreach ($Menu as $m) :  ?>
                                    <option value="<?= $m->id; ?>" <?= $m->id == $namasubmenu['menu_id'] ? 'selected' : '' ?>><?= $m->menu; ?></option>
                                <?php endforeach;  ?>
                            </select>
                            <?= form_error('menu', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control input-rounded" placeholder="input-title" value="<?php echo $namasubmenu['title']; ?>" required>
                            <?= form_error('title', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>Url</label>
                            <input type="text" name="url" class="form-control input-rounded" placeholder="input-url" value="<?php echo $namasubmenu['url']; ?>" required>
                            <?= form_error('url', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class=" form-group">
                            <label>status</label>

                            <select name="is_active" id="" class="form-control" required>
                                <option value="1" <?= $namasubmenu['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $namasubmenu['is_active'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                            <?= form_error('is_active', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">ubah</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>