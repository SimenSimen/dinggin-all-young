<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banner_model extends CI_Model{
	//private $_db_name, $_db_products, $_db_store;
	
	public function __construct(){
		$this->load->database();
		$this->_db_name = 'banner';
	}

	public function getMyAd($type=1){
		$this->db->select('`' . $this->_db_name . '`.`d_img`, `' . $this->_db_name . '`.`d_type`,`'. $this->_db_name . '`.`d_val1`', false);
		$this->db->from($this->_db_name);
		$this->db->where($this->_db_name . '.d_enable', 'Y');
		/*好像沒用
		if ($type === 1){
			$this->db->where($this->_db_name . '.d_index', 'Y');
		}else{
			$this->db->where($this->_db_name . '.d_store', 'Y');
		}
		*/
		$this->db->order_by($this->_db_name . '.d_sort DESC');
		$query = $this->db->get();
		$banner['banner']=$query->result();
		$data=$this->load->view('index/banner', $banner,true);
		return $data;
	}
	
	public function addNum($id=0){
		if ($id > 0){
			$this->db->set('d_num', 'd_num+1', false);
			$this->db->where('d_id', $id);
			return $this->db->update($this->_db_name);
		}
		return false;
	}
}