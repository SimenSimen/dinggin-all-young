<?php
class Views extends MY_Controller
{
	public $ss = '', $web_title = '', $set_language;
	public $Spath = '/uploads/000/000/0000/0000000000/coupon/';

	function __construct($iqr_name = '')
	{
		parent::__construct();

		// helper
        $this->load->helper('url');
        
        $this -> load -> model('views_model', 'mod_views');

        $this -> load -> model('webconfig_model', 'mod_webconfig');

        @session_start();
        // 語言包
  	  	$this->load->model('lang_model', 'lmodel');
        $this -> set_language = $this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';
        $this->lang=$this->lmodel->config('22', $this->setlang);
        $this -> web_title = $this -> mod_webconfig -> config($_SERVER['REQUEST_URI']);

        if (!empty($_SESSION['MT']))
  	      $this -> ss = $this -> mod_views -> login_session($_SESSION['MT']);
  	  	else
  	  		@session_write_close();

  	  	//分享函式
  	  	$this->load->library('/mylib/share');
  	  	$this->load->library('/mylib/useful');
  	  	//model
        $this->load->model('/MyModel/mymodel'); 
        $this->load->model('member_model','mmodel');

	}

	public function items($account, $type = 'C', $element = '')
	{
		if(empty($_SESSION['MT'])){
			$this->useful->AlertPage('/gold/login','請先登入或註冊');
		}
		$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'iqr.l_name', 'iqr.f_name'), array('member.account' => $account), 'member_id', 'row');
		$data = $this -> mod_views -> category_list($element);
		$data['aid'] = $account;

		switch ($iqr['theme_id']) {
			case '10':
				$path = 'temp10' . DIRECTORY_SEPARATOR . $data['filename'];
				break;
		}
		$display='style="display: none;"';
		//關於國鼎
		$about_data=$this->mmodel->get_ck_num(1);
		$data['about_data']=($about_data!=0)?'':$display;
		//最新消息
		$hot_data=$this->mmodel->get_ck_num(2);
		$data['hot_data']=($hot_data!=0)?'':$display;
		//衛教資訊
		$HE_data=$this->mmodel->get_ck_num(3);
		$data['HE_data']=($HE_data!=0)?'':$display;
		//心得投稿
		$reviews_data=$this->mmodel->get_ck_num(6);
		$data['reviews_data']=($reviews_data!=0)?'':$display;
	
		$data['is_login'] = $this -> ss;
		$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
		$this -> load -> view(DIRECTORY_SEPARATOR. 'gold' .DIRECTORY_SEPARATOR. 'footer', $data);
	}

	public function d($account, $element, $category_id, $id = '',$isshareurl='',$docallapp='')
	{


		$iqr = $this -> mod_views -> inner_join('member', 'iqr', array('iqr.theme_id', 'member.account', 'member.member_id','member_num'), array('member.account' => $account), 'member_id', 'row');

		$data['share_url'] = base_url().'business/iqr/'.$iqr['account'];
		if($this->get_device_os() != 'windows')
			$data['plurk_m_btn'] = true;
		else
			$data['plurk_m_btn'] = false;

		if (!empty($iqr))
		{
			$data['aid'] = $iqr['account'];
			$data['member_id'] = $iqr['member_id'];
			$data['category_id'] = $category_id;
		}
		
		if ($element != 'photo')
		{
			$auth_category = $this -> mod_views -> select_from('auth_category', array('type', 'c_name as name', 'category_id as id'), array('category_id' => $category_id, 'lang_type' => $this->setlang), 'row');
			$data['title'] = $auth_category['name'];
		}

		$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;

		switch ($iqr['theme_id']) {
			case '10':
				$path = 'temp10' . DIRECTORY_SEPARATOR;
				break;
		}

		// print_r($_SESSION['MT']);
		$data['Share']=$this->share->config($data['title'],$account,$isshareurl,$docallapp,$iqr['member_id']);
		// print_r($data['Share']);

		$data['img_url']=$this->Spath;

		$this -> mod_views -> category_and_detail($data, $path, $category_id, $id);
		$this -> load -> view(DIRECTORY_SEPARATOR. 'gold' .DIRECTORY_SEPARATOR. 'footer', $data);	
	}
	private function app_converter($elements_array)
	{
		$elements = '';
		if (!empty($elements_array)) {
			foreach ($elements_array as $key => $value)
			{
				if ($key > 0)
					$elements .= '/';
				$elements .= rawurlencode($value);
			}
		}
		return $elements;
	}
	public function AddCollection(){
	
		$_SESSION['AT']['account']=$_POST['account'];
		$member_data=$this->mmodel->get_member_sign('','','',$id);
		$_SESSION['AT']['member_id']=$member_data['member_id'];

		if(!empty($_SESSION['MT'])){
			$dbdata=$this->mymodel->OneSearchSql('collection','d_id',array('BID'=>$_SESSION['MT']['by_id'],'d_url'=>$_POST['url']));
			if(empty($dbdata)){			
				$idata=array(
					'BID'=>$_SESSION['MT']['by_id'],
					'd_title'=>$_POST['title'],
					'd_url'=>$_POST['url'],
					'create_time'=>$this->useful->get_now_time(),
				);
				$this->mymodel->insert_into('collection',$idata);
			}
			$response = array('re_code' => '1', 're_message' => '加入完成');
		}else{
			$response = array('re_code' => '0', 're_message' => '請先登錄!');
		}
			echo json_encode($response);
	}
}