<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['talkapp'];//EBH留言?></header>
    <div class="wrapper">
        <ul class="talk-list">
            <? foreach ($dbdata as $value):?>
                <li>
                    <a href="/gold/talkapp/<?=$value['b_id']?>">
                        <?=($value['d_read']=='N')?'<span>N</span>':'';?>
                        <small><?=$value['create_time']?></small>
                        <h6><?=$value['name']?></h6>
                        <p><?=$value['d_content']?></p>
                    </a>
                </li> 
            <? endforeach;?>
        </ul>
    </div>

