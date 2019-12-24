<?php
class Logis extends MY_Controller
{
	public function __construct()//初始化
	{
		parent::__construct();

		//model
		$this->load->model('admin_model', 'mod_admin');

		//helper
		$this->load->helper('url');

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

		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));

		//model
		$this->load->model('member_model','mmodel');

		//model
		$this->load->model('/MyModel/mymodel');	

		$this -> load -> helper('form');

		$this->load->library('/mylib/useful');

		$this->load->library('/mylib/comment');
	}
	//物流列表
	public function logis_list(){
		//權限判斷
		$this->useful->CheckComp('j_log');

		//資料庫名稱
		$data['dbname']=$dbname='logis';

		$dbdata=$this->mmodel->select_from('logistics_way');
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['active']=($value['active']==0)?'停用':'啟用';
		}
		$data['dbdata']=$dbdata;
		//view
		$this->load->view('logis/'.$dbname.'_list', $data);
	}
	//物流內頁
	public function logis_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_log');
		
		$data['dbname']=$dbname='logis';
		$dbdata=$this->mmodel->select_from('logistics_way',array('lway_id'=>$id));
	
		$data['dbdata']=$dbdata;

		//地區撈取
		$data['city']=$this->mymodel->get_area_data();

		//view
		$this->load->view('logis/'.$dbname.'_info', $data);
	}

	//會員服務條款&隱私權政策 
	public function regconfig($type=''){
		$curr_lang = $this->session->userdata('lang');
		if(!empty($_POST)){
			$tData = [
				'd_type'		=>	$_POST['save_type'],
				'lang_type'		=>	$curr_lang,
			];
			$checkExist = $this->mymodel->select_from_where('config', 'd_id', $tData);
			if(empty($checkExist['d_id'])){ // 不存在，新增
				$tData = [
					'd_type'		=>	$_POST['save_type'],
					'd_title'		=>	$_POST['title'],
					'd_val'			=>	$_POST['d_send_content'],
					'update_time'	=>	date('Y-m-d H:i:s'),
					'lang_type'		=>	$curr_lang,
				];
				$create_id = $this->mmodel->insert_into('config', $tData);
				$tStr = "新增";
			}else{ // 存在，更新
				$this->mymodel->update_set('config','d_type',$_POST['save_type'],array('d_val'=>$_POST['d_send_content'],'lang_type'=>$curr_lang));
				$tStr = "儲存";
			}
			echo '<script>alert("' . $tStr . '完畢");window.location.href="/logis/regconfig/'.$_POST['save_type'].'";</script>';
			unset($tData); $tData = NULL;
			unset($tStr); $tStr = NULL;
		}else{
			switch($type){
				case 'service':
					$this->useful->CheckComp('j_service');
					$title='會員服務條款';
					break;
				case 'privacy':
					$this->useful->CheckComp('j_privacy');
					$title='隱私權政策';
					break;
				case 'announcement':
					$this->useful->CheckComp('j_announcement');
					$title='會員權益';
					break;
				case 'problem':
					$this->useful->CheckComp('j_problem');
					$title='常見問題';
					break;
				case 'selection':
					$this->useful->CheckComp('j_selection');
					$title='嚴選方法';
					break;
				case 'terms':
					$this->useful->CheckComp('j_terms');
					$title='會員註冊說明';
					$desc = '(請輸入沒有圖片的純文字，以免跑版)';
					break;
			}
			//標題
			$data['title']=$title;
			$data['desc']=$desc;

			//撈取資料
			$content=$this->mymodel->GetConfig($type, '', $curr_lang);
			$data['content']=$content[0]['d_val'];
			$data['type']=$type;

			//view
			$this->load->view('logis/regconfig', $data);
		}
		
	}

	//通知信設定
	public function mailconfig(){
		//權限判斷
		$this->useful->CheckComp('j_mailconfig');

		if(!empty($_POST)){
			foreach ($_POST['mail'] as $key=> $value) {
				$this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
			}
			echo '<script>alert("儲存完畢");window.location.href="/logis/mailconfig/";</script>';
		}else{
			$dbdata=$this->mymodel->GetConfig('mailconfig');
			$data['dbdata']=$dbdata;
		}
		//view
		$this->load->view('logis/mailconfig', $data);
	}

	//活躍指標設定
	public function activeconfig(){
		//權限判斷
		$this->useful->CheckComp('j_activeconfig');

		if(!empty($_POST)){
			$this->mymodel->update_set('config','d_id',$_POST['d_id'],array('d_val'=>$_POST['activeconfig']));
			echo '<script>alert("儲存完畢");window.location.href="/logis/activeconfig/";</script>';
		}else{
			$dbdata=$this->mymodel->GetConfig('activeconfig');
			$data['dbdata']=$dbdata;
		}
		//view
		$this->load->view('logis/activeconfig', $data);
	}

	//手續費設定
	public function feeconfig(){
		//權限判斷
		$this->useful->CheckComp('j_feeconfig');

		if(!empty($_POST)){
			foreach ($_POST['feeconfig'] as $key=> $value) {
				$this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
			}
			echo '<script>alert("儲存完畢");window.location.href="/logis/feeconfig/";</script>';
		}else{
			$dbdata=$this->mymodel->GetConfig('feeconfig');
			$data['dbdata']=$dbdata;
		}
		//view
		$this->load->view('logis/feeconfig', $data);
	}

	//wowpay設定
	public function wowpayconfig(){
		//權限判斷
		$this->useful->CheckComp('j_wowpay');

		if(!empty($_POST)){
			foreach ($_POST['wowpayconfig'] as $key=> $value) {
				$this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
			}
			echo '<script>alert("儲存完畢");window.location.href="/logis/wowpayconfig/";</script>';
		}else{
			$dbdata=$this->mymodel->GetConfig('wowpayconfig');
			$data['dbdata']=$dbdata;
		}
		//view
		$this->load->view('logis/wowpayconfig', $data);
	}

	//資料增刪修
	public function data_AED($DB='',$del_id=''){
		$this->load->library('/mylib/CheckInput');
		$check=new CheckInput;

		if($del_id!=''){
			$dbname=$DB;
			$this->bmodel->delete_where($DB,array('d_id'=>$del_id));
			$msg='刪除成功';
		}else{
			$id=$_POST['d_id'];
			$dbname=$_POST['dbname'];

			// $check->fname[]=array('_String',Comment::SetValue('d_name'),'物流名稱');
			$check->fname[]=array('_String',Comment::SetValue('business_account'),'物流費用');
			// $check->fname[]=array('_String',Comment::SetValue('d_sort'),'排序');
			
			if(!empty($check->main())){
				echo $check->main();
				return '';
			}

		
			// if(is_array($_POST['d_area'])){
			// 	$area=$_POST['d_area'];

			// 	foreach ($area as $avalue) {
			// 		$astr.=$avalue.',';
			// 	}
			// 	$_POST['d_area']=$astr;
			// }

			if($id){
				$data=$this->useful->DB_Array($_POST);
			}else{
				$data=$this->useful->DB_Array($_POST,1);
			}

			$data=$this->useful->UnsetArray($data,array('dbname','d_id','create_time','update_time'));
	
		
			if($id){
				$this->mmodel->update_set($dbname,'lway_id',$id,$data);
				$msg='修改成功';
			}else{
		
				$create_id=$this->mmodel->insert_into($dbname,$data);
				if($create_id)
					$msg='新增成功';
				else
					$msg='新增失敗';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/logis/logis_list";</script>';
	}

	//--AJAX 開啟關閉資料專用
	public function oc_data(){
		$DB=$this->input->post('DB');		//資料表
		$field=$this->input->post('field');	//欄位名稱
		$id=$this->input->post('id');		//修改ID 需有分號區隔
		$oc=$this->input->post('oc');		//Open Close Value		
		
		$id_val=explode(';',$id);

		foreach ($id_val as $value) {
			$this->mymodel->update_set($DB,$field,$value,array('active'=>$oc));
		}
		echo '修改成功';
	}
	//--AJAX 開啟關閉資料專用
	
}