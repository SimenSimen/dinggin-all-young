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

    $( "#zipcode" ).bind( "change", function(event, ui) {
        if($("#zipcode").val().length == 3)
        {
            $.ajax({
                type: "post", 
                url: '/cart/get_area',
                data: {
                    zipcode: $('#zipcode').val()
                },
                cache: false,
                dataType: "json",
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                },
                success: function (response) {
                    if(response.county != null && response.area != null)
                    {
                        $('#addr_county')
                            .find('option')
                            .remove()
                            .end()
                            .append(response.co)
                            .val(response.county)
                        ;
                        $('#addr_area')
                            .find('option')
                            .remove()
                            .end()
                            .append(response.options)
                            .val(response.area)
                        ;
                        $('#addr_county-button span').text(response.county);
                        $('#addr_area-button span').text(response.area);
                        $('#addr_county').next().attr('class').addClass("success").text("");
                    }
                    else
                    {
                        alert('錯誤的郵遞區號');
                        $( "#zipcode" ).val();
                    }
                }
            });
        }
        else($( "#zipcode" ).val().length == 5)
        {
            $.ajax({
                type: "post", 
                url: '/cart/get_area',
                data: {
                    zipcode: $('#zipcode').val().substr(0, 3)
                },
                cache: false,
                dataType: "json",
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                },
                success: function (response) {
                    if(response.county != null && response.area != null)
                    {
                        $('#addr_county')
                            .find('option')
                            .remove()
                            .end()
                            .append(response.co)
                            .val(response.county)
                        ;
                        $('#addr_area')
                            .find('option')
                            .remove()
                            .end()
                            .append(response.options)
                            .val(response.area)
                        ;
                        $('#addr_county-button span').text(response.county);
                        $('#addr_area-button span').text(response.area);
                        $('#addr_county').next().attr('class').addClass("success").text("");
                    }
                    else
                    {
                        alert('錯誤的郵遞區號');
                        $( "#zipcode" ).val();
                    }
                }
            });
        } 
    });

    $( "#addr_county" ).bind( "change", function(event, ui) {
        $.ajax({
            type: "post", 
            url: '/cart/get_area',
            data: {
                county: $('#addr_county').val()
            },
            cache: false,
            async: false,
            dataType: "json",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            },
            success: function (response) {
                $('#addr_area')
                    .find('option')
                    .remove()
                    .end()
                    .append(response.options)
                    .val(response.first)
                ;
                $('#addr_area').val(response.first);
                $('#addr_area-button span').text(response.first);
                $.post("/cart/get_zipcode", { county: $('#addr_county').val(), area: $('#addr_area').val()}, function(data){
                    $('#zipcode').val(data);
                }); 
            }
        });
    });

    $( "#addr_area" ).bind( "change", function(event, ui) {
        $.post("/cart/get_zipcode", { county: $('#addr_county').val(), area: $('#addr_area').val()}, function(data){
            $('#zipcode').val(data);
        }); 
    });

    $('#same_address').bind( "change", function(event, ui) {
        if($("#same_address").prop("checked"))
        {
            $('#receipt_zip').val($('#zipcode').val());
            $('#receipt_county').val($('#addr_county').val());
            $('#receipt_county-button span').text($('#addr_county-button span').text());
            $('#receipt_address').val($('#buyer_address').val());
            var this_val, copy_options = '';
            $("#addr_area option").each(function()
            {
                this_val = $(this).val();
                copy_options += '<option value="'+this_val+'">'+this_val+'</option>';
            });
            $('#receipt_area')
                .find('option')
                .remove()
                .end()
                .append(copy_options)
                .val($('#addr_area').val())
            ;
            $('#receipt_area-button span').text($('#addr_area-button span').text());
        }
        else
        {
            $('#receipt_zip').val('');
            $('#receipt_county').val('');
            $('#receipt_area').val('');
            $('#receipt_county-button span').text('請選擇縣市');
            $('#receipt_area-button span').text('請選擇地區');
            $('#receipt_address').val('');
        }
    });

    $( "#receipt_zip" ).bind( "change", function(event, ui) {
        if($( "#receipt_zip" ).val().length == 3 || $( "#receipt_zip" ).val().length == 5)
        {
            $.ajax({
            type: "post", 
            url: '/cart/get_area',
            data: {
                zipcode: $('#receipt_zip').val()
            },
            cache: false,
            dataType: "json",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            },
            success: function (response) {
                if(response.county != null && response.area != null)
                {
                    $('#receipt_county')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.co)
                        .val(response.county)
                    ;
                    $('#receipt_area')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.options)
                        .val(response.area)
                    ;
                    $('#receipt_county-button span').text(response.county);
                    $('#receipt_area-button span').text(response.area);
                    $('#receipt_county').next().attr('class').addClass("success").text("");
                }
                else
                {
                    alert('錯誤的郵遞區號');
                    $( "#receipt_zip" ).val();
                }
            }
        });
        }
    });

    $( "#receipt_county" ).bind( "change", function(event, ui) {
        $.ajax({
            type: "post", 
            url: '/cart/get_area',
            data: {
                county: $('#receipt_county').val()
            },
            cache: false,
            async: false,
            dataType: "json",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            },
            success: function (response) {
                $('#receipt_area')
                    .find('option')
                    .remove()
                    .end()
                    .append(response.options)
                    .val(response.first)
                ;
                $('#receipt_area').val(response.first);
                $('#receipt_area-button span').text(response.first);
                $.post("/cart/get_zipcode", { county: $('#receipt_county').val(), area: $('#receipt_area').val()}, function(data){
                    $('#receipt_zip').val(data);
                }); 
            }
        });
    });

    $( "#receipt_area" ).bind( "change", function(event, ui) {
        $.post("/cart/get_zipcode", { county: $('#receipt_county').val(), area: $('#receipt_area').val()}, function(data){
            $('#receipt_zip').val(data);
        }); 
    });

    $('#buyer_pay_way').closest(".ui-select").css('width', '100%');
    $('#history_select').closest(".ui-select").css('width', '100%');

    $('#history_select').change(function () {
        var order_sort_id = $('#history_select option:selected').val();
        if(order_sort_id != '')
        {
            $.ajax({
                type: "post",
                url: '/cart/get_area',
                data: { id:  order_sort_id },
                cache: false,
                async: false,
                dataType: 'json',
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                },
                success: function (response) {
                    
                    $('#same_address').attr('data-cacheval', 'true');
                    $('#same_address').prev("label").removeClass('ui-checkbox-on');
                    $('#same_address').prev("label").addClass('ui-checkbox-off');

                    $('#buyer_name').val(response.order.name);
                    $('#buyer_phone').val(response.order.phone);
                    $('#buyer_email').val(response.order.email);

                    $('#zipcode').val(response.order.zip);
                    $('#addr_county')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.co)
                        .val(response.order.county)
                    ;
                    $('#addr_area')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.options)
                        .val(response.order.area)
                    ;
                    $('#addr_county-button span').text(response.order.county);
                    $('#addr_area-button span').text(response.order.area);
                    $('#buyer_address').val(response.order.address);

                    $('#receipt_zip').val(response.order.receipt_zip);
                    $('#receipt_county')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.co)
                        .val(response.order.receipt_county)
                    ;
                    $('#receipt_area')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.options2)
                        .val(response.order.receipt_area)
                    ;
                    $('#receipt_county-button span').text(response.order.receipt_county);
                    $('#receipt_area-button span').text(response.order.receipt_area);
                    $('#receipt_address').val(response.order.receipt_address);

                    $('#receipt_title').val(response.order.receipt_title);
                    $('#receipt_code').val(response.order.receipt_code);
                    
                    $('#buyer_pay_way').val('');
                }
            });
        }
        else
        {
            $.ajax({
                type: "post", 
                url: '/cart/get_county',
                cache: false,
                dataType: "json",
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                },
                success: function (response) {
                    $('#same_address').attr('data-cacheval', 'true');
                    $('#same_address').prev("label").removeClass('ui-checkbox-on');
                    $('#same_address').prev("label").addClass('ui-checkbox-off');

                    $('#buyer_name').val('');
                    $('#buyer_phone').val('');
                    $('#buyer_email').val('');

                    $('#zipcode').val('');
                    $('#addr_county')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.county)
                        .val('')
                    ;
                    $('#addr_area')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">請選擇</option>')
                        .val('')
                    ;
                    $('#addr_county-button span').text('請選擇');
                    $('#addr_area-button span').text('請選擇');
                    $('#buyer_address').val('');

                    $('#receipt_zip').val('');
                    $('#receipt_county')
                        .find('option')
                        .remove()
                        .end()
                        .append(response.county)
                        .val('')
                    ;
                    $('#receipt_area')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">請選擇</option>')
                        .val('')
                    ;
                    $('#receipt_county-button span').text('請選擇');
                    $('#receipt_area-button span').text('請選擇');
                    $('#receipt_address').val('');

                    $('#receipt_title').val('');
                    $('#receipt_code').val('');
                    $('#buyer_pay_way').val(''); 
                }
            });
        }
    });
});