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
  	<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
		.content {
			display: inline-block;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		}
	</style>
	<script>
		$(function() {
			// $("#dialog-group-form").dialog({
			//     autoOpen: false,
			//     height: 250,
			//     width: 400,
			//     modal: true,
			//     buttons: {
			//         "Add": {
			//             text: '新增群組',
			//             class: 'btn btn-default',
			//             click: function() {
			//                 $.ajax({
			//                     type: "post",
			//                     url: '/archive/group_add',
			//                     cache: false,
			//                     data: {
			//                         group_name: $('input[name="group_name"]').val(),
			//                         type: $('input[name="type"]').val()
			//                     },
			//                     dataType: "json",
			//                     async: false,
			//                     error: function(XMLHttpRequest, textStatus, errorThrown) {},
			//                     success: function(response) {
			//                     	var recode = response.recode;
			//                     	if (recode != '200')
			//                     	{
			//                     		$('#prompt').html(response.retext);
			//                             $('#prompt').fadeIn();
			//                             $('input[name="group_name"]').focus();
			//                     	}
			//                     	else
			//                     	{
			//                     		top.frames["content-frame"].location.reload();
			//                     	}
			//                     }
			//                 });
			//             }
			//         }
			//     }
			// });

			// $('#add_group').click(function() {
			// 	$("#dialog-group-form").dialog('open');
			// });
			
			$('.content').css('width', $('#list').width() * .06);

			$('.btn-info').click(function() {
				$('#list_form').attr('action', '/comment/update_essay');
				$('#list_form').submit();
			});

			$('.btn-danger').click(function() {
				$('#list_form').attr('action', '/comment/del_essay');
				$('#list_form').submit();
			})

			$('input[name="check_all"]').click(function() {
				if ($(this).prop("checked")) {
					$("input[name='check_id[]']").each(function() {
						$(this).prop("checked", true);
					});
				}
				else
				{
					$("input[name='check_id[]']").each(function() {
						$(this).prop("checked", false);
					});       
				}
			});

			$('#sort').sortable();

			$("#tips").each(function () {
				$("#tips").fadeOut('slow');
			});

			// group
			$('.trash_group').click(function() {
				$.post('/comment/del_ajax_essay', { id: $(this).attr('id') },
					function(response) {
						alert(response.message);
						if (response.result)
							top.frames['content-frame'].location.reload();
					},
					'json'
				);
			});
		});
	</script>
</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  	<table id='button_table'>
	    <tr style="text-align:right;">
	      <td style="width:98%; color:#5A0087;"><p style="display: inline;" id="tips"><?=$this -> message?></p></td>
	      <!-- <td style="width:1%;"><button class="btn btn-primary" type="button" id="add_group">新增群組</button></td> -->
	      <td style="width:1%;"><button class="btn btn-info" type="button">狀態變更</button></td>
	      <td style="width:1%;"><button class="btn btn-danger" type="button">刪除勾選</button></td>
	    </tr>
  	</table>

	<table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
	    <tr id='list_title_tr'>
			<td style="width: 10%;"><input type="checkbox" name="check_all"> 全選</td>
			<td style="width: 25%;">主旨</td>
			<td style="width: 30%;">內容</td>
			<td style="width: 15%;">送審時間</td>
			<td style="width: 10%;">狀態</td>
			<td style="width: 10%;">操作</td>
	    </tr>
		
		<?php if(!empty($essay)): ?>
			<form id="list_form" method="post">
			<?php foreach ($essay as $key => $value): ?>
			    <tr>
			    	<input type="hidden" name="ck_id[]" value="<?=$value['d_id']?>">
			    	<td><input type="checkbox" name="check_id[]" value="<?=$value['d_id']?>"></td>
			    	<td title="<?=$value['d_title']?>"><div class="content"><?=$value['d_title']?></div></td>
			    	<td title="<?=$value['d_content']?>"><div class="content"><?=$value['d_content']?></div></td>
			    	<td><?=$value['update_time']?></td>
			    	<td><?=$value['statusName']?></td>
			    	<td>
			    		<a onclick="top.frames['content-frame'].location='/comment/v?e=<?=$value['d_id']?>&m=<?=$value['member_id']?>'"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
						<a href="javascript:;" class="trash_group" id="<?=$value['d_id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
		    		</td>
			    </tr>
			<?php endforeach; ?>
			</form>
		<?php else: ?>
			<tr>
				<td colspan="6">-</td>
			</tr>
		<?php endif; ?>
	</table>

	
	<?php if(0): ?>
	<div id="dialog-group-form" style="display: none; overflow-y: hidden;" title="創建群組">
	    <form method="post" id='group_form' action='/eform/group_add'>
			<table class='table'>
				<tr>
					<td>群組名稱</td>
					<td>
						<input type="text" name="group_name" value="">
					</td>
				</tr>
			</table>
			<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>
			<input type="hidden" name="type" value="<?=$type?>">
	    </form>
	</div>
	<?php endif; ?>

</body>
</html>
