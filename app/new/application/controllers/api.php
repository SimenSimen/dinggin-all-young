<?php
class Api extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// helper
        $this->load->helper('url');
        // model
		$this->load->model('business_model', 'mod_business');
		// library
		$this -> load -> library('Common');
	}

	// 帳號逾期檢查
	public function Check()
	{
		$now_time = time();
		$m = $this -> input -> get('member_id');
		if(!empty($m))
		{
			$member = $this -> mod_business -> select_from('member', array('member_id' => $m));
			if($now_time > $member['deadline'])
				$request = array('Expired');
			else
				$request = array('Alive');
		}
		else
			$request = array('Error');
		echo json_encode($request);
	}

	// Footer & Theme
	public function index()
	{
		$member_id = $this -> input -> get('member_id');
		$member = $this -> mod_business -> select_from('member', array('member_id' => $member_id));
		if(!empty($member))
		{
			$iqr     = $this -> mod_business -> select_from('iqr', array('member_id' => $member['member_id']));
			$iqrt    = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));
			$default = $this -> mod_business -> select_from('iqr_theme', array('theme_id' => $iqr['theme_id']));
			
			$result	= array(
				'logo_path'				=> $iqr['logo_path'],
				'theme_id'				=> $iqr['theme_id'],
			);
			if(!empty($iqr['theme_bg_image_path']))
				$result['theme_bg_image_path'] = $iqr['theme_bg_image_path'];
			else
				$result['theme_bg_image_path'] = $default['dfu_bg_image_path'];

			// 購物車是否開啟
			if($iqrt['cset_active'] == 1)
			{
					$result['cset_active'] = 1;
					$result['cset_name']   = $iqrt['cset_name'];
					$result['cset_url']    = base_url() . 'cart/store/' . $iqrt['cset_code'];
			}
			else
			{
					$result['cset_active'] = 0;
			}
			$result = array($result);
		}
		else
		{
			$result = array(
				'Error'
			);
		}
		echo json_encode($result);
	}

	// 關於我
	public function about()
	{
		$member_id = $this -> input -> get('member_id');
		$theme_id  = $this -> input -> get('theme_id');
		if($member_id && $theme_id)
		{
			$member = $this -> mod_business -> select_from('member', array('member_id' => $member_id));
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $member_id, 'theme_id' => $theme_id));
			switch ($iqr['theme_id']) {
				case 1:
					break;
				case 2:
					// 個人資訊
						// name 
						if($iqr['f_name'] != '')
							$result['iqr_name'] = $iqr['l_name'] . $iqr['f_name'];
						else
							$result['iqr_name'] = $data['account'];
						// introduce
						$result['introduce'] = $iqr['introduce'];
						// mobile
						if($iqr['mobile'] != '')
						{
							$result['mobile_show'] = true;
							$result['mobile'][] = $iqr['mobile'];
							if($iqr['mobile_name'] != '')
								$result['mobile_name'][] = $iqr['mobile_name'];
							else
								$result['mobile_name'][] = '撥打我的行動電話';
							if($iqr['mobile_phones'] != "")
							{
								$mobile_phones = $this -> get_serialstr($iqr['mobile_phones'], "*#");
								if(!empty($mobile_phones))
								{
									foreach ($mobile_phones as $key => $value)
									{
										$str_mobile = $this -> mod_business -> select_from('strings', array('str_id' => $value, 'type' => 4));
										$result['mobile'][] = $str_mobile['str'];
										$result['mobile_name'][] = ($str_mobile['str_name'] != '') ? $str_mobile['str_name'] : '撥打我的行動電話 '. $mobile_phones_num;
									}
								}
							}
						}
						else
						{
							$result['mobile_show']=false;
						}
						// email
						if($iqr['email'] != '')
						{
							$result['email_show']=true;
							$result['email']=$iqr['email'];
							if($iqr['email_name'] != '')
								$result['email_name']=$iqr['email_name'];
							else
								$result['email_name']='寫信寄到我的電子信箱';
						}
						else
						{
							$result['email_show']=false;
						}
						// skype
						if($iqr['skype'] != '')
						{
							$result['skype_show']=true;
							$result['skype']=$iqr['skype'];
							if($iqr['skype_name'] != '')
								$result['skype_name']=$iqr['skype_name'];
							else
								$result['skype_name']='Skype通話';
						}
						else
						{
							$result['skype_show']=false;
						}
						// facebook
						if($iqr['facebook'] != '')
						{
							$result['facebook_show']=true;
							$result['facebook']=$iqr['facebook'];
							if($iqr['facebook_name'] != '')
								$result['facebook_name']=$iqr['facebook_name'];
							else
								$result['facebook_name']='我的Facebook';
						}
						else
						{
							$result['facebook_show']=false;
						}
						// line
						if($iqr['line'] != '')
						{
							$result['line_show']=true;
							$result['line']=$iqr['line'];
							if($iqr['line_name'] != '')
								$result['line_name']=$iqr['line_name'];
							else
								$result['line_name']='加入我的Line為好友';
						}
						else
						{
							$result['line_show']=false;
						}
						// cpn_phone
						if($iqr['cpn_phone'] != '')
						{
							$result['cpn_phone_show']=true;
							$result['cpn_phone']=$iqr['cpn_phone'];
							if($iqr['cpn_phone_name'] != '')
								$result['cpn_phone_name']=$iqr['cpn_phone_name'];
							else
								$result['cpn_phone_name']='公司電話';
							if($iqr['cpn_extension'] != '')
								$result['cpn_extension']=','.$iqr['cpn_extension'];
							else
								$data['cpn_extension']='';
						}
						else
						{
							$result['cpn_phone_show']=false;
						}
						//cpn_cfax
						if($iqr['cpn_cfax'] != '')
						{
							$result['cpn_cfax_show'] = true;
							$result['cpn_cfax'] = $iqr['cpn_cfax'];
							if($iqr['cpn_fax_name'] != '')
								$result['cpn_fax_name'] = $iqr['cpn_fax_name'];
							else
								$result['cpn_fax_name'] = '傳真電話';
						}
						else
						{
							$result['cpn_cfax_show'] = false;
						}
						//cpn_number
						if($iqr['cpn_number'] != '')
						{
							$result['cpn_number_show']=true;
							$result['cpn_number']=$iqr['cpn_number'];
							if($iqr['cpn_number_name'] != '')
								$result['cpn_number_name']=$iqr['cpn_number_name'];
							else
								$result['cpn_number_name']='顯示我的統編';
						}
						else
						{
							$result['cpn_number_show']=false;
						}
						// Qrcode
						$web_btn     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
						$contact_btn = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
						$app_btn     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));
						
						
						// 網頁
						if($web_btn['qrcode_btn'])
						{
							$result['web_btn_show'] = true; 
							$result['web_btn_name'] = ($iqr['iqr_qrcode_web'] != '') ? $iqr['iqr_qrcode_web'] : '行動商務系統 網頁';
							$result['web_url'] = base_url() . "business/view_qrcode/" . $member["member_id"] . "/0";
						}
						else
							$result['web_btn_show'] = false; 

						// 通訊錄
						if(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != ''))
						{
							$result['mecard_show']=true;
							$result['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') ? $iqr['iqr_qrcode_contact'] : '通訊錄';
							$result['mecard_url'] = base_url() . "business/view_qrcode/" . $member["member_id"] . "/1";
						
						}
						else
							$result['mecard_show']=false;
						// App
						if($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn'])
						{
							$result['app_btn_show'] = true;
							$result['app_btn_name'] = ($iqr['iqr_qrcode_app'] != '') ? $iqr['iqr_qrcode_app'] : '行動商務系統 APP';
							$result['app_url'] = base_url() . "business/view_qrcode/" . $member["member_id"] . "/2";
						}
						else
							$result['app_btn_show'] = false;

					// 附件下載 exfile
						if($iqr['exfile'] != '')
						{
							$temp_exfile = $this -> get_serialstr($iqr['exfile'], '*#');
							foreach($temp_exfile as $key => $value)
							{
								$doc = $this -> mod_business -> select_from('documents', array('doc_id' => $value));
								if(!empty($doc))
								{
									$result['doc_path'][] = $this -> mod_business -> get_doc_path($value);
									if($doc['doc_name'] != '')
										$result['doc_name'][] = $doc['doc_name'];
									else
										$result['doc_name'][] = '附件'.($key+1);
								}
							}
							$result['exfile_show'] = true;
						}
						else
							$result['exfile_show'] = false;
					// 網站 website
						if($iqr['website'] != '')
						{
							$temp_website = $this -> get_serialstr($iqr['website'], '*#');
							foreach($temp_website as $key => $value)
							{
								$str_website = $this -> mod_business -> select_from('strings', array('str_id' => $value, 'type' => 1));
								if(!empty($str_website))
								{
									$result['website'][] = $str_website['str'];
									if($str_website['str_name'] != '')
										$result['website_name'][] = $str_website['str_name'];
									else
										$result['website_name'][] = '網站'.($key+1);
								}
							}
							$result['website_show'] = true;
						}
						else
							$result['website_show'] = false;
					// 影片 ytb_link
						if($iqr['ytb_link'] != '')
						{
							$temp_ytb_link = $this -> get_serialstr($iqr['ytb_link'], '*#');
							foreach($temp_ytb_link as $key => $value)
							{
								$str_ytb_link = $this -> mod_business -> select_from('strings', array('str_id' => $value, 'type' => 0));
								if(!empty($str_ytb_link))
								{
									$result['ytb_link'][] = $str_ytb_link['str'];
									if($str_ytb_link['str_name'] != '')
										$result['ytb_link_name'][] = $str_ytb_link['str_name'];
									else
										$result['ytb_link_name'][] = '影片'.($key+1);
								}
							}
							$result['ytb_link_show'] = true;
						}
						else
							$result['ytb_link_show'] = false;
					// 編輯器 iqr_html | off
						if($iqr['iqr_html'] != '')
						{
							$temp_iqr_html = $this -> get_serialstr($iqr['iqr_html'], '*#');
							foreach($temp_iqr_html as $key => $value)
							{
								$iqr_html = $this -> mod_business -> select_from('iqr_html', array('html_id' => $value, 'member_id' => $iqr['member_id']));
								if(!empty($iqr_html))
								{
									$result['html_content'][] = $iqr_html['html_content'];
									if($iqr_html['html_name'] != '')
										$result['html_name'][] = $iqr_html['html_name'];
									else
										$result['html_name'][] = '網頁'.($key+1);
								}
							}
							$result['html_show'] = true;
						}
						else
							$result['html_show'] = false;
					// 報名表單 uform
						if($iqr['uform'] != '')
						{
							$temp_uform = $this -> get_serialstr($iqr['uform'], '*#');
							foreach($temp_uform as $key => $value)
							{
								$uform = $this -> mod_business -> select_from('uform', array('ufm_id' => $value, 'member_id' => $iqr['member_id']));
								if(!empty($uform) && $uform['ufm_status'] != 0)
								{
									$result['uform_url'][] = base_url() . "form/index/" . $uform['ufm_id'] . "/" . $iqr["member_id"];
									if($uform['uform_name'] != '')
										$result['ufm_name'][] = $uform['ufm_name'];
									else
										$result['ufm_name'][] = '表單'.($key+1);
								}
							}
							$result['uform_show'] = true;
						}
						else
							$result['uform_show'] = false;
					// ecoupon
						if($iqr['ecoupon'] != '')
		                {
		                    $result['ecp_show'] = true;
		                    $ecp_id = $this -> get_serialstr($iqr['ecoupon'], '*#');
		                    foreach($ecp_id as $key => $value)
		                    {
		                        $ecp = $this -> mod_business -> select_from('ecoupon', array('ecp_id' => $value));
		                        $result['ecp_url_name'][$key] = $ecp['name'];
		                        $result['ecp_content'][$key]  = $ecp['content'];
		                        $result['ecp_btn_name'][$key] = $ecp['btn_name'];
		                        // image data uri
		                        $ecp_img_path = $member['img_url'] .'coupon/'. $ecp['filename'];
		                        $result['ecp_img'][$key] = $ecp_img_path;

		                        // share mode
		                        switch ($ecp['mode']) {
		                        	case 1:
				                        $result['ecp_url'][$key] = $ecp['mode_1'];
		                        		break;
		                        	case 2:
				                        $result['ecp_url'][$key] = $ecp['mode_2'];
		                        		break;
		                        	case 3:
				                        $result['ecp_url'][$key] = base_url().'business/ecoupon_editor/'.$member['member_id'].'/'.$ecp['ecp_id'];
		                        		break;
		                        }
		                    }
		                }
		                else
		                {
		                    $result['ecp_show'] = false;
		                }
					$result = array($result);
					break;
			}
		}
		else
		{
			$result = array(
				'Error'
			);
		}
		echo json_encode($result);
	}

	private function auth_member($member_id)
	{
		$member = $this -> mod_business -> select_from('member', array('member_id' => $member_id));
		$auth01_m = $this -> mod_business -> select_from('member', array('auth' => 01, 'domain_id' => $member['domain_id']));
		$auth_member = $auth01_m['member_id'];
		return $auth_member;
	}

	// Theme = 2, 資料庫
	public function news()
	{
		$cid = $this -> input -> get('cid');
		$member_id = $this -> input -> get('member_id');
		
		$auth_member = $this -> auth_member($member_id);
		if($cid == "")
			$iqr_html= $this -> mod_business -> select_from_order('iqr_html', 'html_id', 'desc', array('member_id' => $auth_member));
		else
			$iqr_html= $this -> mod_business -> select_from_order('iqr_html', 'html_id', 'desc', array('member_id' => $auth_member, 'classify_id' => $cid));

		foreach ($iqr_html as $key => $value)
		{
			$iqr_classify = $this -> mod_business -> select_from('iqr_classify', array('classify_id' => $value['classify_id']));
			$result[] = array(
				'html_name' 	=> $value['html_name'],
				'html_content'  => $value['html_content'],
				'classify_name' => $value['classify_name'],
				'classify_id' 	=> $value['classify_id'],
				'html_id' 		=> $value['html_id'],
			);
			// $result['html_name'][]    = $value['html_name'];
			// $result['html_content'][] = $value['html_content'];
			// $result['classify_name'][] = $iqr_classify['classify_name'];
			// $result['classify_id'][]  = $value['classify_id']; 
			// $result['html_id'][]  = $value['html_id']; 
		}
		// $reuslt = array($result);
		echo json_encode($result);
	}

	// theme = 2, 影片
	public function film()
	{
		$cid = $this -> input -> get('cid');
		$member_id = $this -> input -> get('member_id');

		$auth_member = $this -> auth_member($member_id);
		if($cid == "")
			$film_str= $this -> mod_business -> select_from_order('strings', 'str_id', 'desc', array('member_id' => $auth_member, 'type' => 0));
		else
			$film_str= $this -> mod_business -> select_from_order('strings', 'str_id', 'desc', array('member_id' => $auth_member, 'cid' => $cid, 'type' => 0));

		foreach ($film_str as $key => $value)
		{
			$strings_category = $this -> mod_business -> select_from('strings_category', array('cid' => $value['cid'],'type' => 'ytb_link'));
			$result[] = array(
				'film_name'		=> $value['str_name'],
				'film_content'	=> $value['str'],
				'classify_name'	=> $strings_category['name'],
				'cid'			=> $value['cid'],
				'film_id'		=> $value['str_id']
			);
			// $result['film_name'][]    = $value['str_name'];
			// $result['film_content'][] = $value['str'];
			// $result['classify_name'][] = $strings_category['name'];
			// $result['cid'][]  = $value['cid']; 
			// $result['film_id'][]  = $value['str_id']; 
		}
		// $reuslt = array($result);
		echo json_encode($result);
	}

	public function picture()
	{
		$member_id = $this -> input -> get('member_id');
		$auth_member = $this -> auth_member($member_id);
		$photo_array = $this -> mod_business -> select_from_order('photo_category', 'd_id', 'desc', array('d_member_id' => $auth_member, 'd_enable' => 'Y'));

		foreach ($photo_array as $key => $value)
		{
			if(!empty($value['d_photo']))
			{
				$d_photo_img = $this -> get_serialstr($value['d_photo'], '*#');
				$image = $this -> mod_business -> select_from('images', array('img_id' => $d_photo_img[0]));
				$result[] = array(
					'f_img'			=> substr($image['img_path'], 1),
					'photo_id'		=> $value['d_id'],
					'photo_name'	=> $value['d_name'],
				);
				// $result['f_img'][] = substr($image['img_path'], 1);
				// $result['photo_id'][] = $value['d_id'];
				// $result['photo_name'][] = $value['d_name'];
			}
		}
		// $result = array($result);
		echo json_encode($result);
	}

	public function pic_info()
	{
		$d_id  = $this -> input -> get('d_id');
		$member_id = $this -> input -> get('member_id');
		if(!empty($d_id))
		{
			$auth_member = $this -> auth_member($member_id);
			$photo = $this -> mod_business -> select_from('photo_category', array('d_member_id' => $auth_member, 'd_enable' => 'Y', 'd_id' => $d_id));
			$photo_array = $this -> get_serialstr($photo['d_photo'], '*#');
			foreach ($photo_array as $key => $value)
			{
				$image = $this -> mod_business -> select_from('images', array('img_id' => $value));
				$result[] = array(
					'image_path'	=> substr($image['img_path'], 1),
					'image_note'	=> $image['img_note'],
				);
				// $result['image_path'][] = substr($image['img_path'], 1);
				// $result['image_note'][] = $image['img_note'];
			}
			// $result = array($result);
		}
		else
			$result = array('Error');
		echo json_encode($result);
	}
}

