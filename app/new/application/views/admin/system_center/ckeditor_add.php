<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- seo -->
    <title>新增文章</title>
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
    <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/admin/system_center/form.css">
</head>

    <body>
        <form method="post" id="form_ckeditor">
            <button type="button" id="cancel" class="btn btn-default">返回列表</button>
            <input class="aa3" type="submit" name="form_submit" onclick="window.onbeforeunload=null;return true;" value="儲存編輯">
            <table>
                <?php if($category_btn): ?>
                    <tr>
                        <td class="title_td">新增群組</td>
                        <td>
                            <input type="hidden" name="add_category" value="<?=$text['category_id']?>">
                            <input class="required" type="text" name="add_category" maxlength="16" value="<?=$text['c_name']?>">
                        </td>
                    </tr>
                    <?php if(!empty($category)): ?>
                    <tr>
                        <td class="title_td">現有群組<br />
                        <span style="font-size: 9px; color: red;">*右鍵移除群組</span>
                        </td>
                        <td>
                            <div style="display: inline-block; width: 50%;">
                                <?php foreach ($category as $key => $value):?>
                                    <a style="cursor: pointer;" class="category" id="<?=$value['category_id']?>"><label><?=$value['c_name']?></label></a>&nbsp;&nbsp;
                                <?php endforeach; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
                <tr>
                    <td class="title_td">名稱</td>
                    <td><input class="required" type="text" name="name" value="<?=$text['name']?>"></td>
                </tr>
                <tr>
                    <td class="title_td">內容</td>
                    <td>
                        <?php if($ckeditor_btn): ?>
                            <textarea class="required" id="ckeditor" name="content"><?=$text['content']?></textarea>
                        <?php else: ?>
                            <input type="text" class="required" name="content" placeholder="<?=$content_placeholder?>" value="<?=$text['content']?>">
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="back" value="<?=$back_url?>">
            <input type="hidden" id="type" name="type" value="<?=$type?>">
        </form>
    </body>
</html>

<?php if($ckeditor_btn) :?>
    <script type="text/javascript" src="/js/admin/system_center/build_ckeditor.js"></script>
<?php endif; ?>
<script type="text/javascript" src="/js/admin/system_center/ckeditor_add.js"></script>
