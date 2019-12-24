<section class="content has-side">
                    <div class="title">申請退貨</div>
                    <div class="order-detail">
                        <table class="table table-v order-id-table">
                            <tbody>
                                <tr>
                                    <th>訂單編號</th>
                                    <td><strong><?=$orderdata['order_id'];?></strong></td>
                                </tr>
                                <tr>
                                    <th>訂單金額</th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['pay_price'];?></strong></td>
                                </tr>
                                <tr>
                                    <th>運費</th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['lway_price'];?></strong></td>
                                </tr>
                                <tr>
                                    <th>訂單總金額</th>
                                    <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['total_price'];?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <table class="table table-h cart-table refund">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2">商品名稱</th>
                                <th>金額</th>
                                <th>數量</th>
                                <th>小計</th>
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
                        <a href="/order/refund_info/<?=$id;?>" class="btn simple bg2 fancybox-refund">申請退貨 <i class="icon-chevron-right"></i></a>
                    </div>                    
                    <div class="pagination_box">
                        <a href="/order" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> 回列表</a>
                    </div>

                </section>
            </div>
        </main>
<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
$(document).ready(function() {
    $('.fancybox-refund').fancybox({
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
  </script>
