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
/*		目前沒用到以下功能暫註解

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

*/
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
		    		$this->mymodel->update_set('dividend','d_id',$value['d_id'],array('is_send'=>'Y','send_dt'=>$this->useful->get_now_time()));
					$redata=array(
						'BID'=>$value['buyer_id'],
						'EID'=>'1',
						'd_type'=>'1',
						'd_bonus'=>$value['d_val'],
						'd_content'=>'排程發送紅利(確認已完成交易)',
						'create_time'=>$this->useful->get_now_time(),
						'update_time'=>$this->useful->get_now_time()
					);
					$this->mymodel->insert_into('dividend_log',$redata);
		    	}	    		
	    	}
	    }
	    //--------------------紅利過期----------------------

			// 去年 今年
	   	$yesday=date("Y-m-d", strtotime(date('Y-m-d')."-1 year"));
			//撈取會員過期紅利
			$mdata=$this->mymodel->SelectSearch('dividend','','GROUP_CONCAT(DISTINCT d_id SEPARATOR ",") d_id,buyer_id,sum(d_val) d_val','WHERE SUBSTRING(send_dt,1,10)<="'.$yesday.'" AND d_type IN (18,19,43,44,66) and is_del="N" GROUP BY buyer_id');
			foreach ($mdata as $mvalue) {
				$mdata1=$this->mymodel->SelectSearch('dividend','','GROUP_CONCAT(DISTINCT d_id SEPARATOR ",") d_id,buyer_id,sum(d_val) d_val','WHERE  d_type IN (20) and is_del="N" and buyer_id='.$mvalue['buyer_id'].' GROUP BY buyer_id');
				if($mvalue['d_val']>$mdata1[0]['d_val']){
					$mdata2=$this->mymodel->select_page_form('buyer','','by_id,d_dividend',array('by_id'=>$mvalue['buyer_id']));
					$d_dividend=$mdata2[0]['d_dividend']-($mvalue['d_val']-$mdata1[0]['d_val']);
					$d_content='扣除過期紅利';

					$this->mymodel->update_set('buyer','by_id',$mvalue['buyer_id'],array('d_dividend'=>$d_dividend));
					$this->mymodel->update_where_array_set('dividend','d_id in('.$mdata1[0]['d_id'].')',array('is_del'=>'Y'));
					$this->mymodel->update_where_array_set('dividend','d_id in('.$mvalue['d_id'].')',array('is_del'=>'Y'));

					$iaddata=array(
						'buyer_id'=>$mvalue['buyer_id'],
						'd_type'=>'75',
						'd_val'=>($mvalue['d_val']-$mdata1[0]['d_val']),
						'd_des'=>'扣除過期紅利'.($mvalue['d_val']-$mdata1[0]['d_val']),
						'is_send'=>'Y',
						'create_time'=>$this->useful->get_now_time(),
						'update_time'=>$this->useful->get_now_time(),
						'send_dt'=>$this->useful->get_now_time(),
					);
					$this->mymodel->insert_into('dividend',$iaddata);
					$redata=array(
						'BID'=>$mvalue['buyer_id'],
						'EID'=>'1',
						'd_type'=>'1',
						'd_bonus'=>($mvalue['d_val']-$mdata1[0]['d_val']),
						'd_content'=>$d_content,
						'create_time'=>$this->useful->get_now_time(),
						'update_time'=>$this->useful->get_now_time()
					);
					$this->mymodel->insert_into('dividend_log',$redata);
				}
	   	}

			//紅利過期30日前通知buyer
			$today_day=date('d');
			if($today==01){
				// 去年 今年
				$yesday=date("Y-m", strtotime(date('Y-m-d')."-11 month"));
				//撈取會員過期紅利
				$mdata=$this->mymodel->SelectSearch('dividend','','buyer_id,sum(d_val) d_val,min(send_dt) send_dt','WHERE SUBSTRING(send_dt,1,7)<="'.$yesday.'" AND d_type IN (18,19,43,44,66) and is_del="N" GROUP BY buyer_id');

				foreach ($mdata as $mvalue) {
					$mdata1=$this->mymodel->SelectSearch('dividend','','sum(d_val) d_val','WHERE  d_type IN (20) and is_del="N" and buyer_id='.$mvalue['buyer_id'].' GROUP BY buyer_id');
					if($mvalue['d_val']>$mdata1[0]['d_val']){
						$mdata=$this->mymodel->select_page_form('buyer','','by_id,by_email',array('by_id'=>$mvalue['buyer_id']));
						$message='
						<p><span style="font-weight: 400;">親愛的會員您好： </span></p>
						<p>&nbsp;</p>
						<p><span style="font-weight: 400;">提醒您 ! 會員帳戶內紅利點數的使用效期為1年。</span></p>
						<p><span style="font-weight: 400;">您有紅利點數</span><span style="font-weight: 400;">'.($mvalue['d_val']-$mdata1[0]['d_val']).'</span><span style="font-weight: 400;">點即將於</span><span style="font-weight: 400;">'.date("Y-m-d", strtotime($mvalue['send_dt']."+1 year")).'</span><span style="font-weight: 400;">到期。</span></p>
						<p><span style="font-weight: 400;">請您把握最後機會，前往</span><a href="http://www.naturefa.com"><span style="font-weight: 400;">超惠購官網</span></a><span style="font-weight: 400;">享受折扣。</span></p>
						<p><span style="font-weight: 400;">紅利點數相關使用說明，請至</span><a href="http://naturefa.com/gold/member"><span style="font-weight: 400;">會員專區</span></a><span style="font-weight: 400;">查詢。</span></p>
						<p>&nbsp;</p>
						<p><span style="font-weight: 400;">超惠購 敬上</span></p>
						<p>&nbsp;</p>
						<p><em><span style="font-weight: 400;">注意：本郵件是由系統自動產生與發送，請勿直接回覆。</span></em></p>
						<p><em><span style="font-weight: 400;">若您有相關問題，歡迎來信客服中心，謝謝！</span></em></p>
						<p><span style="font-weight: 400;">----------------------------------------------------------</span></p>
						<p><span style="font-weight: 400;">超惠購聯絡電話：</span><span style="font-weight: 400;">0424351862</span></p>
						<p><span style="font-weight: 400;">超惠購聯絡地址：</span><span style="font-weight: 400;">台中市北屯區東山路一段50-18號</span></p>
						<p><span style="font-weight: 400;">超惠購客服信箱: </span><a href="mailto:natureFA@vital-wellspring.com"><span style="font-weight: 400;">natureFA@vital-wellspring.com</span></a></p>
						<p><span style="font-weight: 400;">超惠購網址：</span><a href="http://www.naturefa.com"><span style="font-weight: 400;">www.naturefa.com</span></a></p>
						<p><span style="font-weight: 400;">超惠購粉絲專頁：</span><a href="https://www.facebook.com/FragranceAesthetics"><span style="font-weight: 400;">https://www.facebook.com/FragranceAesthetics</span></a></p>';

						// // 寄信
						if(!empty($mvalue['d_val'])){
							$this->mod_index->send_mail('natureFA@vital-wellspring.com', '超惠購', $mdata[0]['by_email'], '【超惠購】紅利點數到期通知', $message);
						}
					}
				}
			}
	    //--------------------壽星紅利----------------------

	   	//撈取會員今天生日
	   	$mddate=date('m-d');
	   	// $mddate='05-28';
	   	$mdata=$this->mymodel->select_page_form('buyer','','by_id,d_dividend',array('SUBSTRING(birthday,6)'=>$mddate));
	   	//撈取會員壽星紅利
	   	$bonus=$this->mymodel->GetConfig('','5112');

	   	// 去年 今年
	   	$yesday=date("Y-m-d", strtotime(date('Y-m-d')."-1 year"));

	   	foreach ($mdata as $mvalue) {
				$d_dividend=$mvalue['d_dividend']+$bonus['d_val'];
				$d_content='排程發送紅利(壽星紅利)';

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
				'send_dt'=>$this->useful->get_now_time(),
			);
	   		$this->mymodel->insert_into('dividend',$iaddata);
			$redata=array(
				'BID'=>$mvalue['by_id'],
				'EID'=>'1',
				'd_type'=>'1',
				'd_bonus'=>$bonus['d_val'],
				'd_content'=>$d_content,
				'create_time'=>$this->useful->get_now_time(),
				'update_time'=>$this->useful->get_now_time()
			);
			$this->mymodel->insert_into('dividend_log',$redata);
	   	}
	   	// 記LOG
		$this->WriteLog();
	}

	// 寫入LOG
	private function WriteLog(){
		$this->mymodel->InsertData('schedule_log',array('d_type'=>'O','create_time'=>$this->useful->get_now_time()));
	}
} 
