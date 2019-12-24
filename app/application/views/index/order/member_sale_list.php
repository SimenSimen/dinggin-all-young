<section class="content has-side">
    <form action="/order/member_sale" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
		<div class="title"><?=$this->lang_menu['member_sale'];//個人訂單查詢?></div>
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
                                <th><?=$this->lang['orderer'];//訂購者?></th>
                                <th><?=$this->lang['orddate'];//訂單日期?></th>
                                <th><?=$this->lang['ordstat'];//訂單狀態?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($dbdata as $key => $value){?>
                            <tr>
                                <td data-title="訂單編號："><?=$value['order_id']?></td>
                                <td data-title="訂購者："><?=$value['name']?></td>
                                <td data-title="訂單日期："><?=substr($value['create_time'],0,10)?></td>
                                <td data-title="訂單狀態："><?=$value['status_name']?></td>
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
    });
</script>