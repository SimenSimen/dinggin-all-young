<?php
require_once('./application/core/MY_Sql.php');
class Gallery_model extends My_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function images_group_list($where)
	{
		$sql  = 'SELECT images.img_id, SUBSTR(images.img_path,2) AS img_path, images.sort, images.type ';
		$sql .= 'FROM photo_category LEFT JOIN images ON ';
		$sql .= 'images.type = photo_category.d_id ';
		$sql .= 'AND images.type = ? ';
		$sql .= 'ORDER BY images.sort, images.img_id ASC';
		
		// echo $sql; break;
		$query = $this -> db -> query($sql, $where);
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
				$array = $this -> select_from('photo_category', array('d_id as id', 'd_name as name'), array('d_id' => $id));
				break;
			
			case 'c':
				$array = $this -> select_from('images', array('img_id as id', 'img_note as name'), array('img_id' => $id));
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
				case 'photo_category':
					$target = 'd_id';
					$sign_id = 'd_sort';
					break;
				
				case 'images':
					$target = 'img_id';
					$select_cloumns = array('img_id', 'type');
					$update_sign = 'd_photo';
					$sign_id = 'sort';
					$m_table = 'photo_category';
					break;
			}
			$old = '';
			$i = 0;
			foreach ($ck_array as $key => $value)
			{
				$t = $this -> select_from($table, $select_cloumns, array($target => $value));
				if ($t['type'] != $old || $i == $key)
				{
					if (is_string($m_table))
					{
						if ($old != $t['type'])
							$update_sort = '*#' . $value;
						else
							$update_sort .= '*#' . $value;

						$old = $t['type'];
						$i = $i+1;
						
						$this -> update_set($m_table, array('d_id' => $old), array($update_sign => $update_sort));
					}
					
				}
				else
				{
					$update_sort = '*#' . $value;
				}
				$this -> update_set($table, array($target => $value), array($sign_id => $key));
			}
		}
		else
			return false;
	}
}