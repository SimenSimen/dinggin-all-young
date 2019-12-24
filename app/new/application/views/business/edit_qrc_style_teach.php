<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$QrcodeTitle?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>


<style type="text/css">
	#table tr td
	{
		font-family:'微軟正黑體';
		font-size: 20px;
	}
	#eye_table tr td
	{
		padding: 10px;
		width: 430px;
		vertical-align: top;
		text-align: left;
	}
</style>

</head>

<center>
<body>

<img src='/images/edit_qrc_style_teach.png'>

<table id='table' class="table table-hover">

<tr><td style="width:6%;"><?=$Project?></td><td><?=$Explanation?></td></tr>
<tr><td>1.</td><td><?=$Exp_1?></td></tr>
<tr><td>2.</td><td><?=$Exp_2?></td></tr>
<tr><td>3.</td><td><?=$Exp_3?></td></tr>
<tr><td>4.</td><td><?=$Exp_4?> <br><?=$Exp_5?></td></tr>
<tr><td>5.</td><td><?=$Exp_6?></td></tr>
<tr><td>6.</td><td><?=$Exp_7?></td></tr>
<tr><td>7.</td><td><?=$Exp_8?></td></tr>
<tr><td>8.</td><td><?=$Exp_9?></td></tr>
<tr><td>9.</td><td><?=$Exp_10?></td></tr>
<tr><td>10.</td><td><?=$Exp_11?></td></tr>
<tr><td>11.</td><td><?=$Exp_12?></td></tr>
<tr><td>12.</td><td><?=$Exp_13?></td></tr>
<tr><td>13.</td><td><?=$Exp_14?></td></tr>
<tr><td>14.</td><td><?=$Exp_15?></td></tr>
<tr><td>15.</td><td><?=$Exp_16?><br>
<table id='eye_table'><tr><td><img src='/images/qrcode_eye1.png'><td><img src='/images/qrcode_eye2.png'><tr><td><?=$Exp_17?><td><?=$Exp_18?></td></tr>

</table>


</body>
</html>
