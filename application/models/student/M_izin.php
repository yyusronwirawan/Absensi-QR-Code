<?php

class M_izin extends CI_Model
{
    public function inputizin($bukti, $nis)
    {
        $data = [
            'nis_siswa' => $nis,
            'type' => $this->input->post('alasan', true),
            'file_bukti' => $bukti,
            'keterangan' => $this->input->post('keterangan', true),
            'tanggal_izin' => $this->input->post('tanggal', true),
            'status' => 'Menunggu Konfirmasi',
        ];
        $this->db->insert('tabel_izin', $data);
    }
    public function tampildata($nis)
    {
        return  $this->db->where(['nis_siswa' => $nis])->get('tabel_izin')->result_array();
    }
}
