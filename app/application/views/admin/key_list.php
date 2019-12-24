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

      //隱藏金鑰
      $('#key_title_td').click(function(){
        $('.key_td').each(function(){
          $(this).toggle();
        });
        $('.password_ori').each(function(){
          $(this).toggle();
        });
      });

      //dialog for 產生金鑰
      $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 220,
        width: 350,
        modal: true,
        buttons: {
          "Export": {
            text: '產生金鑰', class: 'btn btn-default', click: function() {
              if($.isNumeric($('#key_amount').val()) && $('#key_amount').val() >= 1 && $('#key_amount').val() <= 2000)
              {
                window.location.href='/keymaker/generate/'+$('#key_amount').val();
                 $('#msg').html('');
              }
              else
              {
                $('#msg').html('請輸入數字 1 - 2000');
                $('#msg').css('color', 'red');
                $('#key_amount').val('');
                $('#key_amount').focus();
              }
            }
          }
        }
      });
      $( "#export_xls" )
        .button()
        .click(function() {
          $( "#dialog-form" ).dialog( "open" );
      });

      //dialog for 匯入金鑰
      $( "#dialog-form-2" ).dialog({
        autoOpen: false,
        height: 220,
        width: 350,
        modal: true,
        buttons: {
          "Import": {
            text: '匯入金鑰', class: 'btn btn-default', click: function() {
              if($('#key_file').val().length > 0)
              {
                $('#import_form').submit();
              }
            }
          }
        }
      });
      $( "#import_xls" )
        .button()
        .click(function() {
          $( "#dialog-form-2" ).dialog( "open" );
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
    .key_value_td { width: 120px; }
    .key_use_td { width: 120px; }
    .domain_td { width: 300px; word-break:break-all; }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" id="export_xls">產生金鑰</button></td>
      <td style="width:1%;"><button class="btn btn-default" type="button" id="import_xls">匯入金鑰</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/key_edit'">編輯金鑰</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/key_delete'">刪除金鑰</button></td>
      
    </tr>
  </table>

  <!--金鑰列表-->
  <table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='list_title_tr'>
      <td>流水號</td>
      <td>網域</td>
      <td>卡號</td>
      <td><span id='key_title_td'>金鑰</span></td>
      <td>開卡狀態</td>
      <td>開卡人</td>
    </tr>

    <!--for-->
    <?php if (!empty($keys)): ?>
      <?php foreach ($keys as $key => $value): ?>
        <tr class='<?=$domain_name_tr[$key]?>'>
          <td class='center_td white_td'><?=$key_no[$key]?></td>
          <td class='center_td white_td domain_td'><?=$domain_name[$key]?></td>
          <td class='center_td white_td'><?=$value['key_number']?></td>
          <td class='center_td white_td key_value_td'><div class='key_td' style='display:none;'>****</div><div class='password_ori' style='color:#eeeeee; width: 120px; '><?=$value['key_value']?></div></td>
          <td class='center_td white_td key_use_td'><?=$key_use[$key]?></td>
          <td class='center_td white_td'><?=$member_account[$key]?><?php if ($member_name[$key] != ''): ?> / <?=$member_name[$key]?><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>

  </table>

  <!--金鑰數量對話框-->
  <div id="dialog-form" title="請輸入金鑰數量">
    <input type="text" name="key_amount" id="key_amount" class="text ui-widget-content ui-corner-all">
    <p><span id='msg'></span></p>
  </div>

  <!--匯入金鑰Excel檔案對話框-->
  <div id="dialog-form-2" title="請選擇.xls匯入">
    <form method="post" id='import_form' action='/admin/key_import' enctype="multipart/form-data">
      <input type="file" name="key_file" id="key_file" class="text ui-widget-content ui-corner-all" style="width:100%;">
    </form>
  </div>

<p style="height:200px;"></p>

</body>
</html>
