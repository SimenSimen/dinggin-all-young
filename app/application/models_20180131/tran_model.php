<?php
class Tran_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_list(){
		$sql='select * from lapack_list';
		return $this->db->query($sql)->result_array();
	}

	public function get_data($id=''){
		$sql='select * from language_pack where d_type='.$id;
		return $this->db->query($sql)->result_array();
	}
	
}
