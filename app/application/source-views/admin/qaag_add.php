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
      <td style="width:1%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/key_management'">返回列表</button></td>
      <td style="width:1%;"><button class="btn btn-default" type="button" disabled="disabled">新增類別</button></td>
      <td style="width:1%;"><button class="btn btn-info"    type="button" onclick="top.frames['content-frame'].location='/admin/qaa_add'">新增問答</button></td>
      <td style="width:1%;"><button class="btn btn-danger"  type="button" onclick="top.frames['content-frame'].location='/admin/qaa_delete'">刪除問答</button></td>
      
    </tr>
  </table>

  <!--問題列表-->
  <form action="/admin/qaa_add" method="post" name="form_qaa_add" id="form_qaa_add">
    <table id='qaa_list' class='table table-bordered table-condensed' style="width:60%;">
      <tr id='qaa_list_title_tr'><td colspan="2">請依據欄位填入問與答</td></tr>
      <tr>
        <td class="center_td">問題類型</td>
        <td><input type='text' class="form-control" name='qaa_title' id='qaa_title' maxlength='128'></td>
      </tr>
      <tr>
        <td class="center_td">問題名稱</td>
        <td><input type='text' class="form-control" name='qaa_title' id='qaa_title' maxlength='128'></td>
      </tr>
      <tr>
        <td class="center_td">問題描述</td>
        <td><textarea class="form-control" name='qaa_content' id='qaa_content' cols="65" rows="5" style="resize:none;"></textarea></td>
      </tr>
      <tr>
        <td class="center_td">答案內容</td>
        <td><textarea class="form-control" name='qaa_answer' id='qaa_answer' cols="65" rows="5" style="resize:none;"></textarea></td>
      </tr>
    </table>
  </form>

<p style="height:200px;"></p>

</body>
</html>
