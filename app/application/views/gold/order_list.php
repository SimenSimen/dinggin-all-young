<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
      <header class="main-top">
            <div class="container">
                <ol class="breadcrumb list-inline">
                    <li><a href="index.php"><span>首頁</span></a></li>
                    <li><a href="member.php"><span>會員專區</span></a></li>
                    <li><a href="#"><span>個人訂單查詢</span></a></li>
                </ol>
            </div>
          </header>
      <div class="container">
        <aside class="side">
          <ul class="side-nav list-v">
  <li class="active"><a href="products.php">進入商城</a></li>
  <li><a href="member_wishlist.php">最愛商品</a></li>
  <li><a href="order.php">個人訂單查詢</a></li>
  <li><a href="member_dividend.php">紅利點數查詢</a></li>
  <li><a href="member_info.php">基本資料</a></li>
  <li><a href="member_address.php">常用寄貨地址</a></li>
  <li><a href="member_announcement.php">會員權益公告</a></li>
  <li><a href="invite_share.php">邀請碼分享</a></li>
  <!--<li><a href="member_active.php">活躍指標</a></li>-->
  <li><a href="member_upgrade.php">升級經營會員</a></li>
  <li><a href="member_order.php">經營會員銷售訂單查詢</a></li>
  <li><a href="organization.php">組織表</a></li>
  <li><a href="invoice.php">我要請款</a></li>
  <li><a href="member_bonus.php">佣金查詢</a></li>
  <li><a href="member_dividend_fun.php">購物金查詢</a></li>
  <li><a href="member_leader_announcement.php">經營會員權益公告</a></li>
</ul>
          
                </aside>
        <section class="content has-side">
          <div class="title">個人訂單查詢</div>
          <div class="select-bar clearfix">
            
                        <div class="form-group clearfix">
                            <label class="control-label">訂單編號</label>
                            <div class="control-box">
                                <input class="form-control" type="text" name="" id="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label">訂單區間</label>
                            <div class="control-box datepicker">
                                <input class="form-control" type="text" name="" id="datepicker" placeholder="">
                                <input class="form-control" type="text" name="" id="datepicker02" placeholder="">
                            </div>
                        </div>
                        <a  href="order.php" class="more-search2">搜尋</a>
                        
          </div>
            <table class="table table-h order-table refund-table">
                        <thead>
                            <tr>
                                <th>訂單編號</th>
                                <th>訂單日期</th>
                                <th>訂單狀態</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<3; $i++) { ?>
                            <tr>
                                <td data-title="訂單編號："><a href="order_detail.php" class="num-link">0164864864</a></td>
                                <td data-title="訂單日期：">2015-12-25</td>
                                <td data-title="訂單狀態：">已完成</td>
                                <td class="btn-holder"><a href="refund.php">申請退貨</a></td>
                                <td>
                                    <a href="order_detail.php" class="btn more"><i class="icon-search"></i> 詳細資訊</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <div class="pagination_box">
                    <p>共 N 筆</p>
                    
<ul class="pagination">
    <li><a class="controls prev" href="#" title="上一頁"><i class="icon-chevron-left"></i></a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li class="active"><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a class="controls next" href="#" title="下一頁"><i class="icon-chevron-right"></i></a></li>
</ul>
<div class="page-info">
    <select class="form-control" name="" id="">
        <option value="">第 1 頁</option>
        <option value="">第 2 頁</option>
        <option value="">第 3 頁</option>
    </select>
</div>

                    </div>

        </section>
      </div>
    </main>