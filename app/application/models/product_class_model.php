<?php

class Product_class_model extends My_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function enable($id, array $data)
    {
        $data['is_hot'] = 1;
        $this->db->where('prd_cid', $id);
        $this->db->or_where('PID', $id);
        $this->db->update('product_class', $data);
    }

    public function cancel($id)
    {
        $this->db->where('prd_cid', $id);
        $this->db->or_where('PID', $id);
        $this->db->update('product_class', [
            'is_hot' => 0,
            'start_at' => null,
            'end_at' => null
        ]);
    }

    public function modifyDate($id, array $data)
    {
        $this->db->where('prd_cid', $id);
        $this->db->update('product_class', $data);
    }
}
