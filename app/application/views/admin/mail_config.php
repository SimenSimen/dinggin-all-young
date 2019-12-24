 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript">
    $(function(){
      $('#save_submit').click(function(){
        if(confirm("您即將更新資料，確認儲存?"))
          $('#mail_config_form').submit();
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
    .center_td
    {
      text-align: center;
    }

  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%; color:#5A0087;">警告，請勿重複開啟不同會員視窗，以免資料錯置導致遺失</td>
      <td style="width:1%;"><button class="btn btn-success" type="button" id='save_submit'>儲存編輯 <i class="fa fa-floppy-o"></i></button></td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='member_list_title_tr'>
      <td>編號</td>
      <td>網域</td>
      <td>公司名稱</td>
      <td>管理者 E-mail <i class="fa fa-envelope-o"></i> (多組請以 , 分隔)</td>
    </tr>

    <!--for-->
      <form method="post" id='mail_config_form' action='/admin/mail_config'>
        <?php foreach ($domain as $key => $value): ?>
          <tr>
            <td class='center_td white_td'><?=$key+1?></td>
            <td class='center_td white_td'><a href='https://<?=$value['domain']?>/' target='_blank'><?=$value['domain']?></a></td>
            <td class='center_td white_td'><?=$value['company']?></td>
            <td class='center_td white_td'><input type="text" name="sys_mail[]" style="width:68%; padding: 4px 1px 4px 6px;margin-right: 8px; font-size: 18px; border:0;" value="<?=$value['sys_mail']?>"></td>
          </tr>
          <input type="hidden" name="domain_id[]" value="<?=$value['domain_id']?>">
        <?php endforeach; ?>
      </form>

  </table>

<p style="height:200px;"></p>

</body>
</html>
