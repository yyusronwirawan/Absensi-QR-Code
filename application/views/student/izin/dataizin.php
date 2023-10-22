<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Izin</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data izin</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Data izin <?= $user['nama_siswa']; ?></p>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th class="width80">No</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($dataizin as $d) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <?php
                                        $num = explode('-', $d['tanggal_izin']);
                                        ?>
                                        <td><?= $num[2] . ' ' . nama_bulan($num[1]) . ' ' . $num[0] ?></td>
                                        <td><span class="badge light badge-<?= $d['status'] == 'Diterima' ? 'success' : 'warning' ?>"><?= $d['status'] ?></span></td>
                                        <td>
                                            <button class="btn-md btn btn-primary detailizin" data-toggle="modal" idizin="<?= $d['id'] ?>" data-target="#modalketerangan"> <i class="flaticon-381-view-2"></i> </button>
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

<div class="modal fade bd-example-modal-lg" id="modalketerangan">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formdetailizin" method="POST">
                    <div class="form-row">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                        <input type="hidden" name="id_izin" class="id_izin" id="id_izin">
                        <div class="form-group col-md-12">
                        </div>

                        <div class="form-group col-md-12 form2">
                            <label class="labelkelas">Izin Untuk tanggal</label>
                            <input type="text" class="form-control" id="tanggalizin" readonly>
                            <label class="labelkelas">Alasan Izin</label>
                            <input type="text" class="form-control" id="alasanizin" readonly>
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
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('.detailizin').click(function() {
        let idizin = $(this).attr('idizin');
        console.log('okokoko')
        console.log(idizin);
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>ajax/tampilizin",
            data: {
                idizin: idizin,
            },
            dataType: 'json',
            success: function(data) {
                $('.buttonnya').html(`<p class="badge badge-secondary">Permintaan Izin Ini sudah ${data.status}</p>`)
                $('.bukti_izin').html(`<img src="<?= base_url() ?>assets/images/izinsiswa/${data.file_bukti}">`)
                $('.modal-title').html(`Data Izin ${data.nama_siswa}`)
                $('#keterangan_izin').html(`${data.keterangan}`);
                $('#id_izin').attr('value', idizin);
                $('#alasanizin').attr('value', data.type);
                $('#tanggalizin').attr('value', data.tanggal_indonesia);

            },
            error: function() {
                $('.modal-body').html('Kesalahan system')
            }
        });
    })
</script>