<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_detail_css'); ?>

<!-------一個一個跑出來------------>
<script type="text/javascript" src="/js/gold/jquery.jqfader.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function(){
init();
});
function init(){
jQuery('.fader').jqfader({callback:showRestart});
}
function showRestart(){
jQuery('.restart').fadeTo(300,1);
}
function restart(){
jQuery('.restart,.fader').css({'display':'none'});
init();
}
</script>
<!-------設定檔------------>
</head>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['interest']?></header>
<div class="wrapper">
<div class="info-list">
    <ul>
        <li class="fader">
          <a href="/gold/policies/service" class="set-title01"><?=$service[0]['d_title']?></a>
        </li>
      	<li class="fader">
          <a href="/gold/policies/privacy" class="set-title01"><?=$privacy[0]['d_title']?></a>
        </li>
      
    </ul>
 </div>     
</div><!--/wrapper-->               
