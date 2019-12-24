<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$this -> web_title?></title>
<link type="text/css" rel="stylesheet" href="/template/temp10/css/header.css" />
<link type="text/css" rel="stylesheet" href="/template/temp10/css/layout.css" />
<script type="text/javascript" src="/template/temp10/js/jquery-1.9.0.min.js"></script>
<link href="/template/temp10/css/font-awesome.min.css" rel="stylesheet">        
<!--相簿輪播JS-->
<link rel="stylesheet" type="text/css" href="/template/temp10/css/photo-style.css" />
<link rel="stylesheet" type="text/css" href="/template/temp10/css/elastislide.css" />
<style>
.es-carousel ul{
    display:block;
}
</style>
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
      <div class="set-c-word" style="display:none;">
          <p></p>
      </div>
  </div>
  </div>
</script>
<!--分享 彈出窗-->
<link rel="stylesheet" href="/template/temp10/css/baze.modal.css"> 
<!--設定檔-->
<link href="/template/temp10/css/setting.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><? //=$photo['name']?></header>
<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'share_btn'); ?>
<div class="wrapper">
<section class="content">                        
<h1 class="content-title set-c-title"><?=$photo['name']?></h1>
<div id="rg-gallery" class="rg-gallery">
  <div class="rg-thumbs">
      <!-- Elastislide Carousel Thumbnail Viewer -->
      <div class="es-carousel-wrapper">
          <div class="es-nav">
              <span class="es-nav-prev">Previous</span>
              <span class="es-nav-next">Next</span>
          </div>
          <div class="es-carousel">
              <ul> <!--程式請將小圖裁切成正方形-->
                <?php if(!empty($list)): ?>
                  <?php foreach ($list as $key => $value): ?>
                    <li class="set-c-word"><a href="#"><img src="<?=$value['img_path']?>" data-large="<?=$value['img_path']?>" data-description="<?=$value['img_note']?>"/></a></li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
          </div>
      </div>
      <!-- End Elastislide Carousel Thumbnail Viewer -->
  </div><!-- rg-thumbs -->
</div><!-- rg-gallery -->
</section><!-- content -->                   
</div><!--/wrapper-->

<!--相簿的JS-->
<script type="text/javascript" src="/template/temp10/js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="/template/temp10/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/template/temp10/js/jquery.elastislide.js"></script>
<script type="text/javascript" src="/template/temp10/js/gallery.js"></script>
<!--分享彈出窗 JS-->
<script src="/template/temp10/js/baze.modal.js"></script> 
<script>
  var elems = $('[data-baze-modal]');
  elems.bazeModal({
      onOpen: function() {
          alert('opened');
      },
      onClose: function() {
          alert('closed');
      }
  });
  $('#ngehe').bazeModal();
</script>
