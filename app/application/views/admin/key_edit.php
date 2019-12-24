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
      $('#key_edit_submit').click(function(){
        $('#key_edit_form').submit();
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    #key_title_td { cursor: pointer; color: #F99; }
    #domain_id { width: 148px; height: 40px; }
    .key_value_td { color:#eeeeee; width: 120px; }
    .domain_td { width: 280px; word-break:break-all; }
    .checkbox_td { text-align: center; vertical-align: middle; }
    .check_domain { cursor: pointer; zoom: 150%; }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

<form method="post" id='key_edit_form' action='/admin/key_edit'>

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/key_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" disabled="disabled">編輯金鑰</button></td>

      <td style="width:1%;">
        <?php if (!empty($domain)): ?>
          <select name='domain_id' id='domain_id' class='form-control'>
            <option value=''>請選擇分配網域</option>
            <option value='unset'>設為未分配</option>
            <?php foreach ($domain as $key => $value): ?>
              <option value='<?=$value['domain_id']?>'><?=str_replace("有限公司", "", $value['company']).' ( '.$value['domain'].' )'?></option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>
      </td>

      <td style="width:1%;"><button class="btn btn-info"    type="button" id='key_edit_submit'>儲存</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/key_delete'">刪除金鑰</button></td>
      
    </tr>
  </table>

  <!--金鑰編輯-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='edit_title_tr'>
      <td>流水號</td>
      <td>網域</td>
      <td>卡號</td>
      <td>金鑰</td>
      <td>開卡狀態</td>
      <td>開卡人</td>
      <td>分配</td>
    </tr>

    <!--for-->
    <?php if (!empty($keys)): ?>

      <?php foreach ($keys as $key => $value): ?>
        <tr style='background-color: <?=$key_use_color[$key]?>;'>
          <td class='center_td white_td'><?=$key_no[$key]?></td>
          <td class='center_td white_td domain_td'><?=$domain_name[$key]?></td>
          <td class='center_td white_td'><?=$value['key_number']?></td>
          <td class='center_td white_td key_value_td'><?=$value['key_value']?></td>
          <td class='center_td white_td'><?=$key_use_status[$key]?></td>
          <td class='center_td white_td'><?=$member_account[$key]?><?php if ($member_name[$key] != ''): ?> / <?=$member_name[$key]?><?php endif; ?></td>
          <td class='center_td white_td checkbox_td'><input type='checkbox' class='check_domain' name='check_domain[]' value='<?=$value['key_id']?>'></td>

        </tr>
      <?php endforeach; ?>

    <?php endif; ?>

  </table>

</form>

<p style="height:200px;"></p>

</body>
</html>
