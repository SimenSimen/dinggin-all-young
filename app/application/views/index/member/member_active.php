				<section class="content has-side">
					<div class="title"><?=$this->lang_menu['member_active'];//活躍指標?></div>
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                    			<th><?=$this->lang['year'];//年度?></th>
                                <th><?=$this->lang['month'];//月份?></th>
                                <th><?=$this->lang['turnover'];//營業額?></th>
                                <th><?=$this->lang['qualification'];//活躍資格?></th>
                            </tr>
                        </thead>
                        <tbody>
						<?php if(!empty($active)): ?>
							<?php foreach ($active as $key => $value): ?>
                            <tr>
                    			<td data-title="年度："><?=$value['d_year']?></td>
                                <td data-title="月份："><?=$value['d_month']?></td>
                                <td data-title="營業額：">¥<?=$value['turnover']?></td>
                                <td data-title="活躍資格：">
                    			<?if($value['d_is_active']=='N'){?>
                    				<i class="icon-x"></i> 
                    			<?}else{?>
                    				<i class="icon-checkmark"></i> 
                    			<?}?>
                                <a href="/products" class="btn more"><?=$this->lang['buy'];//繼續購買?></a></td>
                            </tr>
				      		<?php endforeach; ?>
				      	<?php endif; ?>
                        </tbody>
                    </table>

				</section>
			</div>
		</main>