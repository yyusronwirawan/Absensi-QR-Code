	<!--**********************************
          Bagian  Content body start
        ***********************************-->
	<?php
	$jam = date("G");
	if ($jam >= 0 && $jam <= 11)
		$sapa = "Selamat Pagi";
	else if ($jam >= 12 && $jam <= 15)
		$sapa = "Selamat Siang";
	else if ($jam >= 16 && $jam <= 18)
		$sapa = "Selamat Sore";
	else if ($jam >= 19 && $jam <= 23)
		$sapa = "Selamat Malam";
	?>

	<div class="content-body">
		<!-- row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-white  mb-4">
						<div class="card-body">
							<h3><span class="flaticon-381-alarm-clock"></span> Hari Ini</h3>
							<div id="date-and-clock mt-3">
								<h4 id="clocknow"></h4>
								<h4 id="datenow"></h4>
							</div>
							</h6>
						</div>
						<div class="card-footer d-flex align-items-center justify-content-between">

							<div class="small text-primary"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-9 ">
					<div class="card border-0 pb-0">
						<div class="card-header border-0 pb-0">
							<?php
							$thbulan = date('Y') . '-' . date('m');
							$querycekizin = "SELECT * FROM tabel_izin JOIN tabel_siswa on tabel_siswa.nis = tabel_izin.nis_siswa WHERE tanggal_izin LIKE '%$thbulan%' ORDER BY tanggal_izin DESC LIMIT 10";
							$izin = $this->db->query($querycekizin)->result_array();

							?>
							<h4 class="card-title">Permintaan izin bulan ini</h4>
							<a href="<?= base_url('izin') ?>" class="btn-sm btn btn-primary"> <span class="flaticon-381-view"></span> Lihat semua</a>
						</div>
						<div class="card-body">
							<div id="DZ_W_Todo3" class="widget-media dz-scroll height200">
								<?php if (count($izin) == 0) { ?>
									<h3 class="text-center text-primary m-auto">Tidak ada izin bulan ini</h1>
									<?php } else { ?>
										<ul class="timeline">
											<?php foreach ($izin as $i) : ?>
												<li>
													<div class="timeline-panel">
														<div class="media mr-2">
															<img alt="image" width="50" src="<?= base_url() ?>assets/images/user/<?= $i['gambar']; ?>?>">
														</div>
														<div class="media-body">
															<h5 class="mb-1"><?= $i['nama_siswa'] ?> <small class="text-muted"><?= $i['tanggal_izin'] ?></small></h5>
															<p class="mb-1"><?= substr($i['keterangan'], 1, 70) ?>....</p>
															<!-- <a href="#" class="btn btn-primary btn-xxs shadow">Lihat</a> -->
															<p class="badge badge-secondary"><?= $i['status'] ?></p>
														</div>
													</div>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-12 col-xxl-12">
					<div class="row">
						<div class="col-xl-4 col-lg-6 col-sm-6">
							<div class="widget-stat card bg-primary">
								<div class="card-body  p-4">
									<div class="media">
										<span class="mr-3">
											<i class="la la-users"></i>
										</span>
										<div class="media-body text-white">
											<p class="mb-1">Jumlah Siswa</p>
											<h3 class="text-white"><?= $this->db->query("SELECT * FROM tabel_siswa")->num_rows() ?></h3>
											<div class="progress mb-2 bg-secondary">
												<div class="progress-bar progress-animated bg-light" style="width: 100%"></div>
											</div>
											<small>Seluruh siswa aktif dan tidak aktif</small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-6 col-sm-6">
							<div class="widget-stat card bg-warning">
								<div class="card-body p-4">
									<div class="media">
										<span class="mr-3">
											<i class="la la-user"></i>
										</span>
										<div class="media-body text-white">
											<p class="mb-1">Jumlah Pengguna</p>
											<?php
											$akunpetugas = $this->db->query("SELECT * FROM tabel_user")->num_rows();
											$akunsiswa = $this->db->query("SELECT * FROM login_siswa")->num_rows();
											?>
											<h3 class="text-white"><?= $akunpetugas + $akunsiswa ?></h3>
											<div class="progress mb-2 bg-primary">
												<div class="progress-bar progress-animated bg-light" style="width: 50%"></div>
											</div>
											<small><?= $akunpetugas . ' Akun staff' . ' dan ' . $akunsiswa . ' Akun siswa' ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-6 col-sm-6">
							<div class="widget-stat card bg-secondary">
								<div class="card-body p-4">
									<div class="media">
										<span class="mr-3">
											<i class="la la-graduation-cap"></i>
										</span>
										<div class="media-body text-white">
											<p class="mb-1">Jumlah Kelas</p>
											<h3 class="text-white"><?= $this->db->query("SELECT * FROM tabel_kelas")->num_rows() ?></h3>
											<div class="progress mb-2 bg-primary">
												<div class="progress-bar progress-animated bg-light" style="width: 76%"></div>
											</div>
											<small>dari <?= $this->db->query("SELECT * FROM tabel_jurusan")->num_rows() . ' Jurusan' ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>


			</div>
		</div>
	</div>
	<!--**********************************
          Akhir  Content body end
        ***********************************-->
	<script type='text/javascript'>
		function currentTime() {
			var date = new Date(); /* creating object of Date class */
			var hour = date.getHours();
			var min = date.getMinutes();
			var sec = date.getSeconds();
			hour = updateTime(hour);
			min = updateTime(min);
			sec = updateTime(sec);
			document.getElementById("clocknow").innerText = hour + " : " + min + " : " + sec; /* adding time to the div */

			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

			var curWeekDay = days[date.getDay()]; // get day
			var curDay = date.getDate(); // get date
			var curMonth = months[date.getMonth()]; // get month
			var curYear = date.getFullYear(); // get year
			var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear; // get full date
			document.getElementById("datenow").innerHTML = date;

			var t = setTimeout(function() {
				currentTime()
			}, 1000); /* setting timer */
		}

		function updateTime(k) {
			if (k < 10) {
				return "0" + k;
			} else {
				return k;
			}
		}

		if (document.getElementById("clocknow")) {
			currentTime(); /* calling currentTime() function to initiate the process */
		}
	</script>