<?php


class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kelas');
        $this->load->model('M_jurusan');
        $this->load->model('M_user');
        $this->load->model('M_menu');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data = [
            'title' => WEBNAME . 'Menu access',
            'webname' => WEBNAME,

        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/footer');
    }



    // kelola kelas
    // digunakan untuk ajax




    // access
    public function Access()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);

        verifikasiuser($datauser['role_id'], $url);
        if ($datauser['role_id'] != 1) {
            echo 'Anda tidak diizinkan untuk akses halaman ini';
            exit;
        };
        $data = [
            'title' => 'Access Management',
            'user' => $datauser,
            'webname' => WEBNAME
        ];
        //$data['Tabel_absensi'] = $this->Msiswa->tampil_data_login_Absen();
        $this->load->view('templates/header', $data);
        $this->load->view('menu/access');
        $this->load->view('templates/footer');
    }


    // menu
    public function management()
    {
        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . '| Menu Management',
            'user' => $datauser,
            'webname' => WEBNAME,
            'titleedit' => 'Edit Menu',
            'titletambah' => 'Tambah Menu'
        ];
        //$data['Tabel_absensi'] = $this->Msiswa->tampil_data_login_Absen();
        $data['Menu'] = $this->M_menu->Tampil_menu();
        $this->load->view('templates/header', $data);
        $this->load->view('menu/management');
        $this->load->view('templates/footer');
    }
    public function Tambah()
    {
        //$data['user'] untuk menampilkan nama yang login  di header dan saidbar

        $this->form_validation->set_rules('menu', 'menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('icon', 'icon', 'required|trim', [
            'required' => 'Icon Tidak Boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_menu->tambahmenu();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'berhasil di tambah']);
        }
        redirect(base_url('menu/management'));
    }
    public function Edit()
    {
        $this->form_validation->set_rules('menu', 'menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('icon', 'icon', 'required|trim', [
            'required' => 'Icon Tidak Boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_menu->edit();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil edit menu']);
        }
        redirect(base_url('menu/management'));
    }
    public function Hapus($id)
    {
        //message adalah parameter untuk membuat pesan
        $id = base64_decode($id);
        $this->M_menu->hapusmenu($id);
        $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Berhasil Hapus']);
        redirect(base_url('menu/management'));
    }
    //

    // submenu
    public function submanagement()
    {

        $datauser = $this->M_user->getUserById($this->session->userdata('id'))[0];
        $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);

        verifikasiuser($datauser['role_id'], $url);
        $data = [
            'title' => WEBNAME . '| Menu Management',
            'user' => $datauser,
            'webname' => WEBNAME,
            'titleedit' => 'Edit Sub Menu',
            'titletambah' => 'Tambah Sub Menu',
            'Menu' => $this->M_menu->Tampil_menu(),
            'Submenu' => $this->M_menu->DataJoinTampil_sub_menu()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('menu/submanagement', $data);
        $this->load->view('templates/footer');
    }

    public function tambahsub()
    {
        //$data['user'] untuk menampilkan nama yang login  di header dan saidbar

        $this->form_validation->set_rules('menu_id', 'menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('title', 'title', 'required|trim', [
            'required' => 'title Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('url', 'url', 'required|trim', [
            'required' => 'url Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('is_active', 'is_active', 'required|trim', [
            'required' => 'is_active Tidak Boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_menu->tambahsub();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil tambah sub menu']);
        }
        redirect(base_url('menu/submanagement'));
    }
    public function editsub()
    {
        $this->form_validation->set_rules('menu_id', 'menu', 'required|trim', [
            'required' => 'Menu Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('title', 'title', 'required|trim', [
            'required' => 'title Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('url', 'url', 'required|trim', [
            'required' => 'url Tidak Boleh kosong'
        ]);
        $this->form_validation->set_rules('is_active', 'is_active', 'required|trim', [
            'required' => 'is_active Tidak Boleh kosong'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_menu->editsubmenu();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil edit sub menu']);
            redirect(base_url('menu/submanagement'));
        }
    }
    public function hapussubmenu($id)
    {
        $idsubmenu = base64_decode($id);
        $this->M_menu->hapussubmenu($idsubmenu);
        $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Berhasil Hapus']);
        redirect(base_url('menu/submanagement'));
    }
}
