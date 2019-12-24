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
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript">
    $(function(){
      $('#domain_edit_submit').click(function(){
        $('#domain_edit_form').submit();
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    .domain { width: 200px; }
    .company { width: 200px; }
    .note { resize: none; width: 100%; }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:95%;">&nbsp;</td>
      <!-- <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/domain_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" disabled="disabled">修改網域</button></td> -->
      <td style="width:1%;"><button class="btn btn-info"    type="button" id='domain_edit_submit'>儲存編輯</button></td>
      <!-- <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/domain_delete'">刪除網域</button></td> -->
      
    </tr>
  </table>

  <!--網域修改-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='edit_title_tr'>
      <!-- <td>流水號</td> -->
      <td>網域</td>
      <td>公司名稱</td>
      <td>備註</td>
    </tr>

    <!--for-->
    <?php if (!empty($domain)): ?>
      <form method="post" id='domain_edit_form' action='/admin/domain_edit'>
      <?php foreach ($domain as $key => $value): ?>
        <tr>
          <!-- <td class='center_td white_td'><?=($key+1)?><input type='hidden' name='domain_id[]' value='<?=$value['domain_id']?>'></td> -->
          <td class='center_td white_td' style="width: 200px;"><input type='text' class='form-control domain' name='domain[]' value='<?=$value['domain']?>'></td>
          <td class='center_td white_td' style="width: 200px;"><input type='text' class='form-control company' name='company[]' value='<?=$value['company']?>'></td>
          <td class='center_td white_td'><textarea class='form-control note' rows="1" name='note[]'><?=$value['note']?></textarea></td>
        </tr>
      <?php endforeach; ?>
      </form>
    <?php endif; ?>

  </table>

<p style="height:200px;"></p>

</body>
</html>
