<?
class ipn extends MY_Controller
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
		
		//Model
		$this->load->model('paypal_model', 'mod_paypal');

		//模式初始化 0=>'sandbox', 1=>'truly'
		$this->mode = 1;
	}

	// 交易狀態
	public function main()
	{
		if($this->input->get('key') && $this->input->get('key') == 'sendipn')
		{
			$data   = $this->data; // 網頁資訊設定
			$mode   = $this->mode; // mode switch
			switch($mode)
			{
				case 0: //sandbox
					$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				break;
				case 1: //truly
					$url = 'https://www.paypal.com/cgi-bin/webscr';
				break;
			}
			$result = $this->mod_paypal->fsockPost($url, $_POST); 

			//check the ipn result received back from paypal
			$now = time();
			if(preg_match("/VERIFIED/i", $result)) 
			{
				/* *************************************************************
				 * Important:
				 * After you have authenticated an IPN message (that is, 
				 * received a VERIFIED response from PayPal), you must 
				 * perform these important checks before you can assume
				 * that the IPN is both legitimate and has not already 
				 * been processed:
				 * 
				 * 1. payment_status完成付款
				 * Check that the [payment_status] is [Completed].
				 *
				 * 2. if 1.成立, 檢查交易是否重複發送 by [txn_id] 
				 * If the [payment_status] is [Completed], check the [txn_id] 
				 * against the previous PayPal transaction that you processed
				 * to ensure the IPN message is not a duplicate.
				 *
				 * 3. 賣家帳戶確認
				 * Check that the receiver_email is an email address registered
				 * in your PayPal account.
				 *
				 * 4. 檢查收款是否正確
				 * Check that the price (carried in mc_gross) and the currency 
				 * (carried in mc_currency) are correct for the item (carried 
				 * in item_name or item_number).
				 *
				 * *************************************************************
				 * 0. 程式檢查 if $_POST['txn_type'] 等於 'subscr_payment'
				 * 1. 檢查 $_POST['payment_status'] 是不是 'Completed'
				 * 2. 1.成立, 檢查 $_POST['txn_id'] 在資料庫中是否重複
				 * 3. 2.成立, 檢查 $_POST['receiver_email'] 是不是我們設定的商家
				 * 4. 3.成立, 檢查 $_POST['mc_currency'] 是否等於 'USD'
				 * 5. 4.成立, 檢查 $_POST['mc_gross'] 是否等於我們設定的金額
				 *
				 * *************************************************************/
				if($_POST['txn_id'] != '')
					$txn_id = $this->mod_paypal->chk_txn_id($_POST['txn_id']);
				else
					$txn_id = NULL;

				//檢查開始 0.
				//取得現在時間
				if($_POST['txn_type'] == 'cart')//subscr_payment
				{
					// 1.
					if($_POST['payment_status'] == 'Completed')
					{
						// 2.
						if($this->mod_paypal->chk_txn_id($_POST['txn_id']))
						{
							// seller setting
							$order  = $this->mod_paypal->select_from('order', array('order_id' => $_POST['option_selection1_1'])); // order
							$store  = $this->mod_paypal->select_from('iqr_cart', array('member_id' => $order['card_owner'])); // 商店設定檔
							$iqrt   = $this->mod_paypal->select_from('iqr_trans', array('cset_id' => $store['cset_id'], 'pway_id'=>2)); // 金流帳戶設定檔
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
							// 3.
							if($_POST['receiver_email'] == $seller)
							{
								// 4. and 5.
								if($_POST['mc_currency'] == 'TWD') // && ($_POST['mc_gross'] == 2000 || $_POST['mc_gross'] == 1500 || $_POST['mc_gross'] == 1000)
								{
									$recive_data=array(
										'receiver_email'	=> $_POST['receiver_email'],
										'receiver_id'		=> $_POST['receiver_id'],
										'txn_id'			=> $_POST['txn_id'],
										'txn_type'			=> $_POST['txn_type'],
										'payer_email'		=> $_POST['payer_email'],
										'payer_id'			=> $_POST['payer_id'],
										'payer_status'		=> $_POST['payer_status'],
										'first_name'		=> $_POST['first_name'],
										'last_name'			=> $_POST['last_name'],
										'mc_currency'		=> $_POST['mc_currency'],
										'mc_gross'			=> $_POST['mc_gross'],
										'payment_date'		=> $_POST['payment_date'],
										'payment_status'	=> $_POST['payment_status'],
										'verify_sign'		=> $_POST['verify_sign'],
										'addtime'			=> $now,
										'order_id'			=> $_POST['option_selection1_1']
									);
									$ipn = $this->mod_paypal->insert_into('ipn', $recive_data);

									// 付款確認
									$this->mod_paypal->update_set('order', 'order_id', $_POST['option_selection1_1'], array('status'=>1));
								}
								else//4&5
								{
									$ipn_log = array(
										'txn_id'	=> $_POST['txn_id'],
										'content'	=> '貨幣類型錯誤：mc_currency='.$_POST['mc_currency'],
										'addtime'	=> $now
									);
									$ipn_log_statu = $this->mod_paypal->insert_into('ipn_log', $ipn_log);
								}
							}
							else//3
							{
								$ipn_log = array(
									'txn_id'	=> $_POST['txn_id'],
									'content'	=> '收款帳戶錯誤：receiver_email='.$_POST['receiver_email'],
									'addtime'	=> $now
								);
								$ipn_log_statu = $this->mod_paypal->insert_into('ipn_log', $ipn_log);
							}
						}
						else if(!is_null($_POST['txn_id']))//2
						{
							$ipn_log = array(
								'txn_id'	=> $_POST['txn_id'],
								'content'	=> '交易id重複：txn_id(repeat)='.$_POST['txn_id'].', '.$_POST['txn_type'],
								'addtime'	=> $now
							);
							$ipn_log_statu = $this->mod_paypal->insert_into('ipn_log', $ipn_log);
						}
					}
					else//1
					{
						$ipn_log = array(
							'txn_id'	=> $_POST['txn_id'],
							'content'	=> '交易非預期失敗：payment_status='.$_POST['payment_status'],
							'addtime'	=> $now
						);
						$ipn_log_statu = $this->mod_paypal->insert_into('ipn_log', $ipn_log);
					}
				}
				else // other else if($_POST['txn_type'] == 'subscr_cancel' || $_POST['txn_type'] == 'subscr_signup')
				{
					$recive_data=array(
						'receiver_email'	=> $_POST['receiver_email'],
						'receiver_id'		=> $_POST['receiver_id'],
						'txn_id'			=> $_POST['txn_id'],
						'txn_type'			=> $_POST['txn_type'],
						'payer_email'		=> $_POST['payer_email'],
						'payer_id'			=> $_POST['payer_id'],
						'payer_status'		=> $_POST['payer_status'],
						'first_name'		=> $_POST['first_name'],
						'last_name'			=> $_POST['last_name'],
						'mc_currency'		=> $_POST['mc_currency'],
						'mc_gross'			=> $_POST['mc_gross'],
						'payment_date'		=> $_POST['payment_date'],
						'payment_status'	=> $_POST['payment_status'],
						'verify_sign'		=> $_POST['verify_sign'],
						'addtime'			=> $now,
						'order_id'			=> $_POST['option_selection1_1']
					);
					$ipn = $this->mod_paypal->insert_into('ipn', $recive_data);
				}
			} 
			else 
			{
				$ipn_log = array(
					'txn_id'	=> $_POST['txn_id'],
					'content'	=> 'ipn回傳驗證未通過：'.$result,
					'addtime'	=> $now
				);
				$ipn_log_statu = $this->mod_paypal->insert_into('ipn_log', $ipn_log);
			}
		}
		else
		{
			//非法連ipn
			redirect('/index/error');
		}
	}
}