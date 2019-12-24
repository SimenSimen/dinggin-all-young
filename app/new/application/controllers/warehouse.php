<?php
class Warehouse extends MY_Controller
{
	private $_rootPath, $_data, $_myView;
	public function __construct()//初始化
	{
		parent::__construct();
		//model
		$this->load->model('admin_model', 'mod_admin');
		//model
		$this->load->model('member_model','mmodel');
		//語言包設置
        $this->load->model('lang_model','lmodel');
		//model 20171117
		$this->load->model(array('banner_model', 'products_model', '/MyModel/mymodel'));
		
		// language detail需要語系,否則會錯誤
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang') || $this -> session -> userdata('lang') == 'zh-tw'){
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}else{
			$this -> data['lang'] = $this -> session -> userdata('lang');			
		}
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('14', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		//helper
		$this->load->helper('url');

		//library
		$this->load->library('/mylib/useful');

		//domain
		if($this->session->userdata('session_domain') != ''){
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}else{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');

		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		$this -> load -> helper('form');

		//檔案名
		$this->DataName='warehouse';
		@session_start();
        $this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
	}

	//供應商列表 20171228
	public function warehouse_list(){
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		//資料庫名稱
		$data['dbname']=$dbname=$this->DataName;

		$dbdata=$this->mymodel->select_page_form($dbname,$qpage['result'],'*',array(''));
		$data['dbdata']=$dbdata;
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname,'',20,array());		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end	
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('warehouse/warehouse_list', $data);
	}
	//供應商內頁 20171228
	public function warehouse_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_comlist');
		$data['dbname']=$dbname=$this->DataName;
		$dbdata=$this->mmodel->select_from($dbname,array('d_id'=>$id));
		$data['dbdata']=$dbdata;
		$data['protype']=$this->mymodel->select_page_form('warehouse','','*',array('d_id'=>'NULL'));
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('warehouse/warehouse_info', $data);
	}
	
	//--AJAX 開啟關閉資料專用
	public function oc_data(){
		$DB=$this->input->post('DB');		//資料表
		$field=$this->input->post('field');	//欄位名稱
		$id=$this->input->post('id');		//修改ID 需有分號區隔
		$oc=$this->input->post('oc');		//Open Close Value

		$id_val=explode(';',$id);

		if($oc=='1'||$oc=='2'||$oc=='0')
			$is_filed='prd_active';
		else
			$is_filed='prd_hot';
		
		if($oc=='E')
			$oc='fa fa-heart-o';
		elseif($oc=='L')
			$oc='fa fa-heart';
		foreach ($id_val as $value) {
			$this->mmodel->update_set($DB,$field,$value,array($is_filed=>$oc));
		}
		echo '修改成功';
	}
	//--AJAX 開啟關閉資料專用

	//資料增刪修
	public function data_AED($dbname='',$del_id=''){
		$d_id='d_id';
		$img_url='/uploads/000/000/0000/0000000000/products/';
		if(!is_dir('.'.$img_url))
			mkdir('.'.$img_url,0777);
		
		if($del_id!=''){
			
			if($dbname=='product_class')
				$d_id='prd_cid';
			
			if($dbname=='products'){
				$d_id='prd_id';
				$this->mmodel->update_set($dbname,$d_id,$del_id,array('d_enable'=>'N'));
				$this->useful->AlertPage('','刪除成功');
				return '';
			}

			$this->mmodel->delete_where($dbname,array($d_id=>$del_id));
			$msg='刪除成功';
		}else{
			$id=$_POST['d_id'];
			$dbname=$_POST['dbname'];

			if($dbname=='products'){
				$d_id='prd_id';
				if($_POST['restrice_num']!='0'){
					if($_POST['prd_lock_amount'] > $_POST['restrice_num']){
						echo '<script>alert("單次購買數量不得大於限購數量");history.go(-1);</script>';
						return '';
					}
				}
				if($_POST['prd_pv']<=0){
					$this->useful->AlertPage('','PV值不得小於等於零');
					return '';
				}


				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');
				if($_FILES['prd_image']['error'] != 4)
				{
					$img=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
					$_POST['prd_image']=$img['path'];
					if($id){
						unlink('.'.$img_url.$_POST['prd_image_hide']);
						unlink('.'.$img_url.'set_'.substr($_POST['prd_image_hide'],1));
					}
				}else
				{
					$_POST['prd_image']=$_POST['prd_image_hide'];
				}
				unset($_POST['prd_image_hide']);
				//商品特點			
				$_POST['prd_describe']=$this->Array_String($_POST['prd_describe']);
				//影片標題
				$_POST['prd_video_name']=$this->Array_String($_POST['prd_video_name']);
				//影片連結
				$_POST['prd_video_link']=$this->Array_String($_POST['prd_video_link']);
				//規格名稱
				$_POST['prd_specification_name']=$this->Array_String($_POST['prd_specification_name']);
				//規格內容
				$_POST['prd_specification_content']=$this->Array_String($_POST['prd_specification_content']);

				$_POST['prd_content'] = str_replace("\"", "&quot;", $_POST['prd_content']);
				
				// 更改PV寫入LOG
				$Chkdata=$this->mymodel->OneSearchSql('products','prd_pv,prd_name',array('prd_id'=>$id));
				if($Chkdata['prd_pv']!=$_POST['prd_pv']){
					$content='管理員'.$_SESSION['AT']['account_name'].'-更改'.$Chkdata['prd_name'].'的PV('.$Chkdata['prd_pv'].'->'.$_POST['prd_pv'].')';
					$this->mymodel->WriteLog('2',$content);
				}
			}
		
			if($id){
				$data=$this->useful->DB_Array($_POST);
			}else{
				$data=$this->useful->DB_Array($_POST,1);
			}
			
			if($dbname=='product_class'){
				$d_id='prd_cid';
			}


			
			unset($data['dbname']);
			unset($data['d_id']);
		
			if($id){
				$this->mmodel->update_set($dbname,$d_id,$id,$data);
				$msg='修改成功';
			}else{
				
				$create_id=$this->mmodel->insert_into($dbname,$data);
				if($create_id)
					$msg='新增成功';
				else
					$msg='新增失敗';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/'.$this->DataName.'/'.$dbname.'_list";</script>';
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
