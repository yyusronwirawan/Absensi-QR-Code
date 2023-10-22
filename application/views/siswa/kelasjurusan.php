<div class="content-body">
    <!-- row -->

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelas</a></li>
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
        <div class="row ">
            <div class="col-xl-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kelas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($kelasjurusan as $k) : ?>
                                <?php
                                $kodekelas = $k['kode_kelas'];
                                $kodejurusan = $k['kode_jurusan'];
                                $sqlsiswa = "SELECT * FROM tabel_siswa WHERE kode_kelas = '$kodekelas' AND kode_jurusan = '$kodejurusan'";
                                $jumlahsiswa = $this->db->query($sqlsiswa)->num_rows();
                                $namakelas = $this->db->query("SELECT * FROM tabel_kelas WHERE id_kelas = '$kodekelas'")->result_array()[0]['kelas'];
                                $namajurusan = $this->db->query("SELECT * FROM tabel_jurusan WHERE id_jurusan = '$kodejurusan'")->result_array()[0]['jurusan'];

                                ?>
                                <div class="col-xl-3 col-lg-6 col-sm-4">
                                    <a href="<?= base_url('siswa/?kelas=' . $kodekelas . '&jurusan=' . $kodejurusan) ?>">

                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body  p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="la la-users"></i>
                                                    </span>
                                                    <div class="media-body text-white">
                                                        <p class="mb-1">Kelas <?= $namakelas ?> <?= $namajurusan ?></p>
                                                        <h3 class="text-white"><?= $jumlahsiswa ?></h3>
                                                        <p>Total siswa</p>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>