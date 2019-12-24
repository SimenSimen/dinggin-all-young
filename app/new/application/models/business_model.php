<?php
//-----------------------------------------------------------------------------------
// get_img_path 取得圖檔路徑
// get_doc_path 取得附件路徑
//----------------------------------------------------------------------------------- 
class Business_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：make_random_cset_code($len)
	// 作 用 ：產生隨機商店代碼
	// 參 數 ：$len 代碼長度
	// 返回值：商店代碼
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function iqr_views_add($iqr_id, $ip)
	{
		$time = time();
		$iqrv = $this->select_from('iqr_views', array('iqr_id'=>$iqr_id, 'ip'=>$ip));
		if(empty($iqrv))
		{//沒有紀錄, 新增計量紀錄
			$iqrv_info = array(
				'iqr_id'	=> $iqr_id,
				'views'		=> 1,
				'ip'		=> $ip,
				'y'			=> date('Y', $time),
				'm'			=> date('m', $time),
				'd'			=> date('d', $time),
				'time'		=> $time
			);
			$iqrv_id = $this->insert_into('iqr_views', $iqrv_info);
		}
		else
		{//有紀錄, 檢查時間是否超過一天, 有則從上次計量數+1, 並更新時間, 無則不動作
			if(($time - $iqrv['time']) >= 86400)
			{
				$iqrv_info=array(
					'views'		=> ($iqrv['views']+1),
					'y'			=> date('Y', $time),
					'm'			=> date('m', $time),
					'd'			=> date('d', $time),
					'time'		=> $time
				);
				$iqrv_id = $this->update_set('iqr_views', 'iqrv_id', $iqrv['iqrv_id'], $iqrv_info);
			}
		}
	}

	public function get_img_path($img_id)
	{
		$img=$this->select_from('images', array('img_id'=>$img_id));
		$img_path=substr($img['img_path'], 1);
		return $img_path;
	}

	public function get_doc_path($doc_id)
	{
		$doc=$this->select_from('documents', array('doc_id'=>$doc_id));
		$doc_path=substr($doc['doc_path'], 1);
		return $doc_path;
	}

	public function get_doc_name($doc_id)
	{
		$doc=$this->select_from('documents', array('doc_id'=>$doc_id));
		$str = strpos($doc['doc_path'], "exfile");
		$str = substr($doc['doc_path'], $str + 7, strlen($doc['doc_path']));
		return $str;
	}

	//檢查會員圖檔資料夾是否異常
	public function member_img_dir_check($member)
	{
		if($member['img_url'] == '0' || strlen($member['img_url']) < 33)
		{
			$member_dir=$this->get_member_dir($member['member_id']);

			//修正會員狀態
			$this->update_set('member', 'member_id', $member['member_id'], array('img_url'=>$member_dir));
			return $member_dir;
		}
		else
		{
			return $member['img_url'];
		}
	}
	function get_member_dir($mid)
	{
		//full relative path
		$path='/uploads/';

		$user=str_pad($mid, 10, '0', STR_PAD_LEFT);
		$one=substr($user, 7, 3);
		$two=substr($user, 0, 3);
		$three=substr($user, 3, 4);
		$dir='.'.$path.$one.'/'.$two.'/'.$three.'/'.$user;

		$temp = explode('/', $dir);
		$cur_dir = '';
		for($i = 0; $i < count($temp); $i++)
		{
			$cur_dir .= $temp[$i].'/';
		}
		return substr($cur_dir, 1, (strlen($cur_dir) - 1));
	}
}