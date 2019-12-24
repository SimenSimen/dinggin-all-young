<!DOCTYPE html>
<html lang="zh-Hant" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="images/app_icon/favicon.ico" type="image/x-icon" />
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
<meta name="msapplication-square70x70logo" content="images/app_icon/smalltile.png" />
<meta name="msapplication-square150x150logo" content="images/app_icon/mediumtile.png" />
<meta name="msapplication-wide310x150logo" content="images/app_icon/widetile.png" />
<meta name="msapplication-square310x310logo" content="images/app_icon/largetile.png" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/normalize.css">
<link rel="stylesheet" type="text/css" href="/css/icon-font/style.css">
<link rel="stylesheet" type="text/css" href="/js/jquery.bxslider/jquery.bxslider.min.css">
<link rel="stylesheet" type="text/css" href="/js/WOW/css/libs/animate.css">
<link rel="stylesheet" href="/js/slick/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/css/basic.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">
<script src="/js/jquery.min.js"></script>
<script src="/js/modernizr.js"></script>
<script src="/js/bootstrap.min.js"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="/js/fancyBox/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="/js/fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/js/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="/js/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
</head>
<body>
<div class="lightbox-wrapper">
    <form onsubmit="return check()">
    <h1>取消訂單</h1>
    提醒您，提交退貨申請，我們將於次日起1個工作天內審核，通過審核後即以E-mail回覆通知
        <div class="form-group">
            <label class="control-label required">取消原因</label>
           <div class="control-box">
                <textarea name="back_note" id="back_note" class="form-control" rows="7"></textarea>
            </div>
        </div>        
        <input type='hidden' name='order_id' id='order_id' value='<?=$id?>'>
        <input class="form-control" type="hidden" name="back_name" id="back_name" value="<?=$name?>">
        <button type="button" class="btn normal send">送出</button>
    </form>
</div>
</body>
</html>
<script>
$(function() {
        $(".send").click(function(){   
        var f = document.forms[0];          
        /*if (f.back_name.value=='') {
            alert("姓名不能空白");  
            f.back_name.focus();  
            return false;  
        }*/
        var order_id=$("#order_id").val();
        var back_name=$("#back_name").val();           
        var back_note =$("#back_note").val();         
        $.ajax({
            url:"/order/ajax_cancel",
            method:"POST",
            data:{
                order_id:order_id,
                back_name:back_name,
                back_note:back_note
            },
            success:function(){  
                window.parent.location.reload();
            }
            })//end ajax 
        });
    });
</script>