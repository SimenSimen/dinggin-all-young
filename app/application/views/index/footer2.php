        <footer>
            <div class="info_box">
				<div class="container">
					<div class="link">
						<ul class="list-v">
                        <?php if(!empty($_SESSION['MT'])){ ?>
						    <a href="/providers/create"><i class="fa fa-caret-right" aria-hidden="true"></i> 加入供應商</a>
					    <?php } ?>
                        <?if ($_SESSION['MT']['is_login'] != 1) {?>
							<a href="/gold/login" style="display:inline;"><i class="fa fa-caret-right" aria-hidden="true"></i> 登入</a> | 
							<a href="/gold/register" style="display:inline;">註冊</a>
						<?}?>
						<? foreach ($this->bottom_link_list as $key => $value):?>
                            <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a></li>
						<? endforeach;?>
						</ul>
					</div>
					<div class="map">
					<iframe width="100%" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q=<?=$this->iqr_cart['cset_address'];?>&z=16&output=embed&t=></iframe>
					</div>
					<div class="info">
						E-mail : <a href="mailto:<?=$this->iqr_cart['cset_email'];?>"><?=$this->iqr_cart['cset_email'];?></a><br>
						Phone : <a href="tel:<?=$this->iqr_cart['cset_telphone'];?>"><?=$this->iqr_cart['cset_telphone'];?></a><br>
						FAX: <a href="tel:<?=$this->iqr_cart['cset_fax'];?>"><?=$this->iqr_cart['cset_fax'];?></a><br>
						<?=$this->iqr_cart['cset_address'];?><br>
					</div>
				</div>
			</div>
			<div class="copyright">
				<div class="container">
					Copyright © <?=$this->iqr_cart['cset_company'];?> All Rights Reserved.
				</div>                
			</div>
        </footer>
    </div>
	<div class="floating top-hide">
	    <a href="#" class="ibtn gotop" title="TOP">TOP</a>
	</div>
	<div id="mobile-fixed">
    <ul>
        <li>
            <a href="body" class="btn toggle-mmenu toggleBtn" 
            <?=(!empty($this->session->userdata['isapp']))?' onclick="getQrcodeEncode3()" ':'data-toggletag="mmenu-open"'?>>
            <?=(!empty($this->session->userdata['isapp']))?'<img src="/images/qrcode.png" style="height: 60%; width: 60%;">':'<i class="icon-menu"></i>'?>
            </a>
        </li>        
    </ul>
	</div>
