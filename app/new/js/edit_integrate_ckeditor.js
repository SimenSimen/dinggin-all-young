//ckeditor
var introduce_ckeditor;
var introduce = document.getElementById('introduce');

var text_edit01, text_edit02, text_edit03;
var edit01    = document.getElementById('text_edit01');
var edit02    = document.getElementById('text_edit02');
var edit03    = document.getElementById('text_edit03');

function createEditor( languageCode )
{
  if(introduce != null)
  {
    if ( introduce_ckeditor )
    {
      introduce_ckeditor.destroy();
    }

    introduce_ckeditor = CKEDITOR.replace( 'introduce', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 460,
      height: 150,
      resize_enabled:false,
      enterMode: 2,
      forcePasteAsPlainText :true,
      toolbar :
          [['Undo','Redo', 'Bold','Italic','Underline', 'TextColor', 'BGColor', 'Font','FontSize', 'JustifyLeft','JustifyCenter','JustifyRight']]
    });
  }

  if(edit01 != null)
  {
    if ( text_edit01 )
    text_edit01.destroy();

    text_edit01 = CKEDITOR.replace( 'text_edit01', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 500,
      height: 270,
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

  if(edit02 != null)
  {
    if ( text_edit02 )
    text_edit02.destroy();

    text_edit02 = CKEDITOR.replace( 'text_edit02', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 500,
      height: 270,
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

  if(edit03 != null)
  {
    if ( text_edit03 )
    text_edit03.destroy();

    text_edit03 = CKEDITOR.replace( 'text_edit03', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 500,
      height: 270,
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