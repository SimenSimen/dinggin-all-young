<section class="content has-side">
                    <div class="title"><?=$this->lang['o_12'];//取消訂單?></div>
                    <div class="order-detail">
                        <table class="table table-v">
                            <tbody>
                                <tr>
                                    <th><?=$this->lang['ordernumber'];//訂單編號?></th>
                                    <td><strong><?=$orderdata['order_id'];?></strong></td>
                                </tr>
                                <tr>
                                    <th><?=$this->lang['o_63'];//訂單金額?></th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['pay_price'];?></strong></td>
                                </tr>
                                <tr>
                                    <th><?=$this->lang['o_67'];//運費?></th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['lway_price'];?></strong></td>
                                </tr>
                                <tr>
                                    <th><?=$this->lang['o_58'];//訂單總金額?></th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['total_price'];?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <table class="table table-h cart-table refund">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['o_62'];//商品名稱?></th>
                                <th><?=$this->lang['o_63'];//金額?></th>
                                <th><?=$this->lang['o_64'];//數量?></th>
                                <th><?=$this->lang['o_65'];//小計?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($dbdata as $key => $value) {?>
                            <tr>     
                                <td class="img">
                                    <a href="/products/detail/<?=$value['prd_id'];?>" class="pic"><img src="<?=$Spath;?><?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></a>
                                </td>
                                <td class="info align-left">
                                    <a href="/products/detail/<?=$value['prd_id'];?>"><span class="pd-name"><?=$value['prd_name'];?></span></a>
                                </td>
                                <td data-title="金額："><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
                                <td data-title="數量："><?=$value['number'];?></td>
                                <td data-title="小計："><?=$this->data['web_config']['currency'];?><?=$value['total_price'];?></td>
                            </tr>
                            <?}?>
                                                        
                        </tbody>
                    </table>
                    <div class="pagination_box">
                        <button class="btn simple bg2" onclick="cancelOrder()"><?=$this->lang['o_12'];//取消訂單?> <i class="icon-chevron-right"></i></button>
                    </div>                    
                    <div class="pagination_box">
                        <a href="/order" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> <?=$this->lang['back_list'];//回列表?></a>
                    </div>

                </section>
            </div>
        </main>
<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });

    const cancelOrder = () => {
        if (confirm('確定要取消訂單？')) {
            $.ajax({
				url: '/order/ajax_order_back',
				type: 'POST',
				data: {
                    FromPage: 'cancel',
                    order_id: <?=$id?>,
                },
                dataType: 'JSON',
				success: function () {
                    window.location.href = '/order'     
                }
            });
        }
    }
</script>