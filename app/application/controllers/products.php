<?php
class Products extends MY_Controller
{
	private $_rootPath, $_data, $_myView;
	public $Spath = '/uploads/000/000/0000/0000000000/products/';
	public $Spath_class = '/uploads/000/000/0000/0000000000/products_class/';
	public function __construct() //初始化
	{
		parent::__construct();

		//model
		$this->load->model('admin_model', 'mod_admin');
		$this->load->model('member_model', 'mmodel');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('index_model');
		//語言包設置
		$this->load->model('lang_model', 'lmodel');
		//model 20171117
		$this->load->model(array('banner_model', 'products_model', '/MyModel/mymodel'));
		$this->load->model('product_class_model', 'classModel');
		$this->load->model('commits_model');
		// language detail需要語系,否則會錯誤
		$this->load->helper('language');
		if (!$this->session->userdata('lang') || $this->session->userdata('lang') == 'zh-tw') {
			$this->session->set_userdata('lang', 'TW');
			$this->data['lang'] = $this->session->userdata('lang');
		} else {
			$this->data['lang'] = $this->session->userdata('lang');
		}
		$this->load->model('language_model', 'mod_language');
		$lang = $this->mod_language->converter('14', $this->session->userdata('lang'));
		$this->data = array_merge($this->data, $lang);

		// language
		$lang = $this -> mod_language -> converter('20', $this->session-> userdata('lang'));
		$this ->data = array_merge($this -> data, $lang);


		//helper
		$this->load->helper('url');
		//library
		$this->load->library('/mylib/useful');
		// comment 
		$this->load->library('/mylib/comment');
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
		//列表顯示
		$_SESSION['select_prd_list'] = (!empty($_SESSION['select_prd_list'])) ? $_SESSION['select_prd_list'] : 'prd_list_img';
		//列表排序
		$_SESSION['prd_sort'] = (!empty($_SESSION['prd_sort'])) ? $_SESSION['prd_sort'] : 'prd_new';
		//web config
		$this->data['web_config']	=	$this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->data['banner'] = $this->banner_model->getMyAd();
		$this->style 				=	(!empty($this->data['style_config']['style_id'])) ? $this->data['style_config']['style_id'] : '';
		$this->load->helper('form');
		//檔案名
		$this->DataName = 'products';
		@session_start();
	}

	//紀錄列表顯示方式ajax
	public function ajax_prd_list()
	{
		$_SESSION['select_prd_list'] = $_POST['list'];
	}
	//紀錄列表排序方式ajax
	public function prd_sort()
	{
		$_SESSION['prd_sort'] = $_POST['sort'];
	}

	//產品前台列表
	public function index($pid = 0)
	{
		header("Cache-control: private");

		/** extract query string to variables */
		extract(Comment::params(['providerId', 'keyword', 'maxPrice', 'minPrice', 'sortType', 'pageNumber', 'pageSize'], ['pageNumber' => 1, 'pageSize' => 12]));
		$data['keyword'] = $keyword;

		//語言包
		$this->lang = $this->lmodel->config('9', $this->setlang);

		if ($_SESSION['MT']['is_login'] == 1) {
			$by_id		=	$_SESSION['MT']['by_id'];
			$account_id	= $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));
			$PID	=	$account_id['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}
		}

		$_SESSION['url']			= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$_SESSION['shareUrl']	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		//資料庫名稱
		$data['dbname'] = $dbname = 'products';
		$data['dbname_class'] = $dbname_class = 'product_class';
		$data['banner'] = $this->data['banner'] = $this->banner_model->getMyAd();

