<?php
require_once('./application/core/MY_Sql.php');
class Payment_model extends MY_Sql
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function sort1_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('payment_way', array('pway_id' => $value), array('sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
	
}