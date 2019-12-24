
(function ($) {
	'use strict';

	var isOpera = Object.prototype.toString.call(window.opera) === '[object Opera]',

		guiValuePairs = [
			["size", "px"],
			["minversion", ""],
			["quiet", " modules"],
			["radius", "%"],
			["msize", "%"],
			["mposx", "%"],
			["mposy", "%"]
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
			content = $("#base_url").val()+'form/index/'+$("#ufm_id").val()+'/'+$("#mid").val();
			if($("#v").val())
				content = content + '/' + $("#v").val();

			var options = {
				render: $("#render").val(),
				ecLevel: $("#eclevel").val(),
				minVersion: parseInt($("#minversion").val(), 10),

				fill: $("#fill").val(),
				background: $("#background").val(),

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
				fontcolor: $("#fontcolor").val(),

				image: $("#img-buffer")[0]
			};

			$("#container").empty().qrcode(options);
		},

		update = function () {

			updateGui();
			updateQrCode();
		},

		onImageInput = function () {

			var input = $("#image")[0];

			if (input.files && input.files[0]) {

				var reader = new FileReader();

				reader.onload = function (event) {
					$("#img-buffer").attr("src", event.target.result);
					$("#mode").val("4");
					setTimeout(update, 250);
				};
				reader.readAsDataURL(input.files[0]);
			}
			update();
		},

		download = function (event) {
			var data = $("#container canvas")[0].toDataURL('image/png');
			$("#download").attr("href", data);
		};

	$(function () {
		if (isOpera) {
			$('html').addClass('opera');
			$('#radius').prop('disabled', true);
		}
		$("#download").on("click", download);
		$("#image").on('change', onImageInput);
		//$("input, textarea, select").on("input change", update);
		
		$(window).load(update, function()
		{
			$("#scale_canvas").hide();
			if($("#size").val() > "400px" && $("#canvas_scale_type").val() == 'redirecter')
			{
				$("canvas").css("width", "400px");
				$("#scale_canvas").show();
			}
			
			if($("#mode").val() == 0)
			{
				$("#label").val('');
				$("#label").attr("disabled", true);
			}
			else
			{
				$("#label").attr("disabled", false);
				if($("#label").val()==0)
				{
					$("#label").val('');
				}
			}
			$("#mode").on("change", function(){
				if($("#mode").val() == 0)
				{
					$("#label").val('');
					$("#label").attr("disabled", true);
				}
				else
				{
					$("#label").attr("disabled", false);
					if($("#label").val()==0)
					{
						$("#label").val('');
					}
				}
			});
		});
		update();
		var temp = $("#container canvas")[0].toDataURL('image/png');
		$("#img-buffer").attr('src', temp);
	});

}(jQuery));

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
