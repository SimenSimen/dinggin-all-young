<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class favorite_model extends CI_Model
{
	private $_db_name, $_db_store, $_db_type;

	public function __construct()
	{
		$this->load->database();
		$this->db_products = 'products';
		$this->db_favorite = 'product_favorite';
	}
	/**
	 * 取得最愛產品
	 * @return array stdClass db
	 */
	public function selectFavorite($by_id)
	{
		$sql_where = "where f.`d_edit_id` = $by_id";
		$sql = "SELECT p.`prd_id`, p.`prd_name`, p.`prd_image`, p.`prd_price00`  
    	FROM `$this->db_products` as p
    	INNER JOIN `$this->db_favorite` as f ON f.`d_product_id` = p.`prd_id`
    	 $sql_where order by f.`d_id` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/**
	 * 刪除最愛產品
	 * @return array stdClass db
	 */
	public function deleteFavorite($by_id, $prd_id)
	{
		$sql = "DELETE FROM `$this->db_favorite` 
    			WHERE `$this->db_favorite`.`d_edit_id` = $by_id and `$this->db_favorite`.`d_product_id` = $prd_id  ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * get favorite product id array
	 *
	 * @param string|int $by_id
	 * @return array
	 */
	public function getFavoriteIds($by_id)
	{
		$data = $this->db
			->where(['d_member_id' => $by_id])
			->from('product_favorite')
			->get()
			->result_array();
		return array_column($data, 'd_product_id');
	}
}
