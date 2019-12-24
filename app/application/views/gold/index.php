<link rel="stylesheet" href="/css/test.css">
<script src="/js/modernizr.js"></script>
<script src="/js/main.js"></script>
<body class="bg-style">
<header class="header">
    <?=$this->lang['about'];//關於eoneda?>
    <!-- <select style="float: right;" id="setlang" >
        <option value="TW" <?=($lang=='TW')?'selected':'';?>>中文繁體</option>
        <option value="ENG" <?=($lang=='ENG')?'selected':'';?>>English</option>
        <option value="JAP" <?=($lang=='JAP')?'selected':'';?>>日本の</option>
    </select> -->
</header>
    <div class="cd-dropdown-wrapper">
        <a class="cd-dropdown-trigger" href="#0"><?=$NowLang?></a>
        <nav class="cd-dropdown"><!-- <h2>篩選順序</h2> -->
          <a href="#0" class="cd-close">Close</a>
        <ul class="cd-dropdown-content">
                <? foreach ($lang_list as $key => $value):?>
                   <li class="selectsortid" ref="<?=$value['d_code']?>"><a href="javascript: void(0)"><?=$value['d_title']?></a></li>
                <? endforeach;?>          
            </ul> <!-- .cd-dropdown-content -->
        </nav> <!-- .cd-dropdown -->
    </div>

<div class="wrapper">
   <section class="about-i-nav">
<!--         <a class="i-button" id="icon-i-ebh" target="_blank" href="https://www.ebhinfo.com"><b>EBH</b><?=$this->lang['ebhnet'];//健康網?></a> -->
        <a class="i-button" id="icon-i-cart" href="/cart/store/1"><?=$this->lang['store'];//線上商城?></a>
        <a class="i-button" id="icon-i-member" href="/gold/login"><?=($_SESSION['MT']['name']!='')?$_SESSION['MT']['name']:$this->lang['member'];//會員中心?></a>
        <a class="i-button" id="icon-i-enroll" <?=$udata?> href="/views/items/<?=$aid?>/C/enroll"><?=$this->lang['activity'];//活動與報名?></a>
        <a class="i-button" id="icon-i-share" <?=$fdata?> href="/views/items/<?=$aid?>/C/share"><?=$this->lang['share'];//好友分享券?></a>        
        <?/*?><a class="i-button" id="icon-i-ask"  href="/gold/talkapp"><?=$this->lang['sevice'];//客服中心?></a><?/*/?>
        <a class="i-button" id="icon-i-contact" href="/gold/contact"><?=$this->lang['customer'];//顧客中心?></a>
        <a class="i-button" id="icon-i-article" href="/views/items/<?=$aid?>/C"><?=$this->lang['massage'];//訊息中心?></a>
        <a class="i-button" id="icon-i-vedio" <?=$mdata?> href="/views/items/<?=$aid?>/C/video"><?=$this->lang['movie'];//影音專區?></a> <!-- <?=$mdata?> -->
        <a class="i-button" id="icon-i-photo" <?=$adata?> href="/views/items/<?=$aid?>/C/photo"><?=$this->lang['album'];//公司相簿?></a>
        <a class="i-button" id="icon-i-annex" <?=$rdata?> href="/views/items/<?=$aid?>/C/annex"><?=$this->lang['download'];//文件下載?></a>       
        <a class="i-button" id="icon-i-link" <?=$ldata?> href="/views/items/<?=$aid?>/C/link"><?=$this->lang['link'];//友善連結?></a>
  </section> 
</div><!--/wrapper-->
<form action="/gold/setlang" method="post" id="searchmainform">
    <input type="hidden" name="lang" value="TW">
</form>
<script>
$('.selectsortid').click(function(){
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $(this).attr('ref')
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
function userappcall(val){
    <?  if (!$this->session->userdata('isapp')){?>
        location.href = "/gold/index/<?=$_SESSION['AT']['account']?>/app";        
    <? }?>
}

</script>