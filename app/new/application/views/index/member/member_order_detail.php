				<link rel="stylesheet" href="/css/gold/baze.modal.css">
				<script src="/js/gold/baze.modal.js"></script> 
				<section class="content has-side">
					<div class="title"><?=$this->lang['odetail'];//訂單明細?></div>
					
					  <div class="order-detail">
                        <table class="table table-v order-id-table">
                            <tbody>
                                <tr>
                                    <th><?=$this->lang['num'];//編號?></th>
                                    <td><strong><?=$dbdata['order_id']?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix">
                                <table class="table table-v">
                                    <tbody>
                                        <tr>
                                            <th><?=$this->lang['odate'];//訂單日期：?></th>
                                            <td><?=$dbdata['create_time']?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['sname'];//收件人姓名?></th>
                                            <td><?=$dbdata['name']?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['sphoto'];//收件人電話?></th>
                                            <td><?=$dbdata['phone']?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['saddress'];//收件人地址?></th>
                                            <td><?=$dbdata['zip'].$dbdata['county'].$dbdata['area'].$dbdata['address']?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['ordertotal'];//訂單總金額?></th>
                                            <td><strong><?=number_format($dbdata['total_price'])?>元</strong></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['paytype'];//付款方式?></th>
                                            <td><?=$dbdata['pay']?></td>
                                        </tr>
                                         <tr>
                                            <th><?=$this->lang['paystatus'];//付款狀態?></th>
                                            <td><?=$dbdata['status']?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['vinfo'];//發票資訊?></th>
                                            <td><?=$this->lang['rece'];//電子式發票?> <?=($dbdata['rece']!='')?$dbdata['rece']:'';?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['sendtype'];//配送方式?></th>
                                            <td><?=$dbdata['logis']?></td>
                                        </tr>
                                        <tr>
                                            <th>匯款後五碼</th>
                                            <td>56566</td>
                                        </tr>
                                        <tr>
                                            <th>匯款日期</th>
                                            <td>2017-02-13 00:00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                        </div>
                    </div>
                    
                    <div class="title">購物清單</div>
                     <table class="table table-h cart-table" border="0">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['option'];//品項?></th>
                                <th><?=$this->lang['money'];//金額?></th>
                                <th>數量</th>
                                <th>小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($details as $dvalue):?>
                            <tr>
                                <td class="img" align="right">
                                    <a href="/products/detail" target=_blank class="pic"><img src="/images/pro/pic1.jpg" title="<?=$dvalue['prd_name']?>" border="0" width="60" class="pic"></a>
                                </td>
                                <td class="info align-left">
                                    <a href="/products/detail" target=_blank>
                                        <span class="pd-name"><?=$dvalue['prd_name']?></span>
                        			</a>
                                </td>
                                <td data-title="金額：">$<?=number_format($dvalue['price'])?></td>
                                <td data-title="數量："> <?=$dvalue['number']?> </td>
                                <td data-title="小計：">$<?=number_format($dvalue['total_price'])?></td>
                            </tr>
                              
                            <? endforeach;?>
                            
                        </tbody>
                    </table>
                    <div class="sum-box">
                        <table class="table table-h sum-table">
                            <tfoot>
                                <tr>
                                    <td><?=$this->lang['total'];//金額總計?></td>
                                    <td>$<?=number_format($dbdata['total_price'])?><?=$this->lang['tw'];//元?><!--+紅利100點+樂活50點--></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['sendmo'];//運費?></td>
                                    <td>$<?=($dbdata['lway_price']!='')?number_format($dbdata['lway_price']).$this->lang['tw']:'0'.$this->lang['tw'].'('.$this->lang['nopay'].')'; //元 （達免運標準）?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['pay'];//實付金額?></td>
                                    <td>$<?=number_format($dbdata['total_price']+$dbdata['lway_price'])?><?=$this->lang['tw'];//元?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">目前積點： 紅利<span class="color01">500點</span>，樂活<span class="color01">100點</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">累計積點： 紅利<span class="color01">400點</span>，樂活<span class="color01">50點</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">本次購買可再護得:紅利<span class="color01">0點</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    
                    <div class="pagination_box">
                        <a href="/gold/member_order" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> 回列表</a>
                    </div>

				</section>
			</div>
		</main>