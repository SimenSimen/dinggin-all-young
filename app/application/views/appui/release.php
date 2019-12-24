<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>自動打包 - <?=$web_config['title']?></title>
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
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- validate -->
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
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
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">APP 自動打包</p>
      <p>&nbsp;</p>
      <p style="line-height: 36px; text-align: center;">系統維護時間：星期一至五：1:00 - 7:00 AM, 星期六、日不關機</p>
      <p style="line-height: 36px; text-align: center;">打包功能於系統維護時間之內暫時無法為您使用，不便之處請多見諒。</p>
      
      <div class="imgUPss" style="height: 1000px;overflow: hidden;">


      <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

        <!-- 姓氏, 名字 -->
        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">姓名</td>
          <td class="dd3">
            <input type='text' placeholder='姓氏' maxlength="16" name='l_name' id='l_name' value='<?=$iqr['l_name']?>'>
            <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>請輸入您的中文姓氏，例如「王」</div>
            <input type='text' class="required" placeholder='名字' maxlength="16" name='f_name' id='f_name' value='<?=$iqr['f_name']?>'>
            <input type='hidden' id='vertify_name' value='<?=$iqr['f_name']?>'>
            <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>請輸入您的中文名字(必填)，例如「小明」</div>
          </td>
          <td rowspan="2" style="text-align: center;"><img id='preview_icon' src='<?=$icon?>' style='width:100px;height:100px;'><div style="margin-top: 5px;text-align: center;"><?=$iqr['l_name']?><?=$iqr['f_name']?></div></td>
        </tr>
        
        <!--手機 icon-->
        <tr>
          <td>&nbsp;</td>
          <td>APP圖示</td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input type="file" name='icon' id='icon'/>
              <span id='file_chosen' class="file_chosen button">選擇 120&sup2; 以上 png 圖片&nbsp;&nbsp;</span>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'>圖示建議尺寸為正方形 120 x 120 以上 png 圖片</p>
              <p>您可以上傳自己喜歡的圖片，作為手機桌面的名片圖示</p>
              <p>若您想要使用預設圖示，請勾選「使用預設手機圖示」</p>
              <p style='color: #0000ff'>為了符合各種需求，本系統未強制限制上傳圖片尺寸</p>
            </div>
            <input type='checkbox' name='icon_status' class='default_image_checkbox' id='icon_status' <?=$icon_checked?>><span class='status_span' id='status_span_icon'>使用預設圖示</span>
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
          <td>Android<br><br>歡迎頁</td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input type="file" name='a_wp' id='a_wp'/>
              <span id='a_wp_chosen' class="file_chosen button">選擇 480 x 760 png 圖片&nbsp;&nbsp;</span>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'>Android 歡迎頁建議尺寸為 480 x 760 以上 png 圖片</p>
              <p>此歡迎頁比例為：12 比 19，請使用固定比例圖片</p>
              <p>您可以按照此比例上修尺寸，例如：960 x 1520(2x)</p>
              <p style='color: #0000ff'>為了符合各種需求，本系統未強制限制上傳圖片尺寸</p>
            </div>
            <input type='checkbox' name='a_wp_status' class='default_image_checkbox' id='a_wp_status' <?=$a_wp_checked?>><span class='status_span' id='status_span_a_wp'>使用預設圖示</span>
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
          <td>IOS<br><br>歡迎頁</td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input type="file" name='i_wp_0' id='i_wp_0'/>
              <span id='i_wp_0_chosen' class="file_chosen button">選擇 640 x 960 png 圖片&nbsp;&nbsp;</span>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'>IOS 歡迎頁建議尺寸為 640 x 960 以上 png 圖片</p>
              <p>此歡迎頁比例為：2 比 3，請使用固定比例圖片</p>
              <p>您可以按照此比例上修尺寸，例如：1280 x 1920(2x)</p>
              <p style='color: #0000ff'>為了符合各種需求，本系統未強制限制上傳圖片尺寸</p>
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
          <td>IOS<br><br>歡迎頁</td>
          <td style="padding-top: 0px;">
            <div class="file-wrapper">
              <input type="file" name='i_wp_1' id='i_wp_1'/>
              <span id='i_wp_1_chosen' class="file_chosen button">選擇 640 x 1136 png 圖片</span>
            </div>
            <a href="#" class="why" tabindex = "-1">?</a>
            <div class='prompt-box'>
              <p style='color: #ff6600'>IOS 歡迎頁建議尺寸為 640 x 1136 以上 png 圖片</p>
              <p>此歡迎頁比例為：40 比 71，請使用固定比例圖片</p>
              <p>您可以按照此比例上修尺寸，例如：1280 x 2272(2x)</p>
              <p style='color: #0000ff'>為了符合各種需求，本系統未強制限制上傳圖片尺寸</p>
            </div>
            <input type='checkbox' name='i_wp_1_status' class='default_image_checkbox' id='i_wp_1_status' <?=$i_wp_1_checked?>><span class='status_span' id='status_span_i_wp_1'>使用預設圖示</span>
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
                  
        <tr>
          <td align="center" colspan="4">
            <input class="<?=$app_update_class?>" type='button' id='update_app' value='<?=$app_update_text?>'>
            <input style="font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='儲存編輯'>
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
