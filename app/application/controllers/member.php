<?php
class Member extends MY_Controller
{
	public function __construct() //初始化
	{
		parent::__construct();

		//model
		$this->load->model('admin_model', 'mod_admin');

		//helper
		$this->load->helper('url');

		//host
		$this->data['host'] = $this->get_host_config();

		//domain
		if ($this->session->userdata('session_domain') != '') {
			$this->data['session_domain'] = $this->session->userdata('session_domain');
		} else {
			$this->data['session_domain'] = $this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain = $this->mod_admin->select_from('domain', array('domain_id' => $this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name'] = $this->session->userdata('session_domain_name');

		//web config
		$this->data['web_config'] = $this->get_web_config($this->session->userdata('session_domain'));
		$this->load->helper('form');
		//library
		$this->load->library('encrypt');
		//model
		$this->load->model('member_model', 'mmodel');
		$this->load->model('/MyModel/mymodel');
		$this->load->library('/mylib/useful');
		$this->load->library('/mylib/comment');

		$this->load->model('index_model', 'imodel');
	}
	//獎金首頁
	public function index()
	{
		//view
		$this->load->view('member/main', $data);
	}
	//會員列表
	// public function buyer_list(){

	// 	//權限判斷
	// 	$this->useful->CheckComp('j_member');

	// 	//資料庫名稱
	// 	$data['dbname']=$dbname='buyer';

	// 	$data['s_account']=$s_account=Comment::SetValue('s_account');
	// 	$data['s_num']=$s_num=Comment::SetValue('s_num');
	// 	$data['s_name']=$s_name=Comment::SetValue('s_name');
	// 	$data['s_type']=$s_type=Comment::SetValue('s_type');

	// 	$dbdata=$this->mmodel->get_member_data('',$s_num,$s_name,$s_type,'','','',$s_account);

	// 	if(!empty($dbdata)){
	// 		//分頁程式 start
	// 		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
	// 		$qpage=$this->useful->SetPage($dbname,'',20,'','',count($dbdata));		
	// 		$data['page']=$this->useful->get_page($qpage);
	// 		//分頁程式 end	
	// 	}
	// 	$dbdata=$this->mmodel->get_member_data('',$s_num,$s_name,$s_type,'','',$qpage['result'],$s_account);

	// 	foreach ($dbdata as $key => $value) {
	// 		$dbdata[$key]['sex']=($value['sex']=='male')?'男':'女';
	// 		if($value['d_is_member']=='0')
	// 			$member_type='一般會員';
	// 		elseif($value['d_is_member']=='1')
	// 			$member_type='經營會員';
	// 		else
	// 			$member_type='待審核會員';

	// 		$dbdata[$key]['d_is_member']=$member_type;

	// 		$dbdata[$key]['ctime']=substr($value['ctime'],0,10);

	// 		//經營狀態 會員期限
	// 		$dbdata[$key]['deadline']='';
	// 		$dbdata[$key]['deadstatus']='';
	// 		if($value['d_is_member']=='1'){
	// 			$deadline=round(($value['deadline'] - time()) / 86400);
	// 			if($deadline<=30){
	// 				$dbdata[$key]['deadline']="<span style='color:RED;'>餘".$deadline."天</span>";
	// 			}else
	// 				$dbdata[$key]['deadline']='餘'.$deadline.'天';
	// 			if($deadline<=0){
	// 				$dbdata[$key]['deadstatus']="無效";
	// 			}else
	// 				$dbdata[$key]['deadstatus']="有效";
	// 		}
	// 		//判斷是否可刪除(經銷會員及有訂單記錄不可刪除)
	// 		$odata=$this->mymodel->select_page_form('`order`','','order_id',array('by_id'=>$value['by_id']));

	// 		if(!empty($odata) or $value['d_is_member']=='1')
	// 			$dbdata[$key]['seldel']='NoDel';
	// 	}
	// 	$data['dbdata']=$dbdata;


	// 	//view
	// 	$this->load->view('member/'.$dbname.'_list', $data);
	// }
	//會員列表
	public function buyer_list()
	{

		//權限判斷
		$this->useful->CheckComp('j_member');

		//資料庫名稱
		$data['dbname'] = $dbname = 'buyer';

		// $data['s_account']=$s_account=Comment::SetValue('s_account');
		// $data['s_num']=$s_num=Comment::SetValue('s_num');
		// $data['s_name']=$s_name=Comment::SetValue('s_name');
		// $data['s_type']=$s_type=Comment::SetValue('s_type');
		$search_default_array = array('s_account', 's_num', 's_name', 's_type', 'Pname', 'upline');
		$this->mymodel->search_session($search_default_array);

		$where_array = array();
		if ($_SESSION["AT"]["where"]['s_account'] != "") {
			$where_array[] = "b.d_account like '%" . $_SESSION["AT"]["where"]['s_account'] . "%'";
		}
		if ($_SESSION["AT"]["where"]['s_num'] != "") {
			$where_array[] = "m.member_num like '%" . $_SESSION["AT"]["where"]['s_num'] . "%'";
		}
		if ($_SESSION["AT"]["where"]['s_name'] != "") {
			$where_array[] = "b.name like '%" . $_SESSION["AT"]["where"]['s_name'] . "%'";
		}
		if ($_SESSION["AT"]["where"]['s_type'] != "") {
			$where_array[] = "b.d_is_member = '" . $_SESSION["AT"]["where"]['s_type'] . "'";
		}
		// if($_SESSION["AT"]["where"]['Pname']!=""){
		//     $where_array[]="b1.name like '%".$_SESSION["AT"]["where"]['Pname']."%'";
		// }
		// if($_SESSION["AT"]["where"]['upline']!=""){
		//     $where_array[]="b2.name like '%".$_SESSION["AT"]["where"]['upline']."%'";
		// }
		$where = !empty($where_array) ? " where " . implode(" and ", $where_array) : "";
		// 分頁程式 start
		$this->load->library('/mylib/PageNew');
		$page = new PageNew();
		$page->SetMySQL($this->db);
		$page->SetPagSize(50);
		$qpage = $page->PageStar('buyer b left join member m on m.by_id=b.by_id left join member m1 on m.by_id=m1.member_id left join buyer b1 on b.PID=b1.by_id left join buyer b2 on m1.by_id=b2.by_id', '', $where);
		$data['page'] = $this->load->view('mypage/page', $qpage, true);
		// print_r($_POST);
		//分頁程式 end
		// $dbdata=$this->mmodel->GetMember($where,$qpage['result']);
		$dbdata = $this->mmodel->GetMember($where, $qpage['result']);
		// $dbdata=$this->mymodel->get_member_data('',$s_num,$s_name,$s_type,'','',$qpage['result'],$s_account);

		foreach ($dbdata as $key => $value) {
			if ($value['d_is_member'] == '0')
				$member_type = '一般會員';
			elseif ($value['d_is_member'] == '1')
				$member_type = '經營會員';
			else
				$member_type = '待審核會員';

			$dbdata[$key]['d_is_member'] = $member_type;

			$dbdata[$key]['ctime'] = substr($value['ctime'], 0, 10);

			//經營狀態 會員期限
			$dbdata[$key]['deadline'] = '';
			$dbdata[$key]['deadstatus'] = '';
			if ($value['d_is_member'] == '1') {
				$dbdata[$key]['seldel'] = 'NoDel';
				$deadline = round(($value['deadline'] - time()) / 86400);
				if ($deadline <= 30) {
					$dbdata[$key]['deadline'] = "<span style='color:RED;'>餘" . $deadline . "天</span>";
				} else
					$dbdata[$key]['deadline'] = '餘' . $deadline . '天';
				if ($deadline <= 0) {
					$dbdata[$key]['deadstatus'] = "無效";
				} else
					$dbdata[$key]['deadstatus'] = "有效";
			}
			//判斷是否可刪除(經銷會員及有訂單記錄不可刪除)
			$odata = $this->mymodel->select_page_form('`order`', '', 'order_id', array('by_id' => $value['by_id']));

			if (!empty($odata) or $value['d_is_member'] == '1')
				$dbdata[$key]['seldel'] = 'NoDel';
		}
		$data['dbdata'] = $dbdata;


		//view
		$this->load->view('member/' . $dbname . '_list', $data);
	}
	//會員內頁
	public function buyer_info($id = '')
	{
		header("Cache-control: private");
		//權限判斷
		$this->useful->CheckComp('j_member');

		$data['dbname'] = $dbname = 'buyer';
		// $dbdata=$this->mmodel->select_from($dbname,array('by_id'=>$id));
		$dbdata = $this->mmodel->get_buyer_info($id);
		$dbdata['by_pw'] = $this->encrypt->decode($dbdata['by_pw']);
		$data['dbdata'] = $dbdata[0];
		switch ($dbdata['is_alipay']) {
			case '0':
				$data['alipay'] = '網站注册';
				break;
			case '1':
				$data['alipay'] = '支付宝注册';
				break;
			case '2':
				$data['alipay'] = '微信注册';
				break;
			case '3':
				$data['alipay'] = '微博注册';
				break;
			default:
				$data['alipay'] = '第三方注册';
				break;
		}
		$data['d_id'] = $id;
		//撈取經營會員資料
		if ($dbdata['d_is_member'] == '1') {
			$mdbdata = $this->mmodel->select_from('member', array('by_id' => $id));
			$data['mdbdata'] = $mdbdata;

			$fdata = $this->mymodel->OneSearchSql('family', 'd_name', array('d_id' => $mdbdata['GID']));
			$data['f_name'] = (!empty($fdata) and $mdbdata['GID'] != 0) ? $fdata['d_name'] : '無體系';
		}
		if ($dbdata['d_is_member'] == '2') {
			$mdbdata = $this->mmodel->select_from('member_apply', array('by_id' => $id));
			$data['mdbdata'] = $mdbdata;
		}

		//抓buyer及member
		$mebdata = $this->mmodel->get_member_data($id, '', '', '', '1');
		$data['mebdata'] = $mebdata;
		$buyerdata = $this->mmodel->get_member_data($id, '', '', '', '1');
		$data['buyerdata'] = $buyerdata;
		$dbdata['country'] = empty($dbdata['country']) ? '0' : $dbdata['country'];
		$dbdata['city']	  = empty($dbdata['city']) ? '0' : $dbdata['city'];
		$data['country_num'] = $this->mymodel->get_country_num();
		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();
		//城市撈取
		// $data['city']	  =	$this->mymodel->get_area_data($dbdata['country']);		
		$data['city']	  =	$this->city();
		$city_category 	  =	$this->mymodel->OneSearchSql('`city_category`', 's_id,s_name', array('s_id' => $dbdata['city']));
		$data['area']	  =	$this->mymodel->get_area_data($city_category['s_id']);
		//特殊身分
		$sdata = $this->mymodel->GetConfig('spectype');
		foreach ($sdata as $key => $value) {
			$spec[$value['d_val']] = $value['d_title'];
		}
		$data['spec'] = $spec;

		// 在哪個APP註冊		
		// $data['Pushdata']=$this->mymodel->WriteSQL('
		// 	select m.member_num,b.name from member m 
		// 	inner join buyer b on b.by_id=m.by_id
		// 	where m.member_id='.$dbdata['PID'].'',1);


		if ($_SESSION['ssoc'] != 1) {
			unset($_SESSION['RT']);
		} else {
			$data['dbdata'] = $_SESSION['RT'];
			$data['mdbdata'] = $_SESSION['RT'];
		}
		unset($_SESSION['ssoc']);

		//返回鍵
		$data['back_url'] = '/member/buyer_list';
		//view
		$this->load->view('member/' . $dbname . '_info', $data);
	}
	//會員增刪修
	public function member_AED($del_id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_member');
		$data = $this->data;


		if ($del_id != '') {

			//判斷是否可刪除(經銷會員及有訂單記錄不可刪除)
			$odata = $this->mymodel->select_page_form('`order`', '', 'order_id', array('by_id' => $del_id));

			if (empty($odata)) {
				$this->mymodel->delete_where('buyer', array('by_id' => $del_id));
				$this->mymodel->delete_where('member', array('by_id' => $del_id));
				$this->mymodel->delete_where('dividend', array('buyer_id' => $del_id));
				$msg = '刪除成功';
			} else
				$msg = '此會員有訂單記錄，故無法刪除';
		} else {
			$by_id = $_POST['d_id'];

			$this->load->library('/mylib/CheckInput');
			$check = new CheckInput;
			$check->fname[] = array('_String', Comment::SetValue('d_account'), '帳號');
			$check->fname[] = array('_String', Comment::SetValue('mobile'), '手機號碼');
			$check->fname[] = array('_String', Comment::SetValue('name'), '姓名');
			$check->fname[] = array('_CheckRadio', Comment::SetValue('sex'), '性別');
			$check->fname[] = array('_String', Comment::SetValue('by_pw'), '密碼');
			//$check->fname[]=array('_String',Comment::SetValue('address'),'地址');
			//$check->fname[]=array('_Select',Comment::SetValue('birthday'),'生日');
			$check->fname[] = array('_String', Comment::SetValue('by_email'), '信箱');
			if ($_POST['d_is_member'] == '1') {
				$check->fname[] = array('_String', Comment::SetValue('identity_num'), '身分證');
				// $check->fname[]=array('_String',Comment::SetValue('cen_address'),'地址');
				$check->fname[] = array('_String', Comment::SetValue('bank_name'), '銀行名稱');
				$check->fname[] = array('_String', Comment::SetValue('bank_account_name'), '銀行帳號');
				$check->fname[] = array('_String', Comment::SetValue('bank_account'), '銀行帳號');
				// $check->fname[]=array('_String',Comment::SetValue('join_time'),'入會日');
			}
			if (!empty($check->main())) {
				//記錄密碼
				$_SESSION['RT'] = $_POST;
				$_SESSION['ssoc'] = 1;
				echo $check->main();
				return '';
			}
			$buy_data = array(
				'd_account' => Comment::SetValue('d_account'),
				'mobile' => Comment::SetValue('mobile'),
				'name' => Comment::SetValue('name'),
				'sex' => Comment::SetValue('sex'),
				'telphone' => Comment::SetValue('telphone'),
				'by_pw' => $this->encrypt->encode(Comment::SetValue('by_pw')),
				'country' => Comment::SetValue('country'),
				'city' => Comment::SetValue('city'),
				'countory' => Comment::SetValue('countory'),
				'address' => Comment::SetValue('address'),
				'birthday' => Comment::SetValue('birthday'),
				'd_spec_type' => Comment::SetValue('d_spec_type'),
				'by_email' => Comment::SetValue('by_email'),
				'd_is_member' => Comment::SetValue('d_is_member'),
				'd_content' => Comment::SetValue('d_content'),
				'PID' => Comment::SetValue('PID'),
				'update_time' => $this->useful->get_now_time(),
			);

			if ($by_id) {

				//語言包
				$this->lang1 = $this->lmodel->config('3', $this->setlang);

				if (Comment::SetValue('mobile') != '') {
					if ((strlen(Comment::SetValue('mobile')) < 8 or strlen(Comment::SetValue('mobile')) > 11)) {
						$this->useful->AlertPage('', $this->lang1['ten_or_elevenphone']/*手機號碼需要10碼(台灣)或11碼(中國)?*/);
						return '';
					}
				}

				$mobile_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('mobile' => Comment::SetValue('mobile')));
				if (!empty($mobile_data) and $mobile_data['0']['by_id'] <> $by_id) {
					$this->useful->AlertPage('', $this->lang1['somephone']/*此手機已註冊過，請重新輸入?*/);
					return '';
				}

				// 更改註冊APP寫入LOG
				$buyerdata = $this->mymodel->OneSearchSql('buyer', 'PID', array('by_id' => $by_id));

				if ($buyerdata['PID'] != Comment::SetValue('PID') && $buyerdata['PID'] && Comment::SetValue('PID')) {
					$pdata = $this->mymodel->WriteSQL("
						SELECT REPLACE(group_concat(" . ($buyerdata['PID'] ? "if(m.member_id=" . $buyerdata['PID'] . ",m.member_num,'')" : '') . "),',','') as oldid,
						REPLACE(group_concat(if(m.member_id=" . Comment::SetValue('PID') . ",m.member_num,'')),',','') as newid FROM member m
						where m.member_id in (" . ($buyerdata['PID'] ? $buyerdata['PID'] : '') . Comment::SetValue('PID') . ")", '1');

					$content = '管理員' . $_SESSION['AT']['account_name'] . '-更改' . Comment::SetValue('d_account') . '的註冊APP(' . ((empty($pdata['oldid'])) ? '無註冊APP會員' : $pdata['oldid']) . '->' . ((empty($pdata['newid'])) ? '無註冊APP會員' : $pdata['newid']) . ')';
					$this->mymodel->WriteLog('4', $content);
				}
				$this->mmodel->update_set('buyer', 'by_id', $by_id, $buy_data);


				if ($_POST['d_is_member'] == '1' or $_POST['d_is_member'] == '2') {
					// // 更改上線寫入LOG
					$Memberdata = $this->mymodel->OneSearchSql('member', 'upline,member_num', array('by_id' => $by_id));

					if ($Memberdata['upline'] != Comment::SetValue('upline') && $Memberdata['upline'] && Comment::SetValue('upline')) {
						$Memberdata['upline'] = empty($Memberdata['upline']) ? 0 : $Memberdata['upline']; //20170619加入會有錯誤增加檢查
						$pdata = $this->mymodel->WriteSQL("
						SELECT REPLACE(group_concat(if(m.member_id=" . $Memberdata['upline'] . ",m.member_num,'')),',','') as oldid,
						REPLACE(group_concat(if(m.member_id=" . Comment::SetValue('upline') . ",m.member_num,'')),',','') as newid FROM member m
						where m.member_id in (" . $Memberdata['upline'] ? $Memberdata['upline'] . ',' : '' . Comment::SetValue('upline') . ")", '1');

						$content = '管理員' . $_SESSION['AT']['account_name'] . '-更改' . $Memberdata['member_num'] . '的上線(' . ((empty($pdata['oldid'])) ? '無上線會員' : $pdata['oldid']) . '->' . ((empty($pdata['newid'])) ? '無上線會員' : $pdata['newid']) . ')';

						$this->mymodel->WriteLog('1', $content);
					}

					$member_data = array(
						'account' => Comment::SetValue('d_account'),
						'password' => $this->encrypt->encode(Comment::SetValue('by_pw')),
						'email' => Comment::SetValue('by_email'),
						'identity_num' => Comment::SetValue('identity_num'),
						'country' => Comment::SetValue('cen_country'),
						'city' => Comment::SetValue('cen_city'),
						'countory' => Comment::SetValue('cen_countory'),
						'address' => Comment::SetValue('cen_address'),
						'bank_name' => Comment::SetValue('bank_name'),
						'bank_account_name' => Comment::SetValue('bank_account_name'),
						'bank_account' => Comment::SetValue('bank_account'),
						'wowpay_email' => Comment::SetValue('wowpay_email'),
						'wowpay_country_num' => Comment::SetValue('wowpay_country_num'),
						'wowpay_mobile' => Comment::SetValue('wowpay_mobile'),
						'wowpay_cardAsn' => Comment::SetValue('wowpay_cardAsn'),
						'wowpay_pay_password' => Comment::SetValue('wowpay_pay_password'),
						'wowpay_login_password' => Comment::SetValue('wowpay_login_password'),
						'wowpay_signature' => Comment::SetValue('wowpay_signature'),
						'upline' => Comment::SetValue('upline'),
						'join_time' => Comment::SetValue('join_time'),
						// 'deadline'=>strtotime(date('Y-m-d', strtotime(''.Comment::SetValue("join_time").' +1 years'))),
						'update_time' => $this->useful->get_now_time(),
						'is_shop' => Comment::SetValue('is_shop'),
						'shop_country' => Comment::SetValue('shop_country'),
						'shop_city' => Comment::SetValue('shop_city'),
						'shop_countory' => Comment::SetValue('shop_countory'),
						'shop_address' => Comment::SetValue('shop_address'),
					);
					$is_member_data = $this->mmodel->get_member_sign('', '', '', Comment::SetValue('d_account'));

					if (!empty($is_member_data)) {
						//取得新ID並重新寫入資料庫
						if (Comment::SetValue('upline') != 0) {
							$udata = $this->mymodel->OneSearchSql('member', 'GID,d_keys', array('member_id' => Comment::SetValue('upline')));
							$d_keys = $udata['d_keys'] . ',' . Comment::SetValue('upline');
							$GID = $udata['GID'];
						} else {
							$d_keys = Comment::SetValue('upline');
							$GID = '';
						}

						$member_data['d_keys'] = $d_keys;

						//判斷原本有無deadline,若有deadline,就不能變更
						$member = $this->mymodel->OneSearchSql('member', 'deadline,by_id', array('by_id' => $by_id));
						if (empty($member['deadline'])) {
							$member_data['deadline'] = strtotime(date('Y-m-d', strtotime('' . Comment::SetValue("join_time") . ' +19 years')));
						}

						$this->mmodel->update_set('member', 'by_id', $by_id, $member_data);
					} else {
						$member_data = array(
							'by_id' => $by_id,
							'domain_id' => '1',
							'account' => Comment::SetValue('d_account'),
							'password' => $this->encrypt->encode(Comment::SetValue('by_pw')),
							'email' => Comment::SetValue('by_email'),
							'identity_num' => Comment::SetValue('identity_num'),
							'country' => Comment::SetValue('cen_country'),
							'city' => Comment::SetValue('cen_city'),
							'countory' => Comment::SetValue('cen_countory'),
							'address' => Comment::SetValue('cen_address'),
							'bank_name' => Comment::SetValue('bank_name'),
							'bank_account_name' => Comment::SetValue('bank_account_name'),
							'bank_account' => Comment::SetValue('bank_account'),
							'wowpay_email' => Comment::SetValue('wowpay_email'),
							'wowpay_country_num' => Comment::SetValue('wowpay_country_num'),
							'wowpay_mobile' => Comment::SetValue('wowpay_mobile'),
							'wowpay_cardAsn' => Comment::SetValue('wowpay_cardAsn'),
							'wowpay_pay_password' => Comment::SetValue('wowpay_pay_password'),
							'wowpay_login_password' => Comment::SetValue('wowpay_login_password'),
							'wowpay_signature' => Comment::SetValue('wowpay_signature'),
							'upline' => Comment::SetValue('upline'),
							'auth' => '02',
							'addtime' => time(),
							'join_time' => Comment::SetValue('join_time'),
							'deadline' => strtotime(date('Y-m-d', strtotime('' . Comment::SetValue("join_time") . ' +19 years'))),
							'create_time' => $this->useful->get_now_time(),
							'update_time' => $this->useful->get_now_time(),
						);

						$member_id = $this->mmodel->insert_into('member', $member_data);

						//取得新ID並重新寫入資料庫
						if (Comment::SetValue('upline') != 0) {
							$udata = $this->mymodel->OneSearchSql('member', 'GID,d_keys', array('member_id' => Comment::SetValue('upline')));
							$d_keys = $udata['d_keys'] . ',' . Comment::SetValue('upline');
							$GID = $udata['GID'];
						} else {
							$d_keys = Comment::SetValue('upline');
							$GID = '';
						}
						$imgurl = $this->imodel->create_dir($member_id);

						$mdata = array(
							'GID' => $GID,
							'member_num' => 'A' . str_pad($member_id, 8, '0', STR_PAD_LEFT),
							'd_keys' => $d_keys,
							'img_url' => $imgurl
						);

						$this->mmodel->update_set('member', 'member_id', $member_id, $mdata);
						//取得新ID並重新寫入資料庫

						$this->mod_index->create_qrcode_style($member_id, 0); //iqr
						$this->mod_index->create_qrcode_style($member_id, 1); //mecard
						$this->mod_index->create_qrcode_style($member_id, 2); //iqr app

						$domin0 = $this->mmodel->select_from('domain', array('domain_id' => $data['domain_id']));
						$shelf_info = array(
							'member_id' 	=> $member_id,
							'shelf_HD_url'  => 'images/web_style_images/' . $domin0['domain'] . '/app_welcome_page/icon.png',
							'type'			=> 0
						);
						$shelf_id = $this->mmodel->insert_into('application_shelves', $shelf_info);

						//行動名片欄位
						$iqr_info = array(
							'f_name'			 => Comment::SetValue('name'),
							'email'			 	 => Comment::SetValue('by_email'),
							'mobile'			 => Comment::SetValue('mobile'),
							'member_id'			 => $member_id,
							'banner_status'		 => 0,
							'banner_status_name' => '',
							// 'theme_id'			 => 1,
							'theme_bg_type'		 => 0,
							'cart_id'			 => 1
						);
						$iqr_id = $this->mmodel->insert_into('iqr', $iqr_info);

						//刪除申請經營會員資料
						$this->mymodel->delete_where('member_apply', array('by_id' => $by_id));
					}
				}

				$msg = '修改成功';
			} else {
				$buy_data['create_time'] = $this->useful->get_now_time();
				$bdata = $this->mymodel->OneSearchSql('buyer', 'd_account', array('d_account' => Comment::SetValue('d_account')));
				if (!empty($bdata)) {
					echo $this->useful->AlertPage('', 'buyer已有相同帳號，請重新輸入');
					return '';
				}
				$member_account = $this->mymodel->OneSearchSql('member', 'account', array('account' => Comment::SetValue('d_account')));
				if (!empty($member_account)) {
					echo $this->useful->AlertPage('', 'member已有相同帳號，請重新輸入');
					return '';
				}
				$mobile_data = $this->mymodel->select_page_form('buyer', '', 'by_id', array('mobile' => Comment::SetValue('mobile')));
				if (!empty($mobile_data) and $mobile_data['0']['by_id'] <> $by_id) {
					$this->useful->AlertPage('', '此手機已註冊過，請重新輸入');
					return '';
				}

				$create_id = $this->mmodel->insert_into('buyer', $buy_data);

				$content = '管理員' . $_SESSION['AT']['account_name'] . '-新增此' . Comment::SetValue('d_account') . '的資料';
				$this->mymodel->WriteLog('3', $content);

				//新增會員免驗證兼發送紅利
				$this->mymodel->update_set('buyer', 'by_id', $create_id, array('is_verify' => 'Y', 'verify_time' => $this->useful->get_now_time()));
				$set = $this->mymodel->GetConfig('', '60');
				$ddata = array(
					'buyer_id' => $create_id,
					'd_type' => '18',
					'd_val' => $set['d_val'],
					'd_des' => '註冊驗證成功發送紅利',
					'is_send' => 'Y',
					'create_time' => $this->useful->get_now_time(),
					'update_time' => $this->useful->get_now_time(),
					'is_del' => 'N'
				);
				$this->mymodel->insert_into('dividend', $ddata);
				$this->mymodel->update_set('buyer', 'by_id', $create_id, array('d_dividend' => $set['d_val']));
				//新增會員免驗證兼發送紅利

				if (Comment::SetValue('d_is_member') == '1') {
					$member_data = array(
						'by_id' => $create_id,
						'domain_id' => '1',
						'account' => Comment::SetValue('d_account'),
						'password' => $this->encrypt->encode(Comment::SetValue('by_pw')),
						'email' => Comment::SetValue('by_email'),
						'identity_num' => Comment::SetValue('identity_num'),
						'country' => Comment::SetValue('cen_country'),
						'city' => Comment::SetValue('cen_city'),
						'countory' => Comment::SetValue('cen_countory'),
						'address' => Comment::SetValue('cen_address'),
						'bank_name' => Comment::SetValue('bank_name'),
						'bank_account_name' => Comment::SetValue('bank_account_name'),
						'bank_account' => Comment::SetValue('bank_account'),
						'wowpay_email' => Comment::SetValue('wowpay_email'),
						'wowpay_country_num' => Comment::SetValue('wowpay_country_num'),
						'wowpay_mobile' => Comment::SetValue('wowpay_mobile'),
						'wowpay_cardAsn' => Comment::SetValue('wowpay_cardAsn'),
						'wowpay_pay_password' => Comment::SetValue('wowpay_pay_password'),
						'wowpay_login_password' => Comment::SetValue('wowpay_login_password'),
						'wowpay_signature' => Comment::SetValue('wowpay_signature'),
						'upline' => Comment::SetValue('upline'),
						'auth' => '02',
						'addtime' => time(),
						'join_time' => Comment::SetValue('join_time'),
						'deadline' => strtotime(date('Y-m-d', strtotime('' . Comment::SetValue("join_time") . ' +19 years'))),
						'create_time' => $this->useful->get_now_time(),
						'update_time' => $this->useful->get_now_time(),
					);
					$member_id = $this->mmodel->insert_into('member', $member_data);

					//取得新ID並重新寫入資料庫
					if (Comment::SetValue('upline') != 0) {
						$udata = $this->mymodel->OneSearchSql('member', 'GID,d_keys', array('member_id' => Comment::SetValue('upline')));
						$d_keys = $udata['d_keys'] . ',' . Comment::SetValue('upline');
						$GID = $udata['GID'];
					} else {
						$d_keys = Comment::SetValue('upline');
						$GID = '';
					}
					$imgurl = $this->imodel->create_dir($member_id);
					$mdata = array(
						'GID' => $GID,
						'member_num' => 'A' . str_pad($member_id, 8, '0', STR_PAD_LEFT),
						'd_keys' => $d_keys,
						'img_url' => $imgurl
					);

					$this->mmodel->update_set('member', 'member_id', $member_id, $mdata);
					//取得新ID並重新寫入資料庫

					$this->mod_index->create_qrcode_style($member_id, 0); //iqr
					$this->mod_index->create_qrcode_style($member_id, 1); //mecard
					$this->mod_index->create_qrcode_style($member_id, 2); //iqr app

					$domin0 = $this->mmodel->select_from('domain', array('domain_id' => $data['domain_id']));
					$shelf_info = array(
						'member_id' 	=> $member_id,
						'shelf_HD_url'  => 'images/web_style_images/' . $domin0['domain'] . '/app_welcome_page/icon.png',
						'type'			=> 0
					);
					$shelf_id = $this->mmodel->insert_into('application_shelves', $shelf_info);

					//行動名片欄位
					$iqr_info = array(
						'f_name'			 => Comment::SetValue('name'),
						'email'			 	 => Comment::SetValue('by_email'),
						'mobile'			 => Comment::SetValue('mobile'),
						'member_id'			 => $member_id,
						'banner_status'		 => 0,
						'banner_status_name' => '',
						// 'theme_id'			 => 10,
						'theme_bg_type'		 => 0,
						'cart_id'			 => 1
					);
					$iqr_id = $this->mmodel->insert_into('iqr', $iqr_info);
				}

				if ($create_id)
					$msg = '新增成功';
				else
					$msg = '新增失敗';
			}
		}
		echo '<script>alert("' . $msg . '");window.location.href="/member/buyer_list";</script>';
	}

	//會員匯出
	public function dl_member()
	{
		//權限判斷
		$this->useful->CheckComp('j_member');

		// $title_array=array('編號','帳號','姓名','性別','手機','電話','通訊地址','生日','信箱','備註','身分','身份證','戶籍地址','銀行名稱','銀行帳號','入會日','到期日','體系名稱','上線會員','經營狀態','註冊時間');
		$title_array = array('帳號', '姓名', '手機', '生日', 'E-mail', '身分證字號', '銀行名稱', '分行銀行', '帳戶名稱', '銀行帳號', '有無稅卡', '稅卡編號', '註冊日期', '是否接收優惠訊息', '最新一次登入日期');

		$dbdata = $this->mymodel->select_page_form('buyer', '', '*');


		foreach ($dbdata as $value) {
			$deadstatus = '';
			if ($value['d_is_member'] == 1) {
				$mdata = $this->mymodel->OneSearchSql('member', '*', array('by_id' => $value['by_id']));

				//經營狀態
				$deadline = round(($mdata['deadline'] - time()) / 86400);
				if ($deadline <= 0) {
					$deadstatus = "無效";
				} else
					$deadstatus = "有效";

				// 有無稅卡
				$tax_card_no_exist = $mdata['tax_card_no'] ? '有' : '無';

				// 最後登入日期
				$last_login_date = $mdata['last_login'] ? date('Y-m-d', $mdata['last_login']) : '-';
			}
			//身分
			$mtype = $this->mymodel->OneSearchSql('config', 'd_title', array('d_type' => 'bytype', 'd_val' => $value['d_is_member']));
			$type = $mtype['d_title'];
			//性別
			$sex = ($value['sex'] == 'female') ? '女' : '男';
			//密碼
			$password = $this->encrypt->decode($value['by_pw']);
			//通訊地址
			$country = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $value['country']));
			$city = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $value['city']));
			$countory = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $value['countory']));
			$address = $city['s_name'] . $countory['s_name'] . $value['address'];

