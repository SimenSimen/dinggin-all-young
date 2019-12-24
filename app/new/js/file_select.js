$(function(){

  var SITE = SITE || {};

  SITE.fileInputs = function() {
    var $this = $(this),
        $val = $this.val(),
        valArray = $val.split('\\'),
        newVal = valArray[valArray.length-1],
        $button = $this.siblings('.button'),
        $fakeFile = $this.siblings('.file-holder');
    if(newVal != '') {
      $button.text('已選檔案');
      if($fakeFile.length == 0) {
        if(newVal.length > 20)
          $button.after('<span class="file-holder">' + newVal.substr(0, 5) + '...' + newVal.substr(newVal.length-5, 5) + '</span>');
        else
          $button.after('<span class="file-holder">' + newVal + '</span>');
      } else {
        if(newVal.length > 20)
          $fakeFile.text(newVal.substr(0, 5) + '...' + newVal.substr(newVal.length-5, 5));
        else
          $fakeFile.text(newVal);
      }
    }
  };
  $('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);

  image_check = function (element, input_file, ori_ifname, limit_s, limit_st, ext_0, ext_1, input, name, image_element, w, h)
  {
    // element    : input image 物件本身
    // input_file : input file element
    // ori_ifname : input file element name
    // limit_s    : 限制檔案大小
    // limit_st   : 限制檔案大小單位
    // ext_0      : 限制附檔名小寫
    // ext_1      : 限制附檔名大寫
    
    var img = element[0].files[0];
    var img_size = img.size;
    var i_size = (img_size / 1024);
    var file_element = $('input[name='+name+']');
    var error = false;
    i_size = (Math.round(i_size * 100) / 100);

    if (input.files && input.files[0]) 
    {
      var reader = new FileReader();
      reader.onload = function (e) 
      {
          image_element.attr('src', e.target.result);

          if(image_element.width() != w || image_element.height() != h)
          {
              alert('圖檔尺寸不符，請使用邊長'+w+' x '+h);
              error = true;
              element.val('');
              input_file.text(ori_ifname);
              element.siblings('.file-holder').text('');
          }
          else
          {
              eval('var type = /(.png|.PNG)$/i');
              var file_type = file_element.val().substr(-4);
              if(!type.test(file_type))
              {
                  alert('圖檔格式不符，請使用 .png 格式檔案');
                  error = true;
                  element.val('');
                  input_file.text(ori_ifname);
                  element.siblings('.file-holder').text('');
              }
          }

      }
      reader.readAsDataURL(input.files[0]);
    }

    // 驗證限制條件
    
    if(i_size >= limit_s)
    {
      alert('您使用的圖檔過大，請使用 '+(limit_s / 1024)+' MB 以下圖檔');
      error = true;
    }
    if(error)
    {
      element.val('');
      input_file.text(ori_ifname);
      element.siblings('.file-holder').text('');
    }
  }

  //icon
  $('#icon').change(function(){
    var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
    var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
    var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display"); // 將預上傳的圖寫入img，以取得長寬
    image_check($('#icon'), $('#file_chosen'), '選擇 512 x 512 png 圖片', 1024, 'kb', 'png', 'PNG', this, $(this).attr('id'), $("#"+data_display), data_width, data_height);
  });
  //a_wp
  $('#a_wp').change(function(){
    var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
    var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
    var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display");
    image_check($('#a_wp'), $('#a_wp_chosen'), '選擇 480 x 760 png 圖片', 2048, 'kb', 'png', 'PNG', this, $(this).attr('id'), $("#"+data_display), data_width, data_height);
  });
  //i_wp_0
  $('#i_wp_0').change(function(){
    var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
    var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
    var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display");
    image_check($('#i_wp_0'), $('#i_wp_0_chosen'), '選擇 640 x 960 png 圖片', 2048, 'kb', 'png', 'PNG', this, $(this).attr('id'), $("#"+data_display), data_width, data_height);
  });
  //i_wp_1
  $('#i_wp_1').change(function(){
    var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
    var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
    var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display");
    image_check($('#i_wp_1'), $('#i_wp_1_chosen'), '選擇 640 x 1136 png 圖片', 2048, 'kb', 'png', 'PNG', this, $(this).attr('id'), $("#"+data_display), data_width, data_height);
  });
});
