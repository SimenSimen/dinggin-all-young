<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
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
		.btn {
			width: 170px;
			font-size: 18px;
		}

		#menu_title {
			margin-top:0px;
			font-family: '微軟正黑體';
			color: <?=$web_config['admin_font_color']?>;
			cursor: pointer;
		}
	</style>

  	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
<div id='menu-link-table'>

	<h3 id='menu_title' onclick="top.frames['content-frame'].location='/providers/main'">供應商專區</h3>

	<p><button class="btn btn-warning" style="background: indianred;" type="button" onclick="top.frames['content-frame'].location='/providers/auth_user'">個人設定</button></p>

    <p><button class="btn btn-success" type="button" onclick="top.frames['content-frame'].location='/products/products_info'">商品新增</button></p>

	<p><button class="btn btn-success" type="button" onclick="top.frames['content-frame'].location='/products/get_provider_products'">我的商品</button></p>
      
    <p><button class="btn btn-warning" type="button" onclick="top.frames['content-frame'].location='/providers/product_commits'">商品提交紀錄</button></p>
  
	<!--登出-->
	<p><button class="btn btn-default" type="button" onclick="top.window.location.href='/providers/logout'">登出</button></p>

</div>
</body>
</html>
