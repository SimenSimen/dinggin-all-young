$(function()
{
    $('.limit-pic').each(function()
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
        alert('圖檔尺寸不符，請使用'+w+' x '+h+'圖片');
        file_element.val('');
    }
    else
    {
        eval('var type = /(.png|.PNG|.jpg|.jpeg|.JPG|.JPEG)$/i');
        var file_type = file_element.val().substr(-4);
        if(!type.test(file_type))
        {
            alert('圖檔格式不符，請使用 .png/.jpg/.jpeg 格式檔案');
            file_element.val('');
        }
    }
}