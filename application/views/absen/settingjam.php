<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Absen</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Jam absen</a></li>
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
                        <h4 class="card-title">Jam absen</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th class="width80">No</th>
                                        <th>Tipe</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jamabsen as $jam) : ?>
                                        <tr>
                                            <td><?php echo $jam['id']; ?></td>
                                            <td><span class="badge light badge-success"><?= $jam['type'] ?></td>
                                            <td><?= $jam['mulai'] ?></td>
                                            <td><?= $jam['selesai'] ?></td>
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
                                                        <button class="dropdown-item" data-toggle="modal" data-target="#ubah<?= $jam['id']; ?>">Edit</button>
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

<?php foreach ($jamabsen as $jam) : ?>
    <div class="modal fade" id="ubah<?= $jam['id']; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit jam <?= $jam['type'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo base_url('absen/editjamabsen'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">

                            <input type="hidden" name="id" class="form-control input-default " placeholder="input-default" value="<?= $jam['id'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" placeholder="input-menu" value="<?= $jam['type'] ?>" readonly required>
                        </div>
                        <div class=" form-group">
                            <label>Mulai</label>
                            <input type="text" name="jammulai" class="form-control input-rounded" placeholder="input-icon" value="<?= $jam['mulai'] ?>" required>
                            <small class="text-danger pl-2">jam:menit:detik (pisahkan dengan titik dua)</small>
                        </div>
                        <div class=" form-group">
                            <label>Selesai</label>
                            <input type="text" name="jamselesai" class="form-control input-rounded" placeholder="input-icon" value="<?= $jam['selesai'] ?>" required>
                            <small class="text-danger pl-2">jam:menit:detik (pisahkan dengan titik dua)</small>
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