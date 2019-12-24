				<section class="content has-side">
					<div class="title"><?=$this->lang_menu['invoice_list'];//請款記錄?></div>
					 <table class="table table-h table02">
                        <form action="/bonus/dividend" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
                        <thead>
                            <tr>
                                <th><?=$this->lang['time'];//時間?></th>
                                <th>付款方式</th>
                                <th>實際金額</th>
                                <th><?=$this->lang['status'];//狀態?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($dbdata as $value) :?>
                            <tr>
		                      <td nowrap><?=$value['d_date']?></td>
		                      <td nowrap><?=$value['d_type']?></td>
		                      <td nowrap><?=$value['d_bonus']?></td>
		                      <td nowrap><?=$value['d_send']?></td>
                            </tr>
                            <? endforeach;?>
                        </tbody>
                        <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
                        </form>
                    </table>
                     <div class="pagination_box">
                     <p><?=$this->lang['total'];//共?> <?=$TotalRecord;?> <?=$this->lang['count'];//筆?></p>
                    <?=$page;?>
                    </div>
				</section>
			</div>
		</main>
