<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template3_seo', $data); ?>
        <link type="text/css" rel="stylesheet" href="/template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="/template/temp3/css/layout.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="/template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
	
		
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="/template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
 
        
        <!------分享 彈出窗------>
       <link rel="stylesheet" href="/template/temp3/css/baze.modal.css">
       

		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
			    <div ref="<?=$public_share_buttom_url?>" id="head_share_buttom" style="position:absolute;top:0;right:0;margin:.3rem 1rem 0 0"><span class="finger_point"><img src="<?=$base_url?>template/temp3/images/share_btn.png"></span></div>
				<a href="#menu"></a>
				關於我 / 好友分享券
			</header>
			
            
			<?php $this -> load -> view('template/public_share', $data); ?>
			<?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
             <div class="wrapper">                  

                   
                   <section class="content">
                        <h2 class="content-title"><?=$my_e_coupon['name']?></h2>
                                  
                        <div class="word-area">   
                           <img src="<?=$ecp_Ppath?>">
                        </div>   
                        
                     <!------------分享------------->
                        <div class="btn-share">
                          <a href="javascript:avoid(0)" onclick="gobarcodeurl()">收藏</a>
                        </div>
    <script language="javascript">
    function gobarcodeurl(){
//		alert('<?=$public_barcodeurl?>');
		location ='<?=$public_barcodeurl?>';
     }
    </script>
						
						
<!--						
                        <div class="bzm-content" id="modal2" data-title="分享到">   
                            <ul class="share-box">
							        <!-- fb --><!--
                              <li><a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"><i><img src="/template/temp3/images/icon-fb.png" align="center" ></i>facebook</a></li>
                              <li><a href="https://line.naver.jp/R/msg/text/?<?=$iqr_name?>行動商務系統 <?=$iqr_url?>"><i><img src="/template/temp3/images/icon-line.png" align="center" ></i>LINE</a></li>
                              <li><a href="https://www.jiathis.com/share"><i><img src="/template/temp3/images/icon-wechat.png" align="center"></i>WeChat</a></li>
                            </ul>
                        </div>
-->						
                                                  
                   </section>
                   
           </div><!--/wrapper-->
    
                 

				 
<!------分享彈出窗 JS------>
<script src="/template/temp3/js/baze.modal.js"></script> 
<script>
	var elems = $('[data-baze-modal]');
	elems.bazeModal({
		onOpen: function () {
			alert('opened');
		},
		onClose: function () {
			alert('closed');
		}
	});

	$('#ngehe').bazeModal();
</script>
                 
    
	   </div><!--/page-->
  </body>
</html>