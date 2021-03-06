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
			title		: '文章分類'
		}
	});
});
</script>
</head>
<script type="text/javascript">
	$(function(){
		// 幫 #qaContent 的 ul 子元素加上 .accordionPart
		// 接著再找出 li 中的第一個 div 子元素加上 .qa_title
		// 並幫其加上 hover 及 click 事件
		// 同時把兄弟元素加上 .qa_content 並隱藏起來
		$('#qaContent ul').addClass('accordionPart').find('li div:nth-child(1)').addClass('qa_title').hover(function(){
			$(this).addClass('qa_title_on');
		}, function(){
			$(this).removeClass('qa_title_on');
		}).click(function(){
			// 當點到標題時，若答案是隱藏時則顯示它，同時隱藏其它已經展開的項目
			// 反之則隱藏
			var $qa_content = $(this).next('div.qa_content');
			if(!$qa_content.is(':visible')){
				$('#qaContent ul li div.qa_content:visible').slideUp();
			}
			$qa_content.slideToggle();
		}).siblings().addClass('qa_content').hide();
	});
</script>

</head> 
<body scroll="yes" style="overflow-x: hidden;">
     
    <div id="header" class="Fixed">
            <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo" style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                影片 - <?=$film['str_name']?>
                </div>
          	 <div class="header-right"><a href="#" style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
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
                    <p>將此內容分享至：</p>
                  </td>
                </tr>
                <tr>
                  <td> <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
                	<tr>
                    <td align="center"><!-- fb -->
                        <a href="javascript: void(window.open('http://www.facebook.com/share.php?u=<?=$share_link?>'));"><img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" /></a>
                    </td>
                    <td align="center"><!-- weibo -->
                        <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title=<?=$film["str_name"]?>&url=<?=$share_link?>&source=bookmark','_blank','width=450,height=400');})()"> <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" /></a>
                    </td>
                    <td align="center"><!-- googleplus -->
                        <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$share_link?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" /></a>
                    </td>
                    <td align="center"><!-- plurk -->
                        <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=<?=$share_link?>' .concat(' ') .concat('&#40;') <?=$film["str_name"]?> .concat('&#41;')));"><img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" /></a>
                    </td>
                    <td align="center"><!-- twitter -->
                        <a href="javascript: void(window.open('http://twitter.com/home/?status=<?=$film['str_name']?>' .concat(' ') <?=$share_link?>));"><img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" /></a>
                    </td>
                    <td align="center"><!-- line -->
                        <a href="http://line.naver.jp/R/msg/text/?<?=$film['str_name']?>%0D%0A<?=$share_link?>" rel="nofollow" ><img class='share' src="/images/share_btn/line_35x35.png" /></a>
                    </td>
                    <td align="center">
                      <a href="whatsapp://send?text=<?=$film['str_name']?> <?=$share_link?>" data-action="share/whatsapp/share">
                        <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
                      </a>
                    </td>
                    <td align="center"><!-- Email -->
                        <a href="mailto:?subject=<?=$film['str_name']?>&body=<?=$film['str_name']?>網址：<?=$share_link?>"><img class='share' src="/images/share_btn/email_35x35.png" /></a>
                    </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>

                                       
                                           
               <div class="sharelocse" style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
              <br /> close area
               </div>
          </div>
         <!--分享按鈕-->
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="40" align="center" class="bg_01">&nbsp;</td>
           </tr>
           <tr>
             <td align="center"><br />
               <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><?=$film['str_name']?><br />
                   
                     <span class="text_70">@全聚網</span><br /></td>
                 </tr>
                 <tr>
                   <td colspan="2" align="center"><p>&nbsp;</p><br />
                     <p> <iframe width="320" src="https://www.youtube.com/embed/<?=$film['str']?>" frameborder="0" allowfullscreen></iframe>
                     <br />
                       <br />
                     </p></td>
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
             <td height="55" align="center" >&nbsp;</td>
           </tr>
           </table><!--確保下方內容被看見-->
       </div>
     <!--index-bill-->
        
    
      <!-- footer  -->
<div style="border:none;" data-role="footer">
  <div id="stickBottom" >
                   <ul class="itemFooter">
                     
                      <li><a rel="external" href="index_6.html" style="font-weight:inherit;"><i></i>關於我</a></li>
                     <li><a rel="external" href="info.html"><i></i>資訊</a></li>
                      <li><a rel="external" href="video.html"><i></i>影片</a></li>
                      <li><a rel="external" href="event.html"><i></i>活動</a></li>
                      <li><a rel="external" href="g.html"><i></i>照片</a></li>
                      <li><a rel="external" href="shop.html"><i></i>購物車</a></li>
                   </ul>
                    <div class="clear"></div>
  </div>
   	 </div>
     
    
  <!--script影片縮圖-->
<script type="text/javascript">
    //圖片縮圖
    $(function () {
      $("iframe").each(function(i){
          $(this).removeAttr('width');
          $(this).removeAttr('height');
     
          //取得影像實際的長寬
          var imgW = $(this).width();
          var imgH = $(this).height()+40;
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
<!--分享按鈕圖層閉合-->
<script type="text/javascript" language="javascript">
    function showHide() {
        $('.sharearea').css('display', 'block');
    }
	function Hideshow() {
        $('.sharearea').css('display', 'none');
    }
</script>
</body>

<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:32 GMT -->
</html>