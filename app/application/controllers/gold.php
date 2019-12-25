<?php
class Gold extends MY_Controller
{
	public $web_title = '', $set_language;
	//初始化
	public function __construct()
	{
		parent::__construct();

		// language
		$this->load->helper('language');
		//model
		$this->load->model('admin_model', 'mod_admin');
		//語言包設置
		$this->load->model('lang_model', 'lmodel');
		//banner
		$this->load->model(array('banner_model', 'member_model'));

		$this->data['banner'] = $this->banner_model->getMyAd();

		//helper
		$this->load->helper('url');

		$this->load->model('views_model', 'mod_views');

		//host
		$this->data['host'] = $this->get_host_config();

		//domain
		if ($this->session->userdata('session_domain') != '') {
			$this->data['session_domain'] = $this->session->userdata('session_domain');
		} else {
			$this->data['session_domain'] = $this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain = $this->mod_admin->select_from('domain', array('domain_id' => $this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name'] = $this->session->userdata('session_domain_name');

		//web config
		$this->data['web_config'] = $this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->style 				=	(!empty($this->data['style_config']['style_id'])) ? $this->data['style_config']['style_id'] : '';
		$this->load->helper('form');
		//library
		$this->load->library('encrypt');

		//分享函式
		$this->load->library('/mylib/share');

		//model
		$this->load->model('/MyModel/mymodel');
		$this->load->library('/mylib/useful');
		$this->load->library('/mylib/comment');
		$this->load->model('member_model', 'mmodel');
		$this->load->model('menu_model', 'mod_menu');


		$this->load->model('webconfig_model', 'mod_webconfig');
		$this->load->model('shoppingmoney_model');
		$this->web_title = $this->mod_webconfig->config($_SERVER['REQUEST_URI']);

		//分享需要
		$_SESSION['shareUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$this->share_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$this->share_prd_image = 'http://' . $_SERVER['HTTP_HOST'] . "/images/logo_s.png";
	}
	//關於商城首頁
	public function home($id = '', $app = '')
	{
	}

	//首頁
	public function index($id = '', $app = '')
	{
		@session_start();
		$_SESSION['AT']['account'] = $id;
		$url = '/products';
		header("Location:$url");
	}

	//登入
	public function login($url = '')
	{
		@session_start();
		$this->lang->load('views/' . $this->indexViewPath . '/login', $this->setlang);

		// //初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		//依url來決定導向何處
		//		$data['burl']=$url;
		$url = (!empty($_SESSION['url'])) ? $_SESSION['url'] : '/';
		$data['burl'] = $url;
		// 判斷是否登入
		if ($_SESSION['MT']['is_login'] == 1) {
			//$this->useful->AlertPage('/gold/member_list');
			//$this->useful->AlertPage('/products');
			$this->useful->AlertPage('/gold/member');
			//$this->useful->AlertPage("$url");
		}

		$account = $this->input->cookie('account', TRUE);
		$password = $this->input->cookie('password', TRUE);
		$remember = $this->input->cookie('remember', TRUE);

		if ($account != '') {
			$data['account'] = $account;
			$data['password'] = $password;
			$data['remember'] = $remember;
		}


		//依url來決定導向何處 shop=>購物車
		$data['burl'] = $url;

		//view
		$this->load->view($this->indexViewPath . '/header', $data);
		$this->load->view($this->indexViewPath . '/login', $data);
		$this->load->view($this->indexViewPath . '/footer', $data);
	}
	//登入判斷頁
	public function login_set()
	{
		@session_start();
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);
		//語言包
		$this->lang = $this->lmodel->config('2', $this->setlang);

		$this->load->model('login_model');

		$url = (!empty($_SESSION['url'])) ? $_SESSION['url'] : '/';
		// 判斷是否登入
		if ($_SESSION['MT']['is_login'] == 1) {
			//$this->useful->AlertPage('/gold/member_list');
			//$this->useful->AlertPage('/products');
			$this->useful->AlertPage('/gold/member');
			//$this->useful->AlertPage("$url");
			return '';
		} else {
			$login_data = array(
				'account' => Comment::SetValue('d_account'),
				'password'  => Comment::SetValue('password'),
			);
			$this->session->set_userdata('ld', $login_data);
			$admin = $this->login_model->login_chekc($login_data); //管理者登入

			//if ($admin['d_is_member'] == '0') {
			//	$this->useful->AlertPage('/gold/login/'.Comment::SetValue('burl').'',$this->lang['loginerror2']/*無此商店*/);
			//	return '';
			//}

			if ($admin == 'NoVer') {
				@session_start();
				$_SESSION['AT']['d_account'] = Comment::SetValue('mobile');
				echo "<script>if(confirm('" . $this->lang['noreg']/*此帳號尚未驗證，是否重新發送簡訊?*/ . "')) window.location.href='/SmsSend';else window.location.href='/gold/login/" . Comment::SetValue('burl') . "'</script>";
				@session_write_close();
				return '';
			} elseif ($admin == 'LoginError') {
				$this->useful->AlertPage('/gold/login/' . Comment::SetValue('burl') . '', $this->lang['loginerror']/*帳號或密碼錯誤，請重新輸入?*/);
				return '';
			} elseif ($admin == 'Nouser') {
				$this->useful->AlertPage('/gold/login/' . Comment::SetValue('burl') . '', $this->lang['loginerror1']/*無此帳號，請先註冊?*/);
				return '';
			} else {

				$remember = $this->input->post('remember');
				$account = $this->input->post('d_account');
				$password = $this->input->post('password');

				if ($remember == 1) {
					$this->input->set_cookie('account', $account, 0);
					$this->input->set_cookie('password', $password, 0);
					$this->input->set_cookie('remember', '1', 0);
				} else {
					$this->input->set_cookie('account', $account, -5);
					$this->input->set_cookie('password', $password, -5);
					$this->input->set_cookie('remember', '1', -5);
				}

				// 登入狀態紀錄
				$_SESSION['AT']['d_account'] = $account;
				$_SESSION['MT']['is_login'] = 1;
				$_SESSION['MT']['by_id'] = $admin['by_id'];
				$_SESSION['MT']['name'] = $admin['name'];
				$_SESSION['MT']['d_is_member'] = $admin['d_is_member'];
				$_SESSION['MT']['member_id'] = $admin['member_id'];
				//if(Comment::SetValue('burl')=='shop')
				//	$this->useful->AlertPage('/cart/store/1',$this->lang['loginsu']/*登入成功?*/);
				//elseif(Comment::SetValue('burl')=='talkapp')
				//	$this->useful->AlertPage('/gold/talkapp',$this->lang['loginsu']/*登入成功?*/);
				//else
				//	$this->useful->AlertPage('/gold/member_list',$this->lang['loginsu']/*登入成功?*/);
				//$this->useful->AlertPage('/products',$this->lang['loginsu']/*登入成功?*/);

				//轉到上頁
				$url = (!empty($_SESSION['url'])) ? $_SESSION['url'] : '/';
				if (!empty($this->session->userdata['isapp']) == 'app') { //APP登入後固定在member
					$url = '/gold/member';
				}
				if ($url == "/products/0/0") {
					$url = "/gold/member";
				}
				$this->useful->AlertPage("$url", $this->lang['loginsu']);
				return '';
			}
		}
	}
	//登出
	public function logout()
	{
		@session_start();
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		//語言包
		$this->lang = $this->lmodel->config('2', $this->setlang);
		unset($_SESSION['MT']);
		unset($_SESSION['join_car']);
		//$this->useful->AlertPage('/products/'.$_SESSION['AT']['account'].'','登出成功');
		$this->useful->AlertPage('/gold/login', $this->lang['logoutsu']);
		return '';
	}

	//註冊
	public function register($upline = '')
	{
		@session_start();

		$this->lang->load('views/' . $this->indexViewPath . '/register', $this->setlang);

		$this->DataName = 'register';
		$lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$lang = $this->lmodel->config('3', $this->setlang);
		//非台灣則不顯示城市鄉鎮
		$data['setlang'] = $this->setlang;

		if ($_SESSION['ssoc'] != 1) {
			unset($_SESSION['RT']);
		}
		
		$data['dbname'] = $dbname = 'buyer';
		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();
		//國碼撈取
		$data['country_num'] = $this->mymodel->get_country_num();

		if ($_SESSION['MT']['upline'] == "" && $_COOKIE['upline'] != '')
			$_SESSION['MT']['upline'] = $_COOKIE['upline'];
		if ($_SESSION['MT']['upline'] == "" && $upline != "")
			$_SESSION['MT']['upline'] = $upline;
		if ($_SESSION['MT']['upline'] != "" && $upline == "")
			$upline = $_SESSION['MT']['upline'];

		if ($upline != "") {
			//解碼
			$upline = base64_decode($upline);
			$upline_by_id = $this->mymodel->OneSearchSql('buyer', 'by_id', array('d_account' => $upline));
			$data['upline_by_id'] = $upline_by_id['by_id'];
		} else {
			$data['upline_by_id'] = 1;
		}
		// 取會員註冊說明
		$tData = [
			'd_type'		=>	'terms',
			'lang_type'		=>	$data['setlang'],
		];
		$data['registerDesc'] = $this->mymodel->select_from_where('config', 'd_val', $tData);
		$data['registerDesc'] = $data['registerDesc']['d_val'];
		//view
		$this->load->view($this->indexViewPath . '/header', $data);
		$this->load->view($this->indexViewPath . '/register/register', $data);
		$this->load->view($this->indexViewPath . '/footer', $data);
	}

	//基本資料
	public function member_info()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('8', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();
		$this->useful->iconfig();

		//非台灣則不顯示城市鄉鎮
		$data['setlang'] = $this->setlang;

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_info';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('6', $this->setlang);
		$this->lang = array_merge($this->lang, $this->lmodel->config('8', $this->setlang));

		//資料庫名稱
		$data['dbname'] = $dbname = 'buyer';

		//抓會員資料(buyer)
		//$data['dbdata'] = $dbdata = $this->member_model->get_member_sign($id);
		$dbdata = $this->mymodel->OneSearchSql('buyer', '*', array('by_id' => $_SESSION['MT']['by_id']));
		//$dbdata['sex']=($dbdata['sex']=='male')?$this->lang['male']:$this->lang['female'];//先生/小姐
		$dbdata['sex'] = ($dbdata['sex'] == 'male') ? "先生" : "小姐"; //先生/小姐

		//抓會員資料(member)
		$data['dbdata'] = $dbdata;
		if ($dbdata['d_is_member'] == '1') {
			$mdbdata = $this->mymodel->OneSearchSql('member', '*', array('by_id' => $dbdata['by_id']));
			$data['mdbdata'] = $mdbdata;
			//經營會員 城市撈取
			$data['member_city']	  =	$this->mymodel->get_area_data($mdbdata['country']);
			//經營會員 鄉鎮countory
			$member_city_category 	  =	$this->mymodel->OneSearchSql('`city_category`', 's_id,s_name', array('s_id' => $mdbdata['city']));
			$data['member_countory'] =	$this->mymodel->get_area_data($member_city_category['s_id']);
			//門市取貨 城市撈取
			$data['shop_city']	  =	$this->mymodel->get_area_data($mdbdata['shop_country']);
			//門市取貨 鄉鎮countory
			$shop_city_category 	  =	$this->mymodel->OneSearchSql('`city_category`', 's_id,s_name', array('s_id' => $mdbdata['shop_city']));
			$data['shop_countory'] =	$this->mymodel->get_area_data($shop_city_category['s_id']);
		}


		$today = date('Y-m-d');
		$birthday = date('Y') . '-' . substr($dbdata['birthday'], -5);

		if (strtotime($today) > strtotime($birthday)) {
			//echo '今天已過!';
			//有效期限
			$data['birthday'] = (date('Y') + 1) . '-' . substr($dbdata['birthday'], -5);
		} else {
			//echo '還沒到!';
			//有效期限
			$data['birthday'] = date('Y') . '-' . substr($dbdata['birthday'], -5);
		}

		//地區國家撈取
		$data['country'] = $this->mymodel->get_area_data();

		//城市撈取
		$data['city']	  =	$this->mymodel->get_area_data($dbdata['country']);
		//鄉鎮countory
		$city_category 	  =	$this->mymodel->OneSearchSql('`city_category`', 's_id,s_name', array('s_id' => $dbdata['city']));
		$data['countory'] =	$this->mymodel->get_area_data($city_category['s_id']);

		//國碼撈取
		$data['country_num'] = $this->mymodel->get_country_num();

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_info', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//常用寄貨地址
	public function member_address()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		unset($_SESSION['RT']);

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_address';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('31', $this->setlang);

		//撈取常用寄貨地址
		if ($_SESSION['MT']['by_id'] != "")
			$data['address'] = $this->mymodel->get_address_data($_SESSION['MT']['by_id']);

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_address', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//常用寄貨地址add
	public function member_address_add()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_address';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('31', $this->setlang);

		$data['dbname'] = $dbname = 'address';

		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_address_add', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//常用寄貨地址edit
	public function member_address_edit($d_id = '')
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_address';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('31', $this->setlang);

		$data['dbname'] = $dbname = 'address';

		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();

		//撈取單筆地址
		$address = $this->mymodel->get_address_one_data($d_id);
		$data['address'] = $address;

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_address_edit', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//會員權益公告
	public function member_announcement($type = "")
	{
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		if ($type == "service")
			$this->DataName = 'member_announcement';
		else if ($type == "privacy")
			$this->DataName = 'privacy';
		else if ($type == "announcement")
			$this->DataName = 'announcement';
		else if ($type == "problem")
			$this->DataName = 'problem';
		else if ($type == "selection")
			$this->DataName = 'selection';
		else
			$this->DataName = 'member_announcement';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = $this->data['banner'];
		if (!empty($type)) {

			//撈取資料
			$content = $this->mymodel->GetConfig($type, '', $this->setlang);
			$data['content'] = $content[0]['d_val'];

			//標題
			$data['title'] = $content[0]['d_title'];

			//view
			$this->load->view('index/header' . $this->style, $data);
			if ($_SESSION['MT']['is_login'] == 1)
				$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/member/member_announcement', $data);
			$this->load->view('index/footer' . $this->style, $data);
		} else {
			// $this->useful->iconfig();
			$data['service'] = $this->mymodel->GetConfig('service', '', $this->setlang);
			$data['privacy'] = $this->mymodel->GetConfig('privacy', '', $this->setlang);
			$data['announcement'] = $this->mymodel->GetConfig('announcement', '', $this->setlang);
			$data['problem'] = $this->mymodel->GetConfig('problem', '', $this->setlang);
			$data['selection'] = $this->mymodel->GetConfig('selection', '', $this->setlang);

			//view
			$this->load->view('index/header' . $this->style, $data);
			if ($_SESSION['MT']['is_login'] == 1)
				$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/member/member_announcement_list', $data);
			$this->load->view('index/footer' . $this->style, $data);
		}
	}

	//邀請碼分享
	public function invite_share()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'invite_share';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('33', $this->setlang);

		//抓取上線,一般會員抓PID
		$sname = $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $_SESSION['MT']['by_id']));
		if (!empty($sname)) {
			$data['upline'] = $sname;
			if ($data['upline']['PID'] != 0) {
				$s_account = $this->mymodel->OneSearchSql('buyer', 'd_account', array('by_id' => $data['upline']['PID']));
				if (!empty($s_account)) {
					$data['s_account'] = $s_account;
				}
			}
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/invite_share', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//邀請碼分享ok
	public function invite_share_ok()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		$this->lang = $this->lmodel->config('33', $this->setlang);
		@session_start();
		//邀請碼解碼
		$invite_code = base64_decode(Comment::SetValue('invite_code'));
		$s_data = $this->mymodel->OneSearchSql('buyer', 'by_id', array('d_account' => $invite_code));
		if ($s_data['by_id'] != $_SESSION['MT']['by_id'] and $s_data['by_id'] <> "") {
			//登入者紅利點數加100
			$d_dividend_data = $this->mymodel->OneSearchSql('buyer', 'd_dividend', array('by_id' => $_SESSION['MT']['by_id']));
			$d_dividend = $d_dividend_data['d_dividend'] + 100;
			$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('PID' => $s_data['by_id'], 'd_dividend' => $d_dividend));
			// 寫入會員紅利
			$didata = array(
				'buyer_id' => $_SESSION['MT']['by_id'],
				'd_type' => '16',
				'd_val' => '100',
				'd_des' => "接受推薦註冊成功發送紅利",
				'is_send' => 'Y',
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time(),
				'send_dt' => $this->useful->get_now_time(),
			);
			$this->mymodel->insert_into('dividend', $didata);
			//推薦者上線紅利點數加100
			$d_upline_dividend_data = $this->mymodel->OneSearchSql('buyer', 'd_dividend', array('by_id' => $s_data['by_id']));
			$d_upline_dividend = $d_upline_dividend_data['d_dividend'] + 100;
			$this->mymodel->update_set('buyer', 'by_id', $s_data['by_id'], array('d_dividend' => $d_upline_dividend));
			$didata = array(
				'buyer_id' => $s_data['by_id'],
				'd_type' => '17',
				'd_val' => '100',
				'd_des' => "推薦註冊成功發送紅利",
				'is_send' => 'Y',
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time(),
				'send_dt' => $this->useful->get_now_time(),
			);
			$this->mymodel->insert_into('dividend', $didata);
			$this->useful->AlertPage('/gold/invite_share', $this->lang['share_ok']);		//加入上線邀請碼完成
		} else if ($s_data['by_id'] <> "") {
			$this->useful->AlertPage('/gold/invite_share', $this->lang['share_no']);		//不能設定上線邀請碼為自己帳號
		} else {
			$this->useful->AlertPage('/gold/invite_share', $this->lang['share_null']);		//帳號不存在,請重新輸入
		}
	}

	//會員專區
	public function member()
	{
		if (empty($_SESSION['MT'])) {
			$this->useful->AlertPage('/gold/login', $this->lang_menu['Login']);
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		if ($_SESSION['MT']['by_id'] != "") {
			$membername = $this->mymodel->get_member_upline_name($_SESSION['MT']['by_id']);
			$data['membername'] = $membername;
		}
		$_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['banner'] = $this->data['banner'];
		//view
		$this->load->view('index/header' . $this->style, $data);
		//$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member' . $this->style, $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//活躍指標
	public function member_active()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_active';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		//語言包
		$this->lang = $this->lmodel->config('34', $this->setlang);

		if ($_SESSION['MT']['d_is_member'] == 1)
			$data['active'] = $this->mymodel->get_member_active_indicator_data($_SESSION['MT']['member_id']);

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_active', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//升級經營會員
	public function member_upgrade()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_upgrade';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = '';

		//語言包
		$this->lang = $this->lmodel->config('8', $this->setlang);
		//非台灣則不顯示城市鄉鎮
		$data['setlang'] = $this->setlang;

		$data['dbname'] = $dbname = 'member_apply';

		$data['by_id'] = $_SESSION['MT']['by_id'];

		if ($_SESSION['RT']['ssoc'] != 1) {
			unset($_SESSION['RT']);
		}

		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_upgrade', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//組織表
	public function organization($s_account = "")
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		$data['s_account'] = $s_account;
		//資料庫名稱
		$data['dbname'] = $dbname = 'member';

		// 	//分頁程式 start
		// $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		// $qpage=$this->useful->SetPage($dbname,'',20);
		// $data['page']=$this->useful->get_page($qpage);
		// //分頁程式 end
		//$_POST['s_account']="0936189295";
		if ($s_account == "")
			$s_account = $_SESSION['AT']['d_account'];
		//if($_POST['s_num']!='' or $_POST['s_account']){
		//	$data['s_num']=$s_num=$_POST['s_num'];
		$data['s_account'] = $s_account;
		//echo "member_num:".$s_num."<br>";
		//echo "account:".$s_account."<br>";
		//exit;

		if ($s_num != '' and $s_account != '') {
			$mdata = $this->mymodel->OneSearchSql('member', 'd_keys,member_id,member_num,d_name,by_id', array('member_num' => $s_num, 'account' => $s_account));
		} elseif ($s_account != '') {
			$mdata = $this->mymodel->OneSearchSql('member', 'd_keys,member_id,member_num,d_name,by_id', array('account' => $s_account));
		} else {
			$mdata = $this->mymodel->OneSearchSql('member', 'd_keys,member_id,member_num,d_name,by_id', array('member_num' => $s_num));
		}
		$mname = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $mdata['by_id']));
		$mdata['d_name'] = $mname['name'];
		$data['mdata'] = $mdata;
		$dbdata = $this->mmodel->get_member_family($mdata['member_id']);
		$upkey = explode(',', $mdata['d_keys']);

		array_shift($upkey);
		foreach ($upkey as $key => $value) {
			if ($value != $mdata['member_id']) {
				$sign = $this->mmodel->get_member_sign($value);
				$line[$key]['name'] = $sign['name'];
				$line[$key]['member_num'] = $sign['member_num'];
			}
		}
		$data['line'] = $line;
		//}
		//else
		//	$dbdata=$this->mymodel->select_page_form('member',$qpage['result'],'*',array('auth'=>'02'));
		foreach ($dbdata as $key => $value) {
			$sname = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $value['by_id']));
			$value['name'] = $sname['name'];

