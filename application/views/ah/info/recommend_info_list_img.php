<link href="https://data.asiahighlights.com/min/?f=/css/article-style.css" rel="stylesheet"> 
<h2>Related Articles</h2>
<div class="row">
<div class="recommendArticles">
<?php
foreach($title_url as $item){
		echo '<div class="col-md-6 col-sm-6 col-xs-12">';
		echo '<div class="deWidth">';
		echo '<a href="'.$item->ic_url.'"><img src="https://images.asiahighlights.com'.$item->ic_photo.'" title="'.$item->ic_title.'" /></a>';
		echo '<div class="relatedTitle"><a href="'.$item->ic_url.'">'.$item->ic_url_title.'</a></div>';
		echo '</div></div>';
	} 
?>	
</div>
</div>