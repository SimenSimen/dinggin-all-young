<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
</head>
<body>
	<form method="post" action="/gallery/con_edit">
		<span>目前名稱: <?=$edit['name']?></span><br>
		<input type="text" name="edit_name" value="" placeholder="欲修改名稱" maxlength="20">
		
		<input type="hidden" name="edit_id" value="<?=$edit['id']?>">
		<input type="hidden" name="type" value="<?=$type?>">
		
		<input class="btn btn-default" type="button" onclick="javascript:history.back(1);" value="返回列表">
		<input class="btn btn-primary" type="submit" name="edit_submit" value="送出">
	</form>
</body>
</html>