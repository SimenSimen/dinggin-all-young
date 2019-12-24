<?php

class Providers extends MY_Controller
{
	public $web_title;
	public $set_language;

    public function __construct()
    {
        parent::__construct();

        // load library
		$this->load->library(['mylib/useful', 'encrypt']);
		
		// load model
		$this->load->model('provider_model', 'providerModel');
		$this->load->model('language_model', 'mod_language');
		$this->load->model('commits_model', 'commitModel');
		$this->load->model('index_model');

		//helper
		$this->load->helper('url');		
	}
	
	public function index()
	{
		//權限判斷
		$this->useful->CheckComp('j_comlist');

		//資料庫名稱
		$data['dbname'] = $dbname = 'providers';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, '', 20, []);		
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end	

		//檔案名
		$dbdata = $this->mymodel->select_page_form($dbname, $qpage['result'], '*', ['']);
		$data['dbdata'] = $dbdata;
		$data['DataName'] = $this->DataName;

		//view
		$this->load->view('providers/index', $data);
	}

	public function create()
    {
    	if (empty($_SESSION['MT'])) {
			$this->useful->AlertPage('/gold/login', $this->lang_menu['Login']);
		}
		@session_start();

		$this->DataName = 'provider_register';
		$this->lang = $this->lmodel->config('1', $this->setlang);
		$data['path_title'] = '<li><a href="/providers/'.$this->DataName.'"><span>'.$this->lang["$this->DataName"].'</span></a></li>';
		$data['banner'] = '';
		$data['now_at'] = date('Y-m-d H:i:s', strtotime('now'));

		//語言包
		$this->lang = $this->lmodel->config('42', $this->setlang);

        // load view
		$this->load->view('index/header', $data);
		$this->load->view('index/providers/provider_register', $data);
		$this->load->view('index/footer', $data);
	}

	public function store()
	{
		if (empty($_SESSION['MT'])) {
			$this->apiResponse(['status' => 1, 'message' => 'Unauthorized'], 401);
		} else {
			if ($this->providerModel->checkCompanyTaxExists($_POST['tax_id'])) {
				$this->apiResponse([
					'status' => 1,
					'message' => 'tax_id has already exists'
				], 422);
			} else {
				$_POST['passbook'] = 'images/providers/passbooks/'.$_SESSION['MT']['by_id'].'_'.strtotime('now').'.'.pathinfo($_FILES['passbook']['name'], PATHINFO_EXTENSION);
				$_POST['registration_certificate'] = 'images/providers/registration_certificate/'.$_SESSION['MT']['by_id'].'_'.strtotime('now').'.'.pathinfo($_FILES['registration_certificate']['name'], PATHINFO_EXTENSION);
				$_POST['phone'] = $this->encrypt->encode($_POST['phone']);

				$result = $this->providerModel->create($_POST);
				move_uploaded_file($_FILES['passbook']['tmp_name'], $_POST['passbook']);
				move_uploaded_file($_FILES['registration_certificate']['tmp_name'], $_POST['registration_certificate']);

				$message = "親愛的管理員：<br><br>";
				$message .= "您有一則新的供應商申請請求<br><br>";
				$message .= "請至後台進行審核程序";

				// 寄送通知信給後台
				$this->index_model->send_mail('', 'service@supergoods.com.tw', 'service@supergoods.com.tw', '供應商申請通知', $message);

				if ($result) {
					$this->apiResponse(['status' => 0, 'message' => 'success']);
				}
			}
		}
	}

	// 後台編輯供應商
	public function edit($id)
	{	
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		
		$data = $this->providerModel->find($id);
		$data['phone'] = $this->encrypt->decode($data['phone']);
		$this->load->view('providers/edit', $data);
	}

	public function update($id)
	{
		$provider = $this->providerModel->find($id);

		if ($_FILES['passbook']['tmp_name']) {
			$_POST['passbook'] = 'images/providers/passbooks/'.$id.'_'.strtotime('now').'.'.pathinfo($_FILES['passbook']['name'], PATHINFO_EXTENSION);
			move_uploaded_file($_FILES['passbook']['tmp_name'], $_POST['passbook']);
		}
		if ($_FILES['registration_certificate']['tmp_name']) {
			$_POST['registration_certificate'] = 'images/providers/registration_certificate/'.$id.'_'.strtotime('now').'.'.pathinfo($_FILES['registration_certificate']['name'], PATHINFO_EXTENSION);
			move_uploaded_file($_FILES['registration_certificate']['tmp_name'], $_POST['registration_certificate']);
		}

		if ($_POST['is_provider'] == 1 && $provider['is_provider'] != 1) {
			$message = "親愛的".$provider['chinese_name']."：<br><br>";
			$message .= "恭喜您通過資格審查！<br><br>";
			$message .= "您可至<a href='".base_url()."providers/login'>供應商登入頁面</a><br><br>";
			$message .= "進行相關操作<br><br>";

			// 審核通過後 mail通知供應商
			$this->index_model->send_mail('', 'service@supergoods.com.tw', $provider['contact_person_email'], '供應商審核通知', $message);
		}

		$_POST['phone'] = $this->encrypt->encode($_POST['phone']);
		$this->providerModel->update($id, $_POST);

		echo "<script>alert('修改成功');location.href = '/providers/main';</script>";
	}

	// 供應商編輯個人設定頁面
	public function auth_user()
	{
		if (empty($_SESSION['provider'])) {
			$this->useful->AlertPage('/providers/login');
		}

		$data = $this->providerModel->find($_SESSION['provider']['id']);
		$data['phone'] = $this->encrypt->decode($data['phone']);
		$this->load->view('index/providers/edit', $data);
	}

	public function login()
	{
		if (empty($_SESSION['MT'])) {
			$this->useful->AlertPage('/gold/login', $this->lang_menu['Login']);
		} else {
			if (empty($_SESSION['provider'])) {
				@session_start();

				$data = $this->mod_language->converter('15', $this->session->userdata('lang'));
					
				//驗證碼設定
				$len = 5;
				$num = $this->random_vcode($len);
				$this->session->unset_userdata('VCODE');
				
				for ($i = 0; $i < $len; $i++) {
					$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
				}
				
				$s_vcode = $this->encryptCode($this->session->userdata('VCODE'));
				$vode_link = base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
				$data['img'] = '<img id="vcode_img" src="'.$vode_link.'">';
				
				$data['hiddenvcode'] = $s_vcode;
		
				//base_url
				$data['base_url'] = base_url();
		
				//register code
				$data['register_code'] = $this->encrypt->decode($data['web_config']['register_code']);
				//view
				$this->load->library('session');
				$this->load->view('index/providers/login', $data);
			} else {
				$this->useful->AlertPage('/providers/panel');
			}
		}
	}

	public function auth()
	{
		$credentials = [
			'tax_id' => $_POST['account'],
			'phone' => $_POST['password'],
			'is_provider' => 1
		];

		if ($provider = $this->providerModel->checkProviderExists($credentials)) {
			@session_start();
			$_SESSION['provider'] = [
				'is_login' => 1,
				'id' => $provider['id'],
				'account' => $provider['account']
			];

			$this->useful->AlertPage('/providers/panel');
		} else {
			echo "<script>alert('帳號或密碼錯誤'); location.href = '/providers/login'</script>";
		}
	}

	public function logout()
	{
		unset($_SESSION['provider']);
		$this->useful->AlertPage('/providers/login');
	}

	public function product_commits()
	{
		$commits = $this->commitModel->getProviderCommits($_SESSION['provider']['id']);
		$data['commits'] = $commits;
		$this->load->view('index/providers/commit_list', $data);
	}

	public function panel()
	{
		if (empty($_SESSION['provider'])) {
			$this->useful->AlertPage('/providers/login');
		}
		
		$data = $this->data;
		$this->load->view('index/providers/manager_panel', $data);
	}

	public function menu()
	{
		$this->load->view('index/providers/menu');
	}

	public function main()
	{
		$this->load->view('index/providers/main');
	}

	private function apiResponse(array $data, $statusCode = 200)
	{
		header('Content-Type: application/json');
		http_response_code($statusCode);
		echo json_encode($data);
	}

	private function encryptCode($vcode)
	{
		do {
			$str=$this->encrypt->encode($vcode);
		} while(strpos($str, '+') !== false);

		return $str;
	}
}
