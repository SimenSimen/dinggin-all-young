<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />

	<!-- seo -->
	<title><?=$_Registered?> <?=$web_config['title']?></title>
	<link rel="shortcut icon" href="<?=$web_config['logo']?>" />
	<meta name="keywords"     content=''>
	<meta name="description"  content=''>
	<meta name="author"       content=''>
	<meta name="copyright"    content=''>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script type="text/javascript" src="/js/jquery.blockUI.js"></script>

	<!-- Le styles -->
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/common.css" rel="stylesheet">

	<style type="text/css">
		.info_prompt
		{
			text-align: right;
			color: #F60;
			font-size: 20px;
		}
		body
		{
			background: url('/images/web_style_images/<?=$web_banner_dir?>/bg_login_001.jpg') no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
    	#vcode_img { zoom: 200%; -moz-transform: scale(2); position: relative; }
	</style>

	<script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '<?=$NotFirefoxChromIE?>';

    $(function()
    {
    	$('#account').focus();
    	
		if(browser == 'IE')
		{
			$('#vcode_img').css('top', '-7px');
			$('#vcode_img').css('left', '0px');
		}
		else if(browser == 'Firefox')
		{
			$('#vcode_img').css('top', '-7px');
       		$('#vcode_img').css('left', '27px');
		}
		else
		{
			$('#vcode_img').css('top', '-3px');
			$('#vcode_img').css('left', '0px');
		}
    });
  </script>

</head>
<body>

  <div class="container" style="width:360px;">

    <form class="form-signin register" name='register_form' id='register_form' action="/index/register/<?=$register_code?>" method="post">

    	<!--系統標題-->
		<p class="form-signin-heading"><b><?=str_replace("行動商務", "", $web_config['title'])?><?=$Registered?></b></p>
		<p style="text-align:right;">&nbsp;</p>

    	<!--註冊資訊欄位-->
		<input type="text" 		placeholder="<?=$AccountNumber?>"	name='account' 		id='account' 		class="input-block-level" maxlength="32" style="width:300px;"><p class='info_prompt' id='account_error'></p>
		<input type="password" 	placeholder="<?=$Password?>"		name='password' 	id='password' 		class="input-block-level" maxlength="32"><p class='info_prompt' id='password_error'></p>
		<input type="password" 	placeholder="<?=$CheckPassword?>"	name='chk_password' id='chk_password' 	class="input-block-level" maxlength="32"><p class='info_prompt'></p>
		<input type="text" 		placeholder="<?=$Email?>"			name='email' 		id='email' 			class="input-block-level" maxlength="128"><p class='info_prompt' id='email_error'></p>
		<input type="password" 	placeholder="<?=$CardNumber?>"		name='key_number' 	id='key_number' 	class="input-block-level" maxlength="6" style="width:120px;">
		<input type="password" 	placeholder="<?=$LicenseKey?>"		name='key_value' 	id='key_value' 		class="input-block-level" maxlength="8" style="width:176px;"><p class='info_prompt' id='keys_error'></p>
		
    	<!--驗證碼-->
		<input type="text" name='vcode' id='vcode' class="input-block-level" placeholder="<?=$ScanRightNum?>" maxlength="5" style="width:62%;">
		<?=$img?>
		<p class='info_prompt' id='vcode_error'></p>
        <input type='hidden' name='hiddenvcode' value='<?=$hiddenvcode?>'>
        <input type='hidden' name='did' value='<?=$domain_id?>'>

    	<!--提示錯誤訊息-->
		<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>

    	<!--按鈕區域-->
		<p style="text-align:right;">
			<input class="btn btn-large btn-default" style="font-family: '微軟正黑體'; width: 49%;" type="button" onclick="window.location.href='/index/login'" value='<?=$ReturnsLogin?>'>
			<input class="btn btn-large btn-primary" style="font-family: '微軟正黑體';" type="submit" value='<?=$SendRegisteredData?>'>
		</p>

    </form>

  </div> <!-- /container -->

  <script type="text/javascript">
    $(function()
    {
		//form register submit
		var form_register = $('#register_form');
		form_register.submit( function( event )
		{
			$.blockUI({ 
              message: '<?=$SendRegisteredDataNow?>',
              css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .7, 
                color: '#fff' 
              } 
            });
			//validate
			$.ajax(
			{ 
				type: "post", 
				url : '<?=$base_url?>validate/register',
				cache: false,
				data:
				{
					account:    $('input[name="account"]').val(),
					password:   $('input[name="password"]').val(),
					repassword: $('input[name="chk_password"]').val(),
					email:      $('input[name="email"]').val(),
					key_number: $('input[name="key_number"]').val(),
					key_value:  $('input[name="key_value"]').val(),
					vcode:      $('input[name="vcode"]').val(),
					hiddenvcode:$('input[name="hiddenvcode"]').val(),
					did: 		$('input[name="did"]').val()
				},
				dataType: "json",
				async: false,
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
				// $('#prompt').html(response);
				// $('#prompt').fadeIn();
				// event.preventDefault();

					//偵測空白
					if(!response.empty_error)
					{
						$('#prompt').html(response.empty_result);
						$('#prompt').fadeIn();
						$('input[name="account"]').focus();
						$.unblockUI();
					}
					else
					{
						$('#prompt').html('');
					}

					//驗證結果
					if(!response.account_error)
					{
						$('#account_error').html(response.account_result);
						$('#account_error').fadeIn();
						$('input[name="account"]').focus();
						$.unblockUI();
					}
					else
					{
						$('#account_error').html('');

						if(!response.password_error)
						{
							$('#password_error').html(response.password_result);
							$('#password_error').fadeIn();
							$('input[name="usr_password"]').focus();
							$.unblockUI();
						}
						else
						{
							$('#password_error').html('');

							if(!response.email_error)
							{
								$('#email_error').html(response.email_result);
								$('#email_error').fadeIn();
								$('input[name="usr_email"]').focus();
								$.unblockUI();
							}
							else
							{
								$('#email_error').html('');

								if(!response.keys_error)
								{
									$('#keys_error').html(response.keys_result);
									$('#keys_error').fadeIn();
									$('input[name="vcode"]').focus();
									$.unblockUI();
								}
								else
								{
									$('#keys_error').html('');

									if(!response.vcode_error)
									{
										$('#vcode_error').html(response.vcode_result);
										$('#vcode_error').fadeIn();
										$('input[name="vcode"]').focus();
										$.unblockUI();
									}
									else
									{
										$('#vcode_error').html('');
									}
								}
							}
						}
					}

					//最後結果阻斷submit
					if(response.result_error == 0)
					{
						event.preventDefault();
						$.unblockUI();
					}
				}
			});
		});
	});
  </script>

</body>
</html>