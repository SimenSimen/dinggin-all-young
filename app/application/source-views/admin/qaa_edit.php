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

      $('#qaag_edit').click(function(){
        $('#form_qaa_edit').submit();
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
      background-color: #2aabd2;
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

  <form action="/admin/qaa_edit" method="post" name="form_qaa_edit" id="form_qaa_edit">
  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%;">&nbsp;</td>
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/qaa_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" disabled="disabled">編輯問答</button></td>
      <td style="width:1%;"><input  class="btn btn-info"    type="submit" value='儲存'></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/qaa_delete'">刪除問答</button></td>
      
    </tr>
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
          <td class='white_td'><textarea class="form-control" name='qaa_title[]' id='qaa_title' rows="2" style="resize:none;" maxlength='128'><?=$value['qaa_title']?></textarea></td>
          <td class='white_td'><textarea class="form-control" name='qaa_content[]' id='qaa_content' rows="2" style="resize:none;"><?=$value['qaa_content']?></textarea></td>
          <td class='white_td'><textarea class="form-control" name='qaa_answer[]' id='qaa_answer' rows="2" style="resize:none;"><?=$value['qaa_answer']?></textarea></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>

  </table>

  </form>
<p style="height:200px;"></p>

</body>
</html>
