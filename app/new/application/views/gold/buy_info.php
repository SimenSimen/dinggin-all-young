<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['buy_info'];//APP銷售訂單明細?></header>
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
    
        <div class="order_money">
          <?=$this->lang['total'];//金額總計?>：<?=number_format($dbdata['proprice'])?><?=$this->lang['tw'];//元?>
          <br />
          <?=$this->lang['sub'];//紅利折抵?>：<b><?=number_format(($sdata['bonus_sub']!='')?$sdata['bonus_sub']:'0')?></b><?=$this->lang['pri'];//點?>
          <em>(1<?=$this->lang['divid'];//紅利?> = $1<?=$this->lang['tw'];//元?>)</em>   
            <br />
            <?=$this->lang['sendmo'];//運費?>：
            <b><?=($dbdata['lway_price']!='')?number_format($dbdata['lway_price']).$this->lang['tw']:'0'.$this->lang['tw'].'('.$this->lang['nopay'].')'; //元 （達免運標準）?></b> 
          </div>
        <div class="order_money2">
          <?=$this->lang['pay'];//實付金額?>：<b><?=number_format($dbdata['total_price'])?></b>
          <?=$this->lang['tw'];//元?>
        </div>        
        <ul class="order_info">
            <h6><?=$this->lang['orderinfo'];//訂購資訊?></h6>
            
            <li><strong><?=$this->lang['bname'];//購買人姓名?></strong>
              <span><?=$bname?></span>
            </li>
            <li><strong><?=$this->lang['btype'];//訂購者身份?></strong>
              <span><?=$d_is_member?></span>
            </li>
            <li ><strong><?=$this->lang['orderstatus'];//訂單狀態?></strong>
              <span><?=$product_flow?></span>
            </li>
            <li><strong><?=$this->lang['patstatus'];//付款狀態?></strong>
              <span><?=$status?></span>
            </li>
         
    
        </ul>
    </div>

</body>

</html>
