<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--[if lt IE 9]>
	<script src="/js/html5shiv.js"></script>
	<![endif]-->

	<!-- seo -->
	<title><?=$uform['ufm_name']?></title>
	<link rel="shortcut icon" href="/images/bookmark_icon.gif" />
	<meta name="keywords"     content=''>
	<meta name="description"  content=''>
	<meta name="author"       content=''>
	<meta name="copyright"    content=''>

	<!--icon-->
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<!-- fb -->
	<meta property="og:url"         content="<?=$actual_link?>"></meta>
	<meta property="og:title"       content="<?=$uform['ufm_name']?>"></meta>
	<meta property="og:description" content="<?=$uform['ufm_name']?>"></meta>
  	<?php if ($first_img['img_status']): ?><meta property="og:image" content="<?=$first_img['first_img']?>"/><?php endif; ?>

	<!-- js -->
	<link rel="stylesheet" href="/css/colors.css">
	<link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
	<script src="/js/jqm/jquery.js"></script>
	<script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>

	<?php if ($select_item_false): ?>
		<link type="text/css" href="/js/datebox/jqm-datebox.min.css" rel="stylesheet" /> 
	    <script type="text/javascript" src="/js/datebox/jquery.mousewheel.min.js"></script>
	    <script type="text/javascript" src="/js/datebox/jqm-datebox.core.min.js"></script>
	    <script type="text/javascript" src="/js/datebox/jqm-datebox.mode.datebox.min.js"></script>
	    <script type="text/javascript" src="/js/datebox/jquery.mobile.datebox.i18n.zh-CN.utf8.js"></script>  
	<?php endif; ?> 

	<script>

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

    	//圖片縮圖
		$(window).load(function(){
			$("img").each(function(i){
				//移除目前設定的影像長寬
				$(this).removeAttr('width');
				$(this).removeAttr('height');
	 
				//取得影像實際的長寬
				var imgW = $(this).width();
				var imgH = $(this).height();
	 
				//計算縮放比例
				var w=($(window).width()*91/100)/imgW;
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
			});

			$('#share_btn_table').css('width', ($(window).width()*91/100));
			$('#share_btn_table').css('text-align', 'center');
      		$('#share_btn_table').css('padding-right', '1px');
			$('#share_btn_table').css('padding-bottom', '20px');

			$(".share").each(function(i){
				//移除目前設定的影像長寬
				$(this).removeAttr('width');
				$(this).removeAttr('height');
	 
				//取得影像實際的長寬
				var imgW = $(this).width();
				var imgH = $(this).height();

				//計算縮放比例
				var w=35/imgW;
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
			});
		});
	</script>
  	
  	<style type="text/css">
	  	*{
	  		font-family: '微軟正黑體';
	  	}
		.ui-icon-loading {
		    background: url(/images/preLoader.png);
		    background-size: 46px 46px;
		    width:46px;
		    height:46px;
		    -webkit-transform: rotate(360deg);
		    -webkit-animation-name: spin;
		    -webkit-animation-duration: 1s;
		    -webkit-animation-iteration-count:  infinite;
		    -webkit-animation-timing-function: linear;
		    z-index: 99;
		}
		@-webkit-keyframes spin {
		    from {-webkit-transform: rotate(0deg);}
		    to {-webkit-transform: rotate(360deg);}
		}
		label.error {
		    background:url("/images/unchecked.gif") no-repeat 0px 0px;
		    padding-left: 16px;
		}

		label.success {
		    background:url("/images/checked.gif") no-repeat 0px 0px;
		    padding-left: 16px;
		}
	</style>

