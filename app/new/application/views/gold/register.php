<script src="/js/myjava/region.js"></script>
<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['regidter'];//註冊會員?></header>
    <div class="wrapper wrapper-640">
        <form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['account'];//帳號?><span>*&nbsp;(<?=$this->lang['input_mobile'];//請輸入手機號碼?>)</span></label>
                    <input type="text" name="d_account" placeholder="<?=$this->lang['default'];//預設為手機號碼?>" value="<?=$_SESSION['RT']['d_account']?>" onKeyUp="value=value.replace(/[^\d]/g,'')" maxlength="10" required>
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['password'];//密碼?><span>*</span></label>
                    <input type="password" placeholder="<?=$this->lang['worderror'];//文字長度不超過16字元?>" name="by_pw" required >
                </div>
            </div>
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['dname'];//姓名?><span>*</span></label>
                    <input type="text" placeholder="<?=$this->lang['plsname'];//請輸入姓名?>" name="name"  value="<?=$_SESSION['RT']['name']?>">
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['sex'];//性別?><span>*</span></label>
                    <div class="inline-group">
                        <label class="radio">
                            <input type="radio" name="sex" checked value="male" <?=($_SESSION['RT']['sex']=='male')?'checked':'';echo ($_SESSION['RT']['sex']=='')?'checked':'';?>><i></i><?=$this->lang['male'];//先生?>
                        </label>
                        <label class="radio">
                            <input type="radio" name="sex" value="female" <?=($_SESSION['RT']['sex']=='female')?'checked':'';?>><i></i><?=$this->lang['female'];//小姐?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['phone'];//電話?></label>
                    <input type="text" maxlength="10" placeholder="<?=$this->lang['plsphone'];//請輸入正確的聯絡電話?>" name="telphone" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['telphone']?>">
                </div>
            </div>
            <div class="j-row">
                <label class="label"><?=$this->lang['address'];//通訊地址?><span>*</span></label>
                <? if($setlang=='TW'):?>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="city" onChange="sel_area(this.value,'','countory')" required >
                                <option value="0">請選擇城市</option>
                                <?foreach ($city as $cvalue):?>
                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
                                <? endforeach;?>
                            </select>
                            <i></i></label>
                    </div>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="countory" id="countory"  required>
                                <option value="0">請選擇鄉鎮地區</option>
                            </select><i></i></label>
                    </div>
                <? endif;?>
            </div>
            <div class="unit">
                <div class="input">
                    <input type="text" placeholder="<?=$this->lang['plsaddress'];//請填寫正確地址?>" name="address" required value="<?=$_SESSION['RT']['address']?>">
                </div>
            </div>
            <div class="j-row">
                <label class="label"><?=$this->lang['brithday'];//生日?><span>*</span></label>
                <div class="span4 unit">
                    <div class="input">
                        <input type="text" maxlength="4" placeholder="<?=$this->lang['exyear'];//例: 1980?>" name="d_year" onKeyUp="value=value.replace(/[^\d]/g,'')" onblur="check_num('y',this);" required value="<?=$_SESSION['RT']['d_year']?>"> 
                        <label class="icon-right" for="text"><?=$this->lang['year'];//年?></label>
                    </div>
                </div>
                <div class="span4 unit">
                    <div class="input">
                        <input type="text" placeholder="<?=$this->lang['exmonth'];//例: 11?>" maxlength="2" name="d_month" onKeyUp="value=value.replace(/[^\d]/g,'');" onblur="check_num('m',this);" required value="<?=$_SESSION['RT']['d_month']?>">
                        <label class="icon-right" for="text"><?=$this->lang['month'];//月?></label>
                    </div>
                </div>
                <div class="span4 unit">
                    <div class="input">
                        <input type="text" placeholder="<?=$this->lang['exday'];//例: 23?>" maxlength="2" name="d_day" onKeyUp="value=value.replace(/[^\d]/g,'')" onblur="check_num('d',this);" required value="<?=$_SESSION['RT']['d_day']?>">
                        <label class="icon-right" for="text"><?=$this->lang['day'];//日?></label>
                    </div>
                </div>
            </div>
            <div class="unit">
                <label class="label">E-mail</label>
                <div class="input">
                    <input type="text" placeholder="<?=$this->lang['plsmail'];//請輸入個人信箱?>" name="by_email" value="<?=$_SESSION['RT']['by_email']?>">
                </div>
            </div>
            <div class="unit">
                <label class="checkbox">
                    <input type="checkbox" name="chk_ok" value="ok">
                    <i></i><?=$this->lang['iread'];//我已詳閱?>
                        <a href="/gold/policies/service" class="link" target="_blank"><?=$this->lang['msevice'];//會員服務條款?></a> <?=$this->lang['and'];//和?> 
                        <a href="/gold/policies/privacy" class="link" target="_blank"><?=$this->lang['privacy'];//隱私權政策?></a>
                </label>
            </div>
            <div class="footer">
                <input type="hidden" name="dbname" value="<?=$dbname?>">
                <input type="submit" class="primary-btn" value="<?=$this->lang['s_send'];//送出?>">
                <input type="reset" class="secondary-btn" value="<?=$this->lang['s_restart'];//重填?>">
            </div>
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
<? if($_SESSION['RT']['city']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm)
{

    if(frm.elements['d_account'].value==''){
        alert("<?=$this->lang['plsacc'];//請輸入帳號?>");
        frm.elements['d_account'].focus();
        return false;   
    }
    else if(frm.elements['by_pw'].value==''){
        alert("<?=$this->lang['plspwd'];//請輸入密碼?>");
        frm.elements['by_pw'].focus();
        return false;   
    }else if((frm.elements['by_pw'].value).length<5){
        alert("<?=$this->lang['pwdfive'];//密碼至少五位數?>");
        frm.elements['by_pw'].focus();
        return false;   
    }
    /*else if(frm.elements['name'].value==''){
        alert("<?=$this->lang['plsname'];//請輸入姓名?>");
        frm.elements['name'].focus();
        return false;   
    }else if(frm.elements['by_email'].value==''){
        alert("<?=$this->lang['plsmail'];//請輸入信箱?>");
        frm.elements['by_email'].focus();
        return false;   
    }*/else if(frm.elements['d_year'].value==''||frm.elements['d_month'].value==''||frm.elements['d_day'].value==''){
        alert("<?=$this->lang['plsbri'];//請確認生日是否正確填寫?>");
        frm.elements['d_year'].focus();
        return false;   
    }else if($("input[name=chk_ok]:checked").val()!='ok'){
        alert("<?=$this->lang['plsview'];//請勾選已詳閱條款和政策?>");
        frm.elements['chk_ok'].focus();
        return false;   
    }
    else
        return true;    
}
function check_num(type,num){
    var num=num.value;
    if(num!=''){
        if(type=='y'){
            if(num><?=date('Y')?> ){
                alert("<?=$this->lang['plsyear'];//請輸入正確年份?>");
                $('input[name="d_year"]').val('');
            }
        }
        if(type=='m'){
            if(num==0 || 13<num){
                alert("<?=$this->lang['plsmonth'];//請輸入正確月份?>");
                $('input[name="d_month"]').val('');
            }
        }
        if(type=='d'){
            if(num==0 || 31<num){
                alert("<?=$this->lang['plsday'];//請輸入正確日期?>");
                $('input[name="d_day"]').val('');
            }
        }
    }
}
    
</script>
