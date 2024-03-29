<?php
require_once('./application/core/MY_Sql.php');
class Views_model extends MY_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function category_list_first()
	{
		$data['list_news'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '2', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		$data['list_video'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '4', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		$data['list_link'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '5', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		$data['list_annex'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '6', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		$data['list_enroll'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '7', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		$data['list_photo'] = $this -> select_from_order_limit('photo_category', array('d_id as id', 'd_name as name', 'd_photo'), array('d_enable' => 'Y', 'd_photo <>' => '', 'lang_type' => $this->set_language), 'd_sort, d_updatetime', 'ASC');
		$data['list_share'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '9', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
		return $data;
	}

	public function category_list($element)
	{
		$data['filename'] = 'list';
		$data['element'] = $element;
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('17', $this -> set_language);
		switch ($element) {
			case 'news':
				$data['title'] = $lang['News'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '2', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break;
			case 'video':
				$data['title'] = $lang['Video'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '4', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break;
			case 'link':
				$data['title'] = $lang['Hyperlink'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '5', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break;
			case 'annex':
				$data['title'] = $lang['Exfile'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '6', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break;
			case 'enroll':
				$data['title'] = $lang['EventAndRegistration'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '7', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break;
			case 'photo':
				$data['title'] = $lang['CompanyGallery'];
				$data['list'] = $this -> select_from_order_limit('photo_category', array('d_id as id', 'd_name as name', 'd_photo'), array('d_enable' => 'Y', 'd_photo <>' => '', 'lang_type' => $this->set_language), 'd_sort, d_updatetime', 'ASC');
				foreach ($data['list'] as $key => $value)
				{
					$images_array = $this -> get_serialstr($value['d_photo'], '*#');
					$images = $this -> select_from('images', array('img_path'), array('img_id' => $images_array[0]), 'row');
					$data['list'][$key]['first_img'] = substr($images['img_path'], 1);
				}
				$data['filename'] = 'i-photo2';
				break;
			case 'share':
				$data['title'] = $lang['FDCoupon'];
				$data['list'] = $this -> select_from_order_limit('auth_category', array('category_id as id', 'c_name as name', 'sort'), array('type' => '9', 'lang_type' => $this -> set_language), 'sort, update_time', 'ASC');
				break; 
			default:
				$data = $this -> mod_language -> converter('1', $this -> set_language);
				$data['title'] = $lang['MessageCenter'];
				$data['filename'] = 'mix';
				break;
		}
		return $data;
	}

	public function category_and_detail($data = array(), $path, $category_id, $id = '')
	{
		if($id == '')
		{	
			$data['category_id'] = $category_id;
			$this -> load -> model('language_model', 'mod_language');
			$lang = $this -> mod_language -> converter('17', $this -> set_language);
			
			switch ($data['category_type']) {
				case '1':
					$data['title'] = $lang['AboutGoldenbiotechTitle'];
					$data['element'] = '1';
					$data['list'] = $this -> select_from_order_limit('ckeditor', array('name', 'ck_id as did'), array('type' => $data['category_type'], 'enable' => '1', 'lang_type' => $this -> set_language), 'sort, ck_id', 'asc');
					$path .= 'i-article2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 最新消息
				case '2':			
					$data['title'] = $lang['NewsInformation'];
					$data['element'] = '2';
					$data['list'] = $this -> select_from_order_limit('ckeditor', array('name', 'ck_id as did'), array('type' => $data['category_type'], 'enable' => '1', 'lang_type' => $this -> set_language), 'sort, ck_id', 'asc');
					$path .= 'i-article2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 衛教資訊
				case '3':
					$data['title'] = $lang['HEDUInformation'];
					$data['element'] = '3';
					$data['list'] = $this -> select_from_order_limit('ckeditor', array('name', 'ck_id as did'), array('type' => $data['category_type'], 'enable' => '1', 'lang_type' => $this -> set_language), 'sort, ck_id', 'asc');
					$path .= 'i-article2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 影片	
				case '4':			
					$data['list'] = $this -> select_from_order_limit('ckeditor', array('name', 'ck_id as did', 'content'), array('category_id' => $category_id, 'enable' => '1', 'lang_type' => $this -> set_language), 'sort, ck_id', 'asc');
					$path .= 'i-enroll2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 網站
				case '5':			
					$data['list'] = $this -> select_from_order_limit('ckeditor', array('name', 'ck_id as did', 'content'), array('category_id' => $category_id, 'enable' => '1', 'lang_type' => $this -> set_language), 'sort, ck_id', 'asc');
					$path .= 'd-link';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 附件
				case '6':
					$data['list'] = $this -> select_from_order_limit('archive', array('name', 'SUBSTR(path, 2) as path'), array('category_id' => $category_id), 'sort, a_id', 'asc');
					$path .= 'i-annex2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 表單
				case '7':			
					$data['list'] = $this -> select_from_order_limit('uform', array('ufm_name as name', 'ufm_id as did'), array('category_id' => $category_id), 'sort, ufm_id', 'asc');
					$path .= 'i-enroll2';

					//$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 相本
				case 'photo':			
					$data['photo'] = $this -> select_from('photo_category', array('d_name as name'), array('d_id' => $category_id), 'row');
					$data['list'] = $this -> select_from_order_limit('images', array('SUBSTR(img_path, 2) as img_path', 'img_note'), array('type' => $category_id), 'sort, img_id', 'asc');
					$path .= 'i-photo3';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 好友分享券
				case '9':
					$data['list'] = $this -> inner_join_order_by('ecoupon', 'member', array('ecoupon.name', 'ecoupon.ecp_id', 'ecoupon.filename', 'member.img_url'), array('ecoupon.category_id' => $category_id), 'member_id', 'sort, ecp_id', 'asc');
					$path .= 'i-share';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 心得分享
				case '10':
					$data['title'] = $lang['ReviewsList'];
					$data['element'] = '10';
					$data['list'] = $this -> select_from_order_limit('reviews', array('d_title as name', 'd_id as did'), array('d_status' => '0'), 'update_time', 'desc');
					$path .= 'i-article2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
			}
		}
		else
		{
			switch ($data['category_type']) {
				case '1':
					$data['list'] = $this -> select_from('ckeditor', array('name', 'ck_id as did', 'content'), array('ck_id' => $id));
					$path .= 'i-article3';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 最新消息
				case '2':			
					$data['list'] = $this -> select_from('ckeditor', array('name', 'ck_id as did', 'content'), array('ck_id' => $id));
					//$path .= 'i-article3';
					//$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					$this->load->view('index/news/news_detail', $data);
					break;
				# 服務專區
				case '3':
					$data['list'] = $this -> select_from('ckeditor', array('name', 'ck_id as did', 'content'), array('ck_id' => $id));
					$path .= 'i-article3';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 影片	
				case '4':			
					$data['list'] = $this -> select_from('ckeditor', array('name', 'ck_id as did', 'content'), array('ck_id' => $id));
					$path .= 'i-video3';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 表單
				case '7':			
					$data['list'] = $this -> select_from('uform', array('*'), array('ufm_id' => $id), 'row');
					$data['back'] = $_SERVER['REQUEST_URI'];
					$path .= 'i-enroll3';
					$data['ufm_title'] = $this->get_serialstr($data['list']['ufm_col_name'], "*#");
					if(count($data['ufm_title']) > 3)
					{
						$ufm_content = $this->get_serialstr($data['list']['ufm_col_content'], "*#");
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
						$ufm_required = $this->get_serialstr($data['list']['ufm_col_required'], "*#");
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
					//$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);

					//$uform=$this->mymodel->get_activity_one_data($id);
					//$data['uform']=$uform;

					//view
					$this->load->view('index/activity/activity_detail', $data);
					break;
				# 好友分享券
				case '9':
					$data['list'] = $this -> select_from('ecoupon', array('*'), array('ecp_id' => $id));
					$member = $this -> select_from('member', array('member.img_url'), array('member_id' => $data['list']['member_id']));
					$data['f_path'] = $member['img_url']. 'coupon/';
					
					if ($data['list']['mode'] == '1')
						$data['s_link'] = '/app/route/' .$data['member_id'];
					elseif ($data['list']['mode'] == '2')
						$data['s_link'] = $data['list']['mode_2'];
					else
						$data['s_link'] = '/business/ecoupon_editor/' . $data['member_id'] . '/' . $data['list']['ecp_id'];

					$path .= 'i-share2';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
				# 心得分享
				case '10':
					$data['list'] = $this -> select_from('reviews', array('d_title as name', 'd_id as did', 'd_content as content','d_img'), array('d_id' => $id), 'row');
					$path .= 'i-article3';
					$this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. $path, $data);
					break;
			}
		}
	}

	public function login_session($session_array = array())
	{
		if ($session_array['is_login'] == 1)
			$is_login = $session_array['is_login'];
		else
			$is_login = '';
		@session_write_close();

		return $is_login;
	}

	private function get_serialstr($str, $target)
	{
		$ori_str=$str;

		$pos_s=strpos($str, $target);
		$amount=0;
		$odd=1;
		while(!($pos_s===False))
		{
			$pos_s=strpos($str, $target);
			$temp_str=substr($str, $pos_s+2, strlen($str));
			$pos_e=strpos($temp_str, $target);
			if(!($pos_e===False))
			{
				$print_str=substr($str, $pos_s+2, $pos_s+$pos_e);
				$result_array[]=substr($str, $pos_s+2, $pos_s+$pos_e);
				$amount=$amount+$pos_e+($odd*2);
			}
			else
			{
				$result_array[]=$temp_str;
				break;
			}
			$str=substr($ori_str, $amount, strlen($ori_str));
		};
		if(!empty($result_array))
		{
			foreach($result_array as $key => $value)
			{
				$result_array[$key] = str_replace('+-', $target, $value);
			}
		}
		return $result_array;
	}
}