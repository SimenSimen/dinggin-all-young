<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
      <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
      
      
      <title><?=$store['cset_name']?> - <?=$web_config['title']?></title>
      <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
      <link rel="stylesheet" type="text/css" href="/tem/css/menuA.css" />
      <link rel="stylesheet" type="text/css" href="/tem/css/globe_shopB01.css" />
      <link rel="stylesheet" type="text/css" href="/tem/css/icon.css">
      
      <script src="/tem/js/modernizr.custom.js"></script>
  </head>
  <body>
      
   <nav class="<?=$cart_menu_button?>">
         <div id="dl-menu" class="dl-menuwrapper">
              <button class="dl-trigger">Open Menu</button>
              <ul class="dl-menu">
            <li><a href="<?=$iqr_url?>"><i class="icon-house"></i> 回首頁</a></li>
            <li style="border-bottom:solid 1px rgba(255,255,255,0.2)" ><a href="/cart/search_engine/<?=$store['cset_code']?>"><i class="icon-search"></i> Search</a></li>
              <?php if (!empty($prdc)): ?>
                <li><a href="/cart/store/<?=$store['cset_code']?>">Hot (<?=$sum?>)</a></li>
                <?php foreach ($prdc as $key => $value): ?>
                  <?php if($value['count'] > 0):?>
                    <li><a href="/cart/store/<?=$store['cset_code']?>/<?=$value['prd_cid']?>"><?=$value['prd_cname']?> (<?=$value['count']?>)</a></li>
                  <?php endif; ?> 
                <?php endforeach; ?>
              <?php endif; ?>
          </ul>
          </div>
      </nav>
   <header>
      <a href="javascript:void(0);">
          <!--for螢幕1200px以上使用，圖片尺寸:寬2000px 建議高度450px-->
          <?php if(!empty($cart_logo_url)):?>
            <img src="<?=$cart_logo_url?>" alt=""/>
          <?php endif; ?> 
          <!--for螢幕1200px以上使用，圖片尺寸:寬1200px 建議高度450px-->   
      </a>
   </header> 
   <div class="status" >
    <ul class="www">
        <li><a class="aa1" href="/cart/check/<?=$cset_code?>/1"><span class="icon-cart3"></span></a></li> <!--購物明細-->
        <?php if ($user_login): ?>
          <li><a class="aa1" href="/cart/record/<?=$cset_code?>"><span class="icon-file-text-o"></span></a></li> <!--訂購紀錄-->
          <li><a class="aa2" href="/cart/user_logout/<?=$cset_code?>">登出</a></li> <!--登入 or 登出-->
        <?php else:?>
          <li><a class="aa2" href="/cart/user_login/<?=$cset_code?>">登入</a></li> <!--登入 or 登出-->
        <?php endif;?>
    </ul>
    <?php if($class_name): ?>
      <ul class="www">
        <li><span style="display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 240px;" class="aa2">類別: <?=$class_name?></span></li>
      </ul>
    <?php endif; ?>
   </div> 

    <div id="container" >
        <?php if (!empty($prdc)): ?>
          <?php if($product_cid == ''): ?>
           <?php foreach ($prd_hot as $key => $value): ?>
            <div class="pp">
              <!-- <div class="new-a01">NEW</div> -->
              <a class="product" href="/cart/product_info/<?=$cset_code?>/<?=$value['prd_id']?>"> 
              <div class="view"><img src="<?=$img_url.'set_'.substr($value['prd_image'], 1)?>" alt=""/>
               <div class="mask"><h6>view more</h6></div></div>
              <div class="pName"><?=$value['prd_name']?></div>
               <div class="pPrice"><?=number_format($value['prd_price00'])?>元</div>
               </a>
            </div>
           <?php endforeach; ?>

          <?php elseif($product_cid != ''): ?>
           <?php foreach ($prd as $sub_key => $sub_value): ?>
            <div class="pp">
              <!-- <div class="new-a01">NEW</div> -->
              <a class="product" href="/cart/product_info/<?=$cset_code?>/<?=$sub_value['prd_id']?>"> 
              <div class="view"><img src="<?=$img_url.'set_'.substr($sub_value['prd_image'], 1)?>" alt=""/>
               <div class="mask"><h6>view more</h6></div></div>
              <div class="pName"><?=$sub_value['prd_name']?></div>
               <div class="pPrice"><?=number_format($sub_value['prd_price00'])?>元</div>
               </a>
            </div>
           <?php endforeach; ?>
          <?php endif; ?>
        <?php endif; ?>
        
        <div class="clear"></div>
        
      </div>
    </div>
    <div class="clear"></div>
    <!-- <p><a class="load-more" href="#">看更多產品</a></p> -->
    
   <footer>
     <div class="www">
        <div class="foo1">
          <?php if($iqr_cart['cset_company'] != ''): ?>
           <span class="fooTXT"><?=$iqr_cart['cset_company']?></span>
          <?php endif; ?>
          <?php if($iqr_cart['cset_address'] != ''): ?>
            <span class="fooTXT"><?=$iqr_cart['cset_address']?></span> <br>
            <?php endif; ?>
            <?php if($iqr_cart['cset_telphone'] != ''): ?>
           <a class="aa3 icon-phone4" href="tel:<?=$iqr_cart['cset_telphone']?>">&nbsp;<?=$iqr_cart['cset_telphone']?></a>
           <?php endif; ?>
           <?php if($iqr_cart['cset_mobile'] != ''): ?>
            <a class="aa3 icon-mobile" href="tel:<?=$iqr_cart['cset_mobile']?>">&nbsp;<?=$iqr_cart['cset_mobile']?></a>
            <?php endif; ?>
            <?php if($iqr_cart['cset_email'] != ''): ?>
            <a class="aa3 icon-envelope5" href="mailto:<?=$iqr_cart['cset_email']?>">&nbsp;<?=$iqr_cart['cset_email']?></a>
            <?php endif; ?>
        </div>
        <div class="foo2">
          <a class="icon-facebook3" href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" ></a>
           <a class="icon-googleplus3" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" ></a>
           <a class="icon-twitter3" href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" ></a>
           <!-- <a class="icon-youtube" href="#" ></a> -->
        </div>
        <div class="clear"></div>
     </div>
  </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/tem/js/imagesloaded.pkgd.min.js"></script>
    <script src="/tem/js/masonry.pkgd.min.js"></script>
    <script src="/tem/js/jquery.dlmenu.js"></script>
      <script>
          $(function() {
              $( '#dl-menu' ).dlmenu({
                  animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
              });
          });
      
      $(function(){
        var $container = $('#container');
        // initialize
        $container.imagesLoaded( function() {
          $container.masonry({
            itemSelector: '.proView'
          }); 
        }); 
      })

      </script>

  </body>
</html>