<?php

class commits_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function judgeVerifyStatus($id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_commits', ['is_admin_verify' => 1]);
    }

    public function getProviderCommits($provider_id)
    {
        return $this->db->query(
            "SELECT p.prd_id, p.prd_name, p.is_admin_verify, p.update_time, p.prd_sn, pc.prd_cname
            FROM product_commits p
            INNER JOIN product_class pc ON p.prd_cid = pc.prd_cid
            WHERE supplier_id = ?
            ORDER BY p.prd_id ASC
        ", $provider_id)->result_array();
    }
}
