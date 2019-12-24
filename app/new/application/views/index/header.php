<!DOCTYPE html>
<html lang="zh-Hant-TW" class="no-js">
<head>
<meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<meta name="msapplication-square70x70logo" content="/images/app_icon/smalltile.png" />
<meta name="msapplication-square150x150logo" content="/images/app_icon/mediumtile.png" />
<meta name="msapplication-wide310x150logo" content="/images/app_icon/widetile.png" />
<meta name="msapplication-square310x310logo" content="/images/app_icon/largetile.png" />
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
	<title><?=$this->lang_menu['jcymall'];//聚彩源商城?></title><!--<title><?=$this -> web_title?></title>-->
    <?=$main_css;?>
</head>
<body class="products">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <header class="site-header">
            <div class="container">
                <div class="site-title"><a href="/products/index" class="logo ibtn"><?=$this->lang_menu['jcymall'];//聚彩源商城?></a></div>
                <select class="language" id="selectsortid">
                    <? foreach ($this->lang_list as $key => $value):?>
                        <?if($value['d_code']==$this->setlang){?>
                            <option selected value="<?=$value['d_code']?>"><?=$value['d_title']?></option>
                        <?}else{?>
                            <option value="<?=$value['d_code']?>"><?=$value['d_title']?></option>
                        <?}?>
                    <? endforeach;?>
                </select>
                <div class="memberid"><a href="/gold/member"><?=$_SESSION['MT']['name']?></a></div>
                <div class="toplink">
                    <ul class="list-h">
                        <li><a href="/gold/about" title="<?=$this->lang_menu['about'];//關於聚彩源?>"><i class="icon-home"></i><span><?=$this->lang_menu['about'];//關於聚彩源?></span></a></li>
                        <li><a href="/gold/login" title="<?=$this->lang_menu['member'];//會員專區?>"><i class="icon-member"></i><span><?=$this->lang_menu['member'];//會員專區?></span></a></li>
                        <li><a href="/products" title="<?=$this->lang_menu['products'];//購物商城?>"><i class="icon-shop"></i><span><?=$this->lang_menu['products'];//購物商城?></span></a></li>
                        <li><a href="/cart" title="<?=$this->lang_menu['cart'];//購物車?>"><i class="icon-shopping-cart"></i><span><?=$this->lang_menu['cart'];//購物車?></span></a></li>
                        <li><a href="/gold/service" title="<?=$this->lang_menu['servicearea'];//服務專區?>"><i class="icon-support"></i><span><?=$this->lang_menu['servicearea'];//服務專區?></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="menu-box wow fadeInDown">
                <div class="container">
                    <nav class="site-nav">
                        <ul class="menu list-h">
                            <li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a></li>
                            <li><a href="/gold/contact"><?=$this->lang_menu['contact'];//與聚彩源對話?></a></li>
                            <li><a href="/gold/register"><?=$this->lang_menu['register'];//加入我們?></a></li>
                            <li><a href="/gold/link/C/link"><?=$this->lang_menu['link'];//友善連結?></a></li>
                            <li><a href="/gold/news/C/news"><?=$this->lang_menu['news'];//最新消息?></a></li>
                            <li><a href="/gold/activity/C/enroll"><?=$this->lang_menu['activity'];//活動與報名?></a></li>
                            <li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a>
								<ul>
									<li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a></li>
									<li><a href="/gold/service"><?=$this->lang_menu['servicearea'];//服務專區?></a></li>
									<li><a href="/gold/media/c/video"><?=$this->lang_menu['movie'];//影音專區?></a></li>
									<li><a href="/gold/photo/c/photo"><?=$this->lang_menu['album'];//活動花絮?></a></li>
									<li><a href="/gold/archive/c/annex"><?=$this->lang_menu['download'];//文件下載?></a></li>
								</ul>
                            </li>
                            <li><a href="/gold/member"><?=$this->lang_menu['member'];//會員專區?></a>
                                <ul>
									<?if($_SESSION['MT']['is_login']==1){?>
									<li><a href="#"><?=$_SESSION['MT']['name']?><?=$this->lang_menu['logged_in'];//已登入?></a></li>
									<?}else{?>
									<li><a href="/gold/login"><?=$this->lang_menu['login'];//會員登入?></a></li>
									<?}?>
                                    <li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a></li>
                                    <li><a href="/favorite"><?=$this->lang_menu['favorite'];//最愛商品?></a></li>
                                    <li><a href="/order"><?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
                                    <li><a href="/bonus/dividend"><?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
                                    <li><a href="/gold/member_dividend_fun"><?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
                                    <li><a href="/gold/member_info"><?=$this->lang_menu['member_info'];//基本資料?></a></li>
                                    <li><a href="/gold/member_address"><?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
                                    <li><a href="/gold/member_announcement"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
                                    <li><a href="/gold/invite_share"></i><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
                                    <li><a href="<?if($_SESSION['MT']['d_is_member']=="0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"><i class="icon-leader"></i> <?=$this->lang_menu['member_upgrade'];//升級經營會員?>
                                        <?if($_SESSION['MT']['d_is_member']=="2")
                                            echo "(".$this->lang_menu['under_review'].")";//審核中
                                        ?>
                                        <?if($_SESSION['MT']['d_is_member']=="1")
                                            echo "(".$this->lang_menu['under_review'].")";//已升級
                                        ?>
                                        </a></li>
    								<?if($_SESSION['MT']['d_is_member']=="1"){?>
                                    <li><a href="/gold/member_active"><?=$this->lang_menu['member_active'];//活躍指標?></a></li>
                                    <li><a href="/order/member_sale"><?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
                                    <li><a href="/gold/organization"><?=$this->lang_menu['organization'];//組織表?></a></li>
                                    <li><a href="/gold/invoice"><?=$this->lang_menu['invoice'];//我要請款?></a></li>
                                    <li><a href="/gold/member_bonus"><?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
                                    <li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
                                    <?}?>
                                    <?if($_SESSION['MT']['is_login']==1){?>
                                    <li><a href="/gold/logout"><?=$this->lang_menu['logout'];//會員登出?></a></li>
                                    <?}?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="marquee wow fadeInDown" data-wow-delay="0.2s">
                <div class="container"><?=$memberName;?>
                    <span><?=$this->lang_menu['cash_back'];//最高可賺取33%現金回饋。?><a href="/gold/member_register"><?=$this->lang_menu['understand_deeper'];//深入了解?></a></span>
                </div>
            </div>
        </header>
            <?=$banner;?>
            <main class="main-content wow fadeInUp" data-wow-delay="0.4s">
            <header class="main-top">
            <div class="container">
                <ol class="breadcrumb list-inline">
                    <li><a href="/"><span><?=$this->lang_menu['home'];//首頁?></span></a></li><?=$path_title;?>
                </ol>
            </div>
            </header>
<script>
$("#selectsortid").change(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $("#selectsortid").val()
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
</script>