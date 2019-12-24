<?php
class MY_Sql extends CI_Model
{
	
	function __construct()
	{
		$this -> load -> database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from($table, $select_characters, $characters_where, $data_type)
	// 作 用 ：取得資料庫指定內容
	// 參 數 ：$table     目標資料表名稱
	// $select_characters 查詢欄位 [Array]
	// $characters_where  指定目標 [Array]
	// $data_type         回傳格式 [row (單筆) / array (陣列)]
	// 返回值：data 陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from($table, $select_characters = array(), $characters_where = array(), $data_type = '')
	{
		if (!empty($select_characters) && !empty($characters_where))
		{
			$this -> db -> select($select_characters);
			$this -> db -> where($characters_where);
			$query = $this -> db -> get($table);
		}
		elseif (!empty($select_characters) && empty($characters_where))
		{
			$this -> db -> select($select_characters);
			$query = $this -> db -> get($table);
		}
		elseif (empty($select_characters) && !empty($characters_where))
		{
			$this -> db -> where($characters_where);
			$query = $this -> db -> get($table);
		}
		else
			$query = $this -> db -> get($table);

		switch ($data_type) {
			case 'row':
				return $query -> row_array();
				break;
			case 'array':
				return $query -> result_array();
				break;
			default:
				return $query -> row_array();
				break;
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_where_in($table, $select_characters, $character, $characters_where_in)
	// 語法  ：SELECT * FROM Table WHERE Character IN (Where_In_Condition)
	// 作 用 ：取得資料庫指定內容
	// 參 數 ：$table 		目標資料表名稱
	// $select_characters 	查詢欄位 [Array]
	// $character 			指定目標欄位 
	// $characters_where_in 指定欄位 [Array]
	// 返回值：data 陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_where_in($table, $select_characters = array(), $character, $characters_where_in = array())
	{
		if (!empty($select_characters) && !empty($characters_where_in) && isset($character))
		{
			$this -> db -> select($select_characters);
			$this -> db -> where_in($character, $characters_where_in);
			$query = $this -> db -> get($table);
		}
		elseif (empty($select_characters) && !empty($characters_where_in) && isset($character))
		{
			$this -> db -> where_in($character, $characters_where_in);
			$query = $this -> db -> get($table);
		}
		else
			return 'Format Error';

		return $query -> result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from_order_limit($table, $selcet_characters, $data_where, $order, $o_type, $limit_num)
	// 作 用 ：取得資料庫指定內容[限制筆數]-排序
	// 參 數 ：$table 目標資料表名稱
	// $selcet_characters 查詢欄位 [Array]
	// $order 			  排序目標 [($o_type == 'random') ? $order = ''; ]
	// $o_type 			  排序類型 [asc, desc, random]
	// $data_where 		  指定目標 [Array]
	// $limit_num 		  限制個數
	// 返回值：data 陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from_order_limit($table, $selcet_characters = array(), $data_where = array(), $order = '', $o_type, $limit_num = '')
	{
		if(!empty($selcet_characters))
			$this -> db -> select($selcet_characters);

		if(!empty($data_where))
			$this -> db -> where($data_where);

		if(!empty($limit_num))
			$this->db->limit($limit_num);

		$this -> db -> order_by($order, $o_type);
		$query = $this -> db -> get($table);
		$data = $query -> result_array();
		return $data;
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：insert_into($table, $insert_data, $data_where) 
	// 作 用 ：新增一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $insert_data   新增資料陣列 [Array]
	// $data_where	  比對條件 [Array]
	// 返回值：資料流水號 ID / (Exception) Data Exist
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function insert_into($table, $insert_data = array(), $data_where = array())
	{
		if(!empty($data_where))
			$this -> db -> where($data_where);
		
		$query = $this -> db -> get($table);
		$exists_check = $query -> row_array();

		// 存在檢查, 不檢查
		if((empty($exists_check) && !empty($data_where)) || empty($data_where)) 
		{
			$this -> db -> insert($table, $insert_data);
			return $this -> db -> insert_id();
		}
		else
		{
			return 'Data Exist';
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：insert_batch($table, $insert_data) 
	// 作 用 ：新增多筆資料
	// 參 數 ：$table 目標資料表名稱
	// $insert_data   新增資料陣列 [Array]
	// 返回值：新增筆數 / false
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function insert_batch($table, $insert_data = array())
	{
		if(!empty($insert_data))
		{
			return $this -> db -> insert_batch($table, $insert_data);
		}
		else
		{
			return false;
		}
	}
	
	//----------------------------------------------------------------------------------- 
	// 函數名：update_set($table, $target_array, $data)
	// 作 用 ：修改一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $target_array  指定修改目標的欄位名稱 [Array]
	// $data          修改資料陣列 [Array]
	// 返回值：資料流水號id
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function update_set($table, $target_array = array(), $data = array())
	{
		$this -> db -> where($target_array);
		return $this -> db -> update($table, $data);
	}
	//設定所有資料 慎用
	public function update_set_all($table, $data)
	{
		return $this -> db -> update($table, $data);
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：delete_where($table, $data_where)
	// 作 用 ：刪除一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $data_where 指定刪除目標 [Array]
	// 返回值：無
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function delete_where($table, $data_where = array())
	{
		$this -> db -> where($data_where);
		$this -> db -> delete($table); 
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：inner_join($Table1, $Table2, $selcet_characters, $data_where, $relation)
	// 作 用 ：合併兩個關聯資料表
	// 參 數 ：$sender_domain 寄件人信箱網域名
	// $Table1 目標資料表名稱
	// $Table2 目標資料表名稱
	// $selcet_characters 查詢欄位 [Array]
	// $data_where 指定目標 [Array]
	// $relation 關聯欄位
	// $data_type [row, array]
	// 返回值：data陣列
	// 備 注 ：join 第三個參數來指定 join 的型態。
	// 		   left、right、outer、inner、left outer 以及 right outer
	//----------------------------------------------------------------------------------- 
	public function inner_join($Table1, $Table2, $selcet_characters = array(), $data_where = array(), $relation, $data_type = '')
	{
		if(!empty($selcet_characters))
			$this -> db -> select($selcet_characters);
		else
			$this -> db -> select('*');

		$this -> db -> from($Table1);
		$this -> db -> join($Table2, $Table1 .".". $relation ."=". $Table2 .".". $relation, 'inner');
		$this -> db -> where($data_where); 
		$query = $this -> db -> get();

		if($data_type == 'row')
			return  $query -> row_array();
		else
			return $query -> result_array();
	}

	public function inner_join_order_by($Table1, $Table2, $selcet_characters = array(), $data_where = array(), $relation,  $order, $o_type, $data_type = '')
	{
		if(!empty($selcet_characters))
			$this -> db -> select($selcet_characters);
		else
			$this->db->select('*');

		$this -> db -> from($Table1);
		$this -> db -> join($Table2, $Table1 .".". $relation ."=". $Table2 .".". $relation, 'inner');
		$this -> db -> where($data_where);
		$this -> db -> order_by($order, $o_type);
		$query = $this -> db -> get();

		if($data_type == 'row')
			return  $query -> row_array();
		else
			return $query -> result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_count($table, $data_where)
	// 作 用 ：計算筆數
	// 參 數 ：$table 資料表名稱
	// $data_where 欄位條件
	// 返回值：筆數數值
	// 備 注 ：無 
	//-----------------------------------------------------------------------------------
	public function select_count($table, $data_where = array())
	{
		$this -> db -> where($data_where);
		$this -> db -> from($table);
		$data = $this -> db -> count_all_results();
		return $data;
	}
}