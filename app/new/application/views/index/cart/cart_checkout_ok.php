<div class="container">
                <section class="content">
                    <div class="success-wrap">
                        <div class="success-box">
                            <div class="success-msg"><?=$this->lang['c_50'];//交易成功?></div>
                            <div class="success-txt"><?=$this->lang['c_51'];//請記住您的【訂單編號】<br>祝您購物愉快?>
                                <br>
                                <div class="order-id"><?=$this->lang['c_52'];//訂單編號?>: <?=$order_id;?></div>
                                <?=$this->lang['c_53'];//感謝您的訂購, <br>有任何問題，請使用 ?>                             
                                <a href="/gold/contact"><?=$this->lang['c_54'];//聯絡我們?></a> <?=$this->lang['c_55'];//留言，我們收到您的留言後，會盡快與您連絡。?>
                            </div>
                        </div>                
                        <div class="col">
                            <div class="payway">
                                <? if($_POST['lway_id']==5){?>
                                    <div class="atm-transfer-info-2">
                                        <h3 class="heading"><?=$this->lang['c_57'];//門市取貨?></h3>
                                        <span><?=$this->lang['c_58'];//取貨門市姓名?>: <font><?=$shop_name;?></font></span>
                                        <span><?=$this->lang['c_59'];//取貨門市地址?>: <font><?=$shop_address;?></font></span>
                                    </div>
                                <?}if($_POST['pway_id']==4){?>
                                    <div class="shopping-title"><?=$this->lang['c_56'];//您選擇的付款方式?>:</div>
                                    <div class="atm-transfer-info-2">
                                        <h3 class="heading"><?=$this->lang['c_60'];//ATM轉帳資料?></h3>
                                    <? foreach ($atm as $value):?>
                                        <span><?=$value['d_title']?>: <font><?=$value['d_val']?></font></span>
                                  <? endforeach;?>
                                    </div>
                                <? }?>
                            </div>
                        </div>
                    </div>
                    <div class="pagination_box">
                        <a href="/index/" class="btn simple bg2"><?=$this->lang['c_65'];//回首頁?> <i class="icon-chevron-right"></i></a>
                        <a href="/order/detail/<?=$oid;?>" class="btn simple bg2"><?=$this->lang['c_66'];//訂單明細?> <i class="icon-chevron-right"></i></a>
                    </div>
                </section>
            </div>
        </main>