<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$AddAnnex?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/front_homepage.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/exfile_management.css">
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script><!--jQuery ui library-->

  <!-- js -->
  <script type="text/javascript" src="/js/exfile_tab.js"></script>

  <!-- jquery.plupload-->
  <link type="text/css" rel="stylesheet" href="/css/jquery.plupload.queue.css">
  <script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>
  <script type="text/javascript" src="/js/plupload/jquery.plupload.queue.js"></script>
  <script type="text/javascript" src="/js/plupload/zh_TW.js"></script>

  <!-- script -->
  <script>
    function over(imgObj,picname) { imgObj.src=picname; }
    function out(imgObj,picname) { imgObj.src=picname; }

  </script>

  <script type="text/javascript">
  $(function(){
    function alert_msg() {   
      alert('<?=$NewSuccessAnnex?>');
      opener.window.parent.location.reload(); 
      window.close();
    }
    if($('#success').text() == 1)
    {
      $('div').css('display', 'none');
      setTimeout(alert_msg, 200);
    }
    $( "#tabs" ).tabs();
  });
    
  </script>

</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

<!--Success-->
<span id='success' style='display:none;'><?=$success?></span>

<div id="tabs">

  <ul>
    <li><a href="#tabs-1"><?=$Cyberspace?></a></li>
    <li><a href="#tabs-2"><?=$MachineUploads?></a></li>
  </ul>

  <div id="tabs-1">
    <p>
      <div class='switch_exfile'>
        <?php if (!empty($exfile)): ?>
        <?echo form_open("/business/exfile_add", array('name'=>'form_exfile_add', 'id'=>'form_exfile_add1'));?>
          <table class='table table-bordered' id='exfile_table'>
            <tr>
              <td>&nbsp;</td>
              <td><?=$OriginalFilename?></td>
              <td><?=$ButtonName?></td>
            </tr>
            <?php foreach ($exfile as $key => $value): ?>
                <tr>
                  <td><input type="checkbox" name='exfile_add[]' class='exfile_add1' value='<?=$exfile_id[$key]?>' /></td>
                  <td><div class='exfile_ori_name'><?=$exfile_ori_name[$key]?></div></td>
                  <td><?=$exfile_name[$key]?></td>
                </tr>
            <?php endforeach; ?>
            <div id='form_server_submit_div'>
              <?=$CheckAnnexNew?><span class='info' id='info' style='color:blue;'></span><br>
              <input name="clickAll" id="clickAll" type="checkbox"><label for='clickAll'><?=$SelectAll?></label>
              <input name="hide_repeat" class="hide_repeat" id='hide_repeat1' type="checkbox"><label class="hide_repeat_label" for='hide_repeat1'><?=$HideRepeatAnnex?></label>
              <input type='submit' name='form_server_submit' value='<?=$Add?>'>
              <input type='button' name='form_server_del' class='form_server_del' id='form_server_del1' value='<?=$RemoveCyberspace?>'>
              <input type='button' name='cancle' class='cancle' value='<?=$Cancle?>'>
              <input type='hidden' name='member_id' id='member_id' value='<?=$member_id?>'>
            </div>
          </table>
        </form>
        <?php else: ?>
          <span id='upload_prompt'><?=$_NoAnyAnnex?></span>
          <input type='button' name='cancle' class='cancle' value='<?=$Cancle?>'>
        <?php endif; ?>
      </div>

      <div class='switch_exfile' style="display:none;">
        <?php if (!empty($no_repeat_exfile)): ?>
        <?echo form_open("/business/exfile_add", array('name'=>'form_exfile_add', 'id'=>'form_exfile_add2'));?>
          <table class='table table-bordered' id='exfile_table'>
            <tr>
              <td>&nbsp;</td>
              <td><?=$OriginalFilename?></td>
              <td><?=$ButtonName?></td>
            </tr>
            <?php foreach ($no_repeat_exfile as $key => $value): ?>
                <tr>
                  <td><input type="checkbox" name='exfile_add[]' class='exfile_add2' value='<?=$exfile_id[$key]?>' /></td>
                  <td><div class='exfile_ori_name'><?=$exfile_ori_name[$key]?></div></td>
                  <td><?=$exfile_name[$key]?></td>
                </tr>
            <?php endforeach; ?>
            <div id='form_server_submit_div'>
              <?=$CheckAnnexNew?><span class='info' id='info' style='color:blue;'></span><br>
              <input name="clickAll" id="clickAll2" type="checkbox"><label for='clickAll2'><?=$SelectAll?></label>
              <input name="hide_repeat" class="hide_repeat" id='hide_repeat2' type="checkbox"><label class="hide_repeat_label" for='hide_repeat2'><?=$ShowAttachments?></label>
              <input type='submit' name='form_server_submit' value='<?=$Add?>'>
              <input type='button' name='form_server_del' class='form_server_del' id='form_server_del2' value='<?=$RemoveCyberspace?>'>
              <input type='button' name='cancle' class='cancle' value='<?=$Cancle?>'>
              <input type='hidden' name='member_id' id='member_id' value='<?=$member_id?>'>
            </div>
          </table>
        </form>
        <?php else: ?>
          <span id='upload_prompt'><?=$AllAnnexAdd?></span>
          <input name="hide_repeat" class="hide_repeat" id='hide_repeat2' type="checkbox"><label class="hide_repeat_label" for='hide_repeat2'><?=$ShowAttachments?></label>
        <?php endif; ?>
      </div>

    </p>
  </div>

  <div id="tabs-2">
    <p>
      <?echo form_open_multipart("", array('name'=>'form', 'id'=>'form_photo'));?>
      <input type='hidden' id='typ_n' value='<?=$typ_n?>'>
        <span id='upload_prompt'>
          <?=$ComputerSelectAnnex?><br><?=$AllowingOnly?><span class='high_light'>doc(x), ppt(x), xls(x), pdf, txt</span><?=$TypeOfFile?><span class='high_light'>3MB</span>
        </span>
        <div id="photo_uploader" style="width: 617px; height: 189px;"><?=$BrowserNotSuppor?></div>
        <div style="position: relative;">
          <input class="upload_button" type='submit' name='form_submit' value='<?=$StareUpLoad?>'>
          <input type='button' name='cancle' class='cancle' value='<?=$Cancle?>'>
        </div>
      </form>
      <style type="text/css">
        #upload_prompt
        {
          font-size: 16px;
          font-family: '微軟正黑體';
        }
        #photo_uploader_filelist
        {
          height:80px;
        }
      </style>
    </p>
  </div>

