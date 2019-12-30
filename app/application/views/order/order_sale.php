<!DOCTYPE html>
<html>
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

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

  </table>
  
  <table >
    <tr>
      <td>
        <a href="javascript:void(0);" title="清除起始日期" class="clear_date" rel="date_start">訂單起始日期：</a><input name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="清除結束日期" class="clear_date" rel="date_end">訂單結束日期：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="txt" placeholder="關鍵字" value="<?=$_SESSION["AT"]["where"]["txt"];?>">
        <input type="submit" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
        <input id="excel_action" type="button" style="font-size: 14px;" value='匯出'>
      </td>
    </tr>
    <tr>
      <td>
        <form action="/order/import_order_sale" method="post" enctype="multipart/form-data" id="excel_form" onsubmit="return false;">
          <span>請上傳欲匯入之excel</span><input type="file" style="font-size: 14px;" name="file" form="excel_form" id="excel">
          <input type="submit" style="font-size: 14px;" id="import_excel" form="excel_form" value="確認匯入">
          <a href="<?=base_url().'images/出貨明細範本.xlsx'?>">點我下載範本</a>
        </form>
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
      
    <tr id='member_list_title_tr'>	
      <td>訂單狀態</td>
      <td>訂單編號</td>
      <td>訂單日期</td>
      <td>訂購人</td>
      <!--<td>訂購人信箱</td>-->
      <td>付款方式</td>
<!--      <td>寄送方式</td>-->
      <td>發票資訊</td>
      <td>物流編號</td>
      <td>物流公司名稱</td>
      <td>出貨日期</td>
      <td>付款狀態</td>
      <td>明細</td>
      <!-- <td>修改</td> -->
      <!--<td>退刷</td>-->

      <!-- <td>商品編號</td>
      <td>產品項目</td>
      <td class="sort" rel="number"><a href="javascript:void(0);" style="color:#FFFFFF">銷量&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="number"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></a></td>
      <td class="sort" rel="price"><a href="javascript:void(0);" style="color:#FFFFFF">產品單價&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="total_price"><a href="javascript:void(0);" style="color:#FFFFFF">銷售額&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_price"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="total_count"><a href="javascript:void(0);" style="color:#FFFFFF">下單數&nbsp;<i class="fa fa-sort<?php if($_SESSION["AT"]["where"]["sort"]=="total_count"):echo "-".$_SESSION["AT"]["where"]["sort_ad"];endif;?>" aria-hidden="true"></i></td> -->
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            <td class="center_td white_td">
							<?=$value['product_flow_txt']?>
						</td>
            <td class='center_td white_td'><?=$value['order_id']?></td>
            <td class='center_td white_td'><?=$value['create_time']?></td>
            <td class='center_td white_td'><?=$value['name']?></td>
            <!--<td class='center_td white_td'><?=$value['email']?></td>-->
            <td class='center_td white_td'><?=$value['pay_way_txt']?></td>
<!--            <td class='center_td white_td'><?=$value['lway_txt']?></td>-->
            <td class='center_td white_td'><?php if(!empty($value['receipt_num']) and $value['receipt_date']!='0000-00-00'){ ?><?=$value['receipt_date']?> <?=$value['receipt_num']?><?php } ?></td>
            <td class='center_td white_td'><?=$value['tracking_num']?></td>
            <td class='center_td white_td'><?=$value['tracking_name']?></td>
            <td class='center_td white_td'><?=!$value['sale_out_date'] || $value['sale_out_date'] == '0000-00-00' ? '' : $value['sale_out_date'] ?></td>
            <td class='center_td white_td'><?=$value['status_txt']?></td>
            <td class='center_td white_td'>
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/order/order_supplier_info/<?=$value['id']?>'">
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
  $('#date_start','#date_end').dblclick(function(){
		$($(this)).val("");
	});
	$("#excel_action").click(function(){
		$("#search_form").attr('action','/order/order_sale_excel');
		$("#search_form").submit();
		$("#search_form").attr('action','');
	});
});

$('#import_excel').on('click', () => {
  const fileUploader = document.querySelector('#excel');
  let data = new FormData();
  data.append('file', fileUploader.files[0]);

  $.ajax({
    url: '/order/import_order_sale',
    method: 'POST',
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    dataType: 'JSON',
    success: response => {
      alert('匯入成功')
      location.reload();
    },
    error: () => {
      alert('匯入發生錯誤')
    }
  })
})
</script>
