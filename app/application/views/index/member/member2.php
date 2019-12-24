				<section class="content has-side">
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
					<div class="title"><?=$this->lang['member'];//會員專區?></div>
					<div class="editor mg">
						<?if($membername['name']!=""){?>
							<div class="m-title"><?=$this->lang['partner'];//合夥經營會員?>:<?=$membername['name']?></div>
						<?}?>
						<div style="margin-top: 1em;"><?=$this->lang['member'];//會員專區?></div>
						<ul class="products-list list-h">
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/favorite"><i class="icon-like" style="font-size:2em"></i></br> <?=$this->lang_menu['favorite'];//最愛商品?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/order"><i class="icon-menu2" style="font-size:2em"></i></br> <?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/bonus/dividend"><i class="icon-cash" style="font-size:2em"></i></br> <?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/member_dividend_fun"><i class="icon-analysis" style="font-size:2em"></i></br> <?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/member_info"><i class="icon-information" style="font-size:2em"></i></br> <?=$this->lang_menu['member_info'];//基本資料?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/member_address"><i class="icon-placeholder" style="font-size:2em"></i></br> <?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/member_announcement"><i class="icon-megaphone" style="font-size:2em"></i></br> <?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/invite_share"><i class="icon-megaphone" style="font-size:2em"></i></br><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
							<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; <?=($_SESSION['MT']['d_is_member']=="1")?'top: 10%;':'top: 20%;'?>" href="<?if($_SESSION['MT']['d_is_member']=="0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"><i class="icon-leader" style="font-size:2em"></i></br> <?=$this->lang_menu['member_upgrade'];//升級經營會員?>
								<?if($_SESSION['MT']['d_is_member']=="2")
									echo "<br>(".$this->lang_menu['under_review'].")";//審核中
								?>
								<?if($_SESSION['MT']['d_is_member']=="1")
									echo "<br>(".$this->lang_menu['upgraded'].")";//已升級
								?>
							</a></li>

							<?if($_SESSION['MT']['is_login']==1){?>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6.5em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/logout"><i class="icon-logout" style="font-size:2em"></i></br><?=$this->lang_menu['logout'];//會員登出?></a></li>
							<?}?>

						</ul>
						
						<?if($_SESSION['MT']['d_is_member']=="1"){?>

							<div style="margin-top: 1em;"><?=$this->lang['business_member'];//經營會員專區?></div>
							<ul class="products-list list-h">
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/order/member_sale"><i class="icon-paper" style="font-size:2em"></i></br> <?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/organization"><i class="fa fa-sitemap" style="font-size:2em"></i></br><?=$this->lang_menu['organization'];//組織表?></a></li>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/invoice"><i class="icon-credit-cards" style="font-size:2em"></i></br><?=$this->lang_menu['invoice'];//我要請款?></a></li>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/member_bonus"><i class="icon-money" style="font-size:2em"></i></br> <?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; "><a style="text-align: center; top: 20%;" href="/gold/announce"><i class="icon-megaphone-2" style="font-size:2em"></i></br> <?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
							</ul>
						<?}?>

						<?
						$this->member2_link	=	$this->mobile_link_list;
						foreach ($this->member2_link as $key => &$value){
							switch ($value['d_lang']) {
								case "products":
								case "choose_language":
								case "member":
									unset($this->member2_link[$key]);//在member頁面不需要
									break;

								case "contact":
									$value['icon']='icon-support';
									break;
								case "register":
									$value['icon']='icon-nickname';
									break;
								case "link":
									$value['icon']='icon-like';
									break;
								case "news":
									$value['icon']='icon-megaphone';
									break;
								case "activity":
									$value['icon']='fa fa-paste';
									break;
								case "movie":
									$value['icon']='fa fa-film';
									break;
								case "album":
									$value['icon']='fa fa-camera';
									break;
								case "download":
									$value['icon']='fa fa-download';
									break;
								case "about":
									$value['icon']='fa fa-user';
									break;

								default:
									$value['icon']='icon-information';
									break;							
							}// end switch
						}//end foreach?>


						<div style="margin-top: 1em;"><?=$this->lang['other'];//其他?></div>
						<ul class="products-list list-h">
						<?foreach ($this->member2_link as $key => $value){?>
							<? if ($value['d_link'] != '/gold/register') { ?>
								<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; ">
									<a style="text-align: center;top: 20%;" href="<?=$value['d_link']?>">
										<i class="<?=$value['icon'];?>" style="font-size:2em"></i><br><?=$this->lang_menu[$value['d_lang']];?>
									</a>
								</li>
							<?}?>
			    		<?}//endforeach ?>
			    			<?if( (!empty($this->session->userdata['isapp']))){//APP裝置?>
				    			<li class="item wow fadeIn" id="prd_list_img" style="height:6em;overflow: hidden; ">
									<a style="text-align: center;top: 20%;" onclick="getSettingEncode3()">
										<i class="fa fa-cogs" style="font-size:2em"></i><br><?=$this->lang_menu['setting'];?>
									</a>
								</li>
							<?}?>
						</ul>
						<?if(!empty($this->session->userdata['isapp'])){?> 			
						<div style="margin-top: 1em;"><?=$this->lang_menu['choose_language'];//選擇語言?></div>
						<ul>
							<? foreach ($this->lang_list as $key => $value){?>
							<li>
								<a onclick="setlang(<?=$key?>)" href="javascript:void();" id="selectsortid_<?=$value['d_code']?>"><?=$value['d_title']?>
									<i id="setlang_<?=$key?>" class="fa fa-toggle-<?=($this->setlang==$value['d_code'])?'on':'off'?>"></i>
								</a>
							</li>
							<? }//endforeach?>							
						</ul>
						<?}?>
					</div>
				</section>
			</div>
		</main>
<script>
	function setlang($value){
		$('.fa-toggle-on').attr("class","fa fa-toggle-off");
		$('#setlang_'+$value).attr("class","fa fa-toggle-on");
	}

	//呼叫APP原生設定
	function getSettingEncode3(){
	    //alert(navigator.userAgent);
	    var val   = 'jecp://setting=setting';
    	var i_val = 'jecp://setting=setting';
	    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
	            location.href = i_val;
	    } else if (/(Android)/i.test(navigator.userAgent)) {
	            NetNewsAndroidShare.setting(val);
	    };
	}
</script>