<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">
                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    <section class="content has-side">
                        <div class="title">Shopping Gold Inquiry</div>
                        <p class="mb-3">Remaining <span class="color01">$<?= number_format($current_money) ?></span>Shopping Gold</p>
                        <table class="table table-h table02">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transfer Member</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>

                                <? $icount = 0; ?>
                                <?php if (!empty($shopping_money)) : ?>
                                    <?php foreach ($shopping_money as $key => $value) : ?>
                                        <tr>
                                            <td data-title="Date："><?= $value['create_time'] ?></td>
                                            <td data-title="Transfer Member："><?= $value['name'] ?></td>
                                            <td data-title="Amount：">
                                                <span class="color02">
                                                    <?= number_format($value['d_shopping_money']) ?>
                                                </span>
                                            </td>
                                            <td data-title="Description："><?= $value['d_content'] ?></td>
                                            <? $icount++; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="pagination_box">
                            <p>Total <?= $icount ?> Data</p>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</div>