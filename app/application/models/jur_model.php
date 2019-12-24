<?php
class Jur_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }
  //權限抓取
  public function get_jur($s_id=''){
    $sql="select d_id,d_code,d_name,d_link from jur_action";
    if($s_id!='')
      $sql.=" where d_p_id=".$s_id;
    else
      $sql.=" where d_p_id=0";
    
    $sql.=($_SESSION['AT']['account_name']=='super')?'':' and is_super="N" ';//只有super才看得到的權限設定
    $sql.=' and is_del="N" order by sort';
    $query=$this->db->query($sql);
    return $query->result_array();
  }
}