<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width"> 

  <!-- seo -->
  <title><?=$theme['theme_display_name']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--js-->
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
  <script src="<?=$base_url?>js/jquery.touchSlider.js"></script>

  <!--css-->
  <link rel="stylesheet" href="<?=$base_url?>css/integrate/<?=$theme_css?>" /><!--主題css-->
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
  <link href="<?=$base_url?>css/integrate/<?=$slider_css?>" rel="stylesheet" type="text/css" />
  <style type="text/css">
    #footer_a
    {
      text-decoration: none;
    }
  </style>

  <!--script-->
  <script type="text/javascript">
    //圖片縮圖
    $(window).load(function(){

      $('#share_btn_table').css('width', ($(window).width()*91/100));
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding', '2px');

      $(".img").each(function(i){
        //移除目前設定的影像長寬
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var imgW = $(this).width();
        var imgH = $(this).height();

        //計算縮放比例
        var w=($(window).width()*93/100)/imgW;
        var h=w;
        var pre=1;
        if(w>h){
          pre=h;
        }else{
          pre=w;
        }
   
        //設定目前的縮放比例
        $(this).width(imgW*pre);
        $(this).height(imgH*pre);
      });

      $(".video_iframe").each(function(i){
        //移除目前設定的影像長寬
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var videoW = $(this).width();
        var videoH = $(this).height();
   
        //計算縮放比例
        var w=($(window).width()*78/100)/videoW;
        var h=w;
        var pre=1;
        if(w>h){
          pre=h;
        }else{
          pre=w;
        }
   
        //設定目前的縮放比例
        $(this).width(videoW*pre);
        $(this).height(videoH*pre);
      });

      $(".share").each(function(i){
        //取得影像實際的長寬
        var imgW = $(this).width();
        var imgH = $(this).height();
   
        //計算縮放比例
        var w=31/imgW;
        var h=w;
        var pre=1;
        if(w>h){
          pre=h;
        }else{
          pre=w;
        }
   
        //設定目前的縮放比例
        $(this).width(imgW*pre);
        $(this).height(imgH*pre);
      });
    });

    // touchSlider
    $(document).ready(function(){
      $('#photo').touchSlider({
        mode: 'index',
        center: true,
        touch: true,
        prevLink: 'a.prev',
        nextLink: 'a.next',
        onChange: function(prev, curr) {
          $('#counter1').html((curr+1)+'/'+ $('#photo').get(0).getCount());
        },
        onStart: function(){
          $('#counter1').html('1/' + $('#photo').get(0).getCount());
        }
      });
      $('#cpn_photo').touchSlider({
        mode: 'index',
        center: true,
        touch: true,
        prevLink: 'a.prev',
        nextLink: 'a.next',
        onChange: function(prev, curr) {
          $('#counter2').html((curr+1)+'/'+ $('#cpn_photo').get(0).getCount());
        },
        onStart: function(){
          $('#counter2').html('1/' + $('#cpn_photo').get(0).getCount());
        }
      });
    });
  </script>

  <!-- user style -->
  <style type="text/css">
    /* font color */
    .user_text
    {
      color:<?=$font_color?>;
      font-size:<?=$font_size?>px;
      font-family:"<?=$font_family?>";
    }
    <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
    /* 背景顏色 */
    body
    {
      background-color:<?=$bg_color?>;
    }
    <?php elseif($bg_image_path != ''): ?>
    /* 背景圖 */
    body
    {
      background:url('<?=$base_url?><?=$bg_image_path?>') no-repeat 0px 0px; 
      -moz-background-size:cover;
      -webkit-background-size:cover;
      -o-background-size:cover;
      background-size:cover;
      background-attachment: fixed;
      background-position: center center;
    }
    <?php endif; ?>
  </style>

</head> 
<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;"> 

