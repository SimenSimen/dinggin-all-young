<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
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
  <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="<?=$base_url?>/js/jquery.touchSlider.js"></script>
  <script type="text/javascript" src="<?=$base_url?>/js/tabulous.js"></script>

  <!--css-->
  <link rel="stylesheet" href="<?=$base_url?>/css/integrate/<?=$theme_css?>" /><!--主題css-->
  <link href="<?=$base_url?>/css/integrate/<?=$slider_css?>" rel="stylesheet" type="text/css" />

  <!--script-->
  <script type="text/javascript">

    //圖片縮圖
    $(window).load(function(){

      var photo_note_div;
       $(".img").each(function(i){
         //移除目前設定的影像長寬
         $(this).removeAttr('width');
         $(this).removeAttr('height');
   
         // 取得影像實際的長寬
         var imgW = $(this).width();
         var imgH = $(this).height();

         //計算縮放比例
         var iqr_img_double;
         // if($('#iqr_img_double').val() == 1)
         // {
         //  iqr_img_double=$(window).width()*2;
         // }
         // else
         // {
         //  iqr_img_double=$(window).width();
         // }
         if($('#iqr_html').val() == 1)
         {
          iqr_img_double=640;
         }
         else
         {
          if($('#iqr_img_double').val() == 1)
          {
              iqr_img_double=($(window).width())*2;
              if(iqr_img_double > 640)
                iqr_img_double = 640;
          }
          else
            iqr_img_double=($(window).width());
         }
         if($('#iqr_img_ipad').val() == 1)
          iqr_img_double=768;
         
         var w=iqr_img_double/imgW;
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

         photo_note_div = imgW*pre;
       });
      
      $('.photo_note_div').each(function(){
        $(this).css('width', photo_note_div);
      });

      var cpn_photo_note_div;
       $(".cpn_img").each(function(i){
         //移除目前設定的影像長寬
         $(this).removeAttr('width');
         $(this).removeAttr('height');
   
         // 取得影像實際的長寬
         var imgW = $(this).width();
         var imgH = $(this).height();

         //計算縮放比例
         var iqr_img_double;
         // if($('#iqr_img_double').val() == 1)
         // {
         //  iqr_img_double=$(window).width()*2;
         // }
         // else
         // {
         //  iqr_img_double=$(window).width();
         // }
         if($('#iqr_html').val() == 1)
         {
          iqr_img_double=640;
         }
         else
         {
          if($('#iqr_img_double').val() == 1)
          {
              iqr_img_double=($(window).width())*2;
              if(iqr_img_double > 640)
                iqr_img_double = 640;
          }
          else
            iqr_img_double=($(window).width());
         }
         if($('#iqr_img_ipad').val() == 1)
          iqr_img_double=768;
         
         var w=iqr_img_double/imgW;
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

         cpn_photo_note_div = imgW*pre;
       });

        $('.cpn_photo_note_div').each(function(){
          $(this).css('width', cpn_photo_note_div);
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
    body
    {
      zoom:44.5%;
    }
    *{
      font: <?=$font_size?>px "<?=$font_family?>", sans-serif, "微軟正黑體";
    }
    h1{
      font-size: <?=$font_size?>px;
      color: <?=$font_color?>;
    }
    h2{
      font-size: <?=$font_size?>px;
      font-family: "<?=$font_family?>", sans-serif, "微軟正黑體";
      color: <?=$font_color?>;
    }
    h3{
      font-size: <?=$font_size?>px;
      font-family: "<?=$font_family?>", sans-serif, "微軟正黑體";
      color: #fff;
    }
    .bg_01{
      background:<?=$bg_color?>;
      }
  </style>
  <script>
    $(document).ready(function ($) {
      $("#tabs").tabs();
      $("#tabs").tabulous({
        effect: 'slideLeft' 
      });
    });
  </script>

</head> 



<body class="bg_01" scroll="yes" style="overflow-x: hidden;">

<input value='<?=$iqr_img_double?>' type='hidden' id='iqr_img_double'>
<input value='<?=$iqr_img_ipad?>' type='hidden' id='iqr_img_ipad'>
<input value='<?=$iqr_html?>' type='hidden' id='iqr_html'>

<div id="container">
	<div class="circle">
	<img src="/images/theme_sample_photo/001.jpg" width="310" height="310" class="image-wrap" />
	</div>

    <h1 class="name">王小明</h1>
    
    <div id="tabs">

      <ul>
          <li><a href="#tabs-1" title="">QR code</a></li>
          <li><a href="#tabs-2" title="">聯絡我</a></li>
          <li><a href="#tabs-3" title="">關於我</a></li>
          <li><a href="#tabs-4" title="">分享名片</a></li>
      </ul>

      <div id="tabs_container">

        <div id="tabs-1">
            <a class="aa04-QR" herf='#' target='_self'>行動名片QR Code</a>
            <a class="aa04-QR" herf='#' target='_self'>通訊錄QR Code</a>
            <p class="tabArrowDown"></p>
        </div>

        <div id="tabs-2">

            <!-- line -->
            <a class="aa04-line" href="#">加入我的Line為好友</a>

            <!-- facebook -->
            <a class="aa04-fb" href="#">我的Facebook</a>

            <!-- mobile -->
            <a class="aa04" id="icon09">撥打我的行動電話</a>

            <!-- skype -->
            <a class="aa04" id="icon09">Skype通話</a>

      			<!-- cpn_phone -->
            <a class="aa04" id="icon08">公司電話</a>

      			<!-- cpn_number -->
            <a class="aa04" id="icon01">顯示我的統編</a>

  		      <!-- email -->
            <a class="aa04" id="icon06">寫信寄到我的電子信箱</a>

            <!-- address -->
            <a href="#" class="aa04" id="icon03">查看公司位置</a>

            <!-- website -->
            <a href="#" class="aa04" id="icon04">前往官方網站</a>

            <!-- uform -->
            <a class="aa04" id="icon12" href="#">馬上報名活動展覽</a>

        </div>

        <!--introduction-->
        <div id="tabs-3">
          行動名片系統開發人員<br>
          行動名片系統設計人員<br>
          <p style='position:relative; left:3%;'>您好，這是<?=$theme['theme_display_name']?>風格預覽</p>

          <p class="tabArrowDown"></p>
        </div>

        <div class='tabs' id="tabs-4">
            <h1><p style='position:relative; left:-5%;'>將我的行動名片分享至各大社群</p><h1>
            <a class="aa05" id="so01" target="_self"></a>
            <a class="aa05" id="so02" target="_self"></a>
            <a class="aa05" id="so03" target="_self"></a>
            <a class="aa05" id="so04" target="_self" rel="nofollow"></a>
            <a class="aa05" id="so05" target="_self"></a>
            <a class="aa05" id="so06" target="_self"></a>
            <a class="aa05" id="so07" target="_self"></a>
            <p class="clear"></p>
            <p class="tabArrowDown"></p>
        </div>

      </div><!--End tabs container-->

    </div><!--End tabs-->

<!-- photo -->
<div class="main"> 
  <div class="divh2"><h2>形象圖</h2></div> 
  <div class="gallery" id="photo"><!-- -->
    <div class="holder">
      <div class="list">
        <div class="item"><img class='img' src="/images/theme_sample_photo/001.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/002.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/003.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/004.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/005.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
      </div>
    </div>
    <div class="main_ar">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="#" class="prev"><img src="<?=$base_url?>/images/integrate/ar_01_L.png" width="22" height="40" border="0" /></a></td>
          <td><span id="counter1"></span></td>
          <td><a href="#" class="next"><img src="<?=$base_url?>/images/integrate/ar_01_R.png" width="22" height="40" border="0" /></a></td>
        </tr>
      </table>   
    </div>
  </div>
</div>
    
<div class="main">
<div class="divh2"><h2>Video</h2></div> 

  <!-- video -->
  <h3>行動名片功能解說</h3>
  <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="https://www.youtube.com/embed/cT7o5SQHpwE"></iframe>

</div>

<!-- 產品型錄 -->
<div class="main">
<div class="divh2"><h2>連結</h2></div>
    <a href="#" class="aa04" id="icon04">我的產品型錄</a>
</div>

<div class="main">
<div class="divh2"><h2>附件</h2></div> 
<div class="main_txt">

    <a id="icon13" class="aa04" href="#">使用說明文件</a>

</div>
</div>


<!-- 公司相簿 cpn_photo -->
<div class="main"> 
  <div class="divh2"><h2>企業形象</h2></div> 
  <div class="gallery" id="cpn_photo"><!-- -->
    <div class="holder">
      <div class="list">
        <div class="item"><img class='img' src="/images/theme_sample_photo/007.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/006.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/008.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/009.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/010.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:640px;white-space:normal;"></p></div>
      </div>
    </div>
    <div class="main_ar">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="#" class="prev"><img src="<?=$base_url?>/images/integrate/ar_01_L.png" width="22" height="40" border="0" /></a></td>
          <td><span id="counter2"></span></td>
          <td><a href="#" class="next"><img src="<?=$base_url?>/images/integrate/ar_01_R.png" width="22" height="40" border="0" /></a></td>
        </tr>
      </table>   
    </div>
  </div>
</div>
<p>&nbsp;</p>
    
  <div id="ad"><?=$web_config['title']?> © 鼎鈞數位行銷有限公司

	</div>  

</div>
</body>
</html>
