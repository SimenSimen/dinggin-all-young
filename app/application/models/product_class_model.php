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

    /**
     * Get the product list for active
     *
     * @param string $lang
     * @param array $where
     * @param int $limit
     * @param boolean $deep
     * @return array
     */
    public function getList($lang, $where = [], $limit = null, $deep = false)
    {

        if ($deep) {
            /** @todo search all and make it a deep json array */
        } else {
            $this->db->where([
                'd_enable'  => 'Y',
                'lang_type' => $lang,
                'PID' => 0
            ]);

            $this->db->where($where);
            if ($limit) {
                $this->db->limit($limit);
            }

            $this->db->order_by("prd_csort", "asc");
        }

        $query = $this->db->get('product_class');

        return $query->result_array();
    }
}
