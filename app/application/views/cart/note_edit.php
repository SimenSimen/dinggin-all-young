<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_EditNotes?> <?=$web_config['title']?></title>
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

    <form action='/cart/order_note/<?=$order['id']?>/1' method='post' id='note_edit'>
      <h3 style="font-family: '微軟正黑體';"><?=$EditNotes?></h3>
        <table class='table product_add_table' id='product_add_table' style="width:90%;">
          <tr>
            <td class='table-cell-right'><?=$Remark?></td>
            <td class='table-cell-left'><textarea name="order_note" rows="4" cols="40" ><?=$order['note']?></textarea></td>
          </tr>
        </table>
        <input type="hidden" id="suc" value="<?=$suc?>">
        <input type='hidden' name='member_id' value='<?=$member['member_id']?>'>
        <input type="submit" id="note_btn" name='note_btn' value="<?=$Send?>">
        <input type="button" onclick="window.close();" value="<?=$ShutDown?>">
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
      alert('<?=$EditsSuccess?>');
      opener.window.parent.location.reload(); 
      window.onbeforeunload=null;
      window.close();
    }
  });
</script>
