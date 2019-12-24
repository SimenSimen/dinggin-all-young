<?php
require_once('./application/core/MY_Sql.php');
class Language_model extends MY_Sql
{
	function __construct()
	{
		parent::__construct();
	}

	public function converter($category, $language)
	{
		$data = array();
		$language_list = $this -> select_from('language', array('column_name', $language), array('category' => $category), 'array');
		foreach ($language_list as $key => $value) {
			$data[$value['column_name']] = $value[$language];
		}
		return $data;
	}

	public function select_bar()
	{
		$this -> db -> select(array('page', 'category'));
		$this -> db -> group_by('category');
		$query = $this -> db -> get('language');
		return $this -> language_category($query -> result_array());
	}

	private function language_category($data)
	{
		foreach ($data as $key => $value)
		{
			switch ($value['category']) {
				case '1':	$data[$key]['category_name'] = 'FE - 訊息中心';			break;
				case '2':	$data[$key]['category_name'] = 'BEV - 個人資訊';		break;
				case '3':	$data[$key]['category_name'] = 'BEC - 個人資訊';		break;
				case '4':	$data[$key]['category_name'] = 'BE - Qrcode樣式';		break;
				case '5':	$data[$key]['category_name'] = 'BE - Qrcode樣式內框';	break;
				case '6':	$data[$key]['category_name'] = 'BE - 管理中心';			break;
				case '7':	$data[$key]['category_name'] = 'BE - 分析報表';			break;
				case '8':	$data[$key]['category_name'] = 'BE - 修改密碼';			break;
				case '9':	$data[$key]['category_name'] = 'BE - APPUI';			break;
				case '10':	$data[$key]['category_name'] = 'BE - 自動打包';			break;
				case '11':	$data[$key]['category_name'] = 'BE - 申請上架';			break;
				case '12':	$data[$key]['category_name'] = 'FE - QRcode顯示頁面';	break;
				case '13':	$data[$key]['category_name'] = 'FE - 個人資訊';			break;
				case '14':	$data[$key]['category_name'] = 'FEC - 登入';			break;
				case '15':	$data[$key]['category_name'] = 'FEV - 登入';			break;
				case '16':	$data[$key]['category_name'] = 'FE - 忘記密碼';			break;
				case '17':	$data[$key]['category_name'] = 'FEV - 標題';			break;
				case '18':	$data[$key]['category_name'] = 'FEV - 好友分享券';		break;
				case '19':	$data[$key]['category_name'] = 'BEV - Qrcode樣式';		break;
				case '996':	$data[$key]['category_name'] = 'FE - WebTitle';			break;
				case '997':	$data[$key]['category_name'] = 'FE - Left12';			break;
				case '998':	$data[$key]['category_name'] = 'FE - Footer12';			break;
				case '999':	$data[$key]['category_name'] = 'BE - Header Nav';		break;
			}
		}
		return $data;
	}
}