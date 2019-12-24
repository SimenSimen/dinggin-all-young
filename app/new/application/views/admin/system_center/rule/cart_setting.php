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
            <form action="/rule/cart_setting" method="post" accept-charset="utf-8">
                <legend>基本資訊 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯"></legend>
              <div class="margin20">
                <table id='store_setting_table' class="personal-info" style="width: 100%;">
                    <tr id='cset_name_td'>
                        <td>按鈕名稱</td>
                        <td>
                            <a class="why" id="why_panel1" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel1'>
                                <p>1. 名片頁按鈕所顯示名稱</p>
                                <p>2. 您的行動商店名稱</p>
                                <p>3. 系統寄發通知信件的「寄件者名稱」</p>
                            </div>
                            <input type='text' placeholder='顯示按鈕名稱，例如：商店頁' maxlength="15" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_name' id='cset_name' value='<?=$iqr_cart['cset_name']?>'>
                            <span id='save_btn_name_info'></span>
                        </td>
                    </tr>
                    <tr id='cset_email_td'>
                        <td>收發信箱</td>
                        <td>
                            <a class="why" id="why_panel2" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel2'>
                                <p>＊填寫收發信箱功用：</p>
                                <p>1. 行動商店頁尾顯示的信箱</p>
                                <p>2. 倘若買家於您的商店內購買物品，系統將寄發通知信到此收發信箱</p>
                            </div>
                            <input type='text' placeholder='收發信箱' maxlength="64" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_email' id='cset_email' value='<?=$iqr_cart['cset_email']?>'>
                            <span id='save_cset_email_info'></span>
                        </td>
                    </tr>
                    <tr id='cset_company_td'>
                        <td>公司名稱</td>
                        <td>
                            <a class="why" id="why_panel3" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel3'>
                                <p>行動商店頁尾顯示的公司名稱</p>
                            </div>
                            <input type='text' placeholder='公司名稱' maxlength="32" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_company' id='cset_company' value='<?=$iqr_cart['cset_company']?>'>
                            <span id='save_cset_company_info'></span>
                        </td>
                    </tr>
                    <tr id='cset_address_td'>
                        <td>聯絡地址</td>
                        <td>
                            <a class="why" id="why_panel4" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel4'>
                                <p>行動商店頁尾顯示的聯絡地址</p>
                            </div>
                            <input type='text' placeholder='聯絡地址' maxlength="64" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_address' id='cset_address' value='<?=$iqr_cart['cset_address']?>'>
                            <span id='save_cset_address_info'></span>
                        </td>
                    </tr>
                    <tr id='cset_telphone_td'>
                        <td>市內電話</td>
                        <td>
                            <a class="why" id="why_panel5" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel5'>
                                <p>行動商店頁尾顯示的市內電話</p>
                            </div>
                            <input type='text' placeholder='市內電話' maxlength="10" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_telphone' id='cset_telphone' value='<?=$iqr_cart['cset_telphone']?>'>
                            <span id='save_cset_telphone_info'></span>
                        </td>
                    </tr>
                    <!--<tr id='cset_mobile_td'>
                        <td>手機號碼</td>
                        <td>
                            <a class="why" id="why_panel6" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel6'>
                                <p>行動商店頁尾顯示的手機號碼</p>
                            </div>
                            <input type='text' placeholder='手機號碼' maxlength="10" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_mobile' id='cset_mobile' value='<?=$iqr_cart['cset_mobile']?>'>
                            <span id='save_cset_mobile_info'></span>
                        </td>
                    </tr>-->
                    <tr id='cset_fax_td'>
                        <td>傳真號碼</td>
                        <td>
                            <a class="why" id="why_panel6" style="margin:0px 12px 0px -15px;">?</a>
                            <div class='prompt-box' id='prompt_panel7'>
                                <p>行動商店頁尾顯示的傳真號碼</p>
                            </div>
                            <input type='text' placeholder='傳真號碼' maxlength="10" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_fax' id='cset_fax' value='<?=$iqr_cart['cset_fax']?>'>
                            <span id='save_cset_fax_info'></span>
                        </td>
                    </tr>

                    <?php foreach ($payment_way as $key => $value): ?>
                    <tr>
                        <td><?=$value['pway_name']?></td>
                        <td>
                            <input type="radio" id="pway_<?=$value['pway_id']?>_open" name="pway[<?=$value['pway_id']?>]" value="0" <?=$value['selected_close']?>><label for="pway_<?=$value['pway_id']?>_open">關閉</label>
                            <input type="radio" id="pway_<?=$value['pway_id']?>_close" name="pway[<?=$value['pway_id']?>]" value="1" <?=$value['selected_open']?>><label for="pway_<?=$value['pway_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </table>
              </div>
            </form>
        </fieldset>

    </body>
</html>

<script type="text/javascript" src="/js/admin/system_center/rule_add.js"></script>
