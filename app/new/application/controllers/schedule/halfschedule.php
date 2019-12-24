<?php
class HalfSchedule extends MY_Controller
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
	
	//半日通知 每日0800與1500
	public function index(){
		$today=date('Y-m-d');
		// $today='2016-06-23';

		// $testtime=strtotime('2016-06-23 15:00:00');
		//現在時間
		$now=date('Hi');
		// $now='1500';

		$stime='15:00:01';	//15:00:01
		$stime1='08:00:01';	//08:00:01

		// 抓取昨天
		$yesday=date("Y-m-d", strtotime($today."-1 day"));
		 // echo $yesday;
		//昨天時間點
		$ystrto=strtotime($yesday.$stime);
		//今天時間點
		$tstrto=strtotime($today.$stime1);
		// VIP到期通知 30天
		$this->SendMember();

		if($now=='0800'){
			$odata=$this->omodel->api_range('1',$ystrto,time());
			// $odata=$this->omodel->api_range('1',$ystrto,$testtime);
		}
		if($now=='1500'){
			$odata=$this->omodel->api_range('1',$tstrto,time());
			// $odata=$this->omodel->api_range('1',$tstrto,$testtime);
		}

		// 訂單通知（新增訂單、申請退貨等）
		$status=$this->mymodel->GetConfig('orderstatus');
		$atmnum=0;
		if(!empty($odata)){
			foreach ($odata as $ovalue){
				// ATM匯款通知
				if($ovalue['status']==3){
					$atmnum++;
					continue;
				}
				// ATM匯款通知
				foreach ($status as $svalue) {
					if($svalue['d_val']==$ovalue['product_flow'])
						$stitle=$svalue['d_title'];
				}
				$order[$stitle]=count($order[$stitle])+1;
			}
		}
		// 訂單通知（新增訂單、申請退貨等）

		// 客服中心留言（國鼎客服）
		$cdata=$this->omodel->api_range('2',$tstrto,time());
		// $cdata=$this->omodel->api_range('2',$tstrto,$testtime);
		$connum=count($cdata);		
		// 申請VIP通知
		$mdata=$this->omodel->api_range('3',$tstrto,time());
		// $mdata=$this->omodel->api_range('3',$tstrto,$testtime);
		$memnum=count($mdata);
		
		$message='
		系統管理者  您好：<br><br>

		提醒您，eoneda系統新增待處理通知如下，<br><br>

		請於後台登入您的管理帳密進行處理。<br>
		eoneda後台：<a href="http://eoneda.appplus.com.tw/" style="font-family:Verdana;font-size:90%" target="_blank">eoneda.appplus<wbr>com.tw</a><br><br><br>
		<div style="width:1000px;padding:0; margin:0; font-family:"微軟正黑體", "新細明體", "標楷體", Arial; font-size:.8em; display:block; text-align:right; font-size:1.1em;">
			<table width="0" border="0" cellpadding="0" cellspacing="0" style="width:100%;color:rgb(0,0,0);font-size:0.9em;display:block;padding:10px 5px">
 			<tbody>
 			<tr>
 				<th colspan="4" style="padding:8px;color:rgb(255,255,255);background:rgb(122,161,73)">eoneda系統通知</th>
 			</tr>';
        if(!empty($order)):
 		$message.='
 			<tr>
 				<td width="25%" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>訂單資訊</strong></td>
 				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
 					<div style="font-size:small;font-family:&quot;microsoft jhenghei&quot;,sans-serif">
	 					<ul>';
	 					
	 						foreach ($order as $key=> $ovalue):
	 							$message.= '<li>'.$key.'<font color="#ff0000">'.$ovalue.'</font>筆<br></li>';
	 						endforeach;
	 					
	 		$message.='	</ul>
 					</div>
 				</td>
 			</tr>';
        endif;
        if(!empty($atmnum)):
		$message.='	<tr>
				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>匯款通知</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>
							新增ATM匯款通知&nbsp;<font color="#ff0000">'.$atmnum.'</font> 筆<br>
						</li>
					</ul>
				</td>
			</tr>';
		endif;
		if(!empty($connum)): 
		$message.='	<tr>
				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>客服中心</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>新增未處理客戶信件<font color="#ff0000">'.$connum.'</font> 筆<br></li>
					</ul>
				</td>
			</tr>';
		endif;
		if(!empty($memnum)):
 		$message.='	<tr>
 				<td style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px;text-align:center;background:rgb(241,239,239)"><strong>經營會員</strong></td>
				<td colspan="3" style="border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgb(204,204,204);padding:8px 5px">
					<ul>
						<li>新增申請VIP資料<font color="#ff0000">'.$memnum.'</font> 筆<br></li>
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

		// 寄信
		if(!empty($order) or !empty($atmnum) or !empty($memnum) or !empty($connum)): 
			$cdata=$this->mymodel->GetConfig('','64');
			$mail=explode(';',$cdata['d_val']);
			foreach ($mail as $key => $value) {
			 	$this->mod_index->send_mail('service@i-qrcode.com', $this->data['web_config']['title'], $value, 'eoneda管理者系統通知', $message);	
			}
		endif;
		// 記LOG
		$this->WriteLog();
	}

	// VIP到期通知 30天
	private function SendMember(){
		$dbdata=$this->mymodel->WriteSql('
			SELECT b.name,m.member_id,m.email FROM member m
			inner join buyer b on b.by_id=m.by_id
			where domain_id=1 and ((TO_DAYS(FROM_UNIXTIME(deadline))-TO_DAYS(NOW()))=30)
		');
		foreach ($dbdata as $key => $value) {
			$message='
			'.$value['name'].'  您好：<br><br>

			提醒您，您在eoneda系統-會員即將過期，請點下列連結進行會員續約<br><br>
			<a href="http://'.$_SERVER['HTTP_HOST'].'/gold/renewal?mid='.base64_encode($value['member_id']).'" style="font-family:Verdana;font-size:90%" target="_blank">會員續約</a><br><br><br>';

			$this->mod_index->send_mail('service@i-qrcode.com', $this->data['web_config']['title'], $value['email'], 'eoneda管理者系統通知', $message);	
		}
	}
	// 寫入LOG
	private function WriteLog(){
		$this->mymodel->InsertData('schedule_log',array('create_time'=>$this->useful->get_now_time()));
	}
} 
