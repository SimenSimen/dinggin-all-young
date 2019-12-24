<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  	<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script>
  //介紹影片
  //介紹影片結束
  //onchange column number
  $(function() {
	  $('#add_prd_video_col').click(function(){
	    $("#prd_video_table").append(
	      "<tr>"+
	            "<td>"+
	            "  <input type='text' placeholder='影片標題' class='form-control d_video_name' style='display:inline; width: 26%;' name='d_video_name[]' id='d_video_name[]' maxlength='32'>"+
	            "  <input placeholder='影片網址' type='text' class='form-control d_video_link' style='display:inline; width: 40%;' name='d_video_link[]' id='d_video_link[]' maxlength='255'>"+
	            "  &nbsp;<button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>"+
	            "</td>"+
	            "</tr>"
	    );
	  });
	  //delete
	  $("#prd_video_table_tbody").on('click', '.del_prd_video_col', function()
	  {
	    $(this).parent().parent().remove();
	  });
	  //介紹影片結束
  });
</script>
</head>
<body>
	<form method="post" action="/gallery/con_edit">
		<table id='button_table'>
			<tr>
              <td class='member_list_title_td'>名稱</td>
              <td class='member_list_input_td'><input type="text" name="edit_name" value="<?=$edit['name']?>" placeholder="<?=$edit['name']?>" maxlength="20"></td>
            </tr>
			<tr>
              <td class='member_list_title_td'>狀態</td>
              <td class='member_list_input_td'>
              	<select name="d_enable">
					<option value='Y' <?=($edit['d_enable'] == 'Y')?'selected':'';?>>公開中</option>
					<option value='N' <?=($edit['d_enable'] == 'N')?'selected':'';?>>隱藏中</option>
				</select>
              </td>
            </tr>
			<tr>
              <td class='member_list_title_td'>內容</td>
              <td class='member_list_input_td'><textarea name='d_content' class='form-control' id='ckeditor'><?=$edit['d_content']?></textarea></td>
            </tr>


            <? if($type=='g'){?>
	            <tr>
	              <td class='member_list_title_td'>介紹影片<br>	              	
	              	<input class="btn btn-default" type="button" id='add_prd_video_col' value="增加">
	              </td>
	              <td class='table-cell-left' style="vertical-align: top;">
	                  <table id='prd_video_table' style="width: 100%;">
	                    <tbody id='prd_video_table_tbody'>
	                    <?php //if ($show_video_link): ?>
	                      <?php foreach ($d_video_link as $key => $value): ?>
	                        <tr>
	                          <td>
	                            <input type='text' placeholder='影片標題' value="<?=$d_video_name[$key]?>" class='form-control' style='display:inline; width:26%;' name='d_video_name[]' id='d_video_name[]' maxlength='32'>
	                            <input placeholder='影片網址' type='text' class='form-control' value="<?=$d_video_link[$key]?>" style='display:inline; width:40%;' name='d_video_link[]' id='d_video_link[]' maxlength='255'>
	                            <button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>
	                          </td>
	                        </tr>
	                      <?php endforeach; ?>
	                    <?php //endif; ?>
	                    </tbody>
	                  </table>
	              </td>
	            </tr>
				<input type="hidden" name="d_type" value="<?=$edit['d_type']?>">
            <?}?>
		</table>
		<br>
		<input type="hidden" name="edit_id" value="<?=$edit['id']?>">
		<input type="hidden" name="type" value="<?=$type?>">
		<input class="btn btn-default" type="button" onclick="javascript:history.back(1);" value="返回列表">
		<input class="btn btn-primary" type="submit" name="edit_submit" value="送出">

	</form>
</body>
</html>
<script type="text/javascript" src="/js/admin/system_center/build_ckeditor.js"></script>