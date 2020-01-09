<?
class Useful extends MY_Model
{
	public function __construct()//初始化
	{
		parent::__construct();
	
		$this->load->model('language_model', 'mod_language');
		$lang = $this->mod_language->converter('20', $this->session->userdata('lang'));
		$this->data = array_merge($this->data, $lang);
	}

	//前台基本設定
	public function iconfig()
	{
		@session_start();
		$this->load->model('member_model', 'mmodel');
		if ($_SESSION['MT']['by_id'] == '') {
			$this->AlertPage('/gold/index/' . $_SESSION['AT']['account'] . '', '操作錯誤，請重新登入');
			return '';
		}
	}

	//分頁專用
	public function SetPage($sql, $Topage, $pagsize = '20', $cond = '', $WhereType = 'and', $STotal = '')
	{
		$this->load->library('/mylib/page');
		$page = new page();
		$page->SetPagSize($pagsize);
		$page->SetMySQL($this->db);
		$qpage = $page->PageStar($sql, $Topage, $cond, $WhereType, $STotal);
		return $qpage;
	}

	//分頁專用(where有值為0不會跳過)
	public function SetPage_0($sql, $Topage, $pagsize = '20', $cond = '', $WhereType = 'and', $STotal = '')
	{
		$this->load->library('/mylib/page');
		$page = new page();
		$page->SetPagSize($pagsize);
		$page->SetMySQL($this->db);
		$qpage = $page->PageStar_0($sql, $Topage, $cond, $WhereType, $STotal);
		return $qpage;
	}


	public function get_page($qpage)
	{
		$qpage['lang'] = $this->data;
		$data = $this->load->view('mypage/page.php', $qpage, true);
		return $data;
	}

	//分頁專用 (新切板前台)
	public function setPageJcy($sql, $Topage, $pagsize = '20', $cond = '', $WhereType = 'and', $STotal = '')
	{
		$this->load->library('/mylib/PageJcy');
		$page = new pagejcy();
		$page->SetPagSize($pagsize);
		$page->SetMySQL($this->db);
		$qpage = $page->PageStar($sql, $Topage, $cond, $WhereType, $STotal);
		return $qpage;
	}

	public function getPageJcy($qpage)
	{ //新切板前台的頁碼
		$data = $this->load->view('mypage/pagejcy.php', $qpage, true);
		return $data;
	}

	//寫入LOG資料表
	public function write_log($d_type, $d_text)
	{
		$logdata = array(
			'd_type' => $d_type,
			'd_text' => $d_text,
			'create_time' => $this->useful->get_now_time(),
			'last_ip' => $this->useful->get_ip(),
		);
		$this->load->model('jur_model', 'jmodel');
		$this->jmodel->insert_into('event_log', $logdata);
	}

	//產生寫入資料庫的陣列
	public function DB_Array($POST, $Create = "")
	{
		$this->load->library('/mylib/comment');
		$Array = array();
		foreach ($POST as $key => $value) {
			$val = Comment::SetValue($key);
			$Array += array($key => $val);
		}
		if ($Create != "") {
			$Array += array('create_time' => $this->get_now_time());
		}
		$Array += array('update_time' => $this->get_now_time());
		return $Array;
	}

	//取得現在日期
	public function get_now_date()
	{
		date_default_timezone_set("Asia/Taipei");
		return date('Y-m-d');
	}

