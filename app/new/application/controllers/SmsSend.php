<?php
class Smssend extends MY_Controller
{
	public $web_title='';
	//初始化
	public function __construct(){
		parent::__construct();
		//helper
		$this->load->helper('url');
		//model
		$this->load->model('/MyModel/mymodel');	
		$this->load->library('/mylib/useful');
		$this->load->library('/mylib/comment');
	}
	//驗證簡訊重發函式
	public function index(){
		@session_start();
		// echo $_POST['d_account'];
		// echo $_SESSION['AT']['account'];
		// //註冊驗證系統-簡訊發送驗證網址
		$this->load->library('Sms');
		$sms=new sms('av8d20','80280616','N7SUQ3');

		$account=$_SESSION['AT']['d_account'];
		$acconut_id=$_SESSION['AT']['account'];
		if($account!='' and $acconut_id!=''){
			$v_num=$this->mymodel->OneSearchSql('buyer','verifty_num,by_email',array('d_account'=>$account));
			//超過發送次數
			if($v_num['verifty_num']>=3){
				$this->useful->AlertPage('/gold/login','此帳號已超過發送次數');
				return '';
			}
			$vnum=$v_num['verifty_num']+1;
			$this->mymodel->update_set('buyer','d_account',$account,array('verifty_num'=>$vnum));
			$nonum=base64_encode(date('Ymd').'_'.$account.'_'.$acconut_id.'');
			$tinyurl=$this->useful->getTinyUrl(base_url().'gold/member_verify?nonum='.$nonum.'');

			$content='感謝您註冊eoneda會員，請於今日內點選連結 '.$tinyurl.' 開通您的帳戶，逾時失效。重新發送次數為3次，目前為'.$vnum.'次';
			$smsval=$sms->Send_sms('eoneda會員註冊驗證通知信',$content,$account,$v_num['by_email'],'');
			$this->useful->AlertPage('/gold/login','已重發簡訊，請稍候!');
			// //註冊驗證系統-簡訊發送驗證網址
			unset($_SESSION['AT']['d_account']);
			@session_write_close();
		}
	}
}