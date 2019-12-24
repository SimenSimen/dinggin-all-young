<body class="bg-style"> 
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['login'];//會員登入?></header>
    <div class="wrapper wrapper-640">
        <form action="/gold/login_set" class="j-forms" method="post" onSubmit="return check_form(this)">
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['account'];//帳號?></label>
                    <input type="text" placeholder="<?=$this->lang['default'];//預設為手機號碼?>" maxlength="10" name="mobile" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$account?>">
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['password'];//密碼?></label>
                    <input type="password" placeholder="<?=$this->lang['worderror'];//文字長度不超過16字元?>" name="password" value="<?=$password?>">
                </div>
            </div>
            <div class="unit">
                <div style="float:right; padding:0 5px 20px;">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1" <?=(empty($remember))?'':'checked';?>><i></i><?=$this->lang['remember'];//記住我?></label>
                </div>
            </div>
            <div class="unit" style="text-align:center; clear:both;">
                <div>
                    <a href="/gold/register" class="link"><?=$this->lang['regidter'];//註冊會員?></a>
                    <a href="/gold/forgot" class="link"><?=$this->lang['fotget'];//忘記密碼?></a>
                </div>
            </div>
            <div class="footer">
                <input type="hidden" name="burl" value="<?=$burl?>">
                <input type="submit" class="primary-btn" value="<?=$this->lang['s_send'];//送出?>">
                <input type="reset" class="secondary-btn" value="<?=$this->lang['s_restart'];//重填?>">
            </div>
        </form>
    </div>

</body>

</html>
<script>
function check_form(frm)
{
    if(frm.elements['mobile'].value==''){
        alert("<?=$this->lang['plsacc'];//請輸入帳號?>");
        frm.elements['mobile'].focus();
        return false;   
    }
    else if(frm.elements['password'].value==''){
        alert("<?=$this->lang['plspwd'];//請輸入密碼?>");
        frm.elements['password'].focus();
        return false;   
    }
    else
        return true;    
}
</script>