<?php
// 分享頁面
class Share_link extends MY_Controller
{
	public $data='';
	public $language='';
	public function __construct() // 初始化
	{
		parent::__construct();
        // helper
        $this->load->helper('url');
        @session_start();
		$this->load->model(array('MyModel/mymodel'));
		$this->load->library('mylib/useful');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('lang_model','lmodel');
		$this->load->model('order_model', 'omodel');
        //web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		//檔案名
		$this->DataName='';
	}
	public function index($shareUrl='')
	{
		//語言包
		$this->lang=$this->lmodel->config('9999',$this->setlang);
		$data['shareUrl']			=	$_SESSION['shareUrl'];
		//view
		$this->load->view('index/share_link/share', $data);				
	}
}
