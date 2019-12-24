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
<link rel="stylesheet" type="text/css" href="/css/normalize.css">
<link rel="stylesheet" type="text/css" href="/css/icon-font/style.css">
<link rel="stylesheet" type="text/css" href="/js/jquery.bxslider/jquery.bxslider.min.css">
<link rel="stylesheet" type="text/css" href="/js/fancyBox/source/jquery.fancybox.css">
<link rel="stylesheet" href="/js/slick/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/css/basic.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">
	<title><?=$this->lang_menu['jcymall'];//聚彩源商城?></title>
    <?=$main_css;?>
</head>
<!-- using axios to fetch api -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!-- using lodash to handle array or collection -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

<script src="/js/jquery.min.js"></script>
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
                <?if($this->DataName=='products'){?>
                    <div class="memberid" id="nav-bottom-menu">
                        <form id="search" method="post" action="/products/search_engine" onsubmit="return check(this)"> 
                            <input type="text" class="field input" style="border-radius: 30px; border: 1px solid #CCCCCC;" name="search_key" id="s" placeholder="<?=$this->lang['ikeyword'];//請輸入關鍵字?>" />
                            <a class="aa6" href="javascript:void(0);">
                                <i class="icon-search"></i><?=$this->lang['strsearch'];//搜尋?>
                            </a> 
                        </form>
                    </div>
                <?}else if($_SERVER['REQUEST_URI']=='/gold/member' or $_SERVER['REQUEST_URI']=='/gold/member/' or 
                            $_SERVER['REQUEST_URI']=='/cart' or $_SERVER['REQUEST_URI']=='/cart/'){?>
                <?}else{?>
                    <div class="memberid"><a href="/gold/member"><?=$_SESSION['MT']['name']?></a></div>
                <?}?>
                <div class="toplink">
                    <ul class="list-h">
                    <? foreach ($this->icon_link_list as $key => $value):?>
                        <?if ($_SESSION['MT']['is_login'] == 1 && $value['d_link'] == '/gold/register') {?>
                        <?} elseif ($_SESSION['MT']['is_login'] != 1 && $value['d_link'] == '/gold/logout') {?>
                        <?} else {?>
                            <li><a href="<?=$value['d_link']?>" title="<?=$this->lang_menu[$value['d_lang']];?>"><i class="<?=$value['d_icon']?>"></i><span><?=$this->lang_menu[$value['d_lang']];?></span></a></li>
                        <?}?>
                    <? endforeach;?>
                    </ul>
                </div>
            </div>
            <div class="menu-box wow fadeInDown">
                <div class="container">
                    <nav class="site-nav">
                        <ul class="menu list-h">
						<? foreach ($this->menu_link_list as $key => $value):?>
                            <?if($value['d_link'] == '/gold/register' and $_SESSION['MT']['is_login'] == 1){//已登入不出現加入我們?>
                            <?}else{?>
                                <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a></li>
                            <?}?>
						<? endforeach;?>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="marquee wow fadeInDown" data-wow-delay="0.2s">
                <div class="container"><?=$memberName;?>
                    <span><?=$this->lang_menu['cash_back'];//最高可賺取33%現金回饋。?><a href="/gold/contact"><?=$this->lang_menu['understand_deeper'];//深入了解?></a></span>
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
<style>
#nav-bottom-menu #search {
    text-align: right;
}
#search {
    text-align: right;
}
#nav-bottom-menu #s {
    background-color: #f9f9f9;
    -webkit-transition-duration: 400ms;
    -moz-transition-duration: 400ms;
    -o-transition-duration: 400ms;
    width: 80px;
}
#nav-bottom-menu #s:focus {
    background-color: #f9f9f9;
    width: 160px;
}
</style>