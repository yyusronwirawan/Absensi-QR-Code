<?php



function generateQrSiswa($data, $path)
{
    //function berikut auto mesave file png ke assets/qr/
    $CI = &get_instance();
    $CI->load->library('ciqrcode');

    $config['cacheable'] = true; //boolean, the default is true
    $config['cachedir']  = './assets/'; //string, the default is application/cache/
    $config['errorlog']  = './assets/'; //string, the default is application/logs/
    $config['imagedir']  = './assets/images/'; //direktori penyimpanan qr code
    $config['quality']   = true; //boolean, the default is true
    $config['size']      = '1024'; //interger, the default is 1024
    $config['black']     = array(224, 255, 255); // array, default is array(255,255,255)
    $config['white']     = array(70, 130, 180); // array, default is array(0,0,0)
    $CI->ciqrcode->initialize($config);
    // header("Content-Type: image/png");
    $params['data']     = $data;
    $params['level']    = 'H'; //H=High
    $params['size']     = 10;
    $params['savename'] = FCPATH . './assets/qr/' . $path;

    $CI->ciqrcode->generate($params);
}

function hari_ini()
{
    $hari = date("D");

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return $hari_ini;
}



function verifikasiuser($roleid, $url)
{
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM user_sub_menu WHERE url = '$url' ";
    $c = $ci->db->query($sql)->result_array();

    $id_sub_menu = $c[0]['id'];
    $sql2 = "SELECT * FROM user_access_submenu WHERE role_id = '$roleid' AND submenu_id = '$id_sub_menu'";
    $d = $ci->db->query($sql2)->num_rows();
    if ($d > 0) {
        return true;
    } else {
        redirect(base_url('dashboard'));
    }
}

function nama_bulan($bulan)
{
    switch ($bulan) {
        case '01':
            $bulan_ini = "Januari";
            break;

        case '02':
            $bulan_ini = "Februari";
            break;

        case '03':
            $bulan_ini = "Maret";
            break;

        case '04':
            $bulan_ini = "April";
            break;

        case '05':
            $bulan_ini = "Mei";
            break;

        case '06':
            $bulan_ini = "Juni";
            break;

        case '07':
            $bulan_ini = "Juli";
            break;
        case '08':
            $bulan_ini = "Agustus";
            break;
        case '09':
            $bulan_ini = "September";
            break;
        case '10':
            $bulan_ini = "Oktober";
            break;
        case '11':
            $bulan_ini = "November";
            break;
        case '12':
            $bulan_ini = "Desember";
            break;

        default:
            $bulan_ini = "Tidak di ketahui";
            break;
    }
    return $bulan_ini;
}


function namaHariBulanIndonesia($tanggal)
{
    $tahun = explode('-', $tanggal)[0];
    $bulan = explode('-', $tanggal)[1];
    $hariangka = explode('-', $tanggal)[2];
    $hari = date('D', strtotime($tanggal));
    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    switch ($bulan) {
        case '01':
            $bulan_ini = "Januari";
            break;

        case '02':
            $bulan_ini = "Februari";
            break;

        case '03':
            $bulan_ini = "Maret";
            break;

        case '04':
            $bulan_ini = "April";
            break;

        case '05':
            $bulan_ini = "Mei";
            break;

        case '06':
            $bulan_ini = "Juni";
            break;

        case '07':
            $bulan_ini = "Juli";
            break;
        case '08':
            $bulan_ini = "Agustus";
            break;
        case '09':
            $bulan_ini = "September";
            break;
        case '10':
            $bulan_ini = "Oktober";
            break;
        case '11':
            $bulan_ini = "November";
            break;
        case '12':
            $bulan_ini = "Desember";
            break;

        default:
            $bulan_ini = "Tidak di ketahui";
            break;
    }

    return $hari_ini . ' ' . $hariangka . ' ' . $bulan_ini . ' ' . $tahun;
}
