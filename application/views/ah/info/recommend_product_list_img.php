<link href="https://data.asiahighlights.com/min/?f=/css/article-style.css" rel="stylesheet"> 
<div class="row">
<?php
foreach($title_url as $item){
		echo '<div class="recommmendTourList">';
		echo '<div class="col-md-8 col-sm-8 col-xs-24">';
		echo '<div class="deWidth">';
		echo '<a href="'.$item->ic_url.'"><img src="https://images.asiahighlights.com'.$item->ic_photo.'"/></a>';
		echo '<div class="tourTitle"><h3><a href="'.$item->ic_url.'">'.$item->ic_title.'</a></h3></div>';
		echo '<a href="'.$item->ic_url.'"><span class="tourDetail">EXPLORE</span></a>';
		echo '</div></div></div>';
	} 
?>	
</div>