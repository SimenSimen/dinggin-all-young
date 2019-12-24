<link href="/css/gold/font-awesome.min.css" rel="stylesheet">
<!-------一個一個跑出來------------>
<script type="text/javascript" src="/js/jquery.jqfader.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    init();
});
function init() {
    jQuery('.fader').jqfader({
        callback: showRestart
    });
}
function showRestart() {
    jQuery('.restart').fadeTo(300, 1);
}
function restart() {
    jQuery('.restart,.fader').css({
        'display': 'none'
    });
    init();
}
</script>
<!-------設定檔------------>
<link href="/css/gold/setting.css" rel="stylesheet" type="text/css">
<style>
<!-- 
.intention{ font-size:1em; color:#666; text-align:center; display:block; padding:0 0 10px;}
.intention span{ color:#F00;}
-->
</style>
</head>
<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['member'];//會員中心?></header>
    <div class="wrapper">
    <? if($dbdata['d_is_member']=='1'):?>
        <div class="intention">
            <?=$this->lang['viplimit'];//VIP會員期限：?><span><?=$this->lang['sub'];//剩?><?=$line?><?=$this->lang['day'];//天?></span>
        </div>
    <?endif;?>
        <ul class="common-item-ul">
            <li class="fader"><a href="/gold/member_info"><h2 class="set-title01"><?=$this->lang['basic'];//基本資料?></h2></a></li>
            <? if($dbdata['d_is_member']=='2'):?>
                <li class="fader"><a href="javascript:void(0)" onClick="vipchk()"><h2 class="set-title01"><?=$this->lang['viping'];//vip會員申請受理中?></h2></a></li>
            <? elseif($dbdata['d_is_member']=='0'):?>
                <li class="fader"><a href="/gold/upgrade"><h2 class="set-title01"><?=$this->lang['update'];//升級VIP會員?></h2></a></li>
            <?endif;?>
            <? if($renewal=='1'):?>
                <li class="fader"><a href="javascript:void(0)" onClick="renewal()"><h2 class="set-title01"><?=$this->lang['viprenewal'];//申請vip會員續約?></h2></a></li>
            <?endif;?>
            <li class="fader"><a href="/gold/order_list"><h2 class="set-title01"><?=$this->lang['sorder'];//訂單查詢?></h2></a></li>
            <? if($dbdata['d_is_member']=='1'):?>                   
                <li class="fader"><a href="/gold/order_list/buyer"><h2 class="set-title01"><?=$this->lang['apporder'];//APP銷售訂單查詢?></h2></a></li>
                <li class="fader"><a href="/gold/bonus_list"><h2 class="set-title01"><?=$this->lang['bonus'];//獎金查詢?></h2></a></li>
             <? endif;?>    
            <li class="fader"><a href="/gold/dividend"><h2 class="set-title01"><?=$this->lang['dividend'];//紅利點數查詢?></h2></a></li>
            <li class="fader"><a href="/gold/announce"><h2 class="set-title01"><?=$this->lang['interest'];//會員權益公告?></h2></a></li>
            <? if($dbdata['d_is_member']=='1'):?>  
                <li class="fader"><a href="/gold/contribute"><h2 class="set-title01"><?=$this->lang['review'];//心得投稿?></h2></a></li>
            <? endif;?>      
            <li class="fader"><a href="/gold/logout"><h2 class="set-title01"><?=$this->lang['logout'];//登出?></h2></a></li>
        </ul>
    </div>
    <!--/wrapper-->
    <!--
<div id="menu">
  <ul class="menu-nav">
      <li><a href="index.html"><i></i>關於我</a></li>
      <li><a href="team.html" class="now"><i></i>關於eoneda</a></li>
  </ul>
</div>
-->
</body>
</html>
