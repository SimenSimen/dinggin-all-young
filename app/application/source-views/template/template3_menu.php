			<nav id="menu">
				<ul>
					<li><a href="<?=$base_url?>business/iqr/<?=$account?>">首頁</a></li>
<!--					<li><a href="<?=$base_url?>business/mytest">test</a></li>-->
					<li><a href="#mm-1" data-target="#mm-1"><i class="people-photo"><!--<img src="<?=$base_url?>template/temp3/images/people-photo.jpg" width="400" height="400" align="center">--></i><span class="m-about-me">關於我</span></a>
						<ul id="mm-1">
			<?php $this -> load -> view('template/template3_lip', $data); ?>
						</ul>
					</li>
                    
					<li class="m-our-team"><i class="team-icon"><img src="<?=$base_url?>template/temp3/images/team-icon.png" align="center" style="width:40px;height:40px"></i>團隊情報<i class="fa fa-angle-down icon-down"></i></li>
			<?php $this -> load -> view('template/template3_lic', $data); ?>
				</ul>
			</nav>
