<?php

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('student/M_auth');
        if (!$this->session->userdata('id_siswa')) {
            redirect(base_url() . 'student/auth');
        }
        if ($this->session->userdata('level') != 'siswa') {
            echo 'Anda tidak diizinkan untuk akses halaman ini';
            exit;
        }
    }

    // dashboard admin
    public function index()
    {
        $this->load->helper('sf_helper');

        $datauser = array_merge($this->M_auth->getUserByNis($this->session->userdata('nis'))[0], ['level' => $this->session->userdata('level')]);

        $this->load->model('M_absensi');
        $data = [
            'title' => WEBNAME . 'Siswa Dashboard',
            'user' => $datauser,
            'webname' => WEBNAME,
            'cekliburnasional' => $this->M_absensi->cekliburnasional(date('Y-m-d')),
            'cekliburweekend' => $this->M_absensi->cekstatusweekend(strtolower(hari_ini()))
        ];

        $this->load->view('student/templates/header', $data);
        $this->load->view('student/dashboard/index');
        $this->load->view('student/templates/footer');
    }
}
