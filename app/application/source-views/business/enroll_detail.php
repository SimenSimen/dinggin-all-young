<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
<?
$istemplate8=false;
//$istemplate8=true;
?>


	<!-- css -->
	<link rel="stylesheet" type="text/css" href="/css/form.css">
  	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

	<!-- js -->
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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

        });
        //圖片縮圖
/*
		$(window).load(function(){
			$("img").each(function(i){
				if($(this).attr('src') != '/images/calendar.png' )
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
*/		
    </script>



		<?php $this -> load -> view('template/template3_seo', $data); ?>
	<!------template8-------->
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/layout.css" />
		
<? if ($istemplate8){ ?>
        <script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery-1.9.0.min.js"></script>
<? }//if ($istemplate8){ ?>

        <link href="<?=$base_url?>template/temp3/css/font-awesome.min.css" rel="stylesheet">

        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
		<?php $this -> load -> view('template/template3_css', $data); ?>
</style>

	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header">
				<a href="#menu"></a>
				關於我 / <?=$viewname?>報名表單
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
<table style="margin: 0px auto;">
	<tr>
		<td id='aim' style="padding-top:10px">
			<?
			echo str_replace("<img ", "<img style='width:100%;height:auto' ", $uform['ufm_aim']);			
			?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
</table>
<table style="margin: 0px auto;width:80%">
	<tr>
    	<td id='form'>
    		<form action='/form/signup/0' method='post' name='bottom_form' id='bottom_form'>
	    	<table border='0' id='form_table' width="90%">
				<tr>
					<td style="white-space: nowrap;" class='right_td'>
						<span class='red_star'>*</span><?=$ufm_title[0]?>
					</td>
					<td style="white-space: nowrap;">
						<input type='text' name='name_r' id='u_name' class="required form-control" minlength="2" maxlength="16" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class='right_td'>
						<span class='red_star'>*</span><?=$ufm_title[1]?>
					</td>
					<td>
						<input type='text' name='mphone_r' id='u_mphone' class="required number form-control" minlength="10" maxlength="10" style="width:100%">
					</td>
				</tr>
				<tr>
					<td class='right_td' width="40%">
						<span class='red_star'>*</span><?=$ufm_title[2]?>
					</td>
					<td>
						<input type='text' name='email_r' id='u_email' class="required email form-control" maxlength="255" style="width:100%">
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
										<!-- text --><input type='text' class='form-control <?=$ufm_required[$index]?>' name='customerInput[<?=$key?>]' value='' style="width:100%">
									<?php elseif ($ufm_content[$index][0] == 1): ?>
										<!-- date --><input type='text' class="form-control datepicker <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' readonly="true" style='display: inline; width: 70%;' placeholder='請點選右側圖示選取日期'>
									<?php elseif ($ufm_content[$index][0] == 6): ?>
										<!-- number --><input type='number' class='form-control <?=$ufm_required[$index]?> number' name='customerInput[<?=$key?>]' value='' style="width:100%">
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
												<select class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style="width:90%">
													<option value=''>請選擇</option>
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
						<input type='submit' class="submit btn btn-default" name='send' id='send' value='送　出' style="font-size: 24px; height: 46px; width: 200px;">
					</td>
				</tr>
	    	</table>
			<p style="height:220px">&nbsp;</p>
			</form>
		</td>
  	</tr>
</table>

		  
	   </div><!--/page-->
  </body>
</html>
