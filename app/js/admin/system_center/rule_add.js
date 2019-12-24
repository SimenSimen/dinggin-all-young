$(function() {
    $('input[name="form_submit"]').click(function() {
        $(this).attr('action', '/rule/editor/' + $('#type').val());
        $(this).submit();
    });
});
