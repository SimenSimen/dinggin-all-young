<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>編輯報名表單 - <?=$web_config['title']?></title>
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

      //取消按鈕關閉視窗
      $('#cancel').click(function(){
        if(confirm('您確定要取消編輯嗎?'))
        {
          window.close();
        }
      });

      $('#prompt_tr').hide();

      <?php if ($ufm_col_name_number == 0): ?>
        //onchange column number
        $('#c_col_table').hide();
        $('#c_col_hr').hide();
      <?php endif; ?>

      if($('#success').val() == 1)
      {
        alert('編輯完成');
        opener.window.parent.location.reload(); 
        window.close();
      }

      //validate
      $('#form_uform_edit').validate({
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
    <form action='/business/uform_edit/<?=$uform['ufm_id']?>' method='post' name='form_uform_edit' id='form_uform_edit'>
    <h3 style="font-family: '微軟正黑體';">編輯報名表單</h3>
    <h5 style="font-family: '微軟正黑體';">※&nbsp;提醒您，填寫活動說明可以幫助填表人了解活動相關資訊</h5>
      <table class='table' id='uform_table'>
        <tr>
          <td class='table-cell-right'>活動名稱</td>
          <td><input type='text' value='<?=$uform['ufm_name']?>' class='form-control required' style="display:inline;" name='ufm_name' maxlength="64"></td>
        </tr>
        <tr>
          <td class='table-cell-right'>分類類別</td>
          <td>
            <select name="ufm_cid" style="height: 34px; padding: 6px 12px; color: #555; border: 1px solid #ccc; font-size: 14px;">
              <option value="0">未分類</option>
            <?php foreach ($uform_category as $key => $value): ?>
              <option value="<?=$value['cid']?>" <?=$value['selection']?>><?=$value['name']?></option>
            <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'>活動說明</td>
          <td> </td>
        </tr>
        <tr>
          <td colspan="2" ><textarea class='' name="ufm_aim" id="ufm_aim" ><?=$uform['ufm_aim']?></textarea></td>
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
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[0]?>' placeholder='必填欄位名稱，例如：姓名' class='form-control' style="display:inline;" name='ufm_col_0' id='ufm_col_name1' maxlength='32'></td></tr>
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[1]?>' placeholder='必填欄位名稱，例如：手機' class='form-control' style="display:inline;" name='ufm_col_1' id='ufm_col_name2' maxlength='32'></td></tr>
                  <tr><td><input type='text' value='<?=$ufm_col_name_1[2]?>' placeholder='必填欄位名稱，例如：信箱' class='form-control' style="display:inline;" name='ufm_col_2' id='ufm_col_name3' maxlength='32'></td></tr>
              </table>
              <table id='c_col_table'>
                <tr><td id='c_col_hr'><hr></td></tr>
                <tr>
                    <td>「左側勾選」可設為必填欄位，左鍵按住&nbsp;<i class="fa fa-bars"></i>&nbsp;可拖曳排序</td>
                </tr>
              </table>
              <table id='col_table'>
                <tbody id='col_table_tbody'>

                  <?php if (!empty($ufm_col_content)): ?>
                    <?php foreach ($ufm_col_content as $key => $value): ?>

                      <?php if ($value[0] == 1): ?>

                        <!--date-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="1">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[日期] [欄位名稱] 例如：您的生日" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 2): ?>

                        <!--text-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="2">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[文字] [欄位名稱] 例如：您的公司電話" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 3): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="3">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[單選] [欄位名稱] 例如：您的交通工具" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                            <i class="fa fa-bars"></i><br>
                            <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="[單選] [選項] 例如：機車;汽車;計程車" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                            <a href="#" class="why" tabindex = "-1">?</a>
                            <div class="prompt-box">
                              <p>[單選] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>
                              <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的交通工具" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>
                              <p><input class="form-control" type="text" readonly="true" value="機車;汽車;計程車" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                              <p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>
                              <p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>
                              <p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>
                            </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 4): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="4">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[下拉] [欄位名稱] 例如：您的交通工具" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                            <i class="fa fa-bars"></i><br>
                            <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="[下拉] [選項] 例如：機車;汽車;計程車" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                            <a href="#" class="why" tabindex = "-1">?</a>
                            <div class="prompt-box">
                              <p>[下拉] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>
                              <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的交通工具" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>
                              <p><input class="form-control" type="text" readonly="true" value="機車;汽車;計程車" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                              <p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>
                              <p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>
                              <p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>
                            </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 5): ?>

                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="5">
                          <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                          <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[複選] [欄位名稱] 例如：您的專長" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                          <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                          <i class="fa fa-bars"></i><br>
                          <input name="item[content][]" value='<?=$space_content[$key]?>' placeholder="[複選] [選項] 例如：網站UI;平面設計;網頁撰寫" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">
                          <a href="#" class="why" tabindex = "-1">?</a>
                          <div class="prompt-box">
                            <p>[複選] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>
                            <p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的專長" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>
                            <p><input class="form-control" type="text" readonly="true" value="網站UI;平面設計;網頁撰寫" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>
                            <p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>
                            <p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>
                            <p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>
                          </div>
                          </td>
                        </tr>

                      <?php elseif ($value[0] == 6): ?>

                        <!--text-->
                        <tr class="item_tr">
                          <td style="width: 484px;"><input name="item[type][]" type="hidden" value="6">
                            <input type="checkbox" name="item[required][]" value="<?=$key?>" <?=$ufm_col_required[$key]?> class="form-control" style="width: 20px; display: inline;">
                            <input name="item[name][]" value='<?=$ufm_col_name_2[$key]?>' placeholder="[數字數量] [欄位名稱] 例如：預計同行人數" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">
                            <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>
                            <i class="fa fa-bars"></i>
                          </td>
                        </tr>

                      <?php endif; ?>

                    <?php endforeach; ?>
                  <?php endif; ?>

                </tbody>
              </table>
          </td>
        </tr>
        <tr>
          <td class='table-cell-right'>完成後動作</td>
          <td class='table-cell-left'><label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="1" <?php if($uform['ufm_mode'] == 1):?>checked<?php endif; ?> >提示文字</label>&nbsp;&nbsp;&nbsp;<label style="font-family: 微軟正黑體; font-weight: normal;"><input type="radio" name="ufm_mode" value="2" <?php if($uform['ufm_mode'] == 2):?>checked<?php endif; ?>>下載App</label></td>
        </tr>
        <tr>
          <td class='table-cell-right'>提示文字<br><a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>當使用者填完資料送出後，您可由此設定彈出視窗的提示文字內容</div></td>
          <td class='table-cell-left'><textarea placeholder='例如：恭喜您，您已經報名完成。' class='form-control' name="ufm_msg" id="ufm_msg" style="width: 484px; resize: none;" rows="4"><?=$uform['ufm_msg']?></textarea></td>
        </tr>
        <tr id='prompt_tr'>
          <td class='table-cell-right'></td>
          <td style="color: #ff6600;">您尚有「未填寫」欄位，請將以下欄位內容填妥後重試</td>
        </tr>
        <tr>
          <td class='table-cell-center' colspan="2">
            <input type='submit' class='btn btn-default' name='form_submit' style="font-size: 18px;" value='儲存編輯'>
            <input type='button' class='btn btn-default' name='cancle' style="font-size: 18px;" id='cancel' value='取消'>
            <input type='hidden' name='ufm_id' id='ufm_id' value='<?=$uform['ufm_id']?>'>
            <input type='hidden' name='ufm_col_num' id='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
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
<script type="text/javascript" src="/js/uform_edit.js"></script>
