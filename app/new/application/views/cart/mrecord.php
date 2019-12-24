<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$OrderTracking?> - <?=$store['cset_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <!--css-->
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    #list { width: 98%; margin: 0px auto; }
    #list tr td { padding-bottom: 10px;  padding-top: 10px; }
  </style>
  <link type="text/css" rel="stylesheet" href="/css/pagination.css">

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>

</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$cart_link?>'" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span></span></a>
    <?php if (!empty($order)): ?>
      <h1><?=$OrderTracking?></h1>
    <?php else: ?>
      <h1><?=$NoOrders?></h1>
    <?php endif; ?>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <?php if (!empty($order)): ?>
      <table id='list'>
          <tr>
              <td colspan="3"><?=$_SignMail?><?=$buyer['by_email']?></div></td>
          </tr>
          <tr>
              <td width="70%"><?=$OrderNum_Click?></td>
              <td width="30%"><?=$PaymentStatus?></td>
          </tr>
          <?php foreach ($page_data as $key => $value): ?>
            <tr>
                <td><a class="record_detail" style="margin-left:0px;" id="rd_<?=$value['id']?>" title="<?=$OpenOrderDetails?>"><?=$value['order_id']?></a></td>
                <td><?=$status[$key]?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="3">
              <div class="pagination" style="position: relative; left: -40px;">
                  <ul>
                      <?=$create_links?>
                  </ul>    
              </div>
            </td>
          </tr>
      </table>

    <?php endif; ?>

  </div>
  
  <!-- footer -->
  <div data-role="footer" data-position="fixed" data-theme="a" id="ftrMain" name="ftrMain" role="banner">
  </div>

  <script type="text/javascript">
    // 開啟訂單狀態變更視窗
    $('.record_detail').click(function(){
        window.open('/cart/record_detail/<?=$cset_code?>/'+$(this).attr('id').substr(3), '<?=$OrderStatus?>', config='height=750,width=800,left=400,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  </script>

</div><!-- page -->
</body>
</html>