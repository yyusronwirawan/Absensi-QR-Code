<?php
class M_bantuan extends CI_Model
{

    public function cekValue($kolom, $tabel, $kolomid, $nilaiid)
    {
        return $this->db->select($kolom)
            ->where($kolomid, $nilaiid)
            ->get($tabel)->result_array()[0][$kolom];
    }
    public function formatnomor($nohp)
    {
        if (substr(trim($nohp), 0, 2) == '62') {
            $hp = trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif (substr(trim($nohp), 0, 1) == '0') {
            $hp = '62' . substr(trim($nohp), 1);
        }
        return $nohp;
    }
}
