<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>編輯商品分類 - <?=$web_config['title']?></title>
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

  <script type="text/javascript">
    $(function(){


    });
  </script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>

    <!--編輯商品分類form-->
    <form action='/cart/class_edit' method='post' name='form_class_edit' id='form_class_edit'>
      <h3>編輯商品分類名稱</h3>
      <table class='table' style="width: 90%;" id='class_add_table'>
        <tr>
          <td>商品分類名稱</td>
          <td class="dd3"><input type='text' value='<?=$prd_c['prd_cname']?>' class='form-control required' style="display:inline; width:80%;" name='prd_cname' id='prd_cname' maxlength="15" placeholder='最多15個字'> <span id='info'></span></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;">
            <input type='hidden' name='prd_cid' value='<?=$prd_cid?>'>
            <input type='submit' class='btn btn-default' name='form_submit' value='儲存編輯'>
            <input type='button' class='btn btn-default' name='cancle' id='cancel' value='取消'>
          </td>
        </tr>
      </table>
      <input type='hidden' name='success' id='success' value='<?=$success?>'>
    </form>
    <!--end 新增商品分類form-->

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
    if(confirm('您確定要取消編輯嗎?'))
    {
      window.close();
    }
  });
  $('#form_class_edit').submit(function(event){
    if($('#prd_cname').val().length == 0)
    {
      $('#info').html('必填');
      $('#info').css('color', 'red');
      event.preventDefault();
    }
  });
</script>