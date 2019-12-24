<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
      <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
      
      <!-- meta -->
      <meta property="og:site_name" content="<?=$web_config['title']?>" />
      <meta property="og:title" content="<?=$prd['prd_name']?> - <?=$web_config['title']?>"/>
      <meta property="og:type" content="website"/>
      <meta property="og:image" content="<?=$base_url?><?=substr($img_url, 1).$prd['prd_image']?>"/>
      <link href="<?=$base_url?><?=substr($img_url, 1).$prd['prd_image']?>" rel="image_src" type="image/jpeg"/>
      
      <title><?=$prd['prd_name']?> - <?=$web_config['title']?></title>
      <!--<link rel="shortcut icon" href="../favicon.ico"> -->
      <link rel="stylesheet" type="text/css" href="/tem/css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="/tem/css/product.css" />
      <link rel="stylesheet" type="text/css" href="/tem/css/icon.css">
      <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script type="text/javascript" src="/js/jquery.blockUI.js"></script>
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/flick/jquery-ui.min.css" rel="stylesheet">
      <script src="/tem/js/bootstrap.min.js"></script>
      <script src="/tem/js/modernizr.custom.js"></script>  
      <script src="/tem/js/tabs.js" type="text/javascript" ></script> 
      <script src="/tem/js/jquery.easydropdown.js"></script>
      <style type="text/css">
        .ui-dialog-titlebar-close { background-image: url(/images/close-icon.png); background-size: cover; }
        .ui-dialog-title{ font-family: 'Microsoft Jhenghei'; font-size: 0.9em; }
        .ui-dialog .ui-dialog-buttonpane button{ font-size: 0.79em; font-family: 'Microsoft Jhenghei'; padding: 0px 2px 0px 2px; }
        #dialog-message{ font-family: 'Microsoft Jhenghei'; font-size: 0.9em; }
      </style>
      <script type="text/javascript">
      $(function() {
       
        $("#cart_link").popover({ html: true, trigger: "click" });
        
      
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
      <div class="row ">
           <div class="col-xs-2 text-left"><a class="goBack" href="/cart/store/<?=$store['cset_code']?>"><span class="icon-arrow-left5"></span></a></div>
           <div class="col-xs-8"><h1><?=$prd['prd_name']?></h1></div>
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
    
      <section id="container" >
    <div class="detail-L">
           <div class="img-size">
              <img src="<?=$img_url.$prd['prd_image']?>" alt=""/>  <!--寬度768 可以滿版-->
           </div>
       </div>
       
       <div class="detail-R"> 
           <div class="row">
               <div class="col-xs-12">    
               
                  <h2><?=$prd['prd_name']?></h2>
                   <div class="des">
                      <ul>
                      <?php if (!empty($prd_describe)): ?>
                        <?php foreach ($prd_describe as $key => $value): ?>
                          <li><span class="icon-media-record-outline ff1"></span><?=$value?></li>
                        <?php endforeach; ?>
                      <?php endif; ?>
                      </ul>
                   </div>
               </div>
               
               <div class="col-lg-2 col-md-3 col-xs-4">建議售價</div>
               <?php if ($prd['prd_price01'] != ''): ?>
               <div class="col-lg-10  col-md-9  col-xs-8">$ <?=number_format($prd['prd_price01'])?></div>
               <?php else: ?>
               <div class="col-lg-10  col-md-9  col-xs-8">無</div>
               <?php endif; ?>

               <div class="col-lg-2 col-md-3  col-xs-4">特價</div>
               <div class="col-lg-10  col-md-9 col-xs-8"><mark>$ <?=number_format($prd['prd_price00'])?></mark></div>
               <?php if ($prd['prd_active'] == 0): ?>
                <div class="col-lg-2 col-md-3  col-xs-4">庫存數量</div>
                <div class="col-lg-10  col-md-9 col-xs-8"><?=$prd['prd_amount']?>   &nbsp;
                <a id="prd_amount" href="#prd_amount_div">僅供參考</a>
                  <div id="prd_amount_div" style="display: none;">實際商品數量以訂購銷存順序為準</div>
                  </div>
               <?php endif; ?>

               <!-- <div class="col-lg-2 col-md-3  col-xs-4">PV</div> -->
               <!-- <div class="col-lg-10  col-md-9 col-xs-8"><?=$prd['prd_pv']?> &nbsp;</div> -->

               <div class="col-lg-2 col-md-3  col-xs-4">付款方式</div>
                <?php if(empty($payment_way)): ?>
                  <div class="col-lg-10  col-md-9 col-xs-8">無 &nbsp;</div>
                <?php else: ?>
                  <div class="col-lg-10  col-md-9 col-xs-8"><?php foreach ($payment_way as $key => $value): ?><?=$value['pway_name']?> &nbsp;<?php endforeach; ?></div>
                <?php endif;?>
               <div class="col-lg-2 col-md-3  col-xs-4">交貨方式</div>
                <?php if(empty($logistics_way)): ?>
                  <div class="col-lg-10  col-md-9 col-xs-8">無 &nbsp;</div>
                <?php else: ?>
                  <?php foreach ($logistics_way as $log_key => $log_value): ?>
                    <div class="col-lg-10  col-md-9 col-xs-8" style="float: right;"><img style="width: 30px;height: auto; vertical-align: middle;margin-right:5px;" src="<?=$log_value['lway_image']?>"><?=$log_value['lway_name']?> <?=($log_value['business_account']==0)?'':$log_value['business_account'];?></div>
                  <?php endforeach; ?>
                <?php endif; ?>
                <?php if(!empty($fee)):?>
                  <div class="col-lg-10 col-md-9  col-xs-8" style="float: right;">購物滿 <span style="color:red;"><?=number_format($fee)?></span> 元，<span style="color:red;">免運費</span></div>
                <?php endif; ?>
                <?php if($prd['restrice_num']!='0'):?>
                  <div class="col-lg-10 col-md-9  col-xs-8" style="float: right;">每人限購 <span style="color:red;"><?=number_format($prd['restrice_num'])?></span>組</div>
                <?php endif; ?>
      </div> 
    
        <section class="pay">
      <div class="row">
               <div class="col-lg-4 col-md-3 col-sm-4 col-xs-5" >
                <!--<input type="number" name="amount" id="prd_num" min="1" max="4" value="1" class="form-control" style="width:120px" >-->
                  <select class="dropdown big" id='prd_num' >
                  <?php if($prd['prd_lock_amount'] < $prd['prd_amount']):?>
                    <?php for($i = 1; $i < $prd['prd_lock_amount']+1; $i++):?>
                      <option value="<?php echo $i?>"><?php echo $i?></option>
                    <?php endfor; ?>
                  <?php else: ?>
                    <?php for($i = 1; $i < $prd['prd_amount']+1; $i++):?>
                      <option value="<?php echo $i?>"><?php echo $i?></option>
                    <?php endfor; ?>
                  <?php endif; ?>           
                  </select>
               </div>  
               <div class="col-lg-8 col-md-9 col-sm-8 col-xs-7">
                <button class="aa4" id="add_to_cart">放入購物車<span class="icon-cart32"></span></button>
            <div id="dialog-message" title=""></div><span id='prd_id' style='display: none;'><?=$prd['prd_id']?></span><span id='cset_code' style='display: none;'><?=$cset_code?></span><span id='iqr_url' style='display: none;'><?=$iqr_url?></span>

               </div>           
            </div> 
         </section>  
       </div>  
       
       <div class="clear"></div>
       
       <div class="tabs">
                <ul class="tab-links">
                    <li class="active"><a href="#buy1" >商品介紹</a></li>
                    <li><a href="#buy2">商品規格</a></li>
                    <li><a href="#buy3">購買說明</a></li>
                    <li><a href="#buy4">運送規則</a></li>
                </ul>
       
                <div class="tab-content">
<!--1商品介紹-->
                  <div id="buy1" class="tab active">
                  
                    <p><?=$prd['prd_content']?></p>
                    <?php if (!empty($prd_video_link)): ?>
                      <?php foreach ($prd_video_link as $key => $value): ?>
                        <p style="padding-top: 25px; font-weight: bold;"><?=$prd_video_name[$key]?></p>
                        <p><iframe class='video_iframe' style="width: 100%; height: 350px;" src="<?=$value?>"></iframe></p>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
<!--2商品規格-->
                  <div id="buy2" class="tab">
                    <?php if (!empty($prd_specification_content)): ?>
                      <?php foreach ($prd_specification_content as $key => $value): ?>
                        <p><?=$prd_specification_name[$key]?></p><br/>
                        <p><?=$value?></p><br/>
                      <?php endforeach; ?>
                      <?php else: ?>
                        <p>目前沒有任何關於商品規格的資訊</p>
                    <?php endif; ?>
<!-- 保固範圍-->
                    <?php if ($prd['prd_assurance_range'] != '' || $prd['prd_assurance_date'] != ''): ?>                    
                      
                      <?php if ($prd['prd_assurance_range'] != ''): ?>
                        <p>保固範圍：<?=$prd['prd_assurance_range']?></p><br/>
                      <?php endif; ?>
                      
                      <?php if ($prd['prd_assurance_date'] != ''): ?>
                        <p>保固期限：<?=$prd['prd_assurance_date']?></p><br/>
                      <?php endif; ?>

                    <?php endif; ?>
                  </div>
<!--3購買說明-->
                  <div id="buy3" class="tab">
                  <p class="prd_content"><strong>【購物說明】</strong><br><br>
                    <?php if ($store['cset_paid'] != ''): ?>
                      <p><?=$store['cset_paid']?></p>
                      <?php else: ?> 
                      <p>無</p>
                    <?php endif; ?>
       
                  </div>
<!--4運送規則-->
                  <div id="buy4" class="tab">
                    <?php if ($store['cset_ship'] != ''): ?>
                      <p><?=$store['cset_ship']?></p>
                        <?php else: ?> 
                        <p>無</p>
                    <?php endif; ?>
                            
                  </div>
                 </div>
              </div>
     
     
    </section>   
    
  <?php if($store['cset_share_btn']): ?>
    <section class="www" id="share"> 
      <h3>分享此商品</h3>
      <a class="shareTo fb" href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" title="facebook"><span class="icon-facebook2"></span></a>
      <a class="shareTo twitter" href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" title="twitter"><span class="icon-twitter"></span></a>
      <a class="shareTo line" href="http://line.naver.jp/R/msg/text/?<?=$prd['prd_name']?>-<?=$web_config['title']?>%0D%0A<?=$prd_url?>" title="line"></a>  
      <a class="shareTo gg" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));"  title="google +"><span class="icon-googleplus"></span></a>                    
      <a class="shareTo sina" href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()"  title="新浪微博" ><span class="icon-weibo"></span></a>
      <!-- <a class="shareTo weChat" href="#"  title="WeChat 微信"><span class="icon-wechat"></span></a> -->
      <a class="shareTo plurk" href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));" title="Plurk 噗浪"></a>
      <!-- <a class="shareTo phoneMassage" href="#" title="簡訊" ><span class="icon-comment"></span></a>  -->
      <!-- <a class="shareTo mail" href="mailto:?subject=<?=$prd['prd_name']?>-<?=$web_config['title']?>&body=網址：<br><?=$iqr_url?>" title="E-mail"><span class="icon-envelope5"></span></a>          -->
      <a class="shareTo qq" href="javascript: void(window.open('http://share.v.t.qq.com/index.php?c=share&a=index&url='.concat(encodeURIComponent(location.href)) +'&title=' .concat(encodeURIComponent(document.title)) ));"  title="腾訊微博"><span class="icon-tencent-weibo"></span></a>
      <a class="shareTo ren" href="javascript: void(window.open('http://widget.renren.com/dialog/share?resourceUrl='.concat(encodeURIComponent(location.href)) +'&title=' .concat(encodeURIComponent(document.title)) ));"  title="人人"><span class="icon-renren2"></span></a>   
      <a class="shareTo qzone" href="javascript: void(window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='.concat(encodeURIComponent(location.href))+'&title='.concat(encodeURIComponent(document.title)) ));"  title=""></a>       
    </section>
  <?php endif; ?>
  
      <section class="www" id="relativeP"> 
      <h3>相關產品</h3>
      <div class="row no-pad">
          <?php foreach ($prds as $key => $value): ?>
            <?php if(count($prds) > 6): ?>
              <?php if($key < 6): ?>
                <div class="col-sm-2 col-xs-4">
                   <div class="proView">
                     <a href="/cart/product_info/<?=$store['cset_code']?>/<?=$value['prd_id']?>" class="view">
                      <div class="centerIMG">
                        <img src="<?=$img_url.'set_'.substr($value['prd_image'], 1)?>" alt=""/>
                      </div>
                      <div class="pName"><?=$value['prd_name']?></div>
                     </a>
                    </div>
                </div>
              <?php endif;?>
              <?php else: ?>
                <?php if($key < count($prds)): ?>
                <div class="col-sm-2 col-xs-4">
                   <div class="proView">
                     <a href="/cart/product_info/<?=$store['cset_code']?>/<?=$value['prd_id']?>" class="view">
                      <div class="centerIMG">
                        <img src="<?=$img_url.'set_'.substr($value['prd_image'], 1)?>" alt=""/>
                      </div>
                      <div class="pName"><?=$value['prd_name']?></div>
                     </a>
                    </div>
                </div>
              <?php endif;?>
              <?php endif;?>

          <?php endforeach;?>
        </div>  
  </section>

    <a href="#top" class="up-btn"><i class="icon-arrow-up5"></i><br>TOP</a>
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
          <a class="icon-facebook3" href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" ></a>
           <a class="icon-googleplus3" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" ></a>
           <a class="icon-twitter3" href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" ></a>
        </div>
        <div class="clear"></div>
     </div>
  </footer>
  

  <script src="/js/cart_process0918.js"></script>
  </body>
</html>