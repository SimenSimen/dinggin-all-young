				<section class="content has-side">
					<div class="title"><?=$this->lang['bdetail'];//獎金明細?></div>
                    
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                                <th><?=$this->lang['bname'];//獎金名稱?></th>
                         		<th><?=$this->lang['pv'];//PV值?></th>
                                <th><?=$this->lang['bonus'];//獎金?></th>
                                <th>擋佣</th>
                                <th align='left'><?=$this->lang['content'];//來源說明?></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<? foreach ($dbdata as $key => $value):?>
                            <tr>
                                <td data-title="佣金名稱：" nowrap><?=$value['d_type']?></td>
                                <td data-title="PV值：" nowrap><?=$value['d_pv']?></td>
                                <td data-title="佣金：" nowrap><?=$value['d_bonus']?></td>
                                <td data-title="擋佣：">否</td>
                                <td data-title="來源：" Style="text-align:left"><?=$value['d_content']?></td>
                            </tr>
                            <?endforeach;?> 
                        </tbody>
                    </table>
                    <p align="right"><?=$this->lang['total'];//獎金總計?><span class="color01">¥<?=number_format($itotal)?></span><?=$this->lang['tw'];//元?></p>
                    

                    <div class="pagination_box">
                        <a href="/gold/member_bonus" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> 回列表</a>
                    </div>
				</section>
			</div>
		</main>