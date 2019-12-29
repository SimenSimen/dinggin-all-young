<?php
require_once('./application/core/MY_Sql.php');
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends CI_Model
{
	//private $_db_name, $_db_products, $_db_store;

	public function __construct()
	{
		$this->load->database();
		$this->_db_name = 'ebanner';
	}

	public function getMyAd($category_id = '')
	{
		$sql = "SELECT * FROM " . $this->_db_name . " WHERE 1=1";
		//if($category_id!='')
		//	$sql.=" and category_id='".$category_id."'";

		$sql .= " and lang_type ='$this->setlang' and hidden='N' order by sort asc";
		$query = $this->db->query($sql);

		return $query->result_array();;
	}

	public function addNum($id = 0)
	{
		if ($id > 0) {
			$this->db->set('d_num', 'd_num+1', false);
			$this->db->where('d_id', $id);
			return $this->db->update($this->_db_name);
		}
		return false;
	}

	public function stretch($type, $id)
	{
		switch ($type) {
			case 'g':
				$array = $this->select_from('auth_category', array('category_id as id', 'c_name as name'), array('type' => '10', 'category_id' => $id));
				break;
		}

		if (!empty($array))
			return $array;
		else
			return false;
	}

	public function sort_action($ck_array = array())
	{
		if (!empty($ck_array)) {
			foreach ($ck_array as $key => $value) {
				$this->update_set('ebanner', array('ebanner_id' => $value), array('sort' => $key));
			}

			return true;
		} else
			return false;
	}
}
