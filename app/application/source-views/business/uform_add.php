<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>新增報名表單 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/uform_add.css">

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/messages_tw.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script><!-- ckeditor -->
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function(){

      $('#prompt_tr').hide();

      //onchange column number
      $('#c_col_table').hide();
      $('#c_col_hr').hide();

      //新增完成
      if($('#success').val() == 1)
      {
        alert('新增成功');
        opener.window.parent.location.reload(); 
        window.close();
      }

      //validate
      $('#form_uform_add').validate({
          success: function(label) {
              label.addClass("success").text("");
          }
      });

      //sortable
      $('#col_table_tbody').sortable();

    });
  </script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>
    <form action='/business/uform_add' method='post' name='form_uform_add' id='form_uform_add'>
    <h3 style="font-family: '微軟正黑體';">新增報名表單</h3>
    <h5 style="font-family: '微軟正黑體';">※&nbsp;提醒您，填寫活動說明可以幫助填表人了解活動相關資訊</h5>
      <table class='table' id='uform_table'>
        <tr>
          <td class='table-cell-right'>活動名稱</td>
          <td class='table-cell-left'><input type='text' class='form-control required' style="display:inline;" name='ufm_name' maxlength="64"></td>
        </tr>
        <tr>
          <td class='table-cell-right'>分類類別</td>
          <td>
            <select name="ufm_cid" style="height: 34px; padding: 6px 12px; color: #555; border: 1px solid #ccc; font-size: 14px;">
              <option value="0">未分類</option>
            <?php foreach ($uform_category as $key => $value): ?>
              <option value="<?=$value['cid']?>"><?=$value['name']?></option>
            <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'>活動說明</td>
          <td> </td>
        </tr>
        <tr>
          <td colspan="2"><textarea class='' name="ufm_aim" id="ufm_aim"></textarea></td>
        </tr>
        <tr>
          <td class='table-cell-right'>
              欄位名稱<br>

              <select class='form-control' id='select_form_item' style="display:inline; width: 80px;">
                <option value='0'>新增</option>
                  <?php foreach ($form_item as $key => $value): ?>
                      <option value='<?=$key+1?>'><?=$value['item_name']?></option>
                  <?php endforeach; ?>
              </select>

          </td>
          <td class='table-cell-left'>
              <table id='h_col_table'>
                  <tr><td>固定欄位名稱</td></tr>
                  <tr><td><input type='text' placeholder='必填欄位名稱，例如：姓名' class='form-control' style="display:inline;" name='ufm_col_0' id='ufm_col_name1' maxlength='32'></td></tr>
                  <tr><td><input type='text' placeholder='必填欄位名稱，例如：手機' class='form-control' style="display:inline;" name='ufm_col_1' id='ufm_col_name2' maxlength='32'></td></tr>
                  <tr><td><input type='text' placeholder='必填欄位名稱，例如：信箱' class='form-control' style="display:inline;" name='ufm_col_2' id='ufm_col_name3' maxlength='32'></td></tr>
              </table>
              <table id='c_col_table'>
                <tr><td id='c_col_hr'><hr></td></tr>
                <tr>
                    <td>「左側勾選」可設為必填欄位，左鍵按住&nbsp;<i class="fa fa-bars"></i>&nbsp;可拖曳排序</td>
                </tr>
                <tr id='prompt_tr'>
                    <td style="color: #ff6600;">您尚有「未填寫」欄位，請將以下欄位內容填妥後重試</td>
                </tr>
              </table>
              <table id='col_table'>
                <tbody id='col_table_tbody'>
                </tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'>完成後動作</td>
          <td class='table-cell-left'><label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="1" checked>提示文字</label>&nbsp;&nbsp;&nbsp;<label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="2">下載App</label></td>
        </tr>
        <tr>
          <td class='table-cell-right'>提示文字<br><a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>當使用者填完資料送出後，您可由此設定彈出視窗的提示文字內容</div></td>
          <td class='table-cell-left'><textarea placeholder='例如：恭喜您，您已經報名完成。' class='form-control' name="ufm_msg" id="ufm_msg" style="width: 484px; resize: none;" rows="4"></textarea></td>
        </tr>
        <tr>
          <td class='table-cell-center' colspan="2">
            <input type='submit' class='btn btn-default' name='form_submit' style="font-size: 18px;" value='新增'>
            <input type='button' class='btn btn-default' name='cancle' style="font-size: 18px;" id='cancel' value='取消'>
            <input type='hidden' name='member_id' id='member_id' value='<?=$member_id?>'>
            <input type='hidden' name='success' id='success' value='<?=$success?>'>
          </td>
        </tr>
      </table>
    </form>
    <p style="height: 100px;"></p>
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">
</style>

<!--bottom script-->
<script type="text/javascript" src="/js/uform_add.js"></script>
