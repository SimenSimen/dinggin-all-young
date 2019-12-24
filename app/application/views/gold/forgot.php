<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['fotget'];//忘記密碼?></header>
    <div class="wrapper wrapper-640">
        <form action="/gold/forgot_set" method="post" onsubmit="return check_form(this)" class="j-forms">
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['account'];//帳號?></label>
                    <input type="text" placeholder="<?=$this->lang['default'];//預設為手機號碼?>" name="acconut" onKeyUp="value=value.replace(/[^\d]/g,'')">
                </div>
                <div class="span6 unit">
                    <label class="label">E-mail</label>
                    <input type="text" placeholder="<?=$this->lang['plsmail'];//請輸入個人信箱?>" name="email">
                </div>
            </div>
            <div class="footer">
                <input type="submit" class="primary-btn" value="<?=$this->lang['s_send'];//送出?>">
            </div>
        </form>
    </div>
    <!--/wrapper-->
</body>

</html>
