<?php

class Provider_model extends My_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('encrypt');
    }
    
    public function index()
    {
        $sql = 'SELECT * FROM providers';    
        return $this->db->query($sql)->result_array();
    }

    public function find($id)
    {
        return $this->db->query("SELECT * FROM providers WHERE id = ?", $id)->result_array()[0];
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO providers $keys VALUES $values";
        return $this->db->insert('providers', $data);
    }

    public function update($id, array $data)
    {
        $this->db->where('id', $id);
        $this->db->update('providers', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('providers', ['id' => $id]);
    }

    public function checkCompanyTaxExists($tax_id)
    {
        $sql = "SELECT * FROM providers WHERE tax_id = ?";
        return !!$this->db->query($sql, $tax_id)->num_rows();
    }

    public function checkProviderExists(array $data)
    {

        $sql = "SELECT * FROM providers WHERE tax_id = ?";
        $provider = $this->db->query($sql, [$data['tax_id']])->result_array()[0];

        if ($provider) {
            if ($data['phone'] === $this->encrypt->decode($provider['phone']) && $provider['is_provider'] == 1) {
                return $provider;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
