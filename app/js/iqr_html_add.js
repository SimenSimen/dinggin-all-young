//ckeditor
var iqr_html_content_ck;
var iqr_html_content = document.getElementById('iqr_html_content');

function createEditor(languageCode) {
  if (iqr_html_content != null) {
    if (iqr_html_content_ck) {
      iqr_html_content_ck.destroy();
    }

    iqr_html_content_ck = CKEDITOR.replace('iqr_html_content', {
      filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?Type=Images',
      width: 900,
      height: 600,
      resize_enabled: true,
      enterMode: 2,
      forcePasteAsPlainText: true,
      toolbar: [
        ['Source', '-', 'Undo', 'Redo'],
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Table', 'HorizontalRule', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'Replace', 'RemoveFormat', 'Templates'],
        ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor', 'BGColor', '-', 'Font', 'FontSize', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Image', 'Maximize']
      ]
    });
  }
}
createEditor('');

//離開頁面確認
window.onbeforeunload = function() {　　
  return "您即將離開本頁面，網頁將不會被新增";
}

$(function() {

  //取消按鈕
  $('#cancel').click(function() {
    if (confirm('您確定要取消新增嗎?')) {
      window.onbeforeunload = null;
      window.close();
      return true;
    }
  });

  //新增完成
  if ($('#success').val() == 1) {
    // $('#iqr_html_empty', opener.document).remove();

    alert('新增成功');
    // $('#iqr_html_tbody', opener.document).append("" +
    //   " <tr>" +
    //   " <td style='text-align:center; width: 15%;'>New</td>" +
    //   " <td>" + $('#classify_name').val() + "</td>" +
    //   " <td>" + $('#html_name').val() + "</td>" +
    //   " <td style='text-align:center; width: 30%;'>" +
    //   " <span style='font-size:10px; color:#bbbbbb;'>操作功能請重新整理</span>" +
    //   " </td>" +
    //   " </tr>" +
    //   "");
    window.onbeforeunload = null;
    window.opener.parent.location.reload();
    window.close();
  }

  //驗證必填欄位
  $('#form_iqr_html_add').validate({
    success: function(label) {
      label.addClass("success").text("");
    }
  });

  // 驗證表單
  $('#form_iqr_html_add').submit(function(event) {
    if (CKEDITOR.instances.iqr_html_content.getData().length == 0) {
      $('#iqr_html_prompt').html('網頁內容不可空白');
      event.preventDefault();
    }
  });
});