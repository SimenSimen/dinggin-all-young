<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_NewClassType?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/uform_add.css">

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/messages_<?=$lang?>.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script><!-- ckeditor -->
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function() {

        $('#cancel').click(function() {
          if (confirm('<?=$SureCancleAdd?>')) {
            window.close();
          }
        });

        //新增完成
        if ($('#success').val() == 1) {
          alert('<?=$NewSuccess?>');
          opener.window.parent.location.reload();
          window.close();
        }

        //validate
        $('#form_uform_category_add').validate({
          success: function(label) {
            label.addClass("success").text("");
          }
        });
    });
  </script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div class='uform'>
    <form action='/business/uform_category_add' method='post' name='form_uform_category_add' id='form_uform_category_add'>
    <h3 style="font-family: '微軟正黑體';"><?=$NewClassType?></h3>
      <table class='table' id='uform_table'>
        <tr>
          <td class='table-cell-right'><?=$ClassTypeName?></td>
          <td class='table-cell-left'><input type='text' class='form-control required' style="display:inline;" name='ufm_category' maxlength="32"></td>
        </tr>
        <tr>
          <td class='table-cell-center' colspan="2">
            <input type='submit' class='btn btn-default' name='form_submit' style="font-size: 18px;" value='<?=$Add?>'>
            <input type='button' class='btn btn-default' name='cancle' style="font-size: 18px;" id='cancel' value='<?=$Cancle?>'>
            <input type='hidden' name='member_id' id='member_id' value='<?=$member_id?>'>
            <input type='hidden' name='success' id='success' value='<?=$success?>'>
          </td>
        </tr>
      </table>
    </form>
  </div>

</body>
</html>
