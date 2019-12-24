<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php $this -> load -> view('template/template3_seo', $data); ?>
	
	

		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/layout.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="<?=$base_url?>template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
        <!------介紹 Contenedor摺疊手風琴-->
        <script type="text/javascript" src="<?=$base_url?>template/temp3/js/accordion.js"></script>

		<?php $this -> load -> view('template/template3_css', $data); ?>

  </style>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
				<a href="#menu"></a>
				關於我 / 個人資訊
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
                 
                 
                 <div class="wrapper">
                 
                     <section class="my-photo">
<!--                        <div class="i-photo"><img src="<?=$base_url?>template/temp3/images/people-photo.jpg" ></div>  -->
                            <?php if(!empty($logo_path)):?>
                        <div class="cover-img"><img src="<?=$logo_path?>" ></div>
                            <?php endif; ?>

						
                        <div class="my-name"><p><?=$iqr_name?></p><p><?=$iqr_en_name?></p></div> 
                     </section>
                    
                    
                    <!--介紹 Contenedor摺疊手風琴 -->
                    <ul id="accordion" class="accordion">
                        <li>
                            <div class="link">介紹<i class="fa fa-chevron-down"></i></div>
                            <section class="sub-i-content">
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
                        </li>
                        <li>
                            <div class="link">聯絡我<i class="fa fa-chevron-down"></i></div>
                            
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
								
                <!-- cpn_number 統一編號 -->
                <?php if($cpn_number_show):?>
                                <a class="c-button" id="icon-number" onclick="alert('<?=$cpn_number_name?>:<?=$cpn_number?>');"><?=$cpn_number_name?></a>
                <?php endif; ?>

                <!-- fax -->
                <?php if($cpn_cfax_show):?>
                                <a class="c-button" id="icon-fax" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
                <?php endif; ?>


                
                <!-- email -->
                <?php if ($email_show): ?>
                                <a class="c-button" id="icon-email"  onclick="location.href='mailto:<?=$iqr['email']?>'"><?=$email_name?></a>
                <?php endif; ?>
                
      			    <!-- line -->
                <?php if ($line_show): ?>
                                <a class="c-button" id="icon-line" onclick="location.href='<?=$line?>'"><?=$line_name?></a>
                <?php endif; ?>
    
                <!-- facebook -->
                <?php if ($facebook_show): ?>
                                <a class="c-button" id="icon-fb" onclick="location.href='<?=$facebook?>'"><?=$facebook_name?></a>
                <?php endif; ?>
 
                <!-- mobile -->
                <?php if($skype_show):?>
                                <a class="c-button" id="icon-skype" onclick="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>       
                <?php endif; ?>

                <!-- address -->
            <?php if (!empty($address)): ?>
                <a class="c-button" id="icon-add" onclick="location.href='http://maps.google.com.tw/maps/place/<?=$address?>'">地址</a>
            <?php endif; ?>
                
                
				<?if($get_device_type>=1){?>
                                <a class="c-button" id="icon-wechat" onclick="getShareEncode2('<?=$public_share_buttom_url?>&linktype=wechat')">微信</a>
                                <a class="c-button" id="icon-whatsapp" onclick="getShareEncode2('<?=$public_share_buttom_url?>&linktype=whatsapp')">What’s App</a>
								<a class="c-button" id="icon-instagram"  onclick="getShareEncode2('<?=$public_share_buttom_url?>&linktype=Instagram')">Instagram</a>
				<?}?>
<!--								
                                <a class="c-button" id="icon-whatsapp" href="whatsapp://send?text=<?=$title?> <?=$iqr_url?>">What’s App</a>
                                <a class="c-button" id="icon-instagram">Instagram</a> 
								
-->
                               
                            </section>
                            
                        </li>
                        <li>
                            <div class="link">QR碼分享<i class="fa fa-chevron-down"></i></div>
							<section class = "sub-i-content" style = "text-align:center" >
							
                      <?php if($web_btn['qrcode_btn']):?>
                                <a class="qr-code2"  onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/0'"><p><?=$web_btn_name?></p></a>
                      <?php endif; ?>

                      <?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
                                <a class="qr-code2"  onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/1'"><p><?=$contact_btn_name?></p></a>
                      <?php endif; ?>
                      
                      <?php if ($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn']): ?>
                                <a class="qr-code2"  onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/2'"><p><?=$app_btn_name?></p></a>
                      <?php endif; ?>
                          </section>
                        </li>
                      
                    </ul>
                    
                    
                    
                    
                    
                   
               </div><!--/wrapper-->
               
            
	   </div><!--/page-->
  </body>
</html>
     <script>
    $(document).ready(function() {
	 $("div[id='head_share_buttom']").click(function(){
		<? if ($get_device_type>=1){ ?>
			getShareEncode2($(this).attr("ref"));
		<? }else{?>
			var sharearea = document.getElementById('sharearea'); 
			sharearea.style.display=sharearea.style.display=='none'?'':'none';
		<? } ?>
	 });
    });
    function getShareEncode2(val){
//			alert(val);
            var i_val = "jecp://"+val.substr(12);
            if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
//				alert(i_val);
                location.href = i_val;
            } else if (/(Android)/i.test(navigator.userAgent)) {
//				alert(val);
                NetNewsAndroidShare.receiveValueFromJs(val);
            } else {
            };
     }
    function getShareEncode3(val){
             alert(val);
     }
    </script>
