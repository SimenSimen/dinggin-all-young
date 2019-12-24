<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- seo -->
    <title></title>
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
    <script type="text/javascript" src="/js/messages_tw.js"></script>
    <!-- // <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script> -->

    <!-- bootstrap -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css"> -->
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script> -->

    <link rel="stylesheet" type="text/css" href="/css/admin/system_center/form.css">
    <style type="text/css" media="screen">
        td {
            display: inline;
        }    
    </style>
</head>

    <body>
        <fieldset>
            <form action="/language/language_setting" method="post" accept-charset="utf-8">
                <legend>前台語系 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯"></legend>
              <div class="margin20">
                <table id='store_setting_table' class="personal-info" style="width: 100%;">

                    <?php foreach ($language_type as $key => $value): ?>
                    <tr>
                        <td><?=$value['d_title']?></td>
                        <td>
                            <input type="radio" id="language_<?=$value['d_id']?>_open" name="language[<?=$value['d_id']?>]" value="N" <?=$value['selected_close']?>><label for="language_<?=$value['d_id']?>_open">關閉</label>
                            <input type="radio" id="language_<?=$value['d_id']?>_close" name="language[<?=$value['d_id']?>]" value="Y" <?=$value['selected_open']?>><label for="language_<?=$value['d_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </table>
              </div>
            </form>
        </fieldset>

    </body>
</html>
