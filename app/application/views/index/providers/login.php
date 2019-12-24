<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />

	<!-- seo -->
	<title><?=$SignIn_3?> <?=$web_config['title']?></title>
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
    .prompt-box {
      display: none;
      border:1px solid #000;
      height:30px;
      width:97%;
      margin-left:10px;
      position: relative;
      border: 0px;
      font-size: 14px;
      text-align: right;
    }
    #vcode_img:hover + .prompt-box {
        display: block;
    }
    body
    {
      background: url('/images/web_style_images/default/bg_login_001.jpg') no-repeat center center fixed;
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

    $(function() {
      $('#account').focus();
      
      if (browser == 'IE') {
        $('#vcode_img').css('top', '-7px');
        $('#vcode_img').css('left', '0px');
      } else if(browser == 'Firefox') {
        $('#vcode_img').css('top', '-7px');
        $('#vcode_img').css('left', '27px');
      } else {
        $('#vcode_img').css('top', '-3px');
        $('#vcode_img').css('left', '0px');
      }
    });
  </script>

</head>
<body>
<div class="container" style="width:360px;">
    <form class="form-signin" name='signin_form' id='signin_form' action="/providers/auth" method="post">
    	<!--系統標題-->
		<p class="form-signin-heading"><b>供應商登入</b></p>
    	<p style="text-align:right;">&nbsp;</p>

    	<!--登入帳號密碼欄位-->
  		<input type="text" placeholder="<?=$AccountNumber?>" name="account" id="account" class="input-block-level" maxlength="32" autocomplete="off">
  		<input type="password" placeholder="<?=$Password?>"	name="password" id="password" class="input-block-level" maxlength="32"><input type='hidden' name='host' value='<?=$host?>'>

    	<!--驗證碼-->
  		<input type="text" name='vcode' id='vcode' class="input-block-level" placeholder="<?=$ScanRightNum?>" maxlength="5" style="width:62%;" autocomplete="off">
  		<?=$img?>

		<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>
		
		<p>
		<p style="text-align:right;">
			<button class="btn btn-large btn-default" type="submit" style="width: 100%;"><?=$LoginBTN?></button>
		</p>
  		
		<?/*php if ($host['domain'] != 'webtest.test888.org'): ?>
			<p style="text-align:center;"><button class="btn btn-large btn-default" type="button" style="width: 100%;" onclick="window.location.href='/index/request'"><?=$ForgotPassword?></button>
		<?php endif; ?>
		<?php if ($web_config['register_status'] == 1): ?>
			<p style="text-align:center;"><button class="btn btn-large btn-danger" type="button" style="width: 100%;" onclick="location.href='/index/register/<?=$register_code?>'"><?=$GotoAccount?></button>
		<?php endif; */?>
    
    	<input type='hidden' id='base_url' value='<?=$base_url?>'>
    </form>

  </div>

  <!-- Le javascript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
    $(function()
    {
      $(window).load(function(){
      	$('#account').focus();
      });

      $('#vcode_img').click(function(){
        $('#vcode_img').attr('src', $('#vcode_img').attr('src'));
      });

      //form login submit
      var signin_form = $('#signin_form');
      var account     = $('#account');
      var password    = $('#password');
      signin_form.submit( function( event )
      {
        //validate
        if(account.val().length == 0 || password.val().length == 0)
        {
    			$('#prompt').html('<?=$ScanAccount?>');
    			event.preventDefault();
        }
        else
        {
          if($('#vcode').val().length != 0)
          {
            $.blockUI({ 
              message: '<?=$DataValidation?>',
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
            $.ajax(
            { 
              type: "post", 
              url : $('#base_url').val()+'index/s_decode',
              cache: false,
              data:
              {
                vcode: $('#vcode').val(),
                hide_vcode: '<?=$hiddenvcode?>',
              },
              // dataType: "json",
              async: false,
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              },
              success: function(response)
              {
                if (response == '0') {
                  $('#prompt').html('<?=$VerificationError?>');
                  event.preventDefault();
                  $.unblockUI();
                } else {

                }
              }
            });
          }
          else
          {
            $('#prompt').html('<?=$ScanVerification?>');
            event.preventDefault();
            $.unblockUI();
          }
        }
      });
    });
  </script>

</body>
</html>