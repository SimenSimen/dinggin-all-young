            <div class="banner wow fadeInLeftBig">
                <ul class="bxslider">
                    <?foreach ($banner as $banner_val) {?>
                		<?if($banner_val["content"]!=""){?>
                        	<li class="pic full"><a href='<?=$banner_val["content"]?>'><img src="/uploads/000/000/0000/0000000000/banner/<?=$banner_val["filename"]?>" alt="<?=$banner_val["name"]?>"></a></li>
                        <?}else{?>
                        	<li class="pic full"><img src="/uploads/000/000/0000/0000000000/banner/<?=$banner_val["filename"]?>" alt="<?=$banner_val["name"]?>"></li>
                        <?}?>
                    <?}?>
                </ul>
            </div>