<?php
class M_data extends CI_Model
{

    public function datalibur()
    {
        $tgl = date('Y-m');
        return $this->db->like('tanggal', $tgl)->where('status', 'Aktif')->get('tabel_libur')->result_array();
    }

    public function dataakunsiswa($nis)
    {
        $this->db->select('*');
        $this->db->from('login_siswa');
        $this->db->join('tabel_siswa', 'tabel_siswa.nis = login_siswa.nis_siswa');
        $this->db->where('nis_siswa', $nis);
        return $this->db->get()->result_array();
    }
}
