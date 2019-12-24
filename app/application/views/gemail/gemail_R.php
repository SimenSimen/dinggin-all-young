<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- seo -->
    <title>新增推播訊息 -
        <?=$web_config['title']?>
    </title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords" content=''>
    <meta name="description" content=''>
    <meta name="author" content=''>
    <meta name="copyright" content=''>
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- js -->
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/messages_<?=$lang?>.js"></script>
    <!-- <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script> -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <!-- css -->
    <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection" />
    <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="/css/validation.css">
    <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">
    <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
    <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
    <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
    <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"> -->
    <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
    <!-- multi-select -->
    <script src="/js/multiselect/jquery.multi-select.js"></script>
    <link rel="stylesheet" href="/js/multiselect/multi-select.css">
</head>
<center>

    <body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
        <div>
            <!--新增推播訊息form-->
            <form action='/push/add' method='post' name='form_push_msg_add' id='form_push_msg_add' enctype="multipart/form-data">
                <h3 style="font-family: 'Microsoft JhengHei';">檢視會員電子報</h3>
                <table class='table push_msg_add_table' id='push_msg_add_table' style="width:90%;">
                    <tr id="multiselect">
                        <td class="table-cell-right">對象</td>
                        <td class="table-cell-left">
                            <table>
                                <?php foreach ($push_log['member_name'] as $skey => $svalue): ?>
                                <tr>
                                    <?php foreach ($svalue as $key => $value): ?>
                                    <td style="padding-right: 12px;"><?=$value?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class='table-cell-right'>標題</td>
                        <td class='table-cell-left'>
                            <input type='text' class='form-control required' name='title' id='title' maxlength="30" placeholder='標題文字 (30)' value="<?=$push_log['d_title']?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td class='table-cell-right'>推播夾訊息</td>
                        <td class='table-cell-left'>
                            <?=$push_log['d_message']?>
                        </td>
                    </tr>
                    <tr>
                        <td class='table-cell-center' colspan="2" style="text-align:center;">
                            <input type='button' class='btn btn-default' onclick="return_page(<?=$page?>);" value='返回列表'>
                        </td>
                    </tr>
                </table>
            </form>
            <!--end 新增商品分類form-->
        </div>
    </body>

</html>
<style type="text/css">
h3 {
    font-family: 'Microsoft Jhenghei';
}

.btn {
    font-size: 16px;
    font-family: 'Microsoft Jhenghei';
}

#push_msg_add_table tr td {
    font-size: 18px;
    font-family: 'Microsoft Jhenghei';
}


/*form*/

.form-control {
    display: inline-block;
    width: 90%;
}

.red_star {
    color: red;
}

.table-cell-right {
    vertical-align: middle;
    text-align: center;
    font-size: 18px;
}

.table-cell-left {
    vertical-align: middle;
    text-align: left;
}


/*validate*/

label.error {
    padding-left: 10px;
    font-size: 16px;
    color: red;
    font-family: 'Microsoft JhengHei';
}

label.success {
    padding-left: 0px;
}

input[type=radio] {
    zoom: 150%;
    -moz-transform: scale(1.5);
    position: relative;
    top: 2px;
}

;
</style>
<script>
function return_page(page) {
    window.location.href = '/member/group_email/' + page;
}
</script>
