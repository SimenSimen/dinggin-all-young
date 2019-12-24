$(document).ready(function() {
    //手機板選單功能，數字為手機板選單要出現的寬度
    mobileMenuInit(980);

    //上方主選單.menu的功能
    menuInit();

    //啟動選單上購物車下拉列表
    gocartBtnInit();

    //按鈕切換class功能
    toggleBtnInit();

    //側選單開合
    sideNavInit();

    //語系下拉 ( *** 沒有下拉請註解這行 *** )
    //languageMenuInit('.site-header .language');

    //TOP按鈕的功能
    gotopBtnInit();

    //單選/多選按鈕點了會加上ckecked的class功能
    labelCkeckedInit();

    //驗證碼換圖
    imgcodeInit();
    
    $('#radio-2').click(function(){
        $('.select-id').prop('disabled',false);
    });
    
    $('#radio-1').click(function(){
       $('.select-id').prop('disabled',true);
    });
    
    $('#radio-4').click(function(){
        $('.amount-type').prop('disabled',false);
    });
    
    $('#radio-3').click(function(){
       $('.amount-type').prop('disabled',true);
    });
    
    
    $(window).scroll(function(){
        
        if($(window).scrollTop() >= 50){
            $('body').css({'margin-top':'70px'});
            $('.mmenu-show #mobile-fixed').css({'position':'fixed'});
            $("header").addClass("fixed");
            $("#mobile-fixed .toggleBtn").addClass("fixed");
            setTimeout(function() {
               $('.site-header.fixed').addClass('slideDown');
               $("#mobile-fixed .toggleBtn").addClass("slideDown2");
            }, 400);
        }
        else{
            $('body').css({'margin-top':'0px'});
            $('.mmenu-show #mobile-fixed').css({'position':'absolute'});
            $('.site-header.fixed').removeClass('slideDown');
            $("header").removeClass("fixed");
            $("#mobile-fixed .toggleBtn").removeClass("slideDown2");
            $("#mobile-fixed .toggleBtn").removeClass("fixed");
        }
    });	
});

$(window).on('load', function() { // makes sure the whole site is loaded 
    $('#status').fadeOut(); // will first fade out the loading animation 
    $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.

}); 
