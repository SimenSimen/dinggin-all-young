<!DOCTYPE html>
<html>
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>銷貨(供應商)報表</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/font-awesome.min.css">

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
    銷貨(供應商)報表
  </table>
  <table >    
    <tr>
      <td>
      <select name='brand_id'  >
        <option value='0'>請選擇品牌</option>
        <? foreach ($brand_list as $value) {?>
          <option value="<?=$value['prd_cid'];?>" <?=($_SESSION["AT"]["where"]["brand_id"]==$value['prd_cid'])?'selected':'';?> ><?=$value['d_name'];?></option>
        <?}?>
      </select>
      <a href="javascript:void(0);" title="清除起始日期" class="clear_date" rel="date_start">訂單起始日期：</a><input name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="清除結束日期" class="clear_date" rel="date_end">訂單結束日期：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
      <input type="text" name="txt" placeholder="關鍵字" value="<?=$_SESSION["AT"]["where"]["txt"];?>">
      <input class="btn btn-info btn-large" type="submit" value="搜尋" style="font-size:18px;" onclick="$(this).closest('form').submit()"/>
      <input class="btn btn-info btn-large" id="excel_action" type="button" style="font-size: 18px;" value='匯出'>   
      <? if(  !empty($_SESSION["AT"]["where"]["supplier_id"]) or !empty($_SESSION["AT"]["where"]["date_start"]) or
              !empty($_SESSION["AT"]["where"]["date_end"]) or !empty($_SESSION["AT"]["where"]["txt"])){?>
          <input class="btn btn-info btn-large" id="return_now_action" type="button" style="width: 100px;font-size: 18px;" value='返回列表'>
      <?}?>
      </td>
    </tr>
  </table>
  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">      
    <tr id='member_list_title_tr'>	
      <td>品牌</td>	
      <td>商品名稱</td>
      <td class="sort" rel="price"><a href="javascript:void(0);" style="color:#FFFFFF">產品單價&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="total_count"><a href="javascript:void(0);" style="color:#FFFFFF">下單數&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_count"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="number"><a href="javascript:void(0);" style="color:#FFFFFF">銷量&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="number"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></a></td>
      <td class="sort" rel="total_price"><a href="javascript:void(0);" style="color:#FFFFFF">銷售總額&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td>明細</td>
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
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/order/order_supplier_list/<?=$value['supplier_id']?>/<?=$value['prd_id']?>/<?=$value['price']?>?del_page=Y'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
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
  $("#return_now_action").click(function(){
    location.href="/order/order_supplier?del_search=Y";
  });
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
		$("#search_form").attr('action','/order/order_supplier_excel');
		$("#search_form").submit();
		$("#search_form").attr('action','');
	});
});
</script>
