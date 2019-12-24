<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable:no"/>

    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content='行動商務系統'/>
    <meta name="description"  content=''/>
    <meta name="author"       content=''/>
    <meta name="copyright"    content=''/>

    <!--js-->
    <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="<?=$base_url?>template/js/jquery.touchSlider.js"></script>

    <!--區塊滑動效果-->
    <script type="text/javascript" src="<?=$base_url?>template/js/tabulous.js"></script>
    <!--主題css-->
    <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
    <!-- footer -->
    <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/<?=$slider_css?>">
    <!-- user style -->
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
            body
            {
              background-color:<?=$bg_color?>;
            }
        <?php elseif($bg_image_path != ''): ?>
            /* 背景圖 */
            body
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
    <!--區塊滑動，動作-->
    <script>
    $(document).ready(function($) {
        $("#tabs").tabs();
        $("#tabs").tabulous({
            effect: 'slideLeft'
        });
    });
    </script>
    <!--區塊滑動，動作-->
</head>

<body scroll="yes" style="overflow-x: hidden;overflow:-moz-scrollbars-vertical;overflow:scrollbars-vertical;">
    <div class="black-overlay"></div>
    <div id="tabs">
        <div id="tabs_container">
            <div class='tabs' id="tabs-1">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" height="180">
                            <br />
                            <?=$logo_img?>=test=
                            <?php if(!empty($logo_path)):?>
                                <img src="<?=$logo_path?>" width="95%" class="tableimg" align="middle" />
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

            </div>
            <!--tabs-1-->
            <!--分享-->
            <?php if ($exfile_show): ?>
            <div class='tabs' id="tabs-2">
                <!--tabs-2-->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="35" align="center" class="topcolor1"> 入會申請 </td>
                    </tr>
                    <tr>
                        <td align="center" height="180">
                            <?php if ($exfile_show): ?>
                                <?php foreach ($doc_path as $key => $value): ?>
                                    <a class="aa04" id="icon13" onclick="location.href='<?=$base_url?><?=substr($value, 1)?>'"> <?=$doc_name[$key]?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
            <!--tabs-2-->
            <!--分享-->
            <!--相本-->
            <!--tabs-3-->
            <?php if ($photo_show):?>
            <div class='tabs' id="tabs-3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1">點圖進入相本</td>
                    </tr>
                    <?php foreach ($photo_category as $key => $value): ?>
                    <?php if($value['show']): ?>
                    <tr>
                        <td align="center" height="30">
                            <p class="name"><?=$d_name?></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="180">
                            <a href onclick="location.href='<?=$base_url?>business/photo/<?=$account?>/<?=$value['d_id']?>"><img src="<?=$value['L_image']?>" width="300" /></a>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            <!--tabs-3-->
            <!--表單-->
            <!--tabs-4-->
            <?php if ($uform_show): ?>
            <div class='tabs' id="tabs-4">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1">會員專區</td>
                    </tr>
                    <tr>
                        <td height="250" valign="top">
                            <?php if ($uform_show): ?>
                                <?php foreach ($ufm_id as $key => $value): ?>
                                    <a class="aa00" id="icon14" href="#" onclick="location.href='<?=$base_url?>form/index/<?=$value?>/<?=$mid?>'"><?=$ufm_btn_name[$key]?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
            <!--表單-->
            <!--tabs-4-->
            <!--影片-->
            <!--tabs-5-->
            <?php if ($ytb_link_num != 0): ?>
            <div class='tabs' id="tabs-5">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php foreach ($ytb_link as $key => $value): ?>
                        <tr>
                            <td align="center">
                                <iframe width="320" height="220" src="https://www.youtube.com/embed/<?=$value?>" frameborder="0" allowfullscreen></iframe>
                                <br />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            <!--影片-->
            <!--tabs-5-->
            <!--網站-->
            <!--tabs-6-->
            <?php if ($website_num != 0): ?>
            <div class='tabs' id="tabs-6">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 於footerstyle.css-->
                        <td height="35" align="center" class="topcolor1">網站</td>
                    </tr>
                    <tr>
                        <td valign="top" height="180">
                            <center>
                                <?php foreach ($website as $key => $value): ?>
                                    <a class="aa00" id="icon14" onclick="location.href='<?=$value?>'"><?=$website_name[$key]?></a>
                                <?php endforeach; ?>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
            <!--網站-->
            <!--tabs-6-->
            <!--分類-->
            <!--tabs-7-->
            <?php if(!empty($iqr_html_page)):?>
            <div class='tabs' id="tabs-7">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 於footerstyle.css-->
                        <td height="35" align="center" class="topcolor1">生活分享</td>
                    </tr>
                    <tr>
                        <td height="180" valign="top">
                            <center>
                                <?php foreach ($iqr_html_page as $key => $value): ?>
                                    <a class="aa00" id="icon14" onclick="location.href='<?=$base_url?>business/html_web/<?=$value['html_id']?>'"><?=$value['html_name']?></a>
                                <?php endforeach; ?>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
            <!--分類-->
            <!--tabs-7-->
            <!--tabs 8-->
            <!--好友分享券-->
            <?php if($ecp_show): ?>
            <div class='tabs' id="tabs-8">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php foreach ($ecp_url as $key => $value): ?>
                            <tr>
                                <td height="35" align="center" class="topcolor1"></td>
                            </tr>
                            <tr>
                                <td height="180" valign="top">
                                   <img src="<?=$ecp_img[$key]?>" alt="man" class="tableimg" align="middle" width="95%"><br />
                                   <span><?=$ecp_content[$key]?></span>
                                   <!-- <a class="goob" href="javascript:void(0);" style="margin:5px auto;padding:3px;line-height:20px;height:26px" onclick="location.href='<?=$ecp_url[$key]?>'"><?=$ecp_btn_name[$key]?></a> -->
                                   <a class="goob" href="jecp://<?=$jecp[$key]?>" onclick="getShareEncode(this)" style="margin:5px auto;padding:3px;line-height:20px;height:26px"><?=$ecp_btn_name[$key]?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            </div>

            
            <?php endif; ?>
            <!--End-->
            <!--tabs 8-->
        </div>
        <!--End tabs container-->
        <center>
            <ul>
                <!--首頁按鈕已改為文字+css-->
                <a class="aa00" id="icon01" href="#tabs-1" onclick="location.href='<?=$base_url?>business/about/<?=$account?>'">個人資訊</a>
                <?php if ($exfile_show): ?>
                    <a class="aa00" id="icon02" href="#tabs-2">入會申請</a>
                <?php endif; ?>
                <?php if ($website_num != 0): ?>
                    <a class="aa00" id="icon03" href="#tabs-6">網絡聯結</a>
                <?php endif; ?>
                <?php if ($ytb_link_num != 0): ?>
                    <a class="aa00" id="icon04" href="#tabs-5">影片介紹</a>
                <?php endif; ?>
                <?php if (!empty($iqr_html_page)): ?>
                    <a class="aa00" id="icon05" href="#tabs-7">生活分享</a>
                <?php endif; ?>
                <?php if ($uform_show): ?>
                    <a class="aa00" id="icon06" href="#tabs-4">報名表單</a>
                <?php endif; ?>
                <?php if($ecp_show): ?>
                    <a class="aa00" id="icon07" href="#tabs-8">好康分享</a> 
                <?php endif; ?>
            </ul>
        </center>
        <!--確保下方內容被看見-->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="55" align="center">&nbsp;</td>
            </tr>
        </table>
        <!--確保下方內容被看見-->
    </div>
    <script>
        //圖片縮圖
        $(window).load(function() {
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

        function getShareEncode(obj){
            var val   = obj.getAttribute('href');
            var i_val = "jecp://"+obj.getAttribute('href').substr(12);
            if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
                location.href = i_val;
            } else if (/(Android)/i.test(navigator.userAgent)) {
                NetNewsAndroidShare.receiveValueFromJs(val);
            } else {
            };
        }
    </script>
</body>
</html>