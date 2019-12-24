<?=$this->load->view('gold/header');?>
<body class="bg-style">
<header class="header"><?=$IQRInformation?></header>
<div class="wrapper">
<div class="i-photo">
  <?php if(!empty($logo_path)): ?>
    <img src="<?=$logo_path?>" >
  <?php endif; ?>
</div>  
<div class="my-name"><p><?=$iqr['l_name']?><?=$iqr['f_name']?><b><?=$iqr['f_en_name']?><?=$iqr['l_en_name']?></b></p></div>
<ul class="accordion">
    <li><section class="set-my-info">
           <ul class="my-title">
            <?php if(!empty($titlename)): ?>
              <?php foreach ($titlename as $key => $value): ?>
                <li><?=$value?></li>
              <?php endforeach; ?>
            <?php endif; ?>
           </ul> 
           <article class="my-word"><?=$iqr['introduce']?></article>
        </section>
        <div class="line"></div></li>
    <li><section class="sub-i-content">
            <?php if(!empty($mobile_show)): ?>
              <a class="c-button" id="icon-phone" href="tel:<?=$mobile?>"><?=$mobile_name?></a>
            <?php endif; ?>

            <?php if(!empty($mobile_phones)): ?>
              <?php foreach ($mobile_phones as $key => $value): ?>
                <a class="c-button" id="icon-phone" href="tel:<?=$value?>"><?=$mobile_phones_name[$key]?></a>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php if(!empty($cpn_phone_show)): ?>
              <a class="c-button" id="icon-tel" href="tel:<?=$cpn_phone?>, <?=$cpn_extension?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if(!empty($cpn_cfax_show)): ?>
              <a class="c-button" id="icon-fax" href="tel:<?=$cpn_cfax?>"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if(!empty($cpn_number_show)): ?>
              <a class="c-button" id="icon-number" href="javascript:alert('統一編號:<?=$cpn_number?>');"><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if(!empty($email_show)): ?>
              <a class="c-button" id="icon-email" href="mailto:<?=$email?>"><?=$email_name?></a>
            <?php endif; ?>

            <?php if(!empty($skype_show)): ?>
              <a class="c-button" id="icon-skype" href="skype:<?=$skype?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if(!empty($facebook_show)): ?>
              <a class="c-button" id="icon-fb" href="<?=$facebook?>"><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if(!empty($line_show)): ?>
              <a class="c-button" id="icon-line" href="<?=$line?>"><?=$line_name?></a>
            <?php endif; ?>
            <!-- <a class="c-button" id="icon-wechat">微信</a> -->
            <!-- <a class="c-button" id="icon-whatsapp">What's App</a> -->
            <!-- <a class="c-button" id="icon-instagram">Instagram</a> -->
        </section></li>
    <li><section class="sub-i-content"><h1 class="qr-title"><?=$QRcodeSharing?></h1>
          <?php if($web_btn['qrcode_btn']):?>
            <a class="qr-code set-qr-word" href="/business/view_qrcode/<?=$iqr['member_id']?>/0"><img src="/images/gold/qr-code.jpg" ><p><?=$web_btn_name?></p></a>
          <?php endif; ?>
          
          <?php if ($iqr['apk'] != 0 && $iqr['ipa'] != 0 && $app_btn['qrcode_btn']): ?>
            <a class="qr-code set-qr-word" href="/business/view_qrcode/<?=$iqr['member_id']?>/2"><img src="/images/gold/qr-code.jpg" ><p><?=$app_btn_name?></p></a>
          <?php endif; ?>

          <?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
            <a class="qr-code set-qr-word" href="/business/view_qrcode/<?=$iqr['member_id']?>/1"><img src="/images/gold/qr-code.jpg" ><p><?=$contact_btn_name?></p></a>
          <?php endif; ?>

      </section></li>
</ul>                    
