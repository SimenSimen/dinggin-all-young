<section class="content has-side">
    <form action="/order/index" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
		<div class="title"><?=$this->lang_menu['order'];//個人訂單查詢?></div>
		<div class="select-bar clearfix">
			<div class="form-group clearfix">
                <label class="control-label"><?=$this->lang['ordernumber'];//訂單編號?></label>
                <div class="control-box">
                    <input class="form-control" type="text" name="orderNumber" id="orderNumber" placeholder="">
                </div>
            </div>
            <div class="form-group clearfix">
            <label class="control-label"><?=$this->lang['ordinter'];//訂單區間?></label>
                <div class="control-box datepicker">
                    <input class="form-control date-object" type="text" name="datepickerStart" id="datepickerStart" autocomplete="off" >
                    <input class="form-control date-object" type="text" name="datepickerEnd" id="datepickerEnd" autocomplete="off" >
                </div>
            </div>
            <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
            <input type='submit' class="more-search2" id="search" value="<?=$this->lang['strsearch'];//搜尋?>">
	   </div>
    </form>
					<table class="table table-h order-table refund-table">
                        <thead>
                            <tr>
                                <th><?=$this->lang['ordernumber'];//訂單編號?></th>
                                <th><?=$this->lang['orddate'];//訂單日期?></th>
                                <th><?=$this->lang['ordstat'];//訂單狀態?></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($dbdata as $key => $value){?>
                            <tr>
                                <td data-title="訂單編號："><!-- <a href="/order/detail/<?=$value['id']?>" class="num-link"> --><?=$value['order_id']?></td>
                                <td data-title="訂單日期："><?=substr($value['create_time'],0,10)?></td>
                                <td data-title="訂單狀態："><?=$value['status_name']?></td>
                                <td class="btn-holder">
                                    <?if($value['status']==1 && $value['product_flow']==2) {?>
                                        <a href="/order/refund/<?=$value['id']?>" class="btn more"><?=$this->lang['o_11'];//申請退貨?></a>
                                    <?}elseif(in_array($value['product_flow'], [0, 1])){?>
                                        <a href="/order/cancel/<?=$value['id']?>" class="btn more"><?=$this->lang['o_12'];//取消訂單?></a>
                                    <?}?>
                                </td>
                                <td>
                                    <form id="order_detail_form" method="POST">
                                        <a href="/order/detail/<?=$value['id']?>" class="btn more"><i class="icon-search"></i> <?=$this->lang['detail'];//詳細資訊?></a>
                                        <? /*if(!empty($value['receipt_num'])): //20160624-有發票號才顯示?>
                                            <input class="btn more" id="invoice_print_action" type="button" value='<?=$this->lang['print_invoice'];//發票列印?>'>
                                            <input type="hidden" name="d_id" value="<?=$value['id']?>">
                                            <input type="hidden" name="dbname" value="order">
                                        <? endif;*/?>
                                    </form>
                                </td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>                    
                    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
                    <?=$page;?>
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
        $("#search").click(function(){   
        var f = document.forms[0];  
        var re = /^\d+$/;  
            if (f.datepickerStart.value=='' && f.datepickerEnd.value=='') {  
                if (!re.test(f.orderNumber.value)) {  
                    alert("<?=$this->lang['o_1'];//訂單編號只允許輸入數字?>");  
                    f.orderNumber.focus();  
                    return false;  
                } 
            }
            if (!f.orderNumber.value=='' && !f.datepickerStart.value=='') {  
                 alert("<?=$this->lang['o_2'];//訂單編號及日期只能擇一?>");  
                 f.orderNumber.focus();  
                 return false;  
            }  
            if (!f.datepickerStart.value=='') {  
                if (f.datepickerEnd.value=='') {  
                     alert("<?=$this->lang['o_3'];//訂單日期請填完整?>");  
                     f.datepickerEnd.focus();
                     return false;
                }
            }  
            if (!f.datepickerEnd.value=='') {  
                if (f.datepickerStart.value=='') {  
                     alert("<?=$this->lang['o_3'];//訂單日期請填完整?>");  
                     f.datepickerStart.focus();  
                     return false;  
                }
            }  
        });
		$("#invoice_print_action").click(function(){
            $("#parm").val(new Date().getTime());
            $(this).parent('form').attr('action','/order/order_invoice_print');
            $(this).parent('form').attr('target','invoice');
            $(this).parent('form').submit();
            $(this).parent('form').attr('target','');
        });
    });
</script>
