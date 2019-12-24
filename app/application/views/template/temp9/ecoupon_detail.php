<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template4_seo', $data); ?>
        <link type="text/css" rel="stylesheet" href="css/header.css" />
		<link type="text/css" rel="stylesheet" href="css/layout.css" />
		<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animateCSS.css" rel="stylesheet">
        
       
       <!------分享 彈出窗------>
       <link rel="stylesheet" href="css/baze.modal.css">
       
    
        <!-------設定檔------------>
        <link href="css/setting.css" rel="stylesheet" type="text/css">
		<?php $this -> load -> view('template/template4_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<?php 
		$data['htmltitle']='好友分享券';
		$this -> load -> view('template/template4_headmenu2', $data); ?>
           
		

               <div class="wrapper">
                    
                      <section class="content">
                        <h2 class="content-title mt set-c-title"><?=$my_e_coupon['name']?></h2>
                                  
                        <div class="word-area share">   
                           <img src="<?=$ecp_Ppath?>">
                        </div>   
                        
                        
                        
                     <!------------分享------------->
                        <div class="btn-share" id="ngehe" data-target="#modal2">
                          <a href="javascript:avoid(0)" onclick="gobarcodeurl()">收藏</a>
                        </div>

    <script language="javascript">
    function gobarcodeurl(){
		location ='<?=$public_barcodeurl?>';
     }
    </script>
                        
                        <div class="bzm-content">   
                            <ul class="share-box">
                              <li><a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"><i><img src="images/icon-fb.png" align="center" ></i>facebook</a></li>
                              <li><a href="https://line.naver.jp/R/msg/text/?<?=$public_share_title?>%0D%0A<?=$public_share_url?>"><i><img src="images/icon-line.png" align="center" ></i>LINE</a></li>
                              <li><a href="javascript:(function(){window.open('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?=$public_share_url ?>&choe=UTF-8','_blank','width=300,height=300');})()"><i><img src="images/icon-wechat.png" align="center"></i>WeChat</a></li>
                            </ul>
                        </div>
                         
                         
                   </section>
               </div><!--/wrapper-->
              
            
	 
     <!------分享彈出窗 JS------>
     <script src="js/baze.modal.js"></script> 
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
  </body>
</html>