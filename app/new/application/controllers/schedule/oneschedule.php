<?php
class OneSchedule extends MY_Controller
{	
	public $web_title='';
	//初始化
	public function __construct(){
		parent::__construct();

		//helper
		$this->load->helper('url');

		//library
		$this->load->library('encrypt');

		$this->load->model('order_model',omodel);
		//model
		$this->load->model('/MyModel/mymodel');	
		$this->load->library('/mylib/useful');

		//web config
		$this->data['web_config']=$this->get_web_config(1);
	}
	
	//一天需執行的資料
	public function index(){
		$stime='00:00:01';	//00:00:01
		$stime1='23:59:59';	//23:59:59

		//抓取今天
		$today=date("Y-m-d");
		// 抓取昨天
		$yesday=date("Y-m-d", strtotime($today."-1 day"));
		 // echo $yesday;
		//昨天開始時間點
		$ystart=strtotime($yesday.$stime);
		//昨天結束時間點
		$yend=strtotime($yesday.$stime1);

		//VIP會員到期30日前通知admin
		$mdata=$this->mymodel->select_page_form('member','','deadline',array('auth'=>'02'));
		foreach ($mdata as $key => $value) {
			$deadline=round(($value['deadline'] - time()) / 86400);
			if($deadline>30){
				unset($mdata[$key]);
			}
		}
		$dnum=count($mdata);
		//會員心得投稿
		$rdata=$this->omodel->api_range('4',$ystart,$yend);
		$rnum=count($rdata);
		//安全庫存不足
		$pdata=$this->mymodel->select_page_form('products','','prd_amount,prd_safe_amount');
		foreach ($pdata as $pkey => $pvalue) {
			if($pvalue['prd_amount']>$pvalue['prd_safe_amount'])
				unset($pdata[$pkey]);
		}
		$pnum=count($pdata);

		$message='
		系統管理者  您好：<br><br>

		提醒您，eoneda系統新增待處理通知如下，<br><br>

		請於後台登入您的管理帳密進行處理。<br>
		eoneda後台：<a href="http://eoneda.appplus.com.tw/" style="font-family:Verdana;font-size:90%" target="_blank">eoneda.appplus.<wbr>com.tw</a><br><br><br>
		<div style="width:1000px;padding:0; margin:0; font-family:"微軟正黑體", "新細明體", "標楷體", Arial; font-size:.8em; display:block; text-align:right; font-size:1.1em;">
			<table width="0" border="0" cellpadding="0" cellspacing="0" style="width:100%;color:rgb(0,0,0);font-size:0.9em;display:block;padding:10px 5px">
 			<tbody>
 			<tr>
 				<th colspan="4" style="padding:8px;color:rgb(255,255,255);background:rgb(122,161,73)">eoneda系統通知</th>
 			</tr>';
      
        if(!empty($dnum)):
		$message.='	<tr>
				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>VIP會員到期</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>
							到期VIP會員資料&nbsp;<font color="#ff0000">'.$dnum.'</font> 筆<br>
						</li>
					</ul>
				</td>
			</tr>';
		endif;
		if(!empty($rnum)): 
		$message.='	<tr>
				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>心得投稿</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>新增待審核 會員心得投稿 <font color="#ff0000">'.$rnum.'</font> 筆<br></li>
					</ul>
				</td>
			</tr>';
		endif;
		if(!empty($pnum)):
 		$message.='	<tr>
 				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>安全庫存</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>低於安全庫存商品<font color="#ff0000">'.$pnum.'</font> 筆<br></li>
					</ul>
					<font style="font-weight:bold">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</font>
				</td>
			</tr>';
		endif;
		$message.='
	 		</tbody>
	 		</table>
		</div>
		<div style="font-size:0.9em;display:block;padding:10px 5px;font-style:italic"><span style="font-size:0.9em">※此信件為系統發出信件，請勿直接回覆，謝謝！</span></div>
		';

		
		// // 寄信
		if(!empty($dnum) or !empty($rnum) or !empty($pnum) ): 
			$cdata=$this->mymodel->GetConfig('','65');
			$mail=explode(';',$cdata['d_val']);
			foreach ($mail as $key => $value) {
			 	$this->mod_index->send_mail('service@i-qrcode.com', $this->data['web_config']['title'], $value, 'eoneda管理者系統通知', $message);	
			}
		endif;


		//--------------------購物紅利-七天後發送---------------------
		//撈取獎金尚未生效名單
		$dbdata=$this->mymodel->select_page_form('`dividend`','','d_id,OID,buyer_id,d_val,SUBSTRING(date_add(create_time,INTERVAL 1 week),1,10)  as ship_time',array('is_send'=>'N','d_type!'=>20));
		// $dbdata=$this->mymodel->select_page_form('`dividend`','','d_id,buyer_id,OID,d_val,SUBSTRING(create_time,1,10)  as ship_time',array('is_send'=>'N','d_type!'=>20));
	    foreach ($dbdata as $value) {
	    	// 檢查是否已結帳
	    	$odata=$this->mymodel->OneSearchSql('`order`','status',array('status'=>'1','product_flow'=>'4','id'=>$value['OID']));
	    	if(!empty($odata)){
		    	if(strtotime($today)>=strtotime($value['ship_time'])){
		    		$mdata=$this->mymodel->OneSearchSql('buyer','d_dividend',array('by_id'=>$value['buyer_id']));
		    		$dividend=$mdata['d_dividend']+$value['d_val'];
		    		$this->mymodel->update_set('buyer','by_id',$value['buyer_id'],array('d_dividend'=>$dividend));
		    		$this->mymodel->update_set('dividend','d_id',$value['d_id'],array('is_send'=>'Y'));
		    	}	    		
	    	}
	    }
	    //--------------------壽星紅利----------------------

	   	//撈取會員今天生日
	   	$mddate=date('m-d');
	   	// $mddate='05-28';
	   	$mdata=$this->mymodel->select_page_form('buyer','','by_id,d_dividend',array('SUBSTRING(birthday,6)'=>$mddate));
	   	//撈取會員壽星紅利
	   	$bonus=$this->mymodel->GetConfig('','10');

	   	// 去年 今年
	   	$yesday=date("Y-m-d", strtotime(date('Y-m-d')."-1 year"));

	   	foreach ($mdata as $mvalue) {
	   		// 去年是否有訂單
	   		$odata=$this->mymodel->WriteSQL('select id from `order` where create_time between "'.$yesday.'" and "'.date('Y-m-d').'" and by_id='.$mvalue['by_id'].'','1');
	   		
	   		
	   		// 去年有訂單 部扣點數 +500 沒有訂單 -500 加500
	   		if(!empty($odata)){
	   			$d_dividend=$mvalue['d_dividend']+$bonus['d_val'];
	   		}else
	   			$d_dividend=$mvalue['d_dividend'];

	   		// $this->mymodel->update_set('buyer','by_id',$mvalue['by_id'],array('d_dividend'=>'0'));
	   		$this->mymodel->update_set('buyer','by_id',$mvalue['by_id'],array('d_dividend'=>$d_dividend));
	   		// $this->mymodel->delete_where('dividend',array('buyer_id'=>$mvalue['by_id']));

	   		$iaddata=array(
				'buyer_id'=>$mvalue['by_id'],
				'd_type'=>'44',
				'd_val'=>$bonus['d_val'],
				'd_des'=>'生日快樂，發送'.$bonus['d_val'].'壽星紅利',			
				'is_send'=>'Y',			
				'create_time'=>$this->useful->get_now_time(),
				'update_time'=>$this->useful->get_now_time(),
			);
	   		$this->mymodel->insert_into('dividend',$iaddata);
	   	}
	   	// 記LOG
		$this->WriteLog();
	}

	// 寫入LOG
	private function WriteLog(){
		$this->mymodel->InsertData('schedule_log',array('d_type'=>'O','create_time'=>$this->useful->get_now_time()));
	}
} 
