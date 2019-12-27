<?php
// 購物車
class Cart extends MY_Controller
{
	public $data = '';
	public $language = '';
	public $Spath = '/uploads/000/000/0000/0000000000/products/';
	public function __construct() // 初始化
	{
		parent::__construct();
		// helper
		$this->load->helper('url');
		@session_start();
		$this->load->model(array('MyModel/mymodel', 'products_model', 'cart_model'));
		$this->load->library('mylib/useful');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('lang_model', lmodel);
		$this->load->model('order_model', 'omodel');

		//web config
		$this->data['web_config']	=	$this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->style 				=	(!empty($this->data['style_config']['style_id'])) ? $this->data['style_config']['style_id'] : '';
		//檔案名
		$this->DataName = 'cart';
	}

	public function nocart()
	{
		//	防呆:版型二購物車沒有商品,且是APP裝置
		if ((!empty($this->style == 2)) and empty($_SESSION['join_car']) and (!empty($this->session->userdata['isapp']))) {
			$language = $this->language;
			//語言包
			$this->lang = $this->lmodel->config('22', $this->setlang);
			//view
			$this->load->view('index/header' . $this->style, $data);
			$this->load->view('index/cart/nocart', $data);
			$this->load->view('index/footer' . $this->style, $data);
		} else {
			$this->useful->AlertPage('/cart');
		}
	}