</head> 
<body> 

	<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

	<div data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
		<?php if (!$v): ?><a href="javascript:history.go(-1)" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a><?php endif; ?>
		<h1 class="ui-title" role="heading" aria-level="1"><?=$uform['ufm_name']?></h1>
	</div>

    <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

		<table id='share_btn_table'>
		  <tr>
		      <td>
		          <!-- fb -->
		          <a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
		              <img class='share' id='fb' title="分享到臉書" src="<?=$base_url?>/images/share_btn/facebook.png" />
		          </a>
		      </td>
		      <td>
		          <!-- weibo -->
		          <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
		              <img class='share' id='weibo' title="分享到微博" src="<?=$base_url?>/images/share_btn/weibo.png" />
		          </a>
		      </td>
		      <td>
		          <!-- googleplus -->
		          <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
		              <img class='share' id='google' title="分享到Google+" src="<?=$base_url?>/images/share_btn/googleplus.png" />
		          </a>
		      </td>
		      <td>
		          <!-- plurk -->
		          <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
		              <img class='share' id='plurk' title="分享到Plurk" src="<?=$base_url?>/images/share_btn/plurk.png" />
		          </a>
		      </td>
		      <td>
		          <!-- twitter -->
		          <a href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
		              <img class='share' id='twitter' title="分享到Twitter" src="<?=$base_url?>/images/share_btn/twitter.png" />
		          </a>
		      </td>
		      <td>
		          <a href="https://line.naver.jp/R/msg/text/?<?=$uform['ufm_name']?>%0D%0A<?=$actual_link?>" rel="nofollow" ><img src="<?=$base_url?>/images/share_btn/line.png" class='share' style='border:0;'/></a>
		      </td>
		      <td>
		          <!-- Email -->
		          <a href="mailto:?subject=<?=$uform['ufm_name']?>&body=<?=$uform['ufm_name']?>網址：<br><?=$actual_link?>">
		              <img class='share' id='email' title="使用Email告訴朋友" src="<?=$base_url?>/images/share_btn/email.png" />
		          </a>
		      </td>
		  </tr>
		</table>

		<?=$uform['ufm_aim']?>
		<form id="form1">
		
			<div id="fnameDiv" data-role="fieldcontain">
				<label for="fname" id="fnameLabel" name="fnameLabel"><span class='red_star'>*</span><?=$ufm_title[0]?></label>		
				<input id="fname" name="name_r" type="text" minlength="2" maxlength="16">
			</div>
			
		  	<div id="lnameDiv" data-role="fieldcontain">
				<label for="lname" id="lnameLabel"><span class='red_star'>*</span><?=$ufm_title[1]?></label>		
				<input id="lname" name="mphone_r" type="text" class='number' minlength='10' maxlength='10'/>
			</div>
			
		  	<div id="emailDiv" data-role="fieldcontain">
				<label for="email" id="emailLabel"><span class='red_star'>*</span><?=$ufm_title[2]?></label>		
				<input id="email" name="email_r" type="text" class='email' maxlength="255"/>
			</div>
			
			<?php if (!empty($ufm_title) && count($ufm_title) > 3): ?>
			<?php foreach ($ufm_title as $key => $value): ?>
				<?php if ($key > 2): ?>
					<?php $index=($key-3);?>

						<?php if ($ufm_content[$index][0] == 2): ?>

							<!-- text -->
							<div class="ui-field-contain">
							    <label for="customerInput_<?=$key?>"><?=$ufm_required_star[$index]?><?=$value?></label>
							    <input type="text" class="ui-input-text ui-body-a ui-corner-all ui-shadow-inset" name="customerInput[<?=$key?>]" id="customerInput_<?=$key?>" placeholder="<?=$value?>" value="">
							</div>

						<?php elseif ($ufm_content[$index][0] == 1): ?>
 
							<div id="<?=$key?>Div" data-role="fieldcontain">
								<?php if ($select_item_false): ?>
									<!-- date -->
									<label for="customerInput_<?=$key?>" id='date_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
		            				<input data-theme='a' data-role="datebox" data-options='{"mode": "datebox", "overrideDateFormat":"%Y/%m/%d", "defaultValue":[2001,0,1], "useFocus": true, "useButton": false}' type='date' id='customerInput_<?=$key?>' style="height: 25px;" id='<?=$key?>' name='customerInput[<?=$key?>]' class='<?=$ufm_required[$index]?>'>
		            				<span style='font-size: 14px; color: #888888; line-height: 30px;'>若下拉選項沒有出現，請試著捲動視窗</span>
								<?php else: ?>
									<label for="customerInput_<?=$key?>" id='date_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
									<input data-theme='a' type='date' id='customerInput_<?=$key?>' style="height: 25px;" id='<?=$key?>' name='customerInput[<?=$key?>]' class='<?=$ufm_required[$index]?>'>
								<?php endif; ?>
							</div>

						<?php elseif ($ufm_content[$index][0] == 6): ?>

							<!-- number -->
							<div class="ui-field-contain">
							    <label for="customerInput_<?=$key?>" id='number_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
							    <input type="number" class="ui-input-text ui-body-a ui-corner-all ui-shadow-inset number" name="customerInput[<?=$key?>]" id="customerInput_<?=$key?>" placeholder="<?=$value?>" value="">
							</div>

						<?php else: ?>

							<!-- multi -->

							<?php if ($ufm_content[$index][0] == 3): ?>

								<!-- 單選 -->
								<div id="<?=$key?>-<?=$content_key?>Div" data-role="fieldcontain">
									<label for="customerInput_<?=$key?>" id='radio_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
									<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
										<?php if ($content_key > 0): ?>
											<label for="<?=$key?>-<?=$content_key?>"><?=$content_value?></label>		
											<input type='radio' id='<?=$key?>-<?=$content_key?>' name='customerInput[<?=$key?>]' class='<?=$ufm_required[$index]?>' value='<?=$content_key?>'>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>

							<?php elseif ($ufm_content[$index][0] == 4): ?>

								<!-- 下拉 -->
								<div id="<?=$key?>-<?=$content_key?>Div" data-role="fieldcontain">
									<label for="customerInput_<?=$key?>" id='select_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
									<select name='customerInput[<?=$key?>]' id='<?=$key?>-<?=$content_key?>' class="<?=$ufm_required[$index]?>" <?php if ($select_item_false): ?>data-native-menu="false"<?php endif; ?>>
										<option value=''>請選擇</option>
										<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
											<?php if ($content_key > 0): ?>
												<option value='<?=$content_key?>'><?=$content_value?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
									<?php if ($select_item_false): ?><span style='font-size: 14px; color: #888888; line-height: 30px;'>若下拉選項沒有出現，請試著捲動視窗</span><?php endif; ?>
								</div>

							<?php else: ?>

								<!-- 複選 -->
								<div id="<?=$key?>-<?=$content_key?>Div" data-role="fieldcontain">
									<label for="customerInput_<?=$key?>" id='checkbox_item_<?=$key?>'><?=$ufm_required_star[$index]?><?=$value?></label>
									<?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
										<?php if ($content_key > 0): ?>
											<label for="<?=$key?>-<?=$content_key?>"><?=$content_value?></label>		
											<input type='checkbox' id='<?=$key?>-<?=$content_key?>' name='customerInput[<?=$key?>][]' class='<?=$ufm_required[$index]?>' value='<?=$content_key?>'>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>

							<?php endif; ?>

						<?php endif; ?>

				<?php endif; ?>
			<?php endforeach; ?>
			<?php endif; ?>
		    
		  	<div align="CENTER" id="submitDiv" data-role="fieldcontain">
		  		<input type='hidden' name='ufm_id' id='ufm_id' value='<?=$ufm_id?>'>
				<input type='hidden' name='card_owner' id='card_owner' value='<?=$card_owner?>'>
				<input type='hidden' name='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
		  		<input type='hidden' name='send' value='1'>
		  		<button type="submit" data-theme="b" name="submit" value="submit-value" class="ui-btn-hidden" aria-disabled="false">送出</button>
		    </div>
	    </form>

	</div><!-- /content -->

	<div align="CENTER" data-role="content" id="contentDialog" name="contentDialog" style="display:none">	
		<div>請填寫必要或正確格式資訊，重新送出</div>
		<a id="buttonOK" name="buttonOK" href="#page1" data-role="button" data-inline="true">返回</a>
	</div>	<!-- contentDialog -->
	
	<!-- contentTransition is displayed after the form is submitted until a response is received back. -->
	<div data-role="content" id="contentTransition" name="contentTransition"  style="display:none">	
		<div align="CENTER"><h4>請稍後，報名資料送出中</h4></div>
		<div align="CENTER"><canvas width="27" height="27" class="ui-icon-loading"></canvas></div>
	</div>	<!-- contentTransition -->
	
	<div data-role="content" id="contentConfirmation" name="contentConfirmation" align="center">
	    <!-- <p>您已報名成功，感謝您</p> -->
	    <p><span id="confirmation" name="confirmation"></span></p>
	</div><!-- contentConfirmation -->	
  	
  	<!-- footer -->	
	<div data-role="footer" class="ui-header ui-bar-b" data-theme="b" id="ftrMain" name="ftrMain" role="banner"><h4><?=$web_config['iqr_footer_text']?></h4></div>
	
