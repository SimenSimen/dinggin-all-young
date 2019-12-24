//ckeditor
// var prd_content_ck;
// var prd_content = document.getElementById('prd_content');
// function createEditor( languageCode )
// {
//   if(prd_content != null)
//   {
//     if ( prd_content_ck )
//     {
//       prd_content_ck.destroy();
//     }

//     prd_content_ck = CKEDITOR.replace( 'prd_content', {
//       filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
//       width : 410,
//       height: 250,
//       resize_enabled:false,
//       enterMode: 2,
//       forcePasteAsPlainText :true,
//       toolbar :
//       [
//         ['Source', '-', 'Undo','Redo'],
//         ['Cut','Copy' , 'Table', 'NumberedList','BulletedList'],
//         ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
//         ['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize', '-', 'Image']
//       ]
//     });
//   }   
// }
// createEditor( '' );

//離開頁面確認
window.onbeforeunload = function()
{ 
　　return "您即將離開本頁面，商品將不會被儲存"; 
}

$(function()
{
  //取消按鈕
  $('#cancel').click(function(){
    if(confirm('您確定要取消編輯嗎?'))
    {
      window.onbeforeunload=null;
      window.close();
      return true;
    }
  });

  //新增完成
  if($('#success').val() == 1)
  {
    alert('編輯成功');
    // opener.window.parent.location.reload(); 
    opener.window.parent.top.frames["content-frame"].location.reload();
    window.onbeforeunload=null;
    window.close();
  }

  //驗證必填欄位
  $('#form_ecoupon_edit').validate({
      success: function(label) {
          label.addClass("success").text("");
      }
  });

  $("#coupon").change(function()
  {
    var iSize = ($("#coupon")[0].files[0].size / 1024); 
    if (iSize / 1024 > 1) 
    { 
      if (((iSize / 1024) / 1024) > 1) 
      { 
        iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
        iSIzeType = "Gb";
      }
      else
      { 
        iSize = (Math.round((iSize / 1024) * 100) / 100);
        iSIzeType = "Mb";
      } 
    } 
    else 
    {
      iSize = (Math.round(iSize * 100) / 100);
      iSIzeType = "kb";
    } 
    if(iSIzeType == 'kb' || (iSIzeType == 'Mb' && iSize <= 3))
    {
      var type = /(.png|.PNG|.jpg|.JPG|.jpeg|.JPEG|.gif|.GIF)$/i;
      if(type.test($("#coupon").val()))
      {
        readURL(this);
        $('#blah').css('max-width', '175px');
      }
      else
      {
        alert('僅允許*.png, *.jpg, *.gif類型圖檔上傳');
        $('#blah').css('display', 'none');
        $('#coupon').val('');
        $('#coupon').get(0).click();
      }
    }
    else
    {
      alert('您使用的圖檔過大，請使用3MB以下圖檔');
      $('#blah').css('display', 'none');
      $('#prd_image').val('');
      $('#prd_image').get(0).click();
    }
  });
});

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function (e) {
          $('#blah').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
  }
  $('#blah').css('display', '');
}
