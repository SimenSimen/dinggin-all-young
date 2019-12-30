<?php
class Login_model extends MY_Model {
	public function __construct()
	{
		$this->load->database();
	}

	public function login_chekc($data)
	{
		$this->load->library('encrypt');//加密
		$this->load->library('session');
		$this->load->library('/mylib/useful');
		$sql='SELECT * FROM buyer
				WHERE  `d_account`="'.$data['account'].'"';
		$query = $this->db->query($sql);
		$admin=$query->row_array();

		//檢查驗證是否有過(check_code必須為空值)
		if (!empty($admin['check_code'])){
			$this->session->set_userdata('revalidate_id', $admin['by_id']);
			$this->useful->AlertPage('/member_sms_code', '您尚未完成驗證！');
			return 'LoginError';
		}

		if(count($admin)!=0)
		{
			$password = $this->encrypt->decode($admin['by_pw']);
			// if($admin['is_verify']=='N'){
			// 	return 'NoVer';//尚未驗證
			// }
			if($password == $data['password'])
			{

				$last_login=array('update_time'=>$this->useful->get_now_time());
				$this->db->where('by_id', $admin['by_id']);
				$this->db->update('buyer', $last_login);
				$array=array('by_id'=>$admin['by_id'],'name'=>$admin['name'], 'check_code' => $admin['check_code'],'d_is_member'=>$admin['d_is_member']);
				if($admin['d_is_member']=='1'){
					$sql='SELECT * FROM member
							WHERE  `by_id`="'.$admin['by_id'].'"';
					$query = $this->db->query($sql);
					$admin=$query->row_array();
					$array['member_id']=$admin['member_id'];
				}

				return $array;
			}
			else{
				return 'LoginError';
			}
		}else
			return 'Nouser';
	}
}