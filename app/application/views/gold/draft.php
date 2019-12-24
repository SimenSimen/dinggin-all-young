<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$this->lang['draft'];//草稿專區?></header>
<div class="wrapper">
<? if(!empty($dbdata)):foreach ($dbdata as $value):?>
	<div id="memo">
		<div>
			<h6><?=$value['d_title']?></h6>
			<?=$value['d_content']?>
		</div>
		<a href="/gold/contribute/<?=$value['d_id']?>"><?=$this->lang['edit'];//編輯?></a>
	</div>
<? endforeach;else:?>
	<?=$this->lang['nodraft'];//目前無草稿資料?>
<?endif;?>	
	

</div><!--/wrapper-->               
<!--
<div id="menu">
  <ul class="menu-nav">
      <li><a href="index.html"><i></i>關於我</a></li>
      <li><a href="team.html" class="now"><i></i>關於eoneda</a></li>
  </ul>
</div>
-->
</body>
</html>