<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$ouput_Order_inquiries_export?> - <?=$web_config['title']?></title>
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
  <link rel="stylesheet" href="/css/pageguide/edit_integrate.css">
  <link rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/global.css" media="screen">
  <link rel="stylesheet" href="/css/cart.css">
  <link rel="stylesheet" href="/css/pagination.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  
  <!-- style & JS -->
  <script src="/js/generator/order.js"></script>
  <link rel="stylesheet" href="/css/generator/order.css">

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container">
  <div class="w1024" style="width:90%;">
  <form action='/generator/order' method='post' name='form_export_order' id='form_export_order'>
      <?php if ($data_array_show === 1): ?>
        <input type="hidden" id="export_url" value="/generator/export">
        <a id='exprot_All_order' target='_blank'  class="aa5" style="float: right; font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$ouput_Total_Export_Report?> <i class="fa fa-cloud-download"></i></a>&nbsp;
      <?php elseif ($data_array_show === 2): ?>
      	<input type="hidden" id="export_url" value="/generator/export_order_xls">
      	<a id='exprot_order' target='_blank'  class="aa5" style="float: right; font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$ouput_Export_Report?> <i class="fa fa-cloud-download"></i></a>&nbsp;
      <?php endif; ?>
    <!-- </p> -->
    <br>
  <!--搜尋介面區-->
    <table border="0" cellspacing="0" cellpadding="0" style="width: 70%;">
      <tr>
        <th><?=$ouput_Order_Date?></th>
        <td>
          <input type="date" name="start_date" value="<?=$post['start_date']?>" required> - 
          <input type="date" name="end_date" value="<?=$post['end_date']?>" required>
        </td>

        <th><?=$ouput_product_name?></th>
        <td><input type="text" name="prd_name" autocomplete="off" value="<?=$post['prd_name']?>"></td>
        
        <th><?=$ouput_Purchaser_mail_box?></th>
        <td><input type="text" name="email" autocomplete="off" value="<?=$post['email']?>"></td>

        <th><?=$ouput_Telephone_Order?></th>
        <td><input type="text" name="phone" autocomplete="off" value="<?=$post['phone']?>"></td>
      </tr>
      <tr>
        <th><?=$ouput_Order_Status?></th>
        <td>
          <select name="product_flow">
            <option value=""><?=$ouput_Any?></option>
            <option value="0" <?php if($post['product_flow'] == '0'):?>selected<?php endif; ?>><?=$ouput_new_order?></option>
            <option value="1" <?php if($post['product_flow'] == '1'):?>selected<?php endif; ?>><?=$ouput_Processing?></option>
            <option value="2" <?php if($post['product_flow'] == '2'):?>selected<?php endif; ?>><?=$ouput_Shipped?></option>
            <option value="3" <?php if($post['product_flow'] == '3'):?>selected<?php endif; ?>><?=$ouput_cancel_order?></option>
            <option value="4" <?php if($post['product_flow'] == '4'):?>selected<?php endif; ?>><?=$ouput_Transaction_complete?></option>
            <option value="5" <?php if($post['product_flow'] == '5'):?>selected<?php endif; ?>><?=$ouput_Return?></option>
            <option value="6" <?php if($post['product_flow'] == '6'):?>selected<?php endif; ?>><?=$ouput_Replacement?></option>
          </select>
        </td>
        
        <th><?=$ouput_payment_method?></th>
        <td>
          <select name="pay_way_id">
            <option value="" <?php if($post['pay_way_id'] == ''):?>selected<?php endif; ?>><?=$ouput_Any?></option>
        <?php if($payment_way) :?>
          <?php foreach($payment_way as $key => $value) : ?>
            <option value="<?=$value['pway_id']?>" <?php if($post['pay_way_id'] == $value['pway_id']):?>selected<?php endif; ?>><?=$value['pway_name']?></option>
          <?php endforeach; ?>
        <?php endif; ?>
          </select>
        </td>

        <th><?=$ouput_Payment_status?></th>
        <td>
          <select name="status">
            <option value="" <?php if($post['status'] == ''):?>selected<?php endif; ?>><?=$ouput_Any?></option>
            <option value="0"<?php if($post['status'] == '0'):?>selected<?php endif; ?>><?=$ouput_Unpaid?></option>
            <option value="1"<?php if($post['status'] == '1'):?>selected<?php endif; ?>><?=$ouput_Already_paid?></option>
            <option value="2"<?php if($post['status'] == '2'):?>selected<?php endif; ?>><?=$ouput_Refund?></option>
          </select>
        </td>

        <td>
          <input type="hidden" name="member_id" value="<?=$mid?>">
          <input type="submit" name="export_btn" value="<?=$ouput_Inquire?>">
        </td>
      </tr>
    </table>
  </form>
  <!--搜尋介面區結束-->

  <?php if($data_array_show === 1): ?>
  	<div class="t-div"></div>
  <?php elseif ($data_array_show === 2): ?>
    <div class="t-div">
    <table id="order_table">
      <tr>
      <?php foreach ($title_array as $key => $value): ?>
        <td class='title_td' style="width: 10%;"><?=$value?></td>
      <?php endforeach; ?>
      </tr>
        <?php foreach ($data_array as $key => $value): ?>
        <tr>
          <td><?=$value['product_flow_name']?></td>
          <td><?=$value['order_id']?></td>
          <td><?=$value['date']?></td>
          <td><?=$value['name']?></td>
          <td style="width:30%;"><?=$value['details']?></td>
          <td><?=$value['total_price']?></td>
          <td><?=$value['status_name']?></td>
          <td><a class="aa5 order_detail" style="margin-left:0px;" id="od_<?=$value['id']?>" title="<?=$ouput_Change_Order_Status?>"><i class="fa fa-pencil-square-o" style=" font-size: 1.3em;"></i></a></td>
        </tr> 
        <?php endforeach; ?>
    </table>
    </div>
  <?php else: ?>
	<div class="t-div R-font"><?=$ouput_No_information?></div>
  <?php endif; ?>
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

<script src="/js/order_management.js"></script>
</body>
</html>
