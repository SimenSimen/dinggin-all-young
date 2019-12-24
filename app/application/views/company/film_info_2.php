<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable:no"/>
    <!-- seo -->
    <title><?=$iqr_name?> <?=$BusinessSystem?></title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content='<?=$BusinessSystem?>'>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>
    <!--js-->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <!--新側欄選單-->
    <link rel="stylesheet" href="/js/assets/test.css">
    <link rel="stylesheet" href="/js/assets/index.css">
    <!--css-->
    <link rel="stylesheet" href="/template/css/area_style.css">
    <!--主題css-->
    <link rel="stylesheet" href="/template/css/integrate/<?=$theme_css?>">
    <!-- footer -->
    <link type="text/css" rel="stylesheet" href="/template/css/<?=$slider_css?>">
    <style type="text/css">
        /* font color */
        .user_text
        {
          color:<?=$font_color?>;
          font-size:<?=$font_size?>px;
          font-family:"<?=$font_family?>";
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
    <div class="slideout-wrapper">
        <main id="panel" class="bg_01">
            <header class="panel-header" id="header">
                <?=$Film?> - <?=$film['str_name']?>
                <button class="btn-hamburger js-slideout-toggle"></button>
                <!--右側分享鈕-->
                <div class="header-right">
                    <a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                        <img src="/template/images/apppic/sharebtn.png"></a>
                </div>
            </header>
            <?php $this -> load -> view('company/left_2', $data); ?>
            <!--內容起始-->
            <div class="index-bill" style="position:relative;z-index:1;">
                <div class="black-overlay"></div>
                <!--black-overlay-->
                <div class="spacefull">
                    <!--填滿表格高度-->
                    <!--分享按鈕 footerstyle.css-->
                    <div id="sharearea" class="sharearea" style="display:none;">
                        <table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id='share_btn_table'>
                            <tr>
                                <td>
                                    <p>&nbsp;</p>
                                    <p>
                                        <?=$ShareTo?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center">
                                                <!-- fb -->
                                                <a href="javascript: void(window.open('https://www.facebook.com/share.php?u=<?=$share_link?>'));"><img class='share' id='fb' title="<?=$ShareFacebook?>" src="/images/share_btn/facebook_35x35.png" /></a>
                                            </td>
                                            <td align="center">
                                                <!-- weibo -->
                                                <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title=<?=$film[" str_name "]?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()"> <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="<?=$ShareWebio?>" /></a>
                                            </td>
                                            <td align="center">
                                                <!-- googleplus -->
                                                <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><img class='share' id='google' title="<?=$ShareGoogle?>" src="/images/share_btn/googleplus_35x35.png" /></a>
                                            </td>
                                            <td align="center">
                                                <!-- plurk -->
                                                <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$film[" str_name "]?> .concat('&#41;')));"><img class='share' id='plurk' title="<?=$SharePlurk?>" src="/images/share_btn/plurk_35x35.png" /></a>
                                            </td>
                                            <td align="center">
                                                <!-- twitter -->
                                                <a href="javascript: void(window.open('https://twitter.com/home/?status=<?=$film['str_name']?>' .concat(' ') <?=$share_link?>));"><img class='share' id='twitter' title="<?=$ShareTwitter?>" src="/images/share_btn/twitter_35x35.png" /></a>
                                            </td>
                                            <td align="center">
                                                <!-- line -->
                                                <a href="https://line.naver.jp/R/msg/text/?<?=$film['str_name']?>%0D%0A<?=$share_link?>" rel="nofollow"><img class='share' src="/images/share_btn/line_35x35.png" /></a>
                                            </td>
                                            <td align="center">
                                                <a href="whatsapp://send?text=<?=$film['str_name']?> <?=$share_link?>" data-action="share/whatsapp/share">
                                                    <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
                                                </a>
                                            </td>
                                            <td align="center">
                                                <!-- Email -->
                                                <a href="mailto:?subject=<?=$film['str_name']?>&body=<?=$film['str_name']?><?=$TheURL?><?=$share_link?>"><img class='share' src="/images/share_btn/email_35x35.png" /></a>
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
                    <!--正文-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="40" align="center" class="bg_01">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center">
                                <br />
                                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><?=$film['str_name']?>
                                            <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <p>&nbsp;</p>
                                            <br />
                                            <p>
                                                <iframe width="320" src="https://www.youtube.com/embed/<?=$film['str']?>" frameborder="0" allowfullscreen></iframe>
                                                <br />
                                                <br />
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
                <!--spacefull-->
            </div>
            <!--black-overlay-->
    </div>
    <!--index-bill-->
    </div>
    <!--slideout-wrapper-->
    <!-- footer -->
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
        <!--script-->
    <script type="text/javascript">
        //填滿表格高度定位
        $(function () {
            $('.spacefull').css('height', ($(window).height() + 55));
            $('.black-overlay').css('height', ($('.slideout-wrapper').height() + 2000));
        });
    </script>
        <!--script影片縮圖-->
    <script type="text/javascript">
        //圖片縮圖
        $(function () {
            $("iframe").each(function(i) {
                $(this).removeAttr('width');
                $(this).removeAttr('height');

                //取得影像實際的長寬
                var imgW = $(this).width();
                var imgH = $(this).height() + 40;
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
            });

        });
    </script>
</body>
</html>
