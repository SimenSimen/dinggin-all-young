 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
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
    <?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
	<table >
    <tr>
      <td>
				<a href="javascript:void(0);" title="清除起始日期" class="clear_date" rel="date_start">訂單起始日期：</a><input name="date_start" id="date_start" value="<?php echo $_SESSION["AT"]["where"]["date_start"];?>" placeholder="訂單起始日期" maxlength='10' class="date-object" type="date" readonly="true"/>
     		<a href="javascript:void(0);" title="清除結束日期" class="clear_date" rel="date_end">訂單結束日期：</a><input name="date_end" id="date_end" value="<?php echo $_SESSION["AT"]["where"]["date_end"];?>" placeholder="訂單結束日期" maxlength='10' class="date-object" type="date" readonly="true"/>
        <input type="text" name="s_account" placeholder="會員帳號" value="<?=$_SESSION["AT"]["where"]['s_account']?>">
        <input type="text" name="s_name" placeholder="會員姓名" value="<?=$_SESSION["AT"]["where"]['s_name']?>">
        <select name="s_type">
          <option value="">請選擇</option>
          <option value="轉贈佣金至現金" <?=($_SESSION["AT"]["where"]['s_type']=='轉贈佣金至現金')?'selected':'';?>>轉贈佣金至現金</option>
          <option value="轉贈佣金至購物金" <?=($_SESSION["AT"]["where"]['s_type']=='轉贈佣金至購物金')?'selected':'';?>>轉贈佣金至購物金</option>
        </select>
        <input type="button" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
        <input type="button" value="匯出" style=" font-size:14px;"  onclick="window.location.href='/bonus/dl_moneytransfer/'"/>
      </td>
    </tr>
  </table>
  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">

    <tr id='member_list_title_tr'>
      <td>時間</td>
      <td>會員帳號</td>
      <td>會員姓名</td>
      <td>付款方式</td>
      <td>請款金額</td>
      <td>狀態</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['d_date']?></td>
            <td class='center_td white_td'><?=$value['d_account']?></td>
            <td class='center_td white_td'><?=$value['name']?></td>
            <td class='center_td white_td'><?=$value['d_type']?></td>
            <td class='center_td white_td'><?=$value['d_bonus']?></td>
            <td class='center_td white_td'><?=$value['d_send']?></td>
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

	$(".date-object").datepicker({dateFormat: "yy-mm-dd"});<?php //日期?>
	$(".clear_date").click(function(){
		$("#"+$(this).attr("rel")).val("");
	});
  function del_file(name,id){
    if(confirm('確定刪除['+name+']資料?'))
      window.location.href='/shoppingmoney/shoppingmoney_AED/'+id;
  }

</script>
