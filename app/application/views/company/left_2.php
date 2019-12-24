<nav id="menu" class="menu">
    <header class="menu-header">
        <span class="menu-header-title"><?=$DatabaseCategory?></span>
    </header>
    <section class="menu-section">
        <ul>
            <?php 
                $news=$this->mod_business->select_from_order('iqr_classify', 'member_id', 'desc', array('member_id'=>$this->member_id));    
                if(!empty($news)){
                    echo '<li style="margin-top:7px;">space</li>';
                    echo '<li id="meunt2">'.$Database.'</li>';
                    foreach($news as $val){
                        echo '<li><a href="'.'/company/news_list/'.$id.'/'.$val['classify_id'].'">'.$val['classify_name'].'</a></li>';
                    }
                }
            ?>
            <? 
            $film_left=$this->mod_business->select_from_order('strings_category', 'member_id', 'desc', array('member_id'=>$this->member_id)); 
            if(!empty($film_left)){
                echo '<li id="meunt2">'.$LFilm.'</li>';
                foreach($film_left as $val){
                    echo '<li><a href="'.'/company/film_list/'.$id.'/'.$val['cid'].'">'.$val['name'].'</a></li>';
                }
            }
            ?>
           
            <? 
                $picture=$this->mod_business->select_from_order('photo_category', 'd_id', 'desc', array('d_member_id'=>$this->member_id));  
                if(!empty($picture)){
                    echo '<li id="meunt2">'.$Albums.'</li>';
                    foreach($picture as $val){
                        echo '<li><a href="'.'/company/picture_info/'.$id.'/'.$val['d_id'].'">'.$val['d_name'].'</a></li>';
                    }
                }
            ?>
        </ul>
        <!--填滿下方空格，避開footbar-->
        <div style="display:block;width:100%;height:65px;"></div>
</nav>