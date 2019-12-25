<?
class MY_Model extends CI_Model
{
	//語系id
	public $lang_id='';

    function __construct()
    {
        parent::__construct();
    }

	//----------------------------------------------------------------------------------- 
	// 函數名：lang_lists($lang_id='')
	// 作 用 ：語言設定
	// 參 數 ：$id 目標資料表名稱
	// 返回值：DB語言資料表或語言名稱
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function lang_lists($lang_id='')
	{
		if($id=='')
		{
			$query = $this->db->get('lang_list');
			$lang_list=$query->result_array();
			return $lang_list;
		}
		else
		{
			$sql='SELECT name FROM lang_list where lang_id='.$id;	
			$query = $this->db->query($sql);
			$name=$query->row_array();
			return $name;
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from($table, $data_where)
	// 作 用 ：取得資料庫指定內容
	// 參 數 ：$table 目標資料表名稱
	// $data_where 指定目標
	// 返回值：data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from($table, $data_where='')
	{
		if($data_where != '')
		{
			$this->db->where($data_where);
			$query = $this->db->get($table);
			return $query->row_array();
		}
		else
		{
			$query = $this->db->get($table);
			return $query->result_array();
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from_array($table, $data_where, $select_where)
	// 作 用 ：取得資料庫指定內容
	// 參 數 ：$table 目標資料表名稱
	// $data_where 指定目標
	// $select_where 查詢欄位
	// 返回值：多筆data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from_array($table, $data_where, $select_where='')
	{
		if($select_where != '')
		{
			$this->db->select($select_where);
			$query = $this->db->get_where($table, $data_where);
		}
		else
		{
			$query = $this->db->get_where($table, $data_where);
		}

		return $query->result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from_where($table, $select_columns, $data_where)
	// 作 用 ：取得資料庫指定內容
	// 參 數 ：$table 目標資料表名稱
	// $select_columns 查詢欄位
	// $data_where 指定條件
	// 返回值：data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from_where($table, $select_columns, $data_where='')
	{
		$this->db->select($select_columns);
		$this->db->where($data_where);
		$query = $this->db->get($table);
		return $query->row_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from($table, $order, $o_type, $data_where)
	// 作 用 ：取得資料庫指定內容-排序
	// 參 數 ：$table 目標資料表名稱
	// $order 排序目標
	// $o_type 排序類型
	// $data_where 指定目標
	// 返回值：data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from_order($table, $order, $o_type, $data_where='')
	{
		if(!empty($data_where))
			$this->db->where($data_where);
		$this->db->order_by($order, $o_type);
		$query=$this->db->get($table);
		$data=$query->result_array();
		return $data;
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_from_order_limit($table, $select_columns = '', $order, $o_type, $limit_num = '', $data_where = '')
	// 作 用 ：取得資料庫指定內容(限制筆數)-排序
	// 參 數 ：$table 目標資料表名稱
	// $select_columns 查詢欄位
	// $order 排序目標
	// $o_type 排序類型
	// $limit_num 限制個數
	// $data_where 指定目標
	// 返回值：data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_from_order_limit($table, $select_columns = '', $order, $o_type, $limit_num = '', $data_where = '')
	{
		if($select_columns != '')
			$this->db->select($select_columns);
		if(!empty($data_where))
			$this->db->where($data_where);
		$this->db->order_by($order, $o_type);
		if(!empty($limit_num))
			$this->db->limit($limit_num);
		$query=$this->db->get($table);
		$data=$query->result_array();
		return $data;
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：insert_into($table, $data) 
	// 作 用 ：新增一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $data 新增資料陣列
	// 返回值：資料流水號id
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function insert_into($table, $data, $data_where = '')
	{
		if($data_where != '')
			$this->db->where($data_where);
		$query = $this->db->get($table);
		$exists_check = $query->row_array();
		if((empty($exists_check) && $data_where != '') || $data_where == '') // 存在檢查 or 不檢查
		{

			$this->db->insert($table, $data);
			return $this->db->insert_id();

		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：update_set($table, $target_name, $target_id, $data)
	// 作 用 ：修改一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $target_name 指定修改目標的欄位名稱
	// $target_id 指定修改目標的id值
	// $data 修改資料陣列
	// 返回值：資料流水號id
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function update_set($table, $target_name, $target_id, $data)
	{

		$this->db->where($target_name, $target_id);
		return $this->db->update($table, $data);

	}
	//設定所有資料 慎用
	public function update_set_all($table, $data)
	{
		return $this->db->update($table, $data);
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：update_where_array_set($table, $target_array, $data)
	// 作 用 ：修改一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $target_array 指定修改目標的欄位名稱
	// $data 修改資料陣列
	// 返回值：資料流水號id
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function update_where_array_set($table, $target_array, $data)
	{
		$this->db->where($target_array);
		return $this->db->update($table, $data);
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：delete_where($table, $data_where)
	// 作 用 ：刪除一筆資料
	// 參 數 ：$table 目標資料表名稱
	// $data_where 指定刪除目標
	// 返回值：無
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function delete_where($table, $data_where)
	{
		$this->db->where($data_where);


		$this->db->delete($table); 
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：get_next_sort_num($table, $data_where)
	// 作 用 ：取得下一筆排序號
	// 參 數 ：$table 目標資料表名稱
	// $data_where 指定目標
	// 返回值：排序號
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function get_next_sort_num($table, $data_where)
	{
		$sql='
			SELECT *
			FROM  `'.$table.'`';
		foreach ($data_where as $key => $value)
		{
			if($key == 0)
			{
				$val=(is_numeric($value)) ? $value : '\''.$value.'\'';
				$sql.=' WHERE `'.$key.'` = '.$val.' ';
			}
			else
			{
				$sql.=' AND `'.$key.'` = '.$val.' ';
			}
		}
		$sql.=' ORDER BY  `prd_csort` DESC';

		$query=$this->db->query($sql);
		$data=$query->result_array();

		if(empty($data))
			return 0;
		else
			return ($data[0]['prd_csort'] + 1);
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：verify_domain($member_id)
	// 作 用 ：比對帳號是否與domain 相符合
	// 參 數 ：$member_id 會員編號
	// 返回值：true / false
	// 備 注 ：無 
	//-----------------------------------------------------------------------------------
	public function verify_domain($table, $data_where, $table2, $field_name, $direct_name = '')
	{
		if($data_where != '')
		{
			$this->db->where($data_where);
			$query = $this->db->get($table);
			// return $query->row_array();
			$row = $query->row_array();
			$this->db->where(array($field_name => $row[$field_name]));
			$query = $this->db->get($table2);
			$row = $query->row_array();
			
			if($direct_name == '')
				$url = $row[$table2];
			else
				$url = $row[$direct_name];

			$x_url = substr(base_url(), 7, -1);

			if(strnatcmp($url, $x_url) == 0)
				return true;
			else
				return false;
		}
		else
		{
			return false;
		}
	}

	static function SetValue($var)
	{
		if(isset($var))
		{
			if(!is_array($var))
			{
				$var = htmlentities($var);
				if(get_magic_quotes_gpc())
					$var = stripcslashes($var);


				return mysql_real_escape_string($var);
				// return $var;
			}
		}
	}
	//----------------------------------------------------------------------------------- 
	// 函數名：inner_join()
	// 作 用 ：合併兩個關聯資料表
	// 參 數 ：$sender_domain 寄件人信箱網域名
	// $Table1 目標資料表名稱
	// $Table2 目標資料表名稱
	// $select_where 查詢欄位
	// $data_where 指定目標
	// $relation 關聯欄位
	// 返回值：data陣列
	// 備 注 ：join 第三個參數來指定 join 的型態。
	// 		   left、right、outer、inner、left outer 以及 right outer
	//----------------------------------------------------------------------------------- 
	public function inner_join($Table1, $Table2, $select_where = '', $data_where, $relation)
	{
		if($select_where != '')
			$this->db->select($select_where);
		else
			$this->db->select('*');

		$this->db->from($Table1);
		$this->db->join($Table2, $Table1 .".". $relation ."=". $Table2 .".". $relation, 'inner');
		$this->db->where($data_where); 
		$query = $this->db->get();

		return $query->result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_query($sql)
	// 作 用 ：查詢 Queries
	// 參 數 ：$sql
	// 返回值：data陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function select_query($sql='',$data_where='',$endotherstr='') 
	{
		$sql=$sql.' '.$data_where.' '.$endotherstr;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：select_count($table, $data_where = '')
	// 作 用 ：計算筆數
	// 參 數 ：$table 資料表名稱
	// $data_where 欄位條件
	// 返回值：筆數數值
	// 備 注 ：無 
	//-----------------------------------------------------------------------------------
	public function select_count($table, $data_where = '')
	{
		$this->db->where($data_where);
		$this->db->from($table);
		$data = $this->db->count_all_results();
		return $data;
	}
// other methods here....

} 