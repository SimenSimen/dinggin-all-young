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
         //   iqr_img_double=(($(window).width()*94/100))*2;
         // }
         // else
         // {
         //   iqr_img_double=($(window).width()*94/100);
         // }
         if($('#iqr_html').val() == 1)
         {
          iqr_img_double=600;
         }
         else
         {
          if($('#iqr_img_double').val() == 1)
          {
              iqr_img_double=($(window).width()*94/100)*2;
          }
          else
            iqr_img_double=($(window).width()*94/100);
         }
         if($('#iqr_img_ipad').val() == 1)
          iqr_img_double=600;
         
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
       });

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
         //   iqr_img_double=(($(window).width()*94/100))*2;
         // }
         // else
         // {
         //   iqr_img_double=($(window).width()*94/100);
         // }
         if($('#iqr_html').val() == 1)
         {
          iqr_img_double=600;
         }
         else
         {
          if($('#iqr_img_double').val() == 1)
          {
              iqr_img_double=($(window).width()*94/100)*2;
          }
          else
            iqr_img_double=($(window).width()*94/100);
         }
         if($('#iqr_img_ipad').val() == 1)
          iqr_img_double=600;
         
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
      font: <?=$font_size?>px "<?=$font_family?>", Helvetica, sans-serif, "微軟正黑體";
    }
    .words
    {
      color:<?=$font_color?>;
    }
    h1{
      color:<?=$font_color?>;
    }
    .bg_01{
      background:url('/images/integrate/theme_background/bg_046.jpg') no-repeat 0px 0px; 
      -moz-background-size:cover;
      -webkit-background-size:cover;
      -o-background-size:cover;
      background-size:cover;
      background-attachment: fixed;
      background-position: center center;
    }
  </style>

</head> 


<body class="bg_01" scroll="yes" style="overflow-x: hidden;">

<input value='<?=$iqr_img_double?>' type='hidden' id='iqr_img_double'>
<input value='<?=$iqr_img_ipad?>' type='hidden' id='iqr_img_ipad'>
<input value='<?=$iqr_html?>' type='hidden' id='iqr_html'>

<div id="container">
<div id="header">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_fb.png" alt="facebook" width="80" height="80" border="0" longdesc="#" /></a></td>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_t.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_sina.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_goo.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_pl.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
        <td><a href="#" rel="nofollow" ><img src="<?=$base_url?>/images/integrate/social_line.png" width="80" height="80" style='border:0;' /></a></td>
        <td><a href="#"><img src="<?=$base_url?>/images/integrate/social_mail.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
      </tr>
    </table>
  </div>

<div class="main">
<!-- photo -->
<div class="main_sh"></div> <!--上方選單的陰影-->
  <div class="gallery" id="photo"><!-- -->
    <div class="holder">
      <div class="list">
        <div class="item"><img class='img' src="/images/theme_sample_photo/001.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/002.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/003.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/004.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
        <div class="item"><img class='img' src="/images/theme_sample_photo/005.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
      </div>
    </div>
    <div class="main_ar">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="#" class="prev aaL"></a></td>
          <td><span id="counter1"></span></td>
          <td><a href="#" class="next aaR"></a></td>
        </tr>
      </table>   
    </div> 
  </div>

<!--introduction-->
  <div class="words">
    王小明<br>
    
    <!-- title_name -->
    <br>
          行動名片系統開發人員<br>
          行動名片系統設計人員<br>

    <br>您好，這是<?=$theme['theme_display_name']?>風格預覽
  </div>
</div><!--main div end-->


<div class="main">
    <h1>企業形象</h1>
    <!-- 公司相簿 cpn_photo -->
      <div class="gallery" id="cpn_photo"  class='album_background_color_div'><!-- -->
        <div class="holder">
          <div class="list">
            <div class="item"><img class='img' src="/images/theme_sample_photo/007.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
            <div class="item"><img class='img' src="/images/theme_sample_photo/006.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
            <div class="item"><img class='img' src="/images/theme_sample_photo/008.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
            <div class="item"><img class='img' src="/images/theme_sample_photo/009.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
            <div class="item"><img class='img' src="/images/theme_sample_photo/010.jpg" /><p style="text-align: center;font-family:'<?=$font_family?>';width:600px;white-space:normal;"></p></div>
          </div>
        </div>
        <div class="main_ar">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><a href="#" class="prev aaL"></a></td>
              <td><span id="counter2"></span></td>
              <td><a href="#" class="next aaR"></a></td>
            </tr>
          </table>   
        </div> 
      </div>
</div>
  

    <div class="main">

    <!-- video -->
      <p class='user_text'>
        <h1>行動名片功能解說</h1>
        <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/cT7o5SQHpwE"></iframe>
      </p>
    </div>

  <div class="main">
    <h1>QRcode</h1>

    <!-- linkthis -->
    <a class="aa02" href="#" target='_self'>行動名片QR code</a>
    
    <!-- mecard -->
    <a class="aa02" href="#" target='_self'>通訊錄QR Code</a>

    </div>
    
  <div class="main">
    <h1>聯絡資訊</h1>
    
  <!-- * moblie -->
  <a class="aa02" href="#">撥打我的行動電話</a>

  <!-- cpn_phone -->
  <a class="aa02" href="#">公司電話</a>

  <!-- cpn_number -->
  <a class="aa02" href="#">顯示我的統編</a>

  <!-- email -->
  <a class="aa02" href="#">寫信寄到我的電子信箱</a>

  <!-- skype -->
  <a class="aa02" href="#">Skype通話</a>

  <!-- facebook -->
  <a class="aa02" href="#">我的Facebook</a>

  <!-- line -->
  <a class="aa02" href="#">加入我的Line為好友</a>

  </div>

  <div class="main">
    <h1>地圖</h1>
      <!-- address -->
      <a class="aa02" href="#">查看公司位置</a>
  </div>


  <div class="main">
    <h1>網站</h1>
      
    <!-- website -->
    <a class="aa02" href="#">前往官方網站</a>

    <!-- uform -->
    <a class="aa02" href="#">馬上報名活動展覽</a>

  </div>
    
  <!-- 產品型錄 -->
    <div class="main">
      <h1>連結</h1>
      <!-- text_edit01 -->
      <a href="#" class="aa02">我的產品型錄</a>
    </div>
    
    <div class="main">
      <h1>附件</h1>

    <!-- exfile -->
    <a href="#" class="aa02" >使用說明文件</a>
    </div>

       
  <div id="ad"><?=$web_config['title']?> © 鼎鈞數位行銷有限公司
  
  </div>  

</div>

</body>
</html>
