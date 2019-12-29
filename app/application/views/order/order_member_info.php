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
              <td class='member_list_input_td'><?=$dbdata['name']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>訂購人手機</td>
              <td class='member_list_input_td'><?=$dbdata['phone']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>付款狀態</td>
              <td class='member_list_input_td'><?=isset($status[$dbdata['status']])?$status[$dbdata['status']]:""?>
                <?php echo ($dbdata['status']=="3")?"&nbsp;&nbsp;匯款後五碼:".$dbdata['atmno']:"";?>
              </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂單狀態</td>
                <td class='member_list_input_td'><?=isset($product_flow[$dbdata['product_flow']])?$product_flow[$dbdata['product_flow']]:""?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>付款方式</td>
                <td class='member_list_input_td'><?=isset($payment_way[$dbdata['pay_way_id']])?$payment_way[$dbdata['pay_way_id']]:""?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>寄送方式</td>
                <td class='member_list_input_td'><?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂購人信箱</td>
                <td class='member_list_input_td'><?=$dbdata['email']?></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>訂購人地址</td>
                <td class='member_list_input_td'><?=$dbdata['county'].$dbdata['area'].$dbdata['address']?></td>
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
    <?php if($dbdata['product_flow']=="3" || $dbdata['product_flow']=="5" || $dbdata['product_flow']=="7" || $dbdata['product_flow']=="9"):?>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">退款資訊</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                <td style="width:120px;" class='center_td white_td'>退款狀態</td>
                <td class='center_td white_td'><?=$product_flow[$dbdata['product_flow']]?></td>
            </tr>
            <tr>
                <td style="width:120px;" class='center_td white_td'>預計退款日</td>
                <td class='center_td white_td'><?=($dbdata["back_date"]=="0000-00-00")?"":$dbdata["back_date"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>退款銀行</td>
                <td class='center_td white_td'><?=$dbdata["back_bank"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>退款分行</td>
                <td class='center_td white_td'><?=$dbdata["back_bank_branch"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>匯款帳戶</td>
                <td class='center_td white_td'><?=$dbdata["back_name"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>匯款帳號</td>
                <td class='center_td white_td'><?=$dbdata["back_account"];?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>有無稅卡</td>
                <td class='center_td white_td'><?=$dbdata['tax_card_no'] ? '有' : '無'?></td>
            </tr>
            <tr>
                <td class='center_td white_td'>稅卡編號</td>
                <td class='center_td white_td'><?=$dbdata['tax_card_no']?></td>
            </tr>
         </table>
    </fieldset>
    <?php endif;?>
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">訂購商品明細</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr id='member_list_title_tr'>		
      			<td>商品名稱</td>
      			<td>價錢</td>
      			<td>數量</td>
      			<td>小計</td>
    		</tr>
    		<?php if (!empty($oddata)): ?>
        		<?php foreach ($oddata as $key => $value): ?>
          			<tr bgcolor='<?//=$member_auth_color[$key]?>'>
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
            		<td  class='center_td white_td'><?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?></td>
            		<td class='center_td white_td'><?=$dbdata['lway_price']?></td>
            		<td class='center_td white_td'>1</td>
            		<td class='center_td white_td'><?=$dbdata['lway_price']?></td>
            	</tr>
            <?php endif;?>
    		<tr bgcolor='<?//=$member_auth_color[$key]?>' align='right'>
            	<td colspan="4" class='center_td white_td'>紅利折抵 <b><?=$dbdata['use_dividend_cost'];?></b> 元，購物金折抵 <b><?=$dbdata['use_shopping_money'];?></b> 元，付款總金額 ：<span style="color:red;font-weight:bold;"><?=number_format($dbdata['price_money'],2)?> 元</span><br>總金額：<span style="color:red;font-weight:bold;"><?=number_format($dbdata['total_price'],2)?> 元</span></td>
            </tr>
        </table>
    </fieldset>
    <!--
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
            	<td align='center' class='center_td white_td' style='color:red;'>物流編號</td>
            	<td colspan='2' class='center_td white_td'><?=$dbdata['tracking_num'];?></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>發票日期</td>
            	<td colspan='2' class='center_td white_td'><?=($dbdata['receipt_date']!="0000-00-00")?$dbdata['receipt_date']:"";?></td>
            </tr>
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            	<td align='center' class='center_td white_td' style='color:red;'>發票號碼</td>
            	<td colspan='2' class='center_td white_td'><?=$dbdata['receipt_num']?></td>
            </tr>
        </table>
    </fieldset>
  -->
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">備註</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr bgcolor='<?//=$member_auth_color[$key]?>'>
              <td colspan='3' class='center_td white_td'><textarea readonly name="note" rows="3" cols="75"><?=$dbdata['note']?></textarea></td>
            </tr>
         </table>
    </fieldset>   
        
    <div style="width:65%">
    <table id="member_list" class="table table-bordered table-condensed">
    <tr>
            	<td colspan="3" style="text-align:left;">
              		<input type="hidden" name="d_id" value="<?=$dbdata['id']?>">
              		<input type="hidden" name="dbname" value="order">
                  <!-- <input class="btn btn-info btn-large" id="rebuy_order_action" type="button" style="width: 100px;font-size: 18px;" value='建立新訂單'> -->
                  <!-- <input class="btn btn-info btn-large" id="fix_data_action" type="button" style="width: 100px;font-size: 18px;" value='儲存'> -->
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
$(function() {
	$("#rebuy_order_action").click(function(){
		if(confirm('確定建立新訂單')){
			$("#parm").val(new Date().getTime());
			$("#add_fix_form").attr('action','/order/rebuy_order/<?=$dbdata['id']?>');
			$("#add_fix_form").submit();
		}
	});
	$("#return_now_action").click(function(){
		$("#parm").val(new Date().getTime());
		<?php if($type=="back"):?>
			$("#add_fix_form").attr('action','/order/order_back_list');
		<?php else:?>
			$("#add_fix_form").attr('action','/order/order_member_list/<?php echo isset($_SESSION["AT"]["where"]["by_id"])?$_SESSION["AT"]["where"]["by_id"]:"";?>');
		<?php endif;?>
		$("#add_fix_form").submit();
	});
});
</script>
