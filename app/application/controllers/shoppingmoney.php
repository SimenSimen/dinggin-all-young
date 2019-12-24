<?php
class Shoppingmoney extends MY_Controller
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
        $this->load->model('shoppingmoney_model','smodel');
        $this->load->model('/MyModel/mymodel');

        //語言包設置
        $this->load->model('lang_model',lmodel);
        $this -> load -> helper('form');
        $this->load->library('/mylib/comment');
        $this->load->library('/mylib/useful');
        $this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';        
    }

	//會員列表
	public function moneytransfer(){
		//權限判斷
		$this->useful->CheckComp('j_moneytransfer');
		
		//資料庫名稱
		$data['dbname']=$dbname='buyer';

		$search_default_array=array('s_make_no','s_bank_name','s_bank_account_name','s_bank_account','s_chktype');
		$this->mymodel->search_session($search_default_array);

		$where_array=array();
		if($_SESSION["AT"]["where"]['s_make_no']!=""){
		    $where_array[]="bonus_pay_bank.make_no like '%".$_SESSION["AT"]["where"]['s_make_no']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_name']!=""){
		    $where_array[]="bonus_pay_bank.bank_name like '%".$_SESSION["AT"]["where"]['s_bank_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_account_name']!=""){
		    $where_array[]="bonus_pay_bank.bank_account_name like '%".$_SESSION["AT"]["where"]['s_bank_account_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_account']!=""){
		    $where_array[]="bonus_pay_bank.bank_account like '%".$_SESSION["AT"]["where"]['s_bank_account']."%'";
		}
		if($_SESSION["AT"]["where"]['s_chktype']!=""){
		    $where_array[]="bonus_pay_bank.chktype = '".$_SESSION["AT"]["where"]['s_chktype']."'";
		}
		
		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		// 分頁程式 start
		$this->load->library('/mylib/PageNew');
	    $page=new PageNew();
	    $page->SetMySQL($this->db);
		$page->SetPagSize(20);
		$qpage=$page->PageStar('bonus_pay_bank','',$where);    
		$data['page']=$this->load->view('mypage/page',$qpage,true);
		// print_r($_POST);
        //分頁程式 end
		$dbdata=$this->smodel->GetShoppingmoney($where,$qpage['result']);
		$data['dbdata']=$dbdata;
		//view
		$this->load->view('shoppingmoney/moneytransfer_list', $data);
	}
	//銀行轉帳單筆內頁
	public function moneytransfer_info($id=''){
		//權限判斷
		$this->useful->CheckComp('j_moneytransfer');
		
		$data['dbname']=$dbname='bonus_pay_bank';
		//返回鍵
		$data['back_url']='/shoppingmoney/moneytransfer';

		$dbdata=$this->smodel->select_from($dbname,array('d_id'=>$id));

		$data['dbdata']=$dbdata;

		//view
		$this->load->view('shoppingmoney/moneytransfer_info', $data);
	}

	////購物金轉帳單增刪修
	public function shoppingmoney_AED($del_id=''){
		@session_start();
		//權限判斷
		$this->useful->CheckComp('j_moneytransfer');
		$data=$this->data;
		if($del_id!=''){
			
	        $this->mymodel->delete_where('bonus_pay_bank',array('d_id'=>$del_id));
	        $msg='刪除成功';
			
		}else{
			$d_id=$_POST['d_id'];

			$this->load->library('/mylib/CheckInput');
			$check=new CheckInput;
			$check->fname[]=array('_String',Comment::SetValue('makedate'),'請款日期');
			$check->fname[]=array('_String',Comment::SetValue('make_no'),'請款編號');
			$check->fname[]=array('_String',Comment::SetValue('tot'),'請款金額');
			$check->fname[]=array('_String',Comment::SetValue('bank_name'),'銀行名稱');
			$check->fname[]=array('_String',Comment::SetValue('bank_account_name'),'帳戶名稱');
			$check->fname[]=array('_String',Comment::SetValue('bank_account'),'銀行帳號');
			$check->fname[]=array('_Select',Comment::SetValue('chktype'),'請款狀況');
			$check->fname[]=array('_String',Comment::SetValue('Fee'),'手續費');

			if(!empty($check->main())){
				//記錄密碼
				$_SESSION['RT']=$_POST;
				$_SESSION['ssoc']=1;
				echo $check->main();
				return '';
			}
			$buy_data=array(
				'makedate'=>Comment::SetValue('makedate'),
				'make_no'=>Comment::SetValue('make_no'),
				'tot'=>Comment::SetValue('tot'),
				'bank_name'=>Comment::SetValue('bank_name'),
				'bank_account_name'=>Comment::SetValue('bank_account_name'),
				'bank_account'=>Comment::SetValue('bank_account'),
				'chktype'=>Comment::SetValue('chktype'),
				'chkdate'=>$this->useful->get_now_date(),
				'chk_user_id'=>$_SESSION['member_id'],
				'notes'=>Comment::SetValue('notes'),
				'viewdate'=>$this->useful->get_now_date(),
				'Fee'=>Comment::SetValue('Fee'),
				'paydate'=>Comment::SetValue('paydate'),
				'update_time'=>$this->useful->get_now_time(),
			);
			
			if($d_id){
				$this->smodel->update_set('bonus_pay_bank','d_id',$d_id,$buy_data);
				$msg='修改成功';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/shoppingmoney/moneytransfer";</script>';
	}

	//購物金轉帳單匯出
	public function dl_moneytransfer(){
		//權限判斷
		$this->useful->CheckComp('j_moneytransfer');

		$title_array=array('請款日期','會員帳號','會員姓名','請款編號','請款金額','銀行名稱','帳戶名稱','銀行帳號','請款狀況','手續費','應轉金額');
		
		$where_array=array();
		if($_SESSION["AT"]["where"]['s_make_no']!=""){
		    $where_array[]="make_no like '%".$_SESSION["AT"]["where"]['s_make_no']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_name']!=""){
		    $where_array[]="bank_name like '%".$_SESSION["AT"]["where"]['s_bank_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_account_name']!=""){
		    $where_array[]="bank_account_name like '%".$_SESSION["AT"]["where"]['s_bank_account_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_bank_account']!=""){
		    $where_array[]="bank_account like '%".$_SESSION["AT"]["where"]['s_bank_account']."%'";
		}
		if($_SESSION["AT"]["where"]['s_chktype']!=""){
		    $where_array[]="chktype = '".$_SESSION["AT"]["where"]['s_chktype']."'";
		}

		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		$dbdata=$this->smodel->GetShoppingmoney($where,$qpage['result']);
		foreach ($dbdata as $value){
			if($value['chktype']==0)
				$chktype='未申請';
			else if($value['chktype']==1)
				$chktype='申請中';
			else if($value['chktype']==2)
				$chktype='核可';
			else if($value['chktype']==3)
				$chktype='不核可';
			else if($value['chktype']==4)
				$chktype='請款完成';
			$data_array[]=array(
				$value['makedate'],
				$value['d_account'],
				$value['name'],
				$value['make_no'],
				$value['tot'],
				$value['bank_name'],
				$value['bank_account_name'],
				$value['bank_account'],
				$chktype,
				$value['Fee'],
				$value['tot']-$value['Fee'],
				);						
		}
		$this->export_xls($title_array,$data_array,date('Y-m-d').'我要請款轉帳資料匯出');
	}

}