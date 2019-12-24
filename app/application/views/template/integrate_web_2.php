<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:08 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!-- /Added by HTTrack -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords" content='行動商務系統'>
    <meta name="description" content=''>
    <meta name="author" content=''>
    <meta name="copyright" content=''>
    <!--js-->
    <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="atmandcs/js/jquery.touchSlider.js"></script>
    <!--區塊滑動效果-->
    <script type="text/javascript" src="atmandcs/js/tabulous.js"></script>
    <!--css-->
    <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
    <!--主題css-->
    <!-- footer -->
    <link rel="stylesheet" href="<?=$base_url?>template/css/<?=$slider_css?>">
    <script type="text/javascript">
      //圖片縮圖
      $(window).load(function() {
        $("#content img").each(function(i) {
            $(this).removeAttr('width');
            $(this).removeAttr('height');

            //取得影像實際的長寬
            var imgW = $(this).width();

            var imgH = $(this).height();

            //計算縮放比例
            var w = ($(window).width() * 0.8) / imgW;
            var h = w;
            var pre = 1;
            if (w > h) {
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
    <style type="text/css">
        .link {
            max-width: 140px;
            max-height: 140px;
            border: 0;
        }
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
              background:url('<?=$bg_image_path?>') no-repeat center 0px;
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

<body class="bg_01" scroll="yes" style="overflow-x: hidden;overflow:-moz-scrollbars-vertical;overflow:scrollbars-vertical;">
    <div class="black-overlay"></div>
    <!--背景漸層-->
    <div id="tabs">
        <div id="tabs_container">
            <!--div tabs_container-->
            <!--最外圍table-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="35" align="center" class="topcolor1">
                        <!--標題顏色table-->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="40" align="center"></td>
                                <td align="center"><?=$header_title?>
                                    <div style="float: right;" class="header-right">
                                      <a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                                        <img class="share_btn" src="/images/apppic/sharebtn.png">
                                      </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="sharearea" class="sharearea" style="display:none;">
                          <table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id='share_btn_table'>
                          <tr>
                            <td>
                              <p>&nbsp;</p>
                              <p>將此內容分享至：</p>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0"  onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                                <tr>
                                  <td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('https://www.facebook.com/share.php?u=<?=$share_link?>'));">
                                        <img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title=<?=$header_title?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()">
                                        <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                                        <img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$header_title?> .concat('&#41;')));">
                                        <img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('https://twitter.com/home/?status=<?=$header_title?>' .concat(' ') <?=$share_link?>));">
                                        <img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="https://line.naver.jp/R/msg/text/?<?=$header_title?>%0D%0A<?=$share_link?>" rel="nofollow" >
                                        <img class='share' src="/images/share_btn/line_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="whatsapp://send?text=<?=$header_title?> <?=$share_link?>" data-action="share/whatsapp/share">
                                        <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="mailto:?subject=<?=$header_title?>&body=<?=$header_title?>網址：<?=$share_link?>">
                                        <img class='share' src="/images/share_btn/email_35x35.png" />
                                      </a>
                                    </td>   
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
                        </div>
                    </td>
                </tr>
            </table>
            <!--最外圍table-->
            <!--標題顏色table end-->
            <!--圖文編輯器起點-->
            <div id="content">
                <?=$content?>
            </div>
            <!--圖文編輯器終點-->
            <!-- website -->
        </div>
        <!--div tabs_container-->
    </div>
    <!--div tabs-->
</body>
</html>
