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
        
       <!-- TAB-->
       <link type="text/css" rel="stylesheet" href="css/tab.css" />
       <script src="js/modernizr.js"></script> <!-- Modernizr -->
       <script src="js/tab-main.js"></script> <!-- Resource jQuery -->
        <!-------設定檔------------>
        <link href="css/setting.css" rel="stylesheet" type="text/css">
		<?php $this -> load -> view('template/template4_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<?php 
		$data['htmltitle']='個人資訊';
		$this -> load -> view('template/template4_headmenu2', $data); ?>
			

                 
                 <div class="wrapper">
  
                     
                     <div class="my-name"><p><?=$iqr_name?><p><p><?=$iqr_en_name?></p></div> 
 
                    
                      <div class="cd-tabs">
                            <nav>
                                <ul class="cd-tabs-navigation">
                                    <li><a data-content="select-master" class="selected" href="#0">介紹</a></li>
                                    <li><a data-content="contact-me" href="#0">聯絡我</a></li>
                                    <li><a data-content="qr" href="#0">QR碼分享</a></li>
                                    
                                </ul> <!-- cd-tabs-navigation -->
                            </nav>
                        
                            <ul class="cd-tabs-content">
                                <li data-content="select-master" class="selected">
                               
                                        <div style="display:block" class="m-s-menu_body">
                                               <section class="sub-i-content set-my-info">
                                                   
												<?php if(!empty($title)): ?>
                                                   <ul class="my-title"> 
                                                  <?php foreach ($title as $key => $value): ?>
                                                      <li><?=$value?></li>
                                                  <?php endforeach; ?>
                                                   </ul> 
                                                <?php endif ; ?>
                                                   
                                                   <article class="my-word">
					                                  <?=$iqr['introduce']?>
	                                               </article>
                                                </section>
                                        </div>
                                    
                                </li>
                        
                        
                                <li data-content="contact-me">
                                     <div class="m-s-menu_body">
                                             <section class="sub-i-content">
				                <!-- mobile -->
								<?php if($mobile_show):?>
				<?if($get_device_type>=1){?>
                                <a class="c-button" id="icon-phone" onclick="location.href='tel:<?=$iqr['mobile']?>'"><?=$iqr['mobile_name']?></a>
				<?}else{?>
                                <a class="c-button" id="icon-phone" onclick="alert('<?=$iqr['mobile_name']?>:<?=$iqr['mobile']?>')"><?=$iqr['mobile_name']?></a>
				<?}?>
								
								<?php endif; ?>
								<?php if ($mobile_phones_num != 0): ?>
								  <?php foreach ($mobile_phones as $key => $value): ?>
				<?if($get_device_type>=1){?>
								<a class="c-button" id="icon-phone"  onclick="location.href='tel:<?=$value?>'"><?=$mobile_phones_name?></a>
				<?}else{?>
								<a class="c-button" id="icon-phone"  onclick="alert('<?=$mobile_phones_name?>:<?=$value?>')"><?=$mobile_phones_name?></a>
				<?}?>
								  <?php endforeach; ?>
								<?php endif; ?>
                                
                                
                <!-- cpn_phone -->
                <?php if ($cpn_phone_show): ?>
				<?if($get_device_type>=1){?>
                                <a class="c-button" id="icon-tel" onclick="location.href='tel:<?=$cpn_phone?><?=$cpn_extension?>'"><?=$cpn_phone_name?></a>
				<?}else{//if($get_device_type>=1){?>
                                <a class="c-button" id="icon-tel" onclick="alert('<?=$cpn_phone_name?>:<?=$cpn_phone?><?=$cpn_extension?>')"><?=$cpn_phone_name?></a>
				<?}//if($get_device_type>=1){?>
                <?php endif; ?>

                <!-- fax -->
                <?php if($cpn_cfax_show):?>
                                <a class="c-button" id="icon-fax" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
                <?php endif; ?>
                <!-- cpn_number 統一編號 -->
                <?php if($cpn_number_show):?>
                                <a class="c-button" id="icon-number" onclick="alert('<?=$cpn_number_name?>:<?=$cpn_number?>');"><?=$cpn_number_name?></a>
                <?php endif; ?>
                
                <!-- email -->
                <?php if ($email_show): ?>
                                <a class="c-button" id="icon-email"  onclick="location.href='mailto:<?=$iqr['email']?>'"><?=$email_name?></a>
                <?php endif; ?>
                
                <!-- address -->
                <?php if(!empty($address)):?>
                                <a class="c-button" id="icon-add" onclick="alert('<?=$address?>');">地址</a>       
                <?php endif; ?>
                <!-- mobile -->
                <?php if($skype_show):?>
                                <a class="c-button" id="icon-skype" onclick="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>       
                <?php endif; ?>
                <!-- facebook -->
                <?php if ($facebook_show): ?>
                	<a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"  class="c-button" id="icon-fb" ></a>
                <?php endif; ?>
      			    <!-- line -->
                <?php if ($line_show): ?>
                      <a class="c-button" id="icon-line"  href="http://line.naver.jp/R/msg/text/?<?=$public_share_title?>%0D%0A<?=$public_share_url?>"><?=$line_name?></a>
                <?php endif; ?>



				<? if($get_device_type>=1){ ?>
            <!-- wechat -->
               <a class="c-button" id="icon-wechat" href="javascript:(function(){window.open('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?=$public_share_url ?>&choe=UTF-8','_blank','width=300,height=300');})()">微信</a>
                                

            <!-- Whatsapp -->
             <a class="c-button" id="icon-whatsapp" href='whatsapp://send?text=<?=$public_share_title?>-<?=$public_share_url?>' data-action="share/whatsapp/share">What’s App</a>
                                
                               
			<a class="c-button" id="icon-instagram"  onclick="getShareEncode2('<?=$public_share_buttom_url?>&linktype=Instagram')">Instagram</a>
				<? } ?>

                                            </section>
                                    </div>       
                                </li>
                        
                        
                        
                        
                                <li data-content="qr">
                                       <div class="m-s-menu_body">
                                                                        
                                                <section class="sub-i-content">
                                                
                      <?php if($web_btn['qrcode_btn']):?>
                                <a class="qr-code set-qr-word" href="javascript: void(0)" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/0'"><img src="images/qr-code.jpg" ><p><?=$web_btn_name?></p></a>
                      <?php endif; ?>

                      <?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
                                <a class="qr-code set-qr-word"  href="javascript: void(0)" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/1'"><img src="images/qr-code.jpg" ><p><?=$contact_btn_name?></p></a>
                      <?php endif; ?>
                      
                      <?php if ($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn']): ?>
                                <a class="qr-code set-qr-word" href="javascript: void(0)" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/2'"><img src="images/qr-code.jpg" ><p><?=$app_btn_name?></p></a>

                      <?php endif; ?>
                                                
                                                </section>
                                      </div>    
                                </li>
                        
                                
                            </ul> <!-- cd-tabs-content -->
                     </div> <!-- cd-tabs -->
                    
                    
                    
                  
                    
                    
                    
                    
                   
               </div><!--/wrapper-->
               
            
	 
  </body>
</html>
<script >

 function getShareEncode1(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$public_share_url?>&ecp_title=<?=$public_share_title?>';
    var i_val = "jecp://<?=$public_share_url?>&ecp_title=<?=$public_share_title?>";
    if (/(chrome|Safari|Firefox)/i.test(navigator.userAgent)) {
      $('#share_btn_table').toggle();
    }else if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
   
    function getShareEncode2(val){
            var i_val = "jecp://"+val.substr(12);
            if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
                location.href = i_val;
            } else if (/(Android)/i.test(navigator.userAgent)) {
                NetNewsAndroidShare.receiveValueFromJs(val);
            } else {
            };
     }
	   
</script>