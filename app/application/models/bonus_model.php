<?php
class Bonus_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function adjustBonusLastStatus($year, $month)
  {
    $sql = "UPDATE bonus_last SET is_calculated = 1 WHERE d_YEAR = ? AND d_Month = ?";
    $this->db->query($sql, [$year, $month]);
  }

  public function getCalculatedStatus($year, $month)
  {
    $this->db->where('d_Year', $year);
    $this->db->where('d_Month', $month);
    return $this->db->get('bonus_last')->result_array()[0];
  }

  //紅利點數明細
  public function get_dividend_data($by_id='',$brithday='',$page_limit,$Topage){
    $start_rec  = ($Topage-1) * $page_limit;  //  起始記錄編號
    $sql='select OID,send_dt,create_time,update_time,d_type,d_val,d_des,is_send,send_dt,is_del from dividend';
    // $sql.=' where buyer_id='.$by_id.' and update_time BETWEEN "'.$brithday.'" AND DATE_ADD("'.$brithday.'",INTERVAL 1 YEAR)';
    $sql.=' where buyer_id='.$by_id." order by `update_time` DESC LIMIT $start_rec, $page_limit";
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  //找出有結算紀錄的最新一筆(月)
  public function get_bonus_date($list=''){
    $month=strtotime('now -1 month',time());
    $sql="SELECT DISTINCT d_Year, d_Month FROM bonus_last ";
    $sql.=" where concat(d_Year,d_Month)<=".date('Ym',$month)."";
    $sql.=" ORDER BY d_Year DESC, d_Month DESC"; 

    $query = $this->db->query($sql);
    if($list!='')
      $list=$query->result_array();
    else
      $list=$query->row_array();
    return $list;
  }
  //抓取獎金資料
  public function get_bonus_data($year='',$month='',$id='',$Topage='',$page_limit=''){
    $sql='select * from bonus as bo';
    if($id!=''){
      $sql.=' where  d_id='.$id;
      $query = $this->db->query($sql);
      $list=$query->row_array();
      return $list;
    }    
    $start_rec  = ($Topage-1) * $page_limit;  //  起始記錄編號
    $sql.=' where d_Year='.$year.' and d_Month='.$month;
    if($Topage<>''&&$page_limit<>''){
      $sql.="  order by MID LIMIT $start_rec, $page_limit"; 
    }else{
      $sql.="  order by MID";
    }
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  //是否有新訂單
  public function get_order_data($date,$list=''){   
    $sql='select by_id,create_time,order_id,member_id,total_pv from `order` ';
    if($list!=''){
      $sql.=' where SUBSTRING(create_time,1,7)="'.$date.'" and product_flow=4 and status=1';
      // $sql.=' group by member_id';
    }else{
      $sql.=' where SUBSTRING(create_time,1,7) BETWEEN "'.$date.'" and "'.date('Y-m').'"' ;
      $sql.=' and SUBSTRING(create_time,6,2)!='.substr($date,5,2);
    }
    $query = $this->db->query($sql);
    if($list!='')
      return $query->result_array();
    else
      return $query->row_array();
  }
  //是否有新訂單
  public function get_order_data1($date,$list=''){   
    $sql='select b.name as buyname,b1.name as membername,m.upline,m.member_num,m.iInsurance,o.total_pv,o.order_id,o.create_time,kv.d_val as kvnum,
          one1.d_val as pvper1,
          round(((o.total_pv*one1.d_val)/100)) as pv1,
          round((((o.total_pv*one1.d_val)/100)*kv.d_val)) as bonus1,
          round(((o.total_pv*two2.d_val)/100)) as pv2,
          round((((o.total_pv*two2.d_val)/100)*kv.d_val)) as bonus2,
          round(((o.total_pv*f.d_pernum)/100)) as pv3,
          round((((o.total_pv*f.d_pernum)/100)*kv.d_val)) as bonus3
          from `order` o
          inner join buyer b on b.by_id=o.by_id
          inner join member m on m.member_id=o.member_id
          inner join buyer b1 on b1.by_id=m.by_id
          inner join config one1 on one1.d_id=1
          inner join config two2 on two2.d_id=2
          inner join config kv on kv.d_id=3
          inner join family f on f.d_id=m.GID
          where SUBSTRING(o.create_time,1,7)="'.$date.'" and o.product_flow=4 and o.status=1
          order by o.order_id';
    $query = $this->db->query($sql);
    return $query->result_array();

  }

  //撈取會員資料
  public function get_buyer_data($bid){
    $sql='select name from buyer';
    $sql.=' where by_id='.$bid;
    $query = $this->db->query($sql);
    return $query->row_array();
  }
  //撈取經銷會員資料
  public function get_member_data($mid=''){
    if($mid!=''){
      $sql='select b.name,m.member_num from member m,buyer b where b.by_id=m.by_id and member_id='.$mid;
    }else
      $sql='select identity_num from member where auth="02" order by identity_num';
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  //設定代扣二代健保
  public function set_insur($id=''){
    if($id!=''){
      $sql='UPDATE member SET iInsurance = "Y" WHERE identity_num IN ('.$id.')';
      $query = $this->db->query($sql);
    }else{
      $sql='UPDATE member SET iInsurance = "N"';
      $query = $this->db->query($sql);
    }
  }
  //撈取選取日期之一年前資料
  public function get_grade_data($year,$month,$inid='',$s=''){   
    $tomonth=date("Y-m-d",strtotime("$year-$month-01")-86400);
    if($s!='')
      $sum=",sum(total_price) as stotal ";

    $sql='select member_id,total_price'.$sum.' from `order` ';
    $sql.=' where create_time BETWEEN "'.($year-1).'-'.$month.'-01'.'" and "'.$tomonth.'"';
    $sql.=' and product_flow=4 and status=1';
    if($inid!=''){
      $sql.=' and member_id in ('.$inid.')';
    }
    //echo $sql.'<br><br>';
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  //撈取群組購買資料
  public function get_grade_order($year,$month,$inid=''){   
    $tomonth=date("Y-m-d",strtotime("$year-$month-01")-86400);
    $sql='select o.total_price,m.member_num,b.name,m.create_time,o.order_id from `order` o';
    $sql.=' left join member m on m.member_id=o.member_id';
    $sql.=' left join buyer b on m.by_id=b.by_id';
    $sql.=' where o.create_time BETWEEN "'.($year-1).'-'.$month.'-01'.'" and "'.$tomonth.'"';
    $sql.=' and o.product_flow=4 ';
    if($inid!=''){
      $sql.=' and o.member_id in ('.$inid.')';
    }
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  //抓取上線及上上線
  public function get_up_data($id=''){
    $sql='select GID,upline from member where member_id in('.$id.') group by upline';
    $query=$this->db->query($sql);
    return $query->result_array();
  }

  public function get_me_data($id=''){
    $sql='select member_id from member where upline ="'.$id.'" group by member_id';
    $query=$this->db->query($sql);
    return $query->result_array();
  }
  //抓取訂單所有帳號
  public function get_ord_data($date,$id){
    $sql="select sum(total_pv) as total1,create_time,order_id from `order` where SUBSTRING(create_time,1,7)='".$date."' and member_id in (".$id.")";
    $query=$this->db->query($sql);
    return $query->row_array(); 
  }
  //抓取獎金資料
  public function get_bdata($mid,$d_Year,$d_Month,$type='',$OID=''){
    $sql='select * from bonus where MID='.$mid;   
    $sql.=' and d_Year='.$d_Year.' and d_Month='.$d_Month;
    $sql.=' and d_type_id='.$type;
    if($OID!='')
      $sql.=' and OID='.$OID;
    $query=$this->db->query($sql);
    return $query->row_array();
  }
  //體系負責人
  public function get_family_data($id){
    $sql='select MID,d_pernum from family where d_id='.$id;   
    $query=$this->db->query($sql);
    return $query->row_array();
  }

  //獎金結算
  public function bonus_pay($year,$month){
    $sql='select b.*,m.iInsurance from bonus b,member m';
    $sql.=' where b.d_Year='.$year.' and b.d_Month='.$month;
    // $sql.=' where SUBSTRING(b.d_date,1,7)="'.$date.'"';
    $sql.=' and b.MID=m.member_id';
    $sql.=' and b.d_block="N"';
    $sql.=' and b.d_send="N"';
    $sql.='  order by b.MID';

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  //刪除統計資料
  public function del_total($iSetYear,$iSetMonth){
    $sql="DELETE FROM bonus_pay ";
    $sql.=" WHERE d_year = '".$iSetYear."' AND d_month = '".$iSetMonth."'";
    $query = $this->db->query($sql);
  }

  //抓取產品資料
  public function get_product_data(){
    $sql="SELECT pc.prd_cname,p.* FROM product_class pc";
    $sql.=" RIGHT JOIN products p ON p.prd_cid = pc.prd_cid ";
    $sql.=" WHERE p.prd_id > 0 ";
    $query = $this->db->query($sql);
    $list=$query->result_array();
    return $list;
  }

  //抓取本期總值
  public function get_amount_total($id,$iDayStart,$iDayEnd){
    $sql="SELECT SUM(od.number) AS iTotalAmount FROM order_details od";
    $sql.=" left join `order` o on o.id=od.oid ";
    $sql.=" WHERE od.prd_id = '".$id."' ";
    $sql.=" AND o.trade_date >= '".$iDayStart."' ";
    $sql.=" AND o.trade_date <= '".$iDayEnd."'";
    $sql.=" AND o.status = 1";
    $query = $this->db->query($sql);
    $list=$query->row_array();
    return $list;
  }

  //體系總攬
  public function check_family($id='',$code='',$name=''){
    $sql='select d_code,d_name from family';  
    if($code!='')
      $sql.=' where d_code="'.$code.'"';
    if($name!='')
      $sql.=' where d_name="'.$name.'"';
    if($id!='')
      $sql.=' and d_id!='.$id;
 
    $query = $this->db->query($sql);
    return $query->row_array();
  }

  //APP銷售明細
  public function salesql($d_spec_type='',$start='',$end='',$keyword='',$sort='',$sortad=''){
    $sql='select od.member_id,sum(od.total_price-od.lway_price) as total_price,count(od.id) as total_count,b.name as bname,b.d_account,b.d_spec_type,m.member_num';
    $sql.=' from `order` od';
    $sql.=' left join member m on od.member_id=m.member_id';
    $sql.=' left join buyer b on b.by_id=m.by_id';
    $sql.=' where od.status=1 and od.product_flow=4 and od.member_id!=0 ';
    if(!empty($d_spec_type))
      $sql.=' and b.d_spec_type='.$d_spec_type;
    if(!empty($start) and !empty($end))
      $sql.=' and SUBSTRING(od.create_time,1,10) between "'.$start.'" and "'.$end.'"';
    if(!empty($keyword))
      $sql.=' and concat(b.d_account,"|",b.name) like "%'.$keyword.'%"';

    $sql.=' group by od.member_id';

    if(!empty($sort))
      $sql.=' order by '.$sort.' '.$sortad.'';

    return $this->db->query($sql)->result_array();
  }
}
