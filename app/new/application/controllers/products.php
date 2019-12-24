<?php
class Products extends MY_Controller
{
	private $_rootPath, $_data, $_myView;
	public function __construct()//初始化
	{
		parent::__construct();
		//model
		$this->load->model('admin_model', 'mod_admin');
		//model
		$this->load->model('member_model','mmodel');
		//語言包設置
        $this->load->model('lang_model','lmodel');
		//model 20171117
		$this->load->model(array('banner_model', 'products_model', '/MyModel/mymodel'));
		// language detail需要語系,否則會錯誤
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang') || $this -> session -> userdata('lang') == 'zh-tw'){
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}else{
			$this -> data['lang'] = $this -> session -> userdata('lang');			
		}
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('14', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);
		//helper
		$this->load->helper('url');
		//library
		$this->load->library('/mylib/useful');
		//domain
		if($this->session->userdata('session_domain') != ''){
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}else{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');

		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		$this -> load -> helper('form');

		//檔案名
		$this->DataName='products';
		@session_start();
        //$this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
	}

	//產品前台列表
	public function index($pid=0, $account='', $page_no=1){
		header("Cache-control: private");
		//如果是已登入會員,account清空
		if($_SESSION['MT']['is_login']==1 && $account<>''){
			$this->useful->AlertPage("/products/$pid");
		}
		//語言包
		$this->lang=$this->lmodel->config('9',$this->setlang);
		if($_SESSION['MT']['is_login']==1){
			$by_id		=	$_SESSION['MT']['by_id'];						
			$account_id	= $this->mymodel->OneSearchSql('buyer','d_account',array('by_id'=>$by_id));
			$account=$account_id['d_account'];	
			$_SESSION['url']			='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(empty($pid)){
				$_SESSION['shareUrl']	='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$pid.'/'.$account;
			}else{
				$_SESSION['shareUrl']	='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$account;
			}
		}else{
			$_SESSION['url']			='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$_SESSION['shareUrl']		='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$_SESSION['AT']['account']	= $account=(!empty($_SESSION['AT']['account']))?$_SESSION['AT']['account']:$account;
		}
		$_SESSION['public_share_title']=$this->lang["$this->DataName"];
		$this->data['banner'] = $this->banner_model->getMyAd();
		//資料庫名稱	
		$data['dbname']=$dbname='products';
		$data['dbname_class']=$dbname_class='product_class';
		if(!empty($pid)){
			//先找出這個分類有沒有上層
			$path= $this->mymodel->OneSearchSql($dbname_class,'PID, prd_cname',array('prd_cid'=>$pid));
			if(!empty($path['PID'])){
				$path2= $this->mymodel->OneSearchSql($dbname_class,'prd_cname',array('prd_cid'=>$path['PID']));
				$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>'.
									'<li><a><span>'.$path2['prd_cname'].'</span></a></li>'.
									'<li><a href="/'.$this->DataName.'/'.$pid.'"><span>'.$path['prd_cname'].'</span></a></li>';
			}else{
				$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>'.
									'<li><a href="/'.$this->DataName.'/'.$pid.'"><span>'.$path['prd_cname'].'</span></a></li>';
			}
		}else{
			$data['path_title']='<li><a href="/'.$this->DataName.'/"><span>'.$this->lang["$this->DataName"].'</span></a></li>';			
		}
		$data['banner']=$this->data['banner'];
		//此商城是誰的(購物顧問)
		//先確認有無此商家存在
		if($_SESSION['MT']['is_login']==1){
			$by_id	=	$_SESSION['MT']['by_id'];
			$account_id= $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
			$PID	=	$account_id['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
		}else{
			$account_id= $this->mymodel->OneSearchSql('member','by_id',array('account'=>$account));
			if(!empty($account_id['by_id'])){
				$by_id	=	$account_id['by_id'];
				$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$by_id));
				$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			}else{
				$data['memberName']	=	$this->lang['noAccount'];
			}
		}
		//是否VIP
		$bdata				=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));
		$data['d_spec_type']=	$d_spec_type	=	$bdata['d_spec_type'];

		$_POST['pid']=(isset($_POST['pid']))?$_POST['pid']:0;
		$pid=( ($pid<>0))?$pid:$_POST['pid'];
		//分頁
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$page_limit 	= 	12	;//	每頁顯示筆數
		if($d_spec_type==1){
			$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('lang_type'=>$this->setlang,'d_enable'=>Y,'prd_cid'=>$pid,'prd_active'=>1,'is_bonus'=>N));
		}else{
			$qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('lang_type'=>$this->setlang,'d_enable'=>Y,'prd_cid'=>$pid,'prd_active'=>1,'is_vip'=>N,'is_bonus'=>N));
		}
		$data['page']=$this->useful->getPageJcy($qpage);
		$data['pid']=$pid;
		//產品列表
		$dbdata =$this->products_model->productsList($pid,$page_limit,$Topage,$d_spec_type);
		foreach ($dbdata as $key => &$value) {
			$value['priceName']	=	($d_spec_type==1)?$this->lang['p_price_vip']:$this->lang['p_price'];
			$value['price']	=	($d_spec_type==1)?$value['d_mprice']:$value['prd_price00'];
		}
		//APP分享
		$data['share_url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$data['share_prd_image']='http://'.$_SERVER['HTTP_HOST']."/images/logo_s.png";
		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('index/header', $data);
		$this->load->view('index/product/nav', $data);
		$this->load->view('index/product/list', $data);
		$this->load->view('index/footer', $data);
	}
	//產品前台詳細列表
	public function detail($id, $account=''){
		//如果是已登入會員,account清空
		if($_SESSION['MT']['is_login']==1 && $account<>''){
			$this->useful->AlertPage("/products/detail/$id");
		}
		if($_SESSION['MT']['is_login']==1){
			$by_id	=	$_SESSION['MT']['by_id'];						
			$account_id= $this->mymodel->OneSearchSql('buyer','d_account',array('by_id'=>$by_id));
			$account=$account_id['d_account'];	
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$_SESSION['shareUrl']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$account;
		}else{
			$_SESSION['url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$_SESSION['shareUrl']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$_SESSION['AT']['account']= $account=(!empty($_SESSION['AT']['account']))?$_SESSION['AT']['account']:$account;
		}
		$insert_data = array(
				'prd_id' 		=>  $id,
				'date_time' 	=>  date("Y-m-d h:i:sa"),
				'page_view'		=>  1,
				'member_id'		=>  (!empty($by_id))?$by_id:'0',
				'account'		=>  $account
				);
		$this->products_model->products_insert_views('products_views', $insert_data);
		//語言包
		$this->lang=$this->lmodel->config('10',$this->setlang);
		//$this->data['banner'] = $this->banner_model->getMyAd();
		$data['isFavoriteName']		=	$this->lang['p_unlike'];
		$data['isJoinName']			=	$this->lang['p_car'];
		$data['isJoinJs']			=	'join_car(0)';
		//此商城是誰的(購物顧問)非會員才判斷,若為會員 購物顧問即推薦人
		//先確認有無此商家存在
		if($_SESSION['MT']['is_login']==1){
			$by_id	=	$_SESSION['MT']['by_id'];
			$account_id= $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
			$PID	=	$account_id['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			//我的最愛
			$favorite= $this->mymodel->OneSearchSql('product_favorite','d_product_id',array('d_member_id'=>$by_id,'d_product_id'=>$id));
			if(!empty($favorite['d_product_id'])){
				$data['isFavorite']="style='background: #D96893;border:1px solid #a5a5a5;color: #fff;'";
				$data['isFavoriteName']=$this->lang['p_islike'];
			}
		}else{
			$account_id= $this->mymodel->OneSearchSql('member','by_id',array('account'=>$account));
			if(!empty($account_id['by_id'])){
				$by_id	=	$account_id['by_id'];
				$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$by_id));
				$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			}else{
				$data['memberName']	=	$this->lang['noAccount'];
			}
		}		
		//資料庫名稱	
		$data['dbname']=$dbname='products';
		$data['dbname_class']=$dbname_class='product_class';		
		//是否VIP
		$bdata				=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));
		$data['d_spec_type']=	$d_spec_type		=	$bdata['d_spec_type'];
		//產品列表		
		$productsDetail 	=	$this->products_model->productsDetail($id,$d_spec_type);
		$dbdata 			=	$productsDetail['data'];
		if(empty($productsDetail['num'])){
			$this->useful->AlertPage('/products',$this->lang['p_no_product']);//沒有這個商品or此商品下架
		}
		//紅利
		$config = $this->mymodel->OneSearchSql('config','d_val',array('d_id'=>73));
		$config['d_val']=($config['d_val'])/100;
		$data['priceName']					=	($d_spec_type==1)?$this->lang['p_price_vip']:$this->lang['p_price'];
		$data['price']						=	($d_spec_type==1)?$dbdata['d_mprice']:$dbdata['prd_price00'];
		$data['bonus']						=	$data['price']*$config['d_val'];
		$dbdata['prd_content'] 				= 	str_replace("&quot;", "", $dbdata['prd_content']);	//編輯器圖檔問題
		$data['dbdata'] 					= 	$dbdata;
		$data['prd_describe'] 				= 	explode('*#',$dbdata['prd_describe']);
		$data['prd_specification_name'] 	= 	explode('*#',$dbdata['prd_specification_name']);
		$data['prd_specification_content']	= 	explode('*#',$dbdata['prd_specification_content']);
		$data['prd_video_name']				= 	explode('*#',$dbdata['prd_video_name']);
		$data['prd_video_link']				= 	explode('*#',$dbdata['prd_video_link']);
		$car_id 							= 	$id.'##*'.$data['prd_specification_content'][1];
		
		//加入購物車
		if(!empty($_SESSION['join_car'])){
			foreach ($_SESSION['join_car'] as $key => $value) {
				if($key	==	$car_id){
			 		$data['isJoin']		=	"style='background: #000;'";
			 		$data['isJoinName']	=	$this->lang['p_delcar'];
			 		$data['isJoinJs']	=	'demit_car(0)';
				}
			}
		}
		if(!empty($dbdata['PID'])){	//2層在撈一次上層
			$path= $this->mymodel->OneSearchSql($dbname_class,'prd_cname',array('prd_cid'=>$dbdata['PID']));
			$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>'.
								'<li><a><span>'.$path['prd_cname'].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'/'.$dbdata['prd_cid'].'"><span>'.$dbdata['prd_cname'].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'/detail/'.$dbdata['prd_id'].'"><span>'.$dbdata['prd_name'].'</span></a></li>';
		}else{
			$data['path_title']='<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'/'.$dbdata['prd_cid'].'"><span>'.$dbdata['prd_cname'].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'/detail/'.$dbdata['prd_id'].'"><span>'.$dbdata['prd_name'].'</span></a></li>';		
		}
		$_SESSION['public_share_title']=$this->lang["$this->DataName"].':'.$dbdata['prd_name'];
		//購買說明
		$cset_paid='cset_paid_'.$this -> session -> userdata('lang');
		$buy_content= $this->mymodel->OneSearchSql('iqr_cart',"$cset_paid",array('member_id'=>'1'));
		$data['buy_content']=$buy_content["$cset_paid"];
		//運送規則
		$cset_ship='cset_ship_'.$this -> session -> userdata('lang');
		$ship_rule= $this->mymodel->OneSearchSql('iqr_cart',"$cset_ship",array('member_id'=>'1'));
		$data['ship_rule']=$ship_rule["$cset_ship"];
		//猜你喜歡
		$data['dbdataLike'] = $this->products_model->productsList($dbdata['prd_cid'],6,1,$d_spec_type);
		//APP分享
		$data['share_url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$data['share_prd_image']='http://'.$_SERVER['HTTP_HOST']."/uploads/000/000/0000/0000000000/products/".$dbdata['prd_image'];
		//view
		$this->load->view('index/header', $data);
		$this->load->view('index/product/nav', $data);
		$this->load->view('index/product/detail', $data);
		$this->load->view('index/footer', $data);
	}
	
	//購物車
	public function ajax_car(){//寫入購物車//echo $product_id;	
		//@session_start();
		if($_SESSION['MT']['is_login']==1){
			$product_id	=	$_POST['product_id'];
			$shop_count	=	$_POST['shop_count'];
			$spec		=	$_POST['spec'];
			if(!empty($shop_count) and preg_match("/^[1-9][0-9]*$/",$shop_count)){
				$_SESSION['join_car']["$product_id##*$spec"] = "$shop_count";
				echo '已加入購物車';
			}else{
				echo '請選擇購買數量';
			}
		}else{			
			echo '請登入';
		}
	}

	public function ajax_demitcar(){//移除購物車
		$product_id	=	$_POST['product_id'];
		$spec		=	$_POST['spec'];
		unset($_SESSION['join_car'][$product_id.'##*'.$spec]);
	}

	//加入最愛
	public function ajax_favorite(){
		//@session_start();
		if($_SESSION['MT']['is_login']==1){
			$product_id	=	$_POST['product_id'];
			$by_id	=	$_SESSION['MT']['by_id'];

			$favorite= $this->mymodel->OneSearchSql('product_favorite','d_product_id',array('d_member_id'=>$by_id,'d_product_id'=>$product_id));

			if(!empty($favorite['d_product_id'])){//移除最愛
				$this->mmodel->delete_where('product_favorite',array('d_member_id'=>$by_id,'d_product_id'=>$product_id));
				echo '1';
			}else{//新增最愛	
				$date=date("Y-m-d h:i:sa");				
				if(!empty($_SERVER['HTTP_CLIENT_IP'])){
				   $myip = $_SERVER['HTTP_CLIENT_IP'];
				}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				   $myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				}else{
				   $myip= $_SERVER['REMOTE_ADDR'];
				}
				$this->mmodel->insert_into('product_favorite', 
					array('d_createTime' => $date, 'd_edit_id' => $by_id, 'd_edit_ip' => $myip, 
						'd_member_id' => $by_id, 'd_product_id' => $product_id, 'd_enable' => 'N'));		
				echo '2';
			}
		}else{	
			echo 'login';
		}
	}

	//後台超管-------------------------------------------------------------------

	//產品分類列表
	public function product_class_list(){
		//權限判斷
		$this->useful->CheckComp('j_comlist');

		//資料庫名稱
		$data['dbname']=$dbname='product_class';


		$dbdata=$this->mymodel->select_page_form($dbname,$qpage['result'],'*',array('lang_type'=>$this->setlang));
		$data['dbdata']=$dbdata;
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname,'',20,array('lang_type'=>$this->setlang));		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end	

		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/product_class_list', $data);
	}
	//產品分類內頁
	public function product_class_info($id=''){


		$this->useful->CheckComp('j_comlist');

		$data['dbname']=$dbname='product_class';
		$dbdata=$this->mmodel->select_from($dbname,array('prd_cid'=>$id));
		$data['dbdata']=$dbdata;
		
		$data['protype']=$this->mymodel->select_page_form('product_class','','*',array('lang_type'=>$this->setlang,'PID'=>'NULL'));

		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/product_class_info', $data);
	}
	//產品列表
	public function products_list(){
		//權限判斷
		$this->useful->CheckComp('j_comdata');
		$img_url='/uploads/000/000/0000/0000000000/products/';

		//資料庫名稱
		$data['dbname']=$dbname='products';
		if((!empty($_POST['product_class']) or !empty($_POST['product_status']) and $_POST['product_status']!=3)){
			if($_POST['product_status']==4)$_POST['product_status']=0;

		    //分頁程式 start
		    $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		    $qpage=$this->useful->SetPage($dbname,$Topage,20,array('lang_type'=>$this->setlang,'d_enable'=>"Y",'prd_cid'=>$_POST['product_class'],'prd_active'=>$_POST['product_status']));		
		    $data['page']=$this->useful->get_page($qpage);
		    //分頁程式 end	

//			$dbdata = $this -> mmodel -> get_order_data($_POST['product_class'],$_POST['product_status'],$this->setlang);
			$dbdata = $this -> select_products_data($qpage['result'],$this->setlang,$_POST['product_class'],$_POST['product_status']);

			$data['product_class']=$_POST['product_class'];
			if($_POST['product_status']==0)$_POST['product_status']=4;
			$data['product_status']=$_POST['product_status'];
		} else {
		    //分頁程式 start
		    $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		    $qpage=$this->useful->SetPage($dbname,$Topage,10,array('lang_type'=>$this->setlang,'d_enable'=>"Y"));		
		    $data['page']=$this->useful->get_page($qpage);
		    //分頁程式 end	

//echo json_encode($qpage);exit;
			//$dbdata = $this -> mod_admin -> select_from_group_by($qpage['result'],$this->setlang);
			$dbdata = $this -> select_products_data($qpage['result'],$this->setlang);

        }

		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['prd_image']=$img_url.$value['prd_image'];
			$dbdata[$key]['prd_hot']=($value['prd_hot']=='fa fa-heart-o')?'否':'是';
			if($value['prd_active']=='2')
				$act="商品下架";
			elseif($value['prd_active']=='1')
				$act="尚有庫存";
			else
				$act="商品補貨";
			$dbdata[$key]['prd_active']=$act;

			$dbdata[$key]['setview']=$value['view'];
			//20160526瀏覽人數設定
			if(strlen($value['view'])>3){
				$dbdata[$key]['setview']=number_format(floor($value['view']/1000)).'K';
			}

			//搜尋結果-庫存量不足
			if($_POST['product_status']==3){
				if($value['prd_amount']>$value['prd_safe_amount']){
					unset($dbdata[$key]);
				}
				$data['product_status']=$_POST['product_status'];
			}
		}
		$data['dbdata']=$dbdata;

		//產品系列
		$data['cdata']=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang));
		
		
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/product_list', $data);
	}
	private function select_products_data($limit = '',$lang_type='TW',$class='',$status='')
	{
		$sql  = 'SELECT products.*, SUM(products_views.page_view) AS view';
		$sql .= ' FROM products LEFT JOIN products_views ON products.prd_id = products_views.prd_id';
		$sql .= ' where lang_type="'.$lang_type.'"';

        if($class!='')
          $sql.=' and products.prd_cid='.$class;
        if($status!='')
          $sql.=' and products.prd_active='.$status;

		$sql .= ' and products.d_enable="Y" group by products.prd_id';
		if(!empty($limit))
			$sql .= $limit;

		return $this -> db -> query($sql) -> result_array();
	}

	//產品內頁
	public function products_info($id=''){

		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname']=$dbname='products';
		$dbdata=$this->mmodel->select_from($dbname,array('prd_id'=>$id));
		$dbdata['prd_image1']=$dbdata['prd_image'];
		$dbdata['prd_image']='/uploads/000/000/0000/0000000000/products/'.$dbdata['prd_image'];

		//商品特點
		$data['prd_describe']=$this->String_Array($dbdata['prd_describe']);
		//影片標題
		$data['prd_video_name']=$this->String_Array($dbdata['prd_video_name']);
		//影片連結
		$data['prd_video_link']=$this->String_Array($dbdata['prd_video_link']);
		//規格名稱
		$data['prd_specification_name']=$this->String_Array($dbdata['prd_specification_name']);
		//規格內容
		$data['prd_specification_content']=$this->String_Array($dbdata['prd_specification_content']);
		//供應商
		$data['supplier']=$this->mymodel->select_page_form('supplier','','d_id,d_name',array());

		if(!empty($id)){
			//Momo
			//分類第一層
			$data['protype']=$this->products_model->productsType(0);
			foreach($data['protype'] as $protypeArr){
				$cidArr[]=$protypeArr['prd_cid'];
			}
			if(in_array($dbdata['prd_cid'], $cidArr)){
		  			//echo "有在陣列裡"; //代表只有一層
		  	}else{ //有兩層	  	
				//分類第二層,先找出最上層的分類
				$dbdata['prd_sub_cid']=$dbdata['prd_cid'];
				$cid=$this->mymodel->OneSearchSql('product_class','PID',array('lang_type'=>$this->setlang,'prd_cid'=>$dbdata['prd_sub_cid']));
		  		$dbdata['prd_cid']=$cid['PID'];
		  		//第2層分類
				$data['protype_sub']=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang,'PID'=>$dbdata['prd_cid']),'prd_cid');
		  	}
		}else{			
			//分類
			$data['protype']=$this->mymodel->select_page_form('product_class','','*',array('lang_type'=>$this->setlang,'PID'=>'NULL'));
			//第2層分類			
			$dbdata['prd_sub_cid']=(isset($dbdata['prd_sub_cid']))?$dbdata['prd_sub_cid']:'0';
			$data['protype_sub']=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang,'PID'=>$dbdata['prd_cid']),'prd_cid');
		}
		$data['dbdata']=$dbdata;
		//KV
		$kv=$this->mymodel->GetConfig('','3');
		$data['kv']=$kv['d_val'];
		$data['bonus']=$kv['d_val']*$dbdata['prd_pv'];
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/product_info', $data);
		//print_r($dbdata);
	}

	public function ajax_product(){//讀取產品分類
		$prd_cid = $_POST['prd_cid'];
		$prd_sub_cid = $_POST['prd_sub_cid'];
		if($prd_cid!=0){
			$product_type=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang,'PID'=>$prd_cid),'prd_cid');
			if(!empty($product_type)){			
				$res="<select name='prd_cid'>";
				foreach ($product_type as $key => $value) {
					$selected=($prd_sub_cid==$value['prd_cid'])? "selected='true'":'';
					$res .= '<option value='.$value['prd_cid']. $selected .'>'.$value['prd_cname'].'</option>';
				}
				$res .= "</select>";
				echo $res;//將型號項目丟回給ajax
			}
		}
	}

	//產品排序
	public function products_sort(){
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname']=$dbname='products';
		if(!empty($_POST['sort'])){
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname,'prd_id',$value,array('hot_sort'=>$key));	
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_sort";</script>';
		}else{
			
			$dbdata=$this->mmodel->select_from_order($dbname,'hot_sort','asc',array('prd_hot'=>'fa fa-heart'));
			//總數
			$data['hot_num']=count($dbdata);
			$img_url='/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$dbdata[$key]['prd_image']=$img_url.$value['prd_image'];
			}
			$data['dbdata']=$dbdata;
		}
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/products_sort', $data);
	}

	//供應商列表 20171227
	public function supplier_list(){
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		//資料庫名稱
		$data['dbname']=$dbname='supplier';

		$dbdata=$this->mymodel->select_page_form($dbname,$qpage['result'],'*',array(''));
		$data['dbdata']=$dbdata;
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname,'',20,array());		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end	
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/supplier_list', $data);
	}
	//供應商內頁 20171227
	public function supplier_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		$data['dbname']=$dbname='supplier';
		$dbdata=$this->mmodel->select_from($dbname,array('d_id'=>$id));
		$data['dbdata']=$dbdata;
		$data['protype']=$this->mymodel->select_page_form('supplier','','*',array('d_id'=>'NULL'));
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/supplier_info', $data);
	}
	
	//--AJAX 開啟關閉資料專用
	public function oc_data(){
		$DB=$this->input->post('DB');		//資料表
		$field=$this->input->post('field');	//欄位名稱
		$id=$this->input->post('id');		//修改ID 需有分號區隔
		$oc=$this->input->post('oc');		//Open Close Value

		$id_val=explode(';',$id);

		if($oc=='1'||$oc=='2'||$oc=='0')
			$is_filed='prd_active';
		else
			$is_filed='prd_hot';
		
		if($oc=='E')
			$oc='fa fa-heart-o';
		elseif($oc=='L')
			$oc='fa fa-heart';
		foreach ($id_val as $value) {
			$this->mmodel->update_set($DB,$field,$value,array($is_filed=>$oc));
		}
		echo '修改成功';
	}
	//--AJAX 開啟關閉資料專用

	//資料增刪修
	public function data_AED($dbname='',$del_id=''){
		$d_id='d_id';
		$img_url='/uploads/000/000/0000/0000000000/products/';
		if(!is_dir('.'.$img_url))
			mkdir('.'.$img_url,0777);
		
		if($del_id!=''){
			
			if($dbname=='product_class')
				$d_id='prd_cid';
			
			if($dbname=='products'){
				$d_id='prd_id';
				$this->mmodel->update_set($dbname,$d_id,$del_id,array('d_enable'=>'N'));
				$this->useful->AlertPage('','刪除成功');
				return '';
			}

			$this->mmodel->delete_where($dbname,array($d_id=>$del_id));
			$msg='刪除成功';
		}else{
			$id=$_POST['d_id'];
			$dbname=$_POST['dbname'];

			if($dbname=='products'){
				$d_id='prd_id';
				if($_POST['restrice_num']!='0'){
					if($_POST['prd_lock_amount'] > $_POST['restrice_num']){
						echo '<script>alert("單次購買數量不得大於限購數量");history.go(-1);</script>';
						return '';
					}
				}
				if($_POST['prd_pv']<=0){
					$this->useful->AlertPage('','PV值不得小於等於零');
					return '';
				}


				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');
				if($_FILES['prd_image']['error'] != 4)
				{
					$img=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
					$_POST['prd_image']=$img['path'];
					if($id){
						unlink('.'.$img_url.$_POST['prd_image_hide']);
						unlink('.'.$img_url.'set_'.substr($_POST['prd_image_hide'],1));
					}
				}else
				{
					$_POST['prd_image']=$_POST['prd_image_hide'];
				}
				unset($_POST['prd_image_hide']);
				//商品特點			
				$_POST['prd_describe']=$this->Array_String($_POST['prd_describe']);
				//影片標題
				$_POST['prd_video_name']=$this->Array_String($_POST['prd_video_name']);
				//影片連結
				$_POST['prd_video_link']=$this->Array_String($_POST['prd_video_link']);
				//規格名稱
				$_POST['prd_specification_name']=$this->Array_String($_POST['prd_specification_name']);
				//規格內容
				$_POST['prd_specification_content']=$this->Array_String($_POST['prd_specification_content']);

				$_POST['prd_content'] = str_replace("\"", "&quot;", $_POST['prd_content']);
				
				// 更改PV寫入LOG
				$Chkdata=$this->mymodel->OneSearchSql('products','prd_pv,prd_name',array('prd_id'=>$id));
				if($Chkdata['prd_pv']!=$_POST['prd_pv']){
					$content='管理員'.$_SESSION['AT']['account_name'].'-更改'.$Chkdata['prd_name'].'的PV('.$Chkdata['prd_pv'].'->'.$_POST['prd_pv'].')';
					$this->mymodel->WriteLog('2',$content);
				}
			}
		
			if($id){
				$data=$this->useful->DB_Array($_POST);
			}else{
				$data=$this->useful->DB_Array($_POST,1);
			}
			
			if($dbname=='product_class'){
				$d_id='prd_cid';
			}


			
			unset($data['dbname']);
			unset($data['d_id']);
		
			if($id){
				$this->mmodel->update_set($dbname,$d_id,$id,$data);
				$msg='修改成功';
			}else{
				
				$create_id=$this->mmodel->insert_into($dbname,$data);
				if($create_id)
					$msg='新增成功';
				else
					$msg='新增失敗';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/'.$this->DataName.'/'.$dbname.'_list";</script>';
	}
	//陣列轉字串
	private function Array_String($array,$sub='*#'){
		$str = '';
		if(!empty($array))
		{
			foreach ($array as $dvalue) {
				$str.=$sub.$dvalue;
			}
		}
		return $str;
	}
	//字串轉陣列
	private function String_Array($String,$sub='*#'){
		$str=explode($sub,$String);
		array_shift($str);
		return $str;
	}
}
