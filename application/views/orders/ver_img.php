<form action="" method="post">
	<input type="text" name="_ver" />
	<?php foreach ($r as $key => $value):?>
		<input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
	<?php endforeach;?>
	<input type="submit" />
</form>
<img src="test" alt=""  onclick="this.src='test?'+Math.random();">