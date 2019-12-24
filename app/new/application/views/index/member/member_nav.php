			<div class="container">
					<aside class="side">
						<ul class="side-nav list-v">
							<li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a></li>
							<li><a href="/favorite"><?=$this->lang_menu['favorite'];//最愛商品?></a></li>
							<li><a href="/order"><?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
							<li><a href="/bonus/dividend"><?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
							<li><a href="/gold/member_dividend_fun"><?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
							<li><a href="/gold/member_info"><?=$this->lang_menu['member_info'];//基本資料?></a></li>
							<li><a href="/gold/member_address"><?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
							<li><a href="/gold/member_announcement"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
							<li><a href="/gold/invite_share"><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
							<li><a href="<?if($_SESSION['MT']['d_is_member']=="0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"><?=$this->lang_menu['member_upgrade'];//升級經營會員?>
								<?if($_SESSION['MT']['d_is_member']=="2")
									echo "(".$this->lang_menu['under_review'].")";//審核中
								?>
								<?if($_SESSION['MT']['d_is_member']=="1")
									echo "(".$this->lang_menu['upgraded'].")";//已升級
								?>
										
							</a></li>
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
	                </aside>