    <?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>
				<section class="content has-side">
					<div class="title"><?=$this->lang['organization'];//組織表?></div>
					<!--
					<div class="select-bar clearfix">
							<div class="form-group clearfix">
									<div class="control-box-2">
        									<input class="form-control" type="text" name="s_account" placeholder="經銷商帳號" value="<?=$s_account?>">
        									<input class="form-control" type="text" name="s_num" placeholder="經銷商編號" value="<?=$s_num?>">
									</div>
							</div>
							<input type="button" class="more-search2" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
					</div>
					-->
					<div class="table-responsive">
						<table class="orga" width="100%" border="" cellpadding="0" cellspacing="5px" bgcolor="rgba(255,255,255,1)">
    <?php if (!empty($dbdata)): ?>
       <?php foreach ($dbdata as $key => $value): ?>
        					<thead>
							<tr>
								<th class="head-th" colspan="7"><?=$this->lang['no'];//第?> <?=$key?> <?=$this->lang['generation'];//代?></th>
							</tr>
							</thead>
							<thead>
								<tr>
								<th colspan="1"><?=$this->lang['dealer_id'];//經銷商編號?></th>
								<!--<th colspan="1">經銷商帳號</th>-->
								<th colspan="1"><?=$this->lang['dealer_name'];//經銷商姓名?></th>
								<th colspan="1"><?=$this->lang['registration_day'];//註冊日?></th>
								<th colspan="1"><?=$this->lang['membership_level'];//會員等級?></th>
								<th colspan="1"><?=$this->lang['recommended'];//推薦人?></th>
							</tr>
							</thead>
							<thead>
							</thead>
		<? foreach ($value as $avalue): ?>
							<tbody>
							<tr bgcolor='<?=$member_auth_color[$key]?>'>
								<td class="link" colspan="1"><a href='/gold/organization/<?=$avalue['d_account']?>'><?=$avalue['member_num']?></a></td>
								<!--<td class="link" colspan="1"><?=$avalue['d_account']?></td>-->
								<td colspan="1"><?=$avalue['name']?></td>
								<td colspan="1"><?=$avalue['create_time']?></td>
								<?if($avalue['is_shop']==0){?>
									<td colspan="1"><?=$this->lang['business_member'];//經營會員?></td>
								<?}else{?>
									<td colspan="1"><?=$this->lang['store_member'];//門市會員?></td>
								<?}?>
								<td colspan="1"><?=$avalue['pname']?></td>
							</tr>
							</tbody>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <?php endif; ?>
						</table>
  <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
   <?=$page?>
  </form>
					</div>       
                 
					
				</section>
			</div>
		</main>
<script src="js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker02" ).datepicker();
  });
  </script>
