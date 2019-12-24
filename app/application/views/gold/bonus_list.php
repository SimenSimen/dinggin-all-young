
<!-- rwd tables -->
<script>
  var allplay="<?=$this->lang['allplay'];?>";
  var selectfiled="<?=$this->lang['selectfiled'];?>";
</script>
<link rel="stylesheet" href="/js/gold/bootstrap.min.css">
<link rel="stylesheet" href="/js/gold/rwd-table.min.css?v=5.0.3">
</head>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['bonus_list'];//獎金查詢?></header>
<div class="wrapper">
   <div class="table-responsive" data-pattern="priority-columns">
       <table cellspacing="0" id="tech-companies-1" class="table table-small-font table-bordered table-striped">
          <thead>
             <tr>
                <th><?=$this->lang['yearmon'];//年月?></th>
                <th data-priority="1"><?=$this->lang['one'];//一代獎金?></th>
                <th data-priority="3"><?=$this->lang['two'];//二代獎金?></th>
                <th data-priority="3"><?=$this->lang['family'];//體系獎金?></th>
                <th data-priority="3"><?=$this->lang['deafult'];//其它?></th>
                <th data-priority="3"><?=$this->lang['sub'];//扣款?></th>
                <th data-priority="6"><?=$this->lang['total'];//原佣總計?></th>
                <th data-priority="6"><?=$this->lang['tax'];//所得稅?></th>
                <th data-priority="6"><?=$this->lang['icote'];//2代健保?></th>
                <th data-priority="1"><?=$this->lang['itotal'];//總計?></th>
                <th data-priority="1"><?=$this->lang['option'];//操作?></th>
             </tr>
          </thead>
          <tbody>
            <? foreach ($dbdata as $key => $value):?>
              <tr>
                <th><?=$value['date']?></th>
                <td class="btrGreen"><?=number_format($value['bonus01'])?></td>
                <td class="btrGreen"><?=number_format($value['bonus02'])?></td>
                <td class="btrGreen"><?=number_format($value['bonus03'])?></td>
                <td class="btrGreen"><?=number_format($value['bonus04'])?></td>
                <td class="btrRed">-<?=number_format($value['bonus05'])?></td>
                <td><?=number_format($value['iOTotal'])?></td>
                <td><?=$value['itax']?></td>
                <td ><?=$value['i2nhi']?></td>
                <td><?=number_format($value['iTotal'])?></td>
                <td><a href="/gold/bonus_info/<?=$value['date']?>"><?=$this->lang['detail'];//明細?></a></td>
              </tr>   
            <?endforeach;?>
                
          </tbody>
       </table>
    </div>
<script src="/js/gold/jquery.min.js"></script>
<script src="/js/gold/bootstrap.min.js"></script>
<script src="/js/gold/rwd-table.min.js?v=5.0.3"></script>
</div><!--/wrapper-->
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
<style>
  .btrRed{
    color: RED;
  }
  .btrGreen{
    color: GREEN;
  }
</style>