				<section class="content has-side">
					<div class="title">紅利點數明細<!--<?=$this->lang['didetail'];//紅利點數明細?>--></div>
                    <p >剩餘<!--<?=$this->lang['subdivi'];//剩餘紅利?>--> <span class="color01"><?=number_format($dividend)?><?=$this->lang['pri'];//點?></span>紅利<!--<?=$this->lang['divid'];//紅利點數?>--></p>
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                                <th><?=$this->lang['time'];//時間?></th>
                                <th><?=$this->lang['prinum'];//點數?></th>
                                <th Style="text-align:left"><?=$this->lang['info'];//來源說明?></th>
                                <th><?=$this->lang['status'];//狀態?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($dbdata as $value) :?>
                            <tr>
		                      <td><?=$value['update_time']?></td>
		                      <td><?=$value['d_val']?></td>
		                      <td Style="text-align:left"><?=$value['contitle'].':'.$value['d_des']?></td>
		                      <td><?=$value['is_send']?></td>
                            </tr>
                            <? endforeach;?>
                        </tbody>
                    </table>
					<!--
                     <div class="pagination_box">
                     <p>共 N 筆</p>
                    <?php include('include_pages.php'); ?>
                    </div>
                    -->
				</section>
			</div>
		</main>
