<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
      <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
      
      <title>商品搜尋 - <?=$web_config['title']?></title>
      <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  	  <link rel="stylesheet" type="text/css" href="/tem/css/bootstrap.css" >
      <link rel="stylesheet" type="text/css" href="/tem/css/product.css" />
      <link rel="stylesheet" type="text/css" href="/tem/css/icon.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <script src="/tem/js/bootstrap.min.js"></script>
      <script src="/tem/js/modernizr.custom.js"></script>  
      <script src="/tem/js/tabs.js" type="text/javascript" ></script> 
      <script src="/tem/js/jquery.easydropdown.js"></script>
      
      <script type="text/javascript">
			$(function() {
		   
			  $("#cart_link").popover({ html: true, trigger: "click" });
			  $(".aa6").click(function(){
          document.getElementById("search").submit();
        })
			
			  $("#prd_amount").hover(function() {
				$("#prd_amount_div").show();
			  }, function() {
				$("#prd_amount_div").hide();
			  });
			  
			});
      </script>
	
      
  </head>
  <body>
           
   <header>
   	 <div class="www">
   		<div class="row">
           <div class="col-xs-2 text-left"><a class="goBack" href="/cart/store/<?=$cset_code?>"><span class="icon-angle-left"></span></a></div>
           <div class="col-xs-8"><h1>搜 尋</h1></div>
           <div class="col-xs-2 text-right">

                <a id="cart_link" class="cart" href="javascript:void(0);" data-placement="bottom" data-trigger="hover"  
                data-content="已選購商品<br><span style='color:#DA5049'>0</span> 件<br>總金額(TWD)<br><span style='color:#DA5049'>0</span> 元" >
                <span class="icon-cart32"></span>
                </a>
     
           </div>
       </div>
      </div>
   </header>  

    <div class="main">
        <!--搜尋-->  
        <section class="search">
           <div class="row">
               <div class="col-sm-6 col-sm-offset-3">
               <?php if($tips == 'fail'):?>
                   <p class="ff2"><span class="icon-notice"></span>關鍵字：<?=$search_key?>&nbsp;&nbsp; 無相關產品，請重新搜尋</p><br>     
                <?php endif;?>
                  <form id="search" method="post" action="/cart/search_engine/<?=$cset_code?>">
                  <input name="search_key" type="text" class="form-control input" placeholder="請輸入關鍵字">    
                  <a class="aa6" href="javascript:void(0);"><span class="icon-search"></span>&nbsp;&nbsp;搜&nbsp;尋</a>         
                  </form>
               </div>
            </div> 
        </section>   
          
            
        <!--結果--> 
        <section class="www resault" id="relativeP">
        <?php if($search_key && $tips != 'fail'):?>
            <h3>關鍵字：<?=$search_key?></h3>
        <?php endif; ?>
            <div class="row no-pad">
            <?php if($search_result):?>
            <?php foreach ($search_result as $key => $value):?>
               <div class="col-sm-2 col-xs-4">
                 <div class="proView">
                   <a href="/cart/product_info/<?=$cset_code?>/<?=$value['prd_id']?>">
                    <div class="centerIMG"><img src="<?=$member['img_url'].'products/set_'.substr($value['prd_image'], 1)?>" alt=""/></div>
                    <div class="pName"><?=$value['prd_name']?></div>
                   </a>
                  </div>
               </div>
            <?php endforeach;?>
          <?php endif;?>
            </div>
         
        </section>
        
     
    </div>
 

 
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
        	<a class="icon-facebook3" href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" ></a>
           <a class="icon-googleplus3" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" ></a>
           <a class="icon-twitter3" href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" ></a>
        </div>
        <div class="clear"></div>
     </div>
  </footer>
  <script src="/js/cart_process0918.js"></script>
  </body>
</html>