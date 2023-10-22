<div class="content-body">
    <!-- row -->




    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Siswa</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Siswa</a></li>
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
                        <h4 class="card-title">Data Siswa </h4>
                        <a href="<?= base_url(); ?>siswa/add" class="btn-sm btn btn-secondary  tambahkelas    shadow"> <i class="flaticon-381-add-2"></i> Tambah</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Kelas</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Nomor HP</th>
                                        <!-- <th>QR</th> -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($siswa as $s) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $s['nis']; ?></td>
                                            <td><?= $s['nama_siswa']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['alamat']; ?></td>
                                            <td><?= $s['kelas']; ?></td>
                                            <td><?= $s['tgl_lahir']; ?></td>
                                            <td><?= $s['no_telepon']; ?></td>

                                            <td>
                                                <div class="d-flex">
                                                    <form action="<?= base_url(); ?>siswa/edit" method="POST">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                        <input type="hidden" name="nis" value="<?= $s['nis'] ?>">
                                                        <button type="submit" class="btn btn-primary shadow btn-xs sharp mr-1" name="editsiswa"><i class="fa fa-pencil"></i></button>
                                                    </form>
                                                    <form action="<?= base_url() ?>siswa/delete" method="POST">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                        <input type="hidden" name="id_siswa" value="<?= $s['id_siswa'] ?>">
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