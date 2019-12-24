<?php
class Generator_model extends MY_Model
{
	function __construct()
	{
		$this->load->database();
	}

	// 交叉查詢比對
	public function select_from_order_bwteen($table,  $order_by, $order_type, $data_where = '', $value1, $value2)
	{
		$sql='
			SELECT 	 *
			FROM  	 `'.$table.'`
		';

		if(!empty($data_where))
		{
			foreach ($data_where as $key => $value) 
			{
				switch ($key) {
					case 'order_id':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'product_flow':
						if(!empty($value))
							$sql .= ' AND `' .$key. '`=' .$value .'';
						break;
					case 'name':
						if(!empty($value))
							$sql .= ' AND `' .$key. '`LIKE "%' .$value .'%"';
						break;
					case 'pay_way_id':
						if(!empty($value))
							$sql .= ' AND `' .$key. '`=' .$value .'';
						break;
					case 'status':
						if(!empty($value))
							$sql .= ' AND `' .$key. '`=' .$value .'';
						break;
					case 'card_owner':
						$sql .= ' WHERE `'.$key.'` = '.$value.' ';
						break;
				}
			}
		}

		$sql .= ' AND `date` BETWEEN "'.$value1.'" AND "'.$value2.'"';

		$sql .= '
			ORDER BY `'.$order_by.'` '.$order_type.'
		';
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	// 訂單查詢，品項子查詢
	public function select_like_group_by($table, $order_by, $order_type, $data_where = '', $data_where1 = '', $startTime, $endTime)
	{
		$sql = 'SELECT order_id, date, name, total_price, id,
				(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.status AND d_type = 1) as status_name,
				(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.product_flow AND d_type = 0) as product_flow_name
				FROM `order` o WHERE id in
		';
		$sql .= '(
			SELECT oid
			FROM  	 `'.$table.'`
		';

		if(!empty($data_where))
		{
			foreach ($data_where as $key => $value) 
			{
				switch ($key) {
					case 'prd_name':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'card_owner':
						$sql .= ' WHERE `'.$key.'` = '.$value.' ';
						break;
				}
			}
		}

		$sql .= ' AND `date` BETWEEN "'.$startTime.'" AND "'.$endTime.'")';
		
		if(!empty($data_where1))
		{
			foreach ($data_where1 as $key => $value) 
			{
				switch ($key) {
					case 'email':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'phone':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'pay_way_id':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;
					case 'product_flow':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;
					case 'status':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;

				}
			}
		}

		$sql .= ' Group By `order_id`';

		$sql .= '
			ORDER BY `'.$order_by.'` '.$order_type.'
		';
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	public function get_order_details($oid)
	{
		$sql = '
			SELECT  prd_name as name,
				    price as amount,
				    number as quantity,
				    total_price as total
			FROM	`order_details`
			WHERE	oid = "'. $oid .'"
		';
		$query = $this -> db -> query($sql);
		$data = $query -> result_array();

		return $data;
	}

	// 訂單匯出(全)
	public function select_All_order($table, $order_by, $order_type, $data_where = '')
	{
		if(!empty($data_where))
		{
			$sql = 'SELECT o.*,
					(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.status AND d_type = 1) as status_name,
					(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.product_flow AND d_type = 0) as product_flow_name
					FROM `order` o WHERE id in
			';

			$sql .= '(
				SELECT oid
				FROM  	 `'.$table.'`
			';

			foreach ($data_where as $key => $value) 
			{
				switch ($key) {
					case 'card_owner':
						$sql .= ' WHERE `'.$key.'` = '.$value.' ';
						break;
				}
			}

			$sql .= ')';
			
			$sql .= ' Group By `order_id`';

			$sql .= '
				ORDER BY `'.$order_by.'` '.$order_type.'
			';
			$query = $this -> db -> query($sql);
			$data = $query -> result_array();
		}
		else
			$data = false;

		return $data;
	}

	// 訂單品項子查詢
	public function order_subquery($table, $order_by, $order_type, $data_where = '', $data_where1 = '', $startTime, $endTime)
	{
		// SELECT (SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.status AND d_type = 0) as status_name,
		// (SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.product_flow AND d_type = 1) as product_flow_name,
		// o.order_id FROM `order` o WHERE id in ( SELECT oid FROM `order_details` WHERE `card_owner` = 324 AND `date` BETWEEN "1448899200" AND "1452873599")
		// Group By `order_id` ORDER BY `date` desc
		
		$sql = 'SELECT o.*,
				(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.status AND d_type = 1) as status_name,
				(SELECT d_value FROM `db_project_config` d WHERE d.d_id = o.product_flow AND d_type = 0) as product_flow_name
				FROM `order` o WHERE id in
		';

		$sql .= '(
			SELECT oid
			FROM  	 `'.$table.'`
		';

		if(!empty($data_where))
		{
			foreach ($data_where as $key => $value) 
			{
				switch ($key) {
					case 'prd_name':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'card_owner':
						$sql .= ' WHERE `'.$key.'` = '.$value.' ';
						break;
				}
			}
		}

		$sql .= ' AND `date` BETWEEN "'.$startTime.'" AND "'.$endTime.'")';
		
		if(!empty($data_where1))
		{
			foreach ($data_where1 as $key => $value) 
			{
				switch ($key) {
					case 'email':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'phone':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` LIKE "%' .$value.'%"';
						break;
					case 'pay_way_id':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;
					case 'product_flow':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;
					case 'status':
						if(!empty($value))
							$sql .= 'AND `' .$key. '` = "' .$value.'"';
						break;

				}
			}
		}

		$sql .= ' Group By `order_id`';

		$sql .= '
			ORDER BY `'.$order_by.'` '.$order_type.'
		';
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}

	// 查詢帳號金流
	public function select_account_payment($member_id)
	{
		$sql = '
			SELECT 	pway_id, pway_name, pway_name_1, pway_name_2, pway_name_3
			FROM 	`payment_way`
			WHERE 	pway_id in
			(
				SELECT 	pway_id
				FROM 	`iqr_trans`
				WHERE 	cset_id in
				(
					SELECT 	cset_id
					FROM 	iqr_cart
					WHERE 	member_id = "' . $member_id . '"
				)
			)
		';

		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
}