</div><!-- /page -->

	<script>
	 
    $(document).ready(function() {
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
	
	$('#buttonOK').click(function() {
		hideContentDialog();
		showMain();
		return false;      
    });
   	
   	//validation
   	var form = $( "#form1" );
   	var errors;
   	var validator = form.validate({
   		success: function(label) {
            label.addClass("success").text("");
        },
        errorPlacement: function(error, element) {
			var element_id=element.attr("id");
			var pos;
        	var id;

        	pos = element.attr("id").search("-");
			id = element_id.substr(0, pos);

		    if (element.attr("type") == "checkbox" )
		        error.insertAfter("#checkbox_item_"+id);
		    else if (element.attr("type") == "radio" )
		        error.insertAfter("#radio_item_"+id);
		    else if (element.attr("type") == "date" )
		        error.insertAfter("#date_item_"+id);
		    else if (element.attr("type") == "number" )
		        error.insertAfter("#number_item_"+id);
		    else
		        error.insertAfter(element);
		}
   	});

    $('#form1').submit(function() {
   		var err = false;
        // Hide the Main content
        hideMain();
        
        // Reset the previously highlighted form elements      
        inputMapVar.each(function(index)
        {              
			$('#'+$(this).attr('id')+'Label').removeClass(MISSING); 
        });
        
        // Perform form validation
        inputMapVar.each(function(index)
        {  
			if($(this).val()==null || $(this).val()==EMPTY)
			{  
				$('#'+$(this).attr('id')+'Label').addClass(MISSING);
				err = true;
			}          
        });

        $('.number').each(function()
        {
        	if($(this).val().length != 0 && !$.isNumeric($(this).val()))
        	{
        		err = true;
        	}
        });

        // If validation fails, show Dialog content
        if(err == true || form.valid() == false)
        {            
			showContentDialog();
			$('input').each(function(){ $(this).blur(); });
			return false;
        }
        
        // If validation passes, show Transition content
//        showContentTransition();
        
        // Submit the form
        $.post("/form/signup/1", form1Var.serialize(), function(data){
//			confirmationVar.text(data);
//			hideContentTransition();
//			showConfirmation();
			alert('<?=$ufm_msg?>'); 
			window.location.href='<?=$public_barcodeurl?>';
        });        
        return false;      
    });    
    
	function hideMain(){
		hdrMainVar.hide();
		contentMainVar.hide();
		// ftrMainVar.hide();   
	}

	function showMain(){
		hdrMainVar.show();
		contentMainVar.show();
		// ftrMainVar.show();
	}

	function hideContentTransition(){
		contentTransitionVar.delay(800).fadeOut();
	}      

	function showContentTransition(){
		contentTransitionVar.show();
	}  

	function hideContentDialog(){
		contentDialogVar.hide();
	}   

	function showContentDialog(){
		contentDialogVar.show();
	}

	function hideConfirmation(){
		contentConfirmationVar.hide();
	}  

	function showConfirmation(){
		contentConfirmationVar.delay(1300).fadeIn();
	}
  </script>
</div> <!-- page1 -->


<!-- Page ends here -->
</body>
</html>
