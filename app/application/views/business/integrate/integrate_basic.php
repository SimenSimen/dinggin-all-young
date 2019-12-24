<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> 行動商務系統</title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='行動商務系統'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- share -->
  <meta property="og:url" content="<?=$iqr_url?>"/>
  <meta property="og:title" content="<?=$iqr_name?> 行動商務系統"/> 
  <meta property="og:image" content="<?=$base_url?><?=$og_image?>"/> 
  <meta property="og:description" content=""/>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="<?=$base_url?><?=$icon?>" />
  <!--js-->
  <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="https://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>

  <!--css-->
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
  <link rel="stylesheet" href="<?=$base_url?>css/integrate/<?=$theme_css?>" />
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

  <!--swipe-->
  <script type="text/javascript" src="<?=$base_url?>js/swipe/jquery.touchSwipe.min.js"></script>
  <link href="<?=$base_url?>js/swipe/touchswipe-gallery-style.css" rel="stylesheet">

  <!--script-->
  <script type="text/javascript">
    //圖片縮圖
    $(window).load(function(){

      $('#share_btn_table').css('width', Math.round($(window).width() * 91 / 100));
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding-right', '1px');
      $('#share_btn_table').css('padding-bottom', '10px');

      $(".video_iframe").each(function(i){
        //移除目前設定的影像長寬
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var videoW = $(this).width();
        var videoH = $(this).height();
   
        //計算縮放比例
        var w=(Math.round($(window).width() * 89 / 100))/videoW;
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
      background:url('<?=$base_url?><?=$bg_image_path?>') no-repeat center 0px;
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
                <a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                    <img class='share' id='fb' title="分享到臉書" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
                </a>
            </td>
            <td>
                <!-- weibo -->
                <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
                    <img class='share' id='weibo' title="分享到微博" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
                </a>
            </td>
            <td>
                <!-- googleplus -->
                <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                    <img class='share' id='google' title="分享到Google+" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
                </a>
            </td>
            <td>
                <!-- plurk -->
                <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
                    <img class='share' id='plurk' title="分享到Plurk" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
                </a>
            </td>
            <td>
                <!-- twitter -->
                <a href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
                    <img class='share' id='twitter' title="分享到Twitter" src="<?=$base_url?>/images/share_btn/twitter_35x35.png" />
                </a>
            </td>
            <td>
                <a href="https://line.naver.jp/R/msg/text/?<?=$iqr_name?>行動商務系統 <?=$iqr_url?>" rel="nofollow"><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>

            </td>
            <td>
                <!-- Email -->
                <a href="mailto:?subject=<?=$iqr_name?> 行動商務系統&body=我的行動商務系統網址：<br><?=$iqr_url?>">
                    <img class='share' id='email' title="使用Email告訴朋友" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
                </a>
            </td>
        </tr>
    </table>

    <!-- photo -->
    <?php if ($photo_show && !empty($photo_src)): ?>
      <table style="background-color: rgba(0,0,0,0.2);" id='photo_table'>
        <tr><td colspan="3"><div id="galleryTouch_0"><div id="imgs_0"><?=$photo_src?></div></div></td></tr>
        <tr>
        	<td rowspan="2"><a class='arrows' id='photo_left'><i class="fa fa-angle-left fa-2x"></i></a></td>
        	<td><div id="galleryNote_0"><div id="note_0"></div></div></td>
        	<td rowspan="2"><a class='arrows' id='photo_right'><i class="fa fa-angle-right fa-2x"></i></a></td>
        </tr>
        <tr><td id='photo_counter'><div id="galleryNumber_0"><div id="currentImgNumber_0"></div></div></td></tr>
      </table>
    <?php endif; ?>

    <!-- * introduction -->
    <div class='user_text'><?=$iqr['l_name']?><?=$iqr['f_name']?>
    
    <!-- titlename -->
    <?php if ($titlename_num != 0): ?>
      <br>
      <?php foreach ($titlename as $key => $value): ?>
        <?=$value?><br>
      <?php endforeach; ?>
    <?php endif; ?>

    <?if($iqr['introduce'] != ''):?><br><?=$iqr['introduce']?><?endif?></div>

    <?php
      // 可調整資料順序基礎code -> table sort -> view path
      // ytb_link
      $this->load->view('cells/ytb_link');
      // qrcode
      $this->load->view('cells/qrcode/app');     // app
      $this->load->view('cells/qrcode/web');     // web
      $this->load->view('cells/qrcode/mecard');  // mecard
      // mobile
      $this->load->view('cells/mobile');
      // mobile_phones
      $this->load->view('cells/mobile_phones');
      // cpn_phone
      $this->load->view('cells/cpn_phone');
      // cpn_cfax
      $this->load->view('cells/cpn_cfax');
      // cpn_number
      $this->load->view('cells/cpn_number');
      // email
      $this->load->view('cells/email');
      // skype
      $this->load->view('cells/skype');
      // facebook
      $this->load->view('cells/facebook');
      // line
      $this->load->view('cells/line');
      // address
      $this->load->view('cells/address');   
      // website
      $this->load->view('cells/website');
      // text_edit
      $this->load->view('cells/text_edit/01');
      $this->load->view('cells/text_edit/02');
      $this->load->view('cells/text_edit/03');
      // iqr_html_page
      $this->load->view('cells/iqr_html');
      // cart  
      $this->load->view('cells/cart');
      // uform
      $this->load->view('cells/uform');
      // ecoupon
      $this->load->view('cells/ecoupon');
      // exfile
      $this->load->view('cells/exfile');

      // 其他待續...
      // 重複資料類型(檔名)請使用版型id判斷(switch)
    ?>
  
    <!-- cpn_photo -->
    <?php if ($cpn_photo_show && !empty($cpn_photo_src)): ?>
      <table style="background-color: rgba(0,0,0,0.2);" id='cpn_photo_table'>
        <tr><td colspan="3"><div id="galleryTouch_1"><div id="imgs_1"><?=$cpn_photo_src?></div></div></td></tr>
        <tr>
        	<td rowspan="2"><a class='arrows' id='cpn_photo_left'><i class="fa fa-angle-left fa-2x"></i></a></td>
			<td><div id="galleryNote_1"><div id="note_1"></div></div></td>
			<td rowspan="2"><a class='arrows' id='cpn_photo_right'><i class="fa fa-angle-right fa-2x"></i></a></td>
        </tr>
        <tr><td id='cpn_photo_counter'><div id="galleryNumber_1"><div id="currentImgNumber_1"></div></div></td></tr>
      </table>
    <?php endif; ?>

    <!-- banner -->
    <?php if ($banner_show): ?>
      <a href="<?=$base_url?>free/<?=$mid?>" target='_top' data-role="button" data-corners="false" data-shadow="true" data-icon='star' data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$banner_name?></a>
    <?php endif; ?>
    
  </div>
  
  <!-- footer -->
  <div data-role="footer">
    <h4><?=$web_config['iqr_footer_text']?></h4>
    <?php if ($banner_show): ?><br />
    <!-- <img src="<?=$base_url?>/images/integrate/ad_01.png" width="536" height="40" border="0" /> 
    <a class="aa03" href="<?=$base_url?>free/<?=$mid?>" target='_self'><?=$banner_name?></a> -->
    <?php endif; ?>
  </div>

  </div><!-- page -->

<!-- Gallery -->
<script>
  $(function()
  {
      var IMG_WIDTH = Math.round($(window).width() * 89 / 100),
      currentImg_0=0, currentImg_1=0,
      maxImages_0='<?=$photo_amount?>', maxImages_1='<?=$cpn_photo_amount?>',
      speed=500,
      imgs_0 = $("#imgs_0"),
      imgs_1 = $("#imgs_1");

      //currentImgNumber
      $('#currentImgNumber_0').html('1 / '+maxImages_0);
      $('#currentImgNumber_1').html('1 / '+maxImages_1);

      // divs width
      $('#galleryTouch_0 #imgs_0').css('width', IMG_WIDTH * maxImages_0);
      $('#galleryTouch_1 #imgs_1').css('width', IMG_WIDTH * maxImages_1);
      // photo
      $('#photo_table').css('width', IMG_WIDTH);
      $('#photo_counter').css('width', IMG_WIDTH);
      $('#galleryTouch_0').css('width', IMG_WIDTH);
      $('#galleryTouch_1').css('width', IMG_WIDTH);
      $('#galleryTouch_0').css('height', 'auto');
      $('#galleryTouch_1').css('height', 'auto');
      $('#galleryTouch_0 #imgs_0 img').css('width', IMG_WIDTH);
      $('#galleryTouch_1 #imgs_1 img').css('width', IMG_WIDTH);
      // cpn_photo
      $('#cpn_photo_table').css('width', IMG_WIDTH);
      $('#cpn_photo_counter').css('width', IMG_WIDTH);

      //note
      var note_array_string = 'var note_array_0 = new Array(<?echo $photo_note;?>);';
      eval(note_array_string);
      var note_array_string = 'var note_array_1 = new Array(<?echo $cpn_photo_note;?>);';
      eval(note_array_string);
      $('#note_0').html(note_array_0[0]);
      $('#note_1').html(note_array_1[0]);

      $('#photo_left').click(function(){
        currentImg_0 = Math.max(currentImg_0-1, 0);
        scrollImages_0( IMG_WIDTH * currentImg_0, speed);
        $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
        $('#note_0').html(note_array_0[currentImg_0]);
      });
      $('#photo_right').click(function(){
        currentImg_0 = Math.min(currentImg_0+1, maxImages_0-1);
        scrollImages_0( IMG_WIDTH * currentImg_0, speed);
        $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
        $('#note_0').html(note_array_0[currentImg_0]);
      });
      $('#cpn_photo_left').click(function(){
        currentImg_1 = Math.max(currentImg_1-1, 0);
        scrollImages_1( IMG_WIDTH * currentImg_1, speed);
        $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
        $('#note_1').html(note_array_1[currentImg_1]);
      });
      $('#cpn_photo_right').click(function(){
        currentImg_1 = Math.min(currentImg_1+1, maxImages_1-1);
        scrollImages_1( IMG_WIDTH * currentImg_1, speed);
        $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
        $('#note_1').html(note_array_1[currentImg_1]);
      });

      //Init touch swipe
      imgs_0.swipe( {
          triggerOnTouchEnd : true,
          swipeStatus : function (event, phase, direction, distance, fingers)
          {
              //If we are moving before swipe, and we are going L or R, then manually drag the images
              if( phase=="move" && (direction=="left" || direction=="right") )
              {
                  var duration=0;

                  if (direction == "left")
                      scrollImages_0((IMG_WIDTH * currentImg_0) + distance, duration);

                  else if (direction == "right")
                      scrollImages_0((IMG_WIDTH * currentImg_0) - distance, duration);
              }

              //Else, cancel means snap back to the begining
              else if ( phase == "cancel")
              {
                  scrollImages_0(IMG_WIDTH * currentImg_0, speed);
              }

              //Else end means the swipe was completed, so move to the next image
              else if ( phase =="end" )
              {
                  if (direction == "right")
                      currentImg_0 = Math.max(currentImg_0-1, 0);
                  else if (direction == "left")
                      currentImg_0 = Math.min(currentImg_0+1, maxImages_0-1);

                  scrollImages_0( IMG_WIDTH * currentImg_0, speed);
                  $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
                  $('#note_0').html(note_array_0[currentImg_0]);
              }
          },
          allowPageScroll:"vertical"
      });

      imgs_1.swipe( {
          triggerOnTouchEnd : true,
          swipeStatus : function (event, phase, direction, distance, fingers)
          {
              //If we are moving before swipe, and we are going L or R, then manually drag the images
              if( phase=="move" && (direction=="left" || direction=="right") )
              {
                  var duration=0;

                  if (direction == "left")
                      scrollImages_1((IMG_WIDTH * currentImg_1) + distance, duration);

                  else if (direction == "right")
                      scrollImages_1((IMG_WIDTH * currentImg_1) - distance, duration);
              }

              //Else, cancel means snap back to the begining
              else if ( phase == "cancel")
              {
                  scrollImages_1(IMG_WIDTH * currentImg_1, speed);
              }

              //Else end means the swipe was completed, so move to the next image
              else if ( phase =="end" )
              {
                  if (direction == "right")
                      currentImg_1 = Math.max(currentImg_1-1, 0);
                  else if (direction == "left")
                      currentImg_1 = Math.min(currentImg_1+1, maxImages_1-1);

                  scrollImages_1( IMG_WIDTH * currentImg_1, speed);
                  $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
                  $('#note_1').html(note_array_1[currentImg_1]);
              }
          },
          allowPageScroll:"vertical"
      });

      function scrollImages_0(distance, duration)
      {
          imgs_0.css("-webkit-transition-duration", (duration/1000).toFixed(1) + "s");
          var value_0 = (distance<0 ? "" : "-") + Math.abs(distance).toString();
          imgs_0.css("-webkit-transform", "translate3d("+value_0 +"px,0px,0px)");
      }
      function scrollImages_1(distance, duration)
      {
          imgs_1.css("-webkit-transition-duration", (duration/1000).toFixed(1) + "s");
          var value_1 = (distance<0 ? "" : "-") + Math.abs(distance).toString();
          imgs_1.css("-webkit-transform", "translate3d("+value_1 +"px,0px,0px)");
      }
  });
</script>
<style type="text/css">
  #galleryTouch_0, #galleryTouch_1
  {
    overflow:hidden;
    position:relative;
    /*border : 1px solid black;*/
  }
  #galleryTouch_0 #imgs_0 img, #galleryTouch_1 #imgs_1 img
  {
    padding:0px;
    margin:0px;
    -webkit-transform: translate3d(0px,0px,0px);
  }
  #galleryNumber_0 div, #galleryNumber_1 div, #galleryNote_0 div, #galleryNote_1 div { text-align: center; }
  .arrows { text-decoration: none; color: #000000; }
</style>
</body>
</html>