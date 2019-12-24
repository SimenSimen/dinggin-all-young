<?php
require_once('./application/core/MY_Sql.php');
class Eform_model extends MY_Sql
{
	
	function __construct()
	{
		$this -> load -> database();
	}

	public function stretch($type, $id)
	{
		switch ($type) {
			case 'g':
				$array = $this -> select_from('auth_category', array('category_id as id', 'c_name as name'), array('type' => '7', 'category_id' => $id, 'lang_type' => $this -> session -> userdata('lang')));
				break;
			case 'd':
				$array = $this -> select_from('auth_category', array('category_id as id', 'c_name as name'), array('type' => '4', 'category_id' => $id, 'lang_type' => $this -> session -> userdata('lang')));
				break;
			case 'e':
				$array = $this -> select_from('auth_category', array('category_id as id', 'c_name as name'), array('type' => '5', 'category_id' => $id, 'lang_type' => $this -> session -> userdata('lang')));
				break;
		}

		if (!empty($array))
			return $array;
		else
			return false;
	}

	public function sort_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('uform', array('ufm_id' => $value), array('sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
}