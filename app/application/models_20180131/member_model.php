<?php
class Member_model extends MY_Model {

  public function __construct()
  {
    $this->load->database();
  }
 
  //抓取一般會員
  public function get_buyer_data($id='',$s_num='',$s_name='',$s_type='',$is_member='',$like='',$page='',$s_account=''){
    $sql="SELECT b.*,b.name as bname,b.create_time as ctime FROM buyer b ";
    $sql.=" where 1=1";
    if($s_type!='')
      $sql.=" and b.d_is_member='".$s_type."'";
  
    if($is_member!='')
      $sql.=" and b.d_is_member='1'";

    if($id!='')
      $sql.=" and b.by_id!=".$id;

    if($s_name!='')
      $sql.=" and b.name like '%".$s_name."%'";

    if($s_account!='')
      $sql.=" and b.d_account like '%".$s_account."%'";
    
    $sql.=' and b.is_del="N"';
    $sql.=' order by b.create_time desc';
    $sql.=$page;
    $query = $this->db->query($sql);
    return $query->result_array();
  }
 
  //抓取目前經營會員
  public function get_member_data($id='',$s_num='',$s_name='',$s_type='',$is_member='',$like='',$page='',$s_account=''){
    $sql="SELECT m.deadline,m.by_id,m.member_num,m.member_id,m.GID,m.d_keys,m.upline,b.*,b.name as bname,b.create_time as ctime FROM buyer b ";
    $sql.=" left join member m on b.by_id=m.by_id ";
    $sql.=" where 1=1";
    if($s_type!='')
      $sql.=" and b.d_is_member='".$s_type."'";
  
    if($is_member!='')
      $sql.=" and b.d_is_member='1'";

    if($id!='')
      $sql.=" and m.by_id!=".$id;

    if($s_num!='')
      $sql.=" and m.member_num like '%".$s_num."%'";

    if($s_name!='')
      $sql.=" and b.name like '%".$s_name."%'";

    if($s_account!='')
      $sql.=" and b.d_account like '%".$s_account."%'";
    
    if($like!=''){
      $sql.=" and m.member_num like '%".$like."%'";
      $sql.=" and m.is_family_boss='N'";
    }

    $sql.=' and b.is_del="N"';
    $sql.=' order by b.create_time desc';
    $sql.=$page;
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  // 20170426 抓取會員
  public function GetMember($where='',$page=''){
    $sql="select b.by_id,b.PID,b.name,if(b.sex='male','男','女') as sex,m.upline,b.create_time as ctime,b.mobile,b.d_is_member,m.member_num,m.deadline";
    $sql.=" from buyer b";
    $sql.=" left join member m on m.by_id=b.by_id";
    $sql.= $where;
    $sql.=' order by b.create_time desc';
    $sql.=$page;
    $query = $this->db->query($sql)->result_array();
    foreach ($query as $key => $value) {
      $upline='';
      $Pname=$this->get_buyer_sign('',$value['PID']);
      $query[$key]['Pname']=!empty($Pname)?$Pname['name']:'無推薦人';
      if($value['upline']!=0)
        $upline=$this->get_member_sign($value['upline']);
      $query[$key]['upline']=!empty($upline)?$upline['name']:'無上線會員';
    }
    

    return $query;
  }

  //抓取一般會員(單筆)
  public function get_buyer_sign($id='',$by_id='',$account=''){
    $sql="SELECT b.* FROM buyer b ";
    $sql.=" where 1=1";
    if($account!='')
      $sql.=" and b.d_account='".$account."'";
    if($by_id!='')
      $sql.=" and b.by_id=".$by_id;

    $query = $this->db->query($sql);
    return $query->row_array();
  }

  //抓取目前經營會員(單筆)
  public function get_member_sign($id='',$by_id='',$is_boss='',$account=''){
    $sql="SELECT m.*,b.*,m.country as mcountry,m.city as mcity,m.countory as mcountory,m.address as maddress,m.create_time as mcreate_time FROM member m ";
    $sql.=" left join buyer b on b.by_id=m.by_id ";
    $sql.=" where m.is_del='N' and m.auth='02'";
    if($account!='')
      $sql.=" and m.account='".$account."'";
    if($id!='')
      $sql.=" and m.member_id=".$id;
    if($by_id!='')
      $sql.=" and m.by_id=".$by_id;

    if($is_boss!='')
      $sql.=" and m.is_family_boss='N'";
    


    $query = $this->db->query($sql);
    return $query->row_array();
  }
  //抓取單會員組織表
  public function get_member_family($num='',$page=''){
    $sql="SELECT m.by_id,m.member_num,m.GID,m.d_keys,m.upline,b.* FROM member m ";
    $sql.=" left join buyer b on b.by_id=m.by_id ";
    $sql.=" where m.is_del='N' and m.auth='02'";
    $sql.=" and concat(m.d_keys,',') LIKE '%,".$num.",%'";

     $sql.=$page;
    $query = $this->db->query($sql);
    return $query->result_array();
  }
  //抓取單會員組織表
  public function get_keys($num=''){
    $sql="SELECT m.member_id,m.d_keys,m.upline FROM member m ";
    $sql.=" where concat(m.d_keys,',') LIKE '%".$num."%'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  //抓取商品資訊
  public function get_order_data($class='',$status='',$lang='TW'){
    $sql  = 'SELECT products.*, SUM(products_views.page_view) AS view';
    $sql .= ' FROM products LEFT JOIN products_views ON products.prd_id = products_views.prd_id';
    $sql.=' where 1=1';
    $sql.=' and lang_type="'.$lang.'"';
    if($class!='')
      $sql.=' and products.prd_cid='.$class;
    if($status!='')
      $sql.=' and products.prd_active='.$status;
    $sql .= ' and products.d_enable="Y" group by products.prd_id';

    return $this -> db -> query($sql) -> result_array();
  }

  //EBH留言
  public function get_ebh_data($m_id='',$b_id=''){
    if($m_id!='' and $b_id!='')
      $sql='select * from talkapp where m_id='.$m_id.' and b_id='.$b_id.' ';
    elseif($m_id!='')
      $sql='select b_id,m_id from talkapp where m_id='.$m_id.' group by b_id';
    else
      $sql='select m_id from talkapp group by m_id';
    return $this ->db-> query($sql) -> result_array();
  }

  //顧客中心總數
  public function get_ck_num($type=''){
    if($type==6){
      $sql='select d_id from reviews where d_status=0';
    }else{
      $sql='select ck_id from ckeditor where enable="1"';
      $sql.=' and type='.$type.'';
    }

    return $this ->db-> query($sql) -> num_rows();
  }

}