			$pname = $this->mmodel->get_member_sign($value['upline']);
			$value['pname'] = $pname['name'];

			$gname = $this->mmodel->select_from('family', array('d_id' => $value['GID']));
			$value['GID'] = $gname['d_name'];

			if ($value['is_family_boss'] == 'Y') {
				$value['imasrc'] = '/images/icon_accept.png';
			} else {
				$value['imasrc'] = '/images/icon_na_t.png';
			}

			$value['create_time'] = substr($value['create_time'], 0, 10);
			// print_r($value);
			$key = explode(',', $value['d_keys']);
			array_shift($key);
			$level[count($key)][] = $value;
		}
		if (!empty($level))
			ksort($level);



		$data['dbdata'] = $level;

		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'organization';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('35', $this->setlang);

		$data['dbname'] = $dbname = 'member';

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/organization', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//我要請款
	public function invoice()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'invoice';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('36', $this->setlang);
		$this->lang = array_merge($this->lang, $this->lmodel->config('8', $this->setlang));

		//抓會員資料(buyer)
		$dbdata = $this->mymodel->OneSearchSql('buyer', '*', array('by_id' => $_SESSION['MT']['by_id']));
		$data['dbdata'] = $dbdata;

		//抓經營會員資料(member)
		$mdata = $this->mymodel->OneSearchSql('member', '*', array('by_id' => $_SESSION['MT']['by_id']));
		$data['mdata'] = $mdata;

		//抓buyer自己及下線
		if ($_SESSION['MT']['by_id'] != "")
			$data['downline'] = $this->mymodel->get_downline_data($_SESSION['MT']['by_id']);

		$feedata = $this->mymodel->getconfig('feeconfig');
		$data['feedata'] = $feedata;

		// 取貨幣符號
		$data['currency'] = $this->mod_admin->select_from('control_setting', array('domain_id' => '1'))['currency'];

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/invoice', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//我要請款ok
	public function invoice_ok()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();
		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'invoice_ok';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';
		//抓請款編號
		$make_no = $this->mymodel->get_bonus_pay_bank_count($this->useful->get_now_date());
		if ($make_no['make_no'] != "")
			$make_no['make_no'] = str_pad(substr($make_no['make_no'], -4) + 1, 4, '0', STR_PAD_LEFT);
		else
			$make_no['make_no'] = "0001";
		//送出多少購物金
		if (Comment::SetValue('money_choice') == "all") {
			$pay_shopping_money = Comment::SetValue('total');
		} else {
			if (Comment::SetValue('shopping_money') > Comment::SetValue('total'))
				$pay_shopping_money = Comment::SetValue('total');
			else
				$pay_shopping_money = Comment::SetValue('shopping_money');
		}
		if (Comment::SetValue('pay_method') == "bank") { //匯入銀行
			//寫入bonus_pay明細
			$didata = array(
				'by_id' => $_SESSION['MT']['by_id'],
				'makedate' => $this->useful->get_now_date(),
				'make_no' => date('Ymd') . $make_no['make_no'],
				'tot' => $pay_shopping_money - Comment::SetValue('Fee'),
				'bank_name' => Comment::SetValue('bank_name'),
				'bank_account_name' => Comment::SetValue('bank_account_name'),
				'bank_account' => Comment::SetValue('bank_account'),
				'bank_address' => Comment::SetValue('bank_address'),
				'swift_code' => Comment::SetValue('swift_code'),
				'chktype' => '1',
				'chkdate' => '',
				'chk_user_id' => '',
				'notes' => '',
				'viewdate' => '',
				'Fee' => Comment::SetValue('Fee'),
				'paydate' => '',
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time()
			);
			$this->mymodel->insert_into('bonus_pay_bank', $didata);
			$didata = array(
				'OID' => '',
				'd_pvper' => '0',
				'd_pv' => '0',
				'd_kv' => '0',
				'd_bonus' => $pay_shopping_money - Comment::SetValue('Fee'),
				'MID' => $_SESSION['MT']['member_id'], //member_id
				'sName' => $_SESSION['MT']['name'],
				'rd_type' => '1',
				'd_type_id' => '0',
				'd_type' => '轉贈佣金至現金',
				'd_content' => '轉贈佣金至現金',
				'd_block' => 'N',
				'd_bcontent' => '',
				'd_send' => 'Y',
				'd_date' => $this->useful->get_now_date(),
				'd_year' => date("Y"),
				'd_month' => date("m")
			);
			$this->mymodel->insert_into('bonus', $didata);
			//扣除轉出buyer bonus
			$d_difference = Comment::SetValue('total') - $pay_shopping_money;
			$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('d_bonus' => $d_difference));
		} else { //匯入下線或自己
			//寫入bonus明細(扣除)
			$didata = array(
				'OID' => '',
				'd_pvper' => '0',
				'd_pv' => '0',
				'd_kv' => '0',
				'd_bonus' => $pay_shopping_money,
				'MID' => $_SESSION['MT']['member_id'], //member_id
				'sName' => $_SESSION['MT']['name'],
				'rd_type' => '1',
				'd_type_id' => '0',
				'd_type' => '轉贈佣金至購物金',
				'd_content' => '轉贈佣金至購物金',
				'd_block' => 'N',
				'd_bcontent' => '',
				'd_send' => 'Y',
				'd_date' => $this->useful->get_now_date(),
				'd_year' => date("Y"),
				'd_month' => date("m")
			);
			$this->mymodel->insert_into('bonus', $didata);
			//寫入shopping_money明細(增加)
			$didata = array(
				'd_shopping_money' => $pay_shopping_money,
				'd_member_id' => $_SESSION['MT']['member_id'],
				'd_guest_id' => Comment::SetValue('guest_id'),
				'd_content' => '得到佣金積點:會員' . $_SESSION['MT']['name'] . '贈送購物金' . $pay_shopping_money . '元',
				'create_time' => $this->useful->get_now_time()
			);
			$this->mymodel->insert_into('shopping_money', $didata);
			//扣除轉出buyer bonus
			//抓會員資料(buyer)
			$dbdata = $this->mymodel->OneSearchSql('buyer', 'd_bonus', array('by_id' => $_SESSION['MT']['by_id']));
			$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('d_bonus' => $dbdata['d_bonus'] - $pay_shopping_money));
			//增加轉入buyer shopping_money
			//抓會員資料(buyer)
			$gdata = $this->mymodel->OneSearchSql('buyer', 'd_shopping_money', array('by_id' => Comment::SetValue('guest_id')));
			//扣掉手續費
			$this->mymodel->update_set('buyer', 'by_id', Comment::SetValue('guest_id'), array('d_shopping_money' => $gdata['d_shopping_money'] + $pay_shopping_money - Comment::SetValue('account_Fee')));
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/invoice_ok', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//請款記錄
	public function invoice_list()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();
		$this->lang = $this->lmodel->config('11', $this->setlang);
		$by_id = $_SESSION['MT']['member_id'];
		$this->load->model('shoppingmoney_model', 'smodel');
		//分頁
		$dbname = 'bonus';
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$page_limit     =   20; // 每頁顯示筆數

		$qpage = $this->useful->setPageJcy($dbname, $Topage, $page_limit, array('MID' => "$by_id", 'd_type_id' => '\"0\"'));
		$data['page'] = $this->useful->getPageJcy($qpage);
		$where = ' where MID=' . $by_id . ' and d_type_id=0';
		$dbdata = $this->smodel->GetShoppingmoney1($where, $qpage['result']);
		//		foreach ($dbdata as $key => $value) {
		//				$dtype=$this->mymodel->GetConfig('',$value['d_type']);
		//				$dbdata[$key]['d_des'] = str_replace("\'","'",$value['d_des']);
		//				$dbdata[$key]['contitle']=$dtype['d_title'];
		//				$dbdata[$key]['d_val']=($dtype['d_val']=='+')?'<span style="color:GREEN">+'.$value['d_val'].'</span>':'<span style="color:RED">-'.$value['d_val'].'</span>';
		//				$dbdata[$key]['update_time']=substr($value['update_time'],0,10);
		//				$odata=$this->mymodel->OneSearchSql('`order`','status,product_flow',array('id'=>$value['OID']));
		//				if(in_array($odata['status'],array(0,1,3)) and in_array($odata['product_flow'],array(0,1,3,4))){
		//						if($value['d_type']!=20){
		//								$dbdata[$key]['is_send']=($value['is_send']=='Y')?$this->lang['sended']:$this->lang['nosend']; //已發送 發送
		//						}elseif($value['d_type']==20){  //是否扣除紅利
		//								$dbdata[$key]['is_send']=($value['is_send']=='Y')?$this->lang['deduct']:$this->lang['nodeduct'];
		//						}
		//				}else
		//						unset($dbdata[$key]);
		//		}
		$data['dbdata'] = $dbdata;
		$data['banner'] = $this->data['banner'];

		//view
		$this->load->view('index/header', $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/invoice_list', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//佣金查詢
	public function member_bonus()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_bonus';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		$data['title'] =	$this->lang["$this->DataName"];

		// $this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('15', $this->setlang);

		//撈取獎金資料
		$dbdata = $this->mymodel->select_page_form('bonus_pay', '', 'bonus01,bonus02,bonus03,bonus04,bonus05,iOTotal,itax,i2nhi,iTotal,d_year,d_month', array('MID' => $_SESSION['MT']['member_id']));
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['date'] = $value['d_year'] . $value['d_month'];
			//所得稅
			$itax = ($value['itax'] == 0) ? '0' : '<span style="color:RED">-' . number_format($value['itax']) . '</span>';
			$dbdata[$key]['itax'] = $itax;
			//二代健保
			$i2nhi = ($value['i2nhi'] == 0) ? '0' : '<span style="color:RED">-' . number_format($value['i2nhi']) . '</span>';
			$dbdata[$key]['i2nhi'] = $i2nhi;
		}

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_bonus', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//佣金查詢detail
	public function member_bonus_detail($date = '')
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_bonus';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';

		$data['banner'] = '';

		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('18', $this->setlang);


		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);

		$date = $year . '-' . $month;

		//撈取獎金明細
		$dbdata = $this->mymodel->select_page_form('bonus', '', 'rd_type,d_type_id,d_type,d_content,d_pv,d_bonus', array('MID' => $_SESSION['MT']['member_id'], 'SUBSTRING(d_date,1,7)' => $date), 'd_type_id');
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['d_bonus'] = ($value['rd_type'] == '1') ? '<span style="color:RED">-' . number_format($value['d_bonus']) . '</span>' : '<span style="color:GREEN">' . number_format($value['d_bonus'], 2) . '</span>';
		}
		$tdata = $this->mymodel->OneSearchSql('bonus_pay', 'iOTotal', array('MID' => $_SESSION['MT']['member_id'], 'd_year' => $year, 'd_month' => $month));
		$data['dbdata'] = $dbdata;
		$itotal = ($tdata['iOTotal'] < 0) ? '0' : $tdata['iOTotal'];
		$data['itotal'] = $itotal;

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_bonus_detail', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//購物金查詢
	public function member_dividend_fun()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		@session_start();

		//data
		$data = $this->data;

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_dividend_fun';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//語言包
		$this->lang = $this->lmodel->config('32', $this->setlang);

		// if($_SESSION['MT']['d_is_member']==1)
		// $data['shopping_money']=$this->mymodel->get_shopping_money_data($_SESSION['MT']['by_id']);

		$moneyInfo = $this->shoppingmoney_model->getShoppingHistory($_SESSION['MT']['by_id']);

		foreach ($moneyInfo as $key => $data) {
			$moneyInfo[$key]['name'] = $data['d_member_id'] !== $data['d_guest_id'] ? $data['name'] : '';
		}

		//抓會員資料(buyer)
		$buyerInfo = $this->mymodel->OneSearchSql('buyer', '*', ['by_id' => $_SESSION['MT']['by_id']]);
		$data['shopping_money'] = $moneyInfo;
		$data['current_money'] = $buyerInfo['d_shopping_money'];

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_dividend_fun', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//友善連結
	public function link($type = 'C', $element = '', $category_id = 0, $account = '')
	{
		//if(empty($_SESSION['MT'])){
		//	$this->useful->AlertPage('/gold/login','請先登入或註冊');
		//}
		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this->mod_views->category_list($element);
		//$data['aid'] = $account;
		//switch ($iqr['theme_id']) {
		//	case '10':
		//		$path = 'temp10' . DIRECTORY_SEPARATOR . $data['filename'];
		//		break;
		//}
		//$display='style="display: none;"';

		@session_start();
		$this->DataName = 'link';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '/C/link"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';

		$data['banner'] = '';
		//語言包
		//$this->lang=$this->lmodel->config('3',$this->setlang);
		if (!empty($data['list'])) {
			if ($category_id == 0)
				$data['category_id'] = $category_id = $data['list'][0]['id'];

			$data['list_detail'] = $this->mymodel->get_news_data($category_id);


			$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

			$data['category_id'] = $category_id;

			//抓現在目錄名稱
			$category_name = '';
			foreach ($data['list'] as $key => $value) :
				if ($value['id'] == $category_id) {
					$category_name = $value['name'];
				}
			endforeach;

			$data['path_title'] = $data['path_title'] . '<li><a href="/gold/' . $this->DataName . '/C/link/' . $category_id . '"><span>' . $category_name . '</span></a></li>';
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/link/link_nav', $data);
		$this->load->view('index/link/link', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//影音專區
	public function media($type = 'C', $element = '', $category_id = 0, $account = '')
	{
		//if(empty($_SESSION['MT'])){
		//	$this->useful->AlertPage('/gold/login','請先登入或註冊');
		//}
		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this->mod_views->category_list($element);

		//$data['aid'] = $account;

		//switch ($iqr['theme_id']) {
		//	case '10':
		//		$path = 'temp10' . DIRECTORY_SEPARATOR . $data['filename'];
		//		break;
		//}
		//$display='style="display: none;"';

		@session_start();
		$this->DataName = 'movie';
		$this->lang = $this->lmodel->config('1', $this->setlang);

		$data['path_title'] = '<li><a href="/gold/aboutMall"><span>關於我們</span></a></li> <li><a href="/gold/media/C/video"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = '';

		//語言包
		$this->lang = $this->lmodel->config('3', $this->setlang);
		if (!empty($data['list'])) {
			if ($category_id == 0)
				$data['category_id'] = $category_id = $data['list'][0]['id'];

			$data['media_detail'] = $this->mymodel->get_media_data($category_id);


			$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

			$data['category_id'] = $category_id;

			//抓現在目錄名稱
			$category_name = '';
			foreach ($data['list'] as $key => $value) :
				if ($value['id'] == $category_id) {
					$category_name = $value['name'];
				}
			endforeach;

			$data['path_title'] = $data['path_title'] . '<li><a href="/gold/media/C/video/' . $category_id . '"><span>' . $category_name . '</span></a></li>';
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/media/media_nav', $data);
		$this->load->view('index/media/media', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//文件下載
	public function archive($type = 'C', $element = '', $category_id = 0, $account = '')
	{
		//if(empty($_SESSION['MT'])){
		//	$this->useful->AlertPage('/gold/login','請先登入或註冊');
		//}
		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this->mod_views->category_list($element);

		//$data['aid'] = $account;

		//switch ($iqr['theme_id']) {
		//	case '10':
		//		$path = 'temp10' . DIRECTORY_SEPARATOR . $data['filename'];
		//		break;
		//}
		//$display='style="display: none;"';

		@session_start();
		$this->DataName = 'download';
		$this->lang = $this->lmodel->config('1', $this->setlang);

		$data['path_title'] = '<li><a href="/gold/aboutMall"><span>關於我們</span></a></li><li><a href="/gold/archive/C/annex"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		$data['title'] = $this->lang["$this->DataName"];

		//語言包
		$this->lang = $this->lmodel->config('3', $this->setlang);
		if (!empty($data['list'])) {
			if ($category_id == 0)
				$data['category_id'] = $category_id = $data['list'][0]['id'];

			$data['archive_detail'] = $this->mymodel->get_archive_data($category_id);

			$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

			$data['category_id'] = $category_id;

			//抓現在目錄名稱
			$category_name = '';
			foreach ($data['list'] as $key => $value) :
				if ($value['id'] == $category_id) {
					$category_name = $value['name'];
				}
			endforeach;

			$data['path_title'] = $data['path_title'] . '<li><a href="/gold/archive/C/annex/' . $category_id . '"><span>' . $category_name . '</span></a></li>';
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/archive/archive_nav', $data);
		$this->load->view('index/archive/archive', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//活動與報名
	public function activity($type = 'C', $element = '', $category_id = 0, $account = '')
	{
		//if(empty($_SESSION['MT'])){
		//	$this->useful->AlertPage('/gold/login','請先登入或註冊');
		//}
		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this->mod_views->category_list($element);
		//$data['aid'] = $account;

		//switch ($iqr['theme_id']) {
		//	case '10':
		//		$path = 'temp10' . DIRECTORY_SEPARATOR . $data['filename'];
		//		break;
		//}
		//$display='style="display: none;"';

		//$data['is_login'] = $this -> ss;
		//$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
		//$this -> load -> view(DIRECTORY_SEPARATOR. 'gold' .DIRECTORY_SEPARATOR. 'footer', $data);
		@session_start();
		$this->DataName = 'activity';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '/C/enroll"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		$data['title'] = $this->lang["$this->DataName"];

		//語言包
		$this->lang = $this->lmodel->config('3', $this->setlang);

		//$data['dbname']=$dbname='buyer';
		if (!empty($data['list'])) {
			if ($category_id == 0)
				$data['category_id'] = $category_id = $data['list'][0]['id'];

			$data['list_detail'] = $this->mymodel->get_activity_data($category_id);

			$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

			$data['category_id'] = $category_id;

			//抓現在目錄名稱
			$category_name = '';
			foreach ($data['list'] as $key => $value) :
				if ($value['id'] == $category_id) {
					$category_name = $value['name'];
				}
			endforeach;

			$data['path_title'] = $data['path_title'] . '<li><a href="/gold/' . $this->DataName . '/C/enroll/' . $category_id . '"><span>' . $category_name . '</span></a></li>';
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/activity/activity_nav', $data);
		$this->load->view('index/activity/activity', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	public function activity_detail($element, $category_id, $id = '', $isshareurl = '', $docallapp = '', $account = '')
	{
		//if(empty($_SESSION['MT'])){
		//	$this->useful->AlertPage('/gold/login','請先登入或註冊');
		//}
		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this->mod_views->category_list($element);

		//$data['aid'] = $account;

		//$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'member.account', 'member.member_id','member_num'), array('member.account' => $account), 'member_id', 'row');

		//$data['share_url'] = base_url().'business/iqr/'.$iqr['account'];

		//if($this->get_device_os() != 'windows')
		//	$data['plurk_m_btn'] = true;
		//else
		//	$data['plurk_m_btn'] = false;

		//if (!empty($iqr))
		//{
		//	$data['aid'] = $iqr['account'];
		//	$data['member_id'] = $iqr['member_id'];
		//	$data['category_id'] = $category_id;
		//}

		if ($element != 'photo') {
			$auth_category = $this->mod_views->select_from('auth_category', array('type', 'c_name as name', 'category_id as id'), array('category_id' => $category_id, 'lang_type' => $this->setlang), 'row');
			$data['title'] = $auth_category['name'];
		}

		$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

		//switch ($iqr['theme_id']) {
		//	case '10':
		//		$path = 'temp10' . DIRECTORY_SEPARATOR;
		//		break;
		//}

		// print_r($_SESSION['MT']);
		//$data['Share']=$this->share->config($data['title'],$account,$isshareurl,$docallapp,$iqr['member_id']);
		// print_r($data['Share']);

		//$data['img_url']=$this->Spath;

		$this->DataName = 'activity';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';

		$data['path_title'] = $data['path_title'] . '<li><a href="/gold/' . $this->DataName . '/C/enroll/' . $category_id . '"><span>' . $auth_category['name'] . '</span></a></li>';
		$data['banner'] = '';

		$data['title'] = $auth_category['name'];

		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/activity/activity_nav', $data);
		$this->mod_views->category_and_detail($data, $path, $category_id, $id);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//經營會員權益公告
	public function announce()
	{
		@session_start();
		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'business_member_announcement';
		$data['path_title'] .= '<li><a href="/gold/announce"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//撈取經營會員權益公告list
		$data['list'] = $this->mymodel->get_announce_data($this->set_language);

		//view
		$this->load->view('index/header' . $this->style, $data);
		if ($_SESSION['MT']['is_login'] == 1)
			$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/announce/announce', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//經營會員權益公告單筆顯示
	public function announce_show($s_id)
	{
		@session_start();
		//撈取經營會員權益公告單筆資料
		$announcedata = $this->mymodel->get_announce_one_data($s_id, $this->set_language);
		$data['announce'] = $announcedata;

		$this->DataName = 'business_member_announcement';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/announce"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['path_title'] = $data['path_title'] . '<li><a href="/gold/announce_show/' . $s_id . '"><span>' . $announcedata['name'] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//view
		$this->load->view('index/header' . $this->style, $data);
		if ($_SESSION['MT']['is_login'] == 1)
			$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/announce/announce_show', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//會員服務條款&隱私權政策
	public function policies($type = "")
	{

		if (!empty($type)) {

			//撈取資料
			$content = $this->mymodel->GetConfig($type, '', $this->setlang);
			$data['content'] = $content[0]['d_val'];

			//標題
			$data['title'] = $content[0]['d_title'];

			//view
			$this->load->view('gold/header');
			$this->load->view('gold/policies', $data);
		} else {
			$this->useful->iconfig();
			//語言包
			$this->lang = $this->lmodel->config('12', $this->setlang);

			$data['service'] = $this->mymodel->GetConfig('service', '', $this->setlang);
			$data['privacy'] = $this->mymodel->GetConfig('privacy', '', $this->setlang);

			//view
			$this->load->view('gold/annou_list', $data);
		}
	}

	//忘記密碼
	public function forgot()
	{
		@session_start();
		$this->DataName = 'forgot';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		//語言包
		$this->lang = $this->lmodel->config('4', $this->setlang);

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_password_forget', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//忘記密碼處理
	public function forgot_set()
	{
		@session_start();
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		//語言包
		$this->alang = $this->lmodel->config('4', $this->setlang);

		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;
		$check->lang = $this->lmodel->config('9999', $this->setlang);

		$check->fname[] = array('_String', Comment::SetValue('acconut'), $this->alang['account']);
		$check->fname[] = array('_String', Comment::SetValue('email'), 'E-mail');
		if (!empty($check->main())) {
			echo $check->main();
			return '';
		}


		$dbdata = $this->mymodel->OneSearchSql('buyer', 'by_email,by_pw', array('d_account' => Comment::SetValue('acconut')));

		if (!empty($dbdata)) {
			if ($dbdata['by_email'] == Comment::SetValue('email')) {
				$password = $this->encrypt->decode($dbdata['by_pw']);

				//model
				$this->load->model('index_model', 'mod_index');
				//寄送密碼信

				//主旨
				if ($this->setlang == 'TW')
					$subject = '超惠購忘記密碼通知信';
				if ($this->setlang == 'ENG')
					$subject = 'supergoods Shop​ Forgot password notification letter';
				if ($this->setlang == 'JAP')
					$subject = '「supergoods」は、パスワード通知の手紙を忘れました';

				//內容
				if ($this->setlang == 'TW') {
					//內容
					$message = '' .
						"<p>親愛的用戶您好:</p>" .
						"<p>您欲查詢之登入密碼如下</p>" .
						"<p>密碼： " . $password . "</p>" .
						"<p>若仍有相關問題歡迎隨時與我們聯絡，我們將竭誠為您服務!謝謝!</p>" .
						"<p>超惠購客服中心</p>";
				} else if ($this->setlang == 'ENG') {
					//內容
					$message = '' .
						"<p>Dear supergoods Shop ​user​:</p>" .
						"<p>To find out your password to sign the following</p>" .
						"<p>Password: " . $password . "</p>" .
						"<p>If you still have questions please do not hesitate to contact us, we will be happy to serve you!Thank you!</p>" .
						"<p>supergoods Shop​ ​Customer ​Center</p>";
				} else if ($this->setlang == 'JAP') {
					//內容
					$message = '' .
						"<p>親愛なるsupergoodsショップユーザー:</p>" .
						"<p>以下に署名するためのパスワードを見つけるために</p>" .
						"<p>パスワード: " . $password . "</p>" .
						"<p>あなたはまだ私達に連絡することを躊躇しないでください質問がありましたら、私たちはあなたを提供させていただきます！ありがとうございました！</p>" .
						"<p>supergoods Shop​ ​顧客サービス</p>";
				}

				//寄信
				$this->mod_index->send_mail($this->data['host']['domain'], $this->data['web_config']['title'], Comment::SetValue('email'), $subject, $message);

				$this->useful->AlertPage('/gold/login', $this->alang['forgot']);	//寄信成功，請至信箱收信
			} else
				$this->useful->AlertPage('/gold/forgot', $this->alang['forgot1']);	//信箱錯誤，請重新輸入
		} else
			$this->useful->AlertPage('/gold/forgot', $this->alang['forgot2']);	//查無此帳號

	}

	/*
	//會員功能列表
	public function member_list(){}

	//續約處理
	public function renewal(){}
	*/

	//會員修改密碼
	public function member_password()
	{
		@session_start();
		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$this->DataName = 'member_password';
		$data['path_title'] .= '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = '';

		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('7', $this->setlang);

		if (!empty($_POST)) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);

			$check->fname[] = array('_String', Comment::SetValue('old_pw'), $this->lang['oldpw']);	//舊密碼
			$check->fname[] = array('_String', Comment::SetValue('new_pw'), $this->lang['newpwd']);	//新密碼
			$check->fname[] = array('_String', Comment::SetValue('re_new_pw'), $this->lang['rnewpwd']); //再次輸入密碼
			if (!empty($check->main())) {
				echo $check->main();
				return '';
			}

			if (strlen(Comment::SetValue('old_pw')) < 5 || strlen(Comment::SetValue('new_pw')) < 5 || strlen(Comment::SetValue('re_new_pw')) < 5) {
				$this->useful->AlertPage('', $this->lang['nofive']);	//密碼至少五位數
				return '';
			}

			$dbdata = $this->mymodel->OneSearchSql('buyer', 'by_pw', array('by_id' => $_SESSION['MT']['by_id']));
			$password = $this->encrypt->decode($dbdata['by_pw']);
			if ($password == Comment::SetValue('old_pw')) {
				if (Comment::SetValue('new_pw') == Comment::SetValue('re_new_pw')) {
					$new_password = $this->encrypt->encode(Comment::SetValue('new_pw'));
					$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('by_pw' => $new_password));
					$this->useful->AlertPage('/gold/member_info', $this->lang['s_editsu']);		//修改完成
				} else
					$this->useful->AlertPage('/gold/member_password', $this->lang['newreno']);	//新密碼跟再次輸入不符,請重新輸入
			} else
				$this->useful->AlertPage('/gold/member_password', $this->lang['oldfaile']);	//舊密碼錯誤,請重新輸入
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_password', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//會員紅利明細
	public function dividend()
	{
		if (empty($_SESSION['MT'])) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);
			$this->useful->AlertPage('/gold/login', $check->lang['Login']); //請先登入或註冊
		}
		$this->useful->iconfig();
		//語言包
		$this->lang = $this->lmodel->config('11', $this->setlang);

		$this->load->model('gold_model', gmodel);
		//會員剩餘紅利
		$bdata = $this->mymodel->OneSearchSql('buyer', 'birthday,d_dividend', array('by_id' => $_SESSION['MT']['by_id']));
		//有效期限

		$data['birthday'] = (date('Y') + 1) . '-' . date("m-d", strtotime($bdata['birthday'] . "-1 day")) . '  23:59';
		$data['dividend'] = ($bdata['d_dividend'] == '') ? '0' : $bdata['d_dividend'];
		//紅利資料
		// $dbdata=$this->mymodel->select_page_form('dividend','','update_time,d_type,d_val,d_des',array('buyer_id'=>$_SESSION['MT']['by_id']));
		$dbirthday = (date('Y')) . '-' . substr($bdata['birthday'], 5);

		$dbdata = $this->gmodel->get_dividend_data($_SESSION['MT']['by_id'], $dbirthday);
		foreach ($dbdata as $key => $value) {
			$dtype = $this->mymodel->GetConfig('', $value['d_type']);
			$dbdata[$key]['contitle'] = $dtype['d_title'];
			$dbdata[$key]['d_val'] = ($dtype['d_val'] == '+') ? '<span style="color:GREEN">+' . number_format($value['d_val']) . '</span>' : '<span style="color:RED">-' . number_format($value['d_val']) . '</span>';
			$dbdata[$key]['update_time'] = substr($value['update_time'], 0, 10);
			$odata = $this->mymodel->OneSearchSql('`order`', 'status,product_flow', array('id' => $value['OID']));
			if (in_array($odata['status'], array(0, 1, 3)) and in_array($odata['product_flow'], array(0, 1, 3, 4))) {
				if ($value['d_type'] != 20)
					$dbdata[$key]['is_send'] = ($value['is_send'] == 'Y') ? $this->lang['sended'] : $this->lang['nosend']; //已發送 發送
			} else
				unset($dbdata[$key]);
			// $dbdata[$key]['is_send']="交易失敗";

		}

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('gold/dividend', $data);
	}

	//申請經營會員
	public function upgrade()
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('8', $this->setlang);
		//非台灣則不顯示城市鄉鎮
		$data['setlang'] = $this->setlang;

		$data['dbname'] = $dbname = 'member_apply';

		$data['by_id'] = $_SESSION['MT']['by_id'];

		if ($_SESSION['RT']['ssoc'] != 1) {
			unset($_SESSION['RT']);
		}

		//地區撈取
		$data['city'] = $this->mymodel->get_area_data();
		unset($_SESSION['RT']['ssoc']);
		//view
		$this->load->view('gold/upgrade', $data);
	}

	//訂單查詢列表
	public function order_list($type = '')
	{

		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('9', $this->setlang);


		$this->load->model('gold_model', gmodel);
		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;
		$check->lang = $this->lmodel->config('9999', $this->setlang);

		$data['order_id'] = $order_id = Comment::SetValue('order_id');
		$data['date_start'] = $start = Comment::SetValue('date_start');
		$data['date_end'] = $end = Comment::SetValue('date_end');
		//使用區間查詢需兩則都有值
		if ($start != '' or $end != '') {
			$check->fname[] = array('_String', Comment::SetValue('date_start'), $this->lang['start']);	//開始區間
			$check->fname[] = array('_String', Comment::SetValue('date_end'), $this->lang['end']);	//'結束區間'
			if (!empty($check->main())) {
				echo $check->main('/gold/order_list');

				return '';
			}
		}

		if ($type == 'buyer') {
			$dbdata = $this->gmodel->get_order_data($order_id, $start, $end, '', '', $_SESSION['MT']['member_id']);
			foreach ($dbdata as $key => $value) {
				$bdata = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $value['by_id']));
				$dbdata[$key]['sname'] = $bdata['name'];
			}
			$data['type'] = $type;

			$data['iurl'] = 'buy_info';
			$data['title'] = $this->lang['appord'];	//APP銷售訂單查詢
		} else {
			$dbdata = $this->gmodel->get_order_data($order_id, $start, $end, '', $_SESSION['MT']['by_id']);
			$data['iurl'] = 'order_info';
			$data['title'] = $this->lang['oderse'];	//訂單查詢
		}
		//狀態撈取
		$status = $this->mymodel->GetConfig('orderstatus');
		foreach ($dbdata as $key => $value) {

			$flow = $this->lang['orderstatus' . $value['product_flow'] . ''];
			$dbdata[$key]['product_flow'] = $flow;
		}

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('gold/order_list', $data);
	}

	//訂單查詢內文
	public function order_info($id = '')
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('10', $this->setlang);


		$data['oid'] = $id;

		if ($_POST['atmno'] != '') {
			if (strlen($_POST['atmno']) != 5) {
				$this->useful->AlertPage('/gold/order_info/' . $id, $this->lang['irealnum']);
				return '';
			}

			if (empty($_POST['atmdate'])) {
				$this->useful->AlertPage('/gold/order_info/' . $id, $this->lang['irealdate']);
				return '';
			}
			$this->mymodel->update_set('`order`', 'id', $id, array('atmno' => $_POST['atmno'], 'atmdate' => $_POST['atmdate'], 'status' => '3', 'update_time' => time()));
			$this->useful->AlertPage('/gold/order_info/' . $id, $this->lang['resu']);
		}


		//訂單詳細資料
		$details = $this->mymodel->select_page_form('order_details', '', 'prd_name,total_price', array('oid' => $id));
		$data['details'] = $details;
		//訂單資料
		$dbdata = $this->mymodel->OneSearchSql('`order`', '*', array('id' => $id));

		//折抵資料
		$sdata = $this->mymodel->OneSearchSql('order_sub', '*', array('OID' => $id));
		$data['sdata'] = $sdata;

		//付款方式
		$pay = $this->mymodel->OneSearchSql('payment_way', 'pway_name,pway_id', array('pway_id' => $dbdata['pay_way_id']));
		$pay['pway_name'] = $this->lang['Pay' . $pay['pway_id'] . ''];
		$dbdata['pay'] = $pay['pway_name'];

		//付款狀態撈取
		$status = $this->mymodel->GetConfig('paystatus');
		foreach ($status as $svalue) {

			$flow = $this->lang['paystatus' . $svalue['d_val'] . ''];
		}
		$dbdata['status'] = $flow;

		//配送方式
		$logis = $this->mymodel->OneSearchSql('logistics_way', 'lway_id,lway_name', array('lway_id' => $dbdata['lway_id']));
		$logis['lway_name'] = $this->lang['Logis' . $logis['lway_id'] . ''];
		$dbdata['logis'] = $logis['lway_name'];

		//門市資訊
		if ($logis['lway_id'] == 5) {
			$shop_arr = $this->mymodel->OneSearchSql('member', 'shop_address', array('account' => $dbdata['shop_id']));
			$dbdata['shop_address'] = '(' . $shop_arr['shop_address'] . ')';
		}
		//商品金額總計
		$dbdata['proprice'] = $dbdata['total_price'] - $dbdata['lway_price'] + $sdata['bonus_sub'];
		// $dbdata['proprice']=$dbdata['total_price']-$dbdata['lway_price']+55;

		//發票資訊
		if ($dbdata['receipt_num'] != '' and $dbdata['receipt_title'] != '') {
			$rece = "(" . $dbdata['receipt_num'] . ")<p>" . $dbdata['receipt_title'] . "</p>";
		}
		$dbdata['rece'] = $rece;

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('gold/order_info', $data);
	}

	//APP銷售訂單查詢內文
	public function buy_info($id = '')
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('19', $this->setlang);

		$data['oid'] = $id;

		//訂單詳細資料
		$details = $this->mymodel->select_page_form('order_details', '', 'prd_name,total_price', array('oid' => $id));
		$data['details'] = $details;

		//訂單資料
		$dbdata = $this->mymodel->OneSearchSql('`order`', '*', array('id' => $id));

		// 訂單狀態
		$status = $this->mymodel->GetConfig('orderstatus');
		foreach ($status as $svalue) {
			if ($dbdata['product_flow'] == $svalue['d_val'])
				$flow = $svalue['d_title'];
		}
		$data['product_flow'] = $flow;
		// 付款狀態
		$paystatus = $this->mymodel->GetConfig('paystatus');
		foreach ($paystatus as $pvalue) {
			if ($dbdata['status'] == $pvalue['d_val'])
				$status = $pvalue['d_title'];
		}
		$data['status'] = $status;

		//折抵資料
		$sdata = $this->mymodel->OneSearchSql('order_sub', 'bonus_sub', array('OID' => $id));
		$data['sdata'] = $sdata;


		//商品金額總計
		$dbdata['proprice'] = $dbdata['total_price'] - $dbdata['lway_price'];

		//購買人資訊
		$bdata = $this->mymodel->OneSearchSql('buyer', 'name,d_is_member', array('by_id' => $dbdata['by_id']));
		$mdata = $this->mymodel->GetConfig('bytype');
		foreach ($mdata as $value) {
			if ($bdata['d_is_member'] == $value['d_val'])
				$data['d_is_member'] = $value['d_title'];
		}

		$data['bname'] = $bdata['name'];

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('gold/buy_info', $data);
	}

	//獎金查詢列表
	public function bonus_list()
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('15', $this->setlang);

		//撈取獎金資料
		$dbdata = $this->mymodel->select_page_form('bonus_pay', '', 'bonus01,bonus02,bonus03,bonus04,bonus05,iOTotal,itax,i2nhi,iTotal,d_year,d_month', array('MID' => $_SESSION['MT']['member_id']));
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['date'] = $value['d_year'] . $value['d_month'];
			//所得稅
			$itax = ($value['itax'] == 0) ? '0' : '<span style="color:RED">-' . number_format($value['itax']) . '</span>';
			$dbdata[$key]['itax'] = $itax;
			//二代健保
			$i2nhi = ($value['i2nhi'] == 0) ? '0' : '<span style="color:RED">-' . number_format($value['i2nhi']) . '</span>';
			$dbdata[$key]['i2nhi'] = $i2nhi;
		}

		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('gold/bonus_list', $data);
	}

	//獎金查詢內文
	public function bonus_info($date = '')
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('18', $this->setlang);


		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);

		$date = $year . '-' . $month;

		//撈取獎金明細
		$dbdata = $this->mymodel->select_page_form('bonus', '', 'rd_type,d_type_id,d_type,d_content,d_pv,d_bonus', array('MID' => $_SESSION['MT']['member_id'], 'SUBSTRING(d_date,1,7)' => $date), 'd_type_id');
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['d_bonus'] = ($value['rd_type'] == '1') ? '<span style="color:RED">-' . number_format($value['d_bonus']) . '</span>' : '<span style="color:GREEN">' . number_format($value['d_bonus']) . '</span>';
		}
		$tdata = $this->mymodel->OneSearchSql('bonus_pay', 'iOTotal', array('MID' => $_SESSION['MT']['member_id'], 'd_year' => $year, 'd_month' => $month));
		$data['dbdata'] = $dbdata;
		$itotal = ($tdata['iOTotal'] < 0) ? '0' : $tdata['iOTotal'];
		$data['itotal'] = $itotal;
		//view
		$this->load->view('gold/bonus_info', $data);
	}
	//心得投稿

	public function contribute($id = '')
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('16', $this->setlang);

		if ($id != '') {
			$data['dbdata'] = $this->mymodel->OneSearchSql('reviews', 'd_title,d_content', array('d_id' => $id));
			$data['d_id'] = $id;
		}

		//view
		$this->load->view('gold/contribute', $data);
	}

	//心得資料儲存
	public function save_contr()
	{
		@session_start();

		//語言包
		$this->lang = $this->lmodel->config('16', $this->setlang);

		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;
		$check->lang = $this->lmodel->config('9999', $this->setlang);

		$type = $_POST['type'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		$edit_id = $_POST['edit_id'];


		$check->fname[] = array('_String', Comment::SetValue('title'), $this->lang['title']); //'主旨'
		$check->fname[] = array('_String', Comment::SetValue('content'), $this->lang['content']); //'內容'
		if (!empty($check->main())) {
			echo 'error';
			return '';
		}

		$member = $this->mymodel->OneSearchSql('member', 'member_id', array('by_id' => $_SESSION['MT']['by_id']));
		$rdata = array(
			'member_id' => $member['member_id'],
			'd_title' => $title,
			'd_content' => $content,
			'd_status' => $type,
			'update_time' => $this->useful->get_now_time()
		);

		if ($edit_id != 0) {
			$this->mymodel->update_set('reviews', 'd_id', $edit_id, $rdata);
		} else {
			$rdata['create_time'] = $this->useful->get_now_time();
			$this->mymodel->insert_into('reviews', $rdata);
		}
		echo $type;
	}

	//心得草稿
	public function draft()
	{
		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('17', $this->setlang);

		$data['dbdata'] = $this->mymodel->select_page_form('reviews', '', 'd_id,d_title,d_content', array('member_id' => $_SESSION['MT']['member_id'], 'd_status' => '2'));

		//view
		$this->load->view('gold/draft', $data);
	}

	//聯絡我們
	public function contact()
	{
		@session_start();
		//語言包
		$this->DataName = 'contact';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';

		$this->lang = $this->lmodel->config('13', $this->setlang);

		$data['dbname'] = $dbname = 'contact';

		$data['title'] = $this->lang["$this->DataName"];
		$data['banner'] = $this->data['banner'];

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/contact/contact', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//聯絡我們ok
	public function contact_ok()
	{
		@session_start();
		//語言包
		$this->DataName = 'contact';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = '';
		$this->lang = $this->lmodel->config('13', $this->setlang);

		$data['dbname'] = $dbname = 'contact';

		$data['title'] = $this->lang["$this->DataName"];

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/contact/contact_ok', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}
	//EBH留言列表
	public function talklist()
	{
	}
	//EBH留言內文
	public function talkapp($by_id = '')
	{
	}

	//資料增刪修
	public function data_AED($DB = '', $del_id = '')
	{
		@session_start();
		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;
		$check->lang = $this->lmodel->config('9999', $this->setlang);
		$this->load->model('login_model');
		// print_r($check->lang);
		// break;
		if ($del_id != '') {
			$dbname = $DB;
			$this->mmodel->delete_where($DB, array('d_id' => $del_id));
			$msg = $check->lang['s_delsu'];/*刪除成功?*/
		} else {
			$id = $_POST['d_id'];
			$dbname = $_POST['dbname'];
			$member_register = $_POST['member_register'];

			unset($_POST['confirm_pw']); // 確認密碼不需送出
			if ($id) {
				$data = $this->useful->DB_Array($_POST);
			} else {
				$data = $this->useful->DB_Array($_POST, 1);
			}

			//記錄密碼
			$_SESSION['RT'] = $data;
			$_SESSION['ssoc'] = 1;
			//常用寄貨地址
			if ($dbname == 'address') {
				//語言包
				$this->lang1 = $this->lmodel->config('3', $this->setlang);
				$d_id = 'd_id';
				if ($id != '') {
					$data = $this->useful->DB_Array($_POST);
					$check->fname[] = array('_String', Comment::SetValue('name'), $this->lang1['dname']/*姓名*/);

					//if(Comment::SetValue('telphone')!=''){
					//	if(strlen(Comment::SetValue('telphone'))<=11){
					//		$this->useful->AlertPage('',$this->lang1['elevenphone']/*電話至少十一碼?*/);
					//		return '';
					//	}
					//}

					if (Comment::SetValue('country') != '' or Comment::SetValue('city') != '' or Comment::SetValue('address') != '') {
						if (Comment::SetValue('country') == '' or Comment::SetValue('city') == '' or Comment::SetValue('countory') == '' or Comment::SetValue('address') == '') {
							$this->useful->AlertPage('', $this->lang1['plsadd']/*通訊地址請填寫完整?*/);
							return '';
						}
					}
				} else {
					$check->fname[] = array('_String', Comment::SetValue('name'), $this->lang1['dname']/*姓名*/);

					//if(Comment::SetValue('telphone')!=''){
					//	if(strlen(Comment::SetValue('telphone'))<=11){
					//		$this->useful->AlertPage('',$this->lang1['elevenphone']/*電話至少十一碼?*/);
					//		return '';
					//	}
					//}

					if ($this->setlang == 'TW' and (Comment::SetValue('country') != '' or Comment::SetValue('city') != '' or Comment::SetValue('address') != '')) {
						if (Comment::SetValue('country') == '' or Comment::SetValue('city') == '' or Comment::SetValue('countory') == '' or Comment::SetValue('address') == '') {
							$this->useful->AlertPage('', $this->lang1['plsadd']/*通訊地址請填寫完整?*/);
							return '';
						}
					}

					//去除陣列無用值
					$data = $this->useful->UnsetArray($data, array('dbname'));
				}
			}
			//會員內頁
			if ($dbname == 'buyer') {
				//語言包
				$this->lang1 = $this->lmodel->config('3', $this->setlang);

				$id = $_SESSION['MT']['by_id'];
				//判斷是否在會員註冊頁,如果是清除$id,讓資料新增非修改
				if ($member_register == "yes")
					$id = "";
				$d_id = 'by_id';
				$url = '/gold/register';
				$check->fname[] = array('_CheckEmail', Comment::SetValue('by_email'), 'E-mail');
				if ($id != '') {
					$data = $this->useful->DB_Array($_POST);
					// $check->fname[]=array('_String',Comment::SetValue('name'),$this->lang1['dname']/*姓名*/);

					// if(Comment::SetValue('mobile')!=''){
					// 	if(!(strlen(Comment::SetValue('mobile'))==11 or strlen(Comment::SetValue('mobile'))==10)){
					// 		$this->useful->AlertPage('',$this->lang1['ten_or_elevenphone']/*手機號碼需要10碼(台灣)或11碼(中國)?*/);
					// 		return '';
					// 	}
					// }

					//if(Comment::SetValue('telphone')!=''){
					//	if(strlen(Comment::SetValue('telphone'))<=11){
					//		$this->useful->AlertPage('',$this->lang1['elevenphone']/*電話至少十一碼?*/);
					//		return '';
					//	}
					//}

					$mobile_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('mobile' => Comment::SetValue('mobile')));
					if (!empty($mobile_data) and $mobile_data['0']['by_id'] <> $id) {
						$this->useful->AlertPage('/gold/member_info', $this->lang1['somephone']/*此手機已註冊過，請重新輸入?*/);
						return '';
					}
					$data = $this->useful->UnsetArray($data, array('chk_ok'));

					$url = '/gold/member_info';
					if ($data['is_member'] == 'Y') {
						$mdata = array(
							'country' => $data['cen_country'],
							'city' => $data['cen_city'],
							'countory' => $data['cen_countory'],
							'address' => $data['cen_address'],
							'bank_name' => $data['bank_name'],
							'bank_account_name' => $data['bank_account_name'],
							'bank_account' => $data['bank_account'],
							'bank_address' => $data['bank_address'],
							'swift_code' => $data['swift_code'],
							'wowpay_email' => $data['wowpay_email'],
							'wowpay_cardAsn' => $data['wowpay_cardAsn'],
							'wowpay_pay_password' => $data['wowpay_pay_password'],
							'wowpay_login_password' => $data['wowpay_login_password'],
							'wowpay_country_num' => $data['wowpay_country_num'],
							'wowpay_mobile' => $data['wowpay_mobile'],
							'wowpay_signature' => $data['wowpay_signature'],
							'shop_country' => $data['shop_country'],
							'shop_city' => $data['shop_city'],
							'shop_countory' => $data['shop_countory'],
							'shop_address' => $data['shop_address'],
							'update_time' => $this->useful->get_now_time()
						);
						$this->mymodel->update_set('member', $d_id, $id, $mdata);
						//去除陣列無用值
						$data = $this->useful->UnsetArray($data, array('wowpay_email', 'wowpay_cardAsn', 'wowpay_pay_password', 'wowpay_login_password', 'wowpay_country_num', 'wowpay_mobile', 'wowpay_signature', 'cen_country', 'cen_city', 'cen_countory', 'cen_address', 'bank_name', 'bank_account_name', 'bank_account', 'bank_address', 'swift_code', 'is_member', 'shop_country', 'shop_city', 'shop_countory', 'shop_address'));
					}
				} else {

					//$check->fname[]=array('_CheckPhone',Comment::SetValue('mobile'),$this->lang1['mobile']/*帳號*/);
					$check->fname[] = array('_String', Comment::SetValue('mobile'), $this->lang1['mobile']/*帳號*/);
					$check->fname[] = array('_String', Comment::SetValue('name'), $this->lang1['dname']/*姓名*/);
					$check->fname[] = array('_String', Comment::SetValue('by_pw'), $this->lang1['password']/*密碼*/);
					//$check->fname[]=array('_String',Comment::SetValue('d_year'),$this->lang1['year']/*年*/);
					//$check->fname[]=array('_String',Comment::SetValue('d_month'),$this->lang1['month']/*月*/);
					//$check->fname[]=array('_String',Comment::SetValue('d_day'),$this->lang1['day']/*日*/);

					// if(Comment::SetValue('mobile')!=''){
					// 	if(!(strlen(Comment::SetValue('mobile'))==11 or strlen(Comment::SetValue('mobile'))==10)){
					// 		$this->useful->AlertPage('',$this->lang1['ten_or_elevenphone']/*手機號碼需要10碼(台灣)或11碼(中國)?*/);
					// 		return '';
					// 	}
					// }

					//if(Comment::SetValue('telphone')!=''){
					//	if(strlen(Comment::SetValue('telphone'))<=11){
					//		$this->useful->AlertPage('',$this->lang1['elevenphone']/*電話至少十一碼?*/);
					//		return '';
					//	}
					//}

					//if($this->setlang=='TW' and (Comment::SetValue('country')!='' or Comment::SetValue('city')!='' or Comment::SetValue('address')!='')){
					//	if(Comment::SetValue('country')=='' or Comment::SetValue('city')=='' or Comment::SetValue('countory')=='' or Comment::SetValue('address')==''){
					//		$this->useful->AlertPage('',$this->lang1['plsadd']/*通訊地址請填寫完整?*/);
					//		return '';
					//	}
					//}

					$buyer_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('d_account' => Comment::SetValue('d_account')));

					if (!empty($buyer_data)) {
						$this->useful->AlertPage('/gold/register/' . Comment::SetValue('PID'), $this->lang1['someacc']/*已有相同帳號，請重新輸入?*/);
						return '';
					}

					$member_data = $this->mymodel->select_page_form('member', '', 'by_id', array('account' => Comment::SetValue('d_account')));

					if (!empty($member_data)) {
						$this->useful->AlertPage('/gold/register/' . Comment::SetValue('PID'), $this->lang1['someacc']/*已有相同帳號，請重新輸入?*/);
						return '';
					}


					$mobile_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('mobile' => Comment::SetValue('mobile')));

					if (!empty($mobile_data)) {
						$this->useful->AlertPage('/gold/register/' . Comment::SetValue('PID'), $this->lang1['somephone']/*此手機已註冊過，請重新輸入?*/);
						return '';
					}

					if (strlen(Comment::SetValue('by_pw')) < 5) {
						$this->useful->AlertPage('', $this->lang1['pwdfive']/*密碼至少五位數?*/);
						return '';
					}


					$data['by_pw'] = $this->encrypt->encode(Comment::SetValue('by_pw'));
					$data['d_is_member'] = '0';
					//$data['birthday']=$data['d_year'].'-'.$data['d_month'].'-'.$data['d_day'];
					//$data['mobile']=Comment::SetValue('d_account');
					if (Comment::SetValue('PID') != "") {
						$rule = $this->mymodel->GetConfig('rule');
						$data['PID'] = Comment::SetValue('PID');
						$data['d_dividend'] = $rule[6]['d_val']; //接受推薦送100點紅利
						//推薦人也送100點紅利
						$d_dividend_data = $this->mymodel->OneSearchSql('buyer', 'd_dividend', array('by_id' => Comment::SetValue('PID')));
						$d_dividend = $d_dividend_data['d_dividend'] + $rule[7]['d_val'];
						$this->mymodel->update_set('buyer', 'by_id', Comment::SetValue('PID'), array('d_dividend' => $d_dividend));
						//推薦人寫入紅利說明
						$didata = array(
							'buyer_id' => Comment::SetValue('PID'),
							'd_type' => '19',
							'd_val' => $rule[7]['d_val'],
							'd_des' => "推薦註冊成功發送紅利", //推薦註冊成功發送紅利
							'is_send' => 'Y',
							'create_time' => $this->useful->get_now_time(),
							'update_time' => $this->useful->get_now_time(),
							'send_dt' => $this->useful->get_now_time(),
						);
						$this->mymodel->insert_into('dividend', $didata);
					} else {
						$data['PID'] = $_SESSION['AT']['member_id'];
						if ($data['PID'] == null)
							$data['PID'] = "0";
					}
					//去除陣列無用值
					$data = $this->useful->UnsetArray($data, array('chk_ok', 'member_register'));
				}
			}
			//經營會員
			if ($dbname == 'member_apply') {
				//語言包
				$this->lang = $this->lmodel->config('8', $this->setlang);

				$mdata = $this->mymodel->OneSearchSql('member', 'identity_num', array('identity_num' => Comment::SetValue('identity_num')));
				if (!empty($mdata)) {
					$this->useful->AlertPage('', $this->lang['iduse']); //身份證字號已被使用
					return '';
				}

				$check->fname[] = array('_String', Comment::SetValue('identity_num'), $this->lang['idnum']);	//身份證字號
				$check->fname[] = array('_Select', Comment::SetValue('country'), '國家地區');
				$check->fname[] = array('_Select', Comment::SetValue('city'), '省份城市');
				$check->fname[] = array('_Select', Comment::SetValue('countory'), '地級市鄉鎮地區');
				$check->fname[] = array('_String', Comment::SetValue('address'), $this->lang['address']);	//地址
				$check->fname[] = array('_String', Comment::SetValue('bank_name'), $this->lang['bname']);	//銀行名稱
				$check->fname[] = array('_String', Comment::SetValue('bank_account_name'), $this->lang['baccname']);	//帳戶名稱
				$check->fname[] = array('_String', Comment::SetValue('bank_account'), $this->lang['bacc']);	//銀行帳號
				$check->fname[] = array('_String', Comment::SetValue('bank_address'), $this->lang['bacc']);	//銀行帳號
				$check->fname[] = array('_String', Comment::SetValue('swift_code'), $this->lang['bacc']);	//銀行帳號
				$data['upline'] = $_SESSION['AT']['member_id'];
				//暫時將上線null填空白,新增member_apply會錯誤
				if ($data['upline'] == null)
					$data['upline'] = "";
				$data['by_id'] = $_SESSION['MT']['by_id'];


				//去除陣列無用值
				$data = $this->useful->UnsetArray($data, array('update_time', 'agree'));
			}
			//聯絡我們
			if ($dbname == 'contact') {
				//語言包
				$this->lang = $this->lmodel->config('13', $this->setlang);

				$check->fname[] = array('_String', Comment::SetValue('d_name'), $this->lang['name']);	//'姓名'
				//$check->fname[]=array('_CheckPhone',Comment::SetValue('d_phone'),$this->lang['mobile']);	//'手機'
				$check->fname[] = array('_String', Comment::SetValue('d_phone'), $this->lang['mobile']);	//'手機'
				$check->fname[] = array('_CheckEmail', Comment::SetValue('d_mail'), $this->lang['mail']);	//'信箱'
				$check->fname[] = array('_String', Comment::SetValue('d_content'), $this->lang['content']);	//'內容'
			}
			//申請退貨
			if ($dbname == 'order') {
				//語言包
				$this->lang = $this->lmodel->config('10', $this->setlang);


				$check->fname[] = array('_String', Comment::SetValue('back_name'), $this->lang['name']);	//退款人姓名
				$check->fname[] = array('_String', Comment::SetValue('back_bank'), $this->lang['bbank']);	//退款銀行名稱
				$check->fname[] = array('_String', Comment::SetValue('back_account'), $this->lang['bacc']);	//退款銀行帳號

				$data['apply_back_date'] = $data['update_time'];
				$data = $this->useful->UnsetArray($data, array('update_time'));

				//狀態改申請退貨
				$data['product_flow'] = '7';
				$d_id = 'id';
			}

			//EBH留言
			if ($dbname == 'talkapp') {

				//語言包
				$this->lang = $this->lmodel->config('14', $this->setlang);

				$check->fname[] = array('_String', Comment::SetValue('d_content'), $this->lang['content']);	//'內容'
				//去除陣列無用值
				$data = $this->useful->UnsetArray($data, array('update_time'));
				if ($data['b_id'] != '') {
					$data['m_id'] = $_SESSION['MT']['member_id'];
					$data['d_type'] = 'M';
					$data['d_read'] = 'Y';
				} else {
					$data['m_id'] = $_SESSION['AT']['member_id'];
					$data['b_id'] = $_SESSION['MT']['by_id'];
					$data['d_type'] = 'B';
					$data['d_read'] = 'N';
				}
			}

			if (!empty($check->main())) {
				echo $check->main($url);
				return '';
			}

			//去除陣列無用值
			$data = $this->useful->UnsetArray($data, array('dbname', 'd_id'));
			//基本資料修改戶籍地址及門市地址暫時先移除
			if ($_SESSION['MT']['d_is_member'] == "1") {
			}
			$data = $this->useful->UnsetArray($data, array('household_city', 'household_countory', 'household_address', 'store_city', 'store_countory', 'store_address'));

			if ($id != '') {
				$this->mymodel->update_set($dbname, $d_id, $id, $data);
				$msg = $check->lang['s_editsu']/*修改成功*/;
			} else {
				unset($data['swift_code']);
				unset($data['bank_address']);
				$create_id = $this->mymodel->insert_into($dbname, $data);
				if ($create_id)
					$msg = $check->lang['s_newsu']/*新增成功*/;
				else
					$msg = $check->lang['s_newfa']/*新增失敗*/;
			}
		}

		//註冊成功後續動作
		if ($dbname == 'buyer') {
			$check->lang = $this->lmodel->config('3', $this->setlang);
			if ($id != '')
				$this->useful->AlertPage('/gold/member_info', $msg);
			else {
				//抓網頁設定判斷是否自動升級經營會員
				//host
				$this->data['host'] = $this->get_host_config();

				//domain id
				if ($this->session->userdata('session_domain'))
					$this->data['domain_id'] = $this->session->userdata('session_domain');
				else
					$this->data['domain_id'] = $this->data['host']['domain_id'];

				//web config
				$this->data['web_config'] = $this->get_web_config($this->data['domain_id']);

				//是否自動升級經營會員
				if ($this->data['web_config']['is_auto_upgrade_member'] == 1) {
					$member_data = array(
						'by_id' => $create_id,
						'domain_id' => '1',
						'account' => Comment::SetValue('d_account'),
						'password' => $this->encrypt->encode(Comment::SetValue('by_pw')),
						'email' => Comment::SetValue('by_email'),
						'identity_num' => '',
						'country' => '',
						'city' => '',
						'countory' => '',
						'address' => '',
						'bank_name' => '',
						'bank_account_name' => '',
						'bank_account' => '',
						// 'bank_address'=>'',
						// 'swift_code'=>'',
						'wowpay_email' => '',
						'wowpay_country_num' => '',
						'wowpay_mobile' => '',
						'wowpay_cardAsn' => '',
						'wowpay_pay_password' => '',
						'wowpay_login_password' => '',
						'wowpay_signature' => '',
						'upline' => '',
						'auth' => '02',
						'addtime' => time(),
						'join_time' => $this->useful->get_now_date(),
						'deadline' => strtotime(date('Y-m-d', strtotime('' . $this->useful->get_now_date() . ' +19 years'))),
						'create_time' => $this->useful->get_now_time(),
						'update_time' => $this->useful->get_now_time(),
					);

					$member_id = $this->mmodel->insert_into('member', $member_data);
					//修改buyer為經營會員
					$this->mymodel->update_set('buyer', 'by_id', $create_id, array('d_is_member' => 1));
				}

				$account = Comment::SetValue('d_account');
				$acconut_id = $_SESSION['AT']['account'];

				$nonum = base64_encode(date('Ymd') . '_' . $account . '_' . $acconut_id . '');
				$tinyurl = $this->useful->getTinyUrl(base_url() . 'gold/member_verify?nonum=' . $nonum . '');

				//主旨
				$subject = $this->data['web_config']['title'] . '會員註冊通知函';
				$adata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('country')));
				$bdata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('city')));
				$cdata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('countory')));
				//內容
				$message = '' .
					"<p>*********************************************************************</p>" .
					"<p>請注意！如要確保電子郵件能被正常收件，請將service@supergoods.com.tw</p>" .
					"<p>加入您的通訊錄中，謝謝。</p>" .
					"<p>*********************************************************************</p>" .
					"<p>&nbsp;</p>" .
					"<p>親愛的會員 您好：</p>" .
					"<p>&nbsp;</p>" .
					"<p>歡迎您加入「超惠購」商城會員！</p>" .
					"<p>「超惠購」商城提供多元化生活商品，</p>" .
					"<p>提供您一次購足、當月滿足；件件超省、樣樣超值的購物體驗。</p>" .
					"<p>&nbsp;</p>" .
					"<p>即日起新會員還享獨家入會好禮！</p>" .
					"<p>您註冊的帳號：" . Comment::SetValue('d_account') . "</p>" .
					"<p>已完成註冊，並開啟完整的會員功能。</p>" .
					"<p>&nbsp;</p>" .
					"<p>日後「超惠購」好康訊息與商城通知都將寄送到此信箱，</p>" .
					"<p>請密切注意，不要錯失任何一個優惠好康與活動。</p>" .
					"<p>&nbsp;</p>" .
					"<p>如有疑問，隨時歡迎您與「超惠購」客服中心聯繫，謝謝。</p>" .
					"<p>&nbsp;</p>" .
					"<p>超惠購聯絡電話：0424351862</p>" .
					"<p>超惠購聯絡地址：台中市北屯區東山路一段50-18號</p>" .
					"<p>超惠購網址：supergoods.com.tw</p>" .
					"<p>客服信箱：service@supergoods.com.tw</p>";

				//寄信
				$this->mod_index->send_mail($this->get_host_config()['domain'], '超惠購', Comment::SetValue('by_email'), $subject, $message);

				//台灣註冊簡訊驗證 海外寄信信件驗證
				if ($this->setlang == 'TW') {
					//註冊驗證系統-簡訊發送驗證網址
					// $this->load->library('Sms');
					// $sms=new sms('av8d20','80280616','N7SUQ3');

					// $content='感謝您註冊jcymall會員，請於今日內點選連結 '.$tinyurl.' 開通您的帳戶，逾時失效。';

					// $smsval=$sms->Send_sms('jcymall會員註冊驗證通知信',$content,Comment::SetValue('d_account'),Comment::SetValue('by_email'),'');
					//註冊驗證系統-簡訊發送驗證網址
				} else {
					//model
					// $this->load->model('index_model', 'mod_index');
					//主旨
					// if($this->setlang=='ENG')
					// 	$subject='jcymall Shop ​Member registration notice letter';
					// if($this->setlang=='JAP')
					// 	$subject='jcymall康会員登録通知書';

					//內容
					// if($this->setlang=='ENG'){
					// 	$message="<p>Thank you for registering 'jcymall Shop', please click the link earlier this day ".$tinyurl." opened your account, failure timeout.</p>";
					// }
					// if($this->setlang=='JAP'){
					// 	$message="<p>「jcymall」を登録していただきありがとうございます、以前のこの日の".$tinyurl."は、障害のタイムアウトを、あなたのアカウントを開設したリンクをクリックしてください。";
					// }

					//寄信
					// $this->mod_index->send_mail('jcymall.com','jcymall', Comment::SetValue('by_email'), $subject, $message);
				}

				//$this->useful->AlertPage('/gold/login',$check->lang['regsucc']);//註冊成功,請重新登入
				//註冊者受邀請紅利100點請寫入紅利說明
				$rule = $this->mymodel->GetConfig('rule');
				$didata = array(
					'buyer_id' => $create_id,
					'd_type' => '19',
					'd_val' => $rule[6]['d_val'],
					'd_des' => "受邀請註冊發送紅利", //受邀請註冊發送紅利
					'is_send' => 'Y',
					'create_time' => $this->useful->get_now_time(),
					'update_time' => $this->useful->get_now_time(),
					'send_dt' => $this->useful->get_now_time(),
				);
				$this->mymodel->insert_into('dividend', $didata);
				//註冊成功後直接登入
				$_SESSION['AT']['d_account'] = $account;
				$login_data = array(
					'account' => Comment::SetValue('d_account'),
					'password'  => Comment::SetValue('by_pw'),
				);

				$admin = $this->login_model->login_chekc($login_data); //管理者登入

				// 登入狀態紀錄
				$_SESSION['MT']['is_login'] = 1;
				$_SESSION['MT']['by_id'] = $admin['by_id'];
				$_SESSION['MT']['name'] = $admin['name'];
				$_SESSION['MT']['d_is_member'] = $admin['d_is_member'];
				$_SESSION['MT']['member_id'] = $admin['member_id'];

				$this->useful->AlertPage('/products', $check->lang['registersu']);
			}
			return '';
		}
		if ($dbname == 'member_apply') {
			//將狀態改為待審中
			$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('d_is_member' => 2));
			//升級經營會員待審查
			$_SESSION['MT']['d_is_member'] = 2;
			$this->useful->AlertPage('/gold/member', $check->lang['applysu']);	//申請成功,請等待審核結果
			return '';
		}
		if ($dbname == 'address') {
			if ($del_id != '') {
				$this->useful->AlertPage('/gold/member_address', $msg);
			} else {
				if ($id != '')
					$this->useful->AlertPage('/gold/member_address', $msg);
				else
					$this->useful->AlertPage('/gold/member_address', $msg);
			}
		}
		//$this->useful->AlertPage('/gold/member_address_add_ok',"常用貨地址新增成功");
		if ($dbname == 'contact')
			$this->useful->AlertPage('/gold/contact_ok', $msg);	//'留言成功，服務人員盡快為您解答'
		if ($dbname == 'order')
			$this->useful->AlertPage('/gold/order_info/' . $id . '', $check->lang['backsu']); //申請退貨成功
		if ($dbname == 'talkapp') {
			if ($_SESSION['EBH'] == '1')
				$this->useful->AlertPage('/gold/talkapp/' . $data['b_id'] . '');
			else
				$this->useful->AlertPage('/gold/talkapp');
		}
	}

	//購物車 AJAX 同會員資料
	public function get_member()
	{
		$id = $_POST['bid'];

		$type = $_POST['type'];
		$dbdata = $this->mymodel->OneSearchSql('buyer', 'name,mobile,by_email,country,city,countory,address', array('by_id' => $id));
		if ($dbdata['country'] != 0)
			$adata = $this->mymodel->OneSearchSql('city_category', 's_id,s_name', array('s_id' => $dbdata['country']));
		if ($dbdata['city'] != 0)
			$cdata = $this->mymodel->OneSearchSql('city_category', 's_id,s_name', array('s_id' => $dbdata['city']));
		if ($dbdata['countory'] != 0)
			$codata = $this->mymodel->OneSearchSql('city_category', 's_zipcode,s_id,s_name', array('s_id' => $dbdata['countory']));
		if ($type == 'upgrade') {
			$dbdata['country'] = $adata['s_id'];
		} else {
			$dbdata['country'] = $adata['s_name'];
		}
		if ($cdata['s_id'] != null) {
			$dbdata['city_id'] = $cdata['s_id'];
			$dbdata['city'] = $cdata['s_name'];
		} else {
			$dbdata['city_id'] = '';
			$dbdata['city'] = '請選擇省份城市';
		}
		if ($codata['s_id'] != null) {
			$dbdata['countory_id'] = $codata['s_id'];
			$dbdata['countory'] = $codata['s_name'];
		} else {
			$dbdata['countory_id'] = '';
			$dbdata['countory'] = '請選擇地級市鄉鎮市區';
		}
		$dbdata['zipcode'] = $codata['s_zipcode'];
		echo json_encode($dbdata);
	}
	//註冊驗證系統-簡訊點選驗證
	public function member_verify()
	{
		//語言包
		$this->lang = $this->lmodel->config('20', $this->setlang);

		$no_num = $_GET['nonum'];

		$noarray = explode('_', base64_decode($no_num));
		$account = $noarray[1];
		$upaccount = $noarray[2];

		$bdata = $this->mymodel->OneSearchSql('buyer', 'by_id,is_verify', array('d_account' => $account));
		if (!empty($bdata)) {
			if ($bdata['is_verify'] == 'N') {
				$this->mymodel->update_set('buyer', 'd_account', $account, array('is_verify' => 'Y', 'verify_time' => $this->useful->get_now_time()));
				$set = $this->mymodel->GetConfig('', '60');
				$ddata = array(
					'buyer_id' => $bdata['by_id'],
					'd_type' => '18',
					'd_val' => $set['d_val'],
					'd_des' => $this->lang['sendsucc'],	//'註冊驗證成功發送紅利'
					'is_send' => 'Y',
					'create_time' => $this->useful->get_now_time(),
					'update_time' => $this->useful->get_now_time(),
					'send_dt' => $this->useful->get_now_time(),
					'is_del' => 'N'
				);
				$this->mymodel->insert_into('dividend', $ddata);
				$this->mymodel->update_set('buyer', 'by_id', $bdata['by_id'], array('d_dividend' => $set['d_val']));
				$this->useful->AlertPage('/gold/index/' . $upaccount . '', $this->lang['success']);	//帳號驗證完成,請重新登入
			} else
				$this->useful->AlertPage('/gold/index/' . $upaccount . '', $this->lang['vsucc']); //帳號已驗證完成
		} else
			$this->useful->AlertPage('/gold/index/' . $upaccount . '', $this->lang['noacc']); //帳號已不存在，請重新申請
	}
	//語系切換
	public function setlang()
	{
		@session_start();
		$lang = $_POST['lang'];
		$type = $_POST['type'];
		if ($type == 'admin') {
			$_SESSION['lang'] = $lang;
			$this->session->set_userdata('lang', $lang);
		} else {
			$_SESSION['LA']['lang'] = $lang;
		}
	}

	public function qa()
	{
		@session_start();
		$this->load->model('qa_model', 'mod_news');

		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = $this->data['banner'];

		//撈取資料
		$data['group'] = $this->mod_news->select_from_order_limit('q_and_a_group', array('qaag_id', 'qaag_name'), array(), 'sort', 'asc');
		$data['news'] = $this->mod_news->select_from_order_limit('q_and_a', array('qaa_id', 'qaag_id', 'qaa_title', 'qaa_content'), array('enable' => '1'), 'sort', 'asc');
		//標題
		$data['title'] = $content[0]['d_title'];

		//view
		$this->load->view('index/header' . $this->style, $data);
		if ($_SESSION['MT']['is_login'] == 1)
			$this->load->view('index/member/member_nav', $data);
		$this->load->view('/qa/qa', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}
}