	//取得現在時間
	public function get_now_time()
	{
		date_default_timezone_set("Asia/Taipei");
		return date('Y-m-d H:i:s');
	}
	//取得來源IP
	public function get_ip()
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (!empty($_SERVER["REMOTE_ADDR"])) {
			$cip = $_SERVER["REMOTE_ADDR"];
		} else {
			$cip = "無法取得IP位址！";
		}
		return $cip;
	}

	//取得訂單編號(通用)
	public function get_order_num($Mid = '', $Order_id = '')
	{
		date_default_timezone_set("Asia/Taipei");
		return date('YmdHis') . $Mid . $Order_id;
	}

	//是否有登入
	public function is_login($Login, $Link = '')
	{
		echo $Login;
		if ($Login == '') {
			echo '<script>alert("請先登入會員!");window.location.href="/gold/login"</script>'; //index/login
			if ($Link != '')
				$_SESSION['LoginLink'] = $Link;
		}
	}

	// 文字編輯器
	public function CKediter($push_path)
	{
		// ckeditor 文字編輯器
		$this->create_dir($push_path . 'ckfinder_image/');
		$this->start_session(3600);
		$_SESSION['member_id']     = '1';
		$_SESSION['IsAuthorized']  = true;
		$_SESSION['ckeditor_url']  = str_replace(".", "", $push_path) . 'ckfinder_image';
		session_write_close();

		// ckeditor 文字編輯器
	}

	//亂數密碼產生
	public function generatorPassword($number)
	{
		$password_len = $number;
		$password = '';
		// remove o,0,1,l
		$word = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
		$len = strlen($word);
		for ($i = 0; $i < $password_len; $i++) {
			$password .= $word[rand() % $len];
		}
		return $password;
	}
	//亂數+時間產生亂數
	public function RandTimeNumber($number, $num)
	{
		$password_len = $number;
		$password = '';
		// remove o,0,1,l
		$word = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
		$len = strlen($word);
		for ($i = 0; $i < $password_len; $i++) {
			$password .= $word[rand() % $len];
			$rand = substr(md5(date('Ymdhis') . microtime('true') . $password . $num), 0, 14);
		}
		return $rand;
	}

	//權限判斷
	public function CheckComp($comp)
	{
		@session_start();

		// if(!isset($_SESSION['AT']['action_list'])){
		// 	echo '<script>alert("連線逾時，請重新登入");window.location.href="/index/logout";</script>';
		// 	return '';
		// }
		$action_list = isset($_SESSION['AT']['action_list']) ? $_SESSION['AT']['action_list'] : "";
		// !strpos(',' .$action_list. ',', ',' . $comp . ',') 用法錯誤
		if ($action_list == '') {
			echo '<script>alert("連線逾時，請重新登入");top.window.location.href="/index/logout"; </script>';
			return '';
		} elseif (strpos(',' . $action_list . ',', ',' . $comp . ',') === false) {
			echo '<script>alert("沒有此權限");window.location.href="/admin/panel"; </script>';
			return '';
		}

		if (!empty($_GET['menu_title'])) {
			$menu_title = $_GET['menu_title'];
			$_SESSION['AT']['menu_title'] = $menu_title;
		}
	}

	//權限設定
	public function set_jur($type = '')
	{
		$this->load->model('jur_model', 'jmodel');
		$data = $this->jmodel->get_jur();
		$action_code_all = "";
		foreach ($data as $key => $value) {
			$cdata = $this->jmodel->get_jur($value['d_id']);

			foreach ($cdata as $ckey => $cvalue) {
				// 20160524
				if (strpos(',' . $_SESSION['AT']['action_list'] . ',', ',' . $cvalue['d_code'] . ',') !== false or $type != '') {
					$sdata[$value['d_name']][] = array(
						'd_code' => $cvalue['d_code'],
						'd_name' => $cvalue['d_name'],
						'd_link' => $cvalue['d_link'],
					);
					$action_code_all .= $cvalue['d_code'] . ',';
				}
			}
			$sdata[$value['d_name']]['action_code_all'] = $action_code_all;
			$sdata[$value['d_name']]['menu_action'] = $value['d_code'];
			$action_code_all = '';

			// 20160524
			if (empty($sdata[$value['d_name']]['action_code_all']))
				unset($sdata[$value['d_name']]);
		}
		return $sdata;
	}

	//刪除陣列Key值
	public function UnsetArray($data, $array)
	{
		foreach ($array as $value) {
			unset($data["$value"]);
		}
		return $data;
	}

	//去除字串最後一碼
	public function del_string_last($str)
	{
		return substr($str, 0, strlen($str) - 1);
	}

	//跳頁
	public function AlertPage($url = '', $msg = '')
	{
		if ($url != '') {
			if ($msg != '')
				echo '<script>alert("' . $msg . '");window.location.href="' . $url . '";</script>';
			else
				echo '<script>window.location.href="' . $url . '";</script>';
		} else
			echo '<script>alert("' . $msg . '");history.go(-1);</script>';
	}

	//檢視錯誤訊息
	public function ViewError()
	{
		ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
		error_reporting(E_ALL & ~E_NOTICE);
	}

	//取得每月最後一天
	function getCurMonthLastDay($date)
	{
		return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
	}

	//短網址
	public function getTinyUrl($url)
	{
		return file_get_contents("http://tinyurl.com/api-create.php?url=" . $url);
	}

	//創建目錄	
	public function create_dir($dir)
	{
		if (!is_dir($dir)) {
			$temp = explode('/', $dir);
			$cur_dir = '';
			for ($i = 0; $i < count($temp); $i++) {
				$cur_dir .= $temp[$i] . '/';
				if (!is_dir($cur_dir)) {
					@mkdir($cur_dir, 0777);
				}
			}
		}
	}
	//session
	private function start_session($expire = 0)
	{
		if ($expire == 0) {
			$expire = ini_get('session.gc_maxlifetime');
		} else {
			ini_set('session.gc_maxlifetime', $expire);
		}

		if (empty($_COOKIE['PHPSESSID'])) {
			session_set_cookie_params($expire);
			session_start();
		} else {
			session_start();
			setcookie('PHPSESSID', session_id(), time() + $expire);
		}
	}
}
