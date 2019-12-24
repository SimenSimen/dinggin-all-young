<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>歐付寶(Allpay)金流設定 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--新增商品分類form-->
    <form action='/admin/allpay_edit/<?=$member['member_id']?>/1' method='post' id='qrcode_edit'>
      <h3 style="font-family: '微軟正黑體';">歐付寶(Allpay) - 金流設定</h3>
      <!-- <p style="font-family: '微軟正黑體'; font-size: 15px;">(若不輸入連結，則保有初始的載點)</p> -->
        <table class='table product_add_table' id='product_add_table' style="width:90%;">
          <tr>
            <td class='table-cell-right'>帳號</td>
            <td class='table-cell-left'><?=$member['account']?></td>
          </tr>

          <tr>
            <td class='table-cell-right'>商店代號</td>
            <td class='table-cell-left'><input value="<?=$iqrt['business_account']?>" type='text' class='form-control' id="business_account" name='business_account' placeholder='歐付寶商店代號'></td>
          </tr>

          <tr>
            <td class='table-cell-right'>HashKey</td>
            <td class='table-cell-left'><input value="<?=$iqrt['business_hashkey']?>" type='text' class='form-control' id="hashkey" name='business_hashkey' placeholder='ALL IN ONE 介接 HashKey'></td>
          </tr>
          <tr>
            <td class='table-cell-right'>HashIV</td>
            <td class='table-cell-left'><input value="<?=$iqrt['business_hashiv']?>" type='text' class='form-control' id="hashiv" name='business_hashiv' placeholder='ALL IN ONE 介接 HashIV'></td>

            <!-- <td class='table-cell-left'>
              <select style="padding: 0px 10px; font-family: 微軟正黑體; font-size: 0.85em;" name="select_status">
              <?php foreach ($instore as $key => $value): ?>
                <option value="<?=$key?>" <?=$instore_selected[$key]?>><?=$value?></option>    
              <?php endforeach; ?>
              </select>
            </td> -->
          </tr>
        </table>
        <input type="hidden" id="suc" value="<?=$suc?>">
        <input type='hidden' name='member_id' value='<?=$member['member_id']?>'>
        <input type="button" id="qrcode_btn" name='qrcode_btn' value="送出">
        <input type="button" onclick="window.close();" value="關閉">
      </form>
    <!--end 新增商品分類form-->
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">

  h3 { font-family: 'Microsoft Jhenghei'; }
  .btn { font-size: 16px; font-family: 'Microsoft Jhenghei'; }
  #product_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; }

  /*form*/
  .form-control { display: inline-block; width: 90%; }
  .red_star { color: red; }
  .table-cell-right { vertical-align: middle; text-align: center; font-size: 18px; }
  .table-cell-left { vertical-align: middle; text-align: left; }

  /*validate*/
  label.error { padding-left: 10px; font-size: 16px; color: red; font-family: '微軟正黑體'; }
  label.success { padding-left: 0px; }

</style>
<script>
  $(function(){
    if($('#suc').val() == 1)
    {
      alert('編輯成功');
      opener.window.parent.location.reload(); 
      window.onbeforeunload=null;
      window.close();
    }
    $('#qrcode_btn').click(function(){
      $('#qrcode_edit').submit();
    });
    
  });
</script>
