<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class products_model extends CI_Model{
	private $_db_name, $_db_store, $_db_type;
	
	public function __construct(){
		$this->load->database();
		$this->db_name = 'products';
		$this->db_store = 'store';
		$this->db_type = 'product_class';
		$this->load->library('session');
	}
	/**
	 * 取得產品類別資料
	 * @return array stdClass db
	 */
	public function productsType($type=0){
		$sql_where ="where lang_type ='$this->setlang'";
		if($type==0){
			$sql_where .=" and PID = 0";
    	}else{
    		$sql_where .=" and PID <> 0";
    	}
    	$sql="SELECT `prd_cid`, `prd_cname`, `PID`  FROM `$this->db_type` 
    	 $sql_where order by `prd_cid`";
    	$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	 * 取得產品清單
	 * @return array stdClass db
	 */
	public function productsList($pid,$page_limit,$Topage,$d_spec_type){
		if($d_spec_type==1){
			$sql_where ="where p.`prd_active`='1' and p.`is_bonus`='N'";
		}else{
			$sql_where ="where p.`prd_active`='1' and p.`is_vip`='N' and p.`is_bonus`='N'";
		}
		if($pid!=0){
			$sql_where .=" and pt.`prd_cid`=$pid";
		}
		$start_rec	=	($Topage-1) * $page_limit;	//	起始記錄編號
    	$sql="SELECT p.`prd_id`,p.`prd_name`, p.`prd_image`, p.`prd_price00`, p.`d_mprice`  FROM `$this->db_name` as p
    		left JOIN `$this->db_type` as pt ON p.`prd_cid`=pt.`prd_cid` $sql_where order by p.`prd_id` DESC LIMIT $start_rec, $page_limit
    		";
    	$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	 * 取得產品,但必須檢查各店跟類別是否有開啟
	 * 只要一個有關閉,就無法取得該資料
	 * @param int $id
	 * @return stdClass db
	 */
	public function productsDetail($id,$d_spec_type){

		if($d_spec_type==1){
			$sql_where ="where p.`prd_id`=$id and p.`prd_active`='1' and p.`is_bonus`='N'";
		}else{
			$sql_where ="where p.`prd_id`=$id and p.`prd_active`='1' and p.`is_vip`='N' and p.`is_bonus`='N'";
		}

    	$sql="SELECT p.`prd_id`, p.`prd_name`, p.`prd_cid`, p.`prd_image`, p.`prd_price00`, p.`prd_price01`, p.`d_mprice`, p.`prd_lock_amount`, pt.`prd_cname`, pt.`PID`, 
    		p.`prd_content`, p.`prd_describe`, p.`prd_specification_name`, p.`prd_specification_content`, p.`prd_pv`, p.`supplier_id`
    		FROM `$this->db_name` as p
    		left JOIN `$this->db_type` as pt ON p.`prd_cid`=pt.`prd_cid` $sql_where ";
    	$query = $this->db->query($sql);
		$result['data']=$query->row_array();
    	$result['num']=$query->num_rows();
		return $result;
	}



//-----------------------------------------------------------------------------------
	// 函數名：products_insert_views
	// 作 用： 新增產品點擊率
	// 參 數：$table  	  資料表名稱
	// $data_array 		  資料陣列
	// 返回值：無
	// 備 注：無
	//-----------------------------------------------------------------------------------
	public function products_insert_views($table, $data_array = array())
	{
		if(!empty($data_array))
		{
			$data_array1 = array();
			foreach ($data_array as $key => $value)
			{
				$data_array1[] = $key. " = '". $value ."'";
			}
			$sql = 'INSERT INTO '. $table . ' SET ' .implode(", ", $data_array1);
			$this -> db -> query($sql);
		}
	}






	
	/**
	 * 取得相關產品,但必須檢查各店跟類別是否有開啟
	 * 只要一個有關閉,就無法取得該資料
	 * @param int $id
	 * @return stdClass db
	 */
	public function productsRelatedDetail($id){
		$sql_where ="where p.`prd_id`=$id";
    	$sql="SELECT p.`prd_name`, p.`prd_image`, p.`prd_price00`  FROM `$this->db_name` as p
    		left JOIN `$this->db_type` as pt ON p.`prd_cid`=pt.`prd_cid` $sql_where ";
    	$query = $this->db->query($sql);
		return $query->row_array();
	}

	/**
	 * 取得產品,但必須檢查各店跟類別是否有開啟
	 * 只要一個有關閉,就無法取得該資料
	 * @param int $id
	 * @return stdClass db
	 */
	public function productsData($id){
		$this->db->select($this->_db_name . '.prd_id, ' . $this->_db_name . '.prd_name, ' . $this->_db_name . '.prd_image, ' . $this->_db_name . '.SID, ' . $this->_db_name . '.prd_describe');
		$this->db->from($this->_db_name);
		$this->db->join($this->_db_store, $this->_db_name . '.SID = ' . $this->_db_store . '.d_id', 'left');
		$this->db->join($this->_db_type, $this->_db_name . '.prd_cid_s = ' . $this->_db_type . '.prd_cid', 'left');
		$this->db->where($this->_db_store . '.d_enable', 'Y');
		$this->db->where($this->_db_type . '.d_enable', 'Y');
		$this->db->where($this->_db_type . '.lang_type', $this->session->userdata('lang'));
		$this->db->where($this->_db_name . '.d_enable', 'Y');
		$this->db->where($this->_db_name . '.lang_type', $this->session->userdata('lang'));
		$this->db->where($this->_db_name . '.prd_id', $id);
		$query = $this->db->get();
		return $query->row();
	}
}