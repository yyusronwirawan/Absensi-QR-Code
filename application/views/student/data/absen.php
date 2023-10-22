<div class="content-body">
    <!-- row -->
    <?php
    $sqlsabtu = "SELECT status FROM tabel_libur WHERE type = 'weekend' AND keterangan = 'sabtu' ";
    $sabtu = $this->db->query($sqlsabtu)->result_array()[0]['status'];
    $sqlminggu = "SELECT status FROM tabel_libur WHERE type = 'weekend' AND keterangan = 'minggu' ";
    $minggu = $this->db->query($sqlminggu)->result_array()[0]['status'];


    ?>
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Absen</a></li>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Absen <?= $user['nama_siswa'] ?></h4>
                        <?php
                        $gettahun = date('Y');
                        if (isset($_GET['cariabsen'])) {
                            if (isset($_GET['kelas'])) {
                                $getkelas = $_GET['kelas'];
                            } else {
                                $getkelas = 1;
                            }
                            if (isset($_GET['bulan'])) {
                                $getbulan = $_GET['bulan'];
                            } else {
                                $getbulan = date('m');
                            }
                            if (isset($_GET['nis'])) {
                                $getnis = $_GET['nis'];
                            } else {
                                $getnis = '';
                            }
                            $gett = 'nis=' . $getnis . '&kelas=' . $getkelas . '&bulan=' . $getbulan;
                        } else {
                            $gett = 'nis=&kelas=1&bulan=' . date('m');
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <form action="<?= base_url() ?>absen/input" method="POST">
                                <table class="table table-bordered table-striped with-check">

                                    <thead>
                                        <tr>

                                            <th rowspan=" 2">Nomor induk siswa</th>
                                            <th rowspan=" 2">Nama</th>
                                            <th rowspan="2">L/P</th>
                                            <?php for ($tanggal_table = 1; $tanggal_table <= 31; $tanggal_table++) {
                                                echo "<th rowspan='2'>$tanggal_table</th>";
                                            } ?>
                                            <th colspan="4">jumlah</th>
                                        </tr>
                                        <tr>
                                            <th>A</th>
                                            <th>I</th>
                                            <th>S</th>
                                            <th>T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswa as $d) :  ?>

                                            <tr>

                                                <td><?= $d['nis']; ?></td>
                                                <td><?= $d['nama_siswa']; ?></td>
                                                <td><?= $d['jenis_kelamin']; ?></td>
                                                <?php
                                                $nomor2 = 1;
                                                // $sisa_td = 30;
                                                //mengabil tanggal 
                                                $keterangan_alpha = 0;
                                                $keterangan_izin = 0;
                                                $keterangan_sakit = 0;
                                                $keterangan_terlambat = 0;

                                                $nis = $d['nis'];
                                                $kelass = $d['kode_kelas'];
                                                $cari_bulan_siswa = date('m');
                                                $tahun = date('Y');


                                                $jurusann = $d['kode_jurusan'];
                                                $sql = "SELECT * FROM tabel_detail_absen WHERE nis = '$nis' AND kode_kelas = '$kelass' AND kode_jurusan = '$jurusann' AND tanggal_absen LIKE '%$tahun-$cari_bulan_siswa%' ORDER BY tanggal_absen ASC";
                                                $bulan = date('m');

                                                $query = $this->db->query($sql);

                                                if ($query->num_rows() > 0) {

                                                    foreach ($query->result_array() as $absen) {
                                                        //mengabil tanggal 
                                                        $ambil_tanggal = explode("-", $absen['tanggal_absen']);
                                                        //merubah menjadi tanggal jadi integer
                                                        $ambil_tanggal[2] = (int)$ambil_tanggal[2];
                                                        for ($nomor = $nomor2; $nomor <= $ambil_tanggal[2]; $nomor++) {
                                                            $nomor < 10 ? $tgl = '0' . $nomor : $tgl = $nomor;
                                                            $tanggal = date('Y') . '-' . $bulan . '-' . $tgl;
                                                            $hari = date('D', strtotime($tanggal));

                                                            if ($nomor == $ambil_tanggal[2]) {

                                                                $nomor < 10 ? $tgl = '0' . $nomor : $tgl = $nomor;
                                                                $tanggal = date('Y') . '-' . $bulan . '-' . $tgl;
                                                                $hari = date('D', strtotime($tanggal));
                                                                // cek libur



                                                                if (count($datalibur) > 0) {
                                                                    echo '<td class="bg-danger">' . $datalibur[0]['keterangan'] . '</td>';
                                                                } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                                                    echo '<td class="bg-danger"></td>';
                                                                } else {
                                                                    if ($absen['keterangan'] == 'h') {
                                                                        if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                                            echo '<td> <i class="fa fa-check"></i></td>';
                                                                        } else {
                                                                            echo "<td><b>1/2</b></td>";
                                                                        }
                                                                    } else if ($absen['keterangan'] == 's' || $absen['keterangan'] == 'a' || $absen['keterangan'] == 'i') {
                                                                        echo "<td><b>" . strtoupper($absen['keterangan']) . " </b></td>";
                                                                    } else {
                                                                        echo '<td></td>';
                                                                    }
                                                                }
                                                            } else {
                                                                echo '<td></td>';
                                                            }
                                                        }
                                                        //meng rekap bulannan
                                                        $nomor2 = $ambil_tanggal[2] + 1;
                                                        $sisa_td = 31 - $nomor2;
                                                        if ($absen['keterangan'] == 'a') {
                                                            $keterangan_alpha++;
                                                        } else if ($absen['keterangan'] == 'i') {
                                                            $keterangan_izin++;
                                                        } else if ($absen['keterangan'] == 's') {
                                                            $keterangan_sakit++;
                                                        } else if ($absen['keterangan'] == 't') {
                                                            $keterangan_alpha++;
                                                        }
                                                    }
                                                    for ($td = 0; $td <= $sisa_td; $td++) {
                                                        $tgl = $nomor2 + $td;
                                                        $tgl < 10 ? $tgl2 = '0' . $tgl : $tgl2 = $tgl;
                                                        $tanggal = date('Y') . '-' . $bulan . '-' . $tgl2;
                                                        $hari = date('D', strtotime($tanggal));

                                                        // cek libur
                                                        $sqllibur = "SELECT * FROM tabel_libur WHERE tanggal = '$tahun-$bulan-$tgl' AND status = 'Aktif'";
                                                        $datalibur = $this->db->query($sqllibur)->result_array();

                                                        if ($td == $tgl) {

                                                            if (count($datalibur) > 0) {
                                                                echo '<td class="bg-danger">' . $datalibur[0]['keterangan'] . '</td>';
                                                            } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                                                echo '<td class="bg-danger"></td>';
                                                            } else {
                                                                if ($absen['keterangan'] == 'h') {
                                                                    if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                                        echo '<td> <i class="fa fa-check"></i></td>';
                                                                    } else {
                                                                        echo "<td><b>1/2</b></td>";
                                                                    }
                                                                } else if ($absen['keterangan'] == 's' || $absen['keterangan'] == 'a' || $absen['keterangan'] == 'i') {
                                                                    echo "<td><b>" . strtoupper($absen['keterangan']) . " </b></td>";
                                                                } else {
                                                                    echo '<td></td>';
                                                                }
                                                            }
                                                        } else {
                                                            echo '<td></td>';
                                                        }
                                                    }
                                                    //tampilan rekap absen
                                                    echo "<td>$keterangan_alpha</td>
                                                <td>$keterangan_izin</td>
                                                <td>$keterangan_sakit</td>
                                                <td>$keterangan_terlambat</td>";
                                                    $keterangan_alpha = 0;
                                                    $keterangan_sakit = 0;
                                                    $keterangan_izin = 0;
                                                    $keterangan_terlambat = 0;
                                                } else {

                                                    $sisa_td = 30;
                                                    for ($td = 0; $td <= $sisa_td; $td++) {
                                                        $tgl = $td + 1;
                                                        $tgl < 10 ?  $tgl2 = '0' . $tgl : $tgl2 = $tgl;
                                                        $tanggal = date('Y') . '-' . $bulan . '-' . $tgl;
                                                        $hari = date('D', strtotime($tanggal));
                                                        // cek libur
                                                        $sqllibur = "SELECT * FROM tabel_libur WHERE tanggal = '$tahun-$bulan-$tgl' AND status = 'Aktif'";
                                                        $datalibur = $this->db->query($sqllibur)->result_array();

                                                        if ($td == $tgl) {

                                                            if (count($datalibur) > 0) {
                                                                echo '<td class="bg-danger">' . $datalibur[0]['keterangan'] . '</td>';
                                                            } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                                                echo '<td class="bg-danger"></td>';
                                                            } else {
                                                                if ($absen['keterangan'] == 'h') {
                                                                    if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                                        echo '<td> <i class="fa fa-check"></i></td>';
                                                                    } else {
                                                                        echo "<td><b>1/2</b></td>";
                                                                    }
                                                                } else if ($absen['keterangan'] == 's' || $absen['keterangan'] == 'a' || $absen['keterangan'] == 'i') {
                                                                    echo "<td><b>" . strtoupper($absen['keterangan']) . " </b></td>";
                                                                } else {
                                                                    echo '<td></td>';
                                                                }
                                                            }
                                                        } else {
                                                            echo '<td></td>';
                                                        }
                                                    }
                                                    //tampilan rekap absen
                                                    echo "<td>$keterangan_alpha</td>
                                                <td>$keterangan_izin</td>
                                                <td>$keterangan_sakit</td>
                                                <td>$keterangan_terlambat</td>";
                                                    $keterangan_alpha = 0;
                                                    $keterangan_sakit = 0;
                                                    $keterangan_izin = 0;
                                                    $keterangan_terlambat = 0;
                                                }
                                                ?>
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