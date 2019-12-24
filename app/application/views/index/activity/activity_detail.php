<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
<!-- js -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
<script type="text/javascript">
    $(document).ready( function(){
        $('#bottom_form').validate({
	        success: function(label) {
	            label.addClass("success").text("");
	        }
	    });

	    $('#u_mphone').mask('0000000000');

	    $.datepicker.regional['zh-TW']={
			dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
			dayNamesMin:["日","一","二","三","四","五","六"],
			monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			prevText:"上月",
			nextText:"次月",
			weekHeader:"週",
			dateFormat:"yy-mm-dd"
		};
		$.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
		$(".datepicker").datepicker({
			showOtherMonths: true, 
			selectOtherMonths: true,
			showOn: "button",
			buttonImage: "/images/calendar.png",
		    buttonImageOnly: true,
		    buttonText: '日期',
		    changeMonth: true,
  			changeYear: true, 
  			yearRange:"1911:+10"
		});
    	$('.ui-datepicker-trigger').css('width', 'auto');

    });
</script>
				<section class="content has-side">
					<? if(!empty($this->style==2)){?>
					<div class="activity_type">
						<aside class="side" style="display:block; opacity:1; width:100%;">
							<div class="nice-select">
								<span class="current"><a href="#"> </a></span>
								<ul class="side-nav list-v">
							    	<?php if(!empty($list)): ?>
							    		<?php foreach ($list as $key => $value): ?>
											<?if($value['id']==$category_id){?>
												<li class="active select"><a href="/gold/activity/C/enroll/<?=$value['id']?>"><?=$value['name']?></a></li>
											<?}else{?>
												<li><a href="/gold/activity/C/enroll/<?=$value['id']?>"><?=$value['name']?></a></li>
											<?}?>
							    		<?php endforeach; ?>
							    	<?php endif; ?>
								</ul>
							</div>
		                </aside>
					</div>
					<?}?>
					<div class="title"><?=$title?></div>
					<div class="share"><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share"<?}else{?> href="/share_link" class="btn share fancybox-share"<?}?>><i class="icon-share2"><?=$this->lang['share_link'];?></i></a></div>
					<div class="share-detail">
					<div class="name"><?=$list['ufm_name']?></div>
					<div class="editor">
						<?=$list['ufm_aim']?>
					</div>
					<form action='/form/signup/0' method='post' name='bottom_form' id='bottom_form'>
					<div class="editor activity">
						<div class="form-box">
						<div class="title"><span>報名表</span></div>
						<div class="form-group w170">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            	<label class="control-label"><span class='red_star'>*</span><?=$ufm_title[0]?></label>
									<input type='text' name='name_r' id='u_name' class="required form-control" minlength="2" maxlength="16">
	                            </div>
	                        </div>
	                        <div class="form-group w170">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label"><span class='red_star'>*</span><?=$ufm_title[1]?></label>
									<input type='text' name='mphone_r' id='u_mphone' class="required number form-control" minlength="10" maxlength="10">
	                            </div>
	                        </div>
	                        <div class="form-group w170">
	                            <div class="control-box">
	                            <i class="icon-mail"></i>
	                            <label class="control-label"><span class='red_star'>*</span><?=$ufm_title[2]?></label>
	                                <input type='text' name='email_r' id='u_email' class="required email form-control" maxlength="255">
	                            </div>
	                        </div>
					<?php if (!empty($ufm_title) && count($ufm_title) > 3): ?>
					<?php foreach ($ufm_title as $key => $value): ?>
						<?php if ($key > 2): ?>
							<?php $index=($key-3);?>
									<!-- 單選 -->
									<?php if ($ufm_content[$index][0] == 3): ?>
									<div class="form-group name" style="color:#666;">
												<i class="icon-cake" style="font-size:20px;"></i> <label class="control-label"><?=$ufm_required_star[$index]?><?=$value?></label>
												<div class="control-box">
																<div class="radio-box" style="left:110px;">
																	<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
																		<?php if ($content_key > 0): ?>
																				<label class="form-radio"><input type="radio" class="form-control1 <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'> <?=$content_value?></label>
																		<?php endif; ?>
																	<?php endforeach; ?>
																</div>
												</div>
									</div>
									<!-- 複選 -->
									<?php elseif ($ufm_content[$index][0] == 5): ?>
									<div class="form-group name" style="color:#666;">
												<i class="icon-cake" style="font-size:20px;"></i> <label class="control-label"><?=$ufm_required_star[$index]?><?=$value?></label>
												<div class="control-box">
																<div class="radio-box" style="left:110px;">
																	<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
																		<?php if ($content_key > 0): ?>
																			<label class="form-radio"><input type="checkbox" class="form-control1 <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>][]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'> <?=$content_value?></label>
																		<?php endif; ?>
																	<?php endforeach; ?>
																</div>
												</div>
									</div>
									<?php else: ?>

									<div class="form-group w170">
													<div class="control-box">
													<i class="icon-cake"></i>
														<label class="control-label"><?=$ufm_required_star[$index]?><?=$value?></label>
									<?php if ($ufm_content[$index][0] == 2): ?>
										<!-- text --><input type='text' class='form-control <?=$ufm_required[$index]?>' name='customerInput[<?=$key?>]' value=''>
									<?php elseif ($ufm_content[$index][0] == 1): ?>
										<!-- date --><input type="text" class="form-control datepicker <?=$ufm_required[$index]?>" name="customerInput[<?=$key?>]" readonly="true" style='display: inline; width: 338px;' placeholder="<?=$ClickRightDate?>">
									<?php elseif ($ufm_content[$index][0] == 6): ?>
										<!-- number --><input type='number' onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" class='form-control <?=$ufm_required[$index]?> number' name='customerInput[<?=$key?>]' min='0' value=''>
									<?php else: ?>

										<!-- multi -->


											<?php if ($ufm_content[$index][0] == 4): ?>

												<!-- 下拉 -->
												<select class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='width: 338px;'>
													<option value=''><?=$Select?></option>
													<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
														<?php if ($content_key > 0): ?>
															<option value='<?=$content_key?>'><?=$content_value?></option>
														<?php endif; ?>
													<?php endforeach; ?>
												</select>
											<?php endif; ?>
									<?php endif; ?>
										</div>
									</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
							<input type="hidden" name="back" value="<?=$back?>">
							<input type='hidden' name='ufm_id' value='<?=$list['ufm_id']?>'>
							<input type='hidden' name='card_owner' value='0'>
							<input type='hidden' name='ufm_col_num' value='<?=$list['ufm_col_num']?>'>
							<input type='submit' class="btn normal send" name='send' id='send' value='送出'>
						</div>
					</div>
					</form>
                    <div class="pagination_box">
                    <a href="/gold/activity/C/enroll/<?=$category_id?>" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> 回列表</a>
                    </div>
                    </div>
				</section>
			</div>
		</main>
<!--分享彈出窗 JS-->
<script src="/template/temp10/js/baze.modal.js"></script> 
<script>
$(document).ready(function() {
    $('.fancybox-share').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
});
//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$this->share_url?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_img=<?=$this->share_prd_image;?>';
    var i_val = "jecp://<?=$share_prd_image?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_url=<?=$share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>
<style>
    @media (min-width:980px) {
      .activity_type {
        display: none;
      }
    }
</style>   
