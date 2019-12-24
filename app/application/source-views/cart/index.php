<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$ShoppingCart?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  <link type="text/css" rel="stylesheet" href="/css/cart.css">
  <link type="text/css" rel="stylesheet" href="/css/management_search.css">  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- js -->
  <!--<script type="text/javascript" src="/js/pageguide.js"></script>-->
  <script type="text/javascript" src="/js/json2html.js"></script>
  <script type="text/javascript" src="/js/jquery.json2html.js"></script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
 
  <p style="font-size:20px;"><?=$CartProductManagement?>
    <a href="#" class="why">?</a>
    <a href='/cart/store/<?=$setting['cset_code']?>' target='_blank' class="aa5" style="font-size:20px; margin-left: 0px; padding: 9px 10px;">前往行動商店 <i class="fa fa-external-link"></i></a>&nbsp;
    <!-- <input type="text" class="form-control" placeholder="搜尋商品" /><i class="fa fa-search"></i> -->
    <div class='prompt-box'>
      <p><?=$InterfaceDescription?></p>
      <p><?=$ClassificationEmptied_1?></p>
      <p><?=$SettingProduct_2?></p>
      <p><?=$BatchProcessing_3?></p>
      <p><?=$HotProducts_4?></p>
      <p><?=$Search_5?></p>
    </div>
  </p>
  <br>
  
  <!--主介面區-->
  <table id='cart_table'>
    <tr>

      <!-- product_class -->
      <td style="word-break:break-all; width: 20%;" valign="top">

        <div style="overflow: hidden;">

          <div style="overflow: scroll; overflow-x:hidden; height: 500px; width: 228px;">

              <!--商品清單-->
            <?php if (count($prd_c) > 0): ?><a href='<?=$base_url?>cart/product_add' onclick="window.open(this.href, '', config='height=650,width=1000,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1'); return false;" class='link aa5'><?=$NewProduct?> <i class="fa fa-plus"></i></a>
            <?php if ($prd_num != 0): ?><a href='/cart/product_del' class="link aa5"><?=$RemoveCommodity?> <i class="fa fa-times"></i></a><?php endif; ?>
            <a href="/cart/product_hot_sort" class="link aa5">熱銷品排序 <i class="fa fa-bars"></i></a>
              <hr>
            <?php endif; ?>
            <!--商品分類清單-->
            <?php if ($allow_add == 1): ?>
              <a href='<?=$base_url?>cart/class_add' onclick="window.open(this.href, '', config='height=250,width=500,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1'); return false;" class='link aa5'><?=$NewProductClass?> <i class="fa fa-plus"></i></a>
            <?php else: ?>
              <a class='link aa5' id='class_limit'><?=$ClassNumUpperLimit?></a>
            <?php endif; ?>

            <hr>

            <?php if (!empty($prd_c)): ?>

              <table>

              <?php foreach ($prd_c as $key => $value): ?>
                <tr>
                  <td align="left" valign="middle">

                      <div class='link aa5 cus_link' id='prd_cid_<?=$value['prd_cid']?>' title='<?=$value['prd_cname']?>&nbsp;(<?=$prdc_num[$key]?>)'>
                        <?=$value['prd_cname']?>&nbsp;(<?=$prdc_num[$key]?>)
                      </div>

                  </td>
                </tr>
                <?php endforeach; ?>
              </table>

              <?php endif; ?>

              <!-- <span class="link aa5 cus_link" id='prd_cid_no_class' title='未分類'>未分類&nbsp;(<?=$prdc_num['no_class']?>)</span> -->
              
              

              <?php //if (!empty($prd)): ?>
              <!-- <table>
                <?php foreach ($prd as $key => $value): ?>
                  <tr>
                    <td align="left" valign="middle">
                      <div class='link prd' id='d_<?=$value['prd_id']?>' title='<?=$value['prd_name']?>&nbsp;(<?=$value['prd_amount']?>)'><?=$value['prd_name']?>&nbsp;(<?=$value['prd_amount']?>)</div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table> -->
              <?php //endif; ?>


          </div>

        </div>

      </td>

      <!-- content -->
      <td id='content' style="word-break:break-all;" valign="top">
        <div style="overflow: hidden;">
          <div style="overflow: scroll; overflow-x:hidden; height: 500px;">
          <!--內容顯示區-->
          <div class='content_list' id='content_list'>
            <ul id='content_ul'>
              <div style="height: 60px;"><img style="vertical-align: middle; padding-right: 10px;" src="/tem/img/notice2.png"><span><?=$PleaseSetHotProduct?></span></div>
              <div style="padding: 3px; margin: 0 auto;"><?=$_Product_Search?>
              <form id="cart_list" method="post" action="/cart/cart_list">
              <div class="cart_search">
                <li class="ui-state-default">
                  <input style="padding: 5px; font-size: 0.8em; width: 60%;" type="text" id="key_searching" name="key_searching" placeholder="<?=$ScanProductName?>">
                  <select name="selector" style="width: auto; font-size: 0.8em; padding: 5px;">
                    <option value="*">All</option>
                    <?php foreach ($prd_c as $key => $value):?>
                      <option value="<?=$value['prd_cid']?>"><?=$value['prd_cname']?></option>
                    <?php endforeach; ?>
                  </select>
                  <a class="search_btn" style="cursor: pointer; display: inline-block;">
                    <img style="width: 30px; vertical-align: middle;" src="/images/cart/cart_search.png" title="<?=$Inquire?>">
                  </a>

                <script>
                  $(function() {
                      $('.search_btn').click(function() {
                          if ($('#key_searching').val() != '') {
                              $('#cart_list').submit();
                          } else {
                              alert('<?=$ScanSearchProduct?>');
                          }
                      });
                  });
                </script>
                </li>
              </div>
              </form>
              </div>
            </ul>
          </div>
          <!--原始顯示區結束-->
          </div>
        </div>
      </td>

    </tr>
  </table>
  <!--主介面區結束-->

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

<!--bottom script-->
<span class='hidden_text' id='mid'><?=$member_id?></span>
<span class='hidden_text' id='img_url'><?=$img_url?></span>
<script type="text/javascript" src="/js/cart_management.js"></script>



</body>
</html>
