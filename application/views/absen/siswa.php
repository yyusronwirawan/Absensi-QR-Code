<!DOCTYPE html>
<html lang="en">

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

<body>




    <script src="<?= base_url(); ?>assets/js/instascan.min.js"></script>

    <!-- row -->


    <div class="container-fluid">
        <div class="page-titles">

        </div>


        <div class="row">

            <div class="col-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Absen</h4>
                    </div>
                    <div class="card-body" id="bodybody">
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
                        <video src="" id="view" height="500"></video>
                        <div id="info" class="text-center"></div>
                        <div class="informasi text-center"></div>
                    </div>
                </div>
            </div>
            <div class="col-5">
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
    <script>
        function carouselReview() {
            /*  testimonial one function by = owl.carousel.js */
            jQuery('.testimonial-one').owlCarousel({
                loop: true,
                autoplay: true,
                margin: 30,
                nav: false,
                dots: false,
                left: true,
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    484: {
                        items: 2
                    },
                    882: {
                        items: 3
                    },
                    1200: {
                        items: 2
                    },

                    1540: {
                        items: 3
                    },
                    1740: {
                        items: 4
                    }
                }
            })
        }
        jQuery(window).on('load', function() {
            setTimeout(function() {
                carouselReview();
            }, 1000);
        });
    </script>

</body>

</html>
<script type="text/javascript">
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
    var now = new Date().getTime();
    var jammasuk = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenmasuk ?>`).getTime();
    var akhirmasuk = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenberakhirmasuk ?>`).getTime();
    var keluar = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $absenkeluar ?>`).getTime();
    var akhirkeluar = new Date(`${bulan2} ${tanggal}, ${tahun} <?= $akhirkeluar ?>`).getTime();

    //  var countDownDate = new Date("Sep 23, 2021 17:00:25").getTime();

    if (now >= jammasuk && now < akhirmasuk) {
        let scanner = new Instascan.Scanner({
            video: document.getElementById('view')
        });
        scanner.addListener('scan', function(content) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>/ajax/inputabsen",
                data: {
                    nis: content,
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
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
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
        let scanner = new Instascan.Scanner({
            video: document.getElementById('view')
        });
        scanner.addListener('scan', function(content) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>/ajax/inputabsen",
                data: {
                    nis: content,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'false') {
                        $('.fotoprofil').html(`<h1 class="text-${data.alert} text-center mt-4">${data.message}</h1>`);
                        $('.namasiswa').html('');
                        $('.tanggal').html('');
                    } else if (data.status == 'true') {
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
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
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


    // // Update the count down every 1 second
    // var x = setInterval(function() {

    //     //     // Get today's date and time
    //     var now = new Date().getTime();

    //     //     // Find the distance between now and the countdown date
    //     var distance = countDownDate - now;

    //     //     // Calculate Remaining Time
    //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    //     //     // Display the result in the element with id="demo"
    //     document.getElementById("bodybody").innerHTML = days + " Hari " + hours + " Jam " +
    //         minutes + " Menit " + seconds + " Detik ";

    //     //     // If the countdown is finished, write some text
    //     if (distance < 0) {
    //         clearInterval(x);
    //         document.getElementById("bodybody").innerHTML = "EXPIRED";
    //     }
    // }, 1000);
</script>