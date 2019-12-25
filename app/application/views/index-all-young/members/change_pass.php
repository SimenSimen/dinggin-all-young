<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">

                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>

                    <form action="" class="" method="post" onsubmit="">
                        <section class="content has-side">
                            <div class="title">Change Password</div>
                            <div class="editor mg">
                                <div class="form-box">

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-id"></i>
                                            <input class="form-control form-control02" type="password" name="old_pw" value="" placeholder="Old Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-lock"></i>
                                            <input class="form-control form-control02" type="password" name="new_pw" value="" placeholder="New Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-name"></i>
                                            <input class="form-control form-control02" type="password" name="re_new_pw" value="" placeholder="Determine the Password Again">
                                        </div>
                                    </div>


                                    <div class="pagination_box">
                                        <input type="hidden" name="dbname" value="buyer">
                                        <input type="reset" class="btn simple" value="Refill">
                                        <input type="submit" class="btn simple bg2 btn-green-bg" value="Send out">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>


                </div>
            </main>


        </div>
    </div>
</div>