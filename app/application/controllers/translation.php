<?php
class Translation extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();
		$this->load->model('tran_model',tmodel);

		if ($this -> session -> userdata('auth') != "00")
			$this -> script_message('請先登入', '/index/login');
	}
	
	public function index($id=''){
		$list=$this->tmodel->get_list();
		$data['list']=$list;
		if(!empty($id)){
			$data['lid']=$id;
			$data['dbdata']=$this->tmodel->get_data($id);
		}
		$data['view_url'] = $list[$id-1]['d_url'];
		$this->load->view('translation',$data);
	}

	public function data_AED($id=''){
		$TW=$_POST['TW'];
		$ENG=$_POST['ENG'];
		$JAP=$_POST['JAP'];
		$CN=$_POST['CN'];
		$d_id=$_POST['did'];
		foreach ($d_id as $key => $value) {
			$idata=array(
				'TW'=>trim($TW[$key]),
				'ENG'=>trim($ENG[$key]),
				'JAP'=>trim($JAP[$key]),
				'CN'=>trim($CN[$key])
			);
			if(!empty($d_id[$key])){								
				$this->db->where('d_id', $d_id[$key]);
				$this->db->update('language_pack', $idata);
			}
		}
		echo "<script>alert('操作成功');window.location.href='/translation/index/".$_POST['listid']."';</script>";
	}
	public function excel(){//匯出
		echo $this->tmodel->get_excel();
	}
}