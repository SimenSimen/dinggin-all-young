<?php
//----------------------------------------------------------------------------------- 
// make_domain_img_dir 	產生網域資料夾 in /image/web_style_images
// check_extend_name	上傳文件的副檔名判斷
// upload_doc			上傳文件
// shared_data_add 		寫入管理員分享欄位
// shared_data_del 		檢查並刪除DB內分享資料欄位
// unset_member 		刪除DB所有會員相關資料
//----------------------------------------------------------------------------------- 
class Admin_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：make_domain_img_dir
	// 作 用：產生網域資料夾 in /image/web_style_images
	// 參 數：$domain 域名
	// $sub_dir 子資料夾
	// 返回值：無
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	public function make_domain_img_dir($domain, $sub_dir='')
	{
		$dir='./images/web_style_images/'.$domain.'/'.$sub_dir;
		if(!is_dir($dir))
		{
			//創建資料夾
			@mkdir($dir);

			//複製預設圖檔
			$web_style_images = glob('./images/web_style_images/default/'.$sub_dir."{*.jpg,*.png}", GLOB_BRACE);
			foreach($web_style_images as $key => $value)
			{
				$filename=substr($value, (strrpos($value, '/')+1));
				copy($value, $dir.$filename);
			}
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：check_extend_name($c_filename,$a_extend) 
	// 作 用：上傳文件的副檔名判斷 
	// 參 數：$c_filename 上傳的檔案名 
	// $a_extend 要求的副檔名 
	// 返回值：布林值 
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	function check_extend_name($c_filename, $a_extend) 
	{ 
		if(strlen(trim($c_filename)) < 5) 
		{ 
			return 0; //返回0表示沒上傳圖片 
		} 
		
		$lastdot = strrpos($c_filename, "."); //取出.最後出現的位置 
		$extended = substr($c_filename, $lastdot+1); //取出副檔名 

		for($i=0;$i<count($a_extend);$i++) //進行檢測 
		{ 
			if (trim(strtolower($extended)) == trim(strtolower($a_extend[$i]))) //轉換大小寫並檢測 
			{ 
				$flag=1; //加成功標誌 
				$i=count($a_extend); //檢測到了便停止檢測 
			} 
		} 

		if($flag<>1) 
		{ 
			for($j=0;$j<count($a_extend);$j++) //列出允許上傳的副檔名種類 
			{ 
				$alarm .= $a_extend[$j]." "; 
			}
			return -1; //返回-1表示上傳圖片的類型不符 
		} 

		return 1; //返回1表示圖片的類型符合要求 
	} 

	//----------------------------------------------------------------------------------- 
	// 函數名：upload_doc($doc_file) 
	// 作 用：上傳文件
	// 參 數：$doc_file = $_FILES['xxx'] => input 傳入檔案
	// $path 存檔dir路徑
	// 返回值：檔案路徑
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	public function upload_doc($doc_file, $path)
	{
		//允許的副檔名
		$allowedExts = array("pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx");

		//檢查檔名合法
		$chk_file_ext= $this->check_extend_name($doc_file['name'], $allowedExts);

		if($chk_file_ext == 1)
		{
			$lastdot = strrpos($doc_file['name'], "."); //取出.最後出現的位置 
			$extended = substr($doc_file['name'], $lastdot); //取出副檔名 

			/*產生唯一的檔案名稱*/
			$doc_name = md5(uniqid(rand())) . $extended;
			
			move_uploaded_file($doc_file["tmp_name"], $path.$doc_name);
			// chmod($path.$doc_name, 0755);

			$data=array(
				"path"	=>  $path.$doc_name,
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：shared_data_add($member_id) 
	// 作 用：寫入管理員分享欄位
	// 參 數：$member_id 管理員會員id
	// 返回值：無
	// 備 注：先檢查DB是否有重複值，若有先刪除 
	//----------------------------------------------------------------------------------- 
		// public function shared_data_add($member_id)
		// {
		// 	//檢查存在並刪除
		// 	$this->shared_data_del($member_id);

		// 	//新增新的狀態值到iqr_shared
		// 	$item_array=array('facebook', 'ytb_link', 'email', 'cpn_phone', 'cpn_number', 'website', 'address', 'text_edit01', 'text_edit02', 'text_edit03', 'myphoto', 'cpn_photo', 'exfile', 'uform');
		// 	$shr_multi_array=array(0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1);
		// 	foreach($item_array as $key => $value)
		// 	{
		// 		$insert_data=array(
		// 			'shr_item'  => $value,
		// 			'shr_multi'	=> $shr_multi_array[$key],
		// 			'shr_status'=> 0,//預設沒資料時不共享
		// 			'member_id' => $member_id
		// 		);
		// 		$shr_id=$this->insert_into('iqr_shared', $insert_data);
		// 	}

		// }

	//----------------------------------------------------------------------------------- 
	// 函數名：shared_data_del($member_id) 
	// 作 用：檢查並刪除DB內分享資料欄位
	// 參 數：$member_id 會員id
	// 返回值：無
	// 備 注：無
	//----------------------------------------------------------------------------------- 
		// public function shared_data_del($member_id)
		// {
		// 	//檢查DB
		// 	$iqr_shared=$this->select_from('iqr_shared', array('member_id'=>$member_id));
		// 	if(!empty($iqr_shared))
		// 	{
		// 		//刪除
		// 		$this->delete_where('iqr_shared', array('member_id'=>$member_id));
		// 		$this->delete_where('iqr_quoted', array('shr_mid'=>$member_id));
		// 	}
		// }

	//----------------------------------------------------------------------------------- 
	// 函數名：unset_member($member_id) 
	// 作 用：刪除DB所有會員相關資料
	// 參 數：$member_id 會員id
	// 返回值：無
	// 備 注：配合 remove_dir 刪除會員目錄
	//----------------------------------------------------------------------------------- 
	public function unset_member($member_id)
	{
		//刪除會員目錄
		$member 		 = $this->select_from('member', array('member_id'=>$member_id));
		$control_setting = $this->select_from('control_setting', array('domain_id'=>$member['domain_id']));
		$member_auth     = intval($member['auth']);
		$auth_level_num  = intval($control_setting['auth_level_num']);
		$this->remove_dir('.'.substr($member['img_url'], 0, 12), true);

		//刪除會員 member
		$this->delete_where('member', array('member_id'=>$member_id));

		//刪除 iqr
		$iqr=$this->select_from('iqr', array('member_id'=>$member_id));
		$this->delete_where('iqr', array('member_id'=>$member_id));

		//刪除 document and images
		$this->delete_where('images', array('member_id'=>$member_id));
		$this->delete_where('documents', array('member_id'=>$member_id));

		//刪除 share_data or quote_data
		if($auth_level_num > $member_auth)
		{
			$this->delete_where('share_data', array('member_id'=>$member_id));
			$this->delete_where('quote_data', array('parent'=>$member_id));
		}
		else
		{
			$this->delete_where('quote_data', array('member_id'=>$member_id));
		}

		//刪除 iqr_views
		$this->delete_where('iqr_views', array('iqr_id'=>$iqr['iqr_id']));

		//刪除 qrc_image
		$this->delete_where('qrc_image', array('member_id'=>$member_id));

		//刪除 qrc_style
		$this->delete_where('qrc_style', array('member_id'=>$member_id));

		//刪除 購物車 iqr_cart, order, product_class, products, 沒有刪除 buyer, iqr_trans
		$this->delete_where('iqr_cart', array('member_id'=>$member_id));
		$this->delete_where('order', array('card_owner'=>$member_id));
		$this->delete_where('product_class', array('member_id'=>$member_id));
		$this->delete_where('products', array('member_id'=>$member_id));

		//刪除 strings
		$this->delete_where('strings', array('member_id'=>$member_id));

		// 刪除 uform and uform_signup
		$uform=$this->select_from('uform', array('member_id'=>$member_id));
		$this->delete_where('uform', array('member_id'=>$member_id));
		$this->delete_where('uform_signup', array('ufm_id'=>$uform['ufm_id']));
	}
	//刪除資料夾(連同下面的檔案和資料夾)
	public function remove_dir($dir, $del_root_dir)
	{
		if(!$dh = @opendir($dir)) return;

		while (false !== ($obj = readdir($dh)))
		{
			if($obj=='.' || $obj=='..') continue;
			if (!@unlink($dir.'/'.$obj)) $this->remove_dir($dir.'/'.$obj, true);
		}

		if ($del_root_dir)
		{
			closedir($dh);
			@rmdir($dir);
		}
	}

	public function select_from_group_by($limit = '',$lang_type='TW')
	{
		$sql  = 'SELECT products.*, SUM(products_views.page_view) AS view';
		$sql .= ' FROM products LEFT JOIN products_views ON products.prd_id = products_views.prd_id';
		$sql .= ' where lang_type="'.$lang_type.'"';
		$sql .= ' and products.d_enable="Y" group by products.prd_id';
		if(!empty($limit))
			$sql .= $limit;

		return $this -> db -> query($sql) -> result_array();
	}

}
