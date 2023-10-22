<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Absen</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Libur</a></li>
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
                        <h4 class="card-title">Libur Weekend</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>

                                        <th>Hari</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($liburweekend as $lw) : ?>
                                        <tr>


                                            <td><span class="badge light badge-success"><?= $lw['keterangan'] ?></td>
                                            <td id="status-<?= $lw['id']; ?>"><span class="badge light badge-<?= $lw['status'] == 'Aktif' ? 'success' : 'danger' ?>"><?= $lw['status'] ?></td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" <?= $lw['status'] == 'Aktif' ? 'status="Non Aktif" checked' : 'status="Aktif"' ?> class="toggle" idlibur="<?= $lw['id'] ?>" hari="<?= $lw['keterangan'] ?>">
                                                    <span class="slider round"></span>
                                                </label>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Libur Nasional</h4>
                    </div>
                    <div class="card-body">

                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahlibur">Tambah</button>
                        <div class="table-responsive">

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>

                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($libur as $l) : ?>
                                        <tr>

                                            <td><?= $l['tanggal'] ?></td>
                                            <td><span class="badge light badge-success"><?= $l['keterangan'] ?></td>
                                            <td><span class="badge light badge-<?= $l['status'] == 'Aktif' ? 'success' : 'danger' ?>"><?= $l['status'] ?></td>
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
                                                        <a class="dropdown-item" href="<?php echo base_url('absen/hapus_libur/' . base64_encode($l['id'])); ?>">Delete</a>

                                                        <button class="dropdown-item" data-toggle="modal" data-target="#ubah<?= $l['id']; ?>">Edit</button>
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

<?php foreach ($libur as $l) : ?>
    <div class="modal fade" id="ubah<?= $l['id']; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit libur <?= $l['keterangan'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo base_url('absen/editlibur'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">

                            <input type="hidden" name="id" class="form-control input-default " placeholder="input-default" value="<?= $l['id'] ?>" readonly>
                        </div>
                        <div class=" form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control input-rounded" placeholder="input-icon" value="<?= $l['tanggal'] ?>" required>
                            <small class="text-danger pl-2">Tahun-bulan-tanggal</small>
                        </div>
                        <div class=" form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control input-rounded" placeholder="input-icon" value="<?= $l['keterangan'] ?>" required>
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
<div class="modal fade" id="tambahlibur">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Libur Nasional</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo base_url('absen/tambahlibur'); ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <div class="form-group">
                        <input type="hidden" name="type" value="other" id="">
                    </div>
                    <div class=" form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control input-rounded" placeholder="input-icon" required>
                    </div>
                    <div class=" form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control input-rounded" placeholder="Keterangan" required>
                    </div>
                    <div class=" form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="" selected disabled>Pilih status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Non Aktif">Non Aktif</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.toggle').click(function() {
            let idlibur = $(this).attr('idlibur')
            let status = $(this).attr('status')
            let hari = $(this).attr('hari')
            console.log(`id libur = ${idlibur} aksi di ${status} kan`)
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>ajax/editliburweekend",
                data: {
                    id: idlibur,
                    status: status,
                    hari: hari,
                },
                // dataType: 'json',
                success: function(data) {
                    if (status == 'Non Aktif') {
                        $(`#status-${idlibur}`).html(`Non Aktif`);
                    } else if (status == 'Aktif') {
                        $(`#status-${idlibur}`).html(`Aktif`);

                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });
    });
</script>