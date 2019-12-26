<?php

class Product_brand_model extends My_Model
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

    public function addFromCkeditor($ck_id)
    {
        $brand_ck = $this -> select_from('ckeditor', array('ck_id' => $ck_id));
        $this -> insert_into('product_brand', 
            array(
                'd_name' => $brand_ck['name'], 
                'prd_csort' => $brand_ck['sort'], 
                'd_enable' => $brand_ck['enable'] == 1 ? 'Y' : 'N' , 
                'd_createTime' => $brand_ck['create_time'], 
                'd_updateTime' => $brand_ck['update_time'],
                'lang_type' => $brand_ck['lang_type'],
                'ck_id' => $ck_id
            )
        );
    }

    public function updateFromCkeditor($ck_id)
    {
        $brand_ck = $this -> select_from('ckeditor', array('ck_id' => $ck_id));
        $this->db->where('ck_id', $ck_id);
        $this->db->update('product_brand',  array(
            'd_name' => $brand_ck['name'], 
            'prd_csort' => $brand_ck['sort'], 
            'd_enable' => $brand_ck['enable'] == 1 ? 'Y' : 'N' , 
            'd_createTime' => $brand_ck['create_time'], 
            'd_updateTime' => $brand_ck['update_time'],
            'lang_type' => $brand_ck['lang_type'],
            'ck_id' => $ck_id
        ));
    }

    public function deleteFromCkeditor($ck_id)
    {
        $this->db->delete('product_brand', array('ck_id' => $ck_id));
    }

}
