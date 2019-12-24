				<section class="content has-side">
					<div class="title"><?=$this->lang['didetail'];//紅利點數明細?></div>
                    <p><?=$this->lang['subdivi'];//剩餘紅利?><span class="color01"><?=$dividend;?><?=$this->lang['pri'];//點?></span><?=$this->lang['divid'];//紅利點數?></p>
					 <table class="table table-h table02">
                        <form action="/bonus/dividend" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
                        <thead>
                            <tr>
                                <th><?=$this->lang['time'];//時間?></th>
                                <th><?=$this->lang['prinum'];//點數?></th>
                                <th><?=$this->lang['info'];//來源說明?></th>
                                <th><?=$this->lang['status'];//狀態?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($dbdata as $value) :?>
                            <tr>
		                      <td><?=$value['update_time']?></td>
		                      <td><?=$value['d_val']?></td>
		                      <td><?=$value['contitle'].':'.$value['d_des']?></td>
		                      <td><?=$value['is_send']?></td>
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