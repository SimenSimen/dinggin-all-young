<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
</head>
<body>
	<form method="post" action="/archive/con_edit">
		<br>
		<span>目前名稱: </span>
		<input type="text" name="edit_name" value="<?=$edit['name']?>"  maxlength="20">
		
		<input type="hidden" name="edit_id" value="<?=$edit['id']?>">
		<input type="hidden" name="type" value="<?=$type?>">
		
		<br>
		<span>目前狀態：</span>
		<select name="file_enable">
			<option value='1' <?=($edit['enable'] == 1)?'selected':'';?>>公開中</option>
			<option value='0' <?=($edit['enable']== 0)?'selected':'';?>>隱藏中</option>
		</select>
		<br>
		<input class="btn btn-default" type="button" onclick="javascript:history.back(1);" value="返回列表">
		<input class="btn btn-primary" type="submit" name="edit_submit" value="送出">
	</form>
</body>
</html>