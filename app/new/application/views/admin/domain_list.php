<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <!-- icon -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript">
    $(function(){

      //dialog for 新增網域
      $( "#dialog-form-domain" ).dialog({
        autoOpen: false,
        height: 270,
        width: 350,
        modal: true,
        buttons: {
          "Add": {
            text: '新增網域', class: 'btn btn-default', click: function() {
              $('#domain_add_form').submit();
            }
          }
        }
      });
      $( "#domain_add_open" )
        .button()
        .click(function() {
          $( "#dialog-form-domain" ).dialog( "open" );
      });

      //切換網域
      $('#domain_switch').click(function()
      {
        window.location.href='/admin/domain_switch/'+$('input[name=domain_radio]:checked').val();
      });

    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/admin_list.css">
  <style type="text/css">
    .domain_radio { cursor: pointer; zoom: 150%; text-align: center; vertical-align: middle; }
    .note
    {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 150px;
    }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:97%; color:#5A0087;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" id='domain_switch'>切換操作網域</button></td>
      <td style="width:1%;"><button class="btn btn-default" type="button" id='domain_add_open'>新增網域</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/domain_edit'">修改網域</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/domain_delete'">刪除網域</button></td>
      
    </tr>
  </table>

  <!--網域列表-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='list_title_tr'>
      <td>勾選</td>
      <td>流水號</td>
      <td>網域</td>
      <td>公司名稱</td>
      <td>功能</td>
      <td>備註</td>
    </tr>

    <!--for-->
    <?php if (!empty($domain)): ?>
      <? $num = 1; ?>
      <?php foreach ($domain as $char_key => $char_content): ?>
        <!-- <tr class='active'>
          <td class='center_td white_td'><?=strtoupper($char_key)?></td>
          <td class='white_td' colspan="4"></td>
        </tr> -->
        <?php foreach ($char_content as $key => $value): ?>
          <tr class='<?=$domain_radio_tr[$value['domain_id']]?>'>
            <td class='center_td white_td'><input type='radio' <?=$domain_radio_checked[$value['domain_id']]?> class='domain_radio' name='domain_radio' id='domain_radio' value='<?=$value['domain_id']?>'></td>
            <td class='center_td white_td'><?=$num?></td>
            <td class='center_td white_td'><a href='http://<?=$value['domain']?>/' target='_blank'><?=$value['domain']?></a></td>
            <td class='center_td white_td'><?=$value['company']?></td>
            <td class='center_td white_td'><?php if($value['status'] == 1):?><i class="fa fa-shopping-cart"></i><?php endif;?></td>
            <td class='center_td white_td' style="width: 150px;"><div class='note' title='<?=$value['note']?>'><?=$value['note']?></div></td>
          </tr>
        <? $num++; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php endif; ?>

  </table>

  <!--新增網域對話框-->
  <div id="dialog-form-domain" title="請輸入域名">
    <form method="post" id='domain_add_form' action='/admin/domain_management'>
      <input type='hidden' name="domain_add" value='1'>
      <table class='table'>
        <tr><td>Domain<td><input type='text' name="domain_name" id="domain_name" class="text ui-widget-content ui-corner-all">
        <tr><td>Company<td><input type='text' name="company_name" id="company_name" class="text ui-widget-content ui-corner-all">
      </table>
    </form>
  </div>

<p style="height:200px;"></p>

</body>
</html>
