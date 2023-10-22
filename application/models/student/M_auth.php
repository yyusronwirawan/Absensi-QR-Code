<?php


class M_auth extends CI_Model
{

    public function cekkodeunik($kodeunik, $nis)
    {
        return $this->db->where(['nis_siswa' => $nis, 'kode_unik' => $kodeunik])
            ->get('login_siswa')->num_rows();
    }
    public function getUserByNis($nis)
    {
        return $this->db->select('*')
            ->from('login_siswa')->join('tabel_siswa', 'tabel_siswa.nis = login_siswa.nis_siswa')
            ->where('nis_siswa', $nis)->get()->result_array();
    }
    public function aktifkanuser($nis)
    {
        $data = [
            'is_active' => 1
        ];
        $this->db->where('nis_siswa', $nis)->update('login_siswa', $data);
    }

    public function resetkodeunik($nis)
    {
        $data = [
            'kode_unik' => null
        ];
        $this->db->where('nis_siswa', $nis)->update('login_siswa', $data);
    }
}
