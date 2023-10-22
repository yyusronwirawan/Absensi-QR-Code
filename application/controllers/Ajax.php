<?php

class Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->model('M_absensi');
        $this->load->model('M_jurusan');
        $this->load->model('M_menu');
        $this->load->model('M_kelas');
    }

    public function inputabsen()
    {
        $nis = $this->input->post('nis');
        $sekarang = date('H:i:s');

        $tanggal = date('Y-m-d');
        $c =  $this->M_absensi->cekliburnasional($tanggal);
        $sabtu = $this->M_absensi->cekstatusweekend('sabtu');
        $minggu = $this->M_absensi->cekstatusweekend('minggu');
        //$tgl = explode('-', $tanggal)[2];
        if (date('D', strtotime($tanggal)) == 'Sun' && $minggu[0]['status'] == 'Aktif') {
            echo json_encode(['status' => 'false', 'alert' => 'danger', 'message' => 'Sekarang Libur weekend, tidak bisa absen sekarang libur weekend!']);
            die;
        } else   if ($c > 0) {
            echo json_encode(['status' => 'false', 'alert' => 'danger', 'message' => 'Sekarang Libur , tidak bisa absen ']);
            die;
        }

        if ($this->M_siswa->CekSiswa($nis) < 1) {
            $result = ['status' => 'false', 'alert' => 'danger', 'message' => 'Kode QR Tidak terbaca, silahkan gunakan kode QR yang VALID'];
            echo json_encode($result);
        } else {
            // cek jam absen
            $jam_masuk = $this->db->query("SELECT * FROM tabel_jam_absen WHERE type = 'Masuk' ")->result_array()[0]['mulai'];
            $jam_selesai_masuk = $this->db->query("SELECT * FROM tabel_jam_absen WHERE type = 'Masuk' ")->result_array()[0]['selesai'];
            $jam_keluar = $this->db->query("SELECT * FROM tabel_jam_absen WHERE type = 'Keluar' ")->result_array()[0]['mulai'];
            $jam_selesai_keluar = $this->db->query("SELECT * FROM tabel_jam_absen WHERE type = 'Keluar' ")->result_array()[0]['selesai'];
            $jam_telat_masuk = $this->db->query("SELECT * FROM tabel_jam_absen WHERE type = 'Terlambat' ")->result_array()[0]['mulai'];

            if (strtotime($sekarang) >= strtotime($jam_masuk) && strtotime($sekarang) < strtotime($jam_selesai_masuk) && strtotime($sekarang)) {
                $absen = 'h';
                $type = 'masuk';
            } else if (strtotime($sekarang) > strtotime($jam_telat_masuk) && strtotime($sekarang) < strtotime($jam_keluar)) {
                $absen = 't';
                $type = 'masuk';
            } else if (strtotime($sekarang) >= strtotime($jam_keluar) && strtotime($sekarang) > strtotime($jam_selesai_masuk)) {
                $absen = 'h';
                $type = 'keluar';
            }
            $tglskrg = date('Y-m-d');
            $cekabsen = $this->db->query("SELECT * FROM tabel_detail_absen WHERE nis = '$nis' AND masuk = '1' AND tanggal_absen = '$tglskrg' ")->num_rows();
            if ($type == 'masuk') {
                if ($cekabsen > 0) {
                    $result2 = ['status' => 'false', 'alert' => 'success', 'message' => 'Kamu sudah absen masuk hari ini, selamat beraktivitas :)'];
                    echo json_encode($result2);
                } else {
                    $datasiswa = $this->M_siswa->detailsiswa($nis);
                    $datasiswa2 = $datasiswa[0];
                    $this->M_absensi->inputAbsenBySiswa($datasiswa2, $absen, $type);
                    $pesannya = 'Ananda ' . $datasiswa2['nama_siswa'] . ' telah absen masuk hari ini pada pukul ' . date('H:i:s');
                    $this->M_notif->send_whatsapp($datasiswa2['no_telepon'], $pesannya);
                    echo json_encode(array_merge($datasiswa2, ['status' => 'true']));
                }
            } else if ($type == 'keluar') {
                $cekabsenkeluar =     $cekabsen = $this->db->query("SELECT * FROM tabel_detail_absen WHERE nis = '$nis' AND keluar = '1' AND tanggal_absen = '$tglskrg' ")->num_rows();
                if ($cekabsen == 0) {
                    $result3 = ['status' => 'false', 'alert' => 'danger', 'message' => 'Kamu tidak bisa absen keluar , karna tidak ada data absen masuk kamu hari ini!'];
                    echo json_encode($result3);
                } else if ($cekabsenkeluar > 0) {
                    $result3 = ['status' => 'false', 'alert' => 'success', 'message' => 'Kamu sudah absen keluar hari ini, selamat beristirahat!'];
                    echo json_encode($result3);
                } else {
                    $this->db->query("UPDATE tabel_detail_absen SET keluar = '1' WHERE nis ='$nis' AND tanggal_absen = '$tanggal' AND masuk = '1'");
                    $datasiswa = $this->M_siswa->detailsiswa($nis);
                    $datasiswa2 = $datasiswa[0];

                    $pesannya = 'Ananda ' . $datasiswa2['nama_siswa'] . ' telah absen keluar hari ini pada pukul ' . date('H:i:s');
                    $this->M_notif->send_whatsapp($datasiswa2['no_telepon'], $pesannya);
                    echo json_encode(array_merge($datasiswa2, ['status' => 'true']));
                }
            }
        }
    }

    public function useraccess()
    {

        $roleid = $this->input->post('roleid');
        $menuid = $this->input->post('menuid');
        $where = [
            'menu_id' => $menuid,
            'role_id' => $roleid
        ];
        if ($this->input->post('status') == 'on') {

            $d = $this->db->select('*')
                ->from('user_access_menu')->where($where)
                ->get()->num_rows();
            if ($d < 1) {
                $this->M_menu->inputuseraccess($menuid, $roleid);
            }
        } else if ($this->input->post('status') == 'off') {
            $this->M_menu->deleteuseraccess($menuid, $roleid);
        }
    }
    public function ambilkelas()
    {
        $idkelas = $this->input->post('idkelas');
        echo json_encode($this->M_kelas->ambilkelas($idkelas));
    }
    public function ambiljurusan()
    {
        $idjurusan = $this->input->post('idjurusan');
        echo json_encode($this->M_jurusan->ambiljurusan($idjurusan));
    }

    // setting libur
    public function editliburweekend()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $hari = $this->input->post('hari');
        $this->M_absensi->editliburweekend($id, $status, $hari);
    }

    // get submenu
    public function useraccesssubmenu()
    {
        $roleid = $this->input->post('roleid');
        $submenuid = $this->input->post('submenuid');
        $where = [
            'submenu_id' => $submenuid,
            'role_id' => $roleid
        ];
        if ($this->input->post('status') == 'on') {

            $d = $this->db->select('*')
                ->from('user_access_submenu')->where($where)
                ->get()->num_rows();
            if ($d < 1) {
                $this->M_menu->inputuseraccesssubmenu($submenuid, $roleid);
            }
        } else if ($this->input->post('status') == 'off') {
            $this->M_menu->deleteuseraccesssubmenu($submenuid, $roleid);
        }
    }


    // student
    public function linked_nis()
    {

        $nis = $this->input->post('nomorinduk');
        $tanggal = date('Y-m-d');
        $kodeunik = base64_encode($nis . '=' . $tanggal . '=' . random_int(10000000, 999999999));
        $ceknis = $this->db->query("SELECT * FROM tabel_siswa WHERE nis = '$nis'");
        $cekuser = $this->db->query("SELECT * FROM login_siswa WHERE nis_siswa = '$nis' AND is_active = '0'")->num_rows();
        if ($ceknis->num_rows() < 1 || $cekuser > 0) {
            echo json_encode('already');
        } else {
            $datasiswa = $ceknis->result_array()[0];
            $message =
                '
Hai ' . $datasiswa['nama_siswa']  . ' Kamu telah melakukan pengaitan akun,
berikut link untuk meneruskan pengaitan akun anda 
' . base_url() . 'student/auth/linked_proccess/' . $kodeunik . '

*link berlaku satu hari
';
            $this->M_notif->send_whatsapp($datasiswa['no_telepon'], $message);
            $data  = [
                'nis_siswa' => $nis,
                'is_active' => 0,
                'kode_unik' => $kodeunik
            ];
            $this->db->insert('login_siswa', $data);
            echo json_encode('success');
        }
    }

    public function linked_success()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $nis = $this->input->post('nis');

        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'kode_unik' => random_int(100, 999)
        ];
        $this->db->where(['nis_siswa' => $nis])->update('login_siswa', $data);
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil kaitkan akun, silahkan login']);
        echo json_encode(base_url('student/auth/'));
    }


    public function login_proccess()
    {

        $nis = $this->input->post('nis');
        $password = $this->input->post('password');
        $siswa = $this->db->get_where('login_siswa', ['nis_siswa' => $nis])->result_array()[0];
        $biosiswa = $this->db->get_where('tabel_siswa', ['nis' => $nis])->result_array()[0];

        if ($siswa && $biosiswa) {
            if ($siswa['is_active'] == 1) {
                if (password_verify($password, $siswa['password'])) {
                    $datasiswa = $biosiswa;
                    $sessionsiswa = array_merge($datasiswa, ['level' => 'siswa']);
                    $this->session->set_userdata($sessionsiswa);
                    $result = ['status' => true, 'data' => base_url() . 'student/dashboard'];
                } else {
                    $result = ['status' => false, 'data' => 'Nis atau password salah!'];
                }
            } else {
                $result = ['status' => false, 'data' => 'Email belum di aktivasi'];
            }
        } else {
            $result = ['status' => false, 'data' => 'Nis atau password salah!'];
        }

        echo json_encode($result);
    }


    public function tampilizin()
    {
        $idizin = $this->input->post('idizin');
        $dataizin = $this->db->query("SELECT * FROM tabel_izin JOIN tabel_siswa on tabel_siswa.nis = tabel_izin.nis_siswa WHERE id = '$idizin' ")->result_array();
        $tgl = ['tanggal_indonesia' => namaHariBulanIndonesia($dataizin[0]['tanggal_izin'])];
        $data = array_merge($dataizin[0], $tgl);
        echo json_encode($data);
    }

    public function konfirmasi_izin()
    {
        $idizin = $this->input->post('idizin');
        $aksi = $this->input->post('aksi');

        $dataizin = $this->db->query("SELECT * FROM tabel_izin JOIN tabel_siswa on tabel_siswa.nis = tabel_izin.nis_siswa WHERE id = '$idizin' ")->result_array()[0];

        if ($aksi == 'Diterima') {
            $jam = date('H:i:s');
            $nis = $dataizin['nis_siswa'];
            $tanggal = $dataizin['tanggal_izin'];
            $dataizin['type'] == 'Sakit' ? $keterangan = 's' : $keterangan = 'i';
            $kodekelas = $dataizin['kode_kelas'];
            $kodejurusan = $dataizin['kode_jurusan'];
            $this->db->query("INSERT INTO tabel_detail_absen VALUES ('','$jam','$tanggal','$nis','$keterangan','$kodekelas','$kodejurusan','1','1')");
            $this->db->query("UPDATE tabel_izin SET status = 'Diterima'  WHERE id = '$idizin'");
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Izin berhasil di konfirmasi, terima']);
        } else if ($aksi == 'Ditolak') {
            $this->db->query("UPDATE tabel_izin SET status = 'Ditolak' WHERE id = '$idizin'");
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Izin berhasil di Di tolak']);
        }

        echo json_encode(base_url('izin'));
    }

    public function verif_email_staff()
    {
        $email = $this->input->post('email');
        $queryemail = $this->db->query("SELECT * FROM tabel_user  WHERE email = '$email'");
        if ($queryemail->num_rows() < 1) {
            $data = ['status' => false, 'message' => 'Email tidak terdaftar !'];
        } else if ($queryemail->result_array()[0]['is_active'] == 0) {
            $datauser = $queryemail->result_array()[0];
            $kodeacak = base64_encode($email . '=' . date('Y-m-d') . '=' . random_int(10000, 999999));
            $this->db->query("UPDATE tabel_user SET kode_unik = '$kodeacak' WHERE email = '$email' ");
            $message = 'Hallo ' . $datauser['name'] . ' Berikut link untuk memverifikasi akun anda ' . base_url() . 'auth/verif_email/' . $kodeacak;
            if ($this->M_notif->send_email($email, 'Verifiksai email', $message) == true) {
                $data = ['status' => true, 'message' => $email];
            } else {

                $data = ['status' => false, 'message' => 'Kesalahan system'];
            }
        } else {
            $data = ['status' => false, 'message' => 'Email tersebut sudah di verifikasi !'];
        }
        echo json_encode($data);
    }
    public function verif_email_siswa()
    {
        $nis = $this->input->post('nis');
        $querynis = $this->db->query("SELECT * FROM login_siswa JOIN tabel_siswa on tabel_siswa.nis = login_siswa.nis_siswa WHERE nis_siswa = '$nis'");
        if ($querynis->num_rows() < 1) {
            $data = ['status' => false, 'message' => 'Nomor induk tidak valid.'];
        } else if ($querynis->result_array()[0]['is_active'] == 0) {
            $datasiswa = $querynis->result_array()[0];
            $email = $datasiswa['email'];
            $kodeacak = base64_encode($datasiswa['nis_siswa'] . '=' . date('Y-m-d') . '=' . random_int(10000, 999999));
            $this->db->query("UPDATE login_siswa SET kode_unik = '$kodeacak' WHERE nis_siswa = '$nis' ");
            $message = 'Hallo ' . $datasiswa['nama_siswa'] . ' Berikut link untuk memverifikasi akun anda ' . base_url() . 'student/auth/verif_email/' . $kodeacak;
            if ($this->M_notif->send_email($email, 'Verifiksai email', $message) == true) {
                $data = ['status' => true, 'message' => $email];
            } else {

                $data = ['status' => false, 'message' => 'Kesalahan system'];
            }
        } else {
            $data = ['status' => false, 'message' => 'Nomor induk tersebut sudah verifikasi email.'];
        }
        echo json_encode($data);
    }

    public function change_password_siswa()
    {
        $nis = $this->session->userdata('nis');
        $pwlama = $this->input->post('oldpw');
        $pwbaru = $this->input->post('newpw');
        $confirmpw = $this->input->post('confirmpw');

        $akun = $this->db->query("SELECT * FROM login_siswa WHERE nis_siswa = '$nis' ")->result_array()[0];
        if (password_verify($pwlama, $akun['password'])) {
            $password = password_hash($pwbaru, PASSWORD_DEFAULT);
            $this->db->query("UPDATE login_siswa SET password = '$password' WHERE nis_siswa = '$nis'");

            $data = ['status' => true, 'message' => 'Berhasil Ubah Kata Sandi'];
        } else {
            $data = ['status' => false, 'message' => 'Kata sandi lama salah !'];
        }
        echo json_encode($data);
    }
}
