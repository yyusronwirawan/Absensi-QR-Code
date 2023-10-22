<?php

class Absen extends CI_Controller
{

    private $bulan = [
        '01' => 'JANUARI',
        '02' => 'FEBRUARI',
        '03' => 'MARET',
        '04' => 'APRIL',
        '05' => 'MEI',
        '06' => 'JUNI',
        '07' => 'JULI',
        '08' => 'AGUSTUS',
        '09' => 'SEPTEMBER',
        '10' => 'OKTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DESEMBER',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_absensi');
        $this->load->model('M_kelas');
        $this->load->model('M_siswa');
        $this->load->library('form_validation');
        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'auth');
        }
    }

    // view index
    public function index()
    {


        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        verifikasiuser($datauser['role_id'], $this->uri->segment(1));
        $namabulan = $this->bulan;
        // untuk pencarian 
        if ($this->input->get('cariabsen') != FALSE) {
            // deklarasi yang di cari
            $idkelas = $this->input->get('kelas');
            $idjurusan = $this->input->get('jurusan');
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');
            // pencarian dengan nis
            if ($this->input->get('nis') != FALSE) {
                $nis = $this->input->get('nis');
                $datasiswa = $this->M_absensi->CariSiswa($nis, $idkelas, $idjurusan);
                // deskripsi pencarian dengan nis
                $desc = 'NIS ' . $nis . ' ( ' . $namabulan[$bulan] . ' ' . $tahun . ' )';
            } else {
                // pencarian tanpa nis
                $datasiswa = $this->M_absensi->dataSiswaByKelas($idkelas, $idjurusan);
                // deskripsi pencarian tanpa nis
                $desc = 'Kelas ' . $this->M_kelas->ambilkelas($idkelas)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan($idjurusan)[0]['jurusan'] . ' ( ' . $namabulan[$bulan] . ' ' . date('Y') . ' )';
            }
        } else {
            // deskripsi
            $desc = 'Kelas ' . $this->M_kelas->ambilkelas(1)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan(1)[0]['jurusan'] . ' ( ' . $namabulan[date('m')] . ' ' . date('Y') . ' )';
            // defaul bulan dan kelas yang ditampilkan
            $datasiswa = $this->M_absensi->dataSiswaByKelas(1, 1);
            // $dataabsen = $this->M_absensi->dataabsensi();
        }
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'kelas' => $this->M_kelas->tampilkelas(),
            'jurusan' => $this->M_kelas->tampiljurusan(),
            'siswa' => $datasiswa,
            'desc' => $desc,
            'user' => $datauser
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('absen/index');
        $this->load->view('templates/footer');
    }

    public function input()
    {

        $tanggal = $this->input->post('tgltahun');
        // $type = $this->input->post('tipe');
        // cek libur nasional 
        $c =  $this->M_absensi->cekliburnasional($tanggal);
        $sabtu = $this->M_absensi->cekstatusweekend('sabtu');
        $minggu = $this->M_absensi->cekstatusweekend('minggu');

        //$tgl = explode('-', $tanggal)[2];
        if (date('D', strtotime($tanggal)) == 'Sun' && $minggu[0]['status'] == 'Aktif') {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Tanggal tersebut adalah hari libur Weekend Minggu']);
        } else if (date('D', strtotime($tanggal)) == 'Sat' && $sabtu[0]['status'] == 'Aktif') {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Tanggal tersebut adalah hari libur Weekend Sabtu']);
        } else   if ($c > 0) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Tanggal tersebut adalah hari libur nasional']);
        } else {
            foreach ($this->input->post('nis') as $n) {
                $siswa = $this->M_siswa->dataspesifiksiswa($n)[0];
                if ($this->input->post('aksi') == 'baru') {
                    $cekabsen = $this->db->query("SELECT * FROM tabel_detail_absen WHERE nis = '$n' AND tanggal_absen = '$tanggal' ");
                    if ($cekabsen->num_rows() < 1) {
                        $this->M_absensi->inputabsen($siswa['nis'], $siswa['kode_kelas'], $siswa['kode_jurusan']);
                        $message = 'Berhasil Absen';
                    } else {
                        $message = 'sudah ada data absen siswa pada tanggal tersebut, silahkan edit jika ingin mengubah';
                    }
                } else if ($this->input->post('aksi') == 'edit') {
                    // edit asen
                    $this->M_absensi->editabsen($siswa['nis'], $siswa['kode_kelas'], $siswa['kode_jurusan']);
                    $message = 'Berhasil edit absen';
                } else if ($this->input->post('aksi') == 'hapus') {
                    $this->M_absensi->hapusabsen($siswa['nis'], $siswa['kode_kelas'], $siswa['kode_jurusan']);
                    $message = 'Berhasil hapus absen';
                    // hapus absen
                }
            }
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => $message]);
        }
        $url = $this->input->post('url');

        redirect('http://' . $_SERVER['HTTP_HOST'] . $url);
    }



    public function exportabsen()
    {
        $namabulan = $this->bulan;
        // untuk pencarian 
        if ($this->input->get('cariabsen') != FALSE) {
            // deklarasi yang di cari
            $idkelas = $this->input->get('kelas');
            $idjurusan = $this->input->get('jurusan');
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');
            // pencarian dengan nis
            if ($this->input->get('nis') != FALSE) {
                $nis = $this->input->get('nis');
                $datasiswa = $this->M_absensi->CariSiswa($nis, $idkelas, $idjurusan);
                // deskripsi pencarian dengan nis
                $desc = 'NIS ' . $nis . ' ( ' . $namabulan[$bulan] . ' ' . $tahun . ' )';
            } else {
                // pencarian tanpa nis
                $datasiswa = $this->M_absensi->dataSiswaByKelas($idkelas, $idjurusan);
                // deskripsi pencarian tanpa nis
                $desc = 'Kelas ' . $this->M_kelas->ambilkelas($idkelas)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan($idjurusan)[0]['jurusan'] . ' ( ' . $namabulan[$bulan] . ' ' . date('Y') . ' )';
            }
        } else {
            // deskripsi
            $desc = 'Kelas ' . $this->M_kelas->ambilkelas(1)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan(1)[0]['jurusan'] . ' ( ' . $namabulan[date('m')] . ' ' . date('Y') . ' )';
            // defaul bulan dan kelas yang ditampilkan
            $datasiswa = $this->M_absensi->dataSiswaByKelas(100, 100);
            // $dataabsen = $this->M_absensi->dataabsensi();
        }
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'kelas' => $this->M_kelas->tampilkelas(),
            'jurusan' => $this->M_kelas->tampiljurusan(),
            'siswa' => $datasiswa,
            'desc' => $desc,
        ];

        $this->load->library('pdf');
        $this->pdf->setPaper('A3', 'landscape');
        $this->pdf->filename = "Data Absen " . $desc . ".pdf";
        $this->pdf->load_view('export/dataabsen', $data);
    }


    // rekap
    public function rekap()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        verifikasiuser($datauser['role_id'], $url);
        $namabulan = $this->bulan;
        // untuk pencarian 
        if ($this->input->get('cariabsen') != FALSE) {
            // deklarasi yang di cari
            $idkelas = $this->input->get('kelas');
            $idjurusan = $this->input->get('jurusan');
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');
            // pencarian dengan nis
            if ($this->input->get('nis') != FALSE) {
                $nis = $this->input->get('nis');
                $datasiswa = $this->M_absensi->CariSiswa($nis, $idkelas, $idjurusan);
                // deskripsi pencarian dengan nis
                $desc = 'NIS ' . $nis . ' ( ' . $namabulan[$bulan] . ' ' . $tahun . ' )';
            } else {
                // pencarian tanpa nis
                $datasiswa = $this->M_absensi->dataSiswaByKelas($idkelas, $idjurusan);
                // deskripsi pencarian tanpa nis
                $desc = 'Kelas ' . $this->M_kelas->ambilkelas($idkelas)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan($idjurusan)[0]['jurusan'] . ' ( ' . $namabulan[$bulan] . ' ' . date('Y') . ' )';
            }
        } else {
            // deskripsi
            $desc = 'Kelas ' . $this->M_kelas->ambilkelas(1)[0]['kelas'] . ' ' . $this->M_kelas->ambiljurusan(1)[0]['jurusan'] . ' ( ' . $namabulan[date('m')] . ' ' . date('Y') . ' )';
            // defaul bulan dan kelas yang ditampilkan
            $datasiswa = $this->M_absensi->dataSiswaByKelas(100, 100);
            // $dataabsen = $this->M_absensi->dataabsensi();
        }
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'kelas' => $this->M_kelas->tampilkelas(),
            'jurusan' => $this->M_kelas->tampiljurusan(),
            'siswa' => $datasiswa,
            'desc' => $desc,
            'user' => $datauser
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('absen/rekap');
        $this->load->view('templates/footer');
    }


    // page jam
    public function jam()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'user' => $datauser,
            'jamabsen' => $this->M_absensi->tampiljamabsen()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('absen/settingjam');
        $this->load->view('templates/footer');
    }
    public function editjamabsen()
    {
        $id = $this->input->post('id', true);
        $this->M_absensi->editjamabsen($id);
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'berhasil edit jam']);
        redirect(base_url('absen/jam'));
    }
    // end jam page
    // page libur
    public function libur()
    {

        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'user' => $datauser,
            'libur' => $this->M_absensi->tampillibur(),
            'liburweekend' => $this->M_absensi->tampilliburweekend()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('absen/settinglibur');
        $this->load->view('templates/footer');
    }
    public function tambahlibur()
    {
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required|min_length[5]|trim');
        if ($this->form_validation->run() !=  FALSE) {
            $this->M_absensi->tambahlibur();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'berhasil Tambah Libur']);
        } else {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Gagal menambahkan libur']);
        }
        redirect(base_url('absen/libur'));
    }
    public function editlibur()
    {
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required|min_length[5]|trim');
        if ($this->form_validation->run() !=  FALSE) {
            $this->M_absensi->editlibur();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'berhasil Edit Libur']);
        } else {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Gagal Edit libur']);
        }
        redirect(base_url('absen/libur'));
    }
    public function hapus_libur($id)
    {
        $id = base64_decode($id);
        $this->M_absensi->hapuslibur($id);
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'berhasil Hapus Libur']);
        redirect(base_url('absen/libur'));
    }
    // end libur page
}
