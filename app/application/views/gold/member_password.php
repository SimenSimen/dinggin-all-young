<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['editpwd'];//修改密碼?></header>
    <div class="wrapper wrapper-640">
        <form  method="post" class="j-forms" onSubmit="return check_form(this)">
            <div class="unit">
                <label class="label"><?=$this->lang['oldpw'];//舊密碼?></label>
                <input type="password" placeholder="<?=$this->lang['ioldpw'];//請輸入舊密碼?>" name="old_pw" >
            </div>
            <div class="j-row">
                <label class="label"><?=$this->lang['newpwd'];//新密碼?></label>
                <div class="span6 unit"><input type="password" placeholder="<?=$this->lang['inewpwd'];//請輸入新密碼?>" name="new_pw"></div>
                <div class="span6 unit"><input type="password" placeholder="<?=$this->lang['rnewpwd'];//再次輸入新密碼?>" name="re_new_pw" ></div>
            </div>
            <div class="footer"><input type="submit" class="primary-btn" value="<?=$this->lang['chkok'];//確認修改?>"></div>
        </form>
    </div>
    <!--/wrapper-->
    <!--
<div id="menu">
  <ul class="menu-nav">
      <li><a href="index.html"><i></i>關於我</a></li>
      <li><a href="team.html" class="now"><i></i>關於eoneda</a></li>
  </ul>
</div>
-->
</body>
</html>
<script>
function check_form(frm)
{
    if(frm.elements['old_pw'].value==''){
        alert("<?=$this->lang['ioldpw']?>");  //請輸入舊密碼
        frm.elements['old_pw'].focus();
        return false;   
    }else if((frm.elements['old_pw'].value).length<5){
        alert("<?=$this->lang['fiveold']?>");  //舊密碼至少五位數
        frm.elements['old_pw'].focus();
        return false;   
    }
    else if(frm.elements['new_pw'].value==''){
        alert("<?=$this->lang['inewpwd']?>");  //請輸入新密碼
        frm.elements['new_pw'].focus();
        return false;   
    }else if((frm.elements['new_pw'].value).length<5){
        alert("<?=$this->lang['fivenew']?>");  //新密碼至少五位數
        frm.elements['new_pw'].focus();
        return false;   
    }
    else if(frm.elements['re_new_pw'].value==''){
        alert("<?=$this->lang['irpwd']?>");   //請輸入再次密碼
        frm.elements['re_new_pw'].focus();
        return false;   
    }
    else
        return true;    
}
</script>