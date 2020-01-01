<?php
class Brands extends MY_Controller
{
	private $_rootPath, $_data, $_myView;
	public $Spath = '/uploads/000/000/0000/0000000000/brands/';
	public $Spath_s = '/uploads/000/000/0000/0000000000/brands-s/';
	public function __construct() //初始化
	{
		parent::__construct();
		//model
		$this->load->model('admin_model', 'mod_admin');
		$this->load->model('member_model', 'mmodel');
		$this->load->model('cart_model', 'mod_cart');
		$this->load->model('index_model');
		//語言包設置
		$this->load->model('lang_model', 'lmodel');
		//model 20171117
		$this->load->model(array('banner_model', 'products_model', '/MyModel/mymodel'));
		$this->load->model('product_brand_model', 'classModel');
		$this->load->model('commits_model');
		// language detail需要語系,否則會錯誤
		$this->load->helper('language');
		if (!$this->session->userdata('lang') || $this->session->userdata('lang') == 'zh-tw') {
			$this->session->set_userdata('lang', 'TW');
			$this->data['lang'] = $this->session->userdata('lang');
		} else {
			$this->data['lang'] = $this->session->userdata('lang');
		}
		$this->load->model('language_model', 'mod_language');
		$lang = $this->mod_language->converter('14', $this->session->userdata('lang'));
		$this->data = array_merge($this->data, $lang);
		//helper
		$this->load->helper('url');
		//library
		$this->load->library('/mylib/useful');
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
		//列表顯示
		$_SESSION['select_prd_list'] = (!empty($_SESSION['select_prd_list'])) ? $_SESSION['select_prd_list'] : 'prd_list_img';
		//列表排序
		$_SESSION['prd_sort'] = (!empty($_SESSION['prd_sort'])) ? $_SESSION['prd_sort'] : 'prd_new';
		//web config
		$this->data['web_config']	=	$this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config']	=	$this->get_style_config($this->session->userdata('session_domain'));
		$this->data['banner'] = $this->banner_model->getMyAd();
		$this->style 				=	(!empty($this->data['style_config']['style_id'])) ? $this->data['style_config']['style_id'] : '';
		$this->load->helper('form');
		//檔案名
		$this->DataName = 'product_brand';
		@session_start();
	}

	//紀錄列表顯示方式ajax
	public function ajax_prd_list()
	{
		$_SESSION['select_prd_list'] = $_POST['list'];
	}
	//紀錄列表排序方式ajax
	public function prd_sort()
	{
		$_SESSION['prd_sort'] = $_POST['sort'];
	}

	//後台超管-------------------------------------------------------------------

	//品牌內頁
	public function product_brand_info($id = '', $copy = '')
	{
		//權限判斷
		$this->useful->CheckComp('j_brands');
		if (empty($_SESSION['AT']) && empty($_SESSION['provider'])) {
			$this->useful->AlertPage('/index/login');
		}

		$data['dbname'] = $dbname = 'product_brand';
		$dbdata = $this->mmodel->select_from($dbname, array('prd_cid' => $id));

		if (!empty($copy)) {
			$dbdata['prd_cid'] = '';
			$dbdata['brand_image'] = '';
		}
		
		$data['dbdata'] = $dbdata;
		//KV
		$kv = $this->mymodel->GetConfig('', '3');
		$data['kv'] = $kv['d_val'];
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('brands/product_brand_info', $data);
	}

