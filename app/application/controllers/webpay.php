<?php

/**
 * 藍新金流
 */
class Webpay extends MY_Controller
{
	public function __construct() // 初始化
	{
		parent::__construct();

		@session_start();

		$this->load->helper('url');
		$this->load->model(['MyModel/mymodel', 'products_model', 'cart_model', 'order_model']);
		$this->load->library('mylib/useful');
		$this->load->library('mylib/newebpay');
	}

	// 藍新支付 等候頁面 (後續將串接藍新金流付款API)
	public function wait()
	{
		$this->load->view('index/cart/pay_wait', $_SESSION['payment_info']);
	}

	// 串接藍新金流付款 API
	public function newebpay()
	{
		$data = [
			'order_id' => $_POST['order_id'],
			'price_money' => $_POST['price_money'],
			'prd_name' => $_POST['prd_name'],
			'email' => $_POST['email']
		];
		$result = $this->newebpay->mpg($data, 'pay_form');
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	// 付款
	public function pay()
	{
		//語言包
		$language = $this->language;
		$this->lang = $this->lmodel->config('26', $this->setlang);

		$data['use_dividend']	=	$use_dividend	=	$_SESSION['use_dividend'];
		$data['use_shopping_money']	=	$use_shopping_money	=	$_SESSION['use_shopping_money'];
		$by_id = $_SESSION['MT']['by_id'];
		$buyer = $this->mymodel->OneSearchSql('buyer', 'PID,d_is_member', array('by_id' => $by_id));
		$PID = $buyer['PID'];
		$memberName	= $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $PID));
		//撈出購物車的商品
		$bdata = $this->mymodel->OneSearchSql('buyer', 'd_spec_type, PID', array('by_id' => $by_id)); //會員是否VIP
		$price	=	($bdata['d_spec_type'] == 1) ? 'd_mprice' : 'prd_price00';
		$join_car	=	$_SESSION['join_car'];
		$order_data['total_pv'] = 0;

		$ids = [];  // 存放商品id
		$priceSum = 0;
		foreach ($join_car as $uuid => $item) {

			$key = $item['prd_id'];
			$value = $item['amount'];

			$productsDetail = $this->products_model->productsDetail($key, $bdata['d_spec_type']);
			$dbdata = $productsDetail['data'];

			if ($value > $dbdata['prd_amount']) {
				array_push($ids, $dbdata['prd_id']);
			}

			$productList[$uuid]['num']			=	$value;
			$productList[$uuid]['prd_id']		=	$dbdata['prd_id'];
			$productList[$uuid]['prd_name']		=	$dbdata['prd_name'];
			$productList[$uuid]['spec']			=	$key;
			$productList[$uuid]['spec_name']		= substr($key, strpos($key, '##*') + 3);
			$prd_name[]							=	$dbdata['prd_name'];
			$productList[$uuid]['price']			=	$dbdata[$price];
			$productList[$uuid]['total']			=	$value * $dbdata[$price];
			$priceSum							=	$productList[$uuid]['total'] + $priceSum;
			$productList[$uuid]['supplier_id']	=	$dbdata['supplier_id'];
			$dbdata['prd_pv']					=	$dbdata['prd_pv'] * $value;
			$order_data['total_pv']				=	$order_data['total_pv'] + $dbdata['prd_pv'];
		}

		if (!empty($ids)) {
			$_SESSION['ids'] = $ids;
		} else {
			$_SESSION['ids'] = [];
		}

		// 確認庫存無誤 才更新商品庫存數量
		foreach ($join_car as $uuid => $item) {

			$key = $item['prd_id'];
			$value = $item['amount'];

			$productsDetail = $this->products_model->productsDetail($key, $bdata['d_spec_type']);
			$dbdata = $productsDetail['data'];
			$this->products_model->reduceProductQty($dbdata['prd_id'], $value);	// 更新商品數量
		}

		$products = '';
		foreach (array_values($productList) as $key => $item) {

			$key = $item['prd_id'];
			$value = $item['amount'];

			$str = $key === (count($productList) - 1) ? '' : ",";
			$products .= $item['prd_name'] . $str;
		}

