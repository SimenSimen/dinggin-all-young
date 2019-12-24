<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>QRcode樣式 - <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type="text/javascript">
    $(function(){
      $('.why').hover(function(){
        $('.prompt-box').show();
      }, function() {
        $('.prompt-box').hide();
      });
    });
  </script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
 
  <p style="font-size:20px;"><?=$qrcode_file_name?>&nbsp;
    <a href="#" class="why">?</a><a href='#' onclick='javascript:window.open("<?=$base_url?>business/edit_qrc_style_teach", "QR code 編輯介面圖解", config="height=568,width=1054,top=50,left=143");' style="font-size:20px; margin-left: 0px;" class='aa5'>編輯介面說明視窗</a>
    <div class='prompt-box'>
      編輯您的行動商務系統QRcode樣式，創造獨具個人特色的行動商務系統QRcode連結圖片，讓其他裝置透過掃描快速開啟您的行動商務系統
    </div>
  </p>
  <br>
  <!--編輯區-->
  <iframe src="/business/editer_iframe/<?=$edit_target?>" style='width:100%;' height='500px;' scrolling='no'></iframe>
  <!--編輯區結束-->

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

</body>
</html>