<!-- page -->
<div data-role="page" data-theme='z'>

  <div data-role="content">
      <table id='share_btn_table'>
          <tr>
              <td>
                  <!-- fb -->
                  <a href="#">
                      <img class='share' id='fb' title="分享到臉書" src="<?=$base_url?>images/share_btn/facebook.png" />
                  </a>
              </td>
              <td>
                  <!-- weibo -->
                  <a href="#">
                      <img class='share' id='weibo' title="分享到微博" src="<?=$base_url?>images/share_btn/weibo.png" />
                  </a>
              </td>
              <td>
                  <!-- googleplus -->
                  <a href="#">
                      <img class='share' id='google' title="分享到Google+" src="<?=$base_url?>images/share_btn/googleplus.png" />
                  </a>
              </td>
              <td>
                  <!-- plurk -->
                  <a href="#">
                      <img class='share' id='plurk' title="分享到Plurk" src="<?=$base_url?>images/share_btn/plurk.png" />
                  </a>
              </td>
              <td>
                  <!-- twitter -->
                  <a href="#">
                      <img class='share' id='twitter' title="分享到Twitter" src="<?=$base_url?>images/share_btn/twitter.png" />
                  </a>
              </td>
              <td>
                  <a href="#" rel="nofollow" ><img src="<?=$base_url?>images/share_btn/line.png" class='share' style='border:0;'/></a>
              </td>
              <td>
                  <!-- Email -->
                  <a href="#">
                      <img class='share' id='email' title="使用Email告訴朋友" src="<?=$base_url?>images/share_btn/email.png" />
                  </a>
              </td>
          </tr>
      </table>
  </div>

  
  <div data-role="content"> 

    <!-- photo -->
      <div class="gallery" id="photo"><!-- -->
        <div class="holder">
          <div class="list">
              <div class="item"><img class='img' src="/images/theme_sample_photo/001.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/002.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/003.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/004.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/005.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
          </div>
        </div>
        <a href="#" class="prev"><img src="<?=$base_url?>images/prevpage.png" style="width: 30px;height: 30px;" alt="" /></a>
        <a href="#" class="next"><img src="<?=$base_url?>images/nextpage.png" style="width: 30px;height: 30px;" alt="" /></a>
        <span id="counter1"></span>
      </div>
      <br>

    <!-- * introduction -->
    <div class='user_text'>王小明
    
    <!-- title_name -->
      <br>
          行動名片系統開發人員<br>
          行動名片系統設計人員<br>

    <br>您好，這是<?=$theme['theme_display_name']?>風格預覽

  </div>


  <div data-role="content"> 

    <!-- video -->
    <p class='user_text'>
      行動名片功能解說
      <iframe class='video_iframe' src="http://www.youtube.com/embed/cT7o5SQHpwE"></iframe>
    </p>

    <!-- linkthis -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">行動名片QR code</a>
    
    <!-- mecard -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">通訊錄QR Code</a>

    <!-- * moblie -->
    <a href="#" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">撥打我的行動電話</a>

    <!-- cpn_phone -->
    <a href="#" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">公司電話</a>

    <!-- cpn_number -->
    <a href="#" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">顯示我的統編</a>
    
    <!-- email -->
    <a href="#" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">寫信寄到我的電子信箱</a>
   
    <!--skype-->
    <a href="#" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">Skype通話</a>
  
    <!-- facebook -->
    <a href="#" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">我的Facebook</a>
  
    <!-- line -->
    <a href="#" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">加入我的Line為好友</a>

    <!-- address -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">查看公司位置</a>

    <!-- website -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">前往官方網站</a>

    <!-- text_edit01 -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">我的產品型錄</a>

    <!-- uform -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>">馬上報名活動展覽</a>
   
    <!-- exfile -->
    <a href="#" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>" data-icon='arrow-d' data-iconpos="right">使用說明文件</a>
   
    <!-- cpn_photo -->
      <div class="gallery" id="cpn_photo">
        <div class="holder">
          <div class="list">
              <div class="item"><img class='img' src="/images/theme_sample_photo/007.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/006.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/008.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/009.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
              <div class="item"><img class='img' src="/images/theme_sample_photo/010.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';"></p></div>
          </div>
        </div>
        <a href="#" class="prev"><img src="<?=$base_url?>images/prevpage.png" style="width: 30px;height: 30px;" alt="" /></a>
        <a href="#" class="next"><img src="<?=$base_url?>images/nextpage.png" style="width: 30px;height: 30px;" alt="" /></a>
        <span id="counter2"></span>
      </div>
      <br>

  </div>
  
  <!-- footer -->
  <div data-role="footer">
    <h4><a id='footer_a' href="<?=$base_url?>"><?=$web_config['title']?> © 2014</a></h4>
  </div>

</div><!-- page -->

</body>
</html>