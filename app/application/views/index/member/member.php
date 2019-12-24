			<div class="container">
				<section class="content">
					<div class="title"><?=$this->lang_menu['member'];//會員專區?></div>
					<div class="editor mg">
						<?if($membername['name']!=""){?>
						<div class="m-title"><?=$this->lang_menu['partner'];//合夥經營會員?>:<?=$membername['name']?></div>
						<?}?>
						<ul class="member_list">
							<li><a href="/products"><i class="icon-shopping-cart"></i><?=$this->lang_menu['products'];//購物商城?></a></li>
							<li><a href="/favorite"><i class="icon-like"></i><?=$this->lang_menu['favorite'];//最愛商品?></a></li>
							<li><a href="/order"><i class="icon-menu2"></i><?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
							<li><a href="/bonus/dividend"><i class="icon-cash"></i><?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
							<li><a href="/gold/member_dividend_fun"><i class="icon-analysis"></i><?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
							<li><a href="/gold/member_info"><i class="icon-information"></i><?=$this->lang_menu['member_info'];//基本資料?></a></li>
							<li><a href="/gold/member_address"><i class="icon-placeholder"></i><?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
							<li><a href="/gold/member_announcement"><i class="icon-megaphone"></i><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
							<?if($_SESSION['MT']['d_is_member']=="0"){ ?>
							<li><a href="/gold/member_upgrade"><i class="icon-leader"></i><?=$this->lang_menu['member_upgrade'];//升級經營會員?>
								<?if($_SESSION['MT']['d_is_member']=="2")
									echo "(".$this->lang_menu['under_review'].")";//審核中
								?>
								<?if($_SESSION['MT']['d_is_member']=="1")
									echo "(".$this->lang_menu['upgraded'].")";//已升級
								?>
							</a></li>
							<?php } ?>
							<?if($_SESSION['MT']['d_is_member']=="1"){?>
							<li><a href="/gold/invite_share"><i class="icon-share2"></i><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
							<li><a href="/order/member_sale"><i class="icon-paper"></i><?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
							<li><a href="/gold/organization"><i class="icon-member"></i><?=$this->lang_menu['organization'];//組織表?></a></li>
							<li><a href="/gold/invoice"><i class="icon-credit-cards"></i><?=$this->lang_menu['invoice'];//我要請款?></a></li>
							<li><a href="/gold/invoice_list"><i class="icon-menu2"></i><?=$this->lang_menu['invoice_list'];//請款記錄?></a></li>
							<li><a href="/gold/member_bonus"><i class="icon-money"></i><?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
							<li><a href="/gold/announce"><i class="icon-megaphone-2"></i><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
							<?}?>
							<?if($_SESSION['MT']['is_login']==1){?>
							<li><a href="/gold/logout"><i class="icon-growth"></i><?=$this->lang_menu['logout'];//會員登出?></a></li>
							<?}?>
						</ul>

					</div>
				</section>
			</div>
		</main>
