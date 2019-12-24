<?php
class Taishin extends MY_Controller
{
	public $taishin_no = '', 
		   $order_id = '';

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Taipei");

		$this -> load -> helper('url');

		$this -> load -> library('Taishinbank/auth');
		
		$this -> rand_order_no(8);

		$this -> load -> model('business_model', 'mod_business');
	}

	//刷卡系統
	public function transaction($oid)
	{
		$order = $this -> mod_business -> select_from('order', array('id' => $oid));
		if ($order['pay_way_id'] == '8' && $order['status'] == '4')
		{
			$this -> queue(substr($order['order_id'], 0, 14));
			
			$this -> mod_business -> update_set('order', 'id', $oid, array('taishin_no' => $this -> taishin_no));
			$taishin_auth = new Auth();
			$object = $taishin_auth -> creditcard($this->taishin_no, ($order['total_price'] * 100));
			
			# redirect
			if ($object['getCode'] == '00')
			{
				$this -> mod_business -> update_set('order', 'id', $oid, array('taishin_code' => $object['getCode'], 'taishin_message' => "付款成功"));
				// redirect($object['getMessage']);
				
				$this -> RedirectTo($object['getMessage']);
			}
			else
			{
				$trade_log = $this -> mod_business -> select_from('taishin_trade_log', array('ret_code' => $object['getCode']));
				$this -> mod_business -> update_set('order', 'id', $oid, array('taishin_code' => $object['getCode'], 'taishin_message' => $trade_log['message']));
				$this -> script_message('錯誤:'. $object['getCode'] .', '. $trade_log['message']);
			}
		}
		else
		{
			$this -> script_message('Error Redirect', '/cart/store/1');
		}
	}

	//退刷系統
	public function backtran($oid){

		$order = $this -> mod_business -> select_from('order', array('id' => $oid));
		// print_r($order);
		if ($order['status']==2 and $order['product_flow']==7 and $order['pay_way_id']==8){
			$taishin_auth = new Auth();
			$taishin_auth->tx_type=7;
			$bdata = $taishin_auth -> other($order['taishin_no']);

			switch ($bdata['params']['order_status']) {
				case '02':
					$status='8';
					break;
				case '03':
					$status='4';
					break;
				case '04':
					$status='5';
					break;
				default:
					$status='NO';
			}
			
			if(in_array($status,array('8','4','5'))){
				$taishin_auth->tx_type=$status;
			}else
				$this -> script_message('資料有誤', '/order/order_list');	
			
			$object = $taishin_auth -> other($order['taishin_no'], ($order['total_price'] * 100));
			# redirect
			if ($object['params']['ret_code'] == '00')
			{
				$this -> mod_business -> update_set('order', 'id', $oid, array('backbrush_date' => $object['params']['purchase_date'], 'taishin_message' => "退款成功"));
				$this -> script_message('退款成功', '/order/order_list');
			}
			else
			{
				$this -> script_message('退款失敗', '/order/order_list');
			}
		}
		else
			$this -> script_message('資料有誤', '/order/order_list');
		
	}


	private function RedirectTo($url)
	{
	   header("HTTP/1.1 307 Temporary Redirect");
	   header("Location: " . $url);
	}

	public function front_result()
	{
		try {
			if ($this -> input -> get('ret_code') == '00')
			{
				// update taishin
				$update_data = array(
					'status'	 => '1',
					'product_flow' 	=> '0',
					'trade_date' => date('Y-m-d H:i:s', time())
				);
				$oid = $this -> mod_business -> update_set('order', 'taishin_no', $this -> input -> get('order_no'), $update_data);
				
				$this -> load -> model('order_model', 'omodel');
				$host = $this -> get_host_config();
				$this -> omodel -> send_mail($oid, $host);

				# Redirect, Successfull
				redirect('/cart/store/1');
			}
			else
				throw new Exception("付款失敗");
		}
		catch (Exception $e) {
			$this -> script_message($e -> getMessage(), $this -> transaction());
		}
	}

	public function back_result()
	{
		if ($this -> input -> post())
		{
			$request = json_decode($this -> input -> post(), true);
			$insert_data = array(
				'ret_code' 		=> $request['params']['ret_code'],
				'ret_msg' 		=> $request['params']['ret_msg'],
				'taishin_no' 	=> $request['params']['order_no'],
				'auth_id_resp' 	=> $request['params']['auth_id_resp'],
				'rrn' 			=> $request['params']['rrn'],
				'purchase_date' => $request['params']['purchase_date']
			);
			$this -> mod_business -> insert_into('taishin_transaction_log', $insert_data);
		}
		else
			echo 'fail';
	}

	private function rand_order_no($len)
	{
		$str = '';
		$string = "ab0123456789cdefghijklmn0123456789opqrstuvwxyzABCD0123456789EFGHIJKLMNO0123456789PQRSTUVWKYZ0123456789"; 
		for($i = 0; $i < $len; $i++)
		{ 
		    $pos  = rand(0,(strlen($string)-1)); 
		    $str .= $string{$pos}; 
		}
		$this -> taishin_no = $str;
	}

	protected function queue($order_id)
	{
		$this -> taishin_no = $order_id . $this -> taishin_no;
	}

	public function back_request_tester()
	{
		ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
		error_reporting(E_ALL & ~E_NOTICE);
		$taishin_no = '201609220004HFB4N750';

		$taishin_auth = new Auth();
		$taishin_auth->tx_type=5;
		$object = $taishin_auth -> other($taishin_no, '8,800');
		print_r($object);
	}
}