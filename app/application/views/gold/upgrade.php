<script src="/js/myjava/region.js"></script>
<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['update'];//升級VIP會員?></header>
    <div class="wrapper wrapper-640">
        <form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)">
            <div class="unit">
                <label class="label"><?=$this->lang['idnum'];//身份證字號?><span>*</span></label>
                <input type="text" placeholder="<?=$this->lang['iidnum'];//請輸入身份證字號?>" name="identity_num" maxlength="10" required >
            </div>
            <div class="j-row">
                <label class="label">
                    <?=$this->lang['address'];//戶籍地址?>
                    <span>*</span>
                    <input type="checkbox" id="somemember" value="1"><?=$this->lang['someadd'];//同通訊地址?>
                </label>
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
                            <select name="countory" id="countory" required >
                                <option value="0">請選擇鄉鎮地區</option>
                            </select>
                            <i></i></label>
                    </div>
                <? endif;?>
            </div>
            <div class="unit">
                <div class="input">
                    <input type="text" placeholder="<?=$this->lang['realadd'];//請填寫正確地址?>" name="address" id="address" required >
                </div>
            </div>
            <div class="j-row">
                <label class="label"><?=$this->lang['accconfig'];//帳戶設定?><span>*</span></label>
                <div class="span6 unit">
                    <input type="text" placeholder="<?=$this->lang['bname'];//銀行名稱?>" name="bank_name" required >
                </div>
                <div class="span6 unit">
                    <input type="text" placeholder="<?=$this->lang['bacc'];//銀行帳號?><?=$this->lang['inputnum'];//(請輸入數字)?>" name="bank_account" required onKeyUp="value=value.replace(/[^0-9]/g,'')">
                </div>
            </div>
            <div class="footer">
                 <input type="hidden" name="dbname" value="<?=$dbname?>">
                 <input type='hidden' name='by_id' id='by_id' value='<?=$by_id?>'>
                <button type="submit" class="primary-btn"><?=$this->lang['s_send'];//送出?></button>
                <button type="reset" class="secondary-btn"><?=$this->lang['s_restart'];//重填?></button>
            </div>
        </form>
    </div>
</body>
</html>
<script>
<? if($_SESSION['RT']['countory']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm){
    if(frm.elements['city'].value=='0'){
        alert("請選擇城市");
        frm.elements['city'].focus();
        return false;   
    }
    else if(frm.elements['countory'].value=='0'){
        alert("請選擇鄉鎮地區");
        frm.elements['countory'].focus();
        return false;   
    }
    else
        return true;    
}
  $('#somemember').click(function(){    
    var bid=$('#by_id').val();
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'type=upgrade&bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
          $('select[name=city]').val(json.city);
          $('select[name=countory] option').remove();
          $('select[name=countory]').prepend("<option value='"+json.countory_id+"'>"+json.countory+"</option>");
          $('#address').val(json.address);
      }
    });
  });
</script>
