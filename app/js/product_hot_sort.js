$(function() {

    $('.why').hover(function() {
        $('.prompt-box').show();
    }, function() {
        $('.prompt-box').hide();
    });

    $('#sortable').sortable({
        containment: "#sortable",
        scroll: true
    });
});
