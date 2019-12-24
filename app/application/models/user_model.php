<?php
class User_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：pmay_get($member_id)
	// 作 用 ：取得當年每個月的名片瀏覽次數
	// 參 數 ：$member_id 名片擁有者
	// 返回值：array : 1 ~ 12月的次數
	// 備 注 ：pmay, per month a year
	//----------------------------------------------------------------------------------- 
	public function pmay_get($member_id, $y='')
	{
		$iqr = $this->select_from('iqr', array('member_id'=>$member_id));
		$sql ='
			SELECT `iqr_views`.`m` as month, SUM(`iqr_views`.`views`) as sum
			FROM `iqr_views` 
			WHERE `iqr_views`.`iqr_id` = '.$iqr['iqr_id'].' 
			AND `iqr_views`.`y` = '.$y.' 
			group by `iqr_views`.`m`
		';
		$query = $this->db->query($sql);
		$data  = $query->result_array();
		$pmay  = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		if(!empty($data))
		{
			foreach($data as $key => $value)
			{
				$pmay[(intval($value['month']) - 1)] = $value['sum'];
			}
		}
		return $pmay;
	}

	//列出超管與網管之下的所有會員
	public function list_user($domain_id='')
	{
		$sql='
			SELECT *
			FROM  `member` 
			WHERE `auth` != \'00\' 
			AND   `auth` != \'01\' 
			AND   `domain_id` = '.$domain_id.'
		';
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
}