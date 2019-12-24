<?php
require_once('./application/core/MY_Sql.php');
class Webconfig_model extends MY_Sql
{
	
	function __construct()
	{
		$this -> load -> database();
	}

	public function config($uri)
	{
		$uri_array = $this -> uri -> segment_array();
		$setting = $this -> select_from('language_pack', array($this -> set_language. ' AS title'), array('d_id' => '468'), 'row');
		if ($uri_array[1] == 'views')
		{
			switch ($uri_array[4]) {
				#公司坑
				case '1':
				case '2':
				case '3':
				case '10':
					$where_124 = array('uri_1' => $uri_array[1], 'uri_2' => $uri_array[2], 'uri_4' => $uri_array[4]);
					$web_config = $this -> select_from('language', array($this -> set_language .' AS middle'), array('uri' => 1));
					if ($uri_array[4] != 1)
					{
						$front = $this -> select_from('language', array($this -> set_language .' AS front'), array('uri' => $uri_array[4]));
						foreach ($front as $key => $value) {
							$web_config['front'] = $value;
						}
					}
					if (!empty($uri_array[6]) && $uri_array[4] != 10)
					{
						$ckeditor = $this -> select_from('ckeditor', array('name'), array('ck_id' => $uri_array[6], 'type' => $uri_array[4]));
						$iqr_name = $ckeditor['name'];
					}
					elseif (!empty($uri_array[6]))
					{
						$reviews = $this -> select_from('reviews', array('d_title'), array('d_id' => $uri_array[6]));
						$iqr_name = $reviews['d_title'];
					}
					else
						$iqr_name = $this -> name($uri_array[3]);
					$iqr_name .=$this -> str_prev( $web_config['front']);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;
				# 分類頁
				case 'C':
					$where = (!empty($uri_array[5])) ? '/'.$uri_array[4].'/'.$uri_array[5] : '/'.$uri_array[4];
					$web_config = $this -> select_from('language', array($this -> set_language .' AS middle'), array('uri' => $where));
					$iqr_name = $this -> name($uri_array[3]);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;
				case '4': # 影片內頁
				case '7': # 表單內頁
				case '9': # 分享券內頁
					$category = $this -> select_from('auth_category', array('c_name'), array('category_id' => $uri_array[5], 'lang_type' => $this->set_language));
					if ($uri_array[4] == 7)
					{
						$uform = $this -> select_from('uform', array('ufm_name'), array('ufm_id' => $uri_array[6]));
						$iqr_name = $uform['ufm_name'];
						$web_config = $this -> select_from('language', array($this -> set_language . ' AS middle'), array('uri' => '/C/enroll'));
					}
					else if ($uri_array[4] == 9)
					{
						$ecoupon = $this -> select_from('ecoupon', array('name'), array('ecp_id' => $uri_array[6]));
						$iqr_name = $ecoupon['name'];
						$web_config = $this -> select_from('language', array($this -> set_language . ' AS middle'), array('uri' => '/C/share'));
					}
					elseif ($uri_array[4] == 4)
					{
						$ckeditor = $this -> select_from('ckeditor', array('name'), array('ck_id' => $uri_array[6], 'type' => $uri_array[4]));
						$iqr_name = $ckeditor['name'];
						$web_config = $this -> select_from('language', array($this -> set_language . ' AS middle'), array('uri' => '/C/video'));
					}
					$iqr_name .= $this -> str_prev($category['c_name']);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;
				# 影片分類
				case 'video':
				case 'enroll':
				case 'annex':
				case 'link':
				case 'share':
					$web_config = $this -> select_from_like('language', array($this -> set_language .' AS middle'), array('uri' => $uri_array[4]), 'row');
					$category = $this -> select_from('auth_category', array('c_name'), array('category_id' => $uri_array[5], 'lang_type' => $this->set_language));
					if ($uri_array[4] == 'video')
					{
						$ckeditor = $this -> select_from('ckeditor', array('name'), array('ck_id' => $uri_array[6], 'type' => $uri_array[4]));
						$iqr_name = $ckeditor['name'];
					}
					$iqr_name = $this -> name($uri_array[3]);
					$iqr_name .= $this -> str_prev($category['c_name']);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;
				# 相本
				case 'photo':
					$web_config = $this -> select_from_like('language', array($this -> set_language .' AS middle'), array('uri' => $uri_array[4]), 'row');
					$category = $this -> select_from('photo_category', array('d_name'), array('d_id' => $uri_array[5]));
					$iqr_name = $category['d_name'];
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;
			}
		}
		else
		{
			switch ($uri_array[2]) {
				case 'iqr':
				case 'index':
				case 'contact':
				case 'login':
				case 'member_list':
				case 'member_info':
				case 'bonus_list':
				case 'dividend':
				case 'contribute':
				case 'announce':
				case 'register':
				case 'forgot':
				case 'policies': #
				case 'upgrade':
				case 'talklist':
				case 'talkapp':
					if ($uri_array[2] == 'talkapp' || $uri_array[2] == 'talklist')
						$web_config = $this -> select_from_like('language_pack', array($this -> set_language .' AS front'), array('uri' => '/gold/talkapp', 'd_is_title' => '1'));
					elseif ($uri_array[2] =='policies' && $uri_array[3] == '')
						$web_config = $this -> select_from_like('language_pack', array($this -> set_language .' AS front'), array('uri' => '/gold/policies', 'd_is_title' => '1'));
					elseif ($uri_array[2] =='policies' && $uri_array[3] != '')
						$web_config = $this -> select_from('config', array('d_title AS front'), array('lang_type' => $this -> set_language, 'd_type' => $uri_array[3]));
					else
						$web_config = $this -> select_from_like('language_pack', array($this -> set_language .' AS front'), array('uri' => $uri_array[2], 'd_is_title' => '1'));

					if ($uri_array[2] == 'member_list')
						$middle = $this -> select_from('language_pack', array($this -> set_language .' AS middle'), array('d_id' => '2'));
					else
						$middle = $this -> select_from('language_pack', array($this -> set_language .' AS middle'), array('d_id' => '82'));

					foreach ($web_config as $key => $value) {
						$web_config['middle'] = $middle['middle'];
					}
					if ($uri_array[3] != '' and $uri_array[2] != 'policies')
						$iqr_name = $this -> name($uri_array[3]);
					else
					{
						@session_start();
						$iqr_name = ($uri_array[2] =='policies' || $uri_array[2] == 'index' || $uri_array[2] =='login'|| $uri_array[2] =='register'|| $uri_array[2] =='forgot') ? $this -> name($_SESSION['AT']['account']) : $this -> name($_SESSION['MT']['name']);
						@session_write_close();
					}
					$iqr_name .= (!empty($web_config['front'])) ? $this -> str_prev($web_config['front']) : '';
					$iqr_name .= (!empty($web_config['middle'])) ? $this -> str_prev($web_config['middle']) : '';
					$iqr_name .= $this -> str_prev($setting['title']);
					break;

				case 'ecoupon_editor':
					$web_config = $this -> select_from('language', array($this -> set_language. ' AS middle'), array('uri' => '/C/share'));
					$iqr_name = $this -> id_getter_name($uri_array[3]);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;

				case 'order_list':
				case 'order_info':
				case 'buy_info':
					$where = '/'. $uri_array[1] .'/'.$uri_array[2];
					$web_config = $this -> select_from('language_pack', array($this -> set_language .' AS front'), array('uri' => $where), 'row');
					$middle = $this -> select_from('language_pack', array($this -> set_language .' AS middle'), array('d_id' => '82'));
					foreach ($web_config as $key => $value) {
						$web_config['middle'] = $middle['middle'];
					}
					@session_start();
					$iqr_name = ($uri_array[2] == 'index' || $uri_array[2] =='login') ? $this -> name($_SESSION['AT']['account']) : $this -> name($_SESSION['MT']['name']);
					@session_write_close();
					$iqr_name .= $this -> str_prev($web_config['front']);
					$iqr_name .= $this -> str_prev($web_config['middle']) . $this -> str_prev($setting['title']);
					break;

				case 'view_qrcode':
					$qrc_style = $this -> select_from('qrc_style', array('label'), array('member_id' => $uri_array[3], 'type' => $uri_array[4]));
					if ($uri_array[3] != '')
						$iqr_name = $this -> id_getter_name($uri_array[3]);
					else
					{
						@session_start();
						$iqr_name = ($uri_array[2] == 'index' || $uri_array[2] =='login') ? $this -> name($_SESSION['AT']['account']) : $this -> name($_SESSION['MT']['name']);
						@session_write_close();
					}
					$iqr_name .= (!empty($qrc_style['label'])) ? $this -> str_prev($qrc_style['label']) : $this -> str_prev();
					$iqr_name .= $this -> str_prev($setting['title']);
					break;
			}
		}

		return $iqr_name;
	}

