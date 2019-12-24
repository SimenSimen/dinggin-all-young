<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- seo -->
  <title><?=$_CheckoutPage?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <!-- css -->
  <!-- js -->
  <!-- <script src="http://code.jquery.com/jquery-1.10.2.js"></script> -->
  <link rel="stylesheet" href="/css/colors.css">
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript">
    // Global declarations - assignments made in $(document).ready() below
      var hdrMainvar = null;
      var contentMainVar = null;
      var ftrMainVar = null;
      var contentTransitionVar = null;
      var whatVar = null;
      var form1var = null;
      var confirmationVar = null;
      var contentDialogVar = null;
      var contentConfirmationVar = null;
      var inputMapVar = null;
      // Constants
      var MISSING = "missing";
      var EMPTY = "";
      var NO_STATE = "ZZ";
  </script>
</head> 
<body> 
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">
  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$cart_link?>'" data-icon="home" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-home"></i></span></span></a>
    <h1><?=$FillOrderingInformation?></h1>
  </div>
      
  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">
    <form id='form1' action="/cart/check/<?=$cset_code?>/2" method='post' data-ajax='false'>
    <table id='check_table' style="border: 0px; width:100%;">
      <tr>
        <td style="border: 0px;">
          <div class="order_div">
            <div style='float: left;'><h3><?=$ShoppingDetail?></h3></div><br><br>
            <div class="order_list" >
              <ul class="buyList" >
              <?php foreach ($prd as $key => $value): ?>   
              		<li>
                      <a class="buyList-delete del_prd" id='del_prd_<?=$key?>' ><img src='/images/_close.png' title='<?=$RemoveItem?>'></a> 
                      <div class="buyList-L"><a href="/cart/product_info/<?=$cset_code?>/<?=$value['prd_id']?>"><img class="prd_img" src="<?=$img_url?><?=$value['prd_image']?>"></a></div>
                      <div class="buyList-R">
                    	 <a class="buyList-title"><?=$value['prd_name']?></a>      
                       <input type="hidden" id="price<?=$key?>" value="<?=$value['prd_price00']?>">
                        <div class="LLL"><span style="display:inline-block; padding-top:20px;"><?=$Quantity?></span></div>
                        <div class="RRR">
                          <div class="w100">
                            <select id="buy<?=$key?>" name="buy[<?=$key?>]">
                            <?php if($value['prd_lock_amount'] < $value['prd_amount']): ?>
                              <?php for($min[$key]; $min[$key] < ($value['prd_lock_amount']+1)-$snum[$key]; $min[$key]++):?>
                                <option value='<?=$min[$key]?>' select=""><?=$min[$key]?></option>
                              <?php endfor; ?>
                            <?php else: ?>
                              <?php for($min[$key]; $min[$key] < ($value['prd_amount']+1)-$snum[$key]; $min[$key]++):?>
                                <option value='<?=$min[$key]?>' select=""><?=$min[$key]?></option>
                              <?php endfor; ?>
                            <?php endif;?>
                                
                            </select>
                          </div>
                        </div>
                        <div class="clear"></div>
                        <div class="LLL"><?=$Subtotal?></div>
                        <!-- <div class="RRR">$<span id="count[<?=$key?>]"> <?=$prd_total[$key]?></span></div> -->
                        <div class="RRR">$<span id="count<?=$key?>"><?=number_format($prd_total[$key])?></span></div>
                        <div class="clear"></div>
     
                        </div>
                        <div class="clear"></div>
                        <script type='text/javascript'>
                        $(function(){ 
                          $('#buy<?=$key?>').val('<?=$prd_num[$key]?>').selectmenu('refresh');
                          $('#buy<?=$key?>').change(function(){
                            var price = $('#buy<?=$key?>').val() * $('#price<?=$key?>').val();
                            $('#count<?=$key?>').text(price).change();
                          });
                        });
                        </script>   
                  </li>
              <?php endforeach; ?>       
              </ul>
              <div class="price_info_div">
                <p>
                  <span class="item"><?=$Altogether?></span>
                  <span class="item_num"><?=$user_cart_num?></span>
                  <span class="item"><?=$Item?></span>
                </p>
             <!--  <p>
                <span class="total">消費總金額(TWD)：</span>
                <span class="price_style">$ <?=$total?>元</span>
              </p> -->
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <!-- <div style='float: left;'>
            <h3><?=$ReceiverInformation?>&nbsp;&nbsp;
              <?php if ($by_id != 0): ?><div style='float:left;color: #aaaaaa; font-size: 0.9em;'><?=$SignIn_2?><?=$buyer['by_email']?></div><?php endif; ?>
              <?php if ($by_id == 0): ?>
                <a onclick='window.location.href="/cart/login_switch/<?=$cset_code?>/check"'><?=$_SignIn?></a>
              <?php endif; ?>
            </h3>
          </div> -->
          <br>
              <table id='buyer_table' style="border: 0px; width:100%;">
              <tr><td><div style="float:left; display:block; clear:both; width:35px;"><input type="checkbox" id="somemember" value="1"></div><?=$somemdata;//同會員資料?></td></tr>
                <?php if ($by_id != 0): ?>
                  <!-- <tr id='history_tr'>
                    <td>
                      <div data-role="fieldcontain">
                        <label for="history_select" id="history_label" name="history_label"><?=$HistoricalOrderDetails?></label>    
                        <?php if (!empty($history)): ?>
                          <select id="history_select">
                            <option value=""><?=$Select?></option>
                            <?php foreach ($history as $key => $value): ?>
                              <option value="<?=$value['id']?>"><?=mb_substr($value['name'].' - '.$value['zip'].' '.$value['county'].$value['area'].$value['address'], 0, 15, 'utf-8').'...'?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php else: ?>
                          <?=$HistoricalOrderDeta?>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr> -->
                <?php endif; ?>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_name" id="buyer_nameLabel" name="buyer_nameLabel"><?=$FullName?><span class='red_star'>*</span></label>    
                      <input id="buyer_name" name="buyer_name_r" type="text" maxlength="32"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_phone" id="buyer_phoneLabel" name="buyer_phoneLabel"><?=$Phone?><span class='red_star'>*</span></label>    
                      <input id="buyer_phone" name="buyer_phone_r" type="text" class="number" minlength='10' maxlength='10'/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_email" id="buyer_emailLabel" name="buyer_emailLabel"><?=$Mailbox?><span class='red_star'>*</span></label>    
                      <input id="buyer_email" name="buyer_email_r" type="text" class="email" maxlength='255' placeholder='<?=$MailFillInCorrect?>'/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_address" id="buyer_addressLabel" name="buyer_addressLabel"><?=$Address?><span class='red_star'>*</span></label>    
                      <input id="zipcode" name="addr_zip" type="text" minlength='3' maxlength='5' placeholder='<?=$PostalCode?>' class='required'/>
                      <div data-role="controlgroup" data-type="horizontal">
                        <select name="addr_county" id="addr_county">
                            <option value=""><?=$SelectCounties?></option>
                            <?php foreach ($tw_county as $key => $value): ?>
                              <option value='<?=$value['county']?>' ><?=$value['county']?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="addr_area" id="addr_area">
                            <option value=""><?=$SelectArea?></option>
                        </select>
                        <input id="buyer_address" name="buyer_address_r" type="text" maxlength='255' placeholder='地址' />
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_pay_way"><?=$PaymentMethods?><span class='red_star'>*</span></label>    
                      <select name='buyer_pay_way' id='buyer_pay_way' class='required'>
                          <option value=''><?=$Select?></option>
                          <?php if (!empty($payment_way)): ?>
                          <?php foreach ($payment_way as $key => $value): ?>
                            <option value='<?=$value['pway_id']?>'><?=$value['pway_name'].' ('.$value['pway_code'].')'?></option>
                          <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                    </div>
                  </td>
                </tr>
                <?php if (!empty($logistics_way)): ?>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_pay_way"><?=$DeliveryMethod?><span class='red_star'>*</span></label>    
                      <select name='buyer_logist_way' id='buyer_logist_way' class='required'>
                          <option value=''><?=$Select?></option>
                          <?php foreach ($logistics_way as $log_key => $log_value): ?>
                            <?php if($log_value['lway_id'] != 4): ?>
                              <option value='<?=$log_value['lway_id']?>'><?=$log_value['lway_name']?><?php if($log_value['business_account'] != ''):?> (<?=$Shipment?> <?=$log_value['business_account']?> <?=$Yuan?>)<?php endif; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                        <div id='logist_shop'></div>
                    </div>
                  </td>
                </tr>
                <?php endif; ?>
                
                <?php if($store['cset_receipt_btn']): ?>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="receipt_title"><?=$InvoiceTitle?></label>    
                      <input id="receipt_title" name="receipt_title" type="text" maxlength='64'/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="receipt_code"><?=$TongBian?></label>    
                      <input id="receipt_code" name="receipt_code" type="text" class="number" minlength='8' maxlength='8'/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div data-role="fieldcontain">
                      <label for="buyer_receipt_code"><?=$InvoiceAddress?><span class='red_star'>*</span></label>    
                      <p><div style="float:left; display:block; clear:both; width:35px;"><input type="radio" name="someadd" id='same_address'></div><?=$somesend;//同收貨地址?></p>
                      <p><div style="float:left; display:block; clear:both; width:35px;"><input type="radio" name="someadd" id='member_address'></div><?=$somemadd;//同會員地址?></p>
                      <input id="receipt_zip" name="receipt_zip" type="text" minlength='3' maxlength='5' placeholder='<?=$PostalCode?>' />
                      <div data-role="controlgroup" data-type="horizontal">
                        <select name="receipt_county" id="receipt_county" class='required'>
                            <option value=""><?=$SelectCounties?></option>
                            <?php foreach ($tw_county as $key => $value): ?>
                              <option value='<?=$value['county']?>'><?=$value['county']?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="receipt_area" id="receipt_area">
                            <option value="" class='required'><?=$SelectArea?></option>
                        </select>
                        <input id="receipt_address" name="receipt_address" class='required' type="text" maxlength='255' placeholder='<?=$InvoiceAddress?>' />
                      </div>
                    </div>
                  </td>
                </tr>
                <?php endif; ?>
                <tr>
                  <td>
                    <div align="CENTER" id="submitDiv" data-role="fieldcontain">
                      <input type='hidden' id='by_id' value='<?=$by_id?>'>
                      <input type='hidden' name='d_spec_type'  value='<?=$d_spec_type?>'>
                      <input type='hidden' name='shop_id'  value='<?=$_SESSION['AT']['account']?>'>
                      <button type="submit" data-theme="b" name="submit" value="submit-value" class="ui-btn-hidden" aria-disabled="false"><?=$PreviewOrder?></button>
                    </div>
                  </td>
                </tr>
              </table>
          </div>
        </td>
      </tr>
    </table>
    </form>
  </div><!-- /content -->
  <div align="CENTER" data-role="content" id="contentDialog" name="contentDialog">  
    <div id='error_message'></div>
    <a id="buttonOK" name="buttonOK" href="#page1" data-role="button" data-inline="true"><?=$Return?></a>
  </div>
  <div data-role="content" id="contentTransition" name="contentTransition"> 
    <div align="CENTER"><h4><?=$DataSend?></h4></div>
    <div align="CENTER"><canvas width="27" height="27" class="ui-icon-loading2"></canvas></div>
  </div>
  <div data-role="content" id="contentConfirmation" name="contentConfirmation" align="center">
      <p><span id="confirmation" name="confirmation"></span></p>
  </div>
  <p id='cset_code' style="display:none;"><?=$cset_code?></p>
