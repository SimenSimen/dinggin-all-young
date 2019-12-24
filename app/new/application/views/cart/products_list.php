<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$SearchResults?> <?=$web_config['title']?></title>
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
  <script type="text/javascript" src="/js/json2html.js"></script>
  <script type="text/javascript" src="/js/jquery.json2html.js"></script>
  <!-- tablesorter -->
  <script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="/js/tablesorter/jquery.tablesorter.widgets.js"></script>
  <script>
    $(document).ready(function() 
      { 
        $("#search-result").tablesorter(); 
        $("#search-result").tablesorter( {sortList: [[0,0], [1,0]]} ); 
      } 
    ); 
  </script>
</head>
<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
 
  <p style="font-size:20px;"><?=$StoreMerchandiseInquiry?>
    <!-- <a href="#" class="why">?</a> -->
    <a href='/cart/cart_management' target='_top' class="aa5" style="font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$ReturnsProductManagement?> <i class="fa fa-reply"></i></a>&nbsp;
    <!-- <div class='prompt-box'> -->
      <!-- <p>請勾選您要刪除的商品，然後點選「移除勾選商品」</p> -->
    </div>
  </p>
  <br>
  
  <!--主介面區-->
  <table id="search-result" class="tablesorter searchPPP" style="border:0px solid; text-align: center; width: 90%; margin:10px auto; ">
   <thead>
    <tr style="background:#e3e3e3;">
    <th><?=$ProductName?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$Categories?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$ProductPopularity?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$CommodityStocks?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$ProductPrice?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$ProductStatus?> <a style="color:blue;"><i class="fa fa-sort"></i></a></th>
    <th><?=$ProductPicture?></th>
    <th><?=$Edit?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($prds as $key => $value):?>
      <tr>
        <td><?=$value['prd_name']?></td>
        <td><?=$value['prd_cname']?></td>
        <td><?=$value['count']?> <?=$Secondary?></td>
        <td><?=$value['prd_amount']?></td>
        <td>$<?=$value['prd_price00']?></td>
        <td class="status"><?=$value['prd_active']?></td>
        <td style="height:90px;"><img style="max-width:80px; max-height:80px; width:expression(this.width >70 && this.height <= this.width ? 70:true); height:expression(this.height >70 && this.width <= this.height ? 70:true);" src="<?=$img_url?><?=$value['prd_image']?>"></td>
        <td style="padding:5px;"><a class="aa5" href="/cart/product_edit/<?=$value['prd_id']?>" style="padding:3px;" onclick="window.open(this.href, '', config='height=500,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1'); return false;" title="<?=$EditCommodity?>"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
      </tr>
  <?php endforeach; ?>    
  </tbody>
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
<script>
  $(function(){
    $("#search-result .status").each(function(){
      // alert($(this).html());
      if($(this).html() == '<?=$CommodityShipments?>')
        $(this).css({color:"#FF4500"});
      else if($(this).html() == '<?=$OffShelf?>')
        $(this).css({color:"red"});
    });
  });
</script>
<!--bottom script-->
<span class='hidden_text' id='mid'><?=$member_id?></span>
<span class='hidden_text' id='img_url'><?=$img_url?></span>

</body>
</html>
