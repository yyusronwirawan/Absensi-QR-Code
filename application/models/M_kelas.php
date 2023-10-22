<?php

class M_kelas extends CI_Model
{

    public function tampilkelas()
    {
        return $this->db->get('tabel_kelas')->result_array();
    }
    public function tampiljurusan()
    {
        return $this->db->get('tabel_jurusan')->result_array();
    }

    public function ambilkelas($idkelas)
    {
        return $this->db->where('id_kelas', $idkelas)->get('tabel_kelas')->result_array();
    }
    public function ambiljurusan($idjurusan)
    {
        return $this->db->where('id_jurusan', $idjurusan)->get('tabel_jurusan')->result_array();
    }
    public function inputkelas()
    {
        $data = [
            'id_kelas' => '',
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'kelas' => $this->input->post('kelas', true)
        ];

        $this->db->insert('tabel_kelas', $data);
    }
    public function hapuskelas($id)
    {
        $this->db->delete('tabel_kelas', ['id_kelas' => $id]);
    }
    public function editkelas()
    {
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'kelas' => $this->input->post('kelas', true)
        ];

        $this->db->where('id_kelas', $this->input->post('idkelas'));
        $this->db->update('tabel_kelas', $data);
    }
}
