<?php
// 購物車
class Favorite extends MY_Controller
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
		$this->load->model(array('MyModel/mymodel','banner_model', 'favorite_model'));
		$this->load->library('mylib/useful');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('lang_model',lmodel);
        $this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';
		//檔案名
		$this->DataName='favorite';
		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
	}

	public function index($cset_code=''){
		$language = $this -> language;
		// 判斷是否登入
		if($_SESSION['MT']['is_login']==1)
		{	
			//語言包
			$this->lang=$this->lmodel->config('30',$this->setlang);
			//推薦人
			$data['by_id'] = $by_id = $_SESSION['MT']['by_id'];
			$account_id= $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
			$PID	=	$account_id['PID'];
			$memberName	= $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
			$data['memberName']	=	$this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
			
			$this->data['banner'] = $this->banner_model->getMyAd();	
			$data['banner']=$this->data['banner'];

			$data['path_title']='<li><a href="/gold/member"><span>'.$this->lang['member'].'</span></a></li>'.
								'<li><a href="/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>';
			//抓資料
			$data['favorite_data']	= $this->favorite_model->selectFavorite($by_id);
			$bdata				=	$this->mymodel->OneSearchSql('buyer','d_spec_type',array('by_id'=>$by_id));
			$d_spec_type		=	$bdata['d_spec_type'];
			foreach ($data['favorite_data'] as $key => &$value) {
				$value['price']	=	($d_spec_type==1)?$value['d_mprice']:$value['prd_price00'];
			}
			$data['Spath']			= $this -> Spath;
			//view
			$this->load->view('index/header', $data);
			$this->load->view('index/member/member_nav', $data);
			$this->load->view('index/favorite/favorite', $data);
			$this->load->view('index/footer', $data);
		}else{
			$_SESSION['url']	=	'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->useful->AlertPage('/gold/login','請登入');
		}
	}
	public function ajax_delete(){		
		$by_id = $_SESSION['MT']['by_id'];
		$prd_id = $_POST['prd_id'];
		//刪除
		$this->favorite_model->deleteFavorite($by_id, $prd_id);
	}	
}?>