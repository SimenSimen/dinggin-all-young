<!DOCTYPE html>
<html lang="zh-Hant" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/app_icon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="57x57" href="/images/app_icon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/app_icon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/app_icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/app_icon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/app_icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/app_icon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/app_icon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/app_icon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/app_icon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/images/app_icon/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/images/app_icon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/images/app_icon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/images/app_icon/android-chrome-192x192.png" sizes="192x192">
    <meta name="msapplication-square70x70logo" content="images/app_icon/smalltile.png" />
    <meta name="msapplication-square150x150logo" content="images/app_icon/mediumtile.png" />
    <meta name="msapplication-wide310x150logo" content="images/app_icon/widetile.png" />
    <meta name="msapplication-square310x310logo" content="images/app_icon/largetile.png" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/icon-font/style.css">
    <link rel="stylesheet" type="text/css" href="/js/jquery.bxslider/jquery.bxslider.min.css">
    <link rel="stylesheet" type="text/css" href="/js/WOW/css/libs/animate.css">
    <link rel="stylesheet" type="text/css" href="/js/fancyBox/source/jquery.fancybox.css">
    <link rel="stylesheet" href="/js/slick/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/modernizr.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            height: auto;
        }
    </style>
</head>
<body>
<div class="lightbox-wrapper">
    <h1><?=$this->lang['share'];?></h1>
    <ul class="share-box list-h">
        <li><a href="javascript: void(window.open('https://www.facebook.com/share.php?u=<?=$shareUrl;?>'));"><i><img src="/images/share_link/icon-fb.png" align="center" ></i>facebook</a></li>
        <li><a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title=share'+'&shareUrl=<?=$shareUrl;?>'+'&source=bookmark','_blank','width=450,height=400');})()"><i><img src="/images/share_link/icon-weibo.jpg" align="center" ></i>Weibo</a></li>
        <li><a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&content=<?=$shareUrl;?>'.concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"><i><img src="/images/share_link/icon-plurk.png" align="center" ></i>Plurk</a></li>                
        <li><a href="javascript: void(window.open('https://twitter.com/home/?status= share <?=$shareUrl;?>'));"><i><img src="/images/share_link/icon-twitter.png" align="center" ></i>Twitter</a></li>
        <li><a href="javascript: void(window.open('https://social-plugins.line.me/lineit/share?url=<?=$shareUrl;?>') );"><i><img src="/images/share_link/icon-line.png" align="center"></i>Line</a></li>
        <!--<li><a class="jiathis_button_weixin" title="分享到微信" alt="分享到微信"><i><img src="/images/share_link/icon-wechat.png" align="center"></i>We chat</a></li>-->
        <li><a href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br><?=$shareUrl;?>'));"><i><img src="/images/share_link/icon-mail.png" align="center"></i>E-mail</a></li>
    </ul>
<!-- JiaThis Button BEGIN 
<div id="ckepop">
<script type="text/javascript" src="https://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
</div> JiaThis Button END -->
</div>
</body>
</html>
