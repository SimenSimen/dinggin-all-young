<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> 行動商務系統</title>
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
  
  <!--PHOTO-->
        <link rel="stylesheet" type="text/css" href="/css/photo_demo.css" />
		<link rel="stylesheet" type="text/css" href="/css/photo_style.css" />
		<link rel="stylesheet" type="text/css" href="/css/photo_elastislide.css" />


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
			title		: '相簿分類'
		}
	});
});
</script>

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
		</script><!--相本動作-->
        
</head> 
<body scroll="yes" style="overflow-x: hidden;">
     
    <div id="header" class="Fixed">
            <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
               	<?=$photo_category['d_name']?>
                </div>
          	 <div class="header-right">
             	<a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
           <img src="/images/apppic/sharebtn.png"></a>
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
             <p>將此內容分享至：</p></td>
          </tr>
          <tr>
            <td> <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><!-- fb -->
                <a href="javascript: void(window.open('http://www.facebook.com/share.php?u=<?=$share_link?>'));"><img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" /></a>
            </td>
            <td align="center"><!-- weibo -->
                <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title=<?=$photo_category["d_name"]?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()"> <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" /></a>
            </td>
            <td align="center"><!-- googleplus -->
                <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" /></a>
            </td>
            <td align="center"><!-- plurk -->
                <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$photo_category["d_name"]?> .concat('&#41;')));"><img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" /></a>
            </td>
            <td align="center"><!-- twitter -->
                <a href="javascript: void(window.open('http://twitter.com/home/?status=<?=$photo_category['d_name']?>' .concat(' ') <?=$share_link?>));"><img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" /></a>
            </td>
            <td align="center"><!-- line -->
                <a href="http://line.naver.jp/R/msg/text/?<?=$photo_category['d_name']?>%0D%0A<?=$share_link?>" rel="nofollow" ><img class='share' src="/images/share_btn/line_35x35.png" /></a>
            </td>
            <td align="center">
              <a href="whatsapp://send?text=<?=$photo_category['d_name']?> <?=$share_link?>" data-action="share/whatsapp/share">
                <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
              </a>
            </td>
            <td align="center"><!-- Email -->
                <a href="mailto:?subject=<?=$photo_category['d_name']?>&body=<?=$photo_category['d_name']?>網址：<?=$share_link?>"><img class='share' src="/images/share_btn/email_35x35.png" /></a>
            </td>
        	</tr>
        </table>
        </td>
				 </tr>
		</table>
<div class="sharelocse"  style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
    <br /> close area
     </div>
</div>
                    <!--分享按鈕-->
                                            
          <div class="container">
			<div class="content">
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="35" align="center" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="40" align="center"><a href="#" onclick="history.go(-1)"><img class="backtag" src="/images/back.png" alt="back" /></a></td>
                        <td align="center"></td>
                      </tr>
                    </table></td>
                  </tr>
                  </table><br />
			  <div id="rg-gallery" class="rg-gallery">
					<div class=" ">
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
						</div>
						<!-- End Elastislide Carousel Thumbnail Viewer -->
					</div><!-- rg-thumbs -->
			  </div><!-- rg-gallery -->
              <div style="text-align: center;"><a onclick="history.back()" class="aa3">回上頁</a></div>
	  </div><!-- content -->
		</div><!-- container -->

       </div>     <!--index-bill-->
        

    
  <!--script內文縮圖-->
<script type="text/javascript">
    //圖片縮圖
    $(window).load(function(){
      $("img").each(function(i){
        if($(this).attr('class') == 'infoimg')
        {
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
        }
      });

    });
</script>
<!--分享按鈕圖層閉合-->
<script type="text/javascript" language="javascript">
    function showHide() {
        $('.sharearea').css('display', 'block');
    }
	function Hideshow() {
        $('.sharearea').css('display', 'none');
    }
</script>
<!--相本讀入-->
		<script type="text/javascript" src="/js/jquery.tmpl.min.js"></script>
		<script type="text/javascript" src="/js/jquery.elastislide.js"></script>
		<script type="text/javascript" src="/js/gallery.js"></script>
</body>

<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:32 GMT -->
</html>