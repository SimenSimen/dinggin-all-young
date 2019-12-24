<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>QRcode樣式修改 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- js -->
  <script type="text/javascript" src="/js/ie_browser_prompt.js"></script>

  <!-- jquery.qrcode -->
  <link type="text/css" rel="stylesheet" href='/css/jqrcode_styles.css'>
  <script type="text/javascript" src="/js/jqrcode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
  <script type="text/javascript" src="/js/jqrcode/ff-range.js"></script>
  <script type="text/javascript" src="/js/jqrcode/scripts.js"></script>

  <!-- jquery.confirmon -->
  <script type="text/javascript" src="/js/jqrcode/jquery.confirmon.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/jquery.confirmon.css"/>

  <!--colorpicker-->
  <script type='text/javascript' src="/js/colpick.js"></script>
  <script type='text/javascript' src="/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/colpick.css">
  <style type='text/css'>
  .colpick {
    z-index: 9999;
  }
  </style>

</head>
<body>

<?echo form_open("/business/editer_iframe", array('id'=>'form_editer', 'accept-charset'=>'utf-8'));?>
  <style type="text/css">
  #button_area
  {
    position: absolute;
    z-index: 9;
    left:39%;
    margin-left:-20px;
    top:-6px;
  }
  </style>
  <script>
    $(function () {
      $('#qrcode_open').click(function(){
        $.ajax({
          type: "post",
          cache: false,
          url: '/business/ajax_editer_qrcode_btn',
          data: {
            qrcode_btn: 0,
            member_id:  $('#mid').val(),
            type:       $('#edit_target').val()
          },
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            if(response)
              alert('關閉Qrcode按鈕成功，提醒您，Qrocde按鈕將「不顯示」於您的名片首頁');
            window.location.reload();
          }
        });
      });

      $('#qrcode_close').click(function(){
        $.ajax({
          type: "post",
          cache: false,
          url: '/business/ajax_editer_qrcode_btn',
          data: {
            qrcode_btn: 1,
            member_id:  $('#mid').val(),
            type:       $('#edit_target').val()
          },
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            if(response)
              alert('開啟Qrcode按鈕成功，提醒您，Qrocde按鈕將「顯示」於您的名片首頁');
            window.location.reload();
          }
        });
      });
    });
  </script>
  <div id='button_area'>
  <table>
  <tr>
    <td><button style="font-size: 21px;height: 34px;" id="download_btn">下載QRcode</button><a id="download_png" download="<?=$qrcode_file_name?>.png"></a>
    <td><input style="font-size: 21px;height: 34px;" type='submit' name='form_submit' id='form_submit' value='儲存樣式' onclick="window.onbeforeunload=null;return true;">
    <td><input style="font-size: 21px;height: 34px;color: white;background: #DA5049; padding: 0px 15px; <?=$open_btn_css?>" type='button' name='qrcode_btn' id='qrcode_open' value='按鈕開啟中' >
    <td><input style="font-size: 21px;height: 34px;color: white;background: #333; padding: 0px 15px; <?=$close_btn_css?>" type='button' name='qrcode_btn' id='qrcode_close' value='按鈕關閉中' >
    <td><span class='info' id='info' style='color:blue;'></span></td>
  </tr>
  </table>
  </div>
  
  <!-- edit qrcode target -->
  <input type='hidden' name='edit_target' id="edit_target" value='<?=$edit_target?>'>
  <input type='hidden' name='mode_value' id="mode_value" value='<?=$mode_value?>'>

  <!-- mecard -->
  <?php if ($edit_target == 1): ?>

    <input name="lastname"      id="lastname"   type="hidden"  value='<?=$iqr['lastname']?>'/>
    <input name="firstname"     id="firstname"  type="hidden"  value='<?=$iqr['firstname']?>'/>
    <input name="mphone"        id="mphone"     type="hidden"  value='<?=$mphone?>'/>
    <input name="cpn_name"      id="cpn_name"   type="hidden"  value='<?=$iqr['cpn_name']?>'/>
    <input name="cpn_tel"       id="cpn_tel"    type="hidden"  value='<?=$cpn_tel?>'/>
    <input name="cpn_fax"       id="cpn_fax"    type="hidden"  value='<?=$cpn_fax?>'/>
    <input name="cpn_addr"      id="cpn_addr"   type="hidden"  value='<?=$iqr['cpn_addr']?>'/>
    <input name="ecard_mail"    id="ecard_mail" type="hidden"  value='<?=$iqr['ecard_mail']?>'/>
    <input name="cpn_website"   id="cpn_website"type="hidden"  value='<?=$iqr_url?>'/>

  <?php endif; ?>
  
  <div>

    <div id="container" title='<?=$qrcode_file_name?>'></div>

    <div class="control left">
      
      <table id='left_table'>

        <tr><td><label for="btn_name">按鈕名稱 : </label></td></tr>
        <tr><td><input name="btn_name" id="btn_name" type="text" value='<?=$btn_name?>' maxlength='15' placeholder='最多15個字'/><hr/></td></tr>

        <tr><td><label for="size">QRcode尺吋 : </label></td></tr>
        <tr><td><input name="size" id="size" type="range" value='<?=$style['size']?>' min="100" max="450" step="10" /><hr/></td></tr>

        <tr><td><label for="fill">前景顏色<span id='msg_1'></span></label></td></tr>
        <tr><td><input type="text" id="fill1" class="colorPick" value='<?=$style['fill']?>'/><input name="fill" id="fill2" type="color" value='<?=$style['fill']?>' /></td></tr>

        <tr><td><label for="background">背景顏色<span id='msg_2'></span></label></td></tr>
        <tr><td><input type="text" id="background1" class="colorPick" value='<?=$style['background']?>'/><input name="background" id="background2" type="color" value='<?=$style['background']?>' /></td></tr>
      
      </table>

      <hr/>

      <table id='left_table'>

        <tr><td><label for="minversion">細緻程度 : </label></td></tr>
        <tr><td><input name="minversion" id="minversion" type="range" value='<?=$style['minversion']?>' min="1" max="10" step="1" /></td></tr>

        <tr><td><label for="quiet">邊緣留白 : </label></td></tr>
        <tr><td><input name="quiet" id="quiet" type="range" value='<?=$style['quiet']?>' min="1" max="4" step="1" /></td></tr>
        
        <tr><td><label for="radius">像素鋸齒程度 : </label></td></tr>
        <tr><td><input name="radius" id="radius" type="range" value='<?=$style['radius']?>' min="0" max="50" step="10" /></td></tr>
      
      </table>

      <hr/>

      <table id='left_table'>
      <tr><td><label for="eclevel">QRcode遮擋程度</label></td></tr>
      <tr><td>
        <select name="eclevel" id="eclevel">
          <option value="L" <?=$eclevel_selected['L']?>>圖形被擋住面積7%，仍可被掃瞄</option>
          <option value="M" <?=$eclevel_selected['M']?>>圖形被擋住面積15%，仍可被掃瞄</option>
          <option value="Q" <?=$eclevel_selected['Q']?>>圖形被擋住面積25%，仍可被掃瞄</option>
          <option value="H" <?=$eclevel_selected['H']?>>圖形被擋住面積30%，仍可被掃瞄</option>
        </select>
      </td></tr>
      </table>

    </div>

    <div class="control right">

      <table id='left_table'>
      <tr><td><label for="mode">標籤類型</label></td></tr>
      <tr><td>
        <select name="mode" id="mode">
          <option value="0" <?=$mode_selected[0]?>>0 - 無標籤</option>
          <option value="1" <?=$mode_selected[1]?>>1 - 橫幅文字標籤</option>
          <option value="2" <?=$mode_selected[2]?>>2 - 文字標籤</option>
          <option value="3" <?=$mode_selected[3]?>>3 - 橫幅圖形標籤</option>
          <option value="4" <?=$mode_selected[4]?>>4 - 圖形標籤</option>
        </select>
      </td></tr>
      </table>

      <hr/>

      <table id='left_table'>
      <tr><td><label for="label">文字標籤內容</label></td></tr>
      <tr><td><input name="label" id="label" type="text" value="<?=$style['label']?>" /></td></tr>
      <tr><td><label for="font">文字標籤字型</label></td></tr>
      <tr><td>
        <select name="font" id="font">
          <option value="0" <?=$font_selected[0]?>>Times New Roman</option>
          <option value="1" <?=$font_selected[1]?>>Cambria</option>
          <option value="2" <?=$font_selected[2]?>>新細明體</option>
          <option value="3" <?=$font_selected[3]?>>標楷體</option>
          <option value="4" <?=$font_selected[4]?>>微軟正黑體</option>
        </select>
      </td></tr>
      <tr><td><label for="fontcolor">文字標籤顏色</label></td></tr>
      <tr><td><input type="text" id="fontcolor1" class="colorPick" value='<?=$style['fontcolor']?>'/><input name="fontcolor" id="fontcolor2" type="color" value='<?=$style['fontcolor']?>' /></td></tr>
      </table>
      
      <hr/>

      <table id='left_table'>

        <tr><td><label for="image">圖形標籤選擇</label></td></tr>
        <tr><td><input name="image" id="image" type="file" /><div id="img_warning"></div></td></tr>

      </table>

      <table id='left_table'>

        <tr><td><label for="msize">標籤尺寸 : </label></td></tr>
        <tr><td><input name="msize" id="msize" type="range" value='<?=$style['msize']?>' min="0" max="40" step="1" /></td></tr>
        
        <tr><td><label for="mposx">內嵌位置 - 水平 X : </label></td></tr>
        <tr><td><input name="mposx" id="mposx" type="range" value='<?=$style['mposx']?>' min="0" max="100" step="1" /></td></tr>
        
        <tr><td><label for="mposy">內嵌位置 - 水平 Y : </label></td></tr>
        <tr><td><input name="mposy" id="mposy" type="range" value='<?=$style['mposy']?>' min="0" max="100" step="1" /></td></tr>
      
      </table>

      <hr/>

    </div>

    <?php if ($img_content == ''): ?>
      <img id="img-buffer" src="dummy.png" />
    <?php else: ?>
      <img id="img-buffer" src="<?=$img_content?>" />
    <?php endif; ?>
    <input type='hidden' name="img_src" id="img_src" value='<?=$img_content?>'/>

    <input type='hidden' name="base_url" id="base_url" value='<?=$base_url?>'/>
    <input type='hidden' name="id" id="id" value='<?=$account?>'/>
    <input type='hidden' name="mid" id="mid" value='<?=$mid?>'/>
  <div>
</form>

</body>
</html>
