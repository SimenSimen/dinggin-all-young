<section class="content has-side">
                    <div class="title"><?=$this->lang['order'];//個人訂單查詢?></div>   
                        <? if ($orderdata['status']==0 && (empty($orderdata['atmno'])) && $orderdata['pay_way_id']==4){?>
                         <div class="order-detail">
                            <form onsubmit="return check()">
                                <table class="table table-v">
                                    <tbody>
                                        <tr>
                                            <th><?=$this->lang['o_52'];//匯款後五碼?></th>
                                            <td>
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="atmno" id="atmno" placeholder="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_53'];//匯款日期?></th>
                                            <td>
                                                <div class="control-box">
                                                    <input class="form-control date-object" type="text" name="atmdate" id="atmdate" placeholder="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <a class="btn  simple bg2" id="remit"><?=$this->lang['o_54'];//送出?> <i class="icon-chevron-right"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <? }?>
                      <div class="order-detail">
                        <table class="table table-v order-id-table">
                            <tbody>
                                <tr>
                                    <th><?=$this->lang['ordernumber'];//訂單編號?></th>
                                    <td><strong><?=$orderdata['order_id'];?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix">
                                <table class="table table-v">
                                    <tbody>
                                        <tr>
                                            <th><?=$this->lang['orddate'];//訂單日期?></th>
                                            <td><?=$orderdata['order_id'];?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_55'];//收件人姓名?></th>
                                            <td><?=$orderdata['name'];?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_56'];//收件人電話?></th>
                                            <td><?=$orderdata['phone'];?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_57'];//收件人地址?></th>
                                            <td><?=$orderdata['country'];?><?=$orderdata['county'];?><?=$orderdata['area'];?><br><?=$orderdata['address'];?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_58'];//訂單總金額?></th>
                                            <td><strong><?=$this->data['web_config']['currency'];?><?=$orderdata['total_price'];?></strong></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_59'];//付款方式?></th>
                                            <td><?=$orderdata['payment_way'];?></td>
                                        </tr>
                                         <tr>
                                            <th><?=$this->lang['o_79'];//付款狀態?></th>
                                            <td><?=$orderdata['status_name'];?></td>
                                        </tr>
                                        <tr>
                                            <th><?=$this->lang['o_60'];//配送方式?></th>
                                            <td><?=$orderdata['logistics_way'];?><?=$shop_address;?></td>
                                        </tr>
                                        <? if ($orderdata['status']<>0 && (!empty($orderdata['atmno'])) && $orderdata['pay_way_id']==4){?>
                                            <tr>
                                                <th><?=$this->lang['o_52'];//匯款後五碼?></th>
                                                <td><?=$orderdata['atmno'];?></td>
                                            </tr>
                                            <tr>
                                                <th><?=$this->lang['o_53'];//匯款日期?></th>
                                                <td><?=$orderdata['atmdate'];?></td>
                                            </tr>
                                        <?}else if($orderdata['pay_way_id']==4){?>
                                            <tr>
                                                <th>匯款期限</th>
                                                <td><?=$orderdata['atmpayment'];?></td>
                                            </tr>
                                        <?}?>
                                        <? if ($orderdata['status']==4){?>
                                            <tr>
                                                <th>取消人姓名</th>
                                                <td><?=$orderdata['back_name'];?></td>
                                            </tr>
                                            <tr>
                                                <th>取消原因</th>
                                                <td><?=$orderdata['back_note'];?></td>
                                            </tr>
                                        <?}?>
                                        <? if ($orderdata['product_flow']==7 or $orderdata['product_flow']==3){?>
                                            <tr>
                                                <th>退貨人姓名</th>
                                                <td><?=$orderdata['back_name'];?></td>
                                            </tr>
                                            <tr>
                                                <th>退貨人銀行名稱</th>
                                                <td><?=$orderdata['back_bank'];?></td>
                                            </tr>
                                            <tr>
                                                <th>退貨人銀行帳戶</th>
                                                <td><?=$orderdata['back_account'];?></td>
                                            </tr>
                                            <tr>
                                                <th>退貨原因</th>
                                                <td><?=$orderdata['back_note'];?></td>
                                            </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    
                    <div class="title"><?=$this->lang['o_61'];//購物清單?></div>
                    <table class="table table-h cart-table">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['o_62'];//商品名稱?></th>
                                <th><?=$this->lang['o_63'];//金額?></th>
                                <th><?=$this->lang['o_64'];//數量?></th>
                                <th><?=$this->lang['o_65'];//小計?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dbdata as $value) { ?>
                            <tr>
                                <td class="img">
                                    <a href="/products/detail/<?=$value['prd_id'];?>" class="pic"><img src="<?=$Spath;?><?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></a>
                                </td>
                                <td class="info align-left">
                                    <a href="/products/detail/<?=$value['prd_id']?>">
                                        <span class="pd-name">
                                            <?=$value['prd_name']?>
                                           <?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['prd_spec'].')':'';?>
                                        </span>
                                    </a>
                                </td>
                                <td data-title="金額："><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
                                <td data-title="數量："><?=$value['number'];?></td>
                                <td data-title="小計："><?=$this->data['web_config']['currency'];?><?=$value['total_price'];?></td>
                            </tr>                              
                            <?php } ?>                            
                        </tbody>
                    </table>
                    <div class="sum-box">
                        <table class="table table-h sum-table">
                            <tfoot>
                                <tr>
                                    <td><?=$this->lang['o_66'];//訂單總計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=$orderdata['pay_price'];?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['o_67'];//運費小計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=$orderdata['lway_price'];?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['o_68'];//總計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=$orderdata['total_price'];?></td>
                                </tr>   
                                <tr>
                                    <td><?=$this->lang['o_81'];//使用紅利?></td>
                                    <td><?=$orderdata['use_dividend'];?></td>
                                </tr>  
                                <tr>
                                    <td><?=$this->lang['o_80'];//使用現金?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=$orderdata['price_money'];?></td>
                                </tr>                               
                                <tr>
                                    <td colspan="2"><?=$this->lang['o_72'];//本次購買可再護得:紅利?><span class="color01"><?=$orderdata['bonus'];?><?=$this->lang['o_70'];//點?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="pagination_box">
                        <input type='hidden' name='order_id' id='order_id' value='<?=$id?>'>
                        <a href="/order" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> <?=$this->lang['o_73'];//回列表?></a>
                    </div>
                </section>
            </div>
        </main>
<link href="/js/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="/js/drawer.min.js" charset="utf-8"></script>
<script src="/js/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
    $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+100"});//生日時間"年"份軸
    $(function() {
        $("#remit").click(function(){   
        var f = document.forms[0];  
        var re = /^\d+$/;  
        var re5 = /^\d{5}$/;
        var reg=/^(\d{4})-(\d{2})-(\d{2})$/;
        if (!re.test(f.atmno.value)) {  
         alert("<?=$this->lang['o_74'];//匯款後五碼欄位不能空白且只允許輸入數字?>");  
         f.atmno.focus();  
         return false;  
      }  
      if (!re5.test(f.atmno.value)) {  
         alert("<?=$this->lang['o_75'];//匯款後五碼欄位不能空白且只允許輸入5個數字?>");  
         f.atmno.focus();  
         return false;  
      }  
      if (!reg.test(f.atmdate.value)) {  
         alert("<?=$this->lang['o_76'];//匯款日期不能空白且只允許輸入日期?>");  
         f.atmdate.focus();  
         return false;  
      }  
        var  id=$("#order_id").val();
        var atmno =$("#atmno").val();
        var atmdate =$("#atmdate").val();            
        $.ajax({
            url:"/order/ajax_remit",
            method:"POST",
            data:{
                id:id,
                atmno:atmno,
                atmdate:atmdate
            },     
            success:function(data){     
                location.href = "/order/detail/"+id;
            }
            })//end ajax 
        });
    });
   function check() {  
       var f = document.forms[0];  
       var re = /^\d+$/;  
      if (!re.test(f.atmno.value)) {  
         alert("<?=$this->lang['o_77'];//欄位不能空白且只允許輸入數字?>");  
         f.atmno.focus();  
         return false;  
      }  
      if (!re.test(f.atmdate.value)) {  
         alert("<?=$this->lang['o_78'];//欄位不能空白且只允許輸入日期?>");  
         f.atmdate.focus();  
         return false;  
      }  
      return true;  
  }  
</script>