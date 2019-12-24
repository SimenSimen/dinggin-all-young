$(function() {

	function _Reset_8_style() {
    	// 文字顏色2-5
        $('#fonts_color_21').val($('#dfu_font_color_2').val());
        $('#fonts_color_21').css('background', $('#dfu_font_color_2').val());
        $('#fonts_color_22').val($('#dfu_font_color_2').val());
        $('#fonts_color_31').val($('#dfu_font_color_3').val());
        $('#fonts_color_31').css('background', $('#dfu_font_color_3').val());
        $('#fonts_color_32').val($('#dfu_font_color_3').val());
        $('#fonts_color_41').val($('#dfu_font_color_4').val());
        $('#fonts_color_41').css('background', $('#dfu_font_color_4').val());
        $('#fonts_color_42').val($('#dfu_font_color_4').val());
        $('#fonts_color_51').val($('#dfu_font_color_5').val());
        $('#fonts_color_51').css('background', $('#dfu_font_color_5').val());
        $('#fonts_color_52').val($('#dfu_font_color_5').val());
        // 文字尺寸 2-5
        $('#fonts_size_2').val($('#dfu_font_size_2').val());
        $('#fonts_size_3').val($('#dfu_font_size_3').val());
        $('#fonts_size_4').val($('#dfu_font_size_4').val());
        $('#fonts_size_5').val($('#dfu_font_size_5').val());
        // 文字字型 2-5
        $('#fonts_family_2').val($('#dfu_font_family_2').val());
        $('#fonts_family_3').val($('#dfu_font_family_3').val());
        $('#fonts_family_4').val($('#dfu_font_family_4').val());
        $('#fonts_family_5').val($('#dfu_font_family_5').val());
	}
	
	function _Reset_UserSeting_8() {
		for (i = 2; i < 6; i++)
		{
			for (num = 1; num < 3; num++)
			{
					$('#fonts_color_'+ i + num).val($('#user_font_color_'+ i).val());
			}

			$('#fonts_size_' + i).val($('#user_font_size_' + i).val());
			$('#fonts_family_' + i).val($('#user_font_family_' + i).val());
		}
	}

    //切換顯示背景圖or色欄位
    $('.switch_background_type').change(function() {
        if ($("#color_background").prop("checked")) {
            $('#color_background_tr').show();
            $('#image_background_tr').hide();
            $('#system_background_tr').hide();
        } else {
            $('#image_background_tr').show();
            $('#system_background_tr').show();
            $('#color_background_tr').hide();
        }
    });

    //檢查radio必選
    $('#form_iqr_style').submit(function(event) {
        if ($('.theme_radio:radio', this).is(':checked')) {} else {
            alert('請選擇版型');
            $(window).scrollTop(0);
            event.preventDefault();
        }
    });

    //基本版型使用按鈕顏色[theme_radio_1]欄位
    // $('.ui-state-default input[type=radio]').change(
    // function(){
    //     if ($('#theme_radio_1').is(':checked')) {
    //       $('#jqm_button_select_div').show();
    //     }
    //     else $('#jqm_button_select_div').hide();
    // });

    //當li被點擊，選取radio
    $('#iqr_theme_ul li').click(function(event) {
        if (event.target.type !== 'radio') {
            $(':radio', this).trigger('click');
        }
    });
    $('#iqr_theme_background_ul li').click(function(event) {
        if (event.target.type !== 'radio') {
            $(':radio', this).trigger('click');
        }
    });

    //當radio被點擊，li變色
    var radios = $('#iqr_theme_ul input[type=radio]');
    radios.on('change', function() {
        radios.each(function() {
            var radio = $(this);
            radio.closest('li')[radio.is(':checked') ? 'addClass' : 'removeClass']('highlight');
        });
    });
    var radios2 = $('#iqr_theme_background_ul input[type=radio]');
    radios2.on('change', function() {
        radios2.each(function() {
            var radio2 = $(this);
            radio2.closest('li')[radio2.is(':checked') ? 'addClass' : 'removeClass']('highlight');
        });
    });

    $('#theme_background_radio_basic').change(function() {
        $('#iqr_theme_background_ul li').each(function() {
            $(this).removeClass("highlight");
        });
    });

    //系統版型預設顏色讀取
    var tid;
    var ajax_id, ajax_fcolor, ajax_fsize, ajax_ffamily, ajax_bgtype, ajax_bgcolor, ajax_bgpath, ajax_bgpathid;
    var ajax_fcolor2, ajax_fcolor3, ajax_fcolor4, ajax_fcolor5, ajax_fsize2, ajax_fsize3, ajax_fsize4, ajax_fsize5, ajax_ffamily2, ajax_ffamily3, ajax_ffamily4, ajax_ffamily5;

    function _Radio_8_Event(response) {
    	$('.radio_8').show();
        $('#fonts_color_21').hide();
        $('#fonts_color_22').show();
        $('#fonts_color_31').hide();
        $('#fonts_color_32').show();
        $('#fonts_color_41').hide();
        $('#fonts_color_42').show();
        $('#fonts_color_51').hide();
        $('#fonts_color_52').show();
        $('#fonts_size_2').show();
        $('#fonts_size_3').show();
        $('#fonts_size_4').show();
        $('#fonts_size_5').show();
        $('#fonts_family_2').show();
        $('#fonts_family_3').show();
        $('#fonts_family_4').show();
        $('#fonts_family_5').show();
        ajax_fcolor2 = response.dfu_font_color_2;
        ajax_fcolor3 = response.dfu_font_color_3;
        ajax_fcolor4 = response.dfu_font_color_4;
        ajax_fcolor5 = response.dfu_font_color_5;
        ajax_fsize2 = response.dfu_font_size_2;
        ajax_fsize3 = response.dfu_font_size_3;
        ajax_fsize4 = response.dfu_font_size_4;
        ajax_fsize5 = response.dfu_font_size_5;
        ajax_ffamily2 = response.dfu_font_family_2;
        ajax_ffamily3 = response.dfu_font_family_3;
        ajax_ffamily4 = response.dfu_font_family_4;
        ajax_ffamily5 = response.dfu_font_family_5;
        // 文字顏色 2-5
        $('#fonts_color_21').val(ajax_fcolor2);
        $('#fonts_color_22').val(ajax_fcolor2);
        $('#fonts_color_21').css('background', ajax_fcolor2);
        $('#fonts_color_31').val(ajax_fcolor2);
        $('#fonts_color_32').val(ajax_fcolor2);
        $('#fonts_color_31').css('background', ajax_fcolor3);
        $('#fonts_color_21').val(ajax_fcolor2);
        $('#fonts_color_42').val(ajax_fcolor2);
        $('#fonts_color_41').css('background', ajax_fcolor4);
        $('#fonts_color_51').val(ajax_fcolor2);
        $('#fonts_color_52').val(ajax_fcolor2);
        $('#fonts_color_51').css('background', ajax_fcolor5);
        // 文字尺寸 2-5
        $('#fonts_size_2').val(ajax_fsize2);
        $('#fonts_size_3').val(ajax_fsize3);
        $('#fonts_size_4').val(ajax_fsize4);
        $('#fonts_size_5').val(ajax_fsize5);
        // 文字字型 2-5
        $('#fonts_family_2').val(ajax_ffamily2);
        $('#fonts_family_3').val(ajax_ffamily3);
        $('#fonts_family_4').val(ajax_ffamily4);
        $('#fonts_family_5').val(ajax_ffamily5);
    }

    function _Radio_8_Hidden() {
    	$('.radio_8').hide();
    }

    $('.theme_radio').change(function() {
        $.blockUI({
            message: '讀取系統版型預設值',
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
        $.ajax({
            type: "post",
            url: $('#base_url').val() + 'business/iqr_default_style',
            cache: false,
            data: {
                theme_id: $('#' + $(this).attr('id') + ':radio').val()
            },
            dataType: "json",
            async: false,
            error: function(XMLHttpRequest, textStatus, errorThrown) {},
            success: function(response) {
                $.unblockUI();
                tid = $('#' + $(this).attr('id') + ':radio').val();
                ajax_id = response.theme_id;
                ajax_fcolor = response.dfu_font_color;
                ajax_fsize = response.dfu_font_size;
                ajax_ffamily = response.dfu_font_family;
                ajax_bgtype = response.dfu_bg_type;
                ajax_bgcolor = response.dfu_bg_color;
                ajax_bgpath = response.dfu_bg_image_path;
                ajax_bgpathid = response.bg_image_path_id;

                //系統版型
                $('#theme_radio_' + ajax_id + ':radio').click();
                if (ajax_id == '8') {
                	_Radio_8_Event(response);
                } else {
                	_Radio_8_Hidden();
                }

                //按鈕顏色
                $('#jqm_button_color option[value="e"]').attr('selected', true);
                //文字顏色
                $('#fonts_color1').val(ajax_fcolor);
                $('#fonts_color2').val(ajax_fcolor);
                $('#fonts_color1').css('background', ajax_fcolor);

                $('#fonts_colorUSER1').val(ajax_bgcolor);
                $('#fonts_colorUSER2').val(ajax_bgcolor);
                $('#fonts_colorUSER1').css('background', ajax_fcolor);
                $('#fonts_colorUSER11').val(ajax_bgcolor);
                $('#fonts_colorUSER12').val(ajax_bgcolor);
                $('#fonts_colorUSER11').css('background', ajax_fcolor);
                $('#fonts_colorUSER21').val(ajax_bgcolor);
                $('#fonts_colorUSER22').val(ajax_bgcolor);
                $('#fonts_colorUSER21').css('background', ajax_fcolor);
                $('#fonts_colorUSER31').val(ajax_bgcolor);
                $('#fonts_colorUSER32').val(ajax_bgcolor);
                $('#fonts_colorUSER31').css('background', ajax_fcolor);


                $('#set_03list1').val(ajax_bgcolor);
                $('#set_03list2').val(ajax_bgcolor);
                $('#set_03list1').css('background', ajax_fcolor);
                $('#set_header1').val(ajax_bgcolor);
                $('#set_header2').val(ajax_bgcolor);
                $('#set_header1').css('background', ajax_fcolor);

                //文字尺寸
                $('#fonts_size').val(ajax_fsize);
                //文字字型
                $('#fonts_family').val(ajax_ffamily);
                //背景模式
                if (ajax_bgtype == 0) //顏色模式
                    $('#color_background').trigger('click');
                else
                    $('#image_background').trigger('click');
                //背景顏色
                $('#background_color1').val(ajax_bgcolor);
                $('#background_color2').val(ajax_bgcolor);
                $('#background_color1').css('background', ajax_bgcolor);



                //背景圖預設
                if (ajax_bgpath != '')
                    $('#theme_background_radio_' + ajax_bgpathid).click();
            }
        });
    });
    $('#theme_radio_' + $('#user_theme_id').val() + ':radio').click();

    $('#help1').hover(function() {
        $('#dfu_background').show();
        $('#dfu_background').attr('src', ajax_bgpath);
    }, function() {
        $('#dfu_background').hide();
    });

    //初始化
    //初始顯示區塊是背景顏色還是背景素材
    if ($('#bg_type').val() == 0) {
        $('#color_background_tr').show();
        $('#image_background_tr').hide();
        $('#system_background_tr').hide();
    } else {
        $('#image_background_tr').show();
        $('#system_background_tr').show();
        $('#color_background_tr').hide();
    }
    //初始按鈕顏色
    $('#jqm_button_color option[value="' + $('#user_jqm_button_color').val() + '"]').attr('selected', true);
    //初始字體顏色
    $('#fonts_color1').val($('#user_font_color').val());
    $('#fonts_color2').val($('#user_font_color').val());
    $('#fonts_color1').css('background', $('#user_font_color').val());

    $('#fonts_color_21').val($('#user_font_color_2').val());
    $('#fonts_color_22').val($('#user_font_color_2').val());
    $('#fonts_color_21').css('background', $('#user_font_color_2').val());

    $('#fonts_color_31').val($('#user_font_color_3').val());
    $('#fonts_color_32').val($('#user_font_color_3').val());
    $('#fonts_color_31').css('background', $('#user_font_color_3').val());

    $('#fonts_color_41').val($('#user_font_color_4').val());
    $('#fonts_color_42').val($('#user_font_color_4').val());
    $('#fonts_color_41').css('background', $('#user_font_color_4').val());

    $('#fonts_color_51').val($('#user_font_color_5').val());
    $('#fonts_color_52').val($('#user_font_color_5').val());
    $('#fonts_color_51').css('background', $('#user_font_color_5').val());

	$('#fonts_size_2').val($('#user_font_size_2').val());
	$('#fonts_size_3').val($('#user_font_size_3').val());
	$('#fonts_size_4').val($('#user_font_size_4').val());
	$('#fonts_size_5').val($('#user_font_size_5').val());
	$('#fonts_family_2').val($('#user_font_family_2').val());
	$('#fonts_family_3').val($('#user_font_family_3').val());
	$('#fonts_family_4').val($('#user_font_family_4').val());
	$('#fonts_family_5').val($('#user_font_family_5').val());

    $('#fonts_colorUSER1').val($('#user_font_color').val());
    $('#fonts_colorUSER2').val($('#user_font_color').val());
    $('#fonts_colorUSER1').css('background', $('#user_font_color').val());
    $('#fonts_colorUSER11').val($('#user_font_color1').val());
    $('#fonts_colorUSER12').val($('#user_font_color1').val());
    $('#fonts_colorUSER11').css('background', $('#user_font_color1').val());
    $('#fonts_colorUSER21').val($('#user_font_color2').val());
    $('#fonts_colorUSER22').val($('#user_font_color2').val());
    $('#fonts_colorUSER21').css('background', $('#user_font_color2').val());
    $('#fonts_colorUSER31').val($('#user_font_color3').val());
    $('#fonts_colorUSER32').val($('#user_font_color3').val());
    $('#fonts_colorUSER31').css('background', $('#user_font_color3').val());

    $('#set_header1').val($('#set_header').val());
    $('#set_header2').val($('#set_header').val());
    $('#set_header1').css('background', $('#set_header').val());

    $('#set_03list1').val($('#set_03list').val());
    $('#set_03list2').val($('#set_03list').val());
    $('#set_03list1').css('background', $('#set_03list').val());

    //初始字體大小
    $('#fonts_size').val($('#user_font_size').val());
    //初始字體字型
    $('#fonts_family').val($('#user_font_family').val());
    //背景模式
    if ($('#bg_type').val() == 0) //顏色模式
        $('#color_background').trigger('click');
    else
        $('#image_background').trigger('click');
    //初始背景顏色
    $('#background_color1').val($('#user_bg_color').val());
    $('#background_color2').val($('#user_bg_color').val());
    $('#background_color1').css('background', $('#user_bg_color').val());

    //背景圖預設
    if ($('#user_bg_image_path').val() != '')
        $('#theme_background_radio_' + $('#user_bg_image_path_id').val()).click();

    

    //恢復系統預設值
    $('#reset_style').click(function() {
        if (confirm('您確定要恢復系統預設值?')) {
            //系統版型
            $('#theme_radio_' + $('#user_theme_id').val() + ':radio').click();
            //按鈕顏色
            $('#jqm_button_color option[value="e"]').attr('selected', true);
            //文字顏色
            $('#fonts_color1').val($('#dfu_font_color').val());
            $('#fonts_color2').val($('#dfu_font_color').val());
            $('#fonts_color1').css('background', $('#dfu_font_color').val());

            $('#fonts_colorUSER1').val($('#dfu_font_color').val());
            $('#fonts_colorUSER2').val($('#dfu_font_color').val());
            $('#fonts_colorUSER1').css('background', $('#dfu_font_color').val());
            $('#fonts_colorUSER11').val($('#dfu_font_color').val());
            $('#fonts_colorUSER12').val($('#dfu_font_color').val());
            $('#fonts_colorUSER11').css('background', $('#dfu_font_color').val());
            $('#fonts_colorUSER21').val($('#dfu_font_color').val());
            $('#fonts_colorUSER22').val($('#dfu_font_color').val());
            $('#fonts_colorUSER21').css('background', $('#dfu_font_color').val());
            $('#fonts_colorUSER31').val($('#dfu_font_color').val());
            $('#fonts_colorUSER32').val($('#dfu_font_color').val());
            $('#fonts_colorUSER31').css('background', $('#dfu_font_color').val());

            $('#set_header1').val($('#dfu_font_color').val());
            $('#set_header2').val($('#dfu_font_color').val());
            $('#set_header1').css('background', $('#dfu_font_color').val());
            $('#set_03list1').val($('#dfu_font_color').val());
            $('#set_03list2').val($('#dfu_font_color').val());
            $('#set_03list1').css('background', $('#dfu_font_color').val());

            _Reset_8_style();

            //文字尺寸
            $('#fonts_size').val($('#dfu_font_size').val());

            //文字字型
            $('#fonts_family').val($('#dfu_font_family').val());

            // 背景模式
            if ($('#dfu_bg_type').val() == 0) //顏色模式
                $('#color_background').trigger('click');
            else
                $('#image_background').trigger('click');
            //背景顏色
            $('#background_color1').val($('#dfu_bg_color').val());
            $('#background_color2').val($('#dfu_bg_color').val());
            $('#background_color1').css('background', $('#dfu_bg_color').val());
            //背景圖預設
            if ($('#user_bg_image_path').val() != '')
                $('#theme_background_radio_' + $('#user_bg_image_path_id').val()).click();
        }
    });

    // 還原編輯前狀態
    $('#reset_edit').click(function() {
        if (confirm('您確定要重新設定?')) {
            if ($('#bg_type').val() == 0) {
                $('#color_background_tr').show();
                $('#image_background_tr').hide();
                $('#system_background_tr').hide();
            } else {
                $('#image_background_tr').show();
                $('#system_background_tr').show();
                $('#color_background_tr').hide();
            }
            //theme_id
            $('#theme_radio_' + $('#user_theme_id').val() + ':radio').click();
            //初始按鈕顏色
            $('#jqm_button_color option[value="' + $('#user_jqm_button_color').val() + '"]').attr('selected', true);
            //初始字體顏色
            $('#fonts_color1').val($('#user_font_color').val());
            $('#fonts_color2').val($('#user_font_color').val());
            $('#fonts_color1').css('background', $('#user_font_color').val());

            $('#fonts_colorUSER1').val($('#user_font_color').val());
            $('#fonts_colorUSER2').val($('#user_font_color').val());
            $('#fonts_colorUSER1').css('background', $('#user_font_color').val());
            $('#fonts_colorUSER11').val($('#user_font_color1').val());
            $('#fonts_colorUSER12').val($('#user_font_color1').val());
            $('#fonts_colorUSER11').css('background', $('#user_font_color1').val());
            $('#fonts_colorUSER21').val($('#user_font_color2').val());
            $('#fonts_colorUSER22').val($('#user_font_color2').val());
            $('#fonts_colorUSER21').css('background', $('#user_font_color2').val());
            $('#fonts_colorUSER31').val($('#user_font_color3').val());
            $('#fonts_colorUSER32').val($('#user_font_color3').val());
            $('#fonts_colorUSER31').css('background', $('#user_font_color3').val());


            $('#set_header1').val($('#set_header').val());
            $('#set_header2').val($('#set_header').val());
            $('#set_header1').css('background', $('#set_header').val());

            $('#set_03list1').val($('#set_03list').val());
            $('#set_03list2').val($('#set_03list').val());
            $('#set_03list1').css('background', $('#set_03list').val());

            _Reset_UserSeting_8();

            //初始字體大小
            $('#fonts_size').val($('#user_font_size').val());
            //初始字體字型
            $('#fonts_family').val($('#user_font_family').val());
            //背景模式
            if ($('#bg_type').val() == 0) //顏色模式
                $('#color_background').trigger('click');
            else
                $('#image_background').trigger('click');
            //初始背景顏色
            $('#background_color1').val($('#user_bg_color').val());
            $('#background_color2').val($('#user_bg_color').val());
            $('#background_color1').css('background', $('#user_bg_color').val());
            //背景圖預設
            if ($('#user_bg_image_path').val() != '')
                $('#theme_background_radio_' + $('#user_bg_image_path_id').val()).click();
        }
    });
});
