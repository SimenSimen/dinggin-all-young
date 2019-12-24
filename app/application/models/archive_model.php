<?php
require_once('./application/core/MY_Sql.php');
class Archive_model extends My_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function archive_group_list()
	{
		$sql  = 'SELECT auth_category.category_id, auth_category.c_name, auth_category.sort, auth_category.type, ';
		$sql .= 'archive.a_id, archive.name, archive.file_name, SUBSTR(archive.path, 2) as path, archive.sort ';
		$sql .= 'FROM archive RIGHT JOIN (SELECT category_id, type, c_name, sort FROM auth_category where type="6" AND lang_type ="'.$this -> session -> userdata('lang').'") auth_category ON ';
		$sql .= 'auth_category.category_id = archive.category_id ';
		$sql .= 'ORDER BY auth_category.sort, auth_category.category_id, archive.sort ASC';
		$query = $this -> db -> query($sql);
		return $query -> result_array();
	}

	public function archive_array_arrange($array = array())
	{
		foreach ($array as $key => $value)
		{
			$arrange_array[$value['category_id']]['category_id'] = $value['category_id'];
			$arrange_array[$value['category_id']]['c_name'] = $value['c_name'];

			if($value['a_id'] != '')
			{
				$arrange_array[$value['category_id']]['content'][$value['a_id']]['a_id'] = $value['a_id'];
				$arrange_array[$value['category_id']]['content'][$value['a_id']]['name'] = $value['name'];
				$arrange_array[$value['category_id']]['content'][$value['a_id']]['file_name'] = $value['file_name'];
				$arrange_array[$value['category_id']]['content'][$value['a_id']]['path'] = $value['path'];
			}
			else
				$arrange_array[$value['category_id']]['content'] = array();

			$arrange_array[$value['category_id']]['content'] = array_merge($arrange_array[$value['category_id']]['content']);
		}

		return $arrange_array;
	}

	public function extname_excluding($fileName)
	{
		$dot = strrpos($fileName, '.');
		$last = $dot;
		$str = substr($fileName, 0, $last);
		return $str;
	}

	public function random_name($len)
	{
		$string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0000000000111111111222222223333333444444555556666777888999"; 
		$max_num=0;
		while(strlen($str)<$len)
		{
			$str='';
			for ($i=0; $i < $len; $i++) { 
				$str .= $string[rand() % strlen($string)];
			}
		}
		return $str;
	}

	public function stretch($type, $id)
	{
		switch ($type) {
			case 'g':
				$array = $this -> select_from('auth_category', array('category_id as id', 'c_name as name'), array('type' => '6', 'category_id' => $id, 'lang_type' => $this -> session -> userdata('lang')));
				break;
			
			case 'c':
				$array = $this -> select_from('archive', array('a_id as id', 'name' , 'enable'), array('a_id' => $id));
				break;
		}

		if (!empty($array))
			return $array;
		else
			return false;
	}

	public function sort_action($table, $ck_array = array())
	{
		if (!empty($ck_array))
		{
			switch ($table) {
				case 'auth_category':
					$target = 'category_id';
					break;
				
				case 'archive':
					$target = 'a_id';
					break;
			}
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set($table, array($target => $value), array('sort' => $key));
			}

			return true;
		}
		else
			return false;
	}
}