				<section class="content has-side">
					<div class="title"><?=$this->lang['shopping_money_details'];//購物金明細?></div>
                    <p ><?=$this->lang['remaining'];//剩餘?> <span class="color01"><?=number_format($dbdata['d_shopping_money'])?><?=$this->lang['point'];//點?></span><?=$this->lang['shopping_money'];//購物金?></p>
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                                <th><?=$this->lang['time'];//時間?></th>
                                <th><?=$this->lang['transfer_membership'];//轉贈會員?></th>
                                <th><?=$this->lang['points'];//點數?></th>
                                <th><?=$this->lang['source'];//來源?></th>
                            </tr>
                        </thead>
                        <tbody>
                    	<?$icount=0;?>
						<?php if(!empty($shopping_money)): ?>
							<?php foreach ($shopping_money as $key => $value): ?>
                            <tr>
                                <td data-title="時間："><?=$value['create_time']?></td>
                    			<td data-title="轉贈會員："><?=$value['name']?></td>
                                <td data-title="點數："><span class="color02"><?=number_format($value['d_shopping_money'])?></span></td>
                                <td data-title="來源："><?=$value['d_content']?></td>
                    			<?
                    			$icount++;
                    			?>
                            </tr>
				      		<?php endforeach; ?>
				      	<?php endif; ?>
                        </tbody>
                    </table>

                     <div class="pagination_box">
                     <p><?=$this->lang['total'];//共?> <?=$icount?> <?=$this->lang['record'];//筆?></p>
                    </div>
				</section>
			</div>
		</main>