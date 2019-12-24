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

      //dialog for 新增問答群組
      $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 220,
        width: 350,
        modal: true,
        buttons: {
          "Qaa_add": {
            text: '新增群組', class: 'btn btn-default', click: function() {
              if($('#qaag_name').val().length > 0)
              {
                $('#qaag_add_form').submit();
              }
            }
          }
        }
      });
      $( "#qaag_add" )
        .button()
        .click(function() {
          $( "#dialog-form" ).dialog( "open" );
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
    #qaa_list tr td, #qaag_list tr td
    {
      padding: 5px;
    }
    #qaag_list_title_tr td, #qaa_list_title_tr td
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
      width: 20%;
    }
  </style>

</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" id='qaag_add'>新增類別</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/qaa_add'">新增問答</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/qaa_edit'">編輯問答</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/qaa_delete'">刪除問答</button></td>
      
    </tr>
  </table>

  <!--群組列表-->
  <table id='qaag_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='qaag_list_title_tr'>
      <td>流水號</td>
      <td>群組名稱</td>
    </tr>

    <!--for-->
    <?php if (!empty($qaag)): ?>
      <?php foreach ($qaag as $key => $value): ?>
        <tr>
          <td class='center_td white_td' style="width:10%;vertical-align: middle;"><?=($key+1)?></td>
          <td class='white_td'>&nbsp;<?=$value['qaag_name']?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>

  </table>

  <!--問題列表-->
  <table id='qaa_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='qaa_list_title_tr'>
      <td>流水號</td>
      <td>標題</td>
      <td>問題</td>
      <td>答案</td>
    </tr>

    <!--for-->
    <?php if (!empty($qaa)): ?>
      <?php foreach ($qaa as $key => $value): ?>
        <tr>
          <td class='center_td white_td' style="width:92px;vertical-align: middle;"><?=($key+1)?><input type='hidden' name='qaa_id[]' id='qaa_id' value='<?=$value['qaa_id']?>'></td>
          <td class='white_td'><?=$value['qaa_title']?></td>
          <td class='white_td'><?=$value['qaa_content']?></td>
          <td class='white_td'><?=$value['qaa_answer']?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>

  </table>

  <!--問答群組對話框-->
  <div id="dialog-form" title="請輸入群組名稱">
    <form method="post" id='qaag_add_form' action='/admin/qaag_add'>
      <input type="text" name="qaag_name" id="qaag_name" class="text ui-widget-content ui-corner-all" style="width:100%;" maxlength="64">
    </form>
  </div>

<p style="height:200px;"></p>

</body>
</html>