	//品牌列表
	public function product_brand_list()
	{
		header("Cache-control: private");
		//權限判斷
		$this->useful->CheckComp('j_brands');
		$img_url = '/uploads/000/000/0000/0000000000/brands/';
		$img_s_url = '/uploads/000/000/0000/0000000000/brands-s/';

		//資料庫名稱
		$data['dbname'] = $dbname = 'product_brand';

		$data['status'] = $status = !empty($_POST['d_enable']) ? $_POST['d_enable'] : '';

		//分頁程式 start
		$data['ToPage'] = $Topage = !empty($_POST['ToPage']) ? $_POST['ToPage'] : 1;
		$qpage = $this->useful->SetPage($dbname, $Topage, 10, array('lang_type' => $this->session->userdata('lang'), 'd_enable' => $status));
		$data['page'] = $this->useful->get_page($qpage);
		//分頁程式 end

		//echo json_encode($qpage);exit;
		//$dbdata = $this -> mod_admin -> select_from_group_by($qpage['result'],$this->setlang);
		
		$data['brand_content'] = $brand_content = !empty($_POST['brand_content']) ? $_POST['brand_content'] : '';
		$dbdata = $this->select_product_brand_data($qpage['result'], $this->session->userdata('lang'), $status,'',$brand_content);
		

		foreach ($dbdata as $key => $value) {
			$image = explode(',', $value['brand_image']);
			$dbdata[$key]['brand_image'] = $img_url . $image[0];
			$dbdata[$key]['prd_new'] = ($value['prd_new'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_prebuy'] = ($value['prd_prebuy'] == 'N') ? '否' : '是';
			$dbdata[$key]['prd_hot'] = ($value['prd_hot'] == 'fa fa-heart-o') ? '否' : '是';
			if ($value['d_enable'] == 'Y')
				$act = "上架";
			else
				$act = "下架";
			$dbdata[$key]['prd_active'] = $act;

			$dbdata[$key]['setview'] = $value['view'];
			//20160526瀏覽人數設定
			if (strlen($value['view']) > 3) {
				$dbdata[$key]['setview'] = number_format(floor($value['view'] / 1000)) . 'K';
			}

			//搜尋結果-庫存量不足
			if ($_POST['product_status'] == 3) {
				if ($value['prd_amount'] > $value['prd_safe_amount']) {
					unset($dbdata[$key]);
				}
				$data['product_status'] = $_POST['product_status'];
			}
		}

		$data['dbdata'] = $dbdata;

		//產品系列
		$data['cdata'] = $this->mymodel->select_page_form('product_class', '', 'prd_cid,prd_cname', array('lang_type' => $this->session->userdata('lang'), 'd_enable' => 'Y'));


		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('products/product_brand_list', $data);
	}

	//品牌排序
	public function product_brand_sort()
	{
		//權限判斷
		$this->useful->CheckComp('j_brands');

		$data['dbname'] = $dbname = 'product_brand';
		if (!empty($_POST['sort'])) {
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname, 'prd_cid', $value, ['prd_csort' => $key]);
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/brands/product_brand_sort";</script>';
		} else {

			$dbdata = $this->mmodel->select_from_order($dbname, 'prd_csort', 'asc', ['lang_type' => $this->session->userdata('lang')]);
			//總數
			$data['total'] = count($dbdata);
			$img_url = '/uploads/000/000/0000/0000000000/brands/';
			foreach ($dbdata as $key => $value) {
				$image = explode(',', $value['brand_image']);
				$dbdata[$key]['image'] = $img_url . $image['0'];
			}
			$data['dbdata'] = $dbdata;
		}
		//檔案名
		$data['DataName'] = $this->DataName;
		//view
		$this->load->view('brands/product_brand_sort', $data);
	}

	/**
	 * Frontend brand page
	 *
	 * @param integer $id
	 * @return void
	 */
	public function index($id = 0)
	{
		$langPage = $this->lmodel->config('9', $this->setlang);

		/**
		 * load necessary package
		 */
		$this->load->model('products_model', 'productModel');
		$this->load->model('product_class_model', 'productClassModel');
		$this->load->library('/mylib/comment');

		$data = [];

		extract(Comment::params(['classId', 'maxPrise', 'minPrise', 'sortType', 'pageNumber'], ['classId' => 0]));

		/** product class list */
		$data['productClasses'] = $this->productClassModel->getList($this->setlang);
		$data['activeClass'] = $classId;


		if ($this->isAjax()) {
			/** return html */
			// $this->load->view($this->indexViewPath . '/products/_item_list', $data);
			/** return array */
			$this->apiResponse($data);
		} else {

			$this->load->view($this->indexViewPath . '/header' . $this->style, $data);
			$this->load->view($this->indexViewPath . '/products/brands', $data);
			$this->load->view($this->indexViewPath . '/footer' . $this->style, $data);
		}
	}

	//資料增刪修
	public function data_AED($dbname = '', $del_id = '')
	{
		$d_id = 'd_id';
		$img_url = '/uploads/000/000/0000/0000000000/brands/';
		$img_s_url = '/uploads/000/000/0000/0000000000/brands-s/';
		
		if (!is_dir('.' . $img_url))
			mkdir('.' . $img_url, 0777);
		if (!is_dir('.' . $img_s_url))
			mkdir('.' . $img_s_url, 0777);

		if ($del_id != '') {

			if ($dbname == 'product_brand') {
				$d_id = 'prd_cid';
				$this->mmodel->update_set($dbname, $d_id, $del_id, array('d_enable' => 'F'));
				$this->useful->AlertPage('', '刪除成功');
				return '';
			}

			$this->mmodel->delete_where($dbname, array($d_id => $del_id));
			$msg = '刪除成功';
		} else {
			$id = $_POST['prd_cid'];
			$dbname = $_POST['dbname'];

			if ($dbname == 'product_brand') {
				$files = [];
				$d_id = 'prd_cid';

				// 上傳多檔案
				foreach ($_FILES as $key => $fileType) {
					if ($key != 'brand_image' && $key != 'brand_image_s') {
						foreach ($fileType['tmp_name'] as $num => $tmpName) {
							if (!empty($tmpName)) {
								$fileName = strtotime('now') . rand(100, 999) . '.' . pathinfo($_FILES[$key]['name'][$num], PATHINFO_EXTENSION);
								$seperator = (count($fileType['tmp_name']) - 1) == $num ? '' : ',';
								move_uploaded_file($tmpName, 'images/brand/' . $fileName);
								$files[$key] .= $fileName . $seperator;
							}
						}
					}
				}

				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');
		
				if ($_FILES['brand_image']['error']['0'] != 4 ) {
					unset($_POST['ck_id']);
					$count = count($_FILES['brand_image']['name']);
					$count_s = count($_FILES['brand_image_s']['name']);
					$img = $this->mod_upload->upload_brand_arr($_FILES['brand_image'], $img_url, $count);
				
					foreach ($img as $key => $value) {
						if (!empty($value['path'])) {
							$img_path[] = $value['path'];
						}
						
						if ($_FILES['brand_image_s']['error']['0'] == 4 ) {
							unset($_POST['x1d_Files' . $key]);
							unset($_POST['y1d_Files' . $key]);
							unset($_POST['x2d_Files' . $key]);
							unset($_POST['y2d_Files' . $key]);
							unset($_POST['widthd_Files' . $key]);
							unset($_POST['heightd_Files' . $key]);
						}
					}
					if (!empty($img_path)) {
						$_POST['brand_image'] = implode(',', $img_path);
					}
					if ($id) {
						$brand_image_hide = explode(',', $_POST['brand_image_hide']);
						foreach ($brand_image_hide as $val_hide) {
							if (is_file('.' . $img_url . $val_hide)) { //若原本沒有圖片,後來再上傳圖片,會因為找不到檔案而有錯誤訊息
								unlink('.' . $img_url . $val_hide);
							}
						}
					}

					
				} else {
					$_POST['brand_image'] = $_POST['brand_image_hide'];

					$ck_array = $this->input->post('ck_id');
					if (!empty($ck_array)) {
						$_POST['brand_image'] = implode(',', $ck_array);
					}
					unset($_POST['ck_id']);
				}

				// 縮圖
				if ($_FILES['brand_image_s']['error']['0'] != 4) {
					unset($_POST['ck_id_s']);
					$count_s = count($_FILES['brand_image_s']['name']);
					$img_s = $this->mod_upload->upload_brand_arr($_FILES['brand_image_s'], $img_s_url, $count_s);
					
					foreach ($img_s as $key => $value) {
						if (!empty($value['path'])) {
							$img_s_path[] = $value['path'];
						}
						unset($_POST['x1d_Files' . $key]);
						unset($_POST['y1d_Files' . $key]);
						unset($_POST['x2d_Files' . $key]);
						unset($_POST['y2d_Files' . $key]);
						unset($_POST['widthd_Files' . $key]);
						unset($_POST['heightd_Files' . $key]);
					}
					if (!empty($img_s_path)) {
						$_POST['brand_image_s'] = implode(',', $img_s_path);
					}
					if ($id) {
						$brand_image_hide_s = explode(',', $_POST['brand_image_hide_s']);
						foreach ($brand_image_hide_s as $val_hide) {
							if (is_file('.' . $img_s_url . $val_hide)) { //若原本沒有圖片,後來再上傳圖片,會因為找不到檔案而有錯誤訊息
								unlink('.' . $img_s_url . $val_hide);
							}
						}
					}
				} else {
					$_POST['brand_image_s'] = $_POST['brand_image_hide_s'];
					$ck_array_s = $this->input->post('ck_id_s');
					if (!empty($ck_array_s)) {
						$_POST['brand_image_s'] = implode(',', $ck_array_s);
					}
					unset($_POST['ck_id_s']);
				}

				unset($_POST['brand_image_hide']);
				unset($_POST['brand_image_hide_s']);
				
				//內容
				$_POST['prd_content'] = str_replace(array("\"", 'youtube.com/watch?v='), array("&quot;", 'youtube.com/embed/'), $_POST['prd_content']);

				foreach ($files as $key => $value) {
					$_POST[$key] = $value;
				}
			}

			if ($id) {
				$data = $this->useful->DB_Array($_POST);
			} else {
				$data = $this->useful->DB_Array($_POST, 1);
			}

			unset($data['dbname']);
			unset($data['d_id']);
			$data['brand_content'] = $data['prd_content'];
			unset($data['prd_content']);
			$data['d_createTime'] = $data['create_time'];
			unset($data['create_time']);
			$data['d_updateTime'] = $data['update_time'];
			unset($data['update_time']);
			$origins = ['origin_report', 'origin_proof', 'origin_contract', 'origin_insurance', 'origin_mark', 'origin_patent'];

			foreach ($origins as $key => $origin) {
				unset($data[$origin]);
			}

			if ($id) {
				$this->mmodel->update_set($dbname, $d_id, $id, $data);
				$msg = '修改成功';
			} else {
				$create_id = $this->mmodel->insert_into($dbname, $data);
				
				if ($create_id)
					$msg = '新增成功';
				else
					$msg = '新增失敗';
			}

			echo '<script>alert("' . $msg . '"); history.go(-2)</script>';
		}
	}

	private function select_product_brand_data($limit = '', $lang_type = 'TW', $status = '', $name = '', $brand_content = '')
	{
		$sql  = 'SELECT product_brand.* FROM product_brand ';
		$sql .= ' where lang_type="' . $lang_type . '"';

		if ($status != '')
			$sql .= ' and product_brand.d_enable=\'' . $status . '\'';
		if ($name != '') {
			$sql .= ' and product_brand.d_name like "%' . $name . '%"';
		}
		if ($brand_content != '') {
			$sql .= ' and product_brand.brand_content like "%' . $brand_content . '%"';
		}

		if (!empty($limit))
			$sql .= $limit;

		return $this->db->query($sql)->result_array();
	}

	/**
	 * api response
	 *
	 * @param array $data
	 * @param integer $statusCode
	 * @return void
	 */
	protected function apiResponse(array $data, $statusCode = 200)
	{
		header('Content-Type: application/json');
		http_response_code($statusCode);
		echo json_encode($data);
		exit;
	}
}
