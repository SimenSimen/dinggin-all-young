			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
						<span class="current">　</span>
						<ul class="side-nav list-v">
							<li <?if($this->DataName=='about')echo("class='active select'");?>><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a></li>
							<li <?if($this->DataName=='service')echo("class='active select'");?>><a href="/gold/service"><?=$this->lang_menu['servicearea'];//服務專區?></a></li>
							<li><a href="/gold/media/C/video"><?=$this->lang_menu['movie'];//影音專區?></a></li>
							<li><a href="/gold/photo/C/photo"><?=$this->lang_menu['album'];//活動花絮?></a></li>
							<li><a href="/gold/archive/C/annex"><?=$this->lang_menu['download'];//文件下載?></a></li>
						</ul>
					</div>
                </aside>