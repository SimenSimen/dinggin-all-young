<?
class Paypal extends MY_Controller
{
	public $data='';
	public $mode='';

	public function __construct()//初始化
	{
		parent::__construct();

		//mac
		header('Access-Control-Allow-Origin: *');

		//helper
		$this->load->helper('url');
		
		//model
		$this->load->model('cart_model', 'mod_cart');

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

		//模式初始化 0=>'sandbox', 1=>'truly'
		$this->mode = 1;
	}

	public function form($cset_code, $id, $order_id)
	{
		//------------------------------------------------------------
		// 購物車金流串接參數設定
		//------------------------------------------------------------
		// 1. item_name		項目名稱
		// 2. total			總金額
		// 3. seller 		賣家Payapl帳戶
		//------------------------------------------------------------
		// 非法進入
		$order = $this->mod_cart->select_from('order', array('id' => $id)); // order
		if($order['order_id'] == $order_id && $order['status'] != 0)
		{
			$this->script_message('請勿使用非法連結', '/index/error');
		}
		else
		{
			$data   = $this->data; // 網頁資訊設定
			$mode   = $this->mode; // mode switch
			$store  = $this->mod_cart->select_from('iqr_cart', array('cset_code' => $cset_code)); // 商店設定檔
			$member = $this->mod_cart->select_from('member', array('member_id' => $store['member_id'])); // 會員資料
			$iqrt   = $this->mod_cart->select_from('iqr_trans', array('cset_id' => $store['cset_id'], 'pway_id'=>2)); // 金流帳戶設定檔
			// 帳戶設定
			switch($mode)
			{
				case 0: //sandbox
					$seller = 'kevin2pig@hotmail.com';
					$url    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				break;
				case 1: //truly
					$seller = $iqrt['business_account'];
					$url    = 'https://www.paypal.com/cgi-bin/webscr';
				break;
			}
				
			// form
			$data['form']=$url;

			// PayPal Configuration
			/* *****************************************************************************************
			 * () Paypal 參數
			 * https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/subscribe_buttons/#id08ADFB00QWS
			 * -----------------------------------------------------------------------------------------
			 * [] 舉例值
			 * -----------------------------------------------------------------------------------------
			 * 參數設定說明 :
			 * -----------------------------------------------------------------------------------------
			 * business 	: 賣家Paypal帳戶
			 * cmd 			: 按鈕類型-循環付款 	(_xclick-subscriptions)
			 * lc 			: 賣家介面語言 			(需在賣家Paypal帳戶中設定對應)
			 * notify_url 	: ipn網址				[http://domain.com/ipn/main/?key=sendipn]
			 * cancel_return: 付款取消導向網址		[http://domain.com/]
			 * return		: 付款完成導向網址		[http://domain.com/]
			 * rm 			: return method  		(2:post, 1:get)
			 * currency_code: 貨幣					
			 * item_name	: 商品名稱 
			 * no_note 		: 顯示備註				(0:yes, 1:no)
			 * cn 			: 顯示備註內容
			 * no_shipping	: 顯示ship地址			(0:yes, 1:no)
			 * src 			: 核准循環付款			(1:yes, 0:失效)
			 * srt 			: 分期付款次數			(1-52次)
			 * bn 			: 按鈕類型
			 * cbt 			: 按鈕上面的文字
			 *
			 * *****************************************************************************************/
			$data['form_info'] = "";
			$data['form_info'] = "
			    <input type = 'hidden' name = 'cmd'              id = 'edit-cmd'              value = '_cart'  />
			    <input type = 'hidden' name = 'charset'          id = 'edit-charset'          value = 'utf-8'  />
			    <input type = 'hidden' name = 'notify_url'       id = 'edit-notify-url'       value = '".base_url()."ipn/main/?key=sendipn'  />
			    <input type = 'hidden' name = 'cancel_return'    id = 'edit-cancel-return'    value = '".base_url()."cart/store/".$cset_code."'  />
			    <input type = 'hidden' name = 'no_note'          id = 'edit-no-note'          value = '1'  />
				<input type = 'hidden' name = 'no_shipping' 								  value = '1'>
			    <input type = 'hidden' name = 'return'           id = 'edit-return'           value = '".base_url()."cart/store/".$cset_code."'  />
			    <input type = 'hidden' name = 'rm'               id = 'edit-rm'               value = '2'  />
			    <input type = 'hidden' name = 'currency_code'    id = 'edit-currency-code'    value = 'TWD'  />
			    <input type = 'hidden' name = 'invoice'          id = 'edit-invoice'          value = '11-1'  />
			    <input type = 'hidden' name = 'business'         id = 'edit-business'         value = '".$seller."'  />
			    <input type = 'hidden' name = 'upload'           id = 'edit-upload'           value = '1'  />
			    <input type = 'hidden' name = 'lc'               id = 'edit-lc'               value = 'EN'  />
			    <input type = 'hidden' name = 'city'             id = 'edit-city'             value = '".$order['county']."'  />
			    <input type = 'hidden' name = 'country'          id = 'edit-country'          value = 'TW'  />
			    <input type = 'hidden' name = 'email'            id = 'edit-email'            value = '".$order['email']."'  />
			    <input type = 'hidden' name = 'first_name'       id = 'edit-first-name'       value = '".$order['name']."'  />
			    <input type = 'hidden' name = 'last_name'        id = 'edit-last-name'        value = ''  />
			    <input type = 'hidden' name = 'on0_1'          	 id = 'edit-on0-1'            value = '訂單編號'  />
			    <input type = 'hidden' name = 'os0_1'            id = 'edit-os0-1'            value = '".$order['order_id']."'  />
			";
			$items = $this->get_serialstr($order['details'], '++');
			foreach($items as $key => $value)
			{
				$sort    = $key + 1;
				$details = explode('*#', $value);
				$prd 	 = $this->mod_cart->select_from('products', array('prd_id' => $details[0])); // 產品資料
			    $data['form_info'] .= "<input type = 'hidden' name = 'amount_".$sort."'      id = 'edit-amount-".$sort."'      value = '".$prd['prd_price00']."'  />"; 	// 價錢
			    $data['form_info'] .= "<input type = 'hidden' name = 'item_name_".$sort."'   id = 'edit-item-name-".$sort."'   value = '".$prd['prd_name']."'  />"; 	// 品名
			    $data['form_info'] .= "<input type = 'hidden' name = 'quantity_".$sort."'    id = 'edit-quantity-".$sort."'    value = '".$details[1]."'  />"; 		 	// 數量
			    $data['form_info'] .= "<input type = 'hidden' name = 'item_number_".$sort."' id = 'edit-item-number-".$sort."' value = '".$details[0]."'  />"; 		 	// 品項id
			}
			// Config
			// $data['form_info'] .= "
			// 	<input type='hidden' name = 'lc'			value = 'EN'>
			// 	<input type='hidden' name = 'currency_code' value = 'TWD'>
			// 	<input type='hidden' name = 'no_note' 		value = '1'>
			// 	<input type='hidden' name = 'no_shipping' 	value = '1'>
			// 	<input type='hidden' name = 'cn' 			value = ''>
			// 	<input type='hidden' name = 'bn' 			value = 'toolkit-php'>
			// 	<input type='hidden' name = 'cbt' 			value = '下一步 >>'>
			// 	<input type='hidden' name = 'on0' 			value = '訂單編號'>
			// 	<input type='hidden' name = 'os0' 			value = '".$order_id."'>
			// ";

			// view
			$this->load->view('cart/paypal_form', $data);
		}
	}
}