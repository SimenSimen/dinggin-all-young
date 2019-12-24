$(function()
{
    $('.why').hover(function(){
        $('.prompt-box').show();
    }, function() {
        $('.prompt-box').hide();
    });

    // 開啟訂單狀態變更視窗
    $('.order_detail').click(function(){
        window.open('/cart/order_detail/'+$(this).attr('id').substr(3), '訂單狀態', config='height=750,width=800,left=400,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
});