<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_OrderManagement?><?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/pagination.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container">
  <div class="w1024" style="width:90%;">
 
  <p style="font-size:20px;"><?=$OrderManagement?>
    <a href="#" class="why">?</a>
    <a href='/cart/store/<?=$setting['cset_code']?>' target='_blank' class="aa5" style="font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$GoStoreAction?> <i class="fa fa-external-link"></i></a>&nbsp;
    <div class='prompt-box'>
      <p><?=$OperatingOrderStatus?></p>
      <p><ul><li><?=$NotPayment_1?><li><?=$Processing_2?><li><?=$Shipped_3?><li><?=$PaymentConfirmation_4?><li><?=$CancelOrder_5?><li><?=$Return_6?></ul></p>
      </div>
  </p>
  <br>
  <!--主介面區-->
  <table style="width: 100%;">
    <tr>
      <!-- content -->
      <td id='content' style="word-break: break-all; width: 100%;" valign="top">
        <div style="height: 500px;">

          <!--內容顯示區-->
          <div class='content_list' id='content_list'>
            <ul id='content_ul'>
              <li class="ui-state-default">
                <?php if (!empty($page_data)): ?>
                  <table id="order_table">
                    <tr>
                      <td class='title_td' style="width: 10%;"><?=$OrderStatus?></td>
                      <td class='title_td' style="width: 17%;"><?=$OrderDate?></td>
                      <td class='title_td' style="width: 14%;"><?=$UsuallyPeople?></td>
                      <td class='title_td' style="width: 22%;"><?=$UsuallyPeopleMail?></td>
                      <td class='title_td' style="width: 10%;"><?=$PaymentMethod?></td>
                      <td class='title_td' style="width: 16%;"><?=$Delivery?></td>
                      <td class='title_td' style="width: 10%;"><?=$PaymentStatus?></td>
                      <td class='title_td' style="width: 5%;"><?=$Operating?></td>
                    </tr>  
                    <?php foreach ($page_data as $key => $value): ?>
                      <tr>
                        <td><?=$product_flow[$key]?></td>
                        <td><?=date('Y-m-d H:i', $value['date'])?></td>
                        <td><?=$value['name']?></td>
                        <td><?=$value['email']?></td>
                        <td><?=$pway_name[$key]?></td>
                        <td><?=$lway_name[$key]?></td>
                        <td><?=$status[$key]?></td>
                        <td>
                          <a class="aa5 order_detail" style="margin-left:0px;" id="od_<?=$value['id']?>" title="<?=$ChangeOrderStatus?>"><i class="fa fa-pencil-square-o" style=" font-size: 1.3em;"></i></a>
                        </td>
                      </tr> 
                    <?php endforeach; ?>
                  </table>

                <?php endif; ?>
              </li>
            </ul>
            <div class="pagination" style="position: relative; left: -40px;">
                <ul>
                    <?=$create_links?>
                </ul>    
            </div>
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

<style type="text/css">
  #order_table { width: 100%; }
  #order_table tr td { text-align: center; border: 1px solid #ddd; padding: 8px 10px 8px 10px; background: #ffffff; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; }
  .aa5 { cursor: pointer; }
</style>
<script src="/js/order_management.js"></script>

</body>
</html>
