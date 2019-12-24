<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$EditShare?> <?=$web_config['title']?></title>
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
    $(function(){


    });
  </script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--新增好友分享券form-->
    <form action='/business/ecoupon/edit/0/<?=$edit_ecp['ecp_id']?>' method='post' name='form_ecoupon_edit' id='form_ecoupon_edit' enctype="multipart/form-data" onsubmit="return chk_val()">
      <h3 style="font-family: '微軟正黑體';"><?=$TellFriendVoucher?></h3>
        <table class='table ecoupon_edit_table' id='ecoupon_edit_table' style="width:90%;">

          <tr>
            <td class='table-cell-right' style="width: 17%;"><span class='red_star'>*</span><?=$ShareCertificatesName?></td>
            <td class='table-cell-left'><input type='text' value='<?=$edit_ecp['name']?>' class='form-control required' name='name' id='name' maxlength="255" placeholder='<?=$Must32Char?>'></td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ShareCertificatesPicture?></td>
            <td class='table-cell-left'>
              <p><?=$Just3MB?></p>
              <p><input type='file' class='form-control' name='coupon' id='coupon'></p>
              <p><img id="blah" style="width:90%;" src="<?=substr($img_url, 1).$edit_ecp['filename']?>"/></p>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$Message?></td>
            <td class='table-cell-left'>
              <textarea name='content' class='form-control' id='content'><?=$edit_ecp['content']?></textarea>
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><span class='red_star'>*</span><?=$ButtonName?></td>
            <td class='table-cell-left'>
              <input type="text" class='form-control required' placeholder='<?=$Must8Char?>' name='btn_name'  maxlength="8" value="<?=$edit_ecp['btn_name']?>">
            </td>
          </tr>

          <tr>
            <td class='table-cell-right'><?=$ShareSetting?></td>
            <td class='table-cell-left'>
              <label style="font-weight:normal; padding: 0 5px;"><input type="radio" name="share_mode" value="1" <?php if($edit_ecp['mode'] == 1):?> checked="checked" <?php endif; ?>><?=$APPDownload?></label>
              <label style="font-weight:normal; padding: 0 5px;"><input type="radio" name="share_mode" value="2" <?php if($edit_ecp['mode'] == 2):?> checked="checked" <?php endif; ?>><?=$CustomerURL?></label>
              <label style="font-weight:normal;"><input type="radio" name="share_mode" value="3" <?php if($edit_ecp['mode'] == 3):?> checked="checked" <?php endif; ?>><?=$CustomerContent?></label>
            </td>
          </tr>

          <tr id="share_mode_2" >
            <td class='table-cell-right'><?=$ShareURL?></td>
            <td class='table-cell-left'>
              <input type='text' class='form-control' name='share_url' placeholder="<?=$ShareURLValue?>" value="<?=$edit_ecp['mode_2']?>">
            </td>
          </tr>

          <tr id="share_mode_3" >
            <td class='table-cell-right'><?=$ShareContent?></td>
            <td class='table-cell-left'>
              <textarea id="share_txt" name="share_txt"><?=$edit_ecp['mode_3']?></textarea>
            </td>
          </tr>

          <tr>
            <td class='table-cell-center' colspan="2" style="text-align:center;">
              <input type='submit' class='btn btn-default' name='edit' value='<?=$SaveEdit?>' onclick="window.onbeforeunload=null;return true;">
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
  #ecoupon_edit_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

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
<script type="text/javascript" src="/js/ecoupon_edit.js"></script>
<script type="text/javascript" src="/js/ecoupon_ckeditor.js"></script>
