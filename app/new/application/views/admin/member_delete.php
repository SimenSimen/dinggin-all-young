<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script type="text/javascript">
    $(function(){
      $('#member_del_submit').click(function(){
        if(confirm('請確定刪除會員，刪除後無法復原'))
          $('#member_delete_form').submit();
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    .checkbox_td { text-align: center; vertical-align: middle; }
    .member_del { cursor: pointer; zoom: 150%; }
    #clickAll { cursor: pointer; }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:97%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/member_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" disabled="disabled">刪除會員</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" id='member_del_submit'>確認刪除會員</button></td>
      
    </tr>
  </table>

  <!--會員列表-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='delete_title_tr'>
      <td>級別</td>
      <td>帳號</td>
      <td class='checkbox_td member_del' style="width:6%;"><input type='checkbox' id='clickAll'></td>
    </tr>

    <!--for-->
    <?php if (!empty($member)): ?>
      <form method="post" id='member_delete_form' action='/admin/member_delete'>

        <?php foreach ($member as $key => $value): ?>
          <tr>
            <td class='center_td white_td'><?=intval($value['auth'])?></td>
            <td class='center_td white_td'><?=$value['account']?></td>
            <td class='checkbox_td white_td'><input type='checkbox' class='member_del' name='member_del[]' value='<?=$value['member_id']?>'></td>
          </tr>
        <?php endforeach; ?>

      </form>
    <?php endif; ?>

  </table>

<p style="height:200px;"></p>

<script type="text/javascript">
  $(function(){
    
    //全選與全不選
    $("#clickAll").click(function() {
      if($("#clickAll").prop("checked"))
      {
        $(".member_del").each(function() {
          $(this).prop("checked", true);
        });
      }
      else
      {
        $(".member_del").each(function() {
          $(this).prop("checked", false);
        });       
      }
    });

  });
</script>

</body>
</html>
