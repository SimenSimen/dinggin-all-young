var fill;
var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
			(/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
			(/MSIE/i.test(navigator.userAgent)) ? 'IE' :
			'非 Firefox/Chrom/IE 瀏覽器';

(function ($) {
	'use strict';

	var isOpera = Object.prototype.toString.call(window.opera) === '[object Opera]',

		guiValuePairs = [
			["size", "px"],
			["minversion", ""],
			["quiet", " px"],
			["radius", "%"],
			["msize", ""],
			["mposx", ""],
			["mposy", ""]
		],

		updateGui = function () {

			$.each(guiValuePairs, function (idx, pair) {

				var $label = $('label[for="' + pair[0] + '"]');

				$label.text($label.text().replace(/:.*/, ': ' + $('#' + pair[0]).val() + pair[1]));
			});
		},

		updateQrCode = function () {

			//font type setting
			var font_val;
			if($("#font").val() == 0)
				font_val='Times New Roman';
			else if($("#font").val() == 1)
				font_val='Cambria';
			else if($("#font").val() == 2)
				font_val='新細明體';
			else if($("#font").val() == 3)
				font_val='標楷體';
			else if($("#font").val() == 4)
				font_val='微軟正黑體';

			//content setting
			var content;
			if($("#edit_target").val() == 0)
				content = $("#base_url").val()+'s/r/'+$("#id").val();
			else if($("#edit_target").val() == 2)
				content = $("#base_url").val()+'app/route/'+$("#mid").val();

			if(browser == 'Firefox' || browser == 'IE')
			{
				$('#fill1').show();
				$('#fill2').hide();
				$('#background1').show();
				$('#background2').hide();
				$('#fontcolor1').show();
				$('#fontcolor2').hide();
			}
			else
			{
				$('#fill2').show();
				$('#fill1').hide();
				$('#background2').show();
				$('#background1').hide();
				$('#fontcolor2').show();
				$('#fontcolor1').hide();
			}

			if($("#edit_target").val() == 1)
			{
				content = 'MECARD:';
				if($("#lastname").length > 0 && $("#firstname").length == 0)
				{
					content+= "N:"+$("#lastname").val()+";";
				}
				else if($("#lastname").length > 0 && $("#firstname").length > 0)
				{
					content+= "N:"+$("#firstname").val()+",";
					content+= $("#lastname").val()+";";
				}
				if($("#cpn_name").length > 0)
				{
					content+= "NOTE:"+$("#cpn_name").val()+";";
				}
				if($("#cpn_tel").val() != '')
				{
					content+= "TEL:"+$("#cpn_tel").val()+";";
				}
				if($("#mphone").val() != '')
				{
					content+= "TEL:"+$("#mphone").val()+";";
				}
				if($("#cpn_fax").val() != '')
				{
					content+= "TEL:"+$("#cpn_fax").val()+";";
				}
				if($("#ecard_mail").length > 0)
				{
					content+= "EMAIL:"+$("#ecard_mail").val()+";";
				}
				if($("#cpn_addr").length > 0)
				{
					content+= "ADR:,,"+$("#cpn_addr").val()+",,,,;";
				}
				if($("#cpn_website").length > 0 && $("#cpn_website").val() != '0')
				{
					content+= "URL:"+$("#cpn_website").val()+";";
				}
				content+= ";";
			}

			var options = {
				render: $("#render").val(),
				ecLevel: $("#eclevel").val(),
				minVersion: parseInt($("#minversion").val(), 10),

				fill: $('#fill2').val(),
				background: $('#background2').val(),

				text: toUtf8(content),
				size: parseInt($("#size").val(), 10),
				radius: parseInt($("#radius").val(), 10) * 0.01,
				quiet: parseInt($("#quiet").val(), 10),

				mode: parseInt($("#mode").val(), 10),

				mSize: parseInt($("#msize").val(), 10) * 0.01,
				mPosX: parseInt($("#mposx").val(), 10) * 0.01,
				mPosY: parseInt($("#mposy").val(), 10) * 0.01,

				label: $("#label").val(),
				fontname: font_val,
				fontcolor: $('#fontcolor2').val(),

				image: $("#img-buffer")[0]
			};

			$("#container").empty().qrcode(options);
		},

		update = function () {

			updateGui();
			updateQrCode();
		},

		onImageInput = function () {

			//標籤事件
			$("#label").val('');
			$("#label").attr("disabled", true);
			$("#fontcolor").attr("disabled", true);
			$("#msize").attr("min", 5);
			$("#msize").attr("max", 20);

			var input = $("#image")[0];

			if (input.files && input.files[0])
			{
				var reader = new FileReader();

				reader.onload = function (event)
				{
					//驗證長度 3145728
					if(event.target.result.length > 3145728)
					{
						$('#img_warning').css("color", "red");
				     	$('#img_warning').css("font-size", "15px");
			    		$('#img_warning').html('圖檔過大，請使用3MB以下圖檔');
				     	$('#img_warning').fadeIn();

						$("#label").attr("disabled", true);
						$("#fontcolor").attr("disabled", true);
						$("#mode").val("0");
					}
					else
					{
						$('#img_warning').css("color", "black");
			    		$('#img_warning').html("");
				     	$('#img_warning').fadeIn();

						$("#img-buffer").attr("src", event.target.result);
						$("#img_src").val(event.target.result);
						if($("#mode").val() < 3)
							$("#mode").val("4");
					}
					setTimeout(update, 250);
				};
				reader.readAsDataURL(input.files[0]);
			}
		},

		download = function (event) {

			var data = $("#container canvas")[0].toDataURL('image/png');
			$("#download_png").attr("href", data);
			$('#download_png').get(0).click();
			myAjax();
		},

		value_check = function (id, v_min, v_max) {
			var result;
			if($("#"+id).val() < v_min)
				result=v_min;
			else if($("#"+id).val() > v_max)
				result=v_max;
			else
				result=$("#"+id).val();
			return result;
		},

		myAjax = function(){

			//值檢查
			//size
				$("#size").val(value_check('size',100, 450));
			//mode
				if($("#mode").val() < 0 || $("#mode").val() > 4)
					$("#mode").val(0);
			//minversion
				$("#minversion").val(value_check('mode',1, 10));
			//eclevel
				if($("#eclevel").val() != 'L' || $("#eclevel").val() != 'M' ||$("#eclevel").val() != 'Q' ||$("#eclevel").val() != 'H')
					$("#eclevel").val('H');
			//quiet
				$("#quiet").val(value_check('quiet',1, 4));
			//radius
				$("#radius").val(value_check('radius',0, 50));
			//msize
				$("#msize").val(value_check('msize',1, 20));
			//mposx
				$("#mposx").val(value_check('mposx',0, 100));
			//mposy
				$("#mposy").val(value_check('mposy',0, 100));

        	$.ajax(
	        { 
				type: "post", 
				url : $("#base_url").val()+'business/editer_iframe',
				cache: false,
				data:
				{
					form_submit: 1,
					btn_name: $('#btn_name').val(),
					id: $("#id").val(),
					edit_target: $("#edit_target").val(),
					mode: parseInt($("#mode").val(), 10),
					size: parseInt($("#size").val(), 10),
					fill: $('#fill2').val(),
					background: $('#background2').val(),
					minversion: parseInt($("#minversion").val(), 10),
					eclevel: $("#eclevel").val(),
					quiet: parseInt($("#quiet").val(), 10),
					radius: parseInt($("#radius").val(), 10),
					msize: $("#msize").val(),
					mposx: $("#mposx").val(),
					mposy: $("#mposy").val(),
					label: $("#label").val(),
					font: $("#font").val(),
					fontcolor: $('#fontcolor2').val(),
					image: $("#img_src").val()
				},
				async: false,
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
				},
				success: function(response)
				{
		            $('#info').fadeIn();
		            $('#info').html('儲存成功');
		            $('#info').css('color', 'red');
    				setTimeout("$('#info').fadeOut()", 1500);
				}
	        });
        };


	$(function () {

		$('#fill1').colpick({
          layout:'hex',
          colorScheme:'dark',
          onSubmit:function(hsb,hex,rgb,el) {
            $(el).css('background-color', '#'+hex);
            $(el).colpickHide();
            $(el).val('#'+hex);
            $('#fill2').val('#'+hex);
            update();
          }
        });

		$('#background1').colpick({
          layout:'hex',
          colorScheme:'dark',
          onSubmit:function(hsb,hex,rgb,el) {
            $(el).css('background-color', '#'+hex);
            $(el).colpickHide();
            $(el).val('#'+hex);
            $('#background2').val('#'+hex);
            update();
          }
        });

		$('#fontcolor1').colpick({
          layout:'hex',
          colorScheme:'dark',
          onSubmit:function(hsb,hex,rgb,el) {
            $(el).css('background-color', '#'+hex);
            $(el).colpickHide();
            $(el).val('#'+hex);
            $('#fontcolor2').val('#'+hex);
            update();
          }
        });

		if (isOpera) {
			$('html').addClass('opera');
			$('#radius').prop('disabled', true);
		}

        $('.colorPick').change(update);
		
		if(browser != 'IE')
		{
			//download and save
			$('#download_btn').confirmOn({
	            questionText: '下載並儲存',
	            textYes: '確定編輯完成',
	            textNo: '繼續編輯'
	        },'click', download);
		}
		else
		{
        	//download and save
			$('#download_btn').confirmOn({
	            questionText: '很抱歉，您使用的瀏覽器無法直接保存圖檔，並同時儲存樣式，請使用滑鼠在QRcode上點擊右鍵，選擇「另存圖片」來下載QRcode。',
	            textYes: '直接儲存樣式',
	            textNo: '取消'
	        },'click', myAjax);
		}

		//save
		$('#form_submit').confirmOn({
            questionText: '儲存此樣式',
            textYes: '確定儲存',
            textNo: '繼續編輯'
        },'click', myAjax);

		//cancle
        $('#back').on('click', function(){
        	window.top.location.href=$('#base_url').val()+'user/index';
        });

		//標籤-圖形內嵌標籤模式onchange
		$("#image").on('change', onImageInput);
		$("#image").on('click', function()
		{
			if($("#mode").val() < 3)
			{
				$("#img-buffer").attr("src", "");
				$("#mode").val("4");
			}
			$("#msize").attr("disabled", false);
			$("#mposx").attr("disabled", false);
			$("#mposy").attr("disabled", false);
			setTimeout(update, 250);
		});

		//標籤模式
		//onload
		if($("#mode_value").val() > 2)
		{
			$("#label").val('');
			$("#msize").attr("min", 5);
			$("#msize").attr("max", 20);
			$("#label").attr("disabled", true);
			$("#fontcolor").attr("disabled", true);
		}
		else if($("#mode_value").val() == 2)
		{
			$("#mode").val(2);
			$("#label").attr("disabled", false);
			$("#fontcolor").attr("disabled", false);
			$("#msize").attr("min", 1);
			$("#msize").attr("max", 10);
			if($('#label').val() != '')
				$("#label").val($('#label').val());
			$("#font").val($('#font').val());
		}
		else
		{
			$("#mode").val(0);
			$("#label").attr("disabled", true);
			$("#fontcolor").attr("disabled", true);
			$("#label").val('');
		}

		//onchange
		$("#mode").on('change', function()
		{
			if($("#mode").val() == 0)
			{
				$("#label").val('');
				$("#label").attr("disabled", true);
				$("#fontcolor").attr("disabled", true);
				$("#msize").attr("disabled", true);
				$("#mposx").attr("disabled", true);
				$("#mposy").attr("disabled", true);
			}
			else if($("#mode").val() == 1 || $("#mode").val() == 2)
			{
				$("#label").attr("disabled", false);
				$("#fontcolor").attr("disabled", false);
				if($('#label').val() != '')
					$("#label").val($('#label').val());
				$("#msize").attr("min", 1);
				$("#msize").attr("max", 10);
				$("#msize").attr("disabled", false);
				$("#mposx").attr("disabled", false);
				$("#mposy").attr("disabled", false);
			}
			else if($("#mode").val() == 3 || $("#mode").val() == 4)
			{
				$("#label").val('');
				$("#label").attr("disabled", true);
				$("#fontcolor").attr("disabled", true);
				$("#msize").attr("min", 5);
				$("#msize").attr("max", 20);
				$("#msize").attr("disabled", false);
				$("#mposx").attr("disabled", false);
				$("#mposy").attr("disabled", false);
				$('#image').get(0).click();
			}
			else
			{
				$("#label").attr("disabled", false);
				$("#fontcolor").attr("disabled", false);
				$("#msize").attr("disabled", false);
				$("#mposx").attr("disabled", false);
				$("#mposy").attr("disabled", false);
			}
		});

		$("input, textarea, select").on("input change", update);

		$(window).load(update);

		update();
	});

}(jQuery));

//chinese
function toUtf8(str) {    
    var out, i, len, c;    
    out = "";    
    len = str.length;    
    for(i = 0; i < len; i++) {    
        c = str.charCodeAt(i);    
        if ((c >= 0x0001) && (c <= 0x007F)) {    
            out += str.charAt(i);    
        } else if (c > 0x07FF) {    
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));    
            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));    
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));    
        } else {    
            out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));    
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));    
        }    
    }   
    return out;    
} 