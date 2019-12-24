<?php
include_once("/var/www/html/chrdc/conf/CConf.php");
include_once("/var/www/html/chrdc/class_general/CMySQL.php");
include_once("class.phpmailer.php");
$mysqlMain=new CMySQL(CMainConf::HOST,CMainConf::PORT,CMainConf::DATABASE,CMainConf::USER,CMainConf::PASSWD);
function upsql($mysqlMain,$is_run){
	$sqlAE="update server_message set d_update_date='".date("Y-m-d")."',d_update_time='".date("H:i:s")."',d_is_run='".$is_run."' where d_type='SM'";
	$mysqlMain->query($sqlAE);
}
$command="select * from server_message where d_type='SM'";
$result1=$mysqlMain->resultSet($command);
while($record1=mysql_fetch_assoc($result1)){
	if($record1["d_is_run"]=="N"){
		upsql($mysqlMain,'Y');//更新資料並鎖定資料表
		$mail = new PHPMailer();
		$mail->IsSMTP();// send via SMTP
		$mail->SMTPAuth = false; // turn on SMTP authentication打開SMTP認證
		$mail->CharSet = "utf-8";
		//while(true){
		echo date("Y-m-d H:i:s",time())."\n";
		$command="select * from send_mail where sm_is_send='N'";
		$result=$mysqlMain->resultSet($command);
		while($record=mysql_fetch_assoc($result)){
			$mail->Host = $record["sm_send_host"];//寄信主機
			//$mail->Username = "";//寄信主機的登入帳號
			//$mail->Password = "";//寄信主機的登入密碼
			$mail->From = $record["sm_send_e_mail"];//寄件者mail
			$mail->FromName = $record["sm_send_name"];//寄件者名稱
			//$mail->AddAddress("jeff.juo@msa.hinet.net");//收件者mail
			//$mail->AddReplyTo("info@site.com","Information");//收件者要回信的mail及名稱
			//$mail->WordWrap = 50; //設定幾個字後換行
			//$mail->AddAttachment("/var/tmp/file.tar.gz");//夾檔
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");//夾多檔
			$mail->IsHTML(true);//網頁格式
			$mail->Subject = $record["sm_title"];//信件標題
			$mail->Body = $record["sm_content"];//信件內容(網頁格式)
			$mail->AddAddress($record["sm_re_e_mail"],$record["sm_re_name"]);//收件者mail及名稱
			if($mail->Send()) {
				$mail->ClearAddresses();//清除收件者mail
				$sqlAE="delete from send_mail where sm_id=".$record["sm_id"]."";
				$mysqlMain->query($sqlAE);
				echo "send mail ".$record["sm_re_e_mail"]." , name is ".$record["sm_re_name"]." ok\n";
			}
			else{
				$sqlAE="update send_mail set sm_error_message='".$mail->ErrorInfo."',sm_is_send='Y' where sm_id=".$record["sm_id"]."";
				$mysqlMain->query($sqlAE);
				//$mail->ErrorInfo;//錯誤訊息
				echo "send mail ".$record["sm_re_e_mail"]." , name is ".$record["sm_re_name"]." error_message:".$mail->ErrorInfo."\n";
			}
			upsql($mysqlMain);
		}
		mysql_free_result($result);
		upsql($mysqlMain,'N');//更新資料並解鎖資料表
		//sleep(150);
		//}
	}
}
mysql_free_result($result1);
?>