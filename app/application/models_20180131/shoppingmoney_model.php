<?php
class Shoppingmoney_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }
 
  // 20180104 抓取購物金
  public function GetShoppingmoney($where='',$page=''){
    $sql="select *";
    $sql.=" from bonus_pay_bank";
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

}
?>