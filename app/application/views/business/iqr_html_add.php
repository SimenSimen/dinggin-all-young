<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_NewCustomPages?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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

    <!--新增自訂網頁form-->
    <form action='/business/iqr_html_add' method='post' name='form_iqr_html_add' id='form_iqr_html_add'>
      <h3 style="font-family: '微軟正黑體';"><?=$NewCustomPages?></h3>
        <table class='table iqr_html_add_table' id='iqr_html_add_table' style="width:90%;">
          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$Class?></td>
            <td>
              <select id="classify_select" class="form-control required" name="iqr_classify_select">
                <option value=""><?=$Select?></option>
              <?php foreach ($classify as $key => $value): ?>
                <option value="<?=$value['classify_id']?>"><?=$value['classify_name']?></option>
              <?php endforeach ?>
              </select>
              <br><p style="color:red;" id='iqr_classify_prompt'>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ButtonName?></td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='iqr_html_name' id='iqr_html_name' maxlength="64" placeholder='<?=$Max64fonts?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$WebContent?></td>
            <td class='table-cell-left'><textarea name='iqr_html_content' id='iqr_html_content'></textarea><p style="color:red;" id='iqr_html_prompt'></p></td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='form_submit' value='<?=$Add?>' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='<?=$Cancle?>'>
            </td>
          </tr>
        </table>
        <input type='hidden' name='success' id='success' value='<?=$success?>'>
        <input type='hidden' name='html_name' id='html_name' value='<?=$html_name?>'>
        <input type='hidden' name='classify_name' id='classify_name' value='<?=$classify_name?>'>
        <input type='hidden' name='html_id' id='html_id' value='<?=$html_id?>'>

      </form>
    <!--end 新增自訂網頁form-->

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
<script type="text/javascript" src="/js/iqr_html_add.js"></script>