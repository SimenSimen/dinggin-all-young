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

  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:1%;">
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info'">
          新增產品
        </button>
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/products/commits'">
          商品提交紀錄
        </button>
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_theme_sort'">
          主題推薦排序
        </button>
        -->
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_type_sort'">
          <!-- 優選好物排序 -->
          排序
        </button>
        <!--
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_new_sort'">
          新品推薦排序
        </button>
        -->
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_sort'">
          好物精選排序
        </button> -->
        <!--<button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_prebuy_sort'">
          預購商品排序
        </button> -->
		<button class="btn btn-default" type="button" onclick="window.location.href='/products/dl_products'">
          匯出
        </button>
		
      </td>
    </tr>

  </table>
  <table >
    <tr>
      <td>
        <input type="text" name="prd_name" placeholder="請輸入商品名稱">
       <select name="product_class">
          <option value="">請選擇商品系列...</option>
          <? foreach ($cdata as $cvalue):?>
            <option value="<?=$cvalue['prd_cid']?>" <?=($product_class==$cvalue['prd_cid'])?'selected':'';?>><?=stripslashes($cvalue['prd_cname'])?></option>
          <?endforeach;?>
        </select>
       <select name="product_status" >
          <option value="" <?=($product_status=='')?'selected':'';?>>請選擇商品狀態...</option>
          <option value="1" <?=($product_status==1)?'selected':'';?>>尚有庫存</option>
          <option value="2" <?=($product_status==2)?'selected':'';?>>商品下架</option>
          <!--<option value="1" <?=($product_status==1)?'selected':'';?>>商品補貨</option>
          <option value="3" <?=($product_status==3)?'selected':'';?>>低於庫存商品</option>-->
        </select>
        <!-- <input type="checkbox" name="">低於庫存商品
        <input type="checkbox" name="">庫存<0 -->
		
		<select name="product_hot">
			<option value="" <?=($product_hot=='')?'selected':'';?>>請選擇狀態..</option>
			<option value="fa fa-heart" <?=($product_hot=='fa fa-heart')?'selected':'';?>>好物精選</option>
			<option value="fa fa-heart-o" <?=($product_hot=='fa fa-heart-o')?'selected':'';?>>非好物精選</option>
		</select>
    
    <select name="product_new">
      <option value="" <?=($product_new=='')?'selected':'';?>>請選擇狀態..</option>
      <option value="Y" <?=($product_new=='Y')?'selected':'';?>>新品推薦</option>
      <option value="N" <?=($product_new=='N')?'selected':'';?>>非新品推薦</option>
    </select>
	   
        <input type="submit" value="搜尋" id="search_action" style=" font-size:14px;">
       
      </td>
    </tr>
  </table>
  <table>
  <tr>
      <td>
         商品狀態
         <select name="show_num" id="show_num" >
          <option value="no">請選擇</option>
          <option value="1" id="1">上架</option>
          <option value="2" id="2">下架</option>
          <!-- <option value="1" id="1">尚有庫存</option>
          <option value="2" id="2">商品下架</option> -->
          <!-- <option value="Y" id="Y">加到新品推薦</option>
          <option value="N" id="N">移除新品推薦</option>
          <option value="L" id="L">加到好物精選</option>
          <option value="E" id="E">移除好物精選</option>
          <option value="P" id="P">加到預購商品</option>
          <option value="B" id="B">移除預購商品</option> -->
          <!-- <option value="del" id="del">刪除</option> -->
          <!--<option value="1">商品補貨</option>-->
        </select>
        <input type="button" value="修改" style=" font-size:14px;"  onclick="allcheck1()"/>
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
      
    <tr id='member_list_title_tr'>
      <td>選取<input type="checkbox" onclick="check_all(this,'allid[]')"></td>
      <td>狀態</td>
      <td>新品推薦</td>
      <td>好物精選</td>
      <td>預購商品</td>
      <td>品名</td>
      <td>照片</td>
      <td>價錢</td>
      <td>庫存量</td>
      <td>瀏覽人數</td>
      <td>修改</td>
      <td>複製</td>
      <td>刪除</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><input type="checkbox" name="allid[]" value="<?=$value['prd_id']?>"></td>
            <td class='center_td white_td'><?=$value['prd_active']?></td>
            <td class='center_td white_td'><?=$value['prd_new']?></td>
            <td class='center_td white_td'><?=$value['prd_hot']?></td>
            <td class='center_td white_td'><?=$value['prd_prebuy']?></td>
            <td class='center_td white_td'><?=stripslashes($value['prd_name'])?></td>
            <td class='center_td white_td'><img src="<?=$value['prd_image']?>" style="vertical-align: middle; max-width: 140px; max-height: 140px;"></td>
            <td class='center_td white_td'><?=number_format($value['prd_price00'],2)?></td>
            <td class='center_td white_td'><?=number_format($value['prd_amount'])?></td>
            <td class='center_td white_td' title="<?=number_format($value['view'])?>"><?=$value['setview']?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value['prd_id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/<?=$DataName?>/<?=$dbname?>_info/<?=$value['prd_id']?>/Y'">
                <i class="fa fa-copy"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="del_file('<?=$value['prd_name']?>','<?=$value['prd_id']?>')">
                <i class="fa fa-trash-o"></i>
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
