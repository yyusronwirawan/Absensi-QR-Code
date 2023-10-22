<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student/M_auth');
        $this->load->model('M_siswa');
    }
    public function index()
    {
        if ($this->session->userdata('id_siswa') && $this->session->userdata('level') == 'siswa') {
            redirect(base_url() . 'student/dashboard');
        } else {
            $this->load->view('student/auth/login');
        }
    }

    public function linked_account()
    {
        $this->load->view('student/auth/linked');
    }
    public function linked_proccess()
    {
        if (!$this->uri->segment(4)) {
            $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 1']);
        } else {
            $kodeunik = $this->uri->segment(4);
            $nis = explode('=', base64_decode($kodeunik))[0];
            $tanggal = explode('=', base64_decode($kodeunik))[1];

            if ($this->M_auth->cekkodeunik($kodeunik, $nis) < 1) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 2']);
            } else if (date('Y-m-d') != $tanggal) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 3']);
            } else {
                $data = [
                    'datasiswa' => $this->M_siswa->dataspesifiksiswa($nis)[0]
                ];
                $this->load->view('student/auth/linked_proccess', $data);
            }
        }
    }

    public function verif_email()
    {
        if (!$this->uri->segment(4)) {

            $this->load->view('student/auth/verifemail');
        } else {
            $kodeunik = $this->uri->segment(4);
            // var_dump(base64_decode('=', $kodeunik));
            $nis = explode('=', base64_decode($kodeunik))[0];
            $tanggal = explode('=', base64_decode($kodeunik))[1];
            if ($this->M_auth->cekkodeunik($kodeunik, $nis) < 1) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 2']);
            } else if (date('Y-m-d') != $tanggal) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 3']);
            } else {
                $this->M_auth->aktifkanuser($nis);
                $this->M_auth->resetkodeunik($nis);
                $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Akun berhasil di aktifkan, silahkan login']);
                redirect(base_url('student/auth'));
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
       Anda Berhasil Logout !
     </div>');
        redirect('student/auth');
    }
}
