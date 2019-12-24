//ckeditor
var this_ckeditor;
var ckeditor = document.getElementById('ckeditor');

function createEditor(languageCode) {
    if (ckeditor != null) {
        if (this_ckeditor) {
            this_ckeditor.destroy();
        }

        this_ckeditor = CKEDITOR.replace('ckeditor', {
            filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?Type=Images',
            width: 540,
            height: 320,
            resize_enabled: false,
            enterMode: 2,
            forcePasteAsPlainText: true,
            toolbar: [
                ['Source', '-'],
                ['Maximize', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'],
                ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                ['TextColor', 'BGColor', '-', 'NumberedList', 'BulletedList', ],
                '/', ['Outdent', 'Indent', 'Iineheight'],
                ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                ['Link', 'Unlink', 'Anchor'],
                ['Image', 'Flash', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'],
                ['Format', 'Font', 'FontSize']
            ]
        });
    }
}
createEditor('');
