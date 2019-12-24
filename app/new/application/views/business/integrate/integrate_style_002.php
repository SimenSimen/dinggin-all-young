<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <!–[if IE]>
      <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=640">

  <!-- seo -->
  <title><?=$iqr_name?> 行動商務系統</title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='行動商務系統'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- share -->
  <meta property="og:url" content="<?=$iqr_url?>"/>
  <meta property="og:title" content="<?=$iqr_name?> 行動商務系統"/> 
  <meta property="og:image" content="<?=$base_url?><?=$og_image?>"/> 
  <meta property="og:description" content=""/>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="<?=$base_url?><?=$icon?>" />

  <!--js-->
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>

  <!--css-->
  <link rel="stylesheet" href="<?=$base_url?>/css/integrate/<?=$theme_css?>" /><!--主題css-->
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

  <!--swipe-->
  <script type="text/javascript" src="<?=$base_url?>js/swipe/jquery.touchSwipe.min.js"></script>
  <link href="<?=$base_url?>js/swipe/touchswipe-gallery-style.css" rel="stylesheet">

  <!-- user style -->
  <style type="text/css">
    <?php if ($iqr_html == 1): ?>
    body
    {
      zoom:44.5%;
    }
    <?php endif; ?>
    *{
      font: <?=$font_size?>px "<?=$font_family?>", Helvetica, sans-serif, "微軟正黑體";
    }
    .words
    {
      color:<?=$font_color?>;
    }
    h1{
      color:<?=$font_color?>;
    }
    <?php if ($bg_type == 0): ?>
    .bg_01{
      background:<?=$bg_color?>;
    }
    <?php else: ?>
    .bg_01{
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

</head> 


<body class="bg_01" scroll="yes" style="overflow-x: hidden; width:640px; padding:0px 10px;">

<input value='<?=$iqr_img_double?>' type='hidden' id='iqr_img_double'>
<input value='<?=$iqr_img_ipad?>' type='hidden' id='iqr_img_ipad'>
<input value='<?=$iqr_html?>' type='hidden' id='iqr_html'>

<div id="container">

	<div id="header">
		<!--Share Button-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"><img src="<?=$base_url?>/images/integrate/social_fb.png" alt="facebook" width="80" height="80" border="0" longdesc="#" /></a></td>
		    <td><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));"><img src="<?=$base_url?>/images/integrate/social_t.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
		    <td><a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()"><img src="<?=$base_url?>/images/integrate/social_sina.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
		    <td><a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"><img src="<?=$base_url?>/images/integrate/social_goo.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
		    <td><a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));"><img src="<?=$base_url?>/images/integrate/social_pl.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
		    <td><a href="http://line.naver.jp/R/msg/text/?<?=$iqr_name?>行動商務系統 <?=$iqr_url?>" rel="nofollow" ><img src="<?=$base_url?>/images/integrate/social_line.png" width="80" height="80" style='border:0;' /></a></td>
		    <td><a href="mailto:?subject=<?=$iqr_name?> 行動商務系統&body=我的行動商務系統網址：<br><?=$iqr_url?>"><img src="<?=$base_url?>/images/integrate/social_mail.png" alt="" width="80" height="80" border="0" longdesc="#" /></a></td>
		  </tr>
		</table>
	</div>
       
	<div class="main">
		<?php if ($photo_show && !empty($photo_src)): ?>
			<table style="background-color: rgba(0,0,0,0.2);" id='photo_table'>
				<tr><td colspan="3"><div id="galleryTouch_0"><div id="imgs_0"><?=$photo_src?></div></div></td></tr>
				<tr>
					<td rowspan="2"><a class='arrows' id='photo_left'><i class="fa fa-angle-left fa-2x"></i></a></td>
					<td><div id="galleryNote_0"><div id="note_0"></div></div></td>
					<td rowspan="2"><a class='arrows' id='photo_right'><i class="fa fa-angle-right fa-2x"></i></a></td>
				</tr>
				<tr><td id='photo_counter'><div id="galleryNumber_0"><div id="currentImgNumber_0"></div></div></td></tr>
			</table>
		<?php endif; ?>

		<div class="words" style="background:rgba(255,255,255,0.01);">
			<!-- name -->
			<?=$iqr['l_name']?><?=$iqr['f_name']?><?if($iqr['f_en_name'] != ''):?> (<?=$iqr['f_en_name']?> <?=$iqr['l_en_name']?>)<?endif;?><br>
			<!-- titlename -->
			<?php if ($titlename_num != 0): ?>
				<br>
				<?php foreach ($titlename as $key => $value): ?>
					<?=$value?><br>
				<?php endforeach; ?>
			<?php endif; ?>
			<!-- introduce -->
			<?if($iqr['introduce'] != ''):?><br><?=$iqr['introduce']?><?endif?>
		</div>
	</div><!--main div end-->

	<!-- video -->
    <?php if ($ytb_link_num != 0 || !empty($quote_data['ytb_link']['value'])): ?>
		<div class="main">
			<?php
				// ytb_link
				$this->load->view('cells/ytb_link');
			?>
		</div>
	<?endif?>

  <?php if($web_btn['qrcode_btn'] || $contact_btn['qrcode_btn'] || $app_btn['qrcode_btn']): ?>
	<div class="main">
		<h1><?=$title_text[0]?></h1>
		<?php
			// qrcode
			$this->load->view('cells/qrcode/app');     // app
			$this->load->view('cells/qrcode/web');     // web
			$this->load->view('cells/qrcode/mecard');  // mecard
		?>
	</div>
 <?php endif; ?>
	<?php if ($mobile_show || $cpn_cfax_show || $cpn_phone_show || $cpn_number_show || $email_show || $skype_show || $facebook_show || $line_show): ?>
		<div class="main">
		<h1><?=$title_text[1]?></h1>
		<?php
			// mobile
			$this->load->view('cells/mobile');
      // mobile
      $this->load->view('cells/mobile_phones');
			// cpn_phone
			$this->load->view('cells/cpn_phone');
      // cpn_cfax
      $this->load->view('cells/cpn_cfax');
			// cpn_number
			$this->load->view('cells/cpn_number');
			// email
			$this->load->view('cells/email');
			// skype
			$this->load->view('cells/skype');
			// facebook
			$this->load->view('cells/facebook');
			// line
			$this->load->view('cells/line');
		?>
		</div>
  	<?php endif; ?>

	<?php if ($address_num != 0 || !empty($quote_data['address']['value'])): ?>
		<div class="main">
		<h1><?=$title_text[2]?></h1>
		<?php
			// address
			$this->load->view('cells/address');
		?>
		</div>
	<?php endif; ?>

    <?php if (
	($web_config['cart_status'] == 1 && $cset_active != 0) || 
	($website_num != 0 || !empty($quote_data['website']['value'])) || 
	($uform_show || !empty($quote_data['uform']['value']))): ?>
		<div class="main">
		<h1><?=$title_text[3]?></h1>
      	<?php
			// cart  
			$this->load->view('cells/cart');
			// website
			$this->load->view('cells/website');
			// uform
			$this->load->view('cells/uform');
        ?>
		</div>
	<?php endif; ?>
    
    <?php if (
	$text_edit01_show ||
	$text_edit02_show ||
	$text_edit03_show ||
	(!empty($iqr_html_page) || !empty($quote_data['iqr_html']['value']))): ?>
		<div class="main">
		<h1><?=$title_text[4]?></h1>
		<?php
			// text_edit
			$this->load->view('cells/text_edit/01');
			$this->load->view('cells/text_edit/02');
			$this->load->view('cells/text_edit/03');
			// iqr_html_page
			$this->load->view('cells/iqr_html');
		?>
		</div>
	<?php endif; ?>
    
	<?php if ($ecp_show || !empty($quote_data['ecoupon']['value'])): ?>
		<div class="main">
		<h1><?=$title_text[5]?></h1>
		<?php
			// ecoupon
			$this->load->view('cells/ecoupon');
		?>
		</div>
	<?php endif; ?>

    <?php if ($exfile_show || !empty($quote_data['exfile']['value'])): ?>
		<div class="main">
		<h1><?=$title_text[6]?></h1>
		<?php
			// exfile
            $this->load->view('cells/exfile');
		?>
		</div>
	<?php endif; ?>

    <?php if ($cpn_photo_show && !empty($cpn_photo_src)): ?>
		<div class="main">
			<h1><?=$title_text[7]?></h1>

			<table style="background-color: rgba(0,0,0,0.2);" id='cpn_photo_table'>
				<tr><td colspan="3"><div id="galleryTouch_1"><div id="imgs_1"><?=$cpn_photo_src?></div></div></td></tr>
				<tr>
					<td rowspan="2"><a class='arrows' id='cpn_photo_left'><img src="<?=$base_url?>images/integrate/ar_01_L.png" width="22" height="40" border="0"></a></td>
					<td><div id="galleryNote_1"><div id="note_1"></div></div></td>
					<td rowspan="2"><a class='arrows' id='cpn_photo_right'><img src="<?=$base_url?>images/integrate/ar_01_R.png" width="22" height="40" border="0"></a></td>
				</tr>
				<tr><td id='cpn_photo_counter'><div id="galleryNumber_1"><div id="currentImgNumber_1"></div></div></td></tr>
			</table>
			
		</div>
    <?php endif; ?>

	<div id="ad"><?=$web_config['iqr_footer_text']?></div>  

