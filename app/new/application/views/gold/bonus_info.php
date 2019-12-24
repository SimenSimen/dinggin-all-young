
<!-- rwd tables -->
<link rel="stylesheet" href="/js/gold/bootstrap.min.css">
<link rel="stylesheet" href="/js/gold/rwd-table.min.css?v=5.0.3">

<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['bdetail'];//獎金明細?></header>
<div class="wrapper">
   <div class="table-responsive" data-pattern="priority-columns">
       <table cellspacing="0" id="tech-companies-1" class="table table-small-font table-bordered table-striped">
          <thead>
             <tr>
                <th><?=$this->lang['bname'];//獎金名稱?></th>
                <th data-priority="1"><?=$this->lang['pv'];//PV值?></th>
                <th data-priority="1"><?=$this->lang['bonus'];//獎金?></th>
                <th data-priority="6"><?=$this->lang['content'];//來源說明?></th>
             </tr>
          </thead>
          <tbody>
            <? foreach ($dbdata as $key => $value):?>
              <tr>
                <th><?=$value['d_type']?></th>
                <td><?=$value['d_pv']?></td>
                <td><?=$value['d_bonus']?></td>
                <td><?=$value['d_content']?></td>
              </tr> 
            <?endforeach;?> 
             
          </tbody>
       </table>
    </div>
    <div class="bonus"><?=$this->lang['total'];//獎金總計NT?>$<b><?=number_format($itotal)?></b><?=$this->lang['tw'];//元?></div>
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