$(function() {
    //取消按鈕關閉視窗
    $('#cancel').click(function() {
        if (confirm('您確定要取消當前動作嗎?')) {
            window.location.href = document.getElementById('back').value
        }
    });

    //validate
    $('#form_ckeditor').validate({
        success: function(label) {
            label.addClass("success").text("");
        }
    });

    $('input[name="form_submit"]').click(function() {
        $(this).attr('action', '/corporate/ckeditor_add/' + $('#type').val());
        $(this).submit();
    });

    $('.category').click(function() {
        $('input[name=add_category]').val($(this).text());
    });

    $('.category').mousedown(function(e) {
        if (e.which == 3) {
            if (confirm('您確定要刪除 ' + $(this).text())) {
                $.post('/corporate/group_del', { del_id: $(this).attr('id') }, function(response) {
                    alert(response.re_msg);
                    if (response.re_code == '001') {
                        window.location.reload();
                    }
                }, 'json');
            }
        }
    });
});
