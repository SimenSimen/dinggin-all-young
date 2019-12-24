<title>翻譯系統</title>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<select id="selnet">
	<option value="">請選擇</option>
	<? foreach ($list as $key => $value):?>
		<option value="<?=$value['d_id']?>" <?=($lid==$value['d_id'])?'selected':'';?>><?=$value['d_title'].'('.$value['d_url'].')'?></option>
	<? endforeach;?>
	<option value="9999" <?=($lid=='9999')?'selected':'';?>>其他</option>
</select>
<table class="TB_COLLAPSE">
  <caption>翻譯系統<br>(一般會員操作部分http://<?=$_SERVER['HTTP_HOST']?>/gold/index/0918666375)</caption>
  <thead>
    <tr>
      <th>參考中文</th>
      <th>繁體中文</th>
      <th>英文</th>
      <th>日文</th>
      <th>簡體中文</th>
    </tr>
  </thead>
  <form action="/translation/data_AED" method="post">

	  <? if(!empty($dbdata)):
	  	 	foreach ($dbdata as $key => $value):
	  ?>
	  	<tr>
		    <td><?=$value['SYS']?></td>
		    <td><input name="TW[]" value="<?=$value['TW']?>"></td>
		    <td><input name="ENG[]" value="<?=$value['ENG']?>"></td>
		    <td><input name="JAP[]" value="<?=$value['JAP']?>"></td>
		    <td><input name="CN[]" value="<?=$value['CN']?>"></td>
		    <input type="hidden" name="did[]" value="<?=$value['d_id']?>">
	  	</tr>
	  <? 	endforeach;
	  	 endif;
	  ?>
		</table>
		<? if($lid!=''):?>
		<table style="float: right;">
			<tr>
				<td>
					<input type="submit" value="儲存">
				</td>
			</tr>
		</table>
		<input type="hidden" name="listid" value="<?=$lid?>">
		<? endif;?>
</form>
<script>
	$('#selnet').change(function(){
		window.location.href="/translation/index/"+$(this).val();
	});
</script>
<style>
table.TB_COLLAPSE {
  width:100%;
  border-collapse:collapse;
}
table.TB_COLLAPSE caption {
  padding:10px;
  font-size:24px;
  background-color:#f3f6f9;
}
table.TB_COLLAPSE thead th {
  padding:5px 0px;
  color:#fff;
  background-color:#915957;
}
table.TB_COLLAPSE tbody td {
  padding:5px 0px;
  color:#555;
  text-align:center;
  background-color:#fff;
  border-bottom:1px solid #915957;
}
table.TB_COLLAPSE tfoot td {
  padding:5px 0px;
  text-align:center;
  background-color:#d6d6a5;
}
</style>