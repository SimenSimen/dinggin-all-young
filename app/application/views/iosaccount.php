<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<form action="IosAccount/data_AED" method="post">
<table id="otable" style="float:left;">
	<th>舊帳號</th>
	<th>取代帳號</th>
	<th>備註</th>
	<th>操作</th>
	<?  if(!empty($dbdata)):
			foreach ($dbdata as $key => $value):
	?>
				<tr id="tr_<?=$key?>">
					<td><input type="text" value="<?=$value['d_account']?>" required name="d_account[]"></td>
					<td><input type="text" value="<?=$value['d_newaccount']?>" required name="d_newaccount[]"></td>
					<td><input type="text" value="<?=$value['d_content']?>" name="d_content[]" placeholder="心靈雞湯"></td>
					<td><input type="button" value="刪除" class="datadel" delid="<?=$key?>" did="<?=$value['d_id']?>"></td>
					<td><input type="hidden" value="<?=$value['d_id']?>" name="d_id[]"></td>
				</tr>

	<?  	endforeach;
		endif;
	?>
	
</table>
<table style="float:left;">
	<tr>
		<td><input type="button" id="addtr" value="增加帳號">
			<br><br><br>
			<input type="submit" value="儲存">
		</td>
	</tr>
</table>
</form>
<script>
$('.datadel').click(function(){	
	if(confirm('確定刪除?')){
		d_id=$(this).attr('did');
		id=$(this).attr('delid');
		$('#tr_'+id+'').remove();
		window.location.href="/IosAccount/data_AED/"+d_id+"";
	}
});
	
	

function del(id){
	$('#tr_'+id+'').remove();
}
num=<?=$cnum?>;
$('#addtr').click(function(){
	var strarray=["喔","嗯","所以呢?","有事嗎?","好累喔","不想上班"];
	var n = Math.floor(Math.random() * 6) + 0;  
	// console.log(n);
	$('#otable').append(
		'<tr id="tr_'+num+'">'+
		'<td><input type="text" name="d_account[]" required></td>'+
		'<td><input type="text" name="d_newaccount[]" required></td>'+
		'<td><input type="text" name="d_content[]"  placeholder="'+strarray[n]+'"></td>'+
		'<td><input type="button" value="刪除" onclick="del('+num+')"></td>'+
		'</tr>'
	);
	num++;
});
</script>