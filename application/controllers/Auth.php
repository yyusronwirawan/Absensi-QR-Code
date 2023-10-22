<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        //ini untuk membuat validasi dari sistemnya
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_user');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'valid_email' => 'Yang Anda Masukan Bukan Email',
            'required' => 'email Harus di isi'
        ]);
        $this->form_validation->set_rules('password1', 'password', 'required|trim', [
            'required' => 'Password Harus di isi'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/loginuser');
        } else {
            $email =  $this->input->post('email');
            $password = $this->input->post('password1');
            $user = $this->db->get_where('tabel_user', ['email' => $email])->result_array()[0];

            if ($user) {
                if ($user['is_active'] == 1) {
                    if (password_verify($password, $user['password'])) {
                        $this->session->set_userdata($user);
                        if ($user['role_id'] == 1) {
                            redirect(base_url('dashboard'));
                        }
                        if ($user['role_id'] == 2) {
                            redirect(base_url('User'));
                        } else {
                            redirect(base_url('dashboard'));
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Email atau Password salah!
                        </div>');
                        redirect('Auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Email Ini Belom di Aktivasi !
                    </div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
              Email atau password salah !
                </div>');
                redirect('Auth');
            }
        }
    }

    public function Regisration()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
            'required' => 'Nama Harus di isi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tabel_user.email]', [
            'is_unique' => 'Email ini sudah Pernah di daftarkan',
            'valid_email' => 'Yang Anda Masukan Bukan Email'
        ]);
        $this->form_validation->set_rules('password1', 'password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Konfirmasi password salah'
        ]);
        $this->form_validation->set_rules('password2', 'password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/registeruser');
        } else {
            //jika lolos masuk ke dalam database
            $kode_unik = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNn*^^%^%$^*&(*OoPpQqRrSsTtUuVvWwX&^&^%&^xYyZz"), 0, 20);

            $data =  [
                'name'     => htmlspecialchars($this->input->post('nama', true)),
                'email'    => htmlspecialchars($this->input->post('email', true)),
                'image'    => 'default.Jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id'  => 2,
                'is_active' => 0,
                'date_create' => date('Y-m-d'),
                'kode_unik' => $kode_unik


            ];
            $this->db->insert('tabel_user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Berhasil ! Daftar berhasil, silahkan verifikasi email terlebih dahulu !
           </div>');
            redirect('Auth');
        }
    }

    public function verif_email()
    {

        if (!$this->uri->segment(3)) {

            $this->load->view('auth/verif_email');
        } else {
            $kodeunik = $this->uri->segment(3);
            // var_dump(base64_decode('=', $kodeunik));
            $email = explode('=', base64_decode($kodeunik))[0];
            $tanggal = explode('=', base64_decode($kodeunik))[1];
            if ($this->M_user->cekkodeunik($kodeunik, $email) < 1) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 2']);
            } else if (date('Y-m-d') != $tanggal) {
                $this->load->view('errors/custom', ['pesanerror' => 'Link verifikasi tidak valid/kadaluarsa 3']);
            } else {
                $this->M_user->aktifkanuser($email);
                $this->M_user->resetkodeunik($email);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
             Berhasil ! Email berhasil di aktivasi, silahkan login !
           </div>');
                redirect(base_url('auth'));
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
       Anda Berhasil Logout !
     </div>');
        redirect('auth');
    }
}