</div> <!-- page1 -->
  <style type="text/css">
    .ui-icon-loading { display: none; }
    .ui-loader { display: none; }
    .red_star{color: red;}
    .ui-controlgroup-controls { width: 100%; }
    .ui-select { width: 50%; }
    a {text-decoration: none;}
    label.error {
        background: url("/images/unchecked.gif") no-repeat 0px 0px;
        padding-left: 16px;
        color: red;
        font-size: 1.1em;
        font-family: "微軟正黑體", Arial,Century Gothic,sans-serif;
        line-height: 160%;
        letter-spacing: 1pt;
        text-indent: 5px;
    }
    label.success {
        padding-left: 16px;
        display: none;
    }
  </style>  
  <script src="/js/mcart_check.js"></script>
  <script>
    $(document).ready(function () {
        // Assign global variables
        hdrMainVar = $('#hdrMain');
        contentMainVar = $('#contentMain');
        ftrMainVar = $('#ftrMain');
        contentTransitionVar = $('#contentTransition');
        whatVar = $('#what');
        form1Var = $('#form1');
        confirmationVar = $('#confirmation');
        contentDialogVar = $('#contentDialog');
        contentConfirmationVar = $('#contentConfirmation');
        inputMapVar = $('input[name*="_r"]');
        hideContentDialog();
        // showContentTransition();
        contentTransitionVar.hide();
        hideConfirmation();
    });

    $('#buttonOK').click(function () {
        hideContentDialog();
        showMain();
        return false;
    });
    //validation
    var form = $("#form1");
    var errors;
    var validator = form.validate({
        success: function (label) {
            label.addClass("success").text("");
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });
    $('#form1').submit(function () {
      // 檢查數量
        $.ajax({
            type: "post",
            url: '/cart/amount_check',
            cache: false,
            async: false,
            dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
            },
            success: function (response) {
              $( "#buttonOK" ).hide();
              if(response.result != 1)
              {
                err = true;
                msg = true;
                $('#error_message').html('<?=$CommodityStocksAlert?>');
                $('#contentDialog').append('<a href="#" onclick="window.location.href=\'/cart/check/'+$('#cset_code').text()+'/1/\'"><?=$Refresh?></a>');
              }
              else { $('#error_message').html(''); msg = false; }
            }
        });
        // $('select').each(function () {
        //     $(this).blur();
        // });
        // $('.ui-loader-default').css('display', 'none');
        // var err = false;
        // var msg = false;
        // // Hide the Main content
        // hideMain();
        // // Reset the previously highlighted form elements      
        // inputMapVar.each(function (index) {
        //     $('#' + $(this).attr('id') + 'Label').removeClass(MISSING);
        // });
        // // Perform form validation
        // inputMapVar.each(function (index) {
        //     if ($(this).val() == null || $(this).val() == EMPTY) {
        //         $('#' + $(this).attr('id') + 'Label').addClass(MISSING);
        //         err = true;
        //     }
        // });
        // $('.number').each(function () {
        //     if ($(this).val().length != 0 && !$.isNumeric($(this).val())) {
        //         err = true;
        //     }
        // });
        

        // if($('#buyer_pay_way').val() == '')
        // {
        //   err = true;
        // }

        // if($('#buyer_logist_way').val() == '')
        // {
        //   err = true;
        // }
        // if($('#receipt_county').val() == '')
        // {
        //   err = true;
        // }
        // if($('#receipt_area').val() == '')
        // {
        //   err = true;
        // }
        // if($('#receipt_address').val() == '')
        // {
        //   err = true;
        // }


        // // If validation fails, show Dialog content
        // if (err == true || form.valid() == false) {
        //     showContentDialog();
        //     $('input').each(function () {
        //         $(this).blur();
        //     });
        //     $('select').each(function () {
        //         $(this).blur();
        //     });
        //     if(!msg)
        //     {
        //       $( "#buttonOK" ).show();
        //       $('#error_message').html('<?=$CorrectFormat?>');
        //     }
        //     return false;
        // }
        // // If validation passes, show Transition content
        // showContentTransition();
        // // Submit the form
        // // $('#form1').submit();
        // return true;
    });
    function hideMain() {
        hdrMainVar.hide();
        contentMainVar.hide();
        // ftrMainVar.hide();   
    }
    function showMain() {
        hdrMainVar.show();
        contentMainVar.show();
        // ftrMainVar.show();
    }
    function hideContentTransition() {
        contentTransitionVar.delay(800).fadeOut();
    }
    function showContentTransition() {
        contentTransitionVar.show();
    }
    function hideContentDialog() {
        contentDialogVar.hide();
    }
    function showContentDialog() {
        contentDialogVar.show();
    }
    function hideConfirmation() {
        contentConfirmationVar.hide();
    }
    function showConfirmation() {
        contentConfirmationVar.delay(1300).fadeIn();
    }
  </script>
