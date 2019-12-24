<?php
class Gold_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }
  
  //前台訂單搜尋
  public function get_order_data($order_id='',$start='',$end='',$id='',$by_id='',$m_id=''){
    $sql='select id,by_id,order_id,FROM_UNIXTIME(date) as create_time,product_flow from `order`';
    $sql.=' where 1=1';
    if($order_id!='')
      $sql.=' and order_id='.$order_id;
    if($start!='' and $end!='')
      $sql.=' and create_time between "'.$start.'" and "'.$end.'"';
    if($id!='')
      $sql.=' and id='.$id;
    if($by_id!='')
      $sql.=' and by_id='.$by_id;
    if($m_id!='')
      $sql.=' and member_id='.$m_id;

    $sql.=' order by id desc';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  //紅利點數明細
  public function get_dividend_data($by_id='',$brithday=''){
    $sql='select OID,update_time,d_type,d_val,d_des,is_send from dividend';
    // $sql.=' where buyer_id='.$by_id.' and update_time BETWEEN "'.$brithday.'" AND DATE_ADD("'.$brithday.'",INTERVAL 1 YEAR)';
     $sql.=' where buyer_id='.$by_id.'';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  //EBH留言
  public function get_talk_data($m_id=''){
    $sql='select b_id,d_content,d_read,create_time from (select * from talkapp order by create_time desc) as a ';
    $sql.=' where d_type="B" and m_id="'.$m_id.'"' ;
    $sql.=' group by b_id';
    $query = $this->db->query($sql);
    return $query->result_array();
  }
}