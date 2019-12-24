<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width"> 

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

  <!--css-->
  <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
  <!-- footer -->
  <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/<?=$slider_css?>">
  <style type="text/css">
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
  <!--區塊滑動，動作-->
	<script>
    $(document).ready(function ($) {
      $("#tabs").tabs();
      $("#tabs").tabulous({
        effect: 'slideLeft' 
      });
    });
  </script><!--區塊滑動，動作-->

</head> 
<body scroll="yes" style="overflow-x: hidden;">

	<div id="tabs">
  		   <div id="tabs_container"><!--div tabs_container-->
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="35" align="center" class="topcolor1">
						  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="40" align="center"><a href="#" onclick="history.go(-1)"><img class="backtag" src="<?=$base_url?>template/images/back.png" alt="back" /></a></td>
                            <td align="center"> 個人名片</td>
                            <div id="sharearea" class="sharearea" style="display:none;">
                          </tr>
                        </table></td>
                  </tr>
                      <tr>
                        <td align="center" >
                        
                          <table width="310" border="0" cellspacing="3" cellpadding="0">
                            <tr>
                              <td>關於 <?=$iqr_name?>  <?php if(!empty($iqr['f_en_name']) || !empty($iqr['l_en_name'])): ?> / <?=$iqr['f_en_name']?> <?=$iqr['l_en_name']?><?php endif; ?></span></td>
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
                                    <td class="user_text">
                                      <?=$iqr['introduce']?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>                         
                        </td>
                      </tr>
             </table>
              
                <!-- mobile -->
                <?php if($mobile_show):?>
                  <a class="aa04" id="icon09" onclick="location.href='tel:<?=$iqr['mobile']?>'"><?=$mobile_name?></a>
                <?php endif; ?>
                
                <?php if ($mobile_phones_num != 0): ?>
                  <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa04" id="icon09" onclick="location.href='tel:<?=$value?>'"><?=$mobile_phones_name?></a>
                  <?php endforeach; ?>
                <?php endif; ?>

                <!-- skype --><!-- cpn_phone -->
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
 
                <!-- mobile -->
                <?php if($skype_show):?>
                  <a class="aa04-sky" onclick="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
                <?php endif; ?>

                <!-- skype --><!-- cpn_phone -->
                <?php if ($cpn_cfax_show): ?>
                  <a class="aa04" id="icon08" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
                <?php endif; ?>
 
                <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"> <span style="color:#333">QR碼 分享</span><BR />
                      <?php if($web_btn['qrcode_btn']):?>
                        <a class="aa04-QR" style="background:#666 url(../../images/integrate/btn04_QR.png) no-repeat 45px center;" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/0'"><?=$web_btn_name?></a> 
                      <?php endif; ?>

                      <?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
                        <a class="aa04-QR" style="background:#666 url(../../images/integrate/btn04_QR.png) no-repeat 45px center;" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/1'"><?=$contact_btn_name?></a>
                      <?php endif; ?>
                      
                      <?php if ($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn']): ?>
                        <a class="aa04-QR" style="background:#666 url(../../images/integrate/btn04_QR.png) no-repeat 45px center;" onclick="location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/2'" ><?=$app_btn_name?></a>
                      <?php endif; ?>
                      <br><br><br>
                    </td>
                  </tr>
                </table>
      </div><!--div tabs_container-->
        </div><!--div tabs-->
</body>
</html>