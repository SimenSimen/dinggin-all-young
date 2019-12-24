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
  </style>
<script src="/js/myjava/region.js"></script>

</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="/<?=$dbname?>/data_AED" >

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">物流總覽</legend>

        <table id="member_list" class="table table-bordered table-condensed">
      <!--       <tr>
                <td class='member_list_title_td'>物流方式</td>
                <td class='member_list_input_td'>
                  <input type="radio" name="d_type" id="d_type1" value="1" <?php echo ($dbdata['d_type']==1)?'checked':'';?>/><label for="d_type1">自取</label>
                  <input type="radio" name="d_type" id="d_type2" value="0" <?php echo ($dbdata['d_type']==0)?'checked':'';?>/><label for="d_type2">送貨</label>
                </td>
            </tr> -->
            <tr>
                <td class='member_list_title_td'>物流名稱 </td>
                <td class='member_list_input_td'>
                  <!-- <input type="text" class="form-control" name="d_name" value='<?=$dbdata['lway_name']?>'/> -->
                  <?=$dbdata['lway_name']?>
                </td>
            </tr>
       <!--      <tr>
                <td class='member_list_title_td'>物流描述</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="d_desc" value='<?=$dbdata['d_desc']?>'/>
                </td>
            </tr> -->
            <tr>
                <td class='member_list_title_td'>物流費用</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control"  name="business_account" value='<?=$dbdata['business_account']?>'/>                
                </td>
            </tr>
          <!--   <tr>
                <td class='member_list_title_td'>排序</td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="d_sort" value="<?=$dbdata['d_sort']?>" onkeyup="return ValidateNumber($(this),value)"/>
                  <div id="suggesstion-box"></div>
                </td>
            </tr> -->
           <!--  <tr id="logis_add">
              <td class='member_list_title_td'>取貨地址</td>
              <td>
                <select name="d_city" onChange="sel_area(this.value,'','countory')">
                    <?foreach ($city as $cvalue):?>
                      <option value="<?=$cvalue['s_id']?>" <?=($dbdata['d_city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
                    <? endforeach;?>
                  </select>
                  <select name="d_area" id="countory" >
                    <option>請選擇</option>
                    <?foreach ($area as $avalue):?>
                      <option value="<?=$avalue['s_id']?>" <?=($dbdata['countory']==$avalue['s_id'])?'selected':'';?>><?=$avalue['s_name']?></option>  
                    <? endforeach;?>
                  </select>
                <input type="text" name="d_address" value='<?=$dbdata['d_address']?>' placeholder="地址"  size="40">
              </td>
            </tr>
            <tr id="logis_send">
              <td class='member_list_title_td'>送貨地區</td>
                  <td colspan='2'>
                  <?foreach ($city as $ckey=> $cvalue):?>
                    <input type="checkbox" name="d_area[]" id="area_<?=$ckey?>" value="<?=$cvalue['s_id']?>" <?=(false !==strpos($dbdata['d_area'],$cvalue['s_id'].','))?'checked':'';?>>
                    <label for="area_<?=$ckey?>"><?=$cvalue['s_name']?></label>
                  <? endforeach;?>
                  </td>
            </tr> -->
          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="d_id" value="<?=$dbdata['lway_id']?>">
              <input type="hidden" name="dbname" value="logistics_way">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='儲存'>
            </td>
          </tr>       
        </table>

    </fieldset>
  </div>

</form>
<p style="height:200px;"></p>
</body>
</html>
<script>



var logis=$('input[name=d_type]:checked').val();
if(logis==1){
  <? if($dbdata['d_type']=='1'):?>
     sel_area(<?=$dbdata['d_city']?>,<?=$dbdata['d_area']?>,'countory');
  <? endif;?>
  $('#logis_add').css('display','');
  $('#logis_send').css('display','none');
}
else{
  $('#logis_add').css('display','none');
  $('#logis_send').css('display','');
}

$('input[name=d_type]').change(function(){
  var logis=$('input[name=d_type]:checked').val();
    if(logis==1){
      $('#logis_add').css('display','');
      $('#logis_send').css('display','none');   
    }
    else{
      $('#logis_add').css('display','none');
      $('#logis_send').css('display','');
    }
});

//input 只限輸入數字
function ValidateNumber(e, pnumber)
{
    if (!/^\d+$/.test(pnumber))
    {
        $(e).val(/^\d+/.exec($(e).val()));
    }
    return false;
}
 

</script>
