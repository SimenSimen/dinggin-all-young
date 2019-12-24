<?php
// stripe 金流
class Stripe extends MY_Controller
{
	public function __construct() // 初始化
	{
		parent::__construct();
        // helper
        $this->load->helper('url');
        @session_start();
		$this->load->model(array('MyModel/mymodel', 'products_model', 'cart_model', 'order_model'));
		$this->load->library('mylib/useful');
		$this->load->library('stripe/init');
        $this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';
	}

	public function pay(){//付款成功
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		//check whether stripe token is not empty
		if(!empty($_POST['stripeToken'])){
		   	$token  = $_POST['stripeToken'];
		    $email = $_POST['stripeEmail'];
		    //set api key
		    $stripe = array(
		      //"secret_key"      => "sk_live_WP9b8GJubak8vwHtSSrpEFeG",
		      //"publishable_key" => "pk_live_HEQJFafAvpWtUPoRhqsstfuo"
					"secret_key"      => "sk_test_FiFOIWJh3ZOaGgDh0GqlThLC",
		      "publishable_key" => "pk_test_1Rj3QEA26zCpbQIOW1Jvic5p"
		    );
			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
			    'email' => $email,
			    'source'  => $token
			));
			$data['use_dividend']	=	$use_dividend	=	$_SESSION['use_dividend'];
			$data['use_shopping_money']	=	$use_shopping_money	=	$_SESSION['use_shopping_money'];
			$by_id	=	$_SESSION['MT']['by_id'];			
			$buyer  =	$this->mymodel->OneSearchSql('buyer','PID,d_is_member',array('by_id'=>$by_id));			
			$PID	=	$buyer['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			//撈出購物車的商品
			$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type, PID',array('by_id'=>$by_id));//會員是否VIP
			$price	=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
			$join_car	=	$_SESSION['join_car'];
			$order_data['total_pv']=0;
			foreach ($join_car as $key => $value) {
				$productsDetail						=	$this->products_model->productsDetail($key,$bdata['d_spec_type']);
				$dbdata								=	$productsDetail['data'];
				$productList[$key]['num']			=	$value;
				$productList[$key]['prd_id']		=	$dbdata['prd_id'];
				$productList[$key]['prd_name']		=	$dbdata['prd_name'];
				$productList[$key]['spec']			=	$key;
				$productList[$key]['spec_name']		=	substr($key,strpos($key,'##*')+3);
				$prd_name[]							=	$dbdata['prd_name'];
				$productList[$key]['price']			=	$dbdata[$price];
				$productList[$key]['total']			=	$value*$dbdata[$price];
				$priceSum							=	$productList[$key]['total']+$priceSum;
				$productList[$key]['supplier_id']	=	$dbdata['supplier_id'];
				$dbdata['prd_pv']					=	$dbdata['prd_pv']*$value;
				$order_data['total_pv']				=	$order_data['total_pv']+$dbdata['prd_pv'];
			}
			$data['totalPrice']		=	$totalPrice 	=	$data['priceSum']	=	$priceSum;			
			//紅利
			$config 		= $this->mymodel->OneSearchSql('config','d_val',array('d_id'=>73));
			$config['d_val']= ($config['d_val'])/100;
			$bonus		= $totalPrice*$config['d_val'];
			$shipCost=0;
			//若未滿免運金額&選擇宅配,再加運費
			$cost=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>4));
			$data['freeShip']	=	$cost['business_account'];			
			if($priceSum < $data['freeShip'] and $_POST['lway_id']<>5){
				$ship_cost=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>$_POST['lway_id']));
				$data['totalPrice']	= $totalPrice =$data['totalPrice']+$ship_cost['business_account'];
				$shipCost=$ship_cost['business_account'];
			}
	
			$config 				=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
			$dividendTurn			=	(int)$config['d_val'];
			$use_dividend_cost		=	$use_dividend/$dividendTurn;
			$price_money			=	$totalPrice-$use_dividend_cost-$use_shopping_money;

			if($buyer['d_is_member']==1){//是經營會員,撈取upline				
				$member  = $this->mymodel->OneSearchSql('member','upline',array('by_id'=>$by_id));
				$account = $member['upline'];
			}else{//非經營會員,撈取buyer.PID,再取得該PID的member_id
				$pid  =	$bdata['PID'];
				$member=$this->mymodel->OneSearchSql('member','member_id',array('by_id'=>$pid));
				while (empty($member)) {
					$buyer=$this->mymodel->OneSearchSql('buyer','pid',array('by_id'=>$pid));
					$member=$this->mymodel->OneSearchSql('member','member_id',array('by_id'=>$buyer['pid']));
					$pid=$buyer['pid'];
				}
				$account = $member['member_id'];
			}
			$post_arr						=	$_POST;
			$post_arr['date']				=	time();
			$order_data['account']			=	$account;
			$order_data['priceSum']			=	$priceSum;
			$order_data['bonus']			=	$bonus;
			$order_data['totalPrice']		=	$totalPrice;
			$order_data['price_money']		=	$price_money;
			$order_data['use_dividend']		=	$use_dividend;
			$order_data['use_dividend_cost']=	$use_dividend_cost;
			$order_data['use_shopping_money']		=	$use_shopping_money;
			$order_data['shipCost']			=	$shipCost;
			$order_data['atmpayment']		=	'';

			if(!empty($priceSum)){
				$oid = $this->cart_model->insertOrder($post_arr,$order_data);
				$order_id =	$this->useful->get_order_num($oid);
				$this->cart_model->insertOrderDetail($oid, $order_id, $post_arr, $productList,$priceSum);
				$prd_name=implode(',',$prd_name);
				$redata=array(
					'OID'=>$oid,
					'buyer_id'=>$by_id,
					'd_type'=>'19',
					'd_val'=>$bonus,
					'd_des'=>$this->lang['ordernumber']/*訂單編號*/.' ['.$order_id.']  - '.$this->lang['o_62']/*商品名稱*/.'：'.$prd_name,
					'is_send'=>'N',
					'create_time'=>$this->useful->get_now_time(),
					'update_time'=>$this->useful->get_now_time(),
				);
				$this->mymodel->insert_into('dividend',$redata);

				if(!empty($use_dividend)){
					$usedata=array(
						'OID'=>$oid,
						'buyer_id'=>$by_id,
						'd_type'=>'20',
						'd_val'=>$use_dividend,
						'd_des'=>$this->lang['ordernumber']/*訂單編號*/.' ['.$order_id.']  - '.$this->lang['o_62']/*商品名稱*/.'：'.$prd_name,
						'is_send'=>'Y',
						'create_time'=>$this->useful->get_now_time(),
						'update_time'=>$this->useful->get_now_time(),
						'send_dt'=>$this->useful->get_now_time(),
					);
					$this->mymodel->insert_into('dividend',$usedata);
				}
				if(!empty($use_shopping_money)){
					$usedata=array(
						'd_member_id'=>$by_id,
						'd_guest_id'=>$by_id,
						'd_shopping_money'=>'-'.$use_shopping_money,
						'd_content'=>$this->lang['ordernumber']/*訂單編號*/.' ['.$order_id.']  - '.$this->lang['o_62']/*商品名稱*/.'：'.$prd_name,
						'create_time'=>$this->useful->get_now_time(),
					);
					$this->mymodel->insert_into('shopping_money',$usedata);
				}
			}
			//新增完畢清掉購物車&使用紅利
			unset($_SESSION['join_car']);
			unset($_SESSION['use_dividend']);
			//item information
		    $itemName = $redata['d_des'];
		    $itemPrice = ($price_money*100);
		    $currency = 'usd';
		    $orderID = $order_id;
		    //charge a credit or a debit card
		    $charge = \Stripe\Charge::create(array(
		        'customer' => $customer->id,
		        'amount'   => $itemPrice,
		        'currency' => $currency,
		        'description' => $itemName,
		        'metadata' => array('order_id' => $orderID)
		    ));

		    //retrieve charge details
		    $chargeJson = $charge->jsonSerialize();
		    //check whether the charge is successful
		    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
		        //order details 
		        $amount = $chargeJson['amount'];
		        $balance_transaction = $chargeJson['balance_transaction'];
		        $currency = $chargeJson['currency'];
		        $status = $chargeJson['status'];
		        $date = date("Y-m-d H:i:s");			        
		        //if order inserted successfully
		        if($status == 'succeeded'){
					$this->lang=$this->lmodel->config('22',$this->setlang);
					$this->mymodel->update_set('`order`','id',$oid,array('status'=>'1'));
					$this->mymodel->update_set('`order_details`','oid',$oid,array('status'=>'1'));
					// 紀錄訂單寄信
					$timer=time();
					//寄給買家
					$this->order_mail($order_id, $_POST['buyer_email']);
					//寄通知信給後台購物車設定email
					$this->order_mail_store($order_id, $_POST['buyer_email']);
							$_SESSION['oid']=$oid;
		            $this->useful->AlertPage('/cart/cart_checkout_ok/');
		        }else{
		            $this->useful->AlertPage('/cart');
		        }
		    }else{
		        $this->useful->AlertPage('/cart');
		    }
		}else{
			$this->useful->AlertPage('/cart');
		}
	}
	
	private function order_mail($timestamp, $buyer_email)
	{
		// 寄信通知訂單紀錄		
		$order = $this->cart_model-> select_from('order', array('order_id' => $timestamp, 'email' => $buyer_email));
		$host = $this->get_host_config();
		$this->order_model->send_mail2($order['id'],$host);
	}

	private function order_mail_store($timestamp, $buyer_email)
	{
		// 寄信通知訂單紀錄		
		$order = $this->cart_model-> select_from('order', array('order_id' => $timestamp, 'email' => $buyer_email));
		$host = $this->get_host_config();
		$this->order_model->send_mail_store($order['id'],$host);
	}
}?>
