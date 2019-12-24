 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head id=<?=$dbname?>>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }
    .btn
    {
      font-size: 18px;
    }
    #button_table
    {
      width:80%;
      margin-top: 10px;
    }
    #button_table tr td
    {
      padding-top:5px;
      padding-bottom: 5px;
      padding-left: 5px;
    }
    #member_list tr td
    {
      padding: 5px;
    }
    #member_list_title_tr td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
    }
    .white_td
    {
      color: <?=$web_config['admin_font_color']?>;
    }
    .center_td
    {
      text-align: center;
    }
    #password_title_td
    {
      cursor: pointer;
      color: #F99;
    }
    .checkbox_td
    {
      zoom: 150%;
      text-align: center;
      vertical-align: middle;
    }
    .mycheckbox
    {
      cursor: pointer;
    }
    .info_prompt
    {
      text-align: right;
      color: #F60;
      font-size: 14px;
    }
  </style>
	<script>
		$(function() {
			$('.btn-info1').click(function() {
				$('#search_form').attr('action', '/payment/sort1_save');
				$('#search_form').submit();
			});
			
			$('#sort1').sortable();
		});
	</script>
</head>
<script src='/js/myjava/allcheck.js'></script>
<center>
    <?=form_open($form,array("id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <!-- <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:1%;">
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'">
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$dbname?>/<?=$dbname?>_info'">
          新增金流
        </button>
      </td>
    </tr>

  </table> -->
  金流設定
  <table >
    <tr>
      <td>
        <select name="show_num" id="show_num" >
          <option value="no">請選擇</option>
          <option value="1">啟用</option>
          <option value="0">停用</option>            
        </select>
        <input type="button" value="修改" style=" font-size:14px;"  onclick="allcheck()"/>
        <button class="btn-info1" style=" font-size:14px;" type="button">儲存排序</button>
      </td>
    </tr>
  </table>
  <!--金流列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    
    <tr id='member_list_title_tr'>
      <td>選取<input type="checkbox" onclick="check_all(this,'allid[]')"></td>
      <td>狀態</td>
      <td>金流名稱</td>
      <!--<td>金流費用</td>-->
      <td>修改</td>
    </tr>

    <!--for-->
    <tbody id="sort1">
    <?php if (!empty($dbdata)): ?>
        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
        	<input type="hidden" name="ck_id[]" value="<?=$value['pway_id']?>">
            <td class='center_td white_td'><input type="checkbox"  name="allid[]" value="<?=$value['pway_id']?>"></td>
            <td class='center_td white_td'><?=$value['active']?></td>
            <td class='center_td white_td'><?=$value['pway_name']?></td>
            <!--<td class='center_td white_td'><?=$value['business_account']?></td>-->
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$dbname?>/<?=$dbname?>_info/<?=$value['pway_id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
           <!--  <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="del_file('<?=$value['d_code']?>','<?=$value['d_id']?>')">
                <i class="fa fa-trash-o"></i>
              </a>
            </td> -->
          </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
  </form>
<!--訂單成功後幾天內可申請退貨start-->
<form method="post" >
  <div class="config-div">
    <fieldset class="config-border">
        <table id="member_list" class="table table-bordered table-condensed" style="width:80%;">
          <? foreach ($return as $value):?>
            <tr>
                <td class='member_list_title_td'><?=$value['d_title']?></td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="return[<?=$value['d_id']?>]" value='<?=$value['d_val']?>'/>
                </td>
            </tr>
          <? endforeach;?> 
          <!--<tr>
            <td colspan="4" style="text-align:right;">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='設定'>
            </td>
          </tr>       -->
        </table>

    </fieldset>
<!--  </div>
</form>-->
<!--訂單成功後幾天內可申請退貨end-->
<!--ATM匯款資訊start-->
<!--<form method="post" >-->
  <div class="config-div">ATM匯款資訊
    <fieldset class="config-border">
        <table id="member_list" class="table table-bordered table-condensed" style="width:80%;">
          <? foreach ($atm as $value):?>
            <tr>
                <td class='member_list_title_td'>
                  <input type="text" class="form-control" name="atm_t[<?=$value['d_id']?>]" value='<?=$value['d_title']?>'/>  
                  </td>
                <td class='member_list_input_td'>
                  <input type="text" class="form-control" name="atm[<?=$value['d_id']?>]" value='<?=$value['d_val']?>'/>
                </td>
            </tr>
          <? endforeach;?> 
          <tr>
            <td colspan="4" style="text-align:right;">
              <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='設定'>
            </td>
          </tr>       
        </table>

    </fieldset>
  </div>
</form>
<!--ATM匯款資訊end-->



<p style="height:200px;"></p>

</body>
</html>
<script>
  function allcheck(){
    var str=''; 
    var DB='payment_way';     //資料庫
    var Field='pway_id'; //欄位名稱
    var show=$('#show_num').val();
    if(show=='no'){
      alert("請選擇動作");
      return '';
    }
    $("input[name='allid[]']:checked").each(function(){   
        str+=$(this).val()+';';   
    })   
    if(str==''){
        alert('請選取項目');
        return  '';
    }   
    $.ajax({
        url:'/payment/oc_data',
        type:'POST',
        data: 'DB='+DB+'&field='+Field+'&id='+str+'&oc='+show,
        dataType: 'text',
        success: function( json ) 
        {
            alert(json);
            window.location.reload();
        }
    });
  }
  function del_file(name,id){
    if(confirm('確定刪除['+name+']資料?'))
      window.location.href='/'+$('head').attr('id')+'/data_AED/'+$('head').attr('id')+'/'+id;
  }  
</script>