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
       </aside>
       <div class="lightbox-wrapper container">
       <section class="content">    
          <form id="prd_search" method="get" action="/products/search_engine" onsubmit="return prd_check(this)">
            <? if(!empty($search_key)){?>
            <div class="form-group">
              <label class="control-label required"><?=$this->lang['psear_1'];//排序方式?></label>
              <div class="select-select">
                <select class="form-control" name="prd_sort" id="prd_sort">
                  <option <?=($_SESSION['prd_sort']=='prd_new')?' selected':'';?> value="prd_new"><?=$this->lang['psear_2'];//最新商品?></option>
                  <option <?=($_SESSION['prd_sort']=='price_decs')?' selected':'';?> value="price_decs"><?=$this->lang['psear_3'];//價格高->低?></option>
                  <option <?=($_SESSION['prd_sort']=='price_acs')?' selected':'';?> value="price_acs"><?=$this->lang['psear_4'];//價格低->高?></option>
                </select>
                <select class="form-control" style="visibility:hidden;"></select>
              </div>
            </div>
            <?}?>
            <div class="form-group">
              <label class="control-label required"><?=$this->lang['psear_5'];//產品類別?></label>
                <div class="select-select">
                  <select class="form-control" name="type1" id="type1">
                    <option value="0"><?=$this->lang['psear_6'];//未選擇?></option>
                    <? foreach ($prd_type1 as $key => $value) {?>
                      <option value="<?=$value['prd_cid'];?>" <?=($post_type1==$value['prd_cid'])?' selected':''?> ><?=$value['prd_cname'];?></option>
                    <?}?>
                  </select>
                </div>
                <div class="select-select type2_div">
                <? if(!empty($prd_type2)){?>
                  <select class="form-control" name="type2" id="type2">
                  <? foreach ($prd_type2 as $key => $value) {?>
                      <option value="<?=$value['prd_cid'];?>" <?=($post_type2==$value['prd_cid'])?' selected':''?> ><?=$value['prd_cname'];?></option>                  
                  <?}?>
                  </select>
                <?}else{?>
                  <select class="form-control" style="visibility:hidden;"></select>
                <?}?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label required"><?=$this->lang['psear_7'];//價格區間?></label>
              <div class="control-box">
                <div class="input-group">
                  <input class="form-control" type="text" name="price_start" id="price_start" placeholder="<?=$this->lang['psear_8'];//最低價?>" value="<?=$price_start;?>"> <?=$this->lang['psear_9'];//至?>
                  <input class="form-control" type="text" name="price_end" id="price_end" placeholder="<?=$this->lang['psear_10'];//最高價?>" value="<?=$price_end;?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="search-box">
                <input name="search_key" <? if(!empty($_SESSION['MT']['by_id'])){?> id="search_key"<?}?> type="text" class="form-control input" placeholder="<?=$this->lang['ikeyword'];//請輸入關鍵字?>" value="<?=$search_key?>" autocomplete="off">
                <a class="prd_aa6 search" href="javascript:void(0);"><i class="icon-search"></i><?/*=$this->lang['strsearch'];*///搜尋?></a>
              </div>
            </div>


            <div class="form-group" id="search_his" style="width: 80%; display: none;">
              <div id="search_list" class="search-box">
                <?for ($i=1; $i < 11; $i++) {
                    if(!empty($search_history['search'.$i])){?>
                    <input name="search_his_list" id="search_his_list" class="form-control input search_his_list" type="button" class="form-control input" value="<?=$search_history['search'.$i];?>" style="width: 80%; display:inline;">
                  <?}
                }?>
                <input name="search_key" id="del_search" type="button" class="form-control input" value="<?=$this->lang['psear_11'];//清除搜尋紀錄?>" style="width: 80%; display:inline;">
              </div>
            </div>


            
          </form>
        <!--結果-->
        <?php if($search_key && $tips != 'fail'):?>
            <div class="search-box"><h3><?=$this->lang['keyword'];//關鍵字?>：<?=$search_key?></h3></div>
        <?php endif; ?>
            <ul class="products-list list-h">
            <?php if($search_result):?>
            <?php foreach ($search_result as $key => $value):?>
               <li class="item wow fadeIn">
                 <div class="box">
                   <a href="/products/detail/<?=$value['prd_id']?>">
                    <figure class="pic product">
                      <img class="lazy" src="<?=(!empty($value['prd_image']))?$img_url.$value['prd_image']:'/images/nodata.jpg';?>" alt="<?=$value['prd_name']?>"/>
                    </figure>
                    <div class="name"><?=$value['prd_name']?></div>
                    <div class="offers"><?=$value['priceName']?>:<?=$this->data['web_config']['currency'];?><?=$value['price']?></div>
                   </a>
                  </div>
               </li>
            <?php endforeach;?>
          <?php endif;?>
            </ul>
            <? if($search_key && $tips=='fail'){?>
                <?=$this->lang['psear_12'];//抱歉,找不到關於?><strong><?=$search_key;?></strong><br><?=$this->lang['psear_13'];//試著更換篩選條件?>
            <?}?>
        </section>
      </div>    
    </div>
 </main>
<!--橫幅選單-->
<link rel="stylesheet" type="text/css" href="/css/bootstrap-horizon.css" />
<!--展開收合-->

<script type="text/javascript">
$(document).ready(function() {
    a=$('.pic.product').width();
    b=a*0.7511004784688;
    $('.pic.product').height(b);
});
    $(function() {
      $(".prd_aa6").click(function(){
        // if($('#search_key').val()==''){
          //alert("<?//=$this->lang['psear_14'];//未輸入搜尋商品?>");  
          // return false;
        // }else{
          document.getElementById("prd_search").submit();
        // }
      })

      $("#search_key").click(function(){
        $("#search_his").slideToggle('3000');
      })        

      $("#del_search").click(function(){
         $.ajax({
          url:"/products/ajax_del_search",
          success:function(data){
            $("#search_list").attr("style","display: none;");
          }
        });//end ajax  
      })

      $(".search_his_list").click(function(){
        var val=$(this).val();
        $("#search_key").val(val);
      })

    });

    function prd_check(frm)
     {
        if(frm.elements['search_key'].value==''){
          alert("<?=$this->lang['psear_14'];//未輸入搜尋商品?>");  
          return false;
        }
     }
$(document).on('change', '#type1', function(){  
  var prd_cid = $('#type1 :selected').val();//注意:selected前面有個空格！
  var prd_sub_cid = '<?=$dbdata['prd_sub_cid']?>';
    $.ajax({
        url:"/products/ajax_search",       
        method:"POST",
        data:{
           prd_cid:prd_cid,
           prd_sub_cid:prd_sub_cid
        },      
        success:function(data){     
          $('.type2_div').html(data);
        }
     });//end ajax  
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