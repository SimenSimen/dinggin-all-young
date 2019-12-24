<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


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
<script src="/js/myjava/jquery.ui.autocomplete.html.min.js"></script>
<link rel="stylesheet" href="/js/myjava/autocomplete.css">
</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<form method="post" action="/bonus/bonus_AE">

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">獎金項目內容</legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                <td class='member_list_title_td'>發給會員</td>
                <td class='member_list_input_td'>
                  <? if($dbdata['d_id']!=''):
                      echo $dbdata['sName'].'['.$dbdata['member_num'].']';
                  else:?>
                    <input type="text" class="form-control" name="member_id" id="d_member_name" value='<?=$value['member_id']?>'/>
                  <? endif;?>
                  <div id="suggesstion-box"></div>
                </td>
            </tr>
           <!--  <tr>
                <td class='member_list_title_td'>生效日期</td>
                <td class='member_list_input_td'>
                <? if($dbdata['d_id']!=''):
                    echo $dbdata['d_date'];
                  else:?>
                    <input type="date" class="form-control" name="d_date" value='<?=$value['d_date']?>'/>
                <? endif;?>
                </td>
            </tr> -->
            <tr>
                <td class='member_list_title_td'>項目類型</td>
                <td class='member_list_input_td'>
                  <? if($dbdata['d_id']!=''):
                    echo $dbdata['d_type'];
                  else:?>
                  <input type="radio" value="0" name="rd_type" id="iClass0" />
                  <label for="iClass0" id="iClassLabel0" class="CheckLabel">補發項目</label>&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" value="1" name="rd_type" id="iClass1" />
                  <label for="iClass1" id="iClassLabel1" class="CheckLabel">扣除項目</label>
                  <?endif;?>
                </td>
            </tr>
            
            <tr name="reissue_tr">
              <td class='member_list_title_td'>補發項目</td>
              <td class='member_list_input_td'>
                <select data-placeholder="補發項目" class="chosen-select" style="width:150px;" name="r_type_id" >
                  <? foreach ($reissue as $value) {?>
                    <option value="<?=$value['d_id']?>"><?=$value['d_title']?></option>  
                  <?}?>
                </select>
              </td>
            </tr>
            <tr name="reissue_tr">
                <td class='member_list_title_td'>補發PV</td>
                <td class='member_list_input_td'>
                      <input name="r_pv" type="text" size="10" maxlength="6"  class="validate[required] Text Currency" autocomplete="off"  />
                </td>
            </tr>
              
            <tr name="deduction_tr">
              <td class='member_list_title_td'>扣除項目</td>
              <td class='member_list_input_td'>
                <select data-placeholder="扣除項目" class="chosen-select" style="width:150px;" name="e_type_id" >
                  <? foreach ($deduction as $value) {?>
                    <option value="<?=$value['d_id']?>"><?=$value['d_title']?></option>  
                  <?}?>
                </select>
              </td>
            </tr>
            <tr name="deduction_tr">
                <td class='member_list_title_td'>扣除PV</td>
                <td class='member_list_input_td'>
                  <input name="e_pv" type="text" size="10" maxlength="6"  class="validate[required] Text Currency" autocomplete="off"  />
                </td>
            </tr>
            </th>
            <tr>
                <td class='member_list_title_td'>項目說明</td>
                <td class='member_list_input_td'>
                  <? if($dbdata['d_id']!=''):
                    echo $dbdata['d_content'];
                  else:?>
                    <textarea name="d_content"></textarea>
                  <? endif;?>
                </td>
            </tr>
            <? if($dbdata['d_id']!=''):?>
              <tr>
                <td class='member_list_title_td'>是否擋佣</td>
                <td class='member_list_input_td'>
                  <input type="checkbox" value="Y" name="d_block" <?=($dbdata['d_block']=='Y')?'checked':'';?>>擋佣  
                </td>
              </tr>
              <tr name="bcontent">
                <td class='member_list_title_td'>擋佣原因</td>
                <td class='member_list_input_td'>
                  <textarea name="d_bcontent"><?=$dbdata['d_bcontent']?></textarea>
                </td>
              </tr>       
            <? endif;?>
          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="year_month" value="<?=$year.$month?>">
              <input type="hidden" name="d_id" value="<?=$dbdata['d_id']?>">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='設定'>
            </td>
          </tr>       
        </table>
    </fieldset>

  </div>
 
</form>


<p style="height:200px;"></p>

</body>
</html>
<script >
var num=$('input[name="d_block"]:checked').val();
if(num=='Y')
  $('tr[name="bcontent"]').css('display','');
else
  $('tr[name="bcontent"]').css('display','none');
$('input[name="d_block"]').click(function(){
  var num=$('input[name="d_block"]:checked').val();
  if(num=='Y')
    $('tr[name="bcontent"]').css('display','');
  else
    $('tr[name="bcontent"]').css('display','none');
});

$('tr[name="deduction_tr"]').hide();
$('tr[name="reissue_tr"]').hide();
$('input[name="rd_type"]').change(function(){
  var classnum=$('input:radio:checked[name="rd_type"]').val();

  if(classnum==0){
    $('tr[name="reissue_tr"]').fadeIn();
    $('tr[name="deduction_tr"]').fadeOut();

  }
  if(classnum==1){
    $('tr[name="reissue_tr"]').fadeOut();
    $('tr[name="deduction_tr"]').fadeIn();
  }
});

$("#d_member_name").keyup(function(){
    if(($(this).val()).length>=2){
        $('#member-name').html('');
        $.ajax({
        type: "POST",
        url: "/member/get_member_ajax",
        data:'keyword='+$(this).val(),
        success: function(data){

          $("#suggesstion-box").show();
          $("#suggesstion-box").html(data);
        }
        });
      }
  });
</script>