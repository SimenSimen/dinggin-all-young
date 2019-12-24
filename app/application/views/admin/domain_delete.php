<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script type="text/javascript">
    $(function(){
      $('#domain_del_submit').click(function(){
        if(confirm('請確定刪除網域，刪除後無法復原'))
          $('#domain_delete_form').submit();
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    .domain_del { cursor: pointer; zoom: 150%; }
    .checkbox_td
    {
      text-align: center;
      vertical-align: middle;
    }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/domain_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/domain_edit'">修改網域</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" disabled="disabled">刪除網域</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" id='domain_del_submit'>確認刪除網域</button></td>
      
    </tr>
  </table>

  <!--網域列表-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='delete_title_tr'>
      <td class='checkbox_td domain_del' style="width:6%;"><input type='checkbox' id='clickAll'></td>
      <td>流水號</td>
      <td>網域</td>
      <td>公司名稱</td>
      <td>備註</td>
    </tr>

    <!--for-->
    <?php if (!empty($domain)): ?>
      <form method="post" id='domain_delete_form' action='/admin/domain_delete'>

        <?php foreach ($domain as $key => $value): ?>
          <tr>
            <td class='checkbox_td white_td'><input type='checkbox' class='domain_del' name='domain_del[]' value='<?=$value['domain_id']?>'></td>
            <td class='center_td white_td'><?=($key+1)?></td>
            <td class='center_td white_td'><?=$value['domain']?></td>
            <td class='center_td white_td'><?=$value['company']?></td>
            <td class='center_td white_td' style="width: 150px;"><div class='note' title='<?=$value['note']?>'><?=$value['note']?></div></td>
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
        $(".domain_del").each(function() {
          $(this).prop("checked", true);
        });
      }
      else
      {
        $(".domain_del").each(function() {
          $(this).prop("checked", false);
        });       
      }
    });

  });
</script>

</body>
</html>
