<?php
class Payment extends MY_Controller
{
	public function __construct()//初始化
	{
		parent::__construct();

		//model
		$this->load->model('admin_model', 'mod_admin');
		
		$this -> load -> model('payment_model', 'mod_payment');

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
	//金流列表
	public function payment_list(){
		//權限判斷
		$this->useful->CheckComp('j_log');
		//資料庫名稱
		$data['dbname']=$dbname='payment';
		//$dbdata=$this->mmodel->select_from('payment_way');
		$dbdata = $this -> mmodel -> select_from_order('payment_way', 'sort,pway_id', asc);
		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['active']=($value['active']==0)?'停用':'啟用';
		}
		$data['dbdata']=$dbdata;

        $data['return']=$this->mymodel->GetConfig('return');
        if(!empty($_POST['return'])){
            foreach ($_POST['return'] as $key => $value) {
                $this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
            }            
            echo '<script>alert("更新成功");window.location.href="/payment/payment_list";</script>';
        }

        $data['atm']=$this->mymodel->GetConfig('atm');
        if(!empty($_POST['atm'])){
            foreach ($_POST['atm'] as $key => $value) {
                $this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
            }
            foreach ($_POST['atm_t'] as $key => $value) {
                $this->mymodel->update_set('config','d_id',$key,array('d_title'=>$value));
            }
            $_POST=array();
            echo '<script>alert("更新成功");window.location.href="/payment/payment_list";</script>';
        }
		//view
		$this->load->view('payment/'.$dbname.'_list', $data);
	}
	//金流內頁
	public function payment_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_log');		
		$data['dbname']=$dbname='payment';
		$dbdata=$this->mmodel->select_from('payment_way',array('pway_id'=>$id));
		$data['dbdata']=$dbdata;
		//地區撈取
		$data['city']=$this->mymodel->get_area_data();
		//view
		$this->load->view('payment/'.$dbname.'_info', $data);
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

			$check->fname[]=array('_String',Comment::SetValue('business_account'),'物流費用');

			if($id){
				$data=$this->useful->DB_Array($_POST);
				$data=($_POST);
			}else{
				$data=$this->useful->DB_Array($_POST,1);
			}

			$data=$this->useful->UnsetArray($data,array('dbname','d_id'));

			if($id){
				$this->mmodel->update_set($dbname,'pway_id',$id,$data);
				$msg='修改成功';
			}else{
		
				$create_id=$this->mmodel->insert_into($dbname,$data);
				if($create_id)
					$msg='新增成功';
				else
					$msg='新增失敗';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/payment/payment_list";</script>';
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

	public function sort1_save()
	{
		$ck_array = $this -> input -> post('ck_id');
		if ($this -> mod_payment -> sort1_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> payment_list();
		}
		else
		{
			$this -> message = '';
			$this -> payment_list();
		}
	}
	
}