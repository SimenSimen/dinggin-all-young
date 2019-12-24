<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$SelectProductClass?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/messages_tw.js"></script>
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>
    <form action='/cart/class_mv' method='post' name='form_class_mv' id='form_class_mv'>
      <h3><?=$_SelectMoveClassName?></h3>
      <table class='table' style="width: 90%;" id='class_add_table'>
        <tr>
          <td><?=$CategoriesName?></td>
          <td class="dd3">
          <select name='selection' id='selection' style="width:100%; padding: 3px 15px; font-family: 微軟正黑體;border: 1px solid #DCD;">
          <option value=""><?=$Select?></option>
          <?php foreach ($class_name as $key => $value): ?>
            <option value="<?=$value['prd_cid']?>" ><?=$value['prd_cname']?></option>
          <?php endforeach; ?>
          </select>
          <span id='info'></span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;">
            <input type='hidden' name='prd_cid' value='<?=$prd_cid?>'>
            <input type='button' class='btn btn-default' name='form_submit' id="form_submit" value='<?=$SaveEdit?>'>
            <input type='button' class='btn btn-default' name='cancle' id='cancel' value='<?=$Cancel?>'>
          </td>
        </tr>
      </table>
      <input type='hidden' name='success' id='success' value='<?=$success?>'>
    </form>
    <input type='hidden' id='count_class' value="<?=$count?>">
    <p style="height: 100px;"></p>
  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">
  h3 { font-family: 'Microsoft Jhenghei'; }
  .btn { font-size: 18px; font-family: 'Microsoft Jhenghei'; }
  #class_add_table tr td { font-size: 18px; font-family: 'Microsoft Jhenghei'; text-align: center; vertical-align: middle; }
</style>

<!--bottom script-->
<script type="text/javascript">

  $(function()
  {
    $('#form_submit').click(function(){
      if($('#selection').val() == '')
      {
        alert('<?=$SelectMoveClassName?>');
      }
      else
      {
        $('#form_class_mv').submit();
      }
    });
    
    if($('#count_class').val() == 1)
    {
      alert('<?=$NewClassificationReuse?>');
      window.close();
    }

    //新增完成
    if($('#success').val() == 1)
    {
      alert('編輯成功');
      opener.window.parent.location.reload(); 
      window.close();
    }
  });

  //取消按鈕關閉視窗
  $('#cancel').click(function(){
    if(confirm('<?=$AreCheckCancleEdit?>?'))
    {
      window.close();
    }
  });
  
</script>