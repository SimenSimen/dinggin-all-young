<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$AppBuildTitle?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/validation.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- validate -->
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <style type="text/css">
    legend { text-align: right; }
    input[type=file]{height: 100%;width: 100%;}
    table.personal-info td.dd3{width: 60%;}
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <?echo form_open_multipart("/appui/build", array('id'=>'form_business'));?>
    
  <div id="con-L" style="width: 100%; height: 1050px;">


    <div class="step-docUP-1" style="height: 1020px;">
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;"><?=$AppBuild?></p>
      <p>&nbsp;</p>
      <p style="line-height: 36px; text-align: center;"><?=$SystemMaintenanceTime?></p>
      <p style="line-height: 36px; text-align: center;"><?=$BuildCanNotUse?></p>
      
      <div class="imgUPss" style="height: 1000px;overflow: hidden;">


      <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

        <!-- 姓氏, 名字 -->
        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2"><?=$FullName?></td>
          <td class="dd3">
            <input type='text' placeholder='<?=$Surname?>' maxlength="16" name='l_name' id='l_name' value='<?=$iqr['l_name']?>'>
            <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanSurname?></div>
            <input type='text' class="required" placeholder='<?=$Name?>' maxlength="16" name='f_name' id='f_name' value='<?=$iqr['f_name']?>'>
            <input type='hidden' id='vertify_name' value='<?=$iqr['f_name']?>'>
            <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanName?></div>
          </td>
          <td rowspan="2" style="text-align: center;"><img id='preview_icon' src='<?=$icon?>' style='width:100px;height:100px;'><div style="margin-top: 5px;text-align: center;"><?=$iqr['l_name']?><?=$iqr['f_name']?></div></td>
        </tr>
        <script type="text/javascript">
        $(function(){
          $('.hidden_image').hide();
        });
        </script>
        <!--手機 icon-->
        <tr>
          <td>&nbsp;</td>
          <td><?=$AppIcon?></td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input class="app_icon" data-icon-width="512" data-icon-height="512" data-icon-display="icon_display" type="file" name='icon' id='icon'/>
              <span id='file_chosen' class="file_chosen button"><?=$Select512?>&sup2; <?=$PngImage?>&nbsp;&nbsp;</span>
              <img id='icon_display' class='hidden_image'>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'><?=$PhotoSize512?></p>
              <p><?=$BusinessCardIcon?></p>
              <p><?=$PresetPhoneIcon?></p>
              <p style='color: #0000ff'><?=$NotCompulsorySize?></p>
            </div>
            <input type='checkbox' name='icon_status' class='default_image_checkbox' id='icon_status' <?=$icon_checked?>><span class='status_span' id='status_span_icon'><?=$UseDefaultIcon?></span>
            <style type="text/css">
              .file_chosen{height: 16px;}
              .status_span{cursor: pointer;}
              .default_image_checkbox{zoom: 160%;position: relative;top: 3px;-moz-transform: scale(1.6);}
            </style>
          </td>
        </tr>
        
        <!-- APP 歡迎頁 -->
        <!-- android : 480 * 760 a_wp -->
        <tr>
          <td>&nbsp;</td>
          <td>Android<br><br><?=$WelcomePage?></td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input data-a_wp-width="480" data-a_wp-height="760" data-a_wp-display="a_wp_display" type="file" name='a_wp' id='a_wp'/>
              <span id='a_wp_chosen' class="file_chosen button"><?=$Select760?>&nbsp;&nbsp;</span>
              <img id='a_wp_display' class='hidden_image'>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'><?=$AndroidSize480?></p>
              <p><?=$WelcomePage12_19?></p>
              <p><?=$Size960_1520?></p>
              <p style='color: #0000ff'><?=$NotCompulsorySize?></p>
            </div>
            <input type='checkbox' name='a_wp_status' class='default_image_checkbox' id='a_wp_status' <?=$a_wp_checked?>><span class='status_span' id='status_span_a_wp'><?=$UseDefaultIcon?></span>
          </td>
          <td style="text-align: center;">
            <span id="a_wp_span" data-tooltip="#a_wp_span_div">
              <img src='<?=$a_wp?>' id='preview_a_wp' style='width:80px; height: auto;'>
            </span>
            <div class='pup_span_div' id="a_wp_span_div">
              <img src='<?=$a_wp?>' style='width:200px; height: auto;'>
            </div>
            <style type="text/css">
              .pup_span_div { position: absolute; display: none; margin-top: 2px; z-index: 999; }
            </style>
            <script>
              $(function(){
                $('#a_wp_status_span').click(function(){
                  if($('#a_wp_status').is(":checked")){
                    $('#a_wp_status').prop("checked", false);
                  }else{
                    $('#a_wp_status').prop("checked", true);
                  }
                });
              });
              $("#a_wp_span").hover(function(e) {
                  $($(this).data("tooltip")).css({
                }).stop().show(100);
              }, function() {
                  $($(this).data("tooltip")).hide();
              });
            </script>
          </td>
        </tr>
        <!-- ios : 320 * 480 i_wp_0 -->
        <!-- ios : 640 * 960 i_wp_0 2x -->
        <tr>
          <td>&nbsp;</td>
          <td>IOS<br><br><?=$WelcomePage?></td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input data-i_wp_0-width="640" data-i_wp_0-height="960" data-i_wp_0-display="i_wp_0_display" type="file" name='i_wp_0' id='i_wp_0'/>
              <span id='i_wp_0_chosen' class="file_chosen button"><?=$Select960?>&nbsp;&nbsp;</span>
              <img id='i_wp_0_display' class='hidden_image'>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'><?=$IosSize960?></p>
              <p><?=$WelcomePage2_3?></p>
              <p><?=$Size1280_1920?></p>
              <p style='color: #0000ff'><?=$NotCompulsorySize?></p>
            </div>
            <input type='checkbox' name='i_wp_0_status' class='default_image_checkbox' id='i_wp_0_status' <?=$i_wp_0_checked?>><span class='status_span' id='status_span_i_wp_0'>使用預設圖示</span>
          </td>
          <td style="text-align: center;">
            <span id="i_wp_0_span" data-tooltip="#i_wp_0_span_div">
              <img src='<?=$i_wp_0?>' id='preview_i_wp_0' style='width:80px; height: auto;'>
            </span>
            <div class='pup_span_div' id="i_wp_0_span_div">
              <img src='<?=$i_wp_0?>' style='width:200px; height: auto;'>
            </div>
            <style type="text/css">
              .pup_span_div { position: absolute; display: none; margin-top: 2px; z-index: 999; }
            </style>
            <script>
              $(function(){
                $('#i_wp_0_status_span').click(function(){
                  if($('#i_wp_0_status').is(":checked")){
                    $('#i_wp_0_status').prop("checked", false);
                  }else{
                    $('#i_wp_0_status').prop("checked", true);
                  }
                });
              });
              $("#i_wp_0_span").hover(function(e) {
                  $($(this).data("tooltip")).css({
                }).stop().show(100);
              }, function() {
                  $($(this).data("tooltip")).hide();
              });
            </script>
          </td>
        </tr>
        <!-- ios : 640 * 1136 i_wp_1 -->
        <tr>
          <td>&nbsp;</td>
          <td>IOS<br><br><?=$WelcomePage?></td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input data-i_wp_1-width="640" data-i_wp_1-height="1136" data-i_wp_1-display="i_wp_1_display" type="file" name='i_wp_1' id='i_wp_1'/>
              <span id='i_wp_1_chosen' class="file_chosen button"><?=$Select1136?></span>
              <img id='i_wp_1_display' class='hidden_image'>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'><?=$IosSize1136?></p>
              <p><?=$WelcomePage40_47?></p>
              <p><?=$Size1280_2272?></p>
              <p style='color: #0000ff'><?=$NotCompulsorySize?></p>
            </div>
            <input type='checkbox' name='i_wp_1_status' class='default_image_checkbox' id='i_wp_1_status' <?=$i_wp_1_checked?>><span class='status_span' id='status_span_i_wp_1'><?=$UseDefaultIcon?></span>
            <script>
              $(function(){
                $('.status_span').each(function(){
                  $(this).click(function(){
                    var status_id = '#'+$(this).attr('id').substr(12) + '_status';
                    if($(status_id).is(":checked")){
                      $(status_id).prop("checked", false);
                    }else{
                      $(status_id).prop("checked", true);
                    }
                  });
                });
              });
            </script>
          </td>
          <td style="text-align: center;">
            <span id="i_wp_1_span" data-tooltip="#i_wp_1_span_div">
              <img src='<?=$i_wp_1?>' id='preview_i_wp_1' style='width:80px; height: auto;'>
            </span>
            <div class='pup_span_div' id="i_wp_1_span_div">
              <img src='<?=$i_wp_1?>' style='width:200px; height: auto;'>
            </div>
            <style type="text/css">
              .pup_span_div { position: absolute; display: none; margin-top: 2px; z-index: 999; }
            </style>
            <script>
              $(function(){
                $('#i_wp_1_status_span').click(function(){
                  if($('#i_wp_1_status').is(":checked")){
                    $('#i_wp_1_status').prop("checked", false);
                  }else{
                    $('#i_wp_1_status').prop("checked", true);
                  }
                });
              });
              $("#i_wp_1_span").hover(function(e) {
                  $($(this).data("tooltip")).css({
                }).stop().show(100);
              }, function() {
                  $($(this).data("tooltip")).hide();
              });
            </script>
          </td>
        </tr>
      <?php if($control_setting['cart_status']):?>
        <tr>
          <td>&nbsp;</td>
          <td><?=$AppHomeSelect?></td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <select style="padding: 3px 10px 3px 10px;font: 0.9em 微軟正黑體;background: #B2A171;margin: 8px 3px 25px 5px;color: #FFF;" name="app_index">
                <?php foreach ($index as $key => $value):?>
                  <option value="<?=$key?>" <?=$index_selected[$key]?>><?=$value?></option>
                <?php endforeach;?>
              </select>
            </div>
            <!-- <a href="#" class="why" tabindex = "-1">?</a> -->
            <div class='prompt-box'>
              <p style='color: #ff6600'><?=$AppHome?></p>
              <p><?=$APPEnterPicturePage?></p>
              <!-- <p>您可以按照此比例上修尺寸，例如：1280 x 2272(2x)</p> -->
              <!-- <p style='color: #0000ff'>為了符合各種需求，本系統未強制限制上傳圖片尺寸</p> -->
            </div>
          </td>
        </tr>
      <?php endif; ?>
        <tr>
          <td align="center" colspan="4">

            <input class="<?=$app_update_class['apk']?>" type='button' id='update_apk' value='<?=$apk_update_text?>'>
            <input class="<?=$app_update_class['ios']?>" type='button' id='update_ios' value='<?=$ios_update_text?>'>
            <input style="font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>
            <input type='hidden' id='member_id' value='<?=$mid?>'>
          </td>
        </tr>

      </table>

    </div>

  </div>
  
  </div>

</form>

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

<!--bottom script-->
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/file_select.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/appbuild.js" charset="utf-8"></script>
</body>
</html>
