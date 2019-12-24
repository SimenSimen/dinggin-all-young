</aside>
    <section class="content has-side">                  
        <div class="share"><a <?if(!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share" <?}else{?> href="/share_link" class="btn share fancybox-share"<?}?> ><i class="icon-share2"><?=$this->lang['share_link'];?></i></a></div>  
                <div class="products-intro clearfix pdt-details-fix">
                        <div class="gallery">
                            <figure class="pic"><img src="/uploads/000/000/0000/0000000000/products/<?=$dbdata['prd_image'];?>" alt=""></figure>
                        </div>
                        <div class="pd-intro">
                            <h1 class="pd-name" itemprop="name"><?=$dbdata['prd_name']?></h1>
                            <div class="pd-info-box">
                                <div class="form-group">
                                    <label class="control-label"><?=$this->lang['p_market_price'];?>:</label>
                                    <div class="control-box"><del><?=$dbdata['prd_price01']?></del></div>
                                </div>
                                <div class="pd-info">
                                    <div class="pd-info-label"><?=$this->lang['p_get'];?>:<?=$this->lang['p_bonu'];?><span class="color01"><?=$bonus?><?=$this->lang['p_point'];?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?=$this->lang['p_num'];//數量?>:</label>
                                    <div class="control-box qty-box">
                                        <input type="button" class="btn add" onClick="qtyUp()" value="＋"/>
                                        <input type="number" name="qty" id="qty" class="qty form-control" value="1">
                                        <input type="button" class="btn less" onClick="qtyDown()" value="－" />
                                    </div>
                                </div>
                                <? if($this->data['web_config']['cart_spec_status']==1){ //選擇規格?>
                                <div class="form-group">
                                    <label class="control-label"><?=$this->lang['p_specification'];?>:</label>
                                    <div class="control-box">                                        
                                        <select name="spec" id="spec" class="form-control" >
                                        <?  foreach ($prd_specification_content as $key => $value) {
                                                if(!empty($value)){                                ?>
                                                    <option value="<?=$value;?>"><?=$value;?></option>
                                        <?      }//if
                                            }//foreach?>
                                        </select>
                                    </div>
                                </div>
                                <?}?>
                                <div class="form-group">
                                    <label class="control-label"><?=$priceName;?></label>
                                    <div class="control-box"><span class="color01"><?=$this->data['web_config']['currency'];?><?=$price;?></span></div>
                                </div>
                            </div>
                            <div class="btn-group clearfix">
                                <a href="javascript: <?=$isJoinJs;?>" class="btn addcart" <?=$isJoin;?> ><i class="icon-shopping-cart"></i> <?=$isJoinName;//加入購物車?></a>
                                <a href="/cart" class="btn buynow"><i class="icon-credit-cards"></i> <?=$this->lang['p_check'];//現在結帳?></a> 
                                <a href="javascript: like_id()" id="like1" class="btn wish" <?=$isFavorite;?>><i class="icon-like"></i>
                                    <?=$isFavoriteName;?>
                                </a>
                                <a <?if(!empty($this->session->userdata['isapp'])){?>  onclick="getShareEncode3()" class="btn p_share"<?}else{?> href="/share_link" class="btn p_share fancybox-share"<?}?> ><i class="icon-share2"></i> <?=$this->lang['p_share'];//我要分享?></a> 
                            </div>
                        </div>                       
                    </div>
                    <div class="products-detail clearfix">
                        <div class="title"><?=$this->lang['p_describe'];?></div>
                        <article class="editor clearfix">
                        <?  foreach ($prd_describe as $value) {
                            echo $value.'<br>';
                        }?>
                        <div id="tabwrap">
                            <ul id="tabs" class="list-h">
                                <li class="current"><a href="#page1"><?=$this->lang['p_content'];?></a></li>
                                <li><a href="#page2"><?=$this->lang['p_spec'];?></a></li>
                                <li><a href="#page3"><?=$this->lang['p_buy'];?></a></li>
                                <li><a href="#page4"><?=$this->lang['p_ship'];?></a></li>
                            </ul>
                        </div>
                        <!-- TAB 内容 -->
                        <div id="content">
                            <div id="page1" class="animated current">
                                <?=$dbdata['prd_content']?>
                                <?foreach ($prd_video_name as $key => $value) {
                                    if($value<>''){
                                        echo '<br><br><br><br><br>'.$value.':<br>';                                        ?>
                                        <iframe width="100%" height="400" src="<?=str_replace('watch?v=','embed/',$prd_video_link[$key]);?>?rel=0&hd=1&vq=hd720" frameborder="0" allowfullscreen></iframe>
                                        <? echo '<br>';
                                    }//if
                                }//foreach?>
                            </div>
                            <div id="page2" class="animated">
                                <table>                                
                                    <?  foreach ($prd_specification_content as $key => $value) {
                                        echo '<tr><td>'.$prd_specification_name[$key].$value.'</td></tr>';
                                    }?>
                                </table>                                
                            </div>
                            <div id="page3" class="animated">
                                <?=$buy_content;?>
                            </div>
                            <div id="page4" class="animated">
                                <?=$ship_rule;?>
                            </div>
                        </div>
                        </article>
                    </div>
                    <div class="related-box">
                        <div class="title"><?=$this->lang['p_like'];?></div>
                        <div class="related-slider">
                            <ul class="products-list list-h">
                                <?php foreach ($dbdataLike as $key=>$value) {?>
                                <li class="item wow fadeIn" data-wow-delay="<?=$key*0.2+0.1?>s">
                                    <div class="box">
                                        <a href="/products/detail/<?=$value['prd_id'];?>">
                                            <figure class="pic"><img src="/uploads/000/000/0000/0000000000/products/<?=$value['prd_image'];?>" alt=""></figure>
                                            <div class="name"><?=$value['prd_name'];?></div>
                                            <div class="offers"><?=$this->data['web_config']['currency'];?><?=($d_spec_type==1)?$value['d_mprice']:$value['prd_price00'];?></div>
                                        </a>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="pagination_box">
        				<script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
            			<div id="qrcodeCanvas"></div>
            			<script>
                			jQuery('#qrcodeCanvas').qrcode({ width : 240, height : 240, text : "http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"}); 
            			</script>
                    </div>
                    <div class="pagination_box">
                        <a href="/products/<?=$dbdata['prd_cid'];?>" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i> <?=$this->lang['p_back'];?></a>
                    </div>
                    <input type="hidden" id="product_id" value="<?=$dbdata['prd_id'];?>">
                </section>
            </div>
        </main>        
<script>
$(document).ready(function() {
    $('.fancybox-arrival').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'products-arrival-advice',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
    $('.products-list').slick({
      dots: false,
      arrows: true,
      infinite: true,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      dotsClass: 'slick-dots list-inline',
      responsive: [
        
        {
          breakpoint: 601,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
        },
        {
          breakpoint: 401,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        },
      ]
    });
});
$(function(){    
    $('#tabs li a').click(function(e){     
        $('#tabs li, #content .current').removeClass('current').removeClass('fadeInLeft');
        $(this).parent().addClass('current');
        var currentTab = $(this).attr('href');
        $(currentTab).addClass('current fadeInLeft');
        e.preventDefault();     
    }); 
});
</script>
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

//購物車
function join_car(){
    var product_id =$("#product_id").val();
    var shop_count =$("#qty").val();
    var spec       =$("#spec").val();
    ajax_car(product_id,shop_count,spec);
}
function ajax_car(product_id,shop_count,spec){
    $.post("/products/ajax_car",
        {
          product_id:product_id,
          shop_count:shop_count,
          spec      :spec
        },
        function(data){
            if(data=='已加入購物車'){      
                // alert("<?=$this->lang['p_carok'];?>");
                $(".addcart").attr("style","background: #000;");
                $('.addcart').html("<i class='icon-shopping-cart'></i> <?=$this->lang['p_delcar'];?>");                 
                $('.addcart').attr("href","javascript: demit_car(0)");
            }
            if(data=='請選擇購買數量'){
                alert("<?=$this->lang['p_carnum'];?>");
                qty.focus();
                return false;  
            }
            if(data=='請登入'){
                alert("<?=$this->lang['Login'];?>");
                location.href ="/gold/login";
            }
        }
    );
}
//移除購物車
function demit_car(){    
    var product_id =$("#product_id").val();
    var spec =$("#spec").val();
      $.post("/products/ajax_demitcar",
        {
          product_id:product_id,
          spec:spec,
        },
        function(data){
               $(".addcart").attr("style","background: #c9b38f;");
               $('.addcart').html("<i class='icon-shopping-cart'></i> <?=$this->lang['p_car'];?>");               
               $('.addcart').attr("href","javascript: join_car(0)");
        }
    );
}
// 規格與購物車連動
$(function() {
    $("#spec").click(function(){
        var spec =$("#spec").val();
        var product_id =$("#product_id").val(); //alert(product_id+'##*'+spec);
        var join_car_arr =<? echo json_encode($_SESSION['join_car']);?>;        
        if(join_car_arr[product_id+'##*'+spec]>0){//此規格已經加入購物車
            $(".addcart").attr("style","background: #000;");
            $('.addcart').html("<i class='icon-shopping-cart'></i> <?=$this->lang['p_delcar'];?>");                 
            $('.addcart').attr("href","javascript: demit_car(0)");
        }else{//此規格沒加入購物車
            $(".addcart").attr("style","background: #c9b38f;");
            $('.addcart').html("<i class='icon-shopping-cart'></i> <?=$this->lang['p_car'];?>");               
            $('.addcart').attr("href","javascript: join_car(0)");
        }
    });
});

// favorite
function like_id(){
    var product_id = $("#product_id").val();//主商品ID
  $.post("/products/ajax_favorite",
        {
          product_id:product_id,
        },
        function(data,status){
            if(data=='1'){
                $("#like1").attr("style","");
                $('#like1').html("<i class='icon-like'></i><?=$this->lang['p_unlike'];?>");
            }
            if(data=='2'){
                $("#like1").attr("style","background: #D96893;border:1px solid #a5a5a5;color: #fff;");
                $('#like1').html("<i class='icon-like'></i><?=$this->lang['p_islike'];?>");
            }
            if(data=="login"){
                alert("<?=$this->lang['p_login_like'];?>");//登入才可加入最愛
                location.href ="/gold/login";
            }
        }
    );
}
//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$share_url?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_img=<?=$share_prd_image;?>';
    var i_val = "jecp://<?=$share_prd_image;?>&ecp_title=<?=$share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>
<!-- 加減-->
<script type="text/javascript" src="/js/quantity_box_button_down.js"></script>