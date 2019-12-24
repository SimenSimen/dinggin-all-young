<?php

class Store_model extends MY_Model
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

    public function create()
    {
        
    }

    public function delete($id)
    {
        return $this->db->delete('shop_store', ['shop_id' => $id]);
    }
}
