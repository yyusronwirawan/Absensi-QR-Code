<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Absen</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/images/favicon.png">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/chartist/css/chartist.min.css">
        <link href="<?= base_url(); ?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
        <link type="text/css" href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <!-- Datatable -->
        <link href="<?= base_url(); ?>assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

    </head>
</head>

<body>
    <div class="container-fluid">
        <div class="page-titles">

        </div>


        <div class="row">

            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Absen</h4>
                        <b>Pilih camera:</b>
                        <select id="cam-list">
                            <option value="environment" selected>Default</option>

                        </select>
                    </div>
                    <div class="card-body " id="bodybody">
                        <div class="embed-responsive embed-responsive-21by9">
                            <video src="" id="qr-video"></video>
                        </div>
                        <?php
                        $sqlmasuk = "SELECT * FROM tabel_jam_absen WHERE type = 'Masuk' ";
                        $sqlkeluar = "SELECT * FROM tabel_jam_absen WHERE type = 'Keluar' ";
                        $sqlterlambat = "SELECT * FROM tabel_jam_absen WHERE type = 'Terlambat' ";
                        $masuk = $this->db->query($sqlmasuk)->result_array();
                        $keluar = $this->db->query($sqlkeluar)->result_array();
                        $terlambat = $this->db->query($sqlterlambat)->result_array();

                        //   $datajam = $q->fetch_assoc();
                        $jamskarang = date('H:i:s');
                        $absenmasuk = $masuk[0]['mulai'];
                        $absenberakhirmasuk = $masuk[0]['selesai'];
                        $absenkeluar = $keluar[0]['mulai'];
                        $akhirkeluar = $keluar[0]['selesai'];
                        // $absensiberakhirkeluar = '15:30:00';
                        $telatmasuk = $terlambat[0]['selesai'];


                        ?>
                        <div id="info" class="text-center mt-2"></div>
                        <div class="informasi text-center mt-2"></div>
                    </div>
                </div>
            </div>




            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Hasil <span class="textberhasil text-success"> </span></h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="fotoprofil text-center">

                        </div>
                        <div class="infoabsen mt-3">
                            <h2 class="namasiswa"></h2>
                            <h4 class="tanggal"></h4>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>





    <!--**********************************
            Content body start
        ***********************************-->

    <!--**********************************
            Content body end
        ***********************************-->

    <!--**********************************
            Footer start
        ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2020</p>
        </div>
    </div>
    <!--**********************************
            Footer end
        ***********************************-->

    <!--**********************************
           Support ticket button start
        ***********************************-->

    <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url(); ?>assets/vendor/global/global.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/custom.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/deznav-init.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/owl-carousel/owl.carousel.js"></script>

    <!-- Chart piety plugin files -->
    <script src="<?= base_url(); ?>assets/vendor/peity/jquery.peity.min.js"></script>

    <!-- Apex Chart -->
    <script src="<?= base_url(); ?>assets/vendor/apexchart/apexchart.js"></script>

    <!-- Dashboard 1 -->
    <script src="<?= base_url(); ?>assets/js/dashboard/dashboard-1.js"></script>

    <!-- Datatable -->
    <script src="<?= base_url(); ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins-init/datatables.init.js"></script>

    <script type="module">
        import QrScanner from "<?= base_url() ?>assets/js/qr-scanner.min.js";
        QrScanner.WORKER_PATH = '<?= base_url() ?>assets/js/qr-scanner-worker.min.js';

        const video = document.getElementById('qr-video');
        const camList = document.getElementById('cam-list');

        function bulan($bulan) {
            if ($bulan == 0) {
                return 'Januari'
            } else if ($bulan == 1) {
                return 'Februari'
            }
            if ($bulan == 2) {
                return 'Maret'
            }
            if ($bulan == 3) {
                return 'April'
            }
            if ($bulan == 4) {
                return 'Mei'
            }
            if ($bulan == 5) {
                return 'Juni'
            }
            if ($bulan == 6) {
                return 'Juli'
            }
            if ($bulan == 7) {
                return 'Agustus'
            }
            if ($bulan == 8) {
                return 'September'
            }
            if ($bulan == 9) {
                return 'Oktober'
            }
            if ($bulan == 10) {
                return 'November'
            }
            if ($bulan == 11) {
                return 'Desember'
            }
        }
        let r = new Date();
        // Set a valid end date
        const bulan2 = r.toLocaleString('default', {
            month: 'short'
        });
        const tanggal = r.getDate();
        const tahun = r.getFullYear();
        //const jammasuk = `"${bulan2} ${tanggal}, ${tahun} 07:00:00"`
        const now = new Date().getTime();
        const jammasuk = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenmasuk ?>`).getTime();
        const akhirmasuk = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenberakhirmasuk ?>`).getTime();
        const keluar = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenkeluar ?>`).getTime();
        const akhirkeluar = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $akhirkeluar ?>`).getTime();



        function setResult(result) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>/ajax/inputabsen",
                data: {
                    nis: result,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'false') {
                        $('.fotoprofil').html(`<h1 class="text-${data.alert} text-center mt-4">${data.message}</h1>`);
                        $('.namasiswa').html('');
                        $('.tanggal').html('');
                    } else if (data.status == 'true') {
                        console.log(data);
                        let image = data['gambar'];
                        let tanggal = `${r.getDate()} ${bulan(r.getMonth())} ${r.getFullYear()} - ${r.getHours()}:${r.getMinutes()}:${r.getSeconds()}`;
                        $('.textberhasil').html('Berhasil absen');
                        $('.fotoprofil').html(
                            `<img src="<?= base_url() ?>assets/images/user/${image}" alt="" width="300" height="300">`
                        );
                        $('.namasiswa').html(data['nama_siswa']);
                        $('.tanggal').html(tanggal);
                    }
                },
                error: function() {
                    console.log('kesalahan system')
                }
            });
        }

        // ####### Web Cam Scanning #######

        const scanner = new QrScanner(video, result => setResult(result), error => {

        });



        // for debugging
        window.scanner = scanner;
        camList.addEventListener('change', event => {
            scanner.setCamera(event.target.value);
        });



        if (now >= jammasuk && now < akhirmasuk) {
            scanner.start().then(() => {
                QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
                    const option = document.createElement('option');
                    option.value = camera.id;
                    option.text = camera.label;
                    camList.add(option);
                }));
            });
            var x = setInterval(function() {
                //     // ambil hari sekarang
                var now = new Date().getTime();
                var distance = akhirmasuk - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $('.informasi').html(`<h1>Silahkan absen masuk,Berlaku  ${hours} Jam ${minutes} Menit ${seconds} detik Lagi</h1>`)
                // document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
                //     minutes + " Menit " + seconds + " Detik ";
                if (distance < 0) {
                    clearInterval(x);
                    window.location.reload();
                }
            }, 1000);
        } else if (now > akhirmasuk && now < keluar) {
            scanner.stop();
            var x = setInterval(function() {
                //     // ambil hari sekarang
                var now = new Date().getTime();
                var distance = keluar - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $('.informasi').html(`<h1>Absen berakhir, Absen keluar ${hours} Jam ${minutes} Menit ${seconds} detik Lagi</h1>`)
                $('#view').hide()
                $('#info').html(`<img src="<?= base_url('assets/img/wapi-clock.gif') ?>">`)

                // document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
                //     minutes + " Menit " + seconds + " Detik ";
                if (distance < 0) {
                    clearInterval(x);
                    window.location.reload();
                }
            }, 1000);
        } else if (now > keluar && now < akhirkeluar) {
            scanner.start().then(() => {
                QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
                    const option = document.createElement('option');
                    option.value = camera.id;
                    option.text = camera.label;
                    camList.add(option);
                }));
            });
            var x = setInterval(function() {
                //     // ambil hari sekarang
                var now = new Date().getTime();
                var distance = akhirkeluar - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $('.informasi').html(`<h1>Silahkan Absen Keluar, berlaku ${hours} Jam ${minutes} Menit ${seconds} detik Lagi</h1>`)
                // document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
                //     minutes + " Menit " + seconds + " Detik ";
                if (distance < 0) {
                    clearInterval(x);
                    window.location.reload();
                }
            }, 1000);
        } else if (now > keluar && now > akhirkeluar && now > akhirmasuk) {
            $('#view').hide()
            var x = setInterval(function() {
                //     // ambil hari sekarang
                const tgltgl = r.getDate() + 1;

                var jammasuk2 = new Date(`${bulan2} ${tgltgl}, ${tahun} 07:00:00`).getTime();
                var now = new Date().getTime();
                var distance = jammasuk2 - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $('.informasi').html(`<h1>Absen berakhir, Absen masuk ${hours} Jam ${minutes} Menit ${seconds} detik Lagi</h1>`)
                $('#info').html(`<img src="<?= base_url('assets/img/wapi-clock.gif') ?>">`)
                // document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
                //     minutes + " Menit " + seconds + " Detik ";
                if (distance < 0) {
                    clearInterval(x);
                    window.location.reload();
                }
            }, 1000);
        } else {
            $('#view').hide()
            $('#info').html(`<img src="<?= base_url('assets/img/wapi-clock.gif') ?>">`)
            var x = setInterval(function() {
                //     // ambil hari sekarang
                const tgltgl = r.getDate() + 1;

                var jammasuk2 = new Date(`${bulan2} ${tgltgl}, ${tahun} 07:00:00`).getTime();
                var now = new Date().getTime();
                var distance = jammasuk2 - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $('.informasi').html(`<h1>Absen berakhir, Absen masuk ${hours} Jam ${minutes} Menit ${seconds} detik Lagi</h1>`)
                // document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
                //     minutes + " Menit " + seconds + " Detik ";
                if (distance < 0) {
                    clearInterval(x);
                    window.location.reload();
                }
            }, 1000);
        }
    </script>