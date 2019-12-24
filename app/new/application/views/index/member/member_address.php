				<section class="content has-side">
					<div class="title"><?=$this->lang['commonaddress'];//常用寄貨地址?></div>
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                                <th><?=$this->lang['recipient'];//收件者?></th>
                                <th><?=$this->lang['phone'];//電話?></th>
                                <th><?=$this->lang['address'];//地址?></th>
                                <th><?=$this->lang['modify'];//修改?></th>
                                <th><?=$this->lang['delete'];//刪除?></th>
                            </tr>
                        </thead>
                        <tbody>
                    	<?if(!empty($address)){?>
                            <?foreach ($address as $avalue):?>
                            <tr>
                                <td data-title="收件者："><?=$avalue['name']?></td>
                                <td data-title="電話："><?=$avalue['telphone']?></td>
                                <td data-title="地址："><?=$avalue['country'].$avalue['city'].$avalue['countory'].$avalue['address']?></td>
                                <td class="btn-holder"><a href="/gold/member_address_edit/<?=$avalue['d_id']?>" class="btn modify"><i class="icon-edit"></i></a></td>
                                <td class="btn-holder"><a href="/gold/data_AED/address/<?=$avalue['d_id']?>" class="btn delete"><i class="icon-trash-can"></i></a></td>
                            </tr>
                            <? endforeach;?>
                        <?}?>
                        </tbody>
                    </table>
                    <div class="pagination_box">
                        <a href="/gold/member_address_add" class="btn simple bg2"><?=$this->lang['add'];//新增地址?> <i class="icon-chevron-right"></i></a>
                    </div>
				</section>
			</div>
		</main>