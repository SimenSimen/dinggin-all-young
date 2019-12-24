<?php
class Photo_category_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

    //----------------------------------------------------------------------------------- 
    // 函數名：get_photo_cateory($domain_id)
    // 作 用 ：取得所有資料
    // 參 數 ：$domain_id 網域id
    // 返回值： array
    // 備 注 ：無
    //----------------------------------------------------------------------------------- 
    public function get_photo_category()
    {
    	$result=array();
        $command ="SELECT d_name,d_id,d_photo FROM photo_category WHERE d_member_id=".$this->session->userdata('member_id')." and d_enable = 'Y'";
        $command.=" order by d_sort ASC";
        $query = $this->db->query($command);
        $data  = $query->result_array();
        foreach($data as $key => $value)
        {
            $result[$value["d_id"]] = $value;
        }
        return $result;
    }

    public function get_auth_photo_category($member_id)
    {
        $result=array();
        $command ="SELECT d_name,d_id,d_photo FROM photo_category WHERE d_member_id=".$member_id." and d_enable = 'Y'";
        $command.=" order by d_id desc";
        $query = $this->db->query($command);
        $data  = $query->result_array();
        foreach($data as $key => $value)
        {
            $result[$value["d_id"]] = $value;
        }
        return $result;
    }
    //-----------------------------------------------------------------------------------
    // 函數名：get_photo_cateory_id($d_id)
    // 作 用 ：取得某一筆資料
    // 參 數 ：$domain_id 網域id
    // 返回值： array
    // 備 注 ：無
    //-----------------------------------------------------------------------------------
    public function get_photo_category_id($d_id)
    {
    	$result=array();
    	if(!empty($d_id)){
    		$command ="SELECT * FROM photo_category";
    		$command.=" WHERE d_member_id=".$this->session->userdata('member_id')." and d_enable = 'Y' and d_id=".$d_id." limit 1";
    		//echo $command;exit();
    		$query = $this->db->query($command);
    		$data  = $query->result_array();
    		foreach($data as $key => $value)
    		{
    			$result = $value;
    		}
    	}
    	return $result;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：add_photo_category($data=array(),$where_name="")
    // 作 用 ：新增資料
    // 參 數 ：$data array("key"=>"val")所有欄位名稱及值,$where_name 名稱
    // 返回值：$error錯誤訊息
    // 備 注 ：
    //----------------------------------------------------------------------------------- 
    public function add_photo_category($data=array(),$where_name="")
    {
    	$error="";
    	if(!empty($data)){
    		$data["d_createTime"]=date("Y-m-d H:i:s",time());
    		$data["d_updateTime"]=date("Y-m-d H:i:s",time());
    		$data["d_member_id"]=$this->session->userdata('member_id');
    		$sql_data["key"]=$sql_data["val"]=array();
    		foreach($data as $key=>$val){
    			$sql_data["key"][]=$key;
    			$sql_data["val"][]="'".$val."'";
    		}
        	$sqlAE = "insert into photo_category (" . implode(",",$sql_data["key"]) . ")";
        	$sqlAE .= " select ". implode(",",$sql_data ["val"]);
        	$sqlAE .= " FROM DUAL WHERE NOT EXISTS (";
        	$sqlAE .= " select 1 from photo_category where d_member_id=".$this->session->userdata('member_id')." and d_name='" .$where_name . "' limit 1";
        	$sqlAE .= ");";
        	
       	 	if (! $this->db->query ( $sqlAE )) {
        		$error = "資料新增失敗";
        	}
        	else {
        		$new_id = $this->db->insert_id ();
        		if (empty ( $new_id )) {//名稱重覆
        			$error="名稱重覆";
        		}
        	}
    	}
        return $error;
    }
    //-----------------------------------------------------------------------------------
    // 函數名：edit_photo_category($data=array(),$where_name="")
    // 作 用 ：修改資料
    // 參 數 ：$data array("key"=>"val")所有欄位名稱及值,$where_name 名稱
    // 返回值：$error錯誤訊息
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function edit_photo_category($data=array(),$d_id,$d_name)
    {
    	$error="";
    	if(!empty($data) && !empty($d_id) && !empty($d_name)){
    		$data["d_updateTime"]=date("Y-m-d H:i:s",time());
    		$sql_data=array();
    		foreach($data as $key=>$val){
    			$sql_data[]=$key."='".$val."'";
    		}
    		$sqlAE = "update photo_category set " . implode(",",$sql_data)." where d_id=".$d_id." and d_member_id=".$this->session->userdata('member_id');
    		$sqlAE .= " and not exists (SELECT * FROM (select 1 from photo_category where d_id<>" . $d_id . " and d_member_id=".$this->session->userdata('member_id')." and d_name='" .$d_name . "') temp)"; // 名稱是否重覆
    		//echo $sqlAE;exit();
    		if (! $this->db->simple_query ( $sqlAE )) {
    			$error = "資料修改失敗";
    		} else {
    			$new_id = $this->db->affected_rows ();
    			if (empty ( $new_id )) {
    				$error = "名稱重覆";
    			}
    		}
    	}
    	return $error;
    }
    //-----------------------------------------------------------------------------------
    // 函數名：edit_photo_category($data=array(),$where_name="")
    // 作 用 ：修改資料
    // 參 數 ：$data array("key"=>"val")所有欄位名稱及值,$where_name 名稱
    // 返回值：$error錯誤訊息
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function edit_photo_category_d_photo($data=array(),$d_id)
    {
    	$error="";
    	if(!empty($data) && !empty($d_id)){
    		$data["d_updateTime"]=date("Y-m-d H:i:s",time());
    		$sql_data=array();
    		foreach($data as $key=>$val){
    			$sql_data[]=$key."='".$val."'";
    		}
    		$sqlAE = "update photo_category set " . implode(",",$sql_data)." where d_id=".$d_id." and d_member_id=".$this->session->userdata('member_id');
    		//echo $sqlAE;exit();
    		if (! $this->db->simple_query ( $sqlAE )) {
    			$error = "資料修改失敗";
    		} 
    	}
    	return $error;
    }
    //-----------------------------------------------------------------------------------
    // 函數名：edit_photo_category($data=array(),$where_name="")
    // 作 用 ：修改資料
    // 參 數 ：$data array("key"=>"val")所有欄位名稱及值,$where_name 名稱
    // 返回值：$error錯誤訊息
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function del_photo_category($d_id)
    {
    	$error="";
    	if(!empty($d_id)){
    		$sqlAE = "delete from photo_category where d_id=" . $d_id." and d_member_id=".$this->session->userdata('member_id');
    		//檢查是否有其他資料在使用
    		//$sqlAE .= " and not exists (SELECT * FROM (select 1 from photo_category where d_xxx_id=" . $d_id . ") temp)"; // 名稱是否重覆
    		if (! $this->db->simple_query ( $sqlAE )) {
    			$this->error = "資料刪除失敗";
    		} else {
    			$new_id = $this->db->affected_rows ();
    			if (empty ( $new_id )) {
    				$this->error = "此筆資料尚有其他地方在使用不可刪除";
    			}
    		}
    	}
    	return $error;
    }

}