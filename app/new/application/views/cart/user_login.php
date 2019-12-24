<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

	<!-- seo -->
  <title><?=$web_config['title']?></title>
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
    body { background: #cccccc; }
    <?php if ($get_device_type > 0): ?>
      body { padding-top: 0px; padding-bottom: 0px; }
    <?php endif; ?>
  </style>
  <script type="text/javascript">
    $(function()
    {
      $('input[name=by_email]').focus();
    });
  </script>

</head>
<body style="width:320px;margin: 0px auto;">
<form method="post" action="/cart/user_login/<?=$cset_code?>/<?=$return?>">
  <div class="container" style="width:320px;">
    <div class="form-signin" name='signin_form' id='signin_form'>
        <p class="form-signin-heading"><b><?=$BuyerLogin?></b></p>
        <p style="text-align: center; margin: 15px 0 20px; font-size: 1.4em;"><span style='position: relative;top: -5px;'><?=$Mailbox?>&nbsp;</span><input style="width: 73%;" name='by_email' type='text' placeholder='<?=$Mailbox?>'></p>
        <p style="text-align: center; margin: 15px 0 20px; font-size: 1.4em;"><span style='position: relative;top: -5px;'><?=$Password?>&nbsp;</span><input style="width: 73%;" name='by_pw' type='password' placeholder='<?=$Password?>'></p>
        <p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-primary" type="submit" style="padding: 11px 80px;font-size: 24px;"><?=$SignIn_1?></button></p>
        <p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-warning" type="button" style="padding: 11px 80px;font-size: 24px;" onclick="window.location.href='<?=$return_url?>'"><?=$return_button?></button></p>
        <!-- <p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-default" type="button" style="padding: 11px 80px;font-size: 24px;">忘記密碼</button></p> --><!-- onclick="window.location.href='/cart/'"-->
        <p style="text-align: center; margin: 15px 0 24px;">※&nbsp;<?=$PasswordPhone?></p>
    </div>
  </div> <!-- /container -->
</form>
</body>
</html>