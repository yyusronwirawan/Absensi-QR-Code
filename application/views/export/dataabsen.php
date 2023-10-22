<html>

<head>
    <style>
        html {
            font-size: 10px;
        }

        body {
            font-family: sans-serif;
            font-size: 1em;
            line-height: 1.4;
            color: #444;
        }

        .hadir {
            background-color: green;
        }

        .libur {
            background-color: red;
        }

        th {
            background-color: yellow;
        }

        main {
            max-width: 1600px;
            margin: 0 auto;
        }

        .table-wrapper {
            overflow: auto;
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        .table-siswa,
        .table-date {
            border-collapse: collapse;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .table-siswa td {
            border: 1px solid silver;
            position: relative;
            padding: 2px;
        }

        .td-date .date {
            display: inline-block;
            width: 20px;
        }

        .label-checkbox {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 100%;
            display: block;
            background: #cecece;
        }

        .label-checkbox:hover {
            background: #bff8ff;
        }

        .label-checkbox input {
            margin: 0;
            -webkit-appearance: none;
            height: 100%;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            width: 100%;
            border: 0;
            cursor: pointer;
            outline: none;
        }

        .label-checkbox.active,
        .label-checkbox.active input,
        .label-checkbox input:checked {
            background: #2196F3;
        }

        .label-checkbox.active::before {
            content: "✓";
            display: block;
            position: absolute;
            z-index: 5;
            color: #fff;
            top: 15%;
            left: 35%;
        }


        .box-color {
            display: inline-block;
            width: 1em;
            height: 1em;
            vertical-align: middle;
        }

        .box-color.true {
            background: #2196F3;
        }

        .box-color.false {
            background: #cecece;
        }
    </style>
</head>
<?php
$sqlsabtu = "SELECT status FROM tabel_libur WHERE type = 'weekend' AND keterangan = 'sabtu' ";
$sabtu = $this->db->query($sqlsabtu)->result_array()[0]['status'];
$sqlminggu = "SELECT status FROM tabel_libur WHERE type = 'weekend' AND keterangan = 'minggu' ";
$minggu = $this->db->query($sqlminggu)->result_array()[0]['status'];


?>

<body>
    <main>
        <?php
        function encode_img_base64($img_path = false, $img_type = 'png')
        {
            if ($img_path) {
                //convert image into Binary data
                $img_data = fopen($img_path, 'rb');
                $img_size = filesize($img_path);
                $binary_image = fread($img_data, $img_size);
                fclose($img_data);

                //Build the src string to place inside your img tag
                $img_src = "data:image/" . $img_type . ";base64," . str_replace("\n", "", base64_encode($binary_image));

                return $img_src;
            }

            return false;
        }
        $path = './assets/images/logo.png';
        $logo = encode_img_base64($path);

        isset($_GET['bulan']) ? $bulan = nama_bulan($_GET['bulan']) : $bulan = nama_bulan(date('m'));
        $kelas = $_GET['kelas'];
        $jurusann = $_GET['jurusan'];
        $jurusannya = $this->db->query("SELECT * FROM tabel_jurusan WHERE id_jurusan = '$jurusann' ")->result_array()[0]['jurusan'];
        ?>
        <div>
            <table width="100%">
                <tr>
                    <td width="80" align="left"><img src="<?= $logo ?>" width="100%"></td>
                    <td width="80" align="center">
                        <h1><?= WEBNAME ?></h1>
                        <h2>Catatan Absen Kelas <?= $kelas . ' ' . $jurusannya . ' Bulan ' . $bulan ?> </h2>
                    </td>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="table-siswa" border="8" cellpadding="5">

                <thead>
                    <tr>

                        <th rowspan=" 2">No</th>
                        <th rowspan=" 2">Nomor induk siswa</th>
                        <th rowspan=" 2">Nama</th>
                        <th rowspan="2">L/P</th>
                        <?php for ($tanggal_table = 1; $tanggal_table <= 31; $tanggal_table++) {
                            echo "<th rowspan='2'>$tanggal_table</th>";
                        } ?>
                        <th colspan="4">jumlah</th>
                    </tr>
                    <tr class="table-row-head">
                        <th>A</th>
                        <th>I</th>
                        <th>S</th>
                        <th>T</th>
                    </tr>
                </thead>
                <tbody class="table-body-content">
                    <?php $no = 1; ?>
                    <?php foreach ($siswa as $d) :  ?>

                        <tr>
                            <td><?= $no++ ?></td>
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
                            $jurusann = $d['kode_jurusan'];
                            $cari_bulan_siswa = date('m');
                            $tahun = date('Y');
                            if (isset($_GET['bulan']) && isset($_GET['kelas'])) {
                                $bulan = $_GET['bulan'];
                                $kelas = $_GET['kelas'];
                                $jurusann = $_GET['jurusan'];
                                $sql = "SELECT * FROM tabel_detail_absen WHERE nis = '$nis' AND kode_kelas = '$kelas' AND kode_jurusan = '$jurusann' AND tanggal_absen LIKE '%$tahun-$bulan%' ORDER BY tanggal_absen ASC";
                            } else {
                                $sql = "SELECT * FROM tabel_detail_absen WHERE nis = '$nis' AND  kode_kelas = '$kelass' AND kode_jurusan = '$jurusann' AND tanggal_absen LIKE '%$tahun-$cari_bulan_siswa%' ORDER BY tanggal_absen ASC";
                                $bulan = date('m');
                            }
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

                                        // cek libur
                                        $sqllibur = "SELECT * FROM tabel_libur WHERE tanggal = '$tahun-$bulan-$tgl' AND status = 'Aktif'";
                                        $datalibur = $this->db->query($sqllibur)->result_array();

                                        //

                                        if ($nomor == $ambil_tanggal[2]) {

                                            if (count($datalibur) > 0) {
                                                echo '<td class="libur">' . $datalibur[0]['keterangan'] . '</td>';
                                            } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                                echo '<td class="libur"></td>';
                                            } else {
                                                if ($absen['keterangan'] == 'h') {
                                                    if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                        echo '<td class="hadir"></td>';
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
                                    if ($td == $tgl) {

                                        if (count($datalibur) > 0) {
                                            echo '<td class="libur">' . $datalibur[0]['keterangan'] . '</td>';
                                        } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                            echo '<td class="libur"></td>';
                                        } else {
                                            if ($absen['keterangan'] == 'h') {
                                                if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                    echo '<td class="hadir"></td>';
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
                                    $tgl < 10 ? $tgl2 = '0' . $tgl : $tgl2 = $tgl;
                                    $tanggal = date('Y') . '-' . $bulan . '-' . $tgl2;
                                    $hari = date('D', strtotime($tanggal));
                                    // cek libur
                                    $sqllibur = "SELECT * FROM tabel_libur WHERE tanggal = '$tahun-$bulan-$tgl' AND status = 'Aktif'";
                                    $datalibur = $this->db->query($sqllibur)->result_array();

                                    //


                                    if ($td == $tgl) {
                                        if (count($datalibur) > 0) {
                                            echo '<td class="libur">' . $datalibur[0]['keterangan'] . '</td>';
                                        } else if ($hari == 'Sun' && $minggu == 'Aktif' || $hari == 'Sat' && $sabtu == 'Aktif') {
                                            echo '<td class="libur"></td>';
                                        } else {
                                            if ($absen['keterangan'] == 'h') {
                                                if ($absen['masuk'] == 1 && $absen['keluar'] == 1) {
                                                    echo '<td class="hadir"></td>';
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
    </main>
</body>



</html>