<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>新增訊息 <?=$web_config['title']?></title>
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
  <script type="text/javascript">

  </script>
</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--新增好友分享券form-->
    <form action='/<?=$this->mode_function;?>/enews/add' method='post' name='form_enews_add' id='form_enews_add' enctype="multipart/form-data" onsubmit="return chk_val()">
      <h3 style="font-family: '微軟正黑體';">新增訊息</h3>
        <table class='table enews_add_table' id='enews_add_table' style="width:90%;">

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>訊息名稱</td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='name' id='name' maxlength="255"></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>群組</td>
            <td class='table-cell-left'>
              <?php if(!empty($category)): ?>
                <select name="category_id" class="required">
                  <?php foreach ($category as $key => $value): ?>
                    <option value="<?=$value['qaag_id']?>"><?=$value['qaag_name']?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td class='table-cell-right'>內容</td>
            <td class='table-cell-left'>
              <textarea name='content' class='form-control' id='ckeditor'></textarea>
            </td>
          </tr>
		   <tr>
            <td class='table-cell-right'>狀態</td>
            <td class='table-cell-left'>
				<select name="news_enable">
					<option value='1'>公開中</option>
					<option value='0'>隱藏中</option>
				</select>
            </td>
          </tr>
          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='add' value='新增' onclick="window.onbeforeunload=null;return true;">
              <input type='button' class='btn btn-default' name='cancle' id='cancel' value='取消'>
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
<script type="text/javascript" src="/js/admin/system_center/build_ckeditor.js"></script>
