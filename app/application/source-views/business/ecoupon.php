<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>好友分享券 - <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/validation.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <style type="text/css">
  #ecoupon_table { width: 80%; margin: 0px auto; }
    #ecoupon_table tr td {
      font-family: '微軟正黑體';
      font-size: 16px;
      text-align: center;
      border: 1px solid #ddd;
      padding: 15px 7px 10px 7px;
      background: #ffffff;
      vertical-align: middle;
    }
    .aa5 { cursor: pointer; }
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <div id="con-L" style="width: 100%; height: 850px;">


    <div class="step-docUP-1" style="height: 800px;">
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">好友分享券&nbsp;<input type='button' class='aa2' id='coupon_add' value='+ 新增'></p>
      
      <div class="imgUPss" style="height: 730px;">

      <!--原始顯示區-->
        <?php if (!empty($ecoupon)): ?>
          <table id='ecoupon_table'>

            <?php foreach ($ecoupon as $key => $value): ?>

                <?php if ($key % 10 == 0): ?>
                  <tr>
                    <td style="width: 10%;">編號</td><!--  align="center" style="width:50px;" -->
                    <td style="width: 30%;">名稱 / 訊息</td>
                    <td style="width: 30%;">分享券</td>
                    <td style="width: 20%;">分享設定</td>
                    <td style="width: 10%;">操作</td>
                  </tr>
                <?php endif; ?>

                <tr>
                  <td align="center"><?=($key+1)?></td>
                  <td><p><?=$value['name']?></p><br><p><?=$value['content']?></p></td>
                  <td><a target="_blank" href='/business/my_ecoupon/<?=$mid?>/<?=$value['ecp_id']?>'><img style="max-width: 250px; max-height: 100px;" src='<?=substr($img_url, 1).$value['filename']?>'></a></td>
                  <td><?=$value['mode_txt']?></td>
                  <td>
                    <a class='qrcode_ecp aa5' style="margin-left:0px;" id='qrcode<?=$value['ecp_id']?>' title='快速連結'><i class="fa fa-qrcode" style=' font-size: 1.3em;'></i></a>
                    <a class='edit_ecp aa5' style="margin-left:0px;" id='edit<?=$value['ecp_id']?>' title='修改'><i class="fa fa-pencil-square-o" style=' font-size: 1.3em;'></i></a>
                    <a class='delete_ecp aa5' style="margin-left:0px;" id='delete<?=$value['ecp_id']?>' title='刪除'><i class="fa fa-times" style=' font-size: 1.3em;'></i></i></a>
                  </td>
                </tr>

            <?php endforeach; ?>
          </table>
        <?php endif; ?>
  
      </div>  <!--imgUPss  結束-->

    </div>  <!--step-docUP-1  結束--> 

  </div>
  
</form>

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

<script type="text/javascript">
  $(function()
  {
    //開啟快速連結
    $('.qrcode_ecp').click(function(){
      window.open('/business/ecoupon_qrcode/'+$(this).attr('id').substr(6), '好友分享券連結', config='height=616,width=420,left=470');
    });
    //開啟新增分享券視窗
    $('#coupon_add').click(function(){
      window.open('/business/ecoupon/add', '新增好友分享券', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
    //開啟編輯分享券視窗
    $('.edit_ecp').click(function(){
      window.open('/business/ecoupon/edit/0/'+$(this).attr('id').substr(4), '編輯報名表單', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
    //刪除分享券
    $('.delete_ecp').click(function(){
      if(confirm('您確定要刪除嗎?'))
      {
        window.location.href = '/business/ecoupon/delete/0/'+$(this).attr('id').substr(6);
      }
    });
  });

</script>

</body>
</html>
