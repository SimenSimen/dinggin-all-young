<style>
    @media (min-width:980px) {
      .prd_type {
        display: none;
      }
    }
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
                </aside>
                <link rel="stylesheet" type="text/css" href="/css/cart.css">
                <form action="/products/index" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="search_form">
                <section class="content has-side">
                    <? if($hot_list<>'Y'){?>
                    <div class="select-bar clearfix">
                        <div class="select-select-fix">
                            <div class="select-select">
                                <select class="form-control" name="prd_sort" id="prd_sort" style="margin-left:0;">
                                    <option<?=($_SESSION['prd_sort']=='prd_new')?' selected':'';?> value="prd_new"><?=$this->lang['p_new'];//最新商品?></option>
                                    <option<?=($_SESSION['prd_sort']=='price_decs')?' selected':'';?> value="price_decs"><?=$this->lang['p_high'];//價格高->低?></option>
                                    <option<?=($_SESSION['prd_sort']=='price_acs')?' selected':'';?> value="price_acs"><?=$this->lang['p_low'];//價格低->高?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <div style="float: right;">
						<a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share"<?}else{?> href="/share_link"  class="btn share fancybox-share"<?}?>><i class="icon-share2"></i><?=$this->lang['share_link'];?></a>
					</div>
                    <? if($this->style==2){?>
                        <div class="prd_type">
                            <aside class="side" style="display:block; opacity:1; width:100%;">
                                <ul class="side-nav list-v">
                                    <li style="text-align: center;"><?=($class_name)?$class_name:$this->lang['p_type'];?></li>
                                    <?=($this->data['web_config']['prd_class_img']==0)?$this->product_type:$this->product_type_img;?>
                                </ul>           
                            </aside>
                        </div>
                    <?}?>
                        <?if($_SESSION['select_prd_list']=='prd_list'){?>
                            <i class="fa fa-table" id="list_img" style="color:#aeaeb3; font-size:24px;cursor: pointer;"></i>
                            <i class="fa fa-list" id="list" style="color:#c79057; font-size:24px;cursor: pointer;"></i>
                        <?}else{?>
                            <i class="fa fa-table" id="list_img" style="color:#c79057; font-size:24px;cursor: pointer;"></i>
                            <i class="fa fa-list" id="list" style="color:#aeaeb3; font-size:24px;cursor: pointer;"></i>
                        <?}?>
                    <!--圖片顯示-->
                    <ul class="products-list list-h" <?=($_SESSION['select_prd_list']=='prd_list')?' style="display: none"':''?>>
                        <?php foreach ($dbdata as $key=>$value) {?>
                        <li id="prd_list_img">
                            <div class="box">
                                <a href="/products/detail/<?=$value['prd_id'];?>" title="<?=stripslashes($value['prd_name']);?>">
                                    <figure class="pic product">
                                        <img class="lazy" src="<?=(!empty($value['prd_image']))?'/uploads/000/000/0000/0000000000/products/'.$value['prd_image']:'/images/nodata.jpg';?>" alt="<?=stripslashes($value['prd_name']);?>">
                                    </figure>
                                    <div class="name"><?=stripslashes($value['prd_name']);?></div>
                                    <div class="offers"><?=$this->data['web_config']['currency'];?><?=$value['price'];?></div>
                                </a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <!--圖片顯示 end-->
                    <!--列表顯示-->
                    <div class="container" id="prd_list" <?=($_SESSION['select_prd_list']=='prd_list')?' style="padding:0;"':' style="display: none"'?>>
                            <table class="table table-h cart-table">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['p_name'];?></th>
                                <th><?=$value['priceName'];?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dbdata as $key=>$value) {?>
                                <tr>
                                    <td class="img">
                                        <a href="/products/detail/<?=$value['prd_id'];?>">
                                            <img class="lazy" src="<?=(!empty($value['prd_image']))?'/uploads/000/000/0000/0000000000/products/'.$value['prd_image']:'/images/nodata.jpg';?>" alt="<?=stripslashes($value['prd_name']);?>">
                                        </a>
                                    </td>
                                    <td class="info align-left">
                                        <a href="/products/detail/<?=$value['prd_id'];?>"><span class="pd-name"><?=stripslashes($value['prd_name']);?></span><br><?=(!empty($value['prd_describe']))?mb_substr($value['prd_describe'],1,10,"UTF-8").'...':'';?></a>
                                    </td>
                                    <td data-title="金額："><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
                                </tr>
                            <?}?>
                        </tbody>
                    </table>
                    </div>
                    <!--列表顯示 end-->
                    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
                    <input type="hidden" name="pid" id="pid" value="<?=$pid?>">
                    <?=$page;?>
                </section>
                </form>
            </div>
        </main>        
<script>
$(document).ready(function() {
    a=$('.pic.product').width();
    b=a*0.7511004784688;
    $('.pic.product').height(b);

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
    var i_val = "jecp://<?=$share_prd_image?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_url=<?=$share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}

//切換瀏覽方式
$(function(){
    $("#list_img").click(function(){
        $('#list_img').attr("style","color:#c79057;font-size: 24px;cursor: pointer;");
        $('#list').attr("style","color:#aeaeb3;font-size: 24px;cursor: pointer;");
        $('#prd_list').attr("style","display: none");
        $('.products-list').attr("style","display: block");        
        a=$('.pic.product').width();
        b=a*0.7511004784688;
        $('.pic.product').height(b);

        $.post("/products/ajax_prd_list",
          { 
              list:'prd_list_img'
          });
  });
    $("#list").click(function(){
        $('#list').attr("style","color:#c79057;font-size: 24px;cursor: pointer;");
        $('#list_img').attr("style","color:#aeaeb3;font-size: 24px;cursor: pointer;");
        $('.products-list').attr("style","display: none");
        $('#prd_list').attr("style","display: block;  padding:0;");
        $.post("/products/ajax_prd_list",
          { 
              list:'prd_list'
          });
  });
});

//排序
$("#prd_sort").change(function () {
    $.ajax({
        type: "post",
        url: '/products/prd_sort',
        cache: false,
        data: {
            sort: $("#prd_sort").val()
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });
});
</script>