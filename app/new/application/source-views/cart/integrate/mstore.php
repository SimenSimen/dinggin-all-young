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
  <title><?=$store['cset_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
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
  </style>
</head>

<body>

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$iqr_url?>'" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span></span></a>
    <h1 style="font-size: 15px; font-weight: bold;">
      <?php if (!empty($prdc)): ?>
        <?=$store['cset_name']?>
      <?php else: ?>
        All<!-- 目前此商店無任何商品資訊 -->
      <?php endif; ?>
    </h1>
    <a onclick="window.location.href='/cart/check/<?=$cset_code?>/1'" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-theme="a" style='float: right;position: absolute;right: 50px;'><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-shopping-cart"></i></span></span></a>
    <a style="display: inline-block;" onclick="window.location.href='/cart/mobile_switch/<?=$cset_code?>'" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-cog"></i></span></span></a>
  </div>

  <div id="container" role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <?php if ($share_bar_hidden): ?>
    <table id='share_btn_table'>
      <tr>
          <td>
              <!-- fb -->
              <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                  <img class='share' id='fb' title="分享到臉書" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
              </a>
          </td>
          <td>
              <!-- weibo -->
              <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
                  <img class='share' id='weibo' title="分享到微博" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
              </a>
          </td>
          <td>
              <!-- googleplus -->
              <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                  <img class='share' id='google' title="分享到Google+" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
              </a>
          </td>
          <td>
              <!-- plurk -->
              <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
                  <img class='share' id='plurk' title="分享到Plurk" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
              </a>
          </td>
          <td>
              <!-- twitter -->
              <a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
                  <img class='share' id='twitter' title="分享到Twitter" src="<?=$base_url?>/images/share_btn/twitter_35x35.png" />
              </a>
          </td>
          <td>
              <a href="http://line.naver.jp/R/msg/text/?<?=$store['cset_name']?>%0D%0A<?=$actual_link?>" rel="nofollow" ><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
          </td>
          <td>
              <!-- Email -->
              <a href="mailto:?subject=<?=$header_title?>&body=<?=$store['cset_name']?>網址：<br><?=$actual_link?>">
                  <img class='share' id='email' title="使用Email告訴朋友" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
              </a>
          </td>
      </tr>

    </table>
    <?php endif; ?>

    <!--
      These are our filter options. The "data-filter" classes are used to identify which
      grid items to show.
      -->
    <br/>
    <!-- <p align="center">分類切換時若按鈕顏色卡住，請點選空白處</p> -->
    <?php if (!empty($prdc)): ?>
      <ol id="filters" style="padding: 0px 0px 0px 25px;">
        <li data-filter="all" style="width: 43%;">All</li>
        <?php foreach ($prdc as $key => $value): ?>
          <li data-filter="filter_<?=$key?>" style="width: 43%;" title='<?=$value['prd_cname']?>'><div class='prd_cname'><?=$value['prd_cname']?></div></li>
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
                    <img class="prd_img" src="<?=$img_url.$sub_value['prd_image']?>">
                    <p style="font-weight:bold; color: #ff6600;"><?=$sub_value['prd_price00']?>元</p>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif;?>

          <?php if($product_cid != 0 && $product_cid !=''): ?>
            <?php foreach ($prd as $sub_key => $sub_value): ?>
              <li class='prd_info' id='prd_info_<?=$sub_value['prd_id']?>' data-filter-class='["filter_<?=$key?>", "products"]' title='<?=$sub_value['prd_name']?>'>
                <div style='padding: 4px 8px 4px 8px;'><?=$sub_value['prd_name']?></div>
                <img class="prd_img" src="<?=$img_url.$sub_value['prd_image']?>">
                <p style="font-weight:bold; color: #ff6600;"><?=$sub_value['prd_price00']?>元</p>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>

        
        <!-- End of grid blocks -->

      </ul>

    </div>

  <!-- This jsPlugin of Filter © jQuery Wookmark -->
  <!-- footer -->
</div><!-- page -->

  <div data-role="footer" class="ui-header ui-bar-b" data-theme="b" id="ftrMain" name="ftrMain" role="banner"><h4 style="font-size: 15px; font-weight: bold;"></h4></div>

  <!-- wookmark -->
  <script src="/js/wookmark/jquery.imagesloaded.js"></script>
  <script src="/js/wookmark/jquery.wookmark.min.js"></script>

  <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
    $(function(){

      $('#share_btn_table').css('width', '98%');
      $('#share_btn_table').css('border', '0px');
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('margin', '0px auto');
      $('#share_btn_table').css('margin-top', '10px');
      $('#share_btn_table').css('padding-right', '2px');
      $('#share_btn_table').css('padding-bottom', '20px');

      var prd_info=$('.prd_info');
      prd_info.each(function()
      {
        $(this).click(function()
        {
          window.location.href='/cart/product_info/<?=$cset_code?>/'+($(this).attr('id').substr(9))+'';
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
