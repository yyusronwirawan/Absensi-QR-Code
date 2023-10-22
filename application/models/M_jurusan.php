<?php

class M_jurusan extends CI_Model
{

    public function tampiljurusan()
    {
        return $this->db->get('tabel_jurusan')->result_array();
    }

    public function tambahjurusan()
    {
        $data = [
            'id_jurusan' => '',
            'jurusan' => $this->input->post('namajurusan', true)
        ];

        $this->db->insert('tabel_jurusan', $data);
    }
    public function hapusjurusan($idjurusan)
    {
        $this->db->delete('tabel_jurusan', ['id_jurusan' => $idjurusan]);
    }
    public function ambiljurusan($idjurusan)
    {
        return $this->db->where('id_jurusan', $idjurusan)->get('tabel_jurusan')->result();
    }

    public function editjurusan()
    {

        $data = [
            'jurusan' => $this->input->post('namajurusan', true)
        ];
        $this->db->where('id_jurusan', $this->input->post('idjurusan'));
        $this->db->update('tabel_jurusan', $data);
    }
}