		$data['totalPrice'] = $totalPrice =	$data['priceSum'] =	$priceSum;
		//紅利
		$config 		= $this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 73));
		$config['d_val'] = ($config['d_val']) / 100;
		$bonus		= $totalPrice * $config['d_val'];
		$shipCost = 0;
		//若未滿免運金額&選擇宅配,再加運費
		$cost = $this->mymodel->OneSearchSql('logistics_way', 'business_account', array('lway_id' => 4));
		$data['freeShip']	=	$cost['business_account'];
		if ($priceSum < $data['freeShip'] and $_POST['lway_id'] <> 5) {
			$ship_cost = $this->mymodel->OneSearchSql('logistics_way', 'business_account', array('lway_id' => $_POST['lway_id']));
			$data['totalPrice']	= $totalPrice = $data['totalPrice'] + $ship_cost['business_account'];
			$shipCost = $ship_cost['business_account'];
		}

		$config = $this->mymodel->OneSearchSql('config', 'd_val', array('d_id' => 76));
		$dividendTurn =	(int) $config['d_val'];
		$use_dividend_cost = $use_dividend / $dividendTurn;
		$price_money = $totalPrice - (int) $use_dividend_cost - $use_shopping_money;

		if ($buyer['d_is_member'] == 1) { //是經營會員,撈取upline				
			$member  = $this->mymodel->OneSearchSql('member', 'upline', ['by_id' => $by_id]);
			$account = $member['upline'];
		} else { //非經營會員,撈取buyer.PID,再取得該PID的member_id
			$pid = $bdata['PID'];
			$member = $this->mymodel->OneSearchSql('member', 'member_id', ['by_id' => $pid]);
			while (empty($member)) {
				$buyer = $this->mymodel->OneSearchSql('buyer', 'pid', ['by_id' => $pid]);
				$member = $this->mymodel->OneSearchSql('member', 'member_id', ['by_id' => $buyer['pid']]);
				$pid = $buyer['pid'];
			}
			$account = $member['member_id'];
		}

		$post_arr =	[];
		$post_arr['by_id'] = $by_id;
		$post_arr['date'] =	time();
		$order_data['account'] = $account;
		$order_data['priceSum'] = $priceSum;
		$order_data['bonus'] =	$bonus;
		$order_data['totalPrice'] =	$totalPrice;
		$order_data['price_money'] = $price_money;
		$order_data['use_dividend'] = ((int) ($use_dividend / $dividendTurn)) * $dividendTurn;
		// $order_data['use_dividend']		=	$use_dividend;
		$order_data['use_dividend_cost'] = (int) $use_dividend_cost;
		$order_data['use_shopping_money'] =	$use_shopping_money;
		$order_data['shipCost'] = $shipCost;
		$order_data['atmpayment'] =	'';

		if (!empty($priceSum)) {
			$oid = $this->cart_model->insertOrder($post_arr, $order_data);
			$order_id =	$this->useful->get_order_num($oid);
			$this->cart_model->insertOrderDetail($oid, $order_id, $post_arr, $productList, $priceSum);
			$prd_name = implode(',', $prd_name);

			// 獲得紅利log
			$redata = [
				'OID' => $oid,
				'buyer_id' => $by_id,
				'd_type' => '19',
				'd_val' => $bonus,
				'd_des' => $this->lang['ordernumber']/*訂單編號*/ . ' [' . $order_id . ']  - ' . $this->lang['o_62']/*商品名稱*/ . '：' . $prd_name,
				'is_send' => 'N',
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time(),
			];
			$this->mymodel->insert_into('dividend', $redata);

			if (!empty($use_dividend)) {
				// 扣除紅利log
				$usedata = [
					'OID' => $oid,
					'buyer_id' => $by_id,
					'd_type' => '20',
					'd_val' => $use_dividend,
					'd_des' => $this->lang['ordernumber']/*訂單編號*/ . ' [' . $order_id . ']  - ' . $this->lang['o_62']/*商品名稱*/ . '：' . $prd_name,
					'is_send' => 'Y',
					'create_time' => $this->useful->get_now_time(),
					'update_time' => $this->useful->get_now_time(),
					'send_dt' => $this->useful->get_now_time(),
				];
				$this->mymodel->insert_into('dividend', $usedata);
			}
			if (!empty($use_shopping_money)) {
				$usedata = [
					'd_member_id' => $by_id,
					'd_guest_id' => $by_id,
					'd_shopping_money' => '-' . $use_shopping_money,
					'd_content' => $this->lang['ordernumber']/*訂單編號*/ . ' [' . $order_id . ']  - ' . $this->lang['o_62']/*商品名稱*/ . '：' . $prd_name,
					'create_time' => $this->useful->get_now_time(),
				];
				$this->mymodel->insert_into('shopping_money', $usedata);
			}
		}

		$this->lang = $this->lmodel->config('22', $this->setlang);

		// 紀錄訂單寄信
		// 寄給買家
		$this->order_mail($order_id, $_POST['buyer_email']);
		//寄通知信給後台購物車設定email
		// $this->order_mail_store($order_id, $_POST['buyer_email']);
		$_SESSION['oid'] = $oid;

		// 若實際付款金額大於0 導向至智付通；否則直接導向至訂單成立頁面
		if ($price_money > 0) {
			$_SESSION['payment_info'] = [
				'order_id' => $order_id,
				'price_money' => $price_money,
				'email' => $_POST['buyer_email'],
				'prd_name' => $products
			];
			$this->useful->AlertPage('/webpay/wait');
		} else {
			$this->useful->AlertPage('/cart/finish');
		}
	}

	private function order_mail($timestamp, $buyer_email)
	{
		// 寄信通知訂單紀錄		
		$order = $this->cart_model->select_from('order', ['order_id' => $timestamp, 'email' => $buyer_email]);
		$host = $this->get_host_config();
		$this->order_model->send_mail2($order['id'], $host);
	}

	private function order_mail_store($timestamp, $buyer_email)
	{
		// 寄信通知訂單紀錄		
		$order = $this->cart_model->select_from('order', ['order_id' => $timestamp, 'email' => $buyer_email]);
		$host = $this->get_host_config();
		$this->order_model->send_mail_store($order['id'], $host);
	}
}
