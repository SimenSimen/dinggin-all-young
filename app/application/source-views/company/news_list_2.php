<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable:no">
    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content='行動商務系統'>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>
    <!--js-->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
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

<body style="overflow-x: hidden;">
    <?php $this -> load -> view('company/left_2', $data); ?>
    <div class="slideout-wrapper">
        <main id="panel" class="bg_01">
            <!--置中標題-->
            <header class="panel-header" id="header">資料庫
                <!--左側選單-->
                <button class="btn-hamburger js-slideout-toggle"></button>
            </header>
            <!--內容起始-->
            <div class="index-bill" style="position:relative;z-index:1;">
                <div class="black-overlay"></div>
                <!--黑影遮罩black-overlay-->
                <div class="spacefull">
                    <!--填滿表格高度-->
                    <table width="100%" id="table_knowledge" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="40" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table id="mocha" width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                                    <!--<tr onclick="location.href='info_c.html'">
                                        <td width="80" align="center"><img src="/template/images/info_picture_03.jpg" width="50" height="50" class="infoimg" /></td>
                                        <td>sylte cool現在正流行!
                                            <br /> 2015-06-11
                                        </td>
                                    </tr>-->
                                     <? if(!empty($data)){
                                         foreach($data as $val){?>
                                         <tr onclick="location.href='<? echo $url.$id.'/'.$val['html_id']?>'">
                                           <td colspan="2" valign="middle"><?=$val['html_name']?></td>
                                         </tr>
                                     <? }}?>
                                </table>
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
                <!--spacefull-->
            </div>
            <!--index-bill-->
    </div>
    <!--slideout-wrapper-->
    
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
        $(window).load(function() {
            $('.spacefull').css('height', ($(window).height() + 55));
            $('.black-overlay').css('height', ($('.slideout-wrapper').height() + 2000));
        });
        </script>
</body>

</html>
