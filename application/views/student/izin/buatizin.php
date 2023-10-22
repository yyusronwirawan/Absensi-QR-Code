<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Izin</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Request</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <?php if ($this->session->flashdata('flash')) : ?>
                    <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible alert-alt fade show my-4 mx-5">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <strong><?= $this->session->flashdata('flash')['alert'] ?>!</strong> <?= $this->session->flashdata('flash')['message']; ?>.
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Permintaan Tidak Masuk </h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('student/izin/kirimpermintaan') ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" id="">
                            <div class="form-group">
                                <label for="">Alasan Tidak Masuk</label>
                                <select class="form-control" name="alasan" id="alasan">
                                    <option value="" disabled selected>Pilih alasan..</option>
                                    <option value="Sakit">sakit</option>
                                    <option value="Izin">izin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="bukti">Bukti</label>
                                <input class="form-control" type="file" name="bukti" id="bukti">
                                <span class="text-small text-danger">Input foto bukti </span>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn-sm btn btn-secondary">Kirim Permintaan Izin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>