<?php
class Brands extends MY_Controller
{
	private $_rootPath, $_data, $_myView;
	public $Spath = '/uploads/000/000/0000/0000000000/products/';
	public $Spath_class = '/uploads/000/000/0000/0000000000/products_class/';
	public function __construct()//初始化
	{
		parent::__construct();
		//model
		$this->load->model('admin_model', 'mod_admin');
		$this->load->model('member_model','mmodel');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('index_model');
		//語言包設置
		$this->load->model('lang_model','lmodel');
		//model 20171117
		$this->load->model(array('banner_model', 'products_model', '/MyModel/mymodel'));
		$this->load->model('product_brand_model', 'classModel');
		$this->load->model('commits_model');
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
		//列表顯示
		$_SESSION['select_prd_list']=(!empty($_SESSION['select_prd_list']))?$_SESSION['select_prd_list']:'prd_list_img';
		//列表排序
		$_SESSION['prd_sort']=(!empty($_SESSION['prd_sort']))?$_SESSION['prd_sort']:'prd_new';
		//web config
		$this->data['web_config']	=	$this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->data['banner'] = $this->banner_model->getMyAd();
		$this->style 				=	(!empty($this->data['style_config']['style_id']))?$this->data['style_config']['style_id']:'';
		$this -> load -> helper('form');
		//檔案名
		$this->DataName='product_brand';
		@session_start();
	}

	//紀錄列表顯示方式ajax
	public function ajax_prd_list(){
		$_SESSION['select_prd_list'] = $_POST['list'];
	}
	//紀錄列表排序方式ajax
	public function prd_sort(){
		$_SESSION['prd_sort'] = $_POST['sort'];
	}

	//後台超管-------------------------------------------------------------------

	//產品品牌列表
	public function brands_list(){
		//權限判斷
		$this->useful->CheckComp('j_brands');
		//資料庫名稱
		$data['dbname']=$dbname=$this->DataName;
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname,'',20,array());		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end	
		$dbdata=$this->mymodel->select_page_form($dbname,$qpage['result'],'*',array('lang_type'=>$this -> session -> userdata('lang')));
		$data['dbdata']=$dbdata;
		//檔案名
		$data['DataName']=$this->DataName;		
		//view
		$this->load->view('brands/brands_list', $data);
	}

	//產品品牌內頁
	public function product_brand_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_brands');
		$data['dbname']=$dbname=$this->DataName;
		$dbdata=$this->mmodel->select_from($dbname,array('prd_cid'=>$id));
		$data['dbdata']=$dbdata;
		$data['protype']=$this->mymodel->select_page_form('product_brand','','*',array('prd_cid'=>'NULL'));
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('brands/product_brand_info', $data);
	}

	//資料增刪修 for table product_brand
	// public function data_AED($dbname='',$del_id=''){
		
	// 	$prd_cid='prd_cid';

	// 	if($del_id!=''){
	// 		$this->mmodel->delete_where($dbname,array($prd_cid=>$del_id));
	// 		$msg='刪除成功';
	// 	}else{
	// 		$id=$_POST['prd_cid'];
	// 		$dbname=$_POST['dbname'];
			
	// 		if($id){
	// 			$data=$this->useful->DB_Array($_POST);
	// 		}else{
	// 			$data=$this->useful->DB_Array($_POST,1);
	// 			$data['d_createTime'] = $data['create_time'];
	// 			unset($data['create_time']);
	// 			$data['d_updateTime'] = $data['update_time'];
	// 			unset($data['update_time']);
	// 		}
	// 		$data['lang_type'] = $this->session->userdata('lang');
	
	// 		//scw 不能輸入空值
	// 		if(!empty($data['d_name'])){
	// 			unset($data['dbname']);
	// 			unset($data['prd_cid']);
			
	// 			if($id){
	// 				$this->mmodel->update_set($dbname,$prd_cid,$id,$data);
	// 				$msg='修改成功';
	// 			}else{
	// 				$create_id=$this->mmodel->insert_into($dbname,$data);
	// 				if($create_id)
	// 					$msg='新增成功';
	// 				else
	// 					$msg='新增失敗';
	// 			}
	// 		}else{
	// 			$msg='欄位空值';
	// 		}
			
	// 	}
	// 	$url_to ='/brands/brands_list';
	// 	$this->useful->AlertPage($url_to,$msg);
		
	// }

}
