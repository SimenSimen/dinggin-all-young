<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    #key_title_td { cursor: pointer; color: #F99; }
    .key_value_td { width: 120px; }
    .key_use_td { width: 120px; }
    .domain_td { width: 300px; word-break:break-all; }
    .hidden_text{ overflow : hidden;  text-overflow : ellipsis;  white-space : nowrap;  width : 240px; }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      
    </tr>
  </table>

  <!--金鑰列表-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='list_title_tr'>
      <?php foreach ($TD as $key => $value): ?>
        <?=$value?>
      <?php endforeach; ?>
    </tr>

    <!--for-->
    <?php if (!empty($list)): ?>
      <?php foreach ($list as $key => $value): ?>
        <tr class='<?=$domain_name_tr[$key]?>'>
          <td class='center_td white_td'><?=$value['no']?></td>
          <td class='center_td white_td'><?=$value['val_field00']?></td>
          <?php if($value['field01_btn']): ?><td class='center_td white_td'><?=$value['val_field01']?></td><?php endif; ?>
          <?php if($value['field02_btn']): ?><td class='center_td white_td'><?=$value['val_field02']?></td><?php endif; ?>
          <?php if($value['field03_btn']): ?><td class='center_td white_td'><?=$value['val_field03']?></td><?php endif; ?>
          <td class='center_td white_td'><a href="<?=$value['gateway_url']?>" onclick="window.open(this.href, '', config='height=345,width=550,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1'); return false;"><i style="font-size: 1.5em;" class="fa fa-pencil-square-o fa-2x"></i></a></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>

<p style="height:200px;"></p>

</body>
</html>
