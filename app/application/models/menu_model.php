<?php
require_once('./application/core/MY_Sql.php');
class Menu_model extends MY_Sql
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
				$this -> update_set('icon_link_type', array('d_id' => $value), array('d_sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
	
	public function sort2_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('menu_link_type', array('d_id' => $value), array('d_sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
	
	public function sort3_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('bottom_link_type', array('d_id' => $value), array('d_sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
	
	public function sort4_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('mobile_link_type', array('d_id' => $value), array('d_sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
	
	public function sort5_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('side_link_type', array('d_id' => $value), array('d_sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
}