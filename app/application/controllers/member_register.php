<?php
defined('BASEPATH') or exit('No direct script access allowed');

class member_register extends MY_Controller
{
	private $_check;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('/mylib/CheckInput', '/mylib/comment', '/mylib/useful', 'encrypt', 'sms_tools', 'session'));
		$this->load->model('/MyModel/mymodel');
		$this->load->model('member_model', 'mmodel');
		$this->load->model('login_model');
		$this->load->helper('url');
		//語言包設置
		$this->load->model('lang_model', 'lmodel');
		$this->_check = new CheckInput;
		$this->_check->lang = $this->lmodel->config('9999', $this->setlang);
		$this->_check->lang = $this->lmodel->config('3', $this->setlang);
	}

	public function register_on()
	{
		$this->lang = $this->lmodel->config('3', $this->setlang);
		$data['path_title'] = '<li><a href="/member_register/register_on"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		//非台灣則不顯示城市鄉鎮
		$data['setlang'] = $this->setlang;

		if ($_SESSION['ssoc'] != 1) {
			unset($_SESSION['RT']);
		}
		$data['dbname'] = $dbname = 'buyer';
		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();
		//國碼撈取
		$data['country_num'] = $this->mymodel->get_country_num();

		if ($_SESSION['MT']['upline'] == "" && $_COOKIE['upline'] != '') $_SESSION['MT']['upline'] = $_COOKIE['upline'];
		if ($_SESSION['MT']['upline'] == "" && $upline != "") $_SESSION['MT']['upline'] = $upline;
		if ($_SESSION['MT']['upline'] != "" && $upline == "") $upline = $_SESSION['MT']['upline'];

		if ($upline != "") {
			//解碼
			$upline = base64_decode($upline);
			$upline_by_id = $this->mymodel->OneSearchSql('buyer', 'by_id', array('d_account' => $upline));
			$data['upline_by_id'] = $upline_by_id['by_id'];
		} else {
			$data['upline_by_id'] = 1;
		}
		// 取會員註冊說明
		$tData = [
			'd_type'		=>	'terms',
			'lang_type'		=>	$data['setlang'],
		];
		$data['registerDesc'] = $this->mymodel->select_from_where('config', 'd_val', $tData);
		$data['registerDesc'] = $data['registerDesc']['d_val'];

		//view
		$this->load->view($this->indexViewPath . '/header', $data);
		$this->load->view($this->indexViewPath . '/register/register', $data);
		$this->load->view($this->indexViewPath . '/footer', $data);
	}
	public function register()
	{
		// 語言包
		$this->lang1 = $this->lmodel->config('3', $this->setlang);
		$this->_check->fname[] = array('_CheckEmail', Comment::SetValue('by_email'), 'E-mail');
		//$this->_check->fname[] = array('_String', Comment::SetValue('mobile'), $this->lang1['mobile'] /* 帳號 */);
		$this->_check->fname[] = array('_String', Comment::SetValue('name'), $this->lang1['dname'] /* 姓名 */);
		$this->_check->fname[] = array('_String', Comment::SetValue('by_pw'), $this->lang1['password'] /* 密碼 */);
		$buyer_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('d_account' => Comment::SetValue('d_account')));

		if (!empty($buyer_data)) {
			$this->useful->AlertPage('/register/' . Comment::SetValue('PID'), $this->lang1['someacc'] /* 已有相同帳號，請重新輸入? */);
			return '';
		}

		$member_data = $this->mymodel->select_page_form('member', '', 'by_id', array('account' => Comment::SetValue('d_account')));

		if (!empty($member_data)) {
			$this->useful->AlertPage('/register/' . Comment::SetValue('PID'), $this->lang1['someacc'] /* 已有相同帳號，請重新輸入? */);
			return '';
		}

		if (strlen(Comment::SetValue('by_pw')) < 5) {
			$this->useful->AlertPage(
				'',
				$this->lang1['pwdfive']
				/** 密碼至少五位數?*/
			);
			return '';
		}

		$data['by_pw'] = $this->encrypt->encode(Comment::SetValue('by_pw'));
		$data['d_is_member'] = '0';
		if (Comment::SetValue('PID') != "") {
			$rule = $this->mymodel->GetConfig('rule');
			$data['PID'] = Comment::SetValue('PID');
			$data['d_dividend'] = $rule[6]['d_val']; // 接受推薦送100點紅利
			//推薦人也送100點紅利
			$d_dividend_data = $this->mymodel->OneSearchSql('buyer', 'd_dividend', array('by_id' => 4));
			$d_dividend = $d_dividend_data['d_dividend'] + $rule[7]['d_val'];
			$this->mymodel->update_set('buyer', 'by_id', Comment::SetValue('PID'), array('d_dividend' => $d_dividend));
			// 推薦人寫入紅利說明
			$didata = array(
				'buyer_id' => Comment::SetValue('PID'),
				'd_type' => '19',
				'd_val' => $rule[7]['d_val'],
				'd_des' => $this->lang1['mem_bouns_get'], // 推薦註冊成功發送紅利
				'is_send' => 'Y',
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time(),
				'send_dt' => $this->useful->get_now_time()
			);
			$this->mymodel->insert_into('dividend', $didata);
		} else {
			$data['PID'] = $_SESSION['AT']['member_id'];
			if ($data['PID'] == null) $data['PID'] = "0";
		}
		// 去除陣列無用值
		$data = $this->useful->UnsetArray($data, array('chk_ok', 'member_register'));
		//新增資料
		if (!empty($this->_check->main())) {
			echo $this->_check->main(base_url('register'));
			return '';
		}

		//簡訊寄送驗證碼
		$checkCode = $this->sms_tools->getCode(8, 3);
		$this->sms_tools->subject = $this->lang1['sms_code_is'];
		$this->sms_tools->content = $this->lang1['sms_code_is'] . '：' . $checkCode;
		$this->sms_tools->mobile = $this->input->post('d_account');
		$this->sms_tools->sendSms();

		$myData = array(
			'PID'					=> $data['PID'],
			'd_account'		=> $this->input->post('d_account'),
			'by_pw'				=> $data['by_pw'],
			'name'				=> $this->input->post('name'),
			'birthday'			=> $this->input->post('birthday'),
			'by_email'			=> $this->input->post('by_email'),
			'country'				=> $this->input->post('country'),
			'address'			=> $this->input->post('address'),
			'telphone'			=> $this->input->post('telphone'),
			'check_code'		=> $checkCode,
			'mobile'				=> $this->input->post('d_account'),
			'd_content'		=> $this->input->post('d_content'),
			'd_service'			=> $this->input->post('d_service'),
			'create_time'		=> date('YmdHis'),
			'update_time'	=> date('YmdHis')
		);
		$create_id = $this->mymodel->insert_into('buyer', $myData);
		$this->session->set_userdata('create_id', $create_id);
		$this->session->set_userdata('ld', array('account' => $this->input->post('d_account'), 'password' => $this->input->post('by_pw')));
		//進行簡訊驗證
		redirect(base_url('member_sms_code'));
	}

	public function mobile()
	{
		@session_start();
		$this->DataName = 'member';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/gold/' . $this->DataName . '"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['path_title'] .= '<li><a href="member_mobile"><span>' . $this->lang["editMobile"] . '</span></a></li>';
		//初始設定
		// $this->useful->iconfig($_SESSION['AT']['account']);

		$data['banner'] = '';

		$this->useful->iconfig();

		//語言包
		$this->lang = $this->lmodel->config('7', $this->setlang);

		if (!empty($_POST)) {
			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->lang = $this->lmodel->config('9999', $this->setlang);

			$check->fname[] = array('_String', Comment::SetValue('old_mobile'), $this->lang1['oldmobile']/*舊手機*/);
			$check->fname[] = array('_String', Comment::SetValue('new_mobile'), $this->lang['newmobile']);	//新手機
			$check->fname[] = array('_String', Comment::SetValue('re_new_mobile'), $this->lang['rnewmobile']); //再次輸入手機
			if (!empty($check->main())) {
				echo $check->main();
				return '';
			}

			$dbdata = $this->mymodel->OneSearchSql('buyer', 'mobile', array('by_id' => $_SESSION['MT']['by_id']));
			if ($dbdata['mobile'] == Comment::SetValue('old_mobile')) {
				if (Comment::SetValue('new_mobile') == Comment::SetValue('re_new_mobile')) {
					$new_mobile = Comment::SetValue('new_mobile');
					//$this->mymodel->update_set('buyer','by_id',$_SESSION['MT']['by_id'],array('by_pw'=>$new_mobile));
					//$this->useful->AlertPage('/gold/member_info',$this->lang['s_editsu']);		//修改完成
					//資料確定沒有問題後先記到SESSION中，先進行簡訊驗證
					$this->lang1 = $this->lmodel->config('3', $this->setlang);
					$this->session->set_userdata('cgmy_mobile', $new_mobile);
					$checkCode = $this->sms_tools->getCode(8, 3);
					$this->session->set_userdata('sms_my_code', $checkCode);
					$this->sms_tools->subject = $this->lang1['sms_code_is'];
					$this->sms_tools->content = $this->lang1['sms_code_is'] . '：' . $checkCode;
					$this->sms_tools->mobile = $new_mobile;
					$this->sms_tools->sendSms();
					redirect(base_url('sms_mobile'));
				} else
					$this->useful->AlertPage('/member_mobile', $this->lang['newreno']);	//新密碼跟再次輸入不符,請重新輸入
			} else
				$this->useful->AlertPage('/member_mobile', $this->lang['oldfaile']);	//舊密碼錯誤,請重新輸入
		}

		//view
		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_nav', $data);
		$this->load->view('index/member/member_mobile', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	public function sms_change_mobile()
	{
		$this->lang = $this->lmodel->config('3', $this->setlang);
		if ($this->input->post('action') == 'check_code') {
			if ($this->input->post('check_code') == $this->session->userdata('sms_my_code')) {
				$this->load->model('login_model');
				$this->mymodel->update_set('buyer', 'by_id', $_SESSION['MT']['by_id'], array('mobile' => $this->session->userdata('cgmy_mobile')));
				$this->session->set_userdata('cgmy_mobile', '');
				$this->session->set_userdata('sms_my_code', '');
				$this->useful->AlertPage('/gold/member_info', $this->lang['change_mobile_ok']);
			} else {
				$this->session->set_userdata('cgmy_mobile', '');
				$this->session->set_userdata('sms_my_code', '');
				$this->useful->AlertPage('/gold/member', $this->lang['sms_error_time']);
			}
		}

		$data['path_title'] = '<li><a href="/gold/member"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['path_title'] .= '<li><a href="/member_mobile"><span>' . $this->lang["editMobile"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		$this->load->view('index/header' . $this->style, $data);
		$this->load->view('index/member/member_sms_mobile', $data);
		$this->load->view('index/footer' . $this->style, $data);
	}

	public function sms_code()
	{
		$this->lang1 = $this->lmodel->config('3', $this->setlang);
		if ($this->input->post('action') == 'check_code') {

			$user_data = $this->mymodel->select_page_form('buyer', '', 'by_id, name, check_code', array('by_id' => $this->session->userdata('create_id')));
			if ($user_data[0]['check_code'] == $this->input->post('check_code')) {
				//解除帳號限制
				$this->load->model('login_model');
				$this->mymodel->update_set('buyer', 'by_id', $this->session->userdata('create_id'), array('check_code' => ''));
				//$this->session->set_userdata('create_id', '');
				//$this->login_model->login_chekc($this->session->userdata('ld'));
				//$this->session->set_userdata('ld', '');
				//$this->useful->AlertPage('/gold/login', $this->lang1['sms_ok_join']);
				redirect(base_url('member_register_ok'));
			} else {
				$this->session->set_userdata('create_id', '');
				$this->useful->AlertPage('/gold/login', $this->lang1['sms_error_time']);
			}
		}
		if ($this->session->userdata('create_id') > 0) {
			//再重新寄送驗證碼
			$user_data = $this->mymodel->select_page_form('buyer', '', 'by_id, d_account, name, check_code', array('by_id' => $this->session->userdata('create_id')));
			$checkCode = $this->sms_tools->getCode(8, 3);
			$this->sms_tools->subject = $this->lang1['sms_code_is'];
			$this->sms_tools->content = $this->lang1['sms_code_is'] . '：' . $checkCode;
			$this->sms_tools->mobile = $user_data[0]['d_account'];
			$this->sms_tools->sendSms();
			$this->mymodel->update_set('buyer', 'by_id', $user_data[0]['by_id'], array('check_code' => $checkCode));
		}

		$this->lang = $this->lmodel->config('3', $this->setlang);
		$data['path_title'] = '<li><a href="/member_register/register_on"><span>' . $this->lang["$this->DataName"] . '</span></a></li>';
		$data['banner'] = $this->data['banner'];

		$this->load->view($this->indexViewPath . '/header', $data);
		$this->load->view($this->indexViewPath . '/register/register_message_valid', $data);
		$this->load->view($this->indexViewPath . '/footer', $data);
	}

	public function register_ok()
	{
		if (empty($this->session->userdata('create_id'))) redirect(base_url('gold/login'));
		$user_data = $this->mymodel->select_page_form('buyer', '', 'by_id, by_pw, d_account, by_email, name', array('by_id' => $this->session->userdata('create_id')));
		$this->session->set_userdata('create_id', '');
		//抓網頁設定判斷是否自動升級經營會員
		//host
		$this->data['host'] = $this->get_host_config();

		// domain id
		if ($this->session->userdata('session_domain'))
			$this->data['domain_id'] = $this->session->userdata('session_domain');
		else
			$this->data['domain_id'] = $this->data['host']['domain_id'];

		// web config
		$this->data['web_config'] = $this->get_web_config($this->data['domain_id']);

		// 是否自動升級經營會員
		if ($this->data['web_config']['is_auto_upgrade_member'] == 1) {
			$member_data = array(
				'by_id' => $user_data[0]['by_id'],
				'domain_id' => '1',
				'account' => $user_data[0]['d_account'],
				'password' => $user_data[0]['by_pw'],
				'email' => $user_data[0]['by_email'],
				'identity_num' => '',
				'country' => '',
				'city' => '',
				'countory' => '',
				'address' => '',
				'bank_name' => '',
				'bank_account_name' => '',
				'bank_account' => '',
				// 'bank_address'=>'',
				// 'swift_code'=>'',
				'wowpay_email' => '',
				'wowpay_country_num' => '',
				'wowpay_mobile' => '',
				'wowpay_cardAsn' => '',
				'wowpay_pay_password' => '',
				'wowpay_login_password' => '',
				'wowpay_signature' => '',
				'upline' => '',
				'auth' => '02',
				'addtime' => time(),
				'join_time' => $this->useful->get_now_date(),
				'deadline' => strtotime(date('Y-m-d', strtotime('' . $this->useful->get_now_date() . ' +19 years'))),
				'create_time' => $this->useful->get_now_time(),
				'update_time' => $this->useful->get_now_time()
			);

			// $member_id = $this->mmodel->insert_into('member', $member_data);
			// 修改buyer為經營會員
			$this->mymodel->update_set('buyer', 'by_id', $user_data[0]['by_id'], array('d_is_member' => 1));
		}

		/*$account = Comment::SetValue('d_account');
		$acconut_id = $_SESSION['AT']['account'];

		$nonum = base64_encode(date('Ymd') . '_' . $account . '_' . $acconut_id . '');
		$tinyurl = $this->useful->getTinyUrl(base_url() . 'gold/member_verify?nonum=' . $nonum . '');
*/
		// 主旨
		$subject = $this->data['web_config']['title'] . '會員註冊通知函';
		//$adata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('country')));
		//$bdata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('city')));
		//$cdata = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => Comment::SetValue('countory')));
		// 內容
		$message = '' .
			"<p>*********************************************************************</p>" .
			"<p>請注意！如要確保電子郵件能被正常收件，請將service@supergoods.com.tw</p>" .
			"<p>加入您的通訊錄中，謝謝。</p>" .
			"<p>*********************************************************************</p>" .
			"<p>&nbsp;</p>" . "<p>親愛的會員 您好：</p>" . "<p>&nbsp;</p>" .
			"<p>歡迎您加入「超惠購」商城會員！</p>" . "<p>「超惠購」商城提供多元化生活商品，</p>" .
			"<p>提供您一次購足、當月滿足；件件超省、樣樣超值的購物體驗。</p>" . "<p>&nbsp;</p>" .
			"<p>即日起新會員還享獨家入會好禮！</p>" . "<p>您註冊的帳號：" . $user_data[0]['d_account'] . "</p>" .
			"<p>已完成註冊，並開啟完整的會員功能。</p>" . "<p>&nbsp;</p>" .
			"<p>日後「超惠購」好康訊息與商城通知都將寄送到此信箱，</p>" .
			"<p>請密切注意，不要錯失任何一個優惠好康與活動。</p>" . "<p>&nbsp;</p>" .
			"<p>如有疑問，隨時歡迎您與「超惠購」客服中心聯繫，謝謝。</p>" . "<p>&nbsp;</p>" .
			"<p>超惠購聯絡電話：0424351862</p>" . "<p>超惠購聯絡地址：台中市北屯區東山路一段50-18號</p>" .
			"<p>超惠購網址：supergoods.com.tw</p>" .
			"<p>客服信箱：service@supergoods.com.tw</p>";

		// 寄信
		
		/** Comment out cause email erro occur @todo 10 */
		// $this->mod_index->send_mail($this->get_host_config()['domain'], '超惠購', $user_data[0]['by_email'], $subject, $message);

		// 台灣註冊簡訊驗證 海外寄信信件驗證
		if ($this->setlang == 'TW') {
			// 註冊驗證系統-簡訊發送驗證網址
			// $this->load->library('Sms');
			// $sms=new sms('av8d20','80280616','N7SUQ3');

			// $content='感謝您註冊jcymall會員，請於今日內點選連結 '.$tinyurl.' 開通您的帳戶，逾時失效。';

			// $smsval=$sms->Send_sms('jcymall會員註冊驗證通知信',$content,Comment::SetValue('d_account'),Comment::SetValue('by_email'),'');
			// 註冊驗證系統-簡訊發送驗證網址
		} else {
			// model
			// $this->load->model('index_model', 'mod_index');
			// 主旨
			// if($this->setlang=='ENG')
			// $subject='jcymall Shop ​Member registration notice letter';
			// if($this->setlang=='JAP')
			// $subject='jcymall康会員登録通知書';

			// 內容
			// if($this->setlang=='ENG'){
			// $message="<p>Thank you for registering 'jcymall Shop', please
			// click the link earlier this day ".$tinyurl." opened your account,
			// failure timeout.</p>";
			// }
			// if($this->setlang=='JAP'){
			// $message="<p>「jcymall」を登録していただきありがとうございます、以前のこの日の".$tinyurl."は、障害のタイムアウトを、あなたのアカウントを開設したリンクをクリックしてください。";
			// }

			// 寄信
			// $this->mod_index->send_mail('jcymall.com','jcymall',
			// Comment::SetValue('by_email'), $subject, $message);
		}

		// $this->useful->AlertPage('/gold/login',$check->lang['regsucc']);//註冊成功,請重新登入
		// 註冊者受邀請紅利100點請寫入紅利說明
		$rule = $this->mymodel->GetConfig('rule');
		$didata = array(
			'buyer_id' => $user_data[0]['by_id'],
			'd_type' => '19',
			'd_val' => $rule[6]['d_val'],
			'd_des' => "受邀請註冊發送紅利", // 受邀請註冊發送紅利
			'is_send' => 'Y',
			'create_time' => $this->useful->get_now_time(),
			'update_time' => $this->useful->get_now_time(),
			'send_dt' => $this->useful->get_now_time()
		);
		$this->mymodel->insert_into('dividend', $didata);
		// 註冊成功後直接登入
		$_SESSION['AT']['d_account'] = $user_data[0]['d_account'];
		$login_data = array('account' => $user_data[0]['d_account'], 'password' => $user_data[0]['by_pw']);

		$admin = $this->login_model->login_chekc($this->session->userdata('ld')); // 管理者登入

		// 登入狀態紀錄
		$_SESSION['MT']['is_login'] = 1;
		$_SESSION['MT']['by_id'] = @$admin['by_id'];
		$_SESSION['MT']['name'] = @$admin['name'];
		$_SESSION['MT']['d_is_member'] = @$admin['d_is_member'];
		$_SESSION['MT']['member_id'] = @$admin['member_id'];

		$this->load->view($this->indexViewPath . '/header', []);
		$this->load->view($this->indexViewPath . '/register/register_complete', []);
		$this->load->view($this->indexViewPath . '/footer', []);
	}
}