	public function index()
	{
		$language = $this->language;
		//語言包
		$this->lang = $this->lmodel->config('22', $this->setlang);
		$data['pay_ls'] = $this->lmodel->config('9999', $this->setlang);
		// 判斷是否登入
		if ($_SESSION['MT']['is_login'] == 1) {
			if (empty($_SESSION['join_car'])) {
				if ((!empty($this->style == 2)) and (!empty($this->session->userdata['isapp']))) {	//版型二,且是APP裝置需到沒有商品頁面
					$this->useful->AlertPage('/cart/nocart');
				} else {
					$this->useful->AlertPage($_SESSION['Url'], $this->lang['nocart']);
				}
			}
			//推薦人
			$by_id = $_SESSION['MT']['by_id'];
			$buyer = $this->mymodel->OneSearchSql('buyer', 'PID, d_dividend,d_shopping_money,address', array('by_id' => $by_id));
			if (empty($buyer['address'])) {
				$this->useful->AlertPage('/member/info', $this->lang['c_63']);
			}
			$data['d_dividend']	= $buyer['d_dividend'];
			$data['d_shopping_money'] = $buyer['d_shopping_money'];
			$PID	=	$buyer['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']			=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}

			$data['by_id']				=	$_SESSION['MT']['by_id'];
			$data['banner']				=	'';
			$bdata						=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $data['by_id']));
			$price						=	($bdata['d_spec_type'] == 1) ? 'd_mprice' : 'prd_price00';
			//撈出購物車的商品
			$join_car	=	$_SESSION['join_car'];
			unset($_SESSION['join_car']['']);
			foreach ($join_car as $key => $value) {
				$productsDetail 					= 	$this->products_model->productsDetail($key, $bdata['d_spec_type']);
				$dbdata								= 	$productsDetail['data'];
				$productList[$key]['num']			=	$value;
				$productList[$key]['prd_id']		=	$dbdata['prd_id'];
				$productList[$key]['prd_amount']	=	$dbdata['prd_amount'];
				$productList[$key]['prd_lock_amount']	=	$dbdata['prd_lock_amount'];
				$productList[$key]['spec']			=	$key;
				$productList[$key]['spec_rename']	=	str_replace('##*', '_', $key);
				$productList[$key]['spec_name']		=	substr($key, strpos($key, '##*') + 3);
				$productList[$key]['prd_name']		=	str_replace("\'", "'", $dbdata['prd_name']);
				$image = explode(',', $dbdata['prd_image']);
				$dbdata['prd_image'] = $image[0];
				$productList[$key]['prd_image']		=	$dbdata['prd_image'];
				$productList[$key]['price']			=	number_format($dbdata[$price], 2);
				$productList[$key]['total']			=	number_format($value * $dbdata[$price], 2);
			}
			//地區撈取
			$data['country'] = $this->mymodel->get_area_data();
			//常用地址
			$data['address'] = $this->mymodel->get_address_data($data['by_id']);
			switch ($this->setlang) {
				case 'ENG':
					$lway_name = 'lway_name_2';
					$pway_name = 'pway_name_2';
					break;
				case 'JAP':
					$lway_name = 'lway_name_3';
					$pway_name = 'pway_name_3';
					break;
				case 'TW':
				default:
					$lway_name = 'lway_name_1';
					$pway_name = 'pway_name_1';
					break;
			}
			// 運送方式
			// logistics_way : 撈取當下能使用的物流付款方式(由超管設定)
			$logistics_way = $this->mod_cart->select_from_order('logistics_way', 'lway_id', asc, array('active' => 1));
			foreach ($logistics_way as $key => $value) {
				$data['logistics_way'][$key]['lway_id'] = $value['lway_id'];
				$data['logistics_way'][$key]['lway_name'] = $value[$lway_name];
			}
			// 付款方式
			// payment_way : 撈取當下能用的付款方式(由超管設定)
			$payment_way = $this->mod_cart->select_from_order('payment_way', 'sort,pway_id', 'asc', array('active' => 1));
			foreach ($payment_way as $key => $value) {
				$data['payment_way'][$key]['pway_id'] = $value['pway_id'];
				$data['payment_way'][$key]['pway_name'] = $value[$pway_name];
			}

			$data['productList']	=	$productList;
			$data['Spath']			=	$this->Spath;
			$data['path_title']		=	'<li><a href="/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
			$data['discount']		=	$this->mymodel->GetConfig('rule', 76)['d_val'];
			$data['maxDiscount']	=	$this->mymodel->GetConfig('rule', 5126)['d_val'];

			$cost 					=	$this->mymodel->OneSearchSql('logistics_way', 'business_account', array('lway_id' => 4));
			$data['freeShip']		=	$cost['business_account'];
			$data['body_class']		=	'cart-check-fix';
			//view
			$this->load->view($this->indexViewPath . '/header' . $this->style, $data);
			$this->load->view($this->indexViewPath . '/cart/cart', $data);
			$this->load->view($this->indexViewPath . '/footer' . $this->style, $data);
		} else {
			$_SESSION['url']	=	'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login', $this->lang['Login']);
		}
	}
	//計算小計ajax
	public function ajax_count()
	{
		$prd_id = str_replace('_', '##*', ($_POST['prd_id']));
		$qty = $_POST['qty'];
		$_SESSION['join_car'][$prd_id] = $qty;
	}

	//計算總額.紅利ajax
	public function total_all()
	{
		$use_dividend	=	$_POST['use_dividend'];
		$use_shopping_money	=	$_POST['use_shopping_money'];
		$joinProducts	=	$_SESSION['join_car'];
		$by_id 			=	$_SESSION['MT']['by_id'];
		$bdata			=	$this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $by_id));
		$price			=	($bdata['d_spec_type'] == 1) ? 'd_mprice' : 'prd_price00';
		$dataTotal		=	0;
		foreach ($joinProducts as $key => $value) {
			$productsDetail		=	$this->products_model->productsDetail($key, $bdata['d_spec_type']);
			$totalData			=	$productsDetail['data'];
			$dataTotal			=	($totalData[$price] * $value) + $dataTotal;
		}
		$data['dataTotal']			=	$dataTotal;
		$config 					=	$this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 76));
		$dividendTurn				=	(int) $config['d_val'];
		$_SESSION['use_dividend']	=	$use_dividend;
		$_SESSION['use_shopping_money']	=	$use_shopping_money;
		$use_dividend_cost			=	$use_dividend / $dividendTurn;
		$data['only_money']			=	number_format($dataTotal - $use_dividend_cost - $use_shopping_money, 2);

		//紅利
		$config 			= $this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 73));
		$config['d_val']	= ($config['d_val']) / 100;
		$data['dataBonus']	= $dataTotal * $config['d_val'];
		echo json_encode($data);
	}

	//刪除商品ajax
	public function ajax_delete()
	{
		$prd_id = $_POST['prd_id'];
		$prd_id = str_replace('_', '##*', ($_POST['prd_id']));
		unset($_SESSION['join_car'][$prd_id]);
	}

	//購物車 AJAX 同會員資料
	public function get_member()
	{
		$id = $_POST['bid'];
		$type = $_POST['type'];
		$dbdata = $this->mymodel->OneSearchSql('buyer', 'name,mobile,by_email,city,countory,country,address,zip', array('by_id' => $id));
		$cdata = $this->mymodel->OneSearchSql('city_category', 's_id,s_name', array('s_id' => $dbdata['city']));
		$codata = $this->mymodel->OneSearchSql('city_category', 's_zipcode,s_id,s_name', array('s_id' => $dbdata['countory']));
		$dbdata['countory_id'] = $codata['s_id'];
		$dbdata['zipcode'] = $codata['s_zipcode'];
		echo json_encode($dbdata);
	}
	//購物車 AJAX 同會員資料(地址)
	public function ajax_area()
	{
		//語言包
		$this->lang = $this->lmodel->config('22', $this->setlang);
		$data['country']	=	"<select name='country' id='country' onChange='";
		$data['country']	.=	'sel_area(this.value,"","city")';
		$data['country']	.=	"' class='form-control'><option value='0'>" . $this->lang["c_22"] . "</option>"; //請選擇國家
		$data['city']		=	"<select name='city' id='city' onChange='";
		$data['city']		.=	'sel_area(this.value,"","countory")';
		$data['city']		.=	"' class='form-control'><option value='0'>" . $this->lang["c_23"] . "</option>"; //請選擇縣市
		$data['countory']	=	'<select name="countory" id="countory" class="form-control"><option value="0">' . $this->lang["c_24"] . '</option>'; //請選擇鄉鎮
		$country 			=	$_POST['country'];
		$city 				=	$_POST['city'];
		$countory 			=	$_POST['countory'];
		$country_arr 			=	$this->mymodel->get_area_data(0);
		foreach ($country_arr as $cvalue) {
			$selected 			=	($cvalue['s_id'] == $country) ? 'selected' : '';
			$data['country']	.=	"<option value='" . $cvalue['s_id'] . "' " . $selected . ">" . $cvalue['s_name'] . "</option>";
		}
		$data['country']		.= "</select>";
		if (!empty($country)) {
			$city_arr 				=	$this->mymodel->get_area_data("$country");
			foreach ($city_arr as $cvalue2) {
				$selected 			=	($cvalue2['s_id'] == $city) ? 'selected' : '';
				$data['city']		.=	"<option value='" . $cvalue2['s_id'] . "' " . $selected . ">" . $cvalue2['s_name'] . "</option>";
			}
			$data['city']			.= "</select>";
		}
		if (!empty($countory)) {
			$countory_arr 			 =	$this->mymodel->get_area_data("$city");
			foreach ($countory_arr as $cvalue3) {
				$selected 			= ($cvalue3['s_id'] == $countory) ? 'selected' : '';
				$data['countory']	.=	"<option value='" . $cvalue3['s_id'] . "' " . $selected . ">" . $cvalue3['s_name'] . "</option>";
			}
			$data['countory'] 		.= "</select>";
		}
		echo json_encode($data);
	}

	//選擇常用地址ajax
	public function ajax_common_address()
	{
		$address_id		=	$_POST['address_id'];
		$address 		=	$this->mymodel->OneSearchSql('address', 'name,telphone,country,city,countory,address,zip', array('d_id' => $address_id));
		$dataAddress['name']		=	$address['name'];
		$dataAddress['telphone']	=	$address['telphone'];
		$dataAddress['zip']		=	$address['zip'];
		$dataAddress['address']		=	$address['address'];
		$dataAddress['country']		=	"<select name='country' id='country' onChange='";
		$dataAddress['country']		.=	'sel_area(this.value,"","city")';
		$dataAddress['country']		.=	"' class='form-control'>";
		$dataAddress['city']		=	"<select name='city' id='city' onChange='";
		$dataAddress['city']		.=	'sel_area(this.value,"","countory")';
		$dataAddress['city']		.=	"' class='form-control'>";
		$dataAddress['countory']	=	'<select name="countory" id="countory" class="form-control">';
		if (!empty($address['country'])) {
			$country_arr 			=	$this->mymodel->get_area_data();
			foreach ($country_arr as $cvalue) {
				$selected 				=	($cvalue['s_id'] == $address['country']) ? 'selected' : '';
				$dataAddress['country']	.=	"<option value='" . $cvalue['s_id'] . "' " . $selected . ">" . $cvalue['s_name'] . "</option>";
			}
			$dataAddress['country']	.= "</select>";
		}
		if (!empty($address['city'])) {
			$city_arr 			=	$this->mymodel->get_area_data($address['country']);
			foreach ($city_arr as $cvalue2) {
				$selected 		=	($cvalue2['s_id'] == $address['city']) ? 'selected' : '';
				$dataAddress['city']	.=	"<option value='" . $cvalue2['s_id'] . "' " . $selected . ">" . $cvalue2['s_name'] . "</option>";
			}
			$dataAddress['city']	.= "</select>";
		}
		if (!empty($address['countory'])) {
			$countory_arr 			=	$this->mymodel->get_area_data($address['city']);
			foreach ($countory_arr as $cvalue3) {
				$selected 		=	($cvalue3['s_id'] == $address['countory']) ? 'selected' : '';
				$dataAddress['countory']	.=	"<option value='" . $cvalue3['s_id'] . "' " . $selected . ">" . $cvalue3['s_name'] . "</option>";
			}
			$dataAddress['countory']	.= "</select>";
		}
		echo json_encode($dataAddress);
	}

	//選擇取貨門市ajax
	public function ajax_shop()
	{
		$shop = '<select name="shop_id" id="shop_id" class="form-control">';
		$member = $this->mymodel->select_page_form('member', '', 'member_id, shop_address', array('is_shop' => 1));
		foreach ($member as $value) {
			$shop .= '<option value=' . $value['member_id'] . '>' . $value['shop_address'] . '</option>';
		}
		$shop .= '</select>';
		echo $shop;
	}

	//結帳頁面
	public function cart_checkout()
	{
		// 判斷是否登入
		// 語言包
		$this->lang = $this->lmodel->config('22', $this->setlang);
		if ($_SESSION['MT']['is_login'] == 1) {
			if (empty($_POST['by_id'])) { //防呆,直接點入此頁面會跳轉購物車
				$this->useful->AlertPage('/cart');
			}
			$data['logistics_way'] = $this->mymodel->OneSearchSql('logistics_way', 'lway_name,lway_id', array('lway_id' => $_POST['lway_id']));
			$data['payment_way'] = $this->mymodel->OneSearchSql('payment_way', 'pway_name,pway_id', array('pway_id' => $_POST['pway_id']));
			$data['buyer_name']		 =	$_POST['buyer_name'];
			$data['buyer_email']	 =	$_POST['buyer_email'];
			$data['buyer_phone']	 =	$_POST['buyer_phone'];
			$data['receipt_title']	 =	$_POST['receipt_title'];
			$data['receipt_code']	 =	$_POST['receipt_code'];
			$data['receipt_zip']	 =	$_POST['receipt_zip'];
			$data['receipt_address'] =	$_POST['receipt_address'];
			$data['buyer_zip']	 	 =	$_POST['buyer_zip'];
			$country				=	$this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $_POST['country']));
			$data['country']		=	$country['s_name'];
			$county 				=	$this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $_POST['city']));
			$data['county']			=	$county['s_name'];
			$area 					=	$this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $_POST['countory']));
			$data['area']			=	$area['s_name'];
			$data['buyer_address']	=	$_POST['buyer_address'];
			$data['shop_id']		=	$_POST['shop_id'];
			$use_dividend	=	$_SESSION['use_dividend'];
			$use_shopping_money	=	$_SESSION['use_shopping_money'];
			$data['buyer_note']		=	$_POST['buyer_note'];

			//推薦人
			$data['by_id'] = $by_id = $_SESSION['MT']['by_id'];
			$buyer = $this->mymodel->OneSearchSql('buyer', 'PID, d_dividend', array('by_id' => $by_id));
			$data['d_dividend']	= $buyer['d_dividend'];
			$PID	=	$buyer['PID'];
			if ($by_id <> 4) {
				$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
				$data['memberName']	=	$this->lang['yourAccount'] . '<b>' . $memberName['name'] . '</b>';
			}

			$data['banner'] = '';
			$bdata = $this->mymodel->OneSearchSql('buyer', 'd_spec_type', array('by_id' => $data['by_id'])); //會員是否VIP
			//撈出購物車的商品
			$join_car	=	$_SESSION['join_car'];
			$price	=	($bdata['d_spec_type'] == 1) ? 'd_mprice' : 'prd_price00';
			$data['PriceSum'] = 0;
			foreach ($join_car as $key => $value) {
				$productsDetail					=	$this->products_model->productsDetail($key, $bdata['d_spec_type']);
				$dbdata							=	$productsDetail['data'];
				$productList[$key]['num']		=	$value;
				$productList[$key]['prd_name']	=	str_replace("\'", "'", $dbdata['prd_name']);
				$productList[$key]['spec']		=	$key;
				$productList[$key]['spec_name']	=	substr($key, strpos($key, '##*') + 3);
				$image = explode(',', $dbdata['prd_image']);
				$dbdata['prd_image'] = $image[0];
				$productList[$key]['prd_image']	=	$dbdata['prd_image'];
				$productList[$key]['price']		=	$dbdata[$price];
				$productList[$key]['total']		=	$value * $dbdata[$price];
				$data['PriceSum']				=	$productList[$key]['total'] + $data['PriceSum'];
			}
			$data['productList']	=	$productList;
			$data['Spath']			=	$this->Spath;
			$data['totalPrice']		=	$dataTotal	=	$data['PriceSum'];
			//紅利
			$config 			= $this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 73));
			$config['d_val']	= ($config['d_val']) / 100;
			$data['bonus']		= $data['totalPrice'] * $config['d_val'];
			//若未滿免運金額&選擇宅配,再加運費
			$cost = $this->mymodel->OneSearchSql('logistics_way', 'business_account', array('lway_id' => 4));
			$data['freeShip']	=	$cost['business_account'];
			if ($data['PriceSum'] < $data['freeShip'] and $_POST['lway_id'] <> 5) {
				$ship_cost = $this->mymodel->OneSearchSql('logistics_way', 'business_account', array('lway_id' => $_POST['lway_id']));
				$data['ship_cost'] = "<tr><td>運費小計</td><td>" . $this->data['web_config']['currency'] . number_format($ship_cost['business_account'], 2) . "</td></tr>";
				$data['totalPrice'] = $dataTotal	= $data['totalPrice'] + $ship_cost['business_account'];
			}
			$config 				=	$this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 76));
			$dividendTurn			=	(int) $config['d_val'];
			$use_dividend_cost		=	$use_dividend / $dividendTurn;

			$quotient = (int) ($use_dividend / $config['d_val']);	// 商

			$realDividend = $quotient * $config['d_val'];	// 實際使用的紅利
			$realDiscount = $quotient;	// 實際折抵金額

			$data['use_dividend']	=	$this->data['web_config']['currency'] . $realDiscount . '(' . $realDividend . $this->lang['c_27'] . ')';

			$data['use_shopping_money']	=	$this->data['web_config']['currency'] . number_format($use_shopping_money, 2);
			$data['only_money']		=	number_format($dataTotal - $use_dividend_cost - $use_shopping_money, 2);
			if ($data['only_money'] < 0.00) {
				$this->useful->AlertPage('/cart', $this->lang['c_50']); //付款金額不得小於0
			}
			$data['stripe_money']		=	(($dataTotal - $use_dividend_cost - $use_shopping_money) * 100);

			$data['path_title'] = '<li><a href="/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
			//門市取貨
			if (!empty($data['shop_id'])) {
				$member = $this->mymodel->OneSearchSql('member', 'shop_address', array('member_id' => $data['shop_id']));
				$data['shop_address'] = $member['shop_address'];
			}
			$data['body_class']		=	'cart-check-fix';
			//view
			$this->load->view('index/header' . $this->style, $data);
			$this->load->view('index/cart/cart_checkout', $data);
			$this->load->view('index/footer' . $this->style, $data);
		} else {
			$this->useful->AlertPage('/gold/login', $this->lang['Login']);
		}
	}
	public function cart_checkout_ok()
	{
		// 判斷是否登入
		// 語言包
		$this->lang = $this->lmodel->config('22', $this->setlang);
		if ($_SESSION['MT']['is_login'] == 1) {
			if (empty($_SESSION['oid'])) { //防呆,直接點入此頁面會跳轉購物車
				$this->useful->AlertPage('/index/');
			}
			$id = $_SESSION['oid'];
			$by_id = $_SESSION['MT']['by_id'];
			$data['oid'] = $id;

			//主訂單
			$orderdata = $this->omodel->orderdata($id);
			$data['order_id'] = $orderdata['order_id'];
			$data['order_price'] = $orderdata['pay_price'] - $orderdata['use_dividend_cost'] - $orderdata['use_shopping_money'];

			// 導回此頁面後 訂單正式完成 且付款成功
			$this->mymodel->update_set('`order`', 'id', $id, ['status' => '1']);
			$this->mymodel->update_set('`order_details`', 'oid', $id, ['status' => '1']);

			// 新增完畢清掉購物車&使用紅利
			unset($_SESSION['join_car']);
			unset($_SESSION['use_dividend']);

			$this->load->view('index/header' . $this->style, $data);
			$this->load->view('index/cart/cart_checkout_ok', $data);
			$this->load->view('index/footer' . $this->style, $data);
			$_SESSION['oid'] = '';
		} else {
			$this->useful->AlertPage('/gold/login', $this->lang['Login']);
		}
	}
}
