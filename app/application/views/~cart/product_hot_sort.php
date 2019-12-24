<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>熱銷品排序 - <?=$web_config['title']?></title>
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
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <link rel="stylesheet" type="text/css" href="/css/product_hot_sort.css">
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="_width">
 
  <p style="font-size:20px;"><?=$HotProudectsSort?>
    <a href="#" class="why">?</a>
    <a href='/cart/cart_management' target='_top' class="aa5" style="font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$Back_to_product?> <i class="fa fa-reply"></i></a>&nbsp;
    <div class='prompt-box'>
      <p><?=$Interface_Description?></p>
    </div>
  </p>
  <br>
  <!--主介面區-->
  <form action='/cart/product_hot_sort' method='post' name='form_product_hot_order' id='form_product_hot_order'>
  <p style="width: 100%; text-align: right; border-radius: 5px; margin-left: 4px; vertical-align: middle;">
    <input style="background: #CCC; color: black;" class="aa3" type="button" value="<?=$Selling_product_items?> (<?=$hot_num?>)">
    <input class="aa3" type="submit" value="<?=$Save_Edits?>">
  </p>
    <div id="sortable">
      <?php foreach ($prd as $key => $value): ?>
        <div class="prd_box">
          <input type="hidden" name="sort[]" value="<?=$value['prd_id']?>">
          <div class="prd_title" title="<?=$value['prd_name']?>"><?=$value['prd_name']?></div>
          <div class="prd_img"><img class="prd_imgSize" src="<?=$img_url?>products/<?=$value['prd_image']?>"></div>
          <span><?=$value['prd_price00']?><?=$Total_Yuan?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </form>
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
<script type="text/javascript" src="/js/product_hot_sort.js"></script>
</body>
</html>