<!-- Page ends here -->
</body>
</html>
<script> 
// $('#addr_county').val('台中市');
  $('#somemember').click(function(){    

    var bid=$('#by_id').val();
   
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
          $('#buyer_name').val(json.name);
          $('#buyer_phone').val(json.mobile);
          $('#buyer_email').val(json.by_email);
          $('input[name=addr_zip]').val(json.zipcode);
          $('#addr_county').val(json.city);
          $('select[name=addr_area] option').remove();
          $('select[name=addr_area]').prepend("<option value='"+json.countory+"'>"+json.countory+"</option>");
          $('#buyer_address').val(json.address);
      	  $("#addr_county").selectmenu("refresh");
          $("#addr_area").selectmenu("refresh");
      }
    });
  });
  $('#member_address').click(function(){
    var bid=$('#by_id').val();
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
          $('input[name=receipt_zip]').val(json.zipcode);
          $('select[name=receipt_county]').val(json.city);
          $('select[name=receipt_area] option').remove();
          $('select[name=receipt_area]').prepend("<option value='"+json.countory+"'>"+json.countory+"</option>");
          $('#receipt_address').val(json.address);
          $("#receipt_county").selectmenu("refresh");
          $("#receipt_area").selectmenu("refresh");
      }
    });
  });

$(document).on('change', '#buyer_logist_way', function(){
  var logist_way = $('#buyer_logist_way :selected').val();//注意:selected前面有個空格！
     $.ajax({
        url:"/cart/ajax_logist_way",       
        method:"POST",
        data:{
           logist_way:logist_way
        },      
        success:function(data){     
          $('#logist_shop').html(data);
        }
     });//end ajax  
});
</script>