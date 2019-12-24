<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
  	<title>供應商專區</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="shortcut icon" href="/images/logo.gif" />
</head>
<style>
	#frameContentLeft {
		position: fixed;
		top: 10px;
		left: 0;
		height: 100%;
		width: 200px;
		overflow: hidden;
		vertical-align: top;
	}

	#frameContentRight {
		position: absolute;
		left: 200px;
		top: 10px;
		height: 100%;
		width: 100%;
		right: 0;
		bottom: 0;
		overflow: hidden;
		background: #fff;
	}
</style>
<body>
	<div>
        <iframe id="frameContentLeft" src="/providers/menu" name="menu-frame" frameborder="no" scrolling="yes" noresize="noresize"></iframe>
        <iframe id="frameContentRight" src="/providers/main" name="content-frame" frameborder="no" scrolling="yes"></iframe>
    </div>
</body>
</html>