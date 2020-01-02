<?php
class Order extends MY_Controller
{
	public $web_config;	
	public $Spath = '/uploads/000/000/0000/0000000000/products/';
	public function __construct()//初始化
	{
		parent::__construct();
		//model
		$this->load->model('admin_model', 'mod_admin');
		//helper
		$this->load->helper('url');
        @session_start();
		$this->load->model(array('products_model', 'order_model'));
		$this->load->model('cart_model', 'mod_cart');
		//domain
		if($this->session->userdata('session_domain') != '')
		{
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}
		else
		{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');
		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->style 				=	(!empty($this->data['style_config']['style_id']))?$this->data['style_config']['style_id']:'';
		$this -> load -> helper('form');
		//library
		$this->load->library('encrypt');
		$this->load->library('/mylib/useful');
		$this->load->library('/mylib/comment');
		//model
		$this->load->model('order_model','omodel');
		$this->load->model('My_Model/mymodel','mymodel');
		$this->load->model('banner_model');
		//語言包設置
		$this->load->model('lang_model','lmodel');
		
		
		$this->load->model('language_model', 'mod_language');
		$lang = $this->mod_language->converter('14', $this->session->userdata('lang'));
		$this->data = array_merge($this->data, $lang);

		// language
		$lang = $this -> mod_language -> converter('20', $this->session-> userdata('lang'));
		$this ->data = array_merge($this -> data, $lang);

		//檔案名
		$this->DataName='order';
		$this->data['banner'] = $this->banner_model->getMyAd();
        //$this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
	}
	//前台訂單列表
	public function index($cset_code='')
	{
		$language = $this -> language;		
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{						
			$data['banner'] = $this->data['banner'];
			//自己的css
			$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
								<link rel='stylesheet' type='text/css' href='/css/cart.css'>
								<link rel='stylesheet' type='text/css' href='/css/order.css'>";
			
			$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'"><span>'.$this->lang_menu["$this->DataName"].'</span></a></li>';
			//推薦人
			$by_id = $_SESSION['MT']['by_id'];
			$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
			$data['d_dividend']	= $buyer['d_dividend'];
			$PID	=	$buyer['PID'];
            if($by_id<>4){			
				$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
				$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			}
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';
			//分頁
			$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
			$page_limit 	= 	10 	;//	每頁顯示筆數
			$orderNumber='';
			$date='';
			$data['today'] = date('Y-m-d') ;
			if(!empty($_POST['orderNumber'])){  //找特定訂單(訂單編號)
				$orderNumber=$_POST['orderNumber'];				
				$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('by_id'=>$by_id,'order_id'=>"$orderNumber"));
				$data['page']=$this->useful->getPageJcy($qpage);
				//訂單列表
				$dbdata = $this->order_model->orderList($by_id,$page_limit,$Topage,$orderNumber,$date);
			}elseif(!empty($_POST['datepickerStart'])){  //找特定訂單(日期)
				$datepickerStart=$_POST['datepickerStart'];
				$datepickerEnd=$_POST['datepickerEnd'];	
				$date = array($datepickerStart,$datepickerEnd);
				$data['page']='';
				//訂單列表
				$dbdata = $this->order_model->orderList($by_id,100,$Topage,$orderNumber,$date);
			}else{
				$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('by_id'=>"$by_id"));
				$data['page']=$this->useful->getPageJcy($qpage);
				//訂單列表
				$dbdata = $this->order_model->orderList($by_id,$page_limit,$Topage,$orderNumber,$date);
			}
			//付款狀態撈取
			foreach ($dbdata as $key => &$value) {
				$value['status_name']= $this->lang['orderstatus'.$value['product_flow'].''];
			}
			$data['dbdata']	=	$dbdata;
			$this->load->view('index/header'.$this->style, $data);
			$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/order/order_list', $data);
			$this->load->view('index/footer'.$this->style, $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}
	//前台訂單明細
	public function detail($id='')
	{
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);

		// 防呆,沒輸入編號直接轉訂單頁
		if(empty($id)){
			$this->useful->AlertPage('/order');
		}

		// 判斷是否登入		
		if($_SESSION['MT']['is_login']==1)
		{ 
			$data['banner'] = $this->data['banner'];
			//自己的css
			$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
								<link rel='stylesheet' type='text/css' href='/css/cart.css'>
								<link rel='stylesheet' type='text/css' href='/css/order.css'>";
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';
			$by_id=$_SESSION['MT']['by_id'];
			$data['id'] = $id;
			//推薦人
			$by_id = $_SESSION['MT']['by_id'];
			$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
			$data['d_dividend']	= $buyer['d_dividend'];
			$PID	=	$buyer['PID'];
            if($by_id<>4){
				$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
				$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			}
			//主訂單
			$orderdata = $this->order_model->orderdata($id);
			//門市取貨
			if(!empty($orderdata['shop_id'])){
				$member=$this->mymodel->OneSearchSql('member','shop_address',array('member_id'=>$orderdata['shop_id']));
				$data['shop_address']='<br>'.$member['shop_address'];
			}
			$orderdata['status_name']	=	$this->lang['paystatus'.$orderdata['status']];
			$orderdata['logistics_way']	=	$this->lang['Logis'.$orderdata['lway_id']];
			$orderdata['payment_way']	=	$this->lang['Pay'.$orderdata['pay_way_id']];			
			$data['orderdata']			=	$orderdata;
			$data['Spath']				=	$this -> Spath;
			//訂單明細
			$order_detail = $this->order_model->orderDetail($id,$by_id);
			foreach($order_detail['data'] as $key => &$val){
				$val['prd_name'] = str_replace("\'","'",$val['prd_name']);				
				$image=explode(',',$val['prd_image']);				
				$val['prd_image']=$image[0];
			}
			$data['dbdata']	= $order_detail['data'];
			if($order_detail['num']==0){
				$this->useful->AlertPage('/order',$this->lang['error']);	//此訂單不是他的
			}
			$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'"><span>'.$this->lang_menu["$this->DataName"].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'/detail/'.$id.'"><span>'.$orderdata['order_id'].'</span></a></li>';

	        $data['atm']=$this->mymodel->GetConfig('atm');
			$data['body_class']	=	'cart-check-fix';				
			$this->load->view('index/header'.$this->style, $data);
			$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/order/order_detail', $data);
			$this->load->view('index/footer'.$this->style, $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}		
	}

	//前台匯款完成ajax
	public function ajax_remit(){		
		$id 		= $_POST['id'];
		$atmno 		= $_POST['atmno'];
		$atmdate 	= $_POST['atmdate'];
		$order_detail = $this->order_model->orderRemit($id, $atmno, $atmdate);
	}

	//前台訂單取消 詳細頁
	public function cancel($id=''){	
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{				
			$data['banner']='';
			//自己的css
			$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
								<link rel='stylesheet' type='text/css' href='/css/cart.css'>
								<link rel='stylesheet' type='text/css' href='/css/order.css'>";
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';

			$by_id=$_SESSION['MT']['by_id'];
			$data['id'] = $id;
			//主訂單
			$orderdata = $this->order_model->orderdata($id);
			$orderdata['status_name']= $this->lang['paystatus'.$orderdata['status']];
			$data['orderdata']=$orderdata;
			//訂單明細
			$order_detail = $this->order_model->orderDetail($id,$by_id);
			foreach($order_detail['data'] as $key => &$val){
				$val['prd_name'] = str_replace("\'","'",$val['prd_name']);				
				$image=explode(',',$val['prd_image']);				
				$val['prd_image']=$image[0];
			}
			$data['Spath']			=	$this -> Spath;
			$data['dbdata']	= $order_detail['data'];
			if($order_detail['num']==0){
				$this->useful->AlertPage('/order',$this->lang['error']);	//此訂單不是他的
			}
			if(!in_array($orderdata['status'], [0, 1])) {	//此訂單不能取消
				$this->useful->AlertPage('/order');
			}
			$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'"><span>'.$this->lang_menu["$this->DataName"].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'/cancel/'.$id.'"><span>取消訂單:'.$orderdata['order_id'].'</span></a></li>';			 					
			$this->load->view('index/header'.$this->style, $data);
			$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/order/cancel', $data);
			$this->load->view('index/footer'.$this->style, $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}
	//前台訂單取消 輸入頁
	public function cancel_info($id=''){	
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('27',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{				
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';
			$by_id=$_SESSION['MT']['by_id'];
			$data['id'] = $id;
			//主訂單
			$orderdata = $this->order_model->orderdata($id);
			$orderdata['status_name']= $this->lang['paystatus'.$orderdata['status']];
			$data['orderdata']=$orderdata;
			//訂單明細
			$order_detail = $this->order_model->orderDetail($id,$by_id);
			$buyer = $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$by_id));
			$data['name']=$buyer['name'];
			
			//退貨理由
			$data['reason'] = $this->mymodel->select_from('order_back_reason');
			
			if($order_detail['num']==0){
				$this->useful->AlertPage('/order',$this->lang['error']);	//此訂單不是他的
			}
			if($orderdata['status']<>0 or $orderdata['product_flow']<>0){
				$this->useful->AlertPage('/order');	//此訂單不能取消
			}
			$this->load->view('index/order/cancel_info', $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}

	//取消訂單&退貨原因
	public function ajax_order_back(){		
		$order_id = (int) $_POST['order_id'];

		if ($_POST['FromPage'] == "cancel") {
			// 取消訂單
			// DATA insert to DB
			$data = array(
				'status'			=>	4,
				'product_flow'		=>	3,
				'back_date'			=>	date("Y-m-d"),
				'apply_back_date'	=>	date("Y-m-d H:i:s")
			);
			$data_details=array(
				'status'			=>	4,
				'product_flow'		=>	3
			);

			// 前台取消訂單 立即退還紅利、購物金與商品庫存
			$this->order_model->revertBuyerBonus($order_id);
		} else {
			// 申請退貨
			// 建立目錄
			$img_url='/uploads/000/000/0000/0000000000/back_pic/';
			if(!is_dir('.'.$img_url))
				mkdir('.'.$img_url,0777);
			
			//上傳圖檔
			$this->load->model('upload_model', 'mod_upload');
			$pic_name=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
		
			$data = array(
				'status'			=>	3,
				'product_flow'		=>	7,
				'back_name'			=>	$_POST['back_name'],
				'back_bank'			=>	$_POST['back_bank'],
				'back_account'		=>	$_POST['back_account'],		
				'back_note'			=>	$_POST['reason_select'].":".$_POST['back_note'],
				'back_date'			=>	date("Y-m-d"),
				'apply_back_date'	=>	date("Y-m-d H:i:s"),
				'back_pic'			=>  $pic_name["path"]
			);
			$data_details=array(
				'status'			=>	3,
				'product_flow'		=>	7
			);
		}

		$this->mymodel->update_set('`order`','id',$order_id,$data);
		$this->mymodel->update_set('`order_details`','oid',$order_id,$data_details);	

		header('Content-Type: application/json');
		http_response_code(200);
		echo json_encode(['status' => 0]);
	}

	//前台申請退貨 明細
	public function refund($id=''){			
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{				
			$data['banner']='';
			//自己的css
			$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
								<link rel='stylesheet' type='text/css' href='/css/cart.css'>
								<link rel='stylesheet' type='text/css' href='/css/order.css'>";
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';

			$by_id=$_SESSION['MT']['by_id'];
			$data['id'] = $id;
			$today = date('Y-m-d') ;
			//主訂單
			$data['orderdata']=$orderdata = $this->order_model->orderdata($id);
			//訂單明細
			$order_detail = $this->order_model->orderDetail($id,$by_id);
			foreach($order_detail['data'] as $key => &$val){
				$val['prd_name'] = str_replace("\'","'",$val['prd_name']);				
				$image=explode(',',$val['prd_image']);				
				$val['prd_image']=$image[0];
			}
			$buyer = $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$by_id));
			$data['name']=$buyer['name'];
			$data['Spath']			=	$this -> Spath;
			$data['dbdata']	= $order_detail['data'];
			if($order_detail['num']==0){
				$this->useful->AlertPage('/order',$this->lang['error']);	//此訂單不是他的
			}

			if($orderdata['status']!=1 || $orderdata['product_flow']!=2){
				$this->useful->AlertPage('/order');	//此訂單不能退貨
			}
			$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'"><span>'.$this->lang_menu["$this->DataName"].'</span></a></li>'.
			 					'<li><a href="/'.$this->DataName.'/refund/'.$id.'"><span>'.$this->lang['o_11'].':'.$orderdata['order_id'].'</span></a></li>';
			$this->load->view('index/header'.$this->style, $data);
			$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/order/refund', $data);
			$this->load->view('index/footer'.$this->style, $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}

	//前台申請退貨 輸入頁
	public function refund_info($id=''){			
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('27',$this->setlang);
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{	
			//資料庫名稱	
			$data['dbname']=$dbname='`order`';
			$data['dbname_details']=$dbname_details='order_details';

			$by_id=$_SESSION['MT']['by_id'];
			$data['id'] = $id;
			$data['pic_config'] = $this->mymodel->select_from_where("config","d_val","d_title = '強制上傳證明照片'");
			
			//主訂單
			$orderdata = $this->order_model->orderdata($id);
			$data['orderdata']=$orderdata;
			
			//退貨理由
			$data['reason'] = $this->mymodel->select_from('order_back_reason');
			
			//訂單明細
			$order_detail = $this->order_model->orderDetail($id,$by_id);
			if($order_detail['num']==0){
				$this->useful->AlertPage('/order',$this->lang['error']);	//此訂單不是他的
			}
			if($orderdata['status']!=1 || !in_array($orderdata['product_flow'], [2, 4])){
				$this->useful->AlertPage('/order');	//此訂單不能退貨
			}
			$this->load->view('index/order/refund_info', $data);
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}
	
	//前台經營會員銷售訂單列表
	public function member_sale($cset_code='')
	{
		$language = $this -> language;
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		
		if($_SESSION['MT']['is_login']==1){	// 判斷是否登入
			if($_SESSION['MT']['d_is_member']==1){		//	判斷是否為經營者
				$data['banner'] = $this->data['banner'];
				//自己的css
				$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
									<link rel='stylesheet' type='text/css' href='/css/cart.css'>
									<link rel='stylesheet' type='text/css' href='/css/order.css'>";
				
				$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
									'<li><a href="/'.$this->DataName.'/member_sale"><span>'.$this->lang_menu['member_sale'].'</span></a></li>';
				//推薦人
				$by_id = $_SESSION['MT']['by_id'];
				$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
				$data['d_dividend']	= $buyer['d_dividend'];
				$PID	=	$buyer['PID'];
            	if($by_id<>4){			
					$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
					$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
				}
				//資料庫名稱	
				$data['dbname']=$dbname='`order`';
				$data['dbname_details']=$dbname_details='order_details';
				$member_id=$_SESSION['MT']['member_id'];
				//分頁
				$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
				$page_limit 	= 	10 	;//	每頁顯示筆數
				$orderNumber='';
				$date='';
				if(!empty($_POST['orderNumber'])){  //找特定訂單(訂單編號)
					$orderNumber=$_POST['orderNumber'];				
					$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('member_id'=>$member_id,'order_id'=>"$orderNumber"));
					$data['page']=$this->useful->getPageJcy($qpage);
					//訂單列表
					$dbdata = $this->order_model->memberOrderList($member_id,$page_limit,$Topage,$orderNumber,$date);
				}elseif(!empty($_POST['datepickerStart'])){  //找特定訂單(日期)
					$datepickerStart=$_POST['datepickerStart'];
					$datepickerEnd=$_POST['datepickerEnd'];	
					$date = array($datepickerStart,$datepickerEnd);
					$data['page']='';
					//訂單列表
					$dbdata = $this->order_model->memberOrderList($member_id,100,$Topage,$orderNumber,$date);
				}else{
					$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('member_id'=>"$member_id"));
					$data['page']=$this->useful->getPageJcy($qpage);
					//訂單列表
					$dbdata = $this->order_model->memberOrderList($member_id,$page_limit,$Topage,$orderNumber,$date);
				}
				//付款狀態撈取
				foreach ($dbdata as $key => &$value) {
					$value['status_name']= $this->lang['orderstatus'.$value['product_flow'].''];
				}
				$data['dbdata']	=	$dbdata;
				$this->load->view('index/header'.$this->style, $data);
				$this->load->view('index/member/member_nav', $data);
				$this->load->view('index/order/member_sale_list', $data);
				$this->load->view('index/footer'.$this->style, $data);

			}else{
				$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
				$this->useful->AlertPage('/order');
			}
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}
	}
	//前台訂單明細
	public function member_sale_detail($id='')
	{
		$language = $this -> language;		
		//語言包
		$this->lang=$this->lmodel->config('26',$this->setlang);
		if($_SESSION['MT']['is_login']==1)	{		// 判斷是否登入		
			if($_SESSION['MT']['d_is_member']==1){		//	判斷是否為經營者
				$data['banner']				=	'';
				//自己的css
				$data['main_css']="<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.css'>
									<link rel='stylesheet' type='text/css' href='/css/cart.css'>
									<link rel='stylesheet' type='text/css' href='/css/order.css'>";
				//推薦人
				$by_id = $_SESSION['MT']['by_id'];
				$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend',array('by_id'=>$by_id));
				$data['d_dividend']	= $buyer['d_dividend'];
				$PID	=	$buyer['PID'];
            	if($by_id<>4){			
					$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
					$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
				}
				//資料庫名稱	
				$data['dbname']=$dbname='`order`';
				$data['dbname_details']=$dbname_details='order_details';
				$member_id=$_SESSION['MT']['member_id'];
				$data['id'] = $id;
				//主訂單
				$orderdata = $this->order_model->orderdata($id);
				//門市取貨
				if(!empty($orderdata['shop_id'])){
					$member=$this->mymodel->OneSearchSql('member','shop_address',array('member_id'=>$orderdata['shop_id']));
					$data['shop_address']='<br>'.$member['shop_address'];
				}
				$orderdata['status_name']	=	$this->lang['paystatus'.$orderdata['status']];
				$orderdata['logistics_way']	=	$this->lang['Logis'.$orderdata['lway_id']];
				$orderdata['payment_way']	=	$this->lang['Pay'.$orderdata['pay_way_id']];
				$data['orderdata']			=	$orderdata;
				$data['Spath']				=	$this -> Spath;
				//訂單明細
				$order_detail = $this->order_model->memberOrderDetail($id,$member_id);
				foreach($order_detail['data'] as $key => &$val){
					$val['prd_name'] = str_replace("\'","'",$val['prd_name']);
					$image=explode(',',$val['prd_image']);
					$val['prd_image']=$image[0];
				}
				$data['dbdata']	= $order_detail['data'];
				if($order_detail['num']==0){
					$this->useful->AlertPage('/order/member_sale',$this->lang['error']);	//此訂單不是他的
				}
				$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
				 					'<li><a href="/'.$this->DataName.'/member_sale"><span>'.$this->lang_menu['member_sale'].'</span></a></li>'.
				 					'<li><a href="/'.$this->DataName.'/member_sale_detail/'.$id.'"><span>'.$orderdata['order_id'].'</span></a></li>';
				$data['body_class']	=	'cart-check-fix';
				$this->load->view('index/header'.$this->style, $data);
				$this->load->view('index/member/member_nav', $data);
				$this->load->view('index/order/member_sale_detail', $data);
				$this->load->view('index/footer'.$this->style, $data);
			}else{
				$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	
				$this->useful->AlertPage('/order');
			}
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login',$this->lang['Login']);
		}		
	}

	//排程(發送紅利)
	public function order_bonus(){
		$data=$this->mymodel->select_page_form('`order`','','id, by_id, bonus',array('is_bonus'=>'N','status'=>1,'product_flow'=>4));
		foreach ($data as $value) {
			$this->mymodel->update_set('`dividend`','OID',$value['id'],array('is_send'=>'Y','send_time'=>$this->useful->get_now_time()));
			$buyer=$this->mymodel->OneSearchSql('buyer','d_dividend',array('by_id'=>$value['by_id']));
			$dividend=$buyer['d_dividend']+$value['bonus'];
			$this->mymodel->update_set('`buyer`','by_id',$value['by_id'],array('d_dividend'=>$dividend));
			$this->mymodel->update_set('`order`','id',$value['id'],array('is_bonus'=>1, 'is_bonus'=>1));
			echo	'會員ID:'.$value['by_id'].' => '.$value['bonus'].'點<br>';
			$redata=array(
				'BID'=>$value['by_id'],
				'EID'=>'1',
				'd_type'=>'1',
				'd_bonus'=>$value['bonus'],
				'd_content'=>'排程發送紅利(確認已完成交易)',
				'create_time'=>$this->useful->get_now_time(),
				'update_time'=>$this->useful->get_now_time()
			);
			$this->mymodel->insert_into('dividend_log',$redata);
		}

		if(!empty($data)){
			echo'發送紅利....................記錄到dividend_log,完成!';
		}else{
			echo'沒有需要發送紅利的訂單!';
		}
	}

	//後台----------------------------------------------------

	public function order_back_excel(){//退貨明細匯出
		// @session_start();
		// //權限判斷
		// $this->useful->CheckComp('j_orderinfo');
		// //資料庫名稱
		// $data['dbname']=$dbname='order_details';	
		// //預設查詢	
		// $search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad");
		// $this->omodel->search_session($search_default_array);
		// $where_array=array();
		// $where_array[]="o.`product_flow`=5";
		// $where_array[]="o.`status`=2";
		// if($_SESSION["AT"]["where"]["txt"]!=""){
		// 	$where_array[]="od.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		// }
		// /*
		// if($_SESSION["AT"]["where"]["date_start"]!=""){
		// 	$where_array[]="o.create_time>='".strtotime($_SESSION["AT"]["where"]["date_start"]." 00:00:00")."'";
		// }
		// if($_SESSION["AT"]["where"]["date_end"]!=""){
		// 	$where_array[]="o.create_time<='".strtotime($_SESSION["AT"]["where"]["date_end"]." 23:59:59")."'";
		// }
		// */

		// if($_SESSION["AT"]["where"]["date_start"]!=""){
		// 	$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		// }
		// $where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
	
		
		// //訂單資料
		// $data['dbdata']=$this->omodel->get_order_back_excel($where);

		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';	
		//預設查詢	
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad","supplier_id");
		$this->omodel->search_session($search_default_array);
		$where_array=array();
		$where_array[]="od.product_flow=5";
		$where_array[]="od.status=2";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="od.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="od.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		if($_SESSION["AT"]["where"]["supplier_id"]!="" and $_SESSION["AT"]["where"]["supplier_id"]!=0){
			$where_array[]="od.supplier_id =".$_SESSION["AT"]["where"]["supplier_id"];
		}
		$where = !empty($where_array) ? "where ".implode(" and ",$where_array) : "";
		
		//分頁程式 start
		$data['ToPage'] = $Topage= !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;		
		$sql="(select sum(number) as number from order_details as od inner join supplier s on s.d_id=od.supplier_id ".$where." group by prd_id,price order by supplier_id,prd_id,price ) a";
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end

		//訂單資料
		$data['dbdata']=$this->omodel->get_order_back_excel($where);
	}
	public function order_back(){//退貨明細列表
		// @session_start();
		// //權限判斷
		// // $this->useful->CheckComp('j_orderinfo');
		// //資料庫名稱
		// $data['dbname']=$dbname='order_details';
	
		// //預設查詢
	
		// $search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad");
		// $this->omodel->search_session($search_default_array);
		// $where_array=array();
		// $where_array[]="o.`product_flow`=5";
		// $where_array[]="o.`status`=2";
		// if($_SESSION["AT"]["where"]["txt"]!=""){
		// 	$where_array[]="od.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		// }
		// if($_SESSION["AT"]["where"]["date_start"]!=""){
		// 	$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		// }
		// $where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		// //分頁程式 start
		// $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		
		// $sql="(select sum(od.number) from `order` o inner join `order_details` od on o.id=od.oid ".$where." group by od.prd_id) a";		
		// $qpage=$this->useful->SetPage($sql,'',20);
		// $data['page']=$this->useful->get_page($qpage);
		// //分頁程式 end
		// //訂單資料
		// $data['dbdata']=$this->omodel->get_order_back_data($where,$qpage['result']);
	
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';	
		//預設查詢	
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad","supplier_id");
		$this->omodel->search_session($search_default_array);
		$where_array=array();
		$where_array[]="product_flow=5";
		$where_array[]="status=2";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="o.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		if($_SESSION["AT"]["where"]["supplier_id"]!="" and $_SESSION["AT"]["where"]["supplier_id"]!=0){
			$where_array[]="o.supplier_id =".$_SESSION["AT"]["where"]["supplier_id"];
		}
		$where = !empty($where_array) ? "where ".implode(" and ",$where_array) : "";
		
		//分頁程式 start
		$data['ToPage'] = $Topage= !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;		
		$sql="(select sum(number) as number from order_details as o inner join supplier s on s.d_id=o.supplier_id ".$where." group by prd_id,price order by supplier_id,prd_id,price ) a";
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_supplier_data($where,$qpage['result']);
		//撈取供應商名稱
		$data['supplier']=$supplier=$this->mymodel->select_page_form('providers','','id, chinese_name',array());
		
		//view
		$this->load->view('order/order_back', $data);
	}
	public function order_sale_excel(){//出貨明細匯出
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';
		//預設查詢
		
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad");
		$this->omodel->search_session($search_default_array);
		// $where_array=array();
		// // $where_array[]="od.product_flow in (2,4)";
		// // $where_array[]="od.status=1";
		
		// if($_SESSION["AT"]["where"]["txt"]!=""){
		// 	$where_array[]="od.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		// }
	
		// if($_SESSION["AT"]["where"]["date_start"]!=""){
		// 	$where_array[]="pd.create_time between '".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		// }
		
		// // $where=!empty($where_array)?"where ".implode(" and ",$where_array):"";	
		// $where=!empty($where_array) ? " where ".implode(" and ",$where_array)." and lway_id = 3" : " where lway_id = 3 and od.product_flow in (2, 4) and od.status = 1 ";





		$where_array=array();
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="(order.order_id like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="order.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array) ? "where ".implode(" and ",$where_array)." and lway_id = 3 and product_flow in (0, 2, 4) " : " where lway_id = 3 and product_flow in (0, 2, 4) "; // lway_id=3 表示貨物需寄送
		
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_sale_excel($where);
	}

	public function import_order_sale()
	{
		$this->load->library('PHPExcel');
	    $this->load->library('PHPExcel/IOFactory');

		// 訂單編號、訂單狀態、物流編號、物流公司名稱、出貨日期
		$data = [];
		$mappingColumn = ['order_id', 'product_flow', 'tracking_num', 'tracking_name', 'sale_out_date'];
		$index = 0;
		$inputFileType = 'Excel2007';
		$objReader = IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($_FILES['file']['tmp_name']);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		$maxRow = $objWorksheet->getHighestRow();
		$maxColumn = $objWorksheet->getHighestColumn();

		for ($i = 2; $i <= $maxRow; $i++) {
			array_push($data, [
				'order_id' => $objWorksheet->getCellByColumnAndRow(ord('A') - 65, $i)->getValue(),
				'product_flow' => $objWorksheet->getCellByColumnAndRow(ord('B') - 65, $i)->getValue(),
				'tracking_num' => $objWorksheet->getCellByColumnAndRow(ord('C') - 65, $i)->getValue(),
				'tracking_name' => $objWorksheet->getCellByColumnAndRow(ord('D') - 65, $i)->getValue(),
				'sale_out_date' => $objWorksheet->getCellByColumnAndRow(ord('E') - 65, $i)->getValue()
			]);
		}
		$this->order_model->adjustOrderSaleOut($data);
		header('Content-Type: application/json');
		http_response_code(200);
		echo json_encode(['status' => 0]);
	}

	public function order_sale(){//出貨明細列表
		// @session_start();
		// //權限判斷
		// // $this->useful->CheckComp('j_orderinfo');
		// //資料庫名稱
		// $data['dbname'] = $dbname = 'order_details';
	
		// //預設查詢
		// $search_default_array = array("ToPage", "select_type", "txt", "date_start", "date_end", "sort", "sort_ad");
		// $this->omodel->search_session($search_default_array);
		// $where_array = array();
		// $where_array[] = "product_flow = 4";
		// $where_array[] = "status = 1";
		// // $where_array[] = '';
		// if ($_SESSION["AT"]["where"]["txt"] != "") {
		// 	$where_array[] = "prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		// }

		// if ($_SESSION["AT"]["where"]["date_start"] != "") {
		// 	$where_array[] = "create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		// }
		// $where = !empty($where_array) ? "where ".implode(" and ", $where_array) : "";
	
		// //分頁程式 start
		// $data['ToPage'] = $Topage =!empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;		
		// $sql = "(select sum(number) as number from order_details ".$where." group by prd_id,price) a";		
		// $qpage = $this->useful->SetPage($sql, '', 20);
		// $data['page'] = $this->useful->get_page($qpage);
		// //分頁程式 end
		// //訂單資料
		// $where = str_replace('prd_name', 'pd.prd_name', $where);
		// $data['dbdata'] = $this->omodel->get_order_sale_data($where, $qpage['result']);		
	
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';
		
		//預設查詢
		$search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","warehouse_select");
		$this->omodel->search_session($search_default_array);
	
		$where_array=array();
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="(order_id like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		}
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}
		if($_SESSION["AT"]["where"]["warehouse_select"]!=""){
			$where_array[]="warehouse_id=".$_SESSION["AT"]["where"]["warehouse_select"];
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array) ? "where ".implode(" and ",$where_array)." and lway_id = 3 and product_flow in (0, 2, 4) " : " where lway_id = 3 and product_flow in (0, 2, 4) "; // lway_id=3 表示貨物需寄送
		//分頁程式 start

		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;

		$sql="(select * from `order` ".$where." order by id ) a";
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		// $data['dbdata']=$this->omodel->get_order_data($where,$qpage['result']);
		$data['dbdata'] = $this->omodel->saleList($where, $qpage['result']);
		$payment_way = $this->mod_cart->select_from_order('payment_way', 'sort,pway_id', 'asc', array('active'=>1));
		foreach ($payment_way as $key => $value) {
			$data['payment_way'][$value["pway_id"]]= $value['pway_name'];
		}

		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態		
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());//出貨倉庫

