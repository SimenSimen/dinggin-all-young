<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords" content='行動商務系統'>
    <meta name="description" content=''>
    <meta name="author" content=''>
    <meta name="copyright" content=''>
    <!--js-->
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="<?=$base_url?>template/js/jquery.touchSlider.js"></script>
    <!--區塊滑動效果-->
    <script type="text/javascript" src="<?=$base_url?>template/js/tabulous.js"></script>
    <!--css-->
    <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
    <!--主題css-->
    <!-- footer -->
    <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/<?=$slider_css?>">
    
    <script type="text/javascript">
      //圖片縮圖
      $(window).load(function() {
        $("img").each(function(i) {
            if($(this).attr('class') != 'share_btn')
            {
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
            }
        });
      });
    </script>
    <style>
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

<body class="bg_01" scroll="yes" style="overflow-x: hidden;">
    <div id="tabs">
        <div id="tabs_container" >
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
                                    <div style="float: right;width:25px;" class="header-right">
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
                                      <a href="javascript: void(window.open('http://www.facebook.com/share.php?u=<?=$share_link?>'));">
                                        <img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title=<?=$header_title?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()">
                                        <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                                        <img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$header_title?> .concat('&#41;')));">
                                        <img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript: void(window.open('http://twitter.com/home/?status=<?=$header_title?>' .concat(' ') <?=$share_link?>));">
                                        <img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="http://line.naver.jp/R/msg/text/?<?=$header_title?>%0D%0A<?=$share_link?>" rel="nofollow" >
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
                    <!--標題顏色table end-->
                    </td>
                </tr>
                <tr>
                    <td aligh="center">
                        <!--最外圍第二列td-->
                        <!--中央table-->
                        <table width="90%" border="0" cellspacing="3" cellpadding="0">
                            <tr>
                                <td colspan="2">
                                    <?=$content?>
                                </td>
                            </tr>
                        </table>
                        <!--最外圍第二列td-->
                    </td>
                </tr>
            </table>
            <!--中央table-->
            </td>
            </tr>
            </table>
            <!--最外圍table-->
            <!-- website -->
        </div>
        <!--div tabs_container-->
    </div>
    <!--div tabs-->
</body>
</html>

