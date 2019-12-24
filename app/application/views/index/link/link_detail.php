				<section class="content has-side">
                    <? if(!empty($this->style==2)){?>
                    <div class="link_type">
                        <aside class="side" style="display:block; opacity:1; width:100%;">
                            <div class="nice-select">
                            <span class="current"><a href="#"> </a></span>
                                <ul class="side-nav list-v">
                                    <?php if(!empty($list)): ?>
                                        <?php foreach ($list as $key => $value): ?>
                                            <?if($value['id']==$category_id){?>
                                                <li class="active select"><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
                                            <?}else{?>
                                                <li><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
                                            <?}?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </aside>
                    </div>
                    <?}?>
					<div class="title">友善連結</div>
					<div class="share"><a href="include_share.php" class="btn share fancybox-share"><i class="icon-share2"></i></a></div>
					
					<div class="share-detail">
					<div class="name">文章一</div>
					<div class="editor">
						即日起~2015/3/31，於線上門市購買17周年限定商品，即可獲得好友分享券一張，讓您與好友跟星巴克一起同慶。

 （贈品數量有限，送完為止）
						
					</div>
					
                    <div class="pagination_box">
                    <a href="link" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> 回列表</a>
                    </div>
                    </div>
				</section>
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
</script>
<style>
    @media (min-width:980px) {
      .link_type {
        display: none;
      }
    }
</style>        
