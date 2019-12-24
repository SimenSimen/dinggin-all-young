<!DOCTYPE html>
<html>
<head>
  	<title>行動名片系統</title>
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
	<style>
		tr {
		}
		#list tr td {
			text-align: center;
		}
		.fa {
			font-size: 24px;
			cursor: pointer;
		}
		p {
			font-size: 18px;
		}
		#button_table {
			margin: 5px auto;
			padding-top: 5px;
			padding-bottom: 5px;
			padding-left: 5px;
		}
	</style>
	<script>
		$(function() {
			$('.btn-info').click(function() {
				$('#list_form').attr('action', '/gallery/sort_type_save');
				$('#list_form').submit();
			});
			$('input[name="check_all"]').click(function() {
				if ($(this).prop("checked")) {
					$("input[name='check_id[]']").each(function() {
						$(this).prop("checked", true);
					});
				}else{
					$("input[name='check_id[]']").each(function() {
						$(this).prop("checked", false);
					});       
				}
			});
			$('#sort').sortable();
		});

		$(function() {
			$("#dialog-group-form").dialog({
			    autoOpen: false,
			    height: 250,
			    width: 400,
			    modal: true,
			    buttons: {
			        "Add": {
			            text: '新增分類',
			            class: 'btn btn-default',
			            click: function() {
			                $.ajax({
			                    type: "post",
			                    url: '/gallery/group_type_add',
			                    cache: false,
			                    data: {
			                        group_name: $('input[name="group_name"]').val(),
			                        type: $('input[name="type"]').val()
			                    },
			                    dataType: "json",
			                    async: false,
			                    error: function(XMLHttpRequest, textStatus, errorThrown) {},
			                    success: function(response) {
			                    	var recode = response.recode;
			                    	if (recode != '200')
			                    	{
			                    		$('#prompt').html(response.retext);
			                            $('#prompt').fadeIn();
			                            $('input[name="group_name"]').focus();
			                    	}
			                    	else
			                    	{
			                    		top.frames["content-frame"].location.reload();
			                    	}
			                    }
			                });
			            }
			        }
			    }
			});

			$('#add_group').click(function() {
				$("#dialog-group-form").dialog('open');
			});

			// group
			$('.trash_group').click(function() {
				var name=$(this).attr('name');
				if(confirm('確定刪除['+name+']分類?')){
					$.post('/gallery/del_group_type', { id: $(this).attr('id') },
						function(response) {
							alert(response.message);
							if (response.result)
								top.frames['content-frame'].location.reload();
						},
						'json'
					);
				}
			});
		});
	</script>
</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  	<table id='button_table'>
	    <tr style="text-align:right;">
	      <td style="width:97%; color:#5A0087;"><p style="display: inline;" id="tips"><?=$this -> message?></p></td>
	      <td style="width:1%;"><button class="btn btn-primary" type="button" id="add_group">新增分類</button></td>
	      <td style="width:1%;"><button class="btn btn-info" type="button">儲存排序</button></td>
	    </tr>
  	</table>
  	<form id="list_form" method="post">
	<table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
	    <tr id='list_title_tr'>
			<td style="width: 10%;">流水號</td>
			<td style="width: 10%;">狀態</td>
			<td style="width: 50%;">相簿分類名稱</td>
			<td style="width: 15%;">操作</td>
	    </tr>		
		<?php if(!empty($group)): ?>
			<tbody id="sort">
			<?php foreach ($group as $key => $value): ?>
				<tr>
					<input type="hidden" name="csort[]" value="<?=$value['d_id']?>">
					<td><?=($key+1)?></td>
					<td><?=($value['d_enable']=='Y')?'顯示中':'隱藏中'?></td>
					<td><?=$value['d_name']?></td>
					<td>
						<a href="/gallery/edit/t/<?=$value['d_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
						<a href="/gallery/main/<?=$value['d_id']?>"><i class="fa fa-photo" aria-hidden="true"></i></a>
						<a class="trash_group" href="javascript:;" id="<?=$value['d_id']?>" name="<?=$value['d_name']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		<?php else: ?>
			<tr>
				<td colspan="3">-</td>
			</tr>
		<?php endif; ?>

	</table>
	</form>

<p style="height:200px;"></p>
<div id="dialog-group-form" style="display: none; overflow-y: hidden;" title="新增分類">
	    <form method="post" id='group_form' action='/gallery/group_type_add'>
			<table class='table'>
				<tr>
					<td>分類名稱</td>
					<td>
						<input type="text" name="group_name" value="">
					</td>
				</tr>
			</table>
			<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>
			<input type="hidden" name="type" value="<?=$type?>">
	    </form>
	</div>
</body>
</html>
