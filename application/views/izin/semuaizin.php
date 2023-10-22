<div class="content-body">
    <!-- row -->

    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Semua Izin</a></li>
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
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Cari Izin</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="get" class="form-horizontal">
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label class="control-label">Kelas </label>
                                    <div class="controls">
                                        <select name="kelas" required="true" class="form-control" required>
                                            <option value="" disabled selected>Pilih kelas..</option>
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?= $k['id_kelas']; ?>"><?= $k['kelas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Bulan</label>
                                    <div class="controls">
                                        <select name="bulan" required="true" class="form-control">
                                            <option value="" disabled selected>Pilih bulan..</option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" name="pencarian" value="isset" class="btn-sm btn btn-secondary"> <i class="flaticon-381-search-1"></i> Cari Izin</button>

                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            // jika ada pencarian kelas dan bulan
            isset($_GET['pencarian']) ? $pencarian = true : $pencarian = false;
            ?>
            <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Izin Siswa Bulan <?= nama_bulan(date('m')) ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive recentOrderTable">
                            <table class="table verticle-middle table-responsive-md">
                                <thead>
                                    <tr>

                                        <th scope="col">Nama</th>
                                        <th scope="col">tanggal</th>
                                        <th scope="col">Alasan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataizin as $d) :
                                        $kodekelas = $d['kode_kelas'];
                                        $kodejurusan = $d['kode_jurusan'];
                                        $bulan = explode('-', $d['tanggal_izin'])[1];
                                    ?>
                                        <?php
                                        if ($pencarian ==  true) {
                                            if ($d['kode_kelas'] == $_GET['kelas'] && $bulan == $_GET['bulan']) { ?>
                                                <tr>

                                                    <td>
                                                        <?= $d['nama_siswa'] ?><br>
                                                        <?php
                                                        $kelas = $this->db->query("SELECT * FROM tabel_kelas WHERE id_kelas = '$kodekelas' ")->result_array()[0]['kelas'];
                                                        $jurusan = $this->db->query("SELECT * FROM tabel_jurusan WHERE id_jurusan = '$kodejurusan' ")->result_array()[0]['jurusan'];
                                                        ?>
                                                        <span class="text-small"><?= 'Kelas ' . $kelas . ' ' . $jurusan ?></span>
                                                    </td>
                                                    <td><?= namaHariBulanIndonesia($d['tanggal_izin']) ?></td>
                                                    <td> <span class="badge badge-rounded badge-<?= $d['type'] == 'Sakit' ? 'danger' : 'success' ?>"><?= $d['type'] ?></td>
                                                    <?php
                                                    if ($d['status'] == 'Menunggu Konfirmasi') {
                                                        $badge = 'warning';
                                                    } else if ($d['status'] == 'Diterima') {
                                                        $badge = 'success';
                                                    } else {
                                                        $badge == 'danger';
                                                    }
                                                    ?>
                                                    <td> <span class="badge badge-rounded badge-<?= $badge; ?>"><?= $d['status'] ?></td>

                                                    <td>
                                                        <a href="" class="btn-sm btn btn-primary">Lihat Keterangan</a>
                                                    </td>

                                                </tr>
                                            <?php } ?>

                                        <?php  } else { ?>
                                            <tr>

                                                <td>
                                                    <?= $d['nama_siswa'] ?><br>
                                                    <?php
                                                    $kelas = $this->db->query("SELECT * FROM tabel_kelas WHERE id_kelas = '$kodekelas' ")->result_array()[0]['kelas'];
                                                    $jurusan = $this->db->query("SELECT * FROM tabel_jurusan WHERE id_jurusan = '$kodejurusan' ")->result_array()[0]['jurusan'];
                                                    ?>
                                                    <span class="text-small"><?= 'Kelas ' . $kelas . ' ' . $jurusan ?></span>
                                                </td>
                                                <td><?= namaHariBulanIndonesia($d['tanggal_izin']) ?></td>
                                                <td> <span class="badge badge-rounded badge-<?= $d['type'] == 'Sakit' ? 'danger' : 'success' ?>"><?= $d['type'] ?></td>
                                                <?php
                                                if ($d['status'] == 'Menunggu Konfirmasi') {
                                                    $badge = 'warning';
                                                } else if ($d['status'] == 'Diterima') {
                                                    $badge = 'success';
                                                } else {
                                                    $badge = 'danger';
                                                }
                                                ?>
                                                <td> <span class="badge badge-rounded badge-<?= $badge; ?>"><?= $d['status'] ?></td>
                                                <td>
                                                    <button idizin="<?= $d['id'] ?>" class="btn-sm btn btn-primary detailizin" data-toggle="modal" data-target="#modalketerangan">Lihat Detail</button>
                                                </td>

                                            </tr>
                                        <?php   }  ?>





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

