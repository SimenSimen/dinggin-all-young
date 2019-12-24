            <div class="banner wow fadeInLeftBig">
                <ul class="bxslider">
                    <?foreach ($banner as $banner_val) {?>
                		<?if($banner_val["content"]!=""){?>
                        	<li class="pic full"><a href='<?=$banner_val["content"]?>' title="<?=$banner_val["name"]?>" target="<?=($banner_val["jump_page"]=="Y")?"_blank":"_self";?>"><img src="/uploads/000/000/0000/0000000000/banner/<?=$banner_val["filename"]?>"></a></li>
                        <?}else{?>
                        	<li class="pic full"><img src="/uploads/000/000/0000/0000000000/banner/<?=$banner_val["filename"]?>"></li>
                        <?}?>
                    <?}?>
                </ul>
            </div>