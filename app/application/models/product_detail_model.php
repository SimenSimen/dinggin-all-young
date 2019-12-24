<?php

class Product_detail_model extends My_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function create($id, array $data)
    {
        $data['product_id'] = (int) $id;
        $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('product_detail', $data);
    }
}
