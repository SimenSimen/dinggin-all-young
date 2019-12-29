<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    div.config-div {
      margin-top: 20px;
      margin-left: 40px;
    }
    div.config-div-img {
      margin-left: 68%;
    }
    div.config-div-encrypt {
      margin-left: 68%;
    }
    div.config-div fieldset {
      display: inline;
      float: left;
    }
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
    }
    fieldset.config-border-img, fieldset.config-border-encrypt {
      width: 100px;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
              text-align: center;
              vertical-align: middle;
    }
    legend.config-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
      width: 130px;
    }
    .member_list_title_td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
      width:150px;
    }
    #member_list tr td
    {
      vertical-align: middle;
    }
    .member_list_input_td
    {
      width:180px;
    }
    input[type=text], .input_select
    {
      background-color: #FDFFE2;
      font-size: 16px;
      color: #000;
    }
  </style>
  <!-- 地區AJAX -->
  <script src="/js/myjava/region.js"></script>
</head>

<left>
<body background="<?//=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="add_fix_form" method="post" action="/order/order_AED" >

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">訂單資料</legend>
        <table id="member_list" class="table table-bordered table-condensed">
        	<tr>
              <td class='member_list_title_td'>訂單編號</td>
              <td class='member_list_input_td'><?=$dbdata['order_id']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>訂單時間</td>
              <td class='member_list_input_td'><?=$dbdata['create_time']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>訂購人姓名</td>
              <td class='member_list_input_td'><?=$dbdata['bname']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>訂購人手機</td>
              <td class='member_list_input_td'><?=$dbdata['bphone']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>付款狀態</td>
              <td class='member_list_input_td'>
              	<select name="status">
                    <? foreach ($status as $key=>$value):?>
                      <option value="<?=$key?>" <?=($dbdata['status']==$key)?'selected':'';?>><?=$value?></option>
                    <? endforeach;?>
                </select>
                <?php echo ($dbdata['atmno']<>'')?"匯款後五碼:".$dbdata['atmno']:"";?>
              </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂單狀態</td>
                <td class='member_list_input_td'>
                  <select name="product_flow" <?if (in_array($dbdata['product_flow'], [3, 4, 5, 6, 8])) { echo 'disabled'; }?>>
                    <? foreach ($product_flow as $key=>$value):?>
                      <option value="<?=$key?>" <?=($dbdata['product_flow']==$key)?'selected':'';?>><?=$value?></option>
                    <? endforeach;?>
                  </select>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>付款方式</td>
                <td class='member_list_input_td'><?=isset($payment_way[$dbdata['pay_way_id']])?$payment_way[$dbdata['pay_way_id']]:""?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>寄送方式</td>
                <td class='member_list_input_td'><?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?>
                  <?=($dbdata['lway_id']==5)? $shop_address:'';?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂購人信箱</td>
                <td class='member_list_input_td'><?=$dbdata['bemail']?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂購人地址</td>
                <td class='member_list_input_td'><?=$dbdata['bcounty'].$dbdata['barea'].$dbdata['baddress']?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>出貨倉庫</td>
                <td class='member_list_input_td'>
                  <select name='warehouse_id'  style="width: 66%;">
                    <option>請選擇出貨倉庫</option>
                    <? foreach ($warehouse as $value) {?>
                      <option value="<?=$value['d_id'];?>" <?=($dbdata['warehouse_id']==$value['d_id'])?'selected':'';?> ><?=$value['d_name'];?></option>
                    <?}?>
                  </select>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">收件人資料</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
              <td class='member_list_title_td'>收件人姓名</td>
              <td class='member_list_input_td'><?=$dbdata['name_buy']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>收件人手機</td>
              <td class='member_list_input_td'><?=$dbdata['phone_buy']?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>收件人信箱</td>
                <td class='member_list_input_td'><?=$dbdata['email_buy']?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>收件人地址</td>
                <td class='member_list_input_td'><?=$dbdata['zip_buy']." ".$dbdata['county_buy'].$dbdata['area_buy'].$dbdata['address_buy']?></td>
            </tr>
        </table>
    </fieldset>
    <?php if($dbdata['product_flow']=="3" || $dbdata['product_flow']=="5" || $dbdata['product_flow']=="7"):?>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">退款資訊</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                <td style="width:120px;" class='center_td white_td'>退款日</td>
                <td class='center_td white_td'><?=($dbdata["back_date"]=="0000-00-00")?"":$dbdata["back_date"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>退款銀行</td>
                <td class='center_td white_td'><?=$dbdata["back_bank"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>退款帳戶</td>
                <td class='center_td white_td'><?=$dbdata["back_account"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>退款備註</td>
                <td class='center_td white_td'><?=$dbdata['back_note']?></td>
            </tr>
            <?if(!empty($dbdata['back_pic'])){?>
           <tr>
                <td class='center_td white_td'>附圖</td>
                <td class='center_td white_td'><img src='<?=$dbdata['back_pic']?>'></td>
            </tr>
            <?}?>
         </table>
    </fieldset>
    <?php endif;?>
    <?php /*if($isOpen_reason):?>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">取消資訊</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                <td style="width:120px;" class='center_td white_td'>取消日</td>
                <td class='center_td white_td'><?=($dbdata["back_date"]=="0000-00-00")?"":$dbdata["back_date"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>取消原因</td>
                <td class='center_td white_td'><?=$dbdata['back_note']?></td>
            </tr>
         </table>
    </fieldset>
    <?php endif;*/?>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">訂購商品明細</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr id='member_list_title_tr'>
            <td>商品條碼</td>
      			<td>商品名稱</td>
      			<td>價錢</td>
      			<td>數量</td>
      			<td>小計</td>
            
    		</tr>
    		<?php if (!empty($oddata)): ?>
        		<?php foreach ($oddata as $key => $value): ?>
          			<tr bgcolor='<?//=$member_auth_color[$key]?>'>
                  <td class='center_td white_td'><?=$value['prd_sn']?></td>
            			<td class='center_td white_td'>
                    <?=$value['prd_name']?>
                    <?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['prd_spec'].')':'';?>                    
                  </td>
            			<td class='center_td white_td'><?=$value['price']?></td>
            			<td class='center_td white_td'><?=$value['number']?></td>
            			<td class='center_td white_td'><?=$value['total_price']?></td>
            		</tr>
        		<?php endforeach; ?>
        		<tr bgcolor='<?//=$member_auth_color[$key]?>'>
								<td class='center_td white_td'></td>
            		<td class='center_td white_td'><?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?></td>
            		<td class='center_td white_td'><?=$dbdata['lway_price']?></td>
            		<td class='center_td white_td'>1</td>
            		<td class='center_td white_td'><?=$dbdata['lway_price']?></td>
            	</tr>
    		<?php endif; ?>
    		<tr bgcolor='<?//=$member_auth_color[$key]?>' align='right'>
            	<td colspan="5" class='center_td white_td'>紅利折抵 <b><?=$dbdata['use_dividend_cost'];?></b> 元，購物金折抵 <b><?=$dbdata['use_shopping_money'];?></b> 元，付款總金額：<span style="color:red;font-weight:bold;"><?=number_format($dbdata['price_money'],2)?> 元</span><br>總金額：<span style="color:red;font-weight:bold;"><?=number_format($dbdata['total_price'],2)?> 元</span></td>
            </tr>
        </table>
    </fieldset>
    
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">發票資訊</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr id='member_list_title_tr'>		
      			<td>發票抬頭		</td>
      			<td>統編</td>
      			<td>發票地址</td>
    		</tr>
          	<tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td class='center_td white_td'><?=$dbdata['receipt_title']?></td>
            	<td class='center_td white_td'><?=$dbdata['receipt_code']?></td>
            	<td class='center_td white_td'><?=$dbdata['receipt_zip']." ".$dbdata['receipt_county'].$dbdata['receipt_area'].$dbdata['receipt_address']?></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>物流公司名稱</td>
            	<?$tracking_name=(!empty($dbdata['tracking_name']))?$dbdata['tracking_name']:Comment::SetValue("tracking_name");?>
            	<td colspan='2' class='center_td white_td'><input type='text' name="tracking_name" id="tracking_name" value="<?=$tracking_name?>" maxlength="45"></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>物流編號</td>
            	<?$tracking_num=(!empty($dbdata['tracking_num']))?$dbdata['tracking_num']:Comment::SetValue("tracking_num");?>
            	<td colspan='2' class='center_td white_td'><input type='text' name="tracking_num" id="tracking_num" value="<?=$tracking_num?>" maxlength="45"></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>出貨日期</td>
            	<?$sale_out_date=!is_null($dbdata['sale_out_date']) ? $dbdata['sale_out_date'] : ''?>
            	<td colspan='2' class='center_td white_td'><input type='date' name="sale_out_date" id="sale_out_date" value="<?=$sale_out_date?>" maxlength="10"></td>
            </tr>
            <tr>
              <td align='center' class='center_td white_td' style='color:red;'>會員載具</td>
              <td colspan='2' class='member_list_input_td'>
                  <select name='vehicle_type'  style="width: 66%;">
                    <option>請選擇會員載具</option>
                    <option value='0' <?=$dbdata['vehicle_type'] == '0' ? 'selected' : ''?>>手機載具</option>
                    <option value='1' <?=$dbdata['vehicle_type'] == '1' ? 'selected' : ''?>>自然人載具</option>
                  </select>
                </td>
            </tr>
            <tr>
              <td align='center' class='center_td white_td' style='color:red;'>載具號碼</td>
              <td colspan='2' class='center_td white_td'><input type="text" value=<?=$dbdata['vehicle_no']?> name='vehicle_no'></input></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>發票日期</td>
            	<?$receuot_date=($dbdata['receipt_date']!="0000-00-00")?$dbdata['receipt_date']:"";?>
            	<td colspan='2' class='center_td white_td'><input type='date' name="receipt_date" id="receipt_date" value="<?=$receuot_date?>" maxlength="10"></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>發票號碼</td>
            	<td colspan='2' class='center_td white_td'>
            	  <select name="get_sInvoice" id="get_sInvoice">
              	    <option value="">自動選擇發票號碼...</option>
              	    <?php $get_sInvoice_value="";
              	  		foreach($get_sInvoice as $key=>$val):
              	  			$d_num=($val["d_now_num"]<$val["d_start"])?$val["d_start"]:($val["d_now_num"]+1);
              	  			$selected="";
              	  			if(empty($get_sInvoice_value)):
              	  				//$get_sInvoice_value=$val["d_code"].substr("00000000".$d_num,-8);
              	  				//$selected="selected";
              	  			endif;
              	  			$d_num_s=($val["d_now_num"]<$val["d_start"])?$val["d_code"].substr("00000000".$val["d_start"],-8):$val["d_code"].substr("00000000".$d_num,-8);
              	  			echo '<option value="'.$val["d_id"].'" val="'.$d_num_s.'" '.$selected.'>'.$val["d_start_end"].' 已開日期：'.$val["d_date"].' 發票號碼：'.$d_num_s.'</option>';
              	  		endforeach;?>
              	  </select><BR><BR>
              	  <?php $receipt_num=isset($_POST['receipt_num'])?Comment::SetValue("receipt_num"):$dbdata['receipt_num'];
              		 // $receipt_num=empty($receipt_num)?$get_sInvoice_value:$receipt_num;?>
            	  <input type='text' name="receipt_num" id="receipt_num" value="<?=$receipt_num?>" maxlength="10">
            	</td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="config-border"><legend class="config-border" style="width:160px">消費者備註</legend><?=$dbdata['buyer_note']?></fieldset>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">備註</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td colspan='3' class='center_td white_td'><textarea name="note" rows="3" cols="75"><?=$dbdata['note']?></textarea></td>
            </tr>
            <tr>
              <?if($subbonus['is_return']=='Y'):?>
              <td>  退還紅利紀錄:<?=$subbonus['return_time'].'由'.$subbonus['d_operator'].'操作退還紅利'?></td>
              <? endif;?>
            </tr>
         </table>
    </fieldset>   
        
    <div style="width:65%">
    <table id="member_list" class="table table-bordered table-condensed">
    <tr>
            	<td colspan="3" style="text-align:left;">
              		<input type="hidden" name="d_id" value="<?=$dbdata['id']?>">
              		<input type="hidden" name="dbname" value="order">
              		<?php /*//此 項目客戶討論中,暫時隱藏?>
              		<input class="btn btn-info btn-large" id="out_print_action" type="button" style="width: 120px;font-size: 18px;" value='出貨單列印'>
          			<?php */?>
                  <? if(!empty($receipt_num)): //20160624-有發票號才顯示?>
              		  <input class="btn btn-info btn-large" id="invoice_print_action" type="button" style="width: 100px;font-size: 18px;" value='發票列印'>
                  <? endif;?>
                  <?/* if($dbdata['status']==2): //20160624-退款才顯示?>
              		  <input class="btn btn-info btn-large" id="discount_print_action" type="button" style="width: 110px;font-size: 18px;" value='折讓單列印'>
                  <? endif;*/?>
                  <!-- 20160623-新增功能-退還紅利 --> 
                  <? if(!empty($subbonus) and $subbonus['is_return']!='Y'):?>
                    <input type="hidden" value="<?=$subbonus['bonus_sub']?>" name="subbonus">
                    <input class="btn btn-info btn-large" id="return_bonus" type="button" style="width: 100px;font-size: 18px;" value='退還紅利'>
                  <? endif;?>
              		<input class="btn btn-info btn-large" id="fix_data_action" type="button" style="width: 100px;font-size: 18px;" value='儲存'>

              		<input class="btn btn-info btn-large" id="return_now_action" type="button" style="width: 100px;font-size: 18px;" value='返回列表'>
                  
            	</td>
          	</tr>
          	</table></div>
  </div>
  <input type="hidden" id="parm" value="">
</form>


<p style="height:200px;"></p>

</body>
</html>
<script>
function ajax_dInvoice(dInvoice){
	$.post("/order/ajax_dInvoice",
    	{
        	"ajax":"ajax",
        	"dInvoice":dInvoice,
        	"parm":new Date().getTime()
        },
       		function(data,status){
        		if(status=="success"){
        			var option_array = JSON.parse(data);
        			$("#get_sInvoice option[value!='']").remove();
        			$("#sInvoice").val(option_array.get_sInvoice_value);
        			for(var i=0;i<option_array.data.length;i++){
        				$("#get_sInvoice").append("<option value='"+option_array.data[i].d_id+"' val='"+option_array.data[i].value+"' "+option_array.data[i].selected+">"+option_array.data[i].title+"</option>");
        				if(option_array.data[i].selected=="selected"){
        					$("#receipt_num").val(option_array.data[i].value);
        				}
        			}
				}
        	}
	);
}
$(function() {
	$("#fix_data_action").click(function(){
		if(confirm('確定修改資料')){
			$("#parm").val(new Date().getTime());
			$("#add_fix_form").attr('action','/order/order_AED');
			$("#add_fix_form").submit();
		}
	});
	$("#return_now_action").click(function(){
		$("#parm").val(new Date().getTime());
		$("#add_fix_form").attr('action','/order/order_list');
		$("#add_fix_form").submit();
	});
	$("#out_print_action").click(function(){
		$("#parm").val(new Date().getTime());
		$("#add_fix_form").attr('action','/order/order_out_print');
		$("#add_fix_form").submit();
	});
	$("#invoice_print_action").click(function(){
		$("#parm").val(new Date().getTime());
		$("#add_fix_form").attr('action','/order/order_invoice_print');
		$("#add_fix_form").attr('target','invoice');
		$("#add_fix_form").submit();
		$("#add_fix_form").attr('target','');
	});
	$("#discount_print_action").click(function(){
		$("#parm").val(new Date().getTime());
		$("#add_fix_form").attr('action','/order/order_discount_print');
		$("#add_fix_form").submit();
	});	
	$("#get_sInvoice").change(function(){
		$("#receipt_num").val($(this).find('option:selected').attr("val"));
	});
	$("#receipt_date").change(function(){
		ajax_dInvoice($(this).val());
	});


  $("#return_bonus").click(function(){
    if(confirm('確認退還?確認後將無法取消交易!')){
      $("#parm").val(new Date().getTime());
      $("#add_fix_form").attr('action','/order/return_bonus');
      $("#add_fix_form").submit();
    }
  }); 
});
</script>
