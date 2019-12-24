//ckeditor
var ufm_aim_ck;
var ufm_aim = document.getElementById('ufm_aim');
function createEditor( languageCode )
{
	if(ufm_aim != null)
	{
		if ( ufm_aim_ck )
		{
			ufm_aim_ck.destroy();
		}

		ufm_aim_ck = CKEDITOR.replace( 'ufm_aim', {
			filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
			width : 900,
			height: 600,
			resize_enabled:false,
			enterMode: 2,
			forcePasteAsPlainText :true,
			toolbar :
			[
				['Source', '-', 'Undo','Redo'],
				['Cut','Copy','Paste','PasteText','PasteFromWord', 'Table', 'HorizontalRule', 'NumberedList','BulletedList', '-', 'Link','Unlink', '-', 'Image'],
				['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']
			]
		});
	}   
}
createEditor( '' );


$(function(){

	//取消按鈕關閉視窗
	$('#cancel').click(function(){
		if(confirm('您確定要取消新增嗎?'))
		{
			window.close();
		}
	});

	var form_item_num=0;
    $("#select_form_item option[value=0]").attr("selected", true);
    $("#select_form_item").val(0);
    //Add a item
    $( "#select_form_item" ).on('change', function()
    {
        form_item_num++;
		$('#c_col_table').show();
		$('#c_col_hr').show();

        if ($('#select_form_item option[value=1]').is(':selected')) {
            $("#col_table").append(''+
            	'<tr class="item_tr">'+
            	'	<td style="width: 484px;"><input name="item[type][]" type="hidden" value="1">'+
            	'		<input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
            	'		<input name="item[name][]" placeholder="[日期] [欄位名稱] 例如：您的生日" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
            	'		<button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
            	'		<i class="fa fa-bars"></i>'+
            	'	</td>'+
            	'</tr>'
        	);
        }
        else if ($('#select_form_item option[value=2]').is(':selected')) {
            $("#col_table").append(''+
            	'<tr class="item_tr">'+
            	'	<td style="width: 484px;"><input name="item[type][]" type="hidden" value="2">'+
            	'		<input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
            	'		<input name="item[name][]" placeholder="[文字] [欄位名稱] 例如：您的公司電話" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
            	'		<button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
            	'		<i class="fa fa-bars"></i>'+
            	'	</td>'+
            	'</tr>'
        	);
        }
        else if ($('#select_form_item option[value=3]').is(':selected')) {
            $("#col_table").append(''+
            	'<tr class="item_tr">'+
            	'	<td style="width: 484px;"><input name="item[type][]" type="hidden" value="3">'+
            	'		<input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
            	'		<input name="item[name][]" placeholder="[單選] [欄位名稱] 例如：您的交通工具" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
            	'		<button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
            	'		<i class="fa fa-bars"></i><br>'+
            	'		<input name="item[content][]" placeholder="[單選] [選項] 例如：機車;汽車;計程車" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">'+
            	'		<a href="#" class="why" tabindex = "-1">?</a>'+
                '       <div class="prompt-box">'+
                '			<p>[單選] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>'+
                '			<p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的交通工具" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>'+
                '			<p><input class="form-control" type="text" readonly="true" value="機車;汽車;計程車" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>'+
                '			<p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>'+
                '			<p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>'+
                '			<p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>'+
                '       </div>'+
      			'	</td>'+
            	'</tr>'
        	);
        }
        else if ($('#select_form_item option[value=4]').is(':selected')) {
            $("#col_table").append(''+
            	'<tr class="item_tr">'+
            	'	<td style="width: 484px;"><input name="item[type][]" type="hidden" value="4">'+
            	'		<input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
            	'		<input name="item[name][]" placeholder="[下拉] [欄位名稱] 例如：您的交通工具" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
            	'		<button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
            	'		<i class="fa fa-bars"></i><br>'+
            	'		<input name="item[content][]" placeholder="[下拉] [選項] 例如：機車;汽車;計程車" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">'+
            	'		<a href="#" class="why" tabindex = "-1">?</a>'+
                '       <div class="prompt-box">'+
                '			<p>[下拉] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>'+
                '			<p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的交通工具" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>'+
                '			<p><input class="form-control" type="text" readonly="true" value="機車;汽車;計程車" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>'+
                '			<p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>'+
                '			<p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>'+
                '			<p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>'+
                '       </div>'+
      			'	</td>'+
            	'</tr>'
        	);
        }
        else if ($('#select_form_item option[value=5]').is(':selected')) {
            $("#col_table").append(''+
            	'<tr class="item_tr">'+
            	'	<td style="width: 484px;"><input name="item[type][]" type="hidden" value="5">'+
            	'		<input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
            	'		<input name="item[name][]" placeholder="[複選] [欄位名稱] 例如：您的專長" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
            	'		<button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
            	'		<i class="fa fa-bars"></i><br>'+
            	'		<input name="item[content][]" placeholder="[複選] [選項] 例如：網站UI;平面設計;網頁撰寫" class="form-control item_content" style="margin-left:25px; width: 376px; display: inline; margin-top: 6px; background-color: #F3FBFF; font-size: 16px;">'+
            	'		<a href="#" class="why" tabindex = "-1">?</a>'+
                '       <div class="prompt-box">'+
                '			<p>[複選] 請輸入 [欄位名稱] 與 [選項]，舉例來說：</p>'+
                '			<p><input type="checkbox" disabled="disabled" class="form-control" style="width: 20px; display: inline;">&nbsp;<input value="您的專長" class="form-control" style="width: 345px; display: inline; font-size: 16px;" readonly="true">&nbsp;<button type="button" class="btn btn-danger">移除</button>&nbsp;<i class="fa fa-bars"></i></p>'+
                '			<p><input class="form-control" type="text" readonly="true" value="網站UI;平面設計;網頁撰寫" style="margin-left:25px; display: inline; width: 345px; font-size: 16px;"></p>'+
                '			<p>請注意，任一選項之間請加入「;」，以分隔您的選項內容</p>'+
                '			<p>若您沒有使用任何選項間隔「;」，此欄位將不會被新增</p>'+
                '			<p>另外，若您沒有填寫欄位名稱，此欄位也不會被新增</p>'+
                '       </div>'+
      			'	</td>'+
            	'</tr>'
        	);
        }
        else if ($('#select_form_item option[value=6]').is(':selected')) {
            $("#col_table").append(''+
                '<tr class="item_tr">'+
                '   <td style="width: 484px;"><input name="item[type][]" type="hidden" value="6">'+
                '       <input type="checkbox" name="item[required][]" value="'+(form_item_num-1)+'" class="form-control" style="width: 20px; display: inline;">'+
                '       <input name="item[name][]" placeholder="[數字數量] [欄位名稱] 例如：預計同行人數" class="form-control item_name" style="width: 375px; display: inline; font-size: 16px;">'+
                '       <button type="button" class="btn btn-danger del_col" onclick="javascript:void(0);">移除</button>'+
                '       <i class="fa fa-bars"></i>'+
                '   </td>'+
                '</tr>'
            );
        }
        $("#select_form_item option[value=0]").attr("selected", true);
        $("#select_form_item").val(0);
    });
	//delete
	$("#col_table_tbody").on('click', '.del_col', function()
	{
        form_item_num--;

		$(this).parent().parent().remove();
		if(form_item_num <= 0)
		{
			$('#prompt_tr').hide();
			$('#c_col_table').hide();
			$('#c_col_hr').hide();
		}
	});

	$('#form_uform_add').submit(function( event )
	{
		$('.item_name').each(function()
		{
			if($(this).val().length == 0)
			{
				$('#prompt_tr').show();
				event.preventDefault();
			}
			else
			{
				$('#prompt_tr').hide();
			}
		});
		$('.item_content').each(function()
		{
			if($(this).val().length == 0)
			{
				$('#prompt_tr').show();
				event.preventDefault();
			}
			else
			{
				$('#prompt_tr').hide();
			}
		});
	});

});