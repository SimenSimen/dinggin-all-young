<?php

class Provider_commits_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getProviderCommits($provider_id)
    {
        $this->db->where('supplier_id', $provider_id);
        return $this->db->get();
    }
}
