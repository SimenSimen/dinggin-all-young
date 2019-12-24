<div class="container">
                <section class="content">
                    <div class="success-wrap">
                        <div class="success-box">
                            <div class="success-msg"><?=$this->lang['c_55'];//交易成功?></div>
                            <div class="success-txt"><?=$this->lang['c_56'];//請記住您的【訂單編號】<br>祝您購物愉快?>
                                <br>
                                <div class="order-id"><?=$this->lang['c_57'];//訂單編號?>: <?=$order_id;?></div>
                                <?=$this->lang['c_58'];//感謝您的訂購, <br>有任何問題，請使用 ?>
                                <a href="/gold/contact"><?=$this->lang['c_59'];//聯絡我們?></a> <?=$this->lang['c_60'];//留言，我們收到您的留言後，會盡快與您連絡。?>
                            </div>
                        </div>
                    </div>
                    <div class="pagination_box">
                        <a href="/index/" class="btn simple bg2"><?=$this->lang['c_61'];//回首頁?> <i class="icon-chevron-right"></i></a>
                        <a href="/order/detail/<?=$oid;?>" class="btn simple bg2"><?=$this->lang['c_62'];//訂單明細?> <i class="icon-chevron-right"></i></a>
                    </div>
                </section>
            </div>
					<script type="text/javascript" src="//cdn.vbtrax.com/javascripts/va.js"></script>
					<script>
						VA.remoteLoad({
							whiteLabel: { id: 8, siteId: 1484, domain: 'vbtrax.com' },
							conversion: true,
							conversionData: {
							step: 'sale', // conversion name
							revenue: '', // revenue share
							orderTotal: '<?=$order_price?>', // order total
							order: '<?=$order_id;?>' // order number
							},
							locale: "en-US", mkt: true
						});
					</script>
        </main>
