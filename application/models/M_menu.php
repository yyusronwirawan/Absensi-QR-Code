<?php

class M_menu extends CI_Model
{
    public function inputuseraccess($menuid, $roleid)
    {
        $data = [
            'id' => '',
            'menu_id' => $menuid,
            'role_id' => $roleid
        ];
        $this->db->insert('user_access_menu', $data);
    }
    public function inputuseraccesssubmenu($submenuid, $roleid)
    {
        $data = [
            'id' => '',
            'submenu_id' => $submenuid,
            'role_id' => $roleid
        ];
        $this->db->insert('user_access_submenu', $data);
    }
    public function deleteuseraccess($menuid, $roleid)
    {
        $data = [

            'menu_id' => $menuid,
            'role_id' => $roleid
        ];
        $this->db->delete('user_access_menu', $data);
    }
    public function deleteuseraccesssubmenu($menuid, $roleid)
    {
        $data = [
            'submenu_id' => $menuid,
            'role_id' => $roleid
        ];
        $this->db->delete('user_access_submenu', $data);
    }

    function Tampil_menu()
    {
        return    $this->db->get('user_menu')->result();
    }

    public function tambahmenu()
    {
        $id = $this->input->post('id');
        $menu = $this->input->post('menu', true);
        $icon = $this->input->post('icon', true);
        $data = [
            'id'                 => $id,
            'menu'               => $menu,
            'icon'               => $icon,

        ];
        $this->db->insert('user_menu', $data);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $menu = $this->input->post('menu', true);
        $icon = $this->input->post('icon', true);
        $data = array(
            'id'                 => $id,
            'menu'               => $menu,
            'icon'               => $icon,

        );
        $where = array(
            'id' => $id
        );
        $this->db->where($where)
            ->update('user_menu', $data);
    }

    public function hapusmenu($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
    }
    public function hapussubmenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
    }
    //Data sub mennu
    function DataJoinTampil_sub_menu()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        $this->db->join('user_sub_menu ', 'user_menu.id = user_sub_menu.menu_id');
        return $this->db->get()->result_array();
    }

    public function tambahsub()
    {
        $menu_id = $this->input->post('menu_id');
        $title = $this->input->post('title', true);
        $url = $this->input->post('url', true);
        $is_active = $this->input->post('is_active');

        $data = [
            'menu_id'                 => $menu_id,
            'title'                   => $title,
            'url'                     => $url,
            'is_active'               => $is_active,

        ];
        $this->db->insert('user_sub_menu', $data);
    }

    public function editsubmenu()
    {
        $id = $this->input->post('id');
        $menu_id = $this->input->post('menu_id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $is_active = $this->input->post('is_active');
        $data = [
            'menu_id'                 => $menu_id,
            'title'                   => $title,
            'url'                     => $url,
            'is_active'               => $is_active,

        ];
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
    }
}
