<?php
//非同步驗證
class Validate extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct()//初始化
	{
		parent::__construct();

		$this->load->model('index_model', 'mod_index');

		// helper
        $this->load->helper('url');

		// language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'zh-tw');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		// language
		$this -> lang -> load('controllers/validate', $this -> data['lang']);

		$this -> language['Use6Char'] = lang('Use6Char');
		$this -> language['PasswordNotMatch'] = lang('PasswordNotMatch');
		$this -> language['AccountRepeatedAccount'] = lang('AccountRepeatedAccount');
		$this -> language['RegisterNotEmpty'] = lang('RegisterNotEmpty');
		$this -> language['InvalidLicenseKey'] = lang('InvalidLicenseKey');
		$this -> language['NotUseIllegalChar'] = lang('NotUseIllegalChar');
		$this -> language['NotUseSpecialAccount'] = lang('NotUseSpecialAccount');
		$this -> language['Use5CharAbove'] = lang('Use5CharAbove');
		$this -> language['SecurityCodeMatch'] = lang('SecurityCodeMatch');
		$this -> language['MailFormatError'] = lang('MailFormatError');
		$this -> language['NotUseBlank'] = lang('NotUseBlank');
		$this -> language['LicenseError'] = lang('LicenseError');
	}

	//驗證註冊表單
	public function register()
	{
		$language = $this -> language;
		//資料設定
		$account 	 = $this->input->post('account');
		$password 	 = $this->input->post('password');
		$repassword  = $this->input->post('repassword');
		$email 		 = $this->input->post('email');
		$key_number  = $this->input->post('key_number');
		$key_value 	 = $this->input->post('key_value');
		$vcode 		 = $this->input->post('vcode');
		$hiddenvcode = $this->input->post('hiddenvcode');
		$domain_id 	 = $this->input->post('did');

		//空白驗證
		if(	$account == '' || 
			$password == '' || 
			$repassword == '' || 
			$email == '' || 
			$key_number == '' || 
			$key_value == '' || 
			$vcode == ''
		)
		{
			$result['empty_error'] = false;
			$result['empty_result']  = $language['RegisterNotEmpty'];
		}
		else
		{
			$result['empty_error'] = true;
			$result['empty_result']  = '';

			//帳號驗證
			if($account != '')
			{
				$vertify_str = $this->vertify_str($account, 0);//帳號不得包含中文
				if(strlen($account) >= 5 && $vertify_str == 1)
				{
					$member=$this->mod_index->select_from('member', array('account'=>$account));
					if(empty($member))
					{
						if($account != 'www' && $account != 'wwww')
						{
							if($this->check_symbol($account))
							{
								$result['account_error']  = true;
								$result['account_result'] = '';
							}
							else
							{
								$result['account_error']  = false;
								$result['account_result'] = $language['NotUseSpecialAccount'];
							}
						}
						else
						{
							$result['account_error']  = false;
							$result['account_result'] = $language['NotUseIllegalChar'];
						}
					}
					else
					{//帳號已存在
						$result['account_error']  = false;
						$result['account_result'] = $language['AccountRepeatedAccount'];
					}
				}
				else
				{
					$result['account_error']  = false;
					$result['account_result'] = $language['Use5CharAbove'];
				}
			}

			//密碼驗證
			if($password != '' && $repassword != '')
			{
				//建議密碼長度與強度
				$vertify_str = $this->vertify_str($password, 1);//密碼要英數混合
				if(strlen($password) >= 6 && $vertify_str == 1)
				{//密碼強度符合，比對確認密碼
					if($password == $repassword)
					{
						$result['password_error']  = true;
						$result['password_result'] = '';
					}
					else
					{
						$result['password_error']  = false;
						$result['password_result'] = $language['PasswordNotMatch'];
					}
				}
				else
				{
					$result['password_error']  = false;
					$result['password_result'] = $language['Use6Char'];
				}
			}

			//信箱驗證
			if($email != '')
			{
				$vertify_str = $this->vertify_str($email, 2);//信箱
				if($vertify_str == 1)
				{
					$result['email_error']  = true;
					$result['email_result'] = '';
				}
				else
				{
					$result['email_error']  = false;
					$result['email_result'] = $language['MailFormatError'];
				}
			}
			else
			{
				$result['email_error']  = false;
				$result['email_result'] = $language['NotUseBlank'];
			}

			//卡號驗證
			if($key_number != '' && $key_value != '')
			{
				$keys_data=$this->mod_index->select_from('keys', array('key_number'=>$key_number, 'key_value'=>$key_value, 'domain_id'=>$domain_id));
				if(!empty($keys_data))
				{
					if($keys_data['key_use'] != 1)
					{
						$result['keys_error']  = true;
						$result['keys_result'] = '';
					}
					else
					{
						$result['keys_error']  = false;
						$result['keys_result'] = $language['InvalidLicenseKey'];
					}
				}
				else
				{
					$result['keys_error']  = false;
					$result['keys_result'] = $language['LicenseError'];
				}
			}

			//驗證碼驗證
			if($vcode != '' && $hiddenvcode != '')
			{
				//library
				$this->load->library('encrypt');
				if(strnatcmp($vcode, $this->encrypt->decode($hiddenvcode)) == 0)
				{
					$result['vcode_error']  = true;
					$result['vcode_result'] = '';
				}
				else
				{
					$result['vcode_error']  = false;
					$result['vcode_result'] = $language['SecurityCodeMatch'];
				}
			}
		}

		if($result['empty_error'] && $result['account_error'] && $result['password_error'] && $result['email_error'] && $result['keys_error'] && $result['vcode_error'])
		{
			$result['result_error']=1;
		}
		else
		{
			$result['result_error']=0;
		}

		// $this->arr_print('result', $result);//type非json列印

		//結果回傳
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	//字符驗證
	public function vertify_str($str, $type)
	{
    	//字符驗證
    	$char=preg_match("/[\x{4e00}-\x{9fa5}]/u", $str);
    	$phonetic=preg_match("/[\x{3105}-\x{312d}]/u", $str);
    	$number=preg_match('/[0-9]/u', $str);
    	$english=preg_match('/[a-zA-Z]/u', $str);
    	$email=preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/', $str);
    	$whitespace=preg_match('/\s/', $str);

    	if($type == 0)
    	{//(帳號)不允許中文、注音或純數字
    		if(($english && !$char && !$phonetic && !$whitespace) || (($number && $english) && !$char && !$phonetic && !$whitespace))
    			return 1;
    		else
    			return 0;
    	}
    	else if($type == 1)
    	{//(密碼)僅允許英數混合
    		if($number && $english && !$phonetic && !$char && !$whitespace)
    			return 1;
    		else
    			return 0;
    	}
    	else if($type == 2)
    	{//(信箱)
    		if($email)
    			return 1;
    		else
    			return 0;
    	}
    	else if($type == 3)
    	{//(手機)僅允許純數字
    		if($number && !$english && !$phonetic && !$char && !$whitespace)
    			return 1;
    		else
    			return 0;
    	}
	}

	public function check_symbol($account)
	{
		$symbol[]=strpos($account, '_');
		$symbol[]=strpos($account, '`');
		$symbol[]=strpos($account, '!');
		$symbol[]=strpos($account, '@');
		$symbol[]=strpos($account, '#');
		$symbol[]=strpos($account, '$');
		$symbol[]=strpos($account, '%');
		$symbol[]=strpos($account, '^');
		$symbol[]=strpos($account, '&');
		$symbol[]=strpos($account, '*');
		$symbol[]=strpos($account, '-');
		$symbol[]=strpos($account, '(');
		$symbol[]=strpos($account, ')');
		$symbol[]=strpos($account, '+');
		$symbol[]=strpos($account, '=');
		$symbol[]=strpos($account, '[');
		$symbol[]=strpos($account, ']');
		$symbol[]=strpos($account, '\\');
		$symbol[]=strpos($account, '/');
		$symbol[]=strpos($account, ',');
		$symbol[]=strpos($account, '.');
		$symbol[]=strpos($account, '?');
		$symbol[]=strpos($account, '"');
		$symbol[]=strpos($account, '\'');
		$symbol[]=strpos($account, '|');
		$symbol[]=strpos($account, '{');
		$symbol[]=strpos($account, '}');
		$result=true;
		foreach($symbol as $key => $value)
		{
			if($value == true)
			{
				$result=false;
				break;
			}
		}
		return $result;
	}
}