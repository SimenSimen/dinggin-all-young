<link rel="stylesheet" type="text/css" href="/css/cart.css">
<div class="container">
				<section class="content">
					<div class="title"><?=$this->lang['cart'];//購物車?></div>
					<form  id="myform" method='post'>
                    <table class="table table-h cart-table">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['c_name'];//商品名稱?></th>
                                <th><?=$this->lang['c_price'];//金額?></th>
                                <th><?=$this->lang['c_num'];//數量?></th>
                                <th><?=$this->lang['c_sum'];//小計?></th>
                                <th><?=$this->lang['c_delete'];//刪除?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($productList as  $key=>$value) {?>
                            <tr>
                                <td class="img">
                                    <a href="/products/detail/<?=$value['prd_id'];?>" class="pic"><img src="<?=$Spath;?>/<?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></a>
                                </td>
                                <td class="info align-left">
                                    <a href="/products/detail/<?=$value['prd_id'];?>">
                                        <span class="pd-name"><?=$value['prd_name'];?>
                                           <?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['spec_name'].')':'';?>
                                        </span>
                                        <input type="hidden" name="prd_id" id="prd_id<?=$value['spec_rename'];?>" value="<?=$value['spec_rename'];?>" ref="<?=$value['spec_rename'];?>">
                                    </a>
                                </td>
                                <td data-title="金額："><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
                                <td data-title="數量：">
                                    <div class="qty-box">
                                        <!--<input type="button" class="btn less" onClick="qtyDown()" value="－" />-->
                                        <input onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" type="number" min="0" max="10" name="qty" id="qty<?=$value['spec_rename'];?>" class="qty form-control" value="<?=$value['num'];?>" ref="<?=$value['spec_rename'];?>" style="width:170%">
                                        <!--<input type="button" class="btn add" onClick="qtyUp()" value="＋">-->
                                    </div>
                                </td>
                                <td data-title="小計：">
                                    <?=$this->data['web_config']['currency'];?><label id="total_single_<?=$value['spec_rename'];?>"><?echo $total_single = ((empty($value['total']))?"0":$value['total'])?></label>
                                </td>
                                <td><a class="delete btn" id="delete<?=$value['spec_rename'];?>" value="<?=$value['spec_rename'];?>" ref="<?=$value['spec_rename'];?>"><i class="icon-trash-can"></i></a>
                                </td>
                            </tr>
                            <? }?>
                        </tbody>
                    </table>
                    <div class="sum-box">
                        <table class="table table-h sum-table">
                            <tfoot>
                                <tr>
                                    <td><?=$this->lang['c_20'];//現金?></td>
                                    <td><?=$this->data['web_config']['currency'];?><span id="only_money"></span></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['c_19'];//使用紅利?></td>
                                    <td><input type="number" min="0" max="<?=$d_dividend;?>" name="use_dividend" id="use_dividend" class="use_dividend form-control" value="0"></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['c_total'];//訂單總計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><span id="total_money"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?=$this->lang['c_26'];//目前積點： 紅利?><span class="color01"><?=$d_dividend;?><?=$this->lang['c_27'];//點?></span><!--，樂活<span class="color01">100點</span>--></td>
                                </tr>
                                <!--<tr>
                                    <td colspan="2">累計積點： 紅利<span class="color01">400點</span>，樂活<span class="color01">50點</span></td>
                                </tr>-->
                                <tr>
                                    <td colspan="2"><?=$this->lang['c_28'];//本次購買可再護得:紅利?><span class="color01"><span id="total_bonus"></span><?=$this->lang['c_27'];//點?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>                    
                    <div class="title"><?=$this->lang['c_1'];//運送 & 付款資訊?></div>
                    <div class="shopping-form">
                        <div class="row">
                            <div class="col col1">
                                <div class="shopping-title"><?=$this->lang['c_2'];//收件人資訊?></div>
                                <div class="form-box02">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="checkbox" name="gender" id="somemember"> <?=$this->lang['c_3'];//收件人同訂購人資料?></label>
                                        <!--<label class="form-radio"><input type="radio" name="gender" id=""> 常用地址</label>-->
                                    </div>

                                    <div class="form-group">
                                        <div class="input-box">
                                            <?if(!empty($address)){?>
                                            <select name="select_address" id="select_address" class="form-control">
                                                <option value="0"><?=$this->lang["c_25"];//常用地址?></option>            
                                                <?foreach ($address as $avalue):?>
                                                    <option value="<?=$avalue['d_id'];?>"><?=$avalue['country'].$avalue['city'].$avalue['countory'].$avalue['address']?></option>   
                                                <? endforeach;?>
                                            </select>
                                            <?}?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_4'];//姓名?></label>
                                        <div class="control-box">
                                            <input class="form-control" type="text" name="buyer_name" id="buyer_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_email'];//email?></label>
                                        <div class="control-box">
                                            <input class="form-control" type="text" name="buyer_email" id="buyer_email">
                                        </div>
                                    </div>
                                    <div class="form-group address">
                                        <label class="control-label"><?=$this->lang['c_5'];//聯絡地址?></label>
                                        <div class="control-box">
                                            <div class="input-group">

                                                <div class="input-box" id="country_select">
                                                    <!--<select name="country" id="country" onChange='sel_area(this.value,"","city")' class="form-control">-->
                                                        <select name="country" id="country" onchange="sel_area(this.value,'','city')" class="form-control">
                                                        <option value="0"><?=$this->lang["c_22"]//請選擇國家;?></option>
                                                        <?foreach ($country as $cvalue):?>
                                                            <option value="<?=$cvalue['s_id']?>"><?=$cvalue['s_name']?></option>  
                                                        <? endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="input-box" id="city_select">
                                                    <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control">
                                                        <option value="0"><?=$this->lang["c_23"]//請選擇縣市;?></option>
                                                        <?foreach ($city as $cvalue):?>
                                                            <option value="<?=$cvalue['s_id']?>"><?=$cvalue['s_name']?></option>  
                                                        <? endforeach;?>
                                                    </select>
                                                </div>

                                                <div class="input-box" id="countory_select">
                                                    <select name="countory" id="countory" class="form-control">
                                                        <option value="0"><?=$this->lang["c_24"]//請選擇鄉鎮;?></option>
                                                    </select>
                                                </div>
                                                <div class="input-box">
                                                    <input class="form-control" type="text" name="buyer_address" id="buyer_address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_6'];//聯絡電話?></label>
                                        <div class="control-box">
                                            <input class="form-control" type="text" name="buyer_phone" id="buyer_phone">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col col2">
                                <div class="shopping-title"><?=$this->lang['c_7'];//運送方式：?><?=$this->lang['c_8'];//滿?><?=$freeShip;?><?=$this->lang['c_9'];//則免運費?></div>
                                <div class="form-box02">
                                   
                                    <div class="form-group">
                                        <div class="input-box">
                                            <select name="lway_id" id="lway_id" class="form-control">
                                                <? foreach ($logistics_way as $key => $value) {?>      
                                                    <option value="<?=$value['lway_id'];?>"><?=$value['lway_name'];?></option>
                                                <?}?>
                                            </select>
                                            <div id='shop'></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopping-title"><?=$this->lang['c_10'];//付款方式?></div>
                                <div class="form-box02">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <select name="pway_id" id="" class="form-control">
                                                <? foreach ($payment_way as $key => $value) {?>      
                                                    <option value="<?=$value['pway_id'];?>"><?=$value['pway_name'];?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                   
					<div class="pagination_box">
                        <a href="/products" class="btn  simple"><i class="icon-chevron-left"></i> <?=$this->lang['c_11'];//回購物商城?></a>
                        <input type='button' class="btn  simple bg2" id="SendData" value="<?=$this->lang['c_12'];//立前結帳"?>" >
                    </div>					
                        <input type='hidden' name='by_id' id='by_id' value='<?=$by_id?>'>
                   </form>
				</section>
			</div>
		</main>
<!-- 加減-->
<script type="text/javascript" src="/js/quantity_box_button_down.js"></script>		
<script>
//同會員資料    
function ajax_area(country,city,countory){
  $.post("/cart/ajax_area",
      {
          country:country,
          city:city,
          countory:countory
        },
          function(data){   
            var area_array = JSON.parse(data);
            $("#country_select").html(area_array['country']);
            $("#city_select").html(area_array['city']);
            $("#countory_select").html(area_array['countory']);
        }
    );
}
  $('#somemember').click(function(){
    var check=$("input[name='gender']:checked").length;    
    if(check==1){
        $('#select_address').val(0);
        var bid=$('#by_id').val();   
        $.ajax({
          url:'/cart/get_member',
          type:'POST',
          data: 'bid='+bid,
          dataType: 'json',
          success: function( json ) 
          {
            console.log(json);    
              $('#buyer_name').val(json.name);
              $('#buyer_email').val(json.by_email);
              $('#buyer_phone').val(json.mobile);
              $('#buyer_address').val(json.address);
              //$('#country option[value='+json.country+']').attr('selected', 'selected');
              ajax_area(json.country,json.city,json.countory);
          }
        });
    }else{
        $('#buyer_name').val('');
        $('#buyer_email').val('');
        $('#buyer_phone').val('');
        $('#buyer_address').val('');
        $('#country').val(0);
        $('#city').val(0);
        $('#countory').val(0);
    }
  });

//常用地址
        $("#select_address").change(function(){
            var address_id=$("select[name='select_address']").val();
            if(address_id!='0'){
                $('#somemember').prop("checked", false);
                $.post("/cart/ajax_common_address",
                  {
                      address_id:address_id
                  },
                function(address){
                    var address_array = JSON.parse(address);
                    $('#buyer_name').val(address_array['name']);
                    $('#buyer_address').val(address_array['address']);
                    $('#buyer_phone').val(address_array['telphone']);
                    $("#country_select").html(address_array['country']);
                    $("#city_select").html(address_array['city']);
                    $("#countory_select").html(address_array['countory']);
                });
            }else{                
                    $('#buyer_name').val('');
                    $('#buyer_phone').val('');
                    $('#buyer_address').val('');
                    $('#country').val(0);
                    $('#city').val(0);
                    $('#countory').val(0);
            }
        });

//計算金額
  function ajax_count(prd_id,qty){//計算個別金額
      $.post("/cart/ajax_count",
          { 
              prd_id:prd_id,
              qty:qty,
          },
        function(data,status){ 
            var data        = data;
            $("#total_single_"+prd_id).text(data);
            //$('#total_single_15217厘米').text(data);
        },"text");
    }
    function total(){//計算總金額.本次總紅利        
        var use_dividend =$("#use_dividend").val();
      $.post("/cart/total_all",
          {
            use_dividend:use_dividend
          },
        function(data){ 
            var option_array = JSON.parse(data);
            $("#only_money").text(option_array['only_money']);
            $("#total_money").text(option_array['dataTotal']);
            $("#total_bonus").text(option_array['dataBonus']);
        },"text");    
    }
    $(function() {
        total();
            $(".qty").change(function(){
                var prd_id =$("#prd_id"+$(this).attr("ref")).val();
                var qty =$("#qty"+$(this).attr("ref")).val();
                ajax_count(prd_id,qty,use_dividend);
                setTimeout('total()', 300 ) ;
        });
        $(".use_dividend").change(function(){       
            var f = document.forms[0];       
            var use_dividend =$("#use_dividend").val();
                if(parseInt(use_dividend)==use_dividend && parseInt(use_dividend)>=0 && parseInt(use_dividend)<=<?=$d_dividend;?>)
                {
                    total();
                }else{
                    alert("<?=$this->lang['c_21'];//请输入可用紅利,范围为?>0-<?=substr($d_dividend,0,strpos($d_dividend,'.'));?>");                    
                    $("#use_dividend").val('0');
                    total();
                    document.getElementById('use_dividend').focus(); 
                    return false;  
                }
        });
        $("#lway_id").change(function(){
                var lway_id =$("#lway_id").val();
                if(lway_id==5){
                    $.ajax({
                        url:"/cart/ajax_shop",       
                        method:"POST",
                        data:{
                            lway_id:lway_id
                        },      
                        success:function(data){     
                            $('#shop').html(data);
                        }
                    })//end ajax                    
                }else{
                    $('#shop').html('');
                }
        });
        //送出
        $("#SendData").click(function(){ 
            var f = document.forms[0];  
            var re = /^\d{9,10}$/;
            //var re10 = /^\d{10}$/;
            if(f.buyer_name.value==''){
                alert("<?=$this->lang['c_15'];//請輸入姓名?>");
                f.buyer_name.focus();  
                return false;  
            }
            if(f.buyer_address.value==''){
                alert("<?=$this->lang['c_16'];//請輸入地址?>");
                f.buyer_address.focus();  
                return false;  
            }
            if (!re.test(f.buyer_phone.value)) {  
                alert("<?=$this->lang['c_17'];//請輸入正確電話格式,只允許輸入數字?>");
                f.buyer_phone.focus();  
                return false;  
            }
            if (f.country.value==0) {  
                alert("<?=$this->lang['c_22'];//請選擇國家?>");
                f.country.focus();  
                return false;  
            }
            if (f.city.value==0) { 
                alert("<?=$this->lang['c_23'];//請選擇縣市?>");
                f.city.focus();  
                return false;  
            }
            if (f.countory.value==0) {   
                alert("<?=$this->lang['c_24'];//請選擇鄉鎮?>");
                f.countory.focus();  
                return false;  
            }
          $("#myform").attr("action","/cart/cart_checkout");
          $("#myform").submit();
        });

         $(".delete").click(function()
        {   
            var prd_id =$("#prd_id"+$(this).attr("ref")).val();
            //alert(prd_id);
            ajax_delete(prd_id);
        });         

        function ajax_delete(prd_id){//刪除
              $.post("/cart/ajax_delete",
                  {
                      prd_id:prd_id
                  },
                function(data,status){
                },"text");
              alert("<?=$this->lang['c_18'];//刪除完成?>");
            location.href = "/cart"
            }
    });
</script>
<script src="/js/myjava/region.js"></script>