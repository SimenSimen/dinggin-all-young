<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
  <!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
  <!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
  <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- seo -->
  <title><?=$theme['cart_display_name']?></title>
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
  </style>
</head>

<body>

  <div id="container">
    
    <header>
      <h1>
      	行動商店
        <a id="cart_link" title="購物明細" style="display: inline-block;" href="javascript:void(0);" data-content="<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>0</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>0</span>元(TWD)</span>" data-placement="bottom" data-trigger="hover"><img style="width:50px;" src="/images/cart.png"></a>
        <a style="display: inline-block;" href="javascript:void(0);" ><img style="width: 47px;position: relative;top: -3px;" src="/images/cart_record.png" title="訂單查詢"></a>
          <a style="display: inline-block;" href="javascript:void(0);" ><img style="width: 47px;position: relative;top: -3px;" src="/images/cart_logout.png" title="登出"></a>
      </h1>
    </header>

    <!--
      These are our filter options. The "data-filter" classes are used to identify which
      grid items to show.
      -->
    <br/>

      <ol id="filters" style="margin-left: 50px; margin: 0px auto;">
        <li style="width: 20%;">All</li>
          <li style="width: 20%;" title='A類'><div class='prd_cname'>A類</div></li>
          <li style="width: 20%;" title='B類'><div class='prd_cname'>B類</div></li>
          <li style="width: 20%;" title='C類'><div class='prd_cname'>C類</div></li>
      </ol>
    <div class="clear"></div>
    <br/>

    <div id="main" role="main">

      <ul id="tiles">

        <!--
          These are our grid items. Notice how each one has classes assigned that
          are used for filtering. The classes match the "data-filter" properties above.
          -->
                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-e02.jpg">
                    <p style="font-weight:bold; color: #ff6600;">600元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-a07.jpg">
                    <p style="font-weight:bold; color: #ff6600;">1500元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-a08.jpg">
                    <p style="font-weight:bold; color: #ff6600;">1500元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-a09.jpg">
                    <p style="font-weight:bold; color: #ff6600;">600元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-a150-2.jpg">
                    <p style="font-weight:bold; color: #ff6600;">1500元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-c01.jpg">
                    <p style="font-weight:bold; color: #ff6600;">1500元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-d06.jpg">
                    <p style="font-weight:bold; color: #ff6600;">1250元</p>
                  </li>

                  <li class='prd_info' title='Item Name'>
                    <div style='padding: 4px 8px 4px 8px;'>Item Name</div>
                    <img class="prd_img" src="/images/integrate/cart_thumb/style_view/p-e03.jpg">
                    <p style="font-weight:bold; color: #ff6600;">2500元</p>
                  </li>

                
        <!-- End of grid blocks-->

      </ul>

    </div>

  </div>

  <!-- wookmark -->
  <script src="/js/wookmark/jquery.imagesloaded.js"></script>
  <script src="/js/wookmark/jquery.wookmark.min.js"></script>

  <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
    // $(function(){

    //   var prd_info=$('.prd_info');
    //   prd_info.each(function()
    //   {
    //     $(this).click(function()
    //     {
    //       window.location.href='/cart/product_info/<?=$cset_code?>/'+($(this).attr('id').substr(9));
    //     });
    //   });
    // });

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
        // function onClickFilter(e) {
        //   var $item = $(e.currentTarget),
        //       activeFilters = [],
        //       filterType = $item.data('filter');

        //   if (filterType === 'all') {
        //     filters.removeClass('active');
        //   } else {
        //     $item.toggleClass('active');

        //     // Collect active filter strings
        //     filters.filter('.active').each(function() {
        //       activeFilters.push($(this).data('filter'));
        //     });
        //   }

        //   handler.wookmarkInstance.filter(activeFilters, 'or');
        // }

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
