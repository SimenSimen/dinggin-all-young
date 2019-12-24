<?php
class Exchange_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

    //----------------------------------------------------------------------------------- 
    // 函數名：get_all_root_in_domain($domain_id)
    // 作 用 ：取得網域中所有管理者 member_id
    // 參 數 ：$domain_id 網域id
    // 返回值：member_id array
    // 備 注 ：無
    //----------------------------------------------------------------------------------- 
    public function get_all_root_in_domain($domain_id)
    {
        $sql ='
            SELECT `member_id`
            FROM `member` 
            WHERE `domain_id` = '.$domain_id.' 
            AND `auth` = \'01\'
        ';
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        foreach($data as $key => $value)
        {
            $result[] = $value['member_id'];
        }
        return $result;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：get_all_member_in_domain($domain_id)
    // 作 用 ：取得網域中所有使用者 member_id
    // 參 數 ：$domain_id 網域id
    // 返回值：member_id array
    // 備 注 ：除了管理層級
    //----------------------------------------------------------------------------------- 
    public function get_all_member_in_domain($domain_id)
    {
        $sql ='
            SELECT `member_id`
            FROM `member` 
            WHERE `domain_id` = '.$domain_id.' 
            AND `auth` != \'00\'
            AND `auth` != \'01\'
        ';
        $query = $this->db->query($sql);
        $data  = $query->result_array();
        foreach($data as $key => $value)
        {
            $result[] = $value['member_id'];
        }
        return $result;
    }

}