<?php

class Izin extends CI_Controller
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
        $this->load->model('M_izin');
        $this->load->model('M_kelas');
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
        // var_dump($this->M_izin->tampilDataIzinBulanIni());
        // die;
        $data = [
            'title' => WEBNAME . ' Semua Izin',
            'webname' => WEBNAME,
            'user' => $datauser,
            'kelas' => $this->M_kelas->tampilkelas(),
            'dataizin' => $this->M_izin->tampilDataIzinBulanIni()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('izin/semuaizin');
        $this->load->view('templates/footer');
    }
}
