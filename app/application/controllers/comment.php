<?php
class Comment extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('comment_model', 'mod_comment');

		$this -> load -> library('/mylib/useful');

		$this->useful->CheckComp('j_share');
	}

	public function main()
	{
		$essay = $this -> mod_comment -> select_from_order_limit('reviews', array('*'), array('d_status <>' => '2'), 'update_time', 'desc');

		foreach ($essay as $key => $value)
		{
			$essay[$key]['chk_status'] = ($value['d_status'] == '1') ? 'checked' : '';
			$essay[$key]['statusName'] = ($value['d_status'] == '0') ? '發佈' : '審核';
		}
		$data['essay'] = $essay;

		$this -> load -> view('admin/system_center/comment/list', $data);
	}

	public function update_essay()
	{
		$ck_array = $this -> input -> post('ck_id');
		$update_array = $this -> input -> post('check_id');

		if (is_array($ck_array) && is_array($update_array))
		{
			$update_data = array_intersect($update_array, $ck_array);
			$update_id = array();
			$essay = $this -> mod_comment -> select_from_order_limit('reviews', array('d_id', 'd_status'), array('d_status <>' => '2'), 'update_time', 'desc');
			foreach ($essay as $key => $value) {
				if (in_array($value['d_id'], $update_data))
					$id = $this -> mod_comment -> update_set('reviews', array('d_id' => $value['d_id']), array('d_status' => (int)!$value['d_status']));
			}

			$this -> script_message('變更成功', '/comment/main');
		}
		else
			$this -> script_message('請勾選您要變更狀態的筆數', '/comment/main');
	}

	public function del_essay()
	{
		$ck_array = $this -> input -> post('ck_id');
		$del_array = $this -> input -> post('check_id');

		if (is_array($ck_array) && is_array($del_array))
		{
			$del_data = array_intersect($del_array, $ck_array);
			foreach ($del_data as $key => $value)
			{
				$this -> mod_comment -> delete_where('reviews', array('d_id' => $value));
			}
			$this -> script_message('刪除成功', '/comment/main');
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/comment/main');
	}

	public function del_ajax_essay()
	{
		$response_array = array('result', 'message');
		$d_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$reviews = $this -> mod_comment -> select_from('reviews', array('d_id'), array('d_id' => $d_id));
		
		if(!empty($reviews))
		{
			$this -> mod_comment -> delete_where('reviews', array('d_id' => $d_id));
			$response_array['result'] = true;
			$response_array['message'] = 'Success';
		}
		else
		{
			$response_array['result'] = false;
			$response_array['message'] = 'Error';
		}

		echo json_encode($response_array);
	}


	public function v()
	{
		$this->member_id=$member_id = $this -> input -> get('m');
		$this->d_id=$d_id = $this -> input -> get('e');

		$reviews = $this -> mod_comment -> select_from('reviews', array('d_title', 'd_content','d_img'), array('member_id' => $member_id, 'd_id' => $d_id), 'row');
		
		$this->DefaultUpload();

		if(!empty($reviews))
		{
			$data['back'] = '/comment/main';
			$data['reviews'] = $reviews;
			$this -> load -> view('admin/system_center/comment/v', $data);
		}
		else
			$this -> script_message('Error', '/comment/main');
	}
	//上傳函式
	private function DefaultUpload(){
		$this->load->library('up_image');
		$this->load->library('/mylib/useful');
		$this->load->model('/MyModel/mymodel');
        // 預覽圖
        if($_FILES['d_img']['name']){
            if($_FILES['d_img']['type']!='image/png' and $_FILES['d_img']['type']!='image/jpeg'){
                $this->useful->AlertPage('/comment/v?e='.$this->d_id.'&m='.$this->member_id.'','預覽圖檔案格式錯誤，請上傳jpg or png副檔名');
                return '';
            }

            $path='./uploads/contribute/'.$this->d_id.'/';//路徑        
            $this->useful->create_dir($path);
            $imgtype=($_FILES['d_img']['type']=='image/png')?'png':'jpg';
            $icon=$this->up_image->uploadimage($_FILES['d_img'],''.$this->d_id.date('YmdHis').'_contribute.'.$imgtype.'',$path);
            $udata['d_img']=substr($icon['path'],2);
            $this->mymodel->UpdateData('reviews',$udata,'where d_id='.$this->d_id.'');
            $this -> script_message('儲存成功', '/comment/main');
        }
	}

	// 刪除圖片
	public function DelPic(){
		$this->load->model('/MyModel/mymodel');

		$dbdata=$this->mymodel->OneSearchSql('reviews','d_img',array('d_id'=>$_POST['Did']));
		unlink($dbdata['d_img']);
		$this->mymodel->UpdateData('reviews',array('d_img'=>''),' where d_id='.$_POST['Did'].'');
		echo 'OK';
	}
}