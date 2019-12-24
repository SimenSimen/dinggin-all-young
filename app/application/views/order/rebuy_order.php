<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>行動名片系統</title>

		<!-- css -->
		<link type="text/css" rel="stylesheet" href="/css/admin.css">

		<!-- jQuery -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


		<!-- bootstrap -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<style type="text/css">
			div.config-div {
				margin-top: 20px;
				margin-left: 40px;
			}
			div.config-div-img {
				margin-left: 68%;
			}
			div.config-div-encrypt {
				margin-left: 68%;
			}
			div.config-div fieldset {
				display: inline;
				float: left;
			}
			fieldset.config-border {
				width: 65%;
				border: 1px groove #ddd !important;
				padding: 0 1.4em 1.4em 1.4em !important;
				margin: 0 0 1.5em 0 !important;
				-webkit-box-shadow:  0px 0px 0px 0px #000;
								box-shadow:  0px 0px 0px 0px #000;
			}
			fieldset.config-border-img, fieldset.config-border-encrypt {
				width: 100px;
				border: 1px groove #ddd !important;
				padding: 0 1.4em 1.4em 1.4em !important;
				margin: 0 0 1.5em 0 !important;
				-webkit-box-shadow:  0px 0px 0px 0px #000;
								box-shadow:  0px 0px 0px 0px #000;
								text-align: center;
								vertical-align: middle;
			}
			legend.config-border {
				font-size: 1.2em !important;
				font-weight: bold !important;
				text-align: left !important;
				width:auto;
				padding:0 10px;
				border-bottom:none;
				width: 130px;
			}
			.member_list_title_td
			{
				text-align: center;
				background-color: #333;
				color: #fff;
				width:150px;
			}
			#member_list tr td
			{
				vertical-align: middle;
			}
			.member_list_input_td
			{
				width:180px;
			}
			input[type=text], .input_select
			{
				background-color: #FDFFE2;
				font-size: 16px;
				color: #000;
			}
		</style>
		<!-- 地區AJAX -->
		<script src="/js/myjava/region.js"></script>
	</head>

	<left>
		<body background="<?//=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
			<form id="add_fix_form" method="post" action="/order/rebuy_order_AED" >
				<div class="config-div">
					<fieldset class="config-border">
						<legend class="config-border" style="width:160px">訂單資料</legend>
						<table id="member_list" class="table table-bordered table-condensed">
							<tr>
								<td class='member_list_title_td'>訂購人姓名</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['name']?>" name="" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>訂購人電話</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['phone']?>" name="" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>寄送方式</td>
								<td class='member_list_input_td'>
									<?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?><?=($dbdata['lway_id']==5)? $shop_address:'';?>
									<input type="hidden" value="<?=$dbdata['lway_id']?>" name="lway_id" readonly>
									<input type="hidden" value="<?=$dbdata['pway_id']?>" name="pway_id" readonly>
								</td>
							</tr>
							<tr>
								<td class='member_list_title_td'>訂購人信箱</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['email']?>" name="" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>訂購人地址</td>
								<td class='member_list_input_td'>
									<input value="<?=$dbdata['zip']?>" name="" readonly>
									<input value="<?=$dbdata['county']?>" name="" readonly>
									<input value="<?=$dbdata['area']?>" name="" readonly>
									<input value="<?=$dbdata['address']?>" name="" readonly>
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset class="config-border">
						<legend class="config-border" style="width:160px">收件人資料</legend>
						<table id="member_list" class="table table-bordered table-condensed">
							<tr>
								<td class='member_list_title_td'>收件人姓名</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['name']?>" name="buyer_name" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>收件人電話</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['phone']?>" name="buyer_email" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>收件人信箱</td>
								<td class='member_list_input_td'><input value="<?=$dbdata['email']?>" name="buyer_phone" readonly></td>
							</tr>
							<tr>
								<td class='member_list_title_td'>收件人地址</td>
								<td class='member_list_input_td'>
									<input value="<?=$dbdata['zip']?>" name="buyer_zip" readonly>
									<input value="<?=$dbdata['country']?>" name="country" readonly>
									<input value="<?=$dbdata['county']?>" name="county" readonly>
									<input value="<?=$dbdata['area']?>" name="area" readonly>
									<input value="<?=$dbdata['address']?>" name="buyer_address" readonly>
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset class="config-border">
						<legend class="config-border" style="width:160px">訂購商品明細</legend>
							<table id="member_list" class="table table-bordered table-condensed">
								<tr id='member_list_title_tr'>
									<td>商品條碼</td>
									<td>商品名稱</td>
									<td>價錢</td>
									<td>數量</td>
									<td>小計</td>
									<td></td>
								</tr>
								<?php if (!empty($oddata)): ?>
								<?php foreach ($oddata as $key => $value): ?>
								<tr bgcolor='<?//=$member_auth_color[$key]?>'>
									<td class='center_td white_td'><?=$value['prd_sn']?></td>
									<td class='center_td white_td'>
										<?=$value['prd_name']?>
										<?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['prd_spec'].')':'';?>
										<input type="hidden" name="prd_id[]" value="<?=$value['prd_id']?>">
										<input type="hidden" name="prd_name[]" value="<?=$value['prd_name']?>">
									</td>
									<td class='center_td white_td'><div id="price_<?=$value['prd_id']?>"><?=$value['price']?></div><input type="hidden" name="price[]" value="<?=$value['price']?>"></td>
									<td class='center_td white_td'>
										<input type="number" value="<?=$value['number']?>" class="qty" name="number[]" ref="<?=$value['prd_id']?>">
										<input type="hidden" id="max_<?=$value['prd_id']?>" value="<?=$value['prd_lock_amount']?>">
									</td>
									<td class='center_td white_td'><div id="total_single_<?=$value['prd_id']?>" class="total_single"><?=$value['total_price']?></div><input type="hidden" name="total_price[]" value="<?=$value['total_price']?>"></td>
									<td><a class="delete btn" onclick="del_prd(this);">刪除</a></td>
								</tr>
								<?php endforeach; ?>
								<tr bgcolor='<?//=$member_auth_color[$key]?>'>
									<td class='center_td white_td'></td>
									<td class='center_td white_td'><?=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:""?></td>
									<td class='center_td white_td'><?=$dbdata['lway_price']?></td>
									<td class='center_td white_td'>1</td>
									<td class='center_td white_td'><?=$dbdata['lway_price']?><input type="hidden" name="lway_price" value="<?=$dbdata['lway_price']?>"></td>
									<td></td>
								</tr>
								<?php endif; ?>
								<tr bgcolor='<?//=$member_auth_color[$key]?>' align='right'>
									<td colspan="6" class='center_td white_td'>
										使用紅利 <input type="number" min="0" step="0.3" id="use_dividend" value="<?=$dbdata['use_dividend']?>" name="use_dividend">
										紅利折抵 <b id="use_dividend_cost"><?=$dbdata['use_dividend_cost'];?></b> 元，
										使用購物金 <input type="number" min="0" step="0.3" id="use_shopping_money" value="<?=$dbdata['use_shopping_money']?>" name="use_shopping_money" max="<?=$d_shopping_money?>">
										付款總金額：<span style="color:red;font-weight:bold;" id="price_money"><?=number_format($dbdata['price_money'],2)?> 元</span><br>
										總金額：<span style="color:red;font-weight:bold;" id="total_price"><?=number_format($dbdata['total_price'],2)?> 元</span>
										<input type="hidden" id="total_price" value="<?=$dbdata['total_price']?>">
									</td>
								</tr>
						</table>
					</fieldset>
					<fieldset class="config-border">
						<legend class="config-border" style="width:160px">發票資訊</legend>
						<table id="member_list" class="table table-bordered table-condensed">
							<tr id='member_list_title_tr'>
								<td>發票抬頭		</td>
								<td>統編</td>
								<td>發票地址</td>
							</tr>
							<tr bgcolor='<?//=$member_auth_color[$key]?>'>
								<td class='center_td white_td'><input value="<?=$dbdata['receipt_title']?>" name="receipt_title" readonly></td>
								<td class='center_td white_td'><input value="<?=$dbdata['receipt_code']?>" name="receipt_code" readonly></td>
								<td class='center_td white_td'>
									<input value="<?=$dbdata['receipt_zip'].$dbdata['receipt_county'].$dbdata['receipt_area'].$dbdata['receipt_address']?>" readonly>
									<input type="hidden" value="<?=$dbdata['receipt_zip']?>" name="receipt_zip" readonly>
									<input type="hidden" value="<?=$dbdata['receipt_county']?>" name="receipt_county" readonly>
									<input type="hidden" value="<?=$dbdata['receipt_area']?>" name="receipt_area" readonly>
									<input type="hidden" value="<?=$dbdata['receipt_address']?>" name="receipt_address" readonly>
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset class="config-border"><legend class="config-border" style="width:160px">消費者備註</legend><textarea name="buyer_note" rows="3" cols="75" readonly><?=$dbdata['buyer_note']?></textarea></fieldset>
					<fieldset class="config-border">
						<legend class="config-border" style="width:160px">備註</legend>
						<table id="member_list" class="table table-bordered table-condensed">
							<tr bgcolor='<?//=$member_auth_color[$key]?>'>
								<td colspan='3' class='center_td white_td'><textarea name="note" rows="3" cols="75"><?=$dbdata['note']?></textarea></td>
							</tr>
						</table>
					</fieldset>
					<div style="width:65%">
						<table id="member_list" class="table table-bordered table-condensed">
							<tr>
								<td colspan="3" style="text-align:left;">
									<input type="hidden" id="dividend" value="<?=$d_dividend?>">
									<input type="hidden" name="d_id" value="<?=$dbdata['id']?>">
									<input type="hidden" name="dbname" value="order">
									<input type="hidden" name="shop_id" value="">
									<input type="hidden" name="by_id" id="by_id" value="<?=$dbdata['by_id']?>">
									<input class="btn btn-info btn-large" id="fix_data_action" type="button" style="width: 100px;font-size: 18px;" value='儲存'>
									<input class="btn btn-info btn-large" id="return_now_action" type="button" style="width: 100px;font-size: 18px;" value='返回列表'>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<input type="hidden" id="parm" value="">
			</form>
			<p style="height:200px;"></p>
		</body>
		<script>
			$(function() {
				$("#fix_data_action").click(function(){
						$("#parm").val(new Date().getTime());
						$("#add_fix_form").submit();
				});
				$("#return_now_action").click(function(){
					$("#parm").val(new Date().getTime());
						$("#add_fix_form").attr('action','/order/order_back_info/<?=$dbdata['id']?>');
					$("#add_fix_form").submit();
				});
			});
			$(function() {
        total();
				$(".qty").change(function(){
						var prd_id =$(this).attr("ref");
						var qty =$(this).val();
						var max =Number($("#max"+prd_id).val());
						var price =$("#price_"+prd_id).text();
						var total=(qty*price).toFixed(2);
						$("#use_dividend").val(0.00);
						if(qty>max){
								alert("此商品上限"+max);
								$(this).val(max);
								$(this).focus();
						}else if(qty<1){
								alert("數量不得為0");
								$(this).val(1);
								$(this).focus();
						}else{
								$("#total_single_"+prd_id).text(total);
								ajax_count(prd_id,qty,0);
					}
				});
        $("#use_dividend").change(function(){
            var use_dividend =$("#use_dividend").val();
						var dividend=$('#dividend').val();
						var dividend_max=+$("#total_price").val()*0.1*30;
						if(dividend<dividend_max){
							dividend_max=dividend;
						}
						if($("#total_price").text()<15){
								alert("消費滿US$15方可使用紅利點數折抵");
								$("#use_dividend").val('0.00');
								total();
								document.getElementById('use_dividend').focus();
								return false;
						}else{
                if(use_dividend==use_dividend && use_dividend>=0 && use_dividend<=dividend_max)
                {
                    total();
                }else{
                    alert("请输入可用紅利,范围为0-"+dividend_max);
                    $("#use_dividend").val('0.00');
                    total();
                    document.getElementById('use_dividend').focus();
                    return false;
                }
						}
        });

        $("#use_shopping_money").change(function(){
            var use_dividend =$("#use_shopping_money").val();
						var dividend=<?=$d_shopping_money?>;
						var dividend_max=+$("#total_price").val();
						if(dividend<dividend_max){
							dividend_max=dividend;
						}
						if(use_dividend==use_dividend && use_dividend>=0 && use_dividend<=dividend_max)
						{
								total();
						}else{
								alert("请输入可用購物金,范围为0-"+dividend_max);
								$("#use_shopping_money").val('0.00');
								total();
								document.getElementById('use_shopping_money').focus();
								return false;
						}
        });
			});
			function ajax_count(prd_id,qty){//計算個別金額
				$.post("/cart/ajax_count",
						{
								prd_id:prd_id,
								qty:qty
						},
					function(data,status){
							total();
					},"text");
			};
			function total(){//計算總金額.本次總紅利
        var use_dividend =$("#use_dividend").val();
        var use_shopping_money =$("#use_shopping_money").val();
				var titles = $('input[name^=prd_id]').map(function(idx, elem) {
					return $(elem).val();
				}).get();
				var titles1 = $('input[name^=number]').map(function(idx, elem) {
					return $(elem).val();
				}).get();
				$.post("/order/total_all",
						{
							use_dividend:use_dividend,
							use_shopping_money:use_shopping_money,
							by_id:$('#by_id').val(),
							prd_id:titles,
							number:titles1
						},
					function(data){
							var option_array = JSON.parse(data);
							$("#price_money").text(option_array['only_money']);
							$("#total_price").text(option_array['dataTotal'].toFixed(2));
							$("#total_price").val(option_array['dataTotal']);
							$('#use_dividend_cost').text(option_array['use_dividend_cost'].toFixed(2));
							var dividend_max = Math.round(option_array['dataTotal']*1000*30)/10000;
							if(<?=$d_shopping_money?>>option_array['dataTotal']){
								$("#use_shopping_money").attr({"max" : option_array['dataTotal']});
							}else{
								$("#use_shopping_money").attr({"max" : <?=$d_shopping_money?>});
							}
							if(dividend_max>$('#dividend').val()){
								dividend_max=$('#dividend').val();
							}
							$("#use_dividend").attr({"max" : dividend_max});
					},"text");
			};
			function del_prd(t){
				$(t).parent().parent().remove();
			};
		</script>
	</left>
</html>
