<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
  <!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
  <!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
  <!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- seo -->
  <title><?=$store['cset_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- include jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <!-- wookmark -->
  <link rel="stylesheet" href="/css/wookmark/reset.css">
  <link rel="stylesheet" href="/css/wookmark/main.css">
  <link rel="stylesheet" href="/css/wookmark/style.css">
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    .prd_img { max-height: 190px; max-width: 190px; margin: 0px auto; }
    .prd_cname { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 98%; }
    .aa3{
      display: inline-block;
      border: none;
      margin: 0px 0px;
      padding: 6px 14px;
      display: inline;
      font-size:20px;  
      background: #cccccc;
      color: #333333;
      border-radius:3px;
      text-align:center;
      font-family: 'Microsoft Jhenghei';
    }
    .aa3:hover{
      background:#333333;
      color:#B2A171;
      cursor: pointer;
    }
    .clear{clear:both;}
    a { text-decoration: none; }
    #share_btn_div { 
      width: 100%;
    }
    #share_btn_table {
      width: 100%;
      border: 0px;
      text-align: right;
      margin-top: 10px;
      padding-right: 2px;
      padding-bottom: 20px;
    }
	footer{ margin:2em auto; padding:2em 0; font-size:1.2em; line-height:1.5em;} 
	.ff { text-align:center; padding:0 !important; }
	.ff li{ list-style:none; display:inline-block; margin:0 10px;  }
	.fb, .twitter, .gg{ display:inline-block; margin:1em; padding:.5em; border-radius: 2px;	 -o-border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px; }
	.fb img, .twitter img, .gg img{ width:26px; height:auto;  }
	.fb{ background:#3B5998; }
	.twitter{ background:#48C7F1; }
	.gg{ background:#E47365; }
  </style>
</head>

<body>

  <div id="container" style="min-height:300px">
    
    <header>
      <h1>
      <?php if (!empty($prdc)): ?>
        <?=$store['cset_name']?>
        <a style="display: inline-block;" href="<?=$iqr_url?>" ><img style="width: 30px; top: -3px; position: relative;" src="/images/cart/cart_home.png" title="回首頁"></a>
        <a style="display: inline-block;" href="/cart/search_engine/<?=$store['cset_code']?>" ><img style="width: 30px; top: -3px; position: relative;" src="/images/cart/cart_search.png" title="查詢"></a>
        <a id="cart_link" title="購物明細" style="display: inline-block;" href="/cart/check/<?=$cset_code?>/1" data-content="<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>0</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>0</span>元(TWD)</span>" data-placement="bottom" data-trigger="hover"><img style="width:30px; top: -3px;position: relative;" src="/images/cart/cart.png"></a>  
        <?php if ($user_login): ?>
          <a style="display: inline-block;" href="/cart/record/<?=$cset_code?>" ><img style="width: 30px; top: -3px;position: relative;" src="/images/cart/cart_record.png" title="訂單查詢"></a>
          <a style="display: inline-block;" href="/cart/user_logout/<?=$cset_code?>" ><img style="width: 30px; top: -3px;position: relative;" src="/images/cart/cart_logout.png" title="登出"></a>
        <?php else: ?>
          <a style="display: inline-block;" href="/cart/user_login/<?=$cset_code?>" ><img style="width: 30px; top: -3px;position: relative;" src="/images/cart/cart_login.png" title="登入"></a>
        <?php endif; ?>
      <?php else: ?>
        <?=$store['cset_name']?>
        <a style="display: inline-block;" href="<?=$iqr_url?>" ><img style="width: 30px; top: -3px; position: relative;" src="/images/cart/cart_home.png" title="回首頁"></a>
        <a style="display: inline-block;" href="/cart/search_engine/<?=$store['cset_code']?>" ><img style="width: 30px; top: -3px; position: relative;" src="/images/cart/cart_search.png" title="查詢"></a>
        <a id="cart_link" title="購物明細" style="display: inline-block;" href="/cart/check/<?=$cset_code?>/1" data-content="<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>0</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>0</span>元(TWD)</span>" data-placement="bottom" data-trigger="hover"><img style="width:30px; top: -3px;position: relative;" src="/images/cart/cart.png"></a>
        <a style="display: inline-block;" href="/cart/record/<?=$cset_code?>" ><img style="width: 30px; top: -3px; position: relative;" src="/images/cart/cart_record.png" title="訂單查詢"></a>
        <?php if ($user_login): ?>
          <a style="display: inline-block;" href="/cart/user_logout/<?=$cset_code?>" ><img style="width: 30px; top: -3px;position: relative;" src="/images/cart/cart_logout.png" title="登出"></a>
        <?php else: ?>
          <a style="display: inline-block;" href="/cart/user_login/<?=$cset_code?>" ><img style="width: 30px; top: -3px;position: relative;" src="/images/cart/cart_login.png" title="登入"></a>
        <?php endif; ?>
      <?php endif; ?>
      </h1>
    </header>

    <!--
      These are our filter options. The "data-filter" classes are used to identify which
      grid items to show.
      -->
    <br/>

    <?php if (!empty($prdc)): ?>
      <ol id="filters" style="margin-left: 50px; margin: 0px auto;">
        <li data-filter="all" style="width: 20%;">All</li>
        <?php foreach ($prdc as $key => $value): ?>
          <li data-filter="filter_<?=$key?>" style="width: 20%;" title='<?=$value['prd_cname']?>'><div class='prd_cname'><?=$value['prd_cname']?></div></li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>
    <div class="clear"></div>
    <br/>

    <div id="main" role="main">

      <ul id="tiles">

        <!--
          These are our grid items. Notice how each one has classes assigned that
          are used for filtering. The classes match the "data-filter" properties above.
          -->
          <?php if (!empty($prdc)): ?>
            <?php foreach ($prdc as $key => $value): ?>
              <?php if (!empty($prd[$value['prd_cid']])): ?>
                <?php foreach ($prd[$value['prd_cid']] as $sub_key => $sub_value): ?>
                  <li class='prd_info' id='prd_info_<?=$sub_value['prd_id']?>' data-filter-class='["filter_<?=$key?>", "products"]' title='<?=$sub_value['prd_name']?>'>
                    <div style='padding: 4px 8px 4px 8px;'><?=$sub_value['prd_name']?></div>
                    <img class="prd_img" src="<?=$img_url.'set_'.substr($sub_value['prd_image'], 1)?>">
                    <p style="font-weight:bold; color: #ff6600;"><?=$sub_value['prd_price00']?>元</p>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif;?>

          <?php if($product_cid != 0 && $product_cid !=''): ?>
            <script type="text/javascript">
              window.location.href='/cart/store/<?=$cset_code?>';
            </script>
          <?php endif;?>
                
        <!-- End of grid blocks -->

      </ul>

    </div>
    
    
    
    
    
    

  </div>
  
  <div class="clear"></div>
  <footer>
     
     <ul class="ff">
     <?php if($iqr_cart['cset_company'] != ''): ?>
     	<li><?=$iqr_cart['cset_company']?></li>
     <?php endif;?>
     <?php if($iqr_cart['cset_address'] != ''):?>
       <li><?=$iqr_cart['cset_address']?></li> 
   <?php endif;?>
     </ul>
     
     <ul class="ff">
    <?php if($iqr_cart['cset_telphone'] != ''): ?>
       <li><a href="tel:<?=$iqr_cart['cset_telphone']?>"><?=$iqr_cart['cset_telphone']?></a></li>
    <?php endif; ?>
    <?php if($iqr_cart['cset_mobile'] != ''): ?>
       <li><a href="tel:<?=$iqr_cart['cset_mobile']?>"><?=$iqr_cart['cset_mobile']?></a></li>
    <?php endif; ?>
    <?php if($iqr_cart['cset_email'] != ''): ?>
     	<li><a href="mailto:<?=$iqr_cart['cset_email']?>"><?=$iqr_cart['cset_email']?></a></li>   
    <?php endif; ?>
     </ul>
     
     <div class="clear"></div>
     <div>
        <a class="fb" href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));" ><img src="/images/fb.png"></a>
        <a class="twitter" href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" ><img src="/images/twitter.png"></a>
        <a class="gg" href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" ><img src="/images/gg.png"></a>     
     </div>

  </footer>

  <!-- wookmark -->
  <script src="/js/wookmark/jquery.imagesloaded.js"></script>
  <script src="/js/wookmark/jquery.wookmark.min.js"></script>

  <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
    $(function(){

      var prd_info=$('.prd_info');
      prd_info.each(function()
      {
        $(this).click(function()
        {
          window.location.href='/cart/product_info/<?=$cset_code?>/'+($(this).attr('id').substr(9));
        });
      });
    });

    (function ($){
      var $tiles = $('#tiles'),
          $handler = $('li', $tiles),
          $main = $('#main'),
          $window = $(window),
          $document = $(document),
          options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $('#main'), // Optional, used for some extra CSS styling
            offset: 2, // Optional, the distance between grid items
            itemWidth: 210, // Optional, the width of a grid item
            itemHeight: 210, // Optional, the width of a grid item
            fillEmptySpace: true // Optional, fill the bottom of each column with widths of flexible height
          };
      $tiles.imagesLoaded(function() {

        // Get a reference to your grid items.
        var handler = $('#tiles li'),
            filters = $('#filters li');

        // Call the layout function.
        handler.wookmark(options);

        /**
         * When a filter is clicked, toggle it's active state and refresh.
         */
        function onClickFilter(e) {
          var $item = $(e.currentTarget),
              activeFilters = [],
              filterType = $item.data('filter');

          if (filterType === 'all') {
            filters.removeClass('active');
          } else {
            $item.toggleClass('active');

            // Collect active filter strings
            filters.filter('.active').each(function() {
              activeFilters.push($(this).data('filter'));
            });
          }

          handler.wookmarkInstance.filter(activeFilters, 'or');
        }

        /**
         * Reinitializes the wookmark handler after all images have loaded
         */
        function applyLayout() {
          $tiles.imagesLoaded(function() {
            // Destroy the old handler
            if ($handler.wookmarkInstance) {
              $handler.wookmarkInstance.clear();
            }

            // Create a new layout handler.
            $handler = $('li', $tiles);
            $handler.wookmark(options);
          });
        }

        // Capture filter click events.
        $('#filters').on('click.wookmark-filter', 'li', onClickFilter);
      });
    })(jQuery);
  </script>

</body>
</html>
