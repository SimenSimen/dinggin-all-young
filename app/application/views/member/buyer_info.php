<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    div.config-div {
      margin-top: 20px;
      margin-left: 40px;
    }
    div.config-div-img {
      margin-left: 68%;
    }
    div.config-div-encrypt {
      margin-left: 68%;
    }
    div.config-div fieldset {
      display: inline;
      float: left;
    }
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
    }
    fieldset.config-border-img, fieldset.config-border-encrypt {
      width: 100px;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
              text-align: center;
              vertical-align: middle;
    }
    legend.config-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
      width: 130px;
    }
    .member_list_title_td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
      width:150px;
    }
    #member_list tr td
    {
      vertical-align: middle;
    }
    .member_list_input_td
    {
      width:180px;
    }
    input[type=text], .input_select
    {
      background-color: #FDFFE2;
      font-size: 16px;
      color: #000;
    }
		.select2
		{
			width: 100% !important;
		}
  </style>
  <!-- 地區AJAX -->
  <script src="/js/myjava/region.js"></script>
</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="/member/member_AED" id='form1'>

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">會員資料</legend>

        <table id="member_list" class="table table-bordered table-condensed">
          <?if($dbdata['is_alipay']==0){?>
            <tr>
              <td class='member_list_title_td'>帳號</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" maxlength="16" name="d_account" value='<?=($dbdata['d_account']!="")?$dbdata['d_account']:''?>' <?=($dbdata['by_id']!="")?'readonly':'';?>/>
              </td>
            </tr>
          <?}else{?>
            <tr>
              <td class='member_list_title_td'>使用第三方註冊</td>
              <td class='member_list_input_td'><?=$alipay?></td>
            </tr>            
              <input type="hidden" name="d_account" id="by_id" value="<?=$dbdata['d_account']?>">
              <input type="hidden" name="by_pw" id="by_id" value="<?=$dbdata['by_pw']?>">
          <?}?>
            <tr>
              <td class='member_list_title_td'>姓名</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="name" value='<?=$dbdata['name']?>'/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>性別</td>
              <td class='member_list_input_td'>
                <input type="radio" name="sex" value='male' <?=($dbdata['sex']=='male')?'checked':'';echo ($dbdata['sex']=='')?'checked':'';?> />男
                <input type="radio" name="sex" value='female' <?=($dbdata['sex']=='female')?'checked':'';?> />女
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>手機</td>
              <td class='member_list_input_td'>
                <input type="text" maxlength="11" class="form-control" name="mobile" onKeyUp="value=value.replace(/[^\d]/g,'')" value='<?=$dbdata['mobile']?>'/>
              </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>電話</td>
                <td class='member_list_input_td'>
                  <input type="text" maxlength="11" class="form-control" name="telphone" onKeyUp="value=value.replace(/[^\d]/g,'')" value='<?=$dbdata['telphone']?>'/>
                </td>
            </tr>
            <?if($dbdata['is_alipay']==0){?>
            <tr>
                <td class='member_list_title_td'>密碼</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control"  name="by_pw" value='<?=$dbdata['by_pw']?>'/>                
                </td>
            </tr>
            <?}?>
            <tr>
                <td class='member_list_title_td'>通訊地址</td>
                <td class='member_list_input_td'>
                  <select name="country" id="country" onChange="sel_area(this.value,'','city')" class="form-control">
                	<option value=''>請選擇</option>
                    <?foreach ($country as $ccvalue):?>
                      <option value="<?=$ccvalue['s_id']?>" <?=($dbdata['country']==$ccvalue['s_id'])?'selected':'';?>><?=$ccvalue['s_name']?></option>  
                    <? endforeach;?>
                  </select>
                  <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control">
                	<option value=''>請選擇</option>
                	<?if(!empty($dbdata['city'])):?>
                    <?foreach ($city as $cvalue):?>
                      <option value="<?=$cvalue['s_id']?>" <?=($dbdata['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
                    <? endforeach;?>
               		<? endif;?>
                  </select>
                  <select name="countory" id="countory" class="form-control">
                    <option value=''>請選擇</option>
                    <?foreach ($area as $avalue):?>
                      <option value="<?=$avalue['s_id']?>" <?=($dbdata['countory']==$avalue['s_id'])?'selected':'';?>><?=$avalue['s_name']?></option>  
                    <? endforeach;?>
                  </select>
                  <input type="text" class="form-control" name="address" value='<?=$dbdata['address']?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>生日</td>
                <td class='member_list_input_td'>
                  <input type="date" class="form-control" name="birthday" value='<?=$dbdata['birthday']?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>信箱</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="by_email" value='<?=$dbdata['by_email']?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>備註</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="d_content" maxlength="255" value='<?=$dbdata['d_content']?>'/>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>身份</td>
                <td class='member_list_input_td'>
                  <input type="radio" name="d_is_member" value='0' <?=($dbdata['d_is_member']=='0')?'checked':'';echo ($dbdata['d_is_member']=='N')?'checked':'';echo ($dbdata['d_is_member']=='')?'checked':'';?> />一般會員
                  <input type="radio" name="d_is_member" value='1' <?=($dbdata['d_is_member']=='1' )?'checked':'';?> />經營會員
                  <? if($dbdata['d_is_member']=='2'):?>
                    <input type="radio" name="d_is_member" value='2' <?=($dbdata['d_is_member']=='2')?'checked':'';?> />待審核會員
                  <? endif;?>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>特殊身份</td>
                <td class='member_list_input_td'>
                  <select name="d_spec_type" class="form-control">
                    <option value="0">無特殊身分</option>
                    <? foreach ($spec as $skey => $svalue):?>
                      <option value="<?=$skey?>" <?=($dbdata['d_spec_type']==($skey))?'selected':'';?>><?=$svalue?></option>
                    <? endforeach;?>
                  </select>
                </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>推薦人</td>
                <td class='member_list_input_td'>
                  <select name="PID" id="pid" class="pid form-control">
                      <option value="0">無推薦人</option>
                    <?foreach ($buyerdata as $mvalue):?>
                      <option value="<?=$mvalue['by_id']?>" <?=($dbdata['PID']==$mvalue['by_id'])?'selected':'';?>><?='['.$mvalue['member_num'].']'.'['.$mvalue['d_account'].']'.$mvalue['name']?></option>
                    <? endforeach;?>
                  </select>
                </td>
            </tr>
            </table>
            <div id="member_div" style="display:none">
              <table class="table table-bordered table-condensed">
                <tr>
                  <td class='member_list_title_td'>身份證</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="identity_num" value='<?=$mdbdata['identity_num']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>戶籍地址</td>
                  <td class='member_list_input_td'>
                    <select name="cen_country" id="cen_country" onChange="sel_area(this.value,'','cen_city')" class="form-control">
                      <option>請選擇</option> 
                      <?foreach ($country as $xccvalue):?>
                        <option value="<?=$xccvalue['s_id']?>" <?=($mdbdata['country']==$xccvalue['s_id'])?'selected':'';?>><?=$xccvalue['s_name']?></option>  
                      <? endforeach;?>
                    </select>
                    <div id="city_select">
                    <select name="cen_city" id="cen_city" onChange="sel_area(this.value,'','cen_countory')" class="form-control">
                      <option>請選擇</option> 
                      <?foreach ($city as $xcvalue):?>
                        <option value="<?=$xcvalue['s_id']?>" <?=($mdbdata['city']==$xcvalue['s_id'])?'selected':'';?>><?=$xcvalue['s_name']?></option>  
                      <? endforeach;?>
                    </select>
                    </div>
                    <div id="countory_select">
                    <select name="cen_countory" id="cen_countory" class="form-control" >
                      <option>請選擇</option>  
                      <?foreach ($area as $xavalue):?>
                        <option value="<?=$xavalue['s_id']?>" <?=($mdbdata['countory']==$xavalue['s_id'])?'selected':'';?>><?=$xavalue['s_name']?></option>  
                      <? endforeach;?>
                    </select>
                    </div>
                    <input type="checkbox" value="1" id="somemember">同通訊地址
                    <input type="text" class="form-control" name="cen_address" value='<?=$mdbdata['address']?>'/>
                  </td>
                </tr>  
                <tr>
                  <td class='member_list_title_td'>銀行名稱</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="bank_name" value='<?=$mdbdata['bank_name']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>帳戶名稱</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="bank_account_name" value='<?=$mdbdata['bank_account_name']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>銀行帳號</td>
                  <td class='member_list_input_td'>
                    <input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" name="bank_account" value='<?=$mdbdata['bank_account']?>'/>
                  </td>
                </tr>
                <?if($this->data['web_config']['is_auto_register_wowpay']==1){?>
                <tr>
                  <td class='member_list_title_td'>wowpay帳號</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_email" value='<?=$mdbdata['wowpay_email']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay國碼</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_country_num" value='<?=$mdbdata['wowpay_country_num']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay電話</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_mobile" value='<?=$mdbdata['wowpay_mobile']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay卡號</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_cardAsn" value='<?=$mdbdata['wowpay_cardAsn']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay支付密碼</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_pay_password" value='<?=$mdbdata['wowpay_pay_password']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay登入密碼</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_login_password" value='<?=$mdbdata['wowpay_login_password']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>wowpay簽名數據</td>
                  <td class='member_list_input_td'>
                    <input type="text" class="form-control" name="wowpay_signature" value='<?=$mdbdata['wowpay_signature']?>'/>
                  </td>
                </tr>
                <?}?>
                <tr>
                  <td class='member_list_title_td'>入會日</td>
                  <td class='member_list_input_td'>
                    <input type="date" class="form-control" name="join_time" id="join_time" value='<?=$mdbdata['join_time']?>'/>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>體系名稱</td>
                  <td class='member_list_input_td'>
                   <?=$f_name?>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>上線會員</td>
                  <td class='member_list_input_td'>
                    <select name="upline" id="upline" class="upline form-control">
                      <option value="0">無上線會員</option>
                    <?foreach ($mebdata as $mvalue):?>
                      <option value="<?=$mvalue['member_id']?>" <?=($mdbdata['upline']==$mvalue['member_id'])?'selected':'';?>><?='['.$mvalue['member_num'].']'.'['.$mvalue['d_account'].']'.$mvalue['name']?></option>
                    <? endforeach;?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class='member_list_title_td'>是否門市取貨</td>
                  <td class='member_list_input_td'>
                    <input type="radio" name="is_shop" value='0' <?=($mdbdata['is_shop']=='0')?'checked':'';echo ($mdbdata['is_shop']=='N')?'checked':'';echo ($mdbdata['is_shop']=='')?'checked':'';?> />否
                      <input type="radio" name="is_shop" value='1' <?=($mdbdata['is_shop']=='1' )?'checked':'';?> />是
                  </td>
                </tr>
                  <tr id="shop_add_data" style="display:none">
                    <td class='member_list_title_td'>門市取貨地址</td>
                    <td class='member_list_input_td'>
                      <select name="shop_country" id="shop_country" onChange="sel_area(this.value,'','shop_city')" class="form-control">
                        <option>請選擇</option> 
                        <?foreach ($country as $xccvalue):?>
                          <option value="<?=$xccvalue['s_id']?>" <?=($mdbdata['shop_country']==$xccvalue['s_id'])?'selected':'';?>><?=$xccvalue['s_name']?></option>  
                        <? endforeach;?>
                      </select>
                      <select name="shop_city" id="shop_city" onChange="sel_area(this.value,'','shop_countory')" class="form-control">
                        <option>請選擇</option> 
                        <?foreach ($city as $xcvalue):?>
                          <option value="<?=$xcvalue['s_id']?>" <?=($mdbdata['shop_city']==$xcvalue['s_id'])?'selected':'';?>><?=$xcvalue['s_name']?></option>  
                        <? endforeach;?>
                      </select>
                      <select name="shop_countory" id="shop_countory" class="form-control">
                        <option>請選擇</option>  
                        <?foreach ($area as $xavalue):?>
                          <option value="<?=$xavalue['s_id']?>" <?=($mdbdata['shop_countory']==$xavalue['s_id'])?'selected':'';?>><?=$xavalue['s_name']?></option>  
                        <? endforeach;?>
                      </select>
                      <input type="text" class="form-control" name="shop_address" value='<?=$mdbdata['shop_address']?>'/>
                    </td>
                  </tr>
              </table>              
            </div>


          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="d_id" id="by_id" value="<?=$d_id?>">
              <input type="hidden" name="dbname" value="<?=$dbname?>">
              <input class="btn btn-info btn-large" type="button" id="cancel" style="width: 100px;font-size: 18px;" value='返回'>
              <input class="btn btn-info btn-large" type="button" id="submit" style="width: 100px;font-size: 18px;" value='儲存'>
            </td>
          </tr>
    </fieldset>
  </div>

</form>
<link href="/js/select2/css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/js/select2/js/select2.full.min.js"></script>
<script>
$(".pid").select2();
$(".upline").select2();
<? if($dbdata['city']!=''):?>
  <? if($dbdata['city']!='0'):?>
    // sel_area(<?=$dbdata['country']?>,<?=$dbdata['city']?>,'city'); 鄉鎮選項會跳掉不會讀原本資料庫的資料 so remark
    // sel_area(<?=$dbdata['city']?>,<?=$dbdata['countory']?>,'countory'); 鄉鎮選項會跳掉不會讀原本資料庫的資料 so remark
  <? endif;?>
<? endif;?>
<? if($mdbdata['city']!=''):?>
  <? if($mdbdata['city']!='0'):?>
  	//sel_area(<?=$mdbdata['country']?>,<?=$mdbdata['city']?>,'cen_city'); 選項會跳掉不會讀原本資料庫的資料 so remark
    sel_area(<?=$mdbdata['city']?>,<?=$mdbdata['countory']?>,'cen_countory');
  <? endif;?>
<? endif;?>
<? if($mdbdata['shop_city']!=''):?>
  <? if($mdbdata['shop_city']!='0'):?>
    sel_area(<?=$mdbdata['shop_city']?>,<?=$mdbdata['shop_countory']?>,'shop_countory');
  <? endif;?>
<? endif;?>
  if($("input:radio[name='d_is_member']:checked").val()=='1' || $("input:radio[name='d_is_member']:checked").val()=='2'){
    $('#member_div').css('display','');
  }else{
    $('#member_div').css('display','none');
  }
  $("input:radio[name='d_is_member']").click(function(){
    if($(this).val()=='1' || $(this).val()=='2')
      $('#member_div').css('display','');
    else
      $('#member_div').css('display','none');
  });
  
  if($("input:radio[name='is_shop']:checked").val()=='1'){
    $('#shop_add_data').css('display','');
  }
  
  $("input:radio[name='is_shop']").click(function(){
    if($(this).val()=='1')
      $('#shop_add_data').css('display','');
    else
      $('#shop_add_data').css('display','none');
  });

$(function() {
    //取消按鈕關閉視窗
    $('#cancel').click(function() {
            window.location.href = "<?=$back_url?>";
    });
    //送出防呆,一定要選一般會員or經營會員才不會有問題。若選經營會員,要填入會日
    $('#submit').click(function() {
        var d_is_member=$("input:radio[name='d_is_member']:checked").val();
        if(d_is_member==2){
          alert('請選擇一般會員or經營會員');
        }else if(d_is_member==1){
          var join_time=$('#join_time').val();
          if(join_time==''){
            alert('請填入會日');
          }else{
						$.ajax({
							url: '/member/get_upline_ajax',
							type: 'POST',
							data: {pid: $('#pid').val(),upline:$('#upline').val()},
							dataType: 'json',
							success: function (data){
								if(data['pid']!=data['upline']){
									alert('推薦人跟上線不同人');
								}else{
									$('#submit').prop('type', 'submit');
									$('#submit').click();
								}
							}
						});
					}
        }else if(d_is_member==0){
					$('#submit').prop('type', 'submit');
					$('#submit').click();
				}
    });
});
$('#somemember').click(function(){    
  if($('#somemember:checked').val()){
    var bid=$('#by_id').val();
    country=$('select[name="country"]').val();
    city=$('select[name="city"]').val();
    countory=$('select[name="countory"]').val();
    address=$('input[name="address"]').val();
    $('select[name="cen_country"]').val(country);
    $('select[name="cen_city"]').val(city);
    ajax_area(country,city,countory);
    $('input[name="cen_address"]').val(address);
  }
});
function ajax_area(country,city,countory){
  $.post("/member/ajax_area",{country:country,city:city,countory:countory},  
    function(data){ 
        var area_array = JSON.parse(data);
        $("#city_select").html(area_array['city']);
        $("#countory_select").html(area_array['countory']);
    }
  );
}
</script>

<p style="height:200px;"></p>

</body>
</html>
