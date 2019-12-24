                </aside>
                <form action="/products/index" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
				<section class="content has-side">
					<div class="share"><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share"<?}else{?> href="/share_link"  class="btn share fancybox-share"<?}?>><i class="icon-share2"><?=$this->lang['share_link'];?></i></a></div>
					<ul class="products-list list-h">
                        <?php foreach ($dbdata as $key=>$value) {?>
                        <li class="item wow fadeIn" data-wow-delay="<?=$key*0.2+0.1?>s">
                            <div class="box">
                                <a href="/products/detail/<?=$value['prd_id'];?>">
                                    <figure class="pic"><img src="/uploads/000/000/0000/0000000000/products/<?=$value['prd_image'];?>" alt=""></figure>
                                    <div class="name"><?=$value['prd_name'];?></div>
                                    <div class="offers"><?=$this->data['web_config']['currency'];?><?=$value['price'];?></div>
                                </a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
                    <input type="hidden" name="pid" id="pid" value="<?=$pid?>">
                    <?=$page;?>
                    <!--<div class="pagination_box">
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
                    </div>-->
				</section>
				</form>
			</div>
		</main>
		
<script>
$(document).ready(function() {
    $('.fancybox-share').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
    
});

//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$share_url?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_img=<?=$share_prd_image;?>';
    var i_val = "jecp://<?=$share_prd_image?>&ecp_title=<?=$share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>