		$bdata = $this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id)); //是否VIP

		$data['d_spec_type'] = $d_spec_type = $bdata['d_spec_type'];

		/** product class list */
		$data['productClasses'] = $this->classModel->getList($this->setlang);
		$data['activeClass'] = $pid;

		/** supplier list */
		$data['suppliers'] = $this->mymodel->select_page_form('providers', '', 'id,english_name,is_provider', array());

		$data['ToPage'] = $Topage = intval($pageNumber) > 0 ? intval($pageNumber) : 1;

		if ($this->data['web_config']['product_home'] == 1 and empty($pid)) { //後台選擇商品首頁為熱銷商品排序
			if ($d_spec_type == 1) { //特殊身分
				$qpage_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
				$dbdata_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
			} else { //一般身分
				$qpage_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
				$dbdata_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
			}
			//分頁程式 start
			$qpage = $this->useful->setPageJcy($dbname, '', 20, $qpage_arr);
			$data['page'] = $this->useful->getPageJcy($qpage);
			//分頁程式 end
			$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', $dbdata_arr, 'hot_sort');
			$data['path_title'] = '<li><a href="/' . $this->DataName . '/"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>';
		} else { //後台選擇商品首頁為最新商品排序	,or 選擇某一分類

			/** breadcrumb maybe I guess */
			if (!empty($pid)) {
				//先找出這個分類有沒有上層
				$path = $this->mymodel->OneSearchSql($dbname_class, 'PID, prd_cname', array('prd_cid' => $pid));
				if (!empty($path['PID'])) {
					$path2 = $this->mymodel->OneSearchSql($dbname_class, 'prd_cname', array('prd_cid' => $path['PID']));
					$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' .
						'<li><a><span>' . $path2['prd_cname'] . '</span></a></li>' .
						'<li><a href="/' . $this->DataName . '/' . $pid . '"><span>' . $path['prd_cname'] . '</span></a></li>';
				} else {
					$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' .
						'<li><a href="/' . $this->DataName . '/' . $pid . '"><span>' . $path['prd_cname'] . '</span></a></li>';
				}
			} else {
				$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>';
			}

			$_POST['pid'] = (isset($_POST['pid'])) ? $_POST['pid'] : 0;
			$pid = (($pid <> 0)) ? $pid : $_POST['pid'];

			/** Product query filter start */
			$qpage_arr = [
				'lang_type' => $this->setlang,
				'd_enable' => 'Y',
				'prd_active' => 1,
			];

			$pid > 0 ? $qpage_arr['prd_cid'] = $pid : '';
			$keyword ? $qpage_arr['prd_name like'] = ('%' . $keyword . '%') : '';
			$providerId ? $qpage_arr['supplier_id'] = $providerId : '';

			$priceColumn = 'prd_price00';

			if ($d_spec_type == 1) {
				$qpage_arr['is_bonus'] = 'N';
				$priceColumn = 'd_mprice';
				$sort = $sortType == 1 ? products_model::SORT_M_PRICE_ASC : products_model::SORT_M_PRICE_DESC;
			} else {
				$qpage_arr['is_vip'] = 'N';
				$qpage_arr['is_bonus'] = 'N';
				$sort = $sortType == 1 ? products_model::SORT_00_PRICE_ASC : products_model::SORT_00_PRICE_DESC;
			}
			$minPrice ? $qpage_arr[$priceColumn . ' >='] = $minPrice : '';
			$maxPrice ? $qpage_arr[$priceColumn . ' <='] = $maxPrice : '';

			/** Product query filter end */

			$pageData = $this->products_model->pageData($qpage_arr, $pageNumber, $pageSize, $sortType ? $sort : null);

			$data['pageData'] = $pageData;
			$data['pid'] = $pid;
			//產品列表
			$prd_sort = $_SESSION['prd_sort'];

			$dbdata = $pageData['data'];
		}

		foreach ($dbdata as $key => &$value) {
			$value['priceName']	=	($d_spec_type == 1) ? $this->lang['p_price_vip'] : $this->lang['p_price'];
			$value['price']		=	($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00'];
			$value['prd_describe'] = str_replace('*#', ',', $value['prd_describe']);
			$image  = explode(',', $value['prd_image']);
			$value['prd_image'] = $image[0];
		}

		$data['dbdata'] = $dbdata;
		$data['body_class'] = 'products';

		// product_type_img用
		$data['class_name'] = $path['prd_cname'];
		$data['class_url'] = '/' . $this->DataName . '/' . $pid;

		//APP分享
		$data['share_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['share_prd_image'] = 'http://' . $_SERVER['HTTP_HOST'] . "/images/logo_s.png";

		/** Get favorite product id array */
		$this->load->model('favorite_model', 'favoModel');
		$data['faIds'] = $this->favoModel->getFavoriteIds($by_id);
		//view
		if ($data['isAjax'] = $this->isAjax()) {
			/** return html */
			$this->load->view($this->indexViewPath . '/products/_item_list', $data);
			/** return array */
			// $this->apiResponse($data['dbdata']);
		} else {

			$this->load->view($this->indexViewPath . '/header' . $this->style, $data);
			$this->load->view($this->indexViewPath . '/products/index', $data);
			$this->load->view($this->indexViewPath . '/footer' . $this->style, $data);
		}
	}

	//好物精選(熱銷產品)前台列表
	public function hot_list()
	{
		header("Cache-control: private");
		//語言包
		$this->lang = $this->lmodel->config('9', $this->setlang);
		if ($_SESSION['MT']['is_login'] == 1) {
			$by_id		=	$_SESSION['MT']['by_id'];
			$account_id	= $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));
			$PID	=	$account_id['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}
		}
		$_SESSION['url']			= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$_SESSION['shareUrl']	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['banner'] = $this->data['banner'] = $this->banner_model->getMyAd();
		//資料庫名稱
		$data['dbname'] = $dbname = 'products';
		$data['dbname_class'] = $dbname_class = 'product_class';
		$bdata				=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id)); //是否VIP
		$data['d_spec_type'] =	$d_spec_type	=	$bdata['d_spec_type'];
		$product_class = $this->mymodel->select_page_form($dbname_class, '', 'prd_cid', array('PID' => $pid, 'd_enable' => 'Y'));
		if (!empty($product_class) and $pid <> 0) {
			$this->useful->AlertPage('/products/' . $product_class['0']['prd_cid']);
		}

		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		if ($d_spec_type == 1) { //特殊身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
		} else { //一般身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
		}
		//分頁程式 start
		$qpage = $this->useful->setPageJcy($dbname, '', 20, $qpage_arr);
		$data['page'] = $this->useful->getPageJcy($qpage);
		//分頁程式 end
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', $dbdata_arr, 'hot_sort');
		$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' . '<li><a href="/hot_list"><span>' . $this->lang_menu['products_hot'] . '</span></a></li>';

		foreach ($dbdata as $key => &$value) {
			$value['priceName']	=	($d_spec_type == 1) ? $this->lang['p_price_vip'] : $this->lang['p_price'];
			$value['price']		=	($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00'];
			$value['prd_describe'] = str_replace('*#', ',', $value['prd_describe']);
			$image  = explode(',', $value['prd_image']);
			$value['prd_image'] = $image[0];
		}
		$data['dbdata'] = $dbdata;
		$data['body_class'] = 'products';
		$data['hot_list'] = 'Y';
		$data['hot_active'] = 'Y';
		// product_type_img用
		$data['class_name'] = $path['prd_cname'];
		$data['class_url'] = '/' . $this->DataName . '/' . $pid;
		//APP分享
		$data['share_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['share_prd_image'] = 'http://' . $_SERVER['HTTP_HOST'] . "/images/logo_s.png";

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/product/nav', $data);
		$this->load->view('index/product/list', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//好物精選(熱銷產品)前台列表
	public function prebuy_list()
	{
		header("Cache-control: private");
		//語言包
		$this->lang = $this->lmodel->config('9', $this->setlang);
		if ($_SESSION['MT']['is_login'] == 1) {
			$by_id		=	$_SESSION['MT']['by_id'];
			$account_id	= $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));
			$PID	=	$account_id['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}
		}
		$_SESSION['url']			= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$_SESSION['shareUrl']	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['banner'] = $this->data['banner'] = $this->banner_model->getMyAd();
		//資料庫名稱
		$data['dbname'] = $dbname = 'products';
		$data['dbname_class'] = $dbname_class = 'product_class';
		$bdata				=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id)); //是否VIP
		$data['d_spec_type'] =	$d_spec_type	=	$bdata['d_spec_type'];
		$product_class = $this->mymodel->select_page_form($dbname_class, '', 'prd_cid', array('PID' => $pid, 'd_enable' => 'Y'));
		if (!empty($product_class) and $pid <> 0) {
			$this->useful->AlertPage('/products/' . $product_class['0']['prd_cid']);
		}

		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		if ($d_spec_type == 1) { //特殊身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_prebuy' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_prebuy' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
		} else { //一般身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_prebuy' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_prebuy' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
		}
		//分頁程式 start
		$qpage = $this->useful->setPageJcy($dbname, '', 20, $qpage_arr);
		$data['page'] = $this->useful->getPageJcy($qpage);
		//分頁程式 end
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', $dbdata_arr, 'prebuy_sort');
		$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' . '<li><a href="/hot_list"><span>' . $this->lang_menu['products_hot'] . '</span></a></li>';

		foreach ($dbdata as $key => &$value) {
			$value['priceName']	=	($d_spec_type == 1) ? $this->lang['p_price_vip'] : $this->lang['p_price'];
			$value['price']		=	($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00'];
			$value['prd_describe'] = str_replace('*#', ',', $value['prd_describe']);
			$image  = explode(',', $value['prd_image']);
			$value['prd_image'] = $image[0];
		}
		$data['dbdata'] = $dbdata;
		$data['body_class'] = 'products';
		$data['hot_list'] = 'Y';
		$data['prebuyer_active'] = 'Y';
		// product_type_img用
		$data['class_name'] = $path['prd_cname'];
		$data['class_url'] = '/' . $this->DataName . '/' . $pid;
		//APP分享
		$data['share_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['share_prd_image'] = 'http://' . $_SERVER['HTTP_HOST'] . "/images/logo_s.png";

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/product/nav', $data);
		$this->load->view('index/product/list', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//新品推薦 前台列表
	public function new_list()
	{
		header("Cache-control: private");
		//語言包
		$this->lang = $this->lmodel->config('9', $this->setlang);
		if ($_SESSION['MT']['is_login'] == 1) {
			$by_id		=	$_SESSION['MT']['by_id'];
			$account_id	= $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));
			$PID	=	$account_id['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}
		}
		$_SESSION['url']			= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$_SESSION['shareUrl']	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['banner'] = $this->data['banner'] = $this->banner_model->getMyAd();
		//資料庫名稱
		$data['dbname'] = $dbname = 'products';
		$data['dbname_class'] = $dbname_class = 'product_class';
		$bdata				=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id)); //是否VIP
		$data['d_spec_type'] =	$d_spec_type	=	$bdata['d_spec_type'];
		$product_class = $this->mymodel->select_page_form($dbname_class, '', 'prd_cid', array('PID' => $pid, 'd_enable' => 'Y'));
		if (!empty($product_class) and $pid <> 0) {
			$this->useful->AlertPage('/products/' . $product_class['0']['prd_cid']);
		}

		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		if ($d_spec_type == 1) { //特殊身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_new' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_new' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N');
		} else { //一般身分
			$qpage_arr = array('lang_type' => $this->setlang, 'prd_new' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
			$dbdata_arr = array('lang_type' => $this->setlang, 'prd_new' => 'Y', 'd_enable' => 'Y', 'prd_active' => '1', 'is_bonus' => 'N', 'is_vip' => 'N');
		}
		//分頁程式 start
		$qpage = $this->useful->setPageJcy($dbname, '', 20, $qpage_arr);
		$data['page'] = $this->useful->getPageJcy($qpage);
		//分頁程式 end
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', $dbdata_arr, 'new_sort');
		$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' . '<li><a href="/new_list"><span>' . $this->lang_menu['products_new'] . '</span></a></li>';

		foreach ($dbdata as $key => &$value) {
			$value['priceName']	=	($d_spec_type == 1) ? $this->lang['p_price_vip'] : $this->lang['p_price'];
			$value['price']		=	($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00'];
			$value['prd_describe'] = str_replace('*#', ',', $value['prd_describe']);
			$image  = explode(',', $value['prd_image']);
			$value['prd_image'] = $image[0];
		}
		$data['dbdata'] = $dbdata;
		$data['body_class'] = 'products';
		$data['hot_list'] = 'Y';
		$data['new_active'] = 'Y';
		// product_type_img用
		$data['class_name'] = $path['prd_cname'];
		$data['class_url'] = '/' . $this->DataName . '/' . $pid;
		//APP分享
		$data['share_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['share_prd_image'] = 'http://' . $_SERVER['HTTP_HOST'] . "/images/logo_s.png";

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/product/nav', $data);
		$this->load->view('index/product/list', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	//產品前台詳細列表
	public function detail($id)
	{
		if ($this->isLogin()) {
			$by_id	=	$_SESSION['MT']['by_id'];
			$account_id = $this->mymodel->OneSearchSql('buyer', 'd_account', array('by_id' => $by_id));
			$account = $account_id['d_account'];
		}

		$_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$_SESSION['shareUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$insert_data = array(
			'prd_id' 		=>  $id,
			'date_time' 	=>  date("Y-m-d h:i:sa"),
			'page_view'		=>  1,
			'member_id'		=> (!empty($by_id)) ? $by_id : '0',
			'account'		=>  $account
		);
		$this->products_model->products_insert_views('products_views', $insert_data);
		//語言包
		$this->lang = $this->lmodel->config('10', $this->setlang);
		$data['isFavoriteName']		=	$this->lang['p_unlike'];
		$data['isJoinName']			=	$this->lang['p_car'];
		$data['isJoinJs']			=	'join_car(0)';
		$data['join_car_add']			=	count($_SESSION['join_car']) + 1;
		$data['join_car_less']			=	count($_SESSION['join_car']);
		//此商城是誰的(購物顧問)非會員才判斷,若為會員 購物顧問即推薦人
		//先確認有無此商家存在
		if ($_SESSION['MT']['is_login'] == 1) {
			$by_id	=	$_SESSION['MT']['by_id'];
			$account_id = $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));
			$PID	=	$account_id['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}
			//我的最愛
			$favorite = $this->mymodel->OneSearchSql('product_favorite', 'd_product_id', array('d_member_id' => $by_id, 'd_product_id' => $id));
			if (!empty($favorite['d_product_id'])) {
				$data['isFavorite'] = "style='background: #D96893;border:1px solid #a5a5a5;color: #fff;'";
				$data['isFavoriteName'] = $this->lang['p_islike'];
			}
		} else {
			$account_id = $this->mymodel->OneSearchSql('member', 'by_id', array('account' => $account));
			if (!empty($account_id['by_id'])) {
				$by_id	=	$account_id['by_id'];
				if ($by_id <> 4) {
					$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $by_id));
					$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
				}
			}
		}
		//資料庫名稱
		$data['dbname'] = $dbname = 'products';
		$data['dbname_class'] = $dbname_class = 'product_class';
		//是否VIP
		$bdata				=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id));
		$data['d_spec_type'] =	$d_spec_type		=	$bdata['d_spec_type'];
		//產品列表
		$productsDetail 	=	$this->products_model->productsDetail($id, $d_spec_type);
		$dbdata 			=	$productsDetail['data'];
		if (empty($productsDetail['num'])) {
			$this->useful->AlertPage('/products', $this->lang['p_no_product']); //沒有這個商品or此商品下架
		}
		//紅利
		$config = $this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 73));
		$config['d_val'] = ($config['d_val']) / 100;
		$data['priceName']					=	($d_spec_type == 1) ? $this->lang['p_price_vip'] : $this->lang['p_price'];
		$data['price']						=	($d_spec_type == 1) ? $dbdata['d_mprice'] : $dbdata['prd_price00'];
		$data['prd_pv']						=	$dbdata['prd_pv'];
		$data['bonus']						=	$data['price'] * $config['d_val'];
		$dbdata['prd_content']				=	str_replace("&quot;", "'", $dbdata['prd_content']);	//編輯器圖檔問題
		$data['dbdata'] 					= 	$dbdata;
		$data['prd_describe'] 				= 	explode('*#', $dbdata['prd_describe']);
		$data['prd_specification_name'] 	= 	explode('*#', $dbdata['prd_specification_name']);
		$data['prd_specification_content']	= 	explode('*#', $dbdata['prd_specification_content']);
		$data['prd_video_name']				= 	explode('*#', $dbdata['prd_video_name']);
		$data['prd_video_link']				= 	explode('*#', $dbdata['prd_video_link']);
		$data['prd_amount']					=	(int) $dbdata['prd_amount'];

		$data['banner'] = $this->data['banner'] = $this->banner_model->getMyAd();

		if ($this->data['web_config']['cart_spec_status'] == 1) {
			$car_id 							= 	$id . '##*' . $data['prd_specification_content'][1];
		} else {
			$car_id 							= 	$id;
		}
		//加入購物車
		if (!empty($_SESSION['join_car'])) {
			foreach ($_SESSION['join_car'] as $key => $value) {
				if ($key	==	$car_id) {
					$data['isJoin']		=	"style='background: #000;'";
					$data['isJoinName']	=	$this->lang['p_delcar'];
					$data['isJoinJs']	=	'demit_car(0)';
					$data['join_car_add']			=	count($_SESSION['join_car']);
					$data['join_car_less']			=	count($_SESSION['join_car']) - 1;
				}
			}
		}
		if (!empty($dbdata['PID'])) {	//2層在撈一次上層
			$path = $this->mymodel->OneSearchSql($dbname_class, 'prd_cname', array('prd_cid' => $dbdata['PID']));
			$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' .
				'<li><a><span>' . $path['prd_cname'] . '</span></a></li>' .
				'<li><a href="/' . $this->DataName . '/' . $dbdata['prd_cid'] . '"><span>' . $dbdata['prd_cname'] . '</span></a></li>' .
				'<li><a href="/' . $this->DataName . '/detail/' . $dbdata['prd_id'] . '"><span>' . $dbdata['prd_name'] . '</span></a></li>';
		} else {
			$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang_menu["$this->DataName"] . '</span></a></li>' .
				'<li><a href="/' . $this->DataName . '/' . $dbdata['prd_cid'] . '"><span>' . $dbdata['prd_cname'] . '</span></a></li>' .
				'<li><a href="/' . $this->DataName . '/detail/' . $dbdata['prd_id'] . '"><span>' . $dbdata['prd_name'] . '</span></a></li>';
		}
		//購買說明
		$cset_paid = 'cset_paid_' . $this->session->userdata('lang');
		$buy_content = $this->mymodel->OneSearchSql('iqr_cart', "$cset_paid", array('member_id' => '1'));
		$data['buy_content'] = $buy_content["$cset_paid"];
		//運送規則
		$cset_ship = 'cset_ship_' . $this->session->userdata('lang');
		$ship_rule = $this->mymodel->OneSearchSql('iqr_cart', "$cset_ship", array('member_id' => '1'));
		$data['ship_rule'] = $ship_rule["$cset_ship"];
		//猜你喜歡
		$data['dbdataLike'] = $this->products_model->productsList($dbdata['prd_cid'], 6, 1, $d_spec_type);
		foreach ($data['dbdataLike'] as $key => $value) {
			$image = explode(',', $value['prd_image']);
			$data['dbdataLike'][$key]['prd_image'] = $img_url . $image['0'];
		}
		//APP分享
		$data['share_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['share_prd_image'] = 'http://' . $_SERVER['HTTP_HOST'] . "/uploads/000/000/0000/0000000000/products/" . $dbdata['prd_image'];
		$data['body_class'] = 'products';
		$data['banner'] = '';

		//view
		if ($this->isAjax()) {
			$this->apiResponse($data);
		} else {
			$this->load->view($this->indexViewPath . '/header', $data);
			$this->load->view($this->indexViewPath . '/products/info', $data);
			$this->load->view($this->indexViewPath . '/footer' . $this->style, $data);
		}
	}

	//購物車
	public function ajax_car()
	{
		$this->lang = $this->lmodel->config('10', $this->setlang);

		if ($_SESSION['MT']['is_login'] == 1) {
			$buyer = $this->mymodel->OneSearchSql('buyer', 'PID, d_spec_type', array('by_id' => $_SESSION['MT']['by_id']));
			if ($this->data['web_config']['is_PID'] == 1 and empty($buyer['PID'])) {
				return $this->apiResponse(['success' => false, 'msg' => $this->lang['norecommended']]);
			} else {

				extract(Comment::params(['product_id', 'shop_count', 'spec'], ['product_id' => 0]));

				if (!empty($shop_count) and preg_match("/^[1-9][0-9]*$/", $shop_count)) {

					$itemData = $this->products_model->productsDetail($product_id, $buyer['d_spec_type']);

					if (count($itemData['data']) == 0) {
						return $this->apiResponse(['success' => false, 'msg' => $this->lang['no_item']]);
					}

					$_SESSION['join_car'] = !empty($_SESSION['join_car']) ? $_SESSION['join_car'] : [];

					$price = ($buyer['d_spec_type'] == 1) ? 'd_mprice' : 'prd_price00';

					$tempData = [
						'prd_id' => $product_id,
						'amount' => $shop_count,
						'prd_name' => $itemData['data']['prd_name'],
						'price' => $itemData['data'][$price],
						'prd_image' => $this->Spath . explode(',', $itemData['data']['prd_image'])[0],
					];

					$this->data['web_config']['cart_spec_status'] == 1 ? $tempData['spec'] = $spec : '';

					$uuid = uniqid('cart_');
					$_SESSION['join_car'][$uuid] = $tempData;

					return $this->apiResponse(['success' => true, 'msg' => $this->lang['p_carok'], 'data' => [
						'item' => $itemData['data'],
						'uuid' => $uuid
					]]);
				} else {
					return $this->apiResponse(['success' => false, 'msg' => $this->lang['p_carnum']]);
				}
			}
		} else {
			return $this->apiResponse(['success' => false, 'msg' => $this->lang['Login']]);
		}
	}

	/**
	 * remove item from cart
	 */
	public function ajax_demitcar()
	{
		$this->lang = $this->lmodel->config('10', $this->setlang);

		extract(Comment::params(['uuid'], ['uuid' => 'there is no key']));

		$uuid = is_array($uuid) ? $uuid : [$uuid];

		foreach ($uuid as $id) {
			unset($_SESSION['join_car'][$id]);
		}

		return $this->apiResponse(['success' => true, 'msg' => $this->lang['del_true'], 'data' => $_SESSION['join_car']]);
	}

	//加入最愛
	public function ajax_favorite()
	{
		//@session_start();
		if ($_SESSION['MT']['is_login'] == 1) {
			$product_id	=	$_POST['product_id'];
			$by_id	=	$_SESSION['MT']['by_id'];

			$favorite = $this->mymodel->OneSearchSql('product_favorite', 'd_product_id', array('d_member_id' => $by_id, 'd_product_id' => $product_id));

			if (!empty($favorite['d_product_id'])) { //移除最愛
				$this->mmodel->delete_where('product_favorite', array('d_member_id' => $by_id, 'd_product_id' => $product_id));
				echo '1';
			} else { //新增最愛
				$date = date("Y-m-d h:i:sa");
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$myip = $_SERVER['HTTP_CLIENT_IP'];
				} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$myip = $_SERVER['REMOTE_ADDR'];
				}
				$this->mmodel->insert_into(
					'product_favorite',
					array(
						'd_createTime' => $date, 'd_edit_id' => $by_id, 'd_edit_ip' => $myip,
						'd_member_id' => $by_id, 'd_product_id' => $product_id, 'd_enable' => 'N'
					)
				);
				echo '2';
			}
		} else {
			echo 'login';
		}
	}
	// 商品搜尋 20180212
	public function search_engine()
	{
		header("Cache-control: private");
		$data = $this->data;
		$by_id	=	$_SESSION['MT']['by_id'];
		//語言包
		$this->lang = $this->lmodel->config('21', $this->setlang);
		$this->prdlang = $this->lmodel->config('9', $this->setlang);
		$data['img_url']	= $this->Spath;
		$data['body_class']	= 'search-engine-fix';
		$data['tips'] 		= '';
		$data['member'] 	= $member = $this->mod_cart->select_from('member', array('member_id' => 1));
		$data['path_title']	= '<li><a href="/' . $this->DataName . '/search_engine"><span>' . $this->lang_menu['products_search'] . '</span></a></li>';
		$data['wrapper_class'] = ' product-search-fix';
		$data['post_type1'] = $_GET['type1'];
		$data['post_type2'] = $_GET['type2'];
		$data['price_start'] = $_GET['price_start'];
		$data['price_end'] = $_GET['price_end'];
		$data['banner'] = $this->data['banner'];
		$data['prd_type1'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->setlang, 'PID' => '0', 'd_enable' => 'Y'), 'prd_cid');
		if (!empty($data['post_type1'])) {
			$data['prd_type2'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->setlang, 'PID' => $data['post_type1'], 'd_enable' => 'Y'), 'prd_cid');
		} else if ($data['post_type1'] == 0) {
			//$data['prd_type2']=;
		} else {
			$data['prd_type2'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->setlang, 'PID' => $data['prd_type1']['0']['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
		}

		$data['search_history']	=	$search_history	=	$this->mymodel->OneSearchSql('search_history', '*', array('by_id' => $by_id));
		// if(!empty($this->input->get('search_key')))
		// {
		if (!empty($search_history)) {
			if ($this->input->get('search_key') <> $search_history['search1']) {
				$saerch_arr = array(
					'search1' => $this->input->get('search_key'),
					'search2' => $search_history['search1'],
					'search3' => $search_history['search2'],
					'search4' => $search_history['search3'],
					'search5' => $search_history['search4'],
					'search6' => $search_history['search5'],
					'search7' => $search_history['search6'],
					'search8' => $search_history['search7'],
					'search9' => $search_history['search8'],
					'search10' => $search_history['search9'],
					'by_id' => $by_id
				);
				$this->mmodel->update_set('search_history', 'by_id', $by_id, $saerch_arr);
			}
		} else {
			if (!empty($by_id)) {
				$this->mymodel->InsertData('search_history', array('search1' => $this->input->get('search_key'), 'by_id' => $by_id, 'create_time' => $this->useful->get_now_time()));
			}
		}
		$data['search_history']	=	$search_history	=	$this->mymodel->OneSearchSql('search_history', '*', array('by_id' => $by_id));

		//是否VIP
		if (!empty($by_id)) {
			$bdata	=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id));
		}
		$d_spec_type = (empty($bdata['d_spec_type'])) ? '0' : $bdata['d_spec_type'];
		$prd_sort 	= $_SESSION['prd_sort'];
		$prd_type 	= empty($_GET['type2']) ? $_GET['type1'] : $_GET['type2'];

		if (!isset($_GET['search_key'])) {
			$searchKey = '""';
		} else {
			$searchKey = empty($_GET['search_key']) ? '%' : $_GET['search_key'];
		}

		$search_result = $this->mod_cart->select_from_order_with_like('products', 'prd_id', desc, array('prd_name' => $searchKey), '0', $d_spec_type, $data['price_start'], $data['price_end'], $prd_sort, $prd_type, $this->setlang);
		if (!$search_result) {
			$data['tips'] = 'fail';
		}
		$data['search_key'] = $search_key = $this->input->get('search_key');
		foreach ($search_result as $key => &$value) {
			$value['priceName']	=	($d_spec_type == 1) ? $this->prdlang['p_price_vip'] : $this->prdlang['p_price'];
			$value['price']	=	($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00'];
			$image = explode(',', $value['prd_image']);
			$search_result[$key]['prd_image'] = $image['0'];
		}

		$data['search_result'] = $search_result;
		// }
		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/product/product_search', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	public function ajax_search()
	{ //前台讀取產品分類
		$prd_cid = $_POST['prd_cid'];
		$prd_sub_cid = $_POST['prd_sub_cid'];
		$res = '<select class="form-control" style="visibility:hidden;"></select>';
		if ($prd_cid != 0) {
			$product_type = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->setlang, 'PID' => $prd_cid, 'd_enable' => 'Y'), 'prd_cid');
			if (!empty($product_type)) {
				$res = '<select class="form-control" name="type2" id="type2">';
				foreach ($product_type as $key => $value) {
					$selected = ($prd_sub_cid == $value['prd_cid']) ? "selected='true'" : '';
					$res .= '<option value=' . $value['prd_cid'] . $selected . '>' . stripslashes($value['prd_cname']) . '</option>';
				}
				$res .= "</select>"; //echo $res;//將型號項目丟回給ajax
			}
		}
		echo $res;
	}
	public function ajax_del_search()
	{ //清除搜尋紀錄
		$this->mmodel->delete_where('search_history', array('by_id' => $_SESSION['MT']['by_id']));
	}

	//後台超管-------------------------------------------------------------------

	//產品分類列表
	public function product_class_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		$data['lang'] = $this->data;
		//資料庫名稱
		$data['dbname'] = $dbname = 'product_class';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage_0($dbname, '', 20, array('d_enable' => 'Y', 'lang_type' => $this->session->userdata('lang'), 'PID' => "0"));
		$qpage_total = $this->useful->SetPage($dbname, '', '', array('d_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end
		$data['total']	=	$qpage_total['TotalRecord'];

		$conditionLevle1 = array(
			'd_enable' => ($_POST['d_enable'] ? $_POST['d_enable'] : 'Y'),
			'lang_type' => $this->session->userdata('lang'),
			'PID' => "0"
		);
		$conditionLevle1Like = array();

		if ($_POST['prd_cname']) {
			$conditionLevle1Like['prd_cname'] = $_POST['prd_cname'];
		}

		//第一層分類
		$data['dbdata'] = $dbdata = $this->mymodel->select_page_form_0_like($dbname, $qpage['result'], '*', $conditionLevle1, $conditionLevle1Like, 'prd_cid');
		$conditionLevle2 = $conditionLevle1;
		unset($conditionLevle2['PID']);
		//第二層分類
		foreach ($dbdata as $key => $value) {
			$prd_cid 					=	$value['prd_cid'];
			$conditionLevle2['PID'] = $prd_cid;
			$data['data_sub'][$prd_cid]	=	$this->mymodel->select_page_form($dbname, '', '*', $conditionLevle2, 'prd_cid');
		}
		//檔案名
		$data['DataName'] = $this->DataName;

		//view
		$this->load->view('products/product_class_list', $data);
	}

	// 啟用限時搶購
	public function enable_buying($id)
	{
		if (in_array('', $_POST) || in_array(null, $_POST)) {
			$this->apiResponse(['error' => 'Unprocessable Entity'], 422);
		}

		$this->classModel->enable($id, $_POST);
		$this->apiResponse(['status' => 'success']);
	}

	// 取消限時搶購
	public function cancel_buying($id)
	{
		$this->classModel->cancel($id);
		$this->apiResponse(['status' => 'success']);
	}

	public function judge_buying($id)
	{
		if (in_array('', $_POST) || in_array(null, $_POST)) {
			$this->apiResponse(['error' => 'Unprocessable Entity'], 422);
		}

		$this->classModel->modifyDate($id, $_POST);
		$this->apiResponse(['status' => 'success']);
	}

	//產品分類內頁
	public function product_class_info($id = '', $copy = '')
	{
		$this->useful->CheckComp('j_comlist');

		$data['dbname'] = $dbname = 'product_class';

		$dbdata = $this->mmodel->select_from($dbname, array('prd_cid' => $id));
		//20180223
		$dbdata['prd_cimage1'] = $dbdata['prd_cimage'];
		$dbdata['prd_cimage'] = '/uploads/000/000/0000/0000000000/products_class/' . $dbdata['prd_cimage'];

		if (!empty($copy)) {
			$dbdata['prd_cid'] = '';
			$dbdata['prd_image'] = '';
		}

		$data['dbdata'] = $dbdata;


		$data['protype'] = $this->mymodel->select_page_form('product_class', '', '*', array('lang_type' => $this->session->userdata('lang'), 'PID' => 'NULL', 'd_enable' => 'Y'));

		//檔案名
		$data['DataName'] = $this->DataName;

		//view
		$this->load->view('products/product_class_info', $data);
	}
	//產品列表
	public function products_list()
	{
		header("Cache-control: private");
		//權限判斷
		$this->useful->CheckComp('j_comdata');
		$img_url = '/uploads/000/000/0000/0000000000/products/';

		//資料庫名稱
		$data['dbname'] = $dbname = 'products';

		if ((!empty($_POST['product_class']) or !empty($_POST['product_status']) or !empty($_POST['product_hot']) or !empty($_POST['product_new'])) or !empty($_POST['prd_name']) and $_POST['product_status'] != 3 or !empty($_POST['prd_no'])) {
			if ($_POST['product_status'] == 4) $_POST['product_status'] = 0;
			$data_array = array(
				'lang_type' => $this->session->userdata('lang'),
				'd_enable' => "Y",
				'prd_cid' => $_POST['product_class'],
				'prd_active' => $_POST['product_status'],
				'prd_hot' => $_POST['product_hot'],
				'prd_new' => $_POST['product_new'],
				'prd_name' => $_POST['prd_name'],
				'prd_no' => $_POST['prd_no']
			);

			//分頁程式 start
			$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
			$qpage = $this->useful->SetPage($dbname, $Topage, 20, $data_array);
			$data['page'] = $this->useful->get_page($qpage);
			//分頁程式 end

			//$dbdata = $this -> mmodel -> get_order_data($_POST['product_class'],$_POST['product_status'],$this->setlang);
			$dbdata = $this->select_products_data($qpage['result'], $this->session->userdata('lang'), $_POST['product_class'], $_POST['product_status'], $_POST['product_hot'], $_POST['product_new'], $_POST['prd_name'], $_POST['prd_no']);
			$data['product_hot'] = $_POST['product_hot'];
			$data['product_new'] = $_POST['product_new'];
			$data['product_class'] = $_POST['product_class'];
			if ($_POST['product_status'] == 0) $_POST['product_status'] = 4;
			$data['product_status'] = $_POST['product_status'];
			$data['prd_name'] = $_POST['prd_name'];
		} else {
			//分頁程式 start
			$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
			$qpage = $this->useful->SetPage($dbname, $Topage, 10, array('lang_type' => $this->session->userdata('lang'), 'd_enable' => "Y"));
			$data['page'] = $this->useful->get_page($qpage);
			//分頁程式 end

			//echo json_encode($qpage);exit;
			//$dbdata = $this -> mod_admin -> select_from_group_by($qpage['result'],$this->setlang);
			$dbdata = $this->select_products_data($qpage['result'], $this->session->userdata('lang'));
		}

		foreach ($dbdata as $key => $value) {
			$image = explode(',', $value['prd_image']);
			$dbdata[$key]['prd_image'] = $img_url . $image[0];
			$dbdata[$key]['prd_new'] = ($value['prd_new'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_prebuy'] = ($value['prd_prebuy'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_hot'] = ($value['prd_hot'] == 'fa fa-heart-o') ? '否' : '是';
			if ($value['prd_active'] == '2')
				$act = "商品下架";
			elseif ($value['prd_active'] == '1')
				$act = "尚有庫存";
			else
				$act = "商品補貨";
			$dbdata[$key]['prd_active'] = $act;

			$dbdata[$key]['setview'] = $value['view'];
			//20160526瀏覽人數設定
			if (strlen($value['view']) > 3) {
				$dbdata[$key]['setview'] = number_format(floor($value['view'] / 1000)) . 'K';
			}

			//搜尋結果-庫存量不足
			if ($_POST['product_status'] == 3) {
				if ($value['prd_amount'] > $value['prd_safe_amount']) {
					unset($dbdata[$key]);
				}
				$data['product_status'] = $_POST['product_status'];
			}
		}

		$data['dbdata'] = $dbdata;

		//產品系列
		$data['cdata'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y'));


		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/product_list', $data);
	}

	
	private function select_products_data($limit = '', $lang_type = 'TW', $class = '', $status = '', $hot = '', $new = '', $name = '', $prd_no = '')
	{
		$sql  = 'SELECT products.*, SUM(products_views.page_view) AS view';
		$sql .= ' FROM products LEFT JOIN products_views ON products.prd_id = products_views.prd_id';
		$sql .= ' where lang_type="' . $lang_type . '"';

		if ($class != '')
			$sql .= ' and products.prd_cid=' . $class;
		if ($status != '')
			$sql .= ' and products.prd_active=' . $status;
		if ($hot != '')
			$sql .= ' and products.prd_hot= "' . $hot . '"';
		if ($new != '')
			$sql .= ' and products.prd_new= "' . $new . '"';
		if ($name != '') {
			$sql .= ' and products.prd_name like "%' . $name . '%"';
		}
		if ($prd_no != '') {
			$sql .= ' and products.prd_no like "%' . $prd_no . '%"';
		}

		$sql .= ' and products.d_enable="Y" group by products.prd_id';
		if (!empty($limit))
			$sql .= $limit;

		return $this->db->query($sql)->result_array();
	}

	//產品列表匯出
	public function dl_products()
	{
		//權限判斷
		$this->useful->CheckComp('j_member');

		//匯出表單的標題
		// $title_array = array("狀態", "新品推薦", "好物精選", "商品名稱", "建議售價", "設定售價", "員工價", "PV值");
		$title_array = array("狀態", "商品編號", "商品名稱", "庫存數");

		$dbdata = $this->mymodel->select_page_form('products', '', '*');
		foreach ($dbdata as $value) {
			$status = '';
			if ($value['prd_active'] == 1) {
				$status = "尚有庫存";
			} else if ($value['prd_active'] == 2) {
				$status = "下架";
			} else {
				$status = "其他狀況";
			}

			// $new = ($value['prd_new'] == 'Y') ? '是' : '否';
			// $hot = ($value['prd_hot'] == 'fa fa-heart') ? '是' : '否';
			$prd_no = $value['prd_no'];
			$prd_name = $value['prd_name'];
			$prd_amount = $value['prd_amount'];
			// $prd_price01 = $value['prd_price01'];
			// $prd_price00 = $value['prd_price00'];
			// $d_mprice = $value['d_mprice'];
			// $prd_pv = $value['prd_pv'];

			//data放進array內
			$data_array[] = array(
				$status,
				$prd_no,
				$prd_name,
				$prd_amount
			);
		}

		//匯出資料
		$this->export_xls($title_array, $data_array, date('Y-m-d') . '商品資料');
	}

	//產品內頁
	public function products_info($id = '', $copy = '')
	{

		//權限判斷
		// $this->useful->CheckComp('j_comdata');
		if (empty($_SESSION['AT']) && empty($_SESSION['provider'])) {
			$this->useful->AlertPage('/index/login');
		}

		$data['dbname'] = $dbname = 'products';
		$dbdata = $this->mmodel->select_from($dbname, array('prd_id' => $id));
		//商品特點
		$data['prd_describe'] = $this->String_Array($dbdata['prd_describe']);
		//影片標題
		$data['prd_video_name'] = $this->String_Array($dbdata['prd_video_name']);
		//影片連結
		$data['prd_video_link'] = $this->String_Array($dbdata['prd_video_link']);
		//規格名稱
		$data['prd_specification_name'] = $this->String_Array($dbdata['prd_specification_name']);
		//規格內容
		$data['prd_specification_content'] = $this->String_Array($dbdata['prd_specification_content']);
		//供應商
		$data['supplier'] = $this->mymodel->select_page_form('providers', '', 'id,chinese_name,is_provider', array());

		if (!empty($id)) {
			//Momo
			//分類第一層
			$data['protype'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname,PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'PID' => '0'), 'prd_cid');;
			foreach ($data['protype'] as $protypeArr) {
				$cidArr[] = $protypeArr['prd_cid'];
			}
			if (in_array($dbdata['prd_cid'], $cidArr)) {
				//echo "有在陣列裡"; //代表只有一層
			} else { //有兩層
				//分類第二層,先找出最上層的分類
				$dbdata['prd_sub_cid'] = $dbdata['prd_cid'];
				$cid = $this->mymodel->OneSearchSql('product_class', 'PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'prd_cid' => $dbdata['prd_sub_cid']));
				$dbdata['prd_cid'] = $cid['PID'];
				//第2層分類
				$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
			}
		} else {
			//分類
			$data['protype'] = $this->mymodel->select_page_form('product_class', '', '*', array('lang_type' => $this->session->userdata('lang'), 'PID' => 'NULL', 'd_enable' => 'Y'));
			//第2層分類
			$dbdata['prd_sub_cid'] = (isset($dbdata['prd_sub_cid'])) ? $dbdata['prd_sub_cid'] : '0';
			$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
		}

		if (!empty($copy)) {
			$dbdata['prd_id'] = '';
			$dbdata['prd_image'] = '';
		}

		$data['dbdata'] = $dbdata;
		//KV
		$kv = $this->mymodel->GetConfig('', '3');
		$data['kv'] = $kv['d_val'];
		$data['bonus'] = $kv['d_val'] * $dbdata['prd_pv'];
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/product_info', $data);
		//print_r($dbdata);
	}

	

	public function ajax_product()
	{ //讀取產品分類
		$prd_cid = $_POST['prd_cid'];
		$prd_sub_cid = $_POST['prd_sub_cid'];
		if ($prd_cid != 0) {
			$product_type = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $prd_cid, 'd_enable' => 'Y'), 'prd_cid');
			if (!empty($product_type)) {
				$res = "<select name='prd_cid'>";
				foreach ($product_type as $key => $value) {
					$selected = ($prd_sub_cid == $value['prd_cid']) ? "selected='true'" : '';
					$res .= '<option value=' . $value['prd_cid'] . $selected . '>' . stripslashes($value['prd_cname']) . '</option>';
				}
				$res .= "</select>";
				echo $res; //將型號項目丟回給ajax
			}
		}
	}

	//熱銷產品排序
	public function products_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname'] = $dbname = 'products';
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_id', $value, array('hot_sort' => $key));
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_sort";</script>';
		} else {

			$dbdata = $this->mmodel->select_from_order($dbname, 'hot_sort', 'asc', array('prd_hot' => 'fa fa-heart', 'd_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));

			//總數
			$data['hot_num'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_image']);
				$dbdata[$key]['prd_image'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/products_sort', $data);
	}

	// 主題推薦排序
	public function products_theme_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname'] = $dbname = 'product_class';
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_cid', $value, ['prd_csort' => $key]);
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_theme_sort";</script>';
		} else {

			$dbdata = $this->mmodel->select_from_order($dbname, 'prd_csort', 'asc', ['PID' => '0', 'lang_type' => $this->session->userdata('lang')]);
			//總數
			$data['total'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products_class/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_cimage']);
				$dbdata[$key]['prd_cimage'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/products_theme_sort', $data);
	}

	public function products_prebuy_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname'] = $dbname = 'products';
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_id', $value, array('prebuy_sort' => $key));
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_prebuy_sort";</script>';
		} else {

			$dbdata = $this->mmodel->select_from_order($dbname, 'prebuy_sort', 'asc', array('prd_prebuy' => 'Y', 'd_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));
			//總數
			$data['hot_num'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_image']);
				$dbdata[$key]['prd_image'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/products_prebuy_sort', $data);
	}

	//新品推薦排序
	public function products_new_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');
		$data['dbname'] = $dbname = 'products';
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_id', $value, array('new_sort' => $key));
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_new_sort";</script>';
		} else {
			$dbdata = $this->mmodel->select_from_order($dbname, 'new_sort', 'asc', array('prd_new' => 'Y', 'd_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));
			//總數
			$data['hot_num'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_image']);
				$dbdata[$key]['prd_image'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/products_new_sort', $data);
	}
	//分類產品排序
	public function products_type_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');
		$_POST['prd_cid'] = (!empty($_POST['prd_cid'])) ? $_POST['prd_cid'] : $_GET['prd_cid'];
		$data['dbname'] = $dbname = 'products';
		$data['protype'] = $this->mymodel->select_page_form('product_class', '', '*', array('lang_type' => $this->session->userdata('lang'), 'PID' => 'NULL', 'd_enable' => 'Y'));
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_id', $value, array('prd_sort' => $key));
				if ($key == 0) {
					$prd = $this->mymodel->OneSearchSql('products', 'prd_cid', array('prd_id' => $value));
					$prd_cid = $prd['prd_cid'];
				}
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_type_sort?prd_cid=' . $prd_cid . '";</script>';
		} else if (!empty($_POST['prd_cid'])) {
			$dbdata = $this->mmodel->select_from_order($dbname, 'prd_sort', 'asc', array('prd_cid' => $_POST['prd_cid'], 'd_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));
			//總數
			$data['hot_num'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_image']);
				$dbdata[$key]['prd_image'] = $img_url . $image['0'];
			}
			$data['prd_sub_cid'] = $_POST['prd_cid'];
			$cid = $this->mymodel->OneSearchSql('product_class', 'PID,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'prd_cid' => $data['prd_sub_cid']));
			$prd_cid = $cid['PID'];
			if (!empty($prd_cid)) {
				$data['prd_cid'] = $prd_cid;
				//第2層分類
				$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $prd_cid, 'd_enable' => 'Y'), 'prd_cid');
			} else {
				$data['prd_cid'] = $_POST['prd_cid'];
			}
			$data['dbdata'] = $dbdata;
			$data['prd_cname'] = $cid['prd_cname'];
		} else {
			$data['memo'] = '尚未選擇分類';
			$dbdata = $this->mmodel->select_from_order($dbname, 'prd_sort', 'asc', array('d_enable' => 'Y', 'lang_type' => $this->session->userdata('lang')));
			//總數
			$data['hot_num'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['prd_image']);
				$dbdata[$key]['prd_image'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('' . $this->DataName . '/products_type_sort', $data);
	}
	//供應商列表 20171227
	public function supplier_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		//資料庫名稱
		$data['dbname'] = $dbname = 'supplier';
		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, array());
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end
		//檔案名
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', array(''));
		$data['dbdata'] = $dbdata;
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('products/supplier_list', $data);
	}
	//供應商內頁 20171227
	public function supplier_info($id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		$data['dbname'] = $dbname = 'supplier';
		$dbdata = $this->mmodel->select_from($dbname, array('d_id' => $id));

		$data['dbdata'] = $dbdata;
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('products/supplier_info', $data);
	}

	//--AJAX 開啟關閉資料專用
	public function oc_data()
	{
		$DB = $this->input->post('DB');		//資料表
		$field = $this->input->post('field');	//欄位名稱
		$id = $this->input->post('id');		//修改ID 需有分號區隔
		$oc = $this->input->post('oc');		//Open Close Value

		$id_val = explode(';', $id);
		if ($oc == 'del') {
			foreach ($id_val as $value) {
				$this->mmodel->update_set('products', 'prd_id', $value, array('d_enable' => 'N'));
			}
			echo '刪除成功';
		} else {

			if ($oc == '1' || $oc == '2' || $oc == '0') {
				$is_filed = 'prd_active';
			} elseif ($oc == 'E' || $oc == 'L') {
				$is_filed = 'prd_hot';
			} elseif ($oc == 'P' || $oc == 'B') {
				$is_filed = 'prd_prebuy';
			} else {
				$is_filed = 'prd_new';
			}

			if ($oc == 'E') {
				$oc = 'fa fa-heart-o';
			} elseif ($oc == 'L') {
				$oc = 'fa fa-heart';
			}
			if ($oc == 'P') {
				$oc = 'Y';
			} elseif ($oc == 'B') {
				$oc = 'N';
			}
			foreach ($id_val as $value) {
				$this->mmodel->update_set($DB, $field, $value, array($is_filed => $oc));
			}
			echo '修改成功';
		}
	}
	//--AJAX 開啟關閉資料專用

	//資料增刪修
	public function data_AED($dbname = '', $del_id = '')
	{
		$d_id = 'd_id';
		$img_url = '/uploads/000/000/0000/0000000000/products/';
		if (!is_dir('.' . $img_url))
			mkdir('.' . $img_url, 0777);

		if ($del_id != '') {

			if ($dbname == 'product_class') {
				$d_id = 'prd_cid';
				$products = $this->mymodel->OneSearchSql('products', 'prd_id', array('prd_cid' => $del_id, 'd_enable' => 'Y'));
				$product_class = $this->mymodel->OneSearchSql('product_class', 'prd_cid', array('PID' => $del_id, 'd_enable' => 'Y'));
				if (!empty($product_class)) {
					$this->useful->AlertPage('', '此分類底下尚有分類不可刪除');
					return '';
				} elseif (!empty($products)) {
					$this->useful->AlertPage('', '此分類底下尚有商品不可刪除');
					return '';
				} else {
					$this->mmodel->update_set($dbname, $d_id, $del_id, array('d_enable' => 'F'));
					$this->useful->AlertPage('', '刪除成功');
					return '';
				}
			}
			if ($dbname == 'products') {
				$d_id = 'prd_id';
				$this->mmodel->update_set($dbname, $d_id, $del_id, array('d_enable' => 'N'));
				$this->useful->AlertPage('/products/products_list', '刪除成功');
				return '';
			}

			$this->mmodel->delete_where($dbname, array($d_id => $del_id));
			$msg = '刪除成功';
		} else {
			$id = $_POST['d_id'];
			$dbname = $_POST['dbname'];

			if ($dbname == 'product_class') {
				$products = $this->mymodel->OneSearchSql('products', 'prd_id', array('prd_cid' => $_POST['PID'], 'd_enable' => 'Y'));
				if (!empty($products) and $_POST['PID'] <> 0) {
					$this->useful->AlertPage('', '選擇的大分類底下有商品,所以不能新增小分類');
					return '';
				}
				//圖檔上傳 20180223
				//model
				$img_url = '/uploads/000/000/0000/0000000000/products_class/';
				$this->load->model('upload_model', 'mod_upload');
				if ($_FILES['prd_cimage']['error'] != 4) {
					$img = $this->mod_upload->upload_product($_FILES['prd_cimage'], $img_url);
					$_POST['prd_cimage'] = $img['path'];
					if ($id) {
						if (is_file($_POST['prd_image_hide'])) { //若原本沒有圖片,後來再上傳圖片,會因為找不到檔案而有錯誤訊息
							unlink('.' . $img_url . $_POST['prd_image_hide']);
							unlink('.' . $img_url . 'set_' . substr($_POST['prd_image_hide'], 1));
						}
					}
				} else {
					$_POST['prd_cimage'] = $_POST['prd_image_hide'];
				}
				unset($_POST['prd_image_hide']);
			}

			if ($dbname == 'products') {
				$files = [];
				$d_id = 'prd_id';
				// if ($_POST['restrice_num'] != '0') {
				// 	if ($_POST['prd_lock_amount'] > $_POST['restrice_num']) {
				// 		echo '<script>alert("單次購買數量不得大於限購數量");history.go(-1);</script>';
				// 		return '';
				// 	}
				// }
				if ($_POST['prd_pv'] < 0) {
					$this->useful->AlertPage('', 'PV值不得小於零');
					return '';
				}

				// 上傳多檔案
				foreach ($_FILES as $key => $fileType) {
					if ($key != 'prd_image') {
						foreach ($fileType['tmp_name'] as $num => $tmpName) {
							if (!empty($tmpName)) {
								$fileName = strtotime('now') . rand(100, 999) . '.' . pathinfo($_FILES[$key]['name'][$num], PATHINFO_EXTENSION);
								$seperator = (count($fileType['tmp_name']) - 1) == $num ? '' : ',';
								move_uploaded_file($tmpName, 'images/providers/' . $fileName);
								$files[$key] .= $fileName . $seperator;
							}
						}
					}
				}

				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');
				if ($_FILES['prd_image']['error']['0'] != 4) {
					unset($_POST['ck_id']);
					$count = count($_FILES['prd_image']['name']);
					$img = $this->mod_upload->upload_product_arr($_FILES['prd_image'], $img_url, $count);
					foreach ($img as $key => $value) {
						if (!empty($value['path'])) {
							$img_path[] = $value['path'];
						}
						unset($_POST['x1d_Files' . $key]);
						unset($_POST['y1d_Files' . $key]);
						unset($_POST['x2d_Files' . $key]);
						unset($_POST['y2d_Files' . $key]);
						unset($_POST['widthd_Files' . $key]);
						unset($_POST['heightd_Files' . $key]);
					}
					if (!empty($img_path)) {
						$_POST['prd_image'] = implode(',', $img_path);
					}
					if ($id) {
						$prd_image_hide = explode(',', $_POST['prd_image_hide']);
						foreach ($prd_image_hide as $val_hide) {
							if (is_file('.' . $img_url . $val_hide)) { //若原本沒有圖片,後來再上傳圖片,會因為找不到檔案而有錯誤訊息
								unlink('.' . $img_url . $val_hide);
							}
						}
					}
				} else {
					$_POST['prd_image'] = $_POST['prd_image_hide'];

					$ck_array = $this->input->post('ck_id');
					if (!empty($ck_array)) {
						$_POST['prd_image'] = implode(',', $ck_array);
					}
					unset($_POST['ck_id']);
				}
				unset($_POST['prd_image_hide']);
				//商品特點
				$_POST['prd_describe'] = $this->Array_String($_POST['prd_describe']);
				//影片標題
				$_POST['prd_video_name'] = $this->Array_String($_POST['prd_video_name']);
				//影片連結
				$_POST['prd_video_link'] = $this->Array_String($_POST['prd_video_link']);
				//規格名稱
				$_POST['prd_specification_name'] = $this->Array_String($_POST['prd_specification_name']);
				//規格內容
				$_POST['prd_specification_content'] = $this->Array_String($_POST['prd_specification_content']);
				//內容
				$_POST['prd_content'] = str_replace(array("\"", 'youtube.com/watch?v='), array("&quot;", 'youtube.com/embed/'), $_POST['prd_content']);

				foreach ($files as $key => $value) {
					$_POST[$key] = $value;
				}

				// 更改PV寫入LOG
				$Chkdata = $this->mymodel->OneSearchSql('products', 'prd_pv,prd_name', array('prd_id' => $id));
				if ($Chkdata['prd_pv'] != $_POST['prd_pv']) {
					$content = '管理員' . $_SESSION['AT']['account_name'] . '-更改' . $Chkdata['prd_name'] . '的PV(' . $Chkdata['prd_pv'] . '->' . $_POST['prd_pv'] . ')';
					$this->mymodel->WriteLog('2', $content);
				}
			}

			if ($id) {
				$data = $this->useful->DB_Array($_POST);
			} else {
				$data = $this->useful->DB_Array($_POST, 1);
			}

			if ($dbname == 'product_class') {
				$d_id = 'prd_cid';
				if ($data['d_id'] == $data['PID'])
					$this->useful->AlertPage("/products/product_class_list", "錯誤選擇");
			}

			unset($data['dbname']);
			unset($data['d_id']);

			$origins = ['origin_report', 'origin_proof', 'origin_contract', 'origin_insurance', 'origin_mark', 'origin_patent'];

			foreach ($origins as $key => $origin) {
				unset($data[$origin]);
			}

			if ($id) {
				$this->mmodel->update_set($dbname, $d_id, $id, $data);
				$msg = '修改成功';
			} else {
				$create_id = $this->mmodel->insert_into($dbname, $data);
				if (!empty($_SESSION['provider']) && empty($_SESSION['AT'])) {
					$message = "親愛的管理員：<br><br>";
					$message .= "供應商已新增產品<br><br>";
					$message .= "產品名稱：" . $_POST['prd_name'] . "<br><br>";

					// 寄送通知信給後台
					$this->index_model->send_mail('', 'service@supergoods.com.tw', 'service@supergoods.com.tw', '供應商產品新增通知', $message);
				}
				if ($create_id)
					$msg = '新增成功';
				else
					$msg = '新增失敗';
			}
		}

		echo '<script>alert("' . $msg . '"); history.go(-2)</script>';
		// switch ($dbname) {
		// 	case 'product_class':
		// 		echo '<script>alert("'.$msg.'"); location.href = "/products/product_class_list"</script>';
		// 		break;

		// 	case 'products':
		// 		echo '<script>alert("'.$msg.'"); location.href = "/products/products_list"</script>';
		// 		break;

		// 	default:
		// 		echo '<script>alert("'.$msg.'"); location.href = "/admin"</script>';
		// 		break;
		// }
	}

	// 供應商取得單一商品
	public function provider_product($id)
	{
		// if (empty($_SESSION['AT']) && empty($_SESSION['provider'])) {
		// 	$this->useful->AlertPage('/index/login');
		// }

		$data['dbname'] = $dbname = 'products';
		$dbdata = $this->mmodel->select_from($dbname, array('prd_id' => $id));
		//商品特點
		$data['prd_describe'] = $this->String_Array($dbdata['prd_describe']);
		//影片標題
		$data['prd_video_name'] = $this->String_Array($dbdata['prd_video_name']);
		//影片連結
		$data['prd_video_link'] = $this->String_Array($dbdata['prd_video_link']);
		//規格名稱
		$data['prd_specification_name'] = $this->String_Array($dbdata['prd_specification_name']);
		//規格內容
		$data['prd_specification_content'] = $this->String_Array($dbdata['prd_specification_content']);
		//供應商
		$data['supplier'] = $this->mymodel->select_page_form('providers', '', 'id,chinese_name,is_provider', array());

		if (!empty($id)) {
			//Momo
			//分類第一層
			$data['protype'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname,PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'PID' => '0'), 'prd_cid');;
			foreach ($data['protype'] as $protypeArr) {
				$cidArr[] = $protypeArr['prd_cid'];
			}
			if (in_array($dbdata['prd_cid'], $cidArr)) {
				//echo "有在陣列裡"; //代表只有一層
			} else { //有兩層
				//分類第二層,先找出最上層的分類
				$dbdata['prd_sub_cid'] = $dbdata['prd_cid'];
				$cid = $this->mymodel->OneSearchSql('product_class', 'PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'prd_cid' => $dbdata['prd_sub_cid']));
				$dbdata['prd_cid'] = $cid['PID'];
				//第2層分類
				$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
			}
		} else {
			//分類
			$data['protype'] = $this->mymodel->select_page_form('product_class', '', '*', array('lang_type' => $this->session->userdata('lang'), 'PID' => 'NULL', 'd_enable' => 'Y'));
			//第2層分類
			$dbdata['prd_sub_cid'] = (isset($dbdata['prd_sub_cid'])) ? $dbdata['prd_sub_cid'] : '0';
			$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
		}

		if (!empty($copy)) {
			$dbdata['prd_id'] = '';
			$dbdata['prd_image'] = '';
		}

		$data['dbdata'] = $dbdata;
		//KV
		$kv = $this->mymodel->GetConfig('', '3');
		$data['kv'] = $kv['d_val'];
		$data['bonus'] = $kv['d_val'] * $dbdata['prd_pv'];
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('index/providers/product_info', $data);
	}

	// 供應商提交商品修改
	public function commit($id)
	{
		$img_url = '/uploads/000/000/0000/0000000000/products/';
		if (!is_dir('.' . $img_url))
			mkdir('.' . $img_url, 0777);

		if ($_POST['restrice_num'] != '0') {
			if ($_POST['prd_lock_amount'] > $_POST['restrice_num']) {
				echo '<script>alert("單次購買數量不得大於限購數量");history.go(-1);</script>';
				return '';
			}
		}
		if ($_POST['prd_pv'] < 0) {
			$this->useful->AlertPage('', 'PV值不得小於零');
			return '';
		}

		// 上傳多檔案
		foreach ($_FILES as $key => $fileType) {
			if ($key != 'prd_image') {
				foreach ($fileType['tmp_name'] as $num => $tmpName) {
					if (!empty($tmpName)) {
						$fileName = strtotime('now') . rand(100, 999) . '.' . pathinfo($_FILES[$key]['name'][$num], PATHINFO_EXTENSION);
						$seperator = (count($fileType['tmp_name']) - 1) == $num ? '' : ',';
						move_uploaded_file($tmpName, 'images/providers/' . $fileName);
						$files[$key] .= $fileName . $seperator;
					}
				}
			}
		}

		//圖檔上傳
		//model
		$this->load->model('upload_model', 'mod_upload');
		if ($_FILES['prd_image']['error']['0'] != 4) {
			unset($_POST['ck_id']);
			$count = count($_FILES['prd_image']['name']);
			$img = $this->mod_upload->upload_product_arr($_FILES['prd_image'], $img_url, $count);
			foreach ($img as $key => $value) {
				if (!empty($value['path'])) {
					$img_path[] = $value['path'];
				}
				unset($_POST['x1d_Files' . $key]);
				unset($_POST['y1d_Files' . $key]);
				unset($_POST['x2d_Files' . $key]);
				unset($_POST['y2d_Files' . $key]);
				unset($_POST['widthd_Files' . $key]);
				unset($_POST['heightd_Files' . $key]);
			}

			if (!empty($img_path)) {
				$_POST['prd_image'] = implode(',', $img_path);
			}

			if ($id) {
				$prd_image_hide = explode(',', $_POST['prd_image_hide']);
				foreach ($prd_image_hide as $val_hide) {
					if (is_file('.' . $img_url . $val_hide)) { //若原本沒有圖片,後來再上傳圖片,會因為找不到檔案而有錯誤訊息
						unlink('.' . $img_url . $val_hide);
					}
				}
			}
		} else {
			$_POST['prd_image'] = $_POST['prd_image_hide'];

			$ck_array = $this->input->post('ck_id');
			if (!empty($ck_array)) {
				$_POST['prd_image'] = implode(',', $ck_array);
			}
			unset($_POST['ck_id']);
		}
		unset($_POST['prd_image_hide']);
		//商品特點
		$_POST['prd_describe'] = $this->Array_String($_POST['prd_describe']);
		//影片標題
		$_POST['prd_video_name'] = $this->Array_String($_POST['prd_video_name']);
		//影片連結
		$_POST['prd_video_link'] = $this->Array_String($_POST['prd_video_link']);
		//規格名稱
		$_POST['prd_specification_name'] = $this->Array_String($_POST['prd_specification_name']);
		//規格內容
		$_POST['prd_specification_content'] = $this->Array_String($_POST['prd_specification_content']);
		//內容
		$_POST['prd_content'] = str_replace(array("\"", 'youtube.com/watch?v='), array("&quot;", 'youtube.com/embed/'), $_POST['prd_content']);

		foreach ($files as $key => $value) {
			$_POST[$key] = $value;
		}

		// 更改PV寫入LOG
		$Chkdata = $this->mymodel->OneSearchSql('products', 'prd_pv,prd_name', array('prd_id' => $id));
		if ($Chkdata['prd_pv'] != $_POST['prd_pv']) {
			$content = '管理員' . $_SESSION['AT']['account_name'] . '-更改' . $Chkdata['prd_name'] . '的PV(' . $Chkdata['prd_pv'] . '->' . $_POST['prd_pv'] . ')';
			$this->mymodel->WriteLog('2', $content);
		}

		if ($id) {
			$data = $this->useful->DB_Array($_POST);
		} else {
			$data = $this->useful->DB_Array($_POST, 1);
		}
		$data['prd_id'] = $id;
		unset($data['dbname']);
		unset($data['d_id']);

		$origins = ['origin_report', 'origin_proof', 'origin_contract', 'origin_insurance', 'origin_mark', 'origin_patent'];

		foreach ($origins as $key => $origin) {
			unset($data[$origin]);
		}

		$this->mmodel->insert_into('product_commits', $data);

		$message = "親愛的管理員：<br><br>";
		$message .= "您有一則新的產品修改提交請求<br><br>";
		$message .= "產品名稱：" . $_POST['prd_name'] . "<br><br>";
		$message .= "請至後台進行審核程序";

		// 寄送通知信給後台
		$this->index_model->send_mail('', 'service@supergoods.com.tw', 'service@supergoods.com.tw', '供應商產品修改提交通知', $message);

		echo '<script>alert("提交成功"); location.href = "/products/get_provider_products"</script>';
	}

	// 供應商取得自己的商品
	public function get_provider_products()
	{
		if (empty($_SESSION['provider'])) {
			$this->useful->AlertPage('/providers/login');
		}
		@session_start();

		$img_url = '/uploads/000/000/0000/0000000000/products/';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;

		$qpage = $this->useful->SetPage('products', $Topage, 10, [
			'd_enable' => 'Y',
			'supplier_id' => $_SESSION['provider']['id']
		]);

		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end

		$dbdata = $this->select_provider_data($qpage['result'], $this->session->userdata('lang'));

		foreach ($dbdata as $key => $value) {
			$image = explode(',', $value['prd_image']);
			$dbdata[$key]['prd_image'] = $img_url . $image[0];
			$dbdata[$key]['prd_new'] = ($value['prd_new'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_prebuy'] = ($value['prd_prebuy'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_hot'] = ($value['prd_hot'] == 'fa fa-heart-o') ? '否' : '是';
			$dbdata[$key]['prd_active'] = $value['prd_amount'] > 0 ? '尚有庫存' : '缺貨中';
		}

		$data['dbdata'] = $dbdata;

		//產品系列
		$this->load->view('index/providers/product_list', $data);
	}

	// 後台查看所有商品提交
	public function commits()
	{
		header("Cache-control: private");
		//權限判斷
		$this->useful->CheckComp('j_comdata');
		$img_url = '/uploads/000/000/0000/0000000000/products/';

		//資料庫名稱
		$data['dbname'] = $dbname = 'product_commits';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, $Topage, 10);
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end

		$dbdata = $this->select_commits($qpage['result'], $this->session->userdata('lang'));


		foreach ($dbdata as $key => $value) {
			$image = explode(',', $value['prd_image']);
			$dbdata[$key]['prd_image'] = $img_url . $image[0];
			$dbdata[$key]['prd_new'] = ($value['prd_new'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_prebuy'] = ($value['prd_prebuy'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_hot'] = ($value['prd_hot'] == 'fa fa-heart-o') ? '否' : '是';
			if ($value['prd_active'] == '2') {
				$act = "商品下架";
			} elseif ($value['prd_active'] == '1') {
				$act = "尚有庫存";
			} else {
				$act = "商品補貨";
			}

			$dbdata[$key]['prd_active'] = $act;
		}

		$data['dbdata'] = $dbdata;

		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('commits/index', $data);
	}

	public function commit_info($id)
	{
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname'] = $dbname = 'product_commits';
		$dbdata = $this->mmodel->select_from($dbname, ['id' => $id]);

		//商品特點
		$data['prd_describe'] = $this->String_Array($dbdata['prd_describe']);
		//影片標題
		$data['prd_video_name'] = $this->String_Array($dbdata['prd_video_name']);
		//影片連結
		$data['prd_video_link'] = $this->String_Array($dbdata['prd_video_link']);
		//規格名稱
		$data['prd_specification_name'] = $this->String_Array($dbdata['prd_specification_name']);
		//規格內容
		$data['prd_specification_content'] = $this->String_Array($dbdata['prd_specification_content']);
		//供應商
		$data['supplier'] = $this->mymodel->select_page_form('providers', '', 'id,chinese_name,is_provider', []);

		if (!empty($id)) {
			//Momo
			//分類第一層
			$data['protype'] = $this->mymodel->select_page_form_0('product_class', '', 'prd_cid,prd_cname,PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'PID' => '0'), 'prd_cid');;
			foreach ($data['protype'] as $protypeArr) {
				$cidArr[] = $protypeArr['prd_cid'];
			}
			if (in_array($dbdata['prd_cid'], $cidArr)) {
				//echo "有在陣列裡"; //代表只有一層
			} else { //有兩層
				//分類第二層,先找出最上層的分類
				$dbdata['prd_sub_cid'] = $dbdata['prd_cid'];
				$cid = $this->mymodel->OneSearchSql('product_class', 'PID', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y', 'prd_cid' => $dbdata['prd_sub_cid']));
				$dbdata['prd_cid'] = $cid['PID'];
				//第2層分類
				$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
			}
		} else {
			//分類
			$data['protype'] = $this->mymodel->select_page_form('product_class', '', '*', array('lang_type' => $this->session->userdata('lang'), 'PID' => 'NULL', 'd_enable' => 'Y'));
			//第2層分類
			$dbdata['prd_sub_cid'] = (isset($dbdata['prd_sub_cid'])) ? $dbdata['prd_sub_cid'] : '0';
			$data['protype_sub'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'PID' => $dbdata['prd_cid'], 'd_enable' => 'Y'), 'prd_cid');
		}

		if (!empty($copy)) {
			$dbdata['prd_id'] = '';
			$dbdata['prd_image'] = '';
		}

		$data['dbdata'] = $dbdata;
		//KV
		$kv = $this->mymodel->GetConfig('', '3');
		$data['kv'] = $kv['d_val'];
		$data['bonus'] = $kv['d_val'] * $dbdata['prd_pv'];
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('commits/show', $data);
	}

	// 審核提交紀錄 (後台)
	public function verify_commit($id)
	{
		$this->commits_model->judgeVerifyStatus($id);
		$this->apiResponse(['status' => 'success']);
	}

	private function select_commits($limit = '', $lang_type = 'TW')
	{
		$sql = "SELECT pc.*, p.chinese_name FROM product_commits pc INNER JOIN providers p ON pc.supplier_id = p.id ";

		if (!empty($limit)) {
			$sql .= $limit;
		}

		return $this->db->query($sql)->result_array();
	}

	// 取得供應商自有商品
	private function select_provider_data($limit = '', $lang_type = 'TW')
	{
		$sql = "SELECT p.*, pc.prd_cname FROM products p INNER JOIN product_class pc ON p.prd_cid = pc.prd_cid WHERE p.d_enable = 'Y' AND supplier_id = ? ";

		if (!empty($limit)) {
			$sql .= $limit;
		}

		return $this->db->query($sql, [$_SESSION['provider']['id']])->result_array();
	}

	//陣列轉字串
	private function Array_String($array, $sub = '*#')
	{
		$str = '';
		if (!empty($array)) {
			foreach ($array as $dvalue) {
				$str .= $sub . $dvalue;
			}
		}
		return $str;
	}
	//字串轉陣列
	private function String_Array($String, $sub = '*#')
	{
		$str = explode($sub, $String);
		array_shift($str);
		return $str;
	}

	protected function apiResponse(array $data, $statusCode = 200)
	{
		header('Content-Type: application/json');
		http_response_code($statusCode);
		echo json_encode($data);
		exit;
	}
}
