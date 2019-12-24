<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />

	<!-- seo -->
  <title><?=$web_config['title']?></title>
	<link rel="shortcut icon" href="<?=$web_config['logo']?>" />
	<meta name="keywords"     content=''>
	<meta name="description"  content=''>
	<meta name="author"       content=''>
	<meta name="copyright"    content=''>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

	<!-- Le styles -->
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/common.css" rel="stylesheet">
  <style type="text/css">
    body { background: #cccccc; }
    <?php if ($get_device_type > 0): ?>
      body { padding-top: 0px; padding-bottom: 0px; }
    <?php endif; ?>
  </style>

</head>
<body style="width:320px;margin: 0px auto;">
  <div class="container" style="width:320px;">
    <div class="form-signin" name='signin_form' id='signin_form'>
        <p class="form-signin-heading"><b><?=$SelectOperating?></b></p>
        <p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-primary" type="button" style="padding: 11px 80px;font-size: 24px;" onclick="window.location.href='/cart/user_login/<?=$cset_code?>/record'"><?=$OrderTracking?></button></p>
        <p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-warning" type="button" style="padding: 11px 80px;font-size: 24px;" onclick="window.location.href='/cart/store/<?=$cset_code?>'"><?=$BackHome?></button></p>
        <?php if ($user_login): ?><p style="text-align: center; margin: 15px 0 20px;"><button class="btn btn-default" type="button" style="padding: 11px 80px;font-size: 24px;" onclick="window.location.href='/cart/user_logout/<?=$cset_code?>'"><?=$_SignOut?></button></p><?php endif; ?>
    </div>
  </div> <!-- /container -->
</body>
</html>