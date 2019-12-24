<?php

class Shop_model extends MY_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function index()
    {
        return $this->db->get('shop_store')->result_array();
    }

    public function find($id)
    {
        $this->db->where('shop_id', $id);
        return $this->db->get('shop_store')->result_array()[0];
    }

    public function create(array $data)
    {
        return $this->db->insert('shop_store', $data);
    }

    public function update($id, array $data)
    {
        $this->db->query("UPDATE shop_store SET shop_name = ?, `address` = ? WHERE shop_id = ?", [$data['shop_name'], $data['address'], $id]);
    }

    public function delete($id)
    {
        return $this->db->delete('shop_store', ['shop_id' => $id]);
    }
}
