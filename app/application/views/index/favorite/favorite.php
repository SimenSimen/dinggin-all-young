<style>
    .product img {
      max-height: 100%;
      max-width: 100%;
      width: auto;
      height: auto;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;
    }
</style>
<section class="content has-side">
					<div class="title"><?=$this->lang_menu['favorite'];?></div>
					<ul class="products-list list-h">
                        <?foreach ($favorite_data as $key => $value) {?>                         
                            <li class="item wow fadeIn" data-wow-delay="<?=$key*0.2+0.1?>s">
                                <div class="box">
                                    <input type="hidden" name="prd_id" id="prd_id<?=$value['prd_id'];?>" value="<?=$value['prd_id'];?>" ref="<?=$value['prd_id'];?>">
                                	<a class="btn delete" title="<?=$this->lang['delete'];//刪除此項目?>" id="delete<?=$value['prd_id'];?>" name="<?=$value['prd_name'];?>" value="<?=$value['prd_id'];?>" ref="<?=$value['prd_id'];?>"><i class="icon-close"></i></a>
                                    <a href="/products/detail/<?=$value['prd_id'];?>">
                                        <figure class="pic product"><img class="lazy" src="<?=$Spath;?>/<?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></figure>
                                        <div class="name"><?=$value['prd_name'];?></div>
                                        <div class="offers"><?=$this->data['web_config']['currency'];?><?=$value['price'];?></div>
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
$(document).ready(function() {
    a=$('.pic.product').width();
    b=a*0.7511004784688;
    $('.pic.product').height(b);    
});
    $(function() {
         $(".delete").click(function()
        {               
            var prd_id =$("#prd_id"+$(this).attr("ref")).val();
            var name=$(this).attr('name');
            ajax_delete(prd_id,name);
        });

        function ajax_delete(prd_id,name){//刪除
            if(confirm("<?=$this->lang['q1'];?>"+name+"<?=$this->lang['q2'];?>")){//確定將[]移除我的最愛嗎?
              $.post("/favorite/ajax_delete",
                  {
                      prd_id:prd_id
                  },
                function(data,status){                     
                });               
                setTimeout("location.href='/favorite'",500);
            }
        }
    });
</script>