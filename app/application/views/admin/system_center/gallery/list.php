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
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
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
		
		.box {
		  float: left;
		  width: 100;
		  height: 100px;
		  margin: 1em;
		}
	</style>
	<script>
		$(function() {
			$('.btn-info').click(function() {
				$('#list_form').attr('action', "/gallery/sort_save/<?=$id;?>");
				$('#list_form').submit();
			});			
			$('#list_form').sortable();			
			$("#dialog-group-form").dialog({
			    autoOpen: false,
			    height: 250,
			    width: 400,
			    modal: true,
			    buttons: {
			        "Add": {
			            text: '新增相簿',
			            class: 'btn btn-default',
			            click: function() {
			                $.ajax({
			                    type: "post",
			                    url: '/gallery/group_add',
			                    cache: false,
			                    data: {
			                        group_name: $('input[name="group_name"]').val(),
			                        type: $('input[name="type"]').val(),
			                        d_type: $('input[name="d_type"]').val()
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
				if(confirm('確定刪除['+name+']相簿?')){
					$.post('/gallery/del_group', { id: $(this).attr('id') },
						function(response) {
							alert(response.message);
							if (response.result)
								top.frames['content-frame'].location.reload();
						},
						'json'
					);
				}
			});

			// content
			$('.trash').click(function () {
				if(confirm('確定刪除此照片?')){
					$.ajax({
						type: 'post',
						url: '/gallery/del_exfile',
						cache: false,
	                    async: false,
	                    dataType: "json",
	                    data: {
	                        id: $(this).attr('id'),
	                    },
	                    error: function(XMLHttpRequest, textStatus, errorThrown) {
	                    },
	                    success: function(response) {
	                    	alert(response.message);
	                    	top.frames["content-frame"].location.reload();
	                    }
					});
				}
			});

			$("#tips").each(function () {
				$("#tips").fadeOut('slow');
			});
			
			$(".btn-photo").click(function(){
				$(".photo_div").toggle();
			});
			
			$(".Allphoto").dblclick(function(){
				$.ajax({
					type: 'POST',
					url: '/gallery/img_opening',
					dataType : "json",
                    data: {
                       id : $(this).attr('id')
                    },
                    success: function(respon) {					
						//是否已存在 顯示框中
						if(respon.enable == 'new'){
							var newphoto = "<div class='box' id='box"+respon.img_id+"'><img src='"+respon.img_path+"' id='"+respon.img_id+"' class='opening' width='50px'></div>";
							$(".photo").append(newphoto);
						}else{
							alert("It is exist");
						}				
                    }
				});
				
			});
			
			$("body").on("dblclick","img.opening",function(){
				var img_id = $(this).attr("id");
				$.ajax({
					type: 'POST',
					url: '/gallery/img_close',
					dataType : "json",
                    data: {
                       id : img_id
                    },
                    success: function(respon) {
						$("#box"+img_id).remove();
                    }
				});
				
			});
		});
	</script>
</head>

<style type="text/css">
	._group {
		width: 80%;
	}
	.groupName {
	    background: #555;
		color: white;
		text-align: center;
		padding: 10px;
		border-radius: 5px;
		margin: 15px 0 5px 0;
	}
	.groupName div {
		/*display: inline-block;*/
		display: inline;
	}
	.groupSort {
		width: 180px;
		max-height: 215px;
		border: 1px solid rgb(100, 61, 113);
		display: inline-block;
		vertical-align: top;
		margin: 5px;
		padding: 10px;
	}
	.groupBox {
		/*border-bottom: 1px solid #cccccc;*/
    	/*width: 100%;*/
    	margin-top: 15px 0 10px 0;
	}
	.Inf_btn {
		margin-top: 5px;
	}
	
	.photo_div {
		position: fixed;
		bottom: 0;
		right: 0;
		width: 400px;
		background-color: white;
		
	}
	
</style>

<center>
<body>
  	<table id='button_table'>
	    <tr style="text-align:right;">
			<td style="width:97%; color:#5A0087;"><p style="display: inline;" id="tips"><?=$this -> message?></p></td>
	      	<td style="width:1%;"><a onclick="top.frames['content-frame'].location='/gallery/type'" class="btn btn-warning">返回列表</a></td>
	      	<td style="width:1%;"><button class="btn btn-primary" type="button" id="add_group">新增相簿</button></td>
	      	<td style="width:1%;"><button class="btn btn-info" type="button">儲存排序</button></td>
			<?/*<td style="width:1%;"><button class="btn btn-photo" id="showButton" type="button" >圖檔狀態</button></td> */?>
		</tr>
  	</table>
	<center>相簿分類名稱:<?=$photo_name;?></center>
	<form id="list_form" method="post">
	<?php if(!empty($group)): ?>
	  	<?php foreach ($group as $key => $value): ?>
		  		<script type="text/javascript">
		  		$(function() {
		  			$('.groupSort_<?=$key?>').sortable({
						cancel : ".groupName",
					});
				});
		  		</script>
				<div class="_group">
					<input type="hidden" name="psort[]" value="<?=$value['d_id']?>">
					<div class="groupName" style="<?=($value['d_enable']==Y)?' background:#da9090;':''?>">
						<div title="<?=$value['d_name']?>"><?=$value['d_name']?><?=($value['d_enable']==Y)?'':'(前台隱藏中)'?></div>
						<div>
							<a href="javascript:;" onclick="window.open('/gallery/plupload/<?=$value['d_id']?>', '上傳附件', config='height=350, width=700');"><i class="fa fa-cloud-upload" aria-hidden="true"></i></a>
							<a href="/gallery/edit/g/<?=$value['d_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							<a class="trash_group" id="<?=$value['d_id']?>" name="<?=$value['d_name']?>" href="javascript:;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						</div>
					</div>
					<?php if(!empty($value['photo_array'])): ?>
						<div class="groupSort_<?=$key?>">
							<?php foreach ($value['photo_array'] as $fkey => $fvalue): ?>
								<div class="groupSort">
									<div class="groupBox">
										<input type="hidden" name="csort[]" value="<?=$fvalue['img_id']?>">
										<div class="re_img"><img class="Allphoto" src="<?=$fvalue['img_path']?>" width="100" id="<?=$fvalue['img_id']?>"></div>
										<div class="Inf_btn">
											<a href="<?=$fvalue['img_path']?>" download="<?=$fvalue['img_id']?>"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
											<?/*<a href="/gallery/edit/c/<?=$fvalue['img_id']?>" title="點我編輯註解"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> */?>
											<a class="trash" id="<?=$fvalue['img_id']?>" href="javascript:;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
		<?php endforeach; ?>
	<?php endif; ?>
	</form>

	<div id="dialog-group-form" style="display: none; overflow-y: hidden;" title="新增相簿">
	    <form method="post" id='group_form' action='/gallery/group_add'>
			<table class='table'>
				<tr>
					<td>相簿名稱</td>
					<td>
						<input type="text" name="group_name" value="">
					</td>
				</tr>
			</table>
			<p style="text-align:right;color:#F60;font-size:20px;" id='prompt'></p>
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="d_type" value="<?=$id;?>">
	    </form>
	</div>
	
	<?/*<div class="photo_div" style="display: none;border-style:solid">
		<div style="background-color:black;width:400px;">
			<font color="white">目前顯示中圖檔</font>
		</div>
		<div  class="photo" style="overflow:scroll;height:400px;width:400px;">
			<?foreach($img_info as $key => $val):?>
				<div class="box" id="box<?=$val['img_id']?>"><img src="<?=$val['img_path']?>" id="<?=$val['img_id']?>" class="opening" width="50px"></div>
			<?endforeach;?>
		</div>
	</div>*/?>
	
</body>
</html>
