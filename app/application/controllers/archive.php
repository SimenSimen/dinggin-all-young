<?php
class Archive extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();

		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
		}

		// helper
        $this->load->helper('url');

        // model
		$this -> load -> model('admin_model', 'mod_admin');
		$this -> load -> model('archive_model', 'mod_archive');

        //domain
		if($this->session->userdata('session_domain') != '')
		{
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}
		else
		{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');

		$this -> load -> library('/mylib/useful');
	}

	public function main($type = '')
	{
		switch ($type) {
			case '7':
				$data['type'] = $type = '7';
				$data['btn_name'] = '新增群組';
				$this -> load -> view('/error/index.html', $data);
				break;

			default:
				$this->useful->CheckComp('j_annex');
				$data['type'] = $type = '6';
				$data['btn_name'] = '新增群組';
				$group = $this -> mod_archive -> archive_group_list();
				$data['group'] = $this -> mod_archive -> archive_array_arrange($group);
				$this -> load -> view('/admin/system_center/archive/archive_list', $data);
				break;
		}
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$type = $this -> input -> post('type');

		if(!empty($group_name))
		{
			$category = $this -> mod_archive -> select_from('auth_category', array('c_name'), array('c_name' => $group_name, 'type' => $type, 'lang_type' => $this -> session -> userdata('lang')));

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
				$this -> mod_archive -> insert_into('auth_category', array('c_name' => $group_name, 'type' => $type, 'update_time' => date('Y-m-d H:i:s', time()), 'lang_type' => $this -> session -> userdata('lang')));
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
		$category = $this -> mod_archive -> select_from('auth_category', array('category_id'), array('category_id' => $category_id));

		if(!empty($category))
		{
			$archives = $this -> mod_archive -> select_from('archive', array('a_id'), array('category_id' => $category['category_id']));
			if(!empty($archives))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_archive -> delete_where('auth_category', array('category_id' => $category_id));
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
		if ($data['edit'] = $this -> mod_archive -> stretch($type, $id))
		{

		}
		else
			show_error('錯誤連結', '404', 'Error');
		$this -> load -> view('/admin/system_center/archive/edit', $data);
	}

	public function con_edit()
	{
		$edit_name = $this -> input -> post('edit_name');
		$id = $this -> input -> post('edit_id');
		$enable = $this -> input -> post('file_enable');
		$type = $this -> input -> post('type');

		switch ($type) {
			case 'g':
				$table = 'auth_category';
				$target = array('category_id' => $id);
				$update_data = array('c_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()), 'lang_type' => $this -> session -> userdata('lang'));
				break;

			case 'c':
				$table = 'archive';
				$target = array('a_id' => $id);
				$update_data = array('name' => $edit_name ,'enable' => $enable);
				break;
		}

		if (isset($edit_name) && !empty($edit_name))
		{
			$this -> mod_archive -> update_set($table, $target, $update_data);
			$this -> main(6);
		}
		else
			$this -> edit($type, $id);
	}

	public function sort_save()
	{
		$ck_array = $this -> input -> post('csort');
		$type = $this -> input -> post('type');
		if ($this -> mod_archive -> sort_action('archive', $ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> main();
		}
		else
		{
			$this -> message = '';
			$this -> main();
		}
	}

	public function plupload($group_id)
	{
		$this->useful->CheckComp('j_annex');
		$group_inf = $this -> mod_archive -> select_from('auth_category', array('type', 'category_id'), array('category_id' => $group_id));
		$message = '';
		switch ($group_inf['type']) {
			case '6':
				$mime_types = array('title' => 'Image files', 'extensions' => 'doc,docx,ppt,pptx,xls,xlsx,pdf,txt');
				break;
			case '7':
				$mime_types = array('title' => 'Image files', 'extensions' => 'png,jpg,jpeg');
				break;
			default:
				$message = 'Error';
				break;
		}
		if($message)
			$this -> script_message_close($message);
		$data['category_id'] = $group_inf['category_id'];
		$data['json_mime'] = json_encode($mime_types);

		$this -> load -> view('/admin/system_center/archive/plupload', $data);
	}

	public function upload_file($category_id)
	{
		$category_id = number_format($category_id);
		$category_id = (string) $category_id;
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
		$targetDir = './uploads/000/000/0000/0000000000/exfile';
		// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		//$targetDir = 'uploads';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir, 0777);
		}

		// 副檔名(Ext) 處理
		$excluding = $this -> mod_archive -> extname_excluding($_FILES["file"]["name"]);

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

			$this -> mod_archive -> insert_into('archive', array('name' => $excluding, 'file_name' => $fileName, 'path' => $filePath, 'category_id' => $category_id, 'lang_type' => $this -> session -> userdata('lang')));

		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	public function del_exfile()
	{
		$response_array = array('result', 'message');
		$a_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$archive = $this -> mod_archive -> select_from('archive', array('path'), array('a_id' => $a_id));

		if(!empty($archive))
		{
			if(!unlink($archive['path']))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'fail path';
			}
			else
			{
				$this -> mod_archive -> delete_where('archive', array('a_id' => $a_id));
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
}