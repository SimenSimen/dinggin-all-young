<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <!-- seo -->
    <!--js-->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

    <!--PHOTO-->
    <link rel="stylesheet" type="text/css" href="/template/css/photo_demo.css" />
    <link rel="stylesheet" type="text/css" href="/template/css/photo_style.css" />
    <link rel="stylesheet" type="text/css" href="/template/css/photo_elastislide.css" />
    <!--新側欄選單-->
    <link rel="stylesheet" href="/js/assets/test.css">
    <link rel="stylesheet" href="/js/assets/index.css">
    <!--css-->
    <link rel="stylesheet" href="/template/css/area_style.css">
    <!--主題css-->
    <link rel="stylesheet" href="/template/css/integrate/<?=$theme_css?>">
    <!-- footer -->
    <link type="text/css" rel="stylesheet" href="/template/css/<?=$slider_css?>">
    <!--相本動作-->
    <script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">
        <div class="rg-image-wrapper">
            {{if itemsCount > 1}}
            <div class="rg-image-nav">
                <a href="#" class="rg-image-nav-prev">Previous Image</a>
                <a href="#" class="rg-image-nav-next">Next Image</a>
            </div>
            {{/if}}
            <div class="rg-image"></div>
            <div class="rg-loading"></div>
            <div class="rg-caption-wrapper">
                <div class="rg-caption" style="display:none;">
                    <p></p>
                </div>
            </div>
        </div>
    </script>
    <style type="text/css">
        /* font color */
        .user_text
        {
          color:<?=$font_color?>;
          font-size:<?=$font_size?>px;
          font-family:"<?=$font_family?>";
        }
		.aa3{
		border: none;
		margin:20px 5px;
		display:inline-block;
		padding:5px 15px;
		/*letter-spacing:0.2em;*/
		font-size:.9rem;	
		background:#666;
		color:#FFF;
		border-radius:3px;
		text-align:center;
		font-family: '微軟正黑體';
		}
        <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
          .bg_01
          {
            background-color:<?=$bg_color?>;
          }
        <?php elseif($bg_image_path != ''): ?>
          /* 背景圖 */
          .bg_01
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

