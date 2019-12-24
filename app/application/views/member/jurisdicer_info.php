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
  <!-- 地區AJAX -->
  <script src="/js/myjava/region.js"></script>
</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="/member/data_AED" >

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">角色設定</legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
              <td class='member_list_title_td'>權限名稱</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="d_name" value='<?=$dbdata['d_name']?>'/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>權限描述</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="d_describe" value='<?=$dbdata['d_describe']?>'/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>權限等級</td>
              <td class='member_list_input_td'>
              <table border="0" cellspacing="0" cellpadding="0" class="contentin-table" style="width:100%;">
                <? foreach ($jur as $key => $value):?>
                  <tr>
                    <th style="border-bottom: 1px solid ;"><input type="checkbox" onClick="check('<?=$value['action_code_all']?>',this);"><?=$key?></th>
                    <? foreach ($value as $jkey=> $jvalue): if(is_numeric($jkey)):?>
                    <tr>
                      <td>
                        <div class="contentin-inputall" style="padding-left: 25px;">
                          <input class="contentin-input" type="checkbox"  name="d_action_list[]"  value="<?=$jvalue['d_code']?>" id="<?=$jvalue['d_code']?>" <?=(false !==strpos($dbdata['d_action_list'],$jvalue['d_code']))?'checked':'';?>>
                          <label for="<?=$jvalue['d_code']?>"><?=$jvalue['d_name']?></label>
                        </div>                
                      </td>
                    </tr> 
                  <? endif;endforeach;?>
                  </tr>   
                <? endforeach;?>
                
              </table>
              </td>
            </tr>
          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="d_id" value="<?=$dbdata['d_id']?>">
              <input type="hidden" name="dbname" value="<?=$dbname?>">
              <input class="btn btn-info btn-large" type="button" style="width: 100px;font-size: 18px;" value='儲存' >
            </td>
          </tr>       
        </table>

    </fieldset>
  </div>

</form>
<script >
function check(list, obj)
{
  var frm = obj.form;

    for (i = 0; i < frm.elements.length; i++)
    {
      if (frm.elements[i].name == "d_action_list[]")
      {
          var regx = new RegExp(frm.elements[i].value + "(?!_)", "i");

          if (list.search(regx) > -1) frm.elements[i].checked = obj.checked;
      }
    }
}


$(document).ready(function(){
	$('input[type="button"]').click(function(){
		
		var name = $('input[name="d_name"]').val();
		var describe = $('input[name="d_describe"]').val();
		var countofcheckbox = 0 ;
		$('input:checkbox:checked').each(function(){
			countofcheckbox++;
		});
		
		if( countofcheckbox > 0 && name != '' && describe != ''){
			$('form').submit();
		}else{
			alert("NO data");
		}
		
	});
});
</script>
<p style="height:200px;"></p>

</body>
</html>
