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
			$('.fa-file-text-o').hover(function() {
				$(this).next('div').show();
			}, function() {
				$(this).next('div').hide();
			});
			$("#dialog-group-form").dialog({
			    autoOpen: false,
			    height: 250,
			    width: 400,
			    modal: true,
			    buttons: {
			        "Add": {
			            text: '新增群組',
			            class: 'btn btn-default',
			            click: function() {
			                $.ajax({
			                    type: "post",
			                    url: '/<?=$this->mode_function;?>/group_add',
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

			$('.btn-info').click(function() {
				$('#list_form').attr('action', '/<?=$this->mode_function;?>/sort_save');
				$('#list_form').submit();
			});

			$('.btn-status').click(function() {
				$('#list_form').attr('action', '/<?=$this->mode_function;?>/article_status');
				$('#list_form').submit();
			});

			$('.btn-danger').click(function() {
				if(confirm('確定刪除勾選的資料?')){
					$('#list_form').attr('action', '/<?=$this->mode_function;?>/form_del');
					$('#list_form').submit();
				}
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
				var name=$(this).attr('name');
				if(confirm('確定刪除['+name+']資料?')){
					$.post('/<?=$this->mode_function;?>/del_group', { id: $(this).attr('id') },
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
	      <td style="width:96%; color:#5A0087;"><p style="display: inline;" id="tips"><?=$this -> message?></p></td>
	      <td style="width:1%;"><button class="btn btn-primary" type="button" id="add_group">新增群組</button></td>
	      <?php if($news_btn): ?>
	      	<td style="width:1%;"><button class="btn btn-primary" type="button" onclick="window.open('/<?=$this->mode_function;?>/enews/add', '新增訊息', config='height=500, width=700')">新增訊息</button></td>
	      <?php endif; ?>
	      <td style="width:1%;"><button class="btn btn-info" type="button">儲存排序</button></td>
	      <td style="width:1%;"><button class="btn btn-danger" type="button">刪除勾選</button></td>
	    </tr>
  	</table>

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
					<td><?=$value['qaag_name']?></td>
					<td>
						<a href="/<?=$this->mode_function;?>/edit/g/<?=$value['qaag_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
						<a class="trash_group" href="javascript:;" name="<?=$value['qaag_name']?>" id="<?=$value['qaag_id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="3">-</td>
			</tr>
		<?php endif; ?>

	</table>

	<?php if(!empty($news)): ?>
		<form id="list_form" method="post">
			<div>
				<select name="article_status">
					<option value="#">請選擇狀態</option>
					<option value="1">公開</option>
					<option value="0">隱藏</option>
				</select>
				<button class="btn-status">修改</button>
			</div>
			<table id='list' class='table table-hover table-bordered table-condensed' style="width:80%;">
			    <tr id='list_title_tr'>
					<td style="width: 10%;"><input type="checkbox" name="check_all"> 全選</td>
					<td>流水號</td>
					<td>群組</td>
					<td>名稱</td>
					<td>狀態</td>
					<td>操作</td>
			    </tr>

				<tbody id="sort">
				<?php foreach ($news as $key => $value): ?>
					<?if($value['member_id']=="")$value['member_id']="1";?>
				    <tr>
				    	<input type="hidden" name="ck_id[]" value="<?=$value['qaa_id']?>">
				    	<td><input type="checkbox" name="check_id[]" value="<?=$value['qaa_id']?>"></td>
				    	<td><?=($key+1)?></td>
				    	<td><?=$value['qaag_name']?></td>
				    	<td><?=$value['qaa_title']?></td>
						<td><?=$value['enable']?></td>
				    	<td>
				    		<i class="fa fa-file-text-o" aria-hidden="true"></i>
								<div style="position: absolute; max-width: 400px; z-index: 1; background: #FFFFCE; display: none;"><?=$value['qaa_content']?></div>
				    		<a onclick="window.open('/<?=$this->mode_function;?>/enews/edit/0/<?=$value['qaa_id']?>', '<?=addslashes($value['qaa_title'])?>', config='height=500,width=700');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<a href="/<?=$this->mode_function;?>/enews/delete/0/<?=$value['qaa_id']?>" onClick="return confirm('您確定要刪除[<?=$value['qaa_title']?>]資料嗎?')" id=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
			    		</td>
				    </tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<input type="hidden" id="type" name="type" value="<?=$type?>">
		</form>
	<?php endif; ?>

	<div id="dialog-group-form" style="display: none; overflow-y: hidden;" title="創建群組">
	    <form method="post" id='group_form' action='/qa/group_add'>
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

</body>
</html>
