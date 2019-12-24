<html lang="en"><head>
    <meta charset="UTF-8">
    <title>INVOICE</title>
<link rel="stylesheet" type="text/css" href="/css/tax_style.css"></head>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<body style="zoom:90%"> <!--style="zoom: 1;"-->
<div class="container">
<table cellspacing="0" cellpadding="0" border="0" class="table01">
    <thead>
        <tr><td colspan="4">Naturefa Seller Center</td></tr>
    </thead>
    <tbody>
        <tr>
          <td width="20%">公司名稱：</td>
          <td width="30%">Vital Wellspring Education Pte. Ltd.</td>
          <td width="20%">稅號：</td>
          <td width="30%">201706222D</td>
        </tr>
        <tr>
          <td width="20%">電話：</td>
          <td width="30%">+65 84780612</td>
          <td width="20%">地址：</td>
          <td width="30%">55 Market Street #10-05 Singapore 048941</td>
        </tr>
    </tbody>
</table>
<table cellspacing="0" cellpadding="0" border="0" class="table01">
    <thead>
        <tr>
            <td colspan="6">TAX INVOICE</td>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td width="10%">Invice Number：</td>
          <td width="20%"><?=$dbdata['receipt_num'];?></td>
          <td width="10%">Invoice To：</td>
          <td width="20%"><?=$dbdata['receipt_title'];?></td>
          <td width="10%">Invice Date：</td>
          <td width="20%"><?=$dbdata['receipt_date'];?></td>
        </tr>
        <tr>
          <td>Order Number：</td>
          <td><?=$dbdata['order_id'];?></td>
          <td>Order Date：</td>
          <td><?=$dbdata['create_time'];?></td>
          <td></td>
          <td></td>
        </tr>
    </tbody>
</table>


<table cellspacing="0" cellpadding="0" border="0" class="table02">
    <thead>
        <tr>
            <td>BILLING ADDRESS</td>
        </tr>
    </thead>
  <tbody>
    
    <tr>
      <td><?=$dbdata['country'];?> <?=$dbdata['county'];?> <?=$dbdata['area'];?> <?=$dbdata['address'];?></td>
    </tr>
    <tr>
      <td>Phone Number：<?=$dbdata['phone'];?></td>
    </tr>
  </tbody>
</table>
<table cellspacing="0" cellpadding="0" border="0" class="table02">
    <thead>
        <tr>
            <td>SHIPPING ADDRESS</td>
        </tr>
    </thead>
  <tbody>
    
    <tr>
      <td><?=$dbdata['receipt_address'];?></td>
    </tr>
    <tr>
      <td>Phone Number：<?=$dbdata['phone'];?></td>
    </tr>
  </tbody>
</table>


<table cellspacing="0" cellpadding="0" border="0" class="table03">
<thead>
    <tr>
      <td>Product name</td>
      <td>Price</td>
      <td>Quantity</td>
      <td>Subtotal Price</td>
      <td>Status</td>
    </tr>
    </thead><?=$product_flow[$value['product_flow']];?>
  <tbody>
    <?foreach ($oddata as $key => $value) {?>
     <tr>
        <td align="center"><?=$value['prd_name'];?></td>
        <td align="center"><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
        <td align="center"><?=$value['number'];?></td>
        <td align="center"><?=$this->data['web_config']['currency'];?><?=$value['total_price'];?></td>
        <td align="center"><?=$product_flow[$dbdata['product_flow']];?></td>
      </tr>
    <?}?>
  </tbody>
</table>
<div class="clearfix">
<table border="0" cellpadding="0" cellspacing="0" class="table04">
  <tbody>
    <tr>
      <td>Net Paid：</td>
      <td><?=$this->data['web_config']['currency'];?><?=$dbdata['price_money'];?></td>
    </tr>
    <tr>
      <td>Used Shop Point：</td>
      <td><?=$this->data['web_config']['currency'];?><?=$dbdata['use_dividend'];?></td>
    </tr>
    <tr>
      <td>Earn Shop Point :</td>
      <td><?=$dbdata['bonus'];?></td>
    </tr>
  </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table04">
  <tbody>
    <tr>
      <td>Subtotal（excl GST）：</td>
      <td><?=$this->data['web_config']['currency'];?><?=$dbdata['pay_price'];?></td>
    </tr>
    <tr>
      <td>Shipping（excl GST）：</td>
      <td><?=$this->data['web_config']['currency'];?><?=$dbdata['lway_price'];?></td>
    </tr>
    <tr class="total">
      <td>Total（excl GST）：</td>
      <td><?=$this->data['web_config']['currency'];?><?=($dbdata['total_price']-($dbdata['total_price']*0.07));?></td>
    </tr>
    <tr>
      <td>*GST（7%）</td>
      <td><?=$this->data['web_config']['currency'];?><?=($dbdata['total_price']*0.07);?></td>
    </tr>
    <tr class="total">
      <td>Total（incl GST）：</td>
      <td><?=$this->data['web_config']['currency'];?><?=$dbdata['total_price'];?></td>
    </tr>
</tbody>
</table>
</div>
<div style="text-align:right;"><input type="button" class="btn btn-info btn-large" id="print_action" value="Print"></div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
  $('#print_action').click(function(){
    text=document;
    window.print_action.style.display = "none";    
    print(text);
    window.print_action.style.display = "";
  });
</script>
</body>
</html>