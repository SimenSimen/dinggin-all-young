<?
class Iosaccount extends MY_Controller
{
	public function index(){

		$query = $this->db->get('iosaccount');
		$dbdata=$query->result_array();
		$data['cnum']=count($dbdata);
		$data['dbdata']=$dbdata;

		$this->load->view('iosaccount',$data);
	}
	public function data_AED($id=''){
		$d_account=$_POST['d_account'];
		$d_newaccount=$_POST['d_newaccount'];
		$d_content=$_POST['d_content'];
		$d_id=$_POST['d_id'];

		if($id!=''){
			$data_where=array('d_id'=>$id);
			$this->db->where($data_where);
			$this->db->delete('iosaccount');
		}else{
			foreach ($d_account as $key => $value) {
				$idata=array(
					'd_account'=>trim($value),
					'd_newaccount'=>trim($d_newaccount[$key]),
					'd_content'=>trim($d_content[$key])
				);

				if(!empty($d_id[$key])){
									
					$this->db->where('d_id', $d_id[$key]);
					$this->db->update('iosaccount', $idata);
				}else{
					$this->db->insert('iosaccount', $idata);
				    $this->db->insert_id();
				}
			}
		}
		echo "<script>alert('操作成功');window.location.href='/IosAccount';</script>";
	}
	public function checkacc($account){
		$this->db->where(array('d_account'=>$account));
		$query = $this->db->get('iosaccount');
		$dbdata=$query->row_array();
		if(!empty($dbdata)){
			$d_account=$dbdata['d_newaccount'];
		}else
			$d_account=$account;

		return $d_account;
	}

}