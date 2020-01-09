<!DOCTYPE html>
<html>
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }
    .btn
    {
      font-size: 18px;
    }
    #button_table
    {
      width:80%;
      margin-top: 10px;
    }
    #button_table tr td
    {
      padding-top:5px;
      padding-bottom: 5px;
      padding-left: 5px;
    }
    #member_list tr td
    {
      padding: 5px;
    }
    #member_list_title_tr td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
    }
    .white_td
    {
      color: <?=$web_config['admin_font_color']?>;
    }
    .center_td
    {
      text-align: center;
    }
    #password_title_td
    {
      cursor: pointer;
      color: #F99;
    }
    .checkbox_td
    {
      zoom: 150%;
      text-align: center;
      vertical-align: middle;
    }
    .mycheckbox
    {
      cursor: pointer;
    }
    .info_prompt
    {
      text-align: right;
      color: #F60;
      font-size: 14px;
    }
  </style>

</head>
<script src='/js/myjava/allcheck.js'></script>
<center>
   

<body background="<?//=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
 <?//=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>
 <form id="search_form" method="post" enctype="multipart/form-data">
  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:1%;">
        <?php /*?><!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/member/<?=$dbname?>_info'">
          新增用戶
        </button><?php */?>
      </td>
    </tr>

  </table>
  
  <table >
    <tr>
      <td>
        <a href="javascript:void(0);" title="<?=$lang['CleanDateStart']?>" class="clear_date" rel="date_start"><?=$lang['OrdersDateStart']?>：</a><input name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="<?=$lang['CleanDateEnd']?>" class="clear_date" rel="date_end"><?=$lang['OrdersDateEnd']?>：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="txt" placeholder="<?=$lang['Keyword']?>" value="<?=$_SESSION["AT"]["where"]["txt"];?>">
        <input type="button" value="<?=$lang['Search']?>" id="search_action" style=" font-size:14px;">
        <input id="excel_action" type="button" style="font-size: 14px;" value='<?=$lang['Export']?>'>
      </td>
    </tr>
  </table>

  <!--資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:90%;">
      
    <tr id='member_list_title_tr'>
   	  <td><?=$lang['OrderStatus']?></td>
   	  <td><?=$lang['PaymentStatus']?><br>
   	    <select name="chang_status" id="chang_status">
          <option value=""><?=$lang['ChangeOrderStatus']?>..</option>
          <? foreach ($status as $key=>$value){ ?>
						<?php if($key==2 or $key==3){ ?>
            <option value="<?=$key?>"><?=$value?></option>
						<?php } ?>
          <? } ?>
        </select>
			</td>
      <td><?=$lang['OrderNo']?></td>
      <td><?=$lang['BackDate']?></td>
      <td><?=$lang['Buyer']?></td>
      <td><?=$lang['RefundName']?></td>
      <td><?=$lang['RefundBank']?></td>
      <td><?=$lang['RefundAccount']?></td>
      <td><?=$lang['Mofify']?></td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            <td class="center_td white_td"><?=$value['product_flow_txt']?></td>
            <td class='center_td white_td'><input type="checkbox" name="ids[]" value="<?php echo $value["id"];?>"/><?=$value['status_txt']?></td>
            <td class='center_td white_td'><?=$value['order_id']?></td>
            <td class='center_td white_td'><?=($value['back_date']!="0000-00-00")?$value['back_date']:"";?></td>
            <td class='center_td white_td'><?=$value['name']?></td>
            <td class='center_td white_td'><?=$value['back_name']?></td>
            <td class='center_td white_td'><?=$value['back_bank']?></td>
            <td class='center_td white_td'><?=$value['back_account']?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/order/order_back_info/<?=$value['id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>
    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">    
  </table>
    <?=$page?>
  </form>
<p style="height:200px;"></p>

</body>
</html>
<script>
$(function() {
	$(".date-object").datepicker({dateFormat: "yy-mm-dd"});<?php //日期?>
	$(".clear_date").click(function(){
		$("#"+$(this).attr("rel")).val("");
	});
	$("#excel_action").click(function(){
		$("#search_form").attr('action','/order/order_back_list_excel');
		$("#search_form").submit();
		$("#search_form").attr('action','');
	});
	$("#search_action").click(function(){
		$("#search_form").attr('action','/order/order_back_list');
		$("#search_form").submit();
	});	
	$("#chang_status").change(function(){
		if(confirm('確定更改付款狀態?')){
			$("#search_form").attr('action','/order/order_back_update_status');
			$("#search_form").submit();
			$("#search_form").attr('action','');
		}else{
			$(this).val('');
		}
	});
});
</script>
