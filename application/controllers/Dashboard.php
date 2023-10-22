<?php

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'auth');
        }
    }

    // dashboard admin
    public function index()
    {
        $this->load->helper('sf_helper');
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        // if ($datauser['role_id'] != 1) {
        //     echo 'Anda tidak diizinkan untuk akses halaman ini';
        //     exit;
        // }
        $data = [
            'title' => WEBNAME . 'User Dashboard',
            'user' => $datauser,
            'webname' => WEBNAME,

        ];

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/admin');
        $this->load->view('templates/footer');
    }
}
