<!DOCTYPE html>
<html>
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

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
        <a href="javascript:void(0);" title="<?=$lang['CleanDateStart']?>" class="clear_date" rel="date_start"><?=$lang['OrdersDateStart']?>：</a><input  name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="<?=$lang['OrdersDateStart']?>" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="<?=$lang['CleanDateEnd']?>" class="clear_date" rel="date_end"><?=$lang['OrdersDateEnd']?>：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="<?=$lang['OrdersDateEnd']?>" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="txt" placeholder="<?=$lang['Keyword']?>" value="<?=$_SESSION["AT"]["where"]["txt"];?>">
        <input type="submit" value="<?=$lang['Search']?>" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
        <input id="excel_action" type="button" style="font-size: 14px;" value='<?=$lang['Export']?>'>
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='member_list_title_tr'>		
      <td><?=$lang['Brand']?></td>
      <td><?=$lang['ProductName']?></td>
      <td class="sort" rel="price"><a href="javascript:void(0);" style="color:#FFFFFF"><?=$lang['UnitPrice']?>&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="total_count"><a href="javascript:void(0);" style="color:#FFFFFF"><?=$lang['BackOrderCount']?>&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_count"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="number"><a href="javascript:void(0);" style="color:#FFFFFF"><?=$lang['BackProductCount']?>&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="number"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></a></td>
      <td class="sort" rel="total_price"><a href="javascript:void(0);" style="color:#FFFFFF"><?=$lang['BackAmount']?>&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['brand']?></td>
            <td class='center_td white_td'><?=$value['prd_name']?></td>
            <td class='center_td white_td'><?=$value['price']?></td>
            <td class='center_td white_td'><?=$value['total_count']?></td>
            <td class='center_td white_td'><?=$value['number']?></td>
            <td class='center_td white_td'><?=$value['total_price']?></td>
            
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>
    <input type="hidden" name="sort" id="sort" value="<?=$_SESSION["AT"]["where"]["sort"];?>">
    <input type="hidden" name="sort_ad" id="sort_ad" value="<?=$_SESSION["AT"]["where"]["sort_ad"]?>">
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
	$(".sort").click(function(){
		var sort_ad="asc";
		if($(this).attr("rel")=="<?=$_SESSION["AT"]["where"]["sort"];?>"){
			if("asc"=="<?=$_SESSION["AT"]["where"]["sort_ad"];?>"){
				sort_ad="desc";
			}
		}
		$("#sort_ad").val(sort_ad);
		$("#sort").val($(this).attr("rel"));
		$("#search_form").submit();
	});
	$(".clear_date").click(function(){
		$("#"+$(this).attr("rel")).val("");
	});
	$("#excel_action").click(function(){
		$("#search_form").attr('action','/order/order_back_excel');
		$("#search_form").submit();
		$("#search_form").attr('action','');
	});
  $('#date_start,#date_end').on('dblclick',function(){
		$($(this)).val("");
	});
});
</script>
