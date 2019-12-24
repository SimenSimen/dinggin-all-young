<link rel="stylesheet" type="text/css" href="/css/cart.css">
<div class="container">
	<section class="content">
		<div class="title">
			<?=$this->lang['cart'];//購物車?>
		</div>
		<form id="myform" method='post'>
			<table class="table table-h cart-table">
				<thead>
					<tr>
						<th class="align-left" colspan="2">
							<?=$this->lang['c_name'];//商品名稱?>
						</th>
						<th>
							<?=$this->lang['c_price'];//金額?>
						</th>
						<th>
							<?=$this->lang['c_num'];//數量?>
						</th>
						<th>
							<?=$this->lang['c_sum'];//小計?>
						</th>
						<th>
							<?=$this->lang['c_delete'];//刪除?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $total=0;?>
					<? foreach ($productList as  $key=>$value) {?>
					<tr>
						<td class="img">
							<a href="/products/detail/<?=$value['prd_id'];?>" class="pic"><img style="height: 3.9em;" src="<?=$Spath;?><?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></a>
						</td>
						<td class="info align-left">
							<a href="/products/detail/<?=$value['prd_id'];?>">
								<span class="pd-name prd_name<?=$value['prd_id'];?>">
									<?=$value['prd_name'];?>
									<?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['spec_name'].')':'';?></span>
								<input type="hidden" name="prd_id" id="prd_id<?=$value['spec_rename'];?>" value="<?=$value['spec_rename'];?>" ref="<?=$value['spec_rename'];?>">
							</a>
							<? if (!empty($_SESSION['ids'])) {?>
								<? echo in_array($value['prd_id'], $_SESSION['ids']) ? '<span style="color: red;">商品庫存量不足</span>' : '' ?>
							<?}?>
						</td>
						<td data-title="金額：">
							<?=$this->data['web_config']['currency'];?><span id="price_<?=$value['spec_rename'];?>">
								<?=$value['price'];?></span></td>
						<td data-title="數量：">
							<div class="qty-box">
								<span id="qty<?=$value['spec_rename'];?>"><?=$value['num'];?></span>
								<!--<input type="button" class="btn less" onClick="qtyDown()" value="－" />-->
								<!-- <input onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
									onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
									type="number"
									min="1"
									max="<?//=$value['prd_lock_amount'] < $value['prd_amount'] ? $value['prd_lock_amount'] : $value['prd_amount'];?>"
									name="qty"
									id="qty<?//=$value['spec_rename'];?>"
									class="qty form-control"
									value="<?//=$value['num'];?>"
									ref="<?//=$value['spec_rename'];?>"
									style="width:170%"
									autocomplete="off"> -->
								<input type="hidden" value="<?=$value['prd_lock_amount'];?>" name="max" id="max<?=$value['spec_rename'];?>" ref="<?=$value['spec_rename'];?>" style="width:170%">
								<!--<input type="button" class="btn add" onClick="qtyUp()" value="＋">-->
							</div>
						</td>
						<td data-title="小計：">
							<?=$this->data['web_config']['currency'];?><label id="total_single_<?=$value['spec_rename'];?>">
								<?echo $total_single = ((empty($value['total']))?"0":$value['total'])?></label>
							<?php $total=$total+((empty($value['total']))?"0":$value['total']);?>
						</td>
						<td><a class="delete btn" id="delete<?=$value['spec_rename'];?>" value="<?=$value['spec_rename'];?>" ref="<?=$value['spec_rename'];?>"><i class="icon-trash-can"></i></a>
						</td>
					</tr>
					<? }?>
				</tbody>
			</table>
			<div class="sum-box">
				<table class="table table-h sum-table">
					<tfoot>
						<tr>
							<td>
								<?=$this->lang['c_total'];//小計?>
							</td>
							<td>
								<?=$this->data['web_config']['currency'];?><span id="only_money"></span></td>
						</tr>
						<tr>
							<td>
								<?=$this->lang['c_19'];//使用紅利?>
							</td>
							<td>
								<div class="form-group">
									<div class="control-box qty-box" style="width:auto;">
										<input type="button" class="btn add" onClick="divUp()" value="＋" />
										<input type="text" min="0" name="use_dividend" id="use_dividend" class="form-control" value="0" step="1">
										<input type="button" class="btn less" onClick="divDown()" value="－" />
									</div>
								</div>
								<p style="color: red;"><?=$discount?>點紅利可折抵1元</p>
								<p style="color: red;">最高可折抵現金<?=$maxDiscount?>%</p>
							</td>
						</tr>
						<tr>
							<td>
								<?=$this->lang['c_52'];//使用購物金?>
							</td>
							<td>
										<input type="number" min="0.00" name="use_shopping_money" id="use_shopping_money" class="form-control" value="0.00" step="1">
							</td>
						</tr>
						<tr>
							<td>
								<?=$this->lang['c_20'];//現金?>
							</td>
							<td>
								<?=$this->data['web_config']['currency'];?><span id="total_money"></span>
								<input type="hidden" id="total_money1" >
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?=$this->lang['c_26'];//目前積點： 紅利?>
								<span class="color01">
									<?=$d_dividend;?>
									<?=$this->lang['c_27'];//點?>
									<input type="hidden" id="d_dividend" value="<?=$d_dividend;?>">
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?=$this->lang['c_53'];//目前積點： 購物金?>
								<span class="color01">
									<?=$d_shopping_money;?>
									<?=$this->lang['c_27'];//點?>
									<input type="hidden" id="d_shopping_money" value="<?=$d_shopping_money;?>">
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?=$this->lang['c_28'];//本次購買可再護得:紅利?><span class="color01"><span id="total_bonus"></span>
									<?=$this->lang['c_27'];//點?></span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="title">
				<?=$this->lang['c_1'];//運送 & 付款資訊?>
			</div>
			<div class="shopping-form">
				<div class="row">
					<div class="col col1">
						<div class="shopping-title">
							<?=$this->lang['c_2'];//收件人資訊?>
						</div>
						<div class="form-box02">
							<div class="radio-box">
								<label class="form-radio"><input type="checkbox" name="gender" id="somemember">
									<?=$this->lang['c_3'];//收件人同訂購人資料?></label>
							</div>
							<div class="form-group">
								<div class="input-box">
									<?if(!empty($address)){?>
									<select name="select_address" id="select_address" class="form-control">
										<option value="0">
											<?=$this->lang["c_25"];//常用地址?>
										</option>
										<?foreach ($address as $avalue):?>
										<option value="<?=$avalue['d_id'];?>">
											<?=$avalue['country'].$avalue['city'].$avalue['countory'].$avalue['address']?>
										</option>
										<? endforeach;?>
									</select>
									<?}?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">
									<?=$this->lang['c_4'];//姓名?></label>
								<div class="control-box">
									<input class="form-control" type="text" name="buyer_name" id="buyer_name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">
									<?=$this->lang['c_email'];//email?></label>
								<div class="control-box">
									<input class="form-control" type="text" name="buyer_email" id="buyer_email">
								</div>
							</div>
							<div class="form-group address">
								<label class="control-label">
									<?=$this->lang['c_5'];//聯絡地址?></label>
								<div class="control-box">
									<div class="input-group">
										<div class="input-box">
											<input class="form-control" type="text" name="buyer_zip" id="zip" placeholder="郵遞區號">
										</div>
										<div class="input-box" id="country_select">
											<select name="country" id="country" class="form-control">
												<option value="0">
													<?=$this->lang["c_22"]//請選擇國家;?>
												</option>
												<?foreach ($country as $cvalue):?>
												<option value="<?=$cvalue['s_id']?>">
													<?=$cvalue['s_name']?>
												</option>
												<? endforeach;?>
											</select>
										</div>
										<div class="input-box" id="city_select">
											<select name="city" id="city" class="form-control">
												<option value="0">
													<?=$this->lang["c_23"]//請選擇縣市;?>
												</option>
												<?foreach ($city as $cvalue):?>
												<option value="<?=$cvalue['s_id']?>">
													<?=$cvalue['s_name']?>
												</option>
												<? endforeach;?>
											</select>
										</div>
										<div class="input-box" id="countory_select">
											<select name="countory" id="countory" class="form-control">
												<option value="0">
													<?=$this->lang["c_24"]//請選擇鄉鎮;?>
												</option>
											</select>
										</div>
										<div class="input-box">
											<input class="form-control" type="text" name="buyer_address" id="buyer_address">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">
									<?=$this->lang['c_6'];//聯絡電話?></label>
								<div class="control-box">
									<input class="form-control" type="text" name="buyer_phone" id="buyer_phone">
								</div>
							</div>
						</div>
					</div>
					<div class="col col2">
						<div class="shopping-title">
							<?=$this->lang['c_10'];//付款方式?>
						</div>
						<div class="form-box02">

							<div class="form-group">
								<div class="input-box">
									<select name="pway_id" id="" class="form-control">
										<? foreach ($payment_way as $key => $value) {?>
										<option value="<?=$value['pway_id'];?>">
											<?=$value['pway_name'];?>
										</option>
										<?}?>
									</select>
								</div>
							</div>
						</div>
						<div class="shopping-title">
							<?=$this->lang['c_7'];//運送方式：?>
							<?=$this->lang['c_8'];//滿?>
							<?=$freeShip;?>
							<?=$this->lang['c_9'];//則免運費?>
						</div>
						<div class="form-box02">
							<div class="form-group">
								<div class="input-box">
									<select name="lway_id" id="lway_id" class="form-control">
										<? foreach ($logistics_way as $key => $value) {?>
										<option value="<?=$value['lway_id'];?>">
											<?=$value['lway_name'];?>
										</option>
										<?}?>
									</select>
									<select name="shop_id" id="shop_id" class="form-control" style="display: none;">
									</select>
								</div>
							</div>
						</div>
						<div class="shopping-title">
							<?=$this->lang['buyer_note'];//備註?>
						</div>
						<div class="form-box02">
							<div class="form-group">
								<div class="input-box">
									<textarea cols="50" rows="5" class="form-control" name="buyer_note" id="buyer_note"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="title">
				<?=$this->lang['invoice'];//發票開立?>
			</div>
			<div class="invoice-info-box">
				<div class="invoice-info">
					<?=$this->lang['invoice2'];//invoice?>
				</div>
				<div class="invoice-form">
					<div class="form-box02">
						<div class="row clearfix">
							<div class="col">
								<div class="form-group">
									<div class="control-box">
										<input class="form-control" type="text" name="receipt_title" id="receipt_title" placeholder="<?=$this->lang['receipt_title'];//公司抬頭?>">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<div class="control-box">
										<input class="form-control" type="text" name="receipt_code" id="receipt_code" placeholder="<?=$this->lang['receipt_code'];//統一編號?>">
									</div>
								</div>
							</div>
							<div class="radio-box" style="text-align:left;">
								<label class="form-radio"><input type="checkbox" name="gender2" id="somemember2">
									<?=$this->lang['same_up'];//同上?></label>
							</div>
							<div class="col">
								<div class="form-group">
									<div class="control-box">
										<input class="form-control" type="text" name="receipt_zip" id="receipt_zip" placeholder="<?=$this->lang['receipt_zip'];//郵遞區號?>">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<div class="control-box">
										<input class="form-control" type="text" name="receipt_address" id="receipt_address" placeholder="<?=$this->lang['receipt_address'];//地址?>">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="pagination_box">
				<a href="/products" class="btn simple"><i class="icon-chevron-left"></i>
					<?=$this->lang['c_11'];//回購物商城?></a>
				<a href="javascript:void();" class="btn simple bg2" id="SendData"><?=$this->lang['c_12'];//立前結帳" ?>
					<i class="icon-chevron-right"></i></a>
			</div>
			<input type='hidden' name='by_id' id='by_id' value='<?=$by_id?>'>

			<span style="display: none;" id="check_message"><?=$this->lang['confirm_delete']?></span>
		</form>
	</section>
