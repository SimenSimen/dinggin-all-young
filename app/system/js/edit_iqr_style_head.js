function pop_theme_preview(url, name)
{
   window.open(url, name, config='height=640,width=300,left=550,scrollbar=yes,resizable=no');
}


$(function()//onload
{
  //browser
  var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
  (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
  (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
  '非 Firefox/Chrom/IE 瀏覽器';

  if(browser == 'Firefox' || browser == 'IE')
  {
    //背景顏色選擇器
    $('#background_color1').show();
    $('#background_color2').hide();
	
    //文字顏色選擇器
    $('#fonts_color1').show();
    $('#fonts_color2').hide();

    $('#fonts_colorUSER1').show();
    $('#fonts_colorUSER2').hide();
    $('#fonts_colorUSER11').show();
    $('#fonts_colorUSER12').hide();
    $('#fonts_colorUSER21').show();
    $('#fonts_colorUSER22').hide();
    $('#fonts_colorUSER31').show();
    $('#fonts_colorUSER32').hide();
	
    $('#set_header1').show();
    $('#set_header2').hide();
    $('#set_03list1').show();
    $('#set_03list2').hide();

	
	
  }
  else
  {
    //背景顏色選擇器
    $('#background_color2').show();
    $('#background_color1').hide();
    //文字顏色選擇器
    $('#fonts_color2').show();
    $('#fonts_color1').hide();
    $('#fonts_colorUSER2').show();
    $('#fonts_colorUSER1').hide();
    $('#fonts_colorUSER12').show();
    $('#fonts_colorUSER11').hide();
    $('#fonts_colorUSER22').show();
    $('#fonts_colorUSER21').hide();
    $('#fonts_colorUSER32').show();
    $('#fonts_colorUSER31').hide();

    $('#set_header2').show();
    $('#set_header1').hide();
    $('#set_03list2').show();
    $('#set_03list1').hide();

    $('#fonts_color_22').show();
    $('#fonts_color_21').hide();
    $('#fonts_color_32').show();
    $('#fonts_color_31').hide();
    $('#fonts_color_42').show();
    $('#fonts_color_41').hide();
    $('#fonts_color_52').show();
    $('#fonts_color_51').hide();
  }

  //背景顏色選擇器
  $('#background_color1').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#background_color2').val('#'+hex);
    }
  });
  
  //文字顏色選擇器
  $('#fonts_color1').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_color2').val('#'+hex);
    }
  });
  
  $('#fonts_colorUSER1').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_colorUSER2').val('#'+hex);
    }
  });
  $('#fonts_colorUSER11').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_colorUSER12').val('#'+hex);
    }
  });
  $('#fonts_colorUSER21').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_colorUSER22').val('#'+hex);
    }
  });
  $('#fonts_colorUSER31').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_colorUSER32').val('#'+hex);
    }
  });
  

  $('#set_03list1').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#set_03list2').val('#'+hex);
    }
  });
  $('#set_header1').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#set_header2').val('#'+hex);
    }
  });


  $('#fonts_color_21').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
    console.log(hex);
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_color_22').val('#'+hex);
    }
  });

  $('#fonts_color_31').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_color_32').val('#'+hex);
    }
  });

  $('#fonts_color_41').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
    	alert(hex);
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_color_42').val('#'+hex);
    }
  });

  $('#fonts_color_51').colpick({
    layout:'hex',
    colorScheme:'dark',
    onSubmit:function(hsb,hex,rgb,el) {
      $(el).css('background-color', '#'+hex);
      $(el).colpickHide();
      $(el).val('#'+hex);
      $('#fonts_color_52').val('#'+hex);
    }
  });

  
});