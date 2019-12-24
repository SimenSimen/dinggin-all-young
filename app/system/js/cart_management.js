$(function(){

	$('.why').hover(function(){
		$('.prompt-box').show();
	}, function() {
		$('.prompt-box').hide();
	});

    //點擊列出商品列表
    var prd_cname;
    $('.cus_link').each(function()
    {
	    $(this).click(function()
	    {
	        var prd_cid=$(this).attr('id').substr(8);
	        $.ajax(
	        { 
				type: "post", 
				url : '/cart/product_class_name_ajax',
				cache: false,
				async: false,
				data:
				{
					id:  prd_cid
				},
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
					prd_cname=response;
				}
	      	});
	        $.ajax(
	        { 
				type: "post", 
				url : '/cart/product_list_ajax',
				cache: false,
				async: false,
				data:
				{
					id:  prd_cid,
					mid: $('#mid').text(),
				},
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
					// console.log(response+"\n");
					// if(prd_cname != '未分類')
					// {
						var class_ctrl_bar = 
											 '<form id="class_edit" method="post" action="/cart/class_edit/'+prd_cid+'"><p><span style="text-align: left; font-size: 18px;">分類名稱： <input style="width:68%;padding: 4px 1px 4px 6px;margin-right: 8px; font-size: 18px; border:0;" placeholder="最多32字元" minlength="1" maxlength="32" name="class_name" id="class_name" value="'+prd_cname+'"></span>'+
											 '<span style="width: 40%; text-align: right; border-radius: 5px; margin-left: 4px; height: 42px; vertical-align: middle;">'+
											 '<input type="hidden" id="original_class" value="'+prd_cname+'"><input type="hidden" id="classesid" value="'+prd_cid+'">'+
											 // '<span style="margin-right: 8px;">'+prd_cname+'</span>'+
											 // '<a class="aa6" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px;" href="/cart/class_edit/'+prd_cid+'" onclick=\'window.open(this.href, "", config="height=250,width=500,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1"); return false;\' title="編輯分類名稱" alt="編輯分類名稱"><i class="fa fa-floppy-o"></i></a>'+
											 '<a class="aa6" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px;" onclick="class_submit();" title="儲存分類名稱" alt="儲存分類名稱"><i class="fa fa-floppy-o"></i></a>'+
											 '<a class="aa6 class_delete" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px;" onclick=\'chk_class_del('+prd_cid+')\' title="刪除此分類" alt="刪除此分類"><i class="fa fa fa-times"></i></a>'+
											 '</form></span></p>'+
											 '<hr style="width:97%;margin-top:0px;margin-bottom: 2px;border: 1px teal; border-top: 1px solid navy;">'+
											 '<div id="component" style="width:100%;">'+
											 '<div style="width: 13%;float: left;margin-right: 3%;"><a class="aa6" style="width:100%;font-size: 0.987em;margin: 0; padding: 9px 0px;" onclick="checkbox_all();" title="全選" alt="全選"><i class="fa fa-check-square-o"></i> 全選</a></div>'+
											 '<div style="width:58.5%; float:left;"><a class="aa6" style="width:30%;font-size: 0.987em; padding: 9px 0px;margin: 0;" onclick="check_prd_selling();" title="加到熱銷" alt="加到熱銷"><i class="fa fa-heart"></i> 加到熱銷</a>'+
											 '<a class="aa6" style="width:30%;font-size: 0.987em; padding: 9px 0px; margin: 0 5%;" onclick="check_prd_slot();" title="上/下架切換" alt="上/下架切換"><i class="fa fa-shopping-cart"></i> 上/下架切換</a>'+
											 '<a class="aa6" style="width:30%;font-size: 0.987em; padding: 9px 0px;margin: 0;" onclick="check_prd_mv();" title="搬移分類" alt="搬移分類"><i class="fa fa-truck"></i> 搬移分類</a></div>'+
											 '<div style="width:20%;float: left;margin-left: 2.5%;"><a class="aa6 class_delete" style="width:100%;margin: 0;font-size: 0.987em; padding: 9px 0px;" onclick="check_prd_del();" title="移除勾選商品" alt="移除勾選商品"><i class="fa fa fa-times"></i> 移除勾選商品</a></div></div>'
											 ;
					// }
					// else
					// {
					// 	var class_ctrl_bar = '<p style="width: 741px; text-align: right; background-color: #f9f9f9; border-radius: 5px; margin-left: 4px; height: 42px; vertical-align: middle;">'+
					// 						 '<a class="aa6" style="font-size: 0.987em; margin: 0px 5px 5px 5px; padding: 9px 15px 9px 15px; background-color: #f9f9f9; color: #333; cursor: default;">'+prd_cname+'</a>'+
					// 					     '<a class="aa6" style="width:30%;font-size: 0.987em; padding: 9px 0px;margin: 0;" onclick="check_prd_mv();" title="搬移分類" alt="搬移分類"><i class="fa fa-truck"></i> 搬移分類</a>'+
					// 					     '<input type="hidden" id="classesid" value="0">'+
					// 						 '</p>';
					// }
					// $('#content').html(response);
					if(response != 'empty')
					{
						var response2 = {"tags":response};
						var tags = eval(response2.tags);
						//tags[0].prd_id
						//tags[1].prd_id

						//商品特點
							// var describe_string='';
							// for(var describe = 0; describe < tags.length; describe++)
							// {
							//   if(tags[describe].prd_describe != null)
							//   {
							//     var str = tags[describe].prd_describe.toString();
							//     var rstr = str.split(',');
							//     describe_string+='<ul>';
							//     for(var des = 0; des < rstr.length; des++)
							//     {
							//       describe_string+='<li>'+rstr[des]+'</li>';
							//     }
							//     describe_string+='</ul>';
							//   }
							// }

						//商品規格
							// var spec_string='';
							// for(var spec = 0; spec < tags.length; spec++)
							// {
							//   if(tags[spec].prd_specification_name != null && tags[spec].prd_specification_content != null)
							//   {
							//     var str1 = tags[spec].prd_specification_name.toString();
							//     var rstr1 = str1.split(',');
							//     var str2 = tags[spec].prd_specification_content.toString();
							//     var rstr2 = str2.split(',');
							//     spec_string+='<ul>';
							//     for(var s = 0; s < rstr1.length; s++)
							//     {
							//       spec_string+='<li>'+rstr1[s]+':'+rstr2[s]+'</li>';
							//     }
							//     spec_string+='</ul>';
							//   }
							// }

						var format = {
							'tag':'ul',
							'html':
							'<li style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 212px;" title="${prd_name}"><a id="prd_status" style="padding:5px 5px;color:${color}" title="${status}"><i class="${prd_active}"></i></a><span style="">${prd_name}</span></li>'+
							'<li style="text-align:center;"><div><img src="'+$('#img_url').text()+'products/${prd_image}"></div></li>'+
							'<li class="prd_id_li"><input type="checkbox" style="vertical-align: middle; zoom:145%;" class="prd_id_box" name="prd_id[]" value="${prd_id}"> ${prd_price00}元'+
							'<a class="aa5" href="/cart/product_edit/${prd_id}" style="margin-left: 0px;" onclick="window.open(this.href, \'\', config=\'height=650,width=1000,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1\'); return false;" title="編輯商品"><i class="fa fa-pencil-square-o"></i></a>'+
							'<a class="aa5" style="margin-left: 0px; cursor: pointer;" onclick="products_heart(${prd_id});" title="熱銷商品"><i id="${prd_id}" class="${prd_hot}"></i></a>'+
							'<a class="aa5" style="margin-left: 0px;cursor:default;" title="瀏覽率 ${prd_count}"><i class="fa fa-male"> <span style="font-size:10px">${prd_count}</span></i></a> </li>'
						};
						$('#content_ul').hide();
						$('#content_list').html(class_ctrl_bar+json2html.transform(tags, format));
						$('#content_list ul').css('width', '215px');
						$('#content_list ul').css('max-height', '215px');
						$('#content_list ul').css('border', '1px solid #B2A171');
						$('#content_list ul').css('display', '-moz-inline-stack');
						$('#content_list ul').css('display', 'inline-block');
						$('#content_list ul').css('vertical-align', 'top');
						$('#content_list ul').css('margin', '5px');
						$('#content_list ul li').css('line-height', '24px');
						$('#content_list ul li').css('list-style', 'none');
						$('#content_list ul li').css('list-style-position', 'inside');
						$('#content_list ul li div').css({'width':'215px','height':'140px','vertical-align':'middle', 'display':'table-cell', 'overflow':'hidden'  });
						$('#content_list ul li img').css({'vertical-align':'middle','max-width':'140px', 'max-height':'140px','width':'expression(this.width >140 && this.height <= this.width ? 140:true);','height':'expression(this.height >140 && this.width <= this.height ? 140:true);'});
						$('#content_list ul').css('margin', '5px');
						$('#content_list ul').css('padding', '10px');
					}
					else
					{
						$('#content_list').html(class_ctrl_bar+'<p style="line-height: 34px; margin-left: 2px;">此分類無任何商品</p>');
						$('#component').hide();
					}
				}
			});
		});
	});

	// 全選與不選
	var check_status = 1;
	checkbox_all = function(){
		if(check_status == 1)
		{
			check_status = 0;
			$(".prd_id_box").each(function() {
				$(this).prop("checked", true);
				$(this).parent().removeClass("photo_box");  
				$(this).parent().addClass("greenBackground"); 
			});
		}
		else
		{
			check_status = 1;
			$(".prd_id_box").each(function() {
				$(this).prop("checked", false);
				$(this).parent().removeClass("greenBackground");  
				$(this).parent().addClass("photo_box"); 
			});           
		}
	}
	// check 熱銷
	check_prd_selling = function(){
		var prd_selling = false;
		$('.prd_id_box').each(function(){
			if($(this).prop('checked'))
			{
				prd_selling = true;
				return false;
			}
		});
		if(prd_selling)
		{
			var chk_id = [];
			$('.prd_id_box:checked').each(function(){
				chk_id.push({prd_id:$(this).val()});
			});
			$.ajax(
			{
				type: "post", 
				url : '/cart/chk_products_hot',
				cache: false,
				async: false,
				data:
				{
					prd_id: chk_id
				},
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
					alert("編輯成功");
					window.location.reload();
				}
			});
		}
		else
		{
			alert('請至少勾選一項');
		}
	}
	// check 上/下架
	check_prd_slot = function(){
		var prd_slot = false;
		$('.prd_id_box').each(function(){
			if($(this).prop('checked'))
			{
				prd_slot = true;
				return false;
			}
		});
		if(prd_slot)
		{
			var chk_id = [];
			$('.prd_id_box:checked').each(function(){
				chk_id.push({prd_id:$(this).val()});
			});
			$.ajax(
			{
				type: "post", 
				url : '/cart/chk_products_slot',
				cache: false,
				async: false,
				data:
				{
					prd_id: chk_id
				},
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
					if(response)
					{
						alert("編輯成功");
						window.location.reload();
					}
					else
					{
						alert('編輯成功，提醒您：您有些物品庫存不足無法變更為上架')
						window.location.reload();
					}
				}
			});
		}
		else
		{
			alert('請至少勾選一項');
		}
	}
	// check 分類
	check_prd_mv = function(){
		var prd_mv = false;
		$('.prd_id_box').each(function(){
			if($(this).prop('checked'))
			{
				prd_mv = true;
				return false;
			}
		});
		if(prd_mv)
		{
			var chk_id = [];
			$('.prd_id_box:checked').each(function(){
				// chk_id.push($(this).val());
				chk_id += $(this).val() + 'ChkENAliKENfIKQ';
			});
			window.open('/cart/class_mv/'+$('#classesid').val()+'/'+chk_id,'',config="height=250,width=500,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1");
		}
		else
		{
			alert('請至少勾選一項');
		}
	}
	// check 刪除
	check_prd_del = function(){
		var prd_del = false;
		$('.prd_id_box').each(function(){
			if($(this).prop('checked'))
			{
				prd_del = true;
				return false;
			}
		});
		if(confirm('您確定要刪除勾選商品嗎?'))
		{
			if(prd_del)
			{
				var chk_id = [];
				$('.prd_id_box:checked').each(function(){
					chk_id.push({prd_id:$(this).val()});
				});
				$.ajax(
				{
					type: "post", 
					url : '/cart/chk_products_del',
					cache: false,
					async: false,
					data:
					{
						prd_id: chk_id
					},
					error: function(XMLHttpRequest, textStatus, errorThrown)
					{
					},
					success: function(response)
					{
						alert("刪除成功");
						window.location.reload();
					}
				});
			}
			else
			{
				alert('請至少勾選一項');
			}	
		}		
	}

	// 熱銷品
	products_heart = function(prd_id){
		$.ajax(
        { 
			type: "post", 
			url : '/cart/products_hot',
			cache: false,
			async: false,
			data:
			{
				prd_id:  prd_id
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
			},
			success: function(response)
			{
				if(response == 'fa fa-heart')
				{

					$('#'+prd_id).removeClass("fa fa-heart-o").addClass("fa fa-heart");
				}
				else
				{
					$('#'+prd_id).removeClass('fa fa-heart').addClass('fa fa-heart-o');
				}
			}
		});
	}

	// 分類修改
	class_submit = function(){
		if($('#class_name').val() == '')
		{
			alert('分類名稱不可以為空白');
		}
		else
		{
			if($('#original_class').val() != $('#class_name').val())
			{
				$('#class_edit').submit();
			}
			else
			{
				alert('此頁並無更新資料');
			}
		}
	}
});

function chk_class_del(prd_cid)
{
	$.ajax({ 
			type: "post", 
			url : '/cart/class_del',
			cache: false,
			async: false,
			data:
			{
				id:  prd_cid
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
			},
			success: function(response)
			{
				if(response == 'suc')
				{
					alert("刪除成功");
					window.location.reload();
				}
				else
					alert(response);
			}
		});
}