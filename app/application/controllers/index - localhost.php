<?php
class Index extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct()//初始化
	{
		parent::__construct();


		// language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang') || $this -> session -> userdata('lang') == 'zh-tw')
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('14', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		//model
		$this->load->model('index_model', 'mod_index');

		//library
		$this->load->library('encrypt');
		
		//helper
		$this->load->helper('url');
		
		//host
		$this->data['host']=$this->get_host_config();

		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id']=$this->session->userdata('session_domain');
		else
			$this->data['domain_id']=$this->data['host']['domain_id'];
$this->data['domain_id']=0;

		//web config
		$this->data['web_config']=$this->get_web_config($this->data['domain_id']);
		
		//設定web banner
		$this->data['web_banner_dir']=$this->set_web_banner_dir($this->data['domain_id'], $this->data['web_config']['web_banner'], $this->data['host']['domain']);

	}

	public function s_lang($case = '')
	{
		switch ($case) {
			case '1':
				$this -> session -> set_userdata('lang', 'EN');
				break;
			case '2':
				$this -> session -> set_userdata('lang', 'JAP');
				break;
			default:
				$this -> session -> set_userdata('lang', 'TW');
				break;
		}
	}

	//時間
	public function showtime($time='')
	{
		echo date_default_timezone_get().'<br>';
		echo time().'<br>';
		echo date('Y-m-d H:i:s', time()).'<br>';

		if($time != '')
		{
			echo '<br>';
			echo $time.'<br>';
			echo date('Y-m-d H:i:s', $time).'<br>';
		}
		
		return 0;
	}

	//錯誤頁面
	public function error()
	{
		// content , http error, header title
		show_error('無此頁面', '404', 'Error');
		// $this->myredirect(base_url(), '無此頁面', 5);
		return 0;
	}

	//註冊頁面
	public function register($auth='')
	{
		//data
		$data=$this->data;
		$language = $this -> language;
		$this -> lang -> load('register', $data['lang']);
		$data['_Registered'] = lang('_Registered');
		$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
		$data['Registered'] = lang('Registered');
		$data['ActionBusiness'] = lang('ActionBusiness');
		$data['AccountNumber'] = lang('AccountNumber');
		$data['Password'] = lang('Password');
		$data['CheckPassword'] = lang('CheckPassword');
		$data['Email'] = lang('Email');
		$data['CardNumber'] = lang('CardNumber');
		$data['LicenseKey'] = lang('LicenseKey');
		$data['ScanRightNum'] = lang('ScanRightNum');
		$data['SendRegisteredData'] = lang('SendRegisteredData');
		$data['ReturnsLogin'] = lang('ReturnsLogin');
		$data['SendRegisteredDataNow'] = lang('SendRegisteredDataNow');

		//檢查公司註冊入口驗證碼
		if($auth != '')
		{
			if($this->session->userdata('session_domain') || ($auth == $this->encrypt->decode($data['web_config']['register_code'])))
			{
				//入口代入form action
				$data['register_code']=$auth;

				if(!$this->input->post('account'))
				{
					//驗證碼設定
					$len=5;
					$num=$this->random_vcode($len);
					$this->session->unset_userdata('VCODE');
					for($i = 0; $i < $len; $i++)
					{
						$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
					}
					$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
					$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
					$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
					$data['hiddenvcode']=$s_vcode;

					//base_url()
					$data['base_url']=base_url();

					//view
					$this->load->view('register', $data);
				}
				else
				{
					//現在時間
					$now_time=time();

					//deadline
					if($this->input->post('key_value') != -1)
					{
						$effectiveDate=date('Y-m-d', $now_time);
						$keys_data=$this->mod_index->select_from('keys', array('key_value'=>$this->input->post('key_value')));
						$deadline=strtotime("+".$keys_data['key_power']." months", strtotime($effectiveDate));
					}
					else
					{
						$effectiveDate=date('Y-m-d', $now_time);
						$deadline=strtotime("+12 months", strtotime($effectiveDate));
					}
					$deadline=$deadline+86400;

					//密碼加密
					$usr_password=$this->encrypt->encode($this->input->post('password'));

					//會員資料
					$member_info=array(
						'account'	=> $this->input->post('account'),
						'domain_id'	=> $data['domain_id'],
						'password'	=> $usr_password,
						'email'		=> $this->input->post('email'),
						'addtime'	=> $now_time,
						'deadline'	=> $deadline,
						'auth'		=> '0'.$data['web_config']['auth_level_num']//預設層級-最底層
					);
					$member_id = $this->mod_index->insert_into('member', $member_info);
					$domin0 = $this -> mod_index -> select_from('domain', array('domain_id' => $data['domain_id']));
					$shelf_info = array(
						'member_id' 	=> $member_id,
						'shelf_HD_url'  => 'images/web_style_images/'.$domin0['domain'].'/app_welcome_page/icon.png',
						'type'			=> 0
					);
					$shelf_id = $this->mod_index->insert_into('application_shelves',$shelf_info);

					//行動名片欄位
					$iqr_info=array(
						'member_id'			 => $member_id,
						'banner_status'		 => 0,
						'banner_status_name' => '',
						'theme_id'			 => 1,
						'theme_bg_type'		 => 0,
						'cart_id'			 => 1
					);
					$iqr_id = $this->mod_index->insert_into('iqr', $iqr_info);

					//商店
					if($data['web_config']['cart_status'] == 1)
					{
						//cset_code
						$this->load->model('cart_model', 'mod_cart');
						$cset_code=$this->mod_cart->make_random_cset_code(12);

						$cart_data=array(
							'member_id'		 => $member_id,
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

					//會員圖檔資料夾
					$img_url = $this->mod_index->create_dir($member_id);
					$this->mod_index->update_set('member', 'member_id', $member_id, array('img_url'=>$img_url));

					//金鑰狀態更新
					$this->mod_index->update_set('keys', 'key_value', $this->input->post('key_value'), array('key_use'=>1, 'member_id'=>$member_id, 'ip'=>$this->get_realip()));

					//設定ckeditor使用的資料夾路徑
					$this->start_session(3600);
					$_SESSION['member_id'] 	  = $member_id;
					$_SESSION['IsAuthorized'] = true;
					$_SESSION['img_url'] 	  = $img_url.'ckfinder_image/';

					//建立QRcode and 空的QRcode內嵌圖片
					$this->mod_index->create_qrcode_style($member_id, 0);//iqr
					$this->mod_index->create_qrcode_style($member_id, 1);//mecard
					$this->mod_index->create_qrcode_style($member_id, 2);//iqr app

					//寄送註冊成功信
					$domain_data=$this->mod_index->select_from('domain', array('domain_id'=>$data['domain_id']));
					//主旨
					$subject=$data['host']['company'].' '.$language['ActionBusinessLetter'];
					//內容
					$message=''.
						"<p>".$language['_RegistrationSuccess']."</p>".
						"<p>".$language['AccountIs']."：".$this->input->post('account')."</p>".
						"<p>".$language['PasswordIs']."：".$this->input->post('password')."</p>".
						"<p>{unwrap}<a href='http://".$domain_data['domain']."/index/login'>".$language['LogInTo']."</a>{/unwrap}</p>".
						"<hr>".
						"<p>".$language['DoNotDirectlyReply']."</p>";
					//寄信
					$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $this->input->post('email'), $subject, $message);
					$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], 'alice@netnews.com.tw', $subject.'(傳銷版)', $message);

					if(!empty($domain_data['sys_mail']))
					{
						$mail_array = $this -> mod_index ->  mail_setter($domain_data['sys_mail']);
						foreach ($mail_array as $key => $value)
						{
							$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $value, $subject. '(傳銷版)', $message);
						}
					}
					
					//自動登入
					if($this->input->post('key_value') != -1)
					{
						$this->session->set_userdata('member_id', $member_id);
						$this->session->set_userdata('domain_id', $data['domain_id']);
						$this->session->set_userdata('auth', '0'.$data['web_config']['auth_level_num']);
						$this->myredirect('/business/edit', $language['RegistrationSuccess'], 5);
					}
					else
					{//後台開帳號
						$this->myredirect('/admin/member_management', $RegistrationSuccess, 5);
					}
					return 0;
				}
			}
			else
			{
				header('Location:'.base_url().'index/login');
			}
		}
		else
		{
			header('Location:'.base_url().'index/login');
		}
	}

	// 帳號重複驗證
	public function revartify()
	{
		$data = $this -> data;
		if($this->input->post('u'))
		{
			$member=$this->mod_index->select_from('member', array('account'=>$this->input->post('u')));
			if(empty($member))
			{
				$result['mbr_account_error']  = true;
				$result['mbr_account_result'] = '';
			}
			else
			{
				$result['mbr_account_error']  = false;
				$result['mbr_account_result'] = $data['AccountRepeatedEmail'];
			}
		}
		else
		{
			$result['mbr_account_error']  = false;
			$result['mbr_account_result'] = $data['NotIllegalOperations'];
		}
		//結果回傳
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	public function login()
	{

		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('15', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);
		
		//檢查是否記住我
		$this->start_session(3600);
		
		if($_SESSION['member_id'] != '' && $_SESSION['member_id'] != 0)
		{
			$this->session->set_userdata('member_id', $_SESSION['member_id']);
			$this->session->set_userdata('auth', $_SESSION['auth']);
			$this->session->set_userdata('domain_id', $_SESSION['domain_id']);
			if($this->session->userdata('auth') == '00' && $data['domain_id'] == 0)
				header('Location: '.base_url().'admin/panel');
			else
				header('Location: '.base_url().'business/edit');
		}
		else
		{
			
			if(!$this->input->post('account'))
			{
				//驗證碼設定
				$len=5;
				$num=$this->random_vcode($len);
				$this->session->unset_userdata('VCODE');
				for($i = 0; $i < $len; $i++)
				{
					$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
				}
				$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
				$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
				$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
				$data['hiddenvcode']=$s_vcode;

				//base_url
				$data['base_url']=base_url();

				//register code
				$data['register_code']=$this->encrypt->decode($data['web_config']['register_code']);
				//view
				$this->load->view('login', $data);
				$this -> load -> library('session');
			}
			else
			{
				$this -> load -> library('session');

				//check
				$this -> chk_login_error();
				$account  = $this->input->post('account');	//帳號
				$password = $this->input->post('password');	//未加密密碼
				try {
//echo $data['host']['domain_id'];exit;
$data['host']['domain_id'] = 0;
					$this->mod_index->login_check_v1($account, $password, $data['host']['domain_id']);
				} catch (Exception  $e) {
					if($e -> getCode() > 0)
					{
						// print_r($e->getCode());break;
						@session_start();
						$this->session->unset_userdata('login_error');
						$this->session->unset_userdata('wip');
						//member
						$m=$this->mod_index->select_from('member', array('account'=>$account));
						
						//國鼎
						if($m['d_is_open']=='N' and $m['auth'] == '00'){
							$this -> script_message('此帳號停權中', '/index/login');
							return '';
						}

						//檢查使用時間, 使用期滿，無法登入, 名片頁無法使用
						$now_time=time();
						$time_out=false;
						if($m['auth'] != '00')
						{
							if($data['web_config']['g_deadline_status'] == 0)//設定個別期限
							{
								if($now_time > $m['deadline'])
									$time_out=true;
							}
							else if($data['web_config']['g_deadline_status'] == 1 && $data['web_config']['global_deadline'] != '')//設定全局期限
							{
								if($now_time > $data['web_config']['global_deadline'])
									$time_out=true;
								echo '1';
							}
							if($time_out)
							{
								$this->session->unset_userdata('member_id');
								$this->session->unset_userdata('domain_id');
								$this -> script_message($data['AccountDeadline'], '/index/login');
								// $this->myredirect('/index/login', '您的帳戶使用期限已到期，請聯絡您的網站管理員', 5);
								return 0;
							}
						}

						//img_url修正
						if($m['img_url'] == '0')
						{
							$member_dir=$this->get_member_dir($m['member_id']);

							//修正會員狀態
							$member_update=$this->mod_index->update_set('member', 'member_id', $m['member_id'], array('img_url'=>$member_dir));
						}
						
						//ckfinder
						$_SESSION['IsAuthorized']=true;
						$_SESSION['img_url']=$m['img_url'].'ckfinder_image/';

						//登入成功
						if($this->input->post('remember_me'))//勾選記住我
						{
							$_SESSION['member_id']=$m['member_id'];
							$_SESSION['auth']=$m['auth'];
							$_SESSION['domain_id']=$data['domain_id'];
						}
						
						//session
						$this->session->set_userdata('auth', $m['auth']);
						$d_action=$this->mod_index->select_from('jurisdicer', array('d_id'=>$m['d_action']));
						$_SESSION['AT']['action_list']=$d_action['d_action_list'];
						$_SESSION['AT']['account_name']=$m['account'];
						$_SESSION['AT']['account_id']=$m['member_id'];
					
						if($m['auth'] == '00' && $data['host']['domain_id'] == 0)
							$this->myredirect('/admin/panel', $data['SuperAdminLogin'], 5);
						else
							$this->myredirect('/business/edit', $data['LoginSuccessful'], 5);
						return 0;
					}
					else
					{
						//ck finder 資料夾關閉
						$_SESSION['IsAuthorized']=false;

						//記錄登入失敗次數
						if(!$this->session->userdata('login_error'))
							$this->session->set_userdata('login_error', 1);
						else
						{
							$this->session->set_userdata('login_error', $this->session->userdata('login_error')+1);

							//紀錄ip
							if($this->session->userdata('login_error') == 5)
							{
								$info=array(
									'ip'=>$this->get_realip(),
									'time'=>$this->session->userdata('login_error'),
									'date'=>time(),
									'account'=>$account
								);
								$login_error_log_data=$this->mod_index->select_from('login_error_log', array('ip'=>$this->get_realip()));
								if(empty($login_error_log_data))
								{
									$this->session->set_userdata('wip', $this->get_realip());
									$this->mod_index->insert_into('login_error_log', $info);
								}
							}
						}
						$this -> script_message($e -> getMessage(), '/index/login');
					}
				}
			}
		}
	}

	private function chk_login_error()
	{
		//檢查
		$chk_try_login_error=$this->mod_index->select_from('login_error_log', array('ip'=>$this->get_realip()));	
		if(!empty($chk_try_login_error))
		{
			//確認重試時間
			if(time() > ($chk_try_login_error['date']+600))//time()+600s
			{
				$this->session->unset_userdata('login_error');
				//delete
				$this->mod_index->delete_where('login_error_log', array('ip'=>$this->session->userdata('wip')));
				$this->session->unset_userdata('wip');
			}
		}
	}

	// ajax 語系切換
	public function lang()
	{
		$lang = $this -> input -> post('lang');
		switch ($lang) {
			case 'zh-tw':
				$this -> session -> set_userdata('lang', 'TW');
				break;
			case 'zh-cn':
				$this -> session -> set_userdata('lang', 'zh-cn');
				break;
			case 'english':
				$this -> session -> set_userdata('lang', 'ENG');
				break;
			case 'japanese':
				$this -> session -> set_userdata('lang', 'JAP');
				break;
		}
		echo $lang . ' selected';
	}

	//登出
	public function logout()
	{
		$data=$this->data;
		$language = $this -> language;
		if($this->session->userdata('member_id') > 0)
		{
			$this->session->sess_destroy();
	        @session_start();
			@session_destroy();
			$this->myredirect('/index/login', $language['LogoutSuccessful'], 5);
			return 0;
		}
		else
		{
			$this->myredirect('/index/login', $language['NotLoggedIn'], 5);
			return 0;
		}
	}

	//忘記密碼
	public function request()
	{
		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('16', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		if(!$this->input->post('account'))
		{
			//驗證碼設定
			$len=5;
			$num=$this->random_vcode($len);
			$this->session->unset_userdata('VCODE');
			for($i = 0; $i < $len; $i++)
			{
				$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
			}
			$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
			$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
			$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
			$data['hiddenvcode']=$s_vcode;

			//base_url
			$data['base_url']=base_url();

			//view
			$this->load->view('request', $data);
		}
		else
		{
			//member
			$m=$this->mod_index->select_from('member', array('account'=>$this->input->post('account'), 'email'=>$this->input->post('email')));

			if(!empty($m))
			{
				//library
				$this->load->library('encrypt');

				//寄送密碼信
				//主旨
				$subject=$data['host']['company'].' '.$data['ActionBusinessLetter'];

				//內容
				$message=''.
					"<p>".$data['MemberHello']."</p>".
					"<p>".$data['YouInTime']."".date('Y-m-d H:i:s', time()).$data['ForgottenPassword']."</p>".
					"<p>".$data['AccountIs']."：".$this->input->post('account')."</p>".
					"<p>".$data['PasswordIs']."：".$this->encrypt->decode($m['password'])."</p>".
					"<p>{unwrap}<a href='http://".$data['host']['domain']."/'>".$data['LogInTo']."</a>{/unwrap}</p>".
					"<hr>".
					"<p>".$data['DoNotDirectlyReply']."</p>";
				//寄信
				$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $this->input->post('email'), $subject, $message);

				$this->myredirect('/index/login', $data['PasswordSentToMailbox'], 5);
				return 0;
			}
			else
			{
				$this->myredirect('/index/request', $data['InformationErrorRescan'], 5);
				return 0;
			}
		}
	}

	//驗證碼使用的隨機數字
	public function vcode($len)
	{
		if($this->input->get('s'))
		{
			$num=$this->encrypt->decode($this->input->get('s'));
			for($i = 0; $i < $len; $i++)
			{
				$array_num[$i] = substr ($num, $i, 1);
			}
			$this->make_vcode_img($array_num, $len);
		}
	}
	
	//驗證碼解密
	public function s_decode()
	{
		if($this->input->post('vcode') && $this->input->post('hide_vcode'))
		{
			if(strnatcmp($this->input->post('vcode'), $this->encrypt->decode($this->input->post('hide_vcode'))) == 0)
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		}
	}
	
	function get_member_dir($mid)
	{
		//full relative path
		$path='/uploads/';

		$user=str_pad($mid, 10, '0', STR_PAD_LEFT);
		$one=substr($user, 7, 3);
		$two=substr($user, 0, 3);
		$three=substr($user, 3, 4);
		$dir='.'.$path.$one.'/'.$two.'/'.$three.'/'.$user;

		$temp = explode('/', $dir);
		$cur_dir = '';
		for($i = 0; $i < count($temp); $i++)
		{
			$cur_dir .= $temp[$i].'/';
		}
		return substr($cur_dir, 1, (strlen($cur_dir) - 1));
	}

	//session
	function start_session($expire = 0)
	{
	    if ($expire == 0) {
	        $expire = ini_get('session.gc_maxlifetime');
	    } else {
	        ini_set('session.gc_maxlifetime', $expire);
	     }
	 
	    if (empty($_COOKIE['PHPSESSID'])) {
	        session_set_cookie_params($expire);
	        session_start();
	    } else {
	        session_start();
	        setcookie('PHPSESSID', session_id(), time() + $expire);
	     }
	}

	//產生無+號的加密碼
	function my_encrypt_encode($vcode)
	{
		do
		{
			$str=$this->encrypt->encode($vcode);
		}
		while(strpos($str, '+') !== false);
		return $str;
	}
	
}
