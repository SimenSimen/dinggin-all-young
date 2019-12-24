<script src="/js/myjava/region.js"></script>
<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['basic'];//基本資料?></header>
    <div class="wrapper wrapper-640">
        <form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)">
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['acconut'];//帳號?></label>
                    <p><?=$dbdata['d_account']?></p>
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['password'];//密碼?></label>
                        <p><a href="/gold/member_password"><?=$this->lang['editpwd'];//修改密碼?></a></p>
                </div>
            </div>
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['name'];//姓名?><span>*</span></label>
                    <p><?=$dbdata['name']?></p>
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['sex'];//性別?></label>
                    <div class="inline-group"><?=$dbdata['sex']?></div>
                </div>
            </div>
            <div class="j-row">
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['phone'];//電話?></label>
                    <input type="text" name="telphone" value="<?=$dbdata['telphone']?>" id="text" onkeyup="value=value.replace(/[^\d]/g,'') ">
                </div>
                <div class="span6 unit">
                    <label class="label"><?=$this->lang['mobile'];//手機?><span>*</span></label>
                    <input type="text" value="<?=$dbdata['mobile']?>" name="mobile" onKeyUp="value=value.replace(/[^\d]/g,'') ">
                </div>
               
            </div>
            <div class="j-row">
                <label class="label"><?=$this->lang['address'];//通訊地址?></label>
                <? if($setlang=='TW'):?>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="city" onChange="sel_area(this.value,'','countory')">
                                <option value="0">請選擇城市</option>
                                <?foreach ($city as $cvalue):?>
                                    <option value="<?=$cvalue['s_id']?>" <?=($dbdata['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
                                <? endforeach;?>
                            </select>
                            <i></i></label>
                    </div>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="countory" id="countory" >
                                <option value="0">請選擇鄉鎮地區</option>
                            </select>
                            <i></i></label>
                    </div>
                <? endif;?>
            </div>
            <div class="unit">
                <div class="input">
                    <input type="text" value="<?=$dbdata['address']?>" name="address">
                </div>
            </div>
            <div class="unit">
                <label class="label"><?=$this->lang['brithday'];//生日?></label>
                <p><?=$dbdata['birthday']?></p>
            </div>
            <div class="unit">
                <label class="label">E-mail</label>
                <div class="input">
                    <input type="text" value="<?=$dbdata['by_email']?>" name="by_email">
                </div>
            </div>
            <? if($_SESSION['MT']['is_member']=='Y'):?>
                <div class="unit">
                    <label class="label"><?=$this->lang['idnum'];//身份證字號?></label>
                    <p><?=$mdbdata['identity_num']?></p>
                </div>
                <div class="j-row">
                    <label class="label"><?=$this->lang['saddress'];//戶籍地址?><span>*</span></label>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="cen_city" onChange="sel_area(this.value,'','countory1')">
                              <?foreach ($city as $cvalue):?>
                                <option value="<?=$cvalue['s_id']?>" <?=($mdbdata['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
                              <? endforeach;?>
                            </select>
                            <i></i></label>
                    </div>
                    <div class="span6 unit">
                        <label class="input select">
                            <select name="cen_countory" id="countory1" >
                                <option>請選擇</option>  
                            </select><i></i></label>
                    </div>
                </div>
                <div class="unit">
                    <div class="input">
                        <input type="text" value="<?=$mdbdata['address']?>" name="cen_address">
                    </div>
                </div>
                <div class="j-row">
                    <label class="label"><?=$this->lang['accconfig'];//帳戶設定?><span>*</span></label>
                    <div class="span6 unit">
                        <input type="text" value="<?=$mdbdata['bank_name']?>" name="bank_name">
                    </div>
                    <div class="span6 unit">
                        <input type="text" value="<?=$mdbdata['bank_acconut']?>" name="bank_acconut">
                    </div>
                </div>
                <input type="hidden" name="is_member" value="Y">
            <? endif;?>
            <div class="dividend"><?=$this->lang['youhave'];//您目前有?><b><?=number_format($dbdata['d_dividend'])?></b><?=$this->lang['dividend'];//紅利點數?>
                <p>(<?=$this->lang['limit'];//有效期限?><?=$birthday?>)</p><a href="/gold/dividend"><?=$this->lang['ddtaile'];//紅利明細?></a></div>
            <div class="footer">
                <input type="hidden" name="dbname" value="<?=$dbname?>">
                <input type="submit" class="primary-btn" value="<?=$this->lang['chkok'];//確認修改?>">
                <input type="button" class="secondary-btn" value="<?=$this->lang['cencel'];//取消?>" onClick="javascript:window.location.href='/gold/member_list';">
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
<? if($dbdata['by_id']!=''):?>
    sel_area(<?=$dbdata['city']?>,<?=$dbdata['countory']?>,'countory');
<? endif;if($mdbdata['city']!=''):?>
    sel_area(<?=$mdbdata['city']?>,<?=$mdbdata['countory']?>,'countory1');
<? endif;?>
</script>