</div>
<span id='base_url' style='display:none;'><?=$base_url?></span>

</body>
</html>

<!--bottom css-->
<style type="text/css">
  .plupload_button.plupload_start
  {
       display:none;
  }
</style>

<!--bottom script-->
<script type="text/javascript">

$(function()
{
  //隱藏重複照片
  $('.hide_repeat').prop("checked", true);
  $(".hide_repeat").each(function() {
    $(this).change(function(){
      $('.switch_exfile').toggle();
      $('#hide_repeat1').prop("checked", true);
      $('#hide_repeat2').prop("checked", true);
      $(".exfile_add").each(function() {
        $('#clickAll').prop("checked", false);
        $('#clickAll2').prop("checked", false);
        $(this).prop("checked", false);
        $(this).parent().removeClass("green");  
        $(this).parent().addClass("normal"); 
      });
      $(".exfile_add2").each(function() {
        $('#clickAll').prop("checked", false);
        $('#clickAll2').prop("checked", false);
        $(this).prop("checked", false);
        $(this).parent().removeClass("green");  
        $(this).parent().addClass("normal"); 
      });
    });
  });

  $('#form_photo').submit(function(e){  
    var photo_uploader = $('#photo_uploader').pluploadQueue();  // 取得上传队列
    if (photo_uploader.files.length == 0)
    {
      alert('<?=$AtLeastFile?>');  
    }
    else
    {  
      if (photo_uploader.files.length > 0)
      {
        photo_uploader.bind('StateChanged', function() {  
          if (photo_uploader.files.length === (photo_uploader.total.uploaded + photo_uploader.total.failed) ) {
            alert('<?=$NewSuccess?>');
            opener.window.parent.location.reload(); 
            window.close();
          } 
        });
        photo_uploader.start();
      }
    }
    return false;  
  });

  //photo_uploader
  $("#photo_uploader").pluploadQueue({
    // General settings
    url : '/business/upload_doc/exfile',
    chunk_size : '3mb',
    unique_names : true,
    dragdrop : false,
    sortable : true,

    filters : {
      max_file_size : '10mb',
      mime_types: [
        {title : "Image files", extensions : "doc,docx,ppt,pptx,xls,xlsx,pdf,txt"}
      ]
    }
  });

});

</script>
