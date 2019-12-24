<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript"> 
window.onload = function(){
	document.gomypay_form.submit();
} 
</script>
</head>
<body>
<form name='gomypay_form' accept-charset="UTF-8" method="post" id="uc-allpay-wps-form" action="<?=$gateway_url?>">
<?=$form_info?>
</form>
</body>
</html>
