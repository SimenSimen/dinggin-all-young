<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>編輯產品分類 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div>

    <!--編輯自訂網頁form-->
    <form action='<?=$gateway_url?>' method='post' name='form_iqr_html_edit' id='form_iqr_html_edit'>
      <h3 style="font-family: '微軟正黑體';">編輯產品分類</h3>
        <table class='table iqr_html_add_table' id='iqr_html_add_table' style="width:90%;">

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>分類名稱</td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='company_classify_name' id='iqr_html_name' maxlength="32" value='<?=$classify_name?>' placeholder='最多32個字'></td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='form_submit' value='儲存' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='取消'>
            </td>
          </tr>
        </table>
        <input type='hidden' name='success' id='success' value='<?=$success?>'>
        <input type='hidden' name='classify_id' id='html_id' value='<?=$classify_id?>'>
        <input type='hidden' name='html_name' id='html_name' value='<?=$classify_name?>'>
      </form>
    <!--end 編輯自訂網頁form-->

  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">

  h3 { font-family: 'Microsoft Jhenghei'; }
  .btn { font-size: 16px; font-family: 'Microsoft Jhenghei'; }
  #iqr_html_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

  /*form*/
  .form-control { display: inline-block; width: 90%; }
  .red_star { color: red; }
  .table-cell-right { vertical-align: middle; text-align: center; font-size: 18px; }
  .table-cell-left { vertical-align: middle; text-align: left; }

  /*validate*/
  label.error { padding-left: 10px; font-size: 16px; color: red; font-family: '微軟正黑體'; }
  label.success { padding-left: 0px; }

</style>

<!--bottom script-->
<script type="text/javascript" src="/js/iqr_classify_edit.js"></script>
