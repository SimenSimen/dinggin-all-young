<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>電子發票</title>
<!--[if lt IE 9]>
<script src="/mailService/mail/../js/ie8.js"></script>
<![endif]-->
<style type="text/css">
@media print 
{
	.cContent { color: #222222; }/* 列印時是白紙黑字的 */
}
.rl{
 -webkit-writing-mode: vertical-rl;writing-mode: tb-rl;height:610px;font-size: 9px;
}
.table{
    border-collapse:collapse;
    border:1px solid black;
}
.td{
    border:1px solid black;
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body>
<?php
function SetCheck($value){////空值補0
	if(empty($value)){
		return "0";
	}
	else{
		return $value;
	}
}
function SetNumCName($value){//數字轉中文
	$string=array("0"=>"零","1"=>"一","2"=>"二","3"=>"三","4"=>"四","5"=>"五","6"=>"六","7"=>"七","8"=>"八","9"=>"九");
	if(isset($string[$value])){
		return $string[$value];
	}
	else{
		return "";
	}
}
function SetNumCName2($value){//數字轉中文
	$string=array("0"=>"零","1"=>"壹","2"=>"贰","3"=>"參","4"=>"肆","5"=>"伍","6"=>"陸","7"=>"柒","8"=>"捌","9"=>"玖");
	if(isset($string[$value])){
		return $string[$value];
	}
	else{
		return "";
	}
}
function utf8_str_split($str, $split_len = 1){
	if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
		return FALSE;

	$len = mb_strlen($str, 'UTF-8');
	if ($len <= $split_len)
		return array($str);

	preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);

	return $ar[0];
}
function utf8_str_split2($str, $split_len = 1){//智慧型處理好文字
	if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
		return array(0,FALSE,"");

	$len = mb_strlen($str, 'UTF-8');
	if ($len <= $split_len)
		return array(1,$str,"");

	preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
	$txt_num=0;
	$txt="";
	$line_br="";
	$line_num=1;
	foreach($ar[0] as $key=>$val){//中文3位元,英數1位元
		$txt_num+=strlen($val);
		if($txt_num>61){
			$txt_num=strlen($val);
			$line_num+=1;
			$line_br.="<BR>";
		}
		if($line_num>=10){
			$line_num=10;
			$txt.="...";
			break;
		}
		$txt.=$val;
	}
	return array($line_num,$txt,$line_br);
}
$data["orders_details"]=array();
if (!empty($oddata)):
	foreach ($oddata as $key => $value):		
		$data["orders_details"][$key]["d_goods_name"]=$value['prd_name'];
		$data["orders_details"][$key]["d_goods_count"]=$value['number'];
		$data["orders_details"][$key]["d_money"]=$value['price'];
    endforeach;
endif;
/*
$data["orders_details"][0]["d_goods_name"]="負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分_";
$data["orders_details"][0]["d_goods_count"]="9999999";
$data["orders_details"][0]["d_money"]="490989999999";

$data["orders_details"][1]["d_goods_name"]="負離子能量浴場型岩盤浴90分";
$data["orders_details"][1]["d_goods_count"]="2";
$data["orders_details"][1]["d_money"]="380";

$data["orders_details"][2]["d_goods_name"]="負離子能量浴場型岩盤浴90分+頂級玻尿酸面膜20分";
$data["orders_details"][2]["d_goods_count"]="3";
$data["orders_details"][2]["d_money"]="270";
*/
$total_num=0;
$record_num=0;
$datas=array();
foreach($data["orders_details"] as $key=>$val):
	$txt=utf8_str_split2($val["d_goods_name"]);
	$total_num+=$txt[0];
	if($total_num>10){
		$total_num=$txt[0];
		$record_num+=1;
	}
	$data["orders_details"][$key]["line_br"]=$txt[2];
	$data["orders_details"][$key]["d_goods_name"]=$txt[1];
	$datas[$record_num][]=$data["orders_details"][$key];
endforeach;
$title_array_2=array("1"=>"存根聯","2"=>"收執聯");
$title_array_3=array("1"=>"存根聯","2"=>"扣抵聯(買受人為非營業人者，本聯作廢)","3"=>"收執聯");
$next_page=0;
foreach($datas as $key=>$val):
	$n=3;//個人印二聯,公司印三聯
	$title_array=($n==3)?$title_array_3:$title_array_2;
	for($j=1;$j<=$n;$j++):
		$next_page+=1;
?>
	  <table border="0" cellpadding="0" cellspacing="0" width="895" <?php if($next_page%2==0):/*換頁*/?>style="page-break-after:always;"<?php endif;?>>
		<tbody>
		  <tr>
		    <td style="width:60px;"><div class="rl">
		      <span style="margin-top: 110px;">第<?php echo SetNumCName($j);?>聯：<?php echo $title_array[$j];?></span><BR>
		      <span>買受人註記欄之註記方法：
		      	<BR>營業人購進貨物或勞務應先按其用途區分為﹁進貨及費用﹂與﹁固定資產﹂，其進項稅額，除營業稅法第十九條
		      	<BR>第一項屬不可扣抵，其餘均得扣抵，並在各該適當欄內打﹁✔﹂符號。</span>
		    </div></td>
			<td><table bgcolor="#999999" border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody><tr>
				<td bgcolor="#FFFFFF"><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tbody><tr bgcolor="#FFFFFF">
					<td colspan="5"><div align="center"><b><font color="#FF4300" face="標楷體" size="4">國鼎生物科技股份有限公司</font></b></div></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="5"><div align="center"><font color="#FF4300">電 子 計 算 機 統 一 發 票</font></div></td>
				  </tr>
				  
				  <tr bgcolor="#FFFFFF">
				    <td colspan="4" width="70%"><table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
				    	<tr><td><table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
				      <tr bgcolor="#FFFFFF">
				    		<td>
				    			<table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
				      				<tr bgcolor="#FFFFFF">
				    					<td width="50%"><font color="#FF4300">發票號碼：</font><?=$dbdata['receipt_num']?></td>
										<td width="50%"><div align="left">
					  						<font color="#FF4300">中華民國</font>&nbsp;&nbsp;<?php echo (empty($dbdata['date']))?"":date("Y",$dbdata['date']);?>&nbsp;&nbsp;
					  						<font color="#FF4300">年</font>&nbsp;&nbsp;<?php echo (empty($dbdata['date']))?"":date("m",$dbdata['date']);?>&nbsp;&nbsp;
					  						<font color="#FF4300">月</font>&nbsp;&nbsp;<?php echo (empty($dbdata['date']))?"":date("d",$dbdata['date']);?>&nbsp;&nbsp;
					  						<font color="#FF4300">日</font>
										</div></td>
									</tr>
								</table>
							</td>
				 	  </tr>
					  <tr bgcolor="#FFFFFF">
						<td><font color="#FF4300">買&nbsp;&nbsp;受&nbsp;&nbsp;人：</font><?=$dbdata['name']?></td>
				  	  </tr>
				  	  <tr bgcolor="#FFFFFF">
						<td><font color="#FF4300">統一編號：</font><?=$dbdata['receipt_code']?></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
						<td><font color="#FF4300">地　　址：</font><?=$dbdata['receipt_county'].$dbdata['receipt_area'].$dbdata['receipt_address']?></td>
					  </tr>
					  </table></td></tr>
					</table></td>
					<td colspan="1" width="30%"><table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
					  <tr bgcolor="#FFFFFF">
						<td><font color="#FF4300">檢查號碼：</font></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
						<td><font color="#FF4300">貨單編號：</font></td>
					  </tr>
					</table></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="5"><table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tbody><tr>
						<td><table border="0" cellpadding="0" cellspacing="0" width="100%">
						  <tbody><tr>
							<td><table  border="0" cellpadding="0" cellspacing="0" width="100%">
							  <tbody><tr>
								<td class="td"><table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
								  <tbody><tr>
									<td class="td" height="25" valign="middle" width="42%"><div align="center"><font color="#FF4300">品 名</font></div></td>
									<td class="td" height="25" width="11%"><div align="center"><font color="#FF4300">數 量</font></div></td>
									<td class="td" height="25" width="13%"><div align="center"><font color="#FF4300">單 價</font></div></td>
									<td class="td" height="25" width="13%"><div align="center"><font color="#FF4300">金 額</font></div></td>
									<td class="td" height="25" width="20%"><div align="center"><font color="#FF4300">備 註</font></div></td>
								  </tr>
								  <tr valign="top"><!-- 內容最多單行10筆,若有單筆佔二行以上要計算高度  -->
									<td style="height:280px;" class="td">
									<?php foreach($val as $key1=>$val1):?>
									<span><?php echo $val1["d_goods_name"];?></span><br>
									<?php endforeach;?>
									</td>
									<td align="center" class="td">
									<?php foreach($val as $key1=>$val1):?>
									<span><?php echo $val1["d_goods_count"]."&nbsp;".$val1["line_br"];?></span><br>
									<?php endforeach;?>
									</td>
									<td align="center" class="td">
									<?php foreach($val as $key1=>$val1):?>
									<span><?php $tax=floor(($val1["d_money"]/1.05));
									echo $tax."&nbsp;".$val1["line_br"];?></span><br>
									<?php endforeach;?>
									</td>
									<td align="center" class="td">
									<?php 
									$total_moneys=0;
									foreach($val as $key1=>$val1):
										$total_ms=number_format(floor($val1["d_goods_count"]*($val1["d_money"]/1.05)),0,".","");
										$total_moneys+=$total_ms;
									?>
									<span><?php echo $total_moneys."&nbsp;".$val1["line_br"];?></span><br>
									<?php 
									endforeach;
									?>
									</td>
									<td rowspan="5" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" style="border-right-width: 0.0px;" width="100%">
											<tr><td height="180" valign="top" class="td"></td></tr>
											<tr><td height="24" class="td" style="font-size: 10px;text-align:center;">營業人蓋用統一發票專用章</td></tr>
											<tr><td height="200" class="td" align="center"></td></tr>
										</table>
									</td>
								  </tr>
								  <tr>
									<td colspan="3"  class="td" style="height:25px"><div align="center"><font color="#FF4300">銷 售 額 合 計</font></div></td>
										<td class="td" align="right"><?php echo ($total_moneys);?>&nbsp;</td>
								  </tr>
								  <tr>
									<td style="height:25px" colspan="3"><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
									  <tbody><tr>
										<td class="td" width="28%" align="center"><font color="#FF4300">營 業 稅</font></td>
										<td class="td" width="12%" align="center"><font color="#FF4300">應 稅</font></td>
										<td class="td" width="12%" align="center">✔</td>
										<td class="td" width="12%" align="center"><font color="#FF4300">零 稅 率</font>	</td>
										<td class="td" width="12%" align="center"></td>
										<td class="td" width="12%" align="center"><font color="#FF4300">免 稅</font></td>
										<td class="td" width="12%" align="center"></td>
									  </tr></tbody>
									</table></td>
									<td style="height:25px" class="td" align="right"><?php $total_tax=number_format(ceil($total_moneys*0.05),0,".","");
									echo $total_tax;?>&nbsp;</td>
								  </tr>
								  <tr>
									<td class="td" colspan="3" style="height:25px" align="center"><font color="#FF4300">總 計</font></td>
									<td class="td" align="right"><?php $total=($total_moneys+$total_tax);echo $total;?>&nbsp;</td>
								  </tr>
								  <tr>
									<td colspan="4" class="td"><table border="0" cellpadding="0" cellspacing="0" width="100%">
									  <tbody><tr>
										<td nowrap="" valign="bottom" width="15%"><div align="center"><font color="#FF4300">總計新台幣</font></div></td>
<?php 
$numlen=strlen($total);
$end=($numlen>8)?$numlen:8;
$ch_arr=array();
$bi=array("元整","拾","佰","仟","萬","拾<BR>萬","佰<BR>萬","仟<BR>萬","億","拾<BR>億","佰<BR>億","仟<BR>億","兆","拾<BR>兆","佰<BR>兆","仟<BR>兆","京","拾<BR>京","佰<BR>京","仟<BR>京");
$jn=0;
for($i=0;$i<$end;$i++):
	if($numlen<($end-$i)):
		$ch_arr[$i]=SetNumCName2(0);
	else:
		$ch_arr[$i]=SetNumCName2(SetCheck(substr($total,abs($jn),1)));
	$jn+=1;
	endif;
endfor;
foreach($ch_arr as $key2=>$val2):
?>
	<td rowspan="2" width="7%"><div align="center"><?php echo $val2;?></div></td>
	<td rowspan="2" valign="middle" width="2%"><div align="center"><font color="#FF4300"><?php echo isset($bi[count($ch_arr)-1-$key2])?$bi[count($ch_arr)-1-$key2]:"";?></font></div></td>
<?php 
endforeach;
?>
									  </tr>
									  <tr>
										<td nowrap="" valign="top"><div align="center"><font color="#FF4300">( 中文大寫	)</font></div></td>
									  </tr></tbody>
									</table></td>
								  </tr>
								  </tbody>
								</table></td>
								
							  </tr>
							  <tr>
									<td colspan="5" ><br /><table border="0" cellpadding="0" cellspacing="0" width="100%">
						  			  <tbody><tr>
										<td><font style="font-size:11px;color:#FE5624;">※ 應稅、零稅率、免稅之銷售額應分別開立統一發票，並應於各該欄打「✔ 」。 </font></td>
						  			  </tr>
						  			  <tr>
										<td><font style="font-size:11px;color:#FE5624;">說明：1.本發票擅自塗改，即屬無效。  2.本發票依財政部臺灣省　區國稅局　　稽徵所　年　月　日　區國稅　字第　　號函核准使用。</font></td>
						  			  </tr></tbody>
									</table> <br /></td>
					  			  </tr>
					  			  </tbody>
							</table></td>
						  </tr></tbody>
						</table></td>
					  </tr>
					  </tbody>
					</table></td>
				  </tr></tbody>
				</table></td>
			  </tr></tbody>
			</table>
		  </td>
		</tr>
	  </tbody>
	</table>
<?php 
	endfor;
endforeach;
?>
<script>
/*$(function() {
	$("span[id^='span_']").each(function(){
		var br_num=((($(this).height()+2)/19)-1);
		var br="";
		for(i=0;i<br_num;i++){
			br+="<BR>";
		}
		$("#a"+$(this).attr("id")).html($("#a"+$(this).attr("id")).html()+br);
		$("#b"+$(this).attr("id")).html($("#b"+$(this).attr("id")).html()+br);
		$("#c"+$(this).attr("id")).html($("#c"+$(this).attr("id")).html()+br);
	});
});*/
</script>
</body>
</html>