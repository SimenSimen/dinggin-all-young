<!DOCTYPE html>
<html>
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  	<!-- css -->
  	<link type="text/css" rel="stylesheet" href="/css/admin.css">
  	<!-- icon -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  	<!-- jQuery -->
  	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  	<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  	<!-- bootstrap -->
  	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  	<link type="text/css" rel="stylesheet" href="/css/admin_list.css">

</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

	<table id='button_table'>
		<tr style="text-align:right;">
		  <td style="width:1%;">
			<!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
			<button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/order/reason_info/'">
				新增退貨原因
			</button>
		  </td>
		</tr>
	</table>
	
	<table id="member_list" class='table table-hover table-bordered table-condensed' style="width:80%;">
        <tr>
            <td style="width:40%;"><?=$item?></td>
            <td style="width:50%;">
				<label for="open"><input type="radio" value="1" id="open" name="pic_upload" <?=($Launcher==1)?'checked="TRUE"':'';?>>開啟</label>&nbsp;&nbsp;
				<label for="close"><input type="radio" value="0" id="close" name="pic_upload" <?=($Launcher==0)?'checked="TRUE"':'';?>>關閉</label>
				<input type="button" id="launcher" style="float:right;" value="確定">
			</td>
        </tr>
    </table>
	
  	
	<form id="list_form" method="post">
		<table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
      
			<tr id='member_list_title_tr'>
				<td>理由名稱</td>
				<td>修改</td>
				<td>刪除</td>
			</tr>
			<?php if (!empty($dbdata)): ?>
			<?php foreach ($dbdata as $key => $value): ?>
			  <tr bgcolor='<?=$member_auth_color[$key]?>'>       
				<td class='center_td white_td'><?=stripslashes($value['reason_item'])?></td>         
				<td class='center_td white_td'> 
				  <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/order/reason_info/<?=$value['r_id']?>'">
					<i class="fa fa-cogs"></i>
				  </a>
				</td>
				<td class='center_td white_td'> 
				  <a href="javascript:void(0); " onclick="del_file('<?=$value['reason_item']?>',<?=$value['r_id']?>)" >
					<i class="fa fa-trash-o"></i>
				  </a>
				</td>
			  </tr>
			<?php endforeach; ?>

			<?php endif; ?>
		</table>
	</form>
</body>
</html>
<script>

$(function() {
	$("#launcher").click(function(){
		var xval = $("input[type=radio]:checked").val();
		$.ajax({
			type: 'post',
			url: '/order/back_order_pic',
			cache: false,
            async: false,
			data:{
				d_val : xval
			},
			success: function() {
				alert("修改成功");
				window.location.reload();
			}
		});
	});	
});	


function del_file(name,id){
	if(confirm("確定刪除["+name+"]資料?"))
		window.location.href='/order/reason_AED/'+id;
}	
	
  
</script>