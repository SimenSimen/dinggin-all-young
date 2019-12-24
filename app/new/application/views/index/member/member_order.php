				<? header("Cache-control: private");?>
				<section class="content has-side">
					<div class="title"><?=$title?></div>
					<div class="select-bar clearfix">
						<form method="post" class="j-forms">
                        <div class="form-group clearfix">
                            <label class="control-label"><?=$this->lang['orderid'];//訂單編號?></label>
                            <div class="control-box">
                    			<input class="form-control" type="text" placeholder="<?=$this->lang['iorderid'];//請輸入訂單編號?>" name="order_id" value="<?=$order_id?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label"><?=$this->lang['ordinter'];//訂單區間?></label>
                            <div class="control-box datepicker">
                    			<input class="form-control date-object" type="text" id="date_from" name="date_start" value="<?=$date_start?>" placeholder="<?=$this->lang['select'].$this->lang['start'];//請選擇開始區間?>">
                    			<input class="form-control date-object" type="text" id="date_to" name="date_end" value="<?=$date_end?>" placeholder="<?=$this->lang['select'].$this->lang['end'];//請選擇結束區間?>">
                            </div>
                        </div>
                    	<input type="submit" value="<?=$this->lang['result'];//搜尋結果?>" class="more-search2">
                    	</form>
                    </div>
					  <table class="table table-h order-table">
                        <thead>
                            <tr>
                                <th><?=$this->lang['orderid'];//訂單編號?></th>
							    <? if($type=='buyer'):?>
							      <th><?=$this->lang['orderer'];//訂購者?></th>
							    <? endif;?>
                                <th><?=$this->lang['orddate'];//訂單日期?></th>
                                <th><?=$this->lang['ordstat'];//訂單狀態?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? if(!empty($dbdata)):foreach ($dbdata as $value):?>
                            <tr>
                                <td data-title="訂單編號："><?=$value['order_id']?></td>
                    			<? if($type=='buyer'):?>
                                <td data-title="訂購者："><?=$value['sname']?></td>
                    			<? endif;?>
                                <td data-title="訂單日期："><?=$value['create_time']?></td>
                                <td data-title="訂單狀態："><?=$value['product_flow']?></td>
                                <td class="btn-holder">
                    				<a href="/gold/<?=$iurl?>/<?=$value['id']?>" class="btn more"><i class="icon-search"></i><?=$this->lang['details'];//詳細內容?></a>
                                </td>
                            </tr>
						    <? endforeach;?>
						    <? else:?>
						      <tr>
						        <td>
						          <?=$this->lang['nodata'];//目前沒有資料?>
						         <td>
						      </tr>
						    <?endif;?>
                        </tbody>
                    </table>
                    <!--
                    <div class="pagination_box">
                    <p>共 N 筆</p>
					<ul class="pagination">
					    <li><a class="controls prev" href="#" title="上一頁"><i class="icon-chevron-left"></i></a></li>
					    <li><a href="#">1</a></li>
					    <li><a href="#">2</a></li>
					    <li class="active"><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li><a class="controls next" href="#" title="下一頁"><i class="icon-chevron-right"></i></a></li>
					</ul>
					<div class="page-info">
					    <select class="form-control" name="" id="">
					        <option value="">第 1 頁</option>
					        <option value="">第 2 頁</option>
					        <option value="">第 3 頁</option>
					    </select>
					</div>
                    </div>
					-->
				</section>
			</div>
		</main>
		<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
		<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
		<script>
		  $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+100"});//生日時間"年"份軸
		</script>