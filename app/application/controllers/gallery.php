<?php
class Gallery extends MY_Controller
{
	public $message = '';
	public $gallery_path = '/uploads/000/000/0000/0000000000/photo';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('gallery_model', 'mod_gallery');

		$this -> load -> helper('url');
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		$this -> load -> library('/mylib/useful');
	}

	// type
	public function type()
	{
		header("Cache-control: private");
		$data['group'] = $this -> mod_gallery -> select_from_order_limit('photo_type', array('d_id', 'd_name', 'd_content', 'd_enable'), array('lang_type' => $this -> session -> userdata('lang')), 'd_sort', 'asc');		
		$this -> load -> view('admin/system_center/gallery/list_type', $data);
	}

	public function group_type_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');		
		if(!empty($group_name))
		{
			$category = $this -> mod_gallery -> select_from('photo_type', array('d_name'), array('d_name' => $group_name, 'lang_type' => $this -> session -> userdata('lang')));			
			if(in_array($group_name, $category))
			{
				$response = array(
					'recode' => '0001',
					'result' => false,
					'retext' => '分類名稱已存在'
				);
			}else{
				$time = date('Y-m-d H:i:s', time());
				$this -> mod_gallery -> insert_into('photo_type', array('d_name' => $group_name, 'd_createTime' => $time, 'd_sort' => '0', 'd_updateTime' => $time, 'lang_type' => $this -> session -> userdata('lang')));
				$response = array(
					'recode' => '200',
					'result' => true,
					'retext' => '',
				);
			}
		}else{
			$response = array(
				'recode' => '0002',
				'result' => false,
				'retext' => '分類名稱不可為空白'
			);
		}
		echo json_encode($response);
	}

	public function del_group_type()
	{
		$response_array = array('result', 'message');
		$category_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$category = $this -> mod_gallery -> select_from('photo_category', array('d_id'), array('d_type' => $category_id));		
		
		if(!empty($category['d_id']))
		{
			$response_array['result'] = false;
			$response_array['message'] = '分類內還有相簿，不能刪除';
		}else{
			$this -> mod_gallery -> delete_where('photo_type', array('d_id' => $category_id));
				$response_array['result'] = true;
				$response_array['message'] = 'Success';
		}
		echo json_encode($response_array);
	}


	public function sort_type_save()
	{
		// 權限判斷
		// $this->useful->CheckComp('j_member');

		$ck_array = $this -> input -> post('csort');
		if ($this -> mod_gallery -> sort_action('photo_type', $ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> type();
		}
		else
		{
			$this -> message = '';
			$this -> type();
		}
	}

	/*開始相簿模組*/

	// detail images yet
	public function main($id=0)
	{
		header("Cache-control: private");
		$group = $this -> mod_gallery -> select_from_order_limit('photo_category', array('d_id', 'd_name', 'd_photo', 'd_enable'), array('lang_type' => $this -> session -> userdata('lang'), 'd_type' => $id), 'd_sort', 'asc');

		$photo_type= $this->mymodel->OneSearchSql('photo_type','d_name',array('d_id'=>$id));
		$data['photo_name']= $photo_type['d_name'];
		
		foreach ($group as $key => $value) {
			$group[$key]['photo_array'] = $this -> mod_gallery -> select_from_order_limit('images', array('img_id', 'SUBSTR(img_path,2) AS img_path', 'type'), array('type' => $value['d_id']), 'sort', 'asc');
		}
		
		$data['img_info']=$this->mod_gallery->pic_status('images');
		foreach($data['img_info'] as $key => $value){
			$data['img_info'][$key]['img_path'] = substr($data['img_info'][$key]['img_path'],1);
		}
		
		$data['group'] = $group;
		$data['id']    = $id;

		$this -> load -> view('admin/system_center/gallery/list', $data);
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$d_type = $this -> input -> post('d_type');
		
		if(!empty($group_name))
		{
			$category = $this -> mod_gallery -> select_from('photo_category', array('d_name'), array('d_name' => $group_name, 'lang_type' => $this -> session -> userdata('lang')));
			
			if(in_array($group_name, $category))
			{
				$response = array(
					'recode' => '0001',
					'result' => false,
					'retext' => '群組名稱已存在'
				);
			}
			else
			{
				$time = date('Y-m-d H:i:s', time());
				$this -> mod_gallery -> insert_into('photo_category', array('d_name' => $group_name, 'd_type' => $d_type, 'd_createTime' => $time, 'd_updateTime' => $time, 'd_member_id' => 0, 'lang_type' => $this -> session -> userdata('lang')));
				$response = array(
					'recode' => '200',
					'result' => true,
					'retext' => '',
				);
			}
		}
		else
		{
			$response = array(
				'recode' => '0002',
				'result' => false,
				'retext' => '群組名不可為空白'
			);
		}
		echo json_encode($response);
	}

	public function del_group()
	{
		$response_array = array('result', 'message');
		$category_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$category = $this -> mod_gallery -> select_from('photo_category', array('d_id', 'd_photo'), array('d_id' => $category_id));
		
		if(!empty($category))
		{
			if(!empty($category['d_photo']))
			{
				$response_array['result'] = false;
				$response_array['message'] = '相簿內還有檔案，不能刪除';
			}
			else
			{
				$this -> mod_gallery -> delete_where('photo_category', array('d_id' => $category_id));
				$response_array['result'] = true;
				$response_array['message'] = 'Success';
			}
		}
		else
		{
			$response_array['result'] = false;
			$response_array['message'] = 'Error';
		}

		echo json_encode($response_array);
	}

	public function edit($type, $id)
	{
		$data['type'] = $type;
		if ($data['edit'] = $this -> mod_gallery -> stretch($type, $id))
		{
			$data['d_video_name']=$this->String_Array($data['edit']['d_video_name']);
			$data['d_video_link']=$this->String_Array($data['edit']['d_video_link']);
		}
		else
			show_error('錯誤連結', '404', 'Error');
		$this -> load -> view('/admin/system_center/gallery/edit', $data);
	}

	public function con_edit()
	{
		$edit_name = $this -> input -> post('edit_name');
		$d_enable  = $this -> input -> post('d_enable');
		$d_content  = $this -> input -> post('d_content');
		$id = $this -> input -> post('edit_id');
		$type = $this -> input -> post('type');

		switch ($type) {
			case 't':
				$table = 'photo_type';
				$target = array('d_id' => $id);
				$update_data = array('d_name' => $edit_name,'d_content' => $d_content,'d_enable' => $d_enable, 'd_updateTime' => date('Y-m-d H:i:s', time()));
				break;

			case 'g':
				$d_type = $this -> input -> post('d_type');
				$d_video_name  = $this->Array_String($this->input->post('d_video_name'));
				$d_video_link  = $this->Array_String($this->input->post('d_video_link'));
				$table = 'photo_category';
				$target = array('d_id' => $id);
				$update_data = array('d_name' => $edit_name,'d_content' => $d_content,'d_enable' => $d_enable,'d_video_name' => $d_video_name, 'd_video_link' => $d_video_link, 'd_type' => $d_type, 'd_updateTime' => date('Y-m-d H:i:s', time()));
				break;
			
			case 'c':
				$table = 'images';
				$target = array('img_id' => $id);
				$update_data = array('img_note' => $edit_name);
				break;
		}

		if (isset($edit_name) && !empty($edit_name))
		{
			$this -> mod_gallery -> update_set($table, $target, $update_data);
			if($type=='t'){
				$this->type();
			}else{
				$this->main($d_type);
			}
		}else{
			$this -> edit($type, $id);
		}
	}

	public function sort_save($id=0)
	{
		// 權限判斷
		// $this->useful->CheckComp('j_member');		
		$ck_array = $this -> input -> post('csort');
		$pk_array = $this -> input -> post('psort');
		$this -> mod_gallery -> sort_action('photo_category', $pk_array);
		if ($this -> mod_gallery -> sort_action('images', $ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> main($id);
		}
		else
		{
			$this -> message = '';
			$this -> main($id);
		}
	}

	public function plupload($group_id)
	{
		$group_inf = $this -> mod_gallery -> select_from('photo_category', array('d_id'), array('d_id' => $group_id));
		$message = '';
		
		if(!empty($group_inf))
			$mime_types = array('title' => 'Image files', 'extensions' => 'png,jpg,jpeg');
		else
			$message = 'Error';
		
		if($message)
			$this -> script_message_close($message);
		$data['d_id'] = $group_inf['d_id'];
		$data['json_mime'] = json_encode($mime_types);

		$this -> load -> view('/admin/system_center/gallery/plupload', $data);
	}

	public function upload_file($category_id)
	{
		$category_id = number_format($category_id);
		// Make sure file is not cached (as it happens for example on iOS devices)
		// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		// header("Cache-Control: no-store, no-cache, must-revalidate");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");

		/* 
		// Support CORS
		header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}
		*/
		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Settings
		// $member = $this -> mod_gallery -> select_from('member', array('img_url'), array('member_id' => $this -> session -> userdata('member_id')));
		$targetDir = '.' .$this -> gallery_path;
		// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		//$targetDir = 'uploads';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir, 0777);
		}

		// 副檔名(Ext) 處理
		$excluding = $this -> mod_gallery -> extname_excluding($_REQUEST["name"]);

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


		// Remove old temp files	
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}	

		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {	
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);

			$insert_id = $this -> mod_gallery -> insert_into('images', array('member_id' => 0, 'img_path' => $filePath, 'type' => $category_id));
			$time = date('Y-m-d H:i:s', time());
			$photo_category = $this -> mod_gallery -> select_from('photo_category', array('d_photo'), array('d_id' => $category_id));
			$this -> mod_gallery -> update_set('photo_category', array('d_id' => $category_id), array('d_photo' => $photo_category['d_photo'] . '*#' . $insert_id, 'd_updateTime' => $time));
		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	public function del_exfile()
	{
		$response_array = array('result', 'message');
		$img_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$images = $this -> mod_gallery -> select_from('images', array('img_path as path'), array('img_id' => $img_id));
		$images_category = $this -> mod_gallery -> select_from('photo_category', array('d_photo', 'd_id'), array('d_photo like' => '%*#' . $img_id . '%'));
		if(!empty($images) && !empty($images_category))
		{
			if(!unlink($images['path']))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'fail path';
			}
			else
			{
				$this -> mod_gallery -> delete_where('images', array('img_id' => $img_id));
				foreach ($this -> get_serialstr($images_category['d_photo'], '*#') as $key => $value) {
					if ($value != $img_id)
						$re_img_id .= '*#' . $value;
				}
				$this -> mod_gallery -> update_set('photo_category', array('d_id' => $images_category['d_id']), array('d_photo' => $re_img_id));
				$response_array['result'] = true;
				$response_array['message'] = 'Success';
			}
		}
		else
		{
			$response_array['result'] = false;
			$response_array['message'] = 'Error';
		}
		echo json_encode($response_array);
	}

	//相片公開
	public function img_opening(){
		$img_id = $this -> input -> post('id');
		
		//先檢查狀態
		$img = $this->mod_gallery->select_from('images', array('img_path','enable'), array('img_id' => $img_id), 'row');
		
		//如果狀態是隱藏的 改成公開
		if($img['enable'] == 0 ){
			$this -> mod_gallery -> update_set('images', array('img_id' => $img_id), array('enable' => '1') );
			$respon['img_id'] = $img_id;
			$respon['img_path'] = substr($img['img_path'],1);
			$respon['enable'] = 'new';
		}else{
			$respon['enable'] = 'exist';
		}
		
		echo json_encode($respon);
	}
	
	//相片隱藏
	public function img_close(){
		$img_id = $this -> input -> post('id');
		$result = $this -> mod_gallery -> update_set('images', array('img_id' => $img_id), array('enable' => '0') );
		echo json_encode($result);
	}

	//陣列轉字串
	private function Array_String($array,$sub='*#'){
		$str = '';
		if(!empty($array))
		{
			foreach ($array as $dvalue) {
				$str.=$sub.$dvalue;
			}
		}
		return $str;
	}
	//字串轉陣列
	private function String_Array($String,$sub='*#'){
		$str=explode($sub,$String);
		array_shift($str);
		return $str;
	}
}