<div class="modal fade bd-example-modal-lg" id="modalketerangan">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="untukloading"></div>
                <form class="formdetailizin" method="POST">
                    <div class="form-row">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                        <input type="hidden" name="id_izin" class="id_izin" id="id_izin">
                        <div class="form-group col-md-12">
                        </div>

                        <div class="form-group col-md-12 form2">
                            <label class="labelkelas">Izin Untuk tanggal</label>
                            <input type="text" class="form-control" id="tanggalizin" readonly>
                        </div>
                        <div class="form-group col-md-12 form2">
                            <label class="labelkelas">Bukti</label>
                            <div class="bukti_izin"></div>
                        </div>
                        <div class="form-group col-md-12 form2">
                            <label for="keterangan_izin">keterangan</label>
                            <textarea class="form-control" name="keterangan_izin" id="keterangan_izin" cols="30" rows="10" readonly>  </textarea>
                        </div>
                    </div>
                    <div class="buttonnya">
                        <button type="submit" name="submit" value="terima" class="btn btn-primary buttonsubmit izinkan">Izinkan</button>
                        <button type="submit" name="submit" value="tolak" class="btn btn-danger buttonsubmit tolakizin">Tolak</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('.detailizin').click(function() {
        let idizin = $(this).attr('idizin');

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>ajax/tampilizin",
            data: {
                idizin: idizin,
            },
            dataType: 'json',
            success: function(data) {
                if (data.status != 'Menunggu Konfirmasi') {
                    $('.buttonsubmit').hide();
                    $('.buttonnya').html(`<p class="badge badge-secondary">Permintaan Izin Ini sudah ${data.status}</p>`)
                }

                $('.modal-title').html(`Data Izin ${data.nama_siswa}`)
                $('#keterangan_izin').html(`${data.keterangan}`);
                $('.bukti_izin').html(`<img src="<?= base_url() ?>assets/images/izinsiswa/${data.file_bukti}" width="200px" height="200px">`)

                $('#id_izin').attr('value', idizin);
                $('#nis').attr('value', data.nis_siswa);
                $('#kodekelas').attr('value', data.kode_kelas);
                $('#tanggal').attr('value', data.tanggal_izin);
                $('#tanggalizin').attr('value', data.tanggal_indonesia);

            },
            error: function() {
                $('.modal-body').html('Kesalahan system')
            }
        });
    })

    $('.tolakizin').click(function(e) {
        e.preventDefault();
        $('.untukloading').html('<img src="<?= base_url('assets/img/loading.gif') ?>">');
        $('.formdetailizin').hide();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>ajax/konfirmasi_izin",
            data: {
                idizin: $('#id_izin').val(),
                aksi: 'Ditolak'
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data)
                window.location.href = data
            },
            error: function() {
                $('.modal-body').html('Kesalahan system')
            }
        });

    })
    $('.izinkan').click(function(e) {
        e.preventDefault();
        $('.untukloading').html('<img src="<?= base_url('assets/img/loading.gif') ?>">');
        $('.formdetailizin').hide();

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>ajax/konfirmasi_izin",
            data: {
                idizin: $('#id_izin').val(),
                aksi: 'Diterima'
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                window.location.href = data
            },
            error: function() {
                $('.modal-body').html('Kesalahan system')
            }
        });

    })
</script>