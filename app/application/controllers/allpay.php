<?
class Allpay extends MY_Controller
{
	public function __construct()//初始化
	{
		parent::__construct();

		//mac
		header('Access-Control-Allow-Origin: *');

		//helper
		$this->load->helper('url');

		//model
		$this->load->model('allpay_model', 'mod_allpay');

		//host
		$this->data['host']=$this->get_host_config();

		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id'] = $this->session->userdata('session_domain');
		else
			$this->data['domain_id'] = $this->data['host']['domain_id'];

		//web config
		$this->data['web_config'] = $this->get_web_config($this->data['domain_id']);

		//購物車開放狀態判斷
		if($this->data['web_config']['cart_status'] == 0)
		{
			redirect('/index/error');
		}
		// 0: sandbox ; 1: truely
		$this -> mode  = 1;
		$this -> added = 'Y';
	}

	public function trade($cset_code, $id, $order_id)
	{
		// AllPay Configuration
		/* *****************************************************************************************
		 * () AllPay 參數
		 * http://www.allpay.com.tw/Content/files/%E5%85%A8%E6%96%B9%E4%BD%8D%E9%87%91%E6%B5%81%E4%BB%8B%E6%8E%A5%E6%8A%80%E8%A1%93%E6%96%87%E4%BB%B6.pdf
		 * -----------------------------------------------------------------------------------------
		 * [] 舉例值 
		 * -----------------------------------------------------------------------------------------
		 * 「訂單產生」參數設定說明 :
		 * -----------------------------------------------------------------------------------------
		 * MerchantID 				: 廠商編號          Varchar(10) 
		 * MerchantTradeNo 			: 廠商交易編號      Varchar(20)     (不可重複)
		 * MerchantTradeDate 		: 廠商交易時間      Varchar(20)     (格式：yyyy/MM/dd HH:mm:ss)
		 * PaymentType 				: 交易類型          Varchar(20)     [aio]
		 * TotalAmount				: 交易金額		  
		 * TradeDesc				: 交易描述		    Varchar(200)    (不可為空)
		 * ItemName 				: 商品名稱  	    Varchar(200)    (以#分隔) [車x1#玩具x1]
		 * return_url  				: 付款完成通知      Varchar(200)    (將付款結果以 server端幕後方式，回傳到該網址)
		 							  回傳網址			
		 * ChoosePayment			: 選擇預設付款方式  Varchar(20)     (不可為空)
		 * CheckMacValue 			: 檢查碼			Varchar			(不可為空)
		 * DeviceSource 			: 裝置來源			Varchar(10)     (P:桌機  M:手機)
		 * ClientBackURL            : Client端			Varchar(200)
		 							  返回廠商網址
		 * IgnorePayment 			: 忽略的付款方式	Varchar(100)    (以#分隔) [ATM#CVS]
		 * *****************************************************************************************/
        // 判斷裝置
		$device = $this -> get_device_os();

		$data   = $this -> data;
		$mode   = $this -> mode;
		$added  = $this -> added; 
		$store  = $this -> mod_allpay -> select_from('iqr_cart', array('cset_code' => $cset_code));
		$order  = $this -> mod_allpay -> select_from('order', array('id' => $id));
		$iqrt   = $this -> mod_allpay -> select_from('iqr_trans', array('cset_id' => $store['cset_id'], 'pway_id' => 5));
		$logist = $this -> mod_allpay -> select_from('iqr_logistics', array('iqrt_id' => $order['lway_iqrt_id']));
		$logist_info = $this -> mod_allpay -> select_from('logistics_way', array('lway_id' => $logist['lway_id']));
        // 判斷後台訂單是否付款
        if($order['pay_way_id'] == 5 && $order['status'] == 0 && $order['product_flow'] == 0)
		{		
			//商店代號
			$merchant_id = $iqrt['business_account'];
			//hashkey
			$hash_key = $iqrt['business_hashkey'];
			//iv
			$hash_iv  = $iqrt['business_hashiv'];


			// form_active 交易網址
			switch ($mode)
			{
				case 0:
					$data['gateway_url'] = "http://payment-stage.allpay.com.tw/Cashier/AioCheckOut";
					break;
				case 1:
					$data['gateway_url'] = "https://payment.allpay.com.tw/Cashier/AioCheckOut";
					break;
			}
			// 判斷裝置
			switch ($device)
			{
				case 'windows':
					$device_source = 'P';
					break;
				default:
					$device_source = 'M';
					break;
			}
			// 訂單編號
			if($order['status'] == 0) 
			{
				$now = time();
				$trade_date = date("Y/m/d H:i:s", $now);
				$time_mark = date("YmdHis", $now);
				$order_no = $this -> mod_allpay -> generatorPassword(6, $time_mark);
				$this -> mod_allpay -> update_set('order', 'id', $id ,array('trade_no' => $order_no));
			}
			else
			{
				$this -> script_message('交易失敗','/cart/store/'.$store['cset_code']);
			}
			
			// 產品名稱
			$items = $this->get_serialstr($order['details'], '++');
			foreach($items as $key => $value)
			{
				$details = explode('*#', $value);
				$prd 	 = $this -> mod_allpay ->select_from('products', array('prd_id' => $details[0])); // 產品資料
				$item[$key] = $prd['prd_name'].'x'.$details[1];
				$money[$key] = $prd['prd_price00'] * $details[1];
				$logist_data = false;
			}
			if($logist_info && $order['lway_price'] != 0)
			{
				$item[$key + 1]  = '運費x1';
				$money[$key + 1] = $order['lway_price'];
				$logist_data = true;

			}
			foreach ($item as $item_key => $item_value)
			{
				if($logist_data)
					$key = $key + 1;
				if($item_key < $key)
					$item_name .= $item_value.'#';
				else
					$item_name .= $item_value;
			}

			// 運算總價格
			$total_amount = array_sum($money);

			//交易返回頁面
			$return_url = base_url()."allpay/return_information";

			//交易通知網址
			$client_back_url = base_url().'cart/store/'.$store['cset_code'];

			//選擇預設付款方式
			$choose_payment = "ALL";

			$ignore_payment = "ATM#WebATM#CVS#BARCODE#Alipay#Tenpay#TopUpUsed";

			$form_array = array(
			    "MerchantID" 		=> $merchant_id, 			 	// 商家代號
			    "MerchantTradeNo"   => $order_no,				 	// 訂單編號
			    "MerchantTradeDate" => $trade_date,  	        	// 訂單日期
			    "PaymentType" 		=> "aio",
			    "TotalAmount" 		=> $total_amount,			 	// 交易金額
			    "TradeDesc" 		=> $store['cset_name'],			// 交易描述
			    "ItemName" 			=> $item_name,				 	// 商品名稱(以井號分隔(#))
			    "ReturnURL" 		=> $return_url,				 	// 交易返回頁面
			    "ChoosePayment" 	=> $choose_payment,			 	// 付款方式
			    "ClientBackURL" 	=> $client_back_url,		 	// 交易通知網址
			    "DeviceSource"		=> $device_source,			 	// 裝置來源
			    "IgnorePayment"		=> $ignore_payment,				// 忽略的付款方式
			    "NeedExtraPaidInfo" => $added,						// 額外回傳
				// 1.信用卡 - 分期
			    "CreditInstallment"	=> $iqrt['creditinstallment']	// 分期期數
			);
			ksort($form_array);
			// 檢查碼
			$encode_str = "HashKey=" . $hash_key . "&" . urldecode(http_build_query($form_array)) . "&HashIV=" . $hash_iv;
			$encode_str = urlencode($encode_str);
			$encode_str = strtolower($encode_str);
			$SPChar_str = $this -> _replaceSPChar($encode_str);
			$CheckMacValue = strtoupper(md5($SPChar_str));
			$form_array["CheckMacValue"] = $CheckMacValue;

			
			foreach($form_array as $key => $val)
			{
			    $form_info .= "<input type='hidden' name='" . $key . "' value='" . $val . "'><BR>";
			}

			// $form_info .= "<input type='submit' value='送出'>";
			$data['form_info'] = $form_info;
		}
		else
		{
			$this -> script_message('連線錯誤', '/cart/store/'.$store['cset_code']);
		}
		echo '<span style="font-family: 微軟正黑體; font-size: 1em;">系統連線中 ...</span>';

		$this -> load -> view('cart/allpay_form', $data);
	}

