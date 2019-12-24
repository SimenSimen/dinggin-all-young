<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_AddNews?> <?=$web_config['title']?></title>
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
  <script type="text/javascript">
    
  </script>
</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--新增好友分享券form-->
    <form action='/news/enews/add' method='post' name='form_enews_add' id='form_enews_add' enctype="multipart/form-data" onsubmit="return chk_val()">
      <h3 style="font-family: '微軟正黑體';"><?=$TellFriendVoucher?></h3>
        <table class='table enews_add_table' id='enews_add_table' style="width:90%;">

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ShareCertificatesName?></td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='name' id='name' maxlength="32" placeholder='<?=$Must32Char?>'></td>
          </tr>
          
          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>群組</td>
            <td class='table-cell-left'>
              <?php if(!empty($category)): ?>
                <select name="category_id" class="required">
                  <?php foreach ($category as $key => $value): ?>
                    <option value="<?=$value['category_id']?>"><?=$value['c_name']?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ShareCertificatesPicture?></td>
            <td class='table-cell-left'>
              <p><?=$Just3MB?></p>
              <p><input type='file' class='form-control required' name='news' id='news'></p>
              <p><img id="blah" src="#"/></p>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$Message?></td>
            <td class='table-cell-left'>
              <textarea name='content' class='form-control' id='content'></textarea>
            </td>
          </tr>
          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='add' value='<?=$Added?>' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='<?=$Cancel?>'>
            </td>
          </tr>
        </table>
        <input type='hidden' name='success' id='success' value='<?=$success?>'>
      </form>
    <!--end 新增商品分類form-->
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">

  h3 { font-family: 'Microsoft Jhenghei'; }
  .btn { font-size: 16px; font-family: 'Microsoft Jhenghei'; }
  #enews_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

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
<script type="text/javascript" src="/js/enews_add.js"></script>
<script type="text/javascript" src="/js/enews_ckeditor.js"></script>