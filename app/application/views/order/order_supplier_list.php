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
  <div id='button_table'>
    供應商:<?=$supplier;?><br>
    產品:<?=$prd_id;?><br>
    售價:<?=$price;?><br>
    訂購單明細
  </div>
  <table >
    <tr>
      <td>
        <!--
        <select name="warehouse_select">
          <option value="">請選擇出貨倉庫...</option>
          <?php foreach($warehouse as $val):?>
            <option value="<?=$val['d_id'];?>" <?=((string)$val['d_id']==(string)$_SESSION["AT"]["where"]["warehouse_select"])?'selected':'';?>><?=$val['d_name'];?></option>
          <?php endforeach;?>
        </select>
       <select name="product_flow_select">
          <option value="">請選擇訂單狀態...</option>
          <?php foreach($product_flow as $key=>$val):?>
          	<option value="<?=$key;?>" <?=((string)$key==(string)$_SESSION["AT"]["where"]["product_flow_select"])?'selected':'';?>><?=$val;?></option>
          <?php endforeach;?>
        </select>
       <select name="payment_way_select">
          <option value="">請選擇付款方式...</option>
          <?php foreach($payment_way as $key=>$val):?>
          	<option value="<?=$key;?>" <?=($key==$_SESSION["AT"]["where"]["payment_way_select"])?'selected':'';?>><?=$val;?></option>
          <?php endforeach;?>
        </select>
       <select name="status_select">
          <option value="">請選擇付款狀態...</option>
          <?php foreach($status as $key=>$val):?>
          	<option value="<?=$key;?>" <?=((string)$key==(string)$_SESSION["AT"]["where"]["status_select"])?'selected':'';?>><?=$val;?></option>
          <?php endforeach;?>
        </select>
        <select name="logistics_way_select">
          <option value="">請選擇寄送方式...</option>
          <?php foreach($logistics_way as $key=>$val):?>
          	<option value="<?=$key;?>" <?=($key==$_SESSION["AT"]["where"]["logistics_way_select"])?'selected':'';?>><?=$val;?></option>
          <?php endforeach;?>
        </select>
        <BR><BR>
        <a href="javascript:void(0);" title="清除起始日期" class="clear_date" rel="date_start">訂單起始日期：</a><input name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="清除結束日期" class="clear_date" rel="date_end">訂單結束日期：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="txt" placeholder="關鍵字" value="<?=$_SESSION["AT"]["where"]["txt"];?>">
        <input type="button" value="搜尋" id="search_action" style=" font-size:14px;">
      -->
      <?=!empty($_SESSION["AT"]["where"]["date_start"])?'訂單起始日期：'.$_SESSION["AT"]["where"]["date_start"]:''?>      
      <?=!empty($_SESSION["AT"]["where"]["date_end"])?'訂單結束日期：'.$_SESSION["AT"]["where"]["date_end"].'<br>':''?> 
      <?=!empty($_SESSION["AT"]["where"]["txt"])?'關鍵字:'.$_SESSION["AT"]["where"]["txt"]:''?>

        <input class="btn btn-info btn-large" id="excel_action" type="button" style="width: 100px;font-size: 18px;" value='匯出'>
        <input class="btn btn-info btn-large" id="return_now_action" type="button" style="width: 100px;font-size: 18px;" value='返回列表'>
      </td>
    </tr>
  </table>

  <!--資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:90%;">
      
    <tr id='member_list_title_tr'>
   	  <td>訂單狀態</td>
      <td>訂單編號</td>
      <td>訂單日期</td>
      <td>訂購人</td>
      <!--<td>訂購人信箱</td>-->
      <td>付款方式</td>
      <td>寄送方式</td>
      <td>付款狀態</td>
      <td>明細</td>
      <!--<td>退刷</td>-->
    </tr>
    <!--for-->
    <?php if (!empty($dbdata)): ?>
        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            <td class="center_td white_td"><input type="checkbox" name="ids[]" value="<?php echo $value["id"];?>"/><?=$value['product_flow_txt']?></td>
            <td class='center_td white_td'><?=$value['order_id']?></td>
            <td class='center_td white_td'><?=$value['create_time']?></td>
            <td class='center_td white_td'><?=$value['name']?></td>
            <!--<td class='center_td white_td'><?=$value['email']?></td>-->
            <td class='center_td white_td'><?=$value['pay_way_txt']?></td>
            <td class='center_td white_td'><?=$value['lway_txt']?></td>
            <td class='center_td white_td'><?=$value['status_txt']?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/order/order_supplier_info/<?=$value['id']?>/<?=$url;?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
            <!--<td class='center_td white_td'>
              <? if(!empty($value['backbrush_date'])):?>
                   <i class="fa fa-check-square-o" title="已退款"></i>
              <? elseif($value['backpay']):?>
                <a href="javascript:void(0);" onclick="backtran('<?=$value['id']?>')">
                  <i class="fa fa-backward"></i>
                </a>
              <? endif;?>
            </td>-->
          </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
  </table>
    <?=$page?>
  </form>
</body>
</html>
<script>
$(function() {
  $("#return_now_action").click(function(){
    location.href="/order/order_supplier";
  });
	$(".date-object").datepicker({dateFormat: "yy-mm-dd"});<?php //日期?>
	$(".clear_date").click(function(){
		$("#"+$(this).attr("rel")).val("");
	});
	$("#excel_action").click(function(){
		$("#search_form").attr('action','/order/order_supplier_list_excel/<?=$url;?>');
		$("#search_form").submit();
		$("#search_form").attr('action','');
	});
	$("#search_action").click(function(){
		$("#search_form").attr('action','/order/order_list');
		$("#search_form").submit();
	});	
	$("#chang_product_flow").change(function(){
		if(confirm('確定更改訂單狀態?')){
			$("#search_form").attr('action','/order/order_update_product_flow');
			$("#search_form").submit();
			$("#search_form").attr('action','');
		}else{
			$(this).val('');
		}
	});
	
});
function backtran(oid){
  if(confirm('確定退刷?')){
    location.href="/taishin/backtran/"+oid;
  }
}

</script>