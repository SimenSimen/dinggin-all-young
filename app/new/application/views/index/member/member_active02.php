				<section class="content has-side">
					<div class="title">活躍指標</div>
					 <table class="table table-h table02">
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>繳款狀態</th>
                                <th>付款方式</th>
                                <th>發票號碼</th>
                                <th>回報匯款後五碼</th>
                                <th>匯款日期</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<5; $i++) { ?>
                            <tr>
                                <td data-title="日期：">2017-3</td>
                                <td data-title="繳款狀態：">已付款</td>
                                <td data-title="付款方式：">ATM轉帳</td>
                                <td data-title="發票號碼："> LL35677655</td>
                                <td data-title="回報匯款後五碼：" class="number">
                                    <div class="control-box">
                                        <input class="form-control" type="text" name="" id="" placeholder="">
                                    </div>
                                </td>
                                <td  data-title="匯款日期：" class="number">
                                    <div class="control-box">
                                        <input class="form-control" type="text" name="" id="datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                      <div class="pagination_box">
                        <a href="member_active" class="btn simple bg2">活躍指標列表 <i class="icon-chevron-right"></i></a>
                    </div>
				</section>
			</div>
		</main>
<script src="js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
