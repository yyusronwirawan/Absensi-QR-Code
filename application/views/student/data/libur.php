	<!--**********************************
          Bagian  Content body start
        ***********************************-->
	<div class="content-body">
	    <!-- row -->
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-xl-12 col-xxl-12">

	                <div class="alert alert-warning alert-dismissible fade show">
	                    <strong>INFORMASI</strong> Data libur ini bukan berdasarkan libur nasional di kalender, Tapi berdasarkan libur yang di tentukan oleh admin / guru atau kordinator sekolah.
	                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
	                    </button>
	                </div>
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header">
	                                <p class="card-title">Data libur Bulan <?= nama_bulan(date('m')); ?> <?= date('Y') ?> </p>
	                            </div>
	                            <div class="card-body">
	                                <div class="table-responsive">

	                                    <table id="example" class="display min-w850">
	                                        <thead>
	                                            <tr>
	                                                <th>Tanggal</th>
	                                                <th>Keterangan</th>

	                                            </tr>
	                                        </thead>
	                                        <tbody>
	                                            <?php foreach ($datalibur as $d) : ?>
	                                                <tr>
	                                                    <?php
                                                        $tanggal = explode('-', $d['tanggal'])[1];
                                                        ?>
	                                                    <td><span class="badge light badge-secondary"><?= $tanggal . ' ' . nama_bulan(date('m')) ?></span></td>
	                                                    <td><span class="badge light badge-secondary"><?= $d['keterangan']; ?></span></td>
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
	    </div>
	</div>
	<!--**********************************
          Akhir  Content body end
        ***********************************-->