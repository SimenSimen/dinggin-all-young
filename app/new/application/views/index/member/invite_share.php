				<section class="content has-side">
					<div class="title"><?=$this->lang['invite'];//邀請碼分享?></div>
					<div class="share"><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share"<?}else{?> href="/share_link" class="btn share fancybox-share"<?}?>><i class="icon-share2"><?=$this->lang['share_link'];?></i></a></div>
					<div class="invite-share">
								<div class="code center">
											<span><?=$this->lang['my_invitation_code'];//我的邀請碼?><br>
										<font><?=base_url();?>gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?></font>
										</span>
								</div>
								<div class="social-link">
										<ul class="share-box list-h">
														<li><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>')) ));"><i><img src="/images/share_link/icon-fb.png" align="center" ></i></a></li>
														<li><a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>')+'&source=bookmark','_blank','width=450,height=400');})()"><i><img src="/images/share_link/icon-weibo.jpg" align="center" ></i></a></li>
														<li><a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&content='.concat(encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>')).concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"><i><img src="/images/share_link/icon-plurk.png" align="center" ></i></a></li>
														<li><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>'))));"><i><img src="/images/share_link/icon-twitter.png" align="center" ></i></a></li>
														<li><a href="javascript: void(window.open('http://line.naver.jp/R/msg/text/?'+encodeURIComponent(document.title)+' - '+encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>') ));"><i><img src="/images/share_link/icon-line.png" align="center"></i></a></li>
														<li><a href="javascript: void(window.open('whatsapp://send?text='+encodeURIComponent(document.title)+' - '+encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>') ));"><i><img src="/images/share_link/icon-wechat.png" align="center"></i></a></li>
														<li><a href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br>'+encodeURIComponent('http://<?=$_SERVER['HTTP_HOST']?>/gold/register/<?=base64_encode($_SESSION['AT']['d_account'])?>') ));"><i><img src="/images/share_link/icon-mail.png" align="center"></i></a></li>
										</ul>
								</div>
                    <div class="pagination_box">
        				<script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
            			<canvas id="qrcodeCanvas" width="240" height="240"></canvas>
            			<script>
                			jQuery('#qrcodeCanvas').qrcode({ width : 240, height : 240, text : "http://<?=$_SERVER['HTTP_HOST'].'/gold/register/'.base64_encode($_SESSION['AT']['d_account']);?>"}); 
  							var canvas = document.getElementById('qrcodeCanvas'),context = canvas.getContext('2d');
            			</script>
            			<br>
            			<a href="#" download="<?=$_SESSION['MT']['name']?>.png" onclick="this.href=canvas.toDataURL();" ><b>qrcode下載</b></a>
                    </div>
								<div class="step-title">
									<div class="titles center"><span></span> <?=$this->lang['share_three_steps'];//分享三步驟?> <span></span></div>
									<p>
										1.<?=$this->lang['share_step1'];//分享個人邀請碼給朋友?>
										2.<?=$this->lang['share_step2'];//朋友輸入您的邀請碼，可立即獲得$100點?>
										3.<?=$this->lang['share_step3'];//朋友於點數效期內消費成功後，您也將獲得$100點回饋?>
									</p>
									<!--<div class="megg center">已經成功推薦給1個人囉!</div>-->
								</div>
							    <?if($s_account['d_account']!=""){?>
								<div class="info-note"><?=$this->lang['share_welcome'];//歡迎加入，輸入邀請碼送點數(每人一次)!?></div>
								<form method="post" action="/gold/invite_share_ok">
										<div class="form-box">
												<div class="form-group">
															<div class="control-box">
																	<i class="icon-name"></i>
																	<label class="control-label"><?=$this->lang['invitation_code'];//邀請人代碼?></label>
																	<input class="form-control" type="text" name="invite_code" id="invite_code" placeholder="" value="<?=base64_encode($s_account['d_account'])?>" <?if($s_account['d_account']!="")echo"disabled";?> required>
															</div>
												</div>
												<button type="submit" class="btn normal send" <?if($s_account['d_account']!="")echo"disabled";?>><?=$this->lang['send'];//送出?></button>
										</div>
								</form>
								</div>
								<?}?>
				</section>
			</div>
		</main>
<style>
.invite-share .form-box .form-control {
    padding-left: 170px;
}
.form-box .form-control{
  padding: 5px 10px 5px 90px;
  background: #e7e7e7;
  color: #666;
}
.invite-share .share-box li{
  width: 14%;
  text-align: center;
  margin: 10px auto;
}
</style>
<script>
$(document).attr("title","<?=$this->lang_menu['jcymall'];//聚彩源商城?><?=$this->lang['inviterequest'];//註冊邀請?>");
$(document).ready(function() {
    $('.fancybox-share').fancybox({
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
//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$this->share_url?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_img=<?=$this->share_prd_image;?>';
    var i_val = "jecp://<?=$this->share_prd_image?>&ecp_title=<?=$this->share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>
