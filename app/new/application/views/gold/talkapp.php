<body class="bg-style" onload="scrollTo(0,document.body.scrollHeight)">
    <header class="header">
        <? if($b_id!=''):?>
            <a href="javascript:history.go(-1);">&lt;</a><?=$this->lang['talkapp'];//客服中心?>
        <? else:?>
            <a href="/gold/index/<?=$_SESSION['AT']['account']?>">&lt;</a><?=$this->lang['talkapp'];//客服中心?>
        <? endif;?>
    </header>
    <div class="wrapper" id="talk1">
        <div id="talk">
            <? 
            foreach ($dbdata as $value):
                if($value['d_type']==$left):
            ?>
                    <div class="our-talk">
                        <span class="our-text">
                            <h6><?=$name?></h6>
                            <div class="o-word"><?=$value['d_content']?></div>
                            <time><?=$value['create_time']?></time>
                        </span>
                    </div>
            <?  endif;
                if($value['d_type']==$right):
            ?>
                    <div class="your-talk">
                        <span class="your-text">
                            <div class="y-word">
                                <?=$value['d_content']?>
                            </div>
                            <time><?=$value['create_time']?></time>
                        </span>
                    </div>

            <?  endif;
            endforeach;
            ?>
            
            
        </div>
        <form method="post" action="/gold/data_AED">
            <div class="foot_bar">
                <input type="hidden" name="b_id" value="<?=$b_id?>">
                <input type="hidden" name="dbname" value="talkapp">
                <input name="d_content" type="text" class="t_txt" placeholder="<?=$this->lang['input'];//輸入文字區?>">
                <input type="submit" value="<?=$this->lang['send'];//發送?>" class="t_send">
            </div>
        </form>
    </div>