	private function str_prev($str = '')
	{
		return ' - ' . $str;
	}

	private function id_getter_name($member_id)
	{
		$iqr = $this -> inner_join('member', 'iqr', array('iqr.l_name', 'iqr.f_name', 'member.account'), array('member.member_id' => $member_id), 'member_id', 'row');
		$iqr_name = (!empty($iqr['l_name'] . $iqr['f_name'])) ? $iqr['l_name'] . $iqr['f_name'] : $account;
		return $iqr_name;
	}

	private function name($account)
	{
		$iqr = $this -> inner_join('member', 'iqr', array('iqr.l_name', 'iqr.f_name', 'member.account'), array('member.account' => $account), 'member_id', 'row');
		$iqr_name = (!empty($iqr['l_name'] . $iqr['f_name'])) ? $iqr['l_name'] . $iqr['f_name'] : $account;
		return $iqr_name;
	}

	private function select_from_like($table, $select_characters = array(), $characters_like = array(), $data_type = '')
	{
		if (!empty($select_characters) && !empty($characters_like))
		{
			$this -> db -> select($select_characters);
			$this -> db -> like($characters_like); 
			$query = $this -> db -> get($table);
		}
		elseif (empty($select_characters) && !empty($characters_like))
		{
			$this -> db -> like($characters_like); 
			$query = $this -> db -> get($table);
		}

		switch ($data_type) {
			case 'row':
				return $query -> row_array();
				break;
			case 'array':
				return $query -> result_array();
				break;
			default:
				return $query -> row_array();
				break;
		}
	}

	private function str_cutting($string, $find, $plus_str)
	{
		$pos = strpos($string, $find);
		$string = substr($string, 0, $pos + $plus_str);
		return $string;
	}
}