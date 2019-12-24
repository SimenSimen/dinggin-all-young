 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head id='<?=$dbname?>'>

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
  <script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
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

  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:1%;">
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
<!--
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/member/<?=$dbname?>_info'">
          新增經銷會員
        </button>
-->
      </td>
    </tr>

  </table>
<!--
  <table >
    <tr>
      <td>
        <input type="text" name="s_account" placeholder="會員帳號" value="<?=$_SESSION["AT"]["where"]['s_account']?>">
        <input type="text" name="s_num" placeholder="編號" value="<?=$_SESSION["AT"]["where"]['s_num']?>">
        <input type="text" name="s_name" placeholder="姓名" value="<?=$_SESSION["AT"]["where"]['s_name']?>">
        <input type="text" name="Pname" placeholder="推薦人" value="<?=$_SESSION["AT"]["where"]['Pname']?>">
        <input type="text" name="upline" placeholder="上線會員" value="<?=$_SESSION["AT"]["where"]['upline']?>">
        <select name="s_type">
          <option value="">請選擇</option>
          <option value="0" <?=($_SESSION["AT"]["where"]['s_type']=='0')?'selected':'';?>>一般會員</option>
          <option value="1" <?=($_SESSION["AT"]["where"]['s_type']=='1')?'selected':'';?>>經營會員</option>
          <option value="2" <?=($_SESSION["AT"]["where"]['s_type']=='2')?'selected':'';?>>待審核會員</option>
        </select>
        <input type="button" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
        <input type="button" value="匯出" style=" font-size:14px;"  onclick="window.location.href='/member/dl_member'"/>
      </td>
    </tr>
  </table>
-->

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">

    <tr id='member_list_title_tr'>
      <td>VIP會員姓名</td>
      <td>會員編號</td>
      <td>體系長</td>
      <td>推薦VIP數</td>
      <td>推薦一般會員數</td>
      <td>明細</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <?$icount++;?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['name']?></td>
            <td class='center_td white_td'><?=$value['member_num']?></td>
            <td class='center_td white_td'><?=$value['is_family_boss']?></td>
            <td class='center_td white_td'><?=$value['count_normal_buyer']?></td>
            <td class='center_td white_td'><?=$value['count_vip_buyer']?></td>
            <td class='center_td white_td'>
							<a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/member/vip_detail_list/<?=$value['by_id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
						</td>
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>
  <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
  </table>
    <?=$page?>
<p style="height:200px;"></p>

</body>

  <?='</form>'?>
	</center>
</html>
