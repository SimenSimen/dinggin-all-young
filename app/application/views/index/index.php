			<div class="container">
                <div class="row clearfix">
                    <!--
                    <div class="home-box-1">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['news'];//農業關懷?></div>
                        <ul class="clearfix">
                            <?foreach($news0 as $val_n0){?>
                                <li>
                                    <a href="/index/content_detail/news/<?=$val_n0['category_id']?>/<?=$val_n0['enews_id'];?>">
                                        <figure>
                                            <img class="lazy pic" src="<?=$news_path;?><?=$val_n0['filename'];?>">
                                            <figcaption>
                                                <h1><?=$val_n0['name'];?></h1>
                                                <p><?=strip_tags($val_n0['content']);?></p>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                    -->
                    <div class="home-box-1">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['products_type'];//主題推薦?></div>
                        <ul class="clearfix">
                            <?foreach($prd_class as $val_prd){?>
                                <li>
                                    <a href="/products/<?=$val_prd['prd_cid'];?>">
                                        <figure>
                                            <img class="lazy pic" src="<?=$prd_class_path;?><?=$val_prd['prd_cimage'];?>">
                                            <figcaption>
                                                <h1><?=$val_prd['prd_cname'];?></h1>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                    <div class="home-box-2">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['service'];//最新消息?></div>
                        <ul class="news-list clearfix">
                            <?foreach($news1 as $val_n1){?>
                                <li class="wow fadeIn clearfix">
                                    <a class="clearfix" href="/index/news_detail/<?=$val_n1['ck_id'];?>">
                                        <figure class="left clear">
                                            <figcaption class="left clear">
                                                <h2 class="left eth_word"><?=$val_n1['name'];?></h2>
                                                <span class="time right"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=substr($val_n1['create_time'],0,10);?></span>
                                            </figcaption>
                                        </figure>
                                        <span class="left clear eth_txt eth_word"><?=strip_tags($val_n1['content']);?></span>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            <!--
                <div class="row clearfix">
                    <div class="home-box-1">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['products_type'];//主題推薦?></div>
                        <ul class="clearfix">
                            <?foreach($prd_class as $val_prd){?>
                                <li>
                                    <a href="/products/<?=$val_prd['prd_cid'];?>">
                                        <figure>
                                            <img class="lazy pic" src="<?=$prd_class_path;?><?=$val_prd['prd_cimage'];?>">
                                            <figcaption>
                                                <h1><?=$val_prd['prd_cname'];?></h1>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                    <div class="home-box-3">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['aesthetic'];//美學生活?></div>
                        <ul class="news-list clearfix">
                            <?foreach($news2 as $val_n2){?>
                                <li>
                                    <a class="clearfix" href="/index/content_detail/aesthetic/<?=$val_n2['category_id']?>/<?=$val_n2['enews_id'];?>">
                                        <figure class="left">
                                            <img class="left lazy" src="<?=$news_path;?><?=$val_n2['filename'];?>">
                                            <figcaption class="left">
                                                <h2 class="left eth_word"><?=$val_n2['name'];?></h2>
                                                <p class="left clear"><?=strip_tags($val_n2['content']);?></p>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            -->
                <div class="container">
                    <div class="related-box">
                        <div class="title"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?=$this->lang_menu['products_hot'];//好物精選?></div>
                        <div class="related-slider">
                            <ul class="products-list list-h">
                                <?foreach($prd_data as $prd_val){
                                    $prd_image=explode(',',$prd_val['prd_image']);?>
                                    <li>
                                        <div class="box">
                                            <a href="/products/detail/<?=$prd_val['prd_id'];?>">
                                            <figure class="pic"><img class="lazy" src="<?=$prd_path;?><?=$prd_image['0'];?>" alt="<?=$prd_val['prd_name'];?>"></figure>
                                            <div class="name"><?=$prd_val['prd_name'];?></div>
                                            <div class="offers"><?=$this->data['web_config']['currency'];?><?=($d_spec_type==0)?$prd_val['prd_price00']:$prd_val['d_mprice']?></div>
                                            <div class="border one"></div>
                                            </a>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                </div>
			</div>
		</main>
<script>
$(document).ready(function() {
    $('.products-list').slick({
      dots: false,
      arrows: true,
      infinite: true,
      speed: 300,
      slidesToShow: 6,
      slidesToScroll: 6,
      dotsClass: 'slick-dots list-inline',
      responsive: [
        
        {
          breakpoint: 601,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
        },
        {
          breakpoint: 426,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
      ]
    });
});
</script>