		//view
		$this->load->view('order/order_sale', $data);
	}

	//銷貨(供應商)報表
	public function order_supplier()
	{
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';
		$data['lang'] = $this->data;	
		//預設查詢	
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad","supplier_id","brand_id");
		$this->omodel->search_session($search_default_array);
		$where_array=array();
		$where_array[]="product_flow=4";
		$where_array[]="status=1";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="o.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		// if($_SESSION["AT"]["where"]["supplier_id"]!="" and $_SESSION["AT"]["where"]["supplier_id"]!=0){
		// 	$where_array[]="o.supplier_id =".$_SESSION["AT"]["where"]["supplier_id"];
		// }
		
		if($_SESSION["AT"]["where"]["brand_id"]!="" and $_SESSION["AT"]["where"]["brand_id"]!=0){
			$where_array[]="pd.prd_cid =".$_SESSION["AT"]["where"]["brand_id"];	
		}

		$where = !empty($where_array) ? "where ".implode(" and ",$where_array) : "";
	
		//分頁程式 start
		$data['ToPage'] = $Topage= !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;		
		$sql="(select sum(number) as number from order_details as o inner join supplier s on s.d_id=o.supplier_id LEFT JOIN (
			SELECT
				pd.*,
				pb.prd_cid prd_cid_brand,
				pb.d_name  d_name_brand
			FROM
				products pd
				LEFT JOIN product_brand pb ON pb.prd_cid = pd.prd_cid 
				) pd ON o.prd_id = pd.prd_id ".$where." group by o.prd_id,price order by o.supplier_id,o.prd_id,o.price ) a";
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_supplier_data($where,$qpage['result']);
		//撈取供應商名稱
		// $data['supplier']=$supplier=$this->mymodel->select_page_form('providers','','id, chinese_name',array());
		//撈取品牌名稱
		$data['brand_list']=$brand_list=$this->mymodel->select_page_form('product_brand','','prd_cid, d_name',array(),'d_name','desc');
		
		//view
		$this->load->view('order/order_supplier', $data);
	}

	public function order_supplier_excel(){//銷貨(供應商)報表匯出20171228
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';
		//預設查詢
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end","sort","sort_ad","supplier_id","brand_id");
		$this->omodel->search_session($search_default_array);
		$where_array=array();
		$where_array[]="product_flow=4";
		$where_array[]="status=1";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="o.prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		// if($_SESSION["AT"]["where"]["supplier_id"]!="" and $_SESSION["AT"]["where"]["supplier_id"]!=0){
		// 	$where_array[]="o.supplier_id =".$_SESSION["AT"]["where"]["supplier_id"];
		// }
		if($_SESSION["AT"]["where"]["brand_id"]!="" and $_SESSION["AT"]["where"]["brand_id"]!=0){
			$where_array[]="pd.prd_cid =".$_SESSION["AT"]["where"]["brand_id"];	
		}
		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_supplier_excel($where);
	}
	public function order_supplier_list($supplier='',$prd_id='',$price=''){//銷貨(供應商詳細頁訂單)列表20180202		
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');

		if(Comment::SetValue("del_page")=="Y" || Comment::Set_GET("del_page")=="Y"){
			if(isset($_SESSION["AT"]["where"]['ToPage'])){
    			unset($_SESSION["AT"]["where"]['ToPage']);
			}
		}
		//資料庫名稱
		$data['dbname']=$dbname='`order`';	
		$data['lang'] = $this->data;	
		//預設查詢
		$search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","warehouse_select");
		$this->omodel->search_session($search_default_array);	
		$where_array=array();
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}
		if($_SESSION["AT"]["where"]["warehouse_select"]!=""){
			$where_array[]="warehouse_id=".$_SESSION["AT"]["where"]["warehouse_select"];
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where_array[]=" od.supplier_id = '".$supplier."'";
		$where_array[]=" od.prd_id = '".$prd_id."'";
		$where_array[]=" od.price = '".$price."'";
		$where_array[]=" o.product_flow = 4";
		$where_array[]=" o.status=1";
		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$sql="(select o.* from `order` as o 
			inner join warehouse w on w.d_id=o.warehouse_id 
			inner join order_details od on od.oid=o.id "
			.$where." group by o.order_id order by o.id ) a";
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_supplier_list($where,$qpage['result']);
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態		
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());//出貨倉庫
		$supplier_name = $this->mymodel->OneSearchSql('supplier','d_name',array('d_id'=>$supplier));
		$products = $this->mymodel->OneSearchSql('products','prd_name',array('prd_id'=>$prd_id));		
		$data['supplier']	=	$supplier_name['d_name'];
		$data['prd_id']		=	$products['prd_name'];
		$data['price']		=	$price;
		$data['url']		=	$supplier.'/'.$prd_id.'/'.$price;
		//view
		$this->load->view('order/order_supplier_list', $data);
	}
	public function order_supplier_list_excel($supplier='',$prd_id='',$price=''){//銷貨(供應商詳細頁訂單)列表20180205	
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		if(Comment::SetValue("del_page")=="Y" || Comment::Set_GET("del_page")=="Y"){
			if(isset($_SESSION["AT"]["where"]['ToPage'])){
    			unset($_SESSION["AT"]["where"]['ToPage']);
			}
		}
		//資料庫名稱
		$data['dbname']=$dbname='`order`';		
		//預設查詢
		$search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","warehouse_select");
		$this->omodel->search_session($search_default_array);	
		$where_array=array();
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="prd_name like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}
		if($_SESSION["AT"]["where"]["warehouse_select"]!=""){
			$where_array[]="warehouse_id=".$_SESSION["AT"]["where"]["warehouse_select"];
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where_array[]=" od.supplier_id = '".$supplier."'";
		$where_array[]=" od.prd_id = '".$prd_id."'";
		$where_array[]=" od.price = '".$price."'";
		$where_array[]=" o.product_flow = 4";
		$where_array[]=" o.status=1";
		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_supplier_list_excel($where);
	}

	public function order_supplier_info($id='',$supplier='',$prd_id='',$price=''){//供應商銷售明細內頁20180205
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
		//發票號碼
		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",time())-1911);
		$command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",time())."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$data["get_sInvoice"]=$get_sInvoice->result_array();
		//$data["dividend"]=$this->omodel->dividend($id);//紅利
		// print_r($data["dividend"]);
		// 20160623-撈取是否有紅利折抵記錄
		/*if($dbdata['product_flow']!=4)
			$data['subbonus']=$this->mymodel->OneSearchSql('order_sub','*',array('OID'=>$id));*/
		$shop_arr=$this->mymodel->OneSearchSql('member','shop_address',array('member_id'=>$dbdata["shop_id"]));
		$data['shop_address']='('.$shop_arr['shop_address'].')';
		
		//出貨倉庫
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());
		$data['supplier']=$supplier;
		$data['prd_id']=$prd_id;
		$data['price']=$price;
		//view
		$this->load->view('order/order_supplier_info', $data);
	}

	public function order_member(){//會員訂購明細列表
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='order_details';
		$data['lang'] = $this->data;
	
		//預設查詢
	
		$search_default_array=array("ToPage","select_type","txt_member","member_d_is_member","date_start_member","date_end_member","sort","sort_ad");
		$this->omodel->search_session($search_default_array);
		$where_array=array();
		$where_array[]="product_flow=4";
		$where_array[]="status=1";
		if($_SESSION["AT"]["where"]["txt_member"]!=""){
			$where_array[]="by_id in(select by_id from buyer where concat(d_account,'|',name) like '%".$_SESSION["AT"]["where"]["txt_member"]."%')";
		}
		if($_SESSION["AT"]["where"]["member_d_is_member"]!=""){
			$where_array[]="by_id in(select by_id from buyer where d_is_member=".$_SESSION["AT"]["where"]["member_d_is_member"].")";
		}
		/*
		if($_SESSION["AT"]["where"]["date_start_member"]!=""){
			$where_array[]="date>='".strtotime($_SESSION["AT"]["where"]["date_start_member"]." 00:00:00")."'";
		}
		if($_SESSION["AT"]["where"]["date_end_member"]!=""){
			$where_array[]="date<='".strtotime($_SESSION["AT"]["where"]["date_end_member"]." 23:59:59")."'";
		}*/

		if($_SESSION["AT"]["where"]["date_start_member"]!=""){
			$where_array[]=" create_time between'".$_SESSION["AT"]["where"]["date_start_member"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end_member"]." 23:59:59'";
		}
		// $where=!empty($where_array)?"where ".implode(" and ",$where_array):"";

		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
	
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
	
		$sql="(select sum(number) as number from order_details ".$where." group by by_id) a ";
	
		$qpage=$this->useful->SetPage($sql,'',20);
		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$dbdata=$this->omodel->get_order_member_data($where,$qpage['result']);
		$data['dbdata']=$dbdata["data"];
		$data['buyer']=$dbdata["buyer"];
		$data['city']=$dbdata["city"];
		$data['bytype']=$dbdata["bytype"];

		//view
		$this->load->view('order/order_member', $data);
	}
	public function order_member_list($by_id=''){//會員訂購明細列表
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		
		if(empty($by_id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		//預設查詢
		$_POST["by_id"]=$by_id;
		$search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","by_id");
		$this->omodel->search_session($search_default_array);
		
		
		$where_array=array();
		$where_array[]="product_flow=4";
		$where_array[]="status=1";
		$where_array[]="by_id=".$by_id;
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="(order_id like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		}
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}

		/*
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time>='".strtotime($_SESSION["AT"]["where"]["date_start"]." 00:00:00")."'";
		}
		if($_SESSION["AT"]["where"]["date_end"]!=""){
			$where_array[]="create_time<='".strtotime($_SESSION["AT"]["where"]["date_end"]." 23:59:59")."'";
		}*/

		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="o.create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}

		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname." ".$where,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_data($where,$qpage['result']);
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		
		//view
		$this->load->view('order/order_member_list', $data);
	}
	public function order_member_info($id=''){//會員訂購明細內頁
		@session_start();
	
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
	
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態

		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
		//發票號碼
		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",time())-1911);
		$command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",time())."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$data["get_sInvoice"]=$get_sInvoice->result_array();
		$data["dividend"]=$this->omodel->dividend($id);//紅利
		//view
		$this->load->view('order/order_member_info', $data);
	}
	public function order_back_list(){//退貨單明細列表
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		//預設查詢		
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end");
		$this->omodel->search_session($search_default_array);		
		$where_array=array();
		$where_array[]="product_flow in (5,7)";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="(concat(order_id,'|',back_name,'|',back_bank,'|',back_account) like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		}

		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname." ".$where,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_back_list_data($where,$qpage['result']);
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		
		//view
		$this->load->view('order/order_back_list', $data);
	}
	public function order_back_list_excel(){//退貨單明細列表
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';

		//預設查詢
		
		$search_default_array=array("ToPage","select_type","txt","date_start","date_end");
		$this->omodel->search_session($search_default_array);
		
		$where_array=array();
		$where_array[]="product_flow = 5";
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="(concat(order_id,'|',back_name,'|',back_bank,'|',back_account) like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		}

		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		$data['dbdata']=$this->omodel->get_order_back_list_excel($where);
	}
	public function order_list(){//訂購單明細列表
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data; 
		
		//預設查詢
		$search_default_array=array("ToPage","select_type","txt","txt_type","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","warehouse_select");
		$this->omodel->search_session($search_default_array);
	
		$where_array=array();
		$join_order_detail = '';
		$join_order_detail_group = '';
		
		if($_SESSION["AT"]["where"]["txt_type"]!="" && $_SESSION["AT"]["where"]["txt"]!=""){
			
			if ($_SESSION["AT"]["where"]["txt_type"] == 'order_id' ) {
				$where_array[]="(order_id  like '%".$_SESSION["AT"]["where"]["txt"]."%')";
			}

			if ($_SESSION["AT"]["where"]["txt_type"] == 'prd_id' ) {
				$where_array[]="(d.prd_id  like '%".$_SESSION["AT"]["where"]["txt"]."%')";	
				$join_order_detail = ' left join ( SELECT `oid`, `prd_id`, `prd_name` FROM `order_details` ) d on d.oid = order.id ';
				$join_order_detail_group = ' group by order.id ';
			}

			if ($_SESSION["AT"]["where"]["txt_type"] == 'prd_name' ) {
				$where_array[]="(d.prd_name  like '%".$_SESSION["AT"]["where"]["txt"]."%')";
				$join_order_detail = ' left join ( SELECT `oid`, `prd_id`, `prd_name` FROM `order_details` ) d on d.oid = order.id ';
				$join_order_detail_group = ' group by order.id ';
			}
			
		}
		// if($_SESSION["AT"]["where"]["txt"]!=""){
		// 	$where_array[]="(order_id like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
		// }
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}
		if($_SESSION["AT"]["where"]["warehouse_select"]!=""){
			$where_array[]="warehouse_id=".$_SESSION["AT"]["where"]["warehouse_select"];
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
		//分頁程式 start
		
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$sql="(select * from `order` " . $join_order_detail . $where . $join_order_detail_group . " order by order.id ) a";
		$where = $join_order_detail . $where; 
		$qpage=$this->useful->SetPage($sql,'',20);
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_data($where,$qpage['result']);
		$payment_way = $this->mod_cart->select_from_order('payment_way', 'sort,pway_id', 'asc', array('active'=>1));
		foreach ($payment_way as $key => $value) {
			$data['payment_way'][$value["pway_id"]]= $value['pway_name'];
		}
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data('0,1,5'); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data('1,3,4,5');  //訂單狀態
		$data["product_flow_search"]=$this->omodel->get_product_flow_data('0,1,2,3,4,5,8,9');  //訂單狀態 查詢用		
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());//出貨倉庫
	
		//view
		$this->load->view('order/order_list', $data);
	}
	public function order_list_excel(){//訂購單明細匯出
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		//資料庫名稱
		$data['dbname']=$dbname='`order`';
	
		//預設查詢
	
		$search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","warehouse_select");
		$this->omodel->search_session($search_default_array);
	
		$where_array=array();
		if($_SESSION["AT"]["where"]["txt"]!=""){
			$where_array[]="concat(name,'|',email,'|',order_id) like '%".$_SESSION["AT"]["where"]["txt"]."%'";
		}
		if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
			$where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
		}
		if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
			$where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
		}
		if($_SESSION["AT"]["where"]["status_select"]!=""){
			$where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
		}
		if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
			$where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
		}
		if($_SESSION["AT"]["where"]["warehouse_select"]!=""){
			$where_array[]="warehouse_id=".$_SESSION["AT"]["where"]["warehouse_select"];
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""){
			$where_array[]="create_time between'".$_SESSION["AT"]["where"]["date_start"]."  00:00:00' and '".$_SESSION["AT"]["where"]["date_end"]." 23:59:59'";
		}
		$where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
	
		//訂單資料
		$data['dbdata']=$this->omodel->get_order_excel($where);
	}
	public function order_info($id=''){//訂購單明細內頁
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
		$data['dbdata']['back_pic'] = (!empty($data['dbdata']['back_pic']))?'/uploads/000/000/0000/0000000000/back_pic/'.$data['dbdata']['back_pic']:'';
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data('0,1,5'); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
		//發票號碼
		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",time())-1911);
		$command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",time())."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$data["get_sInvoice"]=$get_sInvoice->result_array();
		//$data["dividend"]=$this->omodel->dividend($id);//紅利
		// 20160623-撈取是否有紅利折抵記錄
		if($dbdata['product_flow']!=4)
			$data['subbonus']=$this->mymodel->OneSearchSql('order_sub','*',array('OID'=>$id));

		$shopInfo = $this->mymodel->OneSearchSql('shop_store', '*', ['shop_id' => $dbdata['shop_id']]);
		$data['shop_address']='('.$shopInfo['shop_name'].')';
		
		
		//是否開啟取消原因欄位
		$arr_reason = array(5,6,7,8); 
		$data['isOpen_reason'] = in_array($dbdata['product_flow'],$arr_reason);
		//出貨倉庫
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());
		//view
		$this->load->view('order/order_info', $data);
	}
	public function rebuy_order($id=''){//訂購單明細內頁
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
		$buyer = $this->mymodel->OneSearchSql('buyer','PID, d_dividend,d_shopping_money',array('by_id'=>$dbdata['by_id']));
		$data['d_dividend']	= $buyer['d_dividend'];
		$data['d_shopping_money']	= $buyer['d_shopping_money'];
		$data['dbdata']['back_pic'] = (!empty($data['dbdata']['back_pic']))?'/uploads/000/000/0000/0000000000/back_pic/'.$data['dbdata']['back_pic']:'';
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
		//發票號碼
		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",time())-1911);
		$command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",time())."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$data["get_sInvoice"]=$get_sInvoice->result_array();
		//$data["dividend"]=$this->omodel->dividend($id);//紅利
		// 20160623-撈取是否有紅利折抵記錄
		if($dbdata['product_flow']!=4)
			$data['subbonus']=$this->mymodel->OneSearchSql('order_sub','*',array('OID'=>$id));

		$shop_arr=$this->mymodel->OneSearchSql('member','shop_address',array('member_id'=>$dbdata["shop_id"]));
		$data['shop_address']='('.$shop_arr['shop_address'].')';

		//是否開啟取消原因欄位
		$arr_reason = array(5,6,7,8);
		$data['isOpen_reason'] = in_array($dbdata['product_flow'],$arr_reason);
		//出貨倉庫
		$data['warehouse']=$this->mymodel->select_page_form('warehouse','','d_id,d_name',array());
		//view
		$this->load->view('order/rebuy_order', $data);
	}
	public function total_all(){
		$use_dividend	=	$_POST['use_dividend'];
		$use_shopping_gold	=	$_POST['use_shopping_gold'];
		foreach($_POST['prd_id'] as $key=>$val){
			$joinProducts[$val]=$_POST['number'][$key];
		}
		$by_id 			=	$_POST['by_id'];
		$bdata			=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));
		$price			=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
		$dataTotal		=	0;
		foreach ($joinProducts as $key => $value) {
			$productsDetail		=	$this->products_model->productsDetail($key,$bdata['d_spec_type']);
			$totalData			=	$productsDetail['data'];
			$dataTotal			=	($totalData[$price]*$value)+$dataTotal;
		}
		$data['dataTotal']			=	$dataTotal;
		$config1 					=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>76));
		$dividendTurn				=	(int)$config1['d_val'];
		$use_dividend_cost			=	$use_dividend/$dividendTurn;
		$data['only_money']			=	number_format($dataTotal-$use_dividend_cost-$use_shopping_gold,2);
		$data['use_dividend_cost']=$use_dividend_cost;
		//紅利
		$config1 			= $this->mymodel->OneSearchSql('config','d_val',array('d_id'=>73));
		$config1['d_val']	= ($config1['d_val'])/100;
		$data['dataBonus']	= $dataTotal*$config1['d_val'];
		echo json_encode($data);
	}
	public function rebuy_order_AED(){
		$this->load->model(array('MyModel/mymodel', 'products_model', 'cart_model', 'order_model'));
		$data['use_dividend']	=	$use_dividend	=	$_POST['use_dividend'];
		$data['use_shopping_money']	=	$use_shopping_money	=	$_POST['use_shopping_money'];
		$by_id	=	$_POST['by_id'];
		$buyer  =	$this->mymodel->OneSearchSql('buyer','PID,d_is_member',array('by_id'=>$by_id));
		$PID	=	$buyer['PID'];
		$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
		//撈出購物車的商品
		$bdata=$this->mymodel->OneSearchSql('buyer','d_spec_type, PID',array('by_id'=>$by_id));//會員是否VIP
		$price	=	($bdata['d_spec_type']==1)?'d_mprice':'prd_price00';
		foreach($_POST['prd_id'] as $key=>$val){
			$join_car[$val]=$_POST['number'][$key];
		}
		$order_data['total_pv']=$priceSum=0;
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
		$price_money			=	$totalPrice-$use_dividend_cost;

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
		$order_data['use_shopping_money']=	$use_shopping_money;
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
				'd_des'=>'訂單編號 ['.$order_id.']  - 商品名稱：'.$prd_name,
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
					'd_des'=>' ['.$order_id.']  - 商品名稱：'.$prd_name,
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
						'd_content'=>'訂單編號 ['.$order_id.']  - 商品名稱：'.$prd_name,
						'create_time'=>$this->useful->get_now_time(),
					);
					$this->mymodel->insert_into('shopping_money',$usedata);
				}
		}
		$this->lang=$this->lmodel->config('22','TW');
		$this->mymodel->update_set('`order`','id',$oid,array('status'=>'1'));
		$this->mymodel->update_set('`order_details`','oid',$oid,array('status'=>'1'));
		$this->useful->AlertPage('/order/order_list/',$this->lang['c_success']);
	}
	public function order_back_info($id=''){//退貨單明細內頁
		@session_start();
	
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$data['lang'] = $this->data;
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
		$data['dbdata']['back_pic'] = (!empty($data['dbdata']['back_pic']))?'/uploads/000/000/0000/0000000000/back_pic/'.$data['dbdata']['back_pic']:'';	
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data('3,5,7,9');  //訂單狀態
	
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
		//發票號碼
		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",time())-1911);
		$command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",time())."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$data["get_sInvoice"]=$get_sInvoice->result_array();
		$data["type"]="back";
		$data["dividend"]=$this->omodel->dividend($id);//紅利
		//view
		$this->load->view('order/order_member_info', $data);
	}
	public function ajax_dInvoice(){//取得發票資料
		$dInvoice=strtotime(Comment::SetValue("dInvoice"));//發票日期

		$command="select * from invoice where ";
		$command.="d_is_open='Y'";
		$command.=" and d_year=".(date("Y",$dInvoice)-1911);
		$command.=" and d_month=".((ceil(date("m",$dInvoice)/2)*2)-1);
		$command.=" and d_date<='".date("Y-m-d",$dInvoice)."'";
		$command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
		$get_sInvoice=$this->db->query($command);
		$invoice_set=$get_sInvoice->result_array();
	
		$data["get_sInvoice_value"]="";
		foreach($invoice_set as $key=>$val){
			$d_num=empty($val["d_now_num"])?$val["d_start"]:($val["d_now_num"]+1);
			$selected="";
			if(empty($data["get_sInvoice_value"])):
				$data["get_sInvoice_value"]=$val["d_code"].substr("00000000".$d_num,-8);
				$selected="selected";
			endif;
			$d_num_s=($val["d_now_num"]<$val["d_start"])?$val["d_code"].substr("00000000".$val["d_start"],-8):$val["d_code"].substr("00000000".($val["d_now_num"]+1),-8);
			$data["data"][]=array("selected"=>$selected,"d_id"=>$val["d_id"],$d_num_s,"value"=>$d_num_s,"title"=>'已開日期：'.$val["d_date"].' 發票號碼：'.$d_num_s);
		}
		echo json_encode($data);
	}
	public function order_out_print(){//出貨單列印
		$id=Comment::SetValue("d_id");
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
	
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
	
		//view
		$this->load->view('order/order_info', $data);
	}
	public function order_invoice_print(){//發票列印
		$id=Comment::SetValue("d_id");
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		$data['dbname']=$dbname='`order`';
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
	
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_data($id);
	
		//view
		$this->load->view('order/order_invoice2', $data);
	}
	public function order_discount_print(){//折讓單列印
		$id=Comment::SetValue("d_id");
		if(empty($id)){
			echo '<script>alert("ID錯誤");history.go(-1);</script>';
			return '';
		}
		//權限判斷
		$this->useful->CheckComp('j_orderinfo');
		$data['dbname']=$dbname='`order`';
		$dbdata=$this->omodel->get_order_sign($id);
		$data['dbdata']=$dbdata;
	
		$data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
		$data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
		$data["status"]=$this->omodel->get_status_data(); //付款狀態
		$data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態
		//詳細訂單資料
		$data["oddata"]=$this->omodel->get_order_details_excel($id);
		
	}
	public function order_AED(){//訂單資料修改
		@session_start();
		$_SESSION["jeffjuo"]="jeffjuo";
		$this->load->library('/mylib/CheckInput');
		$check=new CheckInput();
		$check->fname[]=array('_String',Comment::SetValue('d_id'),'ID');
		$check->fname[]=array('_String',Comment::SetValue('status'),'付款狀態');
		$check->fname[]=array('_String',Comment::SetValue('product_flow'),'訂單狀態');
		$check->fname[]=array('_String',Comment::SetValue('warehouse_id'),'出貨倉庫');
		if(!empty($check->main())){
			echo $check->main();
			return '';
		}
		if (! preg_match ( "/[1-9]/", Comment::SetValue('d_id') )) {
			echo '<script>alert("參數錯誤");history.go(-1);</script>';
			return '';
		}
		if (! preg_match ( "/[0-9]/", Comment::SetValue('status') )) {
			echo '<script>alert("付款狀態錯誤");history.go(-1);</script>';
			return '';
		}
		if (! preg_match ( "/[0-9]/", Comment::SetValue('product_flow') )) {
			echo '<script>alert("訂單狀態錯誤");history.go(-1);</script>';
			return '';
		}
		$id=Comment::SetValue('d_id');//ID	
		$product_flow=Comment::SetValue('product_flow');//訂單狀態
		$data=array(
				'status'=>Comment::SetValue('status'),
				'product_flow'=>Comment::SetValue('product_flow')
		);
		$datas=$data;
		$datas["receipt_date"]=Comment::SetValue("receipt_date");
		$datas["receipt_num"]=Comment::SetValue("receipt_num");
		$datas["tracking_num"]=Comment::SetValue("tracking_num");
		$datas["tracking_name"]=Comment::SetValue("tracking_name");
		$datas["warehouse_id"]=Comment::SetValue("warehouse_id");
		$datas["note"]=Comment::SetValue("note");
		$datas['sale_out_date'] = Comment::SetValue('sale_out_date');

		// 載具
		$datab['vehicle_type'] = Comment::SetValue('vehicle_type');
		$datab['vehicle_no'] = Comment::SetValue('vehicle_no');

		$order=$this->omodel->get_order_sign($id);
		if($product_flow=="5" && $order["product_flow"]!="5"){
			$datas["back_date"]=date("Y-m-d",time());
		}
		$error=$this->sInvoice($datas,$id);//檢查
		if(!empty($error)){
			if($error=='發票號碼重覆'){
				echo '<script>alert("'.$error.'")</script>';
				
			}else{
				echo '<script>alert("'.$error.'");history.go(-1);</script>';
				return '';
			}
		}
		
		//20160622-新增功能-增加修改時間
		$datas['update_time']=date("Y-m-d h:i:sa");

		if($datas['status']==1 and $datas['product_flow']==4 and $order['deadline']=='0000-00-00'){
			$config 			=	$this->mymodel->OneSearchSql('config','d_val',array('d_id'=>77));
			$deadlineDay 		=	$config['d_val'];
			$datas['deadline']	=	date('Y-m-d', strtotime("+ $deadlineDay days"));
		}
		$order=$this->omodel->get_order_sign($id);//取得變更前資料
		$this->omodel->update_set('`order`','id',$id,$datas);
		$this->omodel->update_set('order_details','oid',$id,$data);
		$this->omodel->update_set('`buyer`','by_id',$order['by_id'],$datab);

		//寄mail
		if($product_flow=="2" && $order["product_flow"]!="2"){
			$host = $this->get_host_config();
			$this->omodel->send_mail($id,$host);
		}

		if ($product_flow == '4' && $order['product_flow'] != '4') {
			$this->omodel->deliverDividend($order['id'], $order['by_id'], $order['bonus']);
		}

		// 判斷原狀態 若為「取消交易」、「已退貨」、「未付款取消」、「交易失敗」則不予觸發
		if (!in_array($order['product_flow'], [3, 5, 6, 8])) {
			if ($product_flow == '5' && $order['product_flow'] != '5') {
				$this->omodel->revertBuyerBonus($order['id']);
			}
	
			if ($product_flow == '3' && $order['product_flow'] != '3') {
				$this->omodel->revertBuyerBonus($order['id']);
			}
	
			if ($product_flow == '6' && $order['product_flow'] != '6') {
				$this->omodel->revertBuyerBonus($order['id']);
			}
	
			if ($product_flow == '8' && $order['product_flow'] != '8') {
				$this->omodel->revertBuyerBonus($order['id']);
			}
		}

		$msg='修改成功';
		echo '<script>alert("'.$msg.'");window.location.href="/order/order_list";</script>';
	} 
	public function sInvoice($CCheck,$id){//檢查發票號碼
		$error="";		
		if(empty($CCheck["receipt_num"]) && empty($CCheck["receipt_date"])){
			return "";//發票日期和發票號碼都是空的不用檢查
		}
		if(!empty($CCheck["receipt_date"]) && empty($CCheck["receipt_num"])){
			$error="發票日期不為空,發票號碼也要輸入";
		}
		if(!empty($CCheck["receipt_num"]) && empty($CCheck["receipt_date"])){
			$error="發票號碼不為空,發票日期也要輸入";
		}
		//echo $CCheck["receipt_num"].$CCheck["receipt_date"];exit();
		if(empty($error)){
			$month=strtotime($CCheck["receipt_date"]);
			$start=date("Y-m-01",$month);
			$end=(date("m",$month) % 2==0)?date("Y-m-t",$month):date("Y-".(date("m",$month)+1)."-t",$month);
			$where_order=array();
			$where_order[]="receipt_date>='".$start."'";
			$where_order[]="receipt_date<='".$end."'";
			$where_order[]="receipt_num='".$CCheck["receipt_num"]."'";
			$where_order[]="id<>".$id;
			$command="select count(*) as num from `order` where ".implode(" and ",$where_order);
			
			$query=$this->db->query($command);
			$order=$query->result_array();
			if($order[0]["num"]>0){
				$error="發票號碼重覆";
			}
			$CCheck["get_sInvoice"]=Comment::SetValue("get_sInvoice");
			if(!empty($CCheck["get_sInvoice"])){
				$sInvoice=substr($CCheck["receipt_num"],2);
				$where_invoice=array();
				$where_invoice[]="d_id=".$CCheck["get_sInvoice"];
				$where_invoice[]="d_is_open='Y'";
				$where_invoice[]="d_year=".(date("Y",$month)-1911);
				$where_invoice[]="d_month=".((ceil(date("m",$month)/2)*2)-1);
				$where_invoice[]="d_date<='".date("Y-m-d",$month)."'";
				$where_invoice[]="d_start<=".$sInvoice;
				$where_invoice[]="d_end>".$sInvoice;
				$command="select count(*) as num from invoice where ".implode(" and ",$where_invoice);
				$query=$this->db->query($command);
				$invoice=$query->result_array();
				if($invoice[0]["num"]<1){
					$error="發票字軌內沒有此組發票號碼";
				}else{
					$this->omodel->update_set('invoice','d_id',$CCheck["get_sInvoice"],array("d_now_num"=>$sInvoice,"d_date"=>$CCheck["receipt_date"]));
				}
			}
		}
		return $error;
	}
	public function order_update_product_flow(){
		$this->load->library('/mylib/CheckInput');
		$check=new CheckInput();
		$check->fname[]=array('_CheckRadio',Comment::SetValue('ids'),'要改變訂單狀態的資料');
		$chang_product_flow=Comment::SetValue('chang_product_flow');//更改狀態
		if(!empty($check->main())){
			echo $check->main();
		}
		elseif($chang_product_flow==""){
			$err="<script>alert('請選擇更改狀態');history.go(-1);</script>";
		}
		else{
			$ids=Comment::SetValue('ids');
			$product_flow=Comment::SetValue('chang_product_flow');
			foreach($ids as $key=>$id){
				$order=$this->omodel->get_order_sign($id);//取得變更前資料
				$sqlAE="update `order` set product_flow=".$product_flow;
				if($product_flow=="5" && $order["product_flow"]!="5"){
					$sqlAE.=",back_date='".date("Y-m-d",time())."'";
				}
				$sqlAE.=" where id in(".implode(",",$ids).")";
				//echo $sqlAE;
				$this->db->query($sqlAE);
				if($product_flow=="2" && $order["product_flow"]!="2"){
					$host = $this->get_host_config();
					$this->omodel->send_mail($id,$host);
				}
			}
			$sqlAE="update order_details set product_flow=".$product_flow." where oid in(".implode(",",$ids).")";
			//echo $sqlAE;
			$this->db->query($sqlAE);
		}
		$this->order_list();
	}
	public function order_back_update_status(){
		$this->load->library('/mylib/CheckInput');
		$check=new CheckInput();
		$check->fname[]=array('_CheckRadio',Comment::SetValue('ids'),'要改變付款狀態的資料');
		$chang_status=Comment::SetValue('chang_status');//更改狀態
		if(!empty($check->main())){
			echo $check->main();
		}
		elseif($chang_status==""){
			$err="<script>alert('請選擇更改狀態');history.go(-1);</script>";
		}
		else{
			$ids=Comment::SetValue('ids');
			$sqlAE="update `order` set status=".$chang_status." where id in(".implode(",",$ids).")";
			//echo $sqlAE;
			$this->db->query($sqlAE);
			$sqlAE="update order_details set status=".$chang_status." where oid in(".implode(",",$ids).")";
			//echo $sqlAE;
			$this->db->query($sqlAE);
		}
		$this->order_back_list();
	}

	//20160623-新增功能-退還紅利
	public function return_bonus(){
		@session_start();

		$d_id=$_POST['d_id'];
		$subbonus=$_POST['subbonus'];

		//撈取訂單資料
		$odata=$this->mymodel->OneSearchSql('`order`','by_id,order_id',array('id'=>$d_id));

		//撈取現在的會員紅利
		$bdata=$this->mymodel->OneSearchSql('buyer','d_dividend',array('by_id'=>$odata['by_id']));
		$dividend=$bdata['d_dividend']+$subbonus;

		//撈取訂單商品
		$ddata=$this->mymodel->select_page_form('order_details','','prd_name',array('oid'=>$d_id));
		foreach ($ddata as $key => $value) {
			$orderstr.=$value['prd_name'].',';
		}
		$orderstr=$this->useful->del_string_last($orderstr);
		
		$this->mymodel->update_set('buyer','by_id',$odata['by_id'],array('d_dividend'=>$dividend));
		$this->mymodel->update_set('order_sub','OID',$d_id,array('is_return'=>'Y','d_operator'=>$_SESSION['AT']['account_name'],'return_time'=>$this->useful->get_now_time()));
		$redata=array(
			'OID'=>$d_id,
			'buyer_id'=>$odata['by_id'],
			'd_type'=>'66',
			'd_val'=>$subbonus,
			'd_des'=>'訂單號碼 ['.$odata['order_id'].'] - 商品：'.$orderstr,
			'is_send'=>'Y',
			'create_time'=>$this->useful->get_now_time(),
			'update_time'=>$this->useful->get_now_time(),
		);
		$this->mymodel->insert_into('dividend',$redata);
		@session_write_close();
		$this->useful->AlertPage('/order/order_info/'.$d_id.'','已退還成功');

	}
	
	//後台退貨原因設定
	public function return_reason(){
		$arr = $this->mymodel->OneSearchSql('config','*',array('d_title' => '強制上傳證明照片') );
		$data['item'] = $arr['d_title'];
		$data['Launcher'] = $arr['d_val'];
		$data['dbdata'] = $this->mymodel->select_from('order_back_reason');	
		$this->load->view('/backreason/package_back_reason',$data);
	}
	
	//後台退貨原因內頁
	public function reason_info($id = ''){
		
		if($id != ''){
			$sele_where = "r_id = '".$id."'";
			$data['dbdata'] = $this->mymodel->select_from('order_back_reason',$sele_where);	
		}
		$this->load->view('/backreason/reason_info',$data);
	}
	
	//退貨原因增刪修
	public function reason_AED($del_id=''){	
		$msg = null;
		$dbname = "order_back_reason";
		if($del_id !=''){			
			$this->mymodel->delete_where( $dbname , array("r_id"=>$del_id) );
			$msg='刪除成功';
		}else{
			$r_id = $this->input->post('r_id');
			$item = $this->input->post('reason');
			
			if($r_id == ''){		
				$result = $this->mymodel->insert_into($dbname,array("reason_item" => $item));
				$msg = ($result != '')? $msg='新增成功':$msg='新增失敗';
			}else{
				$this->mymodel->update_set($dbname,'r_id', $r_id, array("reason_item" => $item));
				$msg = '修改成功';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/order/return_reason";</script>';
	}
	
	//修改 db.config.d_val
	public function back_order_pic(){
		$this->mymodel->update_set('config','d_title','強制上傳證明照片',array('d_val' => $_POST['d_val']));
	}
	
}
