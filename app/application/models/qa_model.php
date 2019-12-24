<?php
require_once('./application/core/MY_Sql.php');
class Qa_model extends MY_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function stretch($type, $id)
	{
		switch ($type) {
			case 'g':
				$array = $this -> select_from('q_and_a_group', array('qaag_id as id', 'qaag_name as name'), array('type' => '2', 'qaag_id' => $id));
				break;
			case 'a':
				$array = $this -> select_from('q_and_a_group', array('qaag_id as id', 'qaag_name as name'), array('type' => '3', 'qaag_id' => $id));
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
				$this -> update_set('q_and_a', array('qaa_id' => $value), array('sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
}