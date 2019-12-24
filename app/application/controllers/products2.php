<?php
class Products extends MY_Controller
{
	public function __construct()//初始化
	{
		parent::__construct();

		//model
		$this->load->model('admin_model', 'mod_admin');

		//helper
		$this->load->helper('url');

		//domain
		if($this->session->userdata('session_domain') != '')
		{
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}
		else
		{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');

		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		$this -> load -> helper('form');
		
		//model
		$this->load->model('member_model','mmodel');
		$this->load->model('/MyModel/mymodel');	
		$this->load->library('/mylib/useful');

		//檔案名
		$this->DataName='products';

		@session_start();
        $this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
	}
	//產品分類列表
	public function product_class_list(){
		//權限判斷
		$this->useful->CheckComp('j_comlist');

		//資料庫名稱
		$data['dbname']=$dbname='product_class';

		$dbdata=$this->mymodel->select_page_form($dbname,$qpage['result'],'*',array('lang_type'=>$this->setlang));
		$data['dbdata']=$dbdata;
		//分頁程式 start
		$data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		$qpage=$this->useful->SetPage($dbname,'',20,array('lang_type'=>$this->setlang));		
		$data['page']=$this->useful->get_page($qpage);
		//分頁程式 end	

		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/product_class_list', $data);
	}
	//產品分類內頁
	public function product_class_info($id=''){


		//權限判斷,array('p_main_cid'=>0)'p_main_cid'=>0
		$this->useful->CheckComp('j_comlist');

		$data['dbname']=$dbname='product_class';
		$dbdata=$this->mmodel->select_from($dbname,array('prd_cid'=>$id));
		$data['dbdata']=$dbdata;
		
		$data['protype']=$this->mymodel->select_page_form('product_class','','*',array('lang_type'=>$this->setlang,'p_main_cid'=>1));

		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view('products/product_class_info', $data);
	}



	
	//產品列表
	public function products_list(){
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$img_url='/uploads/000/000/0000/0000000000/products/';

		//資料庫名稱
		$data['dbname']=$dbname='products';

		if((!empty($_POST['product_class']) or !empty($_POST['product_status']) and $_POST['product_status']!=3)){
			if($_POST['product_status']==4)$_POST['product_status']=0;

		    //分頁程式 start
		    $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		    $qpage=$this->useful->SetPage($dbname,$Topage,20,array('lang_type'=>$this->setlang,'d_enable'=>"Y",'prd_cid'=>$_POST['product_class'],'prd_active'=>$_POST['product_status']));		
		    $data['page']=$this->useful->get_page($qpage);
		    //分頁程式 end	

//			$dbdata = $this -> mmodel -> get_order_data($_POST['product_class'],$_POST['product_status'],$this->setlang);
			$dbdata = $this -> select_products_data($qpage['result'],$this->setlang,$_POST['product_class'],$_POST['product_status']);

			$data['product_class']=$_POST['product_class'];
			if($_POST['product_status']==0)$_POST['product_status']=4;
			$data['product_status']=$_POST['product_status'];
		} else {
		    //分頁程式 start
		    $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
		    $qpage=$this->useful->SetPage($dbname,$Topage,20,array('lang_type'=>$this->setlang,'d_enable'=>"Y"));		
		    $data['page']=$this->useful->get_page($qpage);
		    //分頁程式 end	

//echo json_encode($qpage);exit;
			//$dbdata = $this -> mod_admin -> select_from_group_by($qpage['result'],$this->setlang);
			$dbdata = $this -> select_products_data($qpage['result'],$this->setlang);

        }

		foreach ($dbdata as $key => $value) {
			$dbdata[$key]['prd_image']=$img_url.$value['prd_image'];
			$dbdata[$key]['prd_hot']=($value['prd_hot']=='fa fa-heart-o')?'否':'是';
			if($value['prd_active']=='2')
				$act="商品下架";
			elseif($value['prd_active']=='0')
				$act="尚有庫存";
			else
				$act="商品補貨";
			$dbdata[$key]['prd_active']=$act;

			$dbdata[$key]['setview']=$value['view'];
			//20160526瀏覽人數設定
			if(strlen($value['view'])>3){
				$dbdata[$key]['setview']=number_format(floor($value['view']/1000)).'K';
			}

			//搜尋結果-庫存量不足
			if($_POST['product_status']==3){
				if($value['prd_amount']>$value['prd_safe_amount']){
					unset($dbdata[$key]);
				}
				$data['product_status']=$_POST['product_status'];
			}
		}
		$data['dbdata']=$dbdata;

		//產品系列
		$data['cdata']=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang));
		
		
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/product_list', $data);
	}

	private function select_products_data($limit = '',$lang_type='TW',$class='',$status='')
	{
		$sql  = 'SELECT products.*, SUM(products_views.page_view) AS view';
		$sql .= ' FROM products LEFT JOIN products_views ON products.prd_id = products_views.prd_id';
		$sql .= ' where lang_type="'.$lang_type.'"';

        if($class!='')
          $sql.=' and products.prd_cid='.$class;
        if($status!='')
          $sql.=' and products.prd_active='.$status;

		$sql .= ' and products.d_enable="Y" group by products.prd_id';
		if(!empty($limit))
			$sql .= $limit;

		return $this -> db -> query($sql) -> result_array();
	}

	//產品內頁
	public function products_info($id=''){

		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname']=$dbname='products';
		$dbdata=$this->mmodel->select_from($dbname,array('prd_id'=>$id));
		$dbdata['prd_image1']=$dbdata['prd_image'];
		$dbdata['prd_image']='/uploads/000/000/0000/0000000000/products/'.$dbdata['prd_image'];
		
		//商品特點
		$data['prd_describe']=$this->String_Array($dbdata['prd_describe']);
		//影片標題
		$data['prd_video_name']=$this->String_Array($dbdata['prd_video_name']);
		//影片連結
		$data['prd_video_link']=$this->String_Array($dbdata['prd_video_link']);
		//規格名稱
		$data['prd_specification_name']=$this->String_Array($dbdata['prd_specification_name']);
		//規格內容
		$data['prd_specification_content']=$this->String_Array($dbdata['prd_specification_content']);
	
		$data['dbdata']=$dbdata;

		//分類
		$data['protype']=$this->mymodel->select_page_form('product_class','','*',array('lang_type'=>$this->setlang));

		//KV
		$kv=$this->mymodel->GetConfig('','3');
		$data['kv']=$kv['d_val'];
		$data['bonus']=$kv['d_val']*$dbdata['prd_pv'];

		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/product_info', $data);
	}
	//產品排序
	public function products_sort(){
		//權限判斷
		$this->useful->CheckComp('j_comdata');

		$data['dbname']=$dbname='products';
		if(!empty($_POST['sort'])){
			foreach ($_POST['sort'] as $key => $value) {
				$this->mmodel->update_set($dbname,'prd_id',$value,array('hot_sort'=>$key));	
			}
			unset($_POST['sort']);
			echo '<script>alert("修改完成");window.location.href="/products/products_sort";</script>';
		}else{
			
			$dbdata=$this->mmodel->select_from_order($dbname,'hot_sort','asc',array('prd_hot'=>'fa fa-heart'));
			//總數
			$data['hot_num']=count($dbdata);
			$img_url='/uploads/000/000/0000/0000000000/products/';
			foreach ($dbdata as $key => $value) {
				$dbdata[$key]['prd_image']=$img_url.$value['prd_image'];
			}
			$data['dbdata']=$dbdata;
		}
		//檔案名
		$data['DataName']=$this->DataName;
		//view
		$this->load->view(''.$this->DataName.'/products_sort', $data);
	}
	//--AJAX 開啟關閉資料專用
	public function oc_data(){
		$DB=$this->input->post('DB');		//資料表
		$field=$this->input->post('field');	//欄位名稱
		$id=$this->input->post('id');		//修改ID 需有分號區隔
		$oc=$this->input->post('oc');		//Open Close Value

		$id_val=explode(';',$id);

		if($oc=='1'||$oc=='2'||$oc=='0')
			$is_filed='prd_active';
		else
			$is_filed='prd_hot';
		
		if($oc=='E')
			$oc='fa fa-heart-o';
		elseif($oc=='L')
			$oc='fa fa-heart';
		foreach ($id_val as $value) {
			$this->mmodel->update_set($DB,$field,$value,array($is_filed=>$oc));
		}
		echo '修改成功';
	}
	//--AJAX 開啟關閉資料專用

	//資料增刪修
	public function data_AED($dbname='',$del_id=''){
		$d_id='d_id';
		$img_url='/uploads/000/000/0000/0000000000/products/';
		if(!is_dir('.'.$img_url))
			mkdir('.'.$img_url,0777);
		
		if($del_id!=''){
			
			if($dbname=='product_class')
				$d_id='prd_cid';
			
			if($dbname=='products'){
				$d_id='prd_id';
				$this->mmodel->update_set($dbname,$d_id,$del_id,array('d_enable'=>'N'));
				$this->useful->AlertPage('','刪除成功');
				return '';
			}

			$this->mmodel->delete_where($dbname,array($d_id=>$del_id));
			$msg='刪除成功';
		}else{
			$id=$_POST['d_id'];
			$dbname=$_POST['dbname'];

			if($dbname=='products'){
				$d_id='prd_id';
				if($_POST['restrice_num']!='0'){
					if($_POST['prd_lock_amount'] > $_POST['restrice_num']){
						echo '<script>alert("單次購買數量不得大於限購數量");history.go(-1);</script>';
						return '';
					}
				}
				if($_POST['prd_pv']<=0){
					$this->useful->AlertPage('','PV值不得小於等於零');
					return '';
				}


				//圖檔上傳
				//model
				$this->load->model('upload_model', 'mod_upload');
				if($_FILES['prd_image']['error'] != 4)
				{
					$img=$this->mod_upload->upload_product($_FILES['prd_image'], $img_url);
					$_POST['prd_image']=$img['path'];
					if($id){
						unlink('.'.$img_url.$_POST['prd_image_hide']);
						unlink('.'.$img_url.'set_'.substr($_POST['prd_image_hide'],1));
					}
				}else
				{
					$_POST['prd_image']=$_POST['prd_image_hide'];
				}
				unset($_POST['prd_image_hide']);
				//商品特點			
				$_POST['prd_describe']=$this->Array_String($_POST['prd_describe']);
				//影片標題
				$_POST['prd_video_name']=$this->Array_String($_POST['prd_video_name']);
				//影片連結
				$_POST['prd_video_link']=$this->Array_String($_POST['prd_video_link']);
				//規格名稱
				$_POST['prd_specification_name']=$this->Array_String($_POST['prd_specification_name']);
				//規格內容
				$_POST['prd_specification_content']=$this->Array_String($_POST['prd_specification_content']);

				$_POST['prd_content'] = str_replace("\"", "&quot;", $_POST['prd_content']);
				
				// 更改PV寫入LOG
				$Chkdata=$this->mymodel->OneSearchSql('products','prd_pv,prd_name',array('prd_id'=>$id));
				if($Chkdata['prd_pv']!=$_POST['prd_pv']){
					$content='管理員'.$_SESSION['AT']['account_name'].'-更改'.$Chkdata['prd_name'].'的PV('.$Chkdata['prd_pv'].'->'.$_POST['prd_pv'].')';
					$this->mymodel->WriteLog('2',$content);
				}
			}
		
			if($id){
				$data=$this->useful->DB_Array($_POST);
			}else{
				$data=$this->useful->DB_Array($_POST,1);
			}
			
			if($dbname=='product_class'){
				$d_id='prd_cid';
			}


			
			unset($data['dbname']);
			unset($data['d_id']);
		
			if($id){
				$this->mmodel->update_set($dbname,$d_id,$id,$data);
				$msg='修改成功';
			}else{
				
				$create_id=$this->mmodel->insert_into($dbname,$data);
				if($create_id)
					$msg='新增成功';
				else
					$msg='新增失敗';
			}
		}
		echo '<script>alert("'.$msg.'");window.location.href="/'.$this->DataName.'/'.$dbname.'_list";</script>';
	}
	//陣列轉字串
	private function Array_String($array,$sub='*#'){
		$str = '';
		if(!empty($array))
		{
			foreach ($array as $dvalue) {
				$str.=$sub.$dvalue;
			}
		}
		return $str;
	}
	//字串轉陣列
	private function String_Array($String,$sub='*#'){
		$str=explode($sub,$String);
		array_shift($str);
		return $str;
	}

	

	public function ajax_product(){//讀取產品分類
		
		$p_main_cid = $_POST['p_main_cid'];

		$data=$this->mymodel->select_page_form('product_class','','prd_cid,prd_cname',array('lang_type'=>$this->setlang,'p_main_cid'=>$p_main_cid));

		
		$res="<select id='p_sub_cid'><option id="0">請選擇</option> ";
		foreach ($data as $key => $value) {
			$res .= " <option id='$value[prd_cid]'>$value[prd_cname]</option> ";//將對應的型號項目遞迴列出
		}
		$res .= "</select>";
		echo $res;//將型號項目丟回給ajax
		
		
	}
}