<a href="body" class="btn toggle-mmenu-cover toggleBtn" data-toggletag="mmenu-open"></a>
<div id="mobile-menu">
    <div class="language-menu">
        <div class="site-title"><a href="/products/index" class="logo ibtn"><?=$this->lang_menu['jcymall'];//聚彩源商城?></a></div>
            <div class="language">
                <a href="#" class="btn">EN</a>
                <ul class="list-inline">
                    <li><a href="#">EN</a></li>
                    <li><a href="#">繁中</a></li>
                </ul>
            </div>
        <a href="body" class="btn toggle-mmenu-close toggleBtn" data-toggletag="mmenu-open"><i class="icon-close"></i></a>
    </div>
    <div class="main-menu">
        <ul class="menu list-h">
            <? foreach ($this->mobile_link_list as $key => $value):?>
                <?if($value['d_lang']=="products"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a>
                        <ul><?=$this->product_type;?></ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="contact"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a></li>
                <?}?>
                <?if($value['d_lang']=="register"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a></li>
                <?}?>
                <?if($value['d_lang']=="link"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];?></a>
                        <ul>
                            <?php if(!empty($this->data['list_link'])): ?>
                                <?php foreach ($this->data['list_link'] as $key => $value): ?>
                                    <li><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="news"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//最新消息?></a>
                        <ul>
                            <?php if(!empty($this->data['list_news'])): ?>
                                <?php foreach ($this->data['list_news'] as $key => $value): ?>
                                    <li><a href="/gold/news/C/news/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="activity"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//活動與報名?></a>
                        <ul>
                            <?php if(!empty($this->data['list_enroll'])): ?>
                                <?php foreach ($this->data['list_enroll'] as $key => $value): ?>
                                    <li><a href="/gold/activity/C/enroll/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="activity"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//影音專區?></a>
                        <ul>
                            <?php if(!empty($this->data['list_video'])): ?>
                                <?php foreach ($this->data['list_video'] as $key => $value): ?>
                                    <li><a href="/gold/media/C/video/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="activity"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//活動花絮?></a>
                        <ul>
                            <?php if(!empty($this->data['list_photo'])): ?>
                                <?php foreach ($this->data['list_photo'] as $key => $value): ?>
                                    <li><a href="/gold/photo/C/photo/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="download"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//文件下載?></a>
                        <ul>
                            <?php if(!empty($this->data['list_annex'])): ?>
                                <?php foreach ($this->data['list_annex'] as $key => $value): ?>
                                    <li><a href="/gold/archive/c/annex/<?=$value['id']?>"><?=$value['name']?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="about"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//關於聚彩源?></a>
                        <ul>
                            <li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a></li>
                            <li><a href="/gold/service"><?=$this->lang_menu['servicearea'];//服務專區?></a></li>
                            <li><a href="/gold/member_announcement/service"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
                            <li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
                            <li><a href="/gold/member_announcement/privacy"><?=$this->lang_menu['privacy'];//隱私權政策?></a></li>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="member"){?>
                    <li><a href="<?=$value['d_link']?>"><?=$this->lang_menu[$value['d_lang']];//會員專區?></a>
                        <ul>
                            <?if($_SESSION['MT']['is_login']==1){?>
                            <li><a href="#"><?=$_SESSION['MT']['name']?><?=$this->lang_menu['logged_in'];//已登入?></a></li>
                            <li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a></li>
                            <li><a href="/favorite"><?=$this->lang_menu['favorite'];//最愛商品?></a></li>
                            <li><a href="/order"><?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
                            <li><a href="/bonus/dividend"><?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
                            <li><a href="/gold/member_dividend_fun"><?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
                            <li><a href="/gold/member_info"><?=$this->lang_menu['member_info'];//基本資料?></a></li>
                            <li><a href="/gold/member_address"><?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
                            <li><a href="/gold/member_announcement"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
                            <li><a href="/gold/invite_share"></i><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
                            <li><a href="<?if($_SESSION['MT']['d_is_member']=="0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"> <?=$this->lang_menu['member_upgrade'];//升級經營會員?>
                                <?if($_SESSION['MT']['d_is_member']=="2")
                                    echo "(".$this->lang_menu['under_review'].")";//審核中
                                ?>
                                <?if($_SESSION['MT']['d_is_member']=="1")
                                    echo "(".$this->lang_menu['upgraded'].")";//已升級
                                ?>
                                </a></li>
                            <?}else{?>
                            <li><a href="/gold/login"><?=$this->lang_menu['login'];//會員登入?></a></li>
                            <?}?>
                            <?if($_SESSION['MT']['d_is_member']=="1"){?>
                            <li><a href="/gold/member_active"><?=$this->lang_menu['member_active'];//活躍指標?></a></li>
                            <li><a href="/order/member_sale"><?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
                            <li><a href="/gold/organization"><?=$this->lang_menu['organization'];//組織表?></a></li>
                            <li><a href="/gold/invoice"><?=$this->lang_menu['invoice'];//我要請款?></a></li>
                            <li><a href="/gold/member_bonus"><?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
                            <li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
                            <?}?>
                            <?if($_SESSION['MT']['is_login']==1){?>
                            <li><a href="/gold/logout"><?=$this->lang_menu['logout'];//會員登出?></a></li>
                            <?}?>
                        </ul>
                    </li>
                <?}?>
                <?if($value['d_lang']=="choose_language"){?>
                    <li><a href="#"><?=$this->lang_menu[$value['d_lang']];//選擇語言?></a>
                        <ul>
                        <? foreach ($this->lang_list as $key => $value):?>
                            <li><a href="javascript:void();" id="selectsortid_<?=$value['d_code']?>"><?=$value['d_title']?></a></li>
                        <? endforeach;?>
                        </ul>
                    </li>
                <?}?>
            <? endforeach;?>
        </ul>
    </div>
    <div class="share-menu">
    </div>
</div>
</body>
</html>
<script src="/js/modernizr.js"></script>
<script async src="/js/jquery.scrollTo/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.bxslider/jquery.bxslider.min.js"></script>
<script src="/js/fancyBox/source/jquery.fancybox.pack.js"></script>
<script src="/js/slick/slick/slick.js"></script>
<script src="/js/basic.js"></script>
<script src="/js/main.js"></script>
<script src="/js/jquery.lazyload.js"></script>
<script>
<? foreach ($this->lang_list as $key => $value):?>
$("#selectsortid_<?=$value['d_code']?>").click(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: '<?=$value['d_code']?>'
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
<? endforeach;?>
$("#selectsortid").change(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $("#selectsortid").val()
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
$(function() {
      $(".aa6").click(function(){
        if($('.field').val()==''){
            alert('未輸入搜尋商品');
            return false;
        }else{
            document.getElementById("search").submit();
        }
      })        
});
function check(frm)
 {
    if(frm.elements['search_key'].value==''){
      alert('未輸入搜尋商品');
      return false;
    }
 }   
$(document).ready(function() {
    $('.fancybox-search').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
});
//qrcode
function getQrcodeEncode3(){
    //alert(navigator.userAgent);
    var val   = 'jecp://qrcode=qrcode';
    var i_val = 'jecp://qrcode=qrcode';
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
        location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
        NetNewsAndroidShare.QRcode(val);
    };
}
$(function(){
    $("img.lazy").lazyload();
});

$('.bxslider').bxSlider({
    mode: 'fade',
    captions: true,
    auto: true,
    stopAutoOnClick: true,
    stopAuto: false
}); 
</script>