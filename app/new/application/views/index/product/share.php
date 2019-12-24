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
</head>
<body>
<div class="lightbox-wrapper">
    <h1><?=$this->lang['share'];?></h1>
    <ul class="share-box list-h">
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript: void(window.open('http://www.facebook.com/share.php?u=<?=$shareUrl;?>'));"<?}?>><i><img src="/images/share_link/icon-fb.png" align="center" ></i>facebook</a></li>
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title=share'+'&shareUrl=<?=$shareUrl;?>'+'&source=bookmark','_blank','width=450,height=400');})()"<?}?>><i><img src="/images/share_link/icon-weibo.jpg" align="center" ></i>Weibo</a></li>
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&content=<?=$shareUrl;?>'.concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"<?}?>><i><img src="/images/share_link/icon-plurk.png" align="center" ></i>Plurk</a></li>                
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript: void(window.open('http://twitter.com/home/?status= share <?=$shareUrl;?>'));"<?}?>><i><img src="/images/share_link/icon-twitter.png" align="center" ></i>Twitter</a></li>
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript: void(window.open('http://line.naver.jp/R/msg/text/?'+encodeURIComponent('<?=$shareUrl;?>') ));"<?}?>><i><img src="/images/share_link/icon-line.png" align="center"></i>Line</a></li>
        <!--<li><a class="jiathis_button_weixin" title="分享到微信" alt="分享到微信"><i><img src="/images/share_link/icon-wechat.png" align="center"></i>We chat</a></li>-->
        <li><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" <?}else{?> href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br><?=$shareUrl;?>'));"<?}?>><i><img src="/images/share_link/icon-mail.png" align="center"></i>E-mail</a></li>
    </ul>
<!-- JiaThis Button BEGIN 
<div id="ckepop">
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
</div> JiaThis Button END -->
</div>
</body>
</html>
<script>
//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$shareUrl?>&ecp_title=<?=$public_share_title?>';
    var i_val = "jecp://<?=$img_url?>&ecp_title=<?=$shareUrl?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>