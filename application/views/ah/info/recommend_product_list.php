<h3>You might like:</h3>
<?php
foreach($title_url as $item){
		echo '<p>';
		echo '<a href="'.$item->ic_url.'">'.$item->ic_title.'</a>';
		echo '</p>';
	} 
?>	