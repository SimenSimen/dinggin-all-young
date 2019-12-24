<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_detail_css', $data); ?>

<!-- <link rel="stylesheet" type="text/css" href="/css/form.css"> -->
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

<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><? //=$list['ufm_name']?></header>
<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'share_btn'); ?>
<div class="wrapper">
 <section class="content">
      <h2 class="content-title set-c-title"><?=$list['ufm_name']?></h2>
      <div class="word-area set-c-word">
      	<?=$list['ufm_aim']?>
    	<form action='/form/signup/0' method='post' name='bottom_form' id='bottom_form'>
	    	<table border='0' id='form_table'>
				<tr>
					<td style="white-space: nowrap;" class='right_td'>
						<span class='red_star'>*</span><?=$ufm_title[0]?>
					</td>
					<td style="white-space: nowrap;">
						<input type='text' name='name_r' id='u_name' class="required form-control" minlength="2" maxlength="16">
					</td>
				</tr>
				<tr>
					<td class='right_td'>
						<span class='red_star'>*</span><?=$ufm_title[1]?>
					</td>
					<td>
						<input type='text' name='mphone_r' id='u_mphone' class="required number form-control" minlength="10" maxlength="10">
					</td>
				</tr>
				<tr>
					<td class='right_td'>
						<span class='red_star'>*</span><?=$ufm_title[2]?>
					</td>
					<td>
						<input type='text' name='email_r' id='u_email' class="required email form-control" maxlength="255">
					</td>
				</tr>
					<?php if (!empty($ufm_title) && count($ufm_title) > 3): ?>
					<?php foreach ($ufm_title as $key => $value): ?>
						<?php if ($key > 2): ?>
							<?php $index=($key-3);?>
							<tr>
								<td class='right_td' style="word-break:break-all; width: 100px;">
									<?=$ufm_required_star[$index]?><?=$value?>
								</td>
								<td>

									<?php if ($ufm_content[$index][0] == 2): ?>
										<!-- text --><input type='text' class='form-control <?=$ufm_required[$index]?>' name='customerInput[<?=$key?>]' value=''>
									<?php elseif ($ufm_content[$index][0] == 1): ?>
										<!-- date --><input type='text' class="form-control datepicker <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' readonly="true" style='display: inline; width: 338px;' placeholder='<?=$ClickRightDate?>'>
									<?php elseif ($ufm_content[$index][0] == 6): ?>
										<!-- number --><input type='number' class='form-control <?=$ufm_required[$index]?> number' name='customerInput[<?=$key?>]' value=''>
									<?php else: ?>

										<!-- multi -->

											<?php if ($ufm_content[$index][0] == 3): ?>

												<!-- 單選 -->
												<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
													<?php if ($content_key > 0): ?>
														<p><input type='radio' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></p>
													<?php endif; ?>
												<?php endforeach; ?>

											<?php elseif ($ufm_content[$index][0] == 4): ?>

												<!-- 下拉 -->
												<select class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='width: 338px;'>
													<option value=''><?=$Select?></option>
													<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
														<?php if ($content_key > 0): ?>
															<option value='<?=$content_key?>'><?=$content_value?></option>
														<?php endif; ?>
													<?php endforeach; ?>
												</select>

											<?php else: ?>

												<!-- 複選 -->
												<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
													<?php if ($content_key > 0): ?>
														<p><input type='checkbox' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>][]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></p>
													<?php endif; ?>
												<?php endforeach; ?>

											<?php endif; ?>

									<?php endif; ?>
									
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" name="back" value="<?=$back?>">
						<input type='hidden' name='ufm_id' value='<?=$list['ufm_id']?>'>
						<input type='hidden' name='card_owner' value='0'>
						<input type='hidden' name='ufm_col_num' value='<?=$list['ufm_col_num']?>'>
						<p style="height:20px">&nbsp;</p>
						<input type='submit' class="submit btn btn-default" name='send' id='send' value='送出' style="font-size: 24px; height: 46px; width: 200px;">
					</td>
				</tr>
	    	</table>
			<p style="height:220px">&nbsp;</p>
		</form>  
      </div>   
</section>
</div>



<!--分享彈出窗 JS-->
<script src="/template/temp10/js/baze.modal.js"></script> 
<script>
	// var elems = $('[data-baze-modal]');
	// elems.bazeModal({
	// 	onOpen: function () {
	// 	  alert('opened');
	// 	},
	// 	onClose: function () {
	// 	  alert('closed');
	// 	}
	// });
	// $('#ngehe').bazeModal();
</script>
