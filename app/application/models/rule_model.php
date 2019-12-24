<?php
require_once('./application/core/MY_Sql.php');
class rule_model extends My_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function edit($type)
	{
		switch ($type) {
			case 1:
				# 購買說明
				$U_id = $this -> update_set('iqr_cart', array('member_id' => '1'), array('cset_paid_' .$this -> session -> userdata('lang') => $this -> input -> post('content')));
				break;
			
			case 2:
				# 運送規則
				$U_id = $this -> update_set('iqr_cart', array('member_id' => '1'), array('cset_ship_' .$this -> session -> userdata('lang') => $this -> input -> post('content')));
				break;
		}

		if ($U_id)
			return true;
		else
			return false;
	}

	public function selectContactInformation($langType = 'TW')
	{
		$sql = 'SELECT * FROM iqr_cart WHERE lang_type = "'.$langType.'"';
		return $this->db->query($sql)->result_array()[0];
	}
}