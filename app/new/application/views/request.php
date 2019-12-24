<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />

	<!-- seo -->
	<title><?=$_ForgotPassword?> <?=$web_config['title']?></title>
	<link rel="shortcut icon" href="<?=$web_config['logo']?>" />
	<meta name="keywords"     content=''>
	<meta name="description"  content=''>
	<meta name="author"       content=''>
	<meta name="copyright"    content=''>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

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

    <form class="form-signin" name='signin_form' id='signin_form' action="/index/request" method="post">

    	<!--系統標題-->
		<p class="form-signin-heading"><b><?=$ForgotPassword?></b></p>
    	<p style="text-align:right;">&nbsp;</p>

    	<!--登入帳號密碼欄位-->
  		<input type="text" 	placeholder="<?=$ScanYourAccount?>" name='account' id='account' class="input-block-level" maxlength="32">
  		<input type="text" 	placeholder="<?=$ScanYourEmail?>" name='email'   id='email'   class="input-block-level" maxlength="255">

    	<!--驗證碼-->
  		<input type="text" name='vcode' id='vcode' class="input-block-level" placeholder="<?=$ScanRightNum?>" maxlength="5" style="width:62%;">
  		<?=$img?>
      <div class='prompt-box'><?=$PleaseRefresh?></div>

    	<!--提示錯誤訊息-->
  		<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>

    	<!--按鈕區域-->
  		<p style="text-align:right;">
        <input type='hidden' id='base_url' value='<?=$base_url?>'>
  			<button class="btn btn-large btn-default" type="button" onclick="window.location.href='/index/login'"><?=$Cancel?></button>
  			<button class="btn btn-large btn-primary" type="submit"><?=$Send?></button>
  		</p>

    </form>

  </div> <!-- /container -->

  <!-- Le javascript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
    function validateEmail(email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if( !emailReg.test( email ) ) {
        return 0;
      } else {
        return 1;
      }
    }
    $(function()
    {
      $('#vcode_img').click(function(){
        $('#vcode_img').attr('src', $('#vcode_img').attr('src'));
      });

      //form login submit
      var signin_form = $('#signin_form');
      var account     = $('#account');
      var email       = $('#email');
      signin_form.submit( function( event )
      {
        //validate
        if(account.val().length == 0 || email.val().length == 0)
        {
    			$('#prompt').html('<?=$ScanYourAccountEmail?>');
    			event.preventDefault();
        }
        else
        {
          if($('#vcode').val().length != 0)
          {
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
              error: function(XMLHttpRequest, textStatus, errorThrown)
              {
              },
              success: function(response)
              {
                if(response == '0')
                {
                  $('#prompt').html('<?=$VerificationError?>');
                  event.preventDefault();
                }
                else
                {
                  if(email.val().length != 0 && validateEmail(email.val()) == 0)
                  {
                  $('#prompt').html('<?=$EmailWrong?>');
                    event.preventDefault();
                  }
                }
              }
            });
          }
          else
          {
            $('#prompt').html('<?=$ScanVerification?>');
            event.preventDefault();
          }
        }
      });
    });
  </script>

</body>
</html>