</div><!-- end container -->

<!-- Gallery -->
<script>
  $(function()
  {
      var IMG_WIDTH_0 = 600,
      IMG_WIDTH_1 = 600,
      currentImg_0=0, currentImg_1=0,
      maxImages_0='<?=$photo_amount?>', maxImages_1='<?=$cpn_photo_amount?>',
      speed=500,
      imgs_0 = $("#imgs_0"),
      imgs_1 = $("#imgs_1");

      //currentImgNumber
      $('#currentImgNumber_0').html('1 / '+maxImages_0);
      $('#currentImgNumber_1').html('1 / '+maxImages_1);

      // divs width
      $('#galleryTouch_0 #imgs_0').css('width', IMG_WIDTH_0 * maxImages_0);
      $('#galleryTouch_1 #imgs_1').css('width', IMG_WIDTH_1 * maxImages_1);
      // photo
      $('#photo_table').css('width', IMG_WIDTH_0);
      $('#photo_counter').css('width', IMG_WIDTH_0);
      $('#galleryTouch_0').css('width', IMG_WIDTH_0);
      $('#galleryTouch_1').css('width', IMG_WIDTH_1);
      $('#galleryTouch_0').css('height', 'auto');
      $('#galleryTouch_1').css('height', 'auto');
      $('#galleryTouch_0 #imgs_0 img').css('width', IMG_WIDTH_0);
      $('#galleryTouch_1 #imgs_1 img').css('width', IMG_WIDTH_1);
      // cpn_photo
      $('#cpn_photo_table').css('width', IMG_WIDTH_1);
      $('#cpn_photo_counter').css('width', IMG_WIDTH_1);

      //note
      var note_array_string = 'var note_array_0 = new Array(<?echo $photo_note;?>);';
      eval(note_array_string);
      var note_array_string = 'var note_array_1 = new Array(<?echo $cpn_photo_note;?>);';
      eval(note_array_string);
      $('#note_0').html(note_array_0[0]);
      $('#note_1').html(note_array_1[0]);

      $('#photo_left').click(function(){
        currentImg_0 = Math.max(currentImg_0-1, 0);
        scrollImages_0( IMG_WIDTH_0 * currentImg_0, speed);
        $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
        $('#note_0').html(note_array_0[currentImg_0]);
      });
      $('#photo_right').click(function(){
        currentImg_0 = Math.min(currentImg_0+1, maxImages_0-1);
        scrollImages_0( IMG_WIDTH_0 * currentImg_0, speed);
        $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
        $('#note_0').html(note_array_0[currentImg_0]);
      });
      $('#cpn_photo_left').click(function(){
        currentImg_1 = Math.max(currentImg_1-1, 0);
        scrollImages_1( IMG_WIDTH_1 * currentImg_1, speed);
        $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
        $('#note_1').html(note_array_1[currentImg_1]);
      });
      $('#cpn_photo_right').click(function(){
        currentImg_1 = Math.min(currentImg_1+1, maxImages_1-1);
        scrollImages_1( IMG_WIDTH_1 * currentImg_1, speed);
        $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
        $('#note_1').html(note_array_1[currentImg_1]);
      });

      //Init touch swipe
      imgs_0.swipe( {
          triggerOnTouchEnd : true,
          swipeStatus : function (event, phase, direction, distance, fingers)
          {
              //If we are moving before swipe, and we are going L or R, then manually drag the images
              if( phase=="move" && (direction=="left" || direction=="right") )
              {
                  var duration=0;

                  if (direction == "left")
                      scrollImages_0((IMG_WIDTH_0 * currentImg_0) + distance, duration);

                  else if (direction == "right")
                      scrollImages_0((IMG_WIDTH_0 * currentImg_0) - distance, duration);
              }

              //Else, cancel means snap back to the begining
              else if ( phase == "cancel")
              {
                  scrollImages_0(IMG_WIDTH_0 * currentImg_0, speed);
              }

              //Else end means the swipe was completed, so move to the next image
              else if ( phase =="end" )
              {
                  if (direction == "right")
                      currentImg_0 = Math.max(currentImg_0-1, 0);
                  else if (direction == "left")
                      currentImg_0 = Math.min(currentImg_0+1, maxImages_0-1);

                  scrollImages_0( IMG_WIDTH_0 * currentImg_0, speed);
                  $('#currentImgNumber_0').html((currentImg_0+1)+' / '+maxImages_0);
                  $('#note_0').html(note_array_0[currentImg_0]);
              }
          },
          allowPageScroll:"vertical"
      });

      imgs_1.swipe( {
          triggerOnTouchEnd : true,
          swipeStatus : function (event, phase, direction, distance, fingers)
          {
              //If we are moving before swipe, and we are going L or R, then manually drag the images
              if( phase=="move" && (direction=="left" || direction=="right") )
              {
                  var duration=0;

                  if (direction == "left")
                      scrollImages_1((IMG_WIDTH_1 * currentImg_1) + distance, duration);

                  else if (direction == "right")
                      scrollImages_1((IMG_WIDTH_1 * currentImg_1) - distance, duration);
              }

              //Else, cancel means snap back to the begining
              else if ( phase == "cancel")
              {
                  scrollImages_1(IMG_WIDTH_1 * currentImg_1, speed);
              }

              //Else end means the swipe was completed, so move to the next image
              else if ( phase =="end" )
              {
                  if (direction == "right")
                      currentImg_1 = Math.max(currentImg_1-1, 0);
                  else if (direction == "left")
                      currentImg_1 = Math.min(currentImg_1+1, maxImages_1-1);

                  scrollImages_1( IMG_WIDTH_1 * currentImg_1, speed);
                  $('#currentImgNumber_1').html((currentImg_1+1)+' / '+maxImages_1);
                  $('#note_1').html(note_array_1[currentImg_1]);
              }
          },
          allowPageScroll:"vertical"
      });

      function scrollImages_0(distance, duration)
      {
          imgs_0.css("-webkit-transition-duration", (duration/1000).toFixed(1) + "s");
          var value_0 = (distance<0 ? "" : "-") + Math.abs(distance).toString();
          imgs_0.css("-webkit-transform", "translate3d("+value_0 +"px,0px,0px)");
      }
      function scrollImages_1(distance, duration)
      {
          imgs_1.css("-webkit-transition-duration", (duration/1000).toFixed(1) + "s");
          var value_1 = (distance<0 ? "" : "-") + Math.abs(distance).toString();
          imgs_1.css("-webkit-transform", "translate3d("+value_1 +"px,0px,0px)");
      }
  });
</script>
<style type="text/css">
  #galleryTouch_0, #galleryTouch_1
  {
    overflow:hidden;
    position:relative;
    /*border : 1px solid black;*/
  }
  #galleryTouch_0 #imgs_0 img, #galleryTouch_1 #imgs_1 img
  {
    padding:0px;
    margin:0px;
    -webkit-transform: translate3d(0px,0px,0px);
  }
  #galleryNumber_0 div, #galleryNumber_1 div, #galleryNote_0 div, #galleryNote_1 div { text-align: center; }
  .arrows { text-decoration: none; color: #000000; }
</style>
</body>
</html>