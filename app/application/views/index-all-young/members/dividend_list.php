<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">
                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    <section class="content has-side">
                        <div class="title"><?= $this->lang['bonus_query'] ?></div>
                        <p class="mb-3"><?= $this->lang['subdivi'] ?><span class="color01"><?= $dividend; ?><?= $this->lang['pri'] ?></span><?= $this->lang['divid'] ?> (<?= $birthday ?> <?= $this->lang['expires'] ?> <?= number_format($pointsGonnaExpired, 2) ?> <?= $this->lang['pri'] ?>)</p>
                        <table class="table table-h table02 prl20">
                            <form action="" method="post" accept-charset="utf-8" enctype="" id="search_form"></form>
                            <thead>
                                <tr>
                                    <th><?= $this->lang['time'] ?></th>
                                    <th><?= $this->lang['prinum'] ?></th>
                                    <th><?= $this->lang['info'] ?></th>
                                    <th><?= $this->lang['status'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pageData['data'] as $value) : ?>
                                    <tr>
                                        <td data-title="Date：" nowrap><?= isset($value['send_dt']) ? $value['send_dt'] : $value['create_time'] ?></td>
                                        <td data-title="Points：" nowrap><span style="color:<?= $value['d_val'] > 0 ? 'green' : 'red' ?>"><?= $value['d_val'] > 0 ? '+' : '' ?><?= $value['d_val'] ?></span></td>
                                        <td data-title="Source Description："><?= $this->lang[$value['contitle']] . ':' . $value['d_des'] ?></td>
                                        <td data-title="Status：" nowrap><?= $value['is_send'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <input type="hidden" name="ToPage" id="ToPage" value="1">
                        </table>

                        <div class="pagination_box">
                            <p><?= $this->commonsLang['total'] ?> <?= $pageData['total_rows'] ?> <?= $this->commonsLang['count'] ?></p>
                            <div class="pagination_box" id="pagination">
                                <ul class="pagination en">

                                    <?php for ($i = 1; $i <= $pageData['total_pages']; $i++) : ?>
                                        <li class="<?= $currentPage == $i ? 'active' : '' ?>">
                                            <a href="<?= base_url('member/dividend?page=' . $i . (!is_null($pageSize) ? ('&pageSize=' . $pageSize) : '')) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor ?>
                                    <?php if ($currentPage < $pageData['total_pages']) : ?>
                                        <li>
                                            <a class="controls next" href="<?= base_url('member/dividend?page=' . ($currentPage + 1)  . (!is_null($pageSize) ? ('&pageSize=' . $pageSize) : '')) ?>" onclick="changepage(2)">
                                                <i name="icon02" class="icon-chevron-right"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('member/dividend?page=' . $pageData['total_pages'] . (!is_null($pageSize) ? ('&pageSize=' . $pageSize) : '')) ?>">Last &gt;&gt;</a>
                                        </li>
                                    <?php endif ?>
                                </ul>

                                <div class="page-info">
                                    <select class="form-control en" name="" id="" onchange="changepage(this.value);">
                                        <option value="1" selected="">page 1</option>
                                        <option value="2">page 2</option>
                                        <option value="3">page 3</option>
                                        <option value="4">page 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
            </main>


        </div>
    </div>
</div>