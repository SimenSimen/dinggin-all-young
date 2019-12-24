<?php
class Form extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct()//初始化
	{
		parent::__construct();

		//model
		$this->load->model('index_model', 'mod_index');

		//亂碼
		header("Content-Type:text/html; charset=utf-8");

		//host
		$this->data['host'] = $this->get_host_config();

		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id'] = $this->session->userdata('session_domain');
		else
			$this->data['domain_id'] = $this->data['host']['domain_id'];

		//web config
		$this->data['web_config'] = $this->get_web_config($this->data['domain_id']);

		//helper
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
		
		$this -> lang -> load('controllers/form', $this -> data['lang']);
		$this -> language['MustUsePhoneOpen'] = lang('MustUsePhoneOpen');
		$this -> language['ElectronicElegiacNotice'] = lang('ElectronicElegiacNotice');
		$this -> language['DoNotDirectlyReply'] = lang('DoNotDirectlyReply');
		$this -> language['NewApplicants'] = lang('NewApplicants');
		$this -> language['SubaccountNewApplicants'] = lang('SubaccountNewApplicants');
		$this -> language['RegistrationForm'] = lang('RegistrationForm');
		$this -> language['SignSituationOverview'] = lang('SignSituationOverview');
		$this -> language['Details'] = lang('Details');
		$this -> language['_Details'] = lang('_Details');
		$this -> language['DataSendSuccess'] = lang('DataSendSuccess');
		$this -> language['ElectronicElegiac'] = lang('ElectronicElegiac');
		$this -> language['_ElectronicElegiac'] = lang('_ElectronicElegiac');
		$this -> language['NoticeElectronicElegiac'] = lang('NoticeElectronicElegiac');
		$this -> language['Company'] = lang('Company');
		$this -> language['SucMessage'] = lang('SucMessage');



		//裝置判斷分享bar hideen
		$this->data['share_bar_hidden'] = 1;
	}

	public function index($ufm_id = '', $card_owner = 0, $v = '') // $v 某些問卷利用業務通產生，被內嵌於APP中，此頁面被限定只能在APP使用，所以另外判斷若加了V參數則為APP限定
	{
		//data
		$data = $this->data;
		$language = $this -> language;

		$this -> lang -> load('views/form/index', $data['lang']);
		$data['One'] = lang('One');
		$data['January'] = lang('January');
		$data['July'] = lang('July');
		$data['September'] = lang('September');
		$data['Two'] = lang('Two');
		$data['February'] = lang('February');
		$data['August'] = lang('August');
		$data['November'] = lang('November');
		$data['December'] = lang('December');
		$data['October'] = lang('October');
		$data['Three'] = lang('Three');
		$data['March'] = lang('March');
		$data['LastMonth'] = lang('LastMonth');
		$data['Five'] = lang('Five');
		$data['May'] = lang('May');
		$data['Six'] = lang('Six');
		$data['June'] = lang('June');
		$data['Date'] = lang('Date');
		$data['_Date'] = lang('_Date');
		$data['Four'] = lang('Four');
		$data['April'] = lang('April');
		$data['Friday'] = lang('Friday');
		$data['Saturday'] = lang('Saturday');
		$data['Sunday'] = lang('Sunday');
		$data['Thursday'] = lang('Thursday');
		$data['_Send'] = lang('_Send');
		$data['Week'] = lang('Week');
		$data['ClickRightDate'] = lang('ClickRightDate');

		$this -> lang -> load('views/form/m', $data['lang']);
		$data['ShareOnGoogle'] = lang('ShareOnGoogle');
		$data['ShareOnPlurk'] = lang('ShareOnPlurk');
		$data['ShareOnTwitter'] = lang('ShareOnTwitter');
		$data['ShareOnWeibo'] = lang('ShareOnWeibo');
		$data['ShareOnFacebook'] = lang('ShareOnFacebook');
		$data['EmailTellFriend'] = lang('EmailTellFriend');
		$data['Return'] = lang('Return');
		$data['TryScrolling'] = lang('TryScrolling');
		$data['Send'] = lang('Send');
		$data['URL'] = lang('URL');
		$data['SignUpSend'] = lang('SignUpSend');
		$data['CorrectFormat'] = lang('CorrectFormat');
		$data['Select'] = lang('Select');

		//device
		$mobile_browser = $this->get_device_type();
			
		// 判斷APP限定
		if($v)
		{
			//view
			if($mobile_browser >= 1)//手機版
			{
				
			}
			else
			{//電腦版
				$this -> script_message($language['MustUsePhoneOpen'], '/form/view_qrcode/'.$ufm_id.'/1');
				return 0;
			}
			$data['v'] = 1;
		}

		if($ufm_id != '')
		{
			//id
			$data['ufm_id']=$ufm_id;

			//回傳用名片擁有者
			$data['card_owner']=$card_owner;

			//判斷使用期限
			// if(!$this->check_deadline($data['web_config'], $card_owner))
			// {
			// 	redirect('/index/error');
			// }

			//domain
			$data['base_url'] = base_url();

			//行動名片連結
			// $member = $this->mod_index->select_from('member', array('member_id'=>$data['card_owner']));
			// if($data['web_config']['iqr_link_type'] == 1)//短網址
			// {
			// 	$base_url = substr(base_url(), 7);
			// 	$base_url = substr($base_url, 0, -1);
			// 	$data['iqr_url'] = 'http://'.$member['account'].'.'.$base_url;
			// }
			// else
			// {
			// 	$data['iqr_url'] = base_url().'business/iqr/'.$member['account'];
			// }

			//uform data
			$data['uform'] = $uform = $this->mod_index->select_from('uform', array('ufm_id'=>$ufm_id));

			//uform不存在
			if(empty($uform))
			{
				redirect(base_url());
			}

			//edm已關閉
			if(!empty($uform))
			{
				if($uform['ufm_status'] == 0)
				{
					redirect(base_url());
				}
			}
			
			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//title
			$data['ufm_title'] = $this->get_serialstr($uform['ufm_col_name'], "*#");

			//content
			if(count($data['ufm_title']) > 2)
			{
				$ufm_content = $this->get_serialstr($uform['ufm_col_content'], "*#");
				if(!empty($ufm_content))
				{
					foreach($ufm_content as $key => $value)
					{
						// $str[0] 		type, 1:日期, 2:文字, 3:單選, 4:下拉, 2:複選
						// $str[1]-[n] 	content if [1] != 'n'
						$str=explode(';', $value);
						$data['ufm_content'][]=$str;
					}
				}
				$ufm_required = $this->get_serialstr($uform['ufm_col_required'], "*#");
				if(!empty($ufm_required))
				{
					foreach($ufm_required as $key => $value)
					{
						//必填
						$data['ufm_required'][] 	 = ($value == 1) ? 'required' : '';
						$data['ufm_required_star'][] = ($value == 1) ? '<span class="red_star">*</span>' : '';
					}
				}
			}

			//device
			$mobile_browser = $this->get_device_type();
			
			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//搜尋網頁內容是否含圖片
			$data['first_img'] = $this->get_first_img($uform['ufm_aim']);
			
			//裝置判斷分享bar hideen
			if($this->get_device_os() == 'android')
				$data['select_item_false'] = 1;
			else
				$data['select_item_false'] = 0;

			//view
			if($mobile_browser >= 1)
			{//手機版
				$this->load->view('/form/m', $data);
			}
			else
			{//電腦版
				$this->load->view('/form/index', $data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}

	public function signup($type='')
	{
		//data
		$data=$this->data;
		$language = $this -> language;

		//判斷使用期限
		// if(!$this->check_deadline($data['web_config'], $this->input->post('card_owner')))
		// {
		// 	redirect('/index/error');
		// }

		if($this->input->post('send'))
		{
			$data_array[0] = $this->input->post('name_r');
			$data_array[1] = $this->input->post('mphone_r');
			$data_array[2] = $this->input->post('email_r');
			$temp_customer_data = $this->input->post('customerInput');
			for($i = 3; $i < $this->input->post('ufm_col_num'); $i++)
			{
				if(is_array($temp_customer_data[$i]))
					$data_array[$i] = $this->set_serialstr($temp_customer_data[$i], '*#');
				else
					$data_array[$i] = $temp_customer_data[$i];
			}
			$ufms_result = $this->set_serialstr($data_array, '*#');
			$insert_data = array(
				'ufms_result'	=> $ufms_result,
				'ufm_id' 		=> $this->input->post('ufm_id'),
				'card_owner' 	=> 0,
				'addtime' 		=> time()
			);
			$ufms_id=$this->mod_index->insert_into('uform_signup', $insert_data);

			if($ufms_id)
			{
				// $member 	   = $this->mod_index->select_from('member', array('member_id'=>$this->input->post('card_owner')));
				// $member_domain = $this->mod_index->select_from('domain', array('domain_id'=>$member['domain_id']));
				$uform 		   = $this->mod_index->select_from('uform', array('ufm_id'=>$this->input->post('ufm_id')));
				// $admin 		   = $this->mod_index->select_from('member', array('member_id'=>$uform['member_id'], 'auth'=>'01'));
				
				//寄送報名通知信給名片擁有者
				//主旨
				// $subject = $data['host']['company'].$language['ElectronicElegiacNotice'];
				// if($this->input->post('card_owner') != $admin['member_id'])
				// {
				// 	//內容
				// 	$message = ''.
				// 		"<p><h3>".$language['NoticeElectronicElegiac']."</h3></p>".
				// 		"<p>".$language['NewApplicants']."</p>".
				// 		"<p>".$language['_ElectronicElegiac']."".$uform['ufm_name']."</p>".
				// 		"<p>".$language['_Details']."{unwrap}<a href='http://".$member_domain['domain']."/business/uform_sign_up_show/sign_up_".$uform['ufm_id']."/".$this->input->post('card_owner')."'>".$language['SignSituationOverview']."</a>{/unwrap}</p>".
				// 		"<hr>".
				// 		"<p>".$language['DoNotDirectlyReply']."</p>";
				// 	//寄信
				// 	$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $member['email'], $subject, $message);
				// }
				//寄送報名通知信給母站帳戶
				//內容
				// $message = ''.
				// 	"<p><h3>".$language['ElectronicElegiac']."</h3></p>".
				// 	"<p>".$language['SubaccountNewApplicants']."</p>".
				// 	"<p>".$language['_ElectronicElegiac']."".$uform['ufm_name']."</p>".
				// 	"<p>".$language['_Details']."{unwrap}<a href='http://".$member_domain['domain']."/business/uform_sign_up_show/sign_up_".$uform['ufm_id']."/".$admin['member_id']."'>".$language['SignSituationOverview']."</a>{/unwrap}</p>".
				// 	"<hr>".
				// 	"<p>".$language['DoNotDirectlyReply']."</p>";
				// //寄信
				// $this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $admin['email'], $subject, $message);
				$account = $this -> cut($this -> input -> post('back'));
				$member = $this -> mod_index -> select_from('member', array('account' => $account));

				//手機版報名
				$ufm_msg = ($uform['ufm_msg'] != '') ? $uform['ufm_msg'] : $language['DataSendSuccess'];
				if($type == 1)
				{
					echo $ufm_msg;
				}
				else//電腦版報名
				{
					$link = ($uform['ufm_mode'] == '1') ? $this -> input -> post('back') : '/app/route/' . $member['member_id'];
					echo '
					<script>
					setTimeout("alert(\''.$ufm_msg.'\')" , 500);
					setTimeout("window.location.href=\''.$link.'\'" , 500);
					</script>';
				}
			}
		}
	}

	private function cut($str)
	{
		$array = explode('/views/d/', $str);
		$first_slash = strpos($array[1], '/');
		$account = substr($arrays[1], 0, $first_slash);
		return $account;		
	}

	public function view_qrcode($ufm_id = '', $v = '')
	{
		//data
		$data = $this->data;
		$language = $this -> language;

		//helper
		$this->load->helper('url');

		if($ufm_id != '')
		{
			$data['uform']=$uform=$this->mod_index->select_from('uform', array('ufm_id'=>$ufm_id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($uform))
		{
			$data['base_url'] = base_url();
			$data['ufm_id']   = $ufm_id;
			$data['v']        = $v;

			//account
			$data['mid'] = $this->session->userdata('member_id');

			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $this->session->userdata('member_id')))
			{
				redirect('/index/error');
			}
			
			//qrcode style
			$data['style'] = array(
				'mode'		 => 0,
				'size'		 => 400,
				'fill'		 => '#000000',
				'background' => '#FFFFFF',
				'minversion' => 2,
				'eclevel'	 => 'H',
				'quiet'		 => 1,
				'radius'	 => 20,
				'msize'		 => 1,
				'mposx'		 => 50,
				'mposy'		 => 50,
				'font'		 => 4
			);
			
			$this->load->view('business/view_ufm_qrcode_box', $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	//搜尋網頁內容是否含圖片
	private function get_first_img($content)
	{
		//前後位置
		if(($img_tag_pos = strpos($content, '<img')) !== false)
		{
			$img_status 	 = true;
			$temp_content_1  = substr($content, $img_tag_pos);
			$img_tag_end_pos = strpos($temp_content_1, '>'); // 從新位置開始找第一個>
			$img_tag 	  	 = substr($temp_content_1, 0, $img_tag_end_pos + 1);
			$src_pos	 	 = strpos($img_tag, 'src');
			$temp_img_link 	 = substr($img_tag, $src_pos);
			$quotation_marks = substr($temp_img_link, 4, 1);
			$temp_img_link   = substr($temp_img_link, 5);
			$q_marks_pos     = strpos($temp_img_link, $quotation_marks);
			$first_img 		 = substr($temp_img_link, 0, $q_marks_pos);
		}
		else
		{
			$img_status = false;
		}
		return array('img_status'=>$img_status, 'first_img'=>$first_img);
	}
	public function index8($ufm_id = '', $card_owner = '',$base='',$viewtype='')
	{
		$this->publiccheck('',$base);
		$data=$this->data;
		$language = $this -> language;
		if($viewtype == 'C')
		{
			$data['chkmemberid']=$this->member_id;
			$viewname = $language['Company'];
		}
		else{
			$data['chkmemberid']=$this->son_member_id;
			$viewname='';
		}
		$data['viewname'] = $viewname;
		$data['viewtype'] = $viewtype;


		//device
		$mobile_browser = $this->get_device_type();

		if($ufm_id != '' && $card_owner != '')
		{
			//id
			$data['ufm_id']=$ufm_id;

			//回傳用名片擁有者
			$data['card_owner']=$card_owner;


			//行動名片連結
			$member = $this->mod_index->select_from('member', array('member_id'=>$data['card_owner']));
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url = substr(base_url(), 7);
				$base_url = substr($base_url, 0, -1);
				$data['iqr_url'] = 'http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$data['iqr_url'] = base_url().'business/iqr/'.$member['account'];
			}

			//uform data
			$data['uform'] = $uform = $this->mod_index->select_from('uform', array('ufm_id'=>$ufm_id));
			$data['ufm_msg'] = ($uform['ufm_msg'] != '') ? $uform['ufm_msg'] : $language['SucMessage'];

			//uform不存在
			if(empty($uform))
			{
				redirect(base_url());
			}

			//edm已關閉
			if(!empty($uform))
			{
				if($uform['ufm_status'] == 0)
				{
					redirect(base_url());
				}
			}
			
			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//title
			$data['ufm_title'] = $this->get_serialstr($uform['ufm_col_name'], "*#");

			//content
			if(count($data['ufm_title']) > 3)
			{
				$ufm_content = $this->get_serialstr($uform['ufm_col_content'], "*#");
				if(!empty($ufm_content))
				{
					foreach($ufm_content as $key => $value)
					{
						// $str[0] 		type, 1:日期, 2:文字, 3:單選, 4:下拉, 2:複選
						// $str[1]-[n] 	content if [1] != 'n'
						$str=explode(';', $value);
						$data['ufm_content'][]=$str;
					}
				}
				$ufm_required = $this->get_serialstr($uform['ufm_col_required'], "*#");
				if(!empty($ufm_required))
				{
					foreach($ufm_required as $key => $value)
					{
						//必填
						$data['ufm_required'][] 	 = ($value == 1) ? 'required' : '';
						$data['ufm_required_star'][] = ($value == 1) ? '<span class="red_star">*</span>' : '';
					}
				}
			}

			
			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//搜尋網頁內容是否含圖片
			$data['first_img'] = $this->get_first_img($uform['ufm_aim']);
			
			//device
			$mobile_browser = $this->get_device_type();
			
			
			//裝置判斷分享bar hideen
			if($this->get_device_os() == 'android')
				$data['select_item_false'] = 1;
			else
				$data['select_item_false'] = 0;

			//view
			if($mobile_browser >= 1)
			{//手機版
				$this->load->view('business/enroll_detail_m', $data);
			}
			else
			{//電腦版
				$this->load->view('business/enroll_detail_m', $data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}
	
}