	// 交易成功 return
	public function return_information()
	{
		// 一般交易
		$MerchantID      = $this -> input -> post('MerchantID');
		$MerchantTradeNo = $this -> input -> post('MerchantTradeNo');
		$RtnCode         = $this -> input -> post('RtnCode');
		$TradeNo         = $this -> input -> post('TradeNo');
		$TradeAmt        = $this -> input -> post('TradeAmt');
		$date            = $this -> input -> post('PaymentDate');
		$suc_date        = $this -> input -> post('TradeDate');
		$simulatepaid    = $this -> input -> post('SimulatePaid');
		$PaymentType     = $this -> input -> post('PaymentType');
		$CheckMacValue   = $this -> input -> post('CheckMacValue');

		// 信用卡付款
		$gwsr    = $this -> input -> post('gwsr');		  // 授權單號
		$stage   = $this -> input -> post('stage');       // 分期期數
		$stast   = $this -> input -> post('stast'); 	  // 頭期金額
		$staed   = $this -> input -> post('staed'); 	  // 各期金額
		$card4no = $this -> input -> post('card4no'); 	  // 卡片末四碼
		$card6no = $this -> input -> post('card6no'); 	  // 卡片前六碼

		if($RtnCode == 1)
		{
			$insert_data = array(
				'status'		=> 1,
				'allpay_no'     => $TradeNo,
				'trade_date'	=> $date,
				'stage'			=> $stage,
				'stast' 		=> $stast,
				'staed' 		=> $staed,
				'card4no' 		=> $card4no,
				'card6no' 		=> $card6no
			);
			$this -> mod_allpay -> update_set('order', 'trade_no', $MerchantTradeNo, $insert_data);
		// allpay_credit_log
			$trade_msg = $this -> mod_allpay -> select_from('allpay_trade_msg', array('trade_code' => $RtnCode));
			$insert_data = array(
				'gwsr'				=> $gwsr,
				'trade_no'			=> $MerchantTradeNo,
				'allpay_trade_no'	=> $TradeNo,
				'trade_mode'		=> $PaymentType,
				'payment_time'		=> $date,
				'trade_amt'			=> $TradeAmt,
				'add_time'			=> date("YmdHis",time()),
				'stage'				=> $stage,
				'stast' 			=> $stast,
				'staed' 			=> $staed,
				'card4no' 			=> $card4no,
				'card6no' 			=> $card6no,
				'rtncode'			=> $trade_msg['msg_tw']
			);
			$this -> mod_allpay -> insert_into('allpay_trade_log', $insert_data);
		}

		// 定期定額交易
		// $PeriodType     	= $this -> input -> post('PeriodType');         // 週期種類
		// $Frequency      	= $this -> input -> post('Frequency');          // 週期
		// $ExecTimes      	= $this -> input -> post('ExecTimes');			// 執行次數
		// $gwsr 				= $this -> input -> post('gwsr');				// 授權交易單號
		// $FirstAuthAmount    = $this -> input -> post('FirstAuthAmount');	// 初次授權金額
		// $TotalSuccessTimes  = $this -> input -> post('TotalSuccessTimes');	// 已執行成功次數


		$to ='vince@netnews.com.tw'; 
		$subject = 'subject';
		$msg = 'URL:'.base_url().'';
		$msg .= '廠商編號：'.$MerchantID.
			   '<p>交易編號：'.$MerchantTradeNo.
			   '<p>交易狀態：'.$RtnCode.
			   '<p>allpay交易編號：'.$TradeNo.
			   '<p>交易金額：'.$TradeAmt.
			   '<p>付款方式：'.$PaymentType.
			   '<p>檢查碼：'.$CheckMacValue.
			   '<p>付款時間：'.$date.
			   '<p>成立時間：'.$suc_date.
			   '<p>模擬付款：'.$simulatepaid.
			   '<p>授權交易單號：'.$gwsr;

		$msg .= '<p>分期期數：'.$stage.'</p>'.
			   '<p>頭期金額：'.$stast.'</p>'.
			   '<p>各期金額：'.$staed.'</p>'.
			   '<p>卡片末四碼：'.$card4no.'</p>'.
			   '<p>卡片前六碼：'.$card6no.'</p>';

		$headers = 'From: manager@com.tw';
		mail($to, $subject, $msg, $headers);

		// return 1;
		// echo '1';

	}
	public function Refund($id, $order_id, $action)
	{
		// url
		// http://rich899.net/allpay/Refund/92/20150120164211484626/4

		$data = $this -> data;
		$mode = $this -> mode;
		// 利用 member_id 抓取
		$store  = $this -> mod_allpay -> select_from('iqr_cart', array('member_id' => '275'));
		//
		$order  = $this -> mod_allpay -> select_from('order', array('id' => $id));
		$iqrt   = $this -> mod_allpay -> select_from('iqr_trans', array('cset_id' => $store['cset_id'], 'pway_id' => 5));
		switch ($mode)
		{
			case 0:
				$data['gateway_url'] = '';
				break;
			case 1:
				$data['gateway_url'] = 'https://payment.allpay.com.tw/CreditDetail/DoAction';
				break;
		}
		// 執行動作
		switch ($action)
		{
			case 1:	$action = 'C';		break;		// 關帳
			case 2:	$action = 'R';		break;		// 退刷
			case 3:	$action = 'E';		break;		// 取消
			case 4:	$action = 'N';		break;		// 放棄
		}

		$items = $this->get_serialstr($order['details'], '++');
		foreach($items as $key => $value)
		{
			$details = explode('*#', $value);
			$prd 	 = $this -> mod_allpay ->select_from('products', array('prd_id' => $details[0])); // 產品資料
			$item[$key] = $prd['prd_name'].'x'.$details[1];
			$money[$key] = $prd['prd_price00'] * $details[1];
		}

		// 運算總價格
		$total_amount = array_sum($money);
		
		$hash_key = $iqrt['business_hashkey'];
		$hash_iv  = $iqrt['business_hashiv'];

		$form_array = array(
		    "MerchantID" 				=> $iqrt['business_account'],
		    "MerchantTradeNo"   		=> $order['trade_no'],
		    "TradeNo"					=> $order['allpay_no'],
		    "Action"					=> $action,
		    "TotalAmount"				=> $total_amount
		);
		ksort($form_array);
		// 檢查碼
		$encode_str = "HashKey=" . $hash_key . "&" . urldecode(http_build_query($form_array)) . "&HashIV=" . $hash_iv;
		$encode_str = urlencode($encode_str);
		$encode_str = strtolower($encode_str);
		$CheckMacValue = strtoupper(md5($encode_str));
		$form_array["CheckMacValue"] = $CheckMacValue;
		
		foreach($form_array as $key => $val)
		{
		    $form_info .= "<input type='text' name='" . $key . "' value='" . $val . "'><BR>";
		}

		$form_info .= "<input type='submit' value='送出'>";
		$data['form_info'] = $form_info;

		$this -> load -> view('cart/allpay_form', $data);
	}

	function _replaceSPChar($value)
    {
        $search_list = array('%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29');
        $replace_list = array('-', '_', '.', '!', '*', '(', ')');
        $value = str_replace($search_list, $replace_list ,$value);
       
        return $value;
    }
}