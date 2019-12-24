<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> <?=$BusinessSystem?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='行動商務系統'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  <!--js-->
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="/js/jquery.touchSlider.js"></script>
  
  <!--側欄選單效果-->
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.min.all.js"></script> 
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.fixedelements.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/menuA.css" />
<link type="text/css" rel="stylesheet" href="/js/jqmeun/jquery.mmenu.css" />

  <!--css-->
  <link rel="stylesheet" href="/css/style_area.css">
  
  <!--主題css-->

 <!-- footer -->
    <link type="text/css" rel="stylesheet" href="/css/footerStyle.css">

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
<script type="text/javascript">
$(function() {
	$('nav#menu').mmenu({
		extensions	: [ 'effect-slide-menu', 'pageshadow' ],
		navbar 		: {
			title		: '<?=$ArticleCategory?>'
		}
	});
});
</script>
</head>

<body scroll="yes" style="overflow-x: hidden;">
     
    <div id="header" class="Fixed">
	       <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo">
                <?=$CompanyArticle?>
                </div>
          	<div class="header-right">
              <a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                <img class="share_btn" src="/images/apppic/sharebtn.png">
              </a>
      		  </div>       
		</div><!--header-->
      <?php $this -> load -> view('company/left_1', $data); ?>
   		<div class="index-bill"><!--內容開始-->
         <!--分享按鈕 footerstyle.css-->
        <div id="sharearea" class="sharearea" style="display:none;">
          <table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id='share_btn_table'>
          <tr>
            <td>
              <p>&nbsp;</p>
              <p><?=$ShareContentTo?></p>
            </td>
          </tr>
          <tr>
            <td>
              <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0"  onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                <tr>
                  <td>
                    <td align="center">
                      <a href="javascript: void(window.open('http://www.facebook.com/share.php?u=<?=$share_link?>'));">
                        <img class='share' id='fb' title="<?=$ShareFacebook?>" src="/images/share_btn/facebook_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title=<?=$web_config["title"]?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()">
                        <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="<?=$ShareWebio?>" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                        <img class='share' id='google' title="<?=$ShareGoogle?>" src="/images/share_btn/googleplus_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$web_config["title"]?> .concat('&#41;')));">
                        <img class='share' id='plurk' title="<?=$SharePlurk?>" src="/images/share_btn/plurk_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="javascript: void(window.open('http://twitter.com/home/?status=<?=$web_config['title']?>' .concat(' ') <?=$share_link?>));">
                        <img class='share' id='twitter' title="<?=$ShareTwitter?>" src="/images/share_btn/twitter_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="http://line.naver.jp/R/msg/text/?<?=$info['html_name']?>%0D%0A<?=$share_link?>" rel="nofollow" >
                        <img class='share' src="/images/share_btn/line_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="whatsapp://send?text=<?=$info['html_name']?> <?=$share_link?>" data-action="share/whatsapp/share">
                        <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
                      </a>
                    </td>
                    <td align="center">
                      <a href="mailto:?subject=<?=$info['html_name']?>&body=<?=$info['html_name']?><?=$TheURL?><?=$share_link?>">
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
                                           
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="50" align="center">&nbsp;</td>
           </tr>
           <tr>
             <td align="center"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><?=$info['html_name']?></td>
                   <!--<td width="120" align="right" valign="bottom" class="text_70">2015-06-11</td>-->
                 </tr>
                 <tr>
                 <td>
                 <?=$info['html_content']?>
                 </td>
                 </tr>
             </table>
             </td>
           </tr>
             <tr>
               <td >&nbsp;
               </td>
                   </tr>
         </table>
     <!--確保下方內容被看見-->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="55" align="center">&nbsp;</td>
           </tr>
           </table><!--確保下方內容被看見-->
       </div>
     <!--index-bill-->
        
    
  
  <!--script內文縮圖-->
<script type="text/javascript">
    //圖片縮圖
    $(function () {
      $("table img").each(function(i){
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var imgW = $(this).width();
        var imgH = $(this).height();
   
        //計算縮放比例
        var w=($(window).width()*90/100)/imgW;
        var h=w;
        var pre=1;
        if(w>pre){
          pre=h;
        }else{
          pre=w;
        }
        //設定目前的縮放比例
        $(this).width(imgW*pre);
        $(this).height(imgH*pre);
      });
    });
</script>
</body>
</html>