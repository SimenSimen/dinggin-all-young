<section class="content has-side">
					<div class="title"><?=$this->lang['favorite'];?></div>
					<ul class="products-list list-h">
                        <?foreach ($favorite_data as $key => $value) {?>                         
                            <li class="item wow fadeIn" data-wow-delay="<?=$key*0.2+0.1?>s">
                                <div class="box">
                                    <input type="hidden" name="prd_id" id="prd_id<?=$value['prd_id'];?>" value="<?=$value['prd_id'];?>" ref="<?=$value['prd_id'];?>">
                                	<a class="btn delete" title="刪除此項目" id="delete<?=$value['prd_id'];?>" value="<?=$value['prd_id'];?>" ref="<?=$value['prd_id'];?>"><i class="icon-close"></i></a>

                                    <a href="/products/detail/<?=$value['prd_id'];?>">
                                        <figure class="pic"><img src="<?=$Spath;?>/<?=$value['prd_image'];?>" alt=""></figure>
                                        <div class="name"><?=$value['prd_name'];?></div>
                                        <div class="offers">¥<?=$value['prd_price00'];?></div>
                                    </a>
                                </div>
                            </li>
                        <? } ?>
                    </ul>
                    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
                    <?//暫不做頁碼=$page;?>
				</section>
			</div>
		</main>
<script>
    $(function() {
         $(".delete").click(function()
        {   
            var prd_id =$("#prd_id"+$(this).attr("ref")).val();
            ajax_delete(prd_id);
        });         

        function ajax_delete(prd_id){//刪除
              $.post("/favorite/ajax_delete",
                  {
                      prd_id:prd_id
                  },
                function(data,status){                     
                });               
                setTimeout("location.href='/favorite'",500);
            }
    });
</script>