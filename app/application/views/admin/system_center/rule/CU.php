<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
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
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

    <!-- js -->
    <script type="text/javascript" src="/js/messages_tw.js"></script>
    <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/admin/system_center/form.css">
</head>

    <body>
        <form method="post" id="form_ckeditor">
            <input class="aa3" type="submit" name="form_submit" onclick="window.onbeforeunload=null;return true;" value="儲存編輯">
            <table>
                <tr>
                    <td class="title_td"><?=$iqr_cart['title']?></td>
                    <td>
                        <textarea id="ckeditor" name="content"><?=$iqr_cart['content']?></textarea>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="type" name="type" value="<?=$type?>">
        </form>
    </body>
</html>

<script type="text/javascript" src="/js/admin/system_center/build_ckeditor.js"></script>
<script type="text/javascript" src="/js/admin/system_center/rule_add.js"></script>
