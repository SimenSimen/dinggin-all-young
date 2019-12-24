window.onload = function ()
{
  var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
  (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
  (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
  '非 Firefox/Chrom/IE 瀏覽器';

  if(browser == 'IE')
  {
    var iebrowser = (/MSIE 10/i.test(navigator.userAgent)) ? 'IE 10' :
    (/MSIE 9/i.test(navigator.userAgent)) ? '提醒您，您的IE 版本過舊，建議您使用IE 10以上版本' :
    (/MSIE 8/i.test(navigator.userAgent)) ? '提醒您，您的IE 版本過舊，建議您使用IE 10以上版本' :
    (/MSIE 7/i.test(navigator.userAgent)) ? '提醒您，您的IE 版本過舊，建議您使用IE 10以上版本' :
    (/MSIE 6/i.test(navigator.userAgent)) ? '提醒您，您的IE 版本過舊，建議您使用IE 10以上版本' :
    '提醒您，您的IE 版本過舊，建議您使用IE 10以上版本';

    if(iebrowser != 'IE 10')
    {
      alert('您的瀏覽器版本過舊，建議您使用 [IE 10.0] 以上版本');
    }
  }
}