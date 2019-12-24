<?php
require_once('./application/core/MY_Sql.php');
class Corporate_model extends MY_Sql
{
	function __construct()
	{
		$this -> load -> database();
	}

	// prepare input element
	public function category_chk($type)
	{
		$data['category_btn'] = false;
		switch ($type) {
			case '1':
				$data['category_btn'] = false;
				$data['ckeditor_btn'] = true;
				break;
			case '2':
				$data['category_btn'] = true;
				$data['ckeditor_btn'] = true;
				$data['category'] = $category = $this -> select_from_order_limit('auth_category', array('category_id', 'c_name'), array('type' => $type, 'enable' => '1', 'lang_type' => $this -> session -> userdata('lang')), 'update_time', 'desc');
				break;
			case '3':
			case '6':
				$data['ckeditor_btn'] = true;
				break;
			case '4':
			case '5':
				$data['category_btn'] = true;
				$data['ckeditor_btn'] = false;
				$data['category'] = $category = $this -> select_from_order_limit('auth_category', array('category_id', 'c_name'), array('type' => $type, 'enable' => '1', 'lang_type' => $this -> session -> userdata('lang')), 'update_time', 'desc');
				$data['content_placeholder'] = ($type == 4) ? 'Youtube 網址' : '網站網址';
				break;
			default:
				$data['category_btn'] = true;
				$data['ckeditor_btn'] = true;
				$data['category'] = $category = $this -> select_from_order_limit('auth_category', array('category_id', 'c_name'), array('type' => $type, 'enable' => '1', 'lang_type' => $this -> session -> userdata('lang')), 'update_time', 'desc');
				break;
		}
		return $data;
	}

	// add
	public function add_action($post)
	{
		if (isset($post['name']))
		{
			$category = array();
			$time = date('Y-m-d H:i:s', time());

			$post['content'] = $this -> type_check($post['type'], $post['content']);

			if(!$post['content'])
				return $post['content'];

			if (!empty($post['add_category']))
			{
				$category = $this -> select_from('auth_category', array('c_name', 'category_id'), array('type'=>$post['type'],'c_name' => $post['add_category'], 'lang_type' => $this -> session -> userdata('lang')), 'row');
				
				if (empty($category) && ($post['type'] == 2 || $post['type'] == 3 || $post['type'] == 4 || $post['type'] == 5 || $post['type'] == 6))
					$category['category_id'] = $this -> insert_into('auth_category', array('c_name' => $post['add_category'], 'type' => $post['type'], 'update_time' => $time, 'lang_type' => $this -> session -> userdata('lang')));
				else
					$this -> update_set('auth_category', array('category_id' => $category['category_id']), array('update_time' => $time));
			}
			else
				$category['category_id'] = NULL;

			$insert_id = $this -> insert_into('ckeditor', array('name' => $post['name'], 'content' => $post['content'], 'sort' => 0, 'category_id' => $category['category_id'], 'enable' => '1', 'type' => $post['type'], 'lang_type' => $this -> session -> userdata('lang')));
			return $insert_id;
		}
		else
			return false;
	}

	// update
	public function update_action($post, $ck_id)
	{
		if (isset($post['name']))
		{
			$category = array();
			$time = date('Y-m-d H:i:s', time());

			$post['content'] = $this -> type_check($post['type'], $post['content']);

			if(!$post['content'])
				return $post['content'];

			if (!empty($post['add_category']))
			{
				$category = $this -> select_from('auth_category', array('c_name', 'category_id'), array('type'=>$post['type'],'c_name' => $post['add_category'], 'lang_type' => $this -> session -> userdata('lang')), 'row');
				
				if (empty($category) && ($post['type'] == 2 || $post['type'] == 3 || $post['type'] == 4 || $post['type'] == 5))
					$category['category_id'] = $this -> insert_into('auth_category', array('c_name' => $post['add_category'], 'type' => $post['type'], 'update_time' => $time, 'lang_type' => $this -> session -> userdata('lang')));
				else
					$this -> update_set('auth_category', array('category_id' => $category['category_id']), array('update_time' => $time));
			}
			else
				$category['category_id'] = NULL;

			$update_id = $this -> update_set('ckeditor', array('ck_id' => $ck_id), array('category_id' => $category['category_id'], 'name' => $post['name'], 'content' => $post['content']));
			return $update_id;
		}
		else
			return false;
	}

	// sort
	public function sort_action($ck_array = array())
	{
		if (!empty($ck_array))
		{
			foreach ($ck_array as $key => $value)
			{
				$this -> update_set('ckeditor', array('ck_id' => $value), array('sort' => $key));
			}

			return true;
		}
		else
			return false;
	}

	public function extend_ckupload_time($expire)
	{
		if ($expire == 0) {
			$expire = ini_get('session.gc_maxlifetime');
		} else {
			ini_set('session.gc_maxlifetime', $expire);
		}

		if (empty($_COOKIE['PHPSESSID'])) {
			session_set_cookie_params($expire);
			session_start();
		} else {
			session_start();
			setcookie('PHPSESSID', session_id(), time() + $expire);
		}

		$_SESSION['member_id'] 	  = 0;
		$_SESSION['IsAuthorized'] = true;
		$_SESSION['img_url'] 	  = '/uploads/000/000/0000/0000000000/ckfinder_image/';
	}

	private function type_check($type, $content)
	{
		switch ($type) {
			case '4':
				if (!preg_match('/(http|https):\/\/www.youtube.com\/embed\/(.*?)$/i', $content))
					$content = $this -> get_ytb_id($content);
				else
					$content = $this -> ytb_link_convert($content);
				break;
			case '5':
				$content = $this -> http_check($content);
				break;
			// default:
			// 	break;
		}
		return $content;
	}

	private function get_ytb_id($url) 
	{
		//去除首尾空白
		$url = trim($url);

		//擷取id
		if($pos = strpos($url, '?v=') !== false)
		{
			//後綴參數檢查
			$pos = strpos($url, '?v=');
			$and_mark = strpos($url, '&');
			if($and_mark != false)
				$id = substr($url, $pos+3, ($and_mark-$pos-3));
			else
				$id = substr($url, $pos+3);
		}
		else
		{
			//youtu.be檢查
			if ($pos = strpos($url, 'youtu.be') !== false)
			{
				$pos = strrpos($url, '/');
				$and_mark = strpos($url, '&');
				if($and_mark != false)
					$id = substr($url, $pos+1, ($and_mark-$pos-1));
				else
					$id = substr($url, $pos+1);
			}
			else
				$id = false;
		}
		return $id;
	}

	private function ytb_link_convert($url)
	{
		if(false !== ($pos = strpos($url, 'https://')))
			$ytb_id = substr($url, 30, strlen($url));
		else
			$ytb_id = substr($url, 29, strlen($url));
		return $ytb_id;
	}

	private function http_check($temp_url)
	{
		if (false !== ($pos = strpos($temp_url, "https://")))
		{//find https
		    $url=$temp_url;
		}
		else
		{
			if (false !== ($pos = strpos($temp_url, "http://")))
			{//find
			    if($pos!=0)
			    	$url="http://".$temp_url;
			    else
			    	$url=$temp_url;
			}
			else
			{//not find
			    $url="http://".$temp_url;
			}
		}
		return $url;
	}
}