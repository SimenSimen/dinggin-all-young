function mode_event() {
  var share_mode = $("input[name=share_mode]:checked").val();
  if(share_mode == 1)
  {
    $("#share_mode_2").css({'display':'none'});
    $("#share_mode_3").css({'display':'none'});
    $("input[name=share_url]").removeClass('required');
    $("#share_txt").removeClass('required');

  }
  else if(share_mode == 2)
  {
    $("#share_mode_2").css({'display':''});
    $("#share_mode_3").css({'display':'none'});
    $("input[name=share_url]").addClass('required');
    $("#share_txt").removeClass('required');
  }
  else
  {
    $("#share_mode_2").css({'display':'none'});
    $("#share_mode_3").css({'display':''});
    $("input[name=share_url]").removeClass('required');
    $("#share_txt").addClass('required');
  }
}

window.onload = mode_event;

$("input[name=share_mode]:radio").change(function(){
  mode_event();
});

function chk_val() {
  var share_mode = $("input[name=share_mode]:checked").val();
  if(share_mode == 2)
  {
    var input = $('input[name=share_url]');
    if(input.val().match('http://') || input.val().match('https://'))
      return true;
    else
    {
      alert('網址請包含 http:// 或 https://');
      input.focus();
      return false;
    }
  }
}

//ckeditor
var share_txt_ckeditor;
var share_txt = document.getElementById('share_txt');

function createEditor( languageCode )
{
  if(share_txt != null)
  {
    if ( share_txt_ckeditor )
    {
      share_txt_ckeditor.destroy();
    }

    share_txt_ckeditor = CKEDITOR.replace( 'share_txt', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 510,
      height: 200,
      resize_enabled:false,
      enterMode: 2,
      forcePasteAsPlainText :true,
      toolbar :
      [
        ['Source', '-', 'Undo','Redo'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord', 'Table', 'HorizontalRule', 'NumberedList','BulletedList', '-', 'Link','Unlink', 'Replace', 'RemoveFormat', 'Templates'],
        ['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'Image','Iframe']
      ]
    });
  }
}
createEditor( '' );