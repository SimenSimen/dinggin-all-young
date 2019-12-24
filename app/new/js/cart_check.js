$(function () {
	$('.del_prd').each(function () {
		$(this).click(function () {
			var del_key = $(this).attr('id').substr(8);
			if(confirm('您確定要刪除此項目?'))
			{
				window.location.href='/cart/cart_list_change/'+$('#cset_code').text()+'/0/'+del_key;
			}
		});
	});


	//form business validation
	var form_business = $('#buyer_info_form');
	form_business.validate(
	{
		success: function(label)
		{
			label.addClass("success").text("");
		}
	});

    $('#buyer_info_form').submit(function()
    {
        // 檢查數量
        $.ajax({
            type: "post",
            url: '/cart/amount_check',
            cache: false,
            async: false,
            dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
            },
            success: function (response) {
	            if(response.result != 1)
	            {
	                alert('很抱歉，購物車中商品庫存已異動，請再一次確認您的訂購數量');
	            }
	            else { }
            }
        });
    });

	$('#twzipcode').twzipcode({
	    countyName: 'addr_county',
	    districtName: 'addr_area',
	    zipcodeName: 'addr_zip',
	    zipcodeSel: 100,
		readonly: false
	});
	$('input[name=addr_zip]').attr('placeholder', '郵遞區號');
	$('input[name=addr_zip]').attr('maxlength', '5');
	$('input[name=addr_zip]').css('width', '78%');
	$('select[name=addr_area]').css('width', '100%');
	$('select[name=addr_county]').css('width', '100%');


	$('#receipt').twzipcode({
	    countyName: 'receipt_county',
	    districtName: 'receipt_area',
	    zipcodeName: 'receipt_zip',
	    zipcodeSel: 100,
		readonly: false
	});
	$('input[name=receipt_zip]').attr('placeholder', '郵遞區號');
	$('input[name=receipt_zip]').attr('maxlength', '5');
	$('input[name=receipt_zip]').css('width', '78%');
	$('select[name=receipt_area]').css('width', '100%');
	$('select[name=receipt_county]').css('width', '100%');

    $('#same_address').change(
    function(){
        if($(this).is(":checked"))
        {
        	$('input[name=receipt_zip]').val($('input[name=addr_zip]').val());
        	$('select[name=receipt_county]').val($('select[name=addr_county]').val());
        	$('select[name=receipt_area] option').remove();
        	$('select[name=receipt_area]').prepend("<option value='"+$('select[name=addr_area]').val()+"'>"+$('select[name=addr_area]').val()+"</option>");
        	$('select[name=receipt_area]').val($('select[name=addr_area]').val());
        	$('input[name=receipt_address]').val($('input[name=buyer_address_r]').val());
        	$("select[name=receipt_area] option[index='"+$('select[name=addr_area]').val()+"']").remove();
		}
		else
		{
        	$('input[name=receipt_zip]').val('');
        	$('input[name=buyer_receipt_address_r]').val('');
		}
    });

    $('#history_select').change(function () {
        var order_sort_id = $('#history_select option:selected').val();
        $.ajax({
            type: "post",
            url: '/cart/order_history_get',
            data: { id:  order_sort_id },
            cache: false,
            async: false,
            dataType: 'json',
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
            },
            success: function (response) {
                $('#same_address').prop("checked", false);

                $('#buyer_name').val(response.name);
                $('#buyer_phone').val(response.phone);
                $('#buyer_email').val(response.email);

                $('input[name=addr_zip]').val(response.zip);
                $('select[name=addr_county]').val(response.county);
                $('select[name=addr_area] option').remove();
                $('select[name=addr_area]').prepend("<option value='"+response.area+"'>"+response.area+"</option>");
                $('select[name=addr_area]').val(response.area);
                $('#buyer_address').val(response.address);
                $("select[name=addr_area] option[index='"+response.area+"']").remove();

                $('#receipt_title').val(response.receipt_title);
                $('#receipt_code').val(response.receipt_code);
                $('input[name=receipt_zip]').val(response.receipt_zip);
                $('select[name=receipt_county]').val(response.receipt_county);
                $('select[name=receipt_area] option').remove();
                $('select[name=receipt_area]').prepend("<option value='"+response.receipt_area+"'>"+response.receipt_area+"</option>");
                $('select[name=receipt_area]').val(response.receipt_area);
                $('#receipt_address').val(response.receipt_address);
                $("select[name=receipt_area] option[index='"+response.receipt_area+"']").remove();
            }
        });
    });
});
