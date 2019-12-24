$(function(){

	$('.why').hover(function(){
		$('.prompt-box').show();
	}, function() {
		$('.prompt-box').hide();
	});

    //點擊列出商品列表
    $.ajax(
    { 
		type: "post", 
		url : '/cart/product_list_ajax',
		cache: false,
		async: false,
		data:
		{
			id:  -1,
			mid: $('#mid').text(),
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
		},
		success: function(response)
		{
			var class_ctrl_bar = '<p style="width: 99.1%; text-align: right; background-color: #f9f9f9; border-radius: 5px; margin-left: 4px; height: 42px; vertical-align: middle;">'+
								 '<span id="del_prompt" style="margin-right: 8px;">請選擇您要刪除的商品</span>'+
								 '<a class="aa6" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px;" id="check_all" title="全選" alt="全選">全選</a>'+
								 '<a class="aa6 class_delete" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px;" onclick=\'chk_product_del()\' title="移除勾選商品" alt="移除勾選商品">移除勾選商品 <i class="fa fa fa-times"></i></a>'+
								 '</p>';

			// $('#content').html(response);
			if(response != 'empty')
			{
				var response2 = {"tags":response};
				var tags = eval(response2.tags);
				var format = {
					'tag':'ul',
					'html':
					'<li style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 212px;" title="${prd_name}">${prd_name}</li>'+
					'<li style="text-align:center;"><img src="'+$('#img_url').text()+'products/${prd_image}"></li>'+
					'<li class="prd_id_li"><input type="checkbox" name="prd_id[]" value="${prd_id}" class="prd_id">&nbsp;${prd_price00}元</li>'
				};

				$('#content_ul').hide();
				$('#content_list').html(class_ctrl_bar+json2html.transform(tags, format));

				$('#content_list ul').css('width', '214px');
				$('#content_list ul').css('max-height', '214px');
				$('#content_list ul').css('border', '1px solid #B2A171');
				$('#content_list ul').css('display', '-moz-inline-stack');
				$('#content_list ul').css('display', 'inline-block');
				$('#content_list ul').css('vertical-align', 'top');
				$('#content_list ul').css('margin', '5px');
				$('#content_list ul li').css('line-height', '24px');
				$('#content_list ul li').css('list-style', 'none');
				$('#content_list ul li').css('list-style-position', 'inside');
				$('#content_list ul li img').css('max-height', '140px');
				$('#content_list ul li img').css('max-width', '140px');
				$('#content_list ul li img').css('min-height', '140px');
				$('#content_list ul').css('margin', '5px');
				$('#content_list ul').css('padding', '10px');
			}
			else
			{
				$('#content_list').html(class_ctrl_bar+'<p style="line-height: 34px; margin-left: 2px;">此分類無任何商品</p>');
			}
		}
	});

	//全選與全不選
	var check_all_status = 1;
	$("#check_all").click(function() {
		if(check_all_status == 1)
		{
			check_all_status = 0;
			$(".prd_id").each(function() {
				$(this).prop("checked", true);
				$(this).parent().removeClass("photo_box");  
				$(this).parent().addClass("greenBackground"); 
			});
		}
		else
		{
			check_all_status = 1;
			$(".prd_id").each(function() {
				$(this).prop("checked", false);
				$(this).parent().removeClass("greenBackground");  
				$(this).parent().addClass("photo_box"); 
			});           
		}
	});

});

function chk_product_del()
{
	if(confirm('您確定要刪除勾選商品嗎?'))
	{
		var check_statu = false;
		$(".prd_id").each(function() {
			if($(this).prop("checked"))
			{
				check_statu = true;
				return false;
			}
		});
		if(check_statu)
			form_product_del.submit();
		else
		{
			$('#del_prompt').text('請至少勾選一項');
			$('#del_prompt').css('color', '#ff6600');
		}
	}
}