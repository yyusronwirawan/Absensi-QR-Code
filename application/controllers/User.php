<?php

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
        if (!$this->session->userdata('id')) {
            redirect(base_url('dashboard'));
        }
    }
    public function index()

    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1);
        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . 'Data User',
            'webname' => WEBNAME,
            'users' => $this->M_user->datauser(),
            'user' =>  $this->M_user->getUserById($this->session->userdata('id'))[0]
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        if ($this->input->post('id_user') != FALSE) {
            $id_user = $this->input->post('id_user');
            $data_user = $this->M_user->getUserById($id_user)[0];
            $data = [
                'title' => WEBNAME . 'Edit User',
                'webname' => WEBNAME,
                'user' => $data_user
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('user/formedituser');
            $this->load->view('templates/footer');
        } else {
            redirect(base_url() . 'user');
        }
    }

    public function delete()
    {
        if ($this->input->post('id_user') != FALSE) {
            $this->M_user->deleteuser($this->input->post('id_user'));
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'User berhasil dihapus']);
        }
        redirect(base_url() . 'user');
    }

    public function edituser()
    {
        $config['upload_path']          = './assets/images/user';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['file_name']        = $this->input->post('id_user');
        $config['max_size']             = 2000;
        $this->load->library('upload', $config);
        $this->form_validation->set_rules('nama', 'Name', 'required|min_length[6]|trim|alpha', [
            'min_length' => 'Nama minimal 6 karakter',
        ]);
        $old_email = $this->M_user->getUserByid($this->input->post('id_user'))[0]['image'];
        if ($this->input->post('email') == $old_email) {
            $rules_email = '';
        } else {
            $rules_email = '|is_unique[tabel_user.email]';
        }
        $this->form_validation->set_rules('email', 'email', 'required|valid_email' . $rules_email, [
            'valid_email' => 'Harap masukan email yang valid'
        ]);
        if (!isset($_FILES['image']['name'])) {
            $foto = $this->input->post('fotodefault');
        } else {
            if (!$this->upload->do_upload('foto')) {
                $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => $this->upload->display_errors()]);
                redirect(base_url() . 'user');
                exit;
            }
            $foto = $this->input->post('id_user') . '.' . $this->upload->data('image_type');
        }
        $this->M_user->edituser($foto);
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil edit user']);
        redirect(base_url() . 'user');
    }


    public function profile()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $data = [
            'title' => WEBNAME . 'Data User',
            'webname' => WEBNAME,
            'dataakun' => $datauser,
            'user' =>  $this->M_user->getUserById($this->session->userdata('id'))[0]
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('user/profile');
        $this->load->view('templates/footer');
    }

    public function ubahpassword()
    {

        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if (!password_verify($current_password, $datauser['password'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				Password Sebelumnya salah !
				</div>');
            redirect('user/profile');
        } else {

            if ($current_password == $new_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					Password Baru Tidak Boleh Sama dengan Password yang Lama !
					</div>');
                redirect('user/profile');
            } else {

                // password Nya sudak Bener aliyas validasi yang di atas sudah lulus, maka  Pasword yang di inpukan akan di hash
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $password_hash);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('tabel_user');

                $this->session->set_flashdata('message', 'DI EDIT');
                redirect(base_url('user/profile'));
            }
        }
    }


    // page data user siswa
    public function user_siswa()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . 'User Login siswa',
            'webname' => WEBNAME,
            'usersiswa' => $this->M_user->getusersiswa(),
            'titleedit' => 'Ubah Log siswa',
            'user' =>  $this->M_user->getUserById($this->session->userdata('id'))[0]

        ];
        $this->load->view('templates/header', $data);
        $this->load->view('user/usersiswa');
        $this->load->view('templates/footer');
    }
    public function editlogsiswa()
    {
        $this->form_validation->set_rules('nis', 'menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('email', 'icon', 'required|trim|valid_email', [
            'required' => 'Icon Tidak Boleh kosong',
            'valid_email' => 'Yang anda masukan bukan email'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_user->edit();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil edit Log user siswa']);
        }
        redirect('User/logsiswa');
    }
    public function deletelogsiswa($id)
    {
        //message adalah parameter untuk membuat pesan
        $id = base64_decode($id);
        $this->M_user->deletelog($id);
        $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Berhasil Hapus']);
        redirect('User/user _siswa');
    }
}
