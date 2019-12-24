				<section class="content has-side">
					<div class="title"><?=$title?></div>
                     <? foreach ($dbdata as $key => $value):?>
					 <table class="table table-h table02 table03">
                        <thead>
                            <tr>
                                <th><?=$this->lang['yearmon'];//年月?></th>
                                <th>期數</th>
                                <th><?=$this->lang['one'];//一代獎金?></th>
                                <th><?=$this->lang['two'];//二代獎金?></th>
								<th><?=$this->lang['family'];//體系獎金?></th>
                                <th><?=$this->lang['deafult'];//其它?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-title="年月："><?=$value['date']?></td>
                                <td data-title="期數："></td>
                                <td data-title="一代獎金："><?=number_format($value['bonus01'])?></td>
                                <td data-title="二代獎金："><?=number_format($value['bonus02'])?></td>
								<td data-title="體系獎金："><?=number_format($value['bonus03'])?></td>
                                <td data-title="其他："><?=number_format($value['bonus04'])?></td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                    			<th><?=$this->lang['total'];//原佣總計?></th>
                                <th><?=$this->lang['sub'];//扣款?></th>
                                <th><?=$this->lang['tax'];//所得稅?></th>
                                <th><?=$this->lang['icote'];//2代健保補充保費?></th>
                                <th><?=$this->lang['itotal'];//總計佣金總計（稅後佣金）?></th>
                                <th><?=$this->lang['option'];//操作檢視?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                    			<td data-title="原佣總計："><?=number_format($value['iOTotal'])?></td>
                                <td data-title="扣款："><?=number_format($value['bonus05'])?></td>
                                <td data-title="所得稅："><?=$value['itax']?></td>
                                <td data-title="補充保費："><?=$value['i2nhi']?></td>
                                <td data-title="佣金總計（稅後佣金）："><?=number_format($value['iTotal'])?></td>
                                 <td class="btn-holder">
                                    <a href="/gold/member_bonus_detail/<?=$value['date']?>" class="btn more"><i class="icon-search"></i> <?=$this->lang['detail'];//明細?></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?endforeach;?>
				</section>
			</div>
		</main>