<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable:no"/>

    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content='行動商務系統'>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>

    <!--js-->
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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

<body scroll="yes" style="overflow-x: hidden;overflow:-moz-scrollbars-vertical;overflow:scrollbars-vertical;">
    <div class="black-overlay"></div>
    <!--背景漸層-->
    <div id="tabs">
        <div id="tabs_container">
            <!--div tabs_container-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <!--頂端列設定處 class="topcolor1"footerstyle.css-->
                    <td height="35" align="center" class="topcolor1">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="40" align="center">
                                    <a href=javascript:onclick=history.go(-1)>
                                        <img class="backtag" src="<?=$base_url?>template/images/back.png" alt="back" /></a>
                                </td>
                                <td align="center">個人名片　　</td>
                                <td width="40" align="center">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="310" border="0" cellspacing="3" cellpadding="0">
                            <tr>
                                <td>
                                    <div class="h1title">
                                        <?=$iqr_name?>  <?php if(!empty($iqr['f_en_name']) || !empty($iqr['l_en_name'])): ?> / <?=$iqr['f_en_name']?> <?=$iqr['l_en_name']?><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php if(!empty($title)): ?>
                              <?php foreach ($title as $key => $value): ?>
                                <tr>
                                  <td><?=$value?></td>
                                </tr>
                              <?php endforeach; ?>
                            <?php endif ; ?>
                            <tr>
                                <td>
                                    <table width="97%" border="0" align="right" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <div class="user_text">
                                                    <?=$iqr['introduce']?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="text-align:center">
            <!-- mobile -->
            <?php if($mobile_show):?>
              <a class="aa04" id="icon09" onclick="location.href='tel:<?=$iqr['mobile']?>'"><?=$mobile_name?></a>
            <?php endif; ?>
            
            <?php if ($mobile_phones_num != 0): ?>
              <?php foreach ($mobile_phones as $key => $value): ?>
                <a class="aa04" id="icon09" onclick="location.href='tel:<?=$value?>'"><?=$mobile_phones_name[$key]?></a>
              <?php endforeach; ?>
            <?php endif; ?>

            <!-- cpn_phone -->
            <?php if ($cpn_phone_show): ?>
              <a class="aa04" id="icon08" onclick="location.href='tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>'"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <!-- cpn_number -->
            <?php if($cpn_number_show):?>
              <a class="aa04" id="icon01" onclick="alert('<?=$cpn_number_name?>：<?=$cpn_number?>');"><?=$cpn_number_name?></a>
            <?php endif; ?>
            
            <!-- email -->
            <?php if ($email_show): ?>
              <a class="aa04" id="icon06" onclick="location.href='mailto:<?=$iqr['email']?>'"><?=$email_name?></a>
            <?php endif; ?>
            
                <!-- line -->
            <?php if ($line_show): ?>
              <a class="aa04-line" onclick="location.href='<?=$line?>'"><?=$line_name?></a>
            <?php endif; ?>

            <!-- facebook -->
            <?php if ($facebook_show): ?>
              <a class="aa04-fb" onclick="location.href='<?=$facebook?>'"><?=$facebook_name?></a>
            <?php endif; ?>

            <!-- skype -->
            <?php if($skype_show):?>
              <a class="aa04-sky" onclick="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
            <?php endif; ?>

            <!-- cpn_phone -->
            <?php if ($cpn_cfax_show): ?>
              <a class="aa04" id="icon08" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>
            </div>
            <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center"><span style="color:#333">QR碼 分享</span>
                        <BR />
                        <?php if($web_btn['qrcode_btn']):?>
                        <a class="aa04-QR" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/0'"><?=$web_btn_name?></a> 
                      <?php endif; ?>

                      <?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
                        <a class="aa04-QR" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/1'"><?=$contact_btn_name?></a>
                      <?php endif; ?>
                      
                      <?php if ($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn']): ?>
                        <a class="aa04-QR" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/2'" ><?=$app_btn_name?></a>
                      <?php endif; ?>
                    </td>
                </tr>
            </table>
            <!--確保下方內容被看見-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="55" align="center">&nbsp;</td>
                </tr>
            </table>
            <!--確保下方內容被看見-->
        </div>
        <!--div tabs_container-->
    </div>
    <!--div tabs-->
        <!--script影片縮圖-->
        <script type="text/javascript">
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
        </script>
</body>

</html>