<body scroll="yes" style="overflow-x: hidden;" class="topcolor1">
    <!-- left -->
    <?php $this -> load -> view('company/left_2', $data); ?>
    <div class="slideout-wrapper">
        <main id="panel" class="bg_01">
            <header class="panel-header" id="header"> <?=$photo_category['d_name']?>
                <button class="btn-hamburger js-slideout-toggle"></button>
                <div class="header-right">
                    <a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                        <img src="/template/images/apppic/sharebtn.png"></a>
                </div>
            </header>
            <!--內容起始-->
            <div class="index-bill" style="position:relative;z-index:1;">
                <!--分享按鈕 footerstyle.css-->
                <div id="sharearea" class="sharearea" style="display:none;">
                    <table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id='share_btn_table'>
                        <tr>
                            <td>
                                <p>&nbsp;</p>
                                <p><?=$ShareContent?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                                    <tr>
                                        <td align="center"><!-- fb -->
                                            <a href="javascript: void(window.open('https://www.facebook.com/share.php?u=<?=$share_link?>'));"><img class='share' id='fb' title="<?=$ShareFacebook?>" src="/images/share_btn/facebook_35x35.png" /></a>
                                        </td>
                                        <td align="center"><!-- weibo -->
                                            <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title=<?=$photo_category["d_name"]?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()"> <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="<?=$ShareWeibo?>" /></a>
                                        </td>
                                        <td align="center"><!-- googleplus -->
                                            <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><img class='share' id='google' title="<?=$ShareGoogle?>" src="/images/share_btn/googleplus_35x35.png" /></a>
                                        </td>
                                        <td align="center"><!-- plurk -->
                                            <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$photo_category["d_name"]?> .concat('&#41;')));"><img class='share' id='plurk' title="<?=$SharePlurk?>" src="/images/share_btn/plurk_35x35.png" /></a>
                                        </td>
                                        <td align="center"><!-- twitter -->
                                            <a href="javascript: void(window.open('https://twitter.com/home/?status=<?=$photo_category['d_name']?>' .concat(' ') <?=$share_link?>));"><img class='share' id='twitter' title="<?=$ShareTwitter?>" src="/images/share_btn/twitter_35x35.png" /></a>
                                        </td>
                                        <td align="center"><!-- line -->
                                            <a href="https://line.naver.jp/R/msg/text/?<?=$photo_category['d_name']?>%0D%0A<?=$share_link?>" rel="nofollow" ><img class='share' src="/images/share_btn/line_35x35.png" /></a>
                                        </td>
                                        <td align="center">
                                          <a href="whatsapp://send?text=<?=$photo_category['d_name']?> <?=$share_link?>" data-action="share/whatsapp/share">
                                            <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
                                          </a>
                                        </td>
                                        <td align="center"><!-- Email -->
                                            <a href="mailto:?subject=<?=$photo_category['d_name']?>&body=<?=$photo_category['d_name']?><?=$Site?><?=$share_link?>"><img class='share' src="/images/share_btn/email_35x35.png" /></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!--關閉分享區塊-->
                    <div class="sharelocse" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                        <br /> close area
                    </div>
                    <!--關閉分享區塊-->
                </div>
                <!--分享按鈕-->
                <div class="black-overlay"></div>
                <!--黑影遮罩black-overlay-->
                <!--內容起始-->
                <div class="index-bill" style="position:relative;z-index:1;">
                    <div class="spacefull">
                        <!--填滿表格高度-->
                        <!--正文-->
                        <div class="container">
                            <div class="content">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="35" align="center">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="40" align="center">
                                                        <a href="#" onclick="history.go(-1)"><img class="backtag" src="/template/images/back.png" alt="back" /></a>
                                                    </td>
                                                    <td align="center">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <!--相本開始-->
                                <div id="rg-gallery" class="rg-gallery">
                                    <div class="rg-thumbs">
                                        <!-- Elastislide Carousel Thumbnail Viewer -->
                                        <div class="es-carousel-wrapper">
                                            <div class="es-nav">
                                                <span class="es-nav-prev">Previous</span>
                                                <span class="es-nav-next">Next</span>
                                            </div>
                                            <div class="es-carousel">
                                                <ul>
                                                    <? if(!empty($myphoto)){ 
                                                           foreach($myphoto as $key => $val){ ?>
                                                        <li><a href="#"><img src="<?=$val?>" data-large="<?=$val?>" alt="image<?=$key?>" data-description="<?=($myphoto_name[$key]!='')?$myphoto_name[$key]:' ';?>" /></a></li>
                                                    <? }}?>
                                                </ul>
                                            </div>
                                            <!--es-carousel-->
                                        </div>
                                        <!-- End Elastislide Carousel Thumbnail Viewer -->
                                    </div>
                                    <!-- rg-thumbs -->
                                </div>
                                <!-- rg-gallery -->
                                    <div style="text-align: center;"><a onclick="history.back()" class="aa3"><?=$Return_page?></a></div>
                                    <div style="height: 70px;"></div>
                            </div>
                            <!--spacefull-->
                        </div>
                        <!-- content -->
                    </div>
                    <!-- container -->
                    <!--確保下方內容被看見-->
                    <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="55" align="center">&nbsp;</td>
                        </tr>
                    </table>  -->
                    <!--確保下方內容被看見-->
                </div>
                <!--spacefull-->
            </div>
            <!--index-bill-->
    </div>
    <!--slideout-wrapper-->
    </div>
    <!-- footer  -->
   
        <!--側欄選單動作-->
    <script>
        mocha.setup('bdd');
        var exports = null;

        function assert(expr, msg) {
            if (!expr) throw new Error(msg || 'failed');
        }
    </script>
    <script src="/js/assets/slideout.js"></script>
    <script src="/js/assets/test.js"></script>
    <script>
        window.onload = function() {
            document.querySelector('.js-slideout-toggle').addEventListener('click', function() {
                slideout.toggle();
            });

            document.querySelector('.menu').addEventListener('click', function(eve) {
                if (eve.target.nodeName === 'A') {
                    slideout.close();
                }
            });

            var runner = mocha.run();
        };
    </script>
    <script type="text/javascript">
        //填滿表格高度定位
        $(window).load(function() {
            $('.spacefull').css('height', ($(window).height() + 55));
            $('.black-overlay').css('height', ($('.slideout-wrapper').height() + 2000));
        });
    </script>
        <!--script內文縮圖-->
    <script type="text/javascript">
        //圖片縮圖
        $(window).load(function() {
            $("img").each(function(i) {
                if ($(this).attr('class') == 'infoimg') {
                    $(this).removeAttr('width');
                    $(this).removeAttr('height');

                    //取得影像實際的長寬
                    var imgW = $(this).width();
                    var imgH = $(this).height();

                    //計算縮放比例
                    var w = ($(window).width() * 90 / 100) / imgW;
                    var h = w;
                    var pre = 1;
                    if (w > pre) {
                        pre = h;
                    } else {
                        pre = w;
                    }
                    //設定目前的縮放比例
                    $(this).width(imgW * pre);
                    $(this).height(imgH * pre);
                }
            });

        });
    </script>
    <!--相本讀入-->
    <script type="text/javascript" src="/template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="/template/js/jquery.elastislide.js"></script>
    <script type="text/javascript" src="/template/js/gallery.js"></script>
</body>
</html>
