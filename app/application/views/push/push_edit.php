<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>編輯推播訊息 - <?=$web_config['title']?></title>
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
  <script type="text/javascript" src="/js/messages_<?=$lang?>.js"></script>
  <!-- <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script> -->
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/validation.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"> -->
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  
  <!-- multi-select -->
  <script src="/js/multiselect/jquery.multi-select.js"></script>
  <link rel="stylesheet" href="/js/multiselect/multi-select.css">
</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
  <div>
    <!--新增推播訊息form-->
    <form action='/push/edit/<?=$push['p_id']?>' method='post' name='form_push_msg_add' id='form_push_msg_add' enctype="multipart/form-data">
      <h3 style="font-family: 'Microsoft JhengHei';">編輯一則推播訊息</h3>
        <table class='table push_msg_add_table' id='push_msg_add_table' style="width:90%;">

          <?php if ($user_auth == '01' && $group_push): ?>
            <tr>
              <td class='table-cell-right'>對象</td>
              <td class='table-cell-left'>
              <?php if($show_device): ?>
                <input type="radio" name="broadcasting" id="broadcasting_0" value="0" <?php if($push['type'] == 0):?>checked<?php endif; ?>>
                <label style="font-family: 微軟正黑體; font-weight: normal;" for='broadcasting_0'>群體</label> &nbsp;&nbsp;
                <input type="radio" name="broadcasting" id="broadcasting_1" value="1" <?php if($push['type'] == 1):?>checked<?php endif; ?>>
                <label style="font-family: 微軟正黑體; font-weight: normal;" for='broadcasting_1'>個人</label>
              <?php else: ?>
                <input type="radio" name="broadcasting" id="broadcasting_1" value="1" checked>
                <label style="font-family: 微軟正黑體; font-weight: normal;" for='broadcasting_1'>個人</label>
              <?php endif; ?>
              </td>
            </tr>
           
            <?php if($show_device): ?>
              <tr id="multiselect">
                <td class="table-cell-right">角色</td>
                <td class="table-cell-left">
                  <input class="select-btn-all" type="button" id="select-all" value="全選">
                  <input class="select-btn-all" type="button" id="deselect-all" value="取消全選">
                  <select id='multiselect-options' multiple='multiple' name="subordination[]" required>
                  
                    <?php foreach ($device_users as $key => $value): ?>
                      <option value="<?=$value['member_id']?>" <?=$value['selected']?>><?=$value['account']?> (<?=$value['name']?>)</option>
                    <?php endforeach; ?>
                  </select>
                  <!-- <img src="/js/multiselect/switch.png"> -->
                </td>
              </tr>
            <?php endif; ?>
          <?php else: ?>
            <input type='hidden' name='broadcasting' id='broadcasting_self' value='<?=$member_id?>'>
          <?php endif; ?>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>標題</td>
            <td class='table-cell-left'><input type='text' class='form-control required' name='title' id='title' maxlength="30" placeholder='標題文字 (30)' value="<?=$push['title']?>"></td>
          </tr>
          
          <tr>
            <td class='table-cell-right'>圖片</td>
            <td class='table-cell-left'>
              <input id='new_image' style="font-size: 14px;" type='file' name='new_image'>
              <br>
              <?php if(!empty($push['image'])):?>
                <img src="<?=$push['image']?>" width="120px" height="120px">
                <input type="hidden" name="image" value="<?=$push['image']?>">
              <?php endif; ?>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>訊息</td>
            <td class='table-cell-left'>
              <textarea style="resize: none;" name='message' class='form-control required' id='message' rows='4' maxlength='128' placeholder='將不會顯示於IPhone、IPad上'><?=$push['message']?></textarea>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span>推播夾訊息</td>
            <td class='table-cell-left'>
              <textarea id="messagebox" name="messagebox" class='form-control required' id='messagebox'><?=$push['messagebox']?></textarea>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'>狀態</td>
            <td class='table-cell-left'>
              <input type="radio" name="status" id='status_1' value="1" <?php if($push['status'] == 1): ?>checked<?php endif; ?>>
              <label style="font-family: 微軟正黑體; font-weight: normal;" for='status_1'>發送</label> &nbsp;&nbsp;
              <input type="radio" name="status" id='status_2' value="2" <?php if($push['status'] == 2): ?>checked<?php endif; ?>>
              <label style="font-family: 微軟正黑體; font-weight: normal;" for='status_2'>草稿</label>
            </td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='add' value='確認' onclick="window.onbeforeunload=null;return true;">
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
  #push_msg_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

  /*form*/
  .form-control { display: inline-block; width: 90%; }
  .red_star { color: red; }
  .table-cell-right { vertical-align: middle; text-align: center; font-size: 18px; }
  .table-cell-left { vertical-align: middle; text-align: left; }

  /*validate*/
  label.error { padding-left: 10px; font-size: 16px; color: red; font-family: 'Microsoft JhengHei'; }
  label.success { padding-left: 0px; }

  input[type=radio] { zoom:150%;-moz-transform:scale(1.5); position: relative; top: 2px; };

</style>

<script src="/js/push_edit.js"></script>
<script>
  $(function (){

    if($("inpt[name=broadcasting]").val() == 1)
      $("#multiselect").hide();

    $("input[name=broadcasting]").change( function() {
      if( $("#broadcasting_1").is(':checked')) {
        $("#multiselect").hide();
        } else {
        $("#multiselect").show();
      }  
    });

    $("#new_image").change(function(){
      var file = this.files[0]; //定義file=發生改的file
      name = file.name; //name=檔案名稱
      size = file.size; //size=檔案大小
      type = file.type; //type=檔案型態

      if(file.size > 500000) {
        alert('圖片上限500KB');
        $(this).val('');
      }
      else if(file.type != 'image/png' && file.type != 'image/jpg'

      && file.type != 'image/jpeg' ) { //假如檔案格式不等於 png 、jpg、gif、jpeg
        alert('檔案格式不符合: png, jpg');
        $(this).val('');
      }
    });

    $('#multiselect-options').multiSelect({
      selectableHeader: "<div class='custom-header'>角色選擇</div>",
      selectionHeader: "<div class='custom-header'>已選角色</div>",
    });
    $('#select-all').click(function(){
      $('#multiselect-options').multiSelect('select_all');
      return false;
    });
    $('#deselect-all').click(function(){
      $('#multiselect-options').multiSelect('deselect_all');
      return false;
    });

    var messagebox_ckeditor;
    var messagebox = document.getElementById('messagebox');

    function createEditor( languageCode )
    {
      if(messagebox != null)
      {
        if ( messagebox_ckeditor )
          messagebox.destroy();

        messagebox = CKEDITOR.replace( 'messagebox', {
          filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
          width : 500,
          height: 300,
          resize_enabled:false,
          enterMode: 2,
          forcePasteAsPlainText :true,
          toolbar :
          [
            ['Source', '-', 'Undo','Redo'],
            ['Cut','Copy','Paste','PasteText','PasteFromWord', 'Table', 'HorizontalRule', 'NumberedList','BulletedList', '-', 'Link','Unlink', 'Replace', 'RemoveFormat', 'Templates'],
            ['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'Image','Iframe']
          ],
        });
      }
    }
    createEditor( '' );
  });
</script>