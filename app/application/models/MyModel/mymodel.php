<?php
class Mymodel extends MY_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	// 分頁搜尋資料查詢
	public function SelectPage($dbname, $filed = '*', $where = '', $order = '', $PageNum = '20')
	{
		$backdata = array();
		// 分頁程式 start
		$page = new page();
		$page->SetMySQL($this->db);
		$page->SetPagSize($PageNum);
		$qpage = $page->PageStar($dbname, '', $where);
		$backdata['PageList'] = $this->load->view('mypage/page', $qpage, true);
		//分頁程式 end

		$backdata['dbdata'] = $this->SelectSearch($dbname, $qpage['result'], $filed, $where, $order);
		return $backdata;
	}
	public function SelectSearch($table = "", $page = "", $filed = "*", $where = '', $order = '')
	{
		$sql = " select " . $filed . " from " . $table . " ";
		if (!empty($where)) {
			$sql .= $where;
		}

		if ($order != '') {
			$sql .= ' order by ' . $order;
		}
		$sql .= $page;
		$query = $this->db->query($sql)->result_array();
		return $query;
	}
	// 分頁專用
	public function select_page_form($table = "", $page = "", $filed = "*", $set = '', $order_id = "", $order_type = 'asc', $where_type = 'and')
	{
		$type = $where_type;
		$num = 0;
		$sql = " select " . $filed . " from " . $table . " ";
		if ($set != '') {
			foreach ($set as $key => $value) {
				if (!empty($value)) {
					$where_type = ($num == 0) ? 'where' : $type;
					$sql .= $where_type . ' ' . $key . '="' . $value . '"';
					$num++;
				}
			}
		}
		if ($order_id != '') {
			$sql .= ' order by ' . $order_id . ' ' . $order_type;
		}
		$sql .= $page;

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 分頁專用 可like
	public function select_page_form_like($table = "", $page = "", $filed = "*", $set = '',$like='', $order_id = "", $order_type = 'asc', $where_type = 'and')
	{
		$type = $where_type;
		$num = 0;
		$sql = " select " . $filed . " from " . $table . " ";
		if ($set != '') {
			foreach ($set as $key => $value) {
				if (!empty($value)) {
					$where_type = ($num == 0) ? 'where' : $type;
					$sql .= $where_type . ' ' . $key . '="' . $value . '"';
					$num++;
				}
			}
		}

		if ($like != '') {
			foreach ($like as $key => $value) {
				if ($value <> '') {
					$where_type = ($num == 0) ? 'where' : $type;
					
					$sql .= $where_type . ' ' . $key . ' like "%' . $value . '%"';
					$num++;
				}
			}
		}

		if ($order_id != '') {
			$sql .= ' order by ' . $order_id . ' ' . $order_type;
		}
		$sql .= $page;

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 分頁專用(where有值為0不會跳過)
	public function select_page_form_0($table = "", $page = "", $filed = "*", $set = '', $order_id = "", $order_type = 'asc', $where_type = 'and')
	{
		$type = $where_type;
		$num = 0;
		$sql = " select " . $filed . " from " . $table . " ";
		if ($set != '') {
			foreach ($set as $key => $value) {
				if ($value <> '') {
					$where_type = ($num == 0) ? 'where' : $type;
					$sql .= $where_type . ' ' . $key . '="' . $value . '"';
					$num++;
				}
			}
		}
		if ($order_id != '') {
			$sql .= ' order by ' . $order_id . ' ' . $order_type;
		}
		$sql .= $page;

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 分頁專用(where有值為0不會跳過) 可like
	public function select_page_form_0_like($table = "", $page = "", $filed = "*", $set = '', $like='', $order_id = "", $order_type = 'asc', $where_type = 'and')
	{
		$type = $where_type;
		$num = 0;
		$sql = " select " . $filed . " from " . $table . " ";
		if ($set != '') {
			foreach ($set as $key => $value) {
				if ($value <> '') {
					$where_type = ($num == 0) ? 'where' : $type;
					$sql .= $where_type . ' ' . $key . '="' . $value . '"';
					$num++;
				}
			}
		}

		if ($like != '') {
			foreach ($like as $key => $value) {
				if ($value <> '') {
					$where_type = ($num == 0) ? 'where' : $type;
					
					$sql .= $where_type . ' ' . $key . ' like "%' . $value . '%"';
					$num++;
				}
			}
		}

		if ($order_id != '') {
			$sql .= ' order by ' . $order_id . ' ' . $order_type;
		}
		$sql .= $page;

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//單筆資料查詢
	public function OneSearchSql($table = "", $filed = "*", $set = '', $where_type = 'and')
	{
		$sql = " select " . $filed . " from " . $table . " ";
		if ($set != '') {
			$sql .= " where 1=1 ";
			foreach ($set as $key => $value) {
				if (!empty($value))
					$sql .= $where_type . ' ' . $key . '="' . $value . '"';
			}
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	//抓取系統資料
	public function GetConfig($Type = '', $Cid = '', $Lang = 'TW')
	{
		$sql = 'select d_id,d_title,d_val,d_type from config';
		$sql .= ' where 1=1 ';
		if ($Lang != '')
			$sql .= ' and lang_type="' . $Lang . '"';
		if ($Cid != '') {
			$sql .= ' and d_id=?';
			$query = $this->db->query($sql, $Cid);
			return $query->row_array();
		}
		$sql .= ' and d_type=?';
		$query = $this->db->query($sql, $Type);
		return $query->result_array();
	}
	public function get_country_num()
	{
		$sql = "SELECT country_num,country_name FROM country_number where ";
		$sql .= " d_enable='Y'";
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 獲取所有city_category資料
	public function getCityCategory()
	{
		return $this->db->query('SELECT * FROM city_category')->result_array();
	}

	public function get_area_data($s_city_id = '0')
	{
		$sql = "SELECT s_id,s_name FROM city_category where ";
		$sql .= " s_city_id=" . $s_city_id;
		$sql .= " order by s_sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_zip_code($s_id = '')
	{
		$sql = "SELECT s_zipcode FROM city_category where ";
		$sql .= " s_id=" . $s_id;
		$query = $this->db->query($sql);
		return $query->row_object();
	}

	// 抓取會員常用寄貨地址list
	public function get_address_data($s_by_id = '0')
	{
		$sql = "SELECT d_id,name,telphone,c0.s_name as country,c1.s_name as city,c2.s_name as countory,address FROM address left join city_category as c0 on address.country=c0.s_id left join city_category as c1 on address.city=c1.s_id left join city_category as c2 on address.countory=c2.s_id where ";
		$sql .= " by_id=" . $s_by_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取會員常用寄貨地址單筆
	public function get_address_one_data($s_d_id = '0')
	{
		$sql = "SELECT d_id,name,telphone,zip,country,city,countory,address FROM address where ";
		$sql .= " d_id=" . $s_d_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取活動與報名表單list
	public function get_activity_data($s_category_id = '0')
	{
		$sql = "SELECT ufm_id,ufm_name FROM uform where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " and enable ='1' ";
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取友善連結list
	public function get_link_data($s_category_id = '0')
	{
		$sql = "SELECT name,content FROM ckeditor where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " and enable='1'";
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取影音專區list
	public function get_media_data($s_category_id = '0')
	{
		$sql = "SELECT name,content FROM ckeditor where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " and enable='1' ";
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取文件下載list
	public function get_archive_data($s_category_id = '0')
	{
		$sql = "SELECT name,path FROM archive where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " and enable='1' order by sort asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取最新消息目錄list
	public function get_news_data($s_category_id = '0')
	{
		//$sql="SELECT ck_id,name,content FROM ckeditor where ";
		//$sql.=" category_id=".$s_category_id;
		$sql = "SELECT enews_id,name,filename,content FROM enews where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " and enable = '1'";
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取最新消息單筆
	public function get_news_one_data($s_enews_id = '0', $s_language = 'TW')
	{
		$sql = "SELECT * FROM enews where ";
		$sql .= " enews_id=" . $s_enews_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取廣告banner目錄list
	public function get_banner_data($s_category_id = '0')
	{
		//$sql="SELECT ck_id,name,content FROM ckeditor where ";
		//$sql.=" category_id=".$s_category_id;
		$sql = "SELECT ebanner_id,name,filename,content FROM ebanner where ";
		$sql .= " category_id=" . $s_category_id;
		$sql .= " order by sort";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取廣告banner單筆
	public function get_banner_one_data($s_ebanner_id = '0', $s_language = 'TW')
	{
		$sql = "SELECT * FROM ebanner where ";
		$sql .= " ebanner_id=" . $s_ebanner_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取關於我們list
	public function get_about_data($s_language = 'TW')
	{
		$sql = "SELECT name, ck_id as did FROM ckeditor where ";
		$sql .= " type=1";
		$sql .= " and lang_type='" . $s_language . "'";
		$sql .= " and enable='1'";
		$sql .= " order by sort, ck_id asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取關於我們單筆
	public function get_about_one_data($s_ck_id = '0', $s_language = 'TW')
	{
		$sql = "SELECT * FROM ckeditor where ";
		$sql .= " ck_id=" . $s_ck_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取經營會員權益公告list
	public function get_announce_data($s_language = 'TW')
	{
		$sql = "SELECT name, ck_id as did FROM ckeditor where ";
		$sql .= " type=6";
		$sql .= " and lang_type='" . $s_language . "'";
		$sql .= " and enable='1'";
		$sql .= " order by sort, ck_id asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取經營會員權益公告單筆
	public function get_announce_one_data($s_ck_id = '0', $s_language = 'TW')
	{
		$sql = "SELECT * FROM ckeditor where ";
		$sql .= " ck_id=" . $s_ck_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取服務專區list
	public function get_service_data($s_language = 'TW')
	{
		$sql = "SELECT name, ck_id as did FROM ckeditor where ";
		$sql .= " type=3";
		$sql .= " and lang_type='" . $s_language . "'";
		$sql .= " and enable='1'";
		$sql .= " order by sort, ck_id asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取最新消息單筆
	public function get_service_one_data($s_ck_id = '0', $s_language = 'TW')
	{
		$sql = "SELECT * FROM ckeditor where ";
		$sql .= " ck_id=" . $s_ck_id . " and lang_type='" . $s_language . "' and type='3'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取相簿第2層list
	public function get_photo_data($s_type = "")
	{
		$sql = "SELECT img_id,img_path,img_note FROM images where ";
		$sql .= " type=" . $s_type;
		$sql .= " and enable = '1' order by sort, img_id asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取相簿第1層單筆
	public function get_photo_one_data($s_d_id = '0')
	{
		$sql = "SELECT * FROM photo_category where ";
		$sql .= " d_id=" . $s_d_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取上線合夥經營會員
	public function get_member_upline_name($s_by_id = '0')
	{
		$sql = "SELECT name FROM buyer WHERE by_id=(SELECT by_id from member WHERE member_id=(SELECT upline FROM member WHERE";
		$sql .= " by_id=" . $s_by_id;
		$sql .= "))";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// 抓取活躍指標最近一年資料
	public function get_member_active_indicator_data($s_member_id = '0')
	{
		$sql = "SELECT d_year,d_month,turnover,d_is_active FROM member_active_indicator where ";
		$sql .= " d_member_id=" . $s_member_id;
		$sql .= " and (d_year=YEAR(now()) and d_month<=MONTH(now())-1) or (d_year=YEAR(now())-1 and d_month>=MONTH(now()))";
		$sql .= " order by d_year,d_month";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取購物金
	public function get_shopping_money_data($s_guest_id = '0')
	{
		$sql = "select shopping_money.*,buyer.name from shopping_money left join buyer on shopping_money.d_member_id=buyer.by_id where";
		$sql .= " shopping_money.d_guest_id=" . $s_guest_id;
		$sql .= " order by create_time";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取buyer自己及下線
	public function get_downline_data($s_by_id = '0')
	{
		$sql = "select by_id,d_account,name from buyer where";
		$sql .= " by_id=" . $s_by_id;
		$sql .= " union select by_id,d_account,name from buyer where";
		$sql .= " PID=" . $s_by_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// 抓取bonus_pay_bank請款編號
	public function get_bonus_pay_bank_count($s_makedate = '')
	{
		$sql = "SELECT make_no FROM bonus_pay_bank WHERE";
		$sql .= " makedate='" . $s_makedate . "'";
		$sql .= " order by create_time desc";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	//抓取資料庫總數
	public function SqlTotal($table = '', $set = '', $where_type = 'and')
	{
		$type = $where_type;
		$sql = " select * from " . $table . " ";
		if ($set != '') {
			$sql .= " where 1=1 ";
			foreach ($set as $key => $value) {
				$sql .= $where_type . ' ' . $key . '="' . $value . '"';
			}
		}

		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	//由C寫入SQL指令
	public function WriteSQL($Sql, $Sign = '')
	{
		$query = $this->db->query($Sql);
		if (!empty($Sign))
			return $query->row_array();
		else
			return $query->result_array();
	}
	//由C寫入SQL指令
	public function SimpleWriteSQL($Sql)
	{

		$query = $this->db->query($Sql);
	}

	// 操寫LOG
	public function WriteLog($d_type, $d_content)
	{
		$data = array(
			'd_type' => $d_type,
			'd_content' => $d_content,
			'create_time' => date('Y-m-d H:i:s')
		);
		$this->InsertData('web_log', $data);
	}
	//新增資料
	public function InsertData($table, $indata)
	{
		$sql = 'INSERT INTO ' . $table . '';
		$sql .= " (`" . implode("`, `", array_keys($indata)) . "`)";
		$sql .= " VALUES ('" . implode("', '", $indata) . "') ";
		$success = $this->db->query($sql);
		$this->create_id = $this->db->insert_id();
		return $success;
	}
	//修改資料
	public function UpdateData($table, $udata, $where)
	{
		$sql = 'update ' . $table . ' set ';
		foreach ($udata as $key => $value) {
			if (isset($value))
				$sql .= $key . '=' . $this->db->escape($value) . ',';
		}
		$sql = substr($sql, 0, -1);
		$sql .= $where;
		return $this->db->query($sql);
	}

	public function search_session($search_default_array)
	{ //查詢整理
		$data = $this->check_session($search_default_array, "AT");
		if (!empty($_SESSION["AT"]["where"]["ToPage"])) { //給跳頁使用
			$_POST["ToPage"] = $_SESSION["AT"]["where"]["ToPage"];
		}
		return $data;
	}
	public function check_session($search_default_array, $ST)
	{ //查詢整理
		@session_start();
		if (Comment::SetValue("del_search") == "Y" || Comment::Set_GET("del_search") == "Y") { //每個功能轉換時將查詢資料清空
			$_SESSION[$ST]["where"] = array();
		}
		if (!empty($search_default_array)) {
			foreach ($search_default_array as $val) {
				if (!isset($_SESSION[$ST]["where"][$val])) {
					$_SESSION[$ST]["where"][$val] = "";
				}
				if (isset($_POST[$val])) {
					$_SESSION[$ST]["where"][$val] = Comment::SetValue($val);
				}
			}
		}
		return $_SESSION[$ST]["where"];
	}

	public function productsType()
	{ //產品分類		
		$sql = "SELECT * FROM `product_class` where lang_type ='$this->setlang' and PID = 0 and d_enable='Y' order by `prd_cid`";
		$query = $this->db->query($sql);
		$data['product_type1'] = $query->result();
		$sql2 = "SELECT * FROM `product_class` where lang_type ='$this->setlang' and PID <> 0 and d_enable='Y' order by `prd_cid`";
		$query2 = $this->db->query($sql2);
		$data['product_type2'] = $query2->result();
		$data_type = $this->load->view('index/product/product_type', $data, true);
		return $data_type;
	}
	public function productsTypeMenu()
	{ //產品分類		
		$sql = "SELECT `prd_cid`, `prd_cname`, `PID` FROM `product_class` where lang_type ='$this->setlang' and PID = 0 and d_enable='Y' order by `prd_cid`";
		$query = $this->db->query($sql);
		$data['product_type1'] = $product_type1 = $query->result();
		$sql2 = "SELECT `prd_cid`, `prd_cname`, `PID` FROM `product_class` where lang_type ='$this->setlang' and PID <> 0 and d_enable='Y' order by `prd_cid`";
		$query2 = $this->db->query($sql2);
		$data['product_type2'] = $query2->result();
		$data_type = $this->load->view('index/product/product_menu', $data, true);
		return $data_type;
	}

	public function productsType_img()
	{ //產品分類圖片		
		$sql = "SELECT `prd_cid`, `prd_cname`, `PID`, `prd_cimage` FROM `product_class` where lang_type ='$this->setlang' and PID = 0 and d_enable='Y' order by `prd_cid`";
		$query = $this->db->query($sql);
		$data['product_type1'] = $query->result();
		$sql2 = "SELECT `prd_cid`, `prd_cname`, `PID`, `prd_cimage` FROM `product_class` where lang_type ='$this->setlang' and PID <> 0 and d_enable='Y' order by `prd_cid`";
		$query2 = $this->db->query($sql2);
		$data['product_type2'] = $query2->result();
		$data_type = $this->load->view('index/product/product_type_img', $data, true);
		return $data_type;
	}
}
