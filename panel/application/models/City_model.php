<?php

class city_model extends CI_Model
{

    public function get($where = array())
    {
        return $this->db->where($where)->get('city')->row();
    }

    public function get_all($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get("city")->result();
    }

    public function district($id)
    {
        return $result = $this->db->where("city_id",$id)->get("district")->result();
    }

    public function tax_office($id)
    {
        return $result = $this->db->where("city_id",$id)->get("tax_office")->result();
    }

}
