<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="/css/admin.css">

  <!-- accordion -->
  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="/css/accordion/accordion.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/accordion/accordion.css">
	
  <style type="text/css">
		.btn
		{
			width: 170px;
			font-size: 18px;
		}
		#menu_title
		{
			margin-top:0px;
			font-family: '微軟正黑體';
      color: <?=$web_config['admin_font_color']?>;
      cursor: pointer;
		}
	</style>

  <!--js-->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>

</head>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
  超管首頁
<form method="post" >
  <textarea name="d_content" id='prd_content' ><?=$dbdata['d_val']?></textarea>
  <input type="submit" value="儲存">
</form>


</body>

</html>
<script src="/js/myjava/product.js"></script>
