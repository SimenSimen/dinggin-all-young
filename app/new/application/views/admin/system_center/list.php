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
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

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
			$('.fa-file-text-o').hover(function() {
				$(this).next('div').show();
			}, function() {
				$(this).next('div').hide();
			});

			$('.btn-info').click(function() {
				$('#list_form').attr('action', '/corporate/sort_save');
				$('#list_form').submit();
			});

			$('.btn-danger').click(function() {
				$('#list_form').attr('action', '/corporate/ckeditor_del/' + $('#type').val());
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
				$.post('/eform/del_video_group', { id: $(this).attr('id') },
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
	      <td style="width:97%; color:#5A0087;"><p style="display: inline;" id="tips"><?=$this -> message?></p></td>
	      <td style="width:1%;"><button class="btn btn-primary" type="button" onclick="top.frames['content-frame'].location='/corporate/ckeditor_add/<?=$type?>'"><?=$btn_name?></button></td>
	      <td style="width:1%;"><button class="btn btn-info" type="button">儲存排序</button></td>
	      <td style="width:1%;"><button class="btn btn-danger" type="button">刪除勾選</button></td>
	    </tr>
  	</table>
  	<?if($type==4 || $type==5){?>
	<table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
	    <tr id='list_title_tr'>
			<td style="width: 10%;">流水號</td>
			<td style="width: 60%;">群組名稱</td>
			<td style="width: 15%;">操作</td>
	    </tr>
		
		<?php if(!empty($group)): ?>
			<?php foreach ($group as $key => $value): ?>
				<tr>
					<td><?=($key+1)?></td>
					<td><?=$value['c_name']?></td>
					<td>
						<?if($type==4){?>
							<a href="/eform/edit/d/<?=$value['category_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
						<?}else if($type==5){?>
							<a href="/eform/edit/e/<?=$value['category_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
						<?}?>
						<a class="trash_group" href="javascript:;" id="<?=$value['category_id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="3">-</td>
			</tr>
		<?php endif; ?>

	</table>
	<?}?>
	<form id="list_form" method="post">
		<table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
		    <tr id='list_title_tr'>
		      <td><input type="checkbox" name="check_all"> 全選</td>
		      <td>流水號</td>
		      <?php if($type > 3 and $type!=6): ?>
		      	<td>群組</td>
		      <?php endif; ?>
		      <td>標題名稱</td>
		      <td>內容</td>
		      <td>操作</td>
		    </tr>
			
			<?php if(!empty($texts)): ?>
				<tbody id="sort">
					<?php foreach ($texts as $key => $value): ?>
					    <tr>
					    	<input type="hidden" name="ck_id[]" value="<?=$value['ck_id']?>">
					    	<td><input type="checkbox" name="check_id[]" value="<?=$value['ck_id']?>"></td>
					    	<td><?=($key+1)?></td>
					    	<?php if($type > 3 and $type!=6): ?>
					    		<td><?=$value['c_name']?></td>
					    	<?php endif; ?>
					    	<td><?=$value['name']?></td>
					    	<td>
					    		<i class="fa fa-file-text-o" aria-hidden="true"></i>
								<div style="position: absolute; max-width: 400px; z-index: 1; background: #FFFFCE; display: none;"><?=$value['content']?></div>
							</td>
					    	<td><a onclick="top.frames['content-frame'].location='/corporate/ckeditor_edit/<?=$type?>/<?=$value['ck_id']?>'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					    </tr>
					<?php endforeach; ?> 
				</tbody>
			<?php else: ?>
				<tr>
					<?php if($type > 1): ?>
						<td colspan="6">-</td>
					<?php else: ?>
						<td colspan="5">-</td>
					<?php endif; ?>
				</tr>
			<?php endif; ?>
		</table>

		<input type="hidden" id="type" name="type" value="<?=$type?>">
	</form>

<p style="height:200px;"></p>

</body>
</html>
