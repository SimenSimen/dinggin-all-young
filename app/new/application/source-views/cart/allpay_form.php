<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- SEO -->
<title></title>

<script type="text/javascript"> 
window.onload = function(){
	document.allpay_form.submit();
} 
</script>
</head>
<body>
<form name='allpay_form' action="<?=$gateway_url?>"  accept-charset="UTF-8" method="post" id="uc-allpay-wps-form">
	<?=$form_info?>
</form>
</body>
</html>
