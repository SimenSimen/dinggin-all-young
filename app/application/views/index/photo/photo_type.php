				<section class="content has-side">
					<div class="title"><?=$title?></div>
					<ul class="photo-list list-h">
			    	<?php if(!empty($list)): ?>
  			    	<?php foreach ($list as $key => $value): ?>
              <li id="prd_list_img">
                <div class="box">
  							<a href="/index/photo_detail/<?=$value['id']?>">
  									<figure class="pic"><img class="lazy" style="height: 10em;" src="<?=$value['first_img']?>" alt="<?=$value['name']?>"></figure>
  									<div class="name"><?=$value['name']?></div>
  							</a>
                </div>
              </li>
  			    	<?php endforeach; ?>
			    	<?php endif; ?>
          </ul>
				</section>
			</div>
		</main>
<style>
/* 活動花絮styling starts */
body.activity-body .fancybox-close {
    background: url(/js/fancyBox/source/fancybox_sprite.png);
    width: 44px;
    height: 40px;
    right: -20px;
    top:-20px;
}

.photo-list li {
  float: left;
  width: 33.33%;
  padding: 10px;
  text-align: center;
}

.photo-list li a .box .pic:after {
  content:"";
  position: absolute;
  width: 100%;
  height: auto;
  top:0;
  bottom: 0;
  left: 0;
  right: 0;
  opacity: 0;
  background: rgba(0,0,0,.2);
}

.photo-list li a:hover .box .pic:after {
  opacity: 1;
}

.photo-list li a .box .txt .name {
  line-height: 20px;
  height: 40px;
  overflow: hidden;
}

@media (max-width:480px) {
  .photo-list li {
    width: 50%;
  
  }
  
}
/* 活動花絮styling ends */
</style>