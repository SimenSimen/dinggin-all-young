$(function() {
    var msg = "初始日期不可大於截止日期";
    $('input[name="export_btn"]').click(function() {
        if ($('input[name="start_date"]').val() > $('input[name="end_date"]').val()) {
            alert(msg);
            $("input[name='start_date']").focus();
            return false;
        } else
            return true;
    });

    $('#exprot_order').click(function() {
        var $_export = $('#export_url').val();
        $('#form_export_order').attr('action', $_export);
        $('#form_export_order').submit();
    });

    $('#exprot_All_order').click(function() {
        var $_export = $('#export_url').val();
        $('#form_export_order').attr('action', $_export);
        $('#form_export_order').submit();
        $('#form_export_order').attr('action', '');
    });
});
