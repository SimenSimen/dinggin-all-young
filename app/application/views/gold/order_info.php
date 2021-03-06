<link rel="stylesheet" href="/css/gold/baze.modal.css">
<script src="/js/gold/baze.modal.js"></script> 
<body class="bg-style"> 
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['odetail'];//訂單明細?></header>
    <div class="bzm-content" id="modal2" data-title="<?=$this->lang['return'];//申請退貨?>">
        <form action="/gold/data_AED" method="post">
        <div id="opp">
          <div class="opp">
            <strong><?=$this->lang['name'];//退款人姓名?></strong>
            <input name="back_name" type="text" placeholder="<?=$this->lang['iname'];//請輸入退款人姓名?>" required>
          </div>
          <div class="opp">
            <strong><?=$this->lang['bbank'];//退款銀行名稱?></strong>
            <input name="back_bank" type="text" placeholder="<?=$this->lang['ibank'];//請輸入銀行名稱?>" required>
          </div>
          <div class="opp">
            <strong><?=$this->lang['bacc'];//退款銀行帳號?></strong>
            <input name="back_account" type="text" placeholder="<?=$this->lang['ibacc'];//請輸入銀行帳號?>" required onkeyup="value=value.replace(/[^-^\d]/g,'') ">
          </div>
          <div class="opp"><strong><?=$this->lang['bnote'];//退貨原因?></strong>
            <textarea name="back_note" cols="" rows="" placeholder="<?=$this->lang['ibnote'];//請輸入退貨原因?>" ></textarea>
          </div>
          <input type="hidden" value="order" name="dbname">
          <input type="hidden" value="<?=$oid?>" name="d_id">
          <input type="submit" value="<?=$this->lang['s_send'];//確認送出?>" class="opp_ok">
        </div>
        </form>
    </div>
    <div class="num">
      <b><?=$this->lang['num'];//編號?> No.<?=$dbdata['order_id']?></b>
         <?=$this->lang['odate'];//訂單日期：?><?=$dbdata['create_time']?>
    </div>
    <div class="wrapper">
        <table width="0" border="0" id="order_tab">
            <tr>
                <th width="70%"><?=$this->lang['option'];//品項?></th>
                <th><?=$this->lang['money'];//金額?></th>
            </tr>
            <? foreach ($details as $dvalue):?>
                <tr>
                    <td><strong><?=$dvalue['prd_name']?></strong></td>
                    <td>
                        <?=number_format($dvalue['total_price'])?>
                    </td>
                </tr>
                <? endforeach;?>
        </table>
        <? if($dbdata['product_flow']==7):?>
          <div class="order"><a href="javascript: void(0)" onClick="backchk()" ><?=$this->lang['backing'];//退貨處理中?></a></div>
        <? endif;
           if(in_array($dbdata['product_flow'],array('0','1','2'))):
        ?>
            <div class="order" id="ngehe" data-target="#modal2"><a href="javascript: void(0)"><?=$this->lang['return'];//申請退貨?></a></div>
        <? endif;?>
         
        
        

        <div class="order_money">
          <?=$this->lang['total'];//金額總計?>：<?=number_format($dbdata['total_price'])?><?=$this->lang['tw'];//元?>
          <br />
          <?=$this->lang['sub'];//紅利折抵?>：<b><?=number_format(($sdata['bonus_sub']!='')?$sdata['bonus_sub']:'0')?></b><?=$this->lang['pri'];//點?>
          <em>(1<?=$this->lang['divid'];//紅利?> = $1<?=$this->lang['tw'];//元?>)</em>
          <? if($sdata['is_return']=='Y'):?>
            <br />
            <span style="color:red;font-size: 15px;">
              <?=$sdata['return_time'].$this->lang['rdivid'].$sdata['bonus_sub'].$this->lang['pri'] //退還紅利 點?>  
            </span>
          <? endif;?>
            <br />
            <?=$this->lang['sendmo'];//運費?>：
            <b><?=($dbdata['lway_price']!='')?number_format($dbdata['lway_price']).$this->lang['tw']:'0'.$this->lang['tw'].'('.$this->lang['nopay'].')'; //元 （達免運標準）?></b> 
          </div>
        <div class="order_money2">
          <?=$this->lang['pay'];//實付金額?>：<b><?=number_format($dbdata['total_price']+$dbdata['lway_price'])?></b>
          <?=$this->lang['tw'];//元?>
        </div>
        <? if($dbdata['pay_way_id']==4):
            if($dbdata['atmno']!=''):
        ?>
          <ul class="order_info">
              <h6><?=$this->lang['atminfo'];//匯款資訊?></h6>
              <li><strong><?=$this->lang['atmfive'];//匯款後五碼?></strong>
                <span><?=$dbdata['atmno']?></span>
              </li>
              <li><strong><?=$this->lang['atmdate'];//匯款日期?></strong>
                <span><?=$dbdata['atmdate']?></span>
              </li>
          </ul>
        <?
            else:
              if(!in_array($dbdata['product_flow'],array('3','7'))):
        ?>
        <form method="post">
          <ul class="order_info">
              <h6><?=$this->lang['atmask'];//匯款通知?></h6>
              <li><strong><?=$this->lang['i_input'].$this->lang['atmfive'];//請輸入匯款後五碼?></strong>
                <span>
                  <input type="text" name="atmno" maxlength="5" onKeyUp="value=value.replace(/[^\d]/g,'') "  required><input type="date" name="atmdate" max="<?=date('Y-m-d')?>"  required>
                  <input type="submit" value="<?=$this->lang['s_send'];//確定?>">
                </span>
              </li>
          </ul>
        </form>
        <? endif;endif;endif;?>
        <ul class="order_info">
            <h6><?=$this->lang['vinfo'];//發票資訊?></h6>
            <li><strong><?=$this->lang['sname'];//收件人姓名?>：</strong>
              <span><?=$dbdata['name']?></span>
            </li>
            <li class="c1"><strong><?=$this->lang['sphoto'];//收件人電話?>：</strong>
              <span><?=$dbdata['phone']?></span>
            </li>
            <li><strong><?=$this->lang['ymail'];//您的信箱?>：</strong>
              <span><?=$dbdata['email']?></span>
            </li>
            <li class="c1"><strong><?=$this->lang['saddress'];//收件人地址?>：</strong>
              <span><?=$dbdata['zip'].$dbdata['county'].$dbdata['area'].$dbdata['address']?></span></li>
            <li><strong><?=$this->lang['ordertotal'];//訂單總金額?>：</strong><span><?=number_format($dbdata['total_price'])?>元</span>
            </li>
            <li class="c1"><strong><?=$this->lang['paytype'];//付款方式?>：</strong>
              <span><?=$dbdata['pay']?></span>
            </li>
            <? //if($dbdata['pay_way_id']==8):?>
            <li ><strong><?=$this->lang['paystatus'];//付款狀態?>：</strong>
              <span><?=$dbdata['status']?></span>
            </li>
            <?// endif;?>
            <li class="c1"><strong><?=$this->lang['sendtype'];//配送方式?>：</strong>
              <span><?=$dbdata['logis']?><?=$dbdata['shop_address'];?></span>
            </li>            
            <li ><b><strong><?=$this->lang['vinfo'];//發票資訊?>：</strong></b>
              <span><?=$this->lang['rece'];//電子式發票?> <?=($dbdata['rece']!='')?$dbdata['rece']:'';?></span>
            </li>
        </ul>
    </div>

</body>

</html>
<script>
function backchk(){
  alert("<?=$this->lang['noback']?>");//退貨處理中，請勿重複申請退貨，若有任何問題歡迎隨時來電或留言
}
var elems = $('[data-baze-modal]');
elems.bazeModal({
onOpen: function () {
  alert('opened');
},
onClose: function () {
  alert('closed');
}
});
$('#ngehe').bazeModal();
</script>
</script>