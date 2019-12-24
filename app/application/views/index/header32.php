<!DOCTYPE html>
<html lang="zh-Hant-TW" class="no-js">
<head>
<meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
<!--
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
-->
<meta name="msapplication-square70x70logo" content="/images/app_icon/smalltile.png" />
<meta name="msapplication-square150x150logo" content="/images/app_icon/mediumtile.png" />
<meta name="msapplication-wide310x150logo" content="/images/app_icon/widetile.png" />
<meta name="msapplication-square310x310logo" content="/images/app_icon/largetile.png" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/normalize.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/css/icon-font/style.css">
<link rel="stylesheet" type="text/css" href="/js/jquery.bxslider/jquery.bxslider.min.css">

<link rel="stylesheet" href="/js/slick/slick/slick.css">
<link rel="stylesheet" href="/css/owl.carousel.css">
<link rel="stylesheet" href="/css/owl.theme.default.min.css">
<!--
<link rel="stylesheet" type="text/css" href="/css/basic.css">
-->
<link rel="stylesheet" type="text/css" href="/css/style.css">

<script src="/js/modernizr.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.min.js"></script>
<script src="/js/owl.carousel.js"></script>

<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="/js/fancyBox/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="/js/fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/js/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="/js/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<title><?=$dbdata['prd_name'];//產品名稱?>-<?=$dbdata['prd_cname'];//產品分類?>-<?=$this->lang_menu['jcymall'];//芬芳美學?></title>
    <?=$main_css;?>
<script>
$(function() {
	$( document ).tooltip();
});
</script>
</head>
<body class="<?=$body_class;?>">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper <?=$wrapper_class;?>">
        <header class="site-header">
            <div class="container">
                <div class="site-title"><a href="/index" class="logo ibtn"><?=$this->lang_menu['jcymall'];//聚彩源商城?></a></div>
				<? if(count($this->lang_list)>1){?>
				<select class="language" id="selectmenu">
					<? foreach ($this->lang_list as $key => $value):
						if($this->setlang!=$value['d_code']){?>
						<option value="<?=$value['d_code']?>" ><?=$value['d_title']?></option>
					<?}else{?>
						<option value="<?=$value['d_code']?>" selected><?=$value['d_title']?></option>
					<?}
					endforeach;?>
				</select>
				<?}?>
                <div class="memberid"><a href="/gold/member"><i class="icon-leader"></i></a></div>
                <div class="toplink">
                    <ul class="list-h">
                    <? foreach ($this->icon_link_list as $key => $value):
                        if($value['d_lang']=='logout'){
                            if(!empty($_SESSION['MT']['by_id'])){   ?>
                                <li><a href="<?=$value['d_link']?>" title="<?=$this->lang_menu[$value['d_lang']];?>"><i class="<?=$value['d_icon']?>"></i><span><?=$this->lang_menu[$value['d_lang']];?></span></a></li>
                    <?      }
                        }else if($value['d_lang']=='register'){
                            if(empty($_SESSION['MT']['by_id'])){   ?>
                                <li><a href="<?=$value['d_link']?>" title="<?=$this->lang_menu[$value['d_lang']];?>"><i class="<?=$value['d_icon']?>"></i><span><?=$this->lang_menu[$value['d_lang']];?></span></a></li>
										<?      }
                        }else if($value['d_lang']=='cart'){　?>
                            <li><a href="<?=$value['d_link']?>" title="<?=$this->lang_menu[$value['d_lang']];?>"><i class="<?=$value['d_icon']?>"></i><span><?=$this->lang_menu[$value['d_lang']];?></span></a></li>
														<a class="join_car_count" style="position: absolute;z-index: 99;font-size: 1.1em;color: #fff;margin: -15px 0 0 -40px;background: #F00;padding: 0 6px;border-radius: 99px;cursor: default;"><font>
														<?php if(!empty($_SESSION['join_car'])){ ?><?=array_sum($_SESSION['join_car']);?>
														<?php } ?></font></a>
                    <?  }else {?>
                            <li><a href="<?=$value['d_link']?>" title="<?=$this->lang_menu[$value['d_lang']];?>"><i class="<?=$value['d_icon']?>"></i><span><?=$this->lang_menu[$value['d_lang']];?></span></a></li>
                    <?  } endforeach;?>                           
                        <?/*foreach ($this->lang_list as $key => $value):
                            if($this->setlang!=$value['d_code']){*/?>
							<!--
                            <li>
								<a href="javascript:void();" id="selectsortid" title="--><?/*=$value['d_title']?>"><i><?=$value['d_code']*/?><!--</i></a>
							</li>
                            <input type="hidden" name="selectsortid_fra" id="selectsortid_fra" value="--><?/*=$value['d_code']*/?><!--">
							-->
                        <?/*}
                        endforeach;*/?>
                    </ul>
                </div>
            </div>
            <div class="menu-box wow fadeInDown">
                <div class="container">
                    <nav class="site-nav">
                        <ul class="menu list-h">                            
                            <? foreach ($this->menu_link_list as $key => $value):?>
                                <?if($value['d_lang']=="products"){?>
                                    <li class="hover-on has-child">
										<a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?>
											<!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
										</a>
                                    <?/*=$this->mymodel->productsTypeMenu();*/?>
                                <?}else if($value['d_lang']=="news"){?>
                                    <li class="hover-on has-child"><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//好友分享券?>
                                        <?if (!empty($this->data['list_news'])){?>
											<!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                        <?}?>
                                    </a>
                                        <?php/* if(!empty($this->data['list_news'])): */?>
                                            <!--<ul>-->
                                                <?php/* foreach ($this->data['list_news'] as $key => $val): */?>
                                                    <!--<li><a href="/index/content/news/--><?/*=$val['id']*/?><!--">--><?/*=$val['name']*/?><!--</a></li>-->
                                                <?php/* endforeach; */?>
                                            <!--</ul>-->
                                        <?php/* endif; */?>
                                    </li>
                                <?}else if($value['d_lang']=="aesthetic"){?>
                                    <li class="hover-on has-child">
                                        <a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//友善連結?>
                                            <?php // if(!empty($this->data['list_aesthetic'])): ?>
                                                <!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                            <?php // endif; ?>
                                        </a>

                                        <?php // if(!empty($this->data['list_aesthetic'])): ?>
                                            <!--<ul>-->
                                                <?php // foreach ($this->data['list_aesthetic'] as $key => $val): ?>
                                                    <!--<li><a href="/index/content/aesthetic/--><?php //$val['id']?><!--">--><?php //$val['name']?><!--</a></li>-->
                                                <?php // endforeach; ?>
                                            <!--</ul>-->
                                        <?php // endif; ?>
                                    </li>
                                <?}else if($value['d_lang']=="movie"){?>
                                    <li class="hover-on has-child">
                                        <a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//影音專區?>
                                            <?php if(!empty($this->data['list_video'])): ?>
                                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        </a>
                                        <?php if(!empty($this->data['list_video'])): ?>
                                            <ul>
                                                <?php foreach ($this->data['list_video'] as $key => $val): ?>
                                                    <li><a href="/gold/media/C/video/<?=$val['id']?>"><?=$val['name']?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?}else if($value['d_lang']=="about"){?>
                                    <li class="hover-on has-child">
                                        <a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//關於我們?>
                                            <?php // if(!empty($this->mymodel->get_about_data($this->setlang))): ?>
                                                <!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                            <?php // endif; ?>
                                        </a>
                                        <!--<ul>-->
                                            <?php // if(!empty($this->mymodel->get_about_data($this->setlang))): ?>
                                                <?php // foreach ($this->mymodel->get_about_data($this->setlang) as $key => $val): ?>
                                                    <!--<li><a href="/index/about/--><?php //$val['did']?><!--">--><?php //$val['name']?><!--</a></li>-->
                                                <?php // endforeach; ?>
                                            <?php // endif; ?>
                                        <!--</ul>-->
                                    </li>
                                <?}else if($value['d_lang']=="album"){?>
                                    <li class="hover-on has-child">
                                        <a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//活動花絮?>
                                            <?php // if(!empty($this->data['list_photo_type'])): ?>
                                                <!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                            <?php // endif; ?>
                                        </a>
                                            <?php // if(!empty($this->data['list_photo_type'])): ?>
                                                <!--<ul>-->
                                                    <?php // foreach ($this->data['list_photo_type'] as $key => $val): ?>
                                                        <!--<li><a href="/index/photo/--><?php //$val['id']?><!--">--><?php //$val['name']?><!--</a></li>-->
                                                    <?php // endforeach; ?>
                                                <!--</ul>-->
                                            <?php // endif; ?>
                                    </li>
                                <?}else{//單獨一項?>
									<li class="hover-on has-child"><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a></li>
                                <?}?>
                            <?endforeach;?>
                        </ul>
                    </nav>
                </div>
            </div>
            <? if(!empty($memberName)){?>
                <div class="marquee wow fadeInDown" data-wow-delay="0.2s">
                    <div class="container"><?=$memberName;?>
                        <span><?=$this->lang_menu['cash_back'];//最高可賺取33%現金回饋。?><a href="/gold/member_register"><?=$this->lang_menu['understand_deeper'];//深入了解?></a></span>
                    </div>
                </div>
            <?}?>
        </header>
            <?=$banner;?>
            <main class="main-content wow fadeInUp" data-wow-delay="0.4s">
            <div>
            <div class="container">
                <? if(!empty($path_title)){?>
                    <ol class="breadcrumb list-inline">
                        <li><a href="/"><span><?=$this->lang_menu['home'];//首頁?></span></a></li><?=$path_title;?>
                    </ol>
                <?}?>
            </div>
            </div>
<script>
/*
$("#selectsortid").click(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $("#selectsortid_fra").val()
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
*/
$("#selectmenu").change(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $("#selectmenu").val()
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
</script>

<script src="/js/basic.js"></script>
<script src="/js/main.js"></script>
<style type="text/css">
    iframe {
        width:100%;
        margin:0 0 1em;
        border:0;
        height: 40em;
    }
    @media (max-width:667px) {      
        iframe {
            width:100%;
            margin:0 0 1em;
            border:0;
            height: 20em;
        }
    }
</style>