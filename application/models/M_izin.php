<?php


class M_izin extends CI_Model
{

    public function tampilDataIzinBulanIni()
    {
        $bulanini = date('Y') . '-' . date('m');
        $this->db->order_by('id', 'desc');
        $this->db->like('tanggal_izin', $bulanini);
        $this->db->join('tabel_siswa', 'tabel_siswa.nis = tabel_izin.nis_siswa');
        return $this->db->get('tabel_izin')->result_array();
    }
}
