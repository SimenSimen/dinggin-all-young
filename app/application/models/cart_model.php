<?php

class Cart_model extends MY_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function insertOrder($post_arr, $order_data)
	{
		$by_id	=	$post_arr['by_id'];

		$insert_data = array(
			'by_id'			=> $by_id,
			'member_id'		=> $order_data['account'],
			'bonus'			=> $order_data['bonus'],
			'total_price'	=> $order_data['totalPrice'],
			'pay_price'		=> $order_data['priceSum'],
			'total_pv'		=> $order_data['total_pv'],
			'price_money'	=> $order_data['price_money'],
			'use_dividend'	=> $order_data['use_dividend'],
			'use_dividend_cost'	=> $order_data['use_dividend_cost'],
			'use_shopping_money' => $order_data['use_shopping_money'],
			'name'			=> $order_data['name'],
			'email'			=> $order_data['email'],
			'phone'			=> $order_data['phone'],
			'zip'			=> $order_data['zip'],
			'country'		=> $order_data['country'],
			'county'		=> $order_data['county'],
			'area'			=> $order_data['area'],
			'address'		=> $order_data['address'],
			'buyer_note'		=> $order_data['buyer_note'],
			'receipt_title'		=> $order_data['receipt_title'],
			'receipt_code'		=> $order_data['receipt_code'],
			'receipt_zip'		=> $post_arr['receipt_zip'],
			'receipt_address'	=> $post_arr['receipt_address'],
			'pay_way_id'	=> $post_arr['pway_id'],
			'lway_price'	=> $order_data['shipCost'],
			'atmpayment'	=> $order_data['atmpayment'],
			'lway_id'		=> $post_arr['lway_id'],
			'shop_id'		=> $post_arr['shop_id'],
			'date'			=> $post_arr['date'],
			'invoice_type' => $order_data['invoice_type'],
			'carrier_type' => $order_data['carrier_type'],
			'carrier_number' => $order_data['carrier_number'],
			'create_time'	=> $this->useful->get_now_time()
		);
		$data_array1 = array();
		foreach ($insert_data as $key => $value) {
			$data_array1[] = $key . " = '" . $value . "'";
		}
		$sql = 'INSERT INTO `order` SET ' . implode(", ", $data_array1);
		$this->db->query($sql);
		$oid = $this->db->insert_id();
		//扣除點數			
		$use_dividend	=	$order_data['use_dividend'];
		$use_shopping_money = $order_data['use_shopping_money'];

		// 購買獲得紅利
		$d_dividend = $post_arr['d_dividend'];

		$sql = "UPDATE `buyer` SET d_dividend = d_dividend - ?, d_shopping_money = d_shopping_money - ? where `by_id` = ?";
		$query = $this->db->query($sql, [$use_dividend, $use_shopping_money, $by_id]);

		return $oid;
	}
	public function insertOrderDetail($oid, $order_id, $post_arr, $productList, $priceSum)
	{
		foreach ($productList as $key => $value) {
			$insert_data = array(
				'oid'			=> $oid,
				'prd_id'		=> $value['prd_id'],
				'supplier_id'	=> $value['supplier_id'],
				'by_id'			=> $post_arr['by_id'],
				'order_id'		=> $order_id,
				'prd_name'		=> $value['prd_name'],
				'prd_spec'		=> $value['spec_name'],
				'number'		=> $value['num'],
				'price'			=> $value['price'],
				'total_price'	=> $value['total'],
				'date'			=> date("Y-m-d h:i:sa"),
				'create_time'	=> date("Y-m-d h:i:sa"),
				'card_owner'	=> ''
			);
			$this->insert_into('order_details', $insert_data);
		}
		$sql = "UPDATE `order` SET order_id = '$order_id' where `id`= $oid";
		$query = $this->db->query($sql);
		return;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：make_random_cset_code($len)
	// 作 用 ：產生隨機商店代碼
	// 參 數 ：$len 代碼長度
	// 返回值：商店代碼
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function make_random_cset_code($len)
	{
		$string = "0000000000111111111222222223333333444444555556666777888999";
		$max_num = 0;
		while (strlen($str) < $len) {
			$str = '';
			do {
				$max_num++;
				for ($i = 0; $i < $len; $i++) {
					$pos  = rand(0, strlen($string));
					$str .= $string{
					$pos};
				}

				$sql = 'select * from `iqr_cart` where `cset_code`=\'' . $str . '\';';
				$query = $this->db->query($sql);
				$data = $query->result_array();
			} while (!empty($data) && $max_num < 1000);
		}
		return $str;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：get_random_data($table, $data_where='', $num)
	// 作 用 ：隨機選取n筆資料
	// 參 數 ：$table 表名
	// $data_where 條件
	// $except 否定條件
	// $num 筆數
	// 返回值：data array
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function get_random_data($table, $data_where = '', $except = '', $num) //資料列表
	{
		$sql = 'select * from `' . $table . '`';
		if (!empty($data_where)) {
			$index = 0;
			foreach ($data_where as $key => $value) {
				$mark = ($except[$index] == 0) ? '' : '!';
				if ($index == 0) {
					$sql .= ' WHERE `' . $key . '` ' . $mark . '= "' . $value . '"';
				} else {
					$sql .= ' AND `' . $key . '` ' . $mark . '= "' . $value . '"';
				}
				$index++;
			}
		}
		$sql .= ' order by rand() limit ' . $num;

		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：get_county()
	// 作 用 ：取出縣市資料
	// 參 數 ：無
	// 返回值：county array
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function get_county()
	{
		$sql = 'SELECT distinct `county` FROM `twzipcode` order by `id` asc';
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//-----------------------------------------------------------------------------------
	// 函數名：get_history()
	// 作 用 ：取出訂購歷史紀錄(不重複)
	// 參 數 ：$by_id 訂購人id
	// 返回值：history data
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function get_history($by_id)
	{
		$sql = 'SELECT * FROM `order` WHERE `by_id` = ' . $by_id . ' group by `name`, `phone`, `email`, `zip` order by `date` desc';
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//-----------------------------------------------------------------------------------
	// 函數名：get_range_data($table, $order_by, $order_type, $start_id = 0, $real_per_num = 8)
	// 作 用 ：取得範圍資料
	// 參 數 ：
	// $table 		 資料表名稱
	// $order_by	 依據欄位排序
	// $order_type 	 排序類型
	// $start_id 	 資料起始id
	// $real_per_num 該頁實際數量
	// 返回值：$data
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function get_range_data($table, $order_by, $order_type, $start_id = 0, $real_per_num = 8, $where_array = '')
	{
		$start_id = ($start_id >= 0) ? $start_id : 0;
		$sql = '
			SELECT 	 *
			FROM  	 `' . $table . '`
		';
		if (!empty($where_array)) {
			$index = 0;
			foreach ($where_array as $key => $value) {
				if ($index > 0) {
					$sql .= 'AND  `' . $key . '` = ' . $value . ' ';
				} else {
					$sql .= 'WHERE  `' . $key . '` = ' . $value . ' ';
				}
				$index++;
			}
		}
		$sql .= '
			ORDER BY `' . $order_by . '` ' . $order_type . '
			Limit	 ' . $start_id . ', ' . $real_per_num . '
		';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：upload_pic($pic_file)
	// 作 用：上傳圖片
	// 參 數：$pic_file = $_FILES['xxx'] => input 傳入檔案
	// $path 存檔dir路徑
	// 返回值：檔案路徑
	// 備 注：無
	//-----------------------------------------------------------------------------------
	public function upload_pic($pic_file, $path, $name = '')
	{
		//允許的副檔名
		$allowedExts = array("jpg", "png", "jpeg", "gif", "bmp");
		//檢查檔名合法
		$chk_file_ext = $this->check_extend_name($pic_file['name'], $allowedExts);

		if ($chk_file_ext == 1) {
			$lastdot = strrpos($pic_file['name'], "."); //取出.最後出現的位置
			$extended = substr($pic_file['name'], $lastdot); //取出副檔名
			if ($name == '') {
				$doc_name = md5(uniqid(rand())) . $extended;  /*產生唯一的檔案名稱*/
			} else {
				$doc_name = $name . $extended;  /*產生唯一的檔案名稱*/
			}
			move_uploaded_file($pic_file["tmp_name"], $path . $doc_name);
			// chmod($path.$doc_name, 0755);

			$data = array(
				"path"	=>  $path . $doc_name,
				"error" => 	''
			);

			return $data;
		} else {
			$data = array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//-----------------------------------------------------------------------------------
	// 函數名：check_extend_name($c_filename,$a_extend)
	// 作 用：上傳文件的副檔名判斷
	// 參 數：$c_filename 上傳的檔案名
	// $a_extend 要求的副檔名
	// 返回值：布林值
	// 備 注：無
	//-----------------------------------------------------------------------------------
	function check_extend_name($c_filename, $a_extend)
	{
		if (strlen(trim($c_filename)) < 5) {
			return 0; //返回0表示沒上傳圖片
		}

		$lastdot = strrpos($c_filename, "."); //取出.最後出現的位置
		$extended = substr($c_filename, $lastdot + 1); //取出副檔名

		for ($i = 0; $i < count($a_extend); $i++) //進行檢測
		{
			if (trim(strtolower($extended)) == trim(strtolower($a_extend[$i]))) //轉換大小寫並檢測
			{
				$flag = 1; //加成功標誌
				$i = count($a_extend); //檢測到了便停止檢測
			}
		}

		if ($flag <> 1) {
			for ($j = 0; $j < count($a_extend); $j++) //列出允許上傳的副檔名種類
			{
				$alarm .= $a_extend[$j] . " ";
			}
			return -1; //返回-1表示上傳圖片的類型不符
		}

		return 1; //返回1表示圖片的類型符合要求
	}

	//	貨品模糊查詢結果數量
	//	20180221 新增$d_spec_type(特殊身分才看得到的產品)
	//	20180511 新增$price_start,$price_end(價錢區間)$prd_sort(排序)$prd_type(類別)$setlang(語系)
	public function select_from_order_with_like($table, $order_by, $order_type, $data_where = '', $member_id, $d_spec_type, $price_start = 0, $price_end = 0, $prd_sort = '', $prd_type = '', $setlang)
	{
		$sql = 'SELECT * FROM	 `' . $table . '`';
		if (!empty($data_where)) {
			$num = 0;
			foreach ($data_where as $key => $value) {
				if ($value && $num == 0)
					$value = '\'' . '%' . $value . '%' . '\'';
				if ($num == 0)
					$sql .= ' WHERE `' . $key . '` LIKE ' . $value . ' ';
				else
					$sql .= ' AND `' . $key . '` = ' . $value . ' ';
				$num++;
			}
		}

		$price = ($d_spec_type == 1) ? 'd_mprice' : 'prd_price00';
		if ($d_spec_type == 1) {
			$sql .= " AND `lang_type` = '$setlang' AND `d_enable` = 'Y'";
		} else {
			$sql .= " AND `lang_type` = '$setlang' AND `is_vip` = 'N' AND `d_enable` = 'Y'";
		}
		if (!empty($price_start) and !empty($price_end)) {
			$sql .= " AND  `$price` between $price_start and $price_end";
		} else if (!empty($price_start)) {
			$sql .= " AND  `$price` >= $price_start";
		} else if (!empty($price_end)) {
			$sql .= " AND  `$price` <= $price_end";
		}
		if (!empty($prd_type)) {
			$sql .= " AND  `prd_cid` = $prd_type";
		}
		if ($prd_sort == 'prd_new') {
			$order_by = 'prd_sort';
			$order_type = ' ASC';
		} else if ($prd_sort == 'price_acs') {
			$order_by = $price;
			$order_type = ' ASC';
		} else if ($prd_sort == 'price_decs') {
			$order_by = $price;
			$order_type = ' DESC';
		} else {
			$order_by = 'prd_id';
			$order_type = ' DESC';
		}

		$sql .= '	ORDER BY `' . $order_by . '` ' . $order_type;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	public function init_pagination($uri, $total_rows, $per_page = 10, $uri_segment = 3)
	{
		$this->load->library('pagination');
		$this->load->helper('url');

		$config['per_page']          = $per_page;
		$config['uri_segment']       = $uri_segment;
		$config['base_url']          = base_url() . $uri;
		$config['total_rows']        = $total_rows;
		$config['use_page_numbers']  = TRUE;
		$config['total_page']		 = ($config['total_rows'] % $config['per_page'] == 0) ? $config['total_rows'] / $config['per_page'] : intval($config['total_rows'] / $config['per_page']) + 1;

		$config['first_tag_open'] 	 = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open']  = $config['num_tag_open']  = '<li>';
		$config['first_tag_close'] 	 = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] 	 = "<li><span><b>";
		$config['cur_tag_close'] 	 = "</b></span></li>";

		$this->pagination->initialize($config);

		return $config;
	}

	public function range_data($table, $order_by, $order_type, $start_id, $real_per_num = 5, $where_array = '')
	{
		$sql = '
			SELECT 	 *
			FROM  	 `' . $table . '`
		';
		if (!empty($where_array)) {
			$index = 0;
			foreach ($where_array as $key => $value) {
				if ($index > 0) {
					$sql .= 'AND  `' . $key . '` = ' . $value . ' ';
				} else {
					$sql .= 'WHERE  `' . $key . '` = ' . $value . ' ';
				}
				$index++;
			}
		}
		$sql .= '
			ORDER BY `' . $order_by . '` ' . $order_type . '
			Limit	 ' . $start_id . ', ' . $real_per_num . '
		';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：trigger_prd_detail
	// 作 用： 購物商品詳細內容 (副訂單)
	// 參 數：$user_cart  產品陣列
	// $oid 			  主訂單流水號
	// $by_id 			  買家編號
	// $order_random_id   主訂單編號
	// $card_owner 		  賣家編號
	// 返回值：新增購物車副訂單
	// 備 注：無
	//-----------------------------------------------------------------------------------
	public function trigger_prd_detail($user_cart, $oid, $by_id, $order_random_id, $createTime, $card_owner)
	{
		foreach ($user_cart as $key => $value) {
			// explode => 0 -> id, 1 -> num
			$explode = explode("*#", $value);
			$prd = $this->mod_cart->select_from('products', array('prd_id' => $explode[0]));
			$insert_data = array(
				'oid'			=> $oid,
				'prd_id'		=> $prd['prd_id'],
				'by_id'			=> $by_id,
				'order_id'		=> $order_random_id,
				'prd_name'		=> $prd['prd_name'],
				'number'		=> $explode[1],
				'price'			=> $prd['prd_price00'],
				'total_price'	=> $explode[1] * $prd['prd_price00'],
				'date'			=> $createTime,
				'card_owner'	=> $card_owner
			);
			$id = $this->insert_into('order_details', $insert_data);
		}
		return $id;
	}

	public function get_order_details($oid)
	{
		$sql = 'SELECT  prd_name as name,
					    price as amount,
					    number as quantity,
					    total_price as total
				FROM	`order_details`
				WHERE	oid = "' . $oid . '"
		';
		$query = $this->db->query($sql);
		$data = $query->result_array();

		return $data;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：products_insert_views
	// 作 用： 新增產品點擊率
	// 參 數：$table  	  資料表名稱
	// $data_array 		  資料陣列
	// 返回值：無
	// 備 注：無
	//-----------------------------------------------------------------------------------
	public function products_insert_views($table, $data_array = array())
	{
		if (!empty($data_array)) {
			$data_array1 = array();
			foreach ($data_array as $key => $value) {
				$data_array1[] = $key . " = '" . $value . "'";
			}
			$sql = 'INSERT INTO ' . $table . ' SET ' . implode(", ", $data_array1);
			$this->db->query($sql);
		}
	}


	// 20160706-取得以購買此商品數量
	// public function get_order_num($by_id,$oid){
	// 	$sql='select sum(od.number) as osum  from `order` o';
	// 	$sql.=' left join order_details od on od.order_id=o.order_id';
	// 	$sql.=' where o.product_flow in (0,1,2,4,7,6) and o.status in (0,1)';
	// 	$sql.=' and od.by_id='.$by_id.' and od.prd_id='.$oid.'';
	// 	$query = $this -> db -> query($sql);
	// 	return $query -> row_array();
	// }
	public function get_order_num($by_id, $prd_id)
	{
		$sql = 'select details from `order` where details like "%++' . $prd_id . '*%" and by_id="' . $by_id . '" and `status` in (0,1) and product_flow in (0,1,2,4,7,6)';
		$query = $this->db->query($sql)->result_array();
		$num = 0;
		foreach ($query as $key => $value) {
			$odata = explode('*#', $value['details']);
			$num += $odata[1];
		}
		return $num;
	}
}
