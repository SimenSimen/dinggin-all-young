<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- seo -->
	<title><?=$uform['ufm_name']?> - <?=$web_config['title']?></title>
	<link rel="shortcut icon" href="<?=$web_config['logo']?>" />
	<meta name="keywords"     content=''>
	<meta name="description"  content=''>
	<meta name="author"       content=''>
	<meta name="copyright"    content=''>

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/form.css">
  	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

	<!-- js -->
  	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  	<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>

	<!-- bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- script -->
	<script type="text/javascript" charset="utf-8">
        $(document).ready( function(){
            $('#bottom_form').validate({
		        success: function(label) {
		            label.addClass("success").text("");
		        }
		    });

		    $('#u_mphone').mask('0000000000');

		    $.datepicker.regional['zh-TW']={
				dayNames:["<?=$Sunday?>","<?=$Monday?>","<?=$Tuesday?>","<?=$Wednesday?>","<?=$Thursday?>","<?=$Friday?>","<?=$Saturday?>"],
				dayNamesMin:["<?=$Date?>","<?=$One?>","<?=$Two?>","<?=$Three?>","<?=$Four?>","<?=$Five?>","<?=$Six?>"],
				monthNames:["<?=$January?>","<?=$February?>","<?=$March?>","<?=$April?>","<?=$May?>","<?=$June?>","<?=$July?>","<?=$August?>","<?=$September?>","<?=$October?>","<?=$November?>","<?=$December?>"],
				monthNamesShort:["<?=$January?>","<?=$February?>","<?=$March?>","<?=$April?>","<?=$May?>","<?=$June?>","<?=$July?>","<?=$August?>","<?=$September?>","<?=$October?>","<?=$November?>","<?=$December?>"],
				prevText:"<?=$Last?>",
				nextText:"<?=$Next?>",
				weekHeader:"<?=$Week?>",
				dateFormat:"yy-mm-dd"
			};
			$.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
			$(".datepicker").datepicker({
				showOtherMonths: true, 
				selectOtherMonths: true,
				showOn: "button",
				buttonImage: "/images/calendar.png",
			    buttonImageOnly: true,
			    buttonText: '<?=$_Date?>',
			    changeMonth: true,
      			changeYear: true, 
      			yearRange:"1911:+10"
			});

        });
        //圖片縮圖
		$(window).load(function(){
			$("img").each(function(i){
				if($(this).attr('src') != '/images/calendar.png')
				{
					$(this).removeAttr('width');
					$(this).removeAttr('height');
		 
					//取得影像實際的長寬
					var imgW = $(this).width();
					var imgH = $(this).height();
		 
					//計算縮放比例
					var w=980/imgW;
					var h=w;
					var pre=1;
					if(w>h){
						pre=h;
					}else{
						pre=w;
					}
		 
					//設定目前的縮放比例
					$(this).width(imgW*pre);
					$(this).height(imgH*pre);
				}
			});
		});
    </script>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<table style="margin: 0px auto;">
	<tr>
		<td id='aim'>
			<?=$uform['ufm_aim']?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
</table>
<table style="margin: 0px auto;">
	<tr>
    	<td id='form'>
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
						<input type='hidden' name='ufm_id' value='<?=$ufm_id?>'>
						<input type='hidden' name='card_owner' value='<?=$card_owner?>'>
						<input type='hidden' name='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
						<p style="height:20px">&nbsp;</p>
						<input type='submit' class="submit btn btn-default" name='send' id='send' value='<?=$_Send?>' style="font-size: 24px; height: 46px; width: 200px;">
					</td>
				</tr>
	    	</table>
			<p style="height:220px">&nbsp;</p>
			</form>
		</td>
  	</tr>
</table>

</body>
</html>