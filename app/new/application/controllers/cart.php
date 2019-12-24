<?php
// 購物車
class Cart extends MY_Controller
{
	public $data='';
	public $language='';
	public $Spath = '/uploads/000/000/0000/0000000000/products/';
	public function __construct() // 初始化
	{
		parent::__construct();
        // helper
        $this->load->helper('url');
        @session_start();
		$this->load->model(array('MyModel/mymodel','banner_model', 'products_model', 'cart_model'));
		$this->load->library('mylib/useful');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('lang_model',lmodel);
		$this->load->model('order_model', 'omodel');
        //$this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';
        //web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		//檔案名
		$this->DataName='cart';
	}

	public function index()
	{	
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('22',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{	if(empty($_SESSION['join_car'])){	
				$this->useful->AlertPage($_SESSION['Url'],'購物車沒有商品');	
			}
			//推薦人
			$by_id = $_SESSION['MT']['by_id'];
			$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
			$data['d_dividend']	= $buyer['d_dividend'];
			$PID	=	$buyer['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']			=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			
			$this->data['banner'] 		= 	$this->banner_model->getMyAd();	
			$data['by_id']				=	$_SESSION['MT']['by_id'];
			$data['banner']				=	$this->data['banner'];
			$bdata						=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$data['by_id']));		
			$price						=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
			//撈出購物車的商品
			$join_car	=	$_SESSION['join_car'];
			unset($_SESSION['join_car']['']);
			foreach ($join_car as $key => $value) {
				$productsDetail 					= 	$this->products_model->productsDetail($key,$bdata['d_spec_type']);
				$dbdata								= 	$productsDetail['data'];
				$productList[$key]['num']			=	$value;
				$productList[$key]['prd_id']		=	$dbdata['prd_id'];
				$productList[$key]['spec']			=	$key;
				$productList[$key]['spec_rename']	=	str_replace('##*','_',$key);
				$productList[$key]['spec_name']		=	substr($key,strpos($key,'##*')+3);
				$productList[$key]['prd_name']		=	$dbdata['prd_name'];
				$productList[$key]['prd_image']		=	$dbdata['prd_image'];
				$productList[$key]['price']			=	number_format($dbdata[$price],2);
				$productList[$key]['total']			=	number_format($value*$dbdata[$price],2);
			}
			//地區撈取
			$data['country']=$this->mymodel->get_area_data();
			//常用地址
			$data['address']=$this->mymodel->get_address_data($data['by_id']);			
			switch ($this->setlang) {
				case 'TW':
					$lway_name = 'lway_name_1';
					$pway_name = 'pway_name_1';
					break;
				case 'ENG':
					$lway_name = 'lway_name_2';
					$pway_name = 'pway_name_2';
					break;
				case 'JAP':
					$lway_name = 'lway_name_3';
					$pway_name = 'pway_name_3';
					break;
			}
			// 運送方式
			// logistics_way : 撈取當下能使用的物流付款方式(由超管設定)
			$logistics_way = $this -> mod_cart -> select_from_order('logistics_way', 'lway_id', asc, array('active' => 1));
			foreach ($logistics_way as $key => $value) {
				$data['logistics_way'][$key]['lway_id']= $value['lway_id'];
				$data['logistics_way'][$key]['lway_name']= $value[$lway_name];
			}
			// 付款方式
			// payment_way : 撈取當下能用的付款方式(由超管設定)
			$payment_way = $this->mod_cart->select_from_order('payment_way', 'pway_id', 'asc', array('active'=>1));
			foreach ($payment_way as $key => $value) {
				$data['payment_way'][$key]['pway_id']= $value['pway_id'];
				$data['payment_way'][$key]['pway_name']= $value[$pway_name];
			}

			$data['productList']	=	$productList;
			$data['Spath']			=	$this -> Spath;
			$data['path_title']		=	'<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>';
			
			$cost 					=	$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>4));
			$data['freeShip']		=	$cost['business_account'];

			//view
			$this->load->view('index/header', $data);
			$this->load->view('index/cart/cart', $data);
			$this->load->view('index/footer', $data);
		}else{
			$_SESSION['url']	=	'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}		
	}
	//計算小計ajax
	public function ajax_count(){
		$prd_id = str_replace('_','##*',($_POST['prd_id']));
		$qty = $_POST['qty'];
		$_SESSION['join_car'][$prd_id] = $qty;
		$by_id=$_SESSION['MT']['by_id'];
		$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));		
		$price	=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
		$productsDetail = $this->products_model->productsDetail($prd_id,$bdata['d_spec_type']);
		$dbdata			= $productsDetail['data'];
		$data=number_format($dbdata[$price]*$qty,2);
		echo $data;
	}

	//計算總額.紅利ajax
	public function total_all(){
		$use_dividend	=	$_POST['use_dividend'];
		$joinProducts	=	$_SESSION['join_car'];
		$by_id 			=	$_SESSION['MT']['by_id'];
		$bdata			=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));		
		$price			=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
		$dataTotal		=	0;
		foreach ($joinProducts as $key => $value) {
			$productsDetail		=	$this->products_model->productsDetail($key,$bdata['d_spec_type']);
			$totalData			=	$productsDetail['data'];
			$dataTotal			=	($totalData[$price]*$value)+$dataTotal;			
		}
		$data['dataTotal']			=	number_format($dataTotal,2);
		$config 					=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
		$dividendTurn				=	(int)$config['d_val'];
		$_SESSION['use_dividend']	=	$use_dividend;	
		$use_dividend_cost			=	$use_dividend/$dividendTurn;
		$data['only_money']			=	number_format($dataTotal-$use_dividend_cost,2);

		//紅利
		$config 			= $this->mymodel->OneSearchSql('config','d_val',array('d_id'=>73));
		$config['d_val']	= ($config['d_val'])/100;
		$data['dataBonus']	= $dataTotal*$config['d_val'];
		echo json_encode($data);
	}

	//刪除商品ajax
	public function ajax_delete(){
		$prd_id = $_POST['prd_id'];		
		$prd_id = str_replace('_','##*',($_POST['prd_id']));
		unset($_SESSION['join_car'][$prd_id]);
		//$this->useful->AlertPage('/cart/','刪除完成');
	}
	
	//購物車 AJAX 同會員資料
	public function get_member(){
	    $id=$_POST['bid'];	    
		$type=$_POST['type'];
		$dbdata=$this->mymodel->OneSearchSql('buyer','name,mobile,by_email,city,countory,country,address',array('by_id'=>$id));
		$cdata=$this->mymodel->OneSearchSql('city_category','s_id,s_name',array('s_id'=>$dbdata['city']));
		$codata=$this->mymodel->OneSearchSql('city_category','s_zipcode,s_id,s_name',array('s_id'=>$dbdata['countory']));
		$dbdata['countory_id']=$codata['s_id'];
		$dbdata['zipcode']=$codata['s_zipcode'];
		echo json_encode($dbdata);
	}
	//購物車 AJAX 同會員資料(地址)	
	public function ajax_area(){
		//語言包
		$this->lang=$this->lmodel->config('22',$this->setlang);
		$data['country']	=	"<select name='country' id='country' onChange='";
		$data['country']	.=	'sel_area(this.value,"","city")';
		$data['country']	.=	"' class='form-control'><option value='0'>".$this->lang["c_22"]."</option>";//請選擇國家
		$data['city']		=	"<select name='city' id='city' onChange='";
		$data['city']		.=	'sel_area(this.value,"","countory")';
		$data['city']		.=	"' class='form-control'><option value='0'>".$this->lang["c_23"]."</option>";//請選擇縣市
		$data['countory']	=	'<select name="countory" id="countory" class="form-control"><option value="0">'.$this->lang["c_24"].'</option>';//請選擇鄉鎮
		$country 			=	$_POST['country'];
		$city 				=	$_POST['city'];		
		$countory 			=	$_POST['countory'];
			$country_arr 			=	$this->mymodel->get_area_data(0);
			foreach ($country_arr as $cvalue) {
				$selected 			=	($cvalue['s_id']==$country)?'selected':'';
				$data['country']	.=	"<option value='".$cvalue['s_id']."' " .$selected.">".$cvalue['s_name']."</option>";
			}
			$data['country']		.="</select>";
		if(!empty($country)){
			$city_arr 				=	$this->mymodel->get_area_data("$country");
			foreach ($city_arr as $cvalue2) {
				$selected 			=	($cvalue2['s_id']==$city)?'selected':'';
				$data['city']		.=	"<option value='".$cvalue2['s_id']."' " .$selected.">".$cvalue2['s_name']."</option>";
			}
			$data['city']			.="</select>";
		}
		if(!empty($countory)){
			$countory_arr 			 =	$this->mymodel->get_area_data("$city");
			foreach ($countory_arr as $cvalue3) {
				$selected 			=($cvalue3['s_id']==$countory)?'selected':'';
				$data['countory']	.=	"<option value='".$cvalue3['s_id']."' " .$selected.">".$cvalue3['s_name']."</option>";
			}
			$data['countory'] 		.="</select>";
		}		
		echo json_encode($data);
	}

	//選擇常用地址ajax
	public function ajax_common_address(){		
		$address_id		=	$_POST['address_id'];
		$address 		=	$this->mymodel->OneSearchSql('address','name,telphone,country,city,countory,address',array('d_id'=>$address_id));
		$dataAddress['name']		=	$address['name'];
		$dataAddress['telphone']	=	$address['telphone'];
		$dataAddress['address']		=	$address['address'];
		$dataAddress['country']		=	"<select name='country' id='country' onChange='";
		$dataAddress['country']		.=	'sel_area(this.value,"","city")';
		$dataAddress['country']		.=	"' class='form-control'>";
		$dataAddress['city']		=	"<select name='city' id='city' onChange='";
		$dataAddress['city']		.=	'sel_area(this.value,"","countory")';
		$dataAddress['city']		.=	"' class='form-control'>";
		$dataAddress['countory']	=	'<select name="countory" id="countory" class="form-control">';	
		if(!empty($address['country'])){
			$country_arr 			=	$this->mymodel->get_area_data();
			foreach ($country_arr as $cvalue) {
				$selected 				=	($cvalue['s_id']==$address['country'])?'selected':'';
				$dataAddress['country']	.=	"<option value='".$cvalue['s_id']."' " .$selected.">".$cvalue['s_name']."</option>";
			}
			$dataAddress['country']	.="</select>";
		}
		if(!empty($address['city'])){
			$city_arr 			=	$this->mymodel->get_area_data($address['country']);
			foreach ($city_arr as $cvalue2) {
				$selected 		=	($cvalue2['s_id']==$address['city'])?'selected':'';
				$dataAddress['city']	.=	"<option value='".$cvalue2['s_id']."' " .$selected.">".$cvalue2['s_name']."</option>";
			}
			$dataAddress['city']	.="</select>";
		}
		if(!empty($address['countory'])){
			$countory_arr 			=	$this->mymodel->get_area_data($address['city']);
			foreach ($countory_arr as $cvalue3) {
				$selected 		=	($cvalue3['s_id']==$address['countory'])?'selected':'';
				$dataAddress['countory']	.=	"<option value='".$cvalue3['s_id']."' " .$selected.">".$cvalue3['s_name']."</option>";
			}
			$dataAddress['countory']	.="</select>";
		}
		echo json_encode($dataAddress);
	}

	//選擇取貨門市ajax
	public function ajax_shop(){		
		$shop ='<select name="shop_id" id="shop_id" class="form-control">';
		$member=$this->mymodel->select_page_form('member','','member_id, shop_address',array('is_shop'=>1));
		foreach ($member as $value) {
			$shop.='<option value='.$value['member_id'].'>'.$value['shop_address'].'</option>';
		}
        $shop.='</select>';
		echo $shop;
	}

	//結帳頁面
	public function cart_checkout()
	{
		// 判斷是否登入
		// 語言包
		$this->lang=$this->lmodel->config('22',$this->setlang);
		if($_SESSION['MT']['is_login']==1)
		{
			if(empty($_POST['by_id'])){//防呆,直接點入此頁面會跳轉購物車
				$this->useful->AlertPage('/cart');
			}
			$data['logistics_way']=$this->mymodel->OneSearchSql('logistics_way','lway_name,lway_id',array('lway_id'=>$_POST['lway_id']));
			$data['payment_way']=$this->mymodel->OneSearchSql('payment_way','pway_name,pway_id',array('pway_id'=>$_POST['pway_id']));
			$data['buyer_name']		=	$_POST['buyer_name'];
			$data['buyer_email']	=	$_POST['buyer_email'];
			$data['buyer_phone']	=	$_POST['buyer_phone'];
			$country				=	$this->mymodel->OneSearchSql('city_category','s_name',array('s_id'=>$_POST['country']));
			$data['country']		=	$country['s_name'];
			$county 				=	$this->mymodel->OneSearchSql('city_category','s_name',array('s_id'=>$_POST['city']));
			$data['county']			=	$county['s_name'];
			$area 					=	$this->mymodel->OneSearchSql('city_category','s_name',array('s_id'=>$_POST['countory']));
			$data['area']			=	$area['s_name'];
			$data['buyer_address']	=	$_POST['buyer_address'];
			$data['shop_id']		=	$_POST['shop_id'];
			$data['use_dividend']	=	$use_dividend	=	$_SESSION['use_dividend'];

			$this->data['banner'] = $this->banner_model->getMyAd();
			//推薦人
			$data['by_id']= $by_id = $_SESSION['MT']['by_id'];
			$buyer= $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
			$data['d_dividend']	= $buyer['d_dividend'];
			$PID	=	$buyer['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';

			$data['banner']=$this->data['banner'];
			$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$data['by_id']));//會員是否VIP
			//撈出購物車的商品
			$join_car	=	$_SESSION['join_car'];
			$price	=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';			
			$data['PriceSum']=0;
			foreach ($join_car as $key => $value) {				
				$productsDetail					=	$this->products_model->productsDetail($key,$bdata['d_spec_type']);
				$dbdata							=	$productsDetail['data'];
				$productList[$key]['num']		=	$value;
				$productList[$key]['prd_name']	=	$dbdata['prd_name'];
				$productList[$key]['spec']		=	$key;
				$productList[$key]['spec_name']	=	substr($key,strpos($key,'##*')+3);
				$productList[$key]['prd_image']	=	$dbdata['prd_image'];
				$productList[$key]['price']		=	$dbdata[$price];
				$productList[$key]['total']		=	$value*$dbdata[$price];
				$data['PriceSum']				=	$productList[$key]['total']+$data['PriceSum'];
			}
			$data['productList']	=	$productList;
			$data['Spath']			=	$this -> Spath;
			$data['totalPrice']		=	$dataTotal	=	$data['PriceSum'];			
			//紅利
			$config 			= $this->mymodel->OneSearchSql('config','d_val',array('d_id'=>73));
			$config['d_val']	= ($config['d_val'])/100;
			$data['bonus']		= $data['totalPrice']*$config['d_val'];
			//若未滿免運金額&選擇宅配,再加運費
			$cost=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>4));
			$data['freeShip']	=	$cost['business_account'];
			if($data['PriceSum'] < $data['freeShip'] and $_POST['lway_id']<>5){
				$ship_cost=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>$_POST['lway_id']));
				$data['ship_cost'] ="<tr><td>運費小計</td><td>".$ship_cost['business_account']."</td></tr>";
				$data['totalPrice']	=$data['totalPrice']+$ship_cost['business_account'];
			}
			$config 				=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
			$dividendTurn			=	(int)$config['d_val'];
			$use_dividend_cost		=	$use_dividend/$dividendTurn;
			$data['only_money']		=	number_format($dataTotal-$use_dividend_cost,2);


			$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>';
			//門市取貨
			if(!empty($data['shop_id'])){
				$member=$this->mymodel->OneSearchSql('member','shop_address',array('member_id'=>$data['shop_id']));
				$data['shop_address']=$member['shop_address'];
			}
			//view
			$this->load->view('index/header', $data);
			$this->load->view('index/cart/cart_checkout', $data);
			$this->load->view('index/footer', $data);
		}else{
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}

	//交易成功
	public function cart_checkout_ok()	
	{
		//語言包
		$this->lang=$this->lmodel->config('22',$this->setlang);

		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{
			if(empty($_POST['by_id'])||empty($_SESSION['join_car'])){//防呆,直接點入此頁面會跳轉購物車
				$this->useful->AlertPage('/cart/cart_checkout');
			}			
			$data['use_dividend']	=	$use_dividend	=	$_SESSION['use_dividend'];			
			//推薦人
			$by_id	=	$_SESSION['MT']['by_id'];
			$buyer  = $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
			$PID	=	$buyer['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			$this->data['banner'] = $this->banner_model->getMyAd();
			$data['by_id']=	$by_id =	$_SESSION['MT']['by_id'];
			$data['banner']=$this->data['banner'];			
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
	
	        $data['atm']=$this->mymodel->GetConfig('atm');

			$config 				=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
			$dividendTurn			=	(int)$config['d_val'];
			$use_dividend_cost		=	$use_dividend/$dividendTurn;
			$price_money			=	$totalPrice-$use_dividend_cost;
			$pid  =	$bdata['PID'];
			$member=$this->mymodel->OneSearchSql('member','member_id',array('by_id'=>$pid));
			$account  		=	$member['member_id'];
			$atmpayment='';
			
			if($_POST['pway_id']==4){	//繳款期限 目前暫時給他五天
				$atmpayment 		= date("Y-m-d",strtotime("+5 day"));
				$data['trade_year']	= date("Y",strtotime($atmpayment));
				$data['trade_month']= date("m",strtotime($atmpayment));
				$data['trade_day']	= date("d",strtotime($atmpayment));
			}
			$post_arr						=	$_POST;
			$order_data['account']			=	$account;
			$order_data['priceSum']			=	$priceSum;
			$order_data['bonus']			=	$bonus;
			$order_data['totalPrice']		=	$totalPrice;
			$order_data['price_money']		=	$price_money;
			$order_data['use_dividend']		=	$use_dividend;
			$order_data['use_dividend_cost']=	$use_dividend_cost;
			$order_data['shipCost']			=	$shipCost;
			$order_data['atmpayment']		=	$atmpayment;

			if(!empty($priceSum)){
				$oid = $this->cart_model->insertOrder($post_arr,$order_data);
				$data['order_id']	=	$order_id =	$this->useful->get_order_num($oid);
				$this->cart_model->insertOrderDetail($oid, $order_id, $post_arr, $productList,$priceSum);
				$prd_name=implode(',',$prd_name);
				$redata=array(
					'OID'=>$oid,
					'buyer_id'=>$by_id,
					'd_type'=>'19',
					'd_val'=>$bonus,
					'd_des'=>'訂單號碼 ['.$order_id.']  - 商品：'.$prd_name,
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
						'd_des'=>'訂單號碼 ['.$order_id.']  - 商品：'.$prd_name,
						'is_send'=>'Y',
						'create_time'=>$this->useful->get_now_time(),
						'update_time'=>$this->useful->get_now_time(),
					);
					$this->mymodel->insert_into('dividend',$usedata);
				}
				// 紀錄訂單寄信				
				$timer=time();
				$this->order_mail($order_id, $_POST['pway_id'], $_POST['buyer_email'], $productList,$timer);
			}

			$shop=$this->mymodel->OneSearchSql('member','d_name, shop_address',array('member_id'=>$_POST['shop_id']));
			$data['shop_name']=$shop['d_name'];
			$data['shop_address']=$shop['shop_address'];
			$data['oid']=$oid;
			//新增完畢清掉購物車&使用紅利
			unset($_SESSION['join_car']);
			unset($_SESSION['use_dividend']);
			$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>';

			if($_POST['pway_id']==9){//支付寶		
				$_SESSION['alipay']['order_id']	=	$order_id;
				$_SESSION['alipay']['prd_name']	=	$prd_name;
				$_SESSION['alipay']['price_money']	=	$price_money;
				$this->useful->AlertPage('/alipay/pay');				
			}else{
				//view
				$this->load->view('index/header', $data);
				$this->load->view('index/cart/cart_checkout_ok', $data);
				$this->load->view('index/footer', $data);
			}
		}else{			
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}		
	}

	// 錯誤頁面
	public function error($cset_code='')
	{
		$language = $this -> language;
		if($cset_code != '')
		{
			$this->myredirect('/cart/store/'.$cset_code, $language['SuchPage'], 8);
			return 0;
		}
		else
		{
			redirect('/index/error');
		}
	}

	// 基本設定
	public function store_setting()
	{
		$language = $this -> language;

		// 判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			// 未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			// data
			$data = $this -> data;

			// language
				$this -> lang -> load('views/cart/store_setting', $data['lang']);
				$data['FillReceiveMailFunction'] = lang('FillReceiveMailFunction');
				$data['NeedContentBased'] = lang('NeedContentBased');
				$data['PhoneAboveBannerImage_1'] = lang('PhoneAboveBannerImage_1');
				$data['WebAboveBannerImage_1'] = lang('WebAboveBannerImage_1');
				$data['ButtonsNameCards_1'] = lang('ButtonsNameCards_1');
				$data['ShopButtonName_1'] = lang('ShopButtonName_1');
				$data['FooterMailbox_1'] = lang('FooterMailbox_1');
				$data['WantReplaceGood_1'] = lang('WantReplaceGood_1');
				$data['WriteContact_2'] = lang('WriteContact_2');
				$data['AboveBannerImage_2'] = lang('AboveBannerImage_2');
				$data['LogisticsSet_2'] = lang('LogisticsSet_2');
				$data['CashFlowSetting_2'] = lang('CashFlowSetting_2');
				$data['SystemWillSendLetter_2'] = lang('SystemWillSendLetter_2');
				$data['MobileStoreName_2'] = lang('MobileStoreName_2');
				$data['SenderName_3'] = lang('SenderName_3');
				$data['ShippingEdit_3'] = lang('ShippingEdit_3');
				$data['PictureSize1200_3'] = lang('PictureSize1200_3');
				$data['PictureSize2000_3'] = lang('PictureSize2000_3');
				$data['InterfaceDescription'] = lang('InterfaceDescription');
				$data['Yuan'] = lang('Yuan');
				$data['CompanyName'] = lang('CompanyName');
				$data['ShareButton'] = lang('ShareButton');
				$data['InstallmentPeriods_No'] = lang('InstallmentPeriods_No');
				$data['_PhoneLogo'] = lang('_PhoneLogo');
				$data['PhoneNumber'] = lang('PhoneNumber');
				$data['LocalCalls'] = lang('LocalCalls');
				$data['DeliveryWorkingDays'] = lang('DeliveryWorkingDays');
				$data['ReceiverMail'] = lang('ReceiverMail');
				$data['_ActionStore'] = lang('_ActionStore');
				$data['EndViewCompanyName'] = lang('EndViewCompanyName');
				$data['EndViewCompanyNumber'] = lang('EndViewCompanyNumber');
				$data['EndViewCompanyPhone'] = lang('EndViewCompanyPhone');
				$data['EndViewCompanyAddress'] = lang('EndViewCompanyAddress');
				$data['StoreBasicSettings'] = lang('StoreBasicSettings');
				$data['RemoveStoreIcon'] = lang('RemoveStoreIcon');
				$data['OnlyTaiwan'] = lang('OnlyTaiwan');
				$data['SystemCashFlowSeries'] = lang('SystemCashFlowSeries');
				$data['SystemLogisticsInformation'] = lang('SystemLogisticsInformation');
				$data['LogisticsSet'] = lang('LogisticsSet');
				$data['CashFlowSetting'] = lang('CashFlowSetting');
				$data['GoStoreAction'] = lang('GoStoreAction');
				$data['SuggestStayInformation'] = lang('SuggestStayInformation');
				$data['ButtonName'] = lang('ButtonName');
				$data['NotTakeRecord'] = lang('NotTakeRecord');
				$data['Service'] = lang('Service');
				$data['StoreLogo'] = lang('StoreLogo');
				$data['StoreButtonNoShow'] = lang('StoreButtonNoShow');
				$data['StoreButtonShow'] = lang('StoreButtonShow');
				$data['ShopSettings'] = lang('ShopSettings');
				$data['ShopIconUpload'] = lang('ShopIconUpload');
				$data['StoreDisplay'] = lang('StoreDisplay');
				$data['StoresNotEnabled'] = lang('StoresNotEnabled');
				$data['InvoiceSend'] = lang('InvoiceSend');
				$data['InvoiceSendEmail'] = lang('InvoiceSendEmail');
				$data['OnOpen'] = lang('OnOpen');
				$data['ShippingInstructions'] = lang('ShippingInstructions');
				$data['ShippingEditInstructions'] = lang('ShippingEditInstructions');
				$data['phone888'] = lang('phone888');
				$data['Size1200'] = lang('Size1200');
				$data['Size2000'] = lang('Size2000');
				$data['ClickCopy'] = lang('ClickCopy');
				$data['IndustryApplication'] = lang('IndustryApplication');
				$data['Cheng'] = lang('Cheng');
				$data['Save'] = lang('Save');
				$data['SavePhoneNum'] = lang('SavePhoneNum');
				$data['SaveLocalCalls'] = lang('SaveLocalCalls');
				$data['SaveEmail'] = lang('SaveEmail');
				$data['_SaveButtonName'] = lang('_SaveButtonName');
				$data['SaveEditContent'] = lang('SaveEditContent');
				$data['SaveAddress'] = lang('SaveAddress');
				$data['WaysContact'] = lang('WaysContact');
				$data['ContactAddress'] = lang('ContactAddress');
				$data['_BuyExplanation'] = lang('_BuyExplanation');
				$data['BuyExplanationEdit'] = lang('BuyExplanationEdit');
				$data['CloseIn'] = lang('CloseIn');
				$data['WelcomeSystem'] = lang('WelcomeSystem');
				$data['ShowButtonName'] = lang('ShowButtonName');
				$data['Invoice'] = lang('Invoice');
				$data['SaveCompany'] = lang('SaveCompany');
				//啟動中，關閉
				$data['Edit_Start_in'] = lang('Edit_Start_in');
				$data['Edit_Close'] = lang('Edit_Close');

			$upload = '';
			switch ($this -> data['lang']) {
				case 'zh-tw':
					$lang_number = '1';
					break;
				case 'zh-cn':
					$lang_number = '2';
					break;
				case 'english':
					$lang_number = '3';
					break;
			}
			// payment_way : 撈取當下能用的付款方式(由超管設定)
			$data['payment_way'] = $payment_way = $this->mod_cart->select_from_order('payment_way', 'pway_id', 'asc', array('active'=>1));
			// logistics_way : 撈取當下能使用的物流付款方式(由超管設定)
			$data['logistics_way'] = $logistics_way = $this -> mod_cart -> select_from_order('logistics_way', 'lway_id', asc, array('active' => 1));

			// 上傳 web_logo & del web_logo
			if($_FILES['cset_logo'])
			{
				if($_FILES['cset_logo']['error'] != 4)
				{
					$member = $this -> mod_cart -> select_from('member', array('member_id' => $this -> session -> userdata('member_id')));
					$path = $member['img_url'].'products';
					if (!file_exists('.'.$path)) {
						@mkdir('.'.$path, 0777);
					}
					$file = $this -> mod_cart -> upload_pic($_FILES['cset_logo'], './'.$path.'/','logo');
					$file['path'] = str_ireplace("./", "", $file['path']);
					$this -> mod_cart -> update_set('iqr','member_id', $this->session->userdata('member_id'), array('cart_logo_url' => $file['path']));
					$upload = 'suc';
				}
			}
			if($this-> input -> post('del_cset_logo'))
			{
			    $this -> mod_cart -> update_set('iqr','member_id', $this->session->userdata('member_id'), array('cart_logo_url' => NULL));
				$upload='del';
			}
			// 上傳 mobile_logo & del mobile_logo
			if($_FILES['mobile_logo'])
			{
				if($_FILES['mobile_logo']['error'] != 4)
				{
					$member = $this -> mod_cart -> select_from('member', array('member_id' => $this -> session -> userdata('member_id')));
					$path = $member['img_url'].'products';
					$file = $this -> mod_cart -> upload_pic($_FILES['mobile_logo'], './'.$path.'/','mobile_logo');
					$file['path'] = str_ireplace("./", "", $file['path']);
					$this -> mod_cart -> update_set('iqr','member_id', $this->session->userdata('member_id'), array('cart_mobile_logo_url' => $file['path']));
					$upload = 'suc';
				}
			}
			if($this-> input -> post('del_mobile_logo'))
			{
			    $this -> mod_cart -> update_set('iqr','member_id', $this->session->userdata('member_id'), array('cart_mobile_logo_url' => NULL));
				$upload='del';
			}

			if($this->input->post('setting_type') == '')
			{
				// cart setting
				$data['setting'] = $setting = $this->mod_cart->select_from('iqr_cart', array('member_id'=>$this->session->userdata('member_id')));
				$data['iqr'] = $iqr = $this -> mod_cart -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));

				// 系統啟用的付款方式
				foreach($payment_way as $key => $value)
				{
					// 使用者啟用的付款方式
					$iqr_trans = $this->mod_cart->select_from('iqr_trans', array('cset_id'=>$setting['cset_id'], 'pway_id'=>$value['pway_id']));
					$data['iqr_trans'][] = $iqr_trans;

					// 金流設定
					$data['pway_active_name'][$key]  = ($iqr_trans['active'] == 1) ? $language['ShutDown'] : $language['Enable'];		// 變更狀態按鈕文字
					$data['pway_active'][$key]  	 = ($iqr_trans['active'] == 1) ? $language['EnableIn'] : $language['CloseIn'];		// 金流狀態提示
					$data['pway_active_class'][$key] = ($iqr_trans['active'] == 1) ? 'aa3' : 'aa6';				// 金流css class名稱
					$data['business_account'][$key]  = $iqr_trans['business_account'];							// 金流帳戶參數
					// $data['business_hashkey'][$key]  = $iqr_trans['business_hashkey'];
					// $data['business_hashiv'][$key]   = $iqr_trans['business_hashiv'];
					if($iqr_trans['pway_id'] == 5)
						$credit = $iqr_trans['creditinstallment'];

					// payment_way info
					$data['pway_id'][$key]  		 = $value['pway_id'];
					$data['pway_name'][$key]  		 = $value['pway_name_' . $lang_number];
					$data['pway_code'][$key]  		 = $value['pway_code'];
					$data['custome_account'][$key]   = $value['custome_account'];
					$data['pway_placeholder'][$key]  = $value['custome_account_placeholder_' . $lang_number];
				}

				// Allpay 分期期數
				$data['select_credit'][] = '0';
				$data['select_credit'][] = '3';
				$data['select_credit'][] = '6';
				$data['select_credit'][] = '12';
				$data['select_credit'][] = '18';
				$data['select_credit'][] = '24';
				$data['selected_credit'][$credit] = 'selected';

				// 系統啟用的物流方式
				foreach ($logistics_way as $log_key => $log_value)
				{
					$iqr_logistics = $this -> mod_cart -> select_from('iqr_logistics', array('cset_id' => $setting['cset_id'], 'lway_id' => $log_value['lway_id']));
					$data['iqr_logistics'][] = $iqr_logistics;

					// 物流設定
					$data['lway_active_name'][$log_key]  = ($iqr_logistics['active'] == 1) ? $language['SetClose'] : $language['SetEnable'];	// 變更狀態按鈕文字
					$data['lway_active'][$log_key]  	 = ($iqr_logistics['active'] == 1) ? $language['EnableIn'] : $language['CloseIn'];		// 金流狀態提示
					$data['lway_active_class'][$log_key] = ($iqr_logistics['active'] == 1) ? 'aa3' : 'aa6';				// 金流css class名稱
					$data['lway_business_account'][$log_key]  = $iqr_logistics['business_account'];						// 金流帳戶參數

					// logistics_way info
					$data['lway_id'][$log_key]  		 = $log_value['lway_id'];
					$data['lway_name'][$log_key]  		 = $log_value['lway_name_' . $lang_number];
					$data['lway_code'][$log_key]  		 = $log_value['lway_code_' . $lang_number];
					$data['lway_account'][$log_key]      = $log_value['custome_account'];
					$data['lway_placeholder'][$log_key]  = $log_value['custome_account_placeholder_' . $lang_number];
				}

				if(!empty($setting))
				{
					if($setting['cset_active'] == 1)
					{ // 顯示關閉按鈕
						$data['cset_active_open_show']  = 'display:none;';
						$data['cset_active_close_show'] = 'display:inline-block;';
						$data['cset_name_td_show']      = '';
						$data['cset_email_td_show']     = '';
						$data['cset_company_td_show']   = '';
						$data['cset_address_td_show']   = '';
						$data['cset_telphone_td_show']  = '';
						$data['cset_mobile_td_show']    = '';
						$data['cset_share_td_show']     = '';
						$data['cset_logo_td_show']      = '';
						$data['mobile_logo_td_show']    = '';
						$data['cset_receipt_td_show']   = '';
					}
					else
					{ // 顯示開啟按鈕
						$data['cset_active_open_show']     = 'display:inline-block;';
						$data['cset_active_close_show']    = 'display:none;';
						$data['cset_logistics_close_show'] = 'display:none;';
						$data['cset_name_td_show'] 		   = 'display:none;';
						$data['cset_email_td_show'] 	   = 'display:none;';
						$data['cset_company_td_show']      = 'display:none;';
						$data['cset_address_td_show']      = 'display:none;';
						$data['cset_telphone_td_show']     = 'display:none;';
						$data['cset_mobile_td_show']       = 'display:none;';
						$data['cset_share_td_show']        = 'display:none;';
						$data['cset_logo_td_show']         = 'display:none;';
						$data['mobile_logo_td_show']       = 'display:none;';
						$data['cset_receipt_td_show']      = 'display:none;';
					}

					if($setting['cset_share_btn'] == 1)
					{
						$data['cset_share_open_show']  = 'display:none;';
						$data['cset_share_close_show'] = 'display:inline-block;';
					}
					else
					{
						$data['cset_share_open_show']  = 'display:inline-block;';
						$data['cset_share_close_show'] = 'display:none;';
					}

					if($setting['cset_receipt_btn'] == 1)
					{
						$data['cset_receipt_open_show']  = 'display:none;';
						$data['cset_receipt_close_show'] = 'display:inline-block;';
					}
					else
					{
						$data['cset_receipt_open_show']  = 'display:inline-block;';
						$data['cset_receipt_close_show'] = 'display:none;';
					}


					$data['iqr_trans_td_show']  = true;
					$data['iqr_logistics_td_show'] = true;
				}
				else
				{ // 沒有資料顯示開啟按鈕
					// get click
					if($this->input->get('start'))
						$data['click_start'] = 1;

					$data['cset_active_open_show']     = 'display:inline-block;';
					$data['cset_active_close_show']    = 'display:none;';
					$data['cset_logistics_open_show']  = 'display:inline-block;';
					$data['cset_logistics_close_show'] = 'display:none;';
					$data['cset_name_td_show'] 		   = 'display:none;';
					$data['cset_email_td_show'] 	   = 'display:none;';
					$data['cset_company_td_show']      = 'display:none;';
					$data['cset_address_td_show']      = 'display:none;';
					$data['cset_telphone_td_show']     = 'display:none;';
					$data['cset_mobile_td_show']       = 'display:none;';
					$data['cset_share_td_show']        = 'display:none;';
					$data['iqr_trans_td_show'] 		   = false;
					$data['iqr_logistics_td_show']     = false;
				}
				// view
				$this->load->view('cart/store_setting', $data);
			}
			else
			{
				$st  		= $this->input->post('setting_type'); 			// 修改對象
				$mid  		= $this->session->userdata('member_id'); 		// member_id
				$cset_code  = $this->mod_cart->make_random_cset_code(12); 	// cset_code
				$iqr_cart   = $this->mod_cart->select_from('iqr_cart', array('member_id'=>$mid)); // 設定檔

				$email_error = false;

				// exist check
				$check_cart_exist = $this->mod_cart->select_from('iqr_cart', array('member_id' => $mid));
				if(empty($check_cart_exist))
				{ // 新增
					$cset_code = $this->mod_cart->make_random_cset_code(12);

					$cart_data = array(
						'member_id'		 => $mid,
						'cset_code'		 => $cset_code,
						'cset_name'		 => $language['ActionStore'],
						'cset_active'	 => 0
					);
					$cart_id = $this->mod_index->insert_into('iqr_cart', $cart_data);

					// 新增付款方式到 iqr_trans 對應 cset_id
					$payment_way = $this->mod_cart->select_from_order('payment_way', 'pway_id', 'asc', array('active'=>1));
					foreach($payment_way as $key => $value)
					{
						$insert_data = array(
							'cset_id' 	=> $cart_id,
							'pway_id'	=> $value['pway_id'],
							'active'	=> $value['default_active']
						);
						$iqrt_id = $this->mod_cart->insert_into('iqr_trans', $insert_data);
					}
					// 新增物流方式
					$logistics_way = $this -> mod_cart -> select_from_order('logistics_way', 'lway_id', 'asc', array('active' => 1));
					foreach ($logistics_way as $key => $value)
					{
						$insert_logistics = array(
							'cset_id'	=> $cart_id,
							'lway_id'	=> $value['lway_id'],
							'active'	=> $value['default_active']
						);
						$logistics_id = $this->mod_cart->insert_into('iqr_logistics', $insert_logistics);
					}
				}

				switch ($st)
				{
					case 0:
						# code for set 運送規則
						$this->mod_cart->update_set('iqr_cart', 'member_id', $mid, array('cset_ship'=>$this->input->post('cset_ship')));
						break;
					case 1:
						# code for set 購買說明
						$this->mod_cart->update_set('iqr_cart', 'member_id', $mid, array('cset_paid'=>$this->input->post('cset_paid')));
						break;
					case 2:
						# code for set 金流設定
						if($this->input->post('iqrt_id') != FALSE)
						{
							$iqr_trans   = $this->mod_cart->select_from('iqr_trans', array('iqrt_id'=>$this->input->post('iqrt_id')));
							$iqrt_active = $iqr_trans['active'];
							$active  	 = ($iqr_trans['active'] == 1) ? 0 : 1;
							$this->mod_cart->update_set('iqr_trans', 'iqrt_id', $this->input->post('iqrt_id'), array('active'=>$active));
						}
						break;
					case 3:
						# code for set 商店設定
						$cset_active = $this->input->post('cset_active');
						$cset_name   = ($this->input->post('cset_name') == '') ? $language['StorePage'] : $this->input->post('cset_name');
						$this->mod_cart->update_set('iqr_cart', 'member_id', $mid, array('cset_name'=>$cset_name, 'cset_active'=>$cset_active));
						break;
					case 4:
						if($this->input->post('cset_value') != "")
						{
							$email = preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $this->input->post('cset_value'));
							if($email)
								$this->mod_cart->update_set('iqr_cart', 'member_id', $mid, array('cset_email'=>$this->input->post('cset_value')));
							else
							{
								echo '信箱格式錯誤';
								$email_error = true;
							}
						}
						else
						{
							$this->mod_cart->update_set('iqr_cart', 'member_id', $mid, array('cset_email' => NULL));
						}
						break;
					case 5:
						# 收款帳戶設定
						if($this->input->post('iqrt_id') !== FALSE && $this->input->post('business_account'))
						{
							$this->mod_cart->update_set('iqr_trans', 'iqrt_id', $this->input->post('iqrt_id'), array('business_account'=>$this->input->post('business_account'),'creditinstallment'=>$this->input->post('creditinstallment')));
						}
						break;
					case 6:
						# Cart Footer 公司名稱設定
						if($this -> input -> post('company_value') != '')
							$this -> mod_cart -> update_set('iqr_cart','member_id', $mid, array('cset_company' => $this->input->post('company_value')));
						else
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_company' => NULL));
						break;
					case 7:
						# Cart Footer 地址設定
						if($this -> input -> post('address_value') != '')
							$this -> mod_cart -> update_set('iqr_cart','member_id', $mid, array('cset_address' => $this->input->post('address_value')));
						else
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_address' => NULL));
						break;
					case 8:
						# Cart Footer 電話設定
						if($this -> input -> post('telphone_value') != '')
							$this -> mod_cart -> update_set('iqr_cart','member_id', $mid, array('cset_telphone' => $this->input->post('telphone_value')));
						else
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_telphone' => NULL));
						break;
					case 9:
						# Cart Footer 手機設定
						if($this -> input -> post('mobile_value') != '')
							$this -> mod_cart -> update_set('iqr_cart','member_id', $mid, array('cset_mobile' => $this->input->post('mobile_value')));
						else
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_mobile' => NULL));
						break;
					case 10:
						# 物流運費設定
						if($this->input->post('iqrt_id') != false)
							$this -> mod_cart -> update_set('iqr_logistics', 'iqrt_id', $this -> input -> post('iqrt_id'), array('business_account' => $this -> input -> post('lway_count')));
						break;
					case 11:
						# 物流開關
						if($this->input->post('iqrt_id') != false)
						{
							$iqrt_id = $this -> input -> post('iqrt_id');
							$iqr_logistics = $this -> mod_cart -> select_from('iqr_logistics', array('iqrt_id' => $iqrt_id));
							$lway_active = $iqr_logistics['active'];
							$active = ($lway_active == 1) ? 0 : 1;
							$this -> mod_cart -> update_set('iqr_logistics', 'iqrt_id', $iqrt_id, array('active' => $active));
						}
						break;
					case 12:
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_share_btn' => $this -> input -> post('share_active')));
						break;
					case 13:
							$this -> mod_cart -> update_set('iqr_cart', 'member_id', $mid, array('cset_receipt_btn' => $this -> input -> post('receipt_active')));
						break;
				}

				if($st == 3 && $cset_active == 0)
					echo $language['StoreClosingsCompleted'];
				else
				{
					if(!$email_error)
					{
						if($st == 2)
							echo $language['EditSuccess'].$iqrt_active;
						elseif($st == 11 && $active == 0)
							echo 'close-logistics';
						else
							echo '編輯成功';
					}
					else
						echo ', '.$language['EditFailed'];
				}
			}
			if($upload == 'del')
			{
				$upload = '';
				$this -> script_message($language['LogoPictureDel'],'/cart/store_setting');
			}
			if($upload == 'suc')
			{
				$upload = '';
				$this -> script_message($language['UploadLogoSuccess'],'/cart/store_setting');
			}
		}
	}

	// 商品管理主頁
	public function cart_management()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			// language
				$this -> lang -> load('views/cart/index', $data['lang']);
				$data['ClassificationEmptied_1'] = lang('ClassificationEmptied_1');
				$data['SettingProduct_2'] = lang('SettingProduct_2');
				$data['BatchProcessing_3'] = lang('BatchProcessing_3');
				$data['HotProducts_4'] = lang('HotProducts_4');
				$data['Search_5'] = lang('Search_5');
				$data['InterfaceDescription'] = lang('InterfaceDescription');
				$data['ClassNumUpperLimit'] = lang('ClassNumUpperLimit');
				$data['PleaseSetHotProduct'] = lang('PleaseSetHotProduct');
				$data['RemoveCommodity'] = lang('RemoveCommodity');
				$data['Inquire'] = lang('Inquire');
				$data['_Product_Search'] = lang('_Product_Search');
				$data['NewProduct'] = lang('NewProduct');
				$data['NewProductClass'] = lang('NewProductClass');
				$data['ScanProductName'] = lang('ScanProductName');
				$data['ScanSearchProduct'] = lang('ScanSearchProduct');
				$data['ShoppingCart'] = lang('ShoppingCart');
				$data['CartProductManagement'] = lang('CartProductManagement');
				$data['GoShtoppingCart'] = lang('GoShtoppingCart');
				$data['HotProudectsSort'] = lang('HotProudectsSort');

			//檢查商品數
			$prd=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
			$data['prd_num']=count($prd);

			//限制分類數量
			$data['prd_c']=$prd_c=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'asc', array('member_id'=>$this->session->userdata('member_id')));
			$data['allow_add']=(!empty($prd_c) && count($prd_c) >= $data['web_config']['prd_class_num']) ? 0 : 1;// 3 商品分類數量上限
			if(!empty($prd_c))
				$data['cid']=$prd_c[0]['prd_cid'];

			//cart setting
			$data['setting']=$setting=$this->mod_cart->select_from('iqr_cart', array('member_id'=>$this->session->userdata('member_id')));

			//商品數量
			foreach($prd_c as $key => $value)
			{
				$prdc_data=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('prd_cid'=>$value['prd_cid']));
				$data['prdc_num'][]=count($prdc_data);
			}
			// $prdc_data=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('prd_cid'=>0));
			// $data['prdc_num']['no_class']=count($prdc_data);

			//mid
			$data['member_id']=$this->session->userdata('member_id');
			$member=$this->mod_cart->select_from('member', array('member_id'=>$data['member_id']));
			$data['img_url']=$member['img_url'];

			//view
			$this->load->view('cart/index', $data);
		}
	}

	// 後台產品搜尋
	public function cart_list()
	{
		$language = $this -> language;
		$this -> lang -> load('views/cart/products_list');

		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$data = $this -> data;

			// language
				$data['Secondary'] = lang('Secondary');
				$data['StoreMerchandiseInquiry'] = lang('StoreMerchandiseInquiry');
				$data['ReturnsProductManagement'] = lang('ReturnsProductManagement');
				$data['ProductPopularity'] = lang('ProductPopularity');
				$data['OffShelf'] = lang('OffShelf');
				$data['Categories'] = lang('Categories');
				$data['ProductName'] = lang('ProductName');
				$data['ProductStatus'] = lang('ProductStatus');
				$data['CommodityStocks'] = lang('CommodityStocks');
				$data['CommodityShipments'] = lang('CommodityShipments');
				$data['ProductPicture'] = lang('ProductPicture');
				$data['ProductPrice'] = lang('ProductPrice');
				$data['SearchResults'] = lang('SearchResults');
				$data['Edit'] = lang('Edit');
				$data['EditCommodity'] = lang('EditCommodity');

			$mid = $this -> session -> userdata('member_id');
			$keyword = $this -> input -> post('key_searching');
			$selection = $this -> input -> post('selector');

			$member = $this -> mod_cart -> select_from('member', array('member_id' => $mid));
			$data['img_url'] = $member['img_url'].'products/';

			if($selection == '*')
			{
				$prds = $this -> mod_cart -> select_from_order_with_like('products', 'prd_id', desc, array('prd_name' => $keyword), $mid);
				foreach ($prds as $key => $value)
				{
					switch ($value['prd_active']) {
						case 0: $prds[$key]['prd_active'] = $language['ThereStock']; 			break;
						case 1: $prds[$key]['prd_active'] = $language['CommodityShipments']; 	break;
						case 2: $prds[$key]['prd_active'] = $language['MerchandiseOffShelf']; 	break;
					}
					$prd_views = $this -> mod_cart -> select_from_order('products_views', 'member_id', $value['member_id'], array('prd_id' => $value['prd_id']));
					$count = 0 ;
					foreach ($prd_views as $views_key => $views_value)
					{
						$count = $views_value['page_view'] + $count;
					}
					$prds[$key]['count'] = $count;
					$class_prd = $this -> mod_cart -> select_from('product_class', array('prd_cid' => $value['prd_cid']));
					$prds[$key]['prd_cname'] = $class_prd['prd_cname'];
				}
			}
			else
			{
				$prds = $this -> mod_cart -> select_from_order_with_like('products', 'prd_id', desc, array('prd_name' => $keyword, 'prd_cid' => $selection), $mid);
				foreach ($prds as $key => $value)
				{
					switch ($value['prd_active']) {
						case 0: $prds[$key]['prd_active'] = $language['ThereStock']; 			break;
						case 1: $prds[$key]['prd_active'] = $language['CommodityShipments']; 	break;
						case 2: $prds[$key]['prd_active'] = $language['MerchandiseOffShelf']; 	break;
					}
					$prd_views = $this -> mod_cart -> select_from_order('products_views', 'member_id', $value['member_id'], array('prd_id' => $value['prd_id']));
					$count = 0 ;
					foreach ($prd_views as $views_key => $views_value)
					{
						$count = $views_value['page_view'] + $count;
					}
					$prds[$key]['count'] = $count;
					$class_prd = $this -> mod_cart -> select_from('product_class', array('prd_cid' => $value['prd_cid']));
					$prds[$key]['prd_cname'] = $class_prd['prd_cname'];
				}
			}
			if(!empty($prds))
				$data['prds'] = $prds;
			else
			{
				$this -> script_message($language['NoSuchThisInformation'], '/cart/cart_management');
			}

			$this -> load -> view('cart/products_list', $data);
		}
	}

	// 新增商品分類
	public function class_add($success='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;
			// language
				$this -> lang -> load('views/cart/class_add', $data['lang']);
				$data['Required']= lang('Required');
				$data['Cancel']= lang('Cancel');
				$data['CategoriesName']= lang('CategoriesName');
				$data['AreCheckCancleAdd']= lang('AreCheckCancleAdd');
				$data['Must15Char']= lang('Must15Char');
				$data['Added']= lang('Added');
				$data['AddedSuccessfully']= lang('AddedSuccessfully');
				$data['NewProductClass']= lang('NewProductClass');

			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success']=$success;

				//prd_c
				$prd_c=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'asc', array('member_id'=>$this->session->userdata('member_id')));
				if($success == '' && $data['web_config']['prd_class_num'] <= count($prd_c))
				{
					echo '<script>';
					echo 'alert("'.$language['ClassificationNumUpper'].'");';
					echo 'window.close();';
					echo '</script>';
				}

				//view
				$this->load->view('cart/class_add', $data);
			}
			else
			{
				$next_sort_num=$this->mod_cart->get_next_sort_num('product_class', array('member_id'=>$this->session->userdata('member_id')));

				$insert=array(
					'member_id'	=> $this->session->userdata('member_id'),
					'prd_cname'	=> $this->input->post('prd_cname'),
					'prd_csort' => $next_sort_num
				);
				$prd_cid = $this->mod_cart->insert_into('product_class', $insert);

				redirect('/cart/class_add/1');
			}
		}
	}

	// 編輯商品分類
	public function class_mv($class = '', $id = '')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			// data
			$data = $this -> data;

			// language
				$this -> lang -> load('views/cart/class_mv', $data['lang']);
				$data['Cancel'] = lang('Cancel');
				$data['CategoriesName'] = lang('CategoriesName');
				$data['NewClassificationReuse'] = lang('NewClassificationReuse');
				$data['AreCheckCancleEdit'] = lang('AreCheckCancleEdit');
				$data['Select'] = lang('Select');
				$data['SelectMoveClassName'] = lang('SelectMoveClassName');
				$data['SelectProductClass'] = lang('SelectProductClass');
				$data['_SelectMoveClassName'] = lang('_SelectMoveClassName');
				$data['SaveEdit'] = lang('SaveEdit');

			$data['success'] = '';
			if($this -> input -> post('selection'))
			{

				$selected = $this -> input -> post('selection');

				$classmv  = $this -> session -> userdata('classmv');

				foreach ($classmv as $key => $value)
				{
					$this -> mod_cart -> update_set('products', 'prd_id', $value, array('prd_cid' => $selected));
				}
				$this -> session -> unset_userdata('classmv');
				$data['success'] = 1;
			}
			else
			{
				$id = array_filter(explode('ChkENAliKENfIKQ', $id));
				$this-> session -> set_userdata('classmv', $id);
				$class_all = $this -> mod_cart -> select_from_order('product_class', 'member_id', $this->session->userdata('member_id'), array('member_id' => $this -> session -> userdata('member_id')));

				$data['count'] = count($class_all);
				foreach ($class_all as $key => $value)
				{
					if($product_class['prd_cid'] != $value['prd_cid'])
						$data['class_name'][] = $value;
				}
			}
				$this->load->view('cart/class_mv', $data);
		}
	}

	//編輯商品分類
	public function class_edit($id='', $success='')
	{
		$language = $this -> language;
		//data
		$data=$this->data;
		if($id != '')
		{
			$id = $this -> mod_cart -> select_from('product_class', array('prd_cid' => $id));
			if(!empty($id) && strnatcmp($this -> input -> post('class_name'),$id['prd_cname']) != 0)
			{
				$this -> mod_cart -> update_set('product_class', 'prd_cid', $id['prd_cid'], array('prd_cname' => $this -> input -> post('class_name')));
				$this -> script_message($language['SuccessfullyModified'], '/cart/cart_management');
			}
		}
	}

	// 刪除商品分類
	public function class_del($id='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			$id = $this->input->post('id');

			if($id != '')
			{
				$prd_c=$this->mod_cart->select_from('product_class', array('prd_cid'=>$id, 'member_id'=>$this->session->userdata('member_id')));
				$prds = $this -> mod_cart -> select_from_order('products', 'member_id', $this->session->userdata('member_id'), array('prd_cid' => $id));

				if(!empty($prd_c) && count($prds) == 0)
				{
					//刪除商品分類
					$this->mod_cart->delete_where('product_class', array('prd_cid'=>$id));
					echo 'suc';
				}
				else
				{
					echo $language['RemoveTheProduct'];
				}
			}
			else
			{
				echo '<script>';
				echo 'alert("'.$language['DataLoss'].'");';
				echo 'window.location.href="'.base_url().'"';
				echo '</script>';
			}
		}
	}

	// 新增商品
	public function product_add($success='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			// language
				$this -> lang -> load('views/cart/product_add', $data['lang']);
				$data['IntroductionMovie'] = lang('IntroductionMovie');
				$data['SafetyStock'] = lang('SafetyStock');
				$data['ExampleOneYear'] = lang('ExampleOneYear');
				$data['ExampleProductMalfunction'] = lang('ExampleProductMalfunction');
				$data['Cancel'] = lang('Cancel');
				$data['WarrantyPeriod'] = lang('WarrantyPeriod');
				$data['WarrantyCoverage'] = lang('WarrantyCoverage');
				$data['SuggestedRetailPrice'] = lang('SuggestedRetailPrice');
				$data['Picture600'] = lang('Picture600');
				$data['StorageCapacity'] = lang('StorageCapacity');
				$data['ProductInfo'] = lang('ProductInfo');
				$data['Categories'] = lang('Categories');
				$data['ProductName'] = lang('ProductName');
				$data['ProductFeatures'] = lang('ProductFeatures');
				$data['ProductSpecifications'] = lang('ProductSpecifications');
				$data['ProductPicture'] = lang('ProductPicture');
				$data['GoodsWillNotAdded'] = lang('GoodsWillNotAdded');
				$data['NoFillInFields'] = lang('NoFillInFields');
				$data['SetSell'] = lang('SetSell');
				$data['StockEmailNotice'] = lang('StockEmailNotice');
				$data['OneBuyQuantity'] = lang('OneBuyQuantity');
				$data['Must225Char'] = lang('Must225Char');
				$data['TaiwanDollar'] = lang('TaiwanDollar');
				$data['Added'] = lang('Added');
				$data['NewProduct'] = lang('NewProduct');
				$data['_NewProduct'] = lang('_NewProduct');
				$data['Increase'] = lang('Increase');
				$data['Select'] = lang('Select');
			    $data['Introductory_video'] = lang('Introductory_video');

			header("Cache-control: private");

			if(!$this->input->post('form_submit'))
			{
				//member
				$member = $this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//新增完成
				$data['success']=$success;

				//分類清單
				$data['prd_c']=$prd_c=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'asc', array('member_id'=>$this->session->userdata('member_id')));

				//view
				$this->load->view('cart/product_add', $data);
			}
			else
			{
				//商品描述
				if($this->input->post('prd_describe'))
				{
					$access_arr=$this->empty_col($this->input->post('prd_describe'));
					$prd_describe=$this->set_serialstr($access_arr, '*#');
				}

				//商品規格名稱 與內容
				if($this->input->post('prd_specification_name') && $this->input->post('prd_specification_content'))
				{
					$access_arr=$this->empty_two_col($this->input->post('prd_specification_name'), $this->input->post('prd_specification_content'), $language['ProductFormat']);
					$prd_specification_name=$this->set_serialstr($access_arr[0], '*#');
					$prd_specification_content=$this->set_serialstr($access_arr[1], '*#');
				}

				//介紹影片
				if($this->input->post('prd_video_name') && $this->input->post('prd_video_link'))
				{
					$access_arr=$this->empty_two_col($this->input->post('prd_video_name'), $this->input->post('prd_video_link'), $language['IntroductionMovie']);
					$prd_video_name=$this->set_serialstr($access_arr[0], '*#');
					if(!empty($access_arr[1]))
					{
						foreach($access_arr[1] as $key => $value)
						{
							$prd_video_link[]=$this->http_check($value);
						}
						$prd_video_link=$this->set_serialstr($prd_video_link, '*#');
					}
					else
					{
						$prd_video_link=null;
					}
				}

				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');

				//會員圖檔目錄
				$member=$this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
				$img_url=$member['img_url'].'products/';
				if (!file_exists('.'.$img_url)) {
					@mkdir('.'.$img_url, 0777);
				}
				if($_FILES['prd_image']['error'] != 4)
				{
					$img=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
				}
				$insert=array(
					'prd_name'					=> $this->input->post('prd_name'),
					'prd_amount'				=> $this->input->post('prd_amount'),
					'prd_safe_amount'			=> $this->input->post('prd_safe_amount'),
					'prd_lock_amount'			=> $this->input->post('prd_lock_amount'),
					// 'prd_prepare_amount'		=> $this->input->post('prd_prepare_amount'),
					'prd_image'					=> $img['path'],
					'prd_price00'				=> $this->input->post('prd_price00'),
					'prd_price01'				=> $this->input->post('prd_price01'),
					'prd_describe'				=> $prd_describe,
					'prd_content'				=> $this->input->post('prd_content'),
					'prd_video_name'			=> $prd_video_name,
					'prd_video_link'			=> $prd_video_link,
					'prd_specification_name'	=> $prd_specification_name,
					'prd_specification_content'	=> $prd_specification_content,
					'prd_assurance_range'		=> $this->input->post('prd_assurance_range'),
					'prd_assurance_date'		=> $this->input->post('prd_assurance_date'),
					'prd_active'				=> 0,
					'member_id'					=> $this->session->userdata('member_id'),
					'prd_cid'					=> $this->input->post('prd_cid')
				);
				$prd_id=$this->mod_cart->insert_into('products', $insert);

				redirect('/cart/product_add/1');
			}
		}
	}

	// 編輯商品
	public function product_edit($prd_id='', $success='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			// language
				$this -> lang -> load('views/cart/product_edit', $data['lang']);
				$data['IntroductionMovie'] = lang('IntroductionMovie');
				$data['NoClass'] = lang('NoClass');
				$data['SafetyStock'] = lang('SafetyStock');
				$data['AllowNumber'] = lang('AllowNumber');
				$data['ExYear'] = lang('ExYear');
				$data['ProductMalfunction'] = lang('ProductMalfunction');
				$data['Cancle'] = lang('Cancle');
				$data['ThereStock'] = lang('ThereStock');
				$data['WarrantyPeriod'] = lang('WarrantyPeriod');
				$data['WarrantyCoverage'] = lang('WarrantyCoverage');
				$data['SuggestPrice'] = lang('SuggestPrice');
				$data['PicSize_600'] = lang('PicSize_600');
				$data['StorageCapacity'] = lang('StorageCapacity');
				$data['OffShelf'] = lang('OffShelf');
				$data['ProductContent'] = lang('ProductContent');
				$data['ProductClass'] = lang('ProductClass');
				$data['ProductName'] = lang('ProductName');
				$data['ProductStatus'] = lang('ProductStatus');
				$data['ProductFeature'] = lang('ProductFeature');
				$data['ProductSpecification'] = lang('ProductSpecification');
				$data['ProductReplenishment'] = lang('ProductReplenishment');
				$data['ProductPicture'] = lang('ProductPicture');
				$data['NotAnyClass'] = lang('NotAnyClass');
				$data['SpecificationsContent'] = lang('SpecificationsContent');
				$data['SpecificationsName'] = lang('SpecificationsName');
				$data['SetPrice'] = lang('SetPrice');
				$data['LessNumEmail'] = lang('LessNumEmail');
				$data['SinglePurchase'] = lang('SinglePurchase');
				$data['New'] = lang('New');
				$data['MovieUrl'] = lang('MovieUrl');
				$data['MovieTitle'] = lang('MovieTitle');
				$data['EditProduct'] = lang('EditProduct');
				$data['Select'] = lang('Select');
				$data['ClickStatus'] = lang('ClickStatus');
				$data['SaveEdit'] = lang('SaveEdit');
				$data['TaiwanDollar'] = lang('TaiwanDollar');
				$data['Sequence'] = lang('Sequence');
				$data['Remove'] = lang('Remove');

			if(!$this->input->post('submit') && $prd_id != '')
			{
				//member
				$member = $this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//編輯完成
				$data['success']=$success;

				//分類清單
				$data['prd_c']=$prd_c=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'asc', array('member_id'=>$this->session->userdata('member_id')));

				//商品
				$data['prd']=$prd=$this->mod_cart->select_from('products', array('prd_id'=>$prd_id, 'member_id'=>$this->session->userdata('member_id')));
				$data['prd_c_select'][$prd['prd_cid']]='selected';

				//商品特點
				$data['prd_describe']=$this->get_serialstr($prd['prd_describe'], '*#');
				if($data['prd_describe'][0] != '')
					$data['show_describe']=true;
				else
					$data['show_describe']=false;

				//介紹影片
				$data['prd_video_name']=$this->get_serialstr($prd['prd_video_name'], '*#');
				$prd_video_link=$this->get_serialstr($prd['prd_video_link'], '*#');
				if(!empty($prd_video_link))
				{
					foreach($prd_video_link as $key => $value)
					{
						$data['prd_video_link'][]=$value;//$this->get_ytb_id($value);
					}
					if($data['prd_video_link'][0] != '')
						$data['show_video_link']=true;
					else
						$data['show_video_link']=false;
				}

				//商品規格
				$data['prd_specification_name']=$this->get_serialstr($prd['prd_specification_name'], '*#');
				$data['prd_specification_content']=$this->get_serialstr($prd['prd_specification_content'], '*#');
				if($data['prd_specification_content'][0] != '')
					$data['show_specification']=true;
				else
					$data['show_specification']=false;

				//商品狀態
				$data['prd_active_select'][$prd['prd_active']]='selected';//<a href="#">已賣出'.$sell_num.'</a>

				//圖檔目錄
				$member=$this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
				$data['img_url']=$member['img_url'].'products/';

				//view
				$this->load->view('cart/product_edit', $data);
			}
			else
			{
				//商品描述
				if($this->input->post('prd_describe'))
				{
					$access_arr=$this->empty_col($this->input->post('prd_describe'));
					$prd_describe=$this->set_serialstr($access_arr, '*#');
				}

				//商品規格名稱 與內容
				if($this->input->post('prd_specification_name') && $this->input->post('prd_specification_content'))
				{
					$access_arr=$this->empty_two_col($this->input->post('prd_specification_name'), $this->input->post('prd_specification_content'), $language['ProductFormat']);
					$prd_specification_name=$this->set_serialstr($access_arr[0], '*#');
					$prd_specification_content=$this->set_serialstr($access_arr[1], '*#');
				}

				//介紹影片
				if($this->input->post('prd_video_name') && $this->input->post('prd_video_link'))
				{
					$access_arr=$this->empty_two_col($this->input->post('prd_video_name'), $this->input->post('prd_video_link'), $language['IntroductionMovie']);
					$prd_video_name=$this->set_serialstr($access_arr[0], '*#');
					if(!empty($access_arr[1]))
					{
						foreach($access_arr[1] as $key => $value)
						{
							$prd_video_link[]=$this->http_check($value);
						}
						$prd_video_link=$this->set_serialstr($prd_video_link, '*#');
					}
					else
					{
						$prd_video_link=null;
					}
				}

				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');

				//會員圖檔目錄
				$member=$this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
				$img_url=$member['img_url'].'products/';
				if($_FILES['prd_image']['error'] != 4)
				{
					$img=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
					//刪舊檔
					unlink('.'.$img_url.$this->input->post('prd_image_hide'));
					unlink('.'.$img_url.substr($this->input->post('prd_image_hide'), 1));
					if(unlink('.'.$img_url.'s'.substr($this->input->post('prd_image_hide'), 1)))
					{
					}
					else
					{
					}
				}
				else
				{
					$img['path']=$this->input->post('prd_image_hide');
				}
				$update_data=array(
					'prd_name'					=> $this->input->post('prd_name'),
					'prd_amount'				=> $this->input->post('prd_amount'),
					'prd_safe_amount'			=> $this->input->post('prd_safe_amount'),
					'prd_lock_amount'			=> $this->input->post('prd_lock_amount'),
					'prd_prepare_amount'		=> 1,
					'prd_image'					=> $img['path'],
					'prd_price00'				=> $this->input->post('prd_price00'),
					'prd_price01'				=> $this->input->post('prd_price01'),
					'prd_describe'				=> $prd_describe,
					'prd_content'				=> $this->input->post('prd_content'),
					'prd_video_name'			=> $prd_video_name,
					'prd_video_link'			=> $prd_video_link,
					'prd_specification_name'	=> $prd_specification_name,
					'prd_specification_content'	=> $prd_specification_content,
					'prd_assurance_range'		=> $this->input->post('prd_assurance_range'),
					'prd_assurance_date'		=> $this->input->post('prd_assurance_date'),
					'prd_active'				=> $this->input->post('cset_active'),
					'member_id'					=> $this->session->userdata('member_id'),
					'prd_cid'					=> $this->input->post('prd_cid')
				);
				$prd_id=$this->mod_cart->update_set('products', 'prd_id', $this->input->post('prd_id'), $update_data);

				// echo '<script type="text/javascript">window.close();</script>';
				redirect('/cart/product_edit/'.$this->input->post('prd_id').'/1');
			}
		}
	}

	// 刪除商品
	public function product_del($prd_id='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			// language
				$this -> lang -> load('views/cart/product_del', $data['lang']);
				$data['Deleteitem'] = lang('Deleteitem');
				$data['ShoppingCartDitem'] = lang('ShoppingCartDitem');
				$data['Returns'] = lang('Returns');
				$data['Remove_check_goods'] = lang('Remove_check_goods');

			//檢查商品數
			$prd=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
			if(empty($prd))
			{
				$this->myredirect('/cart/cart_management', $language['NoCommodity'], 5);
				return 0;
			}

			if(!$this->input->post('prd_id'))
			{
				//限制分類數量
				$data['prd_c']=$prd_c=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'asc', array('member_id'=>$this->session->userdata('member_id')));
				$data['allow_add']=(!empty($prd_c) && count($prd_c) >= 5) ? 0 : 1;// 3 商品分類數量上限
				if(!empty($prd_c))
					$data['cid']=$prd_c[0]['prd_cid'];

				//商品
				// $data['prd']=$prd=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));

				//商品數量
				foreach($prd_c as $key => $value)
				{
					$prdc_data=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('prd_cid'=>$value['prd_cid']));
					$data['prdc_num'][]=count($prdc_data);
				}
				$prdc_data=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('prd_cid'=>0));
				$data['prdc_num']['no_class']=count($prdc_data);

				//mid
				$data['member_id']=$this->session->userdata('member_id');
				$member=$this->mod_cart->select_from('member', array('member_id'=>$data['member_id']));
				$data['img_url']=$member['img_url'];
				//view
				$this->load->view('cart/product_del', $data);
			}
			else
			{
				//刪除對象
				$prd_id=$this->input->post('prd_id');

				//會員目錄
				$member=$this->mod_cart->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				foreach($prd_id as $key => $value)
				{
					//刪除商品圖
					$prd=$this->mod_cart->select_from('products', array('prd_id'=>$value, 'member_id'=>$this->session->userdata('member_id')));
					unlink('.'.$member['img_url'].'products/'.$prd['prd_image']);
					unlink('.'.$member['img_url'].'products/set_'.substr($prd['prd_image'], 1));

					//刪除商品資料
					$this->mod_cart->delete_where('products', array('prd_id'=>$value, 'member_id'=>$this->session->userdata('member_id')));
				}
				$this->myredirect('/cart/product_del', $language['ProductDeletedSuccess'], 5);
				return 0;
			}
		}
	}


	// --------------------------------------------------------
	// 熱銷產品
	// --------------------------------------------------------
	// 熱銷產品Ajax
	public function products_hot($prd_id = '')
	{
		if($this->input-> post('prd_id'))
		{
			$product = $this -> mod_cart -> select_from('products',array('prd_id' => $this->input->post('prd_id')));
			$prd_id = $this -> input -> post('prd_id');
			if($product['prd_hot'] == 'fa fa-heart-o' )
			{
				$num = $this -> mod_cart -> update_set('products', 'prd_id', $prd_id, array('prd_hot' => 'fa fa-heart'));
				$return = 'fa fa-heart';
			}
			else
			{
				$num = $this -> mod_cart -> update_set('products', 'prd_id', $prd_id, array('prd_hot' => 'fa fa-heart-o'));
				$return = 'fa fa-heart-o';
			}
			echo $return;
		}
		else
			redirect('business/edit');
	}

	// 熱銷產品排序
	public function product_hot_sort()
	{
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		else
		{
			//data
			$data = $this -> data;

			$this -> lang -> load('views/cart/product_hot_sort', $data['lang']);

            $data['HotProudectsSort'] = lang('HotProudectsSort');
            $data['Back_to_product'] = lang('Back_to_product');
            $data['Interface_Description'] = lang('Interface_Description');
            $data['Selling_product_items'] = lang('Selling_product_items');
            $data['Save_Edits'] = lang('Save_Edits');
            $data['Total_Yuan'] = lang('Total_Yuan');

			//檢查商品數
			$data['prd'] = $prd = $this -> mod_cart -> select_from_order('products', 'hot_sort', 'asc', array('prd_hot' => 'fa fa-heart', 'member_id' => $this -> session -> userdata('member_id')));
			if(empty($prd))
			{
				$this -> script_message('您無任何熱銷商品', '/cart/cart_management');
				return 0;
			}

			if(!$this -> input -> post('sort'))
			{
				$data['hot_num'] = $this -> mod_cart -> select_count('products', array('prd_hot' => 'fa fa-heart', 'member_id' => $this -> session -> userdata('member_id')));

				//mid
				$data['member_id'] = $this -> session -> userdata('member_id');
				$member = $this -> mod_cart -> select_from('member', array('member_id' => $data['member_id']));
				$data['img_url'] = $member['img_url'];

				$this -> load -> view('cart/product_hot_sort', $data);
			}
			else
			{
				$sort = $this -> input -> post('sort');

				foreach ($sort as $key => $value)
				{
					$this -> mod_cart -> select_from('products', array('prd_id' => $value));

					$this -> mod_cart -> update_set('products', 'prd_id', $value, array('hot_sort' => $key));
				}

				$this -> script_message('修改成功', '/cart/product_hot_sort');
			}
		}
	}

	public function chk_products_hot()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			if($this-> input -> post('prd_id'))
			{
				$prd_id = $this -> input -> post('prd_id');
				foreach ($prd_id as $key => $value)
				{
					$products = $this -> mod_cart -> select_from('products', array('prd_id' => $value['prd_id'], 'member_id' => $this -> session -> userdata('member_id')));
					if($products['prd_hot'] == 'fa fa-heart-o')
					{
						$num = $this -> mod_cart -> update_set('products', 'prd_id', $value['prd_id'], array('prd_hot' => 'fa fa-heart'));
					}
					else
					{
						$num = $this -> mod_cart -> update_set('products', 'prd_id', $value['prd_id'], array('prd_hot' => 'fa fa-heart-o'));
					}
				}
				echo 'suc';
			}
			else
				redirect('business/edit');
		}
	}

	public function chk_products_del()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			if($this-> input -> post('prd_id'))
			{
				$member = $this -> mod_cart -> select_from('member', array('member_id' => $this -> session -> userdata('member_id')));
				$prd_id = $this -> input -> post('prd_id');
				foreach ($prd_id as $key => $value)
				{
					$product = $this -> mod_cart -> select_from('products', array('prd_id' => $value['prd_id'], 'member_id' => $this -> session -> userdata('member_id')));
					unlink('.'.$member['img_url'].'products/'.$product['prd_image']);
					unlink('.'.$member['img_url'].'products/set_'.substr($product['prd_image'], 1));

					//刪除商品資料
					$this -> mod_cart -> delete_where('products', array('prd_id' => $value['prd_id'], 'member_id' => $this -> session -> userdata('member_id')));
				}
				echo 'suc';
			}
			else
				redirect('business/edit');
		}
	}

	public function chk_products_slot()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			if($this -> input -> post('prd_id'))
			{
				$prd_id = $this -> input -> post('prd_id');
				$result = true;
				foreach ($prd_id as $key => $value)
				{
					$product = $this -> mod_cart -> select_from('products', array('prd_id' => $value['prd_id']));
					if($product['prd_active'] == 0)
						$this -> mod_cart -> update_set('products', 'prd_id', $value['prd_id'], array('prd_active' => 2));
					elseif($product['prd_active'] == 1 && $product['prd_amount'] > 0)
						$this -> mod_cart -> update_set('products', 'prd_id', $value['prd_id'], array('prd_active' => 0));
					elseif($product['prd_active'] == 2 && $product['prd_amount'] > 0)
						$this -> mod_cart -> update_set('products', 'prd_id', $value['prd_id'], array('prd_active' => 0));
					else
						$result = false;
				}
				echo $result;
			}
			else
				redirect('business/edit');
		}
	}

	// 商品分類底下的商品列表
	public function product_list_ajax()
	{
		$language = $this -> language;

		if($this->input->post('id') && $this->input->post('mid') && ($this->session->userdata('member_id') == $this->input->post('mid')))
		{
			if($this->input->post('id') != -1)
			{
				if($this->input->post('id') == 'no_class')
					$id=0;
				else
					$id=$this->input->post('id');
				$prd=$this->mod_cart->select_from_order('products', 'prd_id', 'asc', array('prd_cid'=>$id, 'member_id'=>$this->input->post('mid')));
				foreach ($prd as $prd_key => $prd_value)
				{
					$amount = 0;
					$page_view = $this -> mod_cart -> select_from('products_views', array('prd_id' => $prd_value['prd_id'], 'member_id' => $this -> input-> post('mid')));
					if(empty($page_view) || $page_view == '')
						$amount = 0;
					else
					{
						$total_view = $this -> mod_cart -> select_from_order('products_views', 'prd_id', desc, array('member_id' => $this->input->post('mid'), 'prd_id' => $prd_value['prd_id']));
						foreach ($total_view as $tot_key => $tot_value)
						{
							$amount += $tot_value['page_view'];
						}
					}
					$prd[$prd_key]['count'] = $amount;
				}
			}
			else
			{
				$prd=$this->mod_cart->select_from_order('products', 'prd_cid', desc, array('member_id'=>$this->input->post('mid')));
				foreach ($prd as $prd_key => $prd_value)
				{
					$amount = 0;
					$page_view = $this -> mod_cart -> select_from('products_views', array('prd_id' => $prd_value['prd_id'], 'member_id' => $this -> input-> post('mid')));
					if(empty($page_view) || $page_view == '')
						$amount = 0;
					else
					{
						$total_view = $this -> mod_cart -> select_from_order('products_views', 'prd_id', desc, array('member_id' => $this->input->post('mid'), 'prd_id' => $prd_value['prd_id']));
						foreach ($total_view as $tot_key => $tot_value)
						{
							$amount += $tot_value['page_view'];
						}
					}
					$prd[$prd_key]['count'] = $amount;
				}
			}

			foreach($prd as $key => $value)
			{
				//商品特點
				// $prd_describe=$this->get_serialstr($value['prd_describe'], '*#');
				//商品規格名稱
				// $prd_specification_name=$this->get_serialstr($value['prd_specification_name'], '*#');
				//商品規格內容
				// $prd_specification_content=$this->get_serialstr($value['prd_specification_content'], '*#');
				//商品分類名稱
				$prdc=$this->mod_cart->select_from('product_class', array('prd_cid'=>$value['prd_cid'], 'member_id'=>$this->input->post('mid')));
				$prdc_name=($value['prd_cid'] == 0) ? $language['Unclassified'] : $prdc['prd_cname'];
				// if($value['prd_active'] == 0)//尚有庫存
				// 	$prd_active='尚有庫存';
				// else if($value['prd_active'] == 1)//庫存不足
				// 	$prd_active='庫存不足';
				// else
				// 	$prd_active='商品下架';


				if($value['prd_active'] == 0)
				{
					$value['prd_active'] = 'fa fa-sun-o';
					$color  = 'gold';
					$status = $language['OnStore'];
				}
				else
				{
					$value['prd_active'] = 'fa fa-moon-o';
					$color  = 'crimson';
					$status = $language['TakenOff'];
				}
				$result[]=array(
					'status'					=> $status,
					'color'						=> $color,
					'prd_active'				=> $value['prd_active'],
					'prd_id'					=> $value['prd_id'],
					'prd_hot'					=> $value['prd_hot'],
					'prd_count'					=> $value['count'],
					'prd_name'					=> $value['prd_name'],
					'prd_image'					=> $value['prd_image'],
					// 'prd_describe'				=> $prd_describe,
					// 'prd_price01'				=> $value['prd_price01'],
					'prd_price00'				=> $value['prd_price00'],
					// 'prd_specification_name'	=> $prd_specification_name,
					// 'prd_specification_content'	=> $prd_specification_content,
					// 'prd_amount'				=> $value['prd_amount'],
					// 'prd_content'				=> $value['prd_content'],
					// 'prd_assurance_range'		=> $value['prd_assurance_range'],
					// 'prd_assurance_date'		=> $value['prd_assurance_date'],
					// 'prd_cname'					=> $prdc_name,
					// 'prd_cid'					=> $value['prd_cid']
				);
			}

			if(!empty($result))
				echo json_encode($result);
			else
				echo 'empty';
		}
	}

	// 取商品分類名稱
	public function product_class_name_ajax()
	{
		$language = $this -> language;
		if($this->input->post('id'))
		{
			if($this->input->post('id') != 0)
			{
				$prd=$this->mod_cart->select_from('product_class', array('prd_cid'=>$this->input->post('id')));
				echo $prd['prd_cname'];
			}
			else
			{
				echo $language['Unclassified'];
			}
		}
	}

	// 處理當多值欄位新增卻沒填值時忽略
	private function empty_col($arr)
	{
		foreach($arr as $key => $value)
		{
			if($value != '')
				$result[]=$value;
		}
		return $result;
	}

	// 處理當多值欄位新增卻沒填值時忽略
	private function empty_two_col($arr1, $arr2, $item='')
	{
		foreach($arr2 as $key => $value)
		{
			if($value != '')
			{
				if($arr1[$key] != '')
					$str=$arr1[$key];
				else
					$str=$item;
				$result[0][]=$str;
				$result[1][]=$value;
			}
		}
		return $result;
	}

	// --------------------------------------------------------
	// order : 訂單管理介面
	// --------------------------------------------------------
	// 訂單管理主頁
	public function order_management($page = 1)
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			// data
			$data = $this->data;

			// language
				$this -> lang -> load('views/cart/order_management', $data['lang']);
				$data['NotPayment_1'] = lang('NotPayment_1');
				$data['Processing_2'] = lang('Processing_2');
				$data['Shipped_3'] = lang('Shipped_3');
				$data['PaymentConfirmation_4'] = lang('PaymentConfirmation_4');
				$data['CancelOrder_5'] = lang('CancelOrder_5');
				$data['Return_6'] = lang('Return_6');
				$data['PaymentMethod'] = lang('PaymentMethod');
				$data['PaymentStatus'] = lang('PaymentStatus');
				$data['Delivery'] = lang('Delivery');
				$data['GoStoreAction'] = lang('GoStoreAction');
				$data['OrderDate'] = lang('OrderDate');
				$data['OrderStatus'] = lang('OrderStatus');
				$data['OrderManagement'] = lang('OrderManagement');
				$data['_OrderManagement'] = lang('_OrderManagement');
				$data['UsuallyPeople'] = lang('UsuallyPeople');
				$data['UsuallyPeopleMail'] = lang('UsuallyPeopleMail');
				$data['OperatingOrderStatus'] = lang('OperatingOrderStatus');
				$data['Operating'] = lang('Operating');
				$data['ChangeOrderStatus'] = lang('ChangeOrderStatus');

			$data['order'] = $order = $this->mod_cart->select_from_order('order', 'date', 'asc', array('card_owner'=>$this->session->userdata('member_id')));

			// cart setting
			$data['setting'] = $setting = $this->mod_cart->select_from('iqr_cart', array('member_id'=>$this->session->userdata('member_id')));

			// 換頁設定
			$page_uri 	= 'cart/order_management';
	   		$total_rows = count($data['order']);
	   		$per_page	= 10;
			$config  	= $this->init_pagination($page_uri, $total_rows, $per_page);

			// 排序條件
			if($this->input->get('ob') && $this->input->get('ot'))
			{
				$order_by   = $this->input->get('ob');
				$order_type = $this->input->get('ot');
			}
			else
			{
				$order_by   = 'date';
				$order_type = 'desc';
			}

	   		// 每頁資料設定
			$start_id 			  = (($page-1) * $per_page);
			$real_page_num 		  = $per_page;
			$data['page_data'] 	  = $this->mod_cart->get_range_data('order', $order_by, $order_type, $start_id, $real_page_num, array('card_owner'=>$this->session->userdata('member_id')));
			$data['page_config']  = $config;
			$data['page']		  = $page;

			if(empty($data['page_data']))
			{
				$this->script_message($language['NoOrders'], '/cart/store_setting');
			}
			else
			{
			}
			// string replace
			$create_links=str_replace('&lsaquo;', $language['FirstPage'], $this->pagination->create_links());
			$create_links=str_replace('&rsaquo;', $language['LastPage'], $create_links);
			$data['create_links']=$create_links;

			// 訂單狀態
			//---------------------------------------------------------
			// 0	新訂單
			// 1	處理中
			// 2	已出貨
			// 3	取消訂單
			// 4	交易完成
			// 5	退貨
			// 6	換貨
			//---------------------------------------------------------
			foreach($data['page_data'] as $key => $value)
			{
				switch ($value['status']) {
					case 0: $data['status'][$key] = '<span style="color:red;">'.$language['Unpaid'].'</span>';			break;
					case 1:	$data['status'][$key] = '<span style="color:green;">'.$language['AlreadyPaid'].'</span>';	break;
					case 2:	$data['status'][$key] = '<span style="color:fuchsia;">'.$language['Refund'].'</span>';		break;
				}
				switch ($value['product_flow']) {
					case 0: $data['product_flow'][$key] = $language['NewOrder']; 					break;
					case 1: $data['product_flow'][$key] = $language['Processing']; 					break;
					case 2: $data['product_flow'][$key] = $language['Shipped']; 					break;
					case 3: $data['product_flow'][$key] = $language['CancelOrder']; 				break;
					case 4: $data['product_flow'][$key] = $language['TransactionComplete']; 		break;
					case 5: $data['product_flow'][$key] = $language['Return']; 						break;
					case 6: $data['product_flow'][$key] = $language['Exchanges']; 					break;
				}
				switch ($value['lway_id']) {
					case 0: $data['lway_name'][$key] = '';											break;
					case 1: $data['lway_name'][$key] = $language['PersonallyPickupNotSend'];		break;
					case 2: $data['lway_name'][$key] = $language['DeliveryShipping'];				break;
					case 3: $data['lway_name'][$key] = $language['MailRegistration'];				break;
				}
				// 付款方式
				$payment_way = $this->mod_cart->select_from('payment_way', array('pway_id'=>$value['pay_way_id']));
				$data['pway_name'][$key] = $payment_way['pway_name'];
				// if($value['pay_way_id'] > 1)
				// 	$data['pway_name'][$key] .= ' ('.$payment_way['pway_code'].')';
			}

			// view
			$this->load->view('cart/order_management', $data);
		}
	}

	// 訂單詳情
	public function order_detail($id)
	{
		$language = $this -> language;

		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			// data
			$data = $this->data;

			// language
				$this -> lang -> load('views/cart/order_detail', $data['lang']);
				$data['GomypayTransactionNum'] = lang('GomypayTransactionNum');
				$data['GomypayOrderFormNum'] = lang('GomypayOrderFormNum');
				$data['Subtotal'] = lang('Subtotal');
				$data['Yuan'] = lang('Yuan');
				$data['InstallmentPeriods'] = lang('InstallmentPeriods');
				$data['Fee'] = lang('Fee');
				$data['PaymentMethod'] = lang('PaymentMethod');
				$data['PaymentStatus'] = lang('PaymentStatus');
				$data['CardsEndFourNum'] = lang('CardsEndFourNum');
				$data['CardNumber'] = lang('CardNumber');
				$data['TransactionIdPaypal'] = lang('TransactionIdPaypal');
				$data['DealDate'] = lang('DealDate');
				$data['TradingStatus'] = lang('TradingStatus');
				$data['AmountTransaction'] = lang('AmountTransaction');
				$data['TradingMailbox'] = lang('TradingMailbox');
				$data['TransactionHour'] = lang('TransactionHour');
				$data['TransactionNo'] = lang('TransactionNo');
				$data['EachAmount'] = lang('EachAmount');
				$data['_CreationDate'] = lang('_CreationDate');
				$data['OrderNo'] = lang('OrderNo');
				$data['OrderStatus'] = lang('OrderStatus');
				$data['_Order_Details'] = lang('_Order_Details');
				$data['UsuallyPeopleAddress'] = lang('UsuallyPeopleAddress');
				$data['UsuallyPeopleName'] = lang('UsuallyPeopleName');
				$data['UsuallyPeopleMail'] = lang('UsuallyPeopleMail');
				$data['UsuallyPeoplePhone'] = lang('UsuallyPeoplePhone');
				$data['OrderProductDetails'] = lang('OrderProductDetails');
				$data['ProductName'] = lang('ProductName');
				$data['AuthorizeSingle'] = lang('AuthorizeSingle');
				$data['TongBian'] = lang('TongBian');
				$data['InvoiceDate'] = lang('InvoiceDate');
				$data['InvoiceAddress'] = lang('InvoiceAddress');
				$data['InvoiceTitle'] = lang('InvoiceTitle');
				$data['InvoiceNum'] = lang('InvoiceNum');
				$data['CheckoutInformation'] = lang('CheckoutInformation');
				$data['TransferTime'] = lang('TransferTime');
				$data['Price'] = lang('Price');
				$data['Quantity'] = lang('Quantity');
				$data['Edit'] = lang('Edit');
				$data['HeadOfAmount'] = lang('HeadOfAmount');
				$data['_TotalAmount'] = lang('_TotalAmount');
				$data['ClickChange'] = lang('ClickChange');
				$data['SignedBillNumber'] = lang('SignedBillNumber');
				$data['InvoiceInformation'] = lang('InvoiceInformation');
				$data['Remark'] = lang('Remark');

			$data['order'] = $order = $this->mod_cart->select_from('order', array('card_owner'=>$this->session->userdata('member_id'), 'id'=>$id));
			$data['id']    = $id;

			// 訂單狀態 						付款狀態
			//---------------------------------------------------------
			// 0	新訂單 						未付款
			// 1	處理中						已付款
			// 2	已出貨						退款
			// 3	取消訂單
			// 4	交易完成
			// 5	退貨
			// 6	換貨
			//---------------------------------------------------------
			switch ($order['product_flow']) {
				case 0: $data['product_flow'] = $language['NewOrder'];   			$data['jquery_id'] = 'product_flow';  		break;
				case 1: $data['product_flow'] = $language['Processing'];   			$data['jquery_id'] = 'product_flow';		break;
				case 2: $data['product_flow'] = $language['Shipped'];   			$data['jquery_id'] = 'product_flow';  		break;
				case 3: $data['product_flow'] = $language['CancelOrder']; 			$data['jquery_id'] = '';	  				break;
				case 4: $data['product_flow'] = $language['TransactionComplete']; 	$data['jquery_id'] = '';  					break;
				case 5: $data['product_flow'] = $language['Return'];     			$data['jquery_id'] = 'product_flow';  		break;
				case 6: $data['product_flow'] = $language['Exchanges'];     		$data['jquery_id'] = 'product_flow'; 		break;
			}

			switch ($order['status']) {
				case 0: $data['status'] = $language['Unpaid']; 			$data['jquery_status'] = 'status_edit';		break;
				case 1: $data['status'] = $language['AlreadyPaid']; 	$data['jquery_status'] = 'status_edit';		break;
				case 2: $data['status'] = $language['Refund']; 			$data['jquery_status'] = '';				break;
			}


			// 付款方式
			$payment_way = $this->mod_cart->select_from('payment_way', array('pway_id'=>$order['pay_way_id']));
			$data['pway_name'] = $payment_way['pway_name'];
			if($order['pay_way_id'] > 1 && $order['status'] != 2)
				$data['pway_name'] .= ' ('.$payment_way['pway_code'].')';

			// 商品明細
			$data['items'] = $items  = $this -> mod_cart -> get_order_details($id);
			foreach ($items as $key => $value)
			{
				$total += $value['total'];
			}

			// 物流
			if($order['lway_iqrt_id'] != '' && $order['lway_id'] != '')
			{
				$lits_way = $this -> mod_cart -> select_from('logistics_way', array('lway_id' => $order['lway_id']));
				if($order['lway_price'] == 0)
					$order['lway_price'] = $language['ReachFreeShipping'];
				if($order['lway_id'] == 1)
					$order['lway_price'] = $language['FreeShipping'];

				$data['items'][$key+1]['amount']   = $order['lway_price'];
				$data['items'][$key+1]['name']     = $lits_way['lway_name'];
				$data['items'][$key+1]['quantity'] = 1;
			}

			$data['total'] = $total + $order['lway_price'];

			// 結帳資訊
			switch ($order['pay_way_id']) {
			 	case 2: // paypal
			 		$data['ipn'] = $this->mod_cart->select_from('ipn', array('order_id'=>$order['order_id']));
			 		break;
			 	case 5: // allpay
			 		$data['ipn'] = $this -> mod_cart -> select_from('allpay_trade_log', array('trade_no' => $order['trade_no']));
			 		break;
			 	case 6: // gomypay 線上刷卡
			 		$data['ipn'] = $this -> mod_cart -> select_from('gomypay_trade_log', array('e_orderno' => $order['trade_no'], 'gid' => $order['gid']));
			 		break;
			 }

			//view
			$this->load->view('cart/order_detail', $data);
		}
	}

	// 訂單備註
	public function order_note($id, $action = '')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$data = $this -> data;

			// language
				$this -> lang -> load('views/cart/note_edit', $data['lang']);
				$data['Send'] = lang('Send');
				$data['Remark'] = lang('Remark');
				$data['EditsSuccess'] = lang('EditsSuccess');
				$data['EditNotes'] = lang('EditNotes');
				$data['_EditNotes'] = lang('_EditNotes');
				$data['ShutDown'] = lang('ShutDown');

			$data['suc'] = '0';
			$data['order'] = $order = $this->mod_cart->select_from('order', array('card_owner'=>$this->session->userdata('member_id'), 'id'=>$id));
			if($this -> input -> post('order_note') == '' && $action == 1 || $this -> input -> post('order_note') && $action == 1)
			{
				$this -> mod_cart -> update_set('order', 'id', $id, array('note' => $this -> input -> post('order_note')));
				$data['suc'] = '1';
			}

			$this -> load -> view('cart/note_edit', $data);
		}
	}

	// 訂單狀態變更
	public function product_flow_edit($id, $success='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			// data
			$data = $this->data;
			// language
				$this -> lang -> load('views/cart/order_edit', $data['lang']);
				$data['Cancel'] = lang('Cancel');
				$data['Modify'] = lang('Modify');
				$data['EditComplete'] = lang('EditComplete');

			$data['order'] = $order = $this->mod_cart->select_from('order', array('card_owner'=>$this->session->userdata('member_id'), 'id'=>$id));
			$data['id']    = $id;
			$data['title'] = $language['ModifyOrderStatus'];
			$data['main']  = $language['OrderStatus'];
			$data['action_url'] = '/cart/product_flow_edit';
			// not post yet
			if(!$this->input->post('form_submit'))
			{
				// 修改完成
				$data['success'] = $success;

				// 訂單狀態
				$data['product_flow'][] = $language['NewOrder'];
				$data['product_flow'][] = $language['Processing'];
				$data['product_flow'][] = $language['Shipped'];
				$data['product_flow'][] = $language['CancelOrder'];
				$data['product_flow'][] = $language['TransactionComplete'];
				$data['product_flow'][] = $language['Return'];
				$data['product_flow'][] = $language['Exchanges'];

				$data['product_flow_selected'][$order['product_flow']] = 'selected';

				//view
				$this->load->view('cart/order_edit', $data);
			}
			else
			{
				$this->mod_cart->update_set('order', 'id', $this->input->post('id'), array('product_flow'=>$this->input->post('product_flow')));

			// 更改狀態後寄信
				// if($this->input->post('product_flow') == '2' || $this->input->post('product_flow') == '5' || $this->input->post('product_flow') == '5')
				// {
				// 	$order       = $this -> mod_cart -> select_from('order', array('id' => $this -> input -> post('id')));
				// 	$iqr_cart    = $this -> mod_cart -> select_from('iqr_cart', array('member_id' => $this -> session -> userdata('member_id')));
				// 	$payment_way = $this -> mod_cart -> select_from('payment_way', array('pway_id' => $order['pay_way_id']));
				// 	$cart =  explode("++", $order['details']);
				// 	$cart = array_values(array_filter($cart));

				// 	if($this->input->post('product_flow') == '2')
				// 		$status = $language['Shipped'];
				// 	elseif($this->input->post('product_flow') == '3')
				// 		$status = '取消訂單';
				// 	elseif($this->input->post('product_flow') == '5')
				// 		$status = '退貨';
				// 	elseif($this->input->post('product_flow') == '6')
				// 		$status = '換貨';

				// 	// $this -> status_mail($order, $status, $iqr_cart, $payment_way, $order['email'], $cart);
				// }

				redirect('/cart/product_flow_edit/'.$this->input->post('id').'/1');
			}
		}
	}

	// 付款狀態變更
	public function status_edit($id, $success = '')
	{
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$data = $this->data; // data
			$data['order'] = $order = $this->mod_cart->select_from('order', array('card_owner'=>$this->session->userdata('member_id'), 'id'=>$id));
			$data['id']    = $id;
			$data['title'] = $language['ModifyPaymentStatus'];
			$data['main']  = $language['PaymentStatus'];
			$data['action_url'] = '/cart/status_edit';
			// not post yet
			if(!$this->input->post('form_submit'))
			{
				// 修改完成
				$data['success'] = $success;

				// 訂單狀態
				$data['product_flow'][] = $language['Unpaid'];
				$data['product_flow'][] = $language['AlreadyPaid'];
				$data['product_flow'][] = $language['Refund'];

				$data['product_flow_selected'][$order['status']] = 'selected';

				//view
				$this->load->view('cart/order_edit', $data);
			}
			else
			{
				$this->mod_cart->update_set('order', 'id', $this->input->post('id'), array('status'=>$this->input->post('product_flow')));
				redirect('/cart/status_edit/'.$this->input->post('id').'/1');
			}
		}
	}

	// 狀態已出貨時寄信通知
	private function status_mail($order, $status, $store, $pway_info, $buyer_email, $user_cart)
	{
		$data = $this -> data;

		$subject = $order['order_id'].'訂單【'.$status.'】 - 行動商務系統';

		$message =	'<p>'.$language['OrderAtStoreInAction'].'</p>'.
					'<p><hr></p>'.
					'<p><h3>'.$language['OrderInformation'].'</h3></p>'.
					'<p><h4>'.$language['_OrderStatus'].'<font color="red">'.$status.'</font></h4></p>'.
					'<p>'.$language['OrderCreationDate'].''.date('Y年m月d日, H:i', $order['date']).'</p>'.
					'<p>'.$language['_UsuallyPeople'].''.$order['name'].'</p>'.
					'<p>'.$language['UsuallyPeoplePhone'].''.$order['phone'].'</p>'.
					'<p>'.$language['UsuallyPeopleMailbox'].''.$order['name'].'</p>'.
					'<p>'.$language['UsuallyPeopleAddress'].''.$order['zip'].$order['county'].$order['area'].$order['address'].'</p>'.
					'<p>'.$language['StoreName'].'{unwrap}<a href=\''.base_url().'cart/store/'.$store['cset_code'].'\'>'.$store['cset_name'].'</a>{/unwrap}</p>'.
					'<p>'.$language['_PaymentMethod'].''.$pway_info['pway_name'].' ('.$pway_info['pway_code'].')</p>'.
					'<p>'.$language['OrderDetails'].'</p>'.
					'<table style="border: 1px solid #333333;border-collapse: collapse;">'.
					'<tr><td style="padding:5px 10px;border: 1px solid #333333;">'.$language['ProductName'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Quantity'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Subtotal'].'(TWD)</tr>'
		;
		foreach($user_cart as $key => $value)
		{
			$pos 	  = strpos($value, '*#');
			$id 	  = substr($value, 0, $pos);
			$num 	  = substr($value, $pos + 2);
			$prd 	  = $this->mod_cart->select_from('products', array('prd_id'=>$id));
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$prd['prd_name'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$num.'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.($num * $prd['prd_price00']).'</tr>';
			$total 	 += ($num * $prd['prd_price00']);
		}
		$message .=	'<tr><td colspan="3" style="padding:5px 10px;border: 1px solid #333333;text-align:right; color:red; font-weight: blod;">共$'.$total.'元</td></tr>'.
					'</table>'.
					'<p><hr></p>'.
					"<p>".$language['DoNotDirectlyReply']."</p>";

		// 寄信
		$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $buyer_email, $subject, $message);
	}

	// --------------------------------------------------------
	// store : 商店各介面
	// --------------------------------------------------------
	// 商店主頁
	public function store($cset_code = '', $product_cid = '')
	{		
		//data
		$data = $this->data;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		$language=$this->lmodel->config('25',$this->setlang);

		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code,'lang_type'=>$this->setlang));

		if(empty($store) || !$store['cset_active'])
		{
			//無此商店
			$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id'], 'domain_id' => $this->data['domain_id']));

			if(!empty($member))
			{
				//行動名片連結
				if($data['web_config']['iqr_link_type'] == 1)//短網址
				{
					$base_url = substr(base_url(), 7);
					$base_url = substr($base_url, 0, -1);
					$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
				}
				else
				{
					$iqr_url = base_url().'business/iqr/'.$member['account'];
				}

				$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			}
			else
			{
				$this->script_message($language['ActionNotEnabledStore']);
			}
		}
		else
		{
			//判斷使用期限
			// if(!$this->check_deadline($data['web_config'], $store['member_id']))
			// {
			// 	// redirect('/index/error');
			// }

			//member
			$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id'], 'domain_id' => 0));
			if($member)
			{
				// cart
				$iqr = $this -> mod_cart -> select_from('iqr',array('member_id' => $store['member_id']));
				$data['cart_menu_button'] = $iqr['cart_menu_button'];
				$cart_theme = $this -> mod_cart -> select_from('cart_theme', array('cart_id' => $iqr['cart_id']));

				$data['img_url']=$this->Spath;

				//cset_code
				$data['cset_code']=$cset_code;

				//store
				$data['store']=$store;

				//full url
				$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				//20160511-國鼎
				$data['iqr_url']=base_url().'gold/home/'.$_SESSION['AT']['account'];
				//20160511-國鼎
				//product class
				$prdc=$this->mod_cart->select_from_order('product_class', 'prd_cid', 'desc', array('member_id'=>0,'lang_type'=>$this->setlang));

				$data['product_cid'] = $product_cid;
				if(!empty($prdc))
				{
					$iqr = $this -> mod_cart -> select_from('iqr', array('member_id' => $store['member_id']));
					$store['member_id'] = 0;
					if($iqr['cart_id'] != 1)
					{
						foreach ($prdc as $key => $value)
						{
							$prdc[$key]['count'] = $this -> mod_cart -> select_count('products', array('prd_cid' => $value['prd_cid'], 'prd_active' => 0, 'member_id' => $store['member_id'],'d_enable'=>'Y'));
							if($prdc[$key]['count'] == 0 )
								unset($prdc[$key]);
						}
						sort($prdc);
						$data['prdc'] = $prdc;

						if($iqr['cart_id'] == '6')
							$data['sum'] = $this -> mod_cart -> select_count('products', array('prd_active' => 0, 'member_id' => $store['member_id']));
						else
							$data['sum'] = $this -> mod_cart -> select_count('products', array('prd_active' => 0, 'member_id' => $store['member_id'], 'prd_hot'=>'fa fa-heart'));

						if($product_cid == '')
						{
							$data['prd_hot'] = $this -> mod_cart -> select_from_order('products', 'hot_sort', asc, array('prd_active' => 0, 'member_id' => $store['member_id'], 'prd_hot'=>'fa fa-heart'));
						}
						else if($product_cid == 0 && $iqr['cart_id'] == 6)
						{
							$data['prd'] = $this -> mod_cart -> select_from_order('products', 'prd_id', desc, array('prd_active' => 0, 'member_id' => $store['member_id'],'d_enable'=>'Y'));
						}
						else
						{
							if($product_cid === '0')
								$data['prd'] = $this -> mod_cart -> select_from_order('products', 'prd_id', desc, array('prd_active' => 0, 'member_id' => $store['member_id'],'d_enable'=>'Y'));
							else
							{
								$prd_class_name_array = $this -> mod_cart -> select_from_array('product_class', array('prd_cid' => $product_cid), array('prd_cname'));
								$data['class_name'] = $prd_class_name_array[0]['prd_cname'];
								$data['prd'] = $this -> mod_cart -> select_from_order('products', 'prd_id', desc, array('prd_active' => 0, 'member_id' => $store['member_id'], 'prd_cid' => $product_cid,'d_enable'=>'Y'));
							}

							if(empty($data['prd']))
							{
								$this -> script_message($language['IllegalConnections'], '/cart/store/'.$cset_code);
								break;
							}
						}
					}
					else
					{   //$iqr['cart_id'] == 1
						foreach($prdc as $key => $value)
						{ 
							$prd[$value['prd_cid']]=$this->mod_cart->select_from_order('products', 'update_time', 'desc', array('prd_cid'=>$value['prd_cid'], 'member_id'=>$store['member_id'], 'prd_active'=>0,'d_enable'=>'Y'));
							if(!empty($prd[$value['prd_cid']]))
							{
								$total = $this -> mod_cart -> select_from_order('products','prd_cid','desc', array('prd_cid' => $value['prd_cid']));
								$prdc[$key]['total'] = count($total);
								$data['prdc'][]=$prdc[$key];
							}
						}

                        if (empty($product_cid)) {
                            $prdHot=array();
							$prdHot[$data['prdc'][0]['prd_cid']] = $this->mod_cart->select_from_order('products', 'update_time', 'desc', array('prd_hot'=>'fa fa-heart', 'member_id'=>$store['member_id'], 'prd_active'=>0,'d_enable'=>'Y'));

							$total = $this -> mod_cart -> select_from_order('products','prd_cid','desc', array('prd_hot'=>'fa fa-heart'));
							$prdc[0]['total'] = count($total);

        					$data['prd'] = $prdHot;//$prdHot[0];

                        } else { 
                            if ($product_cid == 'a') {
	        					$data['prd'] = $prd;
                            } else { 
    						    $prd2 = array();
	        					if (isset($prd[$product_cid])) $prd2[$product_cid] = $prd[$product_cid];
    //echo 'product_cid='.$product_cid.'<br/>'.json_encode($prd2);exit;
	        					$data['prd'] = $prd2;
                            }
                        }
					}
				}

				//has login
				$data['user_login'] = $this->session->userdata('user_login');
				//裝置判斷分享bar hideen
				if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
					$data['share_bar_hidden'] = 0;
				$data['android_d'] = $this->input->get('d');

				$data['iqr_cart'] = $this -> mod_cart -> select_from('iqr_cart', array('member_id' => $store['member_id'],'lang_type'=>$this->setlang));
				// print_r($cart_theme['cart_mod_name']); //store_A00
				//view
//echo '2>>'.json_encode($data);exit;
				if($this->get_device_type() == 0)
				{//電腦版
					$data['cart_logo_url'] = $iqr['cart_logo_url'];
					$this->load->view('cart/integrate/'.$cart_theme['cart_mod_name'], $data);
					// $this->load->view('cart/store', $data);
				}
				else
				{//手機版
					$data['cart_logo_url'] = $iqr['cart_mobile_logo_url'];
					$this->load->view('cart/integrate/'.$cart_theme['cart_mod_name'], $data);
					// $this->load->view('cart/mstore', $data);
				}
			}
			else
			{
				redirect(base_url());
			}
		}
	}

	// 商品搜尋
	public function search_engine($cset_code = '')
	{
		// 素材
		$data = $this -> data;
		//語言包
		$this->lang=$this->lmodel->config('21',$this->setlang);
		$this->lang1=$this->lmodel->config('27',$this->setlang);

		$data['img_url']=$this->Spath;

		$data['tips'] = '';
		$data['cset_code'] = $cset_code;
		$data['iqr_cart'] = $iqr_cart = $this -> mod_cart -> select_from('iqr_cart', array('cset_code' => $cset_code));
		$data['member'] = $member = $this -> mod_cart -> select_from('member', array('member_id' => 1));
		if($this->input->post('search_key'))
		{
			$data['search_result'] = $search_result = $this -> mod_cart -> select_from_order_with_like('products', 'prd_id', desc, array('prd_name' => $this-> input -> post('search_key')), '0');
			if(!$search_result)
			{
				$data['tips'] = 'fail';
			}
			$data['search_key'] = $search_key = $this -> input -> post('search_key');

		}
		$this -> load -> view('cart/product-search', $data);
	}

	// 商品資訊
	public function product_info($cset_code='', $prd_id='')
	{
		// ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
		// error_reporting(E_ALL & ~E_NOTICE);
		//data
		$data = $this->data;
		// language
		// $language = $this -> language;
		// $this -> lang -> load('views/cart/integrate/product_A01', $data['lang']);
		// $data['ShoppingGuide'] = lang('ShoppingGuide');
		// $data['Plurk'] = lang('Plurk');
		// $data['Everyone'] = lang('Everyone');
		// $data['GoodsHaveBeen'] = lang('GoodsHaveBeen');
		// $data['Yuan'] = lang('Yuan');
		// $data['ShareItem'] = lang('ShareItem');
		// $data['PaymentMethod'] = lang('PaymentMethod');
		// $data['NoProductSpecifications'] = lang('NoProductSpecifications');
		// $data['DeliveryMethod'] = lang('DeliveryMethod');
		// $data['Item'] = lang('Item');
		// $data['AddCart'] = lang('AddCart');
		// $data['_WarrantyPeriod'] = lang('_WarrantyPeriod');
		// $data['_WarrantyCoverage'] = lang('_WarrantyCoverage');
		// $data['WithoutWarranty'] = lang('WithoutWarranty');
		// $data['SuggestedRetailPrice'] = lang('SuggestedRetailPrice');
		// $data['RelatedProducts'] = lang('RelatedProducts');
		// $data['StorageCapacity'] = lang('StorageCapacity');
		// $data['SpecialOffer'] = lang('SpecialOffer');
		// $data['ProductDesciption'] = lang('ProductDesciption');
		// $data['ProductSpecifications'] = lang('ProductSpecifications');
		// $data['No'] = lang('No');
		// $data['ReferenceOnly'] = lang('ReferenceOnly');
		// $data['SinaWeibo'] = lang('SinaWeibo');
		// $data['TransportRules'] = lang('TransportRules');
		// $data['ActualNumberGoods'] = lang('ActualNumberGoods');
		// $data['TotalAmount'] = lang('TotalAmount');
		// $data['Purchase'] = lang('Purchase');
		// $data['BuyExplanation'] = lang('BuyExplanation');
		// $data['TencentWeibo'] = lang('TencentWeibo');

		//語言包
		$this->lang=$this->lmodel->config('21',$this->setlang);
		$language=$this->lmodel->config('25',$this->setlang);

		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		//無此商店
		$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id']));

		//行動名片連結
		if($data['web_config']['iqr_link_type'] == 1)//短網址
		{
			$base_url = substr(base_url(), 7);
			$base_url = substr($base_url, 0, -1);
			$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
		}
		else
		{
			$iqr_url = base_url().'business/iqr/'.$member['account'];
		}
		if(empty($store) || !$store['cset_active'])
		{
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
		}
		else
		{
			//判斷使用期限
			// if(!$this->check_deadline($data['web_config'], $store['member_id']))
			// {
			// 	$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			// }

			//member
			$member=$this->mod_cart->select_from('member', array('member_id'=>$store['member_id']));
			$data['img_url']=$this->Spath;

			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url=substr(base_url(), 7);
				$base_url=substr($base_url, 0, -1);
				$data['iqr_url']='http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$data['iqr_url']=base_url().'business/iqr/'.$member['account'];
			}

			//store
			$data['iqr_cart'] = $data['store'] = $store;
			$data['cart_link'] = base_url().'cart/store/'.$store['cset_code'];
			$data['cset_code'] = $store['cset_code'];

			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$store['member_id'] = 0;
			//products
			$prd = $this -> mod_cart -> select_from('products', array('prd_id'=>$prd_id, 'member_id'=>$store['member_id']));
			//員工價是否顯示
			$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$_SESSION['MT']['by_id']));
			if($bdata['d_spec_type']==0)
				$prd['d_mprice']=0;

			$data['prd'] = $prd ;

			// $data['prds'] = $prds[] = $this -> mod_cart -> select_from_order_limit('products','rand()','rand()', 6, array('member_id' => $store['member_id'], 'prd_active' => 0));
			$data['prds'] = $prds = $this -> mod_cart -> get_random_data('products', array('member_id' => $store['member_id'], 'prd_active' => 0,'d_enable'=>'Y', 'lang_type' => $this->setlang), '', 6);

			//此商店無此商品
			if($prd_id == '' || empty($prd))
			{
				$this->script_message($language['NoSuchMerchandise'], '/cart/store/'.$cset_code);
				return 0;
			}
			else
			{
				if($prd['active'] == 2)//下架商品
				{
					$this->script_message($language['NoSuchMerchandise'], '/cart/store/'.$cset_code);
					return 0;
				}
			}

			$data['stray']=json_encode($this->lang);

			//商品特點
			if($prd['prd_describe'] != '')
			{
				$data['prd_describe']=$this->get_serialstr($prd['prd_describe'], '*#');
			}

			//影片
			if($prd['prd_video_link'] != '')
			{
				$prd_video_name=$this->get_serialstr($prd['prd_video_name'], '*#');
				$prd_video_link=$this->get_serialstr($prd['prd_video_link'], '*#');
				if(!empty($prd_video_link))
				{
					foreach($prd_video_link as $key => $value)
					{
						if($prd_video_name[$key] != '')
							$data['prd_video_name'][]=$prd_video_name[$key];
						else
							$data['prd_video_name'][]=$language['IntroductionMovie'];

						$data['prd_video_link'][]='http://www.youtube.com/embed/'.$this->get_ytb_id($value);
					}
				}
			}

			//商品規格
			if($prd['prd_specification_content'] != '')
			{
				$data['prd_specification_name']=$this->get_serialstr($prd['prd_specification_name'], '*#');
				$data['prd_specification_content']=$this->get_serialstr($prd['prd_specification_content'], '*#');
			}

			//其他商品
			// $data['another_prd']=$this->mod_cart->get_random_data('products', array('member_id'=>$store['member_id'], 'prd_id'=>$prd_id), array(0, 1), 3);

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			$payment_way = $this -> mod_cart -> select_from_order('payment_way', 'pway_id', 'asc', array('active' => 1));
			foreach ($payment_way as $key => $value) {
				$payment_way[$key]['pway_name']=$this->lang['Pay'.$value['pway_id'].''];
			}
			$data['payment_way'] = $payment_way;
			$data['prd_url']     = base_url().'cart/product_info/'.$cset_code.'/'.$prd_id;

			$fee = '';

			$logistics_way=$this->mymodel->select_page_form('logistics_way','','lway_id,lway_name,business_account',array('active'=>1));



			foreach ($logistics_way as $key=> $lvalue) {

				$logistics_way[$key]['lway_name']=$this->lang['Logis'.$lvalue['lway_id'].''];

				if($lvalue['lway_id']==4){
					$fee=$lvalue['business_account'];
					unset($logistics_way[$key]);
				}
			}

			$data['logistics_way'] = $logistics_way;
			$data['fee'] = $fee;

			$time_date = date("Y-m-d", time());
			$page_view = $this -> mod_cart -> select_from('products_views', array('date_time' => $time_date, 'member_id' => $store['member_id'], 'prd_id' => $prd['prd_id']));
			if(!empty($page_view))
			{
				$num = $page_view['page_view'] + 1;
			 	$timer = $this -> mod_cart -> update_where_array_set('products_views', array('date_time' => $time_date, 'member_id' => $store['member_id'], 'prd_id' => $prd['prd_id']), array('page_view' => $num, 'date_time' => $time_date, 'member_id' => $store['member_id']));
			}
			else
			{
				$insert_data = array(
						'prd_id' 		=>  $prd['prd_id'],
						'date_time' 	=>  $time_date,
						'page_view'		=>  1,
						'member_id'		=>  $store['member_id']
					);
				$oid = $this->mod_cart->products_insert_views('products_views', $insert_data);
			}
			// print_r($prd);
			//20160706-抓取已購買商品數量
			if($prd['restrice_num']!='0' and $_SESSION['MT']['by_id']!=''){
				$by_id=$_SESSION['MT']['by_id'];
				$data['snum']=$snum=$this->mod_cart->get_order_num($by_id,$prd_id);
				if($prd['restrice_num']<=$snum)
					$data['over_order']='1';
			}

			$data['prd']['prd_content'] = str_replace("&quot;", "'", $data['prd']['prd_content']);

			//20160706-抓取已購買商品數量
			$this->load->view('cart/integrate/product_A01', $data);
			//view
				// if($this->get_device_type() == 0)
				// {//電腦版
				// 	$this->load->view('cart/integrate/product_A01', $data);
				// 	// $this->load->view('cart/integrate/product_info', $data);
				// }
				// else
				// {//手機版
				// 	$this->load->view('cart/integrate/product_A01', $data);
				// 	// $this->load->view('cart/mproduct_info', $data);
				// }
		}
	}

	// 商品詳細資訊
	public function product_content($cset_code='', $prd_id='')
	{
		//data
		$data = $this->data;

		// language
			$language = $this -> language;
			$this -> lang -> load('views/cart/mproduct_content', $data['lang']);
			$data['AddToCart'] = lang('AddToCart');
			$data['NoProductSpecifications'] = lang('NoProductSpecifications');
			$data['WarrantyPeriod'] = lang('WarrantyPeriod');
			$data['WarrantyCoverage'] = lang('WarrantyCoverage');
			$data['WithoutWarranty'] = lang('WithoutWarranty');
			$data['Inventory_shortage'] = lang('Inventory_shortage');
			$data['ProductInfo'] = lang('ProductInfo');
			$data['ProductSpecifications'] = lang('ProductSpecifications');

		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		//無此商店
		$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id']));

		//行動名片連結
		if($data['web_config']['iqr_link_type'] == 1)//短網址
		{
			$base_url = substr(base_url(), 7);
			$base_url = substr($base_url, 0, -1);
			$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
		}
		else
		{
			$iqr_url = base_url().'business/iqr/'.$member['account'];
		}
		if(empty($store) || !$store['cset_active'])
		{
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
		}
		else
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $store['member_id']))
			{
				$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			}

			//store
			$data['store']=$store;
			$data['prd_link']=base_url().'cart/product_info/'.$store['cset_code'].'/'.$prd_id;
			$data['cset_code']=$store['cset_code'];

			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			//products
			$data['prd']=$prd=$this->mod_cart->select_from('products', array('prd_id'=>$prd_id, 'member_id'=>$store['member_id']));

			//此商店無此商品
			if($prd_id == '' || empty($prd))
			{
				$this->myredirect('/cart/store/'.$cset_code, $language['NoSuchMerchandise'], 5);
				return 0;
			}
			else
			{
				if($prd['active'] == 2)//下架商品
				{
					$this->myredirect('/cart/store/'.$cset_code, $language['NoSuchMerchandise'], 5);
					return 0;
				}
			}

			//影片
			if($prd['prd_video_link'] != '')
			{
				$prd_video_name=$this->get_serialstr($prd['prd_video_name'], '*#');
				$prd_video_link=$this->get_serialstr($prd['prd_video_link'], '*#');
				if(!empty($prd_video_link))
				{
					foreach($prd_video_link as $key => $value)
					{
						if($prd_video_name[$key] != '')
							$data['prd_video_name'][]=$prd_video_name[$key];
						else
							$data['prd_video_name'][]=$language['IntroductionMovie'];

						$data['prd_video_link'][]='http://www.youtube.com/embed/'.$this->get_ytb_id($value);
					}
				}
			}

			//商品規格
			if($prd['prd_specification_content'] != '')
			{
				$data['prd_specification_name']=$this->get_serialstr($prd['prd_specification_name'], '*#');
				$data['prd_specification_content']=$this->get_serialstr($prd['prd_specification_content'], '*#');
			}

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			//view
			if($this->get_device_type() == 0)
			{//電腦版
				header('Location:'.base_url().'cart/product_info/'.$store['cset_code'].'/'.$prd_id);
			}
			else
			{//手機版
				$this->load->view('cart/mproduct_content', $data);
			}
		}
	}

	// 結帳
	public function check($cset_code, $step)
	{
		//data
		$data = $this->data;
		
		// language
		// $language = $this -> language;

		//語言包
		$language=$this->lmodel->config('25',$this->setlang);

		//未登入者請先登入
		if($_SESSION['MT']['by_id']!='' ){
			//找不到商店則導向首頁
			$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
			if(empty($store) || !$store['cset_active'])
			{
				//無此商店
				$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id']));

				//行動名片連結
				if($data['web_config']['iqr_link_type'] == 1)//短網址
				{
					$base_url = substr(base_url(), 7);
					$base_url = substr($base_url, 0, -1);
					$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
				}
				else
				{
					$iqr_url = base_url().'business/iqr/'.$member['account'];
				}

				$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			}
			else
			{
				header('Cache-control: private, must-revalidate');

				//cset code
				$data['cset_code'] = $cset_code;

				//store
				$data['store'] = $store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));

				//member
				$member = $this->mod_cart->select_from('member', array('member_id'=>$store['member_id']));
				$data['img_url'] = $this->Spath;

				// payment_way : 系統啟用的付款方式
				$payment_way = $this->mod_cart->select_from_order('payment_way', 'pway_id', 'asc', array('active'=>1));
				foreach ($payment_way as $pkey => $pvalue) {
					$payment_way[$pkey]['pway_name']=$language['Pay'.$pvalue['pway_id']];
				}
				$data['payment_way']=$payment_way;
				// logistics_way : 系統啟用的物流方式
				$full_pay = $this -> mod_cart -> select_from('iqr_logistics', array('cset_id' => $store['cset_id'], 'lway_id' => 4));

				if(!empty($full_pay))
					$data['full_pay'] = $full_pay['business_account'];
				else
					$data['full_pay'] = $full_pay['business_account'] = 0;

				$logistics_way = $this -> mod_cart -> select_from_order('logistics_way', 'lway_id', asc, array('active' => 1 ));
				
				foreach ($logistics_way as $lkey => $lvalue) {
					$logistics_way[$lkey]['lway_name']=$language['Logis'.$lvalue['lway_id']];
				}
				$data['logistics_way']=$logistics_way;

				// home
				$data['cart_link'] = base_url().'cart/store/'.$store['cset_code'];

				//裝置判斷分享bar hideen
				if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
					$data['share_bar_hidden'] = 0;
				$data['android_d'] = $this->input->get('d');

				//購物清單
				$user_cart=$this->session->userdata('user_cart');
				if(!empty($user_cart))
				{
					//has login
					$data['user_login'] = $this->session->userdata('user_login');

					switch ($step) {
						case 1:
							// 目前購物車內容與總額
							$data['user_cart_num']=count($user_cart);
							//20160803-是否為特殊身分
							$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$_SESSION['MT']['by_id']));
							$data['d_spec_type']=$bdata['d_spec_type'];
	
							foreach($user_cart as $key => $value)
							{
								$pos=strpos($value, '*#');
								$id=substr($value, 0, $pos);
								$num=substr($value, $pos+2);
								$prd=$this->mod_cart->select_from('products', array('prd_id'=>$id));
								$by_id=$_SESSION['MT']['by_id'];
								
								if($prd['prd_amount'] > 0 && $num > 0)
								{
									$data['min'][$key] = 1;
									
									$data['prd_num'][]=substr($value, $pos+2);
									if($bdata['d_spec_type']==1){
										$data['prd_total'][]=$prd_total=($prd['d_mprice'] * $num);
										$prd['prd_price00'] = $prd['d_mprice'];
									}else{
										$data['prd_total'][]=$prd_total=($prd['prd_price00'] * $num);
										$prd['prd_price00'] = $prd['prd_price00'];
									}
									$data['prd'][]=$prd;

									$data['total']+=$prd_total;
								}
								else
								{
									unset($user_cart[$key]);
									$data['user_cart_num']=count($user_cart);
								}
							
								//20160706-撈取以購買數量
								$snum=$this->mod_cart->get_order_num($by_id,$id);
								$data['snum'][$key]=$snum['osum'];
								//20160706-撈取以購買數量
							}
							$this->session->set_userdata('user_cart', $user_cart);
							$user_cart = $this->session->userdata('user_cart');

							// user data
							if($this->session->userdata('by_id'))
							{
								$data['by_id']    = $this->session->userdata('by_id');
								$data['buyer']	  = $this->mod_cart->select_from('buyer', array('by_id'=>$this->session->userdata('by_id')));
								$data['history']  = $this->mod_cart->get_history($this->session->userdata('by_id'));
							}
							else
							{
								$data['by_id'] = 0;
							}

							//20160519-國鼎
							$data['by_id']=$_SESSION['MT']['by_id'];

							if($data['total'] != 0)
							{
								//view
								if($this->get_device_type() == 0)
								{//電腦版
									// language
									//語言包
									$this->lang=$this->lmodel->config('22',$this->setlang);
									foreach ($this->lang as $key => $value) {
										$data[$key]=$value;
									}
										// $this -> lang -> load('views/cart/cart_list', $data['lang']);
										// $data['_SignIn'] = lang('_SignIn');
										// $data['MailThereafterLogin'] = lang('MailThereafterLogin');
										// $data['Subtotal'] = lang('Subtotal');
										// $data['Yuan'] = lang('Yuan');
										// $data['Phone'] = lang('Phone');
										// $data['PaymentMethods'] = lang('PaymentMethods');
										// $data['DeliveryMethod'] = lang('DeliveryMethod');
										// $data['Altogether'] = lang('Altogether');
										// $data['BackStoreHome'] = lang('BackStoreHome');
										// $data['Address'] = lang('Address');
										// $data['ReceiverInformation'] = lang('ReceiverInformation');
										// $data['ThisNumberPasseword'] = lang('ThisNumberPasseword');
										// $data['RemoveItem'] = lang('RemoveItem');
										// $data['FullName'] = lang('FullName');
										// $data['Mailbox'] = lang('Mailbox');
										// $data['MailFillInCorrect'] = lang('MailFillInCorrect');
										// $data['Inventory_shortage'] = lang('Inventory_shortage');
										// $data['Commodity'] = lang('Commodity');
										// $data['HistoricalOrderDeta'] = lang('HistoricalOrderDeta');
										// $data['ExcessiveNumber'] = lang('ExcessiveNumber');
										// $data['TongBian'] = lang('TongBian');
										// $data['UnitPrice'] = lang('UnitPrice');
										// $data['SignIn_2'] = lang('SignIn_2');
										// $data['SignOut'] = lang('SignOut');
										// $data['InvoiceAddress'] = lang('InvoiceAddress');
										// $data['InvoiceTitle'] = lang('InvoiceTitle');
										// $data['CheckoutPage'] = lang('CheckoutPage');
										// $data['Item'] = lang('Item');
										// $data['Shipment'] = lang('Shipment');
										// $data['PreviewOrder'] = lang('PreviewOrder');
										// $data['Quantity'] = lang('Quantity');
										// $data['QuantityNot0'] = lang('QuantityNot0');
										// $data['ScanQuantity'] = lang('ScanQuantity');
										// $data['Select'] = lang('Select');
										// $data['HistoricalOrderDetails'] = lang('HistoricalOrderDetails');
										// $data['ShoppingDetail'] = lang('ShoppingDetail');
										// $data['Change'] = lang('Change');
										// $data['SameAddress'] = lang('SameAddress');
									$this->load->view('cart/cart_list', $data);
								}
								else
								{//手機版
									// 地址
									$data['tw_county']=$this->mod_cart->get_county();
									//語言包
									$this->lang=$this->lmodel->config('22',$this->setlang);
									// print_r($this->lang);
									foreach ($this->lang as $key => $value) {
										$data[$key]=$value;
									}
									// language
										// $this -> lang -> load('views/cart/mcart_list', $data['lang']);
										// $data['_SignIn'] = lang('_SignIn');
										// $data['Phone'] = lang('Phone');
										// $data['Yuan'] = lang('Yuan');
										// $data['PaymentMethods'] = lang('PaymentMethods');
										// $data['DeliveryMethod'] = lang('DeliveryMethod');
										// $data['Altogether'] = lang('Altogether');
										// $data['Address'] = lang('Address');
										// $data['ReceiverInformation'] = lang('ReceiverInformation');
										// $data['RemoveItem'] = lang('RemoveItem');
										// $data['FullName'] = lang('FullName');
										// $data['Return'] = lang('Return');
										// $data['Mailbox'] = lang('Mailbox');
										// $data['MailFillInCorrect'] = lang('MailFillInCorrect');
										// $data['CommodityStocksAlert'] = lang('CommodityStocksAlert');
										// $data['OrderPreview'] = lang('OrderPreview');
										// $data['Refresh'] = lang('Refresh');
										// $data['HistoricalOrderDeta'] = lang('HistoricalOrderDeta');
										// $data['TongBian'] = lang('TongBian');
										// $data['SignIn_2'] = lang('SignIn_2');
										// $data['InvoiceAddress'] = lang('InvoiceAddress');
										// $data['InvoiceTitle'] = lang('InvoiceTitle');
										// $data['_CheckoutPage'] = lang('_CheckoutPage');
										// $data['PostalCode'] = lang('PostalCode');
										// $data['Item'] = lang('Item');
										// $data['FillOrderingInformation'] = lang('FillOrderingInformation');
										// $data['Quantity'] = lang('Quantity');
										// $data['DataSend'] = lang('DataSend');
										// $data['CorrectFormat'] = lang('CorrectFormat');
										// $data['Select'] = lang('Select');
										// $data['SelectArea'] = lang('SelectArea');
										// $data['SelectCounties'] = lang('SelectCounties');
										// $data['HistoricalOrderDetails'] = lang('HistoricalOrderDetails');
										// $data['ShoppingDetail'] = lang('ShoppingDetail');
										// $data['SameAdress'] = lang('SameAdress');

									$this->load->view('cart/mcart_list', $data);
								}
							}
							else
							{
								$this->script_message($language['CartFormatError'], '/cart/store/'.$cset_code);
							}

							break;

						case 2:
							if(!$this->input->post())
							{
								$this->myredirect('/cart/check/'.$cset_code.'/1', $language['ShoppingListNoProduct'], 5);
								return 0;
							}

							//語言包
							$this->lang=$this->lmodel->config('23',$this->setlang);


							// 預覽送出資訊確認
							$data['post']=$this->input->post();
							// 目前購物車內容與總額
							$data['user_cart_num']=count($user_cart);

							foreach($user_cart as $key => $value)
							{
								$pos=strpos($value, '*#');
								$id=substr($value, 0, $pos);
								$num=substr($value, $pos+2);
								$prd=$this->mod_cart->select_from('products', array('prd_id'=>$id));
								if($prd['prd_amount'] > 0 && !empty($data['post']['buy']))
								{
									$prd['prd_image'] = $this->Spath.$prd['prd_image'];
									$data['prd_num'][] = $new_num = $data['post']['buy'][$key];
									if($data['post']['d_spec_type']==1){
										$data['prd_total'][]=$prd_total=($prd['d_mprice'] * $new_num);
										$prd['prd_price00'] = $prd['d_mprice'];
									}else{
										$data['prd_total'][]=$prd_total=($prd['prd_price00'] * $new_num);
										$prd['prd_price00'] = $prd['prd_price00'];

									}
									$data['prd'][]=$prd;

									$data['total']+=$prd_total;
									$prd_pv_total=($prd['prd_pv'] * $new_num);
									$data['total_pv']+=$prd_pv_total;
									$data['source_total'] += $prd_total;
									$user_cart[$key] = $id.'*#'.$new_num;
								}
								else
								{
									unset($user_cart[$key]);
									$data['user_cart_num']=count($user_cart);
								}
							}
							$this->session->set_userdata('user_cart', $user_cart);
							$user_cart = $this->session->userdata('user_cart');

							// 金流
							// $data['buyer_pay_way'] = $this->mod_cart->select_from('iqr_trans', array('iqrt_id'=>$data['post']['buyer_pay_way']));
							// $data['pway_info'] 	   = $this->mod_cart->select_from('payment_way', array('pway_id'=>$data['buyer_pay_way']['pway_id']));
							$data['buyer_pay_way'] = $this->mod_cart->select_from('payment_way', array('pway_id'=>$data['post']['buyer_pay_way']));
							$pway_info = $this->mod_cart->select_from('payment_way', array('pway_id'=>$data['post']['buyer_pay_way']));
							$pway_info['pway_name']=$this->lang['Pay'.$pway_info['pway_id'].''];
							$data['pway_info']=$pway_info;
							if($data['post']['buyer_pay_way']==4){
								$atminfo=$this->mymodel->GetConfig('atm');
								$data['atminfo']='
								<div style="text-align:left">
								'.$this->lang['bank'].'：'.$atminfo[3]['d_val'].'<br>
								'.$this->lang['accnum'].'：'.$atminfo[1]['d_val'].'<br>
								'.$this->lang['username'].'：'.$atminfo[0]['d_val'].'<br>
								</div>
								';
								//銀行 帳號 戶名
							}

							// 物流
							// $data['buyer_logist_way'] = $is_logistics = $this -> mod_cart -> select_from('iqr_logistics', array('iqrt_id' => $data['post']['buyer_logist_way']));
							$lway_info = $this -> mod_cart -> select_from('logistics_way', array('lway_id' =>$data['post']['buyer_logist_way']));
							$lway_info['lway_name']=$this->lang['Logis'.$lway_info['lway_id'].''];
							$data['lway_info'] = $lway_info;

							//門市取貨
							$shop_arr=$this->mymodel->OneSearchSql('member','shop_address',array('account'=>$data['post']['shop_id']));
							$data['shop']=':'.$shop_arr['shop_address'];

							//20160511-撈取會員紅利PV
							$bdata=$this->mymodel->OneSearchSql('buyer','d_is_member,d_dividend',array('by_id'=>$_SESSION['MT']['by_id']));
							$data['dividend']=($bdata['d_dividend']=='')?'0':$bdata['d_dividend'];

							//運費
							$cart_paying=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>$_POST['buyer_logist_way']));

							//免運金額
							$nopay=$this->mymodel->OneSearchSql('logistics_way','business_account',array('lway_id'=>'4'));
							if($data['total']>=$nopay['business_account'] && $nopay['active'] == 1){
								$data['nopay']=$this->lang['freetran'];	//'已達免運金額'
								$data['cart_paying']=0;
								//總金額
								$data['alltotal']=$data['total'];

							}else{
								$data['cart_paying']=$cart_paying['business_account'];
								//總金額
								$data['alltotal']=$data['total']+$lway_info['business_account'];
							}


							if($data['total'] != 0)
							{
								//view
								if($this->get_device_type() == 0)
								{ // 電腦版
									// language
									// print_r($this->lang);
									foreach ($this->lang as $key => $value) {
										$data[$key]=$value;
									}

										// $this -> lang -> load('views/cart/order_preview', $data['lang']);
										// $data['Subtotal'] = lang('Subtotal');
										// $data['Yuan'] = lang('Yuan');
										// $data['Phone'] = lang('Phone');
										// $data['PaymentMethods'] = lang('PaymentMethods');
										// $data['DeliveryMethod'] = lang('DeliveryMethod');
										// $data['Altogether'] = lang('Altogether');
										// $data['Address'] = lang('Address');
										// $data['ReceiverInformation'] = lang('ReceiverInformation');
										// $data['FullName'] = lang('FullName');
										// $data['ReturnModifyInformation'] = lang('ReturnModifyInformation');
										// $data['Mailbox'] = lang('Mailbox');
										// $data['TotalMoneyTWD'] = lang('TotalMoneyTWD');
										// $data['SendOrders'] = lang('SendOrders');
										// $data['Commodity'] = lang('Commodity');
										// $data['TongBian'] = lang('TongBian');
										// $data['UnitPrice'] = lang('UnitPrice');
										// $data['ProtectGoodsNum'] = lang('ProtectGoodsNum');
										// $data['InvoiceAddress'] = lang('InvoiceAddress');
										// $data['InvoiceTitle'] = lang('InvoiceTitle');
										// // $data['_CheckoutPage'] = lang('_CheckoutPage');
										// //20160526國鼎特殊要求
										// $data['_CheckoutPage']='確認訂單-';
										// $data['Item'] = lang('Item');
										// $data['Quantity'] = lang('Quantity');
										// $data['WillNotModified'] = lang('WillNotModified');
										// $data['NotFilledInvoice'] = lang('NotFilledInvoice');
										// $data['ShoppingDetail'] = lang('ShoppingDetail');
									$this->load->view('cart/order_preview', $data);
								}
								else
								{ // 手機版
									// language
									foreach ($this->lang as $key => $value) {
										$data[$key]=$value;
									}
										// $this -> lang -> load('views/cart/morder_preview', $data['lang']);
										// $data['_Subtotal'] = lang('_Subtotal');
										// $data['Yuan'] = lang('Yuan');
										// $data['_Phone'] = lang('_Phone');
										// $data['_PaymentMethods'] = lang('_PaymentMethods');
										// $data['_DeliveryMethod'] = lang('_DeliveryMethod');
										// $data['Altogether'] = lang('Altogether');
										// $data['_Address'] = lang('_Address');
										// $data['ReceiverInformation'] = lang('ReceiverInformation');
										// $data['_FullName'] = lang('_FullName');
										// $data['ReturnReFill'] = lang('ReturnReFill');
										// $data['_Mailbox'] = lang('_Mailbox');
										// $data['OrderSent'] = lang('OrderSent');
										// $data['OrderCheck'] = lang('OrderCheck');
										// $data['TotalMoneyTWD'] = lang('TotalMoneyTWD');
										// $data['SendOrders'] = lang('SendOrders');
										// $data['_TongBian'] = lang('_TongBian');
										// $data['ProtectGoodsNum'] = lang('ProtectGoodsNum');
										// $data['_InvoiceAddress'] = lang('_InvoiceAddress');
										// $data['_InvoiceTitle'] = lang('_InvoiceTitle');
										// // $data['CheckoutPage'] = lang('CheckoutPage');
										// //20160526國鼎特殊要求
										// $data['_CheckoutPage']='確認訂單-';
										// $data['Item'] = lang('Item');
										// $data['_Quantity'] = lang('_Quantity');
										// $data['WillNotModified'] = lang('WillNotModified');
										// $data['NotFilledInvoice'] = lang('NotFilledInvoice');
										// $data['ShoppingDetail'] = lang('ShoppingDetail');
									$this->load->view('cart/morder_preview', $data);
								}
							}
							else
							{
								$this->script_message($language['CartFormatError'], '/cart/store/'.$cset_code);
							}

							break;

						case 3:
							//語言包
							$this->lang=$this->lmodel->config('24',$this->setlang);

							ob_start();
							echo '<div style="font-size:2cm;padding-top:500px;">'.$this->lang['saleing'].'</div>';//"交易正在進行中，請稍後 ..."
					        ob_flush();
					        flush();
					  
							$current = '';
							foreach ($user_cart as $key => $value)
							{
								$strend = strpos($value, "*#");
								$prd_id = substr($value, 0, $strend);

								$prd_number = substr($value, $strend+2); // 訂購數量
								$products = $this -> mod_cart -> select_from('products', array('prd_id' => $prd_id));

								if($products['prd_active'] == 1 || $products['prd_active'] == 2)
								{
									$current = 2;
									$user_cart[$key] = "";
								}
								elseif($products['prd_active'] == 0 && $prd_number > $products['prd_amount'])
								{
									$current = 1;
									$user_cart[$key] = $prd_id."*#".$products['prd_amount'];
								}
								$orderstr.=$products['prd_name'].',';
							}
							$orderstr=$this->useful->del_string_last($orderstr);

							$this -> session -> set_userdata('user_cart',$user_cart);

							if($current == 1)
							{
								$this -> script_message($language['CommoditiesAlert'],'/cart/check/'.$cset_code.'/1');
							}
							elseif($current == 2)
							{
								$this -> script_message($language['AgainChooseCommodity'],'/cart/store/'.$cset_code);
							}

							if($current == '')
							{
								// 串金流-先寫入訂單但尚未成立
								// iqrt_id == 1 "貨到付款"  == 2 "Paypal 尚未付款"
								$order_date   = time();

								if($this -> input -> post('pway_id'))
								{
									if ($this -> input -> post('pway_id') == 8)
									{
										$status = 4;
										$product_flow = 8;
									}
									else
									{
										$status = 0;
										$product_flow = 0;
									}
								}

								// 購買人資料寫入, 回傳by_id
								// $by_id = $this->add_buyer($this->input->post('buyer_email'), $this->input->post('buyer_phone'), $this->session->userdata('user_login'));
								// 20160511-國鼎修正為by_id為登入者ID
								$by_id=$_SESSION['MT']['by_id'];
								// 20160511-國鼎修正為by_id為登入者ID
								// 庫存量修正與安全存量檢查
								$this->stocks_edit($user_cart, $order_date, $store);

								// 清空購物車
								$this->remove_cart();

								// $order_random_id = date('YmdHi', $order_date).$this->random_num_code(8);
								// 20160531 國鼎訂單編號
								$o_date=date('Ymd',$order_date);
								$otdata=$this->mymodel->select_page_form('`order`',' limit 0,1','order_id',array('SUBSTRING(order_id,1,8)'=>$o_date),'date','desc');
								if(!empty($otdata))
									$order_random_id=$otdata[0]['order_id']+1;
								else
									$order_random_id=$o_date.'0001';

								//20160803-員工價購買則不算獎金
								$d_status=($_POST['d_spec_type']==0)?'N':'Y';
								$insert_data = array(
									'by_id'				=> $by_id,
									'order_id'			=> $order_random_id,
									'details'			=> $this->set_serialstr($user_cart, '++'),
									'total_price'		=> ($this->input->post('total_price')-$_POST['subdivid']),
									'total_pv'			=> $this->input->post('total_pv'),
									'name'				=> $this->input->post('buyer_name'),
									'phone'				=> $this->input->post('buyer_phone'),
									'email'				=> $this->input->post('buyer_email'),
									'address'			=> $this->input->post('buyer_address'),
									'zip'				=> $this->input->post('addr_zip'),
									'county'			=> $this->input->post('addr_county'),
									'area'				=> $this->input->post('addr_area'),
									'receipt_title'		=> $this->input->post('receipt_title'),
									'receipt_code'		=> $this->input->post('receipt_code'),
									'receipt_zip'		=> $this->input->post('receipt_zip'),
									'receipt_county'	=> $this->input->post('receipt_county'),
									'receipt_area'		=> $this->input->post('receipt_area'),
									'receipt_address'	=> $this->input->post('receipt_address'),
									'iqrt_id'			=> $this->input->post('iqrt_id'),
									'lway_iqrt_id'		=> $this->input->post('lway_iqrt_id'),
									'lway_id'			=> $this->input->post('lway_id'),
									'lway_price'		=> $this->input->post('cart_fee'),
									'pay_way_id'		=> $this->input->post('pway_id'),
									'shop_id'			=> $this->input->post('shop_id'),
									'card_owner'		=> $store['member_id'],
									'date'				=> $order_date,
									'status'			=> $status,
									'device_type'		=> substr($this->get_device_os(), 0, 3),
									'create_time'		=> date('Y-m-d'),
									'update_time'		=> $order_date,
									'd_status'		    => $d_status,

								);
			
								$bdata=$this->mymodel->OneSearchSql('buyer','PID,by_email',array('by_id'=>$by_id));
								
								//20160510/寫入MEMBER_ID(此帳號) 方便計算獎金 如果式經營會員就寫上線 如果一般會員就寫在哪購買
								// $mdata=$this->mymodel->OneSearchSql('member','member_id',array('by_id'=>$by_id));
								if($_SESSION['MT']['member_id']!=''){
									$mdata=$this->mymodel->OneSearchSql('member','upline',array('member_id'=>$_SESSION['MT']['member_id']));
									$imember=$mdata['upline'];
								}else{
									// 20170418-一般會員消費 獎金則計算給註冊APP ID
									$imember=$bdata['PID'];
								}

								$insert_data['member_id']=$imember;

								$oid = $this->mod_cart->insert_into('order', $insert_data);
								// if($data['post']['buyer_pay_way']!=8){
									$config=$this->mymodel->GetConfig('','73');
									//20160512-國鼎-紅利明細寫入
									//得到紅利
									$get_bonus=floor($_POST['alltotal']*($config['d_val']/100));
					
									$iaddata=array(
										'OID'=>$oid,
										'buyer_id'=>$by_id,
										'd_type'=>'19',
										'd_val'=>$get_bonus,
										'd_des'=>''.$this->lang['ordnum'].' ['.$order_random_id.'] - '.$this->lang['produs'].'：'.$orderstr,
										'is_send'=>'N',
										'create_time'=>$this->useful->get_now_time(),
										'update_time'=>$this->useful->get_now_time(),
									);
									// 訂單號碼 商品

									$isddata=array(
										'OID'=>$oid,
										'buyer_id'=>$by_id,
										'd_type'=>'20',
										'd_val'=>$_POST['subdivid'],
										'd_des'=>''.$this->lang['ordnum'].' ['.$order_random_id.'] - '.$this->lang['produs'].'：'.$orderstr,
										'create_time'=>$this->useful->get_now_time(),
										'update_time'=>$this->useful->get_now_time(),
									);

									$ddata=$this->mymodel->OneSearchSql('buyer','d_dividend',array('by_id'=>$by_id));

									if($ddata['d_dividend']<$_POST['subdivid']){
										$this->useful->AlertPage('',$this->lang['suberror']);
										return '';
									}else{
										// 2017-04-18 員工價不得到紅利
										if($d_status=='N')
											$this->mymodel->insert_into('dividend',$iaddata);

										if($_POST['subdivid']!=0){
											
											$this->mymodel->insert_into('dividend',$isddata);

											$dividend=$ddata['d_dividend']-$_POST['subdivid'];
											$this->mymodel->update_set('buyer','by_id',$by_id,array('d_dividend'=>$dividend));
										}
									}

									//20160512-國鼎-紅利明細寫入

									//20160513-將折扣寫入資料庫
									if($_POST['subdivid']!=0){
										$sdata=array(
											'OID'=>$oid,
											'bonus_sub'=>$_POST['subdivid'],
											'total_price'=> $this->input->post('total_price'),
											'create_time'=>$this->useful->get_now_time(),
										);
										$this->mymodel->insert_into('order_sub',$sdata);
									}
									//20160513-將折扣寫入資料庫
								// }
								$this -> mod_cart -> trigger_prd_detail($user_cart, $oid, $by_id, $order_random_id, $order_date, $store['member_id']);

								//將信箱改為購買人信箱
								$mail=$bdata['by_email'];


								// 訂單紀錄寄信
								$this->order_mail($order_random_id, $this->input->post('iqrt_id'), $this->input->post('buyer_email'), $user_cart, $cset_code, $order_date);
								// $this->order_mail($order_random_id, $this->input->post('iqrt_id'), $mail, $user_cart, $cset_code, $order_date);
								// 20160527
								$this -> load -> model('order_model', 'omodel');
								$host = $this -> get_host_config();
								// if ($status != 4)
								// 	$this -> omodel -> send_mail($oid, $host);

								// 付款選擇前往
								switch ($this->input->post('pway_id'))
								{
									case 1: //貨到付款
										$this->script_message($language['OrderCompletion'], '/cart/store/'.$cset_code);
										break;

									case 2: //paypal
										$this->script_message($language['NotPaymentImmediately'], '/paypal/form/'.$cset_code.'/'.$oid.'/'.$order_random_id);
										break;

									case 3:	//sun tech
										$this->script_message($language['NotPaymentImmediately'], '/cart/suntech/'.$cset_code);
										break;
									case 4: // ATM
										$this -> script_message($language['PaymentImmediately'], '/cart/store/'.$cset_code);
										break;
									case 5: // allpay
										$this->script_message($language['NotPaymentImmediately'], '/allpay/trade/'.$cset_code.'/'.$oid.'/'.$order_random_id);
										break;
									case 6: // gomypay 線上刷卡
										$this->script_message($language['NotPaymentImmediately'], '/gomypay/trade/'.$cset_code.'/'.$oid.'/'.$order_random_id);
										break;
									case 7: // Esun 刷卡
										$this->script_message($language['NotPaymentImmediately'], '/esun/trade/'.$cset_code.'/'.$oid.'/'.$order_random_id);
										break;
									case 8: // 台新刷卡
										$this -> script_message($language['NotPaymentImmediately'], '/taishin/transaction/' . $oid);
										break;
								}
							}
							break;
					}
				}
				else
				{
					echo '<script>';
					echo 'alert("'.$language['ShoppingListNoProduct'].'");';
					echo 'window.location.href="/cart/store/'.$cset_code.'";';
					echo '</script>';
				}
			}
		}else{
			echo '<script>';
			echo 'alert("請先登入會員");';
			echo 'window.location.href="/gold/login/shop";';
			echo '</script>';
			//$this->useful->AlertPage('/gold/login/shop');

		}
	}

	//-----------------------------------------------------------------------------------
	// login : 會員機制登入
	//-----------------------------------------------------------------------------------
	// 購物使用者登入選擇器
	public function login_switch($cset_code='')
	{
		$data=$this->data;
		$language = $this -> language;
		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		if(empty($store) || !$store['cset_active'])
		{
			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url = substr(base_url(), 7);
				$base_url = substr($base_url, 0, -1);
				$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$iqr_url = base_url().'business/iqr/'.$member['account'];
			}

			//無此商店
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			return 0;
		}
		else
		{
			//data

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			if($cset_code != '')
			{
				$data['get_device_type'] = $this->get_device_type();
				$data['cset_code']=$cset_code;
				if(!$this->session->userdata('user_login')) // 未登入
					$this->load->view('cart/login_switch', $data);
				else // 已登入
					redirect('/cart/check/'.$cset_code.'/1');
			}
			else
			{
				redirect('/index/error');
			}
		}
	}

	// 行動使用者選擇器
	public function mobile_switch($cset_code='')
	{
		$language = $this -> language;
		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		if(empty($store) || !$store['cset_active'])
		{
			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url = substr(base_url(), 7);
				$base_url = substr($base_url, 0, -1);
				$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$iqr_url = base_url().'business/iqr/'.$member['account'];
			}

			//無此商店
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			// language
				$this -> lang -> load('views/cart/mobile_switch', $data['lang']);
				$data['BackHome'] = lang('BackHome');
				$data['OrderTracking'] = lang('OrderTracking');
				$data['_SignOut'] = lang('_SignOut');
				$data['SelectOperating'] = lang('SelectOperating');

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			if($cset_code != '')
			{
				$data['get_device_type'] = $this->get_device_type();
				$data['cset_code'] 		 = $cset_code;
				$data['user_login'] 	 = $this->session->userdata('user_login');

				$this->load->view('cart/mobile_switch', $data);
			}
			else
			{
				redirect('/index/error');
			}
		}
	}

	// 購物使用者登入
	public function user_login($cset_code='', $return='')
	{
		//data
		$language = $this -> language;
		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		if(empty($store) || !$store['cset_active'])
		{
			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url = substr(base_url(), 7);
				$base_url = substr($base_url, 0, -1);
				$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$iqr_url = base_url().'business/iqr/'.$member['account'];
			}

			//無此商店
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			return 0;
		}
		else
		{
			$data=$this->data;
			// language
			$this -> lang -> load('views/cart/user_login', $data['lang']);
			$data['Mailbox'] = lang('Mailbox');
			$data['PasswordPhone'] = lang('PasswordPhone');
			$data['Password'] = lang('Password');
			$data['SignIn_1'] = lang('SignIn_1');
			$data['BuyerLogin'] = lang('BuyerLogin');

			$data['cset_code'] 		= $cset_code;
			$data['return']			= $return;
			$data['return_url'] 	= ($return == 'check' && $return != 'mobile') ? '/cart/'.$return.'/'.$cset_code.'/1' : '/cart/store/'.$cset_code;
			$data['return_button']  = ($return == 'check' && $return != 'mobile') ? $language['DirectCheckout'] : $language['_Return'];

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			if(!$this->session->userdata('user_login')) // 未登入
			{
				if(!$this->input->post('by_email') && !$this->input->post('by_pw'))
				{
					$data['get_device_type'] = $this->get_device_type();

					//view
					$this->load->view('cart/user_login', $data);
				}
				else
				{
					$buyer = $this->mod_cart->select_from('buyer', array('by_email'=>$this->input->post('by_email')));

					if(!empty($buyer) && strnatcmp($this->input->post('by_pw'), $buyer['by_pw']) == 0)
					{
						$this->session->set_userdata('by_email', $this->input->post('by_email'));
						$this->session->set_userdata('by_id', $buyer['by_id']);
						$this->session->set_userdata('user_login', 1);
						if($return == 'check') // 返回撈結帳資料指令
						{
							$this->myredirect('/cart/check/'.$cset_code.'/1', '', 5);
						}
						else // 進入帳單查詢
						{
							if($return == 'record')
								$this->myredirect('/cart/record/'.$cset_code, '', 5);
							else
								$this->myredirect('/cart/store/'.$cset_code, '', 5);
						}
					}
					else
					{ // 登入失敗
						$this->session->unset_userdata('by_email');
						$this->session->set_userdata('user_login', 0);
						$this->script_message($language['InformationError'],'/cart/user_login/'.$cset_code);
						// $this->myredirect('/cart/store/'.$cset_code, '', 5);
					}
					return 0;
				}
			}
			else // 已登入
			{
				if($return == 'record')
					redirect('/cart/record/'.$cset_code);
				else
					redirect($data['return_url']);
			}
		}
	}

	// 購物使用者登出
	public function user_logout($cset_code='', $return='')
	{
		$language = $this -> language;
		$this->session->unset_userdata('by_email');
		$this->session->unset_userdata('by_id');
		$this->session->unset_userdata('user_login');
		if($return == 'cart_list')
			$this->script_message($language['LogoutSuccessful'], '/cart/check/'.$cset_code.'/1');
		else
			$this->script_message($language['LogoutSuccessful'], '/cart/store/'.$cset_code);
	}

	// 購物車訂單查詢
	public function record($cset_code = '', $page = 1)
	{
		$language = $this -> language;
		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		if(empty($store) || !$store['cset_active'])
		{
			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url = substr(base_url(), 7);
				$base_url = substr($base_url, 0, -1);
				$iqr_url  = 'http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$iqr_url = base_url().'business/iqr/'.$member['account'];
			}

			//無此商店
			$this->script_message($language['ActionNotEnabledStore'], $iqr_url);
			return 0;
		}
		else
		{
			if(!$this->session->userdata('user_login')) // 未登入
			{
				$this->myredirect('/cart/user_login/'.$cset_code.'/record', '', 5);
				return 0;
			}
			else
			{ // 查詢訂購紀錄

				$data = $this->data; // data

				$data['buyer'] = $buyer = $this->mod_cart->select_from('buyer', array('by_email'=>$this->session->userdata('by_email')));
				$data['order'] = $order = $this->mod_cart->select_from_order('order', 'date', 'asc', array('card_owner'=>$store['member_id'], 'by_id'=>$buyer['by_id']));

				// cart setting
				$data['store'] = $store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
				$data['cset_code'] = $cset_code;
				$data['cart_link'] = base_url().'cart/store/'.$store['cset_code'];

				//has login
				$data['user_login'] = $this->session->userdata('user_login');

				// 換頁設定
				$page_uri 	= 'cart/record/'.$cset_code;
		   		$total_rows = count($data['order']);
		   		$per_page	= 8;
				$config  	= $this->init_pagination($page_uri, $total_rows, $per_page, 4);

				// 排序條件
				if($this->input->get('ob') && $this->input->get('ot'))
				{
					$order_by   = $this->input->get('ob');
					$order_type = $this->input->get('ot');
				}
				else
				{
					$order_by   = 'date';
					$order_type = 'asc';
				}

		   		// 每頁資料設定
				$start_id 			  = (($page-1) * $per_page);
				$real_page_num 		  = $per_page;
				$data['page_data'] 	  = $this->mod_cart->get_range_data('order', $order_by, $order_type, $start_id, $real_page_num, array('card_owner'=>$store['member_id'], 'by_id'=>$buyer['by_id']));
				$data['page_config']  = $config;
				$data['page']		  = $page;

				if(empty($data['page_data']))
				{
					header('Location: /cart/store/'.$cset_code);
				}
				else
				{

				}

				// string replace
				$create_links=str_replace('&lsaquo;', '第一頁', $this->pagination->create_links());
				$create_links=str_replace('&rsaquo;', '最末頁', $create_links);
				$data['create_links']=$create_links;

				// 訂單狀態
				//---------------------------------------------------------
				// 0	待確認
				// 1	處理中
				// 2	付款待確認
				// 3	收到付款
				// 4	出貨準備中
				// 5	已出貨
				// 6	取消訂單
				// 7	退貨
				//---------------------------------------------------------
				foreach($data['page_data'] as $key => $value)
				{
					switch ($value['status']) {
						// case 0: $data['product_flow'][$key] = '待確認'; 	break;
						// case 1: $data['product_flow'][$key] = '處理中'; 	break;
						// case 2: $data['product_flow'][$key] = '付款待確認'; break;
						// case 3: $data['product_flow'][$key] = '收到付款'; 	break;
						// case 4: $data['product_flow'][$key] = '出貨準備中'; break;
						// case 5: $data['product_flow'][$key] = '已出貨'; 	break;
						// case 6: $data['product_flow'][$key] = '取消訂單'; 	break;
						// case 7: $data['product_flow'][$key] = '退貨'; 		break;
						case 0: $data['status'][$key] = $language['Unpaid'];   	break;
						case 1: $data['status'][$key] = $language['AlreadyPaid'];     break;
						case 2: $data['status'][$key] = $language['Refund'];   	break;
					}

					// 付款方式
					$payment_way = $this->mod_cart->select_from('payment_way', array('pway_id'=>$value['pay_way_id']));
					$data['pway_name'][$key] = $payment_way['pway_name'];
					if($value['pay_way_id'] > 1)
						$data['pway_name'][$key] .= ' ('.$payment_way['pway_code'].')';
				}

				//裝置判斷分享bar hideen
				if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
					$data['share_bar_hidden'] = 0;
				$data['android_d'] = $this->input->get('d');

				// view
				if($this->get_device_type() == 0)
				{ // 電腦版
					// language
						$this -> lang -> load('views/cart/record', $data['lang']);
						$data['Yuan_TWD'] = lang('Yuan_TWD');
						$data['PaymentStatus'] = lang('PaymentStatus');
						$data['OpenOrderDetails'] = lang('OpenOrderDetails');
						$data['BackStoreHome'] = lang('BackStoreHome');
						$data['OrderStatus'] = lang('OrderStatus');
						$data['OrderTracking'] = lang('OrderTracking');
						$data['OrderNum'] = lang('OrderNum');
						$data['OrderDetails_1'] = lang('OrderDetails_1');
						$data['NoOrders'] = lang('NoOrders');
						$data['_SignMail'] = lang('_SignMail');
						$data['CartHas'] = lang('CartHas');
						$data['ShoppingDetail'] = lang('ShoppingDetail');
						$data['Items'] = lang('Items');
						$data['Logout'] = lang('Logout');
						$data['Login'] = lang('Login');
					$this->load->view('cart/record', $data);
				}
				else
				{ // 手機版
					// language
						$this -> lang -> load('views/cart/mrecord', $data['lang']);
						$data['PaymentStatus'] = lang('PaymentStatus');
						$data['OpenOrderDetails'] = lang('OpenOrderDetails');
						$data['OrderStatus'] = lang('OrderStatus');
						$data['OrderTracking'] = lang('OrderTracking');
						$data['OrderNum_Click'] = lang('OrderNum_Click');
						$data['NoOrders'] = lang('NoOrders');
						$data['_SignMail'] = lang('_SignMail');
					$this->load->view('cart/mrecord', $data);
				}
			}
		}
	}

	// 訂購人查看訂單明細
	public function record_detail($cset_code = '', $id)
	{
		$language = $this -> language;
		$data 		   	   = $this->data; // data
		$store 			   = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		$data['order'] 	   = $order = $this->mod_cart->select_from('order', array('card_owner'=>$store['member_id'], 'id'=>$id));
		$data['id']    	   = $id;
		$data['cset_code'] = $cset_code;

		// 訂單狀態 						付款狀態
		//---------------------------------------------------------
		// 0	新訂單 						0 	未付款
		// 1	處理中						1 	已付款
		// 2	已出貨						2 	退款
		// 3	取消訂單
		// 4	交易完成
		// 5	退貨
		// 6	換貨
		//---------------------------------------------------------
		switch ($order['status']) {
			case 0: $data['status'] = $language['Unpaid'];							break;
			case 1: $data['status'] = $language['AlreadyPaid'];						break;
			case 2: $data['status'] = $language['Refund'];							break;
		}
		switch ($order['product_flow']) {
			case 0: $data['product_flow'] = $language['NewOrder'];   				break;
			case 1: $data['product_flow'] = $language['Processing'];     			break;
			case 2: $data['product_flow'] = $language['Shipped'];   				break;
			case 3: $data['product_flow'] = $language['CancelOrder']; 				break;
			case 4: $data['product_flow'] = $language['TransactionComplete'];   	break;
			case 5: $data['product_flow'] = $language['Return'];         			break;
			case 6: $data['product_flow'] = $language['Exchanges'];   	  			break;
		}
		switch ($order['lway_id']) {
			case 0: $data['lway_name'] = '';										break;
			case 1: $data['lway_name'] = $language['PersonallyPickupNotSend'];		break;
			case 2: $data['lway_name'] = $language['DeliveryShipping'];				break;
			case 3: $data['lway_name'] = $language['MailRegistration'];				break;
		}

		// 付款方式
		$payment_way = $this->mod_cart->select_from('payment_way', array('pway_id'=>$order['pay_way_id']));
		$data['pway_name'] = $payment_way['pway_name'];
		if($order['pay_way_id'] > 1 && $order['status'] != 1)
			$data['pway_name'] .= ' ('.$payment_way['pway_code'].')';

		// 物流方式
		$logistics_way = $this -> mod_cart -> select_from('logistics_way', array('lway_id' => $order['lway_id']));
		$data['lway_name'] = $logistics_way['lway_name'];
		// 商品明細
		$items = $this->get_serialstr($order['details'], '++');
		foreach($items as $key => $value)
		{
			$sort    = $key + 1;
			$details = explode('*#', $value);
			$prd 	 = $this->mod_cart->select_from('products', array('prd_id' => $details[0])); // 產品資料
		    $data['items'][$key]['amount'] 	 = $prd['prd_price00']; // 價錢
		    $data['items'][$key]['name'] 	 = $prd['prd_name']; 	// 品名
		    $data['items'][$key]['quantity'] = $details[1]; 		// 數量
		    $total += $prd['prd_price00'] * $details[1];
		}
		if($order['lway_id'] != '' && $order['lway_iqrt_id'] != '' && !empty($logistics_way))
		{
			if($order['lway_price'] == 0 )
				$data['items'][$key+1]['amount'] = $language['FullFreeShipping'];
			else
				$data['items'][$key+1]['amount'] = $order['lway_price'];

			if($order['lway_id'] == 1)
				$data['items'][$key+1]['amount'] = $language['FreeShipping'];

			$fee = $order['lway_price'];
			$data['items'][$key+1]['name'] = $logistics_way['lway_name'];
			$data['items'][$key+1]['quantity'] = 1;
		}
		$data['total'] = $total + $fee;

		// 結帳資訊
		$data['pay_way_id'] = $order['pay_way_id'];
		$data['pay_status'] = false;
		switch ($order['pay_way_id']) {
		 	case 2: // paypal
		 		$ipn = $this->mod_cart->select_from('ipn', array('order_id'=>$order['order_id']));
		 		if(!empty($ipn)) $data['pay_status'] = true;
		 		break;
		 	case 5: //Allpay
		 		$allpay_trade_log = $this -> mod_cart -> select_from('allpay_trade_log', array('trade_no' => $order['trade_no']));
		 		if(!empty($allpay_trade_log))
		 			$data['pay_status'] = true;
		 		break;
		 	case 6: // Gomypay 線上刷卡
		 		$gomypay_trade_log = $this -> mod_cart -> select_from('gomypay_trade_log', array('e_orderno' => $order['trade_no']));
		 		if(!empty($gomypay_trade_log))
		 			$data['pay_status'] = true;
		 		break;
		 	case 7: // Esun
		 		$esun_trade_log = $this -> mod_cart -> select_from('esun_credit_log', array('ONO' => $order['trade_no']));
		 		if(!empty($esun_trade_log))
		 			$data['pay_status'] = true;
		 		break;
		}

		//裝置判斷分享bar hideen
		if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
			$data['share_bar_hidden'] = 0;
		$data['android_d'] = $this->input->get('d');

		// view
		if($this->get_device_type() == 0)
		{ // 電腦版
			// language
				$this -> lang -> load('views/cart/record_detail', $data['lang']);
				$data['Subtotal'] = lang('Subtotal');
				$data['AlreadyPaid'] = lang('AlreadyPaid');
				$data['Yuan'] = lang('Yuan');
				$data['PaymentMethod'] = lang('PaymentMethod');
				$data['Unpaid'] = lang('Unpaid');
				$data['ReceiverAddress'] = lang('ReceiverAddress');
				$data['ReceiverName'] = lang('ReceiverName');
				$data['ReceiverPhone'] = lang('ReceiverPhone');
				$data['_CreationDate'] = lang('_CreationDate');
				$data['ClickPayment'] = lang('ClickPayment');
				$data['_OrderDetails'] = lang('_OrderDetails');
				$data['OrderDetailsNo'] = lang('OrderDetailsNo');
				$data['OrderStatus'] = lang('OrderStatus');
				$data['OrderProductDetails'] = lang('OrderProductDetails');
				$data['ProductName'] = lang('ProductName');
				$data['YourEmail'] = lang('YourEmail');
				$data['TongBian'] = lang('TongBian');
				$data['InvoiceAddress'] = lang('InvoiceAddress');
				$data['InvoiceTitle'] = lang('InvoiceTitle');
				$data['InvoiceInformation'] = lang('InvoiceInformation');
				$data['Price'] = lang('Price');
				$data['Quantity'] = lang('Quantity');
				$data['_TotalAmount'] = lang('_TotalAmount');
				$data['CloseWindow'] = lang('CloseWindow');
			$this->load->view('cart/record_detail', $data);
		}
		else
		{ // 手機版
			// language
				$this -> lang -> load('views/cart/mrecord_detail', $data['lang']);
				$data['Subtotal'] = lang('Subtotal');
				$data['AlreadyPaid'] = lang('AlreadyPaid');
				$data['Yuan'] = lang('Yuan');
				$data['PaymentMethod'] = lang('PaymentMethod');
				$data['Unpaid'] = lang('Unpaid');
				$data['PickupMode'] = lang('PickupMode');
				$data['CreationDate'] = lang('CreationDate');
				$data['OrderDetails'] = lang('OrderDetails');
				$data['_OrderDetails'] = lang('_OrderDetails');
				$data['OrderStatus'] = lang('OrderStatus');
				$data['OrderNum'] = lang('OrderNum');
				$data['UsuallyPeopleAddress'] = lang('UsuallyPeopleAddress');
				$data['UsuallyPeopleName'] = lang('UsuallyPeopleName');
				$data['UsuallyPeopleMail'] = lang('UsuallyPeopleMail');
				$data['UsuallyPeoplePhone'] = lang('UsuallyPeoplePhone');
				$data['OrderProductDetails'] = lang('OrderProductDetails');
				$data['ProductName'] = lang('ProductName');
				$data['_TongBian'] = lang('_TongBian');
				$data['_InvoiceAddress'] = lang('_InvoiceAddress');
				$data['_InvoiceTitle'] = lang('_InvoiceTitle');
				$data['InvoiceInformation'] = lang('InvoiceInformation');
				$data['Price'] = lang('Price');
				$data['Quantity'] = lang('Quantity');
				$data['TotalAmount'] = lang('TotalAmount');
				$data['CloseWindow'] = lang('CloseWindow');
				$data['GoToPay'] = lang('GoToPay');
			$this->load->view('cart/mrecord_detail', $data);
		}
	}

	//-----------------------------------------------------------------------------------
	// function : 操作功能
	//-----------------------------------------------------------------------------------
	// 加入商品到購物車
	public function add_to_cart()
	{
		$language = $this -> language;
		//未登入者請先登入
		if($_SESSION['MT']['by_id']!='' ){
			if($this->input->post('prd_id') && $this->input->post('prd_num'))
			{
				//商品合法性
				$prd = $this->mod_cart->select_from('products', array('prd_id'=>$this->input->post('prd_id')));
				//20160525 -判斷是否為限購商品並是否以買過
				if($prd['restrice_num']!='0'){
					$by_id=$_SESSION['MT']['by_id'];
					$snum=$this->mod_cart->get_order_num($by_id,$this->input->post('prd_id'));
					if($prd['restrice_num']<=$snum){
						echo 'Noshop';	//超過限購數
						return '';
					}
				}
				if(!empty($prd))
				{
					if($prd['prd_active'] == 1 || $prd['prd_amount'] <= 0) // 庫存不足
					{
                        echo 'deficient';
                        return '';

                    }

					if($prd['prd_active'] == 0) // 尚有庫存
					{
						//陣列尚未建立
						if(!is_array($this->session->userdata('user_cart')))
						{
							$user_cart=array();
							array_push($user_cart, $this->input->post('prd_id').'*#'.$this->input->post('prd_num'));
							echo 'adding';
						}
						else
						{
							// 新增商品到陣列中
							// 檢查是否有重複商品id，若有
							// 檢查結帳銷貨數量
							// 若數量足夠則疊加，不足則返回實際數量已不足
							// 1. 訂購數量已達庫存上限
							// 2. 加入合法數量到session cart中
							// 3. 商品不足或下架
							$insert = 1;
							$user_cart = $this->session->userdata('user_cart');
							foreach($user_cart as $key => $value)
							{
								$pos = strpos($value, '*#');
								$id  = substr($value, 0, $pos);
								$num = substr($value, $pos+2);
								if($id == $this->input->post('prd_id'))
								{
									$insert=0; // 相等
									$temp_num = ($this->input->post('prd_num')+$num);

									// 1. limited
									if($prd['prd_lock_amount'] < $temp_num)
									{ // 超出單次購買數量最大值
										$user_cart[$key]=$this->input->post('prd_id').'*#'.$prd['prd_lock_amount'];
										echo 'limited';
										break;
									}
									else
									{ // 2. adding
										$user_cart[$key]=$this->input->post('prd_id').'*#'.$temp_num;
										echo 'adding';
										break;
									}
								}
								continue;
							}
							if($insert == 1)
							{
								array_push($user_cart, $this->input->post('prd_id').'*#'.$this->input->post('prd_num'));
								echo 'adding';
							}
						}
						$this->session->set_userdata('user_cart', $user_cart);
					}
					else
					{ // 3. shrot of
						echo 'deficient';
					}
				}
			}
		}else{
			echo 'NoLogin';
		}
	}

	// 取得目前商品數量與價格總數
	public function amount_and_price_get()
	{
		$language = $this -> language;
		$user_cart=$this->session->userdata('user_cart');
		$total_num=0;
		$total_price=0;

		$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$_SESSION['MT']['by_id']));

		if(!empty($user_cart)) // 購物車 cookies 不為空
		{
			foreach($user_cart as $key => $value)
			{
				$pos = strpos($value, '*#');
				$id  = substr($value, 0, $pos);
				$num = substr($value, $pos+2);
				$prd = $this->mod_cart->select_from('products', array('prd_id'=>$id));
				for($i = 0; $i < $num; $i++)
				{
					if($bdata['d_spec_type']==1)
						$total_price+=$prd['d_mprice'];
					else
						$total_price+=$prd['prd_price00'];
				}
				$total_num++;
			}
		}
		$result = array(
			'total_price' => $total_price,
			'total_num'	  => $total_num,
			'lock_amount' => $prd['prd_lock_amount']
			);
		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	// 檢查訂購數量是否符合庫存
	public function amount_check()
	{
		$language = $this -> language;
		$new_user_cart = $temp_user_cart = $user_cart = $this->session->userdata('user_cart');
		if(is_array($user_cart) && !empty($user_cart))
		{
			// 目前購物車內容與總額
			$changing = false;
			foreach($user_cart as $key => $value)
			{
				// 商品
				// 0. ok
				// 1. over_amount
				// 2. prepare_product
				// 3. del_product
				$pos = strpos($value, '*#');
				$id  = substr($value, 0, $pos);
				$num = substr($value, $pos+2);
				$prd = $this->mod_cart->select_from('products', array('prd_id'=>$id));
				if(!empty($prd))
				{
					switch ($prd['prd_active'])
					{
						case 0: // 尚有庫存
							if($prd['prd_amount'] < $num) // 超出庫存最大值
							{
								$temp_user_cart[$key] = array(
									'id'	 =>	$id,
									'num'	 =>	$prd['prd_amount'],
									'status' =>	1
								); // 1. over_amount
								$new_user_cart[$key] = $id.'*#'.$prd['prd_amount'];
								$changing = true;
							}
							else
							{
								$temp_user_cart[$key] = array(
									'id'	 =>	$id,
									'num'	 =>	$num,
									'status' =>	0
								); // 0. ok
								$new_user_cart[$key] = $id.'*#'.$num;
							}
							break;
						case 1: // 庫存不足
							$temp_user_cart[$key] = array(
								'id'	 =>	$id,
								'num'	 =>	$num,
								'status' =>	2
							); // 2. prepare_product
							if($prd['prd_prepare_amount'] > ($num - $prd['prd_amount']))
								$new_user_cart[$key] = $id.'*#'.$num;
							else
								unset($new_user_cart[$key]);
							$changing = true;
							break;
						case 2: // 商品下架
							$temp_user_cart[$key] = array(
								'id'	 =>	$id,
								'num'	 =>	$num,
								'status' =>	3
							); // 3. del_product
							unset($new_user_cart[$key]);
							$changing = true;
							break;
					}
				}
			}
			$user_cart = '';
			$user_cart = $temp_user_cart;
			$this->session->set_userdata('user_cart', $new_user_cart);
			if($changing)
				echo json_encode($user_cart);
			else
				echo json_encode(array('result' => 1));
		}
	}

	// 取得訂購歷史資料
	public function order_history_get()
	{
		if($this->input->post('id'))
		{
			$order = $this->mod_cart->select_from('order', array('id'=>$this->input->post('id')));
	 		echo json_encode($order);
		}
	}

	// 變更購物車內商品
	public function cart_list_change($cset_code='', $ctrl='', $key)
	{
		$language = $this -> language;
		//找不到商店則導向首頁
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		if(empty($store) || !$store['cset_active'])
		{
			//無此商店
			$this->myredirect('/cart/store_setting/?start=1', $language['StoresNotEnabled'], 5);
			return 0;
		}
		else
		{
			if($key != '')
			{
				switch ($ctrl) {
					case 0:
						# delete product from cart
						$user_cart = array_values($this->session->userdata('user_cart'));
						unset($user_cart[$key]);
						$user_cart = array_merge($user_cart);
						$this->session->set_userdata('user_cart', $user_cart);
						break;
					case 1:
						# change product number
						break;
				}
				header('Location:/cart/check/'.$cset_code.'/1');
			}
			else
			{
				$this->myredirect('/cart/check/'.$cset_code.'/1', $language['DataLoss'], 5);
				return 0;
			}
		}
	}

	//-----------------------------------------------------------------------------------
	// 函數名：get_ytb_id($url)
	// 作 用 ：取得youtube影片網址中的id
	// 參 數 ：
	// $url 原始網址
	// 返回值：youtube id
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function get_ytb_id($url)
	{
		//去除首尾空白
		$url=trim($url);

		//youtu.be檢查
		if($pos = strpos($url, 'youtu.be') !== false)
		{
			$pos=strrpos($url, '/');
			$and_mark=strpos($url, '&');
			if($and_mark != false)
			{
				$id=substr($url, $pos+1, ($and_mark-$pos-1));
			}
			else
			{
				$id=substr($url, $pos+1);
			}
		}
		else if($pos = strpos($url, '?v=') !== false)
		{
			//後綴參數檢查
			$pos=strpos($url, '?v=');
			$and_mark=strpos($url, '&');
			if($and_mark != false)
			{
				$id=substr($url, $pos+3, ($and_mark-$pos-3));
			}
			else
			{
				$id=substr($url, $pos+3);
			}
		}
		else
		{
			$id='';
		}
		return $id;
	}

	//-----------------------------------------------------------------------------------
	// ajax : 非同步處理返回資料
	//-----------------------------------------------------------------------------------
	// ajax 返回縣市名稱
	public function get_county()
	{
		// 列出所有縣市
		$county = $this->mod_cart->get_county();
		$county_options .= '<option value="">'.$language['PleaseSelect'].'</option>';
		foreach($county as $key => $value)
		{
			$county_options .= '<option value="'.$value['county'].'">'.$value['county'].'</option>';
		}
		$result['county'] = $county_options;
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	// ajax 返回縣市地區名稱
	public function get_area()
	{
		// 列出所有縣市
		$county = $this->mod_cart->get_county();
		foreach($county as $key => $value)
		{
			$county_options .= '<option value="'.$value['county'].'">'.$value['county'].'</option>';
		}

		// 設定地區:
		// 收到郵遞區號
		if($this->input->post('zipcode'))
		{
			$target = $this->mod_cart->select_from('twzipcode', array('zipcode' => $this->input->post('zipcode')));				// 對應郵遞區號縣市地區
			$area = $this->mod_cart->select_from_order('twzipcode', 'zipcode', 'asc', array('county' => $target['county']));	// 對應郵遞區號縣市的所有地區
		}
		else if($this->input->post('county')) //收到縣市
		{
			$area = $this->mod_cart->select_from_order('twzipcode', 'zipcode', 'asc', array('county' => $this->input->post('county'))); // 對應郵遞區號縣市的所有地區
			$target['county'] = $this->input->post('county');
			$target['area']   = $area[0]['area'];
		}
		else if($this->input->post('id'))
		{
			$order  = $this->mod_cart->select_from('order', array('id'=>$this->input->post('id')));
			$target = $this->mod_cart->select_from('twzipcode', array('zipcode' => $order['zip'])); 							// 對應歷史紀錄的縣市地區
			$area   = $this->mod_cart->select_from_order('twzipcode', 'zipcode', 'asc', array('county' => $order['county'])); 	// 對應歷史紀錄的縣市的所有地區
			$area2  = $this->mod_cart->select_from_order('twzipcode', 'zipcode', 'asc', array('county' => $order['receipt_county'])); 	// 對應歷史紀錄的縣市的所有地區
			foreach($area2 as $key => $value)
			{
				$options2 .= '<option value="'.$value['area'].'">'.$value['area'].'</option>';
			}
			$result['options2'] = $options2;
			$result['order'] 	= $order;
		}
		foreach($area as $key => $value)
		{
			$options .= '<option value="'.$value['area'].'">'.$value['area'].'</option>';
		}

		$result['first'] 	= $area[0]['area'];
		$result['zipcode'] 	= $area[0]['zipcode'];
		$result['co'] 		= $county_options;
		$result['options'] 	= $options;
		$result['county'] 	= $target['county'];
		$result['area'] 	= $target['area'];

 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	// ajax 返回郵遞區號
	public function get_zipcode()
	{
		$zipcode = $this->mod_cart->select_from('twzipcode', array('county' => $this->input->post('county'), 'area' => $this->input->post('area')));
		echo $zipcode['zipcode'];
	}

	//-----------------------------------------------------------------------------------
	// check : 結帳處理流程
	// 1. order_mail 	寄信通知訂單成立
	// 2. add_buyer		新增購買人紀錄
	// 3. stocks_edit 	庫存量修正與安全存量檢查
	// 4. remove_cart 	清空購物車
	//-----------------------------------------------------------------------------------
	// 函數名：order_mail($timestamp, $pway_id, $buyer_email, $user_cart)
	// 作 用 ：訂單紀錄寄信
	// 參 數 ：
	// $timestamp 		時間戳記
	// $iqrt_id 		付款方式
	// $buyer_email 	訂購人email
	// $user_cart 		訂購項目
	// $productList 	訂購項目
	// $cset_code 		商店id
	// 返回值：無
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	private function order_mail($timestamp, $iqrt_id, $buyer_email, $productList, $timer)
	{ 
		//語言包
		$language=$this->lmodel->config('24',$this->setlang);
		// 寄信通知訂單紀錄
		// 主旨
		$subject = $language['OrderNumber'].':'.$timestamp.$language['OrderFormSystems'];
		// 商店
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_id'=>2));
		$order = $this -> mod_cart -> select_from('order', array('order_id' => $timestamp, 'email' => $buyer_email));
		//紅利折抵
		$config 				=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
		$dividendTurn			=	(int)$config['d_val'];
		$use_dividend_cost		=	$order['use_dividend']/$dividendTurn;

		//20160523 國鼎
		$pway_info = $this->mod_cart->select_from('payment_way', array('pway_id'=>$order['pay_way_id']));

		// 物流
		$iqr_logistics  = $this->mod_cart->select_from('iqr_logistics', array('iqrt_id'=>$order['lway_iqrt_id']));
		$logistics_info = $this->mod_cart->select_from('logistics_way', array('lway_id'=>$order['lway_id']));

		// 內容
		$message =		'<p>'.$language['NewOrderAtStoreInAction'].'</p>'.
						'<p><hr></p>'.
						'<p><h3>'.$language['OrderInformation'].'</h3></p>'.
						'<p>'.$language['OrderCreationDate'].''.date('Y年m月d日, H:i', $timer).'</p>'.
						'<p>'.$language['UsuallyPeople'].''.$order['name'].'</p>'.
						'<p>'.$language['UsuallyPeoplePhone'].''.$order['phone'].'</p>'.
						'<p>'.$language['UsuallyPeopleMailbox'].''.$order['email'].'</p>'.
						'<p>'.$language['UsuallyPeopleAddress'].''.$order['zip'].$order['county'].$order['area'].$order['address'].'</p>'.
						'<p>'.$language['PaymentMethod'].''.$pway_info['pway_name'].' ('.$pway_info['pway_code'].')</p>';
		//20160525-選擇ATM轉帳則寄出帳戶資料
		if($order['pay_way_id']==4){
			$cdata=$this->mymodel->GetConfig('atm');

			$message .= '<p>轉帳戶名:'.$cdata['0']['d_val'].'</p>'.
						'<p>轉帳分行:'.$cdata['3']['d_val'].'</p>'.
						'<p>轉帳代號:'.$cdata['2']['d_val'].'</p>'.
						'<p>轉帳帳號:'.$cdata['1']['d_val'].'</p>';
		}
		//20160525-選擇ATM轉帳則寄出帳戶資料
		if($iqr_trans['pway_id'] == 4)
			$message .= '<p>'.$language['RemittanceAccount'].''.$iqr_trans['business_account'].'</p>';
		if($order['lway_iqrt_id'] != '' && $order['lway_id'] != '')
			$message .= '<p>'.$language['DeliveryMethod'].''.$logistics_info['lway_name'].'</p>';

		$message .= '<p>'.$language['OrderDetails'].'</p>'.
					'<table style="border: 1px solid #333333;border-collapse: collapse;">'.
					'<tr><td style="padding:5px 10px;border: 1px solid #333333;">'.$language['ProductName'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Quantity'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Subtotal'].'(TWD)</tr>';
		/*
		foreach($user_cart as $key => $value)
		{
			$pos 	  = strpos($value, '*#');
			$id 	  = substr($value, 0, $pos);
			$num 	  = substr($value, $pos + 2);
			$prd 	  = $this->mod_cart->select_from('products', array('prd_id'=>$id));
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$prd['prd_name'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$num.'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.number_format($num * $prd['prd_price00']).'</tr>';
			$total 	 += ($num * $prd['prd_price00']);
		}*/
		foreach ($productList as $key => $value) {
			$insert_data = array(
					'oid'			=> $oid,
					'prd_id'		=> $value['prd_id'],
					'supplier_id'	=> $value['supplier_id'],
					'by_id'			=> $post_arr['by_id'],
					'order_id'		=> $order_id,
					'prd_name'		=> $value['prd_name'],
					'number'		=> $value['num'],
					'price'			=> $value['price'],
					'total_price'	=> $value['total'],
				);
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$value['prd_name'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$value['num'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$value['total'].'</tr>';
			$total 	 += $value['total'];
		}	
		if($order['pway_id'] != '' && $order['lway_id'] != '')
		{
			if($order['lway_price'] == 0)
				$fee_price = $language['ReachFreeShipping'];
			else
				$fee_price = $order['lway_price'];
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$language['Shipment'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">1<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$fee_price.'</tr>';
			$total = $total + $order['lway_price'];
		}
		$message .=	'<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;" colspan="2":>紅利折抵<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.number_format($use_dividend_cost).'元</tr>'.
					'<tr><td colspan="3" style="padding:5px 10px;border: 1px solid #333333;text-align:right; color:red; font-weight: blod;">'.$language['TotalPrice'].''.number_format($total).''.$language['NTDollars'].'</td></tr>'.
					'</table>'.
					'<p><hr></p>'.
					"<p>".$language['DoNotDirectlyReply']."</p>";
		//20180109
		$host = $this->get_host_config();
		$this->omodel->send_mail($order['id'],$host);

		// 寄信
		//$this->mod_index->send_mail($data['host']['domain'], $store['cset_name'], $buyer_email, $subject, $message);
        //$this->mod_index->SendMail($buyer_email, $subject, $message, $this->data['web_config']['title']);
		// 買家通知
		if($store['cset_email'] != '')
		{
			$time = date('Y-m-d',time());
			$title = $language['YouAreIn'].$time.$language['HaveSingleRecord'];
			//$this->mod_index->send_mail($data['host']['domain'], $store['cset_name'], $store['cset_email'], $title, $message);
            //$this->mod_index->SendMail($store['cset_email'], $title, $message, $data['web_config']['title']);

		}
	}

	private function test_mail($timestamp, $iqrt_id, $buyer_email, $user_cart, $cset_code, $timer)
	{
		$data = $this->data;
		$language = $this -> language;
		// 寄信通知訂單紀錄
		// 主旨
		$subject = $timestamp.$language['OrderFormSystems'];

		// 金流
		$iqr_trans = $this->mod_cart->select_from('iqr_trans', array('iqrt_id'=>$iqrt_id));
		$pway_info = $this->mod_cart->select_from('payment_way', array('pway_id'=>$iqr_trans['pway_id']));
		// 商店
		$store = $this->mod_cart->select_from('iqr_cart', array('cset_code'=>$cset_code));
		$order = $this -> mod_cart -> select_from('order', array('order_id' => $timestamp, 'email' => $buyer_email));

		// 物流
		$iqr_logistics  = $this->mod_cart->select_from('iqr_logistics', array('iqrt_id'=>$order['lway_iqrt_id']));
		$logistics_info = $this->mod_cart->select_from('logistics_way', array('lway_id'=>$order['lway_id']));

		// 折抵
		$order_sub = $this -> mod_cart -> select_from('order_sub', array('oid' => $order['id']));
		$timer = time();

		// 內容
		$message =		'<p>'.$language['NewOrderAtStoreInAction'].'</p>'.
						'<p><hr></p>'.
						'<p><h3>'.$language['OrderInformation'].'</h3></p>'.
						'<p>訂單編號：'.$order['order_id'].'</p>'.
						'<p>'.$language['OrderCreationDate'].''.date('Y年m月d日, H:i', $timer).'</p>'.
						'<p>'.$language['_UsuallyPeople'].''.$order['name'].'</p>'.
						'<p>'.$language['UsuallyPeoplePhone'].''.$order['phone'].'</p>'.
						'<p>'.$language['UsuallyPeopleMailbox'].''.$order['name'].'</p>'.
						'<p>'.$language['UsuallyPeopleAddress'].''.$order['zip'].$order['county'].$order['area'].$order['address'].'</p>'.
						'<p>'.$language['StoreName'].'{unwrap}<a href=\''.base_url().'cart/store/'.$cset_code.'\'>'.$store['cset_name'].'</a>{/unwrap}</p>'.
						'<p>'.$language['_PaymentMethod'].''.$pway_info['pway_name'].' ('.$pway_info['pway_code'].')</p>';
		if($iqr_trans['pway_id'] == 4)
			$message .= '<p>'.$language['RemittanceAccount'].''.$iqr_trans['business_account'].'</p>';
		if($order['lway_iqrt_id'] != '' && $order['lway_id'] != '')
			$message .= '<p>'.$language['DeliveryMethod'].''.$logistics_info['lway_name'].'</p>';

		$message .= 	'<p>'.$language['OrderDetails'].'</p>'.
						'<table style="border: 1px solid #333333;border-collapse: collapse;">'.
						'<tr><td style="padding:5px 10px;border: 1px solid #333333;">'.$language['ProductName'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Quantity'].'<td style="padding:5px 10px;border: 1px solid #333333;">'.$language['Subtotal'].'(TWD)</tr>'
		;
		foreach($user_cart as $key => $value)
		{
			$pos 	  = strpos($value, '*#');
			$id 	  = substr($value, 0, $pos);
			$num 	  = substr($value, $pos + 2);
			$prd 	  = $this->mod_cart->select_from('products', array('prd_id'=>$id));
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$prd['prd_name'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$num.'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.number_format($num * $prd['prd_price00']).'</tr>';
			$total 	 += ($num * $prd['prd_price00']);
		}
		if($order['lway_iqrt_id'] != '' && $order['lway_id'] != '')
		{
			if($order['lway_price'] == 0)
				$fee_price = $language['ReachFreeShipping'];
			else
				$fee_price = $order['lway_price'];
			$message .= '<tr><td style="padding:5px 10px;border: 1px solid #333333;width:60%;">'.$language['Shipment'].'<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">1<td style="padding:5px 10px;border: 1px solid #333333;width:20%;">'.$fee_price.'</tr>';
			$total = $total + $order['lway_price'];
		}
		$message .=	'<tr><td colspan="3" style="padding:5px 10px;border: 1px solid #333333;text-align:right; color:red; font-weight: blod;">'.$language['TotalPrice'].''.number_format($total).''.$language['NTDollars'].'</td></tr>'.
					'</table>'.
					'<p><hr></p>'.
					"<p>".$language['DoNotDirectlyReply']."</p>";

		// 寄信
		$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $buyer_email, $subject, $message);
		// 買家通知
		if($store['cset_email'] != '')
		{
			$time = date('Y-m-d',time());
			$title = $language['YouAreIn'].$time.$language['HaveSingleRecord'];
			$this -> mod_index -> send_mail($data['host']['domain'], $data['web_config']['title'], $store['cset_email'], $title, $message);
		}
	}

	//-----------------------------------------------------------------------------------
	// 函數名：add_buyer($buyer_email, $user_login)
	// 作 用 ：新增購買人紀錄
	// 參 數 ：
	// $buyer_email 	訂購人email
	// $buyer_phone 	訂購人電話 -> by_pw
	// $user_login 		登入狀態
	// 返回值：by_id 	訂購人id
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	private function add_buyer($buyer_email, $buyer_phone, $user_login)
	{
		// 購買人資料寫入
		// 以email判斷有沒有買過
		if(!$user_login) // 沒登入
		{
			$buyer = $this->mod_cart->select_from('buyer', array('by_email'=>$buyer_email));

			if(empty($buyer)) // 沒有買過
			{
				//library
				$this->load->library('encrypt');
				$insert_buyer  = array(
					'by_email' => $buyer_email,
					'by_pw'    => $this->encrypt->encode($buyer_phone)
				);
				$by_id = $this->mod_cart->insert_into('buyer', $insert_buyer);
			}
			else // 買過
			{
				$by_id = $buyer['by_id'];
			}
		}
		else // 已登入
		{
			$buyer = $this->mod_cart->select_from('buyer', array('by_email'=>$this->session->userdata('by_email')));
			$by_id = $buyer['by_id'];
		}
		return $by_id;
	}

	//-----------------------------------------------------------------------------------
	// 函數名：stocks_edit($user_cart, $timestamp, $store)
	// 作 用 ：庫存量修正與安全存量檢查
	// 參 數 ：
	// $user_cart 		訂購項目
	// $timestamp 		時間戳記
	// $store 			商店資訊
	// 返回值：無
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	private function stocks_edit($user_cart, $timestamp, $store)
	{
		$data = $this->data;

		// 寄信通知訂單紀錄
		// 主旨
		$subject = date('YmdHi', $timestamp).$language['SafetyStockRemind'];

		// 內容
		$message =	'<p>'.$language['WillBelowSafetyStock'].'</p>'.
					'<p><hr></p>'.
					'<p>'.$language['_ProductName'].'{unwrap}<a href=\''.base_url().'cart/store/'.$store['cset_code'].'\'>'.$store['cset_name'].'</a>{/unwrap}</p>';

		// 庫存量修正與安全存量檢查
		$send_active = false;
		foreach($user_cart as $key => $value)
		{
			$pos = strpos($value, '*#');
			$id  = substr($value, 0, $pos);
			$num = substr($value, $pos+2);
			$prd = $this->mod_cart->select_from('products', array('prd_id'=>$id));

			//安全庫存檢查
			if($prd['prd_safe_amount'] >= ($prd['prd_amount'] - $num)) // 通知安全庫存過低
			{
				// 是否寄提醒信
				$send_active = true;

				// 內容
				$message .=	'<p>'.$language['_ProductName'].''.$prd['prd_name'].', '.$language['ExcessInventory'].''.($prd['prd_amount'] - $num).', '.$language['SafetyStock'].''.$prd['prd_safe_amount'].'</p>';
			}
			// 庫存數量修改
			$this->mod_cart->update_set('products', 'prd_id', $id, array('prd_amount'=>($prd['prd_amount'] - $num)));
			if(($prd['prd_amount'] - $num) <= 0)
				$this->mod_cart->update_set('products', 'prd_id', $id, array('prd_active'=>1));

		}
		$message .=	'<p><hr></p><p>'.$language['DoNotDirectlyReply'].'</p>';

		// 寄信
		if($send_active){
			$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $store['cset_email'], $subject, $message);
		}
	}

	//-----------------------------------------------------------------------------------
	// 函數名：remove_cart()
	// 作 用 ：清空購物車
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：無
	//-----------------------------------------------------------------------------------
	public function remove_cart()
	{
		$this->session->unset_userdata('user_cart');
	}

	//20160512-國鼎-購物車結帳AJAX
	public function subprice(){
		$type=$_POST['type'];
		$pval=$_POST['pval'];
		$total=$_POST['total'];
		$cdata=$this->mymodel->GetConfig('','3');
		$sub=$total-$pval;
		echo json_encode($sub);
	}
	//20171101-選擇門市取貨AJAX
	public function ajax_logist_way(){
		$logist_way = $_POST['logist_way'];
		if($logist_way==5){
			$shop_add=$this->mymodel->OneSearchSql('member','shop_address',array('account'=>$_SESSION['AT']['account']));
		}
		echo $shop_add['shop_address'];//將型號項目丟回給ajax		
	}	
}