</div>
</main>
<!-- 加減-->
<script type="text/javascript" src="/js/quantity_box_button_down.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script>
	function chageWays(){
		if ($('select[name="pway_id"]').val() == 2){
			$('select[name="lway_id"]').show();
		}else{
			$('select[name="lway_id"]').hide();
		}
	}
	chageWays();
	$('select[name="pway_id"]').change(function(){
		chageWays();
	});

	//同會員資料
	var i = 1;
	var maxDiscountMoney;

	function ajax_area(country, city, countory) {
		$.post("/cart/ajax_area", {
				country: country,
				city: city,
				countory: countory
			},
			function(data) {
				var area_array = JSON.parse(data);
				$("#country_select").html(area_array['country']);
				$("#city_select").html(area_array['city']);
				$("#countory_select").html(area_array['countory']);
			}
		);
	}
	$('#somemember').click(function() {
		var check = $("input[name='gender']:checked").length;
		if (check == 1) {
			$('#select_address').val(0);
			var bid = $('#by_id').val();
			$.ajax({
				url: '/cart/get_member',
				type: 'POST',
				data: 'bid=' + bid,
				dataType: 'json',
				success: function(json) {
					console.log(json);
					$('#buyer_name').val(json.name);
					$('#buyer_email').val(json.by_email);
					$('#buyer_phone').val(json.mobile);
					$('#zip').val(json.zip);
					$('#buyer_address').val(json.address);
					//$('#country option[value='+json.country+']').attr('selected', 'selected');
					ajax_area(json.country, json.city, json.countory);
				}
			});
		} else {
			$('#buyer_name').val('');
			$('#buyer_email').val('');
			$('#buyer_phone').val('');
			$('#zip').val('');
			$('#buyer_address').val('');
			$('#country').val(0);
			$('#city').val(0);
			$('#countory').val(0);
		}
	});

	$('#somemember2').click(function() {
		var check2 = $("input[name='gender2']:checked").length;
		if (check2 == 1) {
			var zip = $("#zip").val();
			var country = $("#country :selected").text();
			var city = $("#city :selected").text();
			var countory = $("#countory :selected").text();
			var buyer_address = $("#buyer_address").val();
			$('#receipt_zip').val(zip);
			$('#receipt_address').val(country + ' ' + city + ' ' + countory + ' ' + buyer_address);
		} else {
			$('#receipt_zip').val('');
			$('#receipt_address').val('');
		}
	});

	//常用地址
	$("#select_address").change(function() {
		var address_id = $("select[name='select_address']").val();
		if (address_id != '0') {
			$('#somemember').prop("checked", false);
			$.post("/cart/ajax_common_address", {
					address_id: address_id
				},
				function(address) {
					var address_array = JSON.parse(address);
					$('#buyer_name').val(address_array['name']);
					$('#buyer_address').val(address_array['address']);
					$('#buyer_phone').val(address_array['telphone']);
					$('#zip').val(address_array['zip']);
					$("#country_select").html(address_array['country']);
					$("#city_select").html(address_array['city']);
					$("#countory_select").html(address_array['countory']);
				});
		} else {
			$('#buyer_name').val('');
			$('#buyer_phone').val('');
			$('#buyer_address').val('');
			$('#zip').val('');
			$('#country').val(0);
			$('#city').val(0);
			$('#countory').val(0);
		}
	});

	//計算金額
	function ajax_count(prd_id, qty) { //計算個別金額
		$.post("/cart/ajax_count", {
				prd_id: prd_id,
				qty: qty,
			},
			function(data, status) {
				total();
			}, "text");
	}

	function total() { //計算總金額.本次總紅利
		var use_dividend = $("#use_dividend").val();
		var use_shopping_money = $("#use_shopping_money").val();
		var d_dividend = $("#d_dividend").val();
		$.post("/cart/total_all", {
				use_dividend: use_dividend,
				use_shopping_money: use_shopping_money
			},
			function(data) {
				var option_array = JSON.parse(data);
				$("#only_money").text(option_array['dataTotal']);
				$("#total_money").text(Math.ceil(option_array['only_money']));
				$("#total_money1").val(option_array['dataTotal']);
				$("#total_bonus").text(option_array['dataBonus']);
				var dividend_max = Math.round(option_array['dataTotal'] * 1000 * 30) / 10000;

				if (i == 1) {
					// 紅利最高可折抵現金
					maxDiscountMoney = Number.parseInt((option_array['only_money'] * <?=$maxDiscount?>) / 100);
					i++;	// 只有第一次call API才可計算最大折扣金額
				}

				if(d_dividend<dividend_max){
					dividend_max=d_dividend;
				}
				if(option_array['dataTotal']><?=$d_shopping_money?>){
				 	$("#use_shopping_money").attr({
						"max": <?=$d_shopping_money?>
					});
				}else{
					$("#use_shopping_money").attr({
						"max": option_array['dataTotal']
					});
				}
				$("#use_dividend").attr({
					"max": <?=$d_dividend?>
				});
			}, "text");
	}
	$(function() {
		total();
		$(".qty").change(function() {
			var prd_id = $("#prd_id" + $(this).attr("ref")).val();
			var qty = $("#qty" + $(this).attr("ref")).val();
			var max = Number($("#max" + $(this).attr("ref")).val());
			var price = $("#price_" + prd_id).text();
			var total = (qty * price).toFixed(2);
			$("#use_dividend").val(0);
			if (qty > max) {
				alert("<?=$this->lang['maxNum'];//此商品上限?>" + max);
				$("#qty" + $(this).attr("ref")).val(max);
				$("#qty" + $(this).attr("ref")).focus();
			} else if (qty < 1) {
				alert("<?=$this->lang['cannot0'];//數量不得為0?>");
				$("#qty" + $(this).attr("ref")).val(1);
				$("#qty" + $(this).attr("ref")).focus();
			} else {
				$("#total_single_" + prd_id).text(total);
				ajax_count(prd_id, qty, use_dividend);
			}

		});
		$("#use_dividend").change(function() {
			var f = document.forms[0];
			var use_dividend = $("#use_dividend").val();
			// if ($("#total_money1").val() < 15) {
			// 	alert("<?=$this->lang['c_51'];//消費滿US$15方可使用紅利點數折抵?>");
			// 	$("#use_dividend").val('0');
			// 	total();
			// 	document.getElementById('use_dividend').focus();
			// 	return false;
			// } else {
				if ((use_dividend == use_dividend) && (use_dividend >= 0) && (use_dividend <= <?=$d_dividend;?>)) {
					total();
				} else {
					alert("<?=$this->lang['c_21'];//请输入可用紅利,范围为?>0-<?=substr($d_dividend,0,strpos($d_dividend,'.'));?>");
					$("#use_dividend").val('0');
					total();
					document.getElementById('use_dividend').focus();
					return false;
				}
			// }
		});
		$("#use_shopping_money").change(function() {
			var f = document.forms[0];
			var use_dividend = $("#use_shopping_money").val();
			if (use_dividend == use_dividend && use_dividend >= 0 && use_dividend <= <?=$d_shopping_money;?>) {
				total();
			} else {
				alert("<?=$this->lang['c_54'];//请输入可用購物金,范围为?>0-<?=substr($d_shopping_money,0,strpos($d_shopping_money,'.'));?>");
				$("#use_shopping_money").val('0');
				total();
				document.getElementById('use_shopping_money').focus();
				return false;
			}
		});
		$("#lway_id").change(function() {
			var lway_id = $("#lway_id").val();
			if (lway_id == 5) {
				document.getElementById('shop_id').style.display = ''
				$.ajax({
					url: "/shop",
					method: "GET",
					success: function(data) {
						_.forEach(data, (shop, key) => {
							$('#shop_id').append(
								`<option value="${shop.shop_id}">${shop.shop_name}</option>`
							);
						})
					}
				}) //end ajax
			} else {
				document.getElementById('shop_id').style.display = 'none'
				$('#shop').html('');
			}
		});
		//送出
		$("#SendData").click(function() {
			var f = document.forms[0];
			var re = /^\d{8,11}$/;
			var only_money = $("#only_money").text();
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			var use_dividend = $('#use_dividend').val();
			var max = <?=$d_dividend?>;
			var currentDiscount = (Number.parseInt(use_dividend)) / <?=$discount?>;	// 當前紅利可折抵現金
			//var re10 = /^\d{10}$/;
			if (f.buyer_name.value == '') {
				alert("<?=$this->lang['c_15'];//請輸入姓名?>");
				f.buyer_name.focus();
				return false;
			} else if (f.buyer_email.value == '' || (!regex.test(f.buyer_email.value))) {
				alert("<?=$this->lang['c_email_error'];//請輸入email?>");
				f.buyer_email.focus();
				return false;
			} else if (f.buyer_address.value == '') {
				alert("<?=$this->lang['c_16'];//請輸入地址?>");
				f.buyer_address.focus();
				return false;
			} else if (!re.test(f.buyer_phone.value)) {
				alert("<?=$this->lang['c_17'];//請輸入正確電話格式,只允許輸入數字?>");
				f.buyer_phone.focus();
				return false;
			} else if (f.country.value == 0) {
				alert("<?=$this->lang['c_22'];//請選擇國家?>");
				f.country.focus();
				return false;
			} else if (f.city.value == 0) {
				alert("<?=$this->lang['c_23'];//請選擇縣市?>");
				f.city.focus();
				return false;
			} else if (f.countory.value == 0) {
				alert("<?=$this->lang['c_24'];//請選擇鄉鎮?>");
				f.countory.focus();
				return false;
			}

			if (currentDiscount > maxDiscountMoney) {
				alert(`您當前最多可折抵的現金為${maxDiscountMoney}元`);
				f.use_dividend.focus();
				return false;
			}

			$("#myform").attr("action", "/cart/cart_checkout");
			$("#myform").submit();
		});

		$(".delete").click(function() {
			var prd_id = $("#prd_id" + $(this).attr("ref")).val();
			var prd_name = $(".prd_name" + $(this).attr("ref")).text();
			if (confirm($('#check_message').text() + '[' + prd_name.trim() + ']？')) {
				var prd_id = $("#prd_id" + $(this).attr("ref")).val();
				ajax_delete(prd_id);
			}
		});

		function ajax_delete(prd_id) { //刪除
			$.post("/cart/ajax_delete", {
					prd_id: prd_id
				},
				function(data, status) {}, "text");
			alert("<?=$this->lang['c_18'];//刪除完成?>");
			location.href = "/cart"
		}
	});

	function divUp() {
		var use_dividend = $('#use_dividend').val();
		var d_dividend = $("#d_dividend").val();
		var max = <?=$d_dividend?>;
		var currentDiscount = (Number.parseInt(use_dividend) + 1) / <?=$discount?>;	// 當前紅利可折抵現金

		if (currentDiscount <= maxDiscountMoney) {
			if ($('#only_money').text() <= 0) {
				alert('金額不可低於0元')
			} else {
				if (use_dividend >= max) {
					$('#use_dividend').val(max);
				} else {
					var a1 = +use_dividend + 1;
					var a1 = Math.round(a1 * 10000) / 10000;
					$('#use_dividend').val(a1);
					$('#use_dividend').change();
				}
			}
		} else {
			alert(`您當前最多可折抵的現金為${maxDiscountMoney}元`)
		}
	};

	function divDown() {
		var use_dividend = $('#use_dividend').val();
		if (use_dividend <= 0) {
			$('#use_dividend').val(0);
		} else {
			var a1 = +use_dividend - 1;
			var a1 = Math.round(a1 * 10000) / 10000;
			$('#use_dividend').val(a1);
			$('#use_dividend').change();
		}
	}
</script>
<script src="/js/myjava/region.js"></script>
<script src="/js/handle_address.js"></script>
