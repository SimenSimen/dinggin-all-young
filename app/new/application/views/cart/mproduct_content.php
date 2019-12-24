<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$prd['prd_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <meta name="viewport" content="width=device-width"> 

  <!--css-->
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    .hr_div { 
      margin: 5px 0 0;
      padding-bottom: 10px;
      border-bottom: 1px solid #e4e4e8;
      border-bottom-width: 1px;
      border-bottom-style: solid;
      border-bottom-color: rgb(228, 228, 232);
      width: 250%;
      position: relative;
      left: -30%;
    }
    .p_title { font-weight: bold; }
    .prd { width: 100%; border-collapse: collapse; }
    .prd tr td { padding: 5px; border: 1px solid #cccccc; }
    .content_td { width: 35%; background-color: #f3f3f3; }
  </style>

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>

  <script type="text/javascript">
    //圖片縮圖
    $(function(){
      $("img").each(function(i){
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var imgW = $(this).width();
        var imgH = $(this).height();
   
        //計算縮放比例
        var w=($(window).width()*91/100)/imgW;
        var h=w;
        var pre=1;
        if(w>h){
          pre=h;
        }else{
          pre=w;
        }
   
        //設定目前的縮放比例
        $(this).width(imgW*pre);
        $(this).height(imgH*pre);
      });
      $(".video_iframe").each(function(i){
        $(this).removeAttr('width');
        $(this).removeAttr('height');
   
        //取得影像實際的長寬
        var imgW = $(this).width();
        var imgH = $(this).height();
   
        //計算縮放比例
        var w=($(window).width()*91/100)/imgW;
        var h=w;
        var pre=1;
        if(w>h){
          pre=h;
        }else{
          pre=w;
        }
   
        //設定目前的縮放比例
        $(this).width(imgW*pre);
        $(this).height(imgH*pre);
      });
    });
  </script>

</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-role="header" data-position="fixed" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$prd_link?>'" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <a onclick="window.location.href='/cart/store/<?=$cset_code?>'" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-theme="a" ><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-home"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <h1><?=$prd['prd_name']?></h1>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <table>

      <!--商品名稱-->
      <tr>
        <td style='font-weight: bold; font-size: 22px;'><?=$prd['prd_name']?></td>
      </tr>

    </table>

    <p></p>
    <?php if ($prd['prd_content'] != ''): ?>
      <p class="p_title"><?=$ProductInfo?></p>
      <p><?=$prd['prd_content']?></p>
    <?php endif; ?>
    
    <?php if (!empty($prd_video_link)): ?>
      <?php foreach ($prd_video_link as $key => $value): ?>
        <p style="font-weight: bold;"><?=$prd_video_name[$key]?></p>
        <p><iframe class='video_iframe' src="<?=$value?>"></iframe></p>
      <?php endforeach; ?>

    <?php endif; ?>

    <div class='hr_div'></div>

    <?php if (!empty($prd_specification_content)): ?>
      <p class="p_title"><?=$ProductSpecifications?></p>
      <table class='prd'>
        <?php foreach ($prd_specification_content as $key => $value): ?>
          <tr>
            <td class='content_td'><?=$prd_specification_name[$key]?></td>
            <td><?=$value?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php else: ?>
      <?=$NoProductSpecifications?>
    <?php endif; ?>

    <div class='hr_div'></div>

    <!--保固範圍-->
    <?php if ($prd['prd_assurance_range'] != '' || $prd['prd_assurance_date'] != ''): ?>
      <p class="p_title"><?=$WarrantyCoverage?></p>
      <table class='prd'>
        <?php if ($prd['prd_assurance_range'] != ''): ?>
          <tr>
            <td class='content_td'><?=$WarrantyCoverage?></td>
            <td><?=$prd['prd_assurance_range']?></td>
          </tr>
        <?php endif; ?>
        <?php if ($prd['prd_assurance_date'] != ''): ?>
          <tr>
            <td class='content_td'><?=$WarrantyPeriod?></td>
            <td><?=$prd['prd_assurance_date']?></td>
          </tr>
        <?php endif; ?>
      </table>
    <?php else: ?>
      <br>
      <?=$WithoutWarranty?>
    <?php endif; ?>

  </div>
  
  <!-- footer -->
  <div data-role="footer" data-position="fixed" data-theme="a" id="ftrMain" name="ftrMain" role="banner">
    <?php if ($prd['prd_active'] == 0): ?>
      <div style="text-align: center;"><button data-theme="b" onlick='add_to_cart(<?=$prd['prd_id']?>)' style="width: 98%; font-size: 18px;"><?=$AddToCart?> <i class="fa fa-shopping-cart"></i></button></div>
    <?php else: ?>
      <h4><?=$Inventory_shortage?></h4>
    <?php endif; ?>
  </div>

</div><!-- page -->

</body>
</html>