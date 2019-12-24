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
      $('#qaa_del_submit').click(function(){
        if(confirm('請確定刪除後無法復原'))
          $('#qaa_delete_form').submit();
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
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
    #qaa_list tr td
    {
      padding: 5px;
    }
    #qaa_list_title_tr td
    {
      text-align: center;
      background-color: #d9534f;
      color: #fff;
    }
    .white_td
    {
      color: <?=$web_config['admin_font_color']?>;
    }
    .center_td
    {
      text-align: center;
      width: 19%;
    }
    #qaa_title_td
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
    #clickAll
    {
      cursor: pointer;
    }
    .qaa_del
    {
      cursor: pointer;
    }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/qaa_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" disabled="disabled">刪除問答</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" id='qaa_del_submit'>確認刪除問答</button></td>
      
    </tr>
  </table>

  <!--金鑰列表-->
  <table id='qaa_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='qaa_list_title_tr'>
      <td class='checkbox_td' style="width:6%;"><input type='checkbox' id='clickAll'></td>
      <td>流水號</td>
      <td>標題</td>
      <td>問題</td>
      <td>答案</td>
    </tr>

    <!--for-->
    <?php if (!empty($qaa)): ?>
      <form method="post" id='qaa_delete_form' action='/admin/qaa_delete'>

        <?php foreach ($qaa as $key => $value): ?>
          <tr>
            <td class='checkbox_td white_td'><input type='checkbox' class='qaa_del' name='qaa_del[]' value='<?=$value['qaa_id']?>'></td>
            <td class='center_td white_td' style="width:92px;vertical-align: middle;"><?=($key+1)?></td>
            <td class='white_td'><?=$value['qaa_title']?></td>
            <td class='white_td'><?=$value['qaa_content']?></td>
            <td class='white_td'><?=$value['qaa_answer']?></td>
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
        $(".qaa_del").each(function() {
          $(this).prop("checked", true);
        });
      }
      else
      {
        $(".qaa_del").each(function() {
          $(this).prop("checked", false);
        });       
      }
    });

  });
</script>

</body>
</html>
