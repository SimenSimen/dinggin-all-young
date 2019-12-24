<!--分享 彈出窗-->
<link rel="stylesheet" href="/template/temp10/css/baze.modal.css"> 
<div class="share" id="ngehe" data-target="#modal2">
    <a class="btn share" id="appsharehtmlid" href="javascript:void(0)"><i class="icon-share2"></i></a>
</div>
<div class="bzm-content" id="modal2" data-title="分享到">
    <ul class="share-box" style="margin:0 0 70px;">
        <li><a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));"><i><img src="/template/temp10/images/icon-fb.png" align="center" ></i>facebook</a></li>
        <li><a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()"><i><img src="/template/temp10/images/icon-weibo.jpg" align="center" ></i>Weibo</a></li>
        
        <?php if($plurk_m_btn): ?>
            <li><a href="javascript: void(window.open('https://www.plurk.com/m?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"><i><img src="/template/temp10/images/icon-plurk.png" align="center" ></i>Plurk</a></li>
        <?php else: ?>
            <li><a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"><i><img src="/template/temp10/images/icon-plurk.png" align="center" ></i>Plurk</a></li>
        <?php endif; ?>
        
        <li><a href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));"><i><img src="/template/temp10/images/icon-twitter.png" align="center" ></i>Twitter</a></li>
        <li><a href="javascript: void(window.open('https://line.naver.jp/R/msg/text/?'+encodeURIComponent(document.title)+' - '+encodeURIComponent(location.href) ));"><i><img src="/template/temp10/images/icon-line.png" align="center"></i>Line</a></li>
        <li><a href="javascript: void(window.open('whatsapp://send?text='+encodeURIComponent(document.title)+' - '+encodeURIComponent(location.href) ));"><i><img src="/template/temp10/images/icon-wechat.png" align="center"></i>WhatsApp</a></li>
        <li><a href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br>'+encodeURIComponent(location.href) ));"><i><img src="/template/temp10/images/icon-mail.png" align="center"></i>E-mail</a></li>
    </ul>
</div>
<script>
$('#ngehe>a').css('padding','2px');
var windowcallapp=null;

$('#appsharehtmlid').click(function(){
    getShareEncode2('<?=$Share["public_share_buttom_url"]?>');
});
$(function()
{
<?          
if ($Share['isshareurl']){ //分享來的URL

    if ($Share['get_device_type']>0){ //手機
        
         if (!$this->session->userdata('isapp')){//網頁
            echo 'docallapp();';//自動呼叫APP
         }
    }
}
?>      

});
function getShareEncode2(val){
    var i_val = "jecp://"+val.substr(12);
    // alert(i_val);
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
        location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
        NetNewsAndroidShare.receiveValueFromJs(val);
    }else{
        var elems = $('[data-baze-modal]');
        elems.bazeModal({
            onOpen: function () {
              alert('opened');
            },
            onClose: function () {
              alert('closed');
            }
        });
        $('#ngehe').bazeModal();
    }
}
function dogatherbox(worktype){
    dosavegatherbox(worktype);
}
function dosavegatherbox(worktype){
    $.ajax({
        type: 'POST',  
        async: false,
        url: "/views/AddCollection",  
        data: { title: "<?=$Share['public_share_title']?>", url: document.URL,account:<?=$Share['Saccount']?>},  
        success: function (response) {  
            alert(response.re_message);
            if (response.re_code==0){
                location.href = "/gold/login";
            }
        },  
        dataType: "json"
    }); 
}
function dodownloadapp(){
    location.href = "<?=$Share['public_barcodeurl']?>";
}
function closedocallapp(){
    windowcallapp.close( );
}
function docallapp(){
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
        document.location = "<?=$Share['callappurl']?>";
    } else if (/(Android)/i.test(navigator.userAgent)) {
        testApp("<?=$Share['callappurl']?>");
// alert("<?=$Share['callappurl']?>");  
    }else{}
}
function testApp(url) {  
    var timeout, t = 1000, hasApp = true;  
    setTimeout(function () {  
        if (hasApp) {  
            //會直接呼叫APP
        } else {  
        //  alert('未安装app');  
        }  
        document.body.removeChild(ifr);  
    }, t+1000)  
  
    var t1 = Date.now();  
    var ifr = document.createElement("iframe");  
    ifr.setAttribute('src', url);  
    ifr.setAttribute('style', 'display:none');  
    document.body.appendChild(ifr);
    timeout = setTimeout(function () {  
         var t2 = Date.now();  
         if (!t1 || t2 - t1 < t + 100) {  
             hasApp = false;  
         }  
    }, t);  
}  
</script>
