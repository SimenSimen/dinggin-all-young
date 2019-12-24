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

</head>
<script src='/js/myjava/allcheck.js'></script>

<center>
    <?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
      
    <tr id='member_list_title_tr'>
      <!-- <td>狀態</td> -->
      <td>新品推薦</td>
      <td>好物精選</td>
      <td>預購商品</td>
      <td>品名</td>
      <td>供應商名稱</td>
      <td>照片</td>
      <td>價錢</td>
      <td>庫存量</td>
      <td>審核狀態</td>
      <td>一鍵審核</td>
      <td>細節內容</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <!-- <td class='center_td white_td'><?//=$value['prd_active']?></td> -->
            <td class='center_td white_td'><?=$value['prd_new']?></td>
            <td class='center_td white_td'><?=$value['prd_hot']?></td>
            <td class='center_td white_td'><?=$value['prd_prebuy']?></td>
            <td class='center_td white_td'><?=stripslashes($value['prd_name'])?></td>
            <td class='center_td white_td'><?=$value['chinese_name']?></td>
            <td class='center_td white_td'><img src="<?=$value['prd_image']?>" style="vertical-align: middle; max-width: 140px; max-height: 140px;"></td>
            <td class='center_td white_td'><?=number_format($value['prd_price00'],2)?></td>
            <td class='center_td white_td'><?=number_format($value['prd_amount'])?></td>
            <td class="center_td white_td"><?=$value['is_admin_verify'] ? '已通過' : '審核中'?></td>
            <td class="center_td white_td">
              <? if (!$value['is_admin_verify']) { ?>
                <a href="javascript:void(0);" class="btn btn-default" onclick="verify(<?=$value['id']?>)">核銷</a>
              <? } ?>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/products/commit_info/<?=$value['id']?>'">
                查看
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">
  </table>
    <?if (!$_POST['prd_name']) {?>
      <?=$page?>
    <? } ?>
  </form>
<p style="height:200px;"></p>
</body>
</html>
<script>

  const verify = (id) => {
    if (confirm('確定審核該筆提交紀錄？')) {
      $.ajax({
        url: `/products/verify_commit/${id}`,
        dataType: 'JSON',
        type: 'PUT',
        success: response => {
          location.reload();
        }
      })
    }
  }

function allcheck1(){
  var str=''; 
  var DB='products';     //資料庫
  var Field='prd_id'; //欄位名稱
  var show=$('#show_num').val();
  var name=$("#"+show).html();

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
  if(confirm('確定將勾選的資料變更為'+name+'?')){
    $.ajax({
        url:'/products/oc_data',
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
}
  function del_file(name,id){
    if(confirm('確定刪除['+name+']資料?'))
      window.location.href='/<?=$DataName?>/data_AED/<?=$DataName?>/'+id;
  }
</script>
