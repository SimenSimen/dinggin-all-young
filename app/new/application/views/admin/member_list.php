 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript">
    $(function(){

      $('#password_title_td').click(function(){
        $('.password_td').each(function(){
          $(this).toggle();
        });
        $('.password_ori').each(function(){
          $(this).toggle();
        });
      });

      $('#update_webmin_submit').click(function(){
        $('#update_type').val(0);
        $('#update_webmin_form').submit();
      });

    });
  </script>

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

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:100%; color:#5A0087;">警告，請勿重複開啟不同會員視窗，以免資料錯置導致遺失</td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='member_list_title_tr'>
      <td>帳號</td>
      <td><span id='password_title_td'>密碼</span></td>
      <td>姓名</td>
      <!-- <td>電子信箱</td> -->
      <td>帳戶期限</td>
      <td>權限</td>
      <td>設定</td>
    </tr>

    <!--for-->
    <?php if (!empty($member)): ?>
      <form method="post" id='update_webmin_form' action='/admin/webmin_update'>
        <input type='hidden' name='update_type' id='update_type' value=''>

        <?php foreach ($member as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['account']?></td>
            <td class='center_td white_td'><div class='password_td' style='display:none;'>****</div><div class='password_ori' style='color:#EEE;'><?=$member_password[$key]?></div></td>
            <td class='center_td white_td' title='<?=$member_name[$key]?>'><?=mb_substr($member_name[$key], 0, 8,"utf-8")?><?php if (mb_strlen($member_name[$key]) > 9): ?>&nbsp;…<?php endif; ?></td>
            <!-- <td class='center_td white_td'><?php if (strlen($value['email']) > 0): ?><a href='mailto:<?=$value['email']?>' title='<?=$value['email']?>'><?=substr($value['email'], 0, 8)?><?php if (strlen($value['email']) > 8): ?>&nbsp;…<?php endif; ?></a><?php endif; ?></td> -->
            <!-- <td class='center_td white_td'><?=substr(date('Y', $value['deadline']), 2, 2).date('/m/d', $value['deadline'])?></td> -->
            <td class='center_td white_td'>餘 <?=round(($value['deadline'] - time()) / 86400)?> 天</td>
            <td class='center_td white_td'>
              <?php if($value['push'] == 0): ?>
                <i class="fa fa-user-times"></i>
              <?php elseif($value['push'] == 1): ?>
                <i class="fa fa-user"></i>
              <?php endif; ?>
              <?php if($android_key[$key]): ?>
                <i class="fa fa-android"></i>
              <?php endif; ?>
              <?php if($ios_key[$key]): ?>
                &nbsp;<i class="fa fa-apple"></i>&nbsp;
                <span style="font-size: 14px;"><?=$ios_deadline[$key]?></span>
              <?php endif; ?>
            </td>
            <td class='center_td white_td'> <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/admin/member_setting/<?=$value['account']?>'"><i class="fa fa-cogs"></i></a></td>
          </tr>
        <?php endforeach; ?>

      </form>
    <?php endif; ?>

  </table>



<p style="height:200px;"></p>

</body>
</html>
