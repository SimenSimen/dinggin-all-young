<?php
class Shoppingmoney_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }
 
  // 20180104 抓取購物金
  public function GetShoppingmoney($where='',$page=''){
    $sql="select bonus_pay_bank.*,buyer.d_account,buyer.name";
    $sql.=" from bonus_pay_bank";
    $sql.=" left join buyer on bonus_pay_bank.by_id = buyer.by_id";
    $sql.= $where;
    $sql.=' order by create_time desc';
    $sql.=$page;
    $query = $this->db->query($sql)->result_array();
    foreach ($query as $key => $value) {
      if($value['chktype']==0)
        $query[$key]['chktype']="未申請";
      else if($value['chktype']==1)
        $query[$key]['chktype']="申請中";
      else if($value['chktype']==2)
        $query[$key]['chktype']="核可";
      else if($value['chktype']==3)
        $query[$key]['chktype']="不核可";
      else if($value['chktype']==4)
        $query[$key]['chktype']="請款完成";
    }
    
    return $query;
  }
	public function GetShoppingmoney1($where='',$page=''){
    $sql="select bonus.*,buyer.d_account,buyer.name";
    $sql.=" from bonus";
    $sql.=" left join member on bonus.MID=member.member_id";
    $sql.=" left join buyer on buyer.by_id=member.by_id";
    $sql.= $where;
    $sql.=' order by d_date desc';
    $sql.=$page;
    $query = $this->db->query($sql)->result_array();
    foreach ($query as $key => $value) {
      if($value['d_send']=='N')
        $query[$key]['d_send']="申請中";
      else if($value['d_send']=='Y')
        $query[$key]['d_send']="完成";
    }

    return $query;
  }

  public function getShoppingHistory($buyer_id)
  {
	return $this->db->query("SELECT s.*, b.name 
		FROM shopping_money s 
		INNER JOIN buyer b ON s.d_member_id = b.by_id 
		WHERE d_guest_id = ? AND s.d_shopping_money <> 0
		ORDER BY create_time DESC", $buyer_id
	)->result_array();
  }
}
?>
