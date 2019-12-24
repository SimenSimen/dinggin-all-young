				<section class="content has-side">
					<div class="title"><?=$this->lang_menu['invoice'];//我要請款?></div>
					<div class="table-responsive">
						<form method="post" action="/gold/invoice_ok" onsubmit="return check_form(this)">
							<input type=hidden name='total' value='<?=$dbdata['d_bonus']?>'>
							<input type=hidden name='bank_name' value='<?=$mdata['bank_name']?>'>
							<input type=hidden name='bank_account_name' value='<?=$mdata['bank_account_name']?>'>
							<input type=hidden name='bank_account' value='<?=$mdata['bank_account']?>'>
							<input type=hidden name='Fee' value='<?=$feedata[0]['d_val']?>'>
							<input type=hidden name='account_Fee' value='<?=$feedata[1]['d_val']?>'>
							<table class="orga invoice-fix" width="100%" border="" cellpadding="0" cellspacing="5px" bgcolor="rgba(255,255,255,1)">
								<thead>
									<tr>
										<th colspan="7"><?=$this->lang['amount'];//累計佣金金額?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="7"><span class="total"><?=$currency;//USD$?> <?=number_format($dbdata['d_bonus'])?></span><br><span class="note"><?=$this->lang['accumulate'];//如果系統沒有收到任何申請，金額將自動累積。?></span></td>
									</tr>
								</tbody>
								<thead>
									<tr>
										<th colspan="6">1.<?=$this->lang['choose'];//選擇付款方式?></th>
										<th colspan="1"><?=$this->lang['fee'];//手續費?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="6">
											<span style="color:red;font-size: 8px;"><?=$this->lang['bank_limit'];//匯款?></span><br>
											<span style="color:red;font-size: 8px;"><?=$this->lang['bank_suggest'];//匯款?></span><br>
											<input type="radio" id="pay_method" name="pay_method" value="bank" checked/>
											<span><?=$this->lang['bank_limit'];//匯款?></span>
											<p class="invocie-p">
												<?=$this->lang['bankname'];//銀行名稱?>:<font><?=$mdata['bank_name']?></font><br>
												<?=$this->lang['baddress'];//銀行名稱?>:<font><?=$mdata['bank_address']?></font><br>
												<?=$this->lang['accountname'];//帳戶名稱?>:<font><?=$mdata['bank_account_name']?></font><br>
												<?=$this->lang['bankaccount'];//匯款帳號?>:<font><?=$mdata['bank_account']?></font><br>
												<?=$this->lang['swiftcode'];//匯款帳號?>:<font><?=$mdata['swift_code']?></font>
											</p>
										</td>
										<td colspan="1"><?=$currency;//USD$?> <?=$feedata[0]['d_val']?></td>
									</tr>
									<tr>
										<td colspan="6">
											<input type="radio" id="pay_method" name="pay_method" value="account" checked/> <label for="radio-2"><?=$this->lang['into_shopping'];//轉入購物金帳戶?></label><br>
											<select class="select-id" name="guest_id">
												<?php if(!empty($downline)): ?>
													<?php foreach ($downline as $key => $value): ?>
														<option value='<?=$value['by_id']?>'><?=$value['d_account']?>(<?=$value['name']?>)</option>
										      		<?php endforeach; ?>
										      	<?php endif; ?>
											</select>
										</td>
										<td colspan="1"><?=$currency;//USD$?> <?=$feedata[1]['d_val']?></td>
									</tr>
								</tbody>
								<thead>
									<tr>
										<th colspan="7">2.<?=$this->lang['choose_amount'];//選擇輸入金額?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="7"><input type="radio" id="money_choice" name="money_choice" value="all" checked/> <label for="radio-3"><?=$this->lang['all'];//全部?></label></td>
									</tr>
									<tr>
										<td colspan="7">
											<input type="radio" id="money_choice" name="money_choice" value="inputmoney"/> <label for="radio-4"><?=$this->lang['enter_amount'];//輸入金額?></label><br>
											<input type="text" name="shopping_money" id="shopping_money" value="" onKeyUp="value=value.replace(/[^\d]/g,'')" />
										</td>
									</tr>
								</tbody>
							</table>
							<div class="pagination_box">
								<button type='submit' class="btn simple bg2" <?if($dbdata['d_bonus']<=0)echo"disabled"?>><?=$this->lang['send'];//送出?></button>
							</div>
						</form>
					</div>       
					<script>
						function check_form(frm){
							if(frm.elements['pay_method'].value=="bank" && frm.elements['money_choice'].value=="inputmoney" && (frm.elements['shopping_money'].value<300 || frm.elements['shopping_money'].value>10000)){
								alert("<?=$this->lang['bank_limit'];?>");
								frm.elements['shopping_money'].focus();
								return false;  
							}else if(frm.elements['pay_method'].value=="bank" && frm.elements['money_choice'].value=="all" && (<?=$dbdata['d_bonus']?><300 || <?=$dbdata['d_bonus']?>>10000)){
								alert("<?=$this->lang['bank_limit'];?>");
								frm.elements['shopping_money'].focus();
								return false;  
							}else{
								return true;
							}
						};
					</script>
				</section>
			</div>
		</main>
<script src="js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
