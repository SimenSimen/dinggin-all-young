<link href="/css/gold/font-awesome.min.css" rel="stylesheet">
<!-------設定檔------------>
<link href="/css/gold/setting.css" rel="stylesheet" type="text/css">
<!-- rwd tables -->
<script src="/js/gold/jquery.min.js"></script>
<script src="/js/gold/bootstrap.min.js"></script>
<script>
  var allplay="<?=$this->lang['allplay'];?>";
  var selectfiled="<?=$this->lang['selectfiled'];?>";
</script>
<script src="/js/gold/rwd-table.min.js?v=5.0.3"></script>
<link rel="stylesheet" href="/js/gold/bootstrap.min.css">
<link rel="stylesheet" href="/js/gold/rwd-table.min.css?v=5.0.3">

<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['didetail'];//紅利點數明細?></header>
    <div class="wrapper">
        <div class="dividend"><?=$this->lang['subdivi'];//剩餘紅利?><b><?=number_format($dividend)?><?=$this->lang['pri'];//點?></b><?=$this->lang['divid'];//紅利點數?>
            <p>(<?=$this->lang['limit'];//有效期限?><?=$birthday?>)</p>
        </div>
        <div class="table-responsive" data-pattern="priority-columns">
            <table cellspacing="0" id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                <thead>
                    <tr>
                        <th data-priority="1"><?=$this->lang['time'];//時間?></th>
                        <th data-priority="1"><?=$this->lang['prinum'];//點數?></th>
                        <th data-priority="6"><?=$this->lang['info'];//來源說明?></th>
                        <th data-priority="1"><?=$this->lang['status'];//狀態?></th>
                    </tr>
                </thead>
                <tbody>
                  <? foreach ($dbdata as $value) :?>
                    <tr>
                      <td><?=$value['update_time']?></td>
                      <td><?=$value['d_val']?></td>
                      <td><?=$value['contitle'].':'.$value['d_des']?></td>
                      <td><?=$value['is_send']?></td>
                    </tr>
                  <? endforeach;?>
                </tbody>
            </table>
        </div>
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
