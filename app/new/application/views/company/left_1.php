<nav id="menu">
    <ul>
        <? 
			$news=$this->mod_business->select_from_order('iqr_classify', 'member_id', 'desc', array('member_id'=>$this->member_id));	
			if(!empty($news)){
        		echo '<li id="meunt2">'.$Informationclassification.'</li>';
				foreach($news as $val){
					echo '<li><a href="'.'/company/news_list/'.$id.'/'.$val['classify_id'].'">'.$val['classify_name'].'</a></li>';
				}
			}
		?>
        <? 
			$film_left=$this->mod_business->select_from_order('strings_category', 'member_id', 'desc', array('member_id'=>$this->member_id, 'type' => 'ytb_link')); 
            if(!empty($film_left)){
            	echo '<li id="meunt2">'.$VideosCategory.'</li>';
                foreach($film_left as $val){
                    echo '<li><a href="'.'/company/film_list/'.$id.'/'.$val['cid'].'">'.$val['name'].'</a></li>';
                }
            }
		?>
        <? 
			$activity_left=$this->mod_business->select_from_order('strings_category', 'member_id', 'desc', array('member_id'=>$this->member_id, 'type' => 'uform')); 
            if(!empty($activity_left)){
            	echo '<li id="meunt2">'.$Activityclassification.'</li>';
                foreach($activity_left as $val){
                    echo '<li><a href="'.'/company/activity_list/'.$id.'/'.$val['cid'].'">'.$val['name'].'</a></li>';
                }
            }
		?>
        <? 
			$picture=$this->mod_business->select_from_order('photo_category', 'd_id', 'desc', array('d_member_id'=>$this->member_id));	
			if(!empty($picture)){
		        echo '<li id="meunt2">'.$PhotoCategories.'</li>';
				foreach($picture as $val){
					echo '<li><a href="'.'/company/picture_info/'.$id.'/'.$val['d_id'].'">'.$val['d_name'].'</a></li>';
				}
			}
		?>
    </ul>
</nav>
