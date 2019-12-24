<!doctype html>
<html>
<head>
  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">
  <!-- seo -->
   <title>行動名片系統</title>  
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
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
  <link rel="stylesheet" type="text/css" href="/css/product_hot_sort.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
</head>
<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
<left>
<div id="container"><div class="_width">
   <p style="font-size:20px;">優選好物<?=(!empty($prd_cname))?'('.$prd_cname.')':'';?>排序    
    <a href="#" class="why">?</a>
    <div class='prompt-box'>
      <p>請拖拉您要排序的商品，然後點選「儲存」</p>
      <p>1.此處優選好物，不論「上架」、「下架」均會做顯示，故會導致優選好物總數量與顯示數量不相符。</p>
      <p>2.紅色字體為已下架。</p>
      <p>3.選擇分類後才可進行排序。</p>
    </div>
  </p>
  <br><?=$memo;?>
  <form action='/products/products_type_sort' method='post' name='form_product_hot_order' id='form_product_hot_order'>
    <p style="width: 100%; border-radius: 5px; margin-left: 4px; vertical-align: middle;">
      <select name="prd_cid" id="prd_cid">
        <option value="0">請選擇</option>
        <?foreach ($protype as $pvalue):?>
          <option value="<?=$pvalue['prd_cid']?>" <?=($prd_cid==$pvalue['prd_cid'])?'selected':'';?>><?=stripslashes($pvalue['prd_cname'])?></option>
        <? endforeach;?>
      </select>
    </p>
      <div id='p_sub_cid'>
       <?if (!empty($protype_sub)){?>
        <p style="width: 100%; border-radius: 5px; margin-left: 4px; vertical-align: middle;">
        <select name="prd_cid" id="prd_sub_cid">
          <?foreach ($protype_sub as $pvalue_sub):?>
            <option value="<?=$pvalue_sub['prd_cid']?>" <?=($prd_sub_cid==$pvalue_sub['prd_cid'])?'selected':'';?>><?=stripslashes($pvalue_sub['prd_cname'])?></option>
          <? endforeach;?>
        </select>
        </p>
       <?}?>
      </div>
    <input class="aa2" type="submit" value="選擇分類">
  </form>
  <!--主介面區-->  
  <form action='/products/products_type_sort' method='post' name='form_product_hot_order' id='form_product_hot_order'>

  <input style="background: #CCC; color: black;" class="aa3" type="button" value="返回商品資料維護" onclick="location.href='/products/products_list'">
  <input class="aa3" type="submit" value="儲存編輯"  <?=(empty($prd_cname))?' style="display:none;"':''?>>

    <div <?=(empty($prd_cname))?'':' id="sortable"'?>>
      <?php foreach ($dbdata as $key => $value): ?>
        <div class="prd_box">
          <input type="hidden" name="sort[]" value="<?=$value['prd_id']?>">
          <div <?=($value['prd_active']=='2')?' style="color:red;"':'';?> class="prd_title" title="<?=$value['prd_name']?>"> <?=($value['prd_active']=='2')?' <del>':'';?><?=stripslashes($value['prd_name'])?><?=($value['prd_active']=='2')?' </del>':'';?></div>
          <div class="prd_img"><img class="prd_imgSize" src="<?=$value['prd_image']?>"></div>
          <span <?=($value['prd_active']=='2')?' style="color:red;"':'';?>><?=$value['prd_price00']?>元</span>
        </div>
      <?php endforeach; ?>
    </div>
  </form>
  優選好物<?=(!empty($prd_cname))?'('.$prd_cname.')':'';?>筆數 (<?=$hot_num?>)
  <!--主介面區結束-->
  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  
  </div><!--the end of w1024(container) -->
</div><!--the end of container -->
<!--bottom script-->
<script type="text/javascript" src="/js/product_hot_sort.js"></script>
<script type="text/javascript">  
$(document).on('change', '#prd_cid', function(){
  var prd_cid = $('#prd_cid :selected').val();//注意:selected前面有個空格！
  var prd_sub_cid = '<?=$prd_sub_cid?>';
    $.ajax({
        url:"/products/ajax_product",
        method:"POST",
        data:{
           prd_cid:prd_cid,
           prd_sub_cid:prd_sub_cid
        },
        success:function(data){
          $('#p_sub_cid').html('<p style="width: 100%; border-radius: 5px; margin-left: 4px; vertical-align: middle;">'+data+'</p>');
        }
     });//end ajax
});
</script>
</body>
</html>