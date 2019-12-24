<?php
//長短網址切換器
class S extends MY_Controller
{
	public $data='';

	public function __construct()//初始化
	{
		parent::__construct();

		//model
		$this->load->model('business_model', 'mod_business');

		//host
		$this->data['host']=$this->get_host_config();

		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id']=$this->session->userdata('session_domain');
		else
			$this->data['domain_id']=$this->data['host']['domain_id'];

		//web config
		$this->data['web_config']=$this->get_web_config($this->data['domain_id']);
	}

	//進入轉址
	public function r($id='')
	{
		//data
		$data=$this->data;

		//helper
		$this->load->helper('url');
		
		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//行動名片連結
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url=substr(base_url(), 7);
				$base_url=substr($base_url, 0, -1);
				$iqr_url='http://'.$id.'.'.$base_url;
			}
			else
			{
				$iqr_url=base_url().'business/iqr/'.$id;
			}

			echo '<script>window.location.href="'.$iqr_url.'";</script>';
		}
	}

	public function t()
	{
		$url = 'http://59.125.75.219/android/apk_build.php?url=http://59.125.75.222/project/a5284ae620ab9f17da1679a9b6a27a5f.zip&name=AppPlusNetnewsWeb&p=com.appplus&n=iqr0912345610&return_url=http://59.125.75.222/app/refresh_app/23/apk';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = json_decode(curl_exec($curl), true);
		curl_close($curl);
	}
}