<?php

class Report_workmachine_model extends CI_Model
{

    public $tableName = "report_workmachine";

    public function __construct()
    {
        parent::__construct();
    }

    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function get_all($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get($this->tableName)->result();
    }

    public function sum_all($where = array(), $column=null)
    {
        $result = $this->db->select_sum($column)->where($where)->get($this->tableName)->result();

        // Sadece toplam değerini alın
        $total = isset($result[0]->$column) ? $result[0]->$column : 0;

        return $total;
    }

    public function add($data = array())
    {
        return $this->db->insert($this->tableName, $data);
    }

    public function update($where = array(), $data = array())
    {
        return $this->db->where($where)->update($this->tableName, $data);
    }

    public function delete($where = array())
    {
        return $this->db->where($where)->delete($this->tableName);
    }

    public function get_unique_workmachine($site_id) {
        $this->db->distinct();
        $this->db->select('workmachine');
        $this->db->from('report_workmachine');
        $this->db->where('site_id', $site_id);
        $query = $this->db->get();
        return $query->result_array(); // Dizi döndür
    }

}
