<?=header("Cache-control: private");?>
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

<script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.js"></script> 
<center>
<body background="<?//=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
 <?//=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>
 <form id="search_form" method="post" enctype="multipart/form-data" onsubmit="return check_form(this)">
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
        <!-- <select name="member_d_is_member">
          <option value="">請選擇會員身份...</option>
          <?php foreach($bytype as $key=>$val):?>
          	<option value="<?=$key;?>" <?=((string)$key==$_POST['member_d_is_member'])?'selected':'';?>><?=$val;?></option>
          <?php endforeach;?>
        </select><BR><BR> -->
        <a href="javascript:void(0);" title="清除起始日期" class="clear_date" rel="date_start">訂單起始日期：</a><input name="date_start_member" id="date_start" value="<?php echo $_POST["date_start_member"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     	<a href="javascript:void(0);" title="清除結束日期" class="clear_date" rel="date_end">訂單結束日期：</a><input name="date_end_member" id="date_end" value="<?php echo $_POST["date_end_member"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="txt_member" placeholder="關鍵字" value="<?=$_POST["txt_member"];?>">
        <input type="submit" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
        <?php /*?><input id="excel_action" type="button" style="font-size: 14px;" value='匯出'><?php */?>
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <thead>
    <tr id='member_list_title_tr'>		
      <td>VIP會員姓名</td>
      <td>會員編號</td>
      <td>特殊身份</td>
      <td class="sort" rel="total_count"><a href="javascript:void(0);" style="color:#FFFFFF">下單數&nbsp;<i class="fa fa-sort<?php if($_POST["sort"]=="total_count"):echo "-".$_POST["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td class="sort" rel="total_price"><a href="javascript:void(0);" style="color:#FFFFFF">銷售額&nbsp;<i class="fa fa-sort<?php if($_POST["sort"]=="total_price"):echo "-".$_POST["sort_ad"];endif;?>" aria-hidden="true"></i></td>
      <td>明細</td>
    </tr>
    </thead>
    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?//=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['bname']?></td>
            <td class='center_td white_td'><?=$value['member_num']?></td>
            <td class='center_td white_td'><?=$value['d_spec_type']?></td>
            <td class='center_td white_td'><?=$value['total_count']?></td>
            <td class='center_td white_td'><?=number_format($value['total_price'])?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/bonus/sale_list/<?=$value['member_id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>
    <input type="hidden" name="sort" id="sort" value="">
    <input type="hidden" name="sort_ad" id="sort_ad" value="">
    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
  </table>
    <?=$page?>
  </form>
<p style="height:200px;"></p>

</body>
</html>
<script>
function check_form(frm){
  if(frm.elements['date_start_member'].value>frm.elements['date_end_member'].value){
    alert("開始時間不得低於結束時間");
    return false; 
  }else
    return true;  
}
$(function() {
	$(".date-object").datepicker({dateFormat: "yy-mm-dd"});<?php //日期?>
});
  $(".sort").click(function(){
    var sort_ad="asc";
    if($(this).attr("rel")=="<?=$sort?>"){
      if("asc"=="<?=$sort_ad?>"){
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
</script>