			//戶籍地址
			$rcountry = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $mdata['country']));
			$rcity = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $mdata['city']));
			$rcountory = $this->mymodel->OneSearchSql('city_category', 's_name', array('s_id' => $mdata['countory']));
			$raddress = $rcity['s_name'] . $rcountory['s_name'] . $value['address'];

			//體系名稱
			$family = $this->mymodel->OneSearchSql('family', 'd_name', array('d_id' => $mdata['GID']));

			//上線會員
			$udata = $this->mymodel->OneSearchSql('member', 'by_id', array('member_id' => $mdata['upline']));
			$upline = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $udata['by_id']));


			$data_array[] = array(
				$value['d_account'], $value['name'], $value['mobile'], $value['birthday'], $value['by_email'],
				$mdata['identity_num'], $mdata['bank_name'], $mdata['bank_branch_name'], $mdata['bank_account_name'],
				$mdata['bank_account'], $tax_card_no_exist, $mdata['tax_card_no'], $value['create_time'], $value['d_service'],
				$last_login_date
				// $mdata['member_num'],$value['d_account'],
				// $value['name'],$sex,$value['mobile'],$value['telphone'],
				// $address,$value['birthday'],$value['by_email'],
				// $value['d_content'],$type,$mdata['identity_num'],
				// $raddress,$mdata['bank_name'],$mdata['bank_account_name'],$mdata['bank_account'],
				// $mdata['join_time'],
				// date('Y-m-d H:i:s',$mdata['deadline']),
				// $family['d_name'],$upline['name'],
				// $deadstatus,$value['create_time']
			);
		}
		$this->export_xls($title_array, $data_array, date('Y-m-d') . '會員資料');
	}

	//組織表
	public function organ_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_organ');

		//資料庫名稱
		$data['dbname'] = $dbname = 'member';

		// 	//分頁程式 start
		// $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		// $qpage=$this->useful->SetPage($dbname,'',20);		
		// $data['page']=$this->useful->get_page($qpage);
		// //分頁程式 end
		if ($_POST['s_account']) {
			// $data['s_num']=$s_num=$_POST['s_num'];
			$data['s_account'] = $s_account = $_POST['s_account'];

			// if($s_num!='' and $s_account!=''){
			// 	$mdata=$this->mymodel->OneSearchSql('member','d_keys,member_id',array('member_num'=>$s_num,'account'=>$s_account));
			// }elseif($s_account!=''){
			// 	$mdata=$this->mymodel->OneSearchSql('member','d_keys,member_id',array('account'=>$s_account));
			// }else{
			// 	$mdata=$this->mymodel->OneSearchSql('member','d_keys,member_id',array('member_num'=>$s_num));
			// }

			if ($s_account != '') {
				$mdata = $this->mymodel->OneSearchSql('member', 'd_keys,member_id', array('account' => $s_account));
			}
			
			$dbdata = $this->mmodel->get_member_family($mdata['member_id']);
			$upkey = explode(',', $mdata['d_keys']);

			array_shift($upkey);
			foreach ($upkey as $key => $value) {
				if ($value != $mdata['member_id']) {
					$sign = $this->mmodel->get_member_sign($value);
					$line[$key]['name'] = $sign['name'];
					$line[$key]['member_num'] = $sign['member_num'];
				}
			}
			
			$data['line'] = $line;
		} else {
			$dbdata = $this->mymodel->select_page_form('member', '', '*', array('auth' => '02'));
		}

		foreach ($dbdata as $key => $value) {
			$sname = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $value['by_id']));
			$value['name'] = $sname['name'];

			$pname = $this->mmodel->get_member_sign($value['upline']);
			$recommendPerson = $this->mmodel->getRecommendPerson($pname['PID']);

			$index = $this->mmodel->find($value['by_id']);

			$value['pname'] = $recommendPerson['name'];
			$value['d_is_member'] = $index['d_is_member'];

			$gname = $this->mmodel->select_from('family', array('d_id' => $value['GID']));
			$value['GID'] = $gname['d_name'];

			if ($value['is_family_boss'] == 'Y') {
				$value['imasrc'] = '/images/icon_accept.png';
			} else {
				$value['imasrc'] = '/images/icon_na_t.png';
			}

			$value['create_time'] = substr($value['create_time'], 0, 10);
			// print_r($value);	
			$key = explode(',', $value['d_keys']);
			array_shift($key);
			if ($value['d_is_member'] != 0) {
				$level[count($key)][] = $value;
			}
		}

		if (!empty($level))
			ksort($level);



		$data['dbdata'] = $level;

		//view
		$this->load->view('member/organ_list', $data);
	}

	//組織表匯出
	public function dl_org()
	{
		//權限判斷
		$this->useful->CheckComp('j_member');

		$title_array = array('會員帳號','會員姓名','入會日');

		if ($_POST['s_account']) {
			$s_account = $_POST['s_account'];

			if ($s_account != '') {
				$mdata = $this->mymodel->OneSearchSql('member', 'd_keys,member_id', array('account' => $s_account));
			}
			
			$result_data = $this->mmodel->get_member_family($mdata['member_id']);

		} else {
			$result_data = $this->mymodel->select_page_form('member', '', '*', array('auth' => '02'));
		}


		foreach ($result_data as $key => $value) {
			$sname = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $value['by_id']));
			$value['name'] = $sname['name'];

			$pname = $this->mmodel->get_member_sign($value['upline']);
			$recommendPerson = $this->mmodel->getRecommendPerson($pname['PID']);

			$index = $this->mmodel->find($value['by_id']);

			$value['pname'] = $recommendPerson['name'];
			$value['d_is_member'] = $index['d_is_member'];

			$gname = $this->mmodel->select_from('family', array('d_id' => $value['GID']));
			$value['GID'] = $gname['d_name'];

			if ($value['is_family_boss'] == 'Y') {
				$value['imasrc'] = '/images/icon_accept.png';
			} else {
				$value['imasrc'] = '/images/icon_na_t.png';
			}

			$value['create_time'] = substr($value['create_time'], 0, 10);
			// print_r($value);	
			$key = explode(',', $value['d_keys']);
			array_shift($key);
			if ($value['d_is_member'] != 0) {
				$level[count($key)][] = $value;
			}
		}

		foreach ($level as $key => $value) {
			
			$data_array[] = array(
				'', 
				'', 
				''
			);
			
			$data_array[] = array(
				'第 '.$key.' 層', 
				'', 
				''
			);

			foreach ($value as $avalue) {
				$data_array[] = array(
					$avalue['account'], 
					$avalue['d_name'], 
					$avalue['join_time']
				);
			}
			
		}

		$this->export_xls($title_array, $data_array, date('Y-m-d') . '組織表');
	}



	//經營權轉讓
	public function transfer_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_transfer');

		//資料庫名稱
		$data['dbname'] = $dbname = 'buyer b left join member m on b.by_id=m.by_id';

		$data['s_num'] = $s_num = Comment::SetValue('s_num');
		$data['s_name'] = $s_name = Comment::SetValue('s_name');
		$data['s_acc'] = $s_acc = Comment::SetValue('s_acc');


		if ($s_num == '' and $s_name == '' and $s_acc == '') {
			//分頁程式 start
			$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
			$qpage = $this->useful->SetPage($dbname, '', 20, array('d_is_member' => '1'));
			$data['page'] = $this->useful->get_page($qpage);
			//分頁程式 end	
		}

		$dbdata = $this->mmodel->get_member_data('', $s_num, $s_name, '', '1', '', $qpage['result'], $s_acc);

		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['sex'] = ($value['sex'] == 'male') ? '男' : '女';
			if ($value['d_is_member'] == '0')
				$member_type = '一般會員';
			elseif ($value['d_is_member'] == '1')
				$member_type = '經營會員';
			else
				$member_type = '待審核會員';

			$dbdata[$key]['d_is_member'] = $member_type;

			//轉讓記錄
			$tdata = $this->mymodel->OneSearchSql('transfer', 'SUBSTRING(d_tran_time,1,10) as tran_time', array('d_member_id' => $value['member_id']));
			if (!empty($tdata)) {
				$dbdata[$key]['d_tran_time'] = $tdata['tran_time'];
			}
		}

		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('member/transfer_list', $data);
	}
	//經營權轉讓內頁
	public function transfer_info($id = '')
	{

		//權限判斷
		$this->useful->CheckComp('j_transfer');
		$data['dbname'] = $dbname = 'transfer';
		//地區撈取
		$data['country'] = $this->mymodel->get_area_data();

		$data['member_id'] = $id;

		$data['dbdata'] = $dbdata = $this->mmodel->get_member_sign($id);

		$data['by_id'] = $dbdata['by_id'];


		//轉讓記錄
		$data['tdata'] = $this->mymodel->select_page_form('transfer', '', 'SUBSTRING(d_tran_time,1,10) as tran_time,d_name,d_admin_account', array('d_member_id' => $id), 'd_tran_time', 'desc');

		//view
		$this->load->view('member/transfer_info', $data);
	}

	//經營權新增並修改原檔案
	public function add_transfer()
	{
		//權限判斷
		$this->useful->CheckComp('j_transfer');

		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;
		$check->fname[] = array('_String', Comment::SetValue('account'), '帳號');
		$check->fname[] = array('_String', Comment::SetValue('mobile'), '手機號碼');
		$check->fname[] = array('_String', Comment::SetValue('name'), '姓名');
		$check->fname[] = array('_CheckRadio', Comment::SetValue('sex'), '性別');
		$check->fname[] = array('_String', Comment::SetValue('telphone'), '聯絡電話');
		$check->fname[] = array('_String', Comment::SetValue('password'), '密碼');
		$check->fname[] = array('_String', Comment::SetValue('address'), '地址');
		$check->fname[] = array('_String', Comment::SetValue('birthday'), '生日');
		$check->fname[] = array('_String', Comment::SetValue('by_email'), '信箱');
		$check->fname[] = array('_String', Comment::SetValue('identity_num'), '身分證');
		$check->fname[] = array('_String', Comment::SetValue('cen_address'), '地址');
		$check->fname[] = array('_String', Comment::SetValue('bank_name'), '銀行名稱');
		$check->fname[] = array('_String', Comment::SetValue('bank_account_name'), '帳戶名稱');
		$check->fname[] = array('_String', Comment::SetValue('bank_account'), '銀行帳號');


		if (!empty($check->main())) {
			echo $check->main();
			return '';
		}

		$cdata = $this->mymodel->OneSearchSql('buyer', 'by_id', array('d_account' => Comment::SetValue('account')));
		if (!empty($cdata)) {
			$this->useful->AlertPage('', '帳號重複');
			return '';
		}

		$data = $this->useful->DB_Array($_POST);

		$member_id = $_POST['member_id'];
		$dbdata = $this->mmodel->get_member_sign($member_id);

		$transfer_data = array(
			'd_member_id' => $dbdata['member_id'],
			'd_admin_account' => $_SESSION['AT']['account_name'],
			'd_member_num' => $dbdata['member_num'],
			'd_account' => $dbdata['account'],
			'd_name' => $dbdata['name'],
			'd_sex' => $dbdata['sex'],
			'd_telphone' => $dbdata['phone'],
			'd_mobile' => $dbdata['mobile'],
			'd_country' => $dbdata['country'],
			'd_city' => $dbdata['city'],
			'd_countory' => $dbdata['countory'],
			'd_address' => $dbdata['address'],
			'd_brithday' => $dbdata['birthday'],
			'd_email' => $dbdata['email'],
			'd_id_num' => $dbdata['identity_num'],
			'd_cen_country' => $dbdata['mcountry'],
			'd_cen_city' => $dbdata['mcity'],
			'd_cen_countory' => $dbdata['mcountory'],
			'd_cen_address' => $dbdata['maddress'],
			'd_bank_name' => $dbdata['bank_name'],
			'd_bank_account_name' => $dbdata['bank_account_name'],
			'd_bank_account' => $dbdata['bank_account'],
			'd_tran_time' => $this->useful->get_now_time(),
		);

		$this->mmodel->insert_into('transfer', $transfer_data);

		$buy_data = array(
			'mobile' => $data['mobile'],
			'name' => $data['name'],
			'sex' => $data['sex'],
			'country' => $data['country'],
			'city' => $data['city'],
			'countory' => $data['countory'],
			'address' => $data['address'],
			'birthday' => $data['birthday'],
			'update_time' => $this->useful->get_now_time()
		);
		$this->mmodel->update_set('buyer', 'by_id', $data['by_id'], $buy_data);
		$member_data = array(
			'account' => $data['account'],
			'password' => $this->encrypt->encode($data['password']),
			'email' => $data['by_email'],
			'phone' => $data['mobile'],
			'city' => $data['cen_city'],
			'countory' => $data['cen_countory'],
			'address' => $data['cen_address'],
			'birthday' => $data['birthday'],
			'bank_name' => $data['bank_name'],
			'bank_account_name' => $data['bank_account_name'],
			'bank_account' => $data['bank_account'],
			'identity_num' => $data['identity_num'],
			'update_time' => $this->useful->get_now_time()
		);
		$this->mmodel->update_set('member', 'member_id', $data['member_id'], $member_data);
		echo '<script>alert("轉讓成功");window.location.href="/member/transfer_list";</script>';
	}

	//權限管理-角色列表 20171229 新增權限
	public function jurisdicer_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_jur');

		//資料庫名稱
		$data['dbname'] = $dbname = 'jurisdicer';


		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;

		if ($_SESSION['AT']['account_name'] == 'super') {
			$qpage = $this->useful->SetPage($dbname, '', 20);
		} else {
			$qpage = $this->useful->SetPage($dbname, '', 20, array('is_super' => 'N'));
		}

		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end	

		if ($_SESSION['AT']['account_name'] == 'super') {
			$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result']);
		} else {
			$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', array('is_super' => 'N'));
		}

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('member/' . $dbname . '_list', $data);
	}
	//權限管理-角色列表 20171229 新增權限
	public function jurisdicer_info($id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_jur');

		//資料庫名稱
		$data['dbname'] = $dbname = 'jurisdicer';

		if ($_SESSION['AT']['account_name'] == 'super') {
			$dbdata = $this->mmodel->select_from($dbname, array('d_id' => $id));
		} else {
			$dbdata = $this->mmodel->select_from($dbname, array('d_id' => $id, 'is_super' => 'N'));
		}

		/*
		if(empty($dbdata['d_id'])){//防呆,若沒有此筆資料
			$this->useful->AlertPage('/admin/panel');
		}*/

		$data['dbdata'] = $dbdata;
		//權限撈取
		$data['jur'] = $this->useful->set_jur('1');
		//view
		$this->load->view('member/' . $dbname . '_info', $data);
	}

	//權限管理-用戶列表
	public function member_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_user');

		//資料庫名稱
		$data['dbname'] = $dbname = 'member';

		//搜索
		$search_default_array = array('d_is_open', 'd_action');
		$this->mymodel->search_session($search_default_array);

		$where = array(
			'auth' => '00',
			'd_is_open' => $_SESSION['AT']['where']['d_is_open'],
			'd_action' => $_SESSION['AT']['where']['d_action']
		);

		if ($_SESSION['AT']['account_name'] != 'super')
			$where['is_super'] = 'N';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, $where);
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end	
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', $where);


		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['d_is_open'] = ($value['d_is_open'] == 'Y') ? '開啟' : '關閉';
			$d_action = $this->mmodel->select_from('jurisdicer', array('d_id' => $value['d_action']));
			$dbdata[$key]['d_action'] = $d_action['d_name'];
		}
		$data['dbdata'] = $dbdata;
		//所有權限等級
		$data['jurisdicer'] = $this->mmodel->select_from('jurisdicer');


		//view
		$this->load->view('member/' . $dbname . '_list', $data);
	}
	//權限管理-用戶詳細頁
	public function member_info($id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_user');

		//資料庫名稱
		$data['dbname'] = $dbname = 'member';

		if ($id != '')
			$data['title'] = '會員資料';
		else
			$data['title'] = '新增用戶資料';




		if ($_SESSION['AT']['account_name'] == 'super') {
			$dbdata = $this->mmodel->select_from($dbname, array('member_id' => $id));
		} else {
			$dbdata = $this->mmodel->select_from($dbname, array('member_id' => $id, 'is_super' => 'N'));
		}

		if (empty($dbdata['member_id'])) { //防呆,若沒有此筆資料
			//$this->useful->AlertPage('/admin/panel');
		}

		//$dbdata=$this->mmodel->select_from($dbname,array('member_id'=>$id));
		$dbdata['password'] = $this->encrypt->decode($dbdata['password']);
		$data['dbdata'] = $dbdata;
		//權限撈取
		$data['jurisdicer'] = $this->mmodel->select_from('jurisdicer');
		if ($_SESSION['AT']['account_id'] == 2) { //刪除super權限
			unset($data['jurisdicer'][0]);
		}
		if ($_SESSION['AT']['account_id'] > 2) { //刪除super.admin權限
			unset($data['jurisdicer'][0]);
			unset($data['jurisdicer'][1]);
		}
		//view
		$this->load->view('member/' . $dbname . '_info', $data);
	}
	//用戶增刪修
	public function user_AED($del_id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_user');

		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;

		if ($del_id != '') {

			$this->mmodel->delete_where('member', array('member_id' => $del_id));
			$msg = '刪除成功';
		} else {
			$id = $_POST['d_id'];
			$dbname = $_POST['dbname'];

			if ($id) {
				$data = $this->useful->DB_Array($_POST);
			} else {
				$data = $this->useful->DB_Array($_POST, 1);
			}




			$check->fname[] = array('_String', Comment::SetValue('account'), '帳號');
			$check->fname[] = array('_CheckEmail', Comment::SetValue('email'), '電子信箱');
			$check->fname[] = array('_String', Comment::SetValue('password'), '登入密碼');
			$check->fname[] = array('_String', Comment::SetValue('d_name'), '姓名');

			$data['password'] = $this->encrypt->encode(Comment::SetValue('password'));
			$data['domain_id'] = 0;
			$data['auth'] = '00';
			$data['addtime'] = time();
			$data['deadline'] = strtotime(date('Y-m-d', strtotime('+19 years')));


			if (!empty($check->main())) {
				echo $check->main();
				return '';
			}


			unset($data['dbname']);
			unset($data['d_id']);

			if ($id != '') {
				$this->mmodel->update_set($dbname, 'member_id', $id, $data);
				$msg = '修改成功';
			} else {
				$chkdata_buyer = $this->mmodel->select_from('buyer', array('d_account' => Comment::SetValue('account')));
				if (!empty($chkdata_buyer)) {
					$this->useful->AlertPage('', 'buyer已有相同帳號，請重新輸入');
					return '';
				}
				$chkdata = $this->mmodel->select_from('member', array('account' => Comment::SetValue('account')));
				if (!empty($chkdata)) {
					$this->useful->AlertPage('', 'member已有相同帳號，請重新輸入');
					return '';
				}

				$create_id = $this->mmodel->insert_into($dbname, $data);
				if ($create_id)
					$msg = '新增成功';
				else
					$msg = '新增失敗';
			}
		}
		echo '<script>alert("' . $msg . '");window.location.href="/member/member_list";</script>';
	}

	//用戶操作動作
	public function member_log($id)
	{
		//權限判斷
		$this->useful->CheckComp('j_user');

		//資料庫名稱
		$dbname = 'event_log';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, '', array('admin_id' => $id));
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end


		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', array('admin_id' => $id));
		foreach ($dbdata as $key => $value) {
			//哪個管理者
			$admin = $this->mymodel->OneSearchSql('member', 'account', array('member_id' => $value['admin_id']));
			//哪個動作
			$type = $this->mymodel->OneSearchSql('e_log_config', 'd_val', array('d_type' => $value['d_type']));
			$type = $type['d_val'];
			//哪個資料夾
			$filed = $this->mymodel->OneSearchSql('e_log_config', 'd_tid,d_val', array('d_type' => $value['d_table']));

			$table = $this->mymodel->OneSearchSql($value['d_table'], $filed['d_val'], array($filed['d_tid'] => $value['d_table_id']));
			$name = $table[$filed['d_val']];
			if ($name != '')
				$dbdata[$key]['content'] = $admin['account'] . '在' . $value['d_content'] . $type . $name . "資料";
			else
				unset($dbdata[$key]);
		}

		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('member/member_log', $data);
	}

	//客服列表
	public function contact_list()
	{
		//權限判斷
		$this->useful->CheckComp('j_cust');

		//資料庫名稱
		$data['dbname'] = $dbname = 'contact';
		$data['s_type'] = $s_type = Comment::SetValue('s_type');


		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, '', array('d_is_send' => $s_type));
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end	



		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', array('d_is_send' => $s_type), 'create_time', 'desc');

		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['d_is_send'] = ($value['d_is_send'] == 'Y') ? '已回覆' : '未回覆';
			$dbdata[$key]['create_time'] = substr($value['create_time'], 0, 10);
			$dbdata[$key]['update_time'] = ($value['d_is_send'] == 'Y') ? substr($value['update_time'], 0, 10) : '';
		}
		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('member/' . $dbname . '_list', $data);
	}

	//客服內文
	public function contact_info($id = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_cust');

		//資料庫名稱
		$data['dbname'] = $dbname = 'contact';

		$dbdata = $this->mmodel->select_from($dbname, array('d_id' => $id));
		$dbdata['d_sex'] = ($dbdata['d_sex'] == 'male') ? '先生' : '小姐';
		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('member/' . $dbname . '_info', $data);
	}

	//EBH留言記錄
	public function ebhlist()
	{
		//權限判斷
		$this->useful->CheckComp('j_ebh');

		//資料庫名稱
		$data['dbname'] = $dbname = 'talkapp';

		$dbdata = $this->mmodel->get_ebh_data();
		foreach ($dbdata as $key => $value) {
			$bid = $this->mymodel->OneSearchSql('member', 'by_id', array('member_id' => $value['m_id']));
			$bdata = $this->mymodel->OneSearchSql('buyer', 'd_account,name', array('by_id' => $bid['by_id']));
			$dbdata[$key]['d_name'] = $bdata['name'] . '(' . $bdata['d_account'] . ')';
		}
		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('member/' . $dbname . '_list', $data);
	}

	//EBH會員留言記錄
	public function ebhmlist($m_id)
	{
		//權限判斷
		$this->useful->CheckComp('j_ebh');

		//資料庫名稱
		$data['dbname'] = $dbname = 'talkapp';

		$dbdata = $this->mmodel->get_ebh_data($m_id);
		foreach ($dbdata as $key => $value) {
			$bdata = $this->mymodel->OneSearchSql('buyer', 'd_account,name', array('by_id' => $value['b_id']));
			$dbdata[$key]['d_name'] = $bdata['name'] . '(' . $bdata['d_account'] . ')';
		}
		$data['dbdata'] = $dbdata;

		//view
		$this->load->view('member/' . $dbname . 'm_list', $data);
	}

	//EBH會員留言記錄內文
	public function ebhinfo($m_id, $b_id)
	{
		//權限判斷
		$this->useful->CheckComp('j_ebh');

		//資料庫名稱
		$data['dbname'] = $dbname = 'talkapp';

		$dbdata = $this->mmodel->get_ebh_data($m_id, $b_id);
		foreach ($dbdata as $key => $value) {
			$bid = $this->mymodel->OneSearchSql('member', 'by_id', array('member_id' => $value['m_id']));
			$bdata = $this->mymodel->OneSearchSql('buyer', 'name', array('by_id' => $bid['by_id']));
			$dbdata[$key]['d_name'] = $bdata['name'];
		}
		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('member/' . $dbname . '_info', $data);
	}

	// LOG
	public function loglist()
	{
		//權限判斷
		$this->useful->CheckComp('j_log');
		//資料庫名稱
		$data['dbname'] = $dbname = 'web_log';
		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, array('d_type' => $_POST['s_type']));
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end	
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', array('d_type' => $_POST['s_type']));
		// 狀態
		$status = array(
			'1' => '更改上線',
			'2' => '更改PV',
			'3' => '新增會員',
			'4' => '更改註冊APP'
		);
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['d_type'] = $status[$value['d_type']];
		}

		$data['status'] = $status;
		$data['dbdata'] = $dbdata;
		//view
		$this->load->view('member/loglist', $data);
	}

	//AJAX搜尋會員
	public function get_member_ajax()
	{
		$name1 = $_POST['keyword'];
		$member_data = $this->mmodel->get_member_data('', '', '', '', '', $name1);

		foreach ($member_data as $key => $value) {
			echo "<li>" . "[" . $value['member_num'] . "]" . $value['name'] . "</li>";
		}
	}

	//AJAX上線
	public function get_upline_ajax()
	{
		$pid = $_POST['pid'];
		$upline = $_POST['upline'];
		$pm_data = $this->mmodel->get_member_sign('', $pid);
		$um_data = $this->mmodel->get_member_sign($upline);
		$json_array = array();
		$json_array['pid'] = $pm_data['GID'];
		$json_array['upline'] = $um_data['GID'];
		echo json_encode($json_array);
	}

	// 獲取所有郵遞區號與地區 API
	public function get_city_category()
	{
		$data = $this->mymodel->getCityCategory();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	//城市撈取地區
	public function select_area()
	{

		$pid = $_POST['pid'];

		$city_data = $this->mymodel->get_area_data($pid);
		echo json_encode($city_data);
	}

	//取 zip code by s_id
	public function getZipCodeBySid()
	{
		$zip_code = $this->mymodel->get_zip_code($_POST['s_id']);
		echo $zip_code->s_zipcode;
	}

	//撈取地區ajax
	public function ajax_area()
	{
		//語言包
		$this->lang = $this->lmodel->config('22', $this->setlang);
		$data['city']		=	"<select name='cen_city' id='cen_city' onChange='";
		$data['city']		.=	'sel_area(this.value,"","cen_countory")';
		$data['city']		.=	"' class='form-control'><option value='0'>" . $this->lang["c_23"] . "</option>"; //請選擇縣市
		$data['countory']	=	'<select name="cen_countory" id="cen_countory" class="form-control"><option value="0">' . $this->lang["c_24"] . '</option>'; //請選擇鄉鎮
		$country 			=	$_POST['country'];
		$city 				=	$_POST['city'];
		$countory 			=	$_POST['countory'];
		$country_arr 			=	$this->mymodel->get_area_data(0);
		foreach ($country_arr as $cvalue) {
			$selected 			=	($cvalue['s_id'] == $country) ? 'selected' : '';
			$data['country']	.=	"<option value='" . $cvalue['s_id'] . "' " . $selected . ">" . $cvalue['s_name'] . "</option>";
		}
		$data['country']		.= "</select>";
		if (!empty($country)) {
			$city_arr 				=	$this->mymodel->get_area_data("$country");
			foreach ($city_arr as $cvalue2) {
				$selected 			=	($cvalue2['s_id'] == $city) ? 'selected' : '';
				$data['city']		.=	"<option value='" . $cvalue2['s_id'] . "' " . $selected . ">" . $cvalue2['s_name'] . "</option>";
			}
			$data['city']			.= "</select>";
		}
		if (!empty($countory)) {
			$countory_arr 			 =	$this->mymodel->get_area_data("$city");
			foreach ($countory_arr as $cvalue3) {
				$selected 			= ($cvalue3['s_id'] == $countory) ? 'selected' : '';
				$data['countory']	.=	"<option value='" . $cvalue3['s_id'] . "' " . $selected . ">" . $cvalue3['s_name'] . "</option>";
			}
			$data['countory'] 		.= "</select>";
		}
		echo json_encode($data);
	}

	//資料增刪修
	public function data_AED($DB = '', $del_id = '')
	{


		$this->load->library('/mylib/CheckInput');
		$check = new CheckInput;

		if ($del_id != '') {
			$dbname = $DB;
			$this->mmodel->delete_where($DB, array('d_id' => $del_id));
			$msg = '刪除成功';
		} else {
			$id = $_POST['d_id'];
			$dbname = $_POST['dbname'];


			if ($dbname == 'jurisdicer') {
				foreach ($_POST['d_action_list'] as $value) {
					$action .= $value . ',';
				}
				unset($_POST['d_action_list']);
			}

			if ($id) {
				$data = $this->useful->DB_Array($_POST);
			} else {
				$data = $this->useful->DB_Array($_POST, 1);
			}

			if ($dbname == 'jurisdicer') {
				$data['d_action_list'] = $action;
			}

			if ($dbname == 'member') {
				$check->fname[] = array('_String', Comment::SetValue('account'), '帳號');
				$check->fname[] = array('_CheckEmail', Comment::SetValue('email'), '電子信箱');
				$check->fname[] = array('_String', Comment::SetValue('password'), '登入密碼');

				$data['password'] = $this->encrypt->encode(Comment::SetValue('password'));
				$data['domain_id'] = 0;
				$data['auth'] = '00';
				$data['addtime'] = time();
				$data['deadline'] = strtotime(date('Y-m-d', strtotime('+19 years')));
			}

			if ($dbname == 'contact') {
				$check->fname[] = array('_String', Comment::SetValue('d_send_content'), '回覆資料');
			}


			if (!empty($check->main())) {
				echo $check->main();
				return '';
			}
			if ($dbname == 'contact') {
				//model
				$this->load->model('index_model', 'mod_index');
				//寄送密碼信
				//主旨
				$subject = $this->data['web_config']['title'] . '客服回應信';

				//內容
				$message = '' .
					"<p>親愛的用戶您好:</p>" .
					"<p>您欲詢問之問題如下</p>" .
					"<p><h4> " . nl2br($data['d_content']) . "</h4></p>" .
					"<p>客服回應如下</p>" .
					"<p> " . nl2br($data['d_send_content']) . "</p>" .
					"<p>" . $this->data['web_config']['title'] . "客服中心</p>";
				//寄信
				$this->mod_index->send_mail($this->data['host']['domain'], $this->data['web_config']['title'], $data['d_mail'], $subject, $message);
				$data['d_is_send'] = 'Y';
			}

			unset($data['dbname']);
			unset($data['d_id']);

			if ($id != '') {
				$this->mmodel->update_set($dbname, 'd_id', $id, $data);
				$msg = '修改成功';
			} else {

				$create_id = $this->mmodel->insert_into($dbname, $data);
				if ($create_id)
					$msg = '新增成功';
				else
					$msg = '新增失敗';
			}
		}
		$this->useful->AlertPage('/member/contact_list', $msg);
	}
	//會員列表
	public function vip_list()
	{

		//權限判斷
		$this->useful->CheckComp('j_member');

		//資料庫名稱
		$data['dbname'] = $dbname = 'buyer';

		$where_array = array();
		$where_array[] = "b.d_is_member=1";
		$where = !empty($where_array) ? " where " . implode(" and ", $where_array) : "";
		// 分頁程式 start
		$this->load->library('/mylib/PageNew');
		$page = new PageNew();
		$page->SetMySQL($this->db);
		$page->SetPagSize(20);
		$qpage = $page->PageStar(' buyer b LEFT JOIN member m on m.by_id=b.by_id', '', $where);
		$data['page'] = $this->load->view('mypage/page', $qpage, true);
		// print_r($_POST);
		//分頁程式 end
		// $dbdata=$this->mmodel->GetMember($where,$qpage['result']);
		$dbdata = $this->mmodel->GetVip($where, $qpage['result']);




		// $dbdata=$this->mymodel->get_member_data('',$s_num,$s_name,$s_type,'','',$qpage['result'],$s_account);

		foreach ($dbdata as $key => $value) {
			if ($value['d_is_member'] == '0')
				$member_type = '一般會員';
			elseif ($value['d_is_member'] == '1')
				$member_type = '經營會員';
			else
				$member_type = '待審核會員';

			$dbdata[$key]['d_is_member'] = $member_type;

			$dbdata[$key]['ctime'] = substr($value['ctime'], 0, 10);

			//經營狀態 會員期限
			$dbdata[$key]['deadline'] = '';
			$dbdata[$key]['deadstatus'] = '';
			if ($value['d_is_member'] == '1') {
				$deadline = round(($value['deadline'] - time()) / 86400);
				if ($deadline <= 30) {
					$dbdata[$key]['deadline'] = "<span style='color:RED;'>餘" . $deadline . "天</span>";
				} else
					$dbdata[$key]['deadline'] = '餘' . $deadline . '天';
				if ($deadline <= 0) {
					$dbdata[$key]['deadstatus'] = "無效";
				} else
					$dbdata[$key]['deadstatus'] = "有效";
			}
			//判斷是否可刪除(經銷會員及有訂單記錄不可刪除)
			$odata = $this->mymodel->select_page_form('`order`', '', 'order_id', array('by_id' => $value['by_id']));

			if (!empty($odata) or $value['d_is_member'] == '1')
				$dbdata[$key]['seldel'] = 'NoDel';
		}
		$data['dbdata'] = $dbdata;


		//view
		$this->load->view('member/vip_list', $data);
	}
	public function vip_detail_list($by_id)
	{
		//權限判斷
		$this->useful->CheckComp('j_member');

		//資料庫名稱
		$data['dbname'] = $dbname = 'buyer';

		$where_array = array();
		$where_array[] = "b1.by_id = " . $by_id;
		$where = !empty($where_array) ? " where " . implode(" and ", $where_array) : "";
		// 分頁程式 start
		$this->load->library('/mylib/PageNew');
		$page = new PageNew();
		$page->SetMySQL($this->db);
		$page->SetPagSize(20);
		$qpage = $page->PageStar('buyer b left join member m on m.by_id=b.by_id left join member m1 on m.by_id=m1.member_id left join buyer b1 on b.PID=b1.by_id left join buyer b2 on m1.by_id=b2.by_id', '', $where);
		$data['page'] = $this->load->view('mypage/page', $qpage, true);
		// print_r($_POST);
		//分頁程式 end
		// $dbdata=$this->mmodel->GetMember($where,$qpage['result']);
		$dbdata = $this->mmodel->GetMember($where, $qpage['result']);

		// $dbdata=$this->mymodel->get_member_data('',$s_num,$s_name,$s_type,'','',$qpage['result'],$s_account);

		foreach ($dbdata as $key => $value) {
			if ($value['d_is_member'] == '0')
				$member_type = '一般會員';
			elseif ($value['d_is_member'] == '1')
				$member_type = '經營會員';
			else
				$member_type = '待審核會員';

			$dbdata[$key]['d_is_member'] = $member_type;

			$dbdata[$key]['ctime'] = substr($value['ctime'], 0, 10);

			//經營狀態 會員期限
			$dbdata[$key]['deadline'] = '';
			$dbdata[$key]['deadstatus'] = '';
			if ($value['d_is_member'] == '1') {
				$deadline = round(($value['deadline'] - time()) / 86400);
				if ($deadline <= 30) {
					$dbdata[$key]['deadline'] = "<span style='color:RED;'>餘" . $deadline . "天</span>";
				} else
					$dbdata[$key]['deadline'] = '餘' . $deadline . '天';
				if ($deadline <= 0) {
					$dbdata[$key]['deadstatus'] = "無效";
				} else
					$dbdata[$key]['deadstatus'] = "有效";
			}
			//判斷是否可刪除(經銷會員及有訂單記錄不可刪除)
			$odata = $this->mymodel->select_page_form('`order`', '', 'order_id', array('by_id' => $value['by_id']));

			if (!empty($odata) or $value['d_is_member'] == '1')
				$dbdata[$key]['seldel'] = 'NoDel';
		}
		$data['dbdata'] = $dbdata;


		//view
		$this->load->view('member/vip_detail_list', $data);
	}

	public function group_email($page = 1)
	{
		if (!$this->session->userdata('member_id')) {
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		} else {
			//model
			$this->load->model('gemail_model', 'mod_gemail');

			$this->member_id = $this->session->userdata('member_id');
			$data = $this->data;
			$data['gemail_log'] = $push_log = $this->mod_gemail->select_from_order('gemail_log', 'd_id', 'desc', array('d_member_id' => $this->member_id, 'd_disable' => 'N'));

			// 換頁設定
			$page_uri   = 'member/group_email';
			$total_rows = count($data['gemail_log']);
			$per_page   = 10;
			$config     = $this->init_pagination($page_uri, $total_rows, $per_page);

			// 排序條件
			if ($this->input->get('ob') && $this->input->get('ot')) {
				$order_by   = $this->input->get('ob');
				$order_type = $this->input->get('ot');
			} else {
				$order_by   = 'd_id';
				$order_type = 'desc';
			}

			// 每頁資料設定
			$start_id             = (($page - 1) * $per_page);
			$real_page_num        = $per_page;
			$data['page_data']    = $this->mod_gemail->get_range_data('gemail_log', $order_by, $order_type, $start_id, $real_page_num, array('d_member_id' => $this->member_id, 'd_disable' => 'N'));
			$data['page_config']  = $config;
			$data['page']         = $page;
			foreach ($data['page_data'] as $key => $value) {
				$data['page_data'][$key]['d_create_time'] = date('Y-m-d H:i:s', $value['d_create_time']);

				switch ($value['d_status']) {
					case '1':
						$data['page_data'][$key]['d_status'] = '已推送';
						break;

					case '2':
						$data['page_data'][$key]['d_status'] = '草稿';
						$data['page_data'][$key]['edit'] = true;
						break;
					case '3':
						$data['page_data'][$key]['d_status'] = '預約中';
						break;
				}

				switch ($value['type']) {
					case '0':
						$data['page_data'][$key]['d_type'] = '全體';
						break;

					default:
						$data['page_data'][$key]['d_type'] = '個人';
						break;
				}
			}

			// string replace
			$create_links = str_replace('&lsaquo;', '第一頁', $this->pagination->create_links());
			$create_links = str_replace('&rsaquo;', '最末頁', $create_links);
			$data['create_links'] = $create_links;

			$data['add_push'] = true;

			$this->load->view('gemail/gemail_index', $data);
		}
	}

	// 新增推播
	public function add()
	{
		if (!$this->session->userdata('member_id')) {
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		} else {
			//model
			$this->load->model('gemail_model', 'mod_gemail');

			$this->member_id = $this->session->userdata('member_id');
			$data = $this->data;
			$member = $this->mod_gemail->select_from('member', array('member_id' => $this->member_id));

			if (!$this->input->post('add')) {
				$data['member_id'] = $this->member_id;
				$data['success'] = 0;
				$data['group_push'] = 1;

				$members = $this->mod_gemail->select_from_order('buyer', 'by_id', 'asc', array());
				if (!empty($members)) {
					foreach ($members as $key => $value) {
						$data['device_users'][$key]['member_id'] = $value['by_id'];
						$data['device_users'][$key]['account'] = $value['d_account'];
						$data['device_users'][$key]['name'] = $value['name'];
					}
					$data['show_device'] = true;
				} else
					$data['show_device'] = false;
			} else {
				$title   = $this->input->post('title');
				$message = $this->input->post('message');

				// broadcasting 為 0, subordination 才有值
				$type    = $this->input->post('broadcasting');
				$subordination = $this->input->post('subordination');
				if (!empty($subordination)) {
					foreach ($subordination as $key => $value) {
						$to_member_id .= '*#' . $value;
					}
				}

				$status = $this->input->post('status');
				$Create_time = time();

				// 會員圖檔目錄
				$img_url = '.' . $member['img_url'] . 'push/';
				if (!file_exists($img_url)) {
					@mkdir($img_url, 0777);
				}

				$insert_data = array(
					'd_member_id'     => $this->member_id,
					'd_title'         => $title,
					'd_message'       => $message,
					'd_ip'            => $this->get_realip(),
					'd_create_time'   => $Create_time,
					'd_type'          => $type,
					'd_to_member_id'  => $to_member_id,
					'd_status'        => $status,
					'd_disable'       => 'N'
				);
				$p_id = $this->mod_gemail->insert_into('gemail_log', $insert_data);

				// status 1: 推送, 2: 草稿
				// type   0: 群體; 1: 個人
				switch ($type) {
					case '0':
						// 禮拜一刪除此段，以send_time (edit_time) 為基準判斷
						if ($status == 1) {
							// 回傳時修改 send_time
							$this->mail_send($p_id);
							$this->mod_gemail->update_set('gemail_log', 'd_id', $p_id, array('d_send_time' => $Create_time));
						}
						break;

					case '1':
						if ($status == 1) {
							// 回傳時修改 send_time
							$this->mail_send($p_id);
							$this->mod_gemail->update_set('gemail_log', 'd_id', $p_id, array('d_send_time' => $Create_time));
						}
						break;
				}
				$data['success'] = 1;
				$this->script_message_close('推送成功');
			}
			$this->load->view('gemail/gemail_add', $data);
		}
	}

	public function mail_send($d_id)
	{
		//model
		$this->load->model('gemail_model', 'mod_gemail');

		// 寄信	
		$gemail = $this->mod_gemail->select_from('gemail_log', array('d_id' => $d_id));
		$to_member = $this->get_serialstr($gemail['d_to_member_id'], '*#');
		$host = $this->get_host_config();
		$this->mod_gemail->send_mail($gemail, $to_member, $host);
	}

	public function R($p_id, $back_page)
	{
		if (isset($p_id)) {
			//model
			$this->load->model('gemail_model', 'mod_gemail');

			$push_log = $this->mod_gemail->select_from('gemail_log', array('d_id' => $p_id));

			if ($push_log['type'] == '0') {
				$to_member = $this->get_serialstr($push_log['d_to_member_id'], '*#');
				$push_log['member_name'] = $this->mod_gemail->get_member_name($to_member);
			} else {
				$to_member = $this->get_serialstr($push_log['d_to_member_id'], '*#');
				$push_log['member_name'] = $this->mod_gemail->get_member_name($to_member);
			}
			$data['page'] = $back_page;
			$data['push_log'] = $push_log;
			$this->load->view('gemail/gemail_R', $data);
		} else {
			$this->script_message('Error Format', '/member/group_email');
		}
	}

	public function edit($p_id, $suc = "")
	{
		if (!$this->session->userdata('member_id')) {
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		} else {
			$this->load->model('gemail_model', 'mod_gemail');

			$data = $this->data;
			$data['push'] = $this->mod_gemail->select_from('gemail_log', array('d_id' => $p_id));
			if (empty($data['push']))
				$this->script_message_close('非法連結');

			if (!$this->input->post('add')) {
				$data['member_id'] = $this->member_id;
				$data['success'] = 0;
				$data['group_push'] = $this->data['web_config']['group_push'];

				$members = $this->mod_gemail->select_from_order('buyer', 'by_id', 'asc', array());
				if (!empty($members)) {
					$to_member_array = $this->get_serialstr($data['push']['d_to_member_id'], '*#');
					foreach ($members as $key => $value) {
						$data['device_users'][$key]['member_id'] = $value['by_id'];
						$data['device_users'][$key]['account'] = $value['d_account'];
						$data['device_users'][$key]['name'] = $value['name'];
						$data['device_users'][$key]['selected'] = in_array($value['by_id'], $to_member_array) ? 'selected' : '';
					}
					$data['show_device'] = true;
				} else
					$data['show_device'] = false;
			} else {
				$title   = $this->input->post('title');
				$message = $this->input->post('message');

				// broadcasting 為 0, subordination 才有值
				$type    = $this->input->post('broadcasting');
				$subordination = $this->input->post('subordination');
				if (!empty($subordination)) {
					foreach ($subordination as $key => $value) {
						$to_member_id .= '*#' . $value;
					}
				}

				$status = $this->input->post('status');
				$Edit_time = time();

				// 會員圖檔目錄
				$member = $this->mod_gemail->select_from('member', array('member_id' => $this->member_id));
				$img_url = '.' . $member['img_url'] . 'push/';
				if (!file_exists($img_url)) {
					@mkdir($img_url, 0777);
				}

				$update_data = array(
					'd_member_id'     => $this->member_id,
					'd_title'         => $title,
					'd_message'       => $message,
					'd_ip'            => $this->get_realip(),
					'd_create_time'   => $Create_time,
					'd_type'          => $type,
					'd_to_member_id'  => $to_member_id,
					'd_status'        => $status,
					'd_disable'       => 'N'
				);
				$id = $this->mod_gemail->update_set('gemail_log', 'd_id', $p_id, $update_data);

				// status 1: 推送, 2: 草稿
				// type   0: 群體; 1: 個人
				switch ($type) {
					case '0':
						// 禮拜一刪除此段，以send_time (edit_time) 為基準判斷
						if ($status == 1) {
							// 回傳時修改 send_time
							$this->mail_send($p_id);
							$this->mod_gemail->update_set('gemail_log', 'd_id', $p_id, array('d_send_time' => $Create_time));
						}
						break;

					case '1':
						if ($status == 1) {
							// 回傳時修改 send_time
							$this->mail_send($p_id);
							$this->mod_gemail->update_set('gemail_log', 'd_id', $p_id, array('d_send_time' => $Create_time));
						}
						break;
				}
				$data['success'] = 1;
			}
			$this->load->view('gemail/gemail_edit', $data);
		}
	}

	public function city()
	{
		$data = array();
		$sql = "select * from city_category where s_city_id = '807'";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val) {
			$data[$val["s_id"]] = $val;
		}
		return $data;
	}

	// Ajax 回傳，刪除 Push 紀錄
	public function del_gemail_log()
	{
		$this->load->model('gemail_model', 'mod_gemail');
		$del_id = $this->input->post('p_id');
		$mode   = $this->input->post('mode');
		$timer  = time();
		$once_push_log = $this->mod_gemail->select_from('gemail_log', array('d_id' => $del_id));
		if ($mode == "0" && !empty($once_push_log)) {
			$update_data = array(
				'd_delete_time' => $timer,
				'd_disable'     => 'Y',
			);
			$update_id = $this->mod_gemail->update_set('gemail_log', 'd_id', $del_id, $update_data);

			echo $update_id;
		} else
			echo false;
	}
}
