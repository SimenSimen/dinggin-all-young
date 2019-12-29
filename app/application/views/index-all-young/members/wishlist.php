<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">
            <main class="main-content">
                <div class="container openside pall0">
                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    <section class="content has-side">
                        <div class="title">Wishlist</div>
                        <ul class="products-list list-h">

                            <?php foreach ($favorite_data as $item) : ?>
                                <li class="item wow fadeIn" data-wow-delay="0.1s">
                                    <div class="box">
                                        <a class="btn delete" title="" id="" name="" value="" ref="">
                                            <i name="icon02" class="icon-close"></i>
                                        </a>
                                        <a href="<?= base_url('/products/detail/' . $item['prd_id']) ?>">
                                            <figure class="pic product"><img class="lazy" src="<?= base_url($item['prd_image']) ?>" alt="<?= $item['prd_name'] ?>"></figure>
                                            <div class="name"><?= $item['prd_name'] ?></div>
                                            <div class="offers">$<?= $item['prd_price01'] ?></div>
                                            <div class="offers offers-pink">$<?= $item['price'] ?></div>
                                        </a>
                                        <div class="wish-btn green">
                                            <a href="#">ADD TO CART</a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <input type="hidden" name="ToPage" id="ToPage" value="">
                    </section>
                </div>
            </main>
        </div>
    </div>
</div>