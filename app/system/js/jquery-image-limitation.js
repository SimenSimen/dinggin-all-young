// 圖片上傳限制尺寸與檔案類型
// 在HTML中要準備兩個元件: <input type='file' ...> and <img src='...>

// Example :
//
// 1.
// <input type="file" class='limited_img' name="image_file" id="image_file" data-image_file-width="640" data-image_file-height="1250" data-image_file-display="image_file_display">
// 
// a. the class name is set to 'limited_img' or some else you want.
// b. based on id of element, data-id-width, data-id-height, and data-id-display are needed parameters for image limiting.
//                                 ^              ^                   ^
//    the ids should be replace to id of element, in this case that is "image_file".
//    so you should set the <input> attributes are data-image_file-width='xxx' ...
//
// 2.
// <img id='id_display' class='hidden_image'>
//                   ^ put the data-id-display value here
//                   ^
// data-id-display ='id_display', in this case is 'image_file_display'.

// 手機畫面擷圖
$(function()
  {
        $('.limited_img').each(function()
        {
            $(this).change(function()
            {
                var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
                var max_width    = $("[data-" + $(this).attr('id') + "-maxwidth]").data($(this).attr('id') + "-maxwidth");
                var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
                var max_height   = $("[data-" + $(this).attr('id') + "-maxheight]").data($(this).attr('id') + "-maxheight");
                var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display"); // 將預上傳的圖寫入img，以取得長寬

                getImgSize_mobile(this, $(this).attr('id'), $("#"+data_display), data_width, data_height, max_width, max_height);
            });
        });
  });

  getImgSize_mobile = function (input, name, image_element, w, h, max_w, max_h) 
  {
      if (input.files && input.files[0]) 
      {
        var reader = new FileReader();
        reader.onload = function (e) 
        {
            image_element.attr('src', e.target.result);
            load_result_mobile($('input[name='+name+']'), image_element, w, h, max_w, max_h);
        }
        reader.readAsDataURL(input.files[0]);
      }
  }

  load_result_mobile = function (file_element, image_element, w, h, max_w, max_h)
  {
        // alert(image_element.width()+'*'+image_element.height());
        if(image_element.width() < w || image_element.height() < h || image_element.width() > max_w || image_element.height() > max_h)
        {
            alert('圖檔尺寸不符，請使用邊長上限'+w+' x '+h+'，邊長下限'+max_w+ ' x '+max_h+'的檔案');
            file_element.val('');
        }
        else
        {
            eval('var type = /(.png|.PNG|.JPEG|.jpeg|.jpg|.JPG)$/i');
            var file_type = file_element.val().substr(-4);
            if(!type.test(file_type))
            {
                alert('圖檔格式不符，請使用 .png/.jpg/.jpeg 格式檔案');
                file_element.val('');
            }
        }
  }

// APP logo & Title banner
$(function()
{
    $('.quantity_img').each(function()
    {
        $(this).change(function()
        {
            var data_width   = $("[data-" + $(this).attr('id') + "-width]").data($(this).attr('id') + "-width");
            var data_height  = $("[data-" + $(this).attr('id') + "-height]").data($(this).attr('id') + "-height");
            var data_display = $("[data-" + $(this).attr('id') + "-display]").data($(this).attr('id') + "-display"); // 將預上傳的圖寫入img，以取得長寬
      
            getImgSize(this, $(this).attr('id'), $("#"+data_display), data_width, data_height);
        });
    });

});

getImgSize = function (input, name, image_element, w, h) 
{
    if (input.files && input.files[0]) 
    {
        var reader = new FileReader();
        reader.onload = function (e) 
        {
            image_element.attr('src', e.target.result);
            load_result($('input[name='+name+']'), image_element, w, h);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

load_result = function (file_element, image_element, w, h)
{
    // alert(image_element.width()+'*'+image_element.height());
    if(image_element.width() != w || image_element.height() != h)
    {
        alert('圖檔尺寸不符，請使用'+w+' x '+h+'檔案');
        file_element.val('');
    }
    else
    {
        eval('var type = /(.png|.PNG|.jpg|.JPG)$/i');
        var file_type = file_element.val().substr(-4);
        if(!type.test(file_type))
        {
            alert('圖檔格式不符，請使用 .png/.jpg 格式檔案');
            file_element.val('');
